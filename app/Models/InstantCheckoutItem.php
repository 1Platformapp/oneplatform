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
        $download_url = null;
        
        if ($this->type == 'music' && $this->music != null) {
            $downloads = $this->music->downloads;
            if (is_string($downloads)) {
                $downloads = unserialize($downloads);
            }

            if (is_array($downloads)) {

                if (empty($downloads)) {
                    $download_url = 'array is empty';
                }
                
                foreach ($downloads as $download) {
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