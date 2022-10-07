<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserCode;
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

class ApiAuthController extends BaseController
{
    private function sendMessage($message, $recipients)
    {
        try {
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_TOKEN");
            $from_number = "+13028658480";
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
            $validator = Validator::make($request->all(), [
                // 'country_code' => ['required', 'regex:/^((?:9[679]|8[035789]|6[789]|5[90]|42|3[578]|2[1-689])|9[0-58]|8[1246]|6[0-6]|5[1-8]|4[013-9]|3[0-469]|2[70]|7|1)$/'],
                'country_code' => ['required', 'numeric'],
                'phone_number' => ['required', 'numeric', 'unique:users', 'phone'],
                // 'g-recaptcha-response' => ['required', new ReCaptcha],
                // 'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {
                $referral_code = $this->generateUniqueCode();
                $user = User::create([
                    'country_code' => $request->country_code,
                    'phone_number' => $request->phone_number,
                    'referral_code' => $referral_code,
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
            return $e->getMessage();
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // 'country_code' => ['required', 'regex:/^((?:9[679]|8[035789]|6[789]|5[90]|42|3[578]|2[1-689])|9[0-58]|8[1246]|6[0-6]|5[1-8]|4[013-9]|3[0-469]|2[70]|7|1)$/'],
                'country_code' => ['required', 'numeric'],
                // 'phone_number' => ['required', 'numeric', 'exists:users,phone_number', 'phone'],

                // 'g-recaptcha-response' => ['required', new ReCaptcha]
                // 'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {

                if (Auth::attempt(['phone' => $request->phone_number, 'password' => ''])) {
                    // $user = Auth::user();

                    $user = User::where('phone_number', Auth::user()->phone_number)->first();

                    if (!$user) {
                        return $this->sendError('Phone not registered.', '');
                    } else {
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

                        // return response()->json(['success' => "Good"], 200);

                    }
                } else {
                    return response()->json(['error' => 'Unauthorised'], 401);
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return $this->json('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    // public function generateOTP(Request $request) {
    private function generateOTP($token)
    {
        try {
            $token = PersonalAccessToken::findToken($token);
            $user = User::findorFail($token->tokenable_id);

            $otp = rand(100000, 999999);
            Log::info("otp = " . $otp);

            $recipient = "+" . $user->country_code . $user->phone_number;
            $message = $otp . " is your One-Time Verification Code.";

            // $errorCode = $this->sendMessage($message, $recipient);

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
            return $e->getMessage();
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
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
            return $e->getMessage();
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $user = User::findorFail(5);
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
                        $user->update(['is_phone_verified' => 1]);
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

            $rules = [];
            $rules['full_name'] = 'required|string|max:255';
            if ($request->gender != null) {
                $rules['gender'] = 'boolean';
            }
            if ($request->dob != null) {
                $rules['dob'] = 'date_format:d-m-Y';
            }
            if ($request->referral_code != null) {
                $rules['referral_code'] = ['regex:/^[A-Z]{2}[0-9]{4}$/', 'exists:users,referral_code'];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {
                $date = Carbon::parse($request->dob)->format('Y-m-d');
                $referrer = User::where('referral_code', $request->referral_code)->first();
                $user->update([
                    'full_name' => $request->full_name,
                    'gender' => $request->gender,
                    'dob' => $date,
                    'referrer_id' => $referrer ? $referrer->id : null,
                ]);

                $user = User::findorFail($user->id);

                return $this->sendResponse($user, 'User Details Updated Successfully.');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    public function getProfile(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $user = User::findorFail($user_id);

            return $this->sendResponse($user, 'User Profile');
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    public function generatePIN(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);
            if ($user->PIN != null) {
                return $this->sendError('PIN already generated', '', 422);
            }
            $user->update(['PIN' => Hash::make($request->pin)]);
            return $this->sendResponse($user, 'PIN Generated Successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    public function forgotPIN(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'country_code' => ['required', 'numeric'],
                'phone_number' => ['required', 'numeric', 'exists:users,phone_number'],
                // 'g-recaptcha-response' => ['required', new ReCaptcha]
                // 'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
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
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    public function resetPIN(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);
            $validator = Validator::make($request->all(), [
                'pin' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {
                $user->update(['PIN' => Hash::make($request->pin)]);
            }

            $request->user()->currentAccessToken()->delete();

            return $this->sendResponse($user, 'PIN Reset Successfully.');
        } catch (\Exception $e) {
            return $e->getMessage();
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    public function changePIN(Request $request)
    {
        try {
            $user = User::findorFail($request->user()->id);

            $validator = Validator::make($request->all(), [
                'old_pin' => 'required',
                'new_pin' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            } else {
                $old_pin = $request->old_pin;
                $new_pin = $request->new_pin;
                if (!Hash::check($old_pin, $user->PIN)) {
                    return $this->sendError('Validation Error.', 'Invalid Old PIN', 422);
                }

                if ($old_pin == $new_pin) {
                    return $this->sendError('Validation Error.', 'Old PIN and New PIN should not be same', 422);
                }
                $user->update(['PIN' => Hash::make($new_pin)]);
            }
            return $this->sendResponse($user, 'PIN Changed Successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
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
            return $this->sendError('Internal Server Error', $e->getMesssage(), 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->update(['is_phone_verified', 0]);
        auth()->user()->tokens()->delete();

        return $this->sendResponse('', 'Logged out');
    }
}
