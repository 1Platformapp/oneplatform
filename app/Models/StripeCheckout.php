<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StripeCheckout extends Authenticatable
{

    public function user()
    {

        return $this->belongsTo( User::class );

    }


    public function customer()
    {

        return $this->belongsTo( User::class );

    }

    public function campaign()
    {

        return $this->belongsTo( userCampaign::class );

    }

    public function instantCheckoutItems()
    {

        return $this->hasMany( InstantCheckoutItem::class );

    }

    public function crowdfundCheckoutItems()
    {

        return $this->hasMany( CrowdfundCheckoutItem::class );

    }

    public function agent()
    {

        return $this->belongsTo( User::class, 'agent_id', 'id' );

    }

    public function stripeSubscription()
    {

        return $this->hasOne( StripeSubscription::class, 'id', 'stripe_subscription_id' );

    }

}