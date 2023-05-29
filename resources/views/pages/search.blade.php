@extends('templates.advanced-template')



@section('pagetitle') 1Platform License  @endsection

@section('page-level-css')

    <link rel="stylesheet" href="{{ asset('jquery-range-selector/jquery.slider.min.css?v=1.1') }}" type="text/css" media="none" class="switchmediaall">
    <link rel="stylesheet" href="{{asset('css/site-home.css?v=1.18')}}"></link>
    <link rel="stylesheet" href="{{asset('css/search.css?v=1.12')}}"></link>

@stop


@section('page-level-js')

  	<script type="text/javascript" src="{{asset('js/site-home.min.js') }}"></script>
    
    <script>
        
        var currentTabId = sessionStorage.getItem("current_search_tab_id");
        if(currentTabId && currentTabId != ''){
        	$('.each_main_tab#'+currentTabId).addClass('active');
        	var contentId = $('.each_main_tab#'+currentTabId).data('id');
        }else{
        	$('.each_main_tab').first().addClass('active');
        	var contentId = $('.each_main_tab').first().data('id');
        }
        //$('.each_search_result, .each_card').addClass('instant_hide');
        $('.each_search_result:not(#result_01), .each_card').addClass('instant_hide');
		$('#'+contentId).removeClass('instant_hide');

        $('body').addClass('search_outer');
        

		$('.each_main_tab:not(#edit_search)').click(function(){

			//var id = $(this).data('id');
			//$('.each_main_tab').removeClass('active');
			//$(this).addClass('active');
			//$('.each_search_result, .each_card').addClass('instant_hide');
			//$('#'+id).removeClass('instant_hide');
			//var currentTabId = sessionStorage.setItem("current_search_tab_id", $(this).attr('id'));
		});
		$('.card_sub_tab').click(function(){

			var id = $(this).data('id');
			$('.card_sub_tab').removeClass('active');
			$(this).addClass('active');
			$('.card_sub_content').removeClass('active').addClass('instant_hide');
			$('.card_sub_content[id="'+id+'"]').addClass('active').removeClass('instant_hide');
		});
		$('.card_check_label').unbind('click').click(function(e){
			
			e.preventDefault();
			if($(this).hasClass('checked')){
				$(this).removeClass('checked');
			}else{
				$(this).addClass('checked');
			}

			var checkbox = $(this).find('input[type="checkbox"]');
        	checkbox.prop("checked", !checkbox.prop("checked"));
		});
		$('.card_main_btn').click(function(){

			if($(this).attr('type') == 'apply_filters'){

				$('form#apply_filters').submit();
			}
			if($(this).attr('type') == 'strip_filters'){

			}
		});
		$('#edit_search, .no_results_retry').click(function(){

			$('.each_search_result, .each_card').addClass('instant_hide');
			var tabId = $('.each_main_tab.active').attr('id');
			if(tabId == 'tab_01'){
				$('#card_01').removeClass('instant_hide');
			}
			if(tabId == 'tab_02'){
				$('#card_02').removeClass('instant_hide');
			}
		});

		var loadMoreScroll = 130;
        var loadInitialMusics = 10;
        var loadInitialArtists = 10;
        var loadMoreItems = 5;
		$('.each-music, .each_artist').hide();
        $("#result_01 .each-music").slice(0, loadInitialMusics).show();
        $("#result_02 .each_artist").slice(0, loadInitialArtists).show();

        $('document').ready(function(){

        	$("#result_01 .result_load_more").on('click', function (e) {
	            e.preventDefault();
	            var parent = $(this).parent();
	            parent.find(".each-music:hidden").slice(0, loadMoreItems).slideDown( "slow", function() {

		            $('html,body').animate({
		                scrollTop: $(window).scrollTop() + (loadMoreScroll*loadMoreItems) 
		            }, 1000);
		        });
	            if (parent.find(".each-music:hidden").length == 0) {
		            parent.find(".result_load_more").fadeOut('slow');
		        }
	        });
	        $("#result_02 .result_load_more").on('click', function (e) {
	            e.preventDefault();
	            var parent = $(this).parent();
	            parent.find(".each_artist:hidden").slice(0, loadMoreItems).slideDown( "slow", function() {

		            $('html,body').animate({
		                scrollTop: $(window).scrollTop() + (loadMoreScroll*loadMoreItems) 
		            }, 1000);
		        });
	            if (parent.find(".each_artist:hidden").length == 0) {
		            parent.find(".result_load_more").fadeOut('slow');
		        }
	        });

	        $('.artist_search_icon').click(function(){

	        	if($('.artists_search').val().length){
	        		$('form#artist_search').submit();
	        	}
	        });
            musicHoverSupport();
        });

        var browserWidth = $( window ).width();
        if( browserWidth <= 767 ) {

            $('.pre_header_banner img').attr('src', '/images/banner7_res.jpg');
        }

        $('.pre_search_genre').click(function(){

            var id = $(this).attr('data-genre');
            if($('input[name="genre[]"][value='+id+']').length){

                $('input[name="genre[]"][value='+id+']').prop('checked', true);
                $('form#apply_filters').submit();
            }
        });
        $('.pre_search_mood').click(function(){

            var id = $(this).attr('data-mood');
            if($('input[name="mood[]"][value='+id+']').length){

                $('input[name="mood[]"][value='+id+']').prop('checked', true);
                $('form#apply_filters').submit();
            }
        });

    </script>

@stop



@section('preheader')

@stop


@section('page-background')

    <div data-url="https://{{Config('constants.primaryDomain')}}/images/license_back_2.jpg" class="pg_back back_inactive"></div>

@stop


@section('header')
	
	<div class="hide_on_mobile">
	    @include('parts.header')
	</div>
@stop

<!-- Page Header !-->



@section('social-media-html')

    <div id="fb-root"></div>

    <input type="hidden" id="share_current_page" value="search">

    @php
        $url = 'search_0';
        $shareURL = route('url.share', ['userName' => '1Platform license', 'imageName' => base64_encode('1a_right_license.png'), 'url' => $url]);
    @endphp


    <input type="hidden" id="url_share_user_name" value="1Platform License">

    <input type="hidden" id="url_share_link" value="{{$shareURL}}">

    <input type="hidden" id="item_share_title" value="">
    
    <input type="hidden" id="item_share_link" value="">

@stop


@section('audio-player')

	@include('parts.audio-player')

@stop
@section('top-center')
	@php $slides = \App\Models\ScrollerSetting::all() @endphp
	@if(count($slides))
	<div class="auth_carosel_section auth_carosel_user">
		<div class="recent_users">NEW ON 1PLATFORM</div>
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
    <div class="search_center_outer">
        <div class="search_center_inner">
        	<!--<div class="search_main_tabs_outer">
		        <div class="search_main_tabs_inner">
		            <div class="each_main_tab" id="tab_01" data-id="{{ ($show_search_results) ? 'result_01' : 'card_01' }}">Licensing</div>
		            <div class="each_main_tab" id="tab_02" data-id="{{ ($show_artist_search_results) ? 'result_02' : 'card_02' }}">Artist</div>
		            <div class="each_main_tab" id="tab_03" data-id="card_03">Hosts</div>
		            <div class="each_main_tab hide_on_desktop" id="edit_search" >
		            	@if($show_search_results || $show_artist_search_results)
		            		Clear
		            	@else
		            		&nbsp;
		            	@endif
		            </div>
                    <div class="each_main_tab hide_on_mobile" id="edit_search" >
                    	@if($show_search_results || $show_artist_search_results)
                    		Clear Search
                    	@else
                    		&nbsp;
                    	@endif
                    </div>
		        </div>
		    </div>!-->
		    <div id="result_02" class="each_search_result search_artist_results instant_hide">
		    	<div class="search_choices_outer">
	                <div class="search_choices_inner">
	                    <div id="ch_gp_02" class="choice_group active">
	                    	@if(isset($search_filters['artist']))
	                    	<div class="each_choice">{{ $search_filters['artist'] }}</div>
	                    	@endif
	                    </div>
	                </div>
	            </div>
	            @if($artist_search_results && $artist_search_results->count() > 0)
	            <div class="result_counter">Results ({{ $artist_search_results->count() }})</div>
	            @foreach($artist_search_results as $key => $user)
		            @include('parts.search-result-artist', ['user' => $user])
		        @endforeach
	            @elseif($artist_search_results && $artist_search_results->count() == 0)
	            <div class="no_results_retry">TRY A NEW SEARCH?</div>
	            <div class="no_results">We Have Found Nothing</div>
	            @endif

	            @if($artist_search_results && count($artist_search_results) > 10)
		    	<div class="result_load_more">Load More</div>
		    	@endif
		    </div>
        	<div id="result_01" class="each_search_result search_results">
        		<!--<div class="search_choices_outer">
	                <div class="search_choices_inner">
	                    <div id="ch_gp_01" class="choice_group active">
	                    	@if(isset($search_filters['genres']) && is_array($search_filters['genres']) && count($search_filters['genres']))
		                    	@foreach($search_filters['genres'] as $key => $searchGenre)
		                    		<div class="each_choice">Genre: {{ $searchGenre }}</div>
		                    	@endforeach
	                    	@endif
	                    	@if(isset($search_filters['moods']) && is_array($search_filters['moods']) && count($search_filters['moods']))
		                    	@foreach($search_filters['moods'] as $key => $searchMood)
		                    		<div class="each_choice">Mood: {{ $searchMood }}</div>
		                    	@endforeach
	                    	@endif
	                    	@if(isset($search_filters['bpm_range']) && is_array($search_filters['bpm_range']) && count($search_filters['bpm_range']) == 2)
	                    		<div class="each_choice">{{ $search_filters['bpm_range'][0] }}-{{ $search_filters['bpm_range'][1] }} BPM</div>
	                    	@endif
	                    	@if(isset($search_filters['instruments']) && is_array($search_filters['instruments']) && count($search_filters['instruments']))
		                    	@foreach($search_filters['instruments'] as $key => $searchInstrument)
		                    		<div class="each_choice">Instrument: {{ $searchInstrument }}</div>
		                    	@endforeach
	                    	@endif
	                    </div>
	                </div>
	            </div>!-->
                @php 
                    $music_search_results = \App\Models\UserMusic::inRandomOrder()->get()->filter(function ($music) {
                        return (!$music->privacy || count($music->privacy) == 0 || !isset($music->privacy['status']) || $music->privacy['status'] == 0) && $music->user && $music->user->isSearchable() == 1;
                    })
                @endphp 
	            <div class="search_result_outer">
	                <div class="search_result_inner">
	                	<!--
	                	@if($music_search_results && $music_search_results->count() > 0)
	                    <div class="result_counter">Results ({{ $music_search_results->count() }})</div>
	                    @elseif($music_search_results && $music_search_results->count() == 0)
	                    <div class="no_results_retry">TRY A NEW SEARCH?</div>
	                    <div class="no_results">We Have Found Nothing</div>
	                    @endif
	                    !-->
	                    <div class="result_rows">
	                    	@if($music_search_results)
		                        @foreach($music_search_results as $key => $music)
		                        	@if(count($music->privacy) && isset($music->privacy['status']) && $music->privacy['status'] == '1')
                                        
                                    @else
                                        @include('parts.user-channel-music-template',['music'=>$music])
                                    @endif
		                        @endforeach
	                        @endif
	                    </div>
	                    @if($music_search_results && count($music_search_results) > 10)
	                    <div class="result_load_more">Load More</div>
	                    @endif
	                </div>
	            </div>
        	</div>
        	<div class="search_cards instant_hide">
        		<form id="apply_filters" action="{{ route('search') }}" method="post">
        			{{ csrf_field() }}
	        		<div id="card_01" class="each_card instant_hide">
		            	<div class="card_header">
		            		<div data-id="card_01_01" class="card_sub_tab active">
		            			<div class="name">Genre</div>
		            		</div>
		            		<div data-id="card_01_02" class="card_sub_tab">
		            			<div class="name">Mood</div>
		            		</div>
		            		<div data-id="card_01_03" class="card_sub_tab">
		            			<div class="name">BPM</div>
		            		</div>
		            		<div data-id="card_01_04" class="card_sub_tab">
		            			<div class="name">Instrument</div>
		            		</div>
		            	</div>
		            	<div class="card_body">
		            		<div id="card_01_01" class="card_sub_content">
		            			<div class="card_heading">FILTER</div>
		            			<div class="card_content">
		            				@foreach($genres as $genre)
		            				<label class="card_check_label">
		            					<input class="card_check" type="checkbox" name="genre[]" value="{{ $genre->id }}">
		            					{{ $genre->name }}
		            				</label>
		            				@endforeach
		            			</div>
		            		</div>
                            @php $moods = \App\Models\Mood::orderBy('id', 'asc')->get() @endphp
		            		<div id="card_01_02" class="card_sub_content instant_hide">
		            			<div class="card_heading">FILTER</div>
		            			<div class="card_content">
                                    @foreach($moods as $mood)
		            				<label class="card_check_label">
                                        <input class="card_check" type="checkbox" name="mood[]" value="{{$mood->name}}">
                                        {{$mood->name}}
                                    </label>
                                    @endforeach
		            			</div>
		            		</div>
		            		<div id="card_01_03" class="card_sub_content instant_hide">
		            			<div class="card_heading">FILTER</div>
		            			<div class="card_content">
		            				<div class="layout-slider">
								    	<div class="slider_contain">
								    		<div id="custom_range_from" class="custom_range">0</div>
								    		<input id="Slider1" type="slider" name="bpm" value="0;250" />
								    		<div id="custom_range_to" class="custom_range">250+</div>
								    	</div>
								    </div>
		            			</div>
		            		</div>
		            		<div id="card_01_04" class="card_sub_content instant_hide">
		            			<div class="card_heading">FILTER</div>
		            			<div class="card_content">
		            				@foreach($instruments as $instrument)
		            				<label class="card_check_label">
		            					<input class="card_check" type="checkbox" name="instrument[]" value="{{ $instrument->value }}">
		            					{{ $instrument->value }}
		            				</label>
		            				@endforeach
		            			</div>
		            		</div>
		            	</div>
		            	<br><br>
		            	<div type="apply_filters" class="card_main_btn smart_btn">Apply Filters</div>
		            	
                        <div class="card_pre_search">
                            <div class="card_pre_search_each">
                                <div data-genre="13" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/01.jpg')}}">
                                </div>
                                <div data-genre="10" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/02.jpg')}}">
                                </div>
                                <div data-genre="" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/03.jpg')}}">
                                </div>
                            </div>
                            <div class="card_pre_search_each">
                                <div data-genre="26" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/04.jpg')}}">
                                </div>
                                <div data-genre="2" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/05.jpg')}}">
                                </div>
                                <div data-genre="18" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/06.jpg')}}">
                                </div>
                            </div>
                            <div class="card_pre_search_each">
                                <div data-genre="11" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/07.jpg')}}">
                                </div>
                                <div data-genre="36" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/08.jpg')}}">
                                </div>
                                <div data-genre="31" class="card_each_pre pre_search_genre">
                                    <img src="{{asset('images/presearch/09.jpg')}}">
                                </div>
                            </div>
                        </div>
		            </div>
		        </form>
		        <form id="artist_search" action="{{ route('search') }}" method="post">
        			{{ csrf_field() }}
		            <div id="card_02" class="each_card instant_hide">
		            	<div class="artists_inner">
			            	<h4 class="artists_title">ENTER YOUR SEARCH</h4>
			            	<div class="artist_field_inner">
			            		<input class="artists_search" type="text" name="artists_search" />
			            		<span class="artist_search_icon">
			            			<i class="fa fa-search vertical_center"></i>
			            		</span>
			            	</div>
			            </div>
		            	<br><br>
		            </div>
		        </form>
		        <div id="card_03" style="font-size: 14px; color:#fff;margin: 20px;" class="each_card instant_hide">Host Search Coming Soon</div>
        	</div>
        </div>
    </div>

@stop




@section('top-right')

@stop




@section('top-left')

    <div class="ch_tab_sec_outer search_right_outer top_right_chart">

        <div class="panel main_panel desktop-only">

            <div class="ch_bag_pric_sec bio_sec desktop-only">

                <div class="fund_raise_left">

                    <img class="bio_sec_percent_image a_percent" src="{{asset('images/1a_right_license.png')}}" alt="#" />
                    <h3 class="project_line"></h3>
                    <div class="fund_raise_status">
                    
                    </div>

                </div>

                <div class="fund_raise_right">

                    <div class="pricing_setail">

                        

                    </div>

                </div>

            </div>

            <div class="social_btns desktop-only clearfix">

                <ul class="clearfix">

                    <li>
                        <a id="facebook_share_url" onclick="return facebookShare('url')" class="ch_sup_fb" href="javascript:void(0)">
                            <i class="fab fa-facebook-f"></i>
                        </a> 
                    </li>
                    <li>
                        <a id="twitter_share_url" onclick="return twitterShare('url')" class="ch_sup_tw" href="javascript:void(0)">
                            <i class="fab fa-twitter"></i>
                        </a> 
                    </li>
                    <li>
                        <a class="ch_sup_feature_tab chart_disabled full_support_me" href="javascript:void(0)">
                            <i class="fas fa-dollar-sign"></i>
                        </a>
                    </li>
                </ul>

            </div>

        </div>
        <div id="double_card_container"></div>

    </div>

@stop



@section('bottom-row-full-width')

@stop



@section('slide')
    

@stop



@section('miscellaneous-html')
    
    <div id="body-overlay"></div>
	<input type="hidden" id="search_filters" value="{{ json_encode($search_filters) }}">
    @include('parts.chart-popups')
@stop

