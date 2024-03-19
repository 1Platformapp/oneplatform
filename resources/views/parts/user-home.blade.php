@extends('templates.advanced-template')

<!-- Page Level CSS !-->

@section('page-level-css')


    <style>

        #container {

            padding: 0 20px 50px;

        }



        pre {

            white-space: pre-wrap;

            tab-size: 2;

            background: black;

            color: white;

        }



        pre[data-lang]::before {

            content: attr(data-lang);

            display: block;

            background-color: #FFA500;

            background-image: -webkit-linear-gradient(top, #FFA500, #D67E21);

            background-image: linear-gradient(to bottom, #FFA500, #D67E21);

            padding: 10px;

        }



        code {

            font-family: "Courier New", Courier, monospace;

            padding: 10px 20px;

            display: inline-block;

        }

    </style>

@stop



<!-- Page Level Javascript !-->

@section('page-level-js')



    <!--  initialize m_custom_scrollbar_function  !-->

    <script defer src="/js/vertical-scroller.js" type="application/javascript"></script>



    <!--  initialize video_plyer !-->

    <script defer src="/js/video-player.js" type="application/javascript"></script>



    <script defer src="/js/feat_items_scroller.js"></script>



    <script defer src="{{asset('js/jquery-ui.min.js')}}" type="application/javascript"></script>



    <script>

        var browserWidth = $( window ).width();

        if( browserWidth <= 767 ){



            //reordering the content on user home page for mobile and smaller devices

            $('.ch_left_sec_outer').insertAfter('.tp_center_video_outer');

            $('.user_hm_rt_btm_otr').insertAfter('.ch_left_sec_outer');

            $('.user_hm_cent_bt_outer').insertAfter('.user_hm_rt_btm_otr');

            $('.donator_outer').parent().insertAfter('.feat_outer');

            $('.project_rit_btm_bns_otr').parent().insertBefore($('.user_hm_rt_btm_otr:not(.feat_outer)').first());

            $('#user_project_outer').insertAfter($(".project_rit_btm_bns_otr").closest(".panel"));

            $('#user_project_outer .tier_two_text_two').insertAfter('#user_project_outer .tier_two_text_one');

            $('#user_project_outer .fund_raise_status').addClass('instant_hide');

            $('.user_follow_outer').insertBefore('.feat_outer');

        }

        window.currentUserId = {{$user->id}};
    </script>


    <script>

        $(document).ready(function() {

            /*setInterval(function(){

                if($('.feat_template').length > 2){
                    $('.feat_template:visible:first #feat_nav_arrow_right').trigger('click');
                }
            }, 5000);*/

            $(".feat_music_info").click(function () {



                var music_id = this.dataset.musicid;

                window.autoPlayMusic = music_id;

                var browserWidth = $( window ).width();






                //$(".add_to_cart_music_" + music_id).fadeIn();



                if($(".btm_center_outer").length){

                    $(".btm_center_outer").fadeOut();

                } else{

                    $(".user_hm_cent_bt_outer").fadeOut();

                }



                if( browserWidth <= 767 ) {



                    //reordering the content for mobile and smaller devices

                    $('.ch_video_detail_outer').insertAfter('.tp_center_video_outer');

                    //$("html, body").animate({scrollTop: $(".add_to_cart_music_" + music_id).offset().top - 50}, 1000);

                    var tab = $('a[href="#tab2"]').trigger('click');

                }else{

                    var tab = $('a[href="#tabd2"]').trigger('click');
                }

                //mediaInstance = playMediaElementVideo(0, 'user-music-files/' + this.dataset.musicfile, mediaInstance, 1);

            });


        });

        var loadUserTab = {{$loadUserTab}};

        $('document').ready(function(){

            if(loadUserTab != ''){

                var browserWidth = $( window ).width();
                if(loadUserTab == '2'){

                    if( browserWidth <= 767 ) {

                        $('a[href="#tab2"]').trigger('click');
                    }else{

                        $('a[href="#tabd2"]').trigger('click');
                    }
                }
            }
        });


    </script>



@stop


@section('preheader')

    @if($user->hasCustomMediaAuthorized() && $user->custom_banner != '')
    <div style="background: none; width: 100%;" class="pre_header_banner">
        <img style="width: 100%;" src="{{asset('user-media/banner/'.$user->custom_banner)}}">
    </div>
    @endif
@stop


@section('header')

    @include('parts.header')

@stop

<!-- Page Header !-->



<!-- facebook/twitter share HTML !-->

@section('social-media-html')

    <div id="fb-root"></div>

    <input type="hidden" id="share_current_page" value="userhome">

    @php
        $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
        $url = 'userhome_'.$user->id;
        $userImageName = $user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $user->profile->profile_display_image_original;
        $shareVideoURL = route('vid.share', ['videoId' => '0cSXq4TYIIk', 'userName' => $user->name, 'url' => $url]);
        $shareURL = route('url.share', ['userName' => $user->name, 'userImage' => $userImageName, 'url' => $url]);
    @endphp

    <input type="hidden" id="video_share_id" value="{{$defaultVideoId}}">

    <input type="hidden" id="video_share_link" value="{{$shareVideoURL}}">

    <input type="hidden" id="video_share_title" value="{{$shareVideoTitle}}">


    <input type="hidden" id="url_share_user_name" value="{{$user->name}}">

    <input type="hidden" id="url_share_link" value="{{$shareURL}}">

@stop

@section('audio-player')

    @include('parts.audio-player')

@stop

@section('top-center')



    <div class="ch_center_outer user_hm_center">

        <h4 class="clearfix"> User Home  <a class="cent_undo_btn" href="javascript:void(0)"></a>  </h4>

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

                            <div class="clearfix ch_tp_sec user_left_bar_top_info mobile-only">

                                <div class="clearfix ch_tp_sec_inner">

                                    <div class="clearfix ch_tp_sec_left">

                                        <a href="javascript:void(0)">
                                            <img class="top_left_user_display_image" src="{{$userPersonalDetails['profileImage']}}" alt="#" />
                                        </a>

                                        <div class="tp_sec_in_det">

                                            <a href="{{ $userPersonalDetails["homePage"] }}" class="user_home_link_left">
                                                <strong class="top_left_user_name">{{ $userPersonalDetails['name'] }}</strong>
                                            </a>

                                            <a href="javascript:void(0)" class="top_left_user_city">
                                                {{ substr($userPersonalDetails['city'], 0, 20) }}
                                            </a>

                                            <a href="javascript:void(0)" class="top_left_user_skills">
                                                {{ substr($userPersonalDetails['skills'], 0, 20) }}
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="jp-interface">

                                <div class="clearfix player_btm_sec">

                                    <div class="player_bot_user_info">
                                        @if($userCampaignDetails['campaignAmount'] == 0)
                                            Store<br>
                                            {{$userCampaignDetails['campaignProducts']}}
                                        @else
                                            Target<br>
                                            {{$userCampaignDetails['campaignGoal'] }}
                                         @endif
                                    </div>

                                    <div class="player_bot_play_vid player_bot_icon" style="cursor: pointer;">
                                        <a href="javascript:void(0)" data-video-id="{{$userPersonalDetails['bioVideoId']}}">
                                            <img src="{{asset('images/player_bot_play.png')}}">
                                        </a>
                                    </div>

                                    <div class="player_bot_tv player_bot_icon">
                                        <a href="javascript:void(0)">
                                            <img src="{{asset('images/player_bot_music.png')}}">
                                        </a>
                                    </div>

                                    <div class="player_bot_social_fb player_bot_icon" style="cursor: pointer;">
                                        <a href="javascript:void(0)" onclick="return facebookShare('video')" >
                                            <img src="{{asset('images/player_bot_fb.png')}}">
                                        </a>
                                    </div>

                                    <div class="player_bot_social_twit player_bot_icon" style="cursor: pointer;">
                                        <a href="javascript:void(0)" onclick="return twitterShare('video')" >
                                            <img src="{{asset('images/player_bot_twit.png')}}">
                                        </a>
                                    </div>

                                    <div class="player_bot_tv player_bot_icon">
                                        <a href="javascript:void(0)">
                                            <img src="{{asset('images/player_bot_tv.png')}}">
                                        </a>
                                    </div>

                                </div>

                            </div>

                            <div class="clearfix tab_btns_outer tab_dsk">

                                <div class="each_tab_btn tab_btn_user_name">
                                    {!! $userPersonalDetails['splitName'] !!}
                                </div>
                                <div class="each_tab_btn tab_btn_music"></div>
                                <div class="each_tab_btn tab_btn_fans"></div>
                                <div class="each_tab_btn tab_btn_social"></div>
                                <div class="each_tab_btn tab_btn_crowd_fund">
                                    @if($userCampaignDetails['campaignAmount'] == 0)
                                        Store<br>
                                        {{$userCampaignDetails['campaignProducts']}}
                                    @else
                                        Target<br>
                                        {{$userCampaignDetails['campaignGoal'] }}
                                    @endif
                                </div>
                                <div class="each_tab_btn tab_btn_play_project"></div>
                                <div class="each_tab_btn tab_btn_tv"></div>

                            </div>

                            <div class="tab_det_left_sec tab_det_dsk">

                                <div style="display: none;" class="lazy_tab_img">
                                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{asset('img/lazy_loading.gif')}}">
                                </div>

                                <div id="tabd1" class="ch_tab_det_sec bio_sec desktop-only">

                                    <div class="btm_text_stor_outer">

                                        <label class="bio_sec_story_title" style="display: none;">{{ $userCampaignDetails['campaignTitle'] }}</label>

                                        <div class="bio_sec_story_text">

                                            <p>{!! $userPersonalDetails['storyText'] !!}</p>

                                            @if( $userPersonalDetails['storyImages'] != '' )

                                                @foreach(explode(', ', $userPersonalDetails['storyImages']) as $key => $storyImage)

                                                    <img class="user_story_image defer_loading" src="" data-src="{{ 'user-story-images/'.$storyImage }}">

                                                @endforeach

                                            @endif

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

                            </div>

                        </div>



                    </div>

                </div>





            </div>

        </div>


        <div class="cent_btm_inp_outer">

            <ul>

                <li><label><input type="text" placeholder="Name" /></label></li>

                <li><label><input type="email" placeholder="Email Address" /></label></li>

                <li><label><input type="tel" placeholder="Phone Number (Optional)" /></label></li>

                <li><label><input type="text" placeholder="Your Website (Optional)" /></label></li>

                <li><label><textarea placeholder="Your Message"></textarea></label></li>

                <li><label><input type="submit" value="Send Message" /></label></li>

            </ul>

        </div>

    </div>

@stop



<!-- Right Bar !-->

@section('top-right')


@stop



<!-- Left Bar !-->

@section('top-left')

    <div class="ch_tab_sec_outer">

        <div class="panel">

            <div class="desktop-only">

                <h2 class="project_name">{{$userPersonalDetails['name']}}'s Store</h2>

            </div>

            <div class="ch_bag_pric_sec bio_sec desktop-only">

                <div class="fund_raise_left">

                    <img class="bio_sec_percent_image" src="{{$userPersonalDetails['profileImageCard']}}" alt="#" />

                    <h3 class="project_line">My Music, Products & Licensing</h3>
                    <div class="fund_raise_status"></div>

                </div>

                <div class="fund_raise_right">

                    <div class="pricing_setail">

                        <ul>

                            <li class="clearfix">

                                <h3 class="tier_one_text_one bio_sec_tot_fans">
                                    {{$userCampaignDetails['campaignProducts']}}
                                </h3>

                            </li>

                            <li class="clearfix">

                                <p class="tier_one_text_two">Products available</p>

                            </li>

                            <li class="fleft">

                                <h3 class="tier_two_text_one bio_sec_tot_amo_rai">City</h3>

                            </li>

                            <li class="fright">

                                <h3 class="tier_three_text_one bio_sec_low_txt">
                                    Skill
                                </h3>

                            </li>

                            <li class="fleft">

                                <p class="tier_two_text_two">{{$userPersonalDetails['city']}}</p>

                            </li>

                            <li class="fright">

                                <p class="tier_three_text_two bio_sec_up_txt">{{$userPersonalDetails['skills']}}</p>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

            <div class="clearfix social_btns desktop-only">

                <ul class="clearfix">

                    <li>
                        <a onclick="return facebookShare('url')" class="ch_sup_fb" href="javascript:void(0)">
                            <i class="fab fa-facebook-f vertical_center"></i>
                        </a>
                    </li>
                    <li>
                        <a onclick="return twitterShare('url')" class="ch_sup_fb" href="javascript:void(0)">
                            <i class="fab fa-twitter vertical_center"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ch_sup_fb full_support_me" href="{{$userCampaignDetails['campaignAmount'] > 0 ? route('user.project', ['userId' => $user->id]) : 'javascript:void(0)'}}">
                            <i class="fas fa-dollar-sign vertical_center"></i>
                        </a>
                    </li>
                </ul>

            </div>

        </div>

        @if(Auth::check() && $user && Auth::user()->id != $user->id)
        <div class="panel user_follow_outer">
            <div class="user_follow_btn">
                <div class="user_follow_inner">
                    {{Auth::check() && $user && Auth::user()->isFollowerOf($user) ? 'Following' : 'Follow' }}
                </div>
            </div>
        </div>
        @endif

        <div class="panel">

            <div class="user_hm_rt_btm_otr feat_outer">

                <?php $count = 0; ?>



                @foreach($userFeatMusics as $userFeatMusic)

                    @include('parts.feat_music_template', ["userFeatMusic" => $userFeatMusic, "count" => ++$count] )

                @endforeach



                @foreach($userFeatProducts as $userFeatProduct)

                    @if($userFeatProduct->is_ticket == 1)

                        @include('parts.feat_ticket_template', ["userFeatProduct" => $userFeatProduct, "count" => ++$count] )

                    @elseif($userFeatProduct->thumbnail != "")

                        @include('parts.feat_product_template', ["userFeatProduct" => $userFeatProduct, "count" => ++$count] )

                    @else

                        @include('parts.feat_product_thumbless', ["userFeatProduct" => $userFeatProduct, "count" => ++$count] )

                    @endif

                @endforeach


                @if($count == 0)

                @include('parts.feat_blank_card', ["count" => ++$count])

                @include('parts.feat_blank_card_2', ["count" => ++$count])

                @endif


                <input type="hidden" id="feat_current_slide" value="1">

                <input type="hidden" id="feat_total_slides" value="{{ $count }}">

            </div>

        </div>

        @if($user->accept_donations == 1)
        <div class="panel">
            @php
                $donationValue = 0;
                $donation = false;
                foreach($basket as $key => $item){

                    if($item->purchase_type == 'donation_goalless'){
                        $donationValue = $item->price;
                        $donation = true;
                    }
                }
            @endphp
            <div class="donator_outer donation_goalless {{ (!$donation) ? '' : 'donation_agree' }}">
                <div class="clearfix donator_box">
                    <h3>Make A Contribution</h3>
                    <p>Contributions are not associated with perks</p>
                    <div class="donation_left">
                        <span id="donation_currency">{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}</span>
                        <input {{ (!$donation) ? '' : 'readonly' }} value="{{ (!$donation) ? '' : $donationValue }}" type="number" min="0" id="donation_amount" name="donation_amount" class="{{ (!$donation) ? 'evade_auto_fill' : '' }}" />
                    </div>
                    <div class="donation_right">
                        <div data-basketuserid="{{ $user->id }}" class="donation_right_in">
                            {{ (!$donation) ? 'Add To Cart' : 'Added To Cart' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif

        @if($user->subscription_amount != null && $user->subscription_amount > 0)
        <!--<div class="panel ">
            @php $encourageBullets = $user->encourage_bullets; @endphp
            <div class="project_rit_btm_bns_otr">
                <div class="{{ (!$basket->contains('purchase_type', 'subscription')) ? 'project_rit_btm_list' : 'proj_rit_btm_list_gray' }}" id="subscribe_box">
                    <h4>Subscribe to {{$user->name}}</h4>
                    <div class="subsription_box_heading">Items included to this monthly subscription</div>
                    <ul class="subsription_box_list">
                        @if(is_array($encourageBullets) && $encourageBullets[0] != '')
                        <li><p>{{ $encourageBullets[0] }}</p></li>
                        @endif
                        @if(is_array($encourageBullets) && $encourageBullets[1] != '')
                        <li><p>{{ $encourageBullets[1] }}</p></li>
                        @endif
                        @if(is_array($encourageBullets) && $encourageBullets[2] != '')
                        <li><p>{{ $encourageBullets[2] }}</p></li>
                        @endif
                    </ul>
                    <label class="proj_add_sec {{ (!$basket->contains('purchase_type', 'subscription')) ? '' : 'proj_add_sec_added' }}" id="subscribe_btn" data-basketuserid="{{ $user->id }}" data-basketprice="{{ $user->subscription_amount }}" style="cursor: pointer;">{{ (!$basket->contains('purchase_type', 'subscription')) ? 'Subscribe' : 'Added To Cart' }}<b>{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{number_format($user->subscription_amount, 2) }} p/m</b>
                    </label>
                </div>
            </div>
        </div>!-->
        @endif
        <div class="panel">

            <div class="user_hm_rt_btm_otr">

                <label class="side_nav_head">My Music, Products & Licensing</label>

                <a href="javascript:void(0)" data-target-id="tabd2" class="desktop-only trig_click"><img style="margin: 0 auto;" src="{{ asset('/images/music_block.png') }}"></a>

                <a href="javascript:void(0)" data-target-id="tab2" class="mobile-only mobile-panel trig_click trig_mobile">
                    <p>
                        <img src="{{ asset('/images/music_block.png') }}">
                    </p>
                    <span>Click here to check out my music</span>
                </a>

            </div>

        </div>


        @if($userCampaignDetails['campaignAmount'] > 0)
        <div id="user_project_outer" data-link="{{route('user.project', ['id' => $user->id])}}" class="panel card_pro_hover card_pro_click user_hm_rt_btm_otr">

            <div class="desktop-only">

                <h2 class="project_name">{{$userCampaignDetails['projectTitle']}}</h2>

            </div>

            <div class="ch_bag_pric_sec bio_sec">

                <div class="fund_raise_left">

                    <img class="bio_sec_percent_image a_percent" src="{{$userCampaignDetails['mainHeaderImage']}}" alt="#" />

                    <h3 class="project_line">{{$userCampaignDetails['mainHeaderTextOne']}}</h3>
                    <div class="fund_raise_status">{{$userCampaignDetails['mainHeaderTextTwo']}}</div>

                </div>

                <div class="fund_raise_right">

                    <div class="pricing_setail">

                        <ul>

                            <li class="clearfix">

                                <h3 class="tier_one_text_one bio_sec_tot_fans">
                                    {{$userCampaignDetails['tierOneTextOne']}}
                                </h3>

                            </li>

                            <li class="clearfix">

                                <p class="tier_one_text_two">{{$userCampaignDetails['tierOneTextTwo']}}</p>

                            </li>

                            <li class="fleft">

                                <h3 class="tier_two_text_one bio_sec_tot_amo_rai">
                                    {{$userCampaignDetails['tierTwoTextOne']}}
                                </h3>

                            </li>

                            <li class="fright">

                                <h3 class="tier_three_text_one bio_sec_low_txt">
                                    {{$userCampaignDetails['tierThreeTextOne']}}
                                </h3>

                            </li>

                            <li class="fleft">

                                <p class="tier_two_text_two">{!! $userCampaignDetails['tierTwoTextTwo'] !!}</p>

                            </li>

                            <li class="fright">

                                <p class="tier_three_text_two bio_sec_up_txt">
                                    {{$userCampaignDetails['tierThreeTextTwo']}}
                                </p>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        @endif

        <!--<div class="panel">

            <div class="user_hm_rt_btm_otr">

                <label class="side_nav_head">My Social Pages</label>

                <a href="javascript:void(0)" data-target-id="tabd4" class="desktop-only trig_click">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/social_block2.jpg') }}">
                </a>

                <a href="javascript:void(0)" data-target-id="tab4" class="mobile-only trig_click trig_mobile">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/social_block2.jpg') }}">
                </a>

            </div>

        </div>

        <div class="panel">

            <div class="user_hm_rt_btm_otr">

                <label class="side_nav_head">My Fans</label>

                <a href="javascript:void(0)" data-target-id="tabd3" class="desktop-only trig_click">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/fans_block2.png') }}">
                </a>

                <a href="javascript:void(0)" data-target-id="tab3" class="mobile-only trig_click trig_mobile">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/fans_block2.png') }}">
                </a>
            </div>

        </div>

        @if($userCampaignDetails['campaignAmount'] > 0)
        <div class="panel">

            <div class="user_hm_rt_btm_otr">

                <label class="side_nav_head">My Crowdfunder</label>

                <a href="{{route('user.project', ['userId' => $user->id])}}">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/crowd_fund_age_img.jpg') }}">
                </a>

            </div>

        </div>
        @endif

        @if($userParams != 'customDomain')
        <div class="panel">

            <div class="user_hm_rt_btm_otr">

                <label class="side_nav_head">Audition TV</label>

                <a href="{{ route('tv') }}" class="desktop-only">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/audition_tv_block.png') }}">
                </a>

                <a href="{{ route('tv') }}" class="mobile-only mobile-panel">
                    <p>
                        <img class="defer_loading" src="" data-src="{{ asset('/images/audition_tv_block.png') }}">
                    </p>
                    <span>Click here to check out the Audition TV</span>
                </a>
            </div>

        </div>

        <div class="panel">

            <div class="user_hm_rt_btm_otr">

                <label class="side_nav_head">Experts & Producers</label>

                <a href="{{ route('live') }}" class="desktop-only">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/studios_producers_block.png') }}">
                </a>

                <a href="{{ route('live') }}" class="mobile-only mobile-panel">
                    <p>
                        <img class="defer_loading" style="margin: 0 auto" src="" data-src="{{ asset('/images/studios_producers_block.png') }}">
                    </p>
                    <span>Click here to check out the experts on the Audition TV</span>
                </a>
            </div>

        </div>

        <div class="panel">

            <div class="user_hm_rt_btm_otr">

                <label class="side_nav_head">The Audition Chart</label>

                <a href="{{ route('chart') }}" class="desktop-only">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{ asset('/images/audition_chart_block.png') }}">
                </a>

                <a href="{{ route('chart') }}" class="mobile-only mobile-panel">
                    <p>
                        <img class="defer_loading" src="" data-src="{{ asset('/images/audition_chart_block.png') }}">
                    </p>
                    <span>Click here to check out the Audition chart</span>
                </a>
            </div>

        </div>
        @endif
    </div>!-->

    <div class="ch_tab_sec_outer mobile-only">

        <div class="clearfix tab_btns_outer">

            <ul>

                <li><a href="#tab1" class="tab_active">Bio</a></li>

                <li><a href="#tab2">Music</a></li>

                <li><a href="#tab3">Fans</a></li>

                <li><a href="#tab4">Social</a></li>

            </ul>

        </div>

        <div class="ch_tab_det_outer">

            <div class="tab_det_inner tab_det_left_sec right_height_res user_home_left_bar">

                <div style="display: none;" class="lazy_tab_img">
                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{asset('img/lazy_loading.gif')}}">
                </div>
                <div id="tab1" class="ch_tab_det_sec bio_sec " style="display: block;">

                    <div class="btm_text_stor_outer">
                        <label class="bio_sec_story_title user_campaign_title" style="display: none;">
                            {{$userCampaignDetails['campaignTitle']}}
                        </label>
                        <div class="bio_sec_story_text">
                            <p>{!! $userPersonalDetails['storyText'] !!}</p>
                            @if( $userPersonalDetails['storyImages'] != '' )
                                @foreach(explode(', ', $userPersonalDetails['storyImages']) as $key => $storyImage)
                                    <img class="user_story_image defer_loading" src="" data-src="{{ 'user-story-images/'.$storyImage }}">
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @if(count($allPastProjects) > 0)
                        <div class="btm_text_stor_outer mobile-only">
                            <label class="bio_sec_story_title" style="color: #fc064c;"><b>Past Projects</b></label>
                            @foreach($allPastProjects as $pastProject)
                                <p><a href="{{ asset("project/" . $pastProject->user_id . "?load_campaign=" . $pastProject->id) }}">{!! $pastProject->title !!}</a></p>
                            @endforeach
                        </div>
                    @endif
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
                <a href="#" class="read-more mobile-only">Read more</a>
            </div>
        </div>!-->
    </div>
@stop



@section('bottom-row-full-width')

@stop



@section('slide')

@stop



@section('miscellaneous-html')
    <div id="body-overlay"></div>
    @include('parts.chart-popups')
</div>
@stop

