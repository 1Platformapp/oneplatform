<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserSupporter extends Authenticatable
{
    public function owner()
    {
        return $this->belongsTo( User::class );
    }

    public function supporter()
    {
        return $this->belongsTo( User::class );
    }
}
