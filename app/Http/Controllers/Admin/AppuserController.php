<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Adminuser;
use App\Models\User;
use App\Models\Role;
use App\Models\Couponcode;
use App\Models\Outlet;
use App\Models\Setting;
use App\Models\User_wallet;
use App\Models\User_reward;
use App\Models\User_reward_history;
use Illuminate\Support\Facades\Hash;
use Validator;
use Datatables;
use DB;

class AppuserController extends Controller
{

    public function __construct()
    {
        $this->userStatus = ['1' => 'Active','2' => 'Inactive'];
        $this->defaultPassword = 'wallet@123';
        $this->middleware('AdminAccess'); // Allows Access to Admin
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //$users = User::query();
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'Customer');
            });

            if ($request->first_name) {
                $users->where('first_name', 'like', '%' . $request->first_name . '%');
            }

            $results = $users->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('first_name', function ($data) {
                    if (empty($data->first_name)) {
                        return 'N/A';
                    }
                    return $data->first_name;
                })
                ->addColumn('last_name', function ($data) {
                    if (empty($data->last_name)) {
                        return 'N/A';
                    }
                    return $data->last_name;
                })
                ->addColumn('phone_number', function ($data) {
                    if (empty($data->phone_number)) {
                        return 'N/A';
                    }
                    return $data->phone_number;
                })
                ->addColumn('email', function ($data) {
                    if (empty($data->email)) {
                        return 'N/A';
                    }
                    return $data->email;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->userStatus[$data->status];
                })
                ->addColumn('action', function ($row) {
                    if($row->status==1){
                        $btn = '<a class="btn btn-danger btn-xs" onclick="return changeStatus('.$row->id.',2);" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Inactive">Inactive</a>&nbsp;';
                    }else{
                        $btn = '<a class="btn btn-info btn-xs" onclick="return changeStatus('.$row->id.',1);" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Active">Active</a>&nbsp;';
                    }
                    
                    $btn .= '<a class="btn btn-danger btn-xs deleteuser" href="javascript:;" data-user="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash-o"></i></a>&nbsp;';
                    $btn .= '<a class="btn btn-primary btn-xs" href="' . route('appuser.show', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="View User"><i class="fa fa fa-eye"></i></a>&nbsp;';
                    $btn .= '<a class="btn btn-success btn-xs" onclick="return getTransactionForm('.$row->id.');" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Add Transaction"><i class="fa fa fa-plus"></i></a>&nbsp;';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['title'] = 'Manage User';

        return view('pages.app_user.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$data['userInfo'] = User::findOrFail($id);
        $data['userInfo'] = User::with('userInfo','user_reward','user_wallet')->where('id',$id)->first();
        if(!$data['userInfo']){
            return redirect()->route('appuser.index');
        }
        $data['user_id'] = $id;
        $data['totalTransaction'] = Couponcode::WhereIn('type', [1,2])->where(['user_id' => $id, 'status' => 1])->get()->count();
        $data['totalTopup'] = Couponcode::where(['user_id' => $id, 'type' => 1, 'status' => 1])->get()->count();
        $data['totalPaid'] = Couponcode::where(['user_id' => $id, 'type' => 2, 'status' => 1])->get()->count();
        return view('pages.app_user.show',$data);
    }

    public function getAllTransaction(Request $request)
    {
        if ($request->ajax()) {
            $results = Couponcode::where(['user_id' => $request->user_id, 'status' => 1])->orderBy('id','desc')->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('type', function ($data) {
                    if (empty($data->type)) {
                        return 'N/A';
                    }
                    if($data->type == 1){
                    	return 'Topup';
                    }elseif ($data->type == 2) {
                    	return 'Paid';
                    }else{
                    	return 'N/A';
                    }
                })
                ->addColumn('amount', function ($data) {
                    if (empty($data->amount)) {
                        return 'N/A';
                    }
                    return $data->amount;
                })
                ->addColumn('transaction_id', function ($data) {
                    if (empty($data->transaction_id)) {
                        return 'N/A';
                    }
                    return $data->transaction_id;
                })
                ->addColumn('outlet_id', function ($data) {
                    $outletInfo = Outlet::Where('id',$data->outlet_id)->first();
                    if (empty($outletInfo)) {
                        return 'N/A';
                    }
                    return $outletInfo->outlet_name;
                })
                ->addColumn('action_by', function ($data) {
                    if($data->coupon == 'CMS'){
                        return 'ADMIN';
                    }else{
                        return 'USER';
                    }
                })
                ->addColumn('tranasaction_datetime', function ($data) {
                    if (empty($data->tranasaction_datetime)) {
                        return 'N/A';
                    }
                    return $data->tranasaction_datetime;
                })
                ->make(true);
        }
    }
    public function getAllTopup(Request $request)
    {
        if ($request->ajax()) {
            $results = Couponcode::where(['user_id' => $request->user_id, 'type' => 1, 'status' => 1])->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('amount', function ($data) {
                    if (empty($data->amount)) {
                        return 'N/A';
                    }
                    return $data->amount;
                })
                ->addColumn('transaction_id', function ($data) {
                    if (empty($data->transaction_id)) {
                        return 'N/A';
                    }
                    return $data->transaction_id;
                })
                ->addColumn('outlet_id', function ($data) {
                    $outletInfo = Outlet::Where('id',$data->outlet_id)->first();
                    if (empty($outletInfo)) {
                        return 'N/A';
                    }
                    return $outletInfo->outlet_name;
                })
                ->addColumn('action_by', function ($data) {
                    if($data->coupon == 'CMS'){
                        return 'ADMIN';
                    }else{
                        return 'USER';
                    }
                })
                ->addColumn('tranasaction_datetime', function ($data) {
                    if (empty($data->tranasaction_datetime)) {
                        return 'N/A';
                    }
                    return $data->tranasaction_datetime;
                })
                ->make(true);
        }
    }
    public function getAllPaid(Request $request)
    {
        if ($request->ajax()) {
            $results = Couponcode::where(['user_id' => $request->user_id, 'type' => 2, 'status' => 1])->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('amount', function ($data) {
                    if (empty($data->amount)) {
                        return 'N/A';
                    }
                    return $data->amount;
                })
                ->addColumn('transaction_id', function ($data) {
                    if (empty($data->transaction_id)) {
                        return 'N/A';
                    }
                    return $data->transaction_id;
                })
                ->addColumn('outlet_id', function ($data) {
                    $outletInfo = Outlet::Where('id',$data->outlet_id)->first();
                    if (empty($outletInfo)) {
                        return 'N/A';
                    }
                    return $outletInfo->outlet_name;
                })
                ->addColumn('action_by', function ($data) {
                    if($data->coupon == 'CMS'){
                        return 'ADMIN';
                    }else{
                        return 'USER';
                    }
                })
                ->addColumn('tranasaction_datetime', function ($data) {
                    if (empty($data->tranasaction_datetime)) {
                        return 'N/A';
                    }
                    return $data->tranasaction_datetime;
                })
                ->make(true);
        }
    }
    public function getTransactionForm(Request $request){
        $data = array();
        $data['outletLists'] = Outlet::Where('status', 1)->get();
        $data['userInfo']    = User::Where('id',$request->user_id)->first();
        if(!$data['userInfo']){
            return redirect()->route('appuser.index');
        }
        $data['user_id'] = $request->user_id;
        return view('pages.app_user.transaction_form', $data);
    }
    public function addTransaction(Request $request){

        $messages = ['amount.required' => 'Amount is Required',
            'amount.numeric' => 'Mobile No must be numeric',
            'outlet_id.required' => 'Outlet is Required',
            'type.required' => 'Type is Required',
            'user_id.required' => 'User Id is Required',
        ];

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:100000',
            'outlet_id' => 'required',
            'type'    => 'required|numeric',
            'user_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'error' => $validator->errors()], 200);
        }

        $user_id = $request->user_id;
        $transaction_id = 'AD-bkksub'.$this->generateTransactionId();
        $outletInfo = Outlet::with('merchant')->Where('id', $request->outlet_id)->first();
        if($outletInfo){
            $merchant_id = $outletInfo->merchant_id;
        }else{
            $merchant_id = '';
        }
        //TOPUP
        if($request->type == 1){
            $walletInfo = User_wallet::Where('user_id', $user_id)->get()->first();
            if($walletInfo){
                $amount = $walletInfo->amount + $request->amount;
                User_wallet::Where('user_id', $user_id)
                                ->update(array('amount' => $amount, 'updated_at' => date('Y-m-d H:i:s')));
            }else{
                $insertData =   array(
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
                $insertData2 =  array(
                                    'user_id' => $user_id, 
                                    'reward_point' => round($reward_point), 
                                    'status'  => 1,
                                    'created_at' => date('Y-m-d H:i:s')
                                );
                User_reward::insert($insertData2);
            }
            //ADD COUPONCODE
            $couponcodeId = Couponcode::insertGetId([
                            'user_id' => $user_id, 
                            'type' => $request->type, 
                            'amount' => $request->amount,
                            'outlet_id' => $request->outlet_id,
                            'merchant_id' => $merchant_id,
                            'firebase_uuid' => 'CMS',
                            'coupon' => 'CMS',
                            'currency' => 'RM',
                            'status' => 1,
                            'tranasaction_datetime' => date('Y-m-d H:i:s'),
                            'transaction_id' => $transaction_id,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
            //ADD REWARD POINTS HISTORY
            $insertData3 =  array(
                                'user_id' => $user_id,
                                'couponcode_id' => $couponcodeId,
                                'type' => $request->type,
                                'rpoint_per_currency' => $rpoint,
                                'reward_point' => round($reward_point),
                                'amount' => $request->amount,
                                'status' => 1,
                                'outlet_id' => $request->outlet_id,
                                'merchant_id' => $merchant_id,
                                'created_by' => $request->user()->id,
                                'created_at' => date('Y-m-d H:i:s')
                            );
            User_reward_history::insert($insertData3);

            return response()->json(['status' => 'success', 'message' => 'Topup added successfully.', 'error' => ''], 200);
        }
        if($request->type == 2){
            $walletInfo = User_wallet::Where('user_id', $user_id)->get()->first();
            if($walletInfo){
                if($request->amount > $walletInfo->amount){
                    $errData = array('amount' => 'You have insufficient balance please top up.');
                    return response()->json(['status' => 'failed','error' => $errData], 200);
                }else{
                    //PAY
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
                            $insertData2 =  array(
                                                'user_id' => $user_id, 
                                                'reward_point' => $reward_point, 
                                                'status'  => 1,
                                                'created_at' => date('Y-m-d H:i:s')
                                            );
                            User_reward::insert($insertData2);
                        }
                        //ADD COUPONCODE
                        $couponcodeId = Couponcode::insertGetId([
                                        'user_id' => $user_id, 
                                        'type' => $request->type, 
                                        'amount' => $request->amount,
                                        'outlet_id' => $request->outlet_id,
                                        'merchant_id' => $merchant_id,
                                        'firebase_uuid' => 'CMS',
                                        'coupon' => 'CMS',
                                        'currency' => 'RM',
                                        'status' => 1,
                                        'tranasaction_datetime' => date('Y-m-d H:i:s'),
                                        'transaction_id' => $transaction_id,
                                        'created_at' => date('Y-m-d H:i:s')
                                      ]);
                        //ADD REWARD POINTS HISTORY
                        $insertData3 = array(
                                            'user_id' => $user_id, 
                                            'couponcode_id' => $couponcodeId,
                                            'type' => $request->type,
                                            'rpoint_per_currency' => $rpoint,
                                            'reward_point' => $reward_point,
                                            'amount' => $request->amount,
                                            'status' => 1,
                                            'outlet_id' => $request->outlet_id,
                                            'merchant_id' => $merchant_id,
                                            'created_by' => $request->user()->id,
                                            'created_at' => date('Y-m-d H:i:s')
                                        );
                        User_reward_history::insert($insertData3);
                    }
                    //END ADD REWARD POINTS
                    return response()->json(['status' => 'success', 'message' => 'Pay successfully.', 'error' => ''], 200);
                }
            }else{
                $errData = array('amount' => 'You have insufficient balance please top up.');
                return response()->json(['status' => 'failed','error' => $errData], 200);
            }
        }
        //return redirect()->route('appuser.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }
    public function changeStatus(Request $request){
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
        echo 1;
    }
    public function generateTransactionId(){
        mt_srand((double)microtime()*10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*",$charid);
        $c = implode("",$c);

        return substr($c,0,16);
    }
}
