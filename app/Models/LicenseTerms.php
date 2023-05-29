<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LicenseTerms extends Authenticatable
{

    public function setTermsAttribute($value)
    {
        $this->attributes['terms'] = serialize($value);
    }

    public function getTermsAttribute($value)
    {
        return $value ? array_filter(unserialize($value)) : [];
    }

}