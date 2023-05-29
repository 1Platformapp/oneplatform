<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class VideoChannel extends Authenticatable
{
        /**
         * @var array
         */
        protected $fillable = [ 'title', 'description'];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function streams()
        {
            return $this->hasMany( VideoStream::class );
        }

        /**
         * @param $query
         *
         * @return mixed
         */
        public function scopeNoStream( $query )
        {
            return $query->doesntHave( 'streams' );
        }

        /**
         * @param $query
         *
         * @return mixed
         */
        public function scopeWithStream( $query )
        {
            return $query->has( 'streams' );
        }

        /**
         * @throws \Exception
         */
        public function delete()
        {
            foreach( $this->streams as $stream )
            {
                $stream->delete();
            }

            parent::delete();
        }

    }
