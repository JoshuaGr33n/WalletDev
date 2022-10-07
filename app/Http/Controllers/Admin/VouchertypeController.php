<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VoucherType;
use Datatables;
use Session;

class VouchertypeController extends Controller
{

    public function __construct()
    {
        $this->VoucherStatus = ['1' => 'Active','2' => 'Inactive'];
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
            $areas = VoucherType::query();

            $results = $areas->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('type_name', function ($data) {
                    if (empty($data->type_name)) {
                        return 'N/A';
                    }
                    return $data->type_name;
                })
                ->addColumn('type_id', function ($data) {
                    if (empty($data->type_id)) {
                        return 'N/A';
                    }
                    return $data->type_id;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }

                    return $this->VoucherStatus[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('vouchertype.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Voucher Type"><i class="fa fa-edit"></i></a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteVouchertype" href="javascript:;" data-vouchertype="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Voucher Type"><i class="fa fa-trash-o"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage Area';

        return view('pages.voucher_type.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = $this->VoucherStatus;
        return view('pages.voucher_type.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                        'type_name' => 'required',
                        'type_id' => 'required|unique:voucher_type,type_id']);
        VoucherType::insert(['type_name' => $request->type_name, 'type_id' => $request->type_id, 'status' => $request->status]);

        return redirect()->route('vouchertype.index')->with('success','Voucher Type added successfully!');
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
        $data['voucherTypeInfo'] = VoucherType::findOrFail($id);   //
        $data['status'] = $this->VoucherStatus;
        return view('pages.voucher_type.edit',$data);
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
        $request->validate([
                        'type_name' => 'required',
                        'type_id' => 'required|unique:voucher_type,type_id,' . $id . ''
                        ]);
        $area = VoucherType::find($id);
        $area->type_name = $request->type_name;
        $area->type_id = $request->type_id;
        $area->status = $request->status;
        $area->save();
        return redirect()->route('vouchertype.index')->with('success','Voucher Type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $area = VoucherType::find($request->id);
        $area->delete();
        Session::flash('success', 'Voucher Type deleted successfully!');
        return response()->json(['status' => 'success']);
    }
}
