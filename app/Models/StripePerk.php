<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


    class StripePerk extends Authenticatable
    {
    
        public function user()

        {

            return $this->belongsTo( User::class );

        }
        
        
        public function customer()

        {

            return $this->belongsTo( User::class );

        }
        
        public function perk()

        {

            return $this->belongsTo( campaignPerks::class );

        }

        public function campaign()
        {

            return $this->hasOne( userCampaign::class, 'id', 'campaign_id' );

        }

    }