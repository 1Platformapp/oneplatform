@extends('templates.bisection-template')



@section('pagetitle') {{$user->name}} - Profile  @endsection


@section('page-level-css')

    @php $page = '' @endphp

    @php $subTab = '' @endphp

    @php $notificationsopener = '' @endphp

    @php $cardsopener = '' @endphp

    @if(session('page'))

        @php $page = session('page') @endphp

    @endif

    @if(session('subTab'))

        @php $subTab = session('subTab') @endphp

    @endif

    @if(session('notificationsopener'))

        @php $notificationsopener = session('notificationsopener') @endphp

    @endif

    @if(session('notificationsopener'))

        @php $cardsopener = session('cardsopener') @endphp

    @endif

    <style>
        @-webkit-keyframes m-dropdown-fade-in { from { opacity: 0 } to { opacity: 1 } }
        @keyframes m-dropdown-fade-in { from { opacity: 0 } to { opacity: 1 } }
        @-webkit-keyframes m-dropdown-move-up { from { margin-top: 10px } to { margin-top: 0 } }
        @keyframes m-dropdown-move-up { from { margin-top: 10px } to { margin-top: 0 } }
        input::-webkit-input-placeholder { font-size: 12px; }
    </style>

    <link rel="stylesheet" href="{{asset('css/profile.min.css?v=5.21')}}" />
    <link rel="stylesheet" href="{{asset('simplepicker/simplepicker.css')}}">

@stop


@section('page-level-js')

	<script src="{{asset('simplepicker/simplepicker.js')}}"></script>
	<script src="https://js.stripe.com/v3/"></script>
   	<script type="text/javascript">

   		window.currentUserId = {{Auth::user()->id}};
   		window.notifications = '{{$notificationsopener}}';
        window.userOS = '{{$userOS}}';
        window.appCards = '{{$cardsopener}}';

   	</script>

   	<script src="{{asset('js/profile.min.js?v=5.22')}}"></script>
    <script type="text/javascript" src="{{asset('js/jwpatch.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/instantiate_jwp.js')}}"></script>
@stop

@section('header')

    @include('parts.header')

@stop

@section('top-section')

@stop


@section('audio-player')

    @include('parts.audio-player')

@stop

@section('flash-message-container')

    @php $quickSetup = $user->quickSetupProfile() @endphp

    @if (Session::has('error'))

        <div class="error_span">
            <i class="fa fa-times-circle"></i>
            {{ (is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error') }}
        </div>

    @endif

    @if (Session::has('success'))

        <div class="success_span">
            <i class="fa fa-check-circle"></i>
            {{ (is_array(Session::get('success'))) ? Session::get('success')[0] : Session::get('success') }}
        </div>

    @endif

    <div class="js_message_contain instant_hide">
        <div class="error_span"></div>
        <div class="success_span"></div>
    </div>
@stop

@section('left-section')

    <div class="pro_left_sec_outer">
    	@if(!$user->is_buyer_only)
    	<div class="pro_acc_stats_outer">
    		<div class="pro_acc_stat_top">
    			<div class="pro_acc_stat_head">Account Statistics</div>
    		</div>
    		<div class="pro_acc_stat_sep"></div>
    		<div class="pro_acc_stat_btm">
    			<div class="pro_acc_stat_each">
    				<div class="pro_acc_stat_name">
    					Total Revenue
    				</div>
    				<div class="pro_acc_stat_val">
    					{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ number_format($purchaseParticulars['total_revenue'], 2) }}
    				</div>
    			</div>
                <div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Singles Sold
                    </div>
                    <div class="pro_acc_stat_val">
                        {{$purchaseParticulars['singles_sold']}}
                    </div>
                </div>
                <div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Albums Sold
                    </div>
                    <div class="pro_acc_stat_val">
                        {{$purchaseParticulars['albums_sold']}}
                    </div>
                </div>
                <div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Products Sold
                    </div>
                    <div class="pro_acc_stat_val">
                        {{$purchaseParticulars['products_sold']}}
                    </div>
                </div>
                <div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Fans
                    </div>
                    <div class="pro_acc_stat_val">
                        {{count($purchaseParticulars['fans'])}}
                    </div>
                </div>
                @php $agent = \App\Models\AgentContact::where(['contact_id' => $user->id, 'approved' => 1])->whereNotNull('agent_id')->first() @endphp
    			<div class="pro_acc_stat_each">
                    <div class="pro_acc_stat_name">
                        Your Agent
                    </div>
                    <div title="{{$agent && $agent->agentUser?$agent->agentUser->activityStatus():''}}" class="pro_acc_stat_val">
                        @if($agent && $agent->agentUser)
                            <i class="fa fa-circle {{$agent->agentUser->activityStatus()}}"></i>&nbsp;
                            {{$agent->agentUser->name}}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
    		</div>
    	</div>

        <div class="pro_get_started">
            <div class="pro_get_start_top">
                <div class="pro_get_start_head">Add New Content</div>
                <div class="pro_get_start_sub_head">Quick links to create new content for your website</div>
            </div>
            <div class="pro_get_start_bottom">
                <div data-cat="media" data-sub-cat="add_musics" class="pro_get_start_each_panel complete">
                    <div class="pro_get_start_panel_head">
                        <i class="fas fa-guitar"></i>
                    </div>
                    <div class="pro_get_start_panel_body">
                        Upload Music
                    </div>
                </div>
                <div data-cat="media" data-sub-cat="my_albums" class="pro_get_start_each_panel complete">
                    <div class="pro_get_start_panel_head">
                        <i class="fas fa-compact-disc"></i>
                    </div>
                    <div class="pro_get_start_panel_body">
                        Create Album
                    </div>
                </div>
                <div data-cat="media" data-sub-cat="standard_products" class="pro_get_start_each_panel complete">
                    <div class="pro_get_start_panel_head">
                        <i class="fas fa-store-alt"></i>
                    </div>
                    <div class="pro_get_start_panel_body">
                        Add Product
                    </div>
                </div>
                <div data-cat="profile" data-sub-cat="portfolio" class="pro_get_start_each_panel complete">
                    <div class="pro_get_start_panel_head">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="pro_get_start_panel_body">
                        Add Portfolio
                    </div>
                </div>
                <div data-cat="profile" data-sub-cat="services" class="pro_get_start_each_panel complete">
                    <div class="pro_get_start_panel_head">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="pro_get_start_panel_body">
                        Add Service
                    </div>
                </div>
                <div data-cat="media" data-sub-cat="videos" class="pro_get_start_each_panel complete">
                    <div class="pro_get_start_panel_head">
                        <i class="fa fa-youtube"></i>
                    </div>
                    <div class="pro_get_start_panel_body">
                        Add YouTube Video
                    </div>
                </div>
            </div>
        </div>

        <div class="pro_lat_sale">
            <div class="pro_lat_sale_top">
                <div class="pro_lat_sale_head">Latest Sales</div>
                <div class="pro_lat_sale_sub_head">Your latest sales</div>
            </div>
            <div class="pro_lat_sale_bottom">
                @if(count($topSales))
                @foreach($topSales as $key => $checkout)
                @php $currencySymbol = $commonMethods->getCurrencySymbol($checkout->currency) @endphp
                @php $customerImage = $commonMethods->getUserDisplayImage($checkout->customer ? $checkout->customer->id : 0) @endphp
                <div class="pro_lat_sale_each">
                    <div class="pro_lat_sale_each_left">
                        <img class="trans_image" title="{{$checkout->customer_name}}" src="{{$customerImage}}" alt="#" />
                    </div>
                    <div class="pro_lat_sale_each_center">
                        <div class="pro_lat_sale_each_name">
                            {{$checkout->customer_name}}
                        </div>
                        <div class="pro_lat_sale_each_desc">
                            @if($checkout->type == 'crowdfund')
                                Crowdfund sale
                            @else
                                {{count($checkout->instantCheckoutItems)}}
                                {{count($checkout->instantCheckoutItems) == 1 ? 'item' : 'items'}}
                            @endif
                        </div>
                    </div>
                    <div class="pro_lat_sale_each_right">
                        {{($checkout->price>0)?$currencySymbol.number_format($checkout->price, 2):' Free'}}
                    </div>
                </div>
                @endforeach
                @else
                <div class="no_results">You do not have any sales yet</div>
                @endif
            </div>
        </div>

    	<div class="pro_get_started">
    		<div class="pro_get_start_top">
    			<div class="pro_get_start_head">Build Basic Page</div>
    			<div class="pro_get_start_sub_head">Complete the steps below to create a basic artist page</div>
    		</div>
    		<div class="pro_get_start_bottom">
    			<div data-cat="profile" data-sub-cat="edit" class="pro_get_start_each_panel {{$quickSetup['personal'] == 1 ? 'complete' : 'incomplete'}}">
    				<div class="pro_get_start_panel_head">
    					@if($quickSetup['personal'] == 1)
    						<i class="fa fa-check-circle"></i>
    					@else
    						<i class="fa fa-question-circle"></i>
    					@endif
    				</div>
    				<div class="pro_get_start_panel_body">
    					Personal Info
    				</div>
    			</div>
    			<div data-cat="profile" data-sub-cat="media" class="pro_get_start_each_panel {{$quickSetup['media'] == 1 ? 'complete' : 'incomplete'}}">
    				<div class="pro_get_start_panel_head">
    					@if($quickSetup['media'] == 1)
    						<i class="fa fa-check-circle"></i>
    					@else
    						<i class="fa fa-question-circle"></i>
    					@endif
    				</div>
    				<div class="pro_get_start_panel_body">
    					Media Info
    				</div>
    			</div>
    			<div data-cat="profile" data-sub-cat="bio" class="pro_get_start_each_panel {{$quickSetup['bio'] == 1 ? 'complete' : 'incomplete'}}">
    				<div class="pro_get_start_panel_head">
    					@if($quickSetup['bio'] == 1)
    						<i class="fa fa-check-circle"></i>
    					@else
    						<i class="fa fa-question-circle"></i>
    					@endif
    				</div>
    				<div class="pro_get_start_panel_body">
    					Add Bio
    				</div>
    			</div>
    			<div data-cat="profile" data-sub-cat="design" class="pro_get_start_each_panel {{$quickSetup['design'] == 1 ? 'complete' : 'incomplete'}}">
    				<div class="pro_get_start_panel_head">
    					@if($quickSetup['design'] == 1)
	                        <i class="fa fa-check-circle"></i>
	                    @else
	                        <i class="fa fa-question-circle"></i>
	                    @endif
    				</div>
    				<div class="pro_get_start_panel_body">
    					Website Design
    				</div>
    			</div>
    			<div data-cat="media" data-sub-cat="add_musics" class="pro_get_start_each_panel {{$quickSetup['music'] == 1 ? 'complete' : 'incomplete'}}">
    				<div class="pro_get_start_panel_head">
    					@if($quickSetup['music'] == 1)
    					    <i class="fa fa-check-circle"></i>
    					@else
    					    <i class="fa fa-question-circle"></i>
    					@endif
    				</div>
    				<div class="pro_get_start_panel_body">
    					Upload Music
    				</div>
    			</div>
    			<div data-cat="media" data-sub-cat="standard_products" class="pro_get_start_each_panel {{$quickSetup['product'] == 1 ? 'complete' : 'incomplete'}}">
    				<div class="pro_get_start_panel_head">
    					@if($quickSetup['product'] == 1)
    					    <i class="fa fa-check-circle"></i>
    					@else
    					    <i class="fa fa-question-circle"></i>
    					@endif
    				</div>
    				<div class="pro_get_start_panel_body">
    					Add Product
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="pro_build_acc">
    		<div class="pro_build_acc_top">
    			<div class="pro_build_acc_head">Build Pro Page</div>
    			<div class="pro_build_acc_sub_head">Follow these steps to create a professional artist page</div>
    		</div>
    		<div class="pro_build_acc_bottom">
    			<div class="pro_build_acc_each_panel {{$quickSetup['error'] == ''?'complete':'incomplete'}}">
    				<div class="pro_build_acc_panel_head">
    					1
    				</div>
    				<div class="pro_build_acc_panel_body">
    					@if($quickSetup['error'] == '')
    						<i class="fa fa-check-circle"></i>
    					@else
    						<i class="fa fa-exclamation-circle"></i>
    					@endif
    					Build Basic Page
    				</div>
    				<div class="pro_build_acc_link">
    					@if($quickSetup['error'] == '')
    					<a href="{{route('user.home', ['params' => $user->username])}}">
    						<i class="fa fa-eye"></i>
    					</a>
    					@else
    					@php $explode = explode(':',$quickSetup['error']) @endphp
    					<a href="{{route('profile.with.tab', ['tab' => $explode[0], 'subtab' => $explode[1]])}}">
    						<i class="fa fa-external-link"></i>
    					</a>
    					@endif
    				</div>
    			</div>
    			<div class="pro_build_acc_each_panel {{$user->hasActivePaidSubscription()?'complete':'incomplete'}}">
    				<div class="pro_build_acc_panel_head">
    					2
    				</div>
    				<div class="pro_build_acc_panel_body">
    					@if($user->hasActivePaidSubscription())
    						<i class="fa fa-check-circle"></i>
    					@else
    						<i class="fa fa-exclamation-circle"></i>
    					@endif
    					Upgrade Seller Plan
    				</div>
    				<div class="pro_build_acc_link">
    					@if($user->hasActivePaidSubscription())

    					@else
    						<a href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}">
		    					<i class="fa fa-external-link"></i>
		    				</a>
    					@endif
    				</div>
    			</div>
    			<div class="pro_build_acc_each_panel {{$user->profile->stripe_secret_key!=''?'complete':'incomplete'}}">
    				<div class="pro_build_acc_panel_head">
    					3
    				</div>
    				<div class="pro_build_acc_panel_body">
    					@if($user->profile->stripe_secret_key != '')
    						<i class="fa fa-check-circle"></i>
    					@else
    						<i class="fa fa-exclamation-circle"></i>
    					@endif
    					Connect Stripe Account
    				</div>
    				<div class="pro_build_acc_link">
    					@if($user->profile->stripe_secret_key != '')
    						<a target="_blank" href="https://dashboard.stripe.com/">
		    					<i class="fa fa-eye"></i>
		    				</a>
    					@else
    						<a href="{{route('user.startup.wizard')}}">
		    					<i class="fa fa-external-link"></i>
		    				</a>
    					@endif
    				</div>
    			</div>
                @if($user->isCotyso())
                <div class="pro_build_acc_each_panel {{$user->profile->paypal_merchant_id!=''?'complete':'incomplete'}}">
                    <div class="pro_build_acc_panel_head">
                        4
                    </div>
                    <div class="pro_build_acc_panel_body">
                        @if($user->profile->paypal_merchant_id != '')
                            <i class="fa fa-check-circle"></i>
                        @else
                            <i class="fa fa-exclamation-circle"></i>
                        @endif
                        Connect PayPal Account
                    </div>
                    <div class="pro_build_acc_link">
                        @if($user->profile->paypal_merchant_id != '')
                            <a target="_blank" href="https://paypal.com/">
                                <i class="fa fa-eye"></i>
                            </a>
                        @else
                            <a href="{{route('user.startup.wizard')}}">
                                <i class="fa fa-external-link"></i>
                            </a>
                        @endif
                    </div>
                </div>
                @endif
    			<div class="pro_build_acc_each_panel {{!$user->hasSocialEmpty()?'complete':'incomplete'}}">
    				<div class="pro_build_acc_panel_head">
    					5
    				</div>
    				<div class="pro_build_acc_panel_body">
    					@if(!$user->hasSocialEmpty())
    						<i class="fa fa-check-circle"></i>
    					@else
    						<i class="fa fa-exclamation-circle"></i>
    					@endif
    					Connect Social Media Accounts
    				</div>
    				<div class="pro_build_acc_link">
	    				<a href="{{route('profile.with.tab', ['tab' => 'media', 'subtab' => 'social-media'])}}">
	    					@if(!$user->hasSocialEmpty())
	    						<i class="fa fa-eye"></i>
	    					@else
	    						<i class="fa fa-external-link"></i>
	    					@endif
	    				</a>
    				</div>
    			</div>
    		</div>
    	</div>
    	@endif
    </div>

@stop



@section('right-section')

    <div class="pro_right_sec_outer">

        <div class="pro_right_tb_det_outer">

            @include('parts.profile-edit-section', ['page' => $page])

            @if(!$user->is_buyer_only)

            @include('parts.profile-media', ['page' => $page])

            @include('parts.profile-crowd-funding-section', ['page' => $page])

            @include('parts.profile-tools', ['page' => $page])

            @endif

            @include('parts.profile-orders-section', ['page' => $page])

            @include('parts.profile-chat-old', ['page' => $page])

        </div>

    </div>

@stop

@section('miscellaneous-html')

    @include('parts.add-form-elements')

    <div id="body-overlay"></div>

    @include('parts.basket-popups')

    @include('parts.profile-page-pop-ups', ['userCampaign' => isset($userCampaign) ? $userCampaign : null, 'stripeUrl' => isset($stripeUrl) ? $stripeUrl : null])

    <div id="fb-root"></div>

    <input type="hidden" id="share_current_page" value="userhome">

    @php
        $url = 'userhome_'.$user->id;
        $userImageName = $user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $user->profile->profile_display_image_original;
        $shareURL = route('url.share', ['userName' => $user->name, 'imageName' => base64_encode($userImageName), 'url' => $url]);
    @endphp

    <input type="hidden" id="url_share_user_name" value="{{$user->name}}">

    <input type="hidden" id="url_share_link" value="{{$shareURL}}">

    <input type="hidden" id="twitter_user_name" value="{{config('services.twitter.user_name')}}">

    <input type="hidden" id="item_share_title" value="">

    <input type="hidden" id="item_share_link" value="">

    <div style="display: none;" id="further_skill_each_item_temp">
        <div class="profile_custom_drop_each">
            <div class="profile_custom_drop_title"></div>
            <div class="profile_custom_drop_icon">
                <i class="fa fa-times"></i>
            </div>
        </div>
    </div>
    <input type="hidden" id="stripe_publishable_key" value="{{config('constants.stripe_key_public')}}">
@stop

@section('bottom-section')
@stop







