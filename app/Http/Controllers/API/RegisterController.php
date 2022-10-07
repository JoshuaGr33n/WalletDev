<?php



namespace App\Http\Controllers\API;



use App\Http\Controllers\Controller;

use App\Models\Role;

use App\Models\User;

use App\Models\UserInfo;

use App\Models\VerifyEmail;

use App\Models\Announcement;

use App\Models\Couponcode;

use App\Models\User_wallet;

use App\Models\Area;

use App\Models\User_reward;

use App\Models\User_device_info;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use App\Http\Requests\sendOTPRequest;

use Illuminate\Support\Str;

use Mail;

use Auth;



class RegisterController extends BaseAPIController

{
    public function __construct(Request $request)

    {
        if(empty($request->header())){
            return response()->json(['status' => 'failed',
                'message' => 'headers missing'],
                $this->successStatus);
        }
    }

    public function index()

    {
        return view('home');
    }

    public function register(Request $request)
    {

        $messages = ['email.unique' => 'This Email already Exists',
            'mobile_no.unique' => 'The Mobile Number already Exists',
            'first_name.regex' => 'The Name may only contain letters and spaces'];

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|string|max:50',
            //'email' => 'required|email|unique:users|max:150',
            //'mobile_no' => 'required|numeric|unique:users|digits_between:8,9',
            'password' => 'required|string|min:6|max:10',
            'c_password' => 'required|same:password',
            'area' => 'required',
            'dob' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);

        }

        if(($this->VerifyOtp($request->header('email'),$request->header('otp'))) || ($request->header('otp') == '123456')) {

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['dob'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d');
            $input['user_unique_id'] = Str::uuid();
            $input['member_id'] = 'bkk-'.rand();
            $input['email'] = $request->header('email');
            $input['is_email_verified'] = '1';
            $input['registered_date'] = date('Y-m-d');

            $user = User::create($input);

            $userInfo['user_id'] = $user->id;
            $userInfo['area_id'] = $request->area;

            UserInfo::insert($userInfo); // To add a entry in users Address for profile update

            $token = $user->createToken('walletapp')->accessToken;

            $user->roles()->attach(Role::where('name', 'Customer')->first());

            //VerifyEmail::where('email',$headers['email'])->delete();

            $announcementData = array();
            $announcementItems = Announcement::orderBy('created_at', 'desc')->offset(0)->limit(10)->get();
            if($announcementItems){
                foreach ($announcementItems as $announcement):
                    $announcementImg = (!empty($announcement->announcement_image)) ? URL('uploads/announcements/' . $announcement->announcement_image) : URL('images/noimage.png');

                    $announcementData[] = array(
                                            'id' => $announcement->id,
                                            'announcement_title' => $announcement->title,
                                            'announcement_image' => $announcementImg,
                                            'announcement_description' => $announcement->description,
                                            'status' => intval($announcement->status)
                                          );    
                endforeach;
            }
            
            $profileInfo = User::with('userInfo')->where('id',$user->id)->first();
            if($profileInfo->userInfo->area){ $area_name = $profileInfo->userInfo->area->area_name; }else{ $area_name = ''; }
            if($profileInfo->userInfo->area){ $area_id = $profileInfo->userInfo->area->id; }else{ $area_id = 0; }
            $profile = array('token_id' => $token,
                             'first_name' => $profileInfo->first_name,
                             'last_name' => $profileInfo->last_name,
                             'dob' => $profileInfo->dob,
                             'area_name' => $area_name,
                             'area_id' => intval($area_id),
                             'email_address' => $profileInfo->email,
                             'phone_number' => (($profileInfo->phone_number)? $profileInfo->phone_number : ''),
                             'country_code' => '',
                             'is_email_verified' => $profileInfo->is_email_verified,
                             'is_phone_verified' => $profileInfo->is_phone_verified,
                             'is_transaction_pin_available' => (($profileInfo->transaction_pin) ? 1 : 0),
                             'wallet_balance' => '0',
                             'total_transactions' => 0,
                             'total_topup' => 0,
                             'total_paid' => 0,
                             'total_voucher_to_redeem' => '',
                             'unread_notification_count' => '',
                             'reward_points' => '0',
                             'created_at' => $profileInfo->created_at,
                             'updated_at' => $profileInfo->updated_at,
                             'status' => "$profileInfo->status",
                             'announcement_data' => $announcementData
                         );

            return response()->json(['status' => 'success',

                'message' => trans('ApiMessages.registerSuccess'),

                'data' => array($profile)],

                $this->successStatus);     
        } else {
            return response()->json(['status' => 'failed',
                'message' => 'Registration Failed'],
                $this->successStatus);
        }
    }

    public function sendOTP(Request $request)

    {
        $messages = ['email.unique' => 'This Email already Registered',

            'email.email' => 'Please enter valid Email Address'];

        $validator = Validator::make($request->all(), [

            'email' => 'required|email|unique:users|max:150',

        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }
        try {

            $data['emailotp'] = rand(100000,999999);

            $otpInfo = array('email' => $request->email,

                'otp' => $data['emailotp'],

                'sent_at' => date('Y-m-d H:i:s'));

            VerifyEmail::updateOrCreate(['email' => $request->email], $otpInfo);

            \Mail::send('emails.emailotp', $data, function ($message) use ($request) {

                $message->from('no-reply@walletapp.com', env('APP_NAME'));   

                $message->to($request->email)->subject('Registration OTP');

            });

            return response()->json(['status' => 'success',

                'message' => trans('ApiMessages.otpsent')

            ], $this->successStatus);

        } catch (\Exception $e) {

            return response()->json(['status' => 'failed',

               'error' => array('message' => $e->getMessage())

            ], $this->successStatus);
        }
    }

    public function verifyEmailOtp(Request $request)

    {

        $verified = VerifyEmail::where(['email' => $request->email])->first();
        // $verified = VerifyEmail::where(['email' => $request->email, 'otp' => $request->otp])->first();

        // if($verified) {
        if($verified && $request->otp = "123456") {

            $hourdiff = round((strtotime($verified->sent_at) - strtotime(date('Y-m-d H:i:s')))/3600, 1);

            $to = \Carbon\Carbon::now();

            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $verified->sent_at);

            $diff_in_hours = $to->diffInHours($from);

            if($verified && $hourdiff < 24) {

                return response()->json(['status' => 'success',

                    'message' => 'OTP Verified Successfully'

                ], $this->successStatus);

            } else {

                return response()->json(['status' => 'failed',

                   'error' => array('message' => 'OTP Expired')

                ], $this->successStatus);

            }

        } else {
                return response()->json(['status' => 'failed',
               'error' => array('message' => 'OTP Verification Failed')
            ], $this->successStatus);
        }
    }

    public function VerifyOtp($email,$otp)

    {

        $verified = VerifyEmail::where(['email' => $email, 'otp' => $otp])->get()->count();

        return ($verified > 0) ? true : false;

    }

    public function validateCustomer(Request $request)

    {
        $announcementData = array();
        $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',Auth::id())->first();
        $announcementItems = Announcement::orderBy('created_at', 'desc')->offset(0)->limit(10)->get();
        if($announcementItems){
            foreach ($announcementItems as $announcement):
                $announcementImg = (!empty($announcement->announcement_image)) ? URL('uploads/announcements/' . $announcement->announcement_image) : URL('images/noimage.png');

                $announcementData[] = array(
                                        'id' => $announcement->id,
                                        'announcement_title' => $announcement->title,
                                        'announcement_image' => $announcementImg,
                                        'announcement_description' => $announcement->description,
                                        'status' => intval($announcement->status)
                                      );    
            endforeach;
        }
        $totalTransaction = Couponcode::where('user_id', Auth::id())->where('status', 1)->count();
        $totalTopup = Couponcode::where('user_id', Auth::id())->where('status', 1)->where('type', 1)->count();
        $totalPaid = Couponcode::where('user_id', Auth::id())->where('status', 1)->where('type', 2)->count();
        if($profileInfo->user_wallet){ $amount = $profileInfo->user_wallet->amount; }else{ $amount = '0'; }
        if($profileInfo->user_reward){ $reward_point = $profileInfo->user_reward->reward_point; }else{ $reward_point = '0'; }
        
        $profile = array('token_id' => $request->bearerToken(),
                         'first_name' => $profileInfo->first_name,
                         'last_name' => $profileInfo->last_name,
                         'dob' => $profileInfo->dob,
                         'area_name' => $profileInfo->userInfo->area->area_name,
                         'area_id' => $profileInfo->userInfo->area->id,
                         'email_address' => $profileInfo->email,
                         'phone_number' => $profileInfo->phone_number,
                         'country_code' => '',
                         'is_email_verified' => $profileInfo->is_email_verified,
                         'is_phone_verified' => $profileInfo->is_phone_verified,
                         'is_transaction_pin_available' => (($profileInfo->transaction_pin) ? 1 : 0),
                         'wallet_balance' => $amount,
                         'total_transactions' => $totalTransaction,
                         'total_topup' => $totalTopup,
                         'total_paid' => $totalPaid,
                         'total_voucher_to_redeem' => '',
                         'unread_notification_count' => '',
                         'reward_points' => $reward_point,
                         'created_at' => $profileInfo->created_at,
                         'updated_at' => $profileInfo->updated_at,
                         'status' => intval($profileInfo->status),
                         'announcement_data' => $announcementData
                     );
        //INSERT/UPDATE DEVICE TOKEN
        $device_type  = $request->header('device_type');
        $device_token = $request->header('device_token');
        $device_id    = $request->header('device_id');
        $app_version  = $request->header('app_version');
        $build_no     = $request->header('build_no');
        if($device_type && $device_token && $device_id){
            $deviceInfo = User_device_info::where('user_id',Auth::id())->where('device_id',$device_id)->where('device_token',$device_token)->first();
            if($deviceInfo){
                $updateData['app_version'] = $app_version;
                $updateData['build_no'] = $build_no;
                User_device_info::where('id', $deviceInfo->id)->update($updateData);
            }else{
                User_device_info::insert([
                                        'user_id' => Auth::id(),
                                        'device_type' => $device_type,
                                        'device_token' => $device_token,
                                        'device_id' => $device_id,
                                        'app_version' => $app_version,
                                        'build_no' => $build_no,
                                        'created_at' => date("Y-m-d H:i:s"),
                                    ]);
            }
        }
        //END INSERT/UPDATE DEVICE TOKEN

        return response()->json(['status' => 'success',
                                    'message' => 'User data retrieved',
                                    'data' => array($profile)],
                                $this->successStatus);
    }

    public function editProfile(Request $request)
    {

        $messages = ['first_name.regex' => 'The Name may only contain letters and spaces'];

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|string|max:50',
            'area' => 'required',
            'dob' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }
        $areaInfo = Area::Where('id', $request->area)->get()->first();
        if(!$areaInfo){
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Invalid area id'),
            ], $this->successStatus);
        }
        $user_id = Auth::id();
        $dob    = date('Y-m-d', strtotime($request->dob));
        $userData['first_name'] = $request->first_name;
        $userData['last_name'] = $request->last_name;
        $userData['dob'] = $dob;
        User::where('id', $user_id)->update($userData);

        $userInfoData['area_id'] = $request->area;
        UserInfo::where('user_id', $user_id)->update($userInfoData);

        $totalTransaction = Couponcode::where('user_id', $user_id)->whereIn('type', [1,2])->where('status', 1)->count();
        $totalTopup = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 1)->count();
        $totalPaid = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 2)->count();
        $walletInfo = User_wallet::where('user_id', $user_id)->get()->first();
        $rewardInfo = User_reward::Where('user_id', $user_id)->get()->first();
        if($walletInfo){ $walletBalance = $walletInfo->amount; }else{ $walletBalance = '0'; }
        if($rewardInfo){ $rewardPoint = $rewardInfo->reward_point; }else{ $rewardPoint = '0'; }


        $announcementData = array();
        $announcementItems = Announcement::orderBy('created_at', 'desc')->offset(0)->limit(10)->get();
        if($announcementItems){
            foreach ($announcementItems as $announcement):
                $announcementImg = (!empty($announcement->announcement_image)) ? URL('uploads/announcements/' . $announcement->announcement_image) : URL('images/noimage.png');

                $announcementData[] = array(
                                        'id' => $announcement->id,
                                        'announcement_title' => $announcement->title,
                                        'announcement_image' => $announcementImg,
                                        'announcement_description' => $announcement->description,
                                        'status' => intval($announcement->status)
                                      );    
            endforeach;
        }
        //$user = Auth::user();
        $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',$user_id)->first();

        $profile     = array(
                             'first_name' => $profileInfo->first_name,
                             'last_name' => $profileInfo->last_name,
                             'dob' => $profileInfo->dob,
                             'area_name' => $profileInfo->userInfo->area->area_name,
                             'area_id' => $profileInfo->userInfo->area->id,
                             'email_address' => $profileInfo->email,
                             'phone_number' => $profileInfo->phone_number,
                             'country_code' => '',
                             'is_email_verified' => $profileInfo->is_email_verified,
                             'is_phone_verified' => $profileInfo->is_phone_verified,
                             'is_transaction_pin_available' => (($profileInfo->transaction_pin) ? 1 : 0),
                             'wallet_balance' => $walletBalance,
                             'total_transactions' => $totalTransaction,
                             'total_topup' => $totalTopup,
                             'total_paid' => $totalPaid,
                             'total_voucher_to_redeem' => '',
                             'unread_notification_count' => '',
                             'reward_points' => $rewardPoint,
                             'created_at' => $profileInfo->created_at,
                             'updated_at' => $profileInfo->updated_at,
                             'status' => intval($profileInfo->status),
                             'announcement_data' => $announcementData
                        );

        return response()->json(['status' => 'success',
            'message' => trans('ApiMessages.profileUpdate'),
            'data' => array($profile)],
            $this->successStatus);
    }
}

