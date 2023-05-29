<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SiteProgramElement extends Authenticatable
{
    public function siteProgram()
    {
        return $this->belongsTo( SiteProgram::class, 'program_id', 'id' );
    }
}