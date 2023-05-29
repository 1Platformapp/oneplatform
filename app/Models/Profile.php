<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

    class Profile extends Authenticatable
    {
        /**
         * @var array
         */
        protected $dates = [ 'birth_date' ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function user()
        {
            return $this->belongsTo( User::class );
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function job()
        {
            return $this->belongsTo( ArtistJob::class );
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function genre()
        {
            return $this->belongsTo( Genre::class );
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function competitionVideos()
        {
            return $this->hasMany( CompetitionVideo::class );
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
         */
        public function competitions()
        {
            return $this->belongsToMany( Competition::class,'competition_videos','profile_id','competition_id' )->distinct();
        }


        /**
         * @param $query
         */
        public function videosNotInCompetition()
        {
            return $this->competitionVideos()->notInCompetition()->get();
        }
        /**
         * @return bool|null
         * @throws \Exception
         */
        public function delete()
        {
            CompetitionVideo::where( 'profile_id', $this->id )->delete();

            return parent::delete();
        }


        public function instagramFeed()
        {
            $return = '';

            if($this->social_instagram_user_id != '' && $this->social_instagram_user_access_token_ll != ''){

                $instaUserId = $this->social_instagram_user_id;
                $instaAccessToken = $this->social_instagram_user_access_token_ll;

                $url2 = 'https://graph.instagram.com/me/media?fields=id,caption&access_token='.$instaAccessToken.'&limit=5';
                $ch2 = curl_init($url2);
                curl_setopt($ch2, CURLOPT_POST, false);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                $output2 = curl_exec ($ch2);
                curl_close ($ch2);
                $return2 = json_decode(trim($output2), TRUE);

                if(isset($return2['data'])){

                    foreach ($return2['data'] as $key => $data) {
                        if(is_array($data) && isset($data['id'])){

                            $url3 = 'https://graph.instagram.com/'.$data['id'].'?fields=id,media_type,media_url,username,timestamp&access_token='.$instaAccessToken;
                            $ch3 = curl_init($url3);
                            curl_setopt($ch3, CURLOPT_POST, false);
                            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                            $output3 = curl_exec ($ch3);
                            curl_close ($ch3);
                            $return3 = json_decode(trim($output3), TRUE);

                            if(is_array($return3) && isset($return3['media_url']) && isset($return3['media_type'])){

                                if($return3['media_type'] == 'IMAGE'){

                                    $return .= '<img class="insta_feed_each_img" src="'.$return3['media_url'].'" />';
                                }
                            }
                        }
                    }
                }else if(isset($return2['error']) && count($return2['error'])){

                    $return .= $return2['error']['message'];
                }
            }

            return $return;
        }

        public function setSplashAttribute($value)
        {
            $this->attributes['splash'] = serialize($value);
        }

        public function getSplashAttribute($value)
        {
            return unserialize($value);
        }
    }
