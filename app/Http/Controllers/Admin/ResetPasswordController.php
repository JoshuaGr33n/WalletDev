<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;

class ResetPasswordController extends Controller
{

    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'Reset Password';

        return view('pages.setting.forgotpassword', $data);
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
        return redirect()->route('area.index');
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
        $area->status = $request->status;
        $area->save();
        return redirect()->route('area.index');
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
