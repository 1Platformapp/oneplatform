@extends('templates.advanced-template')



@section('pagetitle') 1Platform TV  @endsection



@section('pagekeywords') 
    <meta name="keywords" content="1platform tv,live streaming,1platform hosts" />
@endsection

@section('pagedescription') 
    <meta name="description" content="1Platform tv"/>
@endsection

@section('seocontent') 
@endsection



@section('page-level-css')

    <link rel="stylesheet" href="{{asset('css/slider.css')}}" media="none" class="switchmediaall" />
    <link rel="stylesheet" href="{{asset('css/tv.css?v=1.1')}}" />

@stop


@section('page-level-js')
    
    @php $playJWVideo = '' @endphp
    @if($defaultStream)
        @if($defaultStream->source == 'google_drive')
            @php $playVideo = '' @endphp
            @php $playJWVideo = $defaultStream->google_file_id @endphp
        @else
            @if($defaultStream->upcomingStatus()==0) 
                @php $playVideo = $defaultStream->youtube_id @endphp 
            @else
                @php $playVideo = '' @endphp 
            @endif
        @endif 
    @else 
        @php $playVideo =  $videoId @endphp 
    @endif

    <script defer src="/js/video-player.js?v=1.1" type="application/javascript"></script>
    <script type="text/javascript" src="{{asset('js/jwpatch.min.js')}}"></script>
    <script src="{{asset('js/tv-streams.js?v=1.0')}}" type="application/javascript"></script>
    <script>

        $(document).ready(function() {

            @if($playJWVideo !== '')
                setTimeout(function(){ playJWPVideo('{{$playJWVideo}}', 1); }, 1000);
            @else
                setTimeout(function(){$('#new-features-popup,#body-overlay').show(); }, 3000);
            @endif

            window.jwp = function(fileID, autoPlay) {
                window.jwplayer('jw_player').setup({
                    "file":"https:\/\/www.googleapis.com\/drive\/v3\/files\/"+fileID+"?alt=media&key=AIzaSyD6O1MsyoSy1aLoNT0COcRvOlVHe1Jlh00",
                    "image":"https:\/\/drive.google.com\/thumbnail?id="+fileID+"&authuser=0&sz=w640-h360-n-k-rw",
                    "title":"1Platform TV",
                    "description":"",
                    "mediaid":fileID,
                    "type":"mp4",
                    "mute":false,
                    "autostart":autoPlay,
                    "nextupoffset":-10,
                    "repeat":false,
                    "abouttext":"1Platform TV",
                    "aboutlink":"https:\/\/www.1platform.com\/",
                    "playbackRateControls":true,
                    "playbackRates":[0.25,0.5,0.75,1,1.25,1.5,1.75,2],
                    "defaultBandwidthEstimate":false,
                    "controls":true,
                    "aspectratio":"1:0.565",
                    "localization":false,
                    "height":false,
                    "width":"100%",
                    "displaytitle":true,
                    "displaydescription":true,
                    "stretching":"uniform",
                    "nextUpDisplay":false,
                    "qualityLabels":false,
                    "base":"https:\/\/ssl.p.jwpcdn.com\/player\/v\/8.3.3\/",
                    "preload":"metadata",
                    "flashplayer":"https:\/\/ssl.p.jwpcdn.com\/player\/v\/8.3.3\/",
                    "hlsjsdefault":true,
                    "skin":{
                        "controlbar":{
                            "text":"#FFFFFF",
                            "icons":"rgba( 255, 255, 255, 0.8 )",
                            "iconsActive":"#FFFFFF",
                            "background":"rgba( 0, 0, 0, 0 )"
                        },
                        "timeslider":{
                            "progress":"#F2F2F2",
                            "rail":"rgba( 255, 255, 255, 0.3 )"
                        },
                        "menus":{
                            "text":"rgba( 255, 255, 255, 0.8 )",
                            "textActive":"#FFFFFF",
                            "background":"#333333"
                        },
                        "tooltips":{
                            "text":"#000000",
                            "background":"#FFFFFF"
                        },
                        "url":false,
                        "name":false
                    },
                    "renderCaptionsNatively":false,
                    "captions":{
                        "color":"#FFFFFF",
                        "fontSize":15,
                        "fontFamily":"sans",
                        "fontOpacity":100,
                        "backgroundColor":"#000000",
                        "backgroundOpacity":75,
                        "edgeStyle":"none",
                        "windowColor":"#000000",
                        "windowOpacity":0
                    },
                    /*"logo":{
                        "file":"https:\/\/www.1platform.tv\/images\/test\/jw_logo_1.jpg",
                        "hide":false,
                        "link":"https:\/\/www.1platform.tv\/",
                        "margin":20,
                        "position":"top-left"
                    }*/
                });
            };

            $('body').addClass('tv_outer');
            var browserWidth = $( window ).width();

            if( browserWidth <= 767 ) {

                $('.tv_left_outer').parent().insertAfter('.tv_tab_btns_outer.mobile-only');
                $('.quick_nav_contain').insertAfter('.tv_center_outer');

                $('.pre_header_banner img').attr('src', '/images/banner5_res.jpg').hide();

                if($('.default_stream').hasClass('instant_hide')){

                    $('.ch_left_sec_outer').addClass('instant_hide');
                }
            }
            window.currentUserId = 0;

            $('.tv_channels_select').change(function(){

                var channelId = $(this).val();
                var value = $(this).find('option:selected').html();
                $(this).parent().find('.tv_channel_selected').text(value);
                $.ajax({

                    url: '/get-tv-streams',
                    type: 'POST',
                    data: {'by': 'channel', 'id': channelId},
                    cache: false,
                    dataType: 'html',
                    success: function (response) {
                        
                        $('.channel_streams_center .streams_list').html(response);
                        $('.channel_streams_center .stream_contain_head').text(value);
                        $('.channel_streams_center').removeClass('instant_hide');
                        $('.channel_streams_right').addClass('instant_hide');

                        if($('.channel_streams_center .each_stream_outer').length > 3){
                            $(".channel_streams_center .each_stream_outer").hide();
                            $(".channel_streams_center .each_stream_outer").slice(0, 3).show();
                            $('.channel_streams_center .load_more_streams').show().removeClass('instant_hide');
                        }else{
                            $('.channel_streams_center .load_more_streams').addClass('instant_hide');
                        }
                    }
                });
            });

            $('body').on( "click", ".each_stream_outer:not(.channel_streams_center .each_stream_outer, .channel_streams_right .each_stream_outer)", function(e) {
                
                var thiss = $(this);
                var streamId = thiss.attr('data-id');
                $.ajax({

                    url: '/get-tv-streams',
                    type: 'POST',
                    data: {'by': 'stream', 'id': streamId},
                    cache: false,
                    dataType: 'html',
                    success: function (response) {
                        
                        $('.channel_streams_right .project_name').text('More From '+thiss.find('.stream_channel').text().trim());
                        $('.channel_streams_right .streams_list').html(response);
                        $('.channel_streams_right').removeClass('instant_hide');
                        $('.channel_streams_center').addClass('instant_hide');

                        if($('.channel_streams_right .each_stream_outer').length > 3){
                            $(".channel_streams_right .each_stream_outer").hide();
                            $(".channel_streams_right .each_stream_outer").slice(0, 3).show();
                            $('.channel_streams_right .load_more_streams').show().removeClass('instant_hide');
                        }else{
                            $('.channel_streams_right .load_more_streams').addClass('instant_hide');
                        }
                    }
                });
            });

            $('body').on( "click", ".tab_btn_info", function(e) {
                $('.mejs__container').removeClass('instant_hide');
                $('.content_outer').addClass('playing');
            });
        });

    </script>
@stop



@section('preheader')


@stop


@section('page-background')

    <div data-url="{{asset('images/tv_back_03.jpg')}}" class="pg_back back_inactive"></div>

@stop


@section('header')

    @include('parts.header')

@stop



@section('social-media-html')


    <div id="fb-root"></div>

    <input type="hidden" id="share_current_page" value="tv">

    @php
        $url = 'tv_0';
        $shareURL = route('url.share', ['userName' => '1Platform TV', 'imageName' => base64_encode(asset('images/1a_right_tv.png')), 'url' => $url]);
    @endphp

    @if($defaultStream)
        @php $url = 'tv_0' @endphp
        @php $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultStream->name) @endphp
        @php $shareVideoURL = route('vid.share', ['videoId' => $defaultStream->id, 'userName' => $shareVideoTitle, 'url' => $url]) @endphp
    @endif


    <input type="hidden" id="url_share_user_name" value="1Platform TV">

    <input type="hidden" id="url_share_link" value="{{$shareURL}}">

    <input type="hidden" id="video_share_title" value="{{isset($shareVideoTitle)?$shareVideoTitle:''}}">

    <input type="hidden" id="video_share_link" value="{{isset($shareVideoURL)?$shareVideoURL:''}}">


@stop



@section('top-center')
<!--
    <div class="ch_center_outer">

        <aside class="top_info_box hide_on_mobile"> 
            <div class="top_info_right_icon">
                <i class="fa fa-share"></i>
            </div> 
        </aside>

        <div class="tp_center_video_outer">

            <div class="jp-gui">
                <div id="vimeo_player"></div>
                <div id="jw_player"></div>
                <video id="player1" width="578" height="325" style="width: 100%; height: 100%;" class="{{$playVideo == '' ? 'instant_hide' : 'vid_preloader'}}" preload="none">
                    <source type="video/youtube" src="https://www.youtube.com/watch?v={{$playVideo}}" />
                </video>
                <aside class="tv_tab_btns_outer tab_dsk hide_on_mobile">
                    <div class="each_tab_btn tab_btn_tv_logo disabled" data-show="">
                    </div> 
                    <div class="each_tab_btn tab_btn_tv_channels" data-show="">
                        <div class="tv_channels_outer">
                            <div class="tv_channel_selected">{{\App\Models\VideoChannel::find(17)->title}}</div>
                            <select class="tv_channels_select">
                                <option value="" selected disabled>Select</option>
                                @foreach($tvChannels as $key => $channel)
                                    <option {{$channel->id == 17 ? 'selected' : ''}} value="{{$channel->id}}">{{$channel->title}}</option>
                                @endforeach
                            </select>
                            <div class="tv_channels_arrow">
                                <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div> 
                    <div class="each_tab_btn tab_btn_info" data-video-id="0cSXq4TYIIk" data-show="">
                        <div class="tv_info_outer">
                            <div class="tv_info_ic"><i class="fa fa-caret-right"></i></div>
                            <div class="tv_info_text">INFO</div>
                        </div>
                    </div> 
                    <div class="each_tab_btn tab_btn_tv" data-show=""></div> 
                </aside>
                <aside class="tv_tab_btns_outer mobile-only">
                    <div class="each_tab_btn tab_btn_info" data-video-id="0cSXq4TYIIk" data-show="">
                        <div class="tv_info_outer">
                            <div class="tv_info_ic"><i class="fa fa-caret-right"></i></div>
                            <div class="tv_info_text">INFO</div>
                        </div>
                    </div> 
                    <div class="each_tab_btn tab_btn_tv_channels" data-show="">
                        <div class="tv_channels_outer">
                            <div class="tv_channel_selected">{{\App\Models\VideoChannel::find(17)->title}}</div>
                            <select class="tv_channels_select">
                                <option value="" selected disabled>Select</option>
                                @foreach($tvChannels as $key => $channel)
                                    <option {{$channel->id == 17 ? 'selected' : ''}} value="{{$channel->id}}">{{$channel->title}}</option>
                                @endforeach
                            </select>
                            <div class="tv_channels_arrow">
                                <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="each_tab_btn tab_btn_tv" data-show=""></div> 
                </aside>

                <main>
                    <section class="tab_det_left_sec tab_det_dsk tv_center_outer">
                        <h1 class="page_title">1Platform TV</h1>
                        <div id="tabd1" class="bio_sec">
                            <div class="stream_contain_outer channel_streams_center instant_hide">
                                <div class="stream_contain_inner">
                                    <div class="stream_contain_head"></div>
                                    <div class="streams_list"></div>
                                    <div class="load_more_streams instant_hide clearfix">Load More Videos</div>
                                </div>
                            </div>
                            <div class="page_main_tab_content">
                                @include('parts.main-tab-content', ['page' => 'tv'])
                            </div>
                            <div class="scroller_outer hide_on_mobile">
                                <div class="scroller_head">1Platform Latest</div>
                                <div class="hm_lst_slid_outer">
                                    <div class="hm_lst_slid_inner clearfix">
                                        <div data-max-slides="3" id="owl_content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
!-->
@stop



@section('top-right')


@stop



@section('top-left')
<!--
    <div class="ch_tab_sec_outer tv_left_outer">

        <div class="panel ch_tab_tv_outer main_panel">
            <div class="default_card top_right_chart {{$defaultStream?'instant_hide':''}}">
                <div class="ch_bag_pric_sec bio_sec desktop-only">

                    <div class="fund_raise_left">
                        <img class="bio_sec_percent_image" src="{{asset('images/1a_right_tv.png')}}" alt="#" />
                        <h3 class="project_line"></h3>
                        <div class="fund_raise_status"></div>
                    </div>

                    <div class="fund_raise_right">

                        <div class="pricing_setail">
                            <ul>
                                <li class="clearfix">

                                    <h3 class="tier_one_text_one bio_sec_tot_fans"></h3>
                                </li>

                                <li class="clearfix">

                                    <p class="tier_one_text_two"></p>
                                </li>

                                <li class="fleft">

                                    <h3 class="tier_two_text_one bio_sec_tot_amo_rai"></h3>
                                </li>

                                <li class="fright">

                                    <h3 class="tier_three_text_one bio_sec_low_txt"></h3>
                                </li>

                                <li class="fleft">

                                    <p class="tier_two_text_two"></p>
                                </li>

                                <li class="fright">

                                    <p class="tier_three_text_two bio_sec_up_txt"></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="social_btns desktop-only clearfix">

                    <ul class="clearfix">

                        <li>
                            <a onclick="return facebookShare('url')" class="ch_sup_fb" href="javascript:void(0)">
                                <i class="fab fa-facebook-f vertical_center"></i>
                            </a> 
                        </li>
                        <li>
                            <a onclick="return twitterShare('url')" class="ch_sup_tw" href="javascript:void(0)">
                                <i class="fab fa-twitter vertical_center"></i>
                            </a> 
                        </li>
                        <li>
                            <a class="ch_sup_fb full_support_me chart_disabled" href="javascript:void(0)">
                                
                            </a>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="default_stream {{$defaultStream?'':'instant_hide'}}">
                @php $streamLiveStatus = $defaultStream ? $commonMethods::streamLiveStatus( $defaultStream ) : 0 @endphp
                <div class="top_stream_outer {{ $streamLiveStatus ? 'stream_is_live' : '' }}">
                    <div class="top_stream_inner">
                        <div class="top_stream_left">
                            <a class="stream_thumb" href="javascript:void(0)">
                                <img class="defer_loading" src="" data-src="{{ $defaultStream ? $defaultStream->thumb() : '' }}">
                            </a>
                            <ul class="stream_det">
                                <li class="stream_title">{{ $defaultStream ? $defaultStream->name : '' }}</li>
                                <li class="stream_time">
                                    {{$defaultStream ? $defaultStream['time_formatted'] : ''}}
                                </li>
                                <li class="stream_channel">{{ $defaultStream ? $defaultStream->channel->title : '' }}</li>
                            </ul>
                        </div>
                        <div class="top_stream_right">
                            <a class="cent_undo_btn" href="javascript:void(0)">{{ $streamLiveStatus ? 'LIVE' : '' }}</a>
                        </div>
                    </div>
                </div>
                <div class="top_stream_bottom_spacer"></div>
                <div class="hosts_container">
                	@if($defaultStream && $defaultStream->hosts && count($defaultStream->hosts))
                		@foreach($defaultStream->hosts as $userId)
                			@php 
                			    $userr = \App\Models\User::find($userId);
                			    if(!$userr){ continue; }
                			@endphp

                			@include('parts.tv-host', ['user' => $userr, 'commonMethods' => $commonMethods])
                		@endforeach
                	@endif
                </div>
                
                <div class="btm_text_stor_outer">

                    <?php echo $defaultStream ? html_entity_decode($defaultStream->description) : '';  ?>

                    @if($defaultStream)
                        @foreach( explode( ', ', $defaultStream->images) as $key => $streamImage )

                            @if(trim($streamImage) != '')

                            <img class="defer_loading" src="" data-src="https://www.duong.1platform.tv/public/stream-images/{{ $streamImage }}" /><br />

                            @endif

                        @endforeach
                    @endif

                </div>
            </div>

        </div>

        <div class="panel channel_streams_right instant_hide">
            <div class="">
                <h2 class="project_name"></h2>
            </div>
            <div class="stream_contain_outer">
                <div class="streams_list"></div>
                <div class="load_more_streams instant_hide clearfix">Load More Videos</div>
            </div>
        </div>

        <div id="double_card_container"></div>

    </div>


!-->
@stop


@section('bottom-row-full-width')
    

@stop



@section('slide')
    <!--
    <div class="scroller_outer_res">
        <div class="hm_lst_slid_outer">

            <div class="hm_lst_slid_inner clearfix">

                <div id="owl_content"></div>

            </div>

        </div>
    </div>!-->
@stop



@section('miscellaneous-html')

    <div id="body-overlay"></div>
    @include('parts.chart-popups')

@stop



@section('footer')

@stop