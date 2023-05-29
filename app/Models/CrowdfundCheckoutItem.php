<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CrowdfundCheckoutItem extends Authenticatable

{
	protected $table = 'crowdfund_checkout_items';

    public function stripeCheckout()
    {

        return $this->belongsTo(StripeCheckout::class);

    }

    public function bonus()

    {

        return $this->belongsTo( campaignPerks::class, 'source_table_id' );

    }
}