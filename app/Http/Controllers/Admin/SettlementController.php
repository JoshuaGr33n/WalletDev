<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Outlet;
use App\Models\Merchant;
use App\Models\Couponcode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Datatables;
use Validator;
use Auth;
use DB;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->AreaStatus = ['1' => 'Active','2' => 'Inactive'];
        $this->middleware('AdminAccess'); // Allows Access to Admin
    }
    public function index(Request $request)
    {
        $daterange = urldecode($request->daterange);
        $outlet_id = $request->outlet_id;
        $outletInfo = Outlet::with('merchant')->Where('id', $request->outlet_id)->first();
        if($outletInfo){
            $merchant_id = $outletInfo->merchant_id;
        }else{
            $merchant_id = '';
        }
        $type  = $request->type;
        $start = '';
        $end   = '';
        if($daterange){
            $daterangeArr = explode(" - ",$daterange);
            $start = date('Y-m-d',strtotime($daterangeArr[0]));
            $end   = date('Y-m-d',strtotime($daterangeArr[1]));
        }

        $data['start'] = $start;
        $data['end']   = $end;
        $data['filter_type'] = $request->filter_type;
        $data['today'] = date('Y-m-d');
        $data['daterange'] = $daterange;

        $data['title'] = 'Manage Admin Settlement';
        $data['outlet_id'] = $outlet_id;
        $data['type'] = $type;
        $data['outletLists'] = Outlet::Where('status', 1)->get();
        $data['outletInfo'] = Outlet::with('merchant')->Where('id', $outlet_id)->where('status',1)->first();
        //DB::enableQueryLog();
        //dd(DB::getQueryLog());
        //$data['totalTransaction'] = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $outlet_id, 'status' => 1])->whereDate('tranasaction_datetime','<=',$start)->whereDate('tranasaction_datetime','>=',$end)->get()->count();
        //$data['totalTransaction'] = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $outlet_id, 'status' => 1])->whereBetween(DATE_FORMAT('tranasaction_datetime'), array($start, $end))->get()->count();
        if($start && $end){
            $data['totalTransaction'] = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $outlet_id, 'status' => 1])
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                ->get()->count();
            
            $data['totalTopup'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 1, 'status' => 1])
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                ->get()->count();
            $data['totalPaid'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 2, 'status' => 1])
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                ->get()->count();
            $data['totalTransactionAmt'] = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $outlet_id, 'status' => 1])
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                ->sum('amount');
            $data['totalTopupAmt'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 1, 'status' => 1])
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                ->sum('amount');
            $data['totalPaidAmt'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 2, 'status' => 1])
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                ->sum('amount');
            $totalMrcntTopupAmt = Couponcode::where(['merchant_id' => $merchant_id, 'type' => 1, 'status' => 1])
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                ->sum('amount');
            $totalMrcntPaidAmt = Couponcode::where(['merchant_id' => $merchant_id, 'type' => 2, 'status' => 1])
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                ->sum('amount');
        }else{
            $data['totalTransaction'] = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $outlet_id, 'status' => 1])
                ->get()->count();
            
            $data['totalTopup'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 1, 'status' => 1])
                ->get()->count();
            $data['totalPaid'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 2, 'status' => 1])
                ->get()->count();
            $data['totalTransactionAmt'] = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $outlet_id, 'status' => 1])
                ->sum('amount');
            $data['totalTopupAmt'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 1, 'status' => 1])
                ->sum('amount');
            $data['totalPaidAmt'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 2, 'status' => 1])
                ->sum('amount');
            $totalMrcntTopupAmt = Couponcode::where(['merchant_id' => $merchant_id, 'type' => 1, 'status' => 1])
                ->sum('amount');
            $totalMrcntPaidAmt = Couponcode::where(['merchant_id' => $merchant_id, 'type' => 2, 'status' => 1])
                    ->sum('amount');
        }
        if($totalMrcntTopupAmt > $totalMrcntPaidAmt){
            $settleToHead = abs($totalMrcntTopupAmt - $totalMrcntPaidAmt);
            $settleToOutlet = 0;
        }else{
            $settleToOutlet = abs($totalMrcntPaidAmt - $totalMrcntTopupAmt);
            $settleToHead = 0;
        }
        $data['settleToHead']   = $settleToHead;
        $data['settleToOutlet'] = $settleToOutlet;
        $data['mrcntPendingAmt'] = 0;
        return view('pages.settlement.adminsettlement', $data);
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

    public function getAllSettlement(Request $request)
    {
        if ($request->ajax()) {
            $start = '';
            $end   = '';
            if($request->daterange){
                $daterangeArr = explode(" - ",$request->daterange);
                $start = date('Y-m-d',strtotime($daterangeArr[0]));
                $end   = date('Y-m-d',strtotime($daterangeArr[1]));
            }
            if($start && $end){
                $results = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $request->outlet_id, 'status' => 1])
                            ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') >= '$start'")
                            ->whereRaw("DATE_FORMAT(tranasaction_datetime,'%Y-%m-%d') <= '$end'")
                            ->orderBy('tranasaction_datetime','desc')->get();
            }else{
                $results = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $request->outlet_id, 'status' => 1])
                            ->orderBy('tranasaction_datetime','desc')->get();
            }
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
    public function geVerifyPasswordForm(Request $request){
        $data = array();
        $data['settlement_type'] = $request->settlement_type;
        $data['amount'] = $request->amount;
        return view('pages.settlement.verifypassword_form', $data);

    }
    function verifyPassword(Request $request){
        
        $messages = ['password.required' => 'Password is Required'];
        $validator = Validator::make($request->all(), ['password' => 'required'], $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'error' => $validator->errors()], 200);
        }
        $user_id = Auth::id();
        $userInfo    = User::Where('id',$user_id)->first();
        if($userInfo){
            if (Hash::check($request->password, $userInfo->password))
            {
                return response()->json(['status' => 'success', 'message' => 'Password verified successfully.', 'error' => ''], 200);
            }else{
                $errData = array('password' => 'Password mismatch');
                return response()->json(['status' => 'failed','error' => $errData], 200);
            }
        }else{
            $errData = array('msg' => 'Invalid user');
            return response()->json(['status' => 'failed','error' => $errData], 200);
        }
    }
}
