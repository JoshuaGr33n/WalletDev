<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
	use SoftDeletes;
	
    protected $table = 'categories';

    public function subcategoryCount()
    {
    	return $this->hasMany('App\Models\Subcategory','category_id','id');
    }

    public function menuItems()
    {
    	return $this->hasMany('App\Models\Menu','category_id')->where('status','1');
    }
}
