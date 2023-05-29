<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Http\Controllers\CommonMethods;

class UserPortfolio extends Authenticatable
{
    public function user()
    {
        return $this->belongsTo( User::class );
    }

    public function elements()
    {
        return $this->hasMany( PortfolioElement::class, 'portfolio_id' )->orderBy('order', 'asc');
    }

    public function displayImage(){

    	if($this->thumbnail && CommonMethods::fileExists(public_path('portfolio-images/').$this->thumbnail)){

    		return $this->thumbnail;
    	}

    	return 'def.jpg';
    }

    public function product(){

        return $this->belongsTo(UserProduct::class, 'product_id');
    }
}