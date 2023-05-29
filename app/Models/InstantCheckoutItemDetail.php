<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class InstantCheckoutItemDetail extends Authenticatable

{
	protected $table = 'instant_checkout_item_details';

    public function checkoutItem()
    {

        return $this->belongsTo(InstantCheckoutItem::class);

    }
}