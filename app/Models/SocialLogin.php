<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class SocialLogin extends Authenticatable
{
    protected $table = 'social_logins';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeService( $query, $service = 'google')
    {
        return $query->where( 'service', '=', $service );
    }
}
