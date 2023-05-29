<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgentContactRequest extends Authenticatable
{
	protected $table = 'agent_contact_requests';
	
    public function contactUser(){
        return $this->hasOne( User::class, 'id', 'contact_user_id' );
    }

    public function agentUser(){
        return $this->hasOne( User::class, 'id', 'agent_user_id' );
    }

}