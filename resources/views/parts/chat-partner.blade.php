
@if(isset($preloadId) && $preloadId == $user->id)
    @php $active = 1 @endphp
@elseif($firstEver)
    @php $active = 1 @endphp
@else
    @php $active = 0 @endphp
@endif

@if($first)
    <div class="chat_partition_each">
        <div class="chat_partition_head">
            Your Personal Chats 
        </div>
    </div>
    <div class="chat_partners_outer">
@endif

<div data-partner="{{$user->id}}" class="chat_each_user {{$active ? 'active' : ''}}">
    <div class="chat_user_pic">
        <a target="_blank" href="{{route('user.home',['params' => $user->username])}}">
            <img src="{{$commonMethods->getUserDisplayImage($user->id)}}" />
        </a>
        <div class="chat_user_status hide_on_desktop {{$user->activityStatus()}}">
            <i class="fa fa-circle"></i>
        </div>
    </div>
    <div class="chat_user_det">
        <div class="chat_user_name">
            <a target="_blank" href="{{route('user.home',['params' => $user->username])}}">{{$user->name}}</a>
        </div>
        <div class="chat_user_sh_message">{{$partnerChatNote}}</div>
    </div>
    <div class="chat_user_date">
    	{{date('Y') == date('Y', strtotime($partnerChatDate)) ? date('d M', strtotime($partnerChatDate)) : date('d M Y', strtotime($partnerChatDate))}}
    </div>
    <div class="chat_user_status hide_on_mobile {{$user->activityStatus()}}">
        <i class="fa fa-circle"></i> 
        <span class="chat_user_status_txt">{{$user->activityStatus()}}</span>
    </div>
    @php $unApprCont = Auth::user()->hasUnapprovedContact($user) @endphp
    @if($unApprCont)
    <div class="chat_user_link">
        <a target="_blank" href="{{route('agent.contact.details',['code' => $unApprCont->code])}}"><i class="fa fa-file-text-o"></i></a>
    </div>
    @endif
</div>

@if($last)
    </div>
@endif