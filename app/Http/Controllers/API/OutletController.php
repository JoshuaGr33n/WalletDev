<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Outlet;

class OutletController extends BaseAPIController
{
    public function listOutlets(Request $request)
    {
        $data = array();
        $items = array();

    	//$menuList = Category::find($request->category_id);
    	
    	$outletItems = Outlet::with('merchant')->where('status',1)->get();
    	
    	if($outletItems){
	    	   	foreach ($outletItems as $outlet):
	                $outletImg = (!empty($outlet->outlet_logo)) ? URL('uploads/outlets/' . $outlet->outlet_logo) : URL('images/noimage.png');

	                $data[] = array(
		                		'outlet_id'   => $outlet->id,
		                		'outlet_name' => $outlet->outlet_name,
		                		'outlet_address'  => $outlet->outlet_address,
		                		'outlet_image' => $outletImg,
		                		'outlet_latitude'  => $outlet->outlet_latitude,
		                		'outlet_longitude'  => $outlet->outlet_longitude,
		                		'outlet_pincode'  => '',
		                		'merchant_name'  => $outlet['merchant']->company_name,
		                		'merchant_id'  => $outlet->merchant_id,
		                		'operation_hours'  => $outlet->outlet_hours,
		                		'distance'  => 0
	                		);
	            endforeach;

	    		return response()->json(['status' => 'success', 'message' => 'Outlet List Retrieved', 'data' => $data], $this->successStatus);
	    	} else {
	    		return response()->json(['status' => 'failed', 'message' => 'No Outlet Items Retrieved', 'data' => $data], $this->successStatus);	
	    	}
    }
}
