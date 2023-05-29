<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class AgentQuestionnaireAnswer extends Authenticatable

{
    
    protected $table = 'agent_questionnaire_answers';
    
    public function questionnaire(){

        return $this->belongsTo( AgentQuestionnaire::class, 'id', 'agent_questionnaire_id' );
    }

    public function answers(){

        return $this->hasMany( AgentQuestionnaireAnswerElement::class, 'agent_questionnaire_answer_id', 'id' )->orderBy('id', 'asc');
    }

}
