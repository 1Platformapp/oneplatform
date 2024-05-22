@extends('templates.advanced-template')



@section('pagetitle') {{$user->name}} - Project  @endsection


@section('page-level-css')

    <link rel="stylesheet" href="{{asset('css/project.css?v=2.2')}}"></link>
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}"></link>

    @if($user->home_layout == 'background')
        <link rel="stylesheet" href="{{asset('css/user_home_background.min.css')}}"></link>
    @endif

@stop


@section('page-level-js')

    <script defer src="/js/video-player.js" type="application/javascript"></script>
    <script defer src="/js/feat_items_scroller.js"></script>
    <script defer src="{{asset('js/jquery-ui.min.js')}}" type="application/javascript"></script>


    <!-- Youtube subscribe -->

    <script defer src="https://apis.google.com/js/platform.js"></script>

    <!-- Youtube subscribe -->

    <script defer src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyClmbXrPVdKDFBIEzIcX4ZvblS9tZwA6fE'></script>

    <script type="text/javascript">

        window.ajaxResponse = null;

        window.currentUserId = {{$user->id}};

        window.autoShare = '';

    </script>


    @if($user->home_layout == 'background')
        <script src="{{ asset('js/user_home_background.min.js') }}"></script>
    @endif

    <script src="{{ asset('select2/select2.min.js') }}"></script>

    <script type="application/javascript">

        $('.hdr_shop_cart_otr').addClass('instant_hide');

        $('#read_more_less_btns').hide();

        $('.read_less_actual').hide();

        // Project page validate function ..

        var actualSubTotal = 0;
        var actualBonusTotal = 0;


        $(document).ready(function() {

            $('select[name="country"]').select2();

            $('#not_logged_in').remove();

            var browserWidth = $( window ).width();

            if( browserWidth <= 767 ){
                $('.ch_left_sec_outer').appendTo('#ch_left_sec_outer_filler');
                $('.tab_btns_outer.mobile-only,.tab_det_left_sec.tab_det_dsk').appendTo('.ch_left_sec_outer');
                $('.user_bonuses_outer').appendTo('#user_bonuses_filler');
                $('.donator_outer').parent().appendTo('#donator_outer_filler');
                $('#monies_form').appendTo('#project_checkout_filler');
            }
        });



        var mobileBonusPaginate = 2;

        if($(".mobile-only .project_rit_btm_list").length > mobileBonusPaginate){

            $(".mobile-only .show_more_bonuses_btn").show();
        }else{

            $(".mobile-only .show_more_bonuses_btn").hide();
        }

        $(".mobile-only .project_rit_btm_list").hide().slice(0, mobileBonusPaginate).show();

        $(".show_more_bonuses_btn input").on('click', function (e) {

            e.preventDefault();
            $(".mobile-only .project_rit_btm_list:hidden").slice(0, 1).slideDown( "slow", function() {

                $('html,body').animate({
                    scrollTop: $(".mobile-only .project_rit_btm_list").last().offset().top - 100
                }, 200);
            });
            if ($(".mobile-only .project_rit_btm_list:hidden").length == 0) {
                $(".show_more_bonuses_btn input").fadeOut('slow');
            }
        });

    </script>

@stop



@section('preheader')

    @if($user->home_layout == 'banner' && $user->custom_banner != '')
        <div style="background: none; width: 100%;" class="pre_header_banner">
            <img style="width: 100%;" src="{{asset('user-media/banner/'.$user->custom_banner)}}">
        </div>
    @endif

@stop


@section('page-background')

    @if($user->home_layout == 'background')
        <div data-url="/user-media/background/{{$user->custom_background}}" class="pg_back back_inactive"></div>
    @endif

@stop


@section('header')

    @include('parts.header')

@stop


@section('flash-message-container')


    @if (Session::has('error'))

        <div class="error_span">{!! Session::get('error')[0]  !!}</div>

    @endif

    @if (Session::has('success'))

        <div class="success_span">{{ Session::get('success')[0] }}</div>

    @endif

@stop

@section('social-media-html')

    <div id="fb-root"></div>

    <input type="hidden" id="share_current_page" value="project">

    @php
        $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
        $url = 'project_'.$user->id;
        $userImageName = $user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $user->profile->profile_display_image_original;
        $shareVideoURL = route('vid.share', ['videoId' => '0cSXq4TYIIk', 'userName' => $user->name, 'url' => $url]);
        $shareURL = route('url.share', ['userName' => $user->name, 'imageName' => base64_encode($userImageName), 'url' => $url]);
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

        <div class="top_info_box hide_on_mobile">
            <div class="page_title">My Crowd Funder </div>
            <div onclick="return false;" class="top_info_right_icon">
                <i class="fa fa-share"></i>
            </div>
        </div>

        <div class="tp_center_video_outer">

            <div class="jplayer_video_outer">

                <div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player" >

                    <div class="jp-type-single">

                        <div class="jp-gui">

                            <iframe class="{{$user->home_layout == 'background' ? 'instant_hide' : ''}}" id="soundcloudPlayer" width="100%" height="319" scrolling="no" frameborder="no" src="">
                            </iframe>

                            <video width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader {{$user->home_layout == 'background' && $defaultVideoId == '' ? 'instant_hide' : ''}}" preload="none">

                                <source type="video/youtube" src="https://www.youtube.com/watch?v={{ $defaultVideoId }}" />

                            </video>
                            @php $videoUrl = $userCampaignDetails['campaignProjectVideoId'] @endphp
                            @php $projectVideoId = ($videoUrl != '') ? $commonMethods->getYoutubeIdFromUrl($videoUrl) : '' @endphp


                            <div class="clearfix tab_btns_outer tab_dsk hide_on_mobile">

                                <div class="each_tab_btn tab_btn_user_bio fly_user_home disabled" data-show="" data-initials="">
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
                                <div class="each_tab_btn tab_btn_crowd_fund true_active" data-show="#tabd1">
                                    <div class="border_alter">
                                        Target<br>
                                        {{$userCampaignDetails['campaignGoal'] }}
                                    </div>
                                    <div class="border"></div>
                                </div>
                                <div class="each_tab_btn tab_btn_video disabled" data-video-id="{{$projectVideoId}}" data-show="#tabd5">
                                    <div class="border"></div>
                                </div>
                                <div class="each_tab_btn tab_btn_tv" data-show="">
                                    <div class="border"></div>
                                </div>

                            </div>

                            <div class="clearfix tab_btns_outer mobile-only ch_tab_sec_outer project_tabs_mobile">

                                <div class="each_tab_btn tab_btn_user_bio fly_user_home disabled" data-show="" data-initials="{{$user->username}}">
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
                                <div class="each_tab_btn tab_btn_crowd_fund true_active" data-show="#tabd1">
                                    <div class="border_alter">
                                        Target<br>
                                        {{$userCampaignDetails['campaignGoal'] }}
                                    </div>
                                </div>
                                <div class="each_tab_btn tab_btn_video disabled" data-show="#tabd5" data-video-id="{{$userPersonalDetails['bioVideoId']}}" data-show="">
                                    <div class="border"></div>
                                </div>
                                <div class="each_tab_btn tab_btn_tv" data-show="">
                                    <div class="border"></div>
                                </div>

                            </div>



                            <div class="tab_det_left_sec tab_det_dsk">

                                <div style="display: none;" class="lazy_tab_img">
                                    <img class="defer_loading" style="margin: 0 auto;" src="" data-src="{{asset('img/lazy_loading.gif')}}">
                                </div>

                                <div id="tabd1" class="ch_tab_det_sec bio_sec" style="display:block;">

                                    <div id="new_story_text_section" style="color:#696772;font-size:18px;line-height:23px;font-family: Open Sans, sans-serif;">


                                        <iframe onload="setIframeHeight(this.id)" scrolling="no" id="full-screen-me" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%" frameborder="0" wmode="transparent" src="{{ route('user.story.text', ['id' => $userCampaign->id]) }}"></iframe>
                                        <script type="text/javascript">
                                            function getDocHeight(doc) {
                                                doc = doc || document;
                                                var body = doc.body, html = doc.documentElement;
                                                var height = Math.max( body.scrollHeight, body.offsetHeight,
                                                    html.clientHeight, html.scrollHeight, html.offsetHeight );
                                                return height;
                                            }
                                            function setIframeHeight(id) {
                                                var ifrm = document.getElementById(id);
                                                var doc = ifrm.contentDocument? ifrm.contentDocument: ifrm.contentWindow.document;
                                                ifrm.style.visibility = 'hidden';
                                                ifrm.style.height = "10px"; // reset to minimal height ...
                                                // IE opt. for bing/msn needs a bit added or scrollbar appears
                                                ifrm.style.height = getDocHeight( doc ) + 4 + "px";
                                                ifrm.style.visibility = 'visible';
                                            }
                                        </script>


                                        <div id="read_more_less_btns" style="display: none;">

                                            <div class="clearfix story_read_more_btn read_more_actual">

                                                <input type="button" value="Read More" />

                                            </div>

                                            <div class="clearfix story_read_more_btn read_less_actual">

                                                <input type="button" value="Read Less" />

                                            </div>

                                        </div>

                                    </div>
                                    <form id="monies_form" action="{{ route('user.contribute', ['campaignId'=>$userCampaign->id]) }}" method="post" style="padding-top: 20px;">

                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">

                                        <div class="proj_cntr_contribut_sec_otr">

                                            <div class="proj_top_head_outer">
                                                <div class="proj_top_head_each">
                                                    <h3 class="proj_top_head_text">
                                                        You're contributing to {{ $user->name }}
                                                    </h3>
                                                </div>
                                                <div id="proj_fb_share_url" class="proj_top_head_each" onclick="return false;">
                                                    <img src="/images/rszz_player_bot_fb.png">
                                                </div>
                                                <div id="proj_twit_share_url" class="proj_top_head_each" onclick="return false;">
                                                    <img src="/images/rszz_player_bot_twit.png">
                                                </div>
                                            </div>

                                            <ul>

                                                @if(!Auth::user())

                                                    <input type="hidden" name="is_create_new_user" id="is_create_new_user" value="1">

                                                    <li class="proj_create_new_account_outer">

                                                        <div class="clearfix proj_create_new_account_inner">
                                                            <div class="proj_cont_left_inp_outer">

                                                                <b>To purchase create an account</b>

                                                            </div>

                                                            <!--<div class="proj_cont_right_inp_outer">

                                                                <b>
                                                                    <a href="{{ asset('login/checkout_facebook?userId=' . $user->id) }}"><i class="fab fa-facebook-f"></i> Create an account with facebook</a>
                                                                </b>
                                                                <div class="hide_on_desktop" id="account_or_facebook">OR</div>

                                                            </div>!-->
                                                        </div>
                                                        <input class="dummy_field" type="text" name="email_9">
                                                        <input class="dummy_field" type="password" name="password_0">
                                                        <div class="clearfix proj_cont_flt_outer">

                                                            <div class="clearfix proj_email_outer" id="email_password_section">

                                                                <div class="proj_cont_left_inp_outer">

                                                                    <b>Your Email *</b>

                                                                    <input type="text" placeholder="Your Email" name="email" id="email" class="evade_auto_fill" />


                                                                    <span id="email_error" class="instant_hide"></span>

                                                                </div>

                                                                <div class="proj_cont_right_inp_outer">

                                                                    <b>
                                                                        Confirm Your Email *
                                                                    </b>

                                                                    <input type="text" placeholder="Confirm Email" name="emailConfirmation" id="email_confirmation" class="evade_auto_fill" />

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="clearfix proj_cont_flt_outer proj_email_outer">
                                                            <div class="proj_cont_left_inp_outer">

                                                                <b>Password *</b>

                                                                <input type="Password" placeholder="Password" name="password" id="password" class="evade_auto_fill" />

                                                                <span id="password_error" class="instant_hide"></span>

                                                            </div>
                                                        </div>

                                                    </li>

                                                @else

                                                    <input type="hidden" name="is_create_new_user" id="is_create_new_user" value="0">

                                                @endif

                                                <li class="proj_first_surname_outer add_margin">



                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <div class="proj_cont_left_inp_outer">

                                                            <b>First Name *</b>

                                                            <input type="text" placeholder="First Name" name="name" id="name" value="{{$loggedUserDet?$loggedUserDet['first_name']:''}}" />

                                                        </div>

                                                        <div class="proj_cont_right_inp_outer">

                                                            <b>Surname *</b>
                                                            <input type="text" placeholder="Surname" value="{{$loggedUserDet?$loggedUserDet['surname']:''}}" name="surname" id="surname" />

                                                        </div>

                                                    </div>

                                                    <label id="hide_show_details_check" class="proj_checkbox proj_checkbox_unchecked"> <input value="1" type="checkbox" name="make_me_private" id="make_me_private" /> Hide name/comment from everyone except organiser</label>

                                                </li>

                                                <li class="proj_address_outer add_margin">

                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <div class="proj_cont_left_inp_outer">

                                                            <b>Please Enter Your Shipping Address *</b>

                                                            <input type="text" placeholder="Street Address" name="street" id="address" value="{{$loggedUserDet?$loggedUserDet['address']:''}}" />

                                                        </div>

                                                        <div id="country_drop_case" class="proj_cont_right_inp_outer">

                                                            <b>Choose your country *</b>

                                                            <input type="hidden" name="user_country" id="user_country" value="{{ $userPersonalDetails['countryId'] }}">


                                                            <select id="country" name="country">
                                                                <option value="">Choose your country</option>
                                                                @foreach($countries as $country)

                                                                    <option {{$loggedUserDet&&$loggedUserDet['countryId']==$country->id?'selected':''}} value="{{ $country->id }}">{{ $country->name }}</option>

                                                                @endforeach

                                                            </select>

                                                        </div>

                                                    </div>

                                                </li>

                                                <li class="proj_address_two_outer add_margin">

                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <div class="proj_cont_left_inp_outer">

                                                            <input value="{{$loggedUserDet?$loggedUserDet['city']:''}}" type="text" placeholder="City *" name="city" id="city" />
                                                            <p id="city_error" class="instant_hide"></p>
                                                        </div>

                                                        <div class="proj_cont_right_inp_outer">

                                                            <input value="{{$loggedUserDet?$loggedUserDet['postcode']:''}}" type="text" placeholder="Postcode *" name="zip" id="zip" />

                                                        </div>

                                                    </div>

                                                </li>

                                                <li>

                                                    <b>Credit Card Details *</b>

                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <div class="proj_cont_left_inp_outer">

                                                            <input type="text" placeholder="Name On Card" name="card_holder_name" id="card_holder_name"  />

                                                        </div>

                                                        <div class="proj_cont_right_inp_outer">

                                                            <input type="text" placeholder="Card Number" name="number" id="number" />

                                                        </div>

                                                    </div>

                                                </li>

                                                <li class="proj_credit_card_outer">

                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <div class="proj_cont_left_inp_outer">

                                                            <b class="cvc_guid_txt">Enter the 3 (4 Digits for AmEx) on the back of your card *</b>

                                                            <input type="text" placeholder="Security Code" id="cvc" name="cvc" />

                                                        </div>

                                                        <div class="proj_cont_right_inp_outer">

                                                            <b>Expiration Date *</b>

                                                            <div class="proj_cont_right_inner">

                                                                <div class="select_outer">

                                                                    <?php $mon = 1;

                                                                        if($mon<10){

                                                                            $mon = "0" . $mon;
                                                                        }
                                                                    ?>

                                                                    <span>{{ $mon }}</span>

                                                                    <select id="exp_month" name="exp_month">

                                                                        <?php for($i = 1; $i<=12; $i++){

                                                                            $val = $i;

                                                                            if($i<10){

                                                                                $val = "0" . $i;

                                                                            }

                                                                        ?>

                                                                        <option value="{{ $val }}">{{ $val }}</option>

                                                                        <?php }?>

                                                                    </select>

                                                                </div>

                                                                <div class="select_outer">

                                                                    <span>{{ date('Y') }}</span>

                                                                    <select id="exp_year" name="exp_year">

                                                                        <?php for($i=date('Y'); $i<=date('Y') + 10; $i++) {?>

                                                                        <option value="{{ $i }}">{{ $i }}</option>

                                                                        <?php }?>

                                                                    </select>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </li>

                                                <li class="proj_photo_textarea_outer">

                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <div class="proj_cont_left_img_textarea">

                                                            <textarea placeholder="Leave A Comment" id="comment" name="comment"></textarea>

                                                        </div>

                                                    </div>

                                                    <b class="faq_check_stat">If you have any questions about the projects you can check out our <a href="{{ asset("faq") }}">FAQ</a>.</b>

                                                </li>

                                                <li class="proj_total_amount_outer">

                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <div class="proj_cont_left_inp_outer tot_ship_left ">

                                                            <h4>TOTAL</h4>

                                                        </div>

                                                        <div class="proj_cont_right_inp_outer tot_usd_shiping">

                                                            <div class="clearfix proj_cont_right_inner">

                                                                <select class="tot_usd_sec" id="selectedCurrency" name="selectedCurrency">

                                                                    <option {{$crowdfundCart['currency']=='USD'?'selected':''}} value="USD">USD</option>

                                                                    <option {{$crowdfundCart['currency']=='EUR'?'selected':''}} value="EUR">EUR</option>

                                                                    <option {{$crowdfundCart['currency']=='GBP'?'selected':''}} value="GBP">GBP</option>

                                                                </select>

                                                                <input value="{{$crowdfundCart['subtotal']}}" class="tot_usd_val" type="text" placeholder="0.00" style="background: none !important;" name="totalCost" id="total_cost" readonly/>

                                                            </div>

                                                            <!--<b>Your shipping cost is <a href="#" id="shipping_cost_area">£0.00</a></b>!-->

                                                        </div>

                                                    </div>

                                                </li>

                                                <li class="clearfix proj_cont_flt_outer proj_bottom_description">
                                                    <p>
                                                        If you are not paying in your native currency there may be fees for conversion. The actual amount charged by your card issuer may differ from our estimate shown here. This depends on their exchange rate and any applicable fees.
                                                    </p>
                                                </li>

                                                <li class="clearfix proj_cont_flt_outer proj_bottom_description">
                                                    <p>
                                                        I agree to 1Platform's <a target="_blank" href="{{route('tc')}}">terms and conditions</a>
                                                        <span class="terms_agree_outer">
                                                            <input type="checkbox" class="terms_agree" name="terms_agree" id="checkout_terms_agree">
                                                        </span>
                                                    </p>
                                                </li>

                                                <li class="proj_confirm_payment_btn_outer">

                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <input onclick="return false;" type="button" value="Confirm Payment">
                                                    </div>

                                                </li>

                                                <li class="proj_bottom_description">

                                                    <div class="clearfix proj_cont_flt_outer">

                                                        <p>

                                                        To get funds for your project, connect to Stripe. Your funds come 15 days after reaching your goal (for flexible projects). Refunds are managed through Stripe. 1Platform TV takes a 5% fee from each donation. Payment Processing fees are 1.4% + £0.20 + VAT for EEA cards, and 2.9% + £0.20 + VAT for non-EEA cards. By proceeding, you accept 1Platform TV’s terms and privacy policy.

                                                        </p>

                                                    </div>

                                                </li>

                                            </ul>

                                        </div>

                                        <input type="hidden" name="addedBonuses" id="added_bonuses" value="">

                                        <input type="hidden" name="addedDonation" id="added_donation" value="0">

                                        <input type="hidden" value="{{strtoupper($user->profile->default_currency)}}" id="temp_selected_currency">
                                        <input type="hidden" value="{{strtoupper($user->profile->default_currency)}}" id="original_currency">

                                    </form>

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

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="filler" id="ch_left_sec_outer_filler"></div>
        <div class="filler" id="donator_outer_filler"></div>
        <div class="filler" id="user_bonuses_filler"></div>
        <div class="filler" id="project_checkout_filler"></div>

    </div>

@stop


@section('top-right')

@stop


@section('top-left')

    <div class="ch_tab_sec_outer proj_sum_bonuses">

        <div class="panel main_panel colio_outer colio_dark">

            @if($user->home_layout != 'background')
            <div class="desktop-only panel_head">

                <h2 class="project_name">{{$userCampaignDetails['projectTitle']}}</h2>

            </div>
            @endif

            <div class="ch_bag_pric_sec bio_sec">

                <div class="fund_raise_left">

                    <img class="bio_sec_percent_image a_percent" src="{{$userCampaignDetails['campaignPercentImage']}}" alt="#" />
                    <div class="colio_header">My Crowdfunder</div>
                    <div class="fund_raise_status"></div>
                </div>

                <div class="fund_raise_right">

                    <div class="pricing_setail">

                        <ul>

                            <li class="fleft">

                                <h3 class="tier_one_text_one">
                                    {{$userCampaignDetails['campaignDonators']}}
                                </h3>

                            </li>

                            <li class="fright">

                                <h3 class="tier_four_text_one project_txt">
                                    {{ucfirst($userCampaignDetails['campaignStatus'])}}
                                </h3>

                            </li>

                            <li class="fleft">

                                <p class="tier_one_text_two">Fans supported this</p>

                            </li>

                            <li class="fright">

                                <p class="tier_four_text_two">Project status</p>

                            </li>

                            <li class="fleft">

                                <h3 class="tier_two_text_one">
                                    {{$userCampaignDetails['campaignCurrencySymbol'].$userCampaignDetails['amountRaised']}}
                                </h3>

                            </li>

                            <li class="fright">

                                <h3 class="tier_three_text_one">
                                    {{$userCampaignDetails['campaignDaysLeft']}}
                                </h3>

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

            <div class="clearfix social_btns desktop-only">

                <ul class="clearfix">

                    <li>
                        <a id="facebook_share_url" onclick="return false;" class="ch_sup_fb" href="javascript:void(0)">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a id="twitter_share_url" onclick="return false;" class="ch_sup_tw" href="javascript:void(0)">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a class="ch_sup_feature_tab full_support_me" href="javascript:void(0)">
                            <i class="fas fa-music"></i>
                        </a>
                    </li>
                </ul>

            </div>

        </div>

        @if($userCampaign->amount > 0 && ($userCampaignDetails['campaignUnsuccessful'] == false||$userCampaign->is_charity == 1))

        @if($crowdfundCart['donation'])
        @php $donationAdded = 1; @endphp
        @else
        @php $donationAdded = 0; @endphp
        @endif
        <div class="panel colio_outer colio_dark">
            <div class="donator_outer donation_goal {{$donationAdded?'donation_agree':''}}">
                <div class="clearfix donator_box">
                    <div class="colio_header">Donate to support {{$user->firstName()}}</div>
                    <p>Your donations help to meet my target goal</p>
                    <div class="donator_inner">
                        <div class="donation_left">
                            <span id="donation_currency">{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}</span>
                            <input type="text" id="donation_amount" name="donation_amount" class="{{$donationAdded?'':'evade_auto_fill'}}" value="{{$donationAdded?$crowdfundCart['donation']:''}}" />
                            <input class="dummy_field" type="text" name="fakeusernameremembered">
                        </div>
                        <div class="donation_right">
                            <div onclick="return false;" class="donation_right_in">
                                {{$donationAdded?'Remove Donation':'Add Donation'}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif

        @foreach($userCampaign->perks as $perk)

        <div class="panel each_fro_bonus colio_outer colio_dark">
            <div class="colio_header">Bonus</div>
            <div class="project_rit_btm_bns_otr">

                <?php $perkThumb = ""; ?>

                    @if($perk->thumbnail != "")

                        <?php $perkThumb = asset("user-bonus-thumbnails/" . $perk->thumbnail)?>

                    @endif

                    @if(($perk->items_available > $perk->items_claimed && $perk->status == "available" && $userCampaignDetails['campaignUnsuccessful'] == false && $userCampaign->amount > 0) || ($userCampaign->is_charity == 1 && $perk->items_available > $perk->items_claimed && $userCampaign->amount > 0) || ($perk->items_available == null && $userCampaignDetails['campaignUnsuccessful'] == false ) )

                        @if(in_array($perk->id, $crowdfundCart['bonuses']))
                        @php $bonusAdded = 1; @endphp
                        @else
                        @php $bonusAdded = 0; @endphp
                        @endif
                        <div class="{{$bonusAdded?'proj_rit_btm_list_gray':'project_rit_btm_list'}}" id="perk_list_{{ $perk->id }}">

                            @if($perkThumb != "")
                                <span class="project_rit_img">
                                    <img class="defer_loading" src="" data-src="{{ $perkThumb }}" alt="#" />
                                </span>
                            @endif

                            <h4>{{ $perk->title }}</h4>

                            <p>{{ $perk->description }}</p>

                            @if($perk->items_included != "")

                                <ul>

                                    <li><p>Items Included</p></li>

                                    <?php $includedArray = explode(",", $perk->items_included); ?>

                                    @foreach($includedArray as $included)

                                        <li><p>{{ trim($included) }}</p></li>

                                    @endforeach

                                </ul>

                            @endif

                            <strong>{{ $perk->items_claimed }} out of {{ $perk->items_available }} sold</strong>

                            <label class="add_bonus_btn {{$bonusAdded?'proj_add_sec_added':'proj_add_sec'}}" data-perkid="{{ $perk->id }}">
                                <text class="buy_remove_txt">{{$bonusAdded?'Remove Bonus':'Buy Bonus'}}</text>
                                <b>{{$commonMethods::getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ $perk->amount }}</b>
                            </label>

                        </div>

                    @elseif($userCampaign->amount > 0)

                        <hr>

                        <div class="proj_rit_btm_list_gray">

                            @if($perkThumb != "")
                                <span class="project_rit_img">
                                    <img class="defer_loading" src="" data-src="{{ $perkThumb }}" alt="#" />
                                </span>
                            @endif

                            <h4 style="background-image: none;">{{ $perk->title }}</h4>

                            <p>{{ $perk->description }}</p>

                            @if($perk->items_included != "")

                                <ul>

                                    <li><p>Items Included</p></li>

                                    <?php $includedArray = explode(",", $perk->items_included); ?>

                                    @foreach($includedArray as $included)

                                        <li><p>{{ trim($included) }}</p></li>

                                    @endforeach

                                </ul>

                            @endif

                            <strong>{{ $perk->items_claimed }} out of {{ $perk->items_available }} sold</strong>

                            <label class="proj_add_sec_added perk_sold_out" style="background: #4d4d4d;">Sold Out</label>

                        </div>

                    @endif

            </div>

        </div>

        @endforeach

        <!--<div class="clearfix story_read_more_btn return_to_top"><br>

            <input type="button" value="Return to top of the page">

        </div>!-->

    </div>

    <script>
        var browserWidth = $( window ).width();
        if( browserWidth <= 767 ){
            $('.desktop-only,.hide_on_mobile').remove();
        }else{
            $('.mobile-only,.hide_on_desktop').remove();
        }
        if($('.vid_preloader').length && !$('.vid_preloader').hasClass('instant_hide')){

            $('.content_outer').addClass('playing');
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
