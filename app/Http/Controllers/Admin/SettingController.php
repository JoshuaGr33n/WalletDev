<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Datatables;
use Validator;
use Auth;
use DB;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('AdminAccess'); // Allows Access to Admin
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rpointInfo = Setting::Where('status', 1)->Where('_key', 'rpoint_per_currency')->get()->first();
        if($rpointInfo){ $data['rpoint'] = $rpointInfo->_value; }else{ $data['rpoint'] = 0; }
        $mintopupInfo = Setting::Where('status', 1)->Where('_key', 'min_topup_amount')->get()->first();
        if($mintopupInfo){ $data['mintopupamt'] = $mintopupInfo->_value; }else{ $data['mintopupamt'] = 0; }
        $maxtopupInfo = Setting::Where('status', 1)->Where('_key', 'max_topup_amount')->get()->first();
        if($maxtopupInfo){ $data['maxtopupamt'] = $maxtopupInfo->_value; }else{ $data['maxtopupamt'] = 0; }
        $maxwalletamtInfo = Setting::Where('status', 1)->Where('_key', 'max_wallet_amount')->get()->first();
        if($maxwalletamtInfo){ $data['maxwalletamt'] = $maxwalletamtInfo->_value; }else{ $data['maxwalletamt'] = 0; }
        $topupamtopnInfo = Setting::Where('status', 1)->Where('_key', 'topup_amount_options')->get()->first();
        if($topupamtopnInfo){ $data['topupamtopn'] = $topupamtopnInfo->_value; }else{ $data['topupamtopn'] = 0; }
        $enablePayInfo = Setting::Where('status', 1)->Where('_key', 'rpoint_for_pay')->get()->first();
        if($enablePayInfo){ $data['enablePay'] = $enablePayInfo->_value; }else{ $data['enablePay'] = 0; }
        $data['title'] = 'Settings';
        return view('pages.setting.list', $data);
    }
    
    public function updatePoints(Request $request){

        $validator = Validator::make($request->all(), [
            'point' => 'required|min:0|not_in:0|numeric'
        ]);
        if ($validator->passes()) {
            $currencyPoint = Setting::Where('status', 1)->Where('_key', 'rpoint_per_currency')->get();
            if(count($currencyPoint) > 0){
                $formData['_value'] = $request->point;
                Setting::where('_key', 'rpoint_per_currency')->update($formData);
                $action_type = 'UPDATED';
            }else{
                Setting::insert(['_key' => 'rpoint_per_currency', '_value' => $request->point, 'created_at' => date('Y-m-d H:i:s')]);
                $action_type = 'CREATED';
            }
            $payPoint = Setting::Where('status', 1)->Where('_key', 'rpoint_for_pay')->get();
            if(count($payPoint) > 0){
                $formData['_value'] = $request->enablePay;
                Setting::where('_key', 'rpoint_for_pay')->update($formData);
            }else{
                Setting::insert(['_key' => 'rpoint_for_pay', '_value' => $request->enablePay, 'created_at' => date('Y-m-d H:i:s')]);
            }
            //ADD LOG DATA
            DB::table('reward_point_log')->insert(
                ['point_per_rm' => $request->point, 'enable_payment' => $request->enablePay, 'action_type' => $action_type, 'created_by' => Auth::id(),'created_at' => date('Y-m-d H:i:s')]
            );
            return response()->json(['status'=>'success','message'=>'Reward Point updated successfully.']);
        }
        return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
    }
    public function updateTopupAmount(Request $request){

        $validator = Validator::make($request->all(), [
            'min_amount' => 'required|min:0|not_in:0|numeric',
            'max_amount' => 'required|gt:min_amount|numeric'
        ]);
        if ($validator->passes()) {
            $minTopupAmt = Setting::Where('status', 1)->Where('_key', 'min_topup_amount')->get();
            if(count($minTopupAmt) > 0){
                $formData['_value'] = $request->min_amount;
                Setting::where('_key', 'min_topup_amount')->update($formData);
            }else{
                Setting::insert(['_key' => 'min_topup_amount', '_value' => $request->min_amount, 'created_at' => date('Y-m-d H:i:s')]);
            }
            $maxTopupAmt = Setting::Where('status', 1)->Where('_key', 'max_topup_amount')->get();
            if(count($maxTopupAmt) > 0){
                $formData['_value'] = $request->max_amount;
                Setting::where('_key', 'max_topup_amount')->update($formData);
                $action_type = 'UPDATED';
            }else{
                Setting::insert(['_key' => 'max_topup_amount', '_value' => $request->max_amount, 'created_at' => date('Y-m-d H:i:s')]);
                $action_type = 'CREATED';
            }
            //ADD LOG DATA
            DB::table('topup_amount_log')->insert(
                ['min_amount' => $request->min_amount, 'max_amount' => $request->max_amount, 'action_type' => $action_type, 'created_by' => Auth::id(),'created_at' => date('Y-m-d H:i:s')]
            );
            return response()->json(['status'=>'success','message'=>'Topup amount updated successfully.']);
        }
        return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
    }
    public function updateMaxWalletAmount(Request $request){

        $validator = Validator::make($request->all(), [
            'amount' => 'required|min:0|not_in:0|numeric'
        ]);
        if ($validator->passes()) {
            $maxWalletAmt = Setting::Where('status', 1)->Where('_key', 'max_wallet_amount')->get();
            if(count($maxWalletAmt) > 0){
                $formData['_value'] = $request->amount;
                Setting::where('_key', 'max_wallet_amount')->update($formData);
                $action_type = 'UPDATED';
            }else{
                Setting::insert(['_key' => 'max_wallet_amount', '_value' => $request->amount, 'created_at' => date('Y-m-d H:i:s')]);
                $action_type = 'CREATED';
            }
            //ADD LOG DATA
            DB::table('max_wallet_amount_log')->insert(
                ['amount' => $request->amount, 'action_type' => $action_type, 'created_by' => Auth::id(),'created_at' => date('Y-m-d H:i:s')]
            );
            return response()->json(['status'=>'success','message'=>'Maximum Wallet amount updated successfully.']);
        }
        return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
    }
    public function updateTopupAmountOption(Request $request){

        $validator = Validator::make($request->all(), [
            'amount_option' => 'required'
        ]);
        if ($validator->passes()) {
            $minTopupAmt = Setting::Where('status', 1)->Where('_key', 'topup_amount_options')->get();
            if (substr($request->amount_option, -1, 1) == ',')
            {
                $amountOption = substr($request->amount_option, 0, -1);
            }else{
                $amountOption = $request->amount_option;
            }
            if(count($minTopupAmt) > 0){
                $formData['_value'] = trim($amountOption);
                Setting::where('_key', 'topup_amount_options')->update($formData);
            }else{
                Setting::insert(['_key' => 'topup_amount_options', '_value' => rtrim($amountOption), 'created_at' => date('Y-m-d H:i:s')]);
            }
            return response()->json(['status'=>'success','message'=>'Amount options updated successfully.']);
        }
        return response()->json(['status'=>'error','message'=>$validator->errors()->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
