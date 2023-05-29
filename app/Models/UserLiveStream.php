<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserLiveStream extends Authenticatable
{
    public function user(){
        
        return $this->belongsTo( User::class );
    }
    public function productt(){
        
        return $this->hasOne( UserProduct::class, 'id', 'product' );
    }

    public function musicc(){
        
        return $this->hasOne( UserMusic::class, 'id', 'music' );
    }

}