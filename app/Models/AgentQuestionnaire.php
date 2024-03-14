<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgentQuestionnaire extends Authenticatable

{
    protected $fillable = [
        'brief_id'
    ];

    protected $table = 'agent_questionnaires';
    
    public function agent(){

        return $this->belongsTo( User::class, 'id', 'agent_id' );
    }

    public function questions(){

        return $this->hasMany( AgentQuestionnaireElement::class, 'agent_questionnaire_id' )->orderBy('id', 'asc');
    }

    public function answers(){

        return $this->hasMany( AgentQuestionnaireAnswer::class, 'agent_questionnaire_id' )->orderBy('id', 'asc');
    }

}
