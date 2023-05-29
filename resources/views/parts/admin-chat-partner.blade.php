


<div data-sender-id="{{$chat->sender->id}}" data-recipient-id="{{$chat->recipient->id}}" class="chat_each_user {{$counter == 0 ? 'active' : ''}}">
    <div class="chat_each_sender_sec">
        <div class="chat_user_pic">
            <img src="{{$commonMethods->getUserDisplayImage($chat->sender->id)}}" />
        </div>
        <div class="chat_user_det">
            <div class="chat_user_name">{{str_limit($chat->sender->name, 15)}}</div>
        </div>
        <div class="chat_user_status {{$chat->sender->activityStatus()}}">
            <i class="fa fa-circle"></i> 
            <span class="chat_user_status_txt">{{$chat->sender->activityStatus()}}</span>
        </div>
    </div>
    <div class="chat_each_recipient_sec">
        <div class="chat_user_pic">
            <img src="{{$commonMethods->getUserDisplayImage($chat->recipient->id)}}" />
        </div>
        <div class="chat_user_det">
            <div class="chat_user_name">{{str_limit($chat->recipient->name, 15)}}</div>
        </div>
        <div class="chat_user_status {{$chat->recipient->activityStatus()}}">
            <i class="fa fa-circle"></i> 
            <span class="chat_user_status_txt">{{$chat->recipient->activityStatus()}}</span>
        </div>
    </div>
</div>