<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Datatables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('AdminAccess'); // Allows Access to Admin
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Role::query();

            if ($request->name) {
                $categories->where('name', 'like', '%' . $request->name . '%');
            }

            $results = $categories->Where('name','!=','Customer')->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    if (empty($data->name)) {
                        return 'N/A';
                    }
                    return $data->name;
                })
                ->addColumn('description', function ($data) {
                    if (empty($data->description)) {
                        return 'N/A';
                    }

                    return $data->description;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('role.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit role"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleterole" href="javascript:;" data-role="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete role"><i class="fa fa-trash-o"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage Role';

        return view('pages.role.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('pages.role.add',array());
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
        					'name' => 'required|regex:/^[\pL\s\-]+$/u|unique:roles,name',
    						'description' => 'required'
    					]);
        Role::insert(['name' => $request->name, 'description' => $request->description, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")]);
        return redirect()->route('role.index');
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
        $data['roleInfo'] = Role::findOrFail($id);//
        return view('pages.role.edit',$data);
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
        				'name' => 'required|regex:/^[\pL\s\-]+$/u|unique:roles,name,' . $id . '',
        				'description' => 'required'
        			]);
        $role = Role::find($id);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
