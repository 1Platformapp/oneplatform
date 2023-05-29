<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Service extends Authenticatable
{
        
    public function category()
    {
        return $this->belongsTo( ServiceCategory::class, 'service_category_id' );
    }

}
