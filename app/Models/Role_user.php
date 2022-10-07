<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Role_user extends Model

{

	protected $table = 'role_user';


	protected $fillable = [
		'user_id',
        'role_id'
    ];


	

	public function users()

	{

	    return $this->hasMany('App\Models\User');

	}

}

