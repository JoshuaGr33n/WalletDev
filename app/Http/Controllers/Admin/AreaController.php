<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use Datatables;

class AreaController extends Controller
{

    public function __construct()
    {
        $this->AreaStatus = ['1' => 'Active','2' => 'Inactive'];
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
            $areas = Area::query();

            if ($request->area_name) {
                $areas->where('area_name', 'like', '%' . $request->area_name . '%');
            }

            $results = $areas->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('first_name', function ($data) {
                    if (empty($data->area_name)) {
                        return 'N/A';
                    }

                    return $data->area_name;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }

                    return $this->AreaStatus[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('area.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Area"><i class="fa fa-edit"></i></a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deletearea" href="javascript:;" data-area="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Area"><i class="fa fa-trash-o"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage Area';

        return view('pages.area.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = $this->AreaStatus;
        return view('pages.area.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['area_name' => 'required|regex:/^[\pL\s\-]+$/u|unique:areas,area_name', 'pincode' => 'required|regex:/[0-9]+/|numeric|unique:areas,pincode']);
        Area::insert(['area_name' => $request->area_name, 'pincode' => $request->pincode, 'status' => $request->status]);

        return redirect()->route('area.index')->with('success','Area added successfully!');
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
        $data['areaInfo'] = Area::findOrFail($id);   //
        $data['status'] = $this->AreaStatus;
        return view('pages.area.edit',$data);
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
        $request->validate(['area_name' => 'required|regex:/^[\pL\s\-]+$/u|unique:areas,area_name,' . $id . '', 'pincode' => 'required|regex:/[0-9]+/|numeric']);
        $area = Area::find($id);
        $area->area_name = $request->area_name;
        $area->pincode = $request->pincode;
        $area->status  = $request->status;
        $area->save();
        return redirect()->route('area.index')->with('success','Area updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $area = Area::find($request->id);
        $area->delete();
        return redirect()->route('area.index');
    }
}
