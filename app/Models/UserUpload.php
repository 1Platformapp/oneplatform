<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Http\Controllers\Youtube;
use Exception;

class UserUpload extends Authenticatable
{

    protected $fillable = [];


    public function user()
    {
        return $this->belongsTo( User::class );
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
        $this->save();
    }

}
