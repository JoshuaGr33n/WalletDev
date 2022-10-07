<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;

class AreaController extends BaseAPIController
{
    public function listAreas()
    {
    	$areaList = Area::where('status','1')->get()->toArray();
    	return response()->json(['status' => 'success', 'message' => 'Areas List', 'data' => $areaList], $this->successStatus);
    }
}
