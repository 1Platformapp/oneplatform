<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgentQuestionnaireElement extends Authenticatable
{
	protected $table = 'agent_questionnaire_elements';

    public function questionnaire(){

        return $this->belongsTo( AgentQuestionnaire::class, 'id', 'agent_questionnaire_id' );
    }

}