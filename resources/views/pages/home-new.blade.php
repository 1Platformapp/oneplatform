@extends('templates.basic-template')


@section('pagetitle') 1 Platform | Artists, Producers, Musicians, Content Creators @endsection

@section('pagekeywords')
    <meta name="keywords" content="artists,musicians,discover music,songs,songwriters,producers,filmmakers,raise money,promote music,sell music, content creators,connect people,networking,distribution,premium streams,creative,business,sell,music,music license,crowdfunding,studios,online store,gigs,merchandise,bespoke license,music industry" />
@endsection

@section('pagedescription')
    <meta name="description" content="1Platform is for artists to sell music licenses,products,tickets or raise money through crowdfunding. Discover music and support its creators"/>
@endsection

@section('seocontent')
    <h1 class="main_heading">1 Platform is for artists, producers, musicians, content creators</h1>
@endsection

@section('page-level-css')
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}" >
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/portfolio.min.css')}}"></link>
    <link rel="stylesheet" href="{{asset('css/site-home.css?v=1.18')}}"></link>
@stop

@section('page-level-js')
    <script type="text/javascript" src="{{asset('js/site-home.min.js') }}"></script>
@stop

@section('header')
    @include('parts.header')
@stop


@section('flash-message-container')
    @if (Session::has('success'))
        <div style="margin: 0;" class="success_span">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('music_search_filters'))
        @php Session::put('remember_music_search_filters', Session::get('music_search_filters')) @endphp
    @endif
@stop

@section('social-media-html')
@stop


@section('page-content')

                <div class="auto_content">
                    <div class="dsk_her">
                    	<div class="dsk_left">
							<p class="dsk_main_title">1 Platform Management</p>
	                        <!--<div class="dsk_support_outer">
	                            <div class="dsk_support_each">Artists</div>
	                            <div class="dsk_support_each">Producers</div>
	                            <div class="dsk_support_each">Musicians</div>
	                            <div class="dsk_support_each">Creators</div>
	                            <div class="dsk_support_each">Videographers</div>
	                            <div class="dsk_support_each">Photographers</div>
	                            <div class="dsk_support_each">Marketers</div>
	                            <div class="dsk_support_each">Managers</div>
	                            <div class="dsk_support_each">Agents</div>
	                            <div class="dsk_support_each">Producers</div>
	                            <div class="dsk_support_each">Studios</div>
	                            <div class="dsk_support_each">Tuition</div>
	                        </div>!-->
	                        <p class="dsk_sub_title">
	                            Everything creative & business in one place
	                        </p>
	                        <div class="dsk_tools">
	                            @if(!Auth::check())
	                            <a href="{{route('register')}}" id="dsk_signup">
	                            	<i class="fa fa-comment-dots"></i>
	                            	Create an account
	                            </a>
	                            <a href="{{route('login')}}" id="dsk_signin">Sign in</a>
	                            @else
	                            <a href="{{route('agency.dashboard')}}" id="dsk_dashboard">
	                                <span id="dsk_dash_left">
	                                    <img src="{{asset('images/user-default-thumb.jpg')}}" />
	                                </span>
	                                <span>
	                                    MY ACCOUNT
	                                </span>
	                            </a>
	                            @endif
	                        </div>
                    	</div>
                    	<div class="dsk_right">
                    		<video poster="{{asset('images/home-poster.jpg')}}" controls id="myVideo">
							  <source src="{{asset('videos/1platform_revised.mp4')}}" type="video/mp4">
							  Your browser does not support HTML5 video.
							</video>
                    	</div>
                    </div>
                    <div class="app_download">
                        <a class="app_download_ic" href="#">
                            <img src="{{asset('images/android-app-download.png')}}">
                        </a>
                        <a class="app_download_ic" href="#">
                            <img src="{{asset('images/ios-app-download.png')}}">
                        </a>
                    </div>
                    @php $slides = \App\Models\ScrollerSetting::all() @endphp
                    @if(count($slides))
                    <div class="auth_carosel_section auth_carosel_user">
                        <div class="auth_carosel_in">
                        	@foreach($slides as $slide)
                        	@php $details = 0 @endphp
                        	@php
                        		$commonMethods = new \App\Http\Controllers\CommonMethods();
                        		if($slide->type == 'user' and $slide->user and $slide->user->active == 1){
                        			$details = $commonMethods->getUserRealCampaignDetails($slide->user_id);
                        			$thumb = $details['campaignUserInfo']['profileImageCarosel'];

                        	        if($details['campaignIsLive'] == '1' && $details['campaignStatus'] == 'active'){
                        	            $hasCrowdFundd = 1;
                        	            $link = $details['campaignUserInfo']['projectPage'];
                        	        }else{
                        	            $hasCrowdFundd = 0;
                        	            $link = $details['campaignUserInfo']['homePage'];
                        	        }

                        		}else if($slide->type == 'stream' && $slide->stream){
                        			$details = $slide->stream;
                        			$thumb = 'https://i.ytimg.com/vi/'.$details->youtube_id.'/mqdefault.jpg';
                        			$link = route('tv');
                        		}
                        	@endphp
                        	@if($details)
                            <div data-id="{{$slide->id}}" data-link="{{$link}}" class="auth_each_carosel">
                                <div class="auth_carosel_img">
                                    <img alt="{{$slide->type == 'user' ? $details['campaignUserInfo']['name'].' is featured on 1platform' : $details->name}}" src="{{$thumb}}">
                                </div>
                                <div class="auth_carosel_name">
                                    @if($slide->type == 'user')
                                    	{{$details['campaignUserInfo']['name']}}
                                    @elseif($slide->type == 'stream')
                                    	{{$details->name}}
                                    @endif
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="auth_carosel_nav">
                            <div class="auth_carosel_nav_each auth_carosel_back disabled">
                                <i class="fa fa-angle-left"></i>
                            </div>
                            <div class="auth_carosel_nav_each auth_carosel_animate animating disabled">
                                <i class="fa fa-play"></i>
                            </div>
                            <div class="auth_carosel_nav_each auth_carosel_next disabled">
                                <i class="fa fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    @php $programs = \App\Models\SiteProgram::orderBy('order' ,'asc')->get() @endphp
                    @if(count($programs))
                    <div class="home_each_section home_section_portfolio">
                    	<h2>Discover <span>1</span>Platform</h2>
                    	<div class="portfolio_outer">
    	                	<div class="portfolio_det_outer"></div>
    	                	<div class="portfolio_each_contain">
    	                		@foreach($programs as $program)
    			                <div data-id="{{$program->id}}" class="portfolio_each site_program">
    			                    <div class="each_port_up">
    			                        <div class="drop"></div>
    			                        <div class="back back_inactive hide_on_mobile" data-url="https://duong.1platform.tv/public/program-images/{{$program->displayImage()}}"></div>
    			                        <img alt="{{$program->title}}" class="defer_loading hide_on_desktop" src="https://duong.1platform.tv/public/program-images/{{$program->displayImage()}}" />
    			                        <span>View Details</span>
    		                            <div class="cloader"><div></div><div></div><div></div></div>
    			                    </div>
    			                    <div class="each_port_down">
    			                        <div class="each_port_name">
    			                            {{$program->title}}
    			                        </div>
    			                    </div>
    			                </div>
    			                @endforeach
    	                	</div>
                    	</div>
                    </div>
                    @endif
                    @php $packages = config('constants.user_internal_packages') @endphp
                    <!--<div class="home_each_section home_section_packages hide_on_mobile">
                        <div class="int_sub_outer">
                            <div class="int_sub_inner">
                                <div class="int_sub_nav_outer hide_on_desktop">
                                    <div class="int_sub_nav_btn int_nav_btn_prev">
                                        <i class="fa fa-caret-left"></i>
                                    </div>
                                    <div class="int_sub_nav_btn int_nav_btn_next">
                                        <i class="fa fa-caret-right"></i>
                                    </div>
                                </div>
                                <div class="int_sub_liner">
                                    <div class="int_sub_head">
                                        <div class="int_sub_head_up">Subscriptions</div>
                                    </div>

                                    <div class="int_sub_dhead">Price</div>
                                    <div class="int_sub_offer_outer">
                                        <div class="int_sub_offer_each"><span class="hide_on_mobile">Choose </span>Payment Plan</div>
                                        <div class="int_sub_offer_each">&nbsp;</div>
                                        <div class="int_sub_offer_each">
                                            <span> Fee Per Sale </span>
                                            <a href="https://stripe.com/gb/pricing" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                    <path fill="currentColor" fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0a8 8 0 0 1 16 0m-7 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-1-9a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="int_sub_offer_each">
                                            <span class="hide_on_mobile">Connect a&nbsp;</span>Custom Domain
                                        </div>
                                        <div class="int_sub_offer_each">
                                            Max Disk Usage
                                        </div>
                                        <div class="int_sub_offer_each">
                                            Network Associates
                                        </div>
                                        <div class="int_sub_offer_each">
                                            Legal Contracts
                                        </div>
                                        <div class="int_sub_offer_each">
                                            Free From Adverts
                                        </div>
                                        <div class="int_sub_offer_each">
                                            <span class="hide_on_mobile">Access To&nbsp;</span>Industry Contacts
                                        </div>
                                        <div class="int_sub_offer_each">
                                            Get Pro Agent
                                        </div>
                                    </div>
                                </div>
                                <div class="int_sub_act_outer">

                                    <div class="int_sub_each pro_hover">
                                        <div class="int_sub_head">
                                            <div class="int_sub_head_up">{{ucfirst($packages[1]['name'])}}</div>
                                        </div>
                                        <div class="int_sub_dhead">
                                            <div class="inner">
                                                <sup>&pound;</sup>
                                                <p>{{$packages[1]['pricing']['month']}}</p>
                                            </div>
                                            <div class="int_sub_dhead_interval">per month</div>
                                        </div>
                                        <div class="int_sub_offer_outer">
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_term_switch">
                                                    <div data-name="{{$packages[1]['name']}}" data-price="{{$packages[1]['pricing']['month']}}" data-term="month" class="int_sub_term_each active">Monthly</div>
                                                    <div data-name="{{$packages[1]['name']}}" data-price="{{$packages[1]['pricing']['year']}}" data-term="year" class="int_sub_term_each">Yearly</div>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_confirm int_sub_pay">Sign Up</div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                {{$packages[1]['application_fee']}}%
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                {{$packages[1]['volume']}}GB
                                            </div>
                                            <div class="int_sub_offer_each">
                                                {{$packages[1]['network_limit']}}
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_no">
                                                    <i class="fa fa-times"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="int_sub_each pro_hover">
                                        <div class="int_sub_head">
                                            <div class="int_sub_head_up">{{ucfirst($packages[2]['name'])}}</div>
                                        </div>
                                        <div class="int_sub_dhead">
                                            <div class="inner">
                                                <sup>&pound;</sup>
                                                <p>{{$packages[2]['pricing']['month']}}</p>
                                            </div>
                                            <div class="int_sub_dhead_interval">per month</div>
                                        </div>
                                        <div class="int_sub_offer_outer">
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_term_switch">
                                                    <div data-name="{{$packages[2]['name']}}" data-price="{{$packages[2]['pricing']['month']}}" data-term="month" class="int_sub_term_each active">Monthly</div>
                                                    <div data-name="{{$packages[2]['name']}}" data-price="{{$packages[2]['pricing']['year']}}" data-term="year" class="int_sub_term_each">Yearly</div>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_confirm int_sub_pay">Sign Up</div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                {{$packages[2]['application_fee']}}%
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                {{$packages[2]['volume']}}GB
                                            </div>
                                            <div class="int_sub_offer_each">
                                                {{$packages[2]['network_limit']}}
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_offer_each">
                                                <div class="int_sub_offer_yes">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>!-->
                </div>
@stop

@section('miscellaneous-html')

    <div id="body-overlay"></div>

    <style>
    	@media (min-width:320px) and (max-width: 767px) {

    		.home_each_section { padding-top: 0 !important; }
    	}
	</style>
@stop
