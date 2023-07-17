<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgencyContract extends Authenticatable
{

    public function contactUser(){
        return $this->hasOne( User::class, 'id', 'contact_id' );
    }

    public function agentUser(){
        return $this->hasOne( User::class, 'id', 'agent_id' );
    }

    public function contract(){
        return $this->belongsTo( Contract::class );
    }

    public function contact(){
        return $this->belongsTo( AgentContact::class );
    }

    public function setSignaturesAttribute($value){
        $this->attributes['signatures'] = serialize($value);
    }

    public function getSignaturesAttribute($value)
    {
        return $value && unserialize($value) ? array_filter(unserialize($value)) : [];
    }

    public function setContractDetailsAttribute($value){
        $this->attributes['contract_details'] = serialize($value);
    }

    public function getContractDetailsAttribute($value)
    {
        return $value && unserialize($value) ? array_filter(unserialize($value)) : [];
    }

    public function setLegalNamesAttribute($value){
        $this->attributes['legal_names'] = serialize($value);
    }

    public function getLegalNamesAttribute($value)
    {
        return $value && unserialize($value) ? array_filter(unserialize($value)) : [];
    }
}
