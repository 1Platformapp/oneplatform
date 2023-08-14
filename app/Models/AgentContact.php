<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;

class AgentContact extends Authenticatable
{
    protected $table = 'agent_contacts';

    public function contactUser(){
        return $this->hasOne( User::class, 'id', 'contact_id' );
    }

    public function agentUser(){
        return $this->hasOne( User::class, 'id', 'agent_id' );
    }

    public function questions(){
        return $this->hasMany( ContactQuestion::class )->orderBy('order', 'asc');
    }

    public function contracts(){
        return $this->hasMany( Contract::class );
    }

    public function generateCode(){

    	$pool = '0123456789abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
    	$length = 4;
    	$code1 = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    	$code2 = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    	$code3 = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    	$code4 = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);

    	return strtoupper($code1.'-'.$code2.'-'.$code3.'-'.$code4);
    }

}
