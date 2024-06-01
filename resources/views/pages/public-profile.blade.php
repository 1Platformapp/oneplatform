@extends('templates.advanced-template')



<!-- Page Level CSS !-->

@section('page-level-css')



    <link href="/twitter-custom-embedded-feed/twitter-styles.css" rel="stylesheet">

    <link href="/css/twitter-feed.css" rel="stylesheet">

@stop



<!-- Page Level Javascript !-->

@section('page-level-js')



    <!--  initialize m_custom_scrollbar_function  !-->

    <script src="/js/vertical-scroller.js" type="application/javascript"></script>



    <!--  initialize vertical slider  !-->

    <script src="/js/vertical-slider.js" type="application/javascript"></script>

    <!--  initialize video_plyer !-->

    <script src="/js/video-player.js" type="application/javascript"></script>



    <!-- Fill Social Tab with twitter feed !-->

    <script id="twitter-wjs" src="https://platform.twitter.com/widgets.js"></script>

    <script src="/js/twitter-feed.js"></script>

    <script>

        fillSocialTabWithTwitterFeed();

    </script>

    <!-- Fill Social Tab with twitter feed !-->



    <!-- Fill Social Tab with Spotify follow button !-->

    <script src="/js/spotify-follow-button.js"></script>

    <script>

        fillSocialTabWithSpotifyFeed({{ $user->id }});

    </script>

    <!-- Fill Social Tab with Spotify follow button !-->



    <!-- Fill Social Tab with Instagram feed !-->

    <script src="/js/instagra-embedded-feed-js.js"></script>

    <script src="/js/instagram-feed.js"></script>

    <!--fancybox scripts and stylesheets!-->

    <script type="text/javascript" src="/js/fancybox/lib/jquery.mousewheel.pack.js?v=3.1.3"></script>

    <script type="text/javascript" src="/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

    <link rel="stylesheet" type="text/css" href="/js/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen">

    <link rel="stylesheet" type="text/css" href="/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5">

    <script type="text/javascript" src="/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

    <link rel="stylesheet" type="text/css" href="/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7">

    <script type="text/javascript" src="/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <script type="text/javascript" src="/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

    <!--fancybox scripts and stylesheets!-->

    <script>

        fillSocialTabWithInstagramFeed();

    </script>

    <!-- Fill Social Tab with Instagram feed !-->



    <!-- Youtube subscribe -->

    <script src="https://apis.google.com/js/platform.js"></script>

    <!-- Youtube subscribe -->



@stop



<!-- Page Header !-->

@section('header')

    @include('parts.header')

@stop

<!-- Page Header !-->



<!-- facebook/twitter share HTML !-->

@section('social-media-html')



    <div id="fb-root"></div>



    <input type="hidden" id="fb_project_share_name" value="{{ $userPersonalDetails['name'] }}">

    <input type="hidden" id="fb_project_share_link" value="{{ asset('/').$user->username }}">

    <input type="hidden" id="fb_project_share_image" value="{{ $commonMethods->getUserProfileThumb($user->id) }}">

    <input type="hidden" id="fb_project_share_description" value="{{ $userPersonalDetails['story_text'] }}">



    <input type="hidden" id="twit_project_share_name" value="{{ $userCampaignDetails['user_campaign_title'] }}">

    <input type="hidden" id="twit_project_share_link" value="{{ asset('/').$user->username }}">



@stop



<!-- Video Player And Non-Responsive Slider !-->

@section('top-center')

    <div class="ch_center_outer">

        <h4 class="clearfix"> 1Platform Chart  <a class="cent_undo_btn" href="#"></a>  </h4>

        <div class="tp_center_video_outer">

            <div class="jplayer_video_outer">



                <div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player" >

                    <div class="jp-type-single">

                        <!--<div id="jquery_jplayer_1" class="jp-jplayer"></div>-->

                        <div class="jp-gui">

                            <!--<div class="jp-video-play">

                                <button class="jp-video-play-icon" role="button" tabindex="0">play</button>

                            </div>-->



                            <iframe id="soundcloudPlayer" width="100%" height="319" scrolling="no" frameborder="no"

                                    src="&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true">

                            </iframe>



                            <video width="578" height="325" style="width: 100%; height: 100%;" class="" id="player1" preload="none">

                                <source type="video/youtube" src="https://www.youtube.com/watch?v={{ $defaultVideoId }}" />

                            </video>



                            <div class="jp-interface">

                                <div class="player_btm_sec clearfix">

                                    <div class="left_img_sec clearfix">



                                        <input type="hidden" name="userIdValue" id="userIdValue" value="{{ $user->id }}">

                                        <input type="hidden" name="project_video" id="project_video" value="{{ $userCampaignDetails['project_video'] }}">

                                        <input type="hidden" name="user_project_share_link" id="user_project_share_link" value="{{ $userPersonalDetails['user_project_share_link'] }}">

                                        <input type="hidden" name="base_url" id="base_url" value="{{ $userPersonalDetails['base_url'] }}">



                                        <a style="cursor: pointer;" class="user_home_link"><img class="play_btm_user_img" src="{{ $commonMethods->getUserDisplayImage($user->id) }}" alt="#" /></a>

                                        <b style="cursor: pointer;" class="play_btm_user_name user_home_link" onclick="window.location.href='{{ asset("/") }}'">{{ $user->name }}</b>

                                    </div>



                                    <div id="project_img"><p class="play_btm_user_goal" style="cursor: pointer;">Target {{ $userCampaignDetails['user_campaign_goal'] }}</p></div>

                                    <div class="hide_res" style="cursor: pointer;"><p class="play_btm_user_products">Products {{ $userCampaignDetails['user_total_products'] }}</p></div>

                                    <div class="with_playbtn clearfix" style="cursor: pointer;">

                                        <p class="basket" id="basket_icon_vid">Project Video</p>

                                        <a class="ch_tp_play_btn" id="ply_proj_vid_btn" style="cursor: pointer;"></a>

                                    </div>

                                    <div class="vd_social_outer clearfix">

                                        <ul class="clearfix">



                                            <li><a onclick="return facebookShareVideo()" class="vd_fb_link" href="#"></a></li>

                                            <li><a onclick="return twitterShareVideo()" class="vd_tw_link" href="#"></a></li>

                                            <li><a onclick="return googleShareVideo()" class="vd_gogle_link" href="#"></a></li>

                                        </ul>

                                    </div>

                                    <div class="right_sec">

                                        <ul class="clearfix">

                                            <li><a class="vd_tv_link" href="{{ route('tv') }}"></a></li>

                                            <li><a class="vd_tv_link vd_tv_text" href="{{ route('tv') }}"></a></li>

                                        </ul>

                                    </div>

                                </div>





                            </div>

                        </div>



                    </div>

                </div>





            </div>

        </div>

        <div class="btm_center_outer">

            <div class="vetical_slide_sec">

                <ul class="bxslider">



                    @foreach($verticalSliderItems as $key => $slide)

                        @if( $slide->type == "user" )

                            <?php $sliderUserCampaignDetails = $commonMethods->getUserCampaignDetails($slide->user->id); ?>



                            <li>

                                <div class="product_list_outer clearfix">

                                    <div class="product_img_outer">

                                        <span><img src="{{ $commonMethods->getUserDisplayImage($slide->user->id) }}" alt="#" /></span>

                                    </div>



                                    <div class="product_det_outer">

                                        <label>{{ $slide->user->name }}</label>

                                        <b>{{ $sliderUserCampaignDetails['user_campaign_title'] }}</b>



                                        <div class="pro_rais_quant_otr clearfix">

                                            <ul>

                                                <li>

                                                    <a href="#"><img src="{{ asset('percent-images/'.$sliderUserCampaignDetails['user_campaign_amount_raised_percent'].'.png') }}" alt="#" /></a>

                                                    <p>Raised {{ $sliderUserCampaignDetails['user_total_amount_raised'] }}</p>

                                                </li>

                                                <li>

                                                    <a href="#"><img src="/images/sh_cart_icon.png" alt="#" /></a>

                                                    <p>{{ $sliderUserCampaignDetails['user_total_products'] }} @if ($sliderUserCampaignDetails['user_total_products'] > 1) products @else product @endif</p>

                                                </li>

                                            </ul>

                                        </div>

                                    </div>





                                </div>



                            </li>



                        @elseif( $slide->type == "stream" )



                            <li>

                                <div class="product_list_outer clearfix">

                                    <div class="product_img_outer">

                                        <span><img src="https://i.ytimg.com/vi/{{$slide->stream->youtube_id}}/mqdefault.jpg" alt="#" /></span>

                                    </div>





                                    <div class="product_det_outer">

                                        <label>{{$slide->stream->name}}</label>

                                        <b>{{$slide->stream->channel->title}}

                                        </b>



                                        <div class="pro_rais_quant_otr clearfix">

                                            <ul>

                                                <li>

                                                    <a href="#"><img src="/images/bag_img.png" alt="#" /></a>

                                                    <p>{{ date("d M Y h:i A", strtotime($slide->stream->created_at)) }}</p>

                                                </li>

                                                <li>

                                                    <a class="live_now" href="#">Live Now </a>

                                                    <p>Watch Now</p>

                                                </li>

                                            </ul>

                                        </div>

                                    </div>





                                </div>



                            </li>



                        @endif

                    @endforeach



                </ul>

            </div>





        </div>





        <div id="add_to_cart_music_section">

            @foreach($musics as $userMusic)



                @include('parts.user-add-to-cart-music-template',['userMusic'=>$userMusic])

            @endforeach

        </div>



        <div id="add_to_cart_prod_section">

            @foreach($products as $userProduct)



                @include('parts.user-add-to-cart-product-template',['userProduct'=>$userProduct])

            @endforeach

        </div>





    </div>

@stop



<!-- Right Bar !-->

@section('top-right')



    <div class="ch_right_outer">

        <div class="ch_tab_sec_outer">

            <div class=" r_tab_btns_outer clearfix">

                <ul>

                    <li><a href="{{ route('tv') }}">TV</a></li>

                    <li><a href="{{ route('live') }}">Experts</a></li>

                    <li><a href="{{ route('alfie') }}">Alfie</a></li>

                    <li><a href="{{ route('chart') }}" class="tab_active">Chart</a></li>

                </ul>

            </div>

            <div class="ch_tab_det_outer">

                <div class="ch_tp_sec clearfix">

                    <div class="ch_tp_sec_inner clearfix">

                        <div class="ch_tp_sec_left clearfix">

                            <a href="#" style="width:36.5% !important;"><img src="/images/ch_tp_img.png" alt="#" /></a>

                            <div class="tp_sec_in_det">

                                <a href="#"><strong style="color:#1a191c !important;">1Platform</strong></a>

                                <a href="#">How 1Platform Works</a>

                            </div>

                        </div>

                        <div class="ch_tp_sec_right">

                            <a style="cursor: pointer;" id="top_right_button" class="ch_tp_play_btn"></a>



                        </div>

                    </div>

                </div>

                <div class="tab_det_inner">

                    <div id="r_tab1" class="r_tab_det" style="display:block ">

                        @foreach($videos as $key=> $video)

                            <div class="r_video_listing each_chart_video clearfix">

                                <div class="r_rigt_imgdet_outer clearfix">

                                    <a href="#" class="r_rigt_img">

                                        @if($video->type == 'soundcloud')

                                            <img src="{{ asset('images').'/soundcloud.png' }}" alt="#" />

                                        @else

                                            <img src="https://i.ytimg.com/vi/{{ $video->video_id }}/mqdefault.jpg" alt="#" />

                                        @endif

                                    </a>

                                    <div class="r_img_det">

                                        <ul>

                                            @if($video->profile)

                                                <li><a data-stream-type="{{ $video->type }}" data-stream-id="{{ ( $video->type == 'youtube' ) ? $video->video_id : $video->link }}" data-user-id="{{ $video->profile->user->id }}" class="vid_title" href="#">{{$video->profile->user->name}}</a></li>

                                            @endif

                                            <li>

                                                <p>{{$video->title}}</p>

                                            </li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="r_left_sec_outer clearfix">

                                    <ul class="clearfix">

                                        <li><mark>{{$video->rank}}</mark></li>

                                        @if($video->likes > $video->last_period_likes)

                                            <li><a class="down_up_btn video_btn_up" href="#"></a></li>

                                        @else

                                            <li><a class="down_up_btn video_btn_down" href="#"></a></li>

                                        @endif

                                        <li><span class="r_list_like"></span>

                                            <p>{{$video->likes}}</p>

                                            <p>{{$video->total_likes}}</p>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        @endforeach



                    </div>

                </div>

            </div>

        </div>

    </div>

@stop



<!-- Left Bar !-->

@section('top-left')



    <div class="ch_tab_sec_outer">

        <div class="tab_btns_outer clearfix">

            <ul>

                <li><a href="#tab1" class="tab_active">Bio</a></li>

                <li><a href="#tab2"><i style="display: inline-block; font-style:normal; ">My</i> channel</a></li>

                <li><a href="#tab3">Fans</a></li>

                <li><a href="#tab4">Social</a></li>

            </ul>

        </div>

        <div class="ch_tab_det_outer">

            <div class="ch_tp_sec user_left_bar_top_info clearfix">

                <div class="ch_tp_sec_inner clearfix">

                    <div class="ch_tp_sec_left clearfix">

                        <a href="#"><img class="top_left_user_display_image" src="{{ $userPersonalDetails['user_display_image'] }}" alt="#" /></a>

                        <div class="tp_sec_in_det">

                            <a href="{{ $userPersonalDetails["user_project_share_link"] }}" class="user_home_link_left"><strong class="top_left_user_name">{{ $userPersonalDetails['name'] }}</strong></a>

                            <a href="#" class="top_left_user_city">{{ $userPersonalDetails['city'] }}</a>

                            <a href="#" class="top_left_user_skills">{{ $userPersonalDetails['skills'] }}</a>

                        </div>



                    </div>

                    <div class="ch_tp_sec_right">

                        <a href="{{ $userPersonalDetails["user_project_share_link"] }}" class="ch_tp_play_btn user_home_link_left"></a>

                    </div>

                </div>

            </div>

            <div class="tab_det_inner tab_det_left_sec right_height_res">

                <div id="tab1" class="ch_tab_det_sec bio_sec " style="display: block;">

                    <div class="ch_bag_pric_sec">

                        <div class="fund_raise_left">

                            <img class="bio_sec_percent_image" src="{{ asset('percent-images/'.$userCampaignDetails['user_campaign_amount_raised_percent'].'.png') }}" alt="#" />

                        </div>

                        <div class="fund_raise_right">

                            <div class="pricing_setail">

                                <ul>

                                    <li class="clearfix">

                                        <h3 class="bio_sec_tot_amo_rai">{{ $userCampaignDetails['user_total_amount_raised'] }}</h3>

                                    </li>

                                    <li class="clearfix">

                                        <p class="">Raised of <text class="bio_sec_goal">{{ $userCampaignDetails['user_campaign_goal'] }}</text> Target</p>

                                    </li>

                                    <li class="clearfix">

                                        <h3 class="bio_sec_tot_fans">{{ count( $userCampaignDetails['user_project_donators'] ) }}</h3>

                                    </li>

                                    <li class="clearfix">

                                        <p class="">Supporters supported this</p>

                                    </li>

                                    <li class="clearfix">

                                        <h3 class="bio_sec_low_txt">{{ $userCampaignDetails['user_campaign_days_left_lower_text'] }}</h3>

                                    </li>

                                    <li class="clearfix">

                                        <p class="bio_sec_up_txt">{{ $userCampaignDetails['user_campaign_days_left_upper_text'] }}</p>

                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>



                    <div class="social_supp_btns clearfix">

                        <ul class="clearfix">

                            <li><a onclick="return facebookShare()" class="ch_sup_fb" href="#"> Share</a> </li>

                            <li><a onclick="return twitterShare()" class="ch_sup_tw" href="#"> Tweet</a></li>

                            <li class="full_btn"><a href="/project/{{ $user->id }}">Support me</a></li>

                        </ul>

                    </div>



                    <div class="btm_text_stor_outer">

                        <label class="bio_sec_story_title">{{ $userCampaignDetails['user_campaign_title'] }}</label>

                        <div class="bio_sec_story_text">

                            <p>{!! $userPersonalDetails['story_text'] !!}</p>

                            @if( $userPersonalDetails['story_images'] != '' )

                                @foreach(explode(', ', $userPersonalDetails['story_images']) as $key => $storyImage)

                                    <img class="user_story_image" src="{{ 'user-story-images/'.$storyImage }}">

                                    @if( $key+1 != count(explode(', ', $userPersonalDetails['story_images'])) )

                                        <br /><br /><br />

                                    @endif

                                @endforeach

                            @endif

                        </div>

                    </div>



                </div>



                <!-- channel tab -->

                <div id="tab2" class="ch_tab_det_sec " style="display:none ">



                    <div class="tab_chan_tp_btns clearfix">

                        <ul>

                            <li><a class="channel_tab_btn selected" id="channel_tab_btn_01" href="#"></a></li>

                            <li><a class="channel_tab_btn not_selected" id="channel_tab_btn_02" href="#"></a></li>

                            <li><a class="channel_tab_btn not_selected" id="channel_tab_btn_03" href="#"></a></li>

                        </ul>

                    </div>



                    <div class="tab_chanel_list_outer ">

                        <div class="user_musics_outer">

                            @foreach($musics as $userMusic)



                                @include('parts.user-channel-music-template',['music'=>$userMusic])

                            @endforeach

                        </div>

                        <div class="user_videos_outer">

                            @foreach($myChannelVideos as $myChannelVideo)



                                @include('parts.user-channel-video-template',['video'=>$myChannelVideo])

                            @endforeach

                        </div>

                    </div>



                    <div class="user_products_outer">

                        @foreach($products as $userProduct)



                            @include('parts.user-channel-product-template',['product'=>$userProduct])

                        @endforeach

                    </div>

                </div>

                <!-- channel tab ends -->



                <!-- fans tab -->

                <div id="tab3" class="ch_tab_det_sec ">

                    <div class="social_supp_btns clearfix">

                        <ul class="clearfix">

                            <li class="full_with_btn"><a href="#" >Support me</a></li>

                        </ul>

                    </div>



                    <div class="tab_fan_list_outer">



                    @if(count($contributeDetails) > 0)

                        @foreach($contributeDetails as $contribute_detail)

                            @if($contribute_detail->hide_flag == 0)

                                @if(count($contribute_detail->customer) > 0)

                                @include('parts.user-fan-template',['fanType' => 'contributer', 'contribute_detail' => $contribute_detail])

                                @endif

                            @endif

                        @endforeach

                    @endif



                    <!-- checkout details -->

                        @if(count($checkouts) > 0)

                            @foreach($checkouts as $checkout)

                                @if($checkout->hide_flag == 0)

                                    @if(count($checkout->customer) > 0)

                                    @include('parts.user-fan-template',['fanType' => 'buyer', 'checkout' => $checkout])

                                    @endif

                                @endif

                            @endforeach

                        @endif



                    </div>



                </div>

                <!-- fans tab ends -->



                <div id="tab4" class="ch_tab_det_sec " style="display: none;">



                    @foreach($fbUserProfiles as $fbUserProfile)



                        <?php $fbDisplay = "display: none;";?>



                        @if(isset($user) && $fbUserProfile->user->id == $user->id)

                            <?php $fbDisplay = "";?>

                        @endif

                        <div id="usersocialfacebook_{{ $fbUserProfile->user->id }}" style="{{ $fbDisplay }}" class="social_facebook_outer">



                            <div class="fb-page" data-href="https://www.facebook.com/{{ $fbUserProfile->social_facebook }}" data-tabs="timeline" data-small-header="false" data-width="300" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/{{ $fbUserProfile->social_facebook }}" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/{{ $fbUserProfile->social_facebook }}">Facebook</a></blockquote></div>



                        </div>

                    @endforeach





                    <div class="twitter_feed_outer">



                        <div id="twitter-feed"></div>



                        <input type="hidden" id="social_twitter_username" value="<?php echo $userSocialAccountDetails['twitter_account'];?>">

                        <input type="hidden" id="social_twitter_display_limit" value="<?php echo $commonMethods->getSocialTabTweetsDisplayLimit();?>">

                    </div>



                    <div class="spotify_follow_button_outer">



                        <div id="spotify-follow-button-contain"></div>

                    </div>

                    <div style="display: none;" class="instagram_feed_outer">



                        <img style="height: 60px;" src="{{ asset('/images/instagram-feed-top-logo.png') }}"><br />

                        <div id="instagram_id"></div><br />

                        <a class="add_basket_btn" href="#" id="load-more-instagram-posts"> Load More </a>



                        <input type="hidden" id="social_instagram_userid" value="<?php echo $userSocialAccountDetails['instagram_user_id'];?>">

                        <input type="hidden" id="social_instagram_user_access_token" value="<?php echo $userSocialAccountDetails['instagram_user_access_token'];?>">

                    </div>



                    @foreach($youtubeUserProfiles as $youtubeUserProfile)

                        <?php $youtubeDisplay = "display: none;";?>



                        @if(isset($user) && $youtubeUserProfile->user->id == $user->id)

                            <?php $youtubeDisplay = "";?>

                        @endif

                        <div style="{{ $youtubeDisplay }}" id="usersocialyoutube_{{ $youtubeUserProfile->user->id }}" class="social_youtube_outer">

                            <div style="height: 48px;" class="g-ytsubscribe" data-channel="{{ $youtubeUserProfile->social_youtube }}" data-layout="full" data-count="default"></div>

                        </div>

                    @endforeach



                </div>

            </div>

        </div>

    </div>

@stop



<!-- Responsive Slider !-->

@section('bottom-row-full-width')



    <div class="btm_center_outer res_slider_outer">

        <div class="vetical_slide_sec">

            <ul class="bxslider">

                @foreach($verticalSliderItems as $key => $slide)

                    @if( $slide->type == "user" )

                        <?php $sliderUserCampaignDetails = $commonMethods->getUserCampaignDetails($slide->user->id); ?>

                        <li>

                            <div class="product_list_outer clearfix">

                                <div class="product_img_outer">

                                    <span><img src="{{ $commonMethods->getUserDisplayImage($slide->user->id) }}" alt="#" /></span>

                                </div>



                                <div class="product_det_outer">

                                    <label>{{ $slide->user->name }}</label>

                                    <b>{{ $sliderUserCampaignDetails['user_campaign_title'] }}</b>



                                    <div class="pro_rais_quant_otr clearfix">

                                        <ul>

                                            <li>

                                                <a href="#"><img src="{{ asset('percent-images/'.$sliderUserCampaignDetails['user_campaign_amount_raised_percent'].'.png') }}" alt="#" /></a>

                                                <p>Raised {{ $sliderUserCampaignDetails['user_total_amount_raised'] }}</p>

                                            </li>

                                            <li>

                                                <a href="#"><img src="/images/sh_cart_icon.png" alt="#" /></a>

                                                <p>{{ $sliderUserCampaignDetails['user_total_products'] }} @if ($sliderUserCampaignDetails['user_total_products'] > 1) products @else product @endif</p>

                                            </li>

                                        </ul>

                                    </div>

                                </div>





                            </div>



                        </li>



                    @elseif( $slide->type == "stream" )



                        <li>

                            <div class="product_list_outer clearfix">

                                <div class="product_img_outer">

                                    <span><img src="https://i.ytimg.com/vi/{{$slide->stream->youtube_id}}/mqdefault.jpg" alt="#" /></span>

                                </div>





                                <div class="product_det_outer">

                                    <label>{{$slide->stream->name}}</label>

                                    <b>{{$slide->stream->channel->title}}</b>



                                    <div class="pro_rais_quant_otr clearfix">

                                        <ul>

                                            <li>

                                                <a href="#"><img src="/images/bag_img.png" alt="#" /></a>

                                                <p>{{ date("d M Y h:i A", strtotime($slide->stream->created_at)) }}</p>

                                            </li>

                                            <li>

                                                <a class="live_now" href="#">Live Now </a>

                                                <p>Watch Now</p>

                                            </li>

                                        </ul>

                                    </div>

                                </div>





                            </div>



                        </li>

                    @endif

                @endforeach

            </ul>

        </div>





    </div>

@stop



<!-- Page Footer !-->

@section('footer')

@stop







