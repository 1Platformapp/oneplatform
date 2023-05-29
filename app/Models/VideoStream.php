<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class VideoStream extends Authenticatable

{

        public function shows()

        {

            return $this->hasMany( TVShow::class );

        }



        public function channel()

        {

            return $this->belongsTo( VideoChannel::class,'video_channel_id' );

        }

        public function timeFormatted(){

            $startDateTime = $this->live_start_date_time;
            $endDateTime = $this->live_end_date_time;
            if(date('dmy',strtotime($startDateTime)) ==  date('dmy',strtotime($endDateTime))){

                $return = date('M d, Y H:i', strtotime($startDateTime));
            }else{

                $return = date('M d, Y H:i', strtotime($startDateTime));
            }  

            return $return; 
        }

        public function poster(){

            $startDateTime = $this->live_start_date_time;
            $endDateTime = $this->live_end_date_time;
                
            if(strtotime($startDateTime) < time() && strtotime($endDateTime) <= time() && $this->default_thumb !== NULL){
                $return = 'https://www.duong.1platform.tv/public/stream-images/'.$this->default_thumb;
            }else if(strtotime($startDateTime) < time() && strtotime($endDateTime) <= time() && $this->default_thumb == NULL){
                $return = 'https://img.youtube.com/vi/'.$this->youtube_id.'/0.jpg';
            }else if(strtotime($startDateTime) <= time() && strtotime($endDateTime) > time()){
                $return = 'https://img.youtube.com/vi/'.$this->youtube_id.'/0.jpg'; 
            }else if(strtotime($startDateTime) > time() && strtotime($endDateTime) > time()){
                $return = 'https://www.duong.1platform.tv/public/stream-images/'.$this->default_thumb;
            }

            return $return; 
        }

        public function upcomingStatus(){

            $startDateTime = $this->live_start_date_time;
            $endDateTime = $this->live_end_date_time;
            
            if($this->source == 'youtube' && strtotime($startDateTime) > time() && strtotime($endDateTime) > time()){
                $return = 1;
            }else{
                $return = 0;
            }

            return $return; 
        }

        public function thumb(){

            $startDateTime = $this->live_start_date_time;
            $endDateTime = $this->live_end_date_time;
            
            if($this->source == 'youtube'){

                if(strtotime($startDateTime) <= time() && strtotime($endDateTime) > time()){
                    if(strpos($this->youtube_link, 'vimeo') !== false){
                        $return = $this->default_thumb; 
                    }else{
                        $return = 'https://img.youtube.com/vi/'.$this->youtube_id.'/1.jpg'; 
                    }
                }else if(strtotime($startDateTime) < time() && strtotime($endDateTime) <= time()){
                    if(strpos($this->youtube_link, 'vimeo') !== false){
                        $return = $this->default_thumb; 
                    }else{
                        $return = 'https://img.youtube.com/vi/'.$this->youtube_id.'/1.jpg'; 
                    }
                }else if(strtotime($startDateTime) > time() && strtotime($endDateTime) > time()){
                    if(strpos($this->youtube_link, 'vimeo') !== false){
                        $return = $this->default_thumb; 
                    }else{
                        $return = 'https://www.duong.1platform.tv/public/stream-images/thumbs/two/'.$this->default_thumb;
                    }
                }
            }else if($this->source == 'google_drive'){

                if(@getimagesize('https://drive.google.com/thumbnail?id='.$this->google_file_id.'&authuser=0&sz=w320-h180-n-k-rw')){
                    $return = 'https://drive.google.com/thumbnail?id='.$this->google_file_id.'&authuser=0&sz=w320-h180-n-k-rw';
                }else if($this->default_thumb && $this->default_thumb != ''){
                    $return = 'https://www.duong.1platform.tv/public/stream-images/thumbs/two/'.$this->default_thumb;
                }else{
                    $return = '';
                }
            }

            return $return; 
        }

        public function setHostsAttribute($value)
        {
            $this->attributes['hosts'] = serialize($value);
        }

        public function getHostsAttribute($value)
        {
            return unserialize($value);
        }

    }

