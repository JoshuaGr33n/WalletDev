<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Menu;
use DB;

class MenuController extends BaseAPIController
{
    public function listMenus(Request $request)
    {
    	$subCatListing = array();
        $data = array();
        $items = array();

    	//$menuList = Category::find($request->category_id);
    	//DB::enableQueryLog();
    	//$menuItems = Menu::with('category','subCategory')->where('category_id',$request->category_id)->get();
    	if($request->category_id){
    		$subCatItems = Subcategory::with('category')->where('category_id',$request->category_id)->get();
    	}else{
    		$subCatItems = Subcategory::with('category')->get();
    	}
    	//dd(DB::getQueryLog());
    	//print_r($subCatItems);
    	if($subCatItems){
    	   	foreach ($subCatItems as $subCat):
    	   		$menuItems = Menu::Where('sub_category_id',$subCat->id)->get();
    	   		$newMenu = array();
    	   		if($menuItems){
    	   			foreach ($menuItems as $menu):
	                	$menuImg = (!empty($menu->item_image)) ? URL('uploads/menus/' . $menu->item_image) : URL('images/noimage.png');
	              
	                	$newMenu[] = array('id' => $menu->id, 'item_name' => $menu->item_name, 'item_price' => $menu->item_best_price,'description' => $menu->item_description, 'item_image' => $menuImg, 'status' => intval($menu->status));
	                endforeach;
	            }
                $subCatListing[] = array('sub_category_name' => $subCat->sub_category_name, 'sub_category_id' => $subCat->id, 'status' => intval($subCat->status), 'items' => $newMenu);    
            endforeach;

    		return response()->json(['status' => 'success', 'message' => 'Menu List Retrieved', 'data' => $subCatListing], $this->successStatus);
	    } else {
	    	return response()->json(['status' => 'failed', 'message' => 'No Menu Items Retrieved', 'data' => []], $this->successStatus);	
	    }
    }
}
