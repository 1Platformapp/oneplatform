

@if(isset($add))

	<div title="Add a contact in this chat" class="chat_member_each_outer chat_member_add" data-id="{{isset($group) ? $group->id : ''}}">
		<div class="chat_member_each">
			<i class="fa fa-plus"></i>
		</div>
	</div>
@else

	<div data-name="{{$member->name}}" data-member="{{$member->id}}" class="chat_member_each_outer">
		@if(Auth::user()->id == $group->agent_id && $group->other_agent_id != $member->id)
		<div class="chat_member_remove">
			<i class="fa fa-times-circle"></i>
		</div>
		@endif
		<div class="chat_member_each">
		    <img src="{{$commonMethods->getUserDisplayImage($member->id)}}">
		    <div class="chat_user_status chat_group_member_status {{$member->activityStatus()}}">
		    	<i class="fa fa-circle"></i>
		    </div>
		</div>
		<div class="chat_member_name">
		    {{str_limit($member->namePartOne(), 7)}}
		</div>
	</div>

@endif
