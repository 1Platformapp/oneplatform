@extends('templates.setup-template')

@section('pagetitle') {{$title}} @endsection


@section('pagekeywords')
@endsection


@section('pagedescription')
@endsection


@section('seocontent')
@endsection


@section('page-level-css')

	<link rel="stylesheet" href="{{asset('css/profile.min.css?v=5.24')}}" />
	<link rel="stylesheet" href="{{asset('simplepicker/simplepicker.css')}}" />
	<link rel="stylesheet" href="{{asset('css/profile.orders.css')}}">
	@if($page == 'news' || $page == 'social' || $page == 'videos' || $page == 'product')
		<link rel="stylesheet" href="{{asset('css/profile.media.css?v=1.7')}}">
	@endif

	<style>

		body { background: #fff; }
		.setup_outer { width: 100%; }
		.wrapper { width: 100%; position: relative; }
		.setup_inner { max-width: 55%; margin: 40px auto; padding: 15px; border: 1px solid #ccc; border-radius: 5px; background: #fff; }
		.setup_tray_main { margin-bottom: 20px; }
		.pro_main_tray,#email_section, #bio_section form h2, .no_results, .pro_stripeless_outer { display: none; }
		.setup_tray_main { display: flex; flex-direction: column; align-items: flex-start; justify-content: space-between; padding-bottom: 19px; border-bottom: 1px solid #ccc; }
		.setup_tray_top { display: flex; flex-direction: row; align-items: inherit; width: 100%; }
		.setup_tray_step { font-size: 12px; margin-bottom: 10px; }
		.setup_tray_head { font-size: 17px; }
		.setup_tray_right { display: flex; flex-direction: row; margin-left: auto; }
		.setup_tray_btn { display: flex; flex-direction: row; padding: 5px; font-size: 12px; border-radius: 3px; cursor: pointer; align-items: center; }
		.setup_tray_btn a { color: #fff; text-decoration: none; }
		.setup_back_btn { background: #000; color: #fff; margin-right: 5px; justify-content: flex-start; }
		.setup_skip_btn { background: #0069d9; color: #fff; justify-content: flex-end; }
		.setup_next_btn { background: #0069d9; color: #fff; justify-content: flex-end; }
		.setup_chat_btn { background: #9932CC; color: #fff; justify-content: flex-end; margin-right: 5px;  }
		.setup_tray_info { font-size: 15px; margin-top: 8px; line-height: 16px; background: #0069d9; color: white; padding: 8px; }
		.pro_inp_list_outer { padding-top: 8px; }
		.pro_note ul li { line-height: 18px; margin: 9px 0; }
		.setup_welcome { margin: auto; width: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
		.setup_welcome_head { font-size: 26px; margin-bottom: 8px; }
		.setup_welcome_sub_head { font-size: 13px; }
		.setup_welcome .edit_profile_btn_1 { width: 100%; }
		.color_tem { color: #007bff; }
		.check_each_name { font-size: 12px; }
		.pro_tab_feature, .pro_tab_hide_show { margin: 0 5px; }
		*[disabled="disabled"] { cursor: not-allowed; background: #ccc; }

		.manager_chat .manager_chat_init { border: 1px solid #d5dade; display: flex; }
		.manager_chat .manager_chat_init .chat_right { flex: 0 1 67%; border-left: 1px solid #d5dade; }
		.manager_chat .manager_chat_init .chat_left { flex: 0 1 33%; }
		.manager_chat .manager_chat_init textarea { width: 100%; height: 80px; border: 1px solid #d3d9dd; padding: 8px; resize: none; line-height: 1.5; font-size: 14px; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; font-family: Open sans,sans-serif; }
		.manager_chat .manager_chat_init .manager_chat_foot { flex: 0 1 100%; padding: 20px 10px 10px 10px !important; margin-top: 40px; position: relative; }
		.manager_chat .manager_chat_init .manager_chat_actions { display: flex; margin-top: 12px; }
		.manager_chat .manager_chat_init #first_submit_btn { background-color: #5cb85c; cursor: pointer; color: #fff; padding: 7px 12px; border-radius: 3px; margin-left: auto; width: 100%; text-align: center; }
		.manager_chat .manager_chat_init .chat_each_user { padding: 20px 10px; background-color: rgb(39, 40, 42); align-items: center; display: flex; flex-direction: row; }
		.manager_chat .manager_chat_init .chat_each_user .chat_user_pic { margin-right: 5px; }
		.manager_chat .manager_chat_init .chat_each_user .chat_user_name { color: #fff; font-size: 11px; }
		.manager_chat .manager_chat_init .chat_each_user .chat_user_pic img { width: 34px; height: 34px }
		.manager_chat .manager_chat_init .chat_main_body { min-height: 400px; max-height: 400px; }

		#profile_tab_14 .chat_outer .chat_users_outer { margin: 0 !important; }
		#profile_tab_14 .chat_outer .chat_partition_each { display: none; }
		#profile_tab_14 .chat_outer .chat_left { padding: 0; }

		@media (min-width:320px) and (max-width: 767px) {

			body { background: none; }
			.setup_inner { margin: unset; border: unset; border-radius: unset; max-width: 100%; }
			.setup_welcome { max-width: 100%; height: 80vh; }
			.manager_chat .manager_chat_init { flex-direction: column; }
			.manager_chat .manager_chat_init .chat_each_user { padding: 18px 10px !important; border: 1px solid #ccc; }
			.manager_chat .manager_chat_init .chat_main_body { display: none; }
		}

	</style>

@endsection


@section('page-level-js')

	<script type="text/javascript" src="{{asset('js/jwpatch.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/instantiate_jwp.js')}}"></script>

	<script>

		function hasWhiteSpace(s) {
		  return /\s/g.test(s);
		}


 		function validateCurrency(){

 			var value = document.forms['currencyForm']['currency'].value;
 			  if (value == '') {
 			    alert('You must choose a currency');
 			    return false;
 			}
 		}

		$(document).ready(function(){

			$('#first_submit_btn:not(.disabled)').click(function(){

				var message = $('#first_message');
				$('#first_submit_btn').addClass('disabled');

				if((message.val() != '')){

					var formData = new FormData();
					formData.append('message', message.val());
					formData.append('type', 'platform-manager-first');

                    $.ajax({

                        url: '/bispoke-license/message/send',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function (response) {

                            $('#first_submit_btn').removeClass('disabled');

                            if(response.success){

                            	var fd = new FormData();
								fd.append('_token', $('meta[name="csrf-token"]').attr('content') );
								fd.append('managerChatPage', 'personal');

                                $.ajax({

								    url: '/profile-setup/save-next',
								    type: 'POST',
								    data: fd,
						            cache: false,
						            dataType: 'json',
						            contentType: false,
						            enctype: 'multipart/form-data',
						            processData: false,
								    success: function (response) {

								    	if(response.success == 1){

								    		location.reload();
								    	}else{
								    		alert('Error saving');
								    	}
								    }
								});
                            }else{
                                alert(response.error);
                                $('#first_message').val('').change();
                            }
                        }
                    });
				}else{
	                alert('message cannot be empty');
	            }
			});
			$('.save_username_outer').click(function(){

				var username = $(this).closest('form').find('input[name="username"]');
				if(username.val().length < 8 || hasWhiteSpace(username.val())){
					username.addClass('error_field');
				}else{
					$(this).closest('form').submit();
				}
			});
			$('.save_currency_outer').click(function(){

				$(this).closest('form').submit();
			});

			$('.pro_tray_tab_content').removeClass('instant_hide');

			var pageUrl = window.location.href;
			if(pageUrl.indexOf('profile-setup/music') !== -1 || pageUrl.indexOf('profile-setup/standalone/music') !== -1){

				$('#edit_music_section').removeClass('instant_hide');
			}

			$('#setup_finish').click(function(){

				var formData = new FormData();
				formData.append('_token', $('meta[name="csrf-token"]').attr('content') );
				formData.append('setup_finish', '1');

				$.ajax({

				    url: '/saveUserProfile',
				    type: 'POST',
				    data: formData,
		            cache: false,
		            dataType: 'html',
		            contentType: false,
		            enctype: 'multipart/form-data',
		            processData: false,
				    success: function (response) {

				        window.location.href = '/dashboard';
				    }
				});
			});

			$('.connect_domain,.upgrade_subscription').click(function(e){

				e.preventDefault();
				var href = $(this).attr('href');

				var formData = new FormData();
				formData.append('_token', $('meta[name="csrf-token"]').attr('content') );

				if($(this).hasClass('connect_domain')){

					formData.append('page', 'domain');
				}else{

					formData.append('page', 'subscription');
				}

				$.ajax({

				    url: '/profile-setup/save-next',
				    type: 'POST',
				    data: formData,
		            cache: false,
		            dataType: 'json',
		            contentType: false,
		            enctype: 'multipart/form-data',
		            processData: false,
				    success: function (response) {

				    	if(response.success == 1){

				    		window.location.href = href;
				    	}else{
				    		alert('Error saving');
				    	}
				    }
				});
			});

			$('.setup_chat_btn').click(function(e){

				e.preventDefault();
				var page = $(this).attr('data-page');

				var formData = new FormData();
				formData.append('_token', $('meta[name="csrf-token"]').attr('content') );
				formData.append('managerChatPage', page);

				$.ajax({

				    url: '/profile-setup/save-next',
				    type: 'POST',
				    data: formData,
		            cache: false,
		            dataType: 'json',
		            contentType: false,
		            enctype: 'multipart/form-data',
		            processData: false,
				    success: function (response) {

				    	if(response.success == 1){

				    		window.location.href = '/profile-setup/next/'+page;
				    	}else{
				    		alert('Error saving');
				    	}
				    }
				});
			});

		});

		window.currentUserId = '{{$user->id}}';

	</script>

	@if($page == 'music' || $page == 'product')
		<script defer src="{{asset('audio-player/wavesurfer.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('js/bpm_finder.js?v=1.1')}}"></script>
	@endif
	@if($page == 'news' || $page == 'social' || $page == 'videos' || $page == 'product')
		<script type="text/javascript" src="{{asset('js/profile.media.js?v=1.7')}}"></script>
	@endif

	<script src="{{asset('simplepicker/simplepicker.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery.draggableTouch.min.js')}}"></script>
   	<script src="{{asset('js/profile.min.js?v=5.22')}}"></script>

@endsection


@section('flash-message-container')

    @if (Session::has('error'))

        <div class="error_span">
            <i class="fa fa-times-circle"></i>
            {{ (is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error') }}
        </div>
    	@php Illuminate\Support\Facades\Session::forget('error'); @endphp
    @endif

    <div class="js_message_contain instant_hide">
        <div class="error_span"></div>
    </div>

@endsection


@section('page-content')

	@if($page == 'welcome')

		@php $suggestedUsername = $user->recommendedUsername() @endphp
		<div class="setup_welcome">
			<div class="setup_logo">
				<img src={{asset('images/test/setup_welcome.gif')}}>
			</div>
			<div class="setup_welcome_head">
				Welcome to 1Platform
			</div>
			<div class="setup_welcome_sub_head">
				Let's setup your profile on 1Platform
			</div>
			<div class="clearfix edit_profile_btn_1">
			    <a href="{{route('profile.setup', ['page' => 'username'])}}">Okay</a>
			</div>
		</div>

	@elseif($page == 'username')

		@php $suggestedUsername = $user->recommendedUsername() @endphp
		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 2 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add username
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
					<div class="setup_tray_btn setup_next_btn">
						<a href="{{route('profile.setup', ['page' => 'currency'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
					</div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		<div class="pro_note">
		    <ul>
		        <li><span class="color_tem">Example: https://{{Config('constants.primaryDomain')}}/your-username</span></li>
		        <li>The username must be 8 or more characters long and not contain any white spaces</li>
		    </ul>
		</div>

		<form action="" method="post">
            {{csrf_field()}}

            <div class="port_each_field">
                <div class="port_field_body">
                    <input required type="text" class="port_field_text" placeholder="Enter here..." name="username" value="{{$user->username ? $user->username : $suggestedUsername}}" @if($user->profile->basic_setup == 1) disabled="disabled" @endif />
                </div>
            </div>
            @if(!$user->profile->basic_setup)
	            <div class="clearfix save_username_outer edit_profile_btn_1">
	                <a href="javascript:void(0)">Submit</a>
	            </div>
            @endif

        </form>

    @elseif($page == 'currency')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 3 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Choose currency
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
					<div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'username'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'personal'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">
				<div class="setup_tray_info">
					All your merchandize, licenses and crowdfund projects will be created in currency you specify here
				</div>
			</div>
		</div>

		<form onsubmit="return validateCurrency()" action="" method="post" name="currencyForm">
            {{csrf_field()}}

            <div class="port_each_field">
                <div class="port_field_body pro_stream_input_each">
                	<div class="stream_sec_opt_outer">
                		<select @if($user->profile->basic_setup == 1) disabled="disabled" @endif required name="currency">
                			<option value="">Choose your currency</option>
                		    <option {{$user->profile->default_currency == 'gbp' ? 'selected' : ''}} value="gbp">GBP</option>
                		    <option {{$user->profile->default_currency == 'usd' ? 'selected' : ''}} value="usd">USD</option>
                		    <option {{$user->profile->default_currency == 'eur' ? 'selected' : ''}} value="eur">EUR</option>
                		</select>
                	</div>
                </div>
            </div>

            @if(!$user->profile->basic_setup)
	            <div class="clearfix save_currency_outer edit_profile_btn_1">
	                <a href="javascript:void(0)">Submit</a>
	            </div>
            @endif

        </form>

    @elseif($page == 'personal')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 4 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Personal information
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
					<div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'currency'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
					<div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'media'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">
				<div class="setup_tray_info">
					To sell or license, users must add there correct personal information
				</div>
			</div>
		</div>

		@include('parts.profile-edit-section', ['page' => 'edit', 'subTab' => 'info', 'setupWizard' => ''])

	@elseif($page == 'media')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 5 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Media information
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
					<div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'personal'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
					<div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'design'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-edit-section', ['page' => 'edit', 'subTab' => 'media', 'setupWizard' => ''])

	@elseif($page == 'design')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 6 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Design your website
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'media'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'bio'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">
				<div class="setup_tray_info">
					Click on save button at the bottom of this page when you have added all required information
				</div>
			</div>
		</div>

		@include('parts.profile-edit-section', ['page' => 'edit', 'subTab' => 'design', 'setupWizard' => ''])

	@elseif($page == 'bio')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 7 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add your bio
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'design'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'portfolio'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">
				<div class="setup_tray_info">
					Introduce yourself. Write your story. This will appear on your website
				</div>
			</div>
		</div>

		@include('parts.profile-edit-section', ['page' => 'edit', 'subTab' => 'bio', 'setupWizard' => ''])

	@elseif($page == 'portfolio')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 8 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add your portfolio
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'bio'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'service'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-edit-section', ['page' => 'edit', 'subTab' => 'portfolio', 'setupWizard' => ''])

	@elseif($page == 'service')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 9 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add your services
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'portfolio'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'domain'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-edit-section', ['page' => 'edit', 'subTab' => 'services', 'setupWizard' => ''])

	@elseif($page == 'domain')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 10 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Connect your domain
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'service'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'news'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-edit-section', ['page' => 'edit', 'subTab' => 'domain', 'setupWizard' => ''])

		@if($user->hasActiveFreeSubscription() || !$user->internalSubscription)

			<div class="pro_note">
				<ul>
				    <li>If you own a domain e.g example.com, connect it with 1Platform so the viewers of example.com can see and purchase all your artwork added from your 1Platform account</li>
				    <li>Upgrade your plan to avail this opportunity and increase your online visibility</li>
				</ul>
			</div>

			<div class="clearfix edit_profile_btn_1">
				@if(!$user->internalSubscription)
					<a class="connect_domain" href="{{route('user.startup.wizard')}}">Subscribe</a>
				@else
	            	<a class="connect_domain" href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}">Upgrade</a>
	            @endif
	        </div>

		@endif

	@elseif($page == 'news')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 11 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add news
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'domain'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'social'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-media', ['page' => 'media', 'subTab' => 'news', 'setupWizard' => ''])

	@elseif($page == 'social')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 12 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Connect social media accounts
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'news'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'video'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">
				<div class="setup_tray_info">
					Connecting at least 1 social media account is mandatory. It will help your fans connect with you from your website.
				</div>
			</div>
		</div>

		@include('parts.profile-media', ['page' => 'media', 'subTab' => 'social-media', 'setupWizard' => ''])

		<div class="clearfix edit_profile_btn_1">
            <a href="{{route('profile.setup', ['page' => 'video'])}}">Next</a>
        </div>

    @elseif($page == 'video')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 13 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add YouTube URLs
					</div>
				</div>
                @if(!$isStandalone)
                <div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
                        <a href="{{route('profile.setup', ['page' => 'social'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'product'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-media', ['page' => 'media', 'subTab' => 'videos', 'setupWizard' => ''])

    @elseif($page == 'setup-patron')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    <div class="setup_tray_head">
                        Patron Hub
					</div>
				</div>
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-media', ['page' => 'media', 'subTab' => 'subscribers', 'setupWizard' => ''])

	@elseif($page == 'product')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 14 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add product
					</div>
				</div>
                @if(!$isStandalone)
                <div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
                        <a href="{{route('profile.setup', ['page' => 'video'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'music'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-media', ['page' => 'media', 'subTab' => 'products', 'setupWizard' => '', 'content' => $content])

    @elseif($page == 'song-links')

        @include('parts.profile-media', ['page' => 'media', 'subTab' => 'song-links', 'setupWizard' => ''])

	@elseif($page == 'music')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 15 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add music
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
                        <a href="{{route('profile.setup', ['page' => 'product'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'album'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-media', ['page' => 'media', 'subTab' => 'add-music', 'setupWizard' => ''])
	@elseif($page == 'album')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 16 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Add album
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
                        <a href="{{route('profile.setup', ['page' => 'music'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'subscription'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-media', ['page' => 'media', 'subTab' => 'albums', 'setupWizard' => ''])
	@elseif($page == 'crowdfunding')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    <div class="setup_tray_head">
						Crowdfunding
					</div>
				</div>
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		@include('parts.profile-crowd-funding-section', ['page' => 'crowdfunds', 'commonMethods' => $commonMethods, 'setupWizard' => ''])

	@elseif($page == 'agent')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
			        <div class="setup_tray_step">
			            Step 17 of 20
			        </div>
                    @endif
			        <div class="setup_tray_head">
			            Get an artist manager
			        </div>
			    </div>
                @if(!$isStandalone)
			    <div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
                        <a href="{{route('profile.setup', ['page' => 'album'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'subscription'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                @endif
			</div>
			<div class="setup_tray_foot">
				<div class="setup_tray_info">
		            This is optional but highly recommended that you can look for an artist manager that will help you boost your sales or increase your fan base
		        </div>
			</div>
		</div>
		@include('parts.profile-chat-old', ['page' => 'chat', 'subTab' => 'get-agent', 'setupWizard' => ''])

	@elseif($page == 'subscription')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
			        <div class="setup_tray_step">
			            Step 18 of 19
			        </div>
                    @endif
			        <div class="setup_tray_head">
			            Upgrade your subscription plan
			        </div>
			    </div>
                @if(!$isStandalone)
			    <div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
                        <a href="{{route('profile.setup', ['page' => 'album'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'stripe'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>
		<div class="pro_note">
		    <ul>
		        <li>When you create a new account you are automatically subscribed to our free plan</li>
		        <li>Our free plan can unlock basic features to operate as an artist or a store</li>
		        <li>However 1Platform has tons of exciting features for artists and store owners that can be unlocked after you upgrade to one of our paid plans</li>
		    </ul>
		</div>
		<div class="clearfix edit_profile_btn_1">
		    <a class="upgrade_subscription" href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}">Upgrade Now</a>
		</div>

	@elseif($page == 'stripe')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 19 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Connect your stripe account
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
                    <div class="setup_tray_btn setup_back_btn">
                        <a href="{{route('profile.setup', ['page' => 'subscription'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                    <div class="setup_tray_btn setup_next_btn">
                        <a href="{{route('profile.setup', ['page' => 'finish'])}}">Next&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                @endif
			</div>
			<div class="setup_tray_foot">

			</div>
		</div>

		<div class="pro_note">
			<ul>
			    <li>Without connecting a stripe account you can still add your musics, albums and products but you will not be able to sell anything.</li>
			    <li>After you have connected, people can buy from your website and the money will go straight into your connected bank account.</li>
			    <li>Click <a target="_blank" href="https://stripe.com/gb/connect">here</a> to learn about stripe connect or <a target="_blank" href="https://stripe.com/gb/pricing">here</a> to learn about stripe pricing.</li>
			    <li>When you connect your stripe account with 1Platform it implies you agree to our <a href="{{route('tc')}}">terms and conditions</a>.</li>
			</ul>
		</div>

		@if($user->profile->stripe_secret_key == '' || $user->profile->stripe_secret_key == NULL)
		<div class="clearfix edit_profile_btn_1">
            <a href="{{$stripeUrl}}">Connect Now</a>
        </div>
        @else
        <div class="clearfix edit_profile_btn_1">
            <a target="_blank" href="https://dashboard.stripe.com/">Your Stripe Dashboard</a>
        </div>
        @endif

    @elseif($page == 'finish')

		<div class="setup_tray_main">
			<div class="setup_tray_top">
				<div class="setup_tray_left">
                    @if(!$isStandalone)
					<div class="setup_tray_step">
						Step 19 of 19
					</div>
                    @endif
					<div class="setup_tray_head">
						Well done
					</div>
				</div>
                @if(!$isStandalone)
				<div class="setup_tray_right">
					<div class="setup_tray_btn setup_back_btn">
						<a href="{{route('profile.setup', ['page' => 'stripe'])}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
					</div>
				</div>
                @endif
			</div>
			<div class="setup_tray_foot">
				<div class="setup_tray_info">
					You have reached the end of this wizard
				</div>
			</div>
		</div>

		<div class="clearfix edit_profile_btn_1">
            <a id="setup_finish" href="javascript:void(0)">My Profile</a>
        </div>

	@endif

@endsection


@section('miscellaneous-html')

	@php Illuminate\Support\Facades\Session::forget('managerChat') @endphp

	@include('parts.add-form-elements')

	<div id="body-overlay"></div>

	<div style="display: none;" id="further_skill_each_item_temp">
	    <div class="profile_custom_drop_each">
	        <div class="profile_custom_drop_title"></div>
	        <div class="profile_custom_drop_icon">
	            <i class="fa fa-times"></i>
	        </div>
	    </div>
	</div>



	<div class="clearfix pro_uploading_in_progress in_progress pro_page_pop_up" style="z-index: 10;" id="pro_uploading_in_progress_real">

	    <div class="clearfix pro_soc_con_face_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	        </div>
	        <div class="clearfix soc_con_face_username">

	            <h3>Please wait. Uploading is in progress...</h3><br><br><br>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_project_pitch_uploaded pro_page_pop_up" id="pitch_uploaded_popup" style="z-index: 10;">

	    <div class="clearfix pro_soc_discon_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	            <i class="fa fa-times pro_soc_top_close"></i>
	        </div>
	        <div class="clearfix pro_project_pitch_uploaded_inner">

	            <h3>Your Project pitch
	                has been uploaded</h3><br />
	            <center>
	                <img class="show_icon defer_loading" src="" data-src="{{ asset('images/project_pitch_uploaded.png') }}">
	            </center>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_project_pitch_uploaded pro_page_pop_up" id="bio_video_popup" style="z-index: 10;">

	    <div class="clearfix pro_soc_discon_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	            <i class="fa fa-times pro_soc_top_close"></i>
	        </div>
	        <div class="clearfix pro_project_pitch_uploaded_inner">

	            <h3>Your bio video has been updated</h3><br />
	            <center>
	                <img class="show_icon defer_loading" src="" data-src="{{ asset('images/project_pitch_uploaded.png') }}">
	            </center>
	            <div class="clearfix pro_submit_button_outer soc_con_submit_success">

	                <a href="{{route('profile.setup', ['page' => 'design'])}}" id="submit_button">Okay</a>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_confirm_delete_outer pro_page_pop_up" >

	    <div class="clearfix pro_confirm_delete_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a style="opacity: 0;" class="logo8">
	                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}">
	                <div>Platform</div>
	            </a>
	            <i class="fa fa-times pro_soc_top_close"></i>
	        </div>
	        <div class="clearfix pro_confirm_delete_text">

	            <div class="main_headline">Are You Sure You Want To Delete This Item?</div><br>
	            <span class="error"></span>
	        </div>
	        <div class="clearfix pro_confirm_box_outer pro_submit_button_outer soc_submit_success">

	            <div class="delete_yes pro_confirm_box_each" data-delete-id="" data-delete-item-type="" data-album-status="" data-album-music-id="" id="pro_delete_submit_yes">YES</div>
	            <div class="delete_no pro_confirm_box_each" id="pro_confirm_delete_submit_no">NO</div>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_soc_con_face_outer pro_page_pop_up">

	    <div class="clearfix pro_soc_con_face_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	            <i class="pro_soc_top_close fa fa-close"></i>
	        </div>
	        <br>
	        <div class="clearfix soc_con_face_username">

	            <h3>Facebook Page ID</h3><br>
	            <p>Looking for your page ID? Go to the Facebook page that you want to add to the site&gt;click About&gt;Scroll down to the bottom of the page and copy your Facebook page ID</p><br>
	            <input placeholder="Example: TaylorSwift" type="text" id="soc_con_face_username_val" value="" />
	            <span class="error"></span>
	        </div>
	        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

	            <a href="#" id="pro_soc_con_facebook_submit">Connect</a>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_soc_con_youtube_outer pro_page_pop_up" >

	    <div class="clearfix pro_soc_con_youtube_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	            <i class="pro_soc_top_close fa fa-close"></i>
	        </div>
	        <br>
	        <div class="clearfix soc_con_youtube_username">

	            <h3>YouTube Channel ID</h3><br>
	            <input placeholder="Example: UCJ4XbT8rbwUQGB0y0dl4n_w" type="text" id="soc_con_youtube_username_val" value="" />
	            <span class="error"></span>
	        </div>
	        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

	            <a href="#" id="pro_soc_con_youtube_submit">Connect</a>
	        </div><br>
	        <div class="pro_pop_dark_note">
	            <a target="_blank" href="https://support.google.com/youtube/answer/3250431?hl=en">How to find my YouTube channel ID</a>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_soc_con_twit_outer pro_page_pop_up" >

	    <div class="clearfix pro_soc_con_twit_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	            <i class="pro_soc_top_close fa fa-close"></i>
	        </div>
	        <div class="clearfix soc_con_twit_username">

	            <h3>Twitter Account Username</h3><br>
	            <input placeholder="Example: taylorswift13" type="text" id="soc_con_twit_username_val" value="" />
	            <span class="error"></span>
	        </div>
	        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

	            <a href="#" id="pro_soc_con_twit_submit">Connect</a>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_soc_con_spot_outer pro_page_pop_up">

	    <div class="clearfix pro_soc_con_twit_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	            <i class="pro_soc_top_close fa fa-close"></i>
	        </div>
	        <div class="clearfix soc_con_twit_username">

	            <h3>Paste Your Spotify Artist URL</h3><br>
	            <input autocomplete="off" placeholder="Example: https://open.spotify.com/artist/123456789" type="text" id="soc_con_spotify_url_val" value="" />
	            <span class="error"></span>
	        </div>
	        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

	            <a href="javascript:void(0)" id="pro_soc_con_spot_submit">Connect</a>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_soc_discon_outer pro_page_pop_up" >

	    <div class="clearfix pro_soc_discon_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	            <i class="pro_soc_top_close fa fa-close"></i>
	        </div>
	        <br>
	        <div class="clearfix soc_discon_text">

	            <h3>Do You Want To Disconnect Your <span>YouTube</span> Account?</h3><br>
	            <span class="error"></span>
	        </div>
	        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

	            <a data-disconnect-account="" href="#" id="pro_soc_discon_submit_yes">Yes</a>
	        </div>
	        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

	            <a href="#" id="pro_soc_discon_submit_no">No</a>
	        </div>
	    </div>
	</div>
	<div data-music="" class="clearfix music_zip_upload_popup in_progress pro_page_pop_up new_popup" style="z-index: 10;">

	    <div class="clearfix pro_soc_con_face_inner">

	        <div class="pro_pop_head">Upload details</div>
	        <div class="pro_pop_body">
	            <div class="pro_body_in">
	                <div data-type="music_info" class="pro_pop_upload_each waiting">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-info"></i></div>
	                    <div class="pro_pop_each_item item_name">Saving music info</div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="main" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="loop_one" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="loop_two" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="loop_three" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="stem_one" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="stem_two" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="stem_three" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="stem_four" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="stem_five" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="stem_six" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="stem_seven" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="stem_eight" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
	                    <div class="pro_pop_each_item item_name"></div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	                <div data-type="music_file_delete" class="pro_pop_upload_each waiting instant_hide">
	                    <div class="pro_pop_each_item item_type"><i class="fa fa-trash"></i></div>
	                    <div class="pro_pop_each_item item_name">Deleting music file(s)</div>
	                    <div class="pro_pop_each_item item_size"></div>
	                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
	                </div>
	            </div>
	            <div class="pro_pop_info">
	                It may take a while, please be patient. Do not refresh or navigate away from this page
	            </div>
	        </div>
	        <div class="pro_pop_foot">
	            <div class="foot_help">
	                Having problems? Please try again or contact us via online chat
	            </div>
	            <div class="foot_action">
	                <!--<div id="minify_upload" class="foot_action_btn">Hide</div>!-->
	                <div id="close_upload" class="foot_action_btn instant_hide">Finish</div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_page_pop_up" id="music_private_popup" data-music-id="">

	    <div class="clearfix pro_soc_con_face_inner">

	        <div class="clearfix soc_con_top_logo">
	            <a style="opacity:0;" class="logo8">
	                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
	            </a>
	            <i class="fa fa-times pro_soc_top_close"></i>
	        </div>
	        <div class="stage_one">
	            <div class="clearfix soc_con_face_username">
	                <div class="main_headline">Manage music privacy</div><br>
	                <div class="new_popup_check_out">
	                    <input type="hidden" class="new_popup_check" />
	                    <span class="new_popup_check_in">Make this music private</span>
	                </div>
	                <input class="dummy_field" type="text" name="fakeusernameremembered">
	                <input placeholder="Unlock PIN" type="text" id="private_music_pin" />
	                <div class="instant_hide error" id="pin_error">Required</div>
	            </div>
	            <br>
	            <div id="save_music_private" class="pro_button">SAVE</div><br>
	            <div class="pro_pop_dark_note">
	                <a href="#">How music privacy works?</a>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_page_pop_up" id="get_agent_popup">

	    <div class="clearfix pro_soc_con_face_inner">

	        <div class="clearfix soc_con_top_logo">
	            <a style="opacity:0;" class="logo8">
	                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
	            </a>
	            <i class="fa fa-times pro_soc_top_close"></i>
	        </div>
	        <div class="stage_one">
	            <div class="clearfix soc_con_face_username">
	                <div class="primary_headline">Request to have an artist manager</div>
	                <div class="pro_pop_text_light text_normal">
	                    Your request will be sent to <span class="pro_text_dark new_agent_name"></span>
	                </div>
	                <div class="current_agent instant_hide">
	                    <div class="main_headline current_agent_name"></div>
	                    <div class="pro_pop_text_light text_normal">is your current artist manager</div>
	                </div>
	                <div class="new_agent">
	                    <div class="main_headline new_agent_name"></div>
	                    <div class="pro_pop_text_light text_normal">is the manager you are requesting for</div>
	                </div>
	            </div>
	            <br><br>
	            <div id="proceed_get_agent" class="pro_button">Send Request</div>
	        </div>
	        <div class="stage_two instant_hide">
	            <div class="clearfix soc_con_face_username">
	                <div class="pro_pop_text_light text_center">
	                    Your request has been sent to <span class="pro_text_dark new_agent_name"></span>. The manager will be resposible to process and reply to this request. Keep checking your email and 1Platform account for any updates regarding this request.
	                </div>
	            </div>
	            <br>
	        </div>
	    </div>
	</div>
	<div class="clearfix pro_fill_outer pro_page_pop_up">

	    <div class="clearfix pro_fill_inner">

	        <div class="clearfix soc_con_top_logo">

	            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
	            <i class="fa fa-times pro_soc_top_close"></i>
	        </div>
	        <div class="clearfix soc_discon_text">

	            <h3>Wait!! You haven't completed all of your profile information</h3><br />
	            <span class="error"></span>
	        </div>
	        <div class="clearfix pro_fill_img">
	            <img class="defer_loading" src="" data-src="{{ asset('images/pupfillprofile.png') }}">
	        </div>
	    </div>
	</div>

    <div class="clearfix pro_add_edit_bonus_outer pro_page_pop_up" >
        <div class="clearfix pro_confirm_delete_inner">
            <div class="clearfix soc_con_top_logo">
                <a style="opacity: 0;" class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="main_headline"><span class="add_edit_text">Add</span> Bonus</div><br>
            <form id="add_edit_bonus_form" action="{{ route('add.edit.bonus') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="clearfix pro_add_bonus_row_outer cant_edit_fields">

                    <label>Bonus Thumbnail (Optional)</label><br>
                    <img class="pop_up_bonus_thumb defer_loading" src="" data-src="{{ asset('images/p_music_thum_img.png') }}"><br>
                    <div class="pro_input_group">
                        <label>Title *</label><br>
                        <input class="pop_up_bonus_field groupon ring-1 ring-gray-300" placeholder="Bonus Title" type="text" id="pop_up_bonus_title" name="bonus_title" value="" />
                        <div class="error instant_hide" id="pop_up_bonus_title_error">Required</div>
                    </div>
                    <div class="pro_input_group">
                        <label>Description *</label><br>
                        <textarea class="pop_up_bonus_field groupon" name="bonus_description" id="pop_up_bonus_description"></textarea>
                        <div class="error instant_hide" id="pop_up_bonus_description_error">Required</div>
                    </div>
                    <div class="pro_input_group">
                        <label>Amount Of Bonuses Available (leave blank if unlimited)</label><br>
                        <input class="pop_up_bonus_field groupon ring-1 ring-gray-300" type="text" id="pop_up_bonus_quantity" name="bonus_quantity" value="" />
                        <div class="error instant_hide" id="pop_up_bonus_quantity_error">Required</div>
                    </div>
                    <div class="pro_input_group">
                        <label>Bonus Items * (separate each item by comma i.e item 1,item 2)</label><br>
                        <input class="pop_up_bonus_field groupon ring-1 ring-gray-300" type="text" id="pop_up_bonus_items" name="bonus_items" value="" />
                        <div class="error instant_hide" id="pop_up_bonus_items_error">Required</div>
                    </div>
                    <div class="pro_input_group">
                        <label>Bonus Price *</label><br>
                        <div class="proj_bonus_curr_crop_outer">
                            <div class="">
                                <div class="clearfix proj_cont_right_inner drop_substi_bon_inner">
                                    <div class="drop_substi_curr">{{$user->profile->default_currency}}</div>
                                    <input value="" class="pop_up_bonus_field drop_substi_val groupon ring-1 ring-gray-300" type="text" id="pop_up_bonus_price" name="bonus_price" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="error instant_hide" id="pop_up_bonus_price_error">Required</div>
                    </div>
                    <div class="pro_input_group">
                        <label>Worldwide Shipping</label><br>
                        <div class="proj_bonus_curr_crop_outer">
                            <div class="">
                                <div class="clearfix proj_cont_right_inner drop_substi_bon_inner">
                                    <div class="drop_substi_curr">{{$user->profile->default_currency}}</div>
                                    <input value="" class="pop_up_bonus_field drop_substi_val groupon ring-1 ring-gray-300" type="text" id="pop_up_bonus_shipping_worldwide" name="bonus_shipping_worldwide" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="error instant_hide" id="pop_up_bonus_shipping_worldwide_error">Required</div>
                    </div>
                    <div class="pro_input_group">
                        <label>My Country Shipping</label><br>
                        <div class="proj_bonus_curr_crop_outer">
                            <div class="">
                                <div class="clearfix proj_cont_right_inner drop_substi_bon_inner">
                                    <div class="drop_substi_curr">{{$user->profile->default_currency}}</div>
                                    <input value="" class="pop_up_bonus_field drop_substi_val groupon ring-1 ring-gray-300" type="text" id="pop_up_bonus_shipping_my_country" name="bonus_shipping_my_country" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="error instant_hide" id="pop_up_bonus_shipping_my_country_error">Required</div>
                    </div>
                </div>
                <div class="clearfix pro_submit_button_outer soc_submit_success">

                    <input type="hidden" id="pop_up_bonus_id" name="bonus_id" value="0" />
                    <input type="hidden" id="pop_up_campaign_id" name="bonus_campaign_id" value="0" />
                    <input accept="image/*" type="file" id="pop_up_bonus_file" name="bonus_thumbnail" style="display: none;" onchange="setBonusThumb(this)" />
                    <div id="submit_bonus_form" class="pro_button">SUBMIT</div>
                </div>
            </form>
        </div>
    </div>

    <div class="clearfix pro_confirm_go_live pro_page_pop_up" style="z-index: 10;" id="pro_confirm_go_live">

        <div class="clearfix pro_soc_con_face_inner">

            <div class="clearfix soc_con_top_logo">

                <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
                <i class="pro_soc_top_close fa fa-close"></i>
                <br>
            </div>
            <div class="clearfix soc_con_face_username">

                <h3>You are about to go live on 1Platform TV. Once you are live you cannot undo this action</h3><br>
            </div>
            <div class="clearfix pro_submit_button_outer soc_con_submit_success">
                <a href="javascript:void(0)" id="pro_go_live_confirm">Proceed</a>
            </div>
        </div>
    </div>

@endsection
