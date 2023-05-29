<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Region extends Authenticatable
{
        public $timestamps = false;
        protected $table = 'regions';


        public function country()
        {
            return $this->belongsTo(Country::class);
        }

        public function cities()
        {
            return $this->hasMany(City::class);
        }

        public function scopecountryId( $query, $cid )
        {
            return $query->where( 'country_id', $cid );
        }

        public function scopenameLike( $query, $name )
        {
            return $query->where( 'name', 'LIKE', $name );
        }
    }
