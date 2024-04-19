<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class InstantCheckoutItem extends Authenticatable

{
	protected $table = 'instant_checkout_items';
    
    protected $appends = [
        "download_url",
        "source",
    ];

	
    public function stripeCheckout()
    {

        return $this->belongsTo(StripeCheckout::class);

    }

    public function music()
    {
        return $this->belongsTo(UserMusic::class, 'source_table_id');
    }

    public function checkoutDetails()
    {

        return $this->hasMany(InstantCheckoutItemDetail::class);

    }

    public function getDownloadUrlAttribute()
    {
        $download_url = false;
        
        if($this->type == 'music' && $this->music != null) {
            $download_url = true;
            foreach($this->music->downloads as $download) {
                if($download['source'] == 'firebase') {
                }
            }
        }
        
        return $download_url;
    }

    public function getSourceAttribute()
    {
        $source = false;
        
        if($this->type == 'music' && $this->music != null) {
            foreach($this->music->downloads as $download) {
                $source = true;
                if($download['source'] == 'firebase') {
                }
            }
        }
        
        return $source;
    }
}