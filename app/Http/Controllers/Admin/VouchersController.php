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

class VouchersController extends Controller
{

    public function __construct()
    {
        $this->voucherStatus = ['1' => 'Active', '2' => 'Inactive'];
        $this->statusLabel   = ['1' => 'Active', '2' => 'Inactive', '3' => 'Expired'];
        $this->discountType  = ['1' => 'Percentage', '2' => 'Fixed Amount'];
        $this->buyVoucherWith  = ['' => 'Select', '1' => 'Points', '2' => 'Wallet Credit', '3' => 'Both Points & Credit'];
        $this->middleware('AdminAccess'); // Allows Access to Admin
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $voucherLists = Voucher::WhereDate('sale_end_date', '<', date('Y-m-d'))->where('status', '1')->get();
        //UPDATE EXPIRED VOUCHER STATUS
        if ($voucherLists) {
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
                    if ($data->free_voucher_type == "birthday") {
                        $tag = '(B)';
                    } elseif ($data->free_voucher_type == "welcome") {
                        $tag = '(W)';
                    } else {
                        $tag = '';
                    }
                    return $data->voucher_name . $tag;
                })
                ->addColumn('voucher_code', function ($data) {
                    if (empty($data->voucher_code)) {
                        return 'N/A';
                    }
                    return $data->voucher_code;
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

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('vouchers.edit', ['voucher' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Voucher"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteVoucher" href="javascript:;" data-voucher="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Delete voucher"><i class="fa fa-trash-o"></i> Delete</a>';
                    return $btn;
                })
                ->addColumn('actions', function ($row) {
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
        $data['buyVoucherWith'] = $this->buyVoucherWith;
        $data['item_lists'] = Items::get();
        $data['outlet_lists'] = Outlet::Where('status', 1)->get();
        $data['vouchertype_list'] = VoucherType::Where('status', 1)->get();
        return view('pages.voucher.add', $data);
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

            'voucher_name' => 'Required',
            'voucher_name.unique' => 'Name Already Assigned',
            'outlet_ids' => 'Required',
            'voucher_type' => 'Required',
            'max_qty' => 'Required',
            'single_user_qty' => 'Required',
            'sale_start_date' => 'Required',
            'sale_end_date' => 'Required',
            'validity_period' => 'Required',
            'applicable_to_items' => 'Required',
            'discount_type' => 'Required',
            'voucher_value' => 'Required',
            'buy_voucher_with' => 'Required',
            'voucher_description' => 'Required'
        ];
        $request->validate([
            'voucher_name' => 'required|unique:vouchers',
            'outlet_ids' => 'required',
            'voucher_type' => 'required',
            'max_qty' => 'required|numeric',
            'single_user_qty' => 'required|numeric',
            'sale_start_date' => 'required',
            'sale_end_date' => 'required',
            'validity_period' => 'required|numeric',
            'applicable_to_items' => 'required',
            'discount_type' => 'required',
            'voucher_value' => 'required|numeric',
            'buy_voucher_with' => 'required',
            'voucher_description' => 'required'
        ], $messages);
        if ($request->hasFile('voucher_image')) {
            $imageName = time() . '_voucher.' . $request->file('voucher_image')->getClientOriginalExtension();
            $request->file('voucher_image')->move(
                base_path() . '/public/uploads/voucher/',
                $imageName
            );
        } else {
            $imageName = '';
        }
        $group_id = Str::random(6);
        $outlet_ids   = implode(',', $request->outlet_ids);
        $applicable_to_items   = implode(',', $request->applicable_to_items);
        $voucher_code = 'v-bkksub' . $request->discount_type . $this->generateVoucherCode();
        $buy_voucher_with = [["points" => $request->buy_voucher_with_points_value, "wallet_credit" => $request->buy_voucher_with_wallet_credits_value]];
        Voucher::insert([
            'outlet_ids'   => $outlet_ids,
            'voucher_code' => $voucher_code,
            'voucher_type_id' => $request->voucher_type,
            'voucher_name' => $request->voucher_name,
            'voucher_description' => $request->voucher_description,
            'sale_start_date' => $request->sale_start_date,
            'sale_end_date' => $request->sale_end_date,
            'validity_period' => $request->validity_period,
            'applicable_to_items' => $applicable_to_items,
            'discount_type' => $request->discount_type,
            'voucher_value' => $request->voucher_value,
            'max_discount_amount' => $request->max_discount_amount,
            'buy_voucher_with' => json_encode($buy_voucher_with),
            'tAndC' => $request->tAndC,
            'max_qty' => $request->max_qty,
            'single_user_qty' => $request->single_user_qty,
            'voucher_image' => $imageName,
            'status' => $request->status,
            'group_id' => $group_id,
            'created_by' => $request->user()->id
        ]);

        if (isset($request->birthday)) {
            $voucher_code1 = 'v-bkksub' . $request->discount_type . $this->generateVoucherCode();
            Voucher::insert([
                'outlet_ids'   => $outlet_ids,
                'voucher_code' => $voucher_code1,
                'voucher_type_id' => $request->voucher_type,
                'voucher_name' => $request->voucher_name,
                'voucher_description' => $request->voucher_description,
                'sale_start_date' => $request->sale_start_date,
                'sale_end_date' => $request->sale_end_date,
                'validity_period' => $request->validity_period,
                'applicable_to_items' => $applicable_to_items,
                'discount_type' => $request->discount_type,
                'voucher_value' => $request->voucher_value,
                'max_discount_amount' => $request->max_discount_amount,
                'buy_voucher_with' => json_encode($buy_voucher_with),
                'tAndC' => $request->tAndC,
                'max_qty' => $request->max_qty,
                'single_user_qty' => $request->single_user_qty,
                'voucher_image' => $imageName,
                'free_voucher_type' => 'birthday',
                'status' => $request->status,
                'group_id' => $group_id,
                'created_by' => $request->user()->id
            ]);
        }

        if (isset($request->welcome)) {
            $voucher_code2 = 'v-bkksub' . $request->discount_type . $this->generateVoucherCode();
            Voucher::insert([
                'outlet_ids'   => $outlet_ids,
                'voucher_code' => $voucher_code2,
                'voucher_type_id' => $request->voucher_type,
                'voucher_name' => $request->voucher_name,
                'voucher_description' => $request->voucher_description,
                'sale_start_date' => $request->sale_start_date,
                'sale_end_date' => $request->sale_end_date,
                'validity_period' => $request->validity_period,
                'applicable_to_items' => $applicable_to_items,
                'discount_type' => $request->discount_type,
                'voucher_value' => $request->voucher_value,
                'max_discount_amount' => $request->max_discount_amount,
                'buy_voucher_with' => json_encode($buy_voucher_with),
                'tAndC' => $request->tAndC,
                'max_qty' => $request->max_qty,
                'single_user_qty' => $request->single_user_qty,
                'voucher_image' => $imageName,
                'free_voucher_type' => 'welcome',
                'status' => $request->status,
                'group_id' => $group_id,
                'created_by' => $request->user()->id
            ]);
        }

        return redirect()->route('vouchers.index')->with('success', 'Voucher Information added successfully!');
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
        $data['voucherInfo'] = Voucher::findOrFail($id); //
        $data['status'] = $this->voucherStatus;
        $data['discountType'] = $this->discountType;
        $data['buyVoucherWith'] = $this->buyVoucherWith;
        $data['outlet_lists'] = Outlet::Where('status', 1)->get();
        $data['item_lists'] = Items::get();
        $data['vouchertype_list'] = VoucherType::Where('status', 1)->get();
        $buy_voucher_with = json_decode($data['voucherInfo']['buy_voucher_with'], true);
        foreach ($buy_voucher_with as $key => $value) {
            $data['points_value'] = "";
            $data['credits_value'] = '';
            if ($value['points'] !== Null && $value['wallet_credit'] == Null) {
                $data['result'] = 'Points';
                $data['points_value'] = $value['points'];
                $data['result_value'] = 1;
            } elseif ($value['points'] == Null && $value['wallet_credit'] !== Null) {
                $data['result'] = 'Wallet Credits';
                $data['credits_value'] = $value['wallet_credit'];
                $data['result_value'] = 2;
            } elseif ($value['points'] !== Null && $value['wallet_credit'] !== Null) {
                $data['result'] = 'Both Points & Credits';
                $data['points_value'] = $value['points'];
                $data['credits_value'] = $value['wallet_credit'];
                $data['result_value'] = 3;
            }
        }
        return view('pages.voucher.edit', $data);
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
        $voucher = Voucher::find($id);
        $request->validate([
            'voucher_name' => 'required|unique:vouchers,voucher_name,' . $voucher->group_id . ',group_id',
            'outlet_ids' => 'required',
            'voucher_type' => 'required',
            'max_qty' => 'required|numeric',
            'single_user_qty' => 'required|numeric',
            'sale_start_date' => 'required',
            'sale_end_date' => 'required',
            'validity_period' => 'required|numeric',
            'applicable_to_items' => 'required',
            'discount_type' => 'required',
            'voucher_value' => 'required|numeric',
            'buy_voucher_with' => 'required',
            'voucher_description' => 'required'
        ]);

        $start_date = Carbon::createFromFormat('Y-m-d', $request->sale_start_date);
        $end_date = Carbon::createFromFormat('Y-m-d', $request->sale_end_date);
        if ($start_date > $end_date) {
            return redirect()->route('vouchers.edit', ['voucher' => $id])->with('date_error', 'Date Error! Sale End Date Must Be Greater or Equal to Sale Start date');
        }

        $voucher = Voucher::find($id);
        $outlet_ids = implode(',', $request->outlet_ids);
        $applicable_to_items   = implode(',', $request->applicable_to_items);
        $buy_voucher_with = [["points" => $request->buy_voucher_with_points_value, "wallet_credit" => $request->buy_voucher_with_wallet_credits_value]];
        $voucher->outlet_ids = $outlet_ids;
        $voucher->voucher_type_id = $request->voucher_type;
        $voucher->voucher_name = $request->voucher_name;
        $voucher->voucher_description = $request->voucher_description;
        $voucher->sale_start_date = $request->sale_start_date;
        $voucher->sale_end_date = $request->sale_end_date;
        $voucher->validity_period = $request->validity_period;
        $voucher->applicable_to_items = $applicable_to_items;
        $voucher->buy_voucher_with = $buy_voucher_with;
        $voucher->discount_type = $request->discount_type;
        $voucher->voucher_value = $request->voucher_value;
        $voucher->max_discount_amount = $request->max_discount_amount;
        $voucher->total_required_points = $request->total_required_points;
        $voucher->tAndC = $request->tAndC;
        $voucher->max_qty = $request->max_qty;
        $voucher->single_user_qty = $request->single_user_qty;
        if ($request->hasFile('voucher_image')) {
            $imageName = time() . '_voucher.' . $request->file('voucher_image')->getClientOriginalExtension();
            $request->file('voucher_image')->move(
                base_path() . '/public/uploads/voucher/',
                $imageName
            );
            $voucher->voucher_image = $imageName;
            if ($request->current_voucher_image) {
                unlink(base_path() . '/public/uploads/voucher/' . $request->current_voucher_image);
            }
        }
        if ($request->sale_end_date < date('Y-m-d') && $request->status == 1) {
            $voucher->update(array('status' => 3, 'updated_at' => date('Y-m-d H:i:s')));
        } elseif ($request->sale_end_date >= date('Y-m-d') && $request->status == 3) {
            $voucher->update(array('status' => 1, 'updated_at' => date('Y-m-d H:i:s')));
        } else {
            $voucher->status = $request->status;
        }
        $voucher->updated_by = $request->user()->id;
        $voucher->save();
        return redirect()->route('vouchers.edit', ['voucher' => $id])->with('success', 'Voucher Information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $query = BundleVouchers::query();
        $data = $query->orWhere('vouchers', 'LIKE', '%' . $request->id . '%')->get();

        foreach ($data as $key => $value) {
            $list = explode(',', $value['vouchers']);
            $final_list = array_diff($list, array($request->id));
            $cc = implode(',', $final_list);
            $query->update(array('vouchers' => $cc));
        }
        $category = Voucher::find($request->id);
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
