<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CalendarEventParticipant extends Authenticatable
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calendarEvent()
    {
        return $this->belongsTo(CalendarEvent::class);
    }
}
