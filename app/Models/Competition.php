<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Carbon\Carbon;
use DB;


class Competition extends Authenticatable

{
        /**
         * @var string
         */
        protected $table = 'competitions';
        /**
         * @var array
         */
        protected $fillable = [ 'name', 'start-date', 'end-date' ];
        /**
         * @var array
         */
        protected $dates = [ 'start-date', 'end-date' ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function videos()
        {
            return $this->hasMany( CompetitionVideo::class );
        }

        /**
         * @return mixed
         */
        public function getRankedVideos()
        {
            return $this->videos()->orderBy(  DB::raw( 'ISNULL(`rank`),`rank`' ))->get();
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
         */
        public function profiles()
        {
            return $this->hasManyThrough( Profile::class, CompetitionVideo::class );
        }

        /**
         * @param $query
         *
         * @return mixed
         */
        public function scopeLast( $query )
        {
            return $query->whereDate( 'start-date', '<=', Carbon::today()->toDateString() )
                         ->whereDate( 'end-date', '>', Carbon::today()->toDateString() );
        }

        /**
         * @return mixed
         */
        public function getVideosSortedByLikes()
        {
            return $this->videos()->orderBy( 'likes', 'desc' )->get();
        }

        /**
         * @param $query
         * @param $id
         */
        public function scopeAvailable( $query, $list, $multi = true )
        {
            return $this->scopeLast( $query )->whereIn( 'id', $list, 'and', $multi );
        }

        /**
         * @param           $query
         * @param           $user
         * @param bool|true $multi
         *
         * @return mixed
         */
        public function scopeAvailableForUser( $query, $user, $multi = true )
        {
            $list = $user->profile->competitions->pluck( 'id' );

            if( $list->count() == 0 )
            {
                $list->push( 0 );
            }

            return $this->scopeAvailable( $query, $list, !$multi );
        }

        /**
         * @param $id
         *
         * @return mixed
         */
        public function videoForProfile( $id )
        {
            return $this->videos()->where( 'profile_id', $id )->first();
        }

        /**
         * @param $id
         *
         * @return mixed
         */
        public function videosForProfile( $id )
        {
            return $this->videos()->where( 'profile_id', $id )->get();
        }

        public function delete()
        {
            $ids = $this->videos->pluck( 'id' );
            $vids = CompetitionVideo::whereIn('id',$ids)->update(["competition_id"=>0]);
            return parent::delete();
        }
    }
