<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PortfolioElement extends Authenticatable
{
    public function portfolio()
    {
        return $this->belongsTo( UserPortfolio::class );
    }
}