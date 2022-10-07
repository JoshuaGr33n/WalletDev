<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Role_user extends Model

{

	protected $table = 'role_user';


	protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'gender',
        'user_name',
        'postal_code',
        'dob',
        'role',
        'country_code',
        'phone_number',
        'phone_verified_at',
        'email',
        'password',
        'email_verified_at',
        'is_phone_verified',
        'gender',
        'member_id',
        'registered_date',
        'referral_code',
        'referrer_id',
        'user_unique_id',
        'user_image',
        'last_login',
        'is_logged_in'
    ];


	

	public function users()

	{

	    return $this->hasMany('App\Models\User');

	}

}

