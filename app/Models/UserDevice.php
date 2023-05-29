<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserDevice extends Authenticatable
{

	protected $table = 'user_devices';


    public function user(){
        return $this->belongsTo( 'App\Models\User', 'user_id', 'id' );
    }

}