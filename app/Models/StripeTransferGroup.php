<?php


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

    class StripeTransferGroup extends Authenticatable
    {
        
        public function agent(){
            return $this->hasOne( User::class, 'id', 'agent_id' );
        }

        public function agentTwo(){
            return $this->hasOne( User::class, 'id', 'agent_two_id' );
        }

        public function seller(){
            return $this->hasOne( User::class, 'id', 'seller_id' );
        }

        public function buyer(){
            return $this->hasOne( User::class, 'id', 'buyer_id' );
        }
        
        public function setTransfersAttribute($value)
        {
            $this->attributes['transfers'] = serialize($value);
        }

        public function getTransfersAttribute($value)
        {
            return unserialize($value);
        }
    }
