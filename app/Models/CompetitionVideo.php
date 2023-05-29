<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Http\Controllers\Youtube;
use App\Models\CompetitionVideo;

class CompetitionVideo extends Authenticatable
{
    protected $table = 'competition_videos';

    protected $fillable = [ 'title', 'artist', 'profile_id', 'link', 'video_id', 'likes', 'dislikes' , 'type' , 'show_in_cart' ];


    public function competition()
    {
        return $this->belongsTo( Competition::class );
    }

    public function profile()
    {
        return $this->belongsTo( Profile::class );
    }

    public function scopeInCompetition( $query )
    {
        return $query->where( 'competition_id', '<>', '0' );
    }

    public function scopeNotInCompetition( $query )
    {
        return $query->where( 'competition_id', '0' );
    }

    public function place()
    {
        return 0;
    }

    public static function isValidURL($url)
    {
        $result = false;
        try
        {
            $youtube = new Youtube('AIzaSyDDOS7Qt99Muw39WVzzjPYYwZd68yr2i38');
            $result = $youtube::parseVIdFromURL( $url );
        }
        catch( Exception $e )
        {
        }
        return $result;
    }

    public function fillYoutubeData()
    {
        $youtube    = new Youtube('AIzaSyDDOS7Qt99Muw39WVzzjPYYwZd68yr2i38');
        $video = $youtube->getVideoInfo( $this->video_id, [ 'statistics', 'snippet' ] );
        $this->title = $video->snippet->title;
        $this->total_likes = isset( $video->statistics->likeCount)? $video->statistics->likeCount:0;
        $this->total_dislikes = isset( $video->statistics->dislikeCount)? $video->statistics->dislikeCount:0;
        $this->last_period_likes = $this->total_likes;
        $this->last_period_dislikes = $this->total_dislikes;
        $this->likes = 0;
        $this->dislikes = 0;
        $this->rank = $this->show_in_cart == 0 ? null : (CompetitionVideo::max('rank')) + 1;
        $this->save();
    }

    public function fillSoundcloudData()
    {

        $this->title = '';
        $strig = str_replace('https://', '', $this->link);
        $explode = explode('/', $strig);
        foreach ($explode as $key => $value) {

            if( $key == 0 ){ continue; }
            if( count( $explode ) == $key + 1 ){ $this->title .= $value; }
            else{ $this->title .= $value.'-'; }
        }
        $this->likes = 0;
        $this->dislikes = 0;
        $this->save();
    }

    /**
     * @return mixed
     */
    public function getUserData()
    {
        return $this->profile->user->getDetails();
    }

}
