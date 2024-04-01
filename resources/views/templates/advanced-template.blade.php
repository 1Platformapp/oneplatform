<!doctype html>

<html lang="en">

	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="google-site-verification" content="AR1UIRB4nzeneJoD1RppX4OOJKzdrH3GLDc7O1jix9Q">
	    <meta name="csrf-token" content="{{ csrf_token() }}">
	    <title>@yield('pagetitle')</title>

	    @yield('pagekeywords', '')

	    @yield('pagedescription', '')

	    @if(\Request::route()->getName() == 'site.home' || \Request::route()->getName() == 'user.home' || \Request::route()->getName() == 'custom.domain.home')
	    	<link rel="canonical" href="{{asset('')}}">
	    @else
	    	<link rel="canonical" href="{{url()->current()}}">
	    @endif

	    @if(isset($userParams) && $user && $user->favicon_icon)
	        <link rel="icon" href="{{asset('user-media/favicon/'.$user->favicon_icon)}}" type="image/x-icon" />
	    @else
	        <link rel="icon" href="{{asset('favicon.ico?v=1.1')}}" type="image/x-icon" />
	    @endif

	    @if(parse_url(request()->root())['host'] == 'www.singingexperience.co.uk')
	    <link rel="apple-touch-icon" href="{{asset('apple-touch-icon-se.png')}}">
	    @endif
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.5/mediaelementplayer.min.css" class="switchmediaall">
	    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}" class="switchmediaall">
	    <link rel="stylesheet" href="{{asset('player-element/dist/jump-forward/jump-forward.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/skip-back/skip-back.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/speed/speed.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/chromecast/chromecast.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/context-menu/context-menu.min.css')}}">
	    <link href="{{asset('css/style.min.css?v=3.3')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('css/frontend.min.css?v=3.17')}}" rel="stylesheet" type="text/css">
        <link href="/css/app.css?v=3.68" rel="stylesheet" type="text/css" />

	    <script src="{{asset('js/jquery.min.js')}}"></script>
	    <script defer src="{{asset('js/my_script.min.js?v=9.9')}}"></script>
	    <script src="{{asset('js/load_defer.min.js?v=1.11')}}"></script>

	    @yield('page-level-css','')

	    @yield('page-level-js','')

	    @if(isset($userParams))
	        @if($user->private == 1)
	        <meta name="robots" content="noindex, nofollow" />
	        @elseif($user->customDomainSubscription && $user->customDomainSubscription->status == 1 && $userParams != 'customDomain')
	        <meta name="robots" content="noindex, nofollow" />
	        @else
	        <meta name="robots" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1" />
	        @endif
	    @else
	    <meta name="robots" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1" />
	    @endif

	</head>

	<body>

	    <section class="wrapper_outer">

	    	<header>

	    		@yield('header','')

	    	</header>

	        <aside>
		        <div class="clearfix hrd_cart_outer">
		            @include('parts.smart-cart')
		        </div>

		        @include('parts.smart-notifications')

		        @if(!isset($user) || !$user->isCotyso() || Auth::check())
		        <div class="clearfix tv_slide_out_outer">
		            @include('parts.smart-tv-slide-out')
		        </div>

		        @include('parts.smart-user-menu')

		        @endif

		        @if(\Route::current()->getName() != 'site.home')
		            @include('parts.basket-popups')
		        @endif
		    </aside>

		    <aside>
	        	@yield('preheader')

		       	@yield('imp-notice','')
		    </aside>

	        <section>

	        	@yield('seocontent')

		        <section class="content_outer">

		            @yield('page-background','')

		            <section class="auto_content">

		                @yield('flash-message-container','')

		                <section class="clearfix content_inner">

		                	<section class="ch_cent_right_outer">

		                		@yield('social-media-html','')

		                		@yield('top-center','')

		                		@yield('top-right','')

		                	</section>

		                	<aside class="ch_left_sec_outer">

		                		@yield('top-left','')

		                	</aside>

		                	<aside class="ch_bottom_full_outer">

		                		@yield('bottom-row-full-width','')

		                		@yield('miscellaneous-html','')

		                		<div data-basket="" data-user="" id="post_cart_toast" class="post_cart_toast">
		                		    <div class="toast_inner">
		                		        <div class="message">Added to cart</div>
		                		        <div id="undo" class="each_option">Undo</div> |
		                		        <div id="continue" class="each_option">Continue</div> |
		                		        <div id="checkout" class="each_option">Checkout</div>
		                		    </div>
		                		    <div id="close" class="action"><i class="fa fa-times"></i></div>
		                		</div>

		                		<div data-type="" data-bonusid="" data-total="" data-delivery="" data-deliverytext="" id="crowd_funder_toast" class="post_cart_toast">
		                		    <div class="toast_inner">
		                		        <div class="message"></div>
		                		        <div id="undo" class="each_option">Undo</div> |
		                		        <div id="continue" class="each_option">Continue</div> |
		                		        <div id="crowd_checkout" class="each_option">Checkout</div>
		                		    </div>
		                		    <div id="close" class="action"><i class="fa fa-times"></i></div>
		                		</div>

		                		<div id="share_item_toast" class="post_cart_toast">
		                		    <div class="toast_inner">
		                		        <div class="message"></div>
		                		        <div class="share_body">
		                		            <div id="share_item_fb" class="each_option">
		                		                <i class="fab fa-facebook-f"></i>
		                		            </div>
		                		            <div id="share_item_tw" class="each_option">
		                		                <i class="fab fa-twitter"></i>
		                		            </div>
		                		            <div id="share_item_mobile_menu" class="each_option hide_on_desktop">
		                		                <i class="fa fa-share"></i>
		                		            </div>
		                		            <div id="share_item_copy" class="each_option">Copy Link</div>
		                		        </div>
		                		    </div>
		                		    <div id="close" class="action"><i class="fa fa-times"></i></div>
		                		</div>

		                	</aside>

		                </section>

		            </section>

		            @yield('slide','')

		        </section>
		    </section>

		    <footer>
		    	@yield('footer','')
		    </footer>

		    <aside>
		    	<div id="to_top"><i class="fa fa-angle-up"></i></div>
		    </aside>

	    </section>

	    <aside>
		    @yield('audio-player')
		</aside>

		<input type="hidden" id="facebook_app_id" value="{{ config('services.facebook.client_id') }}">
		<input type="hidden" id="twitter_user_name" value="{{ config('services.twitter.user_name') }}">
		<input type="hidden" id="base_url" value="{{trim(route('site.home'), '/')}}">
		<input type="hidden" id="platform" value="1">

		@if(parse_url(request()->root())['host'] == 'www.singingexperience.co.uk')
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-124898766-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-124898766-1');
		</script>
		@endif
	</body>
</html>
