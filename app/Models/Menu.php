<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Menu extends Model
{
	use SoftDeletes;
	
    protected $table = 'menus';
    
    
    public function category()
    {
    	return $this->belongsTo('App\Models\Category','category_id');
    }

    public function subCategory()
    {
    	return $this->belongsTo('App\Models\Subcategory','sub_category_id');
    }
}
