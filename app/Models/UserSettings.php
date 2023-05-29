<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserSettings extends Authenticatable
{
        protected $table = 'user_settings';

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function user()
        {
            return $this->belongsTo( User::class );
        }

        /**
         * @param Builder $query
         * @param int     $val Active or inactive 1 or 0
         *
         * @return Builder
         */
        public function scopeKey( $query, $val = '' )
        {
            return $query->where( 'key', '=', $val );
        }
    }
