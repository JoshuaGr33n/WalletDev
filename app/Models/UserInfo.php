<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class UserInfo extends Model

{

    protected $table = 'user_infos';



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'user_id','area_id'

    ];



    public function users()

    {

        return $this->belongsToMany('App\Models\User');

    }



    public function area()

    {

        return $this->belongsTo('App\Models\Area', 'area_id');

    }

}

