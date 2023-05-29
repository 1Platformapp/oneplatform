@if(Auth::check())
<div class="hrd_notif_outer clearfix">

	<div class="usr_men_main_btn_outer">
	    <div class="menu_close mobile-only">
	        <span onclick="$('#notif_icon_resp').trigger('click');" class="menu_close_go"><i class="fa fa-times"></i></span>
	    </div>
	    <div data-link="{{route('search')}}" id="continue_browse_notif" class="notif_main_btn">
	        <div class="usr_men_main_btn_in">
	            <div class="usr_men_btn_in_text">BROWSE&nbsp;&nbsp;</div>
	        </div>
	    </div>
	    <div data-link="{{route('faq')}}" id="usr_men_login" class="notif_main_btn">
	        <div class="usr_men_main_btn_in">
	            <div class="usr_men_btn_in_text">HELP</div>
	        </div>
	    </div>
	</div>
	@php $commonMethods = new \App\Http\Controllers\CommonMethods() @endphp
	<div class="usr_notif_items_outer">
		<div class="usr_notif_items_inner">
			@if(count(Auth::user()->notifications))
				@foreach(Auth::user()->notifications->take(20) as $notification)
					@include('parts.user-notification-item', ['notification' => $notification, 'commonMethods' => $commonMethods])
				@endforeach
			@else
				@include('parts.user-notification-item', ['notification' => 'none', 'commonMethods' => $commonMethods])
			@endif
		</div>
	</div>
</div>
@endif