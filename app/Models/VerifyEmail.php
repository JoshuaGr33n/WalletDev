<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyEmail extends Model
{
    protected $table = 'verify_email';

    protected $fillable = ['email','otp','sent_at'];
}
