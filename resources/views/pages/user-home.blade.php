@extends('templates.advanced-template')

@section('pagetitle')
    @if($user->profile->seo_title != '')
        {{$user->profile->seo_title}}
    @else
        {{$user->name}} - Home
    @endif
@endsection

@section('pagekeywords')
    @if($user->profile->seo_keywords != '')
        <meta name="keywords" content="{{$user->profile->seo_keywords}}" />
    @endif
@endsection

@section('pagedescription')
    @if($user->profile->seo_description != '')
        <meta name="description" content="{{$user->profile->seo_description}}"/>
    @else
        <meta name="description" content="{{strip_tags(preg_replace('/\s+/', ' ', $userPersonalDetails['storyText']))}}"/>
    @endif
@endsection

@section('seocontent')
@endsection

@section('page-level-css')

    <link rel="stylesheet" href="{{asset('css/user-home.min.css?v=3.8')}}"></link>
    <link rel="stylesheet" href="{{asset('css/portfolio.min.css')}}"></link>

    @if($user->home_layout == 'background')
        <link rel="stylesheet" href="{{asset('css/user_home_background.min.css')}}"></link>
    @endif

    @if($user->home_layout == 'banner')
        <link rel="stylesheet" href="{{asset('css/user_home_banner.css?v=1.0')}}"></link>
    @endif

@stop

@section('page-level-js')

    <script defer src="/js/video-player.js"></script>
    <script defer src="/js/feat_items_scroller.js"></script>

    @if($user->home_layout == 'background')
        <script src="{{ asset('js/user_home_background.min.js') }}"></script>
    @endif

    <script>
        $('document').ready(function(){
            $('.feat_music_info').click(function(){
                var thiss = $(this);
                var musicFile = thiss.attr('data-musicfile');
                $('.user_short_tab_each[data-target-id="2"]').trigger('click');
                updateAndPlayAudioPlayer(thiss, '/user-music-files/' + musicFile, true);
            });

            $('.fore_close').click(function(){

                $('.pg_fore_out').removeClass('fore_active');
            });

            $('#redirect-to-store').click(function(){
                var id = $(this).attr('data-id');
                if(id == 1) {
                    $('.each_tab_btn[data-show="#tabd1"]').trigger('click');
                } else if(id == 2) {
                    $('.each_tab_btn[data-show="#tabd2"]').trigger('click');
                } else if(id == 3) {
                    $('.each_tab_btn[data-show="#tabd3"]').trigger('click');
                } else if(id == 4) {
                    $('.each_tab_btn[data-show="#tabd4"]').trigger('click');
                } else if(id == 5) {
                    $('.each_tab_btn[data-show="#tabd5"]').trigger('click');
                } else if(id == 6 || id == 7) {
                    $('.each_tab_btn[data-show="#tabd6"]').trigger('click');
                }
            });

            var browserWidth = $( window ).width();
            if( browserWidth <= 767 ){
                $('.ch_left_sec_outer').replaceWith('<section class="ch_left_sec_outer">' + $('.ch_left_sec_outer').html() +'</section>');
                $('.tab_btns_outer').appendTo('.ch_left_sec_outer');
                $('.tab_det_left_sec').closest('main').appendTo('.ch_left_sec_outer');
                $('.ch_left_sec_outer').appendTo('#ch_left_sec_outer_filler');
                $('.user_hm_rt_btm_otr.feat_outer').parent().appendTo('#feat_outer_filler');
                $('#user_project_outer').appendTo('#save_user_project_filler');
                $('.donator_outer').parent().appendTo('#donator_outer_filler');
                $('.project_rit_btm_bns_otr').parent().appendTo('#subscribe_box_filler');
                $('.user_follow_outer').appendTo('#user_follow_outer_filler');
                $('.user_short_hand_tab_outer').appendTo('#user_short_hand_tab_filler');
                $('.news_updates_outer').appendTo('#news_updates_outer_filler');
                $('.portfolio_outer').insertAfter('#portfolio_outer_filler');
                $('.services_outer').appendTo('#user_services_filler');
                $('#tab1 .bio_sec_story_text').html($('#tabd1 .bio_sec_story_text').html());
            }
            if( browserWidth <= 767 ){
                $('.desktop-only,.hide_on_mobile').remove();
            }else{
                $('.mobile-only,.hide_on_desktop').remove();
            }
            if($('.vid_preloader').length && !$('.vid_preloader').hasClass('instant_hide')){
                $('.content_outer').addClass('playing');
            }
            if($('.each_tab_btn.tab_btn_crowd_fund').hasClass('true_active')){

                var proOfferTimerInstance = new Interval(1000);
                productOfferCountdown(proOfferTimerInstance);
            }
            window.currentUserId = "{{$user->id}}";
            window.loggedInUserId = "{{Auth::user()?Auth::user()->id:''}}";

            $('.user_sub_paypal a').click(function(){
                if(window.loggedInUserId != ''){
                    window.location.href = '/paypal/subscribe/'+window.currentUserId;
                }else{
                    $('#sub_paypal_info,#body-overlay').show();
                }
            });
            $('#sub_paypal_info_proceed').click(function(){
                if($('#sub_paypal_info_first_name').val() == '' || $('#sub_paypal_info_last_name').val() == '' || $('#sub_paypal_info_email').val() == ''){
                    $('#sub_paypal_info_error').removeClass('instant_hide');
                }else{
                    $(this).closest('form').submit();
                }
            });
        });

        var showPopup = '{{$showPopup}}';
        if(showPopup != ''){
            $(showPopup+',#body-overlay').show();
            if(showPopup == '#bespoke_license_popup'){
                $(showPopup).attr('data-recipient', window.currentUserId);
            }
        }
    </script>
@stop

@section('preheader')

    @if($user->home_layout == 'banner' && $user->custom_banner != '')
        <div style="background: none; width: 100%;" class="pre_header_banner">
            <img class="defer_loading instant_hide" alt="{{$user->name.'\'s banner'}}" style="width: 100%;" src="#" data-src="{{asset('user-media/banner/'.$user->custom_banner)}}">
        </div>
    @endif

@stop

@section('header')
    @include('parts.header')
@stop

@section('imp-notice')
    @if(!$user->hasActivePaidSubscription() && !$user->networkAgent())

    @endif
@stop

@section('page-background')

    @if($user->home_layout == 'background')
        <div data-url="/user-media/background/{{$user->custom_background}}" class="pg_back back_inactive"></div>
    @endif

    @if(!Session::has('exempt_splash') && $user->profile->splash && isset($user->profile->splash['id']))
        @if($user->profile->splash['type'] == 'product')
            @php $item = \App\Models\UserProduct::find($user->profile->splash['id']) @endphp
        @else
            @php $item = \App\Models\UserMusic::find($user->profile->splash['id']) @endphp
        @endif
        <link class="switchmediaall" href="https://fonts.googleapis.com/css2?family=Potta+One&amp;display=swap" rel="stylesheet">
        <div class="pg_fore_out fore_active">
            <div class="pg_fore"></div>
            <div class="pg_fore_in">
                <div class="fore_actions">
                    <div class="fore_close">
                        <svg data-bbox="25.9 25.9 148.2 148.2" xmlns="http://www.w3.org/2000/svg" viewBox="25.9 25.9 148.2 148.2" role="img">
                            <g>
                                <path d="M171.3 158.4L113 100l58.4-58.4c3.6-3.6 3.6-9.4 0-13s-9.4-3.6-13 0L100 87 41.6 28.7c-3.6-3.6-9.4-3.6-13 0s-3.6 9.4 0 13L87 100l-58.4 58.4c-3.6 3.6-3.6 9.4 0 13s9.4 3.6 13 0L100 113l58.4 58.4c3.6 3.6 9.4 3.6 13 0s3.5-9.5-.1-13z"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="fore_content">
                    <div class="fore_title_main">
                        {{$user->profile->splash['type'] == 'product' ? $item->title : $item->song_name}}
                    </div>
                    @if($user->profile->splash['type'] == 'music')
                        @if($item->thumbnail_feat != '')
                            @php $thumbnail = asset('user-music-thumbnails/'.$item->thumbnail_feat) @endphp
                        @else
                            @php $thumbnail = asset('img/url-thumb-profile.jpg') @endphp
                        @endif
                    @elseif($user->profile->splash['type'] == 'product')
                        @if($item->thumbnail != '')
                            @php $thumbnail = asset('user-product-thumbnails/'.$item->thumbnail) @endphp
                        @else
                            @php $thumbnail = asset('img/url-thumb-profile.jpg') @endphp
                        @endif
                    @endif
                    <div class="fore_thumb">
                        <img class="defer_loading instant_hide" alt="{{$user->profile->splash['type'] == 'product' ? $item->title : $item->song_name}}" data-src="{{$thumbnail}}" src="#" />
                    </div>
                    <div class="fore_link">
                        @if($user->profile->splash['type'] == 'music')
                            <a href="{{route('item.share.track', ['itemSlug' => str_slug($item->song_name)])}}">Listen</a>
                        @else
                            <a href="{{route('item.share.product', ['itemSlug' => str_slug($item->title)])}}">View</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section('social-media-html')

    <div id="fb-root"></div>
    <input type="hidden" id="share_current_page" value="userhome">

    @php
        $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
        $url = 'userhome_'.$user->id;
        $userImageName = $user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $user->profile->profile_display_image_original;
        $shareVideoURL = route('vid.share', ['videoId' => '0cSXq4TYIIk', 'userName' => $user->name, 'url' => $url]);
        $shareURL = route('url.share', ['userName' => $user->name, 'imageName' => base64_encode($userImageName), 'url' => $url]);
    @endphp

    <input type="hidden" id="video_share_id" value="{{$defaultVideoId}}">
    <input type="hidden" id="video_share_link" value="{{$shareVideoURL}}">
    <input type="hidden" id="video_share_title" value="{{$shareVideoTitle}}">
    <input type="hidden" id="url_share_user_name" value="{{$user->name}}">
    <input type="hidden" id="url_share_link" value="{{$shareURL}}">
    <input type="hidden" id="item_share_title" value="">
    <input type="hidden" id="item_share_link" value="">

@stop

@section('audio-player')

    @include('parts.audio-player')

@stop

@section('flash-message-container')

    @if (Session::has('error'))
        <div class="error_span">
            <i class="fa fa-times-circle"></i>
            {{ (is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error') }}
        </div>
    @endif

    @if (Session::has('success'))
        <div class="success_span">
            <i class="fa fa-check-circle"></i>
            @if(is_array(Session::get('success')))
                {!! Session::get('success')[0] !!}
            @else
                {!! Session::get('success') !!}
            @endif
        </div>
    @endif

    @if (!Session::has('success') && !Session::has('error') && Session::has('notice'))
        <div class="success_span notice_span">
            <i class="fa fa-bell"></i> &nbsp;
            @if(is_array(Session::get('notice')))
                {!! Session::get('notice')[0] !!}
            @else
                {!! Session::get('notice') !!}
            @endif
        </div>
    @endif
@stop

@section('top-center')

    <div class="ch_center_outer user_hm_center">
        <aside class="top_info_box hide_on_mobile">
            <div class="top_info_right_icon">
                <i class="fa fa-share"></i>
            </div>
        </aside>
        <div class="tp_center_video_outer">
            <div class="jp-gui">

                <video width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader {{$user->home_layout == 'background' ? 'instant_hide' : ''}}" preload="none">
                    <source type="video/youtube" src="https://www.youtube.com/watch?v={{ $defaultVideoId }}" />
                </video>
                <aside class="tab_btns_outer tab_dsk hide_on_mobile clearfix {{$user->home_layout == 'background' ? 'back_curvs' : ''}}">
                    <div class="each_tab_btn tab_btn_user_bio {{$user->default_tab_home == NULL || $user->default_tab_home == 1 ? 'true_active' : ''}}" data-show="#tabd1">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_music {{count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 2 ? 'true_active' : ''}}" data-show="#tabd2">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_fans {{count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 3 ? 'true_active' : ''}}" data-show="#tabd3">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_social {{count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 4 ? 'true_active' : ''}}" data-show="#tabd4">
                        <div class="border"></div>
                    </div>
                    @if($userCampaignDetails['campaignIsLive'] == '1' && $userCampaignDetails['campaignStatus'] == 'active')
                    @php $hasCrowdfunder = 1 @endphp
                    @else
                    @php $hasCrowdfunder = 0 @endphp
                    @endif
                    <div class="each_tab_btn tab_btn_crowd_fund store {{count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 6 ? 'true_active' : ''}}" data-show="#tabd6">
                        <div class="border_alter">
                            Store<br>{{$userCampaignDetails['campaignProducts']}}
                        </div>
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_video {{count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 5 ? 'true_active' : ''}}" data-show="#tabd5" data-video-id="{{$userPersonalDetails['bioVideoId']}}">
                        <div class="border"></div>
                    </div>
                    @if(!$user->isCotyso())
                    <div class="each_tab_btn tab_btn_tv" data-show="">
                        <div class="border"></div>
                    </div>
                    @endif
                </aside>
                <aside class="clearfix tab_btns_outer tab_shared mobile-only ch_tab_sec_outer">
                    <div class="each_tab_btn tab_btn_user_bio {{$user->default_tab_home == NULL || $user->default_tab_home == 1 ? 'true_active' : ''}}" data-show="#tabd1">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_music {{count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 2 ? 'true_active' : ''}}" data-show="#tabd2">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_fans {{count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 3 ? 'true_active' : ''}}" data-show="#tabd3">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_social {{count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 4 ? 'true_active' : ''}}" data-show="#tabd4">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_crowd_fund store {{count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 6 ? 'true_active' : ''}}" data-show="#tabd6">
                        <div class="border_alter">
                            Store<br>{{$userCampaignDetails['campaignProducts']}}
                        </div>
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_video {{count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 5 ? 'true_active' : ''}}" data-show="#tabd5">
                        <div class="border"></div>
                    </div>
                    @if(!$user->isCotyso())
                    <div class="each_tab_btn tab_btn_tv" data-show="">
                        <div class="border"></div>
                    </div>
                    @endif
                </aside>
                <main>
                    <section class="tab_det_left_sec tab_det_dsk tab_det_inner right_height_res expanded @if($user->isCotyso()) expanded @if($user->default_tab_home != 6) leave @else p10 @endif @endif">
                        <h1 class="page_title">
                            @if($user->profile->seo_h1)
                                {{$user->profile->seo_h1}}
                            @else
                            	{{$user->name}}
                            	@if($userPersonalDetails['skills'] != '')
                            		{{' is a '.$userPersonalDetails['skills']}}
                            	@endif
                            	@if($userPersonalDetails['skills'] == '' && $userPersonalDetails['city'] != '')
                            		{{' is'}}
                            	@endif
                            	@if($userPersonalDetails['city'] != '')
                            		{{' based in '.$userPersonalDetails['city']}}
                            	@endif
                            @endif
                        </h1>
                        <aside style="display: none;" class="lazy_tab_img">
                            <img alt="loading" class="defer_loading" style="margin: 0 auto;" src="#" data-src="{{asset('img/lazy_loading.gif')}}">
                        </aside>
                        <article id="tabd1" class="ch_tab_det_sec bio_sec {{$user->default_tab_home == NULL || $user->default_tab_home == 1 ? '' : 'instant_hide'}}">
                            <div class="lazy_tab_content">
                                @if($user->default_tab_home == NULL || $user->default_tab_home == 1)
                                {!! \View::make('parts.user-bio-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render() !!}
                                @endif
                            </div>
                        </article>
                        <article id="tabd2" class="ch_tab_det_sec music_sec {{$user->default_tab_home == 2 ? '' : 'instant_hide'}}">
                            <div class="lazy_tab_content">
                                @if($user->default_tab_home == 2)
                                {!! \View::make('parts.user-music-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render() !!}
                                @endif
                            </div>
                        </article>
                        <article id="tabd3" class="ch_tab_det_sec fans_sec {{$user->default_tab_home == 3 ? '' : 'instant_hide'}}">
                            <br><br>
                            <div class="lazy_tab_content">
                                @if($user->default_tab_home == 3)
                                {!! \View::make('parts.user-fans-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render() !!}
                                @endif
                            </div>
                        </article>
                        <article id="tabd4" class="ch_tab_det_sec social_sec {{$user->default_tab_home == 4 ? '' : 'instant_hide'}}">
                            <div class="lazy_tab_content">
                                @if($user->default_tab_home == 4)
                                {!! \View::make('parts.user-social-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render() !!}
                                @endif
                            </div>
                        </article>
                        <article id="tabd5" class="ch_tab_det_sec {{$user->default_tab_home == 5 ? '' : 'instant_hide'}}">
                            <div class="lazy_tab_content">
                                @if($user->default_tab_home == 5)
                                {!! \View::make('parts.user-video-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render() !!}
                                @endif
                            </div>
                        </article>
                        <article id="tabd6" class="ch_tab_det_sec {{$user->default_tab_home == 6 ? '' : 'instant_hide'}}">
                            <div class="lazy_tab_content">
                                @if($user->default_tab_home == 6)
                                {!! \View::make('parts.user-products-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render() !!}
                                @endif
                            </div>
                        </article>
                    </section>
                </main>
            </div>
        </div>
        <section>
            <div class="filler" id="ch_left_sec_outer_filler"></div>
            <div class="filler" id="user_services_filler"></div>
            <div class="filler" id="feat_outer_filler"></div>
            <div class="filler" id="news_updates_outer_filler"></div>
            <div class="filler" id="user_short_hand_tab_filler"></div>
            <div class="filler" id="user_follow_outer_filler"></div>
            <div class="filler" id="donator_outer_filler"></div>
            <div class="filler" id="subscribe_box_filler"></div>
            <div class="filler" id="save_user_project_filler"></div>
        </section>
    </div>
@stop

@section('top-right')
@stop

@section('top-left')

    <div class="ch_tab_sec_outer">
        <div class="panel main_panel {{$user->home_layout == 'background' ? 'back_curvs' : ''}} colio_outer colio_dark">
            @if($user->home_layout != 'background')
            <div class="desktop-only panel_head">
                <h2 class="project_name">{{$userPersonalDetails['name']}}'s Store</h2>
            </div>
            @endif
            <div class="ch_bag_pric_sec bio_sec">
                <div class="fund_raise_left">
                    @if($user->home_layout != 'background')
                    <img alt="{{$user->name.'\'s profile image'}}" class="bio_sec_percent_image desktop-only" src="{{$userPersonalDetails['profileImageCard']}}" alt="#" />
                    @endif
                    <div class="project_line colio_header">{{str_limit($user->name, 23, '...')}}</div>
                    <div class="fund_raise_status"></div>
                </div>
                <div class="fund_raise_right">
                    <div class="pricing_setail">
                        <ul>
                            <li class="fleft">
                                <div class="tier_one_text_one header3">
                                    {{$userCampaignDetails['campaignProducts']}}
                                </div>
                            </li>
                            <li class="fright">
                                <div class="tier_four_text_one project_txt header3">
                                    @if($hasCrowdfunder)
                                        {{$userCampaignDetails['campaignCurrencySymbol'].$userCampaignDetails['amountRaised'].' / '.$userCampaignDetails['campaignGoal']}}
                                    @endif
                                </div>
                            </li>
                            <li class="fleft">
                                <p class="tier_one_text_two">Products available</p>
                            </li>
                            <li class="fright">
                                <p class="tier_four_text_two">
                                @if($hasCrowdfunder)
                                    Crowdfund project
                                @endif
                                </p>
                            </li>
                            <li class="fleft">
                                <div class="tier_two_text_one header3">City</div>
                            </li>
                            @if(!$user->isCotyso())
                            <li class="fright">
                                <div class="tier_three_text_one header3">Skill</div>
                            </li>
                            @endif
                            <li class="fleft">
                                <p class="tier_two_text_two">{{$userPersonalDetails['city']}}</p>
                            </li>
                            @if(!$user->isCotyso())
                            <li class="fright">
                                <p class="tier_three_text_two">{{$userPersonalDetails['skills']}}</p>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix social_btns desktop-only">
                <ul class="clearfix">
                    <li>
                        <a onclick="return facebookShare('url')" class="ch_sup_fb" href="javascript:void(0)">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a onclick="return twitterShare('url')" class="ch_sup_tw" href="javascript:void(0)">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    @if($user->feature_tab_home)
                    <li>
                        <a data-id="{{$user->feature_tab_home}}" class="ch_sup_feature_tab" href="javascript:void(0)">
                            @if($user->feature_tab_home == 2)
                            <i class="fa fa-music"></i>
                            @elseif($user->feature_tab_home == 3)
                            <i class="fa fa-hand-holding-heart"></i>
                            @elseif($user->feature_tab_home == 4)
                            <i class="fa fa-share-alt"></i>
                            @elseif($user->feature_tab_home == 5)
                            <i class="fa fa-play"></i>
                            @elseif($user->feature_tab_home == 6)
                            <i class="fa fa-ticket-alt"></i>
                            @endif
                        </a>
                    </li>
                    @endif
                    @if(!$user->isCotyso())
                    <li>
                        <a class="ch_sup_chat {{$user->chat_switch == 1 ? '' : 'chart_disabled'}}" href="javascript:void(0)">
                            <i class="fa fa-comments"></i>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a class="ch_sup_fb full_support_me {{$hasCrowdfunder?'':'chart_disabled'}}" href="{{$hasCrowdfunder ? route('user.project', ['username' => $user->username]) : 'javascript:void(0)'}}">
                            <img alt="Support {{$user->name}}" src="{{asset('images/fa-users.png')}}">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @if($user->id == 765)
            <a class="panel se_booking" href="https://www.clients.singingexperience.co.uk">
                Redeem Voucher
            </a>
        @endif
        <div class="panel user_follow_outer {{!Auth::check() ? 'unauth' : ''}}">
            <div class="user_follow_btn">
                <div class="user_follow_inner">
                    <i class="fa fa-rss"></i>
                    {{Auth::check() && $user && Auth::user()->isFollowerOf($user) ? 'Following' : 'Follow' }}
                </div>
            </div>
        </div>
        @if(count($user->services))
            @include('parts.user-services-panel', ['user' => $user])
        @endif
        @php
            $userNews = \App\Models\UserNews::where(['user_id' => $user->id])->orderBy('featured' , 'desc')->get()
        @endphp
        @if(count($userNews))
        <div class="panel news_updates_outer colio_outer colio_dark">
            <div class="colio_header">News update</div>
            @foreach($userNews as $news)
            <div class="news_update_each">
                <div class="news_update_date">{{date('d/m/Y h:i A', strtotime($news->created_at))}}</div>
                <div class="news_update_val">{{$news->value}}</div>
                @if($news->tab)
                <div data-id="{{$news->tab}}" class="news_update_link {{$news->tab == '6' || $news->tab == '7' ? 'tilted' : ''}}">
                    <span id="redirect-to-store" data-id="{{$news->tab}}" class="p-2 text-black bg-white rounded-lg cursor-pointer hover:bg-gray-200">
                    @if($news->tab == '6' || $news->tab == '7')
                    <i class="fa fa-ticket-alt"></i>
                    @php $tname = $news->tab == '6' ? 'My store' : 'My gigs and tickets' @endphp
                    @elseif($news->tab == '2')
                    <i class="fa fa-music"></i>
                    @php $tname = 'My music' @endphp
                    @elseif($news->tab == '1')
                    <i class="fa fa-user"></i>
                    @php $tname = 'My bio' @endphp
                    @elseif($news->tab == '3')
                    <i class="fa fa-hand-holding-heart"></i>
                    @php $tname = 'My fans' @endphp
                    @elseif($news->tab == '4')
                    <i class="fa fa-share-alt"></i>
                    @php $tname = 'My social family' @endphp
                    @elseif($news->tab == '5')
                    <i class="fa fa-play"></i>
                    @php $tname = 'My videos' @endphp
                    @endif
                     {{$tname}}</span>
                </div>
                @endif
            </div>
            @endforeach
            @if(count($userNews) > 1)
            <div class="news_updates_nav">
                <div id="news_nav_back" class="news_updated_nav_each">
                    <i class="fa fa-angle-left"></i>
                </div>
                <div id="news_nav_next" class="news_updated_nav_each">
                    <i class="fa fa-angle-right"></i>
                </div>
            </div>
            @endif
        </div>
        @endif
        @if(count($userFeatMusics) > 0 || count($userFeatProducts) > 0)
        <div class="panel colio_outer colio_dark">
            <div class="user_hm_rt_btm_otr feat_outer">
                <?php $count = 0; ?>
                @foreach($userFeatMusics as $userFeatMusic)
                    @include('parts.feat_music_template', ["userFeatMusic" => $userFeatMusic, "count" => ++$count] )
                @endforeach
                @foreach($userFeatAlbums as $userFeatAlbum)
                    @include('parts.feat_album_template', ["userFeatAlbum" => $userFeatAlbum, "count" => ++$count] )
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
                @endif
                <input type="hidden" id="feat_current_slide" value="1">
                <input type="hidden" id="feat_total_slides" value="{{ $count }}">
            </div>
        </div>
        @endif
        @if($user->accept_donations == 1)
        <div class="panel colio_outer colio_dark">
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
                    <div class="colio_header">Make A Contribution</div>
                    <p>Contributions are not associated with perks</p>
                    <div class="donator_inner">
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
        </div>
        @endif
        @if($user->subscription_amount != null && $user->subscription_amount > 0)
        @if($basket && $basket->contains('purchase_type', 'subscription') && $basket->contains('user_id', $user->id))
            @php $isSubscribed = 1 @endphp
        @endif
        <!--<div class="panel user_subscribe_outer colio_outer colio_dark">
            @php $encourageBullets = $user->encourage_bullets; @endphp
            <div class="project_rit_btm_bns_otr">
                <div class="{{ isset($isSubscribed) && $isSubscribed == 1 ? 'proj_rit_btm_list_gray' : 'project_rit_btm_list' }}" id="subscribe_box">
                    <div class="colio_header">Subscribe to {{str_limit($user->name, 10, '...')}}</div>
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
                    <label class="proj_add_sec {{ isset($isSubscribed) && $isSubscribed == 1 ? 'proj_add_sec_added' : '' }}" id="subscribe_btn" data-basketuserid="{{ $user->id }}" data-basketprice="{{ $user->subscription_amount }}" style="cursor: pointer;">
                        {{ isset($isSubscribed) && $isSubscribed == 1 ? 'Added To Cart' : 'Subscribe' }}
                        <b>
                            {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}
                            {{number_format($user->subscription_amount, 2) }} p/m
                        </b>
                    </label>
                </div>
            </div>
        </div>!-->
        @endif
        <div class="panel user_short_hand_tab_outer colio_outer colio_dark">
            <div class="colio_header">Quick Links</div>
            <div class="user_short_hand_tab">
                <div data-target-id="1" class="user_short_tab_each bi_tb true_active">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">BIO</div>
                </div>
                <div data-target-id="2" class="user_short_tab_each mu_tb {{count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''}}">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">MUSIC</div>
                </div>
                <div data-target-id="3" class="user_short_tab_each fa_tb {{count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''}}">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">FANS</div>
                </div>
                <div data-target-id="6" class="user_short_tab_each st_tb {{count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'disabled' : ''}}">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">STORE</div>
                </div>
                <div data-target-id="4" class="user_short_tab_each so_tb {{count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''}}">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">SOCIAL</div>
                </div>
                <div data-target-id="5" class="user_short_tab_each vi_tb {{count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''}}">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">VIDEOS</div>
                </div>
            </div>
        </div>
        @if($userCampaignDetails['isLive'])
        <div id="user_project_outer" data-link="{{route('user.project', ['username' => $user->username])}}" class="panel card_pro_click user_hm_rt_btm_otr colio_outer colio_dark">
            <div class="ch_bag_pric_sec bio_sec">
                <div class="fund_raise_left">
                    <img alt="{{$user->name.'\'s crowdfund project'}}" class="bio_sec_percent_image a_percent hide_on_mobile" src="{{$userCampaignDetails['campaignPercentImage']}}" alt="#" />
                    <div class="colio_header">My Crowdfunder</div>
                    <div class="fund_raise_status"></div>
                </div>
                <div class="fund_raise_right">
                    <div class="pricing_setail">
                        <ul>
                            <li class="fleft">
                                <div class="tier_one_text_one header3">
                                    {{$userCampaignDetails['campaignDonators']}}
                                </div>
                            </li>
                            <li class="fright">
                                <div class="tier_four_text_one project_txt header3">
                                    {{ucfirst($userCampaignDetails['campaignStatus'])}}
                                </div>
                            </li>
                            <li class="fleft">
                                <p class="tier_one_text_two">Fans supported this</p>
                            </li>
                            <li class="fright">
                                <p class="tier_four_text_two">Status</p>
                            </li>
                            <li class="fleft">
                                <div class="tier_two_text_one header3">
                                    {{$userCampaignDetails['campaignCurrencySymbol'].$userCampaignDetails['amountRaised']}}
                                </div>
                            </li>
                            <li class="fright">
                                <div class="tier_three_text_one header3">
                                    {{$userCampaignDetails['campaignDaysLeft']}}
                                </div>
                            </li>
                            <li class="fleft">
                                <p class="tier_two_text_two">
                                    Raised of <text class="target_value">{{$userCampaignDetails['campaignGoal']}}</text> target
                                </p>
                            </li>
                            <li class="fright">
                                <p class="tier_three_text_two">Days left</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@stop

@section('bottom-row-full-width')
@stop

@section('slide')
@stop

@section('miscellaneous-html')
    <div id="body-overlay"></div>
    @include('parts.chart-popups')
    <input id="has_free_sub" type="hidden" value="{{$user->hasActiveFreeSubscription() ? '1' : '0'}}" />
    <input type="hidden" id="stripe_publishable_key" value="{{config('constants.stripe_key_public')}}">
    <div class="tab_btns_alt_outer tab_dsk hide_on_desktop">
        <div class="each_tab_alt_btn tab_alt_btn_user_bio {{$user->default_tab_home == NULL || $user->default_tab_home == 1 ? 'true_active' : ''}}" data-target-id="1">
            <div class="border"></div>
        </div>
        <div class="each_tab_alt_btn tab_alt_btn_music {{count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 2 ? 'true_active' : ''}}" data-target-id="2">
            <div class="border"></div>
        </div>
        <div class="each_tab_alt_btn tab_alt_btn_fans {{count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 3 ? 'true_active' : ''}}" data-target-id="3">
            <div class="border"></div>
        </div>
        <div class="each_tab_alt_btn tab_alt_btn_social {{count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 4 ? 'true_active' : ''}}" data-target-id="4">
            <div class="border"></div>
        </div>
        @if($userCampaignDetails['campaignIsLive'] == '1' && $userCampaignDetails['campaignStatus'] == 'active')
        @php $hasCrowdfunder = 1 @endphp
        @else
        @php $hasCrowdfunder = 0 @endphp
        @endif
        <div class="each_tab_alt_btn tab_alt_btn_crowd_fund store {{count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 6 ? 'true_active' : ''}}" data-target-id="6">
            <div class="border_alter">
                Store<br>{{$userCampaignDetails['campaignProducts']}}
            </div>
            <div class="border"></div>
        </div>
        <div class="each_tab_alt_btn tab_alt_btn_video {{count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''}} {{$user->default_tab_home == 5 ? 'true_active' : ''}}" data-target-id="5" data-video-id="{{$userPersonalDetails['bioVideoId']}}">
            <div class="border"></div>
        </div>
        @if(!$user->isCotyso())
        <div class="each_tab_alt_btn tab_alt_btn_tv" data-target-id="">
            <div class="border"></div>
        </div>
        @endif
    </div>
@stop

@section('footer')

    @if($user->isCotyso())
        @include('parts.singing-footer')
    @endif

@stop

