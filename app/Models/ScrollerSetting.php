<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ScrollerSetting extends Authenticatable
{
    public function user()

    {

        return $this->hasOne( User::class, 'id', 'user_id' );

    }

    public function stream()

    {

        return $this->hasOne(VideoStream::class, 'id', 'video_stream_id');

    }

}