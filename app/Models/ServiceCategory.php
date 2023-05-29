<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ServiceCategory extends Authenticatable
{
    public function services()
    {
        return $this->hasMany( Service::class, 'service_category_id' );
    }

}