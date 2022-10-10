<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Models\User;
use App\Models\UserCode;
use App\Models\UserInfo;
use App\Models\Role;
use App\Rules\ReCaptcha;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;

use App\Mail\SendMail;

class AuthController extends BaseController
{
    private function sendMessage($message, $recipients)
    {
        try {
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $from_number = getenv("TWILIO_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $response = $client->messages->create($recipients, ['from' => $from_number, 'body' => $message]);

            return $response->errorCode;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function generateUniqueCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 2;

        $code = '';

        while (strlen($code) < 2) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }

        $code = $code . rand(1000, 9999);

        if (User::where('referral_code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;
    }

     

    public function register(Request $request)
    {
        try {

            $messages = [
                'first_name.required' => 'First name is required',
                'last_name.required' => 'Last name is required',
                'gender.required' => 'Gender is required',
                'dob.required' => 'Date of birth is required',
                'dob.date_format' => 'Invalid date format. Sample format: 2002-03-18',
                'country_code.required' => 'Country Code is required',
                'country_code.numeric' => 'Country Code must be numeric',
                'phone_number.required' => 'Phone Number is required',
                'phone_number.unique' => 'Phone number already registered with another customer',
                'phone_number.numeric' => 'Phone Number must be numeric',
                'repeat_phone_number.same' => 'Phone Number dont match',
                'repeat_phone_number.required_with' => 'Repeat your Phone Number',
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email',
                'email.unique' => 'Email already registered with another customer',
                'repeat_email.same' => 'Email dont match',
                'repeat_email.required_with' => 'Please repeat your email address',
                'postal_code.required' => 'Postal Code is required',
                'postal_code.numeric' => 'Postal Code must be numeric',
            ];
            $validator = Validator::make($request->all(), [


                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'dob' => 'required|date_format:Y-m-d',
                'country_code' => 'required|numeric',
                'phone_number' => 'required|unique:users|numeric',
                'repeat_phone_number' => 'same:phone_number|required_with:phone_number',
                'email' => 'required|email|unique:users',
                'repeat_email' => 'same:email|required_with:email',
                'postal_code' => 'required|numeric',
            ], $messages);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {
                $referral_code = $this->generateUniqueCode();
                $dob = Carbon::parse($request->dob)->format('Y-m-d');
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'full_name' => $request->first_name . ' ' . $request->last_name,
                    'gender' => $request->gender,
                    'user_name' => $request->first_name . '' . $referral_code,
                    'role' => 'CUSTOMER',
                    'dob' => $dob,
                    'postal_code' => $request->postal_code,
                    'country_code' => $request->country_code,
                    'phone_number' => $request->phone_number,
                    'referral_code' => $referral_code,
                    'email' => $request->email,
                    'password' => "",
                    'registered_date' => Carbon::now()->format('Y-m-d'),
                    'user_unique_id' => Str::uuid(),
                    'member_id' => 'bkk-' . rand()
                ]);

                $token = $user->createToken('temp_auth_token')->plainTextToken;
                $user->roles()->attach(Role::where('name', 'Customer')->first());

                UserInfo::create([
                    'user_id' => $user->id,
                ]);

                $response = [
                    'temp_token' => $token,
                    'token_type' => 'Bearer',
                    'country_code' =>  $user->country_code,
                    'phone_number' =>  $user->phone_number,
                ];
                $message = $this->generateOTP($token);
                if ($message == 'error') {
                    return $this->sendError('OTP Not Sent', '', 400);
                }

                return $this->sendResponse($response, $message);
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $this->sendError('Internal Server Error', $error, 500);
        }
    }


    
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_code' => ['required', 'numeric'],
                'phone_number' => ['required', 'numeric', 'exists:users,phone_number'],
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {
                $user = User::where([['phone_number', $request->phone_number], ['country_code', $request->country_code]])->first();

                if (!$user) {
                    return $this->sendError('Phone not registered.', '');
                } else {
                    $user->update(['is_phone_verified' => 0, 'is_logged_in' => 0]);
                    $user->tokens()->delete();

                    $token = $user->createToken('temp_auth_token')->plainTextToken;
                    $user->token = $token;

                    $user_codes = UserCode::where('user_id', $user->id)->get();
                    foreach ($user_codes as $item) {
                        $item->delete();
                    }

                    $message = $this->generateOTP($token);

                    if ($message == 'error') {
                        return $this->sendError('OTP Not Sent', '', 400);
                    }

                    $response = [
                        'temp_token' => $token,
                        'token_type' => 'Bearer',
                    ];

                    return $this->sendResponse($response, $message);
                }
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $this->sendError('Internal Server Error', $error, 500);
        }
    }

    private function generateOTP($token)
    {
        try {
            $token = PersonalAccessToken::findToken($token);
            $user = User::findorFail($token->tokenable_id);

            $otp = rand(100000, 999999);
            Log::info("otp = " . $otp);

            $recipient = $user->email;
            $message = $otp . " is your One-Time Verification Code.";

            // $errorCode = $this->sendMessage($message, $recipient);

            Mail::send('emails.emailotp', ['emailotp' => $message, 'email' => $user->email], function($message) use($user){
                $message->to($user->email);
                $message->from('test@wallet.com');
                $message->subject('Wallet.dev');
                });

            $errorCode = null;
            if ($errorCode != null) {
                return 'error';
            }

            $usercode = UserCode::create([
                'user_id' => $user->id,
                'user_code' => $otp,
                'expires_at' => Carbon::now()->addMinutes('3')->format('Y-m-d H:i:s')
            ]);

            return "OTP sent to registered mobile number";
        } catch (\Exception $e) {
            // return $e->getMessage();
            $error = $e->getMessage();
            return $this->sendError('Internal Server Error', $error, 500);
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $user = User::findorFail($request->user()->id);

            $user_codes = UserCode::where('user_id', $user->id)->orderBy('id', 'DESC')->get();

            if (count($user_codes) >= 5) {
                if (Carbon::parse($user_codes[0]->created_at)->addHours('1') >= Carbon::now()) {
                    return $this->sendError('Too many resends. Please, try again later!', '', 400);
                }
            }
            $message = $this->generateOTP($token);

            if ($message == 'error') {
                return $this->sendError('OTP Not Sent', '', 400);
            }

            return $this->sendResponse('', 'OTP resent to the registered phone number.');
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $this->sendError('Internal Server Error', $error, 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);
            $user_code = UserCode::where('user_id', $user->id)->orderBy('id', 'DESC')->first();

            if ($request->otp == $user_code->user_code) {
                if (Carbon::parse($user_code->expires_at) <= Carbon::now()) {
                    return $this->sendError('OTP Expired', '', 422);
                } else {
                    $tokenDetails = $request->user()->currentAccessToken();
                    if ($tokenDetails->name == 'temp_auth_token') {
                        if ($user->is_phone_verified != null) {
                            $message = 'Logged In Successfully.';
                        } else {
                            $message = 'Registeration Successful.';
                        }
                        $user->update(['is_phone_verified' => 1, 'is_logged_in' => 1]);
                        $user = User::findorFail($user->id);

                        $user->tokens()->delete();
                        $token = $user->createToken('access_token')->plainTextToken;

                        $response = [
                            'access_token' => $token,
                            'token_type' => 'Bearer',
                            'user' => $user,
                        ];
                    } else {
                        $request->user()->currentAccessToken()->delete();
                        $temp_token = $user->createToken('temp_token')->plainTextToken;

                        $response = [
                            'temp_token' => $temp_token,
                            'token_type' => 'Bearer',
                            'user' => $user,
                        ];
                        $message = 'OTP Verified';
                    }
                    $user_codes = UserCode::where('user_id', $user->id)->get();
                    foreach ($user_codes as $item) {
                        $item->delete();
                    }
                    $user->update(['last_login' => Carbon::now()->format('Y-m-d H:i:s')]);
                    return $this->sendResponse($response, $message);
                }
            } else {
                return $this->sendError('Invalid OTP', '', 422);
            }
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);

            if ($user->is_phone_verified === true) {

                $messages = [
                    'first_name.required' => 'First name is required',
                    'last_name.required' => 'Last name is required',
                    'gender.required' => 'Gender is required',
                    'dob.required' => 'Date of birth is required',
                    'dob.date_format' => 'Invalid date format. Sample format: 2002-03-18',
                    'country_code.required' => 'Country Code is required',
                    'country_code.numeric' => 'Country Code must be numeric',
                    'phone_number.required' => 'Phone Number is required',
                    'phone_number.unique' => 'Phone number already registered with another customer',
                    'phone_number.numeric' => 'Phone Number must be numeric',
                    'repeat_phone_number.same' => 'Phone Number dont match',
                    'repeat_phone_number.required_with' => 'Repeat your Phone Number',
                    'email.required' => 'Email is required',
                    'email.email' => 'Invalid email',
                    'email.unique' => 'Email already registered with another customer',
                    'repeat_email.same' => 'Email dont match',
                    'repeat_email.required_with' => 'Please repeat your email address',
                    'postal_code.required' => 'Postal Code is required',
                    'postal_code.numeric' => 'Postal Code must be numeric',

                ];
                $validator = Validator::make($request->all(), [

                    'first_name' => 'required',
                    'last_name' => 'required',
                    'gender' => 'required',
                    'dob' => 'required|date_format:Y-m-d',
                    'country_code' => 'required|numeric',
                    'phone_number' => 'required|unique:users,phone_number,' . $user->id . '|numeric',
                    'repeat_phone_number' => 'same:phone_number|required_with:phone_number',
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'repeat_email' => 'same:email|required_with:email',
                    'postal_code' => 'required|numeric',
                ], $messages);



                if ($validator->fails()) {
                    return $this->sendError('Validation Error.', $validator->errors(), 422);
                } else {
                    $dob = Carbon::parse($request->dob)->format('Y-m-d');
                    $referrer = User::where('referral_code', $request->referral_code)->first();
                    $user->update([

                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'full_name' => $request->first_name . ' ' . $request->last_name,
                        'gender' => $request->gender,
                        'dob' => $dob,
                        'postal_code' => $request->postal_code,
                        'country_code' => $request->country_code,
                        'phone_number' => $request->phone_number,
                        'email' => $request->email,
                    ]);

                    $user = User::findorFail($user->id);

                    return $this->sendResponse($user, 'User Details Updated Successfully.');
                }
            } else {
                return $this->sendError('Phone Number not Verified', '', 422);
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $this->sendError('Internal Server Error', $error, 500);
        }
    }

    public function getProfile(Request $request)
    {


        try {
            $user_id = $request->user()->id;
            $user = User::findorFail($user_id);

            if ($user->is_phone_verified === true) {
                return $this->sendResponse($user, 'User Profile');
            } else {
                return $this->sendError('Not Allowed', '', 422);
            }
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function setPIN(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);
            if ($user->is_phone_verified === true) {
                $validator = Validator::make($request->all(), [
                    'pin' => 'required|digits:6|numeric',
                    'retype_pin' => 'same:pin|required_with:pin'
                ]);

                if ($validator->fails()) {
                    return $this->sendError('Validation Error.', $validator->errors(), 422);
                } else {
                    if ($user->PIN != null) {
                        return $this->sendError('You aleady have a PIN', '', 422);
                    }
                    $user->update(['password' => Hash::make($request->pin)]);
                    return $this->sendResponse($user, 'PIN Created Successfully.');
                }
            } else {
                return $this->sendError('Phone Number not verfied!', '', 422);
            }
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function forgotPIN(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_code' => ['required', 'numeric'],
                'phone_number' => ['required', 'numeric', 'exists:users,phone_number'],
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {
                $temp_token = $request->user()->createToken('temp_token')->plainTextToken;

                $response = [
                    'temp_token' => $temp_token,
                    'token_type' => 'Bearer'
                ];
                $message = $this->generateOTP($temp_token);

                if ($message == 'error') {
                    return $this->sendError('OTP Not Sent', '', 400);
                }

                return $this->sendResponse($response, $message);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function resetPIN(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);
            if ($user->is_phone_verified === true) {
                $validator = Validator::make($request->all(), [
                    'pin' => 'required|digits:6|numeric',
                    'retype_pin' => 'same:pin|required_with:pin'
                ]);

                if ($validator->fails()) {
                    return $this->sendError('Validation Error.', $validator->errors(), 422);
                } else {
                    $user->update(['password' => Hash::make($request->pin)]);
                }


                $user->update(['is_phone_verified' => 0, 'is_logged_in' => 0]);
                $request->user()->currentAccessToken()->delete();
                return $this->sendResponse($user, 'PIN Reset Successfully.');
            } else {
                return $this->sendError('Phone Number not verfied!', '', 422);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function changePIN(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);
            if ($user->is_phone_verified === true) {
                $validator = Validator::make($request->all(), [
                    'old_pin' => 'required',
                    'new_pin' => 'required|digits:6|numeric',
                    'retype_new_pin' => 'same:new_pin|required_with:new_pin'
                ]);

                if ($validator->fails()) {
                    return $this->sendError('Validation Error.', $validator->errors(), 422);
                } else {
                    $old_pin = $request->old_pin;
                    $new_pin = $request->new_pin;
                    if (!Hash::check($old_pin, $user->password)) {
                        return $this->sendError('Validation Error.', 'Invalid Old PIN', 422);
                    }

                    if ($old_pin == $new_pin) {
                        return $this->sendError('Validation Error.', 'Old PIN and New PIN should not be same', 422);
                    }
                    $user->update(['password' => Hash::make($new_pin)]);
                }
                return $this->sendResponse($user, 'PIN Changed Successfully.');
            } else {
                return $this->sendError('Phone Number not verfied!', '', 422);
            }
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function profilepicUpload(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);

            $validator = Validator::make($request->all(), [
                "user_image" => "required|image|mimes:jpeg,png,jpg,svg|max:1024",
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {
                $path = public_path('uploads/profile');

                if ($user->user_image != null) {
                    unlink($path . $user->user_image);
                    $user->update(['user_image' => null]);
                }

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file = $request->file('user_image');
                $fileName = uniqid() . '_' . trim($file->getClientOriginalName());

                if (!$file->move($path, $fileName)) {
                    return $this->sendError('Something went worng!', '', 500);
                }

                $user->update(['user_image' => $fileName]);
                return $this->sendResponse('', 'Profile Picture uploaded Successfully');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        $user = User::findorFail($request->user()->id);
        $user->update(['is_phone_verified' => 0, 'is_logged_in' => 0]);
        // auth()->user()->tokens()->delete();
        $user->tokens()->delete();

        return $this->sendResponse('', 'Logged out');
    }
}
