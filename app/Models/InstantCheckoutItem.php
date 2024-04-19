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
        $download_url = 'start';
        
        if ($this->type == 'music' && $this->music != null) {
            $downloads = $this->music->downloads;
            $download_url = 'inside if';
            if (is_string($downloads)) {
                $download_url = 'inside if string';
                $downloads = unserialize($downloads);
            }

            if (is_array($downloads)) {
                logger('checking', $downloads);
                $download_url = $downloads['path'];
                foreach ($downloads as $download) {
                    $download_url = 'inside foreach';
                    if (isset($download['source']) && $download['source'] == 'firebase') {
                        $download_url = $download['path'];
                        break;
                    }
                }
            }
        }
        
        return $download_url;
    }
}