

@if($chat->admin_join_chat)
<div class="chat_join">
    <div class="chat_join_in">
        1 Platform admin has joined this chat
    </div>
</div>
@else
<div class="chat_each_message {{$chat->admin ? 'msg_out' : 'msg_in'}} {{is_array($chat->agreement) && count($chat->agreement)?'msg_agreement':''}}">
    <div class="chat_message_pic">
        @if($chat->admin)
            <img src="{{asset('images/chat_logo.jpg')}}">
        @else
            {{strtoupper(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $chat->sender->name))))}}
        @endif
    </div>
    <div class="chat_message_det">
        <div class="chat_message_det_top">
            <div class="chat_message_name">{{$chat->admin ? 'Admin' : $chat->sender->name}}</div>
            <div class="chat_message_date">{{date('d-M-Y h:i A', strtotime($chat->created_at))}}</div>
        </div>
        <div class="chat_message_det_bottom">
            @if(is_array($chat->agreement) && count($chat->agreement))
            <a download href="{{asset('bespoke-licenses/'.$chat->agreement['filename'])}}">
                <i class="fa fa-file-pdf-o"></i>
                <div class="msg_agreement_det">
                    <div class="msg_agree_name">Agreement</div>
                    <div class="msg_agree_status {{strtolower($chat->agreement['status'])}}">{{$chat->agreement['status']}}</div>
                </div>
            </a>
            @else
            {{$chat->message}}
            @endif
        </div>
    </div>
</div>
@endif