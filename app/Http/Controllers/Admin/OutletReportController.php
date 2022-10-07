<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Outlet;
use App\Models\Merchant;
use App\Models\Couponcode;
use App\Models\User;
use Datatables;

class OutletReportController extends Controller
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
        $outlet_id = $request->outlet_id;
        $outletInfo = Outlet::with('merchant')->Where('id', $request->outlet_id)->first();
        if($outletInfo){
            $merchant_id = $outletInfo->merchant_id;
        }else{
            $merchant_id = '';
        }
        $type = $request->type;

        $data['title'] = 'Manage Notification';
        $data['outlet_id'] = $outlet_id;
        $data['type'] = $type;
        $data['outletLists'] = Outlet::Where('status', 1)->get();
        $data['outletInfo'] = Outlet::with('merchant')->Where('id', $outlet_id)->where('status',1)->first();
        $data['totalTransaction'] = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $outlet_id, 'status' => 1])->get()->count();
        $data['totalTopup'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 1, 'status' => 1])->get()->count();
        $data['totalPaid'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 2, 'status' => 1])->get()->count();
        $data['totalTransactionAmt'] = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $outlet_id, 'status' => 1])->sum('amount');
        $data['totalTopupAmt'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 1, 'status' => 1])->sum('amount');
        $data['totalPaidAmt'] = Couponcode::where(['outlet_id' => $outlet_id, 'type' => 2, 'status' => 1])->sum('amount');
        $totalMrcntTopupAmt = Couponcode::where(['merchant_id' => $merchant_id, 'type' => 1, 'status' => 1])->sum('amount');
        $totalMrcntPaidAmt = Couponcode::where(['merchant_id' => $merchant_id, 'type' => 2, 'status' => 1])->sum('amount');
        $data['mrcntPendingAmt'] = abs($totalMrcntTopupAmt - $totalMrcntPaidAmt);
        return view('pages.report.outletreport', $data);
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

    public function getAllTransaction(Request $request)
    {
        if ($request->ajax()) {
            $results = Couponcode::WhereIn('type', [1,2])->where(['outlet_id' => $request->outlet_id, 'status' => 1])->orderBy('id','desc')->get();
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
            $results = Couponcode::where(['outlet_id' => $request->outlet_id, 'type' => 1, 'status' => 1])->get();
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
            $results = Couponcode::where(['outlet_id' => $request->outlet_id, 'type' => 2, 'status' => 1])->get();
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
}
