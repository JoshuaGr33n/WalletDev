<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'gender',
        'user_name',
        'postal_code',
        'state',
        'location',
        'dob',
        'role',
        'country_code',
        'phone_number',
        'email',
        'password',
        'is_phone_verified',
        'gender',
        'member_id',
        'registered_date',
        'referral_code',
        'referrer_id',
        'user_unique_id',
        'photo',
        'home_phone',
        'user_qr_image',
        'last_login',
        'is_logged_in'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'PIN',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'DOB' => 'datetime:d-m-Y',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    protected $appends = ['referral_link'];

    /**
     * Get the user's referral link.
     *
     * @return string
     */

    public static function boot()
    {
        parent::boot();
        static::deleting(function($user)
        {
             $userProfile = User::find($user->id);
             $userProfile->email = $user->email.'_'.$user->id.'_deleted';
             $userProfile->mobile_no = $user->mobile_no.'_'.$user->id.'_deleted';
             $userProfile->save();
        });
    }

    public function findForPassport($username)
    {
        return $this->Where('email', $username)
            ->with('roles', 'userInfo')
            ->first();
    }

    public function role_user()
    {
        //return $this->belongsTo('App\Models\Role_user');
        return $this->belongsTo('App\Models\Role_user');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withPivot('role_id');
    }

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles);
        }
        return $this->hasRole($roles);
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function userInfo()
    {
        return $this->hasOne('App\Models\UserInfo')->with('area');
    }
    public function user_reward()
    {
        return $this->hasOne('App\Models\User_reward','user_id','id');
    }
    public function user_wallet()
    {
        return $this->hasOne('App\Models\User_wallet','user_id','id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }

    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register', ['ref' => $this->referral_code]);
    }
}
