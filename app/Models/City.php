<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class City extends Authenticatable

{
        public $timestamps = false;
        protected $table = 'cities';

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function region()
        {
            return $this->belongsTo(Region::class);
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

        /**
         * @param $query
         * @param $cid
         *
         * @return mixed
         */
        public function scoperegionId( $query, $cid )
        {
            return $query->where( 'region_id', $cid );
        }
    }
