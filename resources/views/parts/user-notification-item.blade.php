
@if(isset($notification) && $notification != 'none')

	@if($notification->type != 'system' && $notification->customer)
		@if($notification->type == 'sale')
			@php $tab = 'orders' @endphp
		@else
			@php $tab = '' @endphp
		@endif

		@if($notification->type == 'agent_form_filled')
			@php $contact = \App\Models\AgentContact::find($notification->source_table_id) @endphp
			@php $customLink = $contact ? route('agent.contact.details', ['code' => $contact->code]) : '' @endphp
		@elseif($notification->type == 'retry_failed_payment')
			@php $customLink = route('payment.failed.retry', ['id' => $notification->source_table_id]) @endphp
		@elseif($notification->type == 'contact_questionnaire')
			@php $contact = \App\Models\AgentContact::find($notification->source_table_id) @endphp
			@php $customLink = $contact ? route('agent.contact.details', ['code' => $contact->code]) : '' @endphp
		@elseif($notification->type == 'agent_group_member_remove')
			@php $contactUser = \App\Models\User::find($notification->source_table_id) @endphp
		@elseif($notification->type == 'agent_group_member_add')
			@php $group = \App\Models\UserChatGroup::find($notification->source_table_id) @endphp
		@elseif($notification->type == 'music_license_verification')
			@php $user = \App\Models\User::find($notification->source_table_id) @endphp
			@php $customLink = 'https://www.duong.1platform.tv/admin/users/music-license-approval' @endphp
		@elseif($notification->type == 'chat')
			@php $customLink = route('agency.dashboard') @endphp
		@elseif($notification->type == 'new_user_to_platform_manager')
			@php $user = \App\Models\User::find($notification->source_table_id) @endphp
			@php $customLink = 'https://www.duong.1platform.tv/admin/users' @endphp
        @elseif($notification->type == 'contract_created')
			@php $customLink = route('agency.dashboard') @endphp
        @elseif($notification->type == 'contract_approved_for_agent' || $notification->type == 'contract_approved_for_contact')
			@php $customLink = route('agency.dashboard') @endphp
            @php $contract = \App\Models\AgencyContract::find($notification->source_table_id) @endphp
		@endif

		<div data-id="{{$notification->id}}" data-type="{{$notification->type}}" data-link="{{isset($customLink) && $customLink != '' ? $customLink : ($tab != '' ? route('profile.with.tab',['tab' => $tab]) : route('agency.dashboard')) }}" class="each_usr_notif_item">
		    <div class="usr_notif_item_avatar">
		        <img alt="user notification" src="{{$commonMethods->getUserDisplayImage($notification->customer->id)}}" />
		    </div>
		    <div class="usr_notif_item_det">
		        <div class="usr_notif_det_text">
		            @if($notification->type == 'follow')
		            	{{$notification->customer->name}} is following you
		            @elseif($notification->type == 'sale')
		            	{{$notification->customer->name}} has purchased from you
		            @elseif($notification->type == 'chat')
		            	{{$notification->customer->name}} has sent a message
		            @elseif($notification->type == 'contact_approved_for_agent')
		            	{{$notification->customer->name}} has approved agreement with your agency
		            @elseif($notification->type == 'contact_approved_for_contact')
		            	{{$notification->customer->name}} is now your 1Platform agent
		            @elseif($notification->type == 'agent_form_filled')
		            	{{$notification->customer->name}} has made changes to the information form
		            @elseif($notification->type == 'agent_contact_request')
		            	{{$notification->customer->name}} has requested to join your agency
		            @elseif($notification->type == 'contact_left_agent')
		            	{{$notification->customer->name}} has left your agency
		            @elseif($notification->type == 'retry_failed_payment')
		            	Your payment to {{$notification->customer->name}} has failed
		            @elseif($notification->type == 'contact_questionnaire')
		            	Your agent has sent a questionnaire for you
		            @elseif($notification->type == 'agent_group_member_add')
		            	You have been added in a group with {{$group && $group->contact ? $group->contact->name : 'N/A'}}
		            @elseif($notification->type == 'agent_group_member_remove')
		            	You have been removed from a group {{$contactUser ? 'with '.$contactUser->name : ''}}
		            @elseif($notification->type == 'music_license_verification')
		            	{{$user->name}} requires verification to sell music licenses
		            @elseif($notification->type == 'new_user_to_platform_manager')
		            	{{$user->name}} has created an account
                    @elseif($notification->type == 'contract_created')
		            	New contract created for you
                    @elseif($notification->type == 'contract_approved_for_agent' || $notification->type == 'contract_approved_for_contact')
		            	Your Contract {{$contract ? $contract->contract_name : ''}} a now active
		            @endif

		            @if($notification->type == 'chat')
		            	@php $chatt = \App\Models\UserChat::find($notification->source_table_id) @endphp
		            	@if($chatt)
		            		<br>
		            		<div class="usr_noti_det_in_text">
		            			{{str_limit($chatt->message, 32, '...')}}
		            		</div>
		            	@endif
		            @elseif($notification->type == 'retry_failed_payment')
		            	<br>
		            	<div class="usr_noti_det_in_text">
		            		Click for details and to retry
		            	</div>
		            @endif
		        </div>
		        <div class="usr_notif_det_time">
		            {{$notification->created_at->diffForHumans()}}
		        </div>
		    </div>
		    <div class="usr_notif_item_action">
		    	@if(!$notification->seen)
		        <div class="user_notif_item_status noti_status_new">New</div>
		        @else
		        <div class="user_notif_item_status noti_status_seen">Seen</div>
		        @endif
		    </div>
		</div>
	@elseif($notification->type == 'system')

	@endif
@else

	<div id="notif_is_empty" data-id="" data-type=""  data-link="" class="each_usr_notif_item">
	    <div class="cart_empty_img">
	        <i class="fa fa-bell-slash"></i>
	    </div>
	    <div class="cart_empty_text">
	        You have no notifications
	    </div>
	</div>

@endif
