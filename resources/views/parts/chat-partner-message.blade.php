
@if($chat->admin_join_chat)
<div class="chat_join">
    <div class="chat_join_in">
        1 Platform admin has joined this chat
    </div>
</div>
@elseif($chat->admin)
<div class="chat_each_message msg_in">
    <div class="chat_message_pic">
        <img src="{{asset('images/chat_logo.jpg')}}">
    </div>
    <div class="chat_message_det">
        <div class="chat_message_det_top">
            <div class="chat_message_name">Admin</div>
            <div class="chat_message_date">{{date('d-M-Y h:i A', strtotime($chat->created_at))}}</div>
        </div>
        <div class="chat_message_det_bottom">
            {{$chat->message}}
        </div>
    </div>
</div>
@else

@php $isFile = (is_array($chat->product) && count($chat->product)) || (is_array($chat->project) && count($chat->project)) || (is_array($chat->agreement) && count($chat->agreement)) ? 1 : 0 @endphp
<div data-cursor="{{$chat->id}}" class="chat_each_message {{Auth::user()->id == $chat->sender->id ? 'msg_out' : 'msg_in'}} {{$isFile?'msg_agreement':''}}">
    <div class="chat_message_pic">
        {{strtoupper(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $chat->sender->name))))}}
    </div>
    <div class="chat_message_det {{Auth::user()->id == $chat->sender->id ? 'sender' : 'reciever'}}">
        <div class="chat_message_det_top">
            <div class="font-bold text-16">{{$chat->sender->name}}</div>
            <div class="chat_message_date">{{date('d-M-Y h:i A', strtotime($chat->created_at))}}</div>
        </div>
        <div class="text-white chat_message_det_bottom text-14">
            @if(is_array($chat->agreement) && count($chat->agreement))
                <a download href="{{asset('bespoke-licenses/'.$chat->agreement['filename'])}}">
                    <i class="fa fa-file-pdf-o"></i>
                    <div class="msg_agreement_det">
                        <div class="msg_agree_status {{strtolower($chat->agreement['status'])}}">{{$chat->agreement['status']}}</div>
                        <div class="msg_agree_name">LICENSE</div>
                    </div>
                </a>
                @php $price = isset($chat->agreement['price']) ? $chat->agreement['price'] : 0 @endphp
                @php $music = isset($chat->agreement['music']) ? $chat->agreement['music'] : 0 @endphp
                @if(Auth::user()->id == $chat->recipient->id && $chat->agreement['status'] == 'Pending')
                <div class="msg_agreement_actions">
                    <div onclick="chatPurchaseAction(this, 'instant-license', 'Accepted', '{{$chat->id}}', '{{base64_encode($chat->sender->profile->stripe_user_id)}}', '{{$chat->sender->id}}', '{{base64_encode($price)}}', '{{base64_encode($music)}}');return false;" id="msg_agree_accept" class="agree_status_btn">Accept</div>
                    <div onclick="chatPurchaseAction(this, 'instant-license', 'Declined', '{{$chat->id}}', '', '{{$chat->sender->id}}', '{{base64_encode($price)}}', '{{base64_encode($music)}}');return false;" id="msg_agree_decline" class="agree_status_btn">Decline</div>
                </div>
                @elseif(Auth::user()->id == $chat->recipient->id && $chat->agreement['status'] == 'Accepted')
                <div class="msg_agreement_actions">
                    <div onclick="chatPurchaseAction(this, 'instant-license', 'addToCart', '{{$chat->id}}', '{{base64_encode($chat->sender->profile->stripe_user_id)}}', '{{$chat->sender->id}}', '{{base64_encode($price)}}', '{{base64_encode($music)}}');return false;" id="msg_agree_add" class="agree_status_btn">
                        Add to cart
                    </div>
                </div>
                @endif
            @elseif(is_array($chat->project) && count($chat->project))
                <a download href="{{asset('proffered-project/'.$chat->project['filename'])}}">
                    <i class="fa fa-file-pdf-o"></i>
                    <div class="msg_agreement_det">
                        <div class="msg_agree_status {{strtolower($chat->project['status'])}}">{{$chat->project['status']}}</div>
                        <div class="msg_agree_name">PROJECT</div>
                    </div>
                </a>
                @php $price = isset($chat->project['price']) ? $chat->project['price'] : 0 @endphp
                @if(Auth::user()->id == $chat->recipient->id && $chat->project['status'] == 'Pending')
                <div class="msg_agreement_actions">
                    <div onclick="chatPurchaseAction(this, 'project', 'Accepted', '{{$chat->id}}', '{{base64_encode($chat->sender->profile->stripe_user_id)}}', '{{$chat->sender->id}}', '{{base64_encode($price)}}');return false;" id="msg_agree_accept" class="agree_status_btn">Accept</div>
                    <div onclick="chatPurchaseAction(this, 'project', 'Declined', '{{$chat->id}}', '', '{{$chat->sender->id}}', '{{base64_encode($price)}}');return false;" id="msg_agree_decline" class="agree_status_btn">Decline</div>
                </div>
                @elseif(Auth::user()->id == $chat->recipient->id && $chat->project['status'] == 'Accepted')
                <div class="msg_agreement_actions">
                    <div onclick="chatPurchaseAction(this, 'project', 'addToCart', '{{$chat->id}}', '{{base64_encode($chat->sender->profile->stripe_user_id)}}', '{{$chat->sender->id}}', '{{base64_encode($price)}}');return false;" id="msg_agree_add" class="agree_status_btn">
                        Add to cart
                    </div>
                </div>
                @endif
            @elseif(is_array($chat->product) && count($chat->product))
                <a download href="{{asset('proffered-product/'.$chat->product['filename'])}}">
                    <i class="fa fa-file-pdf-o"></i>
                    <div class="msg_agreement_det">
                        <div class="msg_agree_status {{strtolower($chat->product['status'])}}">{{$chat->product['status']}}</div>
                        <div class="msg_agree_name">PRODUCT</div>
                    </div>
                </a>
                @php $price = isset($chat->product['price']) ? $chat->product['price'] : 0 @endphp
                @php $productId = $chat->product['id'] @endphp
                @if(Auth::user()->id == $chat->recipient->id && $chat->product['status'] == 'Pending')
                <div class="msg_agreement_actions">
                    <div onclick="chatPurchaseAction(this, 'proferred-product', 'Accepted', '{{$chat->id}}', '{{base64_encode($chat->sender->profile->stripe_user_id)}}', '{{$chat->sender->id}}', '{{base64_encode($price)}}', '{{$productId}}');return false;" id="msg_agree_accept" class="agree_status_btn">Accept</div>
                    <div onclick="chatPurchaseAction(this, 'proferred-product', 'Declined', '{{$chat->id}}', '', '{{$productId}}', '{{$chat->sender->id}}', '{{base64_encode($price)}}');return false;" id="msg_agree_decline" class="agree_status_btn">Decline</div>
                </div>
                @elseif(Auth::user()->id == $chat->recipient->id && $chat->product['status'] == 'Accepted')
                <div class="msg_agreement_actions">
                    <div onclick="chatPurchaseAction(this, 'proferred-product', 'addToCart', '{{$chat->id}}', '{{base64_encode($chat->sender->profile->stripe_user_id)}}', '{{$chat->sender->id}}', '{{base64_encode($price)}}', '{{$productId}}');return false;" id="msg_agree_add" class="agree_status_btn">
                        Add to cart
                    </div>
                </div>
                @endif
            @else
                @php $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@' @endphp
                @php $message = preg_replace($url, '<a class="user_message_hyp" href="$0" target="_blank" title="Click here">$0</a>', $chat->message); @endphp
                <div>{!! nl2br($message) !!}</div>
                @if($chat->attachments && count($chat->attachments))
                <div class="attachment_visi">
                    @foreach($chat->attachments as $attach)
                    @if($attach['type'] == 'image')
                    <div data-type="{{$attach['type']}}" class="each_attach_visi">
                        <img src="{{asset('chat-attachments/'.$attach['filename'])}}" />
                    </div>
                    @else
                    <div data-download="{{$attach['download_link']}}" data-type="{{$attach['type']}}" class="each_attach_visi cloud">
                        <div class="up">{{$attach['mime']}}</div>
                        <div class="down">
                            <i class="fa fa-download"></i>
                            <div class="attach_size">
                                {{round($attach['size']/(1024*1024)) > 0 ? round($attach['size']/(1024*1024)).' MB' : round($attach['size']/(1024)).' KB'}}
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endif


<style scoped>

.sender {
    background-color: #128C7E;
    border-radius: 10px;
    padding: 7px;
    color: white;
}

.reciever {
    background-color: #435A64;
    border-radius: 10px;
    padding: 7px;
    color: white;
}

</style>