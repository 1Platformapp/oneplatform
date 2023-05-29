<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class InternalSubscription extends Authenticatable
{
        
    protected $table = 'internal_subscriptions';

        public function user()
        {

            return $this->belongsTo(User::class);

        }

        public function invoices()
        {

            return $this->hasMany(InternalSubscriptionInvoice::class);

        }


        public function setSubscriptionCardAttribute($value)
        {
            $this->attributes['subscription_card'] = serialize($value);
        }

        public function getSubscriptionCardAttribute($value)
        {
            return unserialize($value);
        }
    }
