<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Datatables;

class SubcategoryController extends Controller
{

    public function __construct()
    {
        $this->CategoryStatus = ['1' => 'Active','2' => 'Inactive'];
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
            $sub_categories = Subcategory::query();

            if ($request->sub_category_name) {
                $sub_categories->where('sub_category_name', 'like', '%' . $request->sub_category_name . '%');
            }

            $results = $sub_categories->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('sub_category_name', function ($data) {
                    if (empty($data->sub_category_name)) {
                        return 'N/A';
                    }
                    return $data->sub_category_name;
                })
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
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->CategoryStatus[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('subcategory.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Sub Category"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deletesubcategory" href="javascript:;" data-subcategory="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Sub Category"><i class="fa fa-trash-o"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage Sub Category';

        return view('pages.sub_category.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->CategoryStatus;
        $data['Categorys'] = Category::Where('status', 1)->get();
        return view('pages.sub_category.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['sub_category_name' => 'required|regex:/^[\pL\s\-]+$/u']);
        Subcategory::insert(['sub_category_name' => $request->sub_category_name,'category_id' => $request->category_id, 'created_by' => $request->user()->id, 'status' => $request->status]);
        return redirect()->route('subcategory.index');
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
        $data['subCategoryInfo'] = Subcategory::findOrFail($id);//
        $data['Categorys'] = Category::Where('status', 1)->get();
        $data['status'] = $this->CategoryStatus;
        return view('pages.sub_category.edit',$data);
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
        $request->validate(['sub_category_name' => 'required|regex:/^[\pL\s\-]+$/u']);
        $subcategory = Subcategory::find($id);
        $subcategory->sub_category_name = $request->sub_category_name;
        $subcategory->category_id = $request->category_id;
        $subcategory->status = $request->status;
        $subcategory->save();
        return redirect()->route('subcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $subcategory = Subcategory::find($request->id);
        $subcategory->delete();
        return redirect()->route('subcategory.index');
    }
}
