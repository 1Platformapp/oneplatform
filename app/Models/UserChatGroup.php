<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\CommonMethods;
use Auth;

class UserChatGroup extends Authenticatable
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

        $chats = UserChat::where(function ($query) {
                    $query->where('sender_id', $this->agent->id)
                          ->where('recipient_id', $this->contact->id);
                })->orWhere(function ($query) {
                    $query->where('sender_id', $this->contact->id)
                          ->where('recipient_id', $this->agent->id);
                })->get();
        if(count($chats)){
            foreach($chats as $key => $chat){
                if(count($chat->agreement) == 0 && count($chat->project) == 0 && count($chat->product) == 0){
                    $chat->recipient_id = NULL;
                }
                $chat->group_id = $this->id;
                $chat->save();
            }
        }
    }

    public function getGroupMembers(){

        $return = '';
        $agent = $this->agent;
        $artist = $this->contact;
        $user = Auth::user();
        $commonMethods = new CommonMethods();

        if($agent && $artist){

            if($user->id == $agent->id){
                $return .= \View::make('parts.group-chat-member', ['add' => '1', 'group' => $this]);
            }
            if($user->id == $artist->id){
                $return .= \View::make('parts.group-chat-member', ['group' => $this, 'member' => $artist, 'commonMethods' => $commonMethods]);
            }
            if($user->id != $agent->id && $user->id != $artist->id){
                $return .= \View::make('parts.group-chat-member', ['group' => $this, 'member' => $artist, 'commonMethods' => $commonMethods]);
            }
            if(is_array($this->other_members) && count($this->other_members)){
                foreach($this->other_members as $memberId){

                    $member = User::find($memberId);
                    if(!$member) {
                        continue;
                    }
                    $return .= \View::make('parts.group-chat-member', ['group' => $this, 'member' => $member, 'commonMethods' => $commonMethods]);
                }
            }
            if($this->otherAgent){
                $return .= \View::make('parts.group-chat-member', ['group' => $this, 'member' => $this->otherAgent, 'commonMethods' => $commonMethods]);
            }
        }

        return $return;
    }
}
