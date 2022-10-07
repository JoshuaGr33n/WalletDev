<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Outlet;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Datatables;
use DB;

class VoucherController extends Controller
{

    public function __construct()
    {
        $this->voucherStatus = ['1' => 'Active','2' => 'Inactive'];
        $this->statusLabel   = ['1' => 'Active','2' => 'Inactive','3' => 'Expired'];
        $this->discountType  = ['1' => 'Percentage','2' => 'Fixed Amount'];
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
        $voucherLists = Voucher::WhereDate('sale_end_date', '<', date('Y-m-d'))->where('status','1')->get();
        //UPDATE EXPIRED VOUCHER STATUS
        if($voucherLists){
            foreach ($voucherLists as $key => $value) {
                Voucher::Where('id', $value->id)->update(array('status' => 3, 'updated_at' => date('Y-m-d H:i:s')));
            }
        }
        if ($request->ajax()) {
            $vouchers = Voucher::query();

            if ($request->voucher_name) {
                $vouchers->where('voucher_name', 'like', '%' . $request->voucher_name . '%');
            }

            $results = $vouchers->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('voucher_name', function ($data) {
                    if (empty($data->voucher_name)) {
                        return 'N/A';
                    }
                    return $data->voucher_name;
                })
                ->addColumn('discount_type', function ($data) {
                    if (empty($data->discount_type)) {
                        return 'N/A';
                    }
                    return $this->discountType[$data->discount_type];
                })
                ->addColumn('voucher_value', function ($data) {
                    if (empty($data->voucher_value)) {
                        return 'N/A';
                    }
                    return $data->voucher_value;
                })
                ->addColumn('sale_start_date', function ($data) {
                    if (empty($data->sale_start_date)) {
                        return 'N/A';
                    }
                    return date('Y-m-d',strtotime($data->sale_start_date));
                })
                ->addColumn('sale_end_date', function ($data) {
                    if (empty($data->sale_end_date)) {
                        return 'N/A';
                    }
                    return date('Y-m-d',strtotime($data->sale_end_date));
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->statusLabel[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('voucher.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Voucher"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteVoucher" href="javascript:;" data-voucher="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete voucher"><i class="fa fa-trash-o"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage voucher';

        return view('pages.voucher.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->voucherStatus;
        $data['discountType'] = $this->discountType;
        $data['outlet_lists'] = Outlet::Where('status',1)->get();
        return view('pages.voucher.add',$data);
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
                        'voucher_name' => 'required',
                        'outlet_ids' => 'required',
                        'sale_start_date' => 'required',
                        'sale_end_date' => 'required',
                        'discount_type' => 'required',
                        'voucher_value' => 'required'
                    ]);
        if ($request->hasFile('voucher_image')) {
            $imageName = time().'_voucher.' . $request->file('voucher_image')->getClientOriginalExtension();
            $request->file('voucher_image')->move(
                base_path() . '/public/uploads/voucher/', $imageName
                );
        }else{
            $imageName = '';
        }
        $outlet_ids   = implode(',', $request->outlet_ids);
        $voucher_code = 'v-bkksub'.$request->discount_type.$this->generateVoucherCode();
        Voucher::insert([
                    'outlet_ids'   => $outlet_ids,
                    'voucher_code' => $voucher_code,
                    'voucher_name' => $request->voucher_name,
                    'voucher_description' => $request->voucher_description,
                    'sale_start_date' => $request->sale_start_date,
                    'sale_end_date' => $request->sale_end_date,
                    'discount_type' => $request->discount_type,
                    'voucher_value' => $request->voucher_value,
                    'total_required_points' => $request->total_required_points,
                    'tAndC' => $request->tAndC,
                    'max_qty' => $request->max_qty,
                    'single_user_qty' => $request->single_user_qty,
                    'voucher_image' => $imageName,
                    'status' => $request->status,
                    'created_by' => $request->user()->id
                ]);

        return redirect()->route('voucher.index');
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
        $data['voucherInfo'] = Voucher::findOrFail($id);//
        $data['status'] = $this->voucherStatus;
        $data['discountType'] = $this->discountType;
        $data['outlet_lists'] = Outlet::Where('status',1)->get();
        return view('pages.voucher.edit',$data);
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
                        'voucher_name' => 'required',
                        'outlet_ids' => 'required',
                        'sale_start_date' => 'required',
                        'sale_end_date' => 'required',
                        'discount_type' => 'required',
                        'voucher_value' => 'required'
                    ]);
        $voucher = Voucher::find($id);
        $outlet_ids = implode(',', $request->outlet_ids);
        $voucher->outlet_ids = $outlet_ids;
        $voucher->voucher_name = $request->voucher_name;
        $voucher->voucher_description = $request->voucher_description;
        $voucher->sale_start_date = $request->sale_start_date;
        $voucher->sale_end_date = $request->sale_end_date;
        $voucher->discount_type = $request->discount_type;
        $voucher->voucher_value = $request->voucher_value;
        $voucher->total_required_points = $request->total_required_points;
        $voucher->tAndC = $request->tAndC;
        $voucher->max_qty = $request->max_qty;
        $voucher->single_user_qty = $request->single_user_qty;
        if ($request->hasFile('voucher_image')) {
            $imageName = time().'_voucher.' . $request->file('voucher_image')->getClientOriginalExtension();
            $request->file('voucher_image')->move(
                base_path() . '/public/uploads/voucher/', $imageName
            );
            $voucher->voucher_image = $imageName;
            if($request->current_voucher_image){
                unlink(base_path() . '/public/uploads/voucher/'.$request->current_voucher_image);
            }
        }
        $voucher->status = $request->status;
        $voucher->updated_by = $request->user()->id;
        $voucher->save();
        return redirect()->route('voucher.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = Voucher::find($request->id);
        $category->delete();
        return redirect()->route('voucher.index');
    }
    function generateVoucherCode(){
        mt_srand((double)microtime()*10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*",$charid);
        $c = implode("",$c);

        return substr($c,0,12);
    }
}
