<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserFollow extends Authenticatable
{

	protected $table = 'user_follow';


    public function followerUser(){
        return $this->belongsTo( 'App\Models\User', 'follower_user_id', 'id' );
    }

    public function followeeUser(){
        return $this->belongsTo( 'App\Models\User', 'followee_user_id', 'id' );
    }

}