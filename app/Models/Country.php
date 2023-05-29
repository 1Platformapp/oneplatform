<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Country extends Authenticatable

{
        public $timestamps = false;
        protected $table = 'countries';

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function regions()
        {
            return $this->hasMany( Region::class );
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
         */
        public function cities()
        {
            return $this->hasManyThrough( City::class, Region::class );
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
