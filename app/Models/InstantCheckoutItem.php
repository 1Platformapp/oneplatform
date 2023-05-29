<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class InstantCheckoutItem extends Authenticatable

{
	protected $table = 'instant_checkout_items';
	
    public function stripeCheckout()
    {

        return $this->belongsTo(StripeCheckout::class);

    }


    public function checkoutDetails()
    {

        return $this->hasMany(InstantCheckoutItemDetail::class);

    }
}