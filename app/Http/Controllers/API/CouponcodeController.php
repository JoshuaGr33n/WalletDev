<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Couponcode;
use App\Models\User_wallet;
use App\Models\Merchant;
use App\Models\Setting;
use App\Models\Outlet;
use App\Models\User_reward;
use App\Models\User_reward_history;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Redeem_voucher;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;
use Lcobucci\JWT\Token\Parser;
use Auth;
use DB;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class CouponcodeController extends BaseAPIController
{
    public function getCoupon(Request $request)
    {
        $user_id = Auth::user()->id;
        $qr_code = $this->generateRandomString(16);
        $validity_seconds = 60*1;
        $type    = 0;
        $status  = 0;

    	$database = $this->firebaseDB();

        $newPost = $database
        ->getReference('qr_codes')
        ->push([
            'qr_code'=> $qr_code,
            'type'   => $type,
            'amount' => 0,
            'user_id'=> $user_id,
            'status' => $status
        ]);
        $firebase_uuid = $newPost->getKey();
        $insertData = array(
                        'user_id' => $user_id, 
                        'type' => $type, 
                        'firebase_uuid' => $firebase_uuid,
                        'coupon' => $qr_code, 
                        'status' => $status,
                        'created_at' => date('Y-m-d H:i:s')
                      );
        Couponcode::insert($insertData);
        $res = array('qr_code' => $qr_code, 'validity_seconds' => $validity_seconds, 'firebase_uuid' => $firebase_uuid);
    	return response()->json(['status' => 'success', 'message' => 'QR code success', 'data' => $res], $this->successStatus);
    }
    public function checkQRStatus(Request $request)
    {
        $messages = ['qr_code' => 'Please enter QR Code'];

        $validator = Validator::make($request->all(), [
            'qr_code' => 'required'
        ], $messages);

        if ($validator->fails()) {

            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }

        $couponInfo = Couponcode::Where('coupon', $request->qr_code)->get()->first();
        if($couponInfo){
            if($couponInfo->status == 0){
                $user_id    = $couponInfo->user_id;
                $to_time    = strtotime(date('Y-m-d H:i:s'));
                $from_time  = strtotime($couponInfo->created_at);
                $minute     = round(abs($to_time - $from_time) / 60,2);

                $database   = $this->firebaseDB();
                //CHECK IS EXPIRY
                if($minute > 120){ //IF EXPIRY
                    $data1   = array(
                                'status' => 3, 
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                    $Couponcode = Couponcode::find($couponInfo->id);
                    $Couponcode->status = 3;
                    $Couponcode->updated_at = date('Y-m-d H:i:s');
                    $Couponcode->save();
                    //UPDATE STATUS TO FIRBASE
                    if($couponInfo->firebase_uuid){
                        $update = $database->getReference('qr_codes')
                                ->getChild($couponInfo->firebase_uuid)
                                ->update($data1);
                    }
                    $data = array('qr_code' => $request->qr_code,'status' => 3, 'type' => intval($couponInfo->type));

                    return response()->json(['status' => 'success', 'message' => 'QR status retrieved', 'data' => $data], $this->successStatus);
                }else{
                    //IF NOT EXPIRY
                    $data = array('qr_code' => $request->qr_code,'status' => intval($couponInfo->status), 'type' => intval($couponInfo->type));
                    
                    return response()->json(['status' => 'success', 'message' => 'QR status retrieved', 'data' => $data], $this->successStatus);
                }
            }else{
                $data = array('qr_code' => $request->qr_code,'status' => intval($couponInfo->status), 'type' => intval($couponInfo->type));
                    
                return response()->json(['status' => 'success', 'message' => 'QR status retrieved', 'data' => $data], $this->successStatus);
            }
        }else{
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Invalid QR Code'),
            ], $this->successStatus);
        }
    }
    
    //TOPUP 
    public function topUp(Request $request)
    {
        $messages = [
                    'amount' => 'Please enter amount',
                    'outlet_id' => 'Please enter outlet id'
                    ];

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:100000',
            'outlet_id' => 'required'
        ], $messages);

        if ($validator->fails()) {

            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }

        $user_id    = Auth::user()->id;
        $outletInfo = Outlet::with('merchant')->Where('id', $request->outlet_id)->first();
        if($outletInfo){
            $merchant_id = $outletInfo->merchant_id;
        }else{
            $merchant_id = '';
        }
        $user_id  = Auth::user()->id;
        
        // $Couponcode = Couponcode::find($couponInfo->id);
        // $Couponcode->type = 1;
        // $Couponcode->transaction_id = 'T-bkksub1'.$this->generateTransactionId();
        // $Couponcode->tranasaction_datetime = date('Y-m-d H:i:s');
        // $Couponcode->currency = 'RM';
        // $Couponcode->amount = $request->amount;
        // $Couponcode->outlet_id = $request->outlet_id;
        // $Couponcode->merchant_id = $merchant_id;
        // $Couponcode->status = 1;
        // $Couponcode->updated_at = date('Y-m-d H:i:s');
        // $Couponcode->save();
        
        $walletInfo = User_wallet::Where('user_id', $user_id)->get()->first();
        if($walletInfo){
            $amount = $walletInfo->amount + $request->amount;
            User_wallet::Where('user_id', $user_id)
                            ->update(array('amount' => $amount, 'updated_at' => date('Y-m-d H:i:s')));
        }else{
            $insertData = array(
                            'user_id' => $user_id, 
                            'amount'  => $request->amount, 
                            'status'  => 1,
                            'created_at' => date('Y-m-d H:i:s')
                          );
            User_wallet::insert($insertData);
        }
        
        //START ADD REWARD POINTS
        $rewardInfo = User_reward::Where('user_id', $user_id)->get()->first();
        $rpointInfo = Setting::Where('status', 1)->Where('_key', 'rpoint_per_currency')->get()->first();
        if($rpointInfo){ $rpoint = $rpointInfo->_value; }else{ $rpoint = 0; }
        $reward_point = $rpoint * $request->amount;

        if($rewardInfo){
            $rewardPoint = $rewardInfo->reward_point + $reward_point;
            User_reward::Where('user_id', $user_id)
                            ->update(array('reward_point' => round($rewardPoint), 'updated_at' => date('Y-m-d H:i:s')));
        }else{
            $insertData2 = array(
                            'user_id' => $user_id, 
                            'reward_point' => round($reward_point), 
                            'status'  => 1,
                            'created_at' => date('Y-m-d H:i:s')
                          );
            User_reward::insert($insertData2);
        }
        //ADD REWARD POINTS HISTORY
        $insertData3 = array(
                        'user_id' => $user_id,
                        'couponcode_id' => 0,
                        'type' => 1,
                        'rpoint_per_currency' => $rpoint,
                        'reward_point' => round($reward_point),
                        'amount' => $request->amount,
                        'outlet_id' => $request->outlet_id,
                        'merchant_id' => $merchant_id,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                      );
        User_reward_history::insert($insertData3);
        //END ADD REWARD POINTS

        $totalTransaction = Couponcode::where('user_id', $user_id)->whereIn('type', [1,2])->where('status', 1)->count();
        $totalTopup = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 1)->count();
        $totalPaid = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 2)->count();
        $walletInfo = User_wallet::where('user_id', $user_id)->get()->first();
        $rewardInfo = User_reward::Where('user_id', $user_id)->get()->first();
        if($walletInfo){ $walletBalance = $walletInfo->amount; }else{ $walletBalance = '0'; }
        if($rewardInfo){ $rewardPoint = $rewardInfo->reward_point; }else{ $rewardPoint = '0'; }

        $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',$user_id)->first();

        $profile     = array(
                             'first_name' => $profileInfo->first_name,
                             'last_name' => $profileInfo->last_name,
                             'dob' => $profileInfo->dob,
                             'area_name' => $profileInfo->userInfo->area->area_name,
                             'area_id' => $profileInfo->userInfo->area->id,
                             'email_address' => $profileInfo->email,
                             'phone_number' => ($profileInfo->phone_number)?$profileInfo->phone_number:'',
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
                             'announcement_data' => array()
                        );
        return response()->json(['status' => 'success', 'message' => 'Topup successfully', 'data' => array($profile)], $this->successStatus);
    }
    public function payAmount(Request $request)
    {
        $messages = [
                    'amount' => 'Please enter amount',
                    'outlet_id' => 'Please enter outlet id',
                    ];

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:100000',
            'outlet_id' => 'required'
        ], $messages);

        if ($validator->fails()) {

            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }

        $outletInfo = Outlet::with('merchant')->Where('id', $request->outlet_id)->first();
        if($outletInfo){
            $merchant_id = $outletInfo->merchant_id;
        }else{
            $merchant_id = '';
        }
        
        $user_id    = Auth::user()->id;
        $walletInfo = User_wallet::Where('user_id', $user_id)->get()->first();
        if($walletInfo){ //IF WALLET EXITS
            if($request->amount > $walletInfo->amount){ //INSUFFICIENT AMOUNT
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'You have insufficient balance please top up.'),
                ], $this->successStatus);
            }else{ //OK
                $amount = $walletInfo->amount - $request->amount;
                User_wallet::Where('user_id', $user_id)
                                ->update(array('amount' => abs($amount), 'updated_at' => date('Y-m-d H:i:s')));
                
                //START ADD REWARD POINTS
                $enablePayInfo = Setting::Where('status', 1)->Where('_key', 'rpoint_for_pay')->get()->first();
                if($enablePayInfo){ $enablePay = $enablePayInfo->_value; }else{ $enablePay = 0; }
                if($enablePay){
                    $rewardInfo = User_reward::Where('user_id', $user_id)->get()->first();
                    $rpointInfo = Setting::Where('status', 1)->Where('_key', 'rpoint_per_currency')->get()->first();
                    if($rpointInfo){ $rpoint = $rpointInfo->_value; }else{ $rpoint = 0; }
                    $reward_point = $rpoint * $request->amount;

                    if($rewardInfo){
                        $rewardPoint = $rewardInfo->reward_point + $reward_point;
                        User_reward::Where('user_id', $user_id)
                                        ->update(array('reward_point' => $rewardPoint, 'updated_at' => date('Y-m-d H:i:s')));
                    }else{
                        $insertData2 = array(
                                        'user_id' => $user_id, 
                                        'reward_point' => $reward_point, 
                                        'status'  => 1,
                                        'created_at' => date('Y-m-d H:i:s')
                                      );
                        User_reward::insert($insertData2);
                    }
                    //ADD REWARD POINTS HISTORY
                    $insertData3 = array(
                                    'user_id' => $user_id, 
                                    'couponcode_id' => 0,
                                    'type' => 2,
                                    'rpoint_per_currency' => $rpoint,
                                    'reward_point' => $reward_point,
                                    'amount' => $request->amount,
                                    'outlet_id' => $request->outlet_id,
                                    'merchant_id' => $merchant_id,
                                    'status' => 1,
                                    'created_at' => date('Y-m-d H:i:s')
                                  );
                    User_reward_history::insert($insertData3);
                }
                //END ADD REWARD POINTS
                $totalTransaction = Couponcode::where('user_id', $user_id)->whereIn('type', [1,2])->where('status', 1)->count();
                $totalTopup = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 1)->count();
                $totalPaid = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 2)->count();
                $walletInfo = User_wallet::where('user_id', $user_id)->get()->first();
                $rewardInfo = User_reward::Where('user_id', $user_id)->get()->first();
                if($walletInfo){ $walletBalance = $walletInfo->amount; }else{ $walletBalance = '0'; }
                if($rewardInfo){ $rewardPoint = $rewardInfo->reward_point; }else{ $rewardPoint = '0'; }

                $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',$user_id)->first();

                $profile    = array(
                                     'first_name' => $profileInfo->first_name,
                                     'last_name' => $profileInfo->last_name,
                                     'dob' => $profileInfo->dob,
                                     'area_name' => $profileInfo->userInfo->area->area_name,
                                     'area_id' => $profileInfo->userInfo->area->id,
                                     'email_address' => $profileInfo->email,
                                     'phone_number' => ($profileInfo->phone_number)?$profileInfo->phone_number:'',
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
                                     'announcement_data' => array()
                                );
                return response()->json(['status' => 'success', 'message' => 'Payment successfully', 'data' => array($profile)], $this->successStatus);
            }
        }else{ //IF WALLET NOT EXITS
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'You have insufficient balance please top up.'),
            ], $this->successStatus);
        }
    }
    public function listTransactions(Request $request)
    {
        if($request->type){
            $transaction = Couponcode::with('Outlet','reward_history')->Where('type',$request->type)->where('user_id',Auth::id())->where('status','1')->orderBy('id','desc')->get();
        }else{
            $transaction = Couponcode::with('Outlet','reward_history')->where('status','1')->where('user_id',Auth::id())->orderBy('id','desc')->get();
        }
        if($transaction) {
            $transactionList = array();
            foreach ($transaction as $value) {
                if($value->Outlet){
                    $merchant_id = $value->Outlet->merchant_id;
                    $merchantInfo = Merchant::Where('id', $value->Outlet->merchant_id)->get()->first();
                    if($merchantInfo){
                        $merchant_name = $merchantInfo->company_name;
                    }else{
                        $merchant_name = '';
                    }
                    $outlet_name = $value->Outlet->outlet_name;
                    $outlet_address = $value->Outlet->outlet_address;
                }else{
                    $merchant_id = 0;
                    $outlet_name = '';
                    $merchant_name = '';
                    $outlet_address = '';
                }
                if($value->reward_history){
                    $reward_point = $value->reward_history->reward_point;
                }else{
                    $reward_point = '';
                }

                $transactionList[] = array(
                                    'transaction_id' => "$value->transaction_id",
                                    'total_amount' => "$value->amount",
                                    'earned_reward_points' => "$reward_point",
                                    'transaction_type' => intval($value->type),
                                    'merchant_id' => intval($merchant_id),
                                    'merchant_name' => "$merchant_name",
                                    'outlet_id' => intval($value->outlet_id),
                                    'outlet_name' => "$outlet_name",
                                    'outlet_address' => "$outlet_address",
                                    'tranasaction_datetime' => "$value->tranasaction_datetime",
                                    'currency' => "$value->currency",
                                    'transaction_status' => intval($value->status)
                                );
            }
            return response()->json(['status' => 'success', 'message' => 'Tranasactions Retrieved', 'data' => $transactionList], $this->successStatus);   
        } else {
            return response()->json(['status' => 'failed', 'message' => 'No Tranasactions Retrieved', 'data' => []], $this->successStatus);    
        }
    }

    public function getUserInfoByQrcode(Request $request)
    {
        $messages = [
                    'outlet_id' => 'Please enter outlet id',
                    'qr_code' => 'Please enter QR Code',
                    ];

        $validator = Validator::make($request->all(), [
            'outlet_id' => 'required',
            'qr_code' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }
        //TEST RESPONSE
        if($request->qr_code == '2lRwbNR0Glq9f4jd'){
            $user_id = 5;
            $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',$user_id)->first();
            if($profileInfo->user_wallet){ $amount = $profileInfo->user_wallet->amount; }else{ $amount = '0'; }
            $totalTransaction = Couponcode::where('user_id', $user_id)->whereIn('type', [1,2])->where('status', 1)->count();
            $totalTopup = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 1)->count();
            $totalPaid  = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 2)->count();
            if($profileInfo->user_reward){ $reward_point = $profileInfo->user_reward->reward_point; }else{ $reward_point = '0'; }

            $token =  $profileInfo->createToken('wallet_pos')->accessToken; 
            $id = (new Parser())->parse($token)->getHeader('jti');
            //$old = $profileInfo->user()->tokens()->where('id','!=',$id)->delete();
            $revoked = DB::table('oauth_access_tokens')->where('id', '!=', $id)->where('user_id',$user_id)->delete();

            DB::table('oauth_access_tokens')->where('id',$id)->update(['expires_at'=>Carbon::now()->addHours(2)]);

            $profileData = array(
                                'token' => $token,
                                'first_name' => $profileInfo->first_name,
                                'last_name' => $profileInfo->last_name,
                                'dob' => $profileInfo->dob,
                                'email' => $profileInfo->email,
                                'user_image' => '',
                                'wallet_balance' => $amount,
                                'total_transactions' => $totalTransaction,
                                'total_topup' => $totalTopup,
                                'total_paid' => $totalPaid,
                                'member_id' => $profileInfo->member_id,
                                'reward_points' => $reward_point
                                );
            return response()->json(['status' => 'success', 'status_code' => 200, 'message' => 'get profile information successfully', 'data' => $profileData], $this->successStatus);
        }
        //END TEST RESPONSE

        $couponInfo = Couponcode::Where('coupon', $request->qr_code)->get()->first();
        $outletInfo = Outlet::with('merchant')->Where('id', $request->outlet_id)->first();
        if($outletInfo){
            $merchant_id = $outletInfo->merchant_id;
        }else{
            $merchant_id = '';
        }
        if($couponInfo){
            if($couponInfo->status == 0){
                $user_id    = $couponInfo->user_id;
                $to_time    = strtotime(date('Y-m-d H:i:s'));
                $from_time  = strtotime($couponInfo->created_at);
                $minute     = round(abs($to_time - $from_time) / 60,2);

                $database   = $this->firebaseDB();
                //CHECK IS EXPIRY
                if($minute > 120){ //IF EXPIRY
                    $data1  = array(
                                'status' => 3, 
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                    $Couponcode = Couponcode::find($couponInfo->id);
                    $Couponcode->status = 3; //EXPIRY
                    $Couponcode->updated_at = date('Y-m-d H:i:s');
                    $Couponcode->save();
                    //UPDATE STATUS TO FIRBASE
                    if($couponInfo->firebase_uuid){
                        $update = $database->getReference('qr_codes')
                                ->getChild($couponInfo->firebase_uuid)
                                ->update($data1);
                    }

                    $revoked = DB::table('oauth_access_tokens')->where('name','wallet_pos')->where('user_id',$user_id)->delete();

                    return response()->json(['status' => 'failed', 'status_code' => 417,
                        'error' => array('message' => 'QR Code Expired'),
                    ], $this->successStatus);
                }else{ //IF NOT EXPIRY
                    $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',$user_id)->first();
                    //UPDATE COUPON STATUS
                    $Couponcode = Couponcode::find($couponInfo->id);
                    $Couponcode->type = 3;
                    $Couponcode->transaction_id = 'U-bkksub2'.$this->generateTransactionId();
                    $Couponcode->tranasaction_datetime = date('Y-m-d H:i:s');
                    $Couponcode->currency = 'RM';
                    $Couponcode->amount = 0;
                    $Couponcode->outlet_id = $request->outlet_id;
                    $Couponcode->merchant_id = $merchant_id;
                    $Couponcode->status = 1; //SUCCESS
                    $Couponcode->updated_at = date('Y-m-d H:i:s');
                    $Couponcode->save();
                    
                    //UPDATE STATUS TO FIRBASE
                    $data2 = array(
                            'type'   => 3,
                            'amount' => 0, 
                            'status' => 1,
                        );
                    if($couponInfo->firebase_uuid){
                        $update = $database->getReference('qr_codes')
                                ->getChild($couponInfo->firebase_uuid)
                                ->update($data2);
                    }
                    if($profileInfo->user_wallet){ $amount = $profileInfo->user_wallet->amount; }else{ $amount = '0'; }
                    $totalTransaction = Couponcode::where('user_id', $user_id)->whereIn('type', [1,2])->where('status', 1)->count();
                    $totalTopup = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 1)->count();
                    $totalPaid  = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 2)->count();
                    if($profileInfo->user_reward){ $reward_point = $profileInfo->user_reward->reward_point; }else{ $reward_point = '0'; }

                    $token =  $profileInfo->createToken('wallet_pos')->accessToken; 
                    $id = (new Parser())->parse($token)->getHeader('jti');
                    $revoked = DB::table('oauth_access_tokens')->where('id', '!=', $id)->where('user_id',$user_id)->delete();
                    DB::table('oauth_access_tokens')->where('id',$id)->update(['expires_at'=>Carbon::now()->addHours(2)]);

                    //UPDATE STATUS EXPIRY PREVIOUS OR_CODE
                    $oldCouponInfo = Couponcode::Where('coupon', '!=', $request->qr_code)->where('user_id', $user_id)->where('type',3)->where('status',0)->first();
                    if($oldCouponInfo){
                        $Couponcode = Couponcode::find($oldCouponInfo->id);
                        $Couponcode->status = 3; //EXPIRY
                        $Couponcode->updated_at = date('Y-m-d H:i:s');
                        $Couponcode->save();
                        //UPDATE STATUS TO FIRBASE
                        if($oldCouponInfo->firebase_uuid){
                            $database   = $this->firebaseDB();
                            $data3      = array(
                                            'status' => 3, 
                                            'updated_at' => date('Y-m-d H:i:s')
                                         );
                            $update = $database->getReference('qr_codes')
                                    ->getChild($oldCouponInfo->firebase_uuid)
                                    ->update($data3);
                        }
                    }
                    //END UPDATE STATUS EXPIRY PREVIOUS OR_CODE
                    $profileData = array(
                                        'token' => $token,
                                        'first_name' => $profileInfo->first_name,
                                        'last_name' => $profileInfo->last_name,
                                        'dob' => $profileInfo->dob,
                                        'email' => $profileInfo->email,
                                        'user_image' => '',
                                        "wallet_balance" => $amount,
                                        "total_transactions" => $totalTransaction,
                                        "total_topup" => $totalTopup,
                                        "total_paid" => $totalPaid,
                                        'member_id' => 'bkk-'.$profileInfo->member_id,
                                        "reward_points" => $reward_point
                                        );
                    return response()->json(['status' => 'success', 'status_code' => 200, 'message' => 'get profile information successfully', 'data' => $profileData], $this->successStatus);
                }
            }elseif($couponInfo->status == 1){
                return response()->json(['status' => 'failed', 'status_code' => 417,
                    'error' => array('message' => 'QR Code Used'),
                ], $this->successStatus);
            }elseif($couponInfo->status == 2){
                return response()->json(['status' => 'failed', 'status_code' => 417,
                    'error' => array('message' => 'QR Code Failed. Please generate a new QR code.'),
                ], $this->successStatus);
            }elseif($couponInfo->status == 3){
                return response()->json(['status' => 'failed', 'status_code' => 417,
                    'error' => array('message' => 'QR Code Expired'),
                ], $this->successStatus);
            }
        }else{
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Invalid QR Code'),
            ], $this->successStatus);
        }
    }

    public function redeemVoucher(Request $request)
    {
        $messages = [
                    'outlet_id' => 'Please enter outlet id',
                    'qr_code' => 'Please enter QR Code',
                    'order_id' => 'Please enter Order id',
                    'coupon_type' => 'Please enter Coupon Type',
                    'member_id' => 'Please enter Member id'
                    ];

        $validator = Validator::make($request->all(), [
            'outlet_id' => 'required',
            'qr_code'   => 'required',
            'order_id' => 'required',
            'coupon_type' => 'required',
            'member_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }
        $user_id = Auth::id();
        //CHECK TOKEN EXPIRY
        $token_id   = (new Parser())->parse($request->bearerToken())->getHeader('jti');
        $checkToken = DB::table('oauth_access_tokens')->where('id',$token_id)->where('user_id', $user_id)->where('expires_at', '>', Carbon::now())->first();
        if ( !$checkToken ) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Token time has expired. Please log in again.')
            ], $this->successStatus);
        }

        //TEST RESPONSE
        if($request->qr_code == 'v-bkksub1535056515599'){
            
            $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',$user_id)->first();
            if($profileInfo->user_wallet){ $amount = $profileInfo->user_wallet->amount; }else{ $amount = '0'; }
            $totalTransaction = Couponcode::where('user_id', $user_id)->whereIn('type', [1,2])->where('status', 1)->count();
            $totalTopup = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 1)->count();
            $totalPaid  = Couponcode::where('user_id', $user_id)->where('status', 1)->where('type', 2)->count();
            if($profileInfo->user_reward){ $reward_point = $profileInfo->user_reward->reward_point; }else{ $reward_point = '0'; }

            $profileData = array(
                                'voucher_transaction_id' => 'vbkk_'.rand(),
                                'voucher_type' => 1,
                                'price_type' => 1,
                                'value' => '20',
                                'product_id' => '',
                                'product_name' => ''
                                );
            return response()->json(['status' => 'success', 'status_code' => 200, 'message' => 'Voucher Redeem Successful', 'data' => $profileData], $this->successStatus);
        }
        // else{
        //     return response()->json(['status' => 'failed',
        //         'error' => array('message' => 'Invalid Voucher Code'),
        //         ], $this->successStatus);
        // }
        //END TEST RESPONSE

        $couponInfo = Couponcode::Where('user_id', $user_id)->where('type',3)->where('status',1)->first();
        if($couponInfo){
            if($couponInfo->outlet_id != $request->outlet_id){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'Invalid Outlet'),
                ], $this->successStatus);
            }
        }else{
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Invalid QR Code'),
            ], $this->successStatus);
        }

        $voucherInfo = Voucher::Where('voucher_code', $request->qr_code)->first();
        if($voucherInfo){
            $sale_end_date = date('Y-m-d',strtotime($voucherInfo->sale_end_date));
            if($voucherInfo->status == 2){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'voucher code temporarily not available'),
                ], $this->successStatus);
            }elseif (($voucherInfo->status == 3) || ($sale_end_date < date('Y-m-d'))) {
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'Voucher Code Expired'),
                ], $this->successStatus);
            }

            if($voucherInfo->voucher_type_id != $request->coupon_type){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'Invalid Coupon Type'),
                ], $this->successStatus);
            }

            $profileInfo = User::with('userInfo','user_reward','user_wallet')->where('id',$user_id)->first();
            if($profileInfo->user_reward){ $reward_point = intval($profileInfo->user_reward->reward_point); }else{ $reward_point = 0; }
            if(intval($voucherInfo->total_required_points) > $reward_point){
                return response()->json(['status' => 'failed',
                            'error' => array('message' => 'Insufficient reward points'),
                        ], $this->successStatus);
            }

            $voucherCount = Redeem_voucher::where('voucher_code',$request->qr_code)->count();
            $userVoucherCount = Redeem_voucher::where('voucher_code',$request->qr_code)->where('user_id',$user_id)->count();
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
                $rewardPoint = intval($profileInfo->user_reward->reward_point) - $voucherInfo->total_required_points;
                User_reward::Where('user_id', $user_id)->update(array('reward_point' => $rewardPoint, 'updated_at' => date('Y-m-d H:i:s')));
                $expiry_date = date('Y-m-d', strtotime('+1 year'));
                $insertData  = array(
                                    'user_id' => $user_id,
                                    'voucher_code' => $request->qr_code,
                                    'voucher_transaction_id' => 'vbkk_'.rand(),
                                    'voucher_value' => $voucherInfo->voucher_value,
                                    'discount_type' => $voucherInfo->discount_type,
                                    'spend_rpoints' => $voucherInfo->total_required_points,
                                    'expiry_date' => $expiry_date,
                                    'status' => 0,
                                    'created_at' => date('Y-m-d H:i:s')
                                );
                Redeem_voucher::insert($insertData);
            }
            $profileData = array(
                                'voucher_transaction_id' => 'vbkk_'.rand(),
                                'voucher_type' => 1,
                                'price_type' => 1,
                                'value' => '20',
                                'product_id' => '',
                                'product_name' => ''
                                );
            return response()->json(['status' => 'success', 'status_code' => 200, 'message' => 'Voucher Redeem Successful', 'data' => $profileData], $this->successStatus);

        }
    }

    public function addTransaction(Request $request)
    {
        $messages = [
                    'outlet_id' => 'Please enter outlet id',
                    'order_id' => 'Please enter Order id',
                    'transaction_id' => 'Please enter Transaction',
                    'total' => 'Please enter Total amount'
                    ];

        $validator = Validator::make($request->all(), [
            'outlet_id' => 'required',
            'order_id' => 'required',
            'transaction_id' => 'required',
            'total' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }
        $user_id = Auth::id();
        //CHECK TOKEN EXPIRY
        $token_id   = (new Parser())->parse($request->bearerToken())->getHeader('jti');
        $checkToken = DB::table('oauth_access_tokens')->where('id',$token_id)->where('user_id', $user_id)->where('expires_at', '>', Carbon::now())->first();
        if ( !$checkToken ) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Token time has expired. Please log in again.')
            ], $this->successStatus);
        }

        return response()->json(['status' => 'success', 'status_code' => 200, 'message' => 'Transaction added successfully', 'data' => array()], $this->successStatus);
        // return response()->json(['status' => 'failed',
        //     'error' => array('message' => 'Adding transaction failure'),
        //     ], $this->successStatus);
    }

    public function cancelVoucher(Request $request)
    {
        $messages = [
                    'outlet_id' => 'Please enter outlet id',
                    'voucher_id' => 'Please enter voucher id',
                    'order_id' => 'Please enter Order id',
                    'coupon_type' => 'Please enter coupon type',
                    'member_id' => 'Please enter member id'
                    ];

        $validator = Validator::make($request->all(), [
            'outlet_id' => 'required',
            'voucher_id' => 'required',
            'order_id' => 'required',
            'coupon_type' => 'required',
            'member_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }
        $user_id = Auth::id();
        //CHECK TOKEN EXPIRY
        $token_id   = (new Parser())->parse($request->bearerToken())->getHeader('jti');
        $checkToken = DB::table('oauth_access_tokens')->where('id',$token_id)->where('user_id', $user_id)->where('expires_at', '>', Carbon::now())->first();
        if ( !$checkToken ) {
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Token time has expired. Please log in again.')
            ], $this->successStatus);
        }

        if($request->voucher_id == 'v-bkksub1555255559899'){
            return response()->json(['status' => 'success', 'status_code' => 200, 'message' => 'Voucher Removed successfully', 'data' => array()], $this->successStatus);
        }
        else{
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Invalid voucher code'),
            ], $this->successStatus);
        }
        // return response()->json(['status' => 'failed',
        //     'error' => array('message' => 'Failed to remove'),
        //     ], $this->successStatus);
    }

    public function firebaseDB()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(base_path().'/public/firebase/bungkuskawkaw-ea7fb-firebase-adminsdk-0rxsi-62163c5d27.json');
        $firebase = (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->withDatabaseUri('https://bungkuskawkaw-ea7fb.firebaseio.com/')
                        ->create();
        return $firebase->getDatabase();
    }

    public  function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function generateTransactionId(){
        mt_srand((double)microtime()*10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*",$charid);
        $c = implode("",$c);

        return substr($c,0,16);
    }
    //TOPUP OLD
    public function topUp_old(Request $request)
    {
        $messages = [
                    'amount' => 'Please enter amount',
                    'outlet_id' => 'Please enter outlet id',
                    'qr_code' => 'Please enter QR Code',
                    ];

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:100000',
            'outlet_id' => 'required',
            'qr_code' => 'required',
        ], $messages);

        if ($validator->fails()) {

            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }

        $couponInfo = Couponcode::Where('coupon', $request->qr_code)->get()->first();
        $outletInfo = Outlet::with('merchant')->Where('id', $request->outlet_id)->first();
        if($outletInfo){
            $merchant_id = $outletInfo->merchant_id;
        }else{
            $merchant_id = '';
        }
        if($couponInfo){
            if($couponInfo->status == 0){
                $user_id    = $couponInfo->user_id;
                $to_time    = strtotime(date('Y-m-d H:i:s'));
                $from_time  = strtotime($couponInfo->created_at);
                $minute     = round(abs($to_time - $from_time) / 60,2);

                $database   = $this->firebaseDB();
                //CHECK IS EXPIRY
                if($minute > 1){ //IF EXPIRY
                    $data1   = array(
                                'status' => 3, 
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                    $Couponcode = Couponcode::find($couponInfo->id);
                    $Couponcode->status = 3;
                    $Couponcode->updated_at = date('Y-m-d H:i:s');
                    $Couponcode->save();
                    //UPDATE STATUS TO FIRBASE
                    if($couponInfo->firebase_uuid){
                        $update = $database->getReference('qr_codes')
                                ->getChild($couponInfo->firebase_uuid)
                                ->update($data1);
                    }
                    return response()->json(['status' => 'failed',
                        'error' => array('message' => 'QR Code Expired'),
                    ], $this->successStatus);
                }else{
                    //IF NOT EXPIRY
                    $data2  = array(
                                'type'   => 1,
                                'amount' => $request->amount, 
                                'status' => 1,
                            );
                    $Couponcode = Couponcode::find($couponInfo->id);
                    $Couponcode->type = 1;
                    $Couponcode->transaction_id = 'T-bkksub1'.$this->generateTransactionId();
                    $Couponcode->tranasaction_datetime = date('Y-m-d H:i:s');
                    $Couponcode->currency = 'RM';
                    $Couponcode->amount = $request->amount;
                    $Couponcode->outlet_id = $request->outlet_id;
                    $Couponcode->merchant_id = $merchant_id;
                    $Couponcode->status = 1;
                    $Couponcode->updated_at = date('Y-m-d H:i:s');
                    $Couponcode->save();
                    
                    $walletInfo = User_wallet::Where('user_id', $user_id)->get()->first();
                    if($walletInfo){
                        $amount = $walletInfo->amount + $request->amount;
                        User_wallet::Where('user_id', $user_id)
                                        ->update(array('amount' => $amount, 'updated_at' => date('Y-m-d H:i:s')));
                    }else{
                        $insertData = array(
                                        'user_id' => $user_id, 
                                        'amount'  => $request->amount, 
                                        'status'  => 1,
                                        'created_at' => date('Y-m-d H:i:s')
                                      );
                        User_wallet::insert($insertData);
                    }
                    //UPDATE STATUS TO FIRBASE
                    if($couponInfo->firebase_uuid){
                        $update = $database->getReference('qr_codes')
                                ->getChild($couponInfo->firebase_uuid)
                                ->update($data2);
                    }
                    //START ADD REWARD POINTS
                    $rewardInfo = User_reward::Where('user_id', $user_id)->get()->first();
                    $rpointInfo = Setting::Where('status', 1)->Where('_key', 'rpoint_per_currency')->get()->first();
                    if($rpointInfo){ $rpoint = $rpointInfo->_value; }else{ $rpoint = 0; }
                    $reward_point = $rpoint * $request->amount;

                    if($rewardInfo){
                        $rewardPoint = $rewardInfo->reward_point + $reward_point;
                        User_reward::Where('user_id', $user_id)
                                        ->update(array('reward_point' => round($rewardPoint), 'updated_at' => date('Y-m-d H:i:s')));
                    }else{
                        $insertData2 = array(
                                        'user_id' => $user_id, 
                                        'reward_point' => round($reward_point), 
                                        'status'  => 1,
                                        'created_at' => date('Y-m-d H:i:s')
                                      );
                        User_reward::insert($insertData2);
                    }
                    //ADD REWARD POINTS HISTORY
                    $insertData3 = array(
                                    'user_id' => $user_id,
                                    'couponcode_id' => $couponInfo->id,
                                    'type' => 1,
                                    'rpoint_per_currency' => $rpoint,
                                    'reward_point' => round($reward_point),
                                    'amount' => $request->amount,
                                    'outlet_id' => $request->outlet_id,
                                    'merchant_id' => $merchant_id,
                                    'status' => 1,
                                    'created_at' => date('Y-m-d H:i:s')
                                  );
                    User_reward_history::insert($insertData3);
                    //END ADD REWARD POINTS

                    return response()->json(['status' => 'success', 'message' => 'Topup successfully', 'data' => array()], $this->successStatus);
                }
            }elseif($couponInfo->status == 1){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'QR Code Used'),
                ], $this->successStatus);
            }elseif($couponInfo->status == 2){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'QR Code Failed. Please generate a new QR code.'),
                ], $this->successStatus);
            }elseif($couponInfo->status == 3){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'QR Code Expired'),
                ], $this->successStatus);
            }
        }else{
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Invalid QR Code'),
            ], $this->successStatus);
        }
    }
    //PAID OLD
    public function payAmount_old(Request $request)
    {
        $messages = [
                    'amount' => 'Please enter amount',
                    'outlet_id' => 'Please enter outlet id',
                    'qr_code' => 'Please enter QR Code',
                    ];

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:100000',
            'outlet_id' => 'required',
            'qr_code' => 'required',
        ], $messages);

        if ($validator->fails()) {

            return response()->json(['status' => 'failed',
                'error' => array('message' => $validator->errors()->first()),
            ], $this->successStatus);
        }

        $couponInfo = Couponcode::Where('coupon', $request->qr_code)->get()->first();
        $outletInfo = Outlet::with('merchant')->Where('id', $request->outlet_id)->first();
        if($outletInfo){
            $merchant_id = $outletInfo->merchant_id;
        }else{
            $merchant_id = '';
        }
        if($couponInfo){
            if($couponInfo->status == 0){
                $user_id    = $couponInfo->user_id;
                $to_time    = strtotime(date('Y-m-d H:i:s'));
                $from_time  = strtotime($couponInfo->created_at);
                $minute     = round(abs($to_time - $from_time) / 60,2);

                $database   = $this->firebaseDB();
                //CHECK IS EXPIRY
                if($minute > 1){ //IF EXPIRY
                    $data1  = array(
                                'status' => 3, 
                                'updated_at' => date('Y-m-d H:i:s')
                            );
                    $Couponcode = Couponcode::find($couponInfo->id);
                    $Couponcode->status = 3; //EXPIRY
                    $Couponcode->updated_at = date('Y-m-d H:i:s');
                    $Couponcode->save();
                    //UPDATE STATUS TO FIRBASE
                    if($couponInfo->firebase_uuid){
                        $update = $database->getReference('qr_codes')
                                ->getChild($couponInfo->firebase_uuid)
                                ->update($data1);
                    }
                    return response()->json(['status' => 'failed',
                        'error' => array('message' => 'QR Code Expired'),
                    ], $this->successStatus);
                }else{ //IF NOT EXPIRY
                    $walletInfo = User_wallet::Where('user_id', $user_id)->get()->first();
                    if($walletInfo){ //IF WALLET EXITS
                        if($request->amount > $walletInfo->amount){ //INSUFFICIENT AMOUNT
                            //UPDATE COUPON STATUS
                            $Couponcode = Couponcode::find($couponInfo->id);
                            $Couponcode->type = 2;
                            $Couponcode->amount = $request->amount;
                            $Couponcode->outlet_id = $request->outlet_id;
                            $Couponcode->merchant_id = $merchant_id;
                            $Couponcode->status = 2; //FAILED
                            $Couponcode->updated_at = date('Y-m-d H:i:s');
                            $Couponcode->save();
                            //UPDATE STATUS TO FIRBASE
                            $data2 = array(
                                    'type'   => 2,
                                    'amount' => $request->amount, 
                                    'status' => 2,
                                );
                            if($couponInfo->firebase_uuid){
                                $update = $database->getReference('qr_codes')
                                        ->getChild($couponInfo->firebase_uuid)
                                        ->update($data2);
                            }
                            return response()->json(['status' => 'failed',
                                'error' => array('message' => 'You have insufficient balance please top up.'),
                            ], $this->successStatus);
                        }else{ //OK
                            //UPDATE COUPON STATUS
                            $Couponcode = Couponcode::find($couponInfo->id);
                            $Couponcode->type = 2;
                            $Couponcode->transaction_id = 'T-bkksub2'.$this->generateTransactionId();
                            $Couponcode->tranasaction_datetime = date('Y-m-d H:i:s');
                            $Couponcode->currency = 'RM';
                            $Couponcode->amount = $request->amount;
                            $Couponcode->outlet_id = $request->outlet_id;
                            $Couponcode->merchant_id = $merchant_id;
                            $Couponcode->status = 1; //SUCCESS
                            $Couponcode->updated_at = date('Y-m-d H:i:s');
                            $Couponcode->save();
                            $amount = $walletInfo->amount - $request->amount;
                            User_wallet::Where('user_id', $user_id)
                                            ->update(array('amount' => abs($amount), 'updated_at' => date('Y-m-d H:i:s')));
                            //UPDATE STATUS TO FIRBASE
                            $data2 = array(
                                    'type'   => 2,
                                    'amount' => $request->amount, 
                                    'status' => 1,
                                );
                            if($couponInfo->firebase_uuid){
                                $update = $database->getReference('qr_codes')
                                        ->getChild($couponInfo->firebase_uuid)
                                        ->update($data2);
                            }
                            //START ADD REWARD POINTS
                            $enablePayInfo = Setting::Where('status', 1)->Where('_key', 'rpoint_for_pay')->get()->first();
                            if($enablePayInfo){ $enablePay = $enablePayInfo->_value; }else{ $enablePay = 0; }
                            if($enablePay){
                                $rewardInfo = User_reward::Where('user_id', $user_id)->get()->first();
                                $rpointInfo = Setting::Where('status', 1)->Where('_key', 'rpoint_per_currency')->get()->first();
                                if($rpointInfo){ $rpoint = $rpointInfo->_value; }else{ $rpoint = 0; }
                                $reward_point = $rpoint * $request->amount;

                                if($rewardInfo){
                                    $rewardPoint = $rewardInfo->reward_point + $reward_point;
                                    User_reward::Where('user_id', $user_id)
                                                    ->update(array('reward_point' => $rewardPoint, 'updated_at' => date('Y-m-d H:i:s')));
                                }else{
                                    $insertData2 = array(
                                                    'user_id' => $user_id, 
                                                    'reward_point' => $reward_point, 
                                                    'status'  => 1,
                                                    'created_at' => date('Y-m-d H:i:s')
                                                  );
                                    User_reward::insert($insertData2);
                                }
                                //ADD REWARD POINTS HISTORY
                                $insertData3 = array(
                                                'user_id' => $user_id, 
                                                'couponcode_id' => $couponInfo->id,
                                                'type' => 2,
                                                'rpoint_per_currency' => $rpoint,
                                                'reward_point' => $reward_point,
                                                'amount' => $request->amount,
                                                'outlet_id' => $request->outlet_id,
                                                'merchant_id' => $merchant_id,
                                                'status' => 1,
                                                'created_at' => date('Y-m-d H:i:s')
                                              );
                                User_reward_history::insert($insertData3);
                            }
                            //END ADD REWARD POINTS

                            return response()->json(['status' => 'success', 'message' => 'Payment successfully', 'data' => array()], $this->successStatus);
                        }
                    }else{ //IF WALLET NOT EXITS
                        //UPDATE COUPON STATUS
                        $Couponcode = Couponcode::find($couponInfo->id);
                        $Couponcode->type = 2;
                        $Couponcode->amount = $request->amount;
                        $Couponcode->outlet_id = $request->outlet_id;
                        $Couponcode->status = 2; //FAILED
                        $Couponcode->updated_at = date('Y-m-d H:i:s');
                        $Couponcode->save();
                        //UPDATE STATUS TO FIRBASE
                        $data2 = array(
                                'type'   => 2,
                                'amount' => $request->amount, 
                                'status' => 2,
                            );
                        if($couponInfo->firebase_uuid){
                            $update = $database->getReference('qr_codes')
                                    ->getChild($couponInfo->firebase_uuid)
                                    ->update($data2);
                        }
                        return response()->json(['status' => 'failed',
                            'error' => array('message' => 'You have insufficient balance please top up.'),
                        ], $this->successStatus);
                    }
                }
            }elseif($couponInfo->status == 1){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'QR Code Used'),
                ], $this->successStatus);
            }elseif($couponInfo->status == 2){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'QR Code Failed. Please generate a new QR code.'),
                ], $this->successStatus);
            }elseif($couponInfo->status == 3){
                return response()->json(['status' => 'failed',
                    'error' => array('message' => 'QR Code Expired'),
                ], $this->successStatus);
            }
        }else{
            return response()->json(['status' => 'failed',
                'error' => array('message' => 'Invalid QR Code'),
            ], $this->successStatus);
        }
    }
}
