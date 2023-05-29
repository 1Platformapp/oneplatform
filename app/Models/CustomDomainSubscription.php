<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\UserCampaign;
use App\Models\UserLiveStream;
use App\Models\UserChatGroup;

class CustomDomainSubscription extends Authenticatable

{

        /**

         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo

         */

        public function user()
        {

            return $this->belongsTo(User::class);

        }

        public function setSubscriptionPlanAttribute($value)
        {
            $this->attributes['subscription_plan'] = serialize($value);
        }

        public function getSubscriptionPlanAttribute($value)
        {
            return unserialize($value);
        }

        public function setSubscriptionCardAttribute($value)
        {
            $this->attributes['subscription_card'] = serialize($value);
        }

        public function getSubscriptionCardAttribute($value)
        {
            return unserialize($value);
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
