<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ContributeDetail extends Authenticatable

{
    protected $table = 'contribute_details';
    
    public function user()

    {

        return $this->belongsTo( User::class );

    }


    public function customer()

    {

        return $this->belongsTo( User::class );

    }

    public function campaign()

    {

        return $this->belongsTo( userCampaign::class );

    }
}