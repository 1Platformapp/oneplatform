
@if(Auth::user()->id == $group->agent_id)
	@php $userr = $group->contact @endphp
@else
	@php $userr = $group->agent @endphp
@endif

@if($first == 1)
    <div class="chat_partners_outer chat_group_partners">
@endif

@if(isset($preloadId) && $preloadId == $group->id)
    @php $active = 1 @endphp
@elseif($firstEver)
    @php $active = 1 @endphp
@else
    @php $active = 0 @endphp
@endif

@if($userr)
<div data-group="{{$group->id}}" class="chat_each_user chat_each_group {{$active ? 'active' : ''}}">
    <div class="inner">
    	<div data-id="{{$userr->id}}" data-name="{{$userr->name}}" class="chat_user_pic">
    	    <a target="_blank" href="{{route('user.home',['params' => $userr->username])}}">
                <img src="{{$commonMethods->getUserDisplayImage($userr->id)}}" />
            </a>
            <div class="chat_user_status chat_group_member_status {{$userr->activityStatus()}}">
                <i class="fa fa-circle"></i>
            </div>
    	</div>
    	<div class="chat_user_det">
    	    <div class="chat_user_name">
                <a target="_blank" href="{{route('user.home',['params' => $userr->username])}}">{{$userr->name}}</a>
            </div>
            @if(($group->contact && Auth::user()->id == $group->contact_id) || (Auth::user()->id == $group->agent_id))
                @php $realContact = \App\Models\AgentContact::where(['contact_id' => $group->contact_id, 'agent_id' => $group->agent_id])->first() @endphp
                @if($realContact)
                <div class="chat_user_link">
                    <a target="_blank" href="{{route('agent.contact.details',['code' => $realContact->code])}}"><i class="fa fa-file-text-o"></i></a>
                </div>
                @endif
            @endif
    	</div>
    </div>
    <div class="chat_user_members">
    	@if(Auth::user()->id == $group->agent_id)
    	   @include('parts.group-chat-member', ['add' => '1'])
    	@endif
        @if(Auth::user()->id == $group->contact_id)
            @include('parts.group-chat-member', ['group' => $group, 'member' => $group->contact, 'commonMethods' => $commonMethods])
        @endif
        @if(Auth::user()->id != $group->agent_id && Auth::user()->id != $group->contact_id)
            @include('parts.group-chat-member', ['group' => $group, 'member' => $group->contact, 'commonMethods' => $commonMethods])
        @endif
    	@if(is_array($group->other_members) && count($group->other_members))
    		@foreach($group->other_members as $memberId)

    			@php $member = \App\Models\User::find($memberId) @endphp
    			@if(!$member) @php continue @endphp @endif
                @include('parts.group-chat-member', ['group' => $group, 'member' => $member, 'commonMethods' => $commonMethods])
    		@endforeach
	    @endif
        @if($group->otherAgent)
            @include('parts.group-chat-member', ['group' => $group, 'member' => $group->otherAgent, 'commonMethods' => $commonMethods])
        @endif
    </div>
</div>
@endif

@if($key == ($length - 1))
    </div>
@endif