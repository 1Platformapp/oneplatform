<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Genre extends Authenticatable
{
        /**
         * @var bool
         */
        public $timestamps = false;
        /**
         * @var string
         */
        protected $table = 'genres';

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function profiles()
        {
            return $this->hasMany( Profile::class );
        }

        /**
         * @param $query
         * @param $name
         *
         * @return mixed
         */
        public function scopenameLike( $query, $name )
        {
            return $query->where( 'name', 'LIKE', $name );
        }
    }
