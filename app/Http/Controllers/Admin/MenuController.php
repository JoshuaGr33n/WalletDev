<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Subcategory;
use Datatables;
use DB;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->menuStatus = ['1' => 'Active','2' => 'Inactive'];
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
            $menus = Menu::query();

            if ($request->item_name) {
                $menus->where('item_name', 'like', '%' . $request->item_name . '%');
            }

            $results = $menus->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('category_name', function ($data) {
                    if (empty($data->category_id)) {
                        return 'N/A';
                    }
                    $categoryInfo = Category::find($data->category_id);
                    if($categoryInfo){
                        return $categoryInfo->category_name;
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('sub_category_name', function ($data) {
                    if (empty($data->category_id)) {
                        return 'N/A';
                    }
                    $subCategoryInfo = Subcategory::find($data->sub_category_id);
                    if($subCategoryInfo){
                        return $subCategoryInfo->sub_category_name;
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('item_name', function ($data) {
                    if (empty($data->item_name)) {
                        return 'N/A';
                    }
                    return $data->item_name;
                })
                ->addColumn('item_best_price', function ($data) {
                    if (empty($data->item_best_price)) {
                        return 'N/A';
                    }
                    return $data->item_best_price;
                })
                ->addColumn('upc_code', function ($data) {
                    if (empty($data->upc_code)) {
                        return 'N/A';
                    }
                    return $data->upc_code;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->menuStatus[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('menu.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Menu"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteMenu" href="javascript:;" data-menu="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Menu"><i class="fa fa-trash-o"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage Menu';

        return view('pages.menu.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->menuStatus;
        $data['Categorys'] = Category::Where('status', 1)->get();
        $data['Subcategorys'] = Subcategory::Where('status', 1)->get();
        return view('pages.menu.add',$data);
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
                        'item_name' => 'required',
                        'sub_category_id' => 'required',
                        'category_id' => 'required',
                        'item_best_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                        'upc_code' => 'required',
                        'product_id' => 'required'
                    ]);
        if ($request->hasFile('item_image')) {
            $imageName = time().'_menu.' . $request->file('item_image')->getClientOriginalExtension();
            $request->file('item_image')->move(
                base_path() . '/public/uploads/menus/', $imageName
                );
        }else{
            $imageName = '';
        }
        Menu::insert(['category_id' => $request->category_id, 'sub_category_id' => $request->sub_category_id, 'item_name' => $request->item_name, 'item_best_price' => $request->item_best_price,'upc_code' => $request->upc_code,'product_id' => $request->product_id, 'item_image' => $imageName, 'item_description' => $request->item_description, 'created_by' => $request->user()->id, 'status' => $request->status]);

        return redirect()->route('menu.index');
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
        $menuInfo = Menu::findOrFail($id);
        $category_id = $menuInfo->category_id;
        $data['menuInfo'] = $menuInfo;
        $data['Categorys'] = Category::Where('status', 1)->get();
        $data['Subcategorys'] = Subcategory::Where('category_id', $category_id)->Where('status', 1)->get();
        $data['status'] = $this->menuStatus;
        return view('pages.menu.edit',$data);
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
                    'item_name' => 'required',
                    'sub_category_id' => 'required',
                    'category_id' => 'required',
                    'item_best_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                    'upc_code' => 'required',
                    'product_id' => 'required'
                ]);
        $menu = Menu::find($id);
        $menu->category_id = $request->category_id;
        $menu->sub_category_id = $request->sub_category_id;
        $menu->item_name = $request->item_name;
        $menu->item_best_price = $request->item_best_price;
        $menu->upc_code = $request->upc_code;
        $menu->product_id = $request->product_id;
        $menu->item_description = $request->item_description;
        if ($request->hasFile('item_image')) {
            $imageName = time().'_menu.' . $request->file('item_image')->getClientOriginalExtension();
            $request->file('item_image')->move(
                base_path() . '/public/uploads/menus/', $imageName
            );
            $menu->item_image = $imageName;
            if($request->current_item_image){
                unlink(base_path() . '/public/uploads/menus/'.$request->current_item_image);
            }
        }
        $menu->status = $request->status;
        $menu->save();
        return redirect()->route('menu.index');
    }
    public function get_subcategory(Request $request)
    {
        //DB::enableQueryLog();
        $str = '<option value="0" disabled="disabled" selected> -- Select Sub Category -- </option>';
        $category_id = $request->category_id;
        $subCategorys = Subcategory::Where('category_id','=', $category_id)->Where('status', '=', 1)->get();
        //dd(DB::getQueryLog());
        if($subCategorys){
            foreach ($subCategorys as $key => $value) {
                $str .= '<option value="'.$value->id.'">'.$value->sub_category_name.'</option>';
            }
        }
        echo $str;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = Menu::find($request->id);
        $category->delete();
        return redirect()->route('menu.index');
    }
}
