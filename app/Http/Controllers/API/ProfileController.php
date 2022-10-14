<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\profileRequest;
use App\Models\User;
use App\Models\User_reward;
use App\Models\User_reward_history;
use App\Models\User_wallet;
use App\Models\User_Wallet_Transactions;
use App\Models\Outlet;
use App\Models\UserAddresses;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProfileController extends BaseController

{
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

    //   get user total reward points
    public function getUserTotalRewardPoints(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $user = User::findorFail($user_id);
            if ($user->status == 2) {
                return $this->sendError('Account Deactivated', '', 422);
            }
            if ($user->is_phone_verified == true) {
                $total_points = User_reward::where('member_id', $user->member_id)->first();

                if (!$total_points) {
                    return $this->sendError('No Point Awarded Yet', 'No Data', 422);
                }

                return $this->sendResponse($total_points, 'User Total Points');
            } else {
                return $this->sendError('Not Allowed', '', 422);
            }
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    //   get user reward history
    public function getUserRewardHistory(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $user = User::findorFail($user_id);

            if ($user->status == 2) {
                return $this->sendError('Account Deactivated', '', 422);
            }

            if ($user->is_phone_verified == true) {
                $reward_history = User_reward_history::where('member_id', $user->member_id)->get();

                if ($reward_history->count() === 0) {
                    return $this->sendError('No Point Awarded Yet', 'No Data', 422);
                }
                return $this->sendResponse($reward_history, 'User Reward History');
            } else {
                return $this->sendError('Not Allowed', '', 422);
            }
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    //   get user wallet balance
    public function getUserWalletBalance(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $user = User::findorFail($user_id);

            if ($user->status == 2) {
                return $this->sendError('Account Deactivated', '', 422);
            }

            if ($user->is_phone_verified == true) {
                $wallet = User_wallet::where('member_id', $user->member_id)->first();

                return $this->sendResponse($wallet, 'User Wallet Balance');
            } else {
                return $this->sendError('Not Allowed', '', 422);
            }
        } catch (\Exception $e) {
            return $this->sendError('Internal Server Error', $e->getMessage(), 500);
        }
    }

    //  user credit wallet
    public function userCreditWallet(Request $request)
    {
        try {
            $cashier = User::where('id', $request->user()->id)->first();
            $customer  = User::where('member_id',  $request->member_id)->first();
            $outlet = Outlet::Where('id',$request->outlet_id)->first();
            if ($cashier->status == 2) {
                return $this->sendError('Account Deactivated', '', 422);
            }
            if ($cashier->is_phone_verified == true) {
                $messages = [
                    'amount.required' => 'Amount is required',
                    'amount.numeric' => 'Amount must be Numeric',
                    'outlet_id.required' => 'Outlet_id is required',
                    'outlet_id.numeric' => 'Outlet_id must be Numeric',
                    'member_id.required' => 'member_id',
                ];
                $validator = Validator::make($request->all(), [
                    'amount' => 'required|numeric',
                    'outlet_id' => 'required|numeric',
                    'member_id' => 'required',
                ], $messages);

                if ($validator->fails()) {
                    return response()->json(['status' => 'Error', 'status_code' => 100, 'message' => 'Validation Error', $validator->errors()], 422);
                } else {

                    if (!$outlet) {
                        return response()->json(['status' => 'Error', 'status_code' => 110, 'message' => 'Unknown Outlet'], 422);
                    }
                    if (!$customer) {
                        return response()->json(['status' => 'Error', 'status_code' => 120, 'message' => 'Unknown Customer'], 422);
                    }

                    
                    $wallet = User_wallet::where('member_id', $customer->member_id)->first();

                    if ($wallet) {
                        $wallet->update(['wallet_balance' => DB::raw('wallet_balance +' . $request->amount)]);
                        $status_message = "Wallet Credited Successfully";
                        $status_code = 111;
                        $wallet_res = User_wallet::where('member_id', $customer->member_id)->first();
                        $response = [
                            'Amount Added' => $request->amount,
                            'Wallet Balance' => $wallet_res->wallet_balance,
                            'Wallet Address' =>  $wallet_res->wallet_address
                        ];
                    } else {
                        $wallet_address = $this->generateUniqueCode();
                        User_wallet::create([
                            'user_id' => $customer->id,
                            'member_id' => $customer->member_id,
                            'wallet_address' => $wallet_address,
                            'wallet_balance' => $request->amount,
                            'status' => 1
                        ]);
                        $status_message = "Wallet Setup Successful";
                        $status_code = 112;
                        $wallet_res = User_wallet::where('member_id', $customer->member_id)->first();
                        $response = [
                            'Amount Added' => $request->amount,
                            'Wallet Balance' => $wallet_res->wallet_balance,
                            'Wallet Address' =>  $wallet_res->wallet_address
                        ];
                    }
                    $transaction_id = random_int(100000, 999999);
                    $receipt_id = Str::random(6);
                    $receipt_date = Carbon::now()->format('Y-m-d H:i:s');
                    User_Wallet_Transactions::create([
                        'user_id' => $customer->id,
                        'member_id' => $customer->member_id,
                        'transaction_id' => $transaction_id,
                        'receipt_no' => $receipt_id,
                        'wallet_address' =>  $wallet_res->wallet_address,
                        'wallet_balance' => $wallet_res->wallet_balance,
                        'rest_id' => 1,
                        'transaction_date' => $receipt_date,
                        'transaction_type' => 1,
                        'outlet_id' => $request->outlet_id,
                        'reason' => '',
                        'request_amount' => $request->amount,
                        'status' => 1,
                        'staff_id' => $cashier->member_id,
                        'pay_id' => 1
                    ]);

                    return response()->json(['status' => 'success', 'status_code' => $status_code, 'message' => $status_message, 'data' => $response, 'outlet' => $outlet->outlet_name, 'customer'=>$customer->first_name.' '.$customer->last_name, 'cashier'=>$cashier->first_name.' '.$cashier->last_name], 200);
                }
            } else {
                return $this->sendError('Not Allowed. Verified Your Phone', '', 422);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }
}
