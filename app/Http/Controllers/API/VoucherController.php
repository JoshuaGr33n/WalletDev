<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Redeem_voucher;
use App\Models\User_reward;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;

class VoucherController extends BaseAPIController
{
    public function listVouchers(Request $request)
    {
    	$voucherList = array();
    	if($request->discount_type){
            $vouchers = Voucher::With('voucherType')->WhereDate('sale_end_date', '>=', date('Y-m-d'))->where('discount_type',$request->discount_type)->where('status','1')->get();
        }else{
            $vouchers = Voucher::With('voucherType')->WhereDate('sale_end_date', '>=', date('Y-m-d'))->where('status','1')->get();
        }
        if($vouchers){
        	foreach ($vouchers as $key => $value) {
        		$voucherImg = (!empty($value->voucher_image)) ? URL('uploads/voucher/' . $value->voucher_image) : URL('images/noimage.png');
        		$voucherList[] = array(
        							"voucher_code" => "$value->voucher_code",
									"voucher_name" => "$value->voucher_name",
                                    "voucher_type_id" => ($value->voucherType)? $value->voucherType->type_id : '',
									"voucher_description" => "$value->voucher_description",
                                    "voucher_start_date" => "$value->sale_start_date",
									"voucher_end_date" => "$value->sale_end_date",
									"discount_type" => intval($value->discount_type),
									"voucher_value" => "$value->voucher_value",
                                    "max_discount_amount" => "$value->max_discount_amount",
									"total_required_points" => intval($value->total_required_points),
									"t_and_c" => "$value->tAndC",
									"voucher_logo" => "$voucherImg",
									"is_multi_redeem" => intval(1),
									"redeemed_count" => intval($value->single_user_qty),
                                    "max_qty" => intval($value->max_qty),
									"is_all_outlet" => intval(1),
        						);
        	}
        }
    	return response()->json(['status' => 'success', 'message' => 'Voucher list Retrieved', 'data' => $voucherList], $this->successStatus);
    }
    public function redeemVouchers(Request $request)
    {
        $messages = ['voucher_code' => 'Please enter Voucher Code'];

        $validator = Validator::make($request->all(), [
            'voucher_code' => 'required'
        ], $messages);

        if ($validator->fails()) {

            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }

        $voucherInfo = Voucher::Where('voucher_code', $request->voucher_code)->get()->first();
        
        if($voucherInfo){
            $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',Auth::id())->first();
            $sale_end_date = date('Y-m-d',strtotime($voucherInfo->sale_end_date));
            if($sale_end_date < date('Y-m-d')){
                return response()->json(['status' => 'failed',
                            'error' => array('message' => 'Voucher code is expired'),
                        ], $this->successStatus);
            }

            if($profileInfo->user_reward){ $reward_point = intval($profileInfo->user_reward->reward_point); }else{ $reward_point = 0; }
            if(intval($voucherInfo->total_required_points) > $reward_point){
                return response()->json(['status' => 'failed',
                            'error' => array('message' => 'Insufficient reward points'),
                        ], $this->successStatus);
            }

            $voucherCount = Redeem_voucher::where('voucher_code',$request->voucher_code)->count();
            $userVoucherCount = Redeem_voucher::where('voucher_code',$request->voucher_code)->where('user_id',Auth::id())->count();
            if((intval($voucherInfo->max_qty) <= $voucherCount) && $voucherInfo->max_qty){
                return response()->json(['status' => 'failed',
                            'error' => array('message' => 'Out of stock voucher code.'),
                        ], $this->successStatus);
            }

            if((intval($voucherInfo->single_user_qty) <= $userVoucherCount) && $voucherInfo->single_user_qty){
                return response()->json(['status' => 'failed',
                            'error' => array('message' => 'sorry you have reached the collection limit for this voucher.'),
                        ], $this->successStatus);
            }

            if($profileInfo->user_reward->reward_point){
                $rewardPoint = intval($profileInfo->user_reward->reward_point) - intval($voucherInfo->total_required_points);
                User_reward::Where('user_id', Auth::id())->update(array('reward_point' => $rewardPoint, 'updated_at' => date('Y-m-d H:i:s')));
                $expiry_date = date('Y-m-d', strtotime('+1 year'));
                $insertData  = array(
                                    'user_id' => Auth::id(),
                                    'voucher_code' => $request->voucher_code,
                                    'voucher_transaction_id' => 'vbkk_'.rand(),
                                    'voucher_value' => $voucherInfo->voucher_value,
                                    'discount_type' => $voucherInfo->discount_type,
                                    'spend_rpoints' => intval($voucherInfo->total_required_points),
                                    'expiry_date' => $expiry_date,
                                    'status' => 0,
                                    'created_at' => date('Y-m-d H:i:s')
                                );
                Redeem_voucher::insert($insertData);
            }
            $voucherImg = (!empty($voucherInfo->voucher_image)) ? URL('uploads/voucher/' . $voucherInfo->voucher_image) : URL('images/noimage.png');
            $data = array(
                            "voucher_code" => "$voucherInfo->voucher_code",
                            "voucher_name" => "$voucherInfo->voucher_name",
                            "voucher_description" => "$voucherInfo->voucher_description",
                            "voucher_start_date" => "$voucherInfo->sale_start_date",
                            "voucher_end_date" => "$voucherInfo->sale_end_date",
                            "discount_type" => intval($voucherInfo->discount_type),
                            "voucher_value" => "$voucherInfo->voucher_value",
                            "max_discount_amount" => "$voucherInfo->max_discount_amount",
                            "total_required_points" => intval($voucherInfo->total_required_points),
                            "t_and_c" => "$voucherInfo->tAndC",
                            "voucher_logo" => "$voucherImg",
                            "is_multi_redeem" => intval(1),
                            "redeemed_count" => intval($voucherInfo->single_user_qty),
                            "max_qty" => intval($voucherInfo->max_qty),
                            "is_all_outlet" => intval(1)
                        );
            
            return response()->json(['status' => 'success', 'message' => 'Voucher code redeemed successfully.', 'data' => $data], $this->successStatus);

        }else{
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Invalid Voucher Code'),
            ], $this->successStatus);
        }
    }
    public function getRedeemedVouchers(Request $request)
    {
        $voucherList = array();
        if($request->discount_type){
            $vouchers = Redeem_voucher::whereDate('expiry_date', '>=', date('Y-m-d'))->where('user_id',Auth::id())->where('discount_type',$request->discount_type)->get();
        }else{
            $vouchers = Redeem_voucher::WhereDate('expiry_date', '>=', date('Y-m-d'))->where('user_id',Auth::id())->get();
        }
        //print_r($vouchers);
        if(count($vouchers) > 0){
            foreach ($vouchers as $key => $value) {
                $voucherInfo = Voucher::Where('voucher_code', $value->voucher_code)->get()->first();
                $voucherImg  = (!empty($value->voucher_image)) ? URL('uploads/voucher/' . $value->voucher_image) : URL('images/noimage.png');
                $voucherList[] = array(
                                    "redeem_id" => intval($value->id),
                                    "voucher_code" => "$value->voucher_code",
                                    "voucher_name" => "$voucherInfo->voucher_name",
                                    "voucher_description" => "$voucherInfo->voucher_description",
                                    "expiry_date" => "$value->expiry_date",
                                    "discount_type" => intval($value->discount_type),
                                    "voucher_value" => "$value->voucher_value",
                                    "max_discount_amount" => "$value->max_discount_amount",
                                    "total_required_points" => intval($value->spend_rpoints),
                                    "t_and_c" => "$voucherInfo->tAndC",
                                    "voucher_logo" => "$voucherImg",
                                    "is_multi_redeem" => intval(1),
                                    "redeemed_count" => intval($voucherInfo->single_user_qty),
                                    "is_all_outlet" => intval(1),
                                    "status" => intval($value->status)
                                );
            }
            return response()->json(['status' => 'success', 'message' => 'Get redeemed Voucher successfully', 'data' => $voucherList], $this->successStatus);
        }else{
            return response()->json(['status' => 'success', 'message' => 'No redeemed Voucher found.', 'data' => $voucherList], $this->successStatus);
        }
    }
}
