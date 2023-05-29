<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\UserChat;

class CustomerBasket extends Authenticatable
{

    protected $table = 'customer_baskets';

    public function user()

    {

        return $this->belongsTo( User::class );

    }

    public function customer()

    {

        return $this->belongsTo( User::class );

    }

    public function product()

    {

        return $this->belongsTo( UserProduct::class );

    }

    public function music()

    {

        return $this->belongsTo( UserMusic::class );

    }

    public function album()

    {

        return $this->belongsTo( UserAlbum::class );

    }

    public function instantItemTitle(){

        $return = '';
        $explode = explode('_', $this->extra_info);
        $chatId = $explode[1];
        $chat = UserChat::find($chatId);

        if($chat){

            if(($this->purchase_type == 'project' || $this->purchase_type == 'instant-project') && is_array($chat->project) && count($chat->project) && isset($chat->project['title'])){
                $return = $chat->project['title'];
            }else if($this->purchase_type == 'instant-product' && is_array($chat->product) && count($chat->product) && isset($chat->product['id'])){
                $product = \App\Models\UserProduct::find($chat->product['id']);
                if($product){
                    $return = $product->title;
                }
            }else if($this->purchase_type == 'instant-license' && is_array($chat->agreement) && count($chat->agreement) && isset($chat->agreement['music'])){
                $music = \App\Models\UserMusic::find($chat->agreement['music']);
                if($music){
                    $return = $music->song_name;
                }
            }
        }

        return $return;
    }

    public function instantItemThumbnail(){

        $return = '';
        $explode = explode('_', $this->extra_info);
        $chatId = $explode[1];
        $chat = UserChat::find($chatId);

        if($chat){

            if($this->purchase_type == 'project' && is_array($chat->project) && count($chat->project) && isset($chat->project['title'])){
                $return = asset('images/proffered_project_cart.png');
            }else if($this->purchase_type == 'proferred-product' && is_array($chat->product) && count($chat->product) && isset($chat->product['id'])){
                $product = \App\Models\UserProduct::find($chat->product['id']);
                if($product){
                    $return = asset('user-product-thumbnails/'.$product->thumbnail_left);
                }
            }else if($this->purchase_type == 'instant-license' && is_array($chat->agreement) && count($chat->agreement) && isset($chat->agreement['music'])){
                $music = \App\Models\UserMusic::find($chat->agreement['music']);
                if($music){
                    $return = asset('user-music-thumbnails/'.$music->thumbnail_left);
                }
            }
        }

        return $return;
    }

    public function instantItemDescription(){

        $return = '';
        $explode = explode('_', $this->extra_info);
        $chatId = $explode[1];
        $chat = UserChat::find($chatId);

        if($chat){

            if($chat->project || $chat->product || $chat->agreement){
                $return = $chat->message;
            }
        }

        return $return;
    }

    public function instantItemFile(){

        $return = '';
        $explode = explode('_', $this->extra_info);
        $chatId = $explode[1];
        $chat = UserChat::find($chatId);

        if($chat){

            if(($this->purchase_type == 'project' || $this->purchase_type == 'instant-project') && is_array($chat->project) && count($chat->project) && isset($chat->project['filename'])){
                $return = $chat->project['filename'];
            }else if($this->purchase_type == 'instant-product' && is_array($chat->product) && count($chat->product) && isset($chat->product['filename'])){
                $return = $chat->product['filename'];
            }else if($this->purchase_type == 'instant-license' && is_array($chat->agreement) && count($chat->agreement) && isset($chat->agreement['filename'])){
                $return = $chat->agreement['filename'];
            }
        }

        return $return;
    }

    public function hasPriceDisparity(){

        $return = '';
        if($this->purchase_type == 'music'){

            $licenses = config('constants.licenses');
            $music = UserMusic::find($this->music_id);
            foreach ($licenses as $key1 => $license) {
                if($license['filename'] == $this->license){
                    $licenseName = $license['input_name'];
                }
            }
            if($this->license == 'Personal Use Only'){
                $licenseName = 'personal_use_only';
            }
            $itemPrice = $music->{$licenseName};
            //if(!$itemPrice || $itemPrice != $this->price){
            if($itemPrice != 0 && $itemPrice != $this->price){
                return true;
            }
        }else if($this->purchase_type == 'product'){
            
            $product = UserProduct::find($this->product_id);
            $itemPrice = $product->price;
            if($itemPrice != $this->price){
                return true;
            }
        }else if($this->purchase_type == 'album'){
            
            $album = UserAlbum::find($this->album_id);
            $itemPrice = $album->price;
            if(!$itemPrice || $itemPrice != $this->price){
                return true;
            }
        }else if($this->purchase_type == 'subscription'){
            
            $user = User::find($this->user_id);
            $itemPrice = $user->subscription_amount;
            if(!$itemPrice || $itemPrice != $this->price){
                return true;
            }
        }

        return false;
    }

    public function itemOriginalPrice(){

        $itemPrice = 'undefined';
        
        if($this->purchase_type == 'music'){

            $licenses = config('constants.licenses');
            $music = UserMusic::find($this->music_id);
            foreach ($licenses as $key1 => $license) {
                if($license['filename'] == $this->license){
                    $licenseName = $license['input_name'];
                }
            }
            if($this->license == 'Personal Use Only'){
                $licenseName = 'personal_use_only';
            }
            $itemPrice = $music->{$licenseName};
        }else if($this->purchase_type == 'product'){
            
            $product = UserProduct::find($this->product_id);
            $itemPrice = $product->price;
        }else if($this->purchase_type == 'album'){
            
            $album = UserAlbum::find($this->album_id);
            $itemPrice = $album->price;
        }else if($this->purchase_type == 'subscription'){
            
            $user = User::find($this->user_id);
            $itemPrice = $user->subscription_amount;
        }

        return $itemPrice;
    }

}