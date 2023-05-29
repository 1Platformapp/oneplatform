<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserAlbum extends Authenticatable
{
    public function user(){
        return $this->belongsTo( User::class );
    }

    public function musics(){
        return $this->hasMany('App\Models\UserMusic', 'album_music', 'album_id', 'music_id');
    }

    public function firstMusic(){
        return $this->belongsToMany( 'App\Models\UserMusic', 'album_music', 'album_id', 'music_id' )->orderBy("music_id", "asc")->limit(1);
    }

    public function setMusicsAttribute($value){
        $this->attributes['musics'] = serialize($value);
    }

    public function getMusicsAttribute($value){
        return unserialize($value);
    }

}