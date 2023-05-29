<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class CustomProduct extends Authenticatable
{

    protected $tabel = 'custom_products';
    
    public function getColorsAttribute($value)
    {
        return unserialize($value);
    }


    public function setColorsAttribute($value)
    {
        $this->attributes['colors'] = serialize($value);
    }

    public function getSizesAttribute($value)
    {
        return $value ? unserialize($value) : null;
    }

    public function setSizesAttribute($value)
    {
        $this->attributes['sizes'] = $value ? serialize($value) : NULL;
    }

    public function getDeliveryCostAttribute($value)
    {
        return $value ? unserialize($value) : null;
    }

    public function setDeliveryCostAttribute($value)
    {
        $this->attributes['delivery_cost'] = $value ? serialize($value) : NULL;
    }

}