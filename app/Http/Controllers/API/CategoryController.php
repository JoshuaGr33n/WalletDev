<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends BaseAPIController
{
    public function listCategories()
    {
    	$categories = Category::with('subcategoryCount')->where('status','1')->get();
    	
    	if($categories) {
    		foreach ($categories as $i => $value) {
				$categories[$i]['total_sub_category'] = $value->subcategoryCount()->count();
    			$categoryList[] = array('category_name' => $value->category_name, 'category_id' => $value->id, 'total_sub_category' => $value->subcategoryCount()->count());
    		}
    		return response()->json(['status' => 'success', 'message' => 'Categories Retrieved', 'data' => $categories], $this->successStatus);	
    	} else {
    		return response()->json(['status' => 'failed', 'message' => 'No Categories Retrieved', 'data' => []], $this->successStatus);	
    	}
    	
    }
}
