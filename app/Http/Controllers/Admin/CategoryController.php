<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Datatables;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->CategoryStatus = ['1' => 'Active','2' => 'Inactive',];
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
            $categories = Category::query();

            if ($request->category_name) {
                $categories->where('category_name', 'like', '%' . $request->category_name . '%');
            }

            $results = $categories->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('first_name', function ($data) {
                    if (empty($data->category_name)) {
                        return 'N/A';
                    }

                    return $data->category_name;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }

                    return $this->CategoryStatus[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('category.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Category"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deletecategory" href="javascript:;" data-category="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Category"><i class="fa fa-trash-o"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage Category';

        return view('pages.category.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->CategoryStatus;
        return view('pages.category.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['category_name' => 'required|regex:/^[\pL\s\-]+$/u']);
        Category::insert(['category_name' => $request->category_name, 'created_by' => $request->user()->id, 'status' => $request->status]);
        return redirect()->route('category.index');
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
        $data['categoryInfo'] = Category::findOrFail($id);   //
        $data['status'] = $this->CategoryStatus;
        return view('pages.category.edit',$data);
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
        $request->validate(['category_name' => 'required']);
        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->status = $request->status;
        $category->save();
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();
        return redirect()->route('category.index');
    }
}
