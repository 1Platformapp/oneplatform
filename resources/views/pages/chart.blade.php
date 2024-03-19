@extends('templates.advanced-template')

@section('pagetitle') 1Platform Chart @endsection


@section('pagekeywords') 
    <meta name="keywords" content="1platform chart,1platform competition" />
@endsection

@section('pagedescription') 
    <meta name="description" content="1Platform chart.Upload videos and take part in 1platform competition."/>
@endsection

@section('seocontent') 
@endsection


@section('page-level-css')
    
    <link rel="stylesheet" href="{{asset('css/slider.css')}}" media="none" class="switchmediaall" />
    <link rel="stylesheet" href="{{asset('css/chart.css')}}" />

@stop



@section('page-level-js')
    
    <script src="https://js.stripe.com/v3/"></script>
    <script defer src="/js/feat_items_scroller.js"></script>
    <script defer src="{{asset('js/jquery-ui.min.js')}}" type="application/javascript"></script>
    <script defer src="https://apis.google.com/js/platform.js"></script>

    <script type="text/javascript">


        window.currentUserId = {{$user ? $user->id : 0}};

        window.autoShare = '{{$autoShare}}';

        $('document').ready(function(){

            $('body').addClass('chart_outer');
            var browserWidth = $( window ).width();

            if(window.autoShare && window.autoShare == 'facebook_url'){

                $('#facebook_share_url').trigger('click');
            }
            if(window.autoShare && window.autoShare == 'twitter_url'){

                $('#twitter_share_url').trigger('click');
            }

            var loadInitialItems = 11;
            var loadMoreScroll = 120;
            var loadMoreItems = 3;
            var listContainer = '#r_tab1 ';

            if( browserWidth <= 767 ) {

                loadInitialItems = 5;
                loadMoreScroll = 60;
                listContainer = '.ch_tab_sec_outer.mobile-only ';

                $('.pre_header_banner img').attr('src', '/images/banner4_res.jpg').hide();
            }

            $(listContainer+'.each_chart_video').hide();
            $(listContainer+'.each_chart_video').slice(0, loadInitialItems).show();
            $(".load_more_streams").on('click', function (e) {
                e.preventDefault();
                var parent = $(this).parent();
                parent.find(".each_chart_video:hidden").slice(0, loadMoreItems).slideDown( "slow", function() {

                    $('html,body').animate({
                        scrollTop: $(window).scrollTop() + (loadMoreScroll*loadMoreItems) 
                    }, 1000);

                });
                if (parent.find(".each_chart_video:hidden").length == 0) {
                    parent.find(".load_more_streams").fadeOut('slow');
                }
            });

            $('body').on( "click", ".tp_sec_play_project,.top_info_outer", function(e) {
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

    <div data-url="{{asset('images/chart_back_04_2.jpg')}}" class="pg_back back_inactive"></div>

@stop


@section('header')

    @include('parts.header')

@stop



@section('social-media-html')

    <div id="fb-root"></div>
    <input type="hidden" id="share_current_page" value="chart">

    @php
        if($user){
            $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
            $url = 'chart_'.$user->id;
            $userImageName = $user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $user->profile->profile_display_image_original;
            $shareVideoURL = route('vid.share', ['videoId' => $defaultVideoId, 'userName' => $user->name, 'url' => $url]);
            $shareURL = route('url.share', ['userName' => $user->name, 'imageName' => base64_encode($userImageName), 'url' => $url]);
        }else{
            $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
            $url = 'chart_0';
            $shareVideoURL = route('vid.share', ['videoId' => '0cSXq4TYIIk', 'userName' => $shareVideoTitle, 'url' => $url]);
            $shareURL = route('url.share', ['userName' => '1Platform Chart', 'imageName' => base64_encode('1a_right_chart.png'), 'url' => $url]);
        }
    @endphp

    <input type="hidden" id="video_share_id" value="{{$defaultVideoId}}">
    <input type="hidden" id="video_share_link" value="{{$shareVideoURL}}">
    <input type="hidden" id="video_share_title" value="{{$shareVideoTitle}}">
    <input type="hidden" id="url_share_user_name" value="{{$user?$user->name:'1Platform Chart'}}">
    <input type="hidden" id="url_share_link" value="{{$shareURL}}">

@stop

@section('top-center')

    <div class="ch_center_outer">
        <aside class="top_info_box hide_on_mobile"> 
            <div class="top_info_right_icon">
                <i class="fa fa-share"></i>
            </div> 
        </aside>
        <div class="tp_center_video_outer">
            <div class="jp-gui">
                <video poster="{{asset('images/test/coming soon trials-01.jpg')}}" width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader" preload="none">
                    <source type="video/youtube" src="https://www.youtube.com/watch?v={{ $defaultVideoId }}" />
                </video>
                <aside class="clearfix chart_tab_btns tab_btns_outer tab_dsk hide_on_mobile">
                    <div class="each_tab_btn tab_btn_chart_logo" data-show="#tabd1">
                        <!--<a href="javascript:void(0)">
                            <img src="{{asset('images/1a_bottom_chart.png')}}">
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
                </aside>
                <aside class="clearfix tab_btns_outer tab_shared mobile-only ch_tab_sec_outer">
                    <div class="each_tab_btn tab_btn_user_name fly_user_home" data-initials="" data-show="">
                        <div class="border"></div>
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
                </aside>
                <main>
                    <section class="tab_det_left_sec tab_det_dsk tab_det_inner right_height_res">
                        <h1 class="page_title">1Platform Chart</h1>
                        <aside style="display: none;" class="lazy_tab_img">
                            <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{asset('img/lazy_loading.gif')}}">
                        </aside>
                        <article id="tabd1" class="ch_tab_det_sec">
                            <div class="ch_tab_det_outer">
                                <div id="r_tab1" class="r_tab_det" style="display:block ">
                                    @foreach($videos as $key=> $video)
                                        @if (!$video->profile || !$video->profile->user) @php continue @endphp @endif
                                        <div class="clearfix tab_chanel_list each_user_video each_chart_video chart_page_video">
                                            @php
                                                $imgSrc = 'https://i.ytimg.com/vi/'.$video->video_id.'/mqdefault.jpg';
                                            @endphp
                                            <a href="#"><img class="" src="{{ $imgSrc }}" alt="#" /></a>
                                            <div class="tab_chanel_img_det">
                                                <a data-stream-type="{{ $video->type }}" data-orig-image="{{$video->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $video->profile->profile_display_image_original}}" data-stream-id="{{ ( $video->type == 'youtube' ) ? $video->video_id : $video->link }}" href="#" class="each_user_video_artist">{{ $video->profile->user->name }}</a>
                                                <p>{{ substr($video->title, 0, 60) }}</p>
                                            </div>
                                            <div class="clearfix r_left_sec_outer">
                                                <ul class="clearfix chart_rank">

                                                    <li><mark>{{$video->rank}}</mark></li>
                                                </ul>
                                                <ul class="clearfix chart_likes">
                                                    <li>
                                                        @if($video->direction == 1)
                                                            <img src="{{asset('images/chart_rank_up.png')}}">
                                                        @elseif($video->direction == 0)
                                                            <img src="{{asset('images/chart_rank_stay.png')}}">
                                                        @else
                                                            <img src="{{asset('images/chart_rank_down.png')}}">
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <p>{{$video->likes}}</p>
                                                    </li>
                                                    <li>
                                                        <p>{{$video->total_likes}}</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if(count($videos) > 11)
                                        <div class="clearfix load_more_streams">Load More Videos</div>
                                    @endif
                                </div>
                                <br><div class="spacer"></div>
                                <div class="scroller_outer">
                                    <div class="scroller_head">1Platform Latest</div>
                                    <div class="hm_lst_slid_outer">
                                        <div class="clearfix hm_lst_slid_inner">
                                            <div data-max-slides="3" id="owl_content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article id="tabd2" class="ch_tab_det_sec music_sec ">
                            <div class="lazy_tab_content"></div>
                        </article>
                        <article id="tabd3" class="ch_tab_det_sec fans_sec">
                            <div class="lazy_tab_content"></div>
                        </article>
                        <article id="tabd4" class="ch_tab_det_sec social_sec">
                            <div class="lazy_tab_content"></div>
                        </article>
                        <article id="tabd5" class="ch_tab_det_sec">
                            <div class="lazy_tab_content"></div>
                        </article>
                        <article id="tabd6" class="ch_tab_det_sec">
                            <div class="lazy_tab_content"></div>
                        </article>
                    </section>
                </main>
            </div>
        </div>
    </div>

@stop



@section('top-right')

@stop


@section('top-left')

    <div class="ch_tab_sec_outer {{$user?'':'top_right_chart'}}">
        <div class="panel main_panel">
            <div class="ch_bag_pric_sec bio_sec desktop-only">
                <div class="fund_raise_left">
                    <img class="bio_sec_percent_image a_percent" src="{{$user?$userCampaignDetails['mainHeaderImage']:asset('images/1a_right_chart.png')}}" alt="#" />
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
            <div class="clearfix social_btns desktop-only">
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
    </div>
    <script>
        var browserWidth = $( window ).width();
        if( browserWidth <= 767 ){
            $('.desktop-only').remove();
        }else{
            $('.mobile-only,.hide_on_desktop').remove();
        }
    </script>
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