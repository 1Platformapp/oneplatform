<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserProduct extends Authenticatable
{
    public function user()
    {
        return $this->belongsTo( User::class );
    }

    public function portfolio(){

    	return $this->hasOne(UserPortfolio::class, 'product_id');
    }

    public function setSpecialPriceAttribute($value)
    {
        $this->attributes['special_price'] = $value ? serialize($value) : NULL;
    }

    public function getSpecialPriceAttribute($value)
    {
        return $value ? unserialize($value) : null;
    }

    public function setDesignAttribute($value)
    {
        $this->attributes['design'] = $value ? serialize($value) : NULL;
    }

    public function getDesignAttribute($value)
    {
        return $value ? unserialize($value) : null;
    }

    public function getPriceAttribute($value){    

        $return = $value;
        if($this->special_price){
            date_default_timezone_set($this->special_price['timezone']);
            $specialPriceStartDateTime = $this->special_price['start_date_time'];
            $specialPriceEndDateTime = $this->special_price['end_date_time'];
            $now = strtotime(now());
            if(strtotime($specialPriceStartDateTime) < $now && $now < strtotime($specialPriceEndDateTime)){
                $return = $this->special_price['price'];
            }
        }

        return $return;
    }

    public function customProduct(){

        $return = false;

        if($this->type == 'custom' && $this->design && isset($this->design['product_id'])){

            $customProductId = $this->design['product_id'];
            $customProduct = \App\Models\CustomProduct::find($customProductId);
            return $customProduct;
        }

        return $return;
    }
}