<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class UserChatGroup extends Model
{
    public function agent()
    {

        return $this->hasOne( User::class, 'id', 'agent_id' );

    }

    public function contact()
    {

        return $this->hasOne( User::class, 'id', 'contact_id' );

    }

    public function otherAgent()
    {

        return $this->hasOne( User::class, 'id', 'other_agent_id' );

    }

    public function chatMessages()
    {

        return $this->hasMany( UserChat::class, 'group_id', 'id' );

    }

    public function setOtherMembersAttribute($value)
    {
        $this->attributes['other_members'] = serialize($value);
    }

    public function getOtherMembersAttribute($value)
    {
        $r = unserialize($value);
        return is_array($r) ? array_filter($r) : [];
    }

    public function mergePersonalChat(){

        $chats = UserChat::where(['sender_id' => $this->agent->id, 'recipient_id' => $this->contact->id])->orWhere(['sender_id' => $this->contact->id, 'recipient_id' => $this->agent->id])->get();
        if(count($chats)){
            foreach($chats as $key => $chat){
                if(count($chat->agreement) == 0 && count($chat->project) == 0 && count($chat->product) == 0){
                    $chat->recipient_id = NULL;
                }
                $chat->group_id = $this->id;
                //$chat->save();
            }
        }
    }
}