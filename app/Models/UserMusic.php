<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Http\Controllers\CommonMethods;

class UserMusic extends Authenticatable
{

    protected $table = 'user_musics';

    public function user()

    {

        return $this->belongsTo( User::class );

    }

    public function chat(){
        return $this->hasMany( 'App\Models\UserChat' );
    }

    public function genre(){
        return $this->belongsTo( Genre::class, "dropdown_one" );
    }

    public function albums(){
        return $this->belongsToMany( 'App\Models\UserAlbum' );
    }

    public function formatDuration(){
        return gmdate("i:s", $this->duration);
    }



    public function setInstrumentsAttribute($value)
    {
        $this->attributes['instruments'] = serialize($value);
    }
    public function getInstrumentsAttribute($value)
    {
        return unserialize($value);
    }

    public function setDownloadsAttribute($value)
    {
        $this->attributes['downloads'] = serialize($value);
    }

    // public function getDownloadsAttribute($value)
    // {
    //     return $value && is_array($value) && count($value) ? array_filter(unserialize($value)) : array();
    // }

    public function setPrivacyAttribute($value)
    {
        $this->attributes['privacy'] = serialize($value);
    }

    public function getPrivacyAttribute($value)
    {
        return $value ? array_filter(unserialize($value)) : [];
    }

    public function getDownloadName($item){

        if($item['source'] == 'local'){

            return $item['filename'];
        }else{
            if($item['mimetype'] == 'audio/wav' || $item['mimetype'] == 'audio/x-wav'){

                return $item['filename'].'.wav';
            }else if($item['mimetype'] == 'audio/mp3'){
                return $item['filename'].'.mp3';
            }
        }
    }
    public function addDownloadItem($file, $itemType, $source, $decFName){

        $counter = 1;
        if(count($this->downloads)){

            foreach ($this->downloads as $value) {
                $result[$counter]['filename'] = $value['filename'];
                $result[$counter]['type'] = $value['type'];
                $result[$counter]['mimetype'] = $value['mimetype'];
                $result[$counter]['path'] = $value['path'];
                $result[$counter]['itemtype'] = $value['itemtype'];
                $result[$counter]['size'] = $value['size'];
                $result[$counter]['source'] = $value['source'];
                $result[$counter]['dec_fname'] = $value['dec_fname'];
                $counter++;
            }
        }

        $result[$counter]['filename'] = $file['filename'];
        $result[$counter]['type'] = $file['type'];
        $result[$counter]['mimetype'] = $file['mimetype'];
        $result[$counter]['path'] = $file['path'];
        $result[$counter]['itemtype'] = $itemType;
        $result[$counter]['size'] = $file['size'];
        $result[$counter]['source'] = $source;
        $result[$counter]['dec_fname'] = $decFName;

        $this->downloads = $result;
        $this->save();
    }
}
