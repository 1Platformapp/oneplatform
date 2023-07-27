<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Mail\Agent;

use Storage;
use Image;
use Mail;
use Auth;

class UserChat extends Authenticatable
{
    public function recipient()
    {

        return $this->hasOne( User::class, 'id', 'recipient_id' );

    }


    public function sender()
    {

        return $this->hasOne( User::class, 'id', 'sender_id' );

    }

    public function admin()
    {

        return $this->hasOne( User::class, 'id', 'admin_id' );

    }

    public function music()
    {

        return $this->belongsTo(UserMusic::class);

    }

    public function group()
    {

        return $this->hasOne(UserChatGroup::class, 'id', 'group_id');

    }

    public function setAgreementAttribute($value)
    {
        $this->attributes['agreement'] = serialize($value);
    }

    public function getAgreementAttribute($value)
    {
        return $value ? array_filter(unserialize($value)) : [];
    }

    public function setProjectAttribute($value)
    {
        $this->attributes['project'] = serialize($value);
    }

    public function getProjectAttribute($value)
    {
        return $value ? array_filter(unserialize($value)) : [];
    }

    public function setProductAttribute($value)
    {
        $this->attributes['product'] = serialize($value);
    }

    public function getProductAttribute($value)
    {
        return $value ? array_filter(unserialize($value)) : [];
    }

    public function isSuspicious(){

        $return = 0;
        $matches = array('1platform', 'charges', 'credit', 'card', 'phone', 'contact', 'telephone', 'mobile', 'skype', 'whatsapp', 'imo', 'email', 'instagram', 'fraud', 'commission', 'stripe', 'sex', 'porn', 'gay', 'lesbian', 'erotic', 'fuck', 'fucking', 'screw', 'lust', 'foreplay', 'bang', 'intercourse', 'intimate', 'ass', 'breast', 'boob', 'penis', 'dick', 'blowjob', 'girlfriend', 'boyfriend', 'dickhead', 'pissoff', 'asshole', 'bitch', 'bastard', 'damn', 'cunt', 'pimp', 'slut', 'whore', 'bank', 'account', 'number', 'iban');

        $explode = explode(' ', trim($this->message));
        if(count($explode)){
            foreach ($explode as $key => $word) {

                $word = strtolower($word);

                // checking if the word signals a potential attempt to share contact details
                if(in_array($word, $matches)){
                    $return = 1;
                }

                // checking if the word is a credit card number
                if(!$return && preg_match('/^[0-9]{16}$/', $word)){
                    $word = preg_replace('/\D/', '', $word);
                    $numberLength = strlen($word);
                    $parity = $numberLength % 2;
                    $total = 0;
                    for($i = 0; $i < $numberLength; $i++) {
                        $digit = $word[$i];
                        if ($i % 2 == $parity) {
                            $digit*=2;
                            if ($digit > 9) {
                                $digit -= 9;
                            }
                        }
                        $total += $digit;
                    }
                    $return = ($total % 10 == 0) ? TRUE : $return;
                }
            }
        }

        return $return;
    }

    public function setSeenAttribute($value)
    {
        $this->attributes['seen'] = serialize($value);
    }

    public function getSeenAttribute($value)
    {
        return $value ? array_filter(unserialize($value)) : [];
    }

    public function setAttachmentsAttribute($value)
    {
        $this->attributes['attachments'] = serialize($value);
    }

    public function getAttachmentsAttribute($value)
    {
        return $value && unserialize($value) ? array_filter(unserialize($value)) : [];
    }

    public function attachFile($file)
    {
        $success = false;

        $extension = $file->getClientOriginalExtension();
        if($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'PNG'){

            $uniqueId = uniqid();
            $filePath = public_path('chat-attachments/'.$uniqueId.'.'.$extension);
            Image::make($file)->save($filePath, 70);
            $attachments = $this->attachments;
            $attachments[] = ['type' => 'image', 'mime' => $file->getClientMimeType(), 'filename' => $uniqueId.'.'.$extension, 'download_link' => '', 'size' => $file->getSize()];
            $this->attachments = $attachments;
            $this->save();
            $success = true;
        }else{
            $dir = '/';
            $recursive = false;
            $filename = 'chat_attachment_'.$this->id;
            $filePath = $file;
            Storage::disk('google')->put($filename.'.'.$extension, fopen($filePath, 'r+'));
            $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
            $cloudFile = $contents->where('type', '=', 'file')->where('filename', '=', $filename)->first();
            $attachments = $this->attachments;
            $attachments[] = ['type' => 'cloud', 'mime' => $cloudFile['mimetype'], 'filename' => $filename, 'download_link' => $cloudFile['path'], 'size' => $cloudFile['size']];
            $this->attachments = $attachments;
            $this->save();
            $success = true;
        }

        return $success;
    }

    public function sendNotifications(){

        $sender = Auth::user();
        $recipient = $this->recipient;
        $group = $this->group;

        if(!$recipient && !$group){

            return 'no known recipient or group';
        }

        if($group){
            $currentChat = UserChat::where(['group_id' => $this->group_id])->whereNotIn('id', [$this->id])->orderBy('id', 'desc')->get();
        }else if($recipient){
            $currentChat = UserChat::where(['recipient_id' => $this->recipient_id, 'sender_id' => $sender->id])->whereNotIn('id', [$this->id])->orderBy('id', 'desc')->get();
        }

        if($recipient){

            $recipients = [$recipient];
        }else if($group){

            $recipients = $notifMembers = [];
            $notifMembers[] = $group->agent_id;
            $notifMembers[] = $group->contact_id;
            if(count($group->other_members)){
                $notifMembers = array_merge($notifMembers,$group->other_members);
            }
            if(($key = array_search($sender->id, $notifMembers)) !== false) {
                unset($notifMembers[$key]);
            }
            foreach ($notifMembers as $value) {
                $recip = User::find($value);
                $recipients[] = $recip;
            }
        }

        if(count($recipients)){

            foreach ($recipients as $recip) {

                $diffMins = isset($currentChat) && $currentChat->first() ? $currentChat->first()->created_at->diffInMinutes() : 0;
                if($diffMins >= 15){
                    $result = Mail::to($recip->email)->bcc(Config('constants.bcc_email'))->send(new Agent($this));
                    $recip->sendAppNotifications('Message from '.$sender->firstName(), str_limit($this->message, 24));
                }

                $recip->sendWebNotification($sender->id, $this->id);
            }
        }

        return 'success';
    }
}
