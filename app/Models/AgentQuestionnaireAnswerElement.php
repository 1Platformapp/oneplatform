<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgentQuestionnaireAnswerElement extends Authenticatable
{
	protected $table = 'agent_questionnaire_answer_elements';
	
    public function questionnaireAnswer(){

        return $this->belongsTo( AgentQuestionnaireAnswer::class, 'id', 'agent_questionnaire_answer_id' );
    }

}