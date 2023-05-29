<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AgentTransfer extends Authenticatable
{

    protected $table = 'agent_transfers';
    
    public function agent()
    {

        return $this->hasOne( User::class, 'id', 'agent_id' );

    }


    public function decodeDescription(){

    	$return = [
    		'agent' => ['id' => '', 'name' => '', 'percent' => ''], 
    		'buyer' => ['id' => '', 'name' => ''], 
    		'seller' => ['id' => '', 'name' => ''],
    	];

    	if($this->description){
    		$levelOne = explode('. ', $this->description);
    		$return['head'] = $levelOne[0];
    		if(isset($levelOne['1'])){
    			$agentInfo = explode(' - ',$levelOne['1']);
    			$agentIdInfo = explode(': ', $agentInfo[0]);
    			$return['agent']['id'] = $agentIdInfo[1];
    			$return['agent']['name'] = $agentInfo[1];
    			$return['agent']['percent'] = $agentInfo[2];
    		}
    		if(isset($levelOne['2'])){
    			$buyerInfo = explode(' - ',$levelOne['2']);
    			$buyerIdInfo = explode(': ', $buyerInfo[0]);
    			$return['buyer']['id'] = $buyerIdInfo[1];
    			$return['buyer']['name'] = $buyerInfo[1];
    		}
    		if(isset($levelOne['3'])){
    			$sellerInfo = explode(' - ',$levelOne['3']);
    			$sellerIdInfo = explode(': ', $sellerInfo[0]);
    			$return['seller']['id'] = $sellerIdInfo[1];
    			$return['seller']['name'] = $sellerInfo[1];
    		}
    	}

    	return $return;
    }

}