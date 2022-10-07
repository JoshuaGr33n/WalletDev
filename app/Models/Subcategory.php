<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subcategory extends Model
{
	use SoftDeletes;
	
    protected $table = 'sub_categories';

    public function category()
    {
    	return $this->belongsTo('App\Models\Category','category_id');
    }
}
