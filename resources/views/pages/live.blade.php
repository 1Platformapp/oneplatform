@extends('templates.advanced-template')


@section('pagetitle') 1Platform Hosts @endsection


@section('page-level-css')
    <style>

        .page_title, .top_info_box, .top_info_text { font-size: 22px; }
        .tab_det_left_sec.tab_det_dsk { padding: 0 20px 20px; }
        .content_outer:not(.playing) { padding-top: calc(100vh - 318px) !important; }
        .tab_btns_outer.experts_tab_btns.tab_dsk .each_tab_btn { width: 17.5%; min-height: 50px; }
        .tab_btns_outer.experts_tab_btns:not(.tab_dsk) .each_tab_btn { width: 17.5%; min-height: 50px; }
        .experts_tab_btns.tab_dsk .tab_btn_expert_logo img { margin-top: 12px; }
        .live_center_outer .ch_tp_sec { padding: 20px 0 13px 0; }
        .live_outer #r_tab1 .tab_chanel_img_det { width: auto !important; }
        .live_outer .mejs__time-current, .live_outer .mejs__time-handle-content { background: #73e600 !important; }

        @media (min-width:1024px) and (max-width: 1365px) {
            .content_outer.playing { padding-top: calc(100vh - 318px) !important; }
        }
        @media (min-width:1366px){
            .content_outer.playing { padding-top: calc(100vh - 318px) !important; }
        }
        @media (max-width:767px){
            .content_outer .auto_content { position: relative; background: #fff; }
            .content_outer.playing { padding-top: 0 !important; }
        }
        @media (min-width:768px) and (max-width: 1024px) {
            .content_outer.playing { padding-top: calc(100vh - 318px) !important; }
        }
        @media (min-width:320px) and (max-width: 767px) {
            .each_chart_video .tab_chanel_img_det p { line-height: 16px; }
            .live_center_outer .ch_tp_sec_left .tp_sec_in_det { width: 61% !important; left: 41% !important; }
        }
    </style>
@stop



@section('page-level-js')

    <script defer src="/js/vertical-scroller.js" type="application/javascript"></script>


    <script defer src="/js/video-player.js" type="application/javascript"></script>

    <script defer src="/js/feat_items_scroller.js"></script>
    <script defer src="{{asset('js/jquery-ui.min.js')}}" type="application/javascript"></script>

    <script defer src="https://apis.google.com/js/platform.js"></script>

    <script type="text/javascript">

        window.currentUserId = {{$user ? $user->id : 0}};

        
        $('document').ready(function(){

            $('body').addClass('chart_outer');
            var browserWidth = $( window ).width();

            if( browserWidth <= 767 ) {

                $('.pre_header_banner img').attr('src', '/images/banner6_res.jpg').hide();
            }

            $('body').on( "click", ".each_user_video", function(e) {
                $('#soundcloudPlayer, .mejs__container').removeClass('instant_hide');
                $('.content_outer').addClass('playing');
            });
            $('body').on( "click", ".tab_btn_play_project,.tp_sec_play_project,.top_info_outer", function(e) {
                $('.mejs__container').removeClass('instant_hide');
                $('.content_outer').addClass('playing');
            });
        });
    </script>
@stop




@section('audio-player')
    
    @include('parts.audio-player')

@stop



@section('preheader')

    
@stop


@section('page-background')

    <div data-url="{{asset('images/expert_back_03.jpg')}}" class="pg_back back_inactive"></div>

@stop


@section('header')

    @include('parts.header')

@stop



@section('social-media-html')


    <div id="fb-root"></div>

    <input type="hidden" id="share_current_page" value="live">

    @php
        if($user){
            $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
            $url = 'live_'.$user->id;
            $userImageName = $user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $user->profile->profile_display_image_original;
            $shareVideoURL = route('vid.share', ['videoId' => $defaultVideoId, 'userName' => trim($user->name), 'url' => $url]);
            $shareURL = route('url.share', ['userName' => trim($user->name), 'userImage' => base64_encode($userImageName), 'url' => $url]);
        }else{
            $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
            $url = 'live_0';
            $shareVideoURL = route('vid.share', ['videoId' => $defaultVideoId, 'userName' => $shareVideoTitle, 'url' => $url]);
            $shareURL = route('url.share', ['userName' => '1Platform Hosts', 'userImage' => base64_encode('1a_right_expert.png'), 'url' => $url]);
        }
    @endphp

    <input type="hidden" id="video_share_id" value="{{$defaultVideoId}}">

    <input type="hidden" id="video_share_link" value="{{$shareVideoURL}}">

    <input type="hidden" id="video_share_title" value="{{$shareVideoTitle}}">


    <input type="hidden" id="url_share_user_name" value="{{$user?$user->name:'1Platform Hosts'}}">

    <input type="hidden" id="url_share_link" value="{{$shareURL}}">

@stop



@section('top-center')
    
    <div class="ch_center_outer">

        <div class="top_info_box hide_on_mobile">
            <div class="page_title">1Platform Hosts </div>
            <div class="top_info_outer" data-video-id="0cSXq4TYIIk">
                <div class="top_info_ic">
                    <i class="fa fa-caret-right"></i>
                </div>
                <div class="top_info_text">Info</div>
            </div> 
            <div class="top_info_right_icon">
                <i class="fa fa-share"></i>
            </div> 
        </div>

        <div class="tp_center_video_outer">

            <div class="jplayer_video_outer">

                <div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player" >

                    <div class="jp-type-single">

                        <div class="jp-gui">

                            <iframe class="instant_hide" id="soundcloudPlayer" width="100%" height="319" scrolling="no" frameborder="no" src="">
                            </iframe>
                            
                            <!--<video width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader instant_hide" preload="none">

                                <source type="video/youtube" src="https://www.youtube.com/watch?v={{ $defaultVideoId }}" />

                            </video>!-->
                            <video poster="{{asset('images/test/coming soon trials-01.jpg')}}" width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader" preload="none">

                                <source type="video/youtube" src="https://www.youtube.com/watch?v={{ $defaultVideoId }}" />

                            </video>
                            <div class="experts_tab_btns tab_btns_outer tab_dsk hide_on_mobile clearfix">

                                <div class="each_tab_btn tab_btn_expert_logo" data-show="#tabd1">
                                    <!--<a href="javascript:void(0)">
                                        <img src="{{asset('images/1a_bottom_expert.png')}}">
                                    </a>!-->
                                </div> 
                                <div class="each_tab_btn tab_btn_user_name fly_user_home disabled" data-initials="" data-show="">
                                    <div class="border_alter"></div>
                                </div>  
                                <div class="each_tab_btn tab_btn_music disabled" data-show="#tabd2">
                                    <div class="border"></div>
                                </div>
                                <div class="each_tab_btn tab_btn_fans disabled" data-show="#tabd3">
                                    <div class="border"></div>
                                </div>
                                <div class="each_tab_btn tab_btn_social disabled" data-show="#tabd4">
                                    <div class="border"></div>
                                </div>
                                <div class="each_tab_btn tab_btn_crowd_fund store disabled" data-show="#tabd6">
                                    <div class="border_alter">
                                        Store<br>Items
                                    </div>
                                    <div class="border"></div>
                                </div>
                                <div class="each_tab_btn tab_btn_video disabled" data-show="#tabd5">
                                    <div class="border"></div>
                                </div>
                                <div class="each_tab_btn tab_btn_tv" data-show=""></div> 
                            </div>

                            <div class="tab_det_left_sec tab_det_dsk">

                                <div style="display: none;" class="lazy_tab_img">
                                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{asset('img/lazy_loading.gif')}}">
                                </div>

                                <div id="tabd1" class="ch_tab_det_sec desktop-only">

                                    <div class="ch_tab_det_outer">


                                        <div id="r_tab1" class="r_tab_det" style="display:block ">

                                            @foreach($experts as $key=> $expert)

                                                    @if(!$expert->user || !$expert->user->profile) @php continue @endphp @endif

                                                    @php $profile = $expert->user->profile @endphp
                                                    <div data-skill="{{$expert->user->skills}}" class="tab_chanel_list each_user_video each_chart_video studio_page_video clearfix">

                                                        <a href="#">
                                                            <img class="" src="https://i.ytimg.com/vi/{{$profile->user_bio_video_id }}/mqdefault.jpg" alt="#" />
                                                        </a>
                                                        <div class="tab_chanel_img_det">
                                                            <a data-stream-type="user_bio_url" data-orig-image="{{$profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $profile->profile_display_image_original}}" data-stream-id="{{$profile->user_bio_video_id}}" href="javascript:void(0)" class="each_user_video_artist">
                                                                {{ substr($expert->user->name, 0, 40) }}
                                                            </a>
                                                            <p>{{ substr($expert->user->skills, 0, 40) }}</p>
                                                        </div>

                                                    </div>

                                                @endforeach

                                        </div>
                                        <br><div class="spacer"></div>
                                        <div class="scroller_outer">
                                            <div class="scroller_head">1Platform Latest</div>
                                            <div class="hm_lst_slid_outer">

                                                <div class="hm_lst_slid_inner clearfix">

                                                    <div data-max-slides="3" id="owl_content"></div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="tabd2" class="ch_tab_det_sec music_sec ">

                                    <br><br>
                                    <div class="lazy_tab_content"></div>
                                </div>

                                <div id="tabd3" class="ch_tab_det_sec fans_sec ">

                                    <br><br>
                                    <div class="lazy_tab_content"></div>
                                </div>

                                <div id="tabd4" class="ch_tab_det_sec social_sec ">

                                    <div class="lazy_tab_content"></div>
                                </div>

                                <div id="tabd5" class="ch_tab_det_sec">

                                    <div class="lazy_tab_content"></div>
                                </div>

                                <div id="tabd6" class="ch_tab_det_sec">

                                    <div class="lazy_tab_content"></div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@stop



@section('top-right')

@stop


@section('top-left')
    
    <div class="ch_tab_sec_outer mobile-only">
        <div class="experts_tab_btns tab_btns_outer clearfix">
            <div class="each_tab_btn tab_btn_expert_logo" data-show="#tab1">
                <!--<a href="javascript:void(0)">
                    <img src="{{asset('images/tab_experts_logo.png')}}">
                </a>!-->
            </div> 
            <div class="each_tab_btn tab_btn_user_name fly_user_home disabled" data-initials="" data-show="">
                <div class="border_alter"></div>
            </div>  
            <div class="each_tab_btn tab_btn_music disabled" data-show="#tab2">
                <div class="border"></div>
            </div>
            <div class="each_tab_btn tab_btn_fans disabled" data-show="#tab3">
                <div class="border"></div>
            </div>
            <div class="each_tab_btn tab_btn_social disabled" data-show="#tab4">
                <div class="border"></div>
            </div>
            <div class="each_tab_btn tab_btn_crowd_fund store disabled" data-show="#tab6">
                <div class="border_alter">
                    Store<br>Items
                </div>
                <div class="border"></div>
            </div>
            <div class="each_tab_btn tab_btn_video disabled" data-show="#tab5">
                <div class="border"></div>
            </div>
            <div class="each_tab_btn tab_btn_tv" data-show=""></div> 
        </div>
        <br>
        <div class="top_info_outer" data-video-id="0cSXq4TYIIk">
            <div class="top_info_ic">
                <img src="{{asset('images/tab_play_filled.png')}}">
            </div>
            <div class="top_info_text">INFO</div>
        </div>
        <br>
        <div class="">
            <div class="tab_det_inner tab_det_left_sec right_height_res user_home_left_bar">
                <div style="display: none;" class="lazy_tab_img">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{asset('img/lazy_loading.gif')}}">
                </div>
                <div id="tab1" class="ch_tab_det_sec bio_sec " style="display: block;">
                    <div class="user_videos_outer">
                        @foreach($experts as $key=> $expert)

                            @if(!$expert->user || !$expert->user->profile) @php continue @endphp @endif

                            @php $profile = $expert->user->profile @endphp
                            <div data-skill="{{$expert->user->skills}}" class="tab_chanel_list each_user_video each_chart_video studio_page_video clearfix">

                                <a href="#">
                                    <img class="" src="https://i.ytimg.com/vi/{{$profile->user_bio_video_id }}/mqdefault.jpg" alt="#" />
                                </a>
                                <div class="tab_chanel_img_det">
                                    <a data-stream-type="user_bio_url" data-orig-image="{{$profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $profile->profile_display_image_original}}" data-stream-id="{{$profile->user_bio_video_id}}" href="javascript:void(0)" class="each_user_video_artist">
                                        {{ substr($expert->user->name, 0, 40) }}
                                    </a>
                                    <p>{{ substr($expert->user->skills, 0, 40) }}</p>
                                </div>

                            </div>

                        @endforeach
                    </div>
                </div>
                <div id="tab2" class="ch_tab_det_sec desktop-only">
                    
                    <div class="lazy_tab_content"></div>
                </div>

                <div id="tab3" class="ch_tab_det_sec">
                    
                    <div class="lazy_tab_content"></div>
                </div>
                <div id="tab4" class="ch_tab_det_sec">
                    
                    <div class="lazy_tab_content"></div>
                </div>
                <div id="tab5" class="ch_tab_det_sec">
                    
                    <div class="lazy_tab_content"></div>
                </div>
                <div id="tab6" class="ch_tab_det_sec">
                    
                    <div class="lazy_tab_content"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="ch_tab_sec_outer {{$user?'':'top_right_chart'}}">


        <div class="panel main_panel">

            <div class="ch_bag_pric_sec bio_sec desktop-only">

                <div class="fund_raise_left">

                    <img class="bio_sec_percent_image a_percent" src="{{$user?$userCampaignDetails['mainHeaderImage']:asset('images/1a_right_expert.png')}}" alt="#" />
                    <h3 class="project_line">{{$user?$userCampaignDetails['mainHeaderTextOne']:''}}</h3>
                    <div class="fund_raise_status">
                        {{$user?$userCampaignDetails['mainHeaderTextTwo']:''}}
                    </div>

                </div>

                <div class="fund_raise_right">

                    <div class="pricing_setail">

                        <ul>


                            <li class="fleft">

                                <h3 class="tier_one_text_one">
                                    {{$user?$userCampaignDetails['tierOneTextOne']:''}}
                                </h3>

                            </li>

                            <li class="fright">

                                <h3 class="tier_four_text_one project_txt"></h3>

                            </li>

                            <li class="fleft">

                                <p class="tier_one_text_two">
                                    {{$user?$userCampaignDetails['tierOneTextTwo']:''}}
                                </p>

                            </li>

                            <li class="fright">

                                <p class="tier_four_text_two"></p>

                            </li>

                            <li class="fleft">

                                <h3 class="tier_two_text_one">
                                    {{$user?$userCampaignDetails['tierTwoTextOne']:''}}
                                </h3>

                            </li>

                            <li class="fright">

                                <h3 class="tier_three_text_one">
                                    {{$user?$userCampaignDetails['tierThreeTextOne']:''}}
                                </h3>

                            </li>

                            <li class="fleft">

                                <p class="tier_two_text_two">
                                    @if($user){!! $userCampaignDetails['tierTwoTextTwo'] !!}@endif
                                </p>

                            </li>

                            <li class="fright">

                                <p class="tier_three_text_two">
                                    {{$user?$userCampaignDetails['tierThreeTextTwo']:''}}
                                </p>

                            </li>

                        </ul>

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
                        <a class="ch_sup_fb full_support_me {{$user?'':'chart_disabled'}}" href="{{$user?route('user.project', ['username' => $user->username]):'javascript:void(0)'}}">
                            <img src="{{asset('images/fa-users.png')}}">
                        </a>
                    </li>
                </ul>

            </div>

        </div>

        <div id="double_card_container"></div>
        
        <div id="icontent"</div>

    </div>

@stop


@section('bottom-row-full-width')
    
    

@stop



@section('slide')

    

@stop



@section('miscellaneous-html')

    <div id="body-overlay"></div>
    @include('parts.chart-popups')

@stop



@section('footer')

@stop