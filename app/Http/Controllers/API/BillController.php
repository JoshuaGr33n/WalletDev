<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Bills;
use App\Models\User_wallet;
use App\Models\User_Wallet_Transactions;
use App\Models\User_reward;
use App\Models\User_reward_history;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BillController extends BaseAPIController
{
    public function payBill(Request $request)
    {
        try {
            $cashier = User::where('id', $request->user()->id)->first();
            $customer  = User::where('member_id',  $request->customer_id)->first();
            $outlet = Outlet::Where('id', $request->outlet_id)->first();
            if ($cashier->status == 2) {
                return $this->sendError('Account Deactivated', '', 422);
            }
            if ($cashier->is_phone_verified == true) {
                $messages = [
                    // 'member_id.required' => 'Member_id is required',
                ];
                $validator = Validator::make($request->all(), [
                    // 'outlet_name' => 'required',
                    'outlet_id' => 'required|numeric',
                    'pos_sno' => 'required|numeric',
                    'receipt_type' => 'required',
                    'purch_items' => 'required',
                    'purch_items.*.item_code' => 'required',
                    'purch_items.*.item_desc' => 'required',
                    'purch_items.*.quantity' => 'required|numeric|gt:0',
                    'purch_items.*.unit_price' => 'required|numeric',
                    'purch_items.*.discount.*.discount_amount' => 'numeric',
                    'purch_items.*.sub_item.*.sub_item_code' => 'required',
                    'purch_items.*.sub_item.*.sub_item_desc' => 'required',
                    'purch_items.*.sub_item.*.sub_item_quantity' => 'required|numeric|gt:0',
                    'purch_items.*.sub_item.*.sub_item_unit_price' => 'required|numeric',
                    // 'purch_items.*.name' => 'required',
                    // 'purch_items.*.amount' => 'required',
                    // 'purch_items.*.quantity' => 'required|numeric|gt:0',
                    // 'purch_items.*.discount' => 'required',
                    // 'purch_items.*.discount.*.type' => 'required',
                    // 'purch_items.*.discount.*.amount' => 'required|numeric',
                    'discount' => 'required',
                    'discount.*.discount_description' => 'required',
                    'discount.*.discount_amount' => 'required|numeric',
                    'vat_tax_amt' => 'required|numeric',
                    'rounding_adj' => 'required|numeric',
                    'payment' => 'required',
                    'payment.*.payment_type' => 'required',
                    'payment.*.amount' => 'required|numeric',
                    // 'refund_flag' => 'numeric',
                    // 'cancel_flag' => 'numeric',
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

                    if (empty($request->refund_flag)) {
                        $request->refund_flag = 0;
                    }
                    if (empty($request->cancel_flag)) {
                        $request->cancel_flag = 0;
                    }


                    // $sum_item_discount = 0;
                    $sum_bill_discount = 0;
                    $total_payment_amount = 0;

                    // foreach ($request->purch_items as $item) {
                    //     $item_amount = $item['amount'];
                    //     foreach ($item['discount'] as $key => $item_discount) {
                    //         $sum_item_discount += $item_discount['amount'];
                    //     }
                    // }

                    $item_sum = 0;
                    $item_discount_sum = 0;
                    $sub_item_total_amount = 0;
                    $item_price = 0;
                    foreach ($request->purch_items as $item) {
                        foreach ($item['discount'] as $discount) {
                            $item_discount_sum +=  $discount['discount_amount'];
                        }

                        foreach ($item['sub_item'] as $sub_item) {
                            $result = $sub_item['sub_item_quantity'] * $sub_item['sub_item_unit_price'];
                            $sub_item_total_amount += $result;
                        }
                    }
                    
                    //fill in amount and sub item amounts
                    $purch_items = $request->purch_items;
                    foreach ($purch_items as $key => $value) {
                        $item_price = $value['quantity'] * $value['unit_price'];
                        $item_sum += $item_price;
                        $purch_items[$key]['amount'] = $item_price;

                        foreach ($purch_items[$key]['sub_item'] as $key2 => $item) {
                            $sub_item_price = $item['sub_item_quantity'] * $item['sub_item_unit_price'];
                            $purch_items[$key]['sub_item'][$key2]['sub_item_amount'] = $sub_item_price;
                        }
                    }


                    $item_price_after_discount = $item_sum - $item_discount_sum;
                    $gross_sales = $item_price_after_discount +  $sub_item_total_amount;





                    foreach ($request->discount as $bill_discount) {
                        $sum_bill_discount += $bill_discount['discount_amount'];
                    }

                    foreach ($request->payment as $key => $payment) {
                        $total_payment_amount += $payment['amount'];
                    }

                    foreach ($request->payment as $element) {
                        $payment_type = strtoupper($element['payment_type']);
                        if ($payment_type === "WALLET") {

                            if (!$wallet) {
                                return response()->json(['status' => 'Error', 'status_code' => 150, 'message' => 'No Wallet balance. Top up Your Wallet'], 422);
                            }

                            if ($wallet->wallet_balance < $element['amount']) {
                                return response()->json(['status' => 'Error', 'status_code' => 200, 'message' => 'Insufficient Wallet balance. Top up Your Wallet'], 422);
                            }
                        }
                    }

                    // $total_item_amount = $item_amount * $request->purch_items[0]['quantity'];
                    // $total_discount = $sum_bill_discount + $sum_item_discount;
                    $net_amount = $gross_sales - $sum_bill_discount;
                    $taxable_total = $net_amount + $request->service_charge;
                    $total_tax = $request->vat_tax_amt + $request->svc_tax_amt;
                    $total_after_tax = $taxable_total + $total_tax;
                    $grand_total = $total_after_tax + $request->rounding_adj;

                    if ($total_payment_amount < $grand_total) {
                        return response()->json(['status' => 'Error', 'status_code' => 300, 'message' => 'Insufficient Funds', 'total_payment_amount' => $total_payment_amount, 'grand_total_amount' => $grand_total],  422);
                    }
                    if ($total_payment_amount > $grand_total) {
                        return response()->json(['status' => 'Error', 'status_code' => 400, 'message' => 'Surplus Payment', 'total_payment_amount' => $total_payment_amount, 'grand_total_amount' => $grand_total], 422);
                    }
                    $transaction_id = random_int(100000, 999999);
                    $receipt_id = Str::random(6);
                    $reference_no = '#' . random_int(10000, 99999);
                    $receipt_date = Carbon::now()->format('Y-m-d H:i:s');
                    $bill = Bills::create([
                        'transaction_id' => $transaction_id,
                        'receipt_id' =>  $receipt_id,
                        'reference_no' => $reference_no,
                        'table_no' => $request->table_no,
                        'cashier_id' => $cashier->member_id,
                        'customer_id' => $customer->member_id,
                        'customer_count' => $request->customer_count,
                        'business_name' => 'GrandImperial',
                        'outlet_name' => $outlet->outlet_name,
                        'outlet_id' => $request->outlet_id,
                        'pos_sno' => $request->pos_sno,
                        'purch_items' => $purch_items,
                        'gross_sales' => $gross_sales,
                        'discount' => $request->discount,

                        'receipt_type' => $request->receipt_type,
                        'service_charge' => $request->service_charge,
                        'taxable_total' => $taxable_total,
                        'svc_tax_amt' => $request->svc_tax_amt,
                        'vat_tax_amt' => $request->vat_tax_amt,
                        'total_tax' => $total_tax,
                        'rounding_adj' => $request->rounding_adj,
                        'refund_flag' => $request->refund_flag,
                        'cancel_flag' => $request->cancel_flag,


                        'grand_total' => $grand_total,
                        'payment' => $request->payment,
                        'receipt_date' => $receipt_date
                    ]);



                    foreach ($request->payment as $element) {
                        $payment_type = strtoupper($element['payment_type']);
                        if ($payment_type === "WALLET") {
                            $wallet->update(['wallet_balance' => $wallet->wallet_balance - $element['amount']]);

                            User_Wallet_Transactions::create([
                                'user_id' => $customer->id,
                                'member_id' => $customer->member_id,
                                'transaction_id' => $transaction_id,
                                'receipt_no' => $receipt_id,
                                'wallet_address' =>  $wallet->wallet_address,
                                'wallet_balance' => $wallet->wallet_balance,
                                'rest_id' => 1,
                                'transaction_date' => $receipt_date,
                                'transaction_type' => 2,
                                'outlet_id' => $request->outlet_id,
                                'reason' => '',
                                'request_amount' => $element['amount'],
                                'status' => 1,
                                'staff_id' => $cashier->member_id,
                                'pay_id' => 1
                            ]);
                        }
                    }

                    $points_acquired_today = User_reward_history::select("*")->where('member_id', $customer->member_id)->whereDate('created_at', Carbon::today())->get();
                    $total_points_acquired_today = 0;
                    foreach ($points_acquired_today as $key => $each_point) {
                        $total_points_acquired_today += $each_point['amount'];
                    }

                    $yesterday = Carbon::yesterday();
                    $today = Carbon::today();
                    $tomorrow = Carbon::tomorrow();
                    if ($today < $tomorrow) {
                        $target = 2000;
                        if ($total_points_acquired_today < $target) {

                            //substract excess points
                            $deficit = $total_points_acquired_today + $grand_total;
                            if ($deficit > $target) {
                                $grand_total = $target - $total_points_acquired_today;
                            }

                            $user_reward = User_reward::where('member_id', $customer->member_id)->first();
                            if ($user_reward) {
                                $user_reward->update(['reward_point' => DB::raw('reward_point +' . $grand_total)]);
                            } else {
                                User_reward::create([
                                    'user_id' => $customer->id,
                                    'member_id' => $customer->member_id,
                                    'reward_point' => $grand_total,
                                    'status' => 1
                                ]);
                            }

                            User_reward_history::create([
                                'user_id' => $customer->id,
                                'member_id' => $customer->member_id,
                                'couponcode_id' => 50,
                                'type' => 2,
                                'amount' => $grand_total,
                                'rpoint_per_currency' => 1,
                                'outlet_id' => $request->outlet_id,
                                'merchant_id' => 0,
                                'created_by' => 0,
                                'reward_point' => $grand_total,
                                'status' => 1
                            ]);
                        }
                    }

                    return response()->json(['status' => 'success', 'message' => 'Payment successful', 'data' => $bill, 'outlet' => $outlet->outlet_name, 'customer' => $customer->first_name . ' ' . $customer->last_name, 'cashier' => $cashier->first_name . ' ' . $cashier->last_name], $this->successStatus);
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
