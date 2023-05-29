<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CrowdfundBasket extends Authenticatable

{
        protected $table = 'crowdfund_basket';

        public function user()

        {

            return $this->belongsTo( User::class );

        }

        public function customer()

        {

            return $this->belongsTo( User::class );

        }

        public function bonus()

        {

            return $this->belongsTo( CampaignPerks::class, 'bonus_id' );

        }
    }
