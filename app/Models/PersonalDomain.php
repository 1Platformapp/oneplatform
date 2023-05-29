<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PersonalDomain extends Authenticatable
{
        

        public function user()
        {

            return $this->belongsTo(User::class);

        }


        public function setDomainUrlAttribute($value){

            $url = strtolower($value);
            $url = str_replace('http://','',$url);
            $url = str_replace('https://','',$url);
            $url = strpos($url, 'www.') !== false ? $url : 'www.'.$url;
            $explode = explode('/', $url);

            $this->attributes['domain_url'] = $explode[0];
        }

    }
