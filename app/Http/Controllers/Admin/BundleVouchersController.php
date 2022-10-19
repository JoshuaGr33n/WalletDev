<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BundleVouchers;
use App\Models\Voucher;
use App\Models\VoucherType;
use App\Models\Outlet;
use App\Models\Items;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

class BundleVouchersController extends Controller
{

    public function __construct()
    {
        $this->voucherStatus = ['1' => 'Active', '2' => 'Inactive'];
        $this->statusLabel   = ['1' => 'Active', '2' => 'Inactive', '3' => 'Expired'];

        $this->middleware('AdminAccess'); // Allows Access to Admin
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $voucherLists = BundleVouchers::WhereDate('sale_end_date', '<', date('Y-m-d'))->where('status', '1')->get();
        //UPDATE EXPIRED BUNDLE VOUCHER STATUS
        if ($voucherLists) {
            foreach ($voucherLists as $key => $value) {
                BundleVouchers::Where('id', $value->id)->update(array('status' => 3, 'updated_at' => date('Y-m-d H:i:s')));
            }
        }

        if ($request->ajax()) {
            $vouchers = BundleVouchers::query();

            if ($request->bundle_voucher_name) {
                $vouchers->where('bundle_voucher_name', 'like', '%' . $request->bundle_voucher_name . '%');
            }

            $results = $vouchers->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('voucher_name', function ($data) {
                    if (empty($data->bundle_voucher_name)) {
                        return 'N/A';
                    }
                    return $data->bundle_voucher_name;
                })
                ->addColumn('bundle_voucher_code', function ($data) {
                    if (empty($data->bundle_voucher_code)) {
                        return 'N/A';
                    }
                    return $data->bundle_voucher_code;
                })
                ->addColumn('buy_bundle_with', function ($data) {
                    if (empty($data->buy_bundle_with)) {
                        return 'N/A';
                    }
                    $buy_bundle_with = json_decode($data->buy_bundle_with, true);
                    $value = "";
                    foreach($buy_bundle_with as $key => $val){
                        $value = $val['wallet_credit'];
                    }
                    return $value;
                })
                ->addColumn('sale_start_date', function ($data) {
                    if (empty($data->sale_start_date)) {
                        return 'N/A';
                    }
                    return date('Y-m-d', strtotime($data->sale_start_date));
                })
                ->addColumn('sale_end_date', function ($data) {
                    if (empty($data->sale_end_date)) {
                        return 'N/A';
                    }
                    return date('Y-m-d', strtotime($data->sale_end_date));
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->statusLabel[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('bundle-vouchers.edit', ['bundle_voucher' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Voucher"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteVoucher" href="javascript:;" data-voucher="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Delete voucher"><i class="fa fa-trash-o"></i> Delete</a>';
                    return $btn;
                })
                ->addColumn('actions', function ($row) {
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage Bundle Vouchers';

        return view('pages.voucher.bundle_vouchers.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->voucherStatus;
        $data['item_lists'] = Items::get();
        $data['outlet_lists'] = Outlet::Where('status', 1)->get();
        $data['voucherLists'] = Voucher::Where('status', 1)->get();
        $data['vouchertype_list'] = VoucherType::Where('status', 1)->get();
        return view('pages.voucher.bundle_vouchers.add', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [

            'bundle_voucher_name' => 'Required',
            'bundle_voucher_name.unique' => 'Name Already Assigned',
            'outlet_ids' => 'Required',
            'vouchers' => 'Required',
            'max_qty' => 'Required',
            'single_user_qty' => 'Required',
            'sale_start_date' => 'Required',
            'sale_end_date' => 'Required',
            'buy_bundle_voucher_with_wallet_credits_value' => 'Required',
            'bundle_voucher_description' => 'Required'
        ];
        $request->validate([
            'bundle_voucher_name' => 'required|unique:bundle_vouchers',
            'outlet_ids' => 'required',
            'vouchers' => 'required',
            'max_qty' => 'required|numeric',
            'single_user_qty' => 'required|numeric',
            'sale_start_date' => 'required',
            'sale_end_date' => 'required',
            'buy_bundle_voucher_with_wallet_credits_value' => 'required|numeric',
            'bundle_voucher_description' => 'required'
        ], $messages);
        if ($request->hasFile('bundle_voucher_image')) {
            $imageName = time() . '_bundle_vouchers.' . $request->file('bundle_voucher_image')->getClientOriginalExtension();
            $request->file('bundle_voucher_image')->move(
                base_path() . '/public/uploads/bundle_vouchers/',
                $imageName
            );
        } else {
            $imageName = '';
        }

        $vouchers   = implode(',', $request->vouchers);
        $outlet_ids   = implode(',', $request->outlet_ids);
        if (empty($request->free_items_value)) {
            $free_items_value = NULL;
        } else {
            $free_items_value   = implode(',', $request->free_items_value);
        }

        $bundle_voucher_code = 'b-v-bkksub' . $request->discount_type . $this->generateVoucherCode();
        $buy_bundle_with = [["wallet_credit" => $request->buy_bundle_voucher_with_wallet_credits_value]];
        $free_gifts = [["free_points" => $request->free_points_value, "free_items" => $free_items_value]];
        BundleVouchers::insert([
            'outlet_ids'   => $outlet_ids,
            'bundle_voucher_code' => $bundle_voucher_code,
            'vouchers' => $vouchers,
            'bundle_voucher_name' => $request->bundle_voucher_name,
            'description' => $request->bundle_voucher_description,
            'sale_start_date' => $request->sale_start_date,
            'sale_end_date' => $request->sale_end_date,
            'buy_bundle_with' => json_encode($buy_bundle_with),
            'tAndC' => $request->tAndC,
            'max_qty' => $request->max_qty,
            'single_user_qty' => $request->single_user_qty,
            'bundle_voucher_image' => $imageName,
            'free_gifts' => json_encode($free_gifts),
            'status' => $request->status,
            'created_by' => $request->user()->id
        ]);



        return redirect()->route('bundle-vouchers.index')->with('success', 'Bundle Voucher Created successfully!');
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
        $data['voucherInfo'] = BundleVouchers::findOrFail($id); //
        $data['status'] = $this->voucherStatus;
        $data['outlet_lists'] = Outlet::Where('status', 1)->get();
        $data['voucherLists'] = Voucher::get();
        $data['item_lists'] = Items::get();
        $buy_bundle_with = json_decode($data['voucherInfo']['buy_bundle_with'], true);
        $free_gifts = json_decode($data['voucherInfo']['free_gifts'], true);
        foreach ($buy_bundle_with as $key => $value) {

            $data['wallet_credit_value'] = $value['wallet_credit'];;
        }
        foreach ($free_gifts as $key => $value) {

            $data['free_points'] = $value['free_points'];
            $data['free_items'] = $value['free_items'];
        }
        return view('pages.voucher.bundle_vouchers.edit', $data);
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
        $bundle_voucher = BundleVouchers::find($id);
        $request->validate([
            'bundle_voucher_name' => 'required|unique:bundle_vouchers,bundle_voucher_name,' . $bundle_voucher->id . ',id',
            'outlet_ids' => 'required',
            'vouchers' => 'required',
            'max_qty' => 'required|numeric',
            'single_user_qty' => 'required|numeric',
            'sale_start_date' => 'required',
            'sale_end_date' => 'required',
            'buy_bundle_voucher_with_wallet_credits_value' => 'required|numeric',
            'bundle_voucher_description' => 'required'
        ]);

        $start_date = Carbon::createFromFormat('Y-m-d', $request->sale_start_date);
        $end_date = Carbon::createFromFormat('Y-m-d', $request->sale_end_date);
        if($start_date > $end_date){
            return redirect()->route('bundle-vouchers.edit', ['bundle_voucher' => $id])->with('date_error', 'Date Error! Sale End Date Must Be Greater or Equal to Sale Start date');
        }

        $vouchers   = implode(',', $request->vouchers);
        $outlet_ids   = implode(',', $request->outlet_ids);
        if (empty($request->free_items_value)) {
            $free_items_value = NULL;
        } else {
            $free_items_value   = implode(',', $request->free_items_value);
        }
        $buy_bundle_with = [["wallet_credit" => $request->buy_bundle_voucher_with_wallet_credits_value]];
        $free_gifts = [["free_points" => $request->free_points_value, "free_items" => $free_items_value]];
        $bundle_voucher->outlet_ids = $outlet_ids;
        $bundle_voucher->bundle_voucher_name = $request->bundle_voucher_name;
        $bundle_voucher->vouchers = $vouchers;
        $bundle_voucher->description = $request->bundle_voucher_description;
        $bundle_voucher->sale_start_date = $request->sale_start_date;
        $bundle_voucher->sale_end_date = $request->sale_end_date;
        $bundle_voucher->buy_bundle_with = json_encode($buy_bundle_with);
        $bundle_voucher->tAndC = $request->tAndC;
        $bundle_voucher->max_qty = $request->max_qty;
        $bundle_voucher->single_user_qty = $request->single_user_qty;
        $bundle_voucher->free_gifts = json_encode($free_gifts);
        if ($request->hasFile('bundle_voucher_image')) {
            $imageName = time() . '_bundle_voucher.' . $request->file('bundle_voucher_image')->getClientOriginalExtension();
            $request->file('bundle_voucher_image')->move(
                base_path() . '/public/uploads/bundle_vouchers/',
                $imageName
            );
            $bundle_voucher->bundle_voucher_image = $imageName;
            if ($request->current_bundle_voucher_image) {
                unlink(base_path() . '/public/uploads/bundle_vouchers/' . $request->current_bundle_voucher_image);
            }
        }
        if ($request->sale_end_date < date('Y-m-d') && $request->status == 1) {
            $bundle_voucher->update(array('status' => 3, 'updated_at' => date('Y-m-d H:i:s')));
        }elseif ($request->sale_end_date >= date('Y-m-d') && $request->status == 3) {
            $bundle_voucher->update(array('status' => 1, 'updated_at' => date('Y-m-d H:i:s')));
        }else{
            $bundle_voucher->status = $request->status;
        }
        $bundle_voucher->updated_by = $request->user()->id;
        $bundle_voucher->save();
        return redirect()->route('bundle-vouchers.edit', ['bundle_voucher' => $id])->with('success', 'Bundle Voucher updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = BundleVouchers::find($request->id);
        $category->delete();
    }
    function generateVoucherCode()
    {
        mt_srand((float)microtime() * 10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*", $charid);
        $c = implode("", $c);

        return substr($c, 0, 12);
    }
}
