<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Outlet;
use Datatables;

class MerchantController extends Controller
{

    public function __construct()
    {
        $this->merchantStatus = ['1' => 'Active','2' => 'Inactive'];
        $this->merchantCategory = ['1' => 'Restaurants','2' => 'Beauty and Spas','3' => 'Health and Fitness','4' => 'Automobile'];
        $this->defaultPassword = 'mywallet@123';
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
            $merchants = Merchant::query();

            if ($request->company_name) {
                $merchants->where('company_name', 'like', '%' . $request->company_name . '%');
            }

            $results = $merchants->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('company_name', function ($data) {
                    if (empty($data->company_name)) {
                        return 'N/A';
                    }
                    return $data->company_name;
                })
                ->addColumn('reg_no', function ($data) {
                    if (empty($data->reg_no)) {
                        return 'N/A';
                    }
                    return $data->reg_no;
                })
                ->addColumn('merchant_category', function ($data) {
                    if (empty($data->merchant_category)) {
                        return 'N/A';
                    }
                    if($data->merchant_category){
                        return $this->merchantCategory[$data->merchant_category];
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('merchant_email', function ($data) {
                    if (empty($data->merchant_email)) {
                        return 'N/A';
                    }
                    return $data->merchant_email;
                })
                ->addColumn('contact_phone', function ($data) {
                    if (empty($data->contact_phone)) {
                        return 'N/A';
                    }
                    return $data->contact_phone;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->merchantStatus[$data->status];
                })
                ->addColumn('action', function ($row) {
                	$btn = '<a class="btn btn-info btn-xs" href="' . route('outlet.index', ['merchant_id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Outlet List"><i class="fa fa-list"></i> Outlet</a>&nbsp;';
                    $btn .= '<a class="btn btn-info btn-xs" href="' . route('merchant.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Merchant"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteMerchant" href="javascript:;" data-merchant="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Merchant"><i class="fa fa-trash-o"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage merchant';

        return view('pages.merchant.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->merchantStatus;
        $data['category'] = $this->merchantCategory;
        $data['defaultPassword'] = $this->defaultPassword;
        return view('pages.merchant.add',$data);
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
                        'reg_no' => 'required|unique:merchant_details,reg_no',
                        'company_name' => 'required',
                        'merchant_category' => 'required',
                        'contact_name' => 'required',
                        'contact_phone' => 'required',
                        'outlet_address' => 'required',
                        'outlet_name' => 'required',
                        'outlet_latitude' => 'required',
                        'outlet_phone' => 'required',
                        'outlet_longitude' => 'required',
                        'outlet_hours' => 'required'
                    ]);
        if ($request->hasFile('merchant_logo')) {
            $imageName = time().'_merchant.' . $request->file('merchant_logo')->getClientOriginalExtension();
            $request->file('merchant_logo')->move(
                base_path() . '/public/uploads/merchants/', $imageName
                );
        }else{
            $imageName = '';
        }
        $merchantId = Merchant::insertGetId([
        				'merchant_category' => $request->merchant_category,
        				'reg_no' => $request->reg_no,
        				'description' => $request->description,
        				'company_name' => $request->company_name,
        				'merchant_logo' => $imageName,
        				'created_by' => $request->user()->id,
        				'contact_name' => $request->contact_name,
        				'merchant_email' => $request->merchant_email,
        				'contact_phone' => $request->contact_phone,
        				'address' => $request->address,
        				'post_code' => $request->post_code,
        				'status' => $request->status
        			]);
        $secretKey  = str_random(16);
        Outlet::insert([
						'merchant_id' => $merchantId,
                        'outlet_secret_key' => $secretKey,
						'outlet_address' => $request->outlet_address, 
                        'outlet_name' => $request->outlet_name,
						'outlet_latitude' => $request->outlet_latitude,
						'outlet_longitude' => $request->outlet_longitude,
						'outlet_phone' => $request->outlet_phone,
						'outlet_hours' => $request->outlet_hours,
						'outlet_email' => $request->outlet_email,
						'created_at' => date("Y-m-d H:i:s"), 
						'status' => 1,
						'primary_outlet'=> 1
					]);
        return redirect()->route('merchant.index');
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
        $data['merchantInfo'] = Merchant::findOrFail($id);//
        $data['outletInfo'] = Outlet::Where('primary_outlet', 1)->Where('merchant_id', $id)->first();
        $data['status'] = $this->merchantStatus;
        $data['category'] = $this->merchantCategory;
        $data['defaultPassword'] = $this->defaultPassword;
        return view('pages.merchant.edit',$data);
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
                        'reg_no' => 'required|unique:merchant_details,reg_no,' . $id . '',
                        'company_name' => 'required',
                        'merchant_category' => 'required',
                        'contact_name' => 'required',
                        'contact_phone' => 'required',
                        'outlet_address' => 'required',
                        'outlet_name' => 'required',
                        'outlet_latitude' => 'required',
                        'outlet_phone' => 'required',
                        'outlet_longitude' => 'required',
                        'outlet_hours' => 'required'
                    ]);
        $merchant = Merchant::find($id);
        $merchant->merchant_category = $request->merchant_category;
        $merchant->reg_no = $request->reg_no;
        $merchant->description = $request->description;
        $merchant->company_name = $request->company_name;
        $merchant->contact_name = $request->contact_name;
        $merchant->merchant_email = $request->merchant_email;
        $merchant->contact_phone = $request->contact_phone;
        $merchant->address = $request->address;
        $merchant->post_code = $request->post_code;
        if ($request->hasFile('merchant_logo')) {
            $imageName = time().'_merchant.' . $request->file('merchant_logo')->getClientOriginalExtension();
            $request->file('merchant_logo')->move(
                base_path() . '/public/uploads/merchants/', $imageName
            );
            $merchant->merchant_logo = $imageName;
            if($request->current_merchant_logo){
                unlink(base_path() . '/public/uploads/merchants/'.$request->current_merchant_logo);
            }
        }
        $merchant->status = $request->status;
        $merchant->save();
        //UPDATE OUTLET
        $outlet = Outlet::find($request->outlet_id);
        $outlet->outlet_address = $request->outlet_address;
        $outlet->outlet_name = $request->outlet_name;
        $outlet->outlet_latitude = $request->outlet_latitude;
        $outlet->outlet_longitude = $request->outlet_longitude;
        $outlet->outlet_phone = $request->outlet_phone;
        $outlet->outlet_hours = $request->outlet_hours;
        $outlet->outlet_email = $request->outlet_email;
        $outlet->save();
        return redirect()->route('merchant.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $merchant = Merchant::find($request->id);
        $merchant->delete();
        //DELETE OUTLET
        $outlet = Outlet::where('merchant_id', $request->id);
        $outlet->delete();
        return redirect()->route('merchant.index');
    }
}
