<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Bills;
use App\Models\User_wallet;
use App\Models\User_reward;
use App\Models\User_reward_history;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BillController extends BaseAPIController
{
    public function payBill(Request $request)
    {
        try {

            $messages = [
                'member_id.required' => 'Member_id is required',
            ];
            $validator = Validator::make($request->all(), [
                'receipt_number' => 'required',
                'business_name' => 'required',
                'outlet_name' => 'required',
                'outlet_id' => 'required|numeric',
                'terminal_id' => 'required',
                'item' => 'required',
                'item.*.name' => 'required',
                'item.*.amount' => 'required',
                'item.*.quantity' => 'required|numeric|gt:0',
                'item.*.discount' => 'required',
                'item.*.discount.*.type' => 'required',
                'item.*.discount.*.amount' => 'required|numeric',
                'discount' => 'required',
                'discount.*.type' => 'required',
                'discount.*.amount' => 'required|numeric',
                'payment' => 'required',
                'payment.*.type' => 'required',
                'payment.*.amount' => 'required|numeric',
                'member_id' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return response()->json(['status' => 'Error', 'status_code' => 100, 'message' => 'Validation Error', $validator->errors()], 422);
            } else {
                $member_id = $request->member_id;
                $user = User::where('member_id', $member_id)->first();
                if(!$user){
                    return response()->json(['status' => 'Error', 'status_code' => 120, 'message' => 'Unknown Customer'], 422);
                }

                $wallet = User_wallet::where('member_id', $member_id)->first();
                

                $sum_item_discount = 0;
                $sum_bill_discount = 0;
                $total_payment_amount = 0;

                foreach ($request->item as $item) {
                    $item_amount = $item['amount'];
                    foreach ($item['discount'] as $key => $item_discount) {
                        $sum_item_discount += $item_discount['amount'];
                    }
                }

                foreach ($request->discount as $bill_discount) {
                    $sum_bill_discount += $bill_discount['amount'];
                }

                foreach ($request->payment as $key => $payment) {
                    $total_payment_amount += $payment['amount'];
                }

                foreach ($request->payment as $element) {
                    if ($element['type'] === "Wallet") {

                        if(!$wallet){
                            return response()->json(['status' => 'Error', 'status_code' => 150, 'message' => 'No Wallet balance. Credit Your Wallet'], 422);
                        }

                        if ($wallet->amount < $element['amount']) {
                            return response()->json(['status' => 'Error', 'status_code' => 200, 'message' => 'Insufficient Wallet balance'], 422);
                        } 
                    }
                }

                $total_item_amount = $item_amount * $request->item[0]['quantity'];
                $total_discount = $sum_bill_discount + $sum_item_discount;
                $final_amount = $total_item_amount - $total_discount;

                if ($total_payment_amount < $final_amount) {
                    return response()->json(['status' => 'Error', 'status_code' => 300, 'message' => 'Insufficient Funds'], 422);
                } 
                if ($total_payment_amount > $final_amount) {
                    return response()->json(['status' => 'Error', 'status_code' => 400, 'message' => 'Surplus Payment'], 422);
                } 

                $bill = Bills::create([
                    'receipt_number' => $request->receipt_number,
                    'business_name' => $request->business_name,
                    'outlet_name' => $request->outlet_name,
                    'outlet_id' => $request->outlet_id,
                    'terminal_id' => $request->terminal_id,
                    'item' => $request->item,
                    'discount' => $request->discount,
                    'amount' => $final_amount,
                    'payment' => $request->payment,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'member_id' => $member_id
                ]);

                

                foreach ($request->payment as $element) {
                    if ($element['type'] === "Wallet") {
                        $wallet->update(['amount' => $wallet->amount - $element['amount']]);
                    }
                }
                $user_reward = User_reward::where('member_id', $member_id)->first();
                if($user_reward){
                    $user_reward->update(['reward_point' => DB::raw('reward_point +'.$final_amount)]);
                }else{
                    User_reward::create([
                        'user_id' => $user->id,
                        'member_id' => $member_id,
                        'reward_point' => $final_amount,
                        'status' => 1
                    ]);
    
                }

                User_reward_history::create([
                    'user_id' => $user->id,
                    'member_id' => $member_id,
                    'couponcode_id' => 50,
                    'type' => 2,
                    'amount' => $final_amount,
                    'rpoint_per_currency' => 1,
                    'outlet_id' => $request->outlet_id,
                    'merchant_id' => 0,
                    'created_by' => 0,
                    'reward_point' => $final_amount,
                    'status' => 1
                ]);
                
                return response()->json(['status' => 'success', 'message' => 'Payment successful', 'data' => $bill], $this->successStatus);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }
}
