<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CalendarEvent extends Authenticatable
{
    public function participants()
    {
        return $this->hasMany(CalendarEventParticipant::class)->orderBy('id', 'asc');
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
