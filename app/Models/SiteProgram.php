<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SiteProgram extends Authenticatable
{
    protected $table = 'site_programmes';

    public function elements()
    {
        return $this->hasMany( SiteProgramElement::class, 'program_id', 'id' )->orderBy('order', 'asc');
    }

    public function displayImage(){

        if($this->thumbnail){

            return $this->thumbnail;
        }

        return 'site-def.jpg';
    }
}