<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Datatables;
use DB;

class OutletController extends Controller
{

    public function __construct()
    {
        $this->outletStatus = ['1' => 'Active','2' => 'Inactive'];
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
            $results = Outlet::Where('merchant_id', $request->merchant_id)->get();
            
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('outlet_name', function ($data) {
                    if (empty($data->outlet_name)) {
                        return 'N/A';
                    }
                    return $data->outlet_name;
                })
                ->addColumn('outlet_address', function ($data) {
                    if (empty($data->outlet_address)) {
                        return 'N/A';
                    }
                    return $data->outlet_address;
                })
                ->addColumn('outlet_phone', function ($data) {
                    if (empty($data->outlet_phone)) {
                        return 'N/A';
                    }
                    return $data->outlet_phone;
                })
                ->addColumn('outlet_hours', function ($data) {
                    if (empty($data->outlet_hours)) {
                        return 'N/A';
                    }
                    return $data->outlet_hours;
                })
                ->addColumn('outlet_email', function ($data) {
                    if (empty($data->outlet_email)) {
                        return 'N/A';
                    }
                    return $data->outlet_email;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->outletStatus[$data->status];
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-xs" href="' . route('outlet.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Outlet"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteOutlet" href="javascript:;" data-outlet="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Outlet"><i class="fa fa-trash-o"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['title'] = 'Manage Outlet';
        $data['merchant_id'] = $request->input('merchant_id');
        return view('pages.outlet.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->outletStatus;
        $data['merchant_id'] = $request->input('merchant_id');
        return view('pages.outlet.add',$data);
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
                        'outlet_address' => 'required',
                        'outlet_name' => 'required',
                        'outlet_latitude' => 'required',
                        'outlet_phone' => 'required',
                        'outlet_longitude' => 'required',
                        'outlet_hours' => 'required'
                    ]);
        if ($request->hasFile('outlet_logo')) {
            $imageName = time().'_outlet.' . $request->file('outlet_logo')->getClientOriginalExtension();
            $request->file('outlet_logo')->move(
                base_path() . '/public/uploads/outlets/', $imageName
                );
        }else{
            $imageName = '';
        }
        $secretKey  = str_random(16);
        Outlet::insert([
                        'merchant_id' => $request->merchant_id,
                        'outlet_secret_key' => $secretKey,
                        'outlet_logo' => $imageName,
                        'outlet_address' => $request->outlet_address,
                        'outlet_name' => $request->outlet_name,
                        'outlet_latitude' => $request->outlet_latitude,
                        'outlet_longitude' => $request->outlet_longitude,
                        'outlet_phone' => $request->outlet_phone,
                        'outlet_hours' => $request->outlet_hours,
                        'outlet_email' => $request->outlet_email,
                        'created_at' => date("Y-m-d H:i:s"), 
                        'status' => $request->status,
                    ]);
        return redirect()->route('outlet.index',['merchant_id' => $request->merchant_id]);
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
        $data['outletInfo'] = Outlet::findOrFail($id);//
        $data['status'] = $this->outletStatus;
        return view('pages.outlet.edit',$data);
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
                        'outlet_address' => 'required',
                        'outlet_name' => 'required',
                        'outlet_latitude' => 'required',
                        'outlet_phone' => 'required',
                        'outlet_longitude' => 'required',
                        'outlet_hours' => 'required'
                    ]);
        //UPDATE OUTLET
        $outlet = Outlet::find($request->outlet_id);
        $outlet->outlet_address = $request->outlet_address;
        $outlet->outlet_name = $request->outlet_name;
        $outlet->outlet_latitude = $request->outlet_latitude;
        $outlet->outlet_longitude = $request->outlet_longitude;
        $outlet->outlet_phone = $request->outlet_phone;
        $outlet->outlet_hours = $request->outlet_hours;
        $outlet->outlet_email = $request->outlet_email;
        if ($request->hasFile('outlet_logo')) {
            $imageName = time().'_outlet.' . $request->file('outlet_logo')->getClientOriginalExtension();
            $request->file('outlet_logo')->move(
                base_path() . '/public/uploads/outlets/', $imageName
            );
            $outlet->outlet_logo = $imageName;
            if($request->current_outlet_logo){
                unlink(base_path() . '/public/uploads/outlets/'.$request->current_outlet_logo);
            }
        }
        $outlet->status = $request->status;
        $outlet->save();
        return redirect()->route('outlet.index',['merchant_id' => $request->merchant_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $outlet = Outlet::find($request->id);
        $outlet->delete();
        return redirect()->route('outlet.index',['merchant_id' => $request->merchant_id]);
    }
}
