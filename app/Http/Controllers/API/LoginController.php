<?php

namespace App\Http\Controllers\API;

use App\Models\User;

use App\Models\Announcement;

use App\Models\Couponcode;

use App\Models\User_wallet;

use App\Models\User_reward;

use Mail;

use Auth;

use Exception;

use Hash;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Request;

use League\OAuth2\Server\Exception\OAuthServerException;

use Psr\Http\Message\ServerRequestInterface;

use Validator;

use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;

use Lcobucci\JWT\Parser;

use DB;

use Illuminate\Support\Facades\Password;


class LoginController extends BaseAPIController

{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    public $successStatus = 200;

    /**
     * This model function is used to handle the Login functionality for App Login
     *
     * @author Techaffinity:John F
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)

    {
        $announcementData = array();
        $announcementItems = Announcement::orderBy('created_at', 'desc')->offset(0)->limit(10)->get();
        if ($announcementItems) {
            foreach ($announcementItems as $announcement) :
                // $announcementImg = (!empty($announcement->announcement_image)) ? URL('uploads/announcements/' . $announcement->announcement_image) : URL('images/noimage.png');
                $announcementImg = $announcement->announcement_image;
                if ($announcementImg) {
                    $announcementImg = $announcement->announcement_image;
                } else {
                    $announcementImg = URL('images/noimage.png');
                }
                $announcementData[] = array(
                    'id' => $announcement->id,
                    'announcement_title' => $announcement->title,
                    'announcement_image' => $announcementImg,
                    'announcement_description' => $announcement->description,
                    'status' => intval($announcement->status)
                );
            endforeach;
        }

        if (Auth::attempt(['email' => request('username'), 'password' => request('password')])) {

            $user = Auth::user();

            $token =  $user->createToken('wallet')->accessToken;

            //$accessToken = Auth::user()->token();

            $id = (new Parser())->parse($token)->getHeader('jti');

            $old = $request->user()->tokens()->where('id', '!=', $id)->delete();

            //$revoked = DB::table('oauth_access_tokens')->where('id', '!=', $id)->update(['revoked' => 1]);
            $totalTransaction = Couponcode::where('user_id', Auth::id())->whereIn('type', [1, 2])->where('status', 1)->count();
            $totalTopup = Couponcode::where('user_id', Auth::id())->where('status', 1)->where('type', 1)->count();
            $totalPaid = Couponcode::where('user_id', Auth::id())->where('status', 1)->where('type', 2)->count();
            $walletInfo = User_wallet::where('user_id', Auth::id())->get()->first();
            $rewardInfo = User_reward::Where('user_id', Auth::id())->get()->first();
            if ($walletInfo) {
                $walletBalance = $walletInfo->amount;
            } else {
                $walletBalance = '0';
            }
            if ($rewardInfo) {
                $rewardPoint = $rewardInfo->reward_point;
            } else {
                $rewardPoint = '0';
            }
            if ($user->userInfo->area) {
                $area_name = $user->userInfo->area->area_name;
            } else {
                $area_name = '';
            }
            if ($user->userInfo->area) {
                $area_id = $user->userInfo->area->id;
            } else {
                $area_id = '';
            }
            $profile = array(
                'token_id' => $token,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'dob' => $user->dob,
                'area_name' => $area_name,
                'area_id' => $area_id,
                'email_address' => $user->email,
                'phone_number' => $user->phone_number,
                'country_code' => '',
                'is_email_verified' => $user->is_email_verified,
                'is_phone_verified' => $user->is_phone_verified,
                'is_transaction_pin_available' => (($user->transaction_pin) ? 1 : 0),
                'wallet_balance' => $walletBalance,
                'total_transactions' => $totalTransaction,
                'total_topup' => $totalTopup,
                'total_paid' => $totalPaid,
                'total_voucher_to_redeem' => '',
                'unread_notification_count' => '',
                'reward_points' => $rewardPoint,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'status' => "$user->status",
                'announcement_data' => $announcementData
            );

            return response()->json(['status' => 'success', 'message' => 'User data retrieved', 'data' => array($profile)], $this->successStatus);
        } else {

            return response()->json(['status' => 'failed', 'message' => trans('ApiMessages.invaliduser')], $this->successStatus);
        }
    }

    /**
     * This Method function is used sending OTP for forgot password
     *
     * @author Techaffinity:John F
     * @return \Illuminate\Http\Response
     */

    public function forgotPassword_old(Request $request)
    {

        $messages = [
            'mobile_no.required' => 'Mobile No is Required',

            'mobile_no.digits_between' => 'Mobile No must be +971 xxxxxxxxx',

        ];



        $validator = Validator::make($request->all(), [

            'mobile_no' => 'required|digits_between:8,9',

        ], $messages);



        if ($validator->fails()) {

            return response()->json([
                'status' => 'failed',

                'error' => $validator->errors(),

            ], 422);
        }

        $userExists = User::where([
            'mobile_no' => $request->mobile_no,

            'status' => '1'
        ])

            ->first();

        if (!$userExists) {

            return response()->json(['status' => 'failed', 'message' => trans('ApiMessages.mobilenonotexists')], 422);
        } else if ($userExists && $userExists->hasRole('Customer')) {

            //$generatedOtp = rand(1000,10000);

            //$this->sendSMS($request->mobile_no,$generatedOtp); // To send OTP to user

            return response()->json(['status' => 'success', 'message' => trans('ApiMessages.otpsent'), 'data' => array('OTP' => '1234', 'user_id' => $userExists->id)], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => trans('ApiMessages.otpfailed')], 422);
        }
    }



    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', trans($response));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }


    public function forgotPassword(Request $request)
    {
        $messages = ['email.required' => 'Email is Required'];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'error' => $validator->errors(),
            ], 422);
        }

        $user = User::where(['email' => $request->email, 'status' => '1'])->first();
        if (!$user) {
            return response()->json(['status' => 'failed', 'message' => trans('ApiMessages.emailnotexists')], 422);
        } else if ($user && $user->hasRole('Customer')) {

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );
            if ($response == Password::RESET_LINK_SENT) {
                $this->sendResetLinkResponse($request, $response);
                return response()->json(['status' => 'success', 'message' => trans('ApiMessages.resetlinksent'), 'data' => array('user_id' => $user->id)], 200);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Enter valid email address.'], 422);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => trans('ApiMessages.otpfailed')], 422);
        }
    }

    /**

     * This Method function is used reset the password for user account
     *
     * @author Techaffinity:John F
     * @return \Illuminate\Http\Response
     */

    public function changePassword(Request $request)
    {

        $messages = [];

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|string|min:6|max:10'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }

        if (!(Hash::check($request->old_password, Auth::user()->password))) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('ApiMessages.oldPasswordMismatch'),
            ], $this->successStatus);
        }

        if (strcmp($request->old_password, $request->password) == 0) {
            //Current password and new password are same
            return response()->json([
                'status' => 'failed',
                'message' => trans('ApiMessages.newPasswordAsOld'),
            ], $this->successStatus);
        }

        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        //Change Token
        $token  =  $user->createToken('wallet')->accessToken;
        $id     = (new Parser())->parse($token)->getHeader('jti');
        $old    = $request->user()->tokens()->where('id', '!=', $id)->delete();

        $data = array('token_id' => $token);
        return response()->json([
            'status' => 'success', 'data' => $data,
            'message' => trans('ApiMessages.passwordChanged'),
        ], $this->successStatus);
    }

    public function logoutApi()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }
    }
}
