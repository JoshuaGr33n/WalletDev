<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Adminuser extends Model
{
    use SoftDeletes;
    protected $table = 'users';
}
