<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ContactQuestionElement extends Authenticatable
{
	protected $table = 'contact_question_elements';
	
    public function contactQuestion()
    {
        return $this->belongsTo( ContactQuestion::class );
    }
}