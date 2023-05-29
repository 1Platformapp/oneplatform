<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Http\Controllers\CommonMethods;

class ContactQuestion extends Authenticatable
{
	protected $table = 'contact_questions';
	
    public function agentContact()
    {
        return $this->belongsTo( AgentContact::class );
    }

    public function elements()
    {
        return $this->hasMany( ContactQuestionElement::class)->orderBy('order', 'asc');
    }
}