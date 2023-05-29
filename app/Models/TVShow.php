<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

    class TVShow extends Authenticatable
    {
        /**
         * @var string
         */
        protected $table = 'tv_shows';
        /**
         * @var array
         */
        protected $dates = [ 'start','end' ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function recordings()
        {
            return $this->hasMany( TVShowRecording::class );
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function stream()
        {
            return $this->belongsTo(VideoStream::class,'video_stream_id');
        }

        /**
         * @return bool
         */
        public function isLive()
        {
            $nowdate = Carbon::now( 'Europe/London' );
            return $nowdate->between($this->start, $this->end);
        }

        /**
         * @param $query
         *
         * @return mixed
         */
        public function scopeLiveNext( $query )
        {
            $nowdate = Carbon::now( 'Europe/London' )->toDateTimeString();

            return $query->where( 'start', '>=', $nowdate )->orderBy( 'start', 'ASC' )->limit( 1 );
        }

        public function scopeLiveNow( $query )
        {
            $nowdate = Carbon::now( 'Europe/London' )->toDateTimeString();

            return $query->where( 'start', '<=', $nowdate )
                ->where( 'end', '>=', $nowdate )
                ->orderBy( 'start', 'ASC' )->limit( 1 );
        }

        public function scopeLiveLast( $query )
        {
            $nowdate = Carbon::now( 'Europe/London' )->toDateTimeString();
            return $query->where( 'end', '<=', $nowdate )->orderBy( 'id', 'DESC')->limit( 1 );
        }

        /**
         * @param $value
         */
        public function setEndAttribute( $value )
        {
            if( is_string( $value ) )
            {
                $value = Carbon::createFromFormat( 'm/d/Y H:i', $value, 'Europe/London' );
            }

            $this->attributes[ 'end' ] = $value;
        }

        /**
         * @param $value
         */
        public function setStartAttribute( $value )
        {
            if( is_string( $value ) )
            {
                $value = Carbon::createFromFormat( 'm/d/Y H:i', $value, 'Europe/London' );
            }

            $this->attributes[ 'start' ] = $value;
        }

        public function getEndAttribute( $value )
        {
            return new Carbon( $this->attributes[ 'end' ], 'Europe/London' );
        }

        /**
         * @param $value
         */
        public function getStartAttribute( $value )
        {
            return new Carbon( $this->attributes[ 'start' ], 'Europe/London');
        }

        public static function cronUpdateDates()
        {
            $shows = TVShow::all();

            foreach( $shows as $show)
            {
                $show->updateIntervalDates();
            }
        }

        public function updateIntervalDates()
        {
            $result = $this->_adjustDate( $this->start );
            $this->start = $this->start->addDays( $result );
            $this->end = $this->end->addDays($result);
            $this->save();
        }
        /*
        public function getEndAttribute()
        {

            $end = new Carbon( $this->attributes[ 'end' ]);
            return $this->_adjustDate( $end );
        }

        public function getStartAttribute()
        {

            $start = new Carbon( $this->attributes[ 'start' ] );
            return $this->_adjustDate( $start );
        }
*/
        protected function _adjustDate( Carbon $date)
        {
            $result = 0;
            if( $this->interval > 0 )
            {
                $datenow = Carbon::now( 'Europe/London' )->startOfDay();
                $time = $date->copy()->startOfDay();
                $dif = $datenow->diffInDays( $time);
                if( $datenow->gt( $time ) && $dif > 0 )
                {
                    $intervals = ceil( $dif / $this->interval );
                    $result = $intervals * $this->interval;
                }

            }
            return $result;
        }
    }
