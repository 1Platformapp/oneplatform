<?php

$userPageLink = asset('/').$user->username;
$sharePopupDisplay = '';
$stripePopupDisplay = '';
$videoUploadedDisplay = '';
?>

@if(Session::has('share_project'))
    @if($userCampaign->user->profile->stripe_secret_key == "")
        <?php $stripePopupDisplay = "display: block;";?>
    @else
        <?php $sharePopupDisplay = "display: block;";?>
    @endif
@endif

@if(Session::has('video_uploaded'))
    <?php $videoUploadedDisplay = "display: block;"; ?>
@endif

@if(Session::has('user_has_invalid_email'))
    @php $hasInvalidEmail = 1; @endphp
@endif

@if(Session::has('music_license_notice'))
    @php Session::remove('music_license_notice') @endphp
    @php $hasMusicLicenseNotice = 1; @endphp
@endif

@if(isset($hasInvalidEmail) && $hasInvalidEmail == 1)
<div class="clearfix in_progress pro_page_pop_up" style="z-index: 10; display: block;" id="pro_fill_email">
    <div class="clearfix pro_soc_con_face_inner">
        <div class="clearfix soc_con_top_logo">
            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
        </div><br>
        <div class="clearfix soc_con_twit_username">
            <div class="main_headline">Enter Your Email Address</div><br>
            <div class="">
                <input autocomplete="off" placeholder="Email address" type="text" value="" id="pro_fill_email_address" />
                <input class="dummy_field" type="text" name="fakeusernameremembered">
            </div>
            <div class="error instant_hide" id="pro_fill_email_error"></div>
            @if(!$user->password)
            <div class="">
                <input class="dummy_field" type="password" name="fakeusernameremembered">
                <input autocomplete="off" placeholder="Password" type="password" value="" id="pro_fill_password" />
            </div>
            <div class="error instant_hide" id="pro_fill_password_error"></div>
            @endif
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">
            <a href="javascript:void(0)" id="pro_fill_email_submit">Submit</a>
        </div>
    </div>
</div>
@endif

@if(isset($hasMusicLicenseNotice) && $hasMusicLicenseNotice == 1)
<div class="clearfix pro_page_pop_up" style="z-index: 10; display: block;">
    <div class="clearfix pro_soc_con_face_inner">
        <div class="clearfix soc_con_top_logo">
            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
        </div><br>
        <div class="clearfix soc_con_twit_username">
            <div class="main_headline">Important Notice</div>
            <div class="soc_con_face_username">You have selected to sell licences for your music. All accounts must be verified by our team before selling licences.<br><br>Our team will contact you very soon, once verified the license will appear on your website.</div><br>
        </div>
    </div>
</div>
@endif

<!-- Connect Facebook Account  !-->
<div class="clearfix pro_soc_con_face_outer pro_page_pop_up">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <br>
        <div class="clearfix soc_con_face_username">

            <h3>Facebook Page ID</h3><br>
            <p>Looking for your page ID? Go to the Facebook page that you want to add to the site&gt;click About&gt;Scroll down to the bottom of the page and copy your Facebook page ID</p><br>
            <input placeholder="Example: TaylorSwift" type="text" id="soc_con_face_username_val" value="" />
            <span class="error"></span>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a href="#" id="pro_soc_con_facebook_submit">Connect</a>
        </div>
    </div>
</div>
<!-- Connect Facebook Account  !-->


<div class="clearfix pro_page_pop_up" id="bespoke_license_popup" data-music-id="">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">
            <a style="opacity:0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="stage_one">
            <div class="clearfix soc_con_face_username">
                @guest
                <div class="main_headline">Login and negotiate now</div><br>
                <div class="login_separator slim">
                    <div class="login_separator_left"></div>
                    <div class="login_separator_center">1 Platform Account</div>
                    <div class="login_separator_right"></div>
                </div>
                <input class="dummy_field" type="text" name="fakeusernameremembered">
                <input class="dummy_field" type="password" name="fakepasswordremembered">
                <input placeholder="Email address" type="text" id="bispoke_login_email" />
                <div class="instant_hide error" id="bispoke_email_error">Required</div>
                <input placeholder="Password" type="password" id="bispoke_login_password" />
                <div class="instant_hide error" id="bispoke_pass_error">Required</div>
                <!--
                <div class="login_separator">
                    <div class="login_separator_left"></div>
                    <div class="login_separator_center">OR LOGIN AS</div>
                    <div class="login_separator_right"></div>
                </div>
                <div class="auth_social_logins_outer">
                    <div class="auth_social_logins_inner">
                        <div class="auth_social_each auth_social_fb">
                            <a href="{{route('socialite.login.with.action', ['type' => 'facebook', 'action' => 'negotiate_'.(isset($user)?$user->id:'')])}}">
                                <i class="fab fa-facebook-f"></i>FA
                            </a>
                        </div>
                        <div class="auth_social_each auth_social_twit">
                            <a href="{{route('socialite.login.with.action', ['type' => 'twitter', 'action' => 'negotiate_'.(isset($user)?$user->id:'')])}}">
                                <i class="fab fa-twitter"></i>TI
                            </a>
                        </div>
                        <div class="hide_on_mobile auth_social_each auth_social_google">
                            <a href="{{route('socialite.login.with.action', ['type' => 'google', 'action' => 'negotiate_'.(isset($user)?$user->id:'')])}}">
                                <i class="fab fa-google"></i>GG
                            </a>
                        </div>
                        <div class="auth_social_each auth_social_insta">
                            <a href="{{route('socialite.login.with.action', ['type' => 'instagram', 'action' => 'negotiate_'.(isset($user)?$user->id:'')])}}">
                                <i class="fab fa-instagram"></i>IS
                            </a>
                        </div>
                    </div>
                </div>
                !-->
                @endguest
                @auth
                <div class="main_headline">Negotiate with the owner</div><br>
                @endauth
                <textarea id="bispoke_offer" placeholder="Write your proposal here (i.e music name, terms of use, price etc)"></textarea>
                <div class="instant_hide error" id="bispoke_offer_error">Required</div>
            </div>
            <br>
            <div id="send_bispoke_license_offer" class="pro_button">SEND PROPOSAL</div>
            <br>
            <div class="pro_pop_dark_note">
                <a class="inline_info" data-title="1 Platform: World's first bespoke licensing" href="https://www.youtube.com/embed/EksAIXYMEow?autoplay=0&origin={{config('constants.primaryDomain')}}&rel=0">How do license proposals work?</a>
            </div>
        </div>
        <div class="stage_two instant_hide">
            <div class="clearfix soc_con_face_username">
                <div class="pro_pop_text_light">
                    Your proposal has been sent to <span class="pro_text_dark" id="sender_name"></span>. Go to <a href="{{route('agency.dashboard')}}" class="pro_text_dark">chat</a> to read replies or send more messages/details about your proposal.
                </div>
            </div>
            <br>
        </div>
    </div>
</div>

<div class="clearfix pro_page_pop_up" id="private_music_unlock_popup" data-type="" data-music-id="" data-mode="0">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">
            <a style="opacity:0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="stage_one">
            <div class="clearfix soc_con_face_username">
                <div class="main_headline">This is a private music</div>
                <div class="second_headline">To unlock it, enter the PIN below</div><br>
                <input class="dummy_field" type="text" name="fakeusernameremembered">
                <input placeholder="Enter PIN" type="text" id="unlock_pin" />
                <div class="instant_hide error" id="unlock_pin_error">Required</div>
            </div>
            <br>
            <div id="unlock_private_music" class="pro_button">UNLOCK</div><br>
            <div class="pro_pop_dark_note">
                <a href="#">How to get PIN?</a>
            </div>
        </div>
    </div>
</div>

<!-- Connect Youtube Account  !-->
<div class="clearfix pro_soc_con_youtube_outer pro_page_pop_up" >

    <div class="clearfix pro_soc_con_youtube_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <br>
        <div class="clearfix soc_con_youtube_username">

            <h3>YouTube Channel ID</h3><br>
            <input placeholder="Example: UCJ4XbT8rbwUQGB0y0dl4n_w" type="text" id="soc_con_youtube_username_val" value="" />
            <span class="error"></span>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a href="#" id="pro_soc_con_youtube_submit">Connect</a>
        </div><br>
        <div class="pro_pop_dark_note">
            <a target="_blank" href="https://support.google.com/youtube/answer/3250431?hl=en">How to find my YouTube channel ID</a>
        </div>
    </div>
</div>
<!-- Connect Youtube Account  !-->

<!-- Connect Twitter Account  !-->
<div class="clearfix pro_soc_con_twit_outer pro_page_pop_up" >

    <div class="clearfix pro_soc_con_twit_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <div class="clearfix soc_con_twit_username">

            <h3>Twitter Account Username</h3><br>
            <input placeholder="Example: taylorswift13" type="text" id="soc_con_twit_username_val" value="" />
            <span class="error"></span>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a href="#" id="pro_soc_con_twit_submit">Connect</a>
        </div>
    </div>
</div>
<!-- Connect Twitter Account  !-->

<div class="clearfix pro_soc_con_spot_outer pro_page_pop_up">

    <div class="clearfix pro_soc_con_twit_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <div class="clearfix soc_con_twit_username">

            <h3>Paste Your Spotify Artist ID</h3><br>
            <input autocomplete="off" placeholder="Example: https://open.spotify.com/artist/123456789" type="text" id="soc_con_spotify_url_val" value="" />
            <span class="error"></span>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a href="javascript:void(0)" id="pro_soc_con_spot_submit">Connect</a>
        </div>
    </div>
</div>

<!-- Connect Twitter Account  !-->
<div class="clearfix pro_soc_discon_outer pro_page_pop_up" >

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <br>
        <div class="clearfix soc_discon_text">

            <h3>Do You Want To Disconnect Your <span>YouTube</span> Account?</h3><br>
            <span class="error"></span>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a data-disconnect-account="" href="#" id="pro_soc_discon_submit_yes">Yes</a>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a href="#" id="pro_soc_discon_submit_no">No</a>
        </div>
    </div>
</div>
<!-- Connect Twitter Account  !-->


<!-- Email Popups -->
<!-- Email popups end -->

<!-- Profile Form Error Pop up -->
<div class="clearfix pro_fill_outer pro_page_pop_up">

    <div class="clearfix pro_fill_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix soc_discon_text">

            <h3>Wait!! You haven't completed all of your profile information</h3><br />
            <span class="error"></span>
        </div>
        <div class="clearfix pro_fill_img">
            <img class="defer_loading" src="" data-src="{{ asset('images/pupfillprofile.png') }}">
        </div>
    </div>
</div>
<!-- Profile Form Error Pop up -->

<!-- Confirm Delete Pop-up  !-->
<div class="clearfix pro_confirm_delete_outer pro_page_pop_up" >

    <div class="clearfix pro_confirm_delete_inner">

        <div class="clearfix soc_con_top_logo">

            <a style="opacity: 0;" class="logo8">
                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}">
                <div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_confirm_delete_text">

            <div class="main_headline">Are You Sure You Want To Delete This Item?</div><br>
            <span class="error"></span>
        </div>
        <div class="clearfix pro_confirm_box_outer pro_submit_button_outer soc_submit_success">

            <div class="delete_yes pro_confirm_box_each" data-delete-id="" data-delete-item-type="" data-album-status="" data-album-music-id="" id="pro_delete_submit_yes">YES</div>
            <div class="delete_no pro_confirm_box_each" id="pro_confirm_delete_submit_no">NO</div>
        </div>
    </div>
</div>
<!-- Confirm Delete Pop-up  !-->

<!-- Add/Edit Bonus Pop-up  !-->

<div class="clearfix pro_add_edit_bonus_outer pro_page_pop_up" >

    <div class="clearfix pro_confirm_delete_inner">

        <div class="clearfix soc_con_top_logo">

            <a style="opacity: 0;" class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="main_headline"><span class="add_edit_text">Add</span> Bonus</div><br>
        <form id="add_edit_bonus_form" action="{{ route('add.edit.bonus') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="clearfix pro_add_bonus_row_outer cant_edit_fields">

            	<label>Bonus Thumbnail (Optional)</label><br>
                <img class="pop_up_bonus_thumb defer_loading" src="" data-src="{{ asset('images/p_music_thum_img.png') }}"><br>
                <div class="pro_input_group">
                	<label>Title *</label><br>
                	<input class="pop_up_bonus_field groupon" placeholder="Bonus Title" type="text" id="pop_up_bonus_title" name="bonus_title" value="" />
                	<div class="error instant_hide" id="pop_up_bonus_title_error">Required</div>
                </div>
                <div class="pro_input_group">
	                <label>Description *</label><br>
	                <textarea class="pop_up_bonus_field groupon" name="bonus_description" id="pop_up_bonus_description"></textarea>
	                <div class="error instant_hide" id="pop_up_bonus_description_error">Required</div>
	            </div>
	            <div class="pro_input_group">
	                <label>Amount Of Bonuses Available (leave blank if unlimited)</label><br>
	                <input class="pop_up_bonus_field groupon" type="text" id="pop_up_bonus_quantity" name="bonus_quantity" value="" />
	                <div class="error instant_hide" id="pop_up_bonus_quantity_error">Required</div>
	            </div>
	            <div class="pro_input_group">
                	<label>Bonus Items * (separate each item by comma i.e item 1,item 2)</label><br>
                	<input class="pop_up_bonus_field groupon" type="text" id="pop_up_bonus_items" name="bonus_items" value="" />
                	<div class="error instant_hide" id="pop_up_bonus_items_error">Required</div>
                </div>
                <div class="pro_input_group">
	                <label>Bonus Price *</label><br>
	                <div class="proj_bonus_curr_crop_outer">
	                    <div class="">
	                        <div class="clearfix proj_cont_right_inner drop_substi_bon_inner">
	                            <div class="drop_substi_curr">{{$user->profile->default_currency}}</div>
	                            <input value="" class="pop_up_bonus_field drop_substi_val groupon" type="text" id="pop_up_bonus_price" name="bonus_price" value="" />
	                        </div>
	                    </div>
	                </div>
	                <div class="error instant_hide" id="pop_up_bonus_price_error">Required</div>
	            </div>
	            <div class="pro_input_group">
	                <label>Worldwide Shipping</label><br>
	                <div class="proj_bonus_curr_crop_outer">
	                    <div class="">
	                        <div class="clearfix proj_cont_right_inner drop_substi_bon_inner">
	                            <div class="drop_substi_curr">{{$user->profile->default_currency}}</div>
	                            <input value="" class="pop_up_bonus_field drop_substi_val groupon" type="text" id="pop_up_bonus_shipping_worldwide" name="bonus_shipping_worldwide" value="" />
	                        </div>
	                    </div>
	                </div>
	                <div class="error instant_hide" id="pop_up_bonus_shipping_worldwide_error">Required</div>
	            </div>
	            <div class="pro_input_group">
	                <label>My Country Shipping</label><br>
	                <div class="proj_bonus_curr_crop_outer">
	                    <div class="">
	                        <div class="clearfix proj_cont_right_inner drop_substi_bon_inner">
	                            <div class="drop_substi_curr">{{$user->profile->default_currency}}</div>
	                            <input value="" class="pop_up_bonus_field drop_substi_val groupon" type="text" id="pop_up_bonus_shipping_my_country" name="bonus_shipping_my_country" value="" />
	                        </div>
	                    </div>
	                </div>
	                <div class="error instant_hide" id="pop_up_bonus_shipping_my_country_error">Required</div>
	            </div>
            </div>
            <div class="clearfix pro_submit_button_outer soc_submit_success">

                <input type="hidden" id="pop_up_bonus_id" name="bonus_id" value="0" />
                <input type="hidden" id="pop_up_campaign_id" name="bonus_campaign_id" value="0" />
                <input accept="image/*" type="file" id="pop_up_bonus_file" name="bonus_thumbnail" style="display: none;" onchange="setBonusThumb(this)" />
                <div id="submit_bonus_form" class="pro_button">SUBMIT</div>
            </div>
        </form>
    </div>
</div>
<!-- Add/Edit Bonus Pop-up  !-->


<div class="clearfix pro_reset_password_secure pro_page_pop_up" id="change_pwd_secure_popup">

    <div class="clearfix pro_soc_discon_inner">
        <div class="clearfix soc_con_top_logo">
            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <h3>Change Your password</h3><br>
        <div class="clearfix pro_reset_password_inner stage_one">
            <input type="text" class="pro_reset_pass_field" placeholder="Enter email address">
            <h6 class="main_error" style="color: #fc064c; margin-top: 10px;font-size: 13px;display: none;"></h6><br>
            <div class="clearfix pro_submit_button_outer soc_con_submit_success">

                <a style="font-size: 15px; cursor: pointer;" id="submit_button">Submit</a>
            </div>
        </div>
        <div class="clearfix pro_reset_password_inner stage_two instant_hide">
            <input type="text" class="pro_reset_security_token" placeholder="Enter security token (sent to your email)">
            <div class="error instant_hide" id="pro_reset_security_token_error">Required</div>
            <input type="text" class="pro_reset_new_password" placeholder="Enter new password">
            <div class="error instant_hide" id="pro_reset_new_password_error">Required</div>
            <input type="text" class="pro_reset_new_password_confirmation" placeholder="Repeat new password">
            <div class="error instant_hide" id="pro_reset_new_password_confirmation_error">Required</div>
            <h6 class="main_error" style="color: #fc064c; margin-top: 10px;font-size: 13px;display: none;"></h6><br>
            <div class="clearfix pro_submit_button_outer soc_con_submit_success">

                <a style="font-size: 15px; cursor: pointer;" id="submit_button_two">Submit</a>
            </div>
            <br>
        </div>
        <div class="clearfix pro_reset_password_inner stage_three instant_hide">
            <div class="pro_pop_text_light text_center">
                Your password has been changed successfully!
            </div>
            <br>
        </div>
    </div>
</div>

<!-- Change Password  !-->
<div class="clearfix pro_change_pass_outer pro_page_pop_up" >

    <div class="clearfix pro_soc_con_twit_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix soc_con_twit_username">

            <h3>Change Password</h3><br>
            <div class="success"></div>
            <div class="">
                <input placeholder="Current Password" type="password" id="pro_change_pass_current" autocomplete="off" />
                <span class="error"></span>
            </div><br />
            <div class="">
                <input placeholder="New Password" type="password" id="pro_change_pass_new" autocomplete="off" />
                <span class="error"></span>
            </div><br />
            <div class="">
                <input placeholder="Confirm Password" type="password" id="pro_change_pass_confirm" autocomplete="off" />
                <span class="error"></span>
            </div>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a href="#" id="pro_change_pass_submit">Submit</a>
        </div>
    </div>
</div>
<!-- Change Twitter Account  !-->

<!-- Soundcloud Stay Tuned Popups -->
<div class="clearfix pro_soundcloud_stay_tuned pro_page_pop_up" >

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div><br>
        <div class="clearfix soc_discon_text">

            <h3>Soundcloud Integration</h3><br />
            <span class="error"></span>
        </div>
        <div class="clearfix soc_share_images defer_loading">
            <img class="defer_loading" src="" data-src="{{ asset('images/thankyou_icon.JPG') }}">
        </div><br />
        <h3>We are working to get it ready for you. Stay tuned.</h3><br>
    </div>
</div>
<!-- Soundcloud Stay Tuned Popup -->

<!-- Orders Tab Contact Details Pop-up -->

<!-- Orders Tab Contact Details Pop-up -->

<!-- Cannot Edit Information Pop-up -->
<div class="clearfix pro_cannot_change_info pro_page_pop_up" id="cant_edit_popup">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_cannot_change_info_inner">

            <h3>Cannot edit this information</h3><br />
            <center>
                <p>Your project is now live so you cannot
                    change this information.
                </p>
                <br /><img class="show_icon defer_loading" src="" data-src="{{ asset('images/cannot_edit.png') }}">
            </center>
            <div class="clearfix pro_submit_button_outer soc_con_submit_success" onclick="$('.pro_soc_top_close').click()">

                <a style="cursor: pointer;" id="submit_button">Okay</a>
            </div>
        </div>
    </div>
</div>
<!-- Cannot Edit Information Pop-up -->

<!-- Create new project -->
<div class="clearfix pro_select_item_before_procced pro_page_pop_up">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_select_item_before_procced_inner">

            <h3>Please Add an item to your basket</h3><br />
            <center>
                <p>To make this purchase you must select
                    at least one item.
                </p>
                <br /><img class="show_icon defer_loading" src="" data-src="{{ asset('images/add_item_before_proceed.JPG') }}">
            </center>
            <div class="clearfix pro_submit_button_outer soc_con_submit_success">

                <a href="#" id="submit_button">Okay</a>
            </div>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Create new project -->
<div class="clearfix pro_project_pitch_uploaded pro_page_pop_up" id="pitch_uploaded_popup" style="z-index: 10;">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_project_pitch_uploaded_inner">

            <h3>Your Project pitch
                has been uploaded</h3><br />
            <center>
                <img class="show_icon defer_loading" src="" data-src="{{ asset('images/project_pitch_uploaded.png') }}">
            </center>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Create new project -->
<div class="clearfix pro_project_pitch_uploaded pro_page_pop_up" id="bio_video_popup" style="z-index: 10;">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_project_pitch_uploaded_inner">

            <h3>Your bio video has been updated</h3><br />
            <center>
                <img class="show_icon defer_loading" src="" data-src="{{ asset('images/project_pitch_uploaded.png') }}">
            </center>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Share Project Pop-up !-->
@if(!isset($isQuickSetup))
<div class="clearfix pro_page_pop_up" id="share_project_popup" style="{{ $sharePopupDisplay }}" data-name="{{$user->name}}" data-share-image="{{$userCampaignVideoId}}">

    <div class="clearfix pro_confirm_delete_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8">
                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}">
                <div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close" data-reminder="1"></i>
        </div>
        <div class="clearfix pro_confirm_delete_text">

            <div class="pro_text_dark">Your project has been successfully saved. Be sure to Share To Social Media</div><br>
            <span class="error"></span>
        </div>
        <ul class="social_btns_outer">

            <li><a class="hm_fb_icon_share" href="javascript:void(0)"></a></li>
            <li><a class="hm_tw_icon_share" href="javascript:void(0)"></a></li>
            <li><a class="hm_login_icon_share" onclick="$('.pro_soc_top_close').click(); $('#profile-sharing-popup').show();" style="cursor: pointer;"></a></li>

        </ul>
    </div>
</div>
@endif
<!-- Share Project Pop-up !-->

<!-- Share Project to Social Media  -->
<div class="clearfix chart_share_proj_soc_med pro_page_pop_up" id="share_project_reminder_popup" >

    <div class="clearfix chart_share_proj_soc_med_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_project_pitch_uploaded_inner">

            <h3>Wait! Projects shared to social media are more successful than those that aren't</h3>
            <h4>You can tell supporters what's happening through social media</h4><br />
            <a style="cursor: pointer;" onclick=" $('.pro_soc_top_close').click(); $('#share_project_popup').show();">
                <img class="share_to_social_media defer_loading" src="" data-src="{{ asset("images/share_on_social.png") }}">
            </a>
        </div>
    </div>
</div>
<!-- Share Project to Social Media  -->

<div class="clearfix pro_page_pop_up" style="z-index: 10;" id="agent_chat_locked">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix soc_con_face_username">

            <h3 style="line-height: 20px;">Upgrade your package to platinum and have your own professional artist manager</h3><br><br><br>
        </div>
    </div>
</div>

<div class="clearfix pro_uploading_in_progress in_progress pro_page_pop_up" style="z-index: 10;" id="pro_uploading_in_progress_real">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
        </div>
        <div class="clearfix soc_con_face_username">

            <h3>Please wait. Uploading is in progress...</h3><br><br><br>
        </div>
    </div>
</div>

<div class="clearfix pro_page_pop_up new_popup" style="z-index: 10;" id="inline_info_popup">

    <div class="clearfix pro_soc_con_face_inner">

        <div style="padding: 10px 20px;" class="clearfix soc_con_top_logo">
            <a style="opacity:0;" class="logo8">
                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_pop_head"></div>
        <div class="pro_pop_body">
            <iframe allowfullscreen="allowfullscreen" type="text/html" frameborder="0"></iframe><br><br><br>
        </div>
    </div>
</div>

<div class="clearfix pro_pop_chat_upload in_progress new_popup pro_page_pop_up" style="z-index: 10;">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="pro_pop_head">Upload details</div>
        <div class="pro_pop_body">
            <div class="pro_body_in"></div>
            <div class="pro_pop_info">
                It may take a while, please be patient. Do not refresh or navigate away from this page
            </div>
        </div>
        <div class="pro_pop_foot">
            <div class="foot_help">
                Having problems? Please try again or contact us via online chat
            </div>
            <div class="foot_action">
                <!--<div id="minify_upload" class="foot_action_btn">Hide</div>!-->
            </div>
        </div>
    </div>
</div>

<div data-music="" class="clearfix music_zip_upload_popup in_progress pro_page_pop_up new_popup" style="z-index: 10;">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="pro_pop_head">Upload details</div>
        <div class="pro_pop_body">
            <div class="pro_body_in">
                <div data-type="music_info" class="pro_pop_upload_each waiting">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-info"></i></div>
                    <div class="pro_pop_each_item item_name">Saving music info</div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="main" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="loop_one" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="loop_two" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="loop_three" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="stem_one" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="stem_two" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="stem_three" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="stem_four" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="stem_five" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="stem_six" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="stem_seven" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="stem_eight" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-music"></i></div>
                    <div class="pro_pop_each_item item_name"></div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
                <div data-type="music_file_delete" class="pro_pop_upload_each waiting instant_hide">
                    <div class="pro_pop_each_item item_type"><i class="fa fa-trash"></i></div>
                    <div class="pro_pop_each_item item_name">Deleting music file(s)</div>
                    <div class="pro_pop_each_item item_size"></div>
                    <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
                </div>
            </div>
            <div class="pro_pop_info">
                It may take a while, please be patient. Do not refresh or navigate away from this page
            </div>
        </div>
        <div class="pro_pop_foot">
            <div class="foot_help">
                Having problems? Please try again or contact us via online chat
            </div>
            <div class="foot_action">
                <!--<div id="minify_upload" class="foot_action_btn">Hide</div>!-->
                <div id="close_upload" class="foot_action_btn instant_hide">Finish</div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix pro_uploading_in_progress in_progress pro_page_pop_up" style="z-index: 10;" id="pro_uploading_in_progress">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
        </div>
        <br>
        <div class="clearfix soc_con_face_username">

            <div id="step_1" class="each_progress">
                <i class="fa fa-check"></i>
                <div class="progress_head">Uploading Music</div>
            </div>
            <div id="step_2" class="each_progress">
                <i class="fa fa-check"></i>
                <div class="progress_head">Drawing Waveform</div>
            </div>
            <div id="step_3" class="each_progress">
                <i class="fa fa-check"></i>
                <div class="progress_head">Saving Waveform and Duration</div>
            </div>
            <div id="error_mess" style="margin-top: 30px;" class="instant_hide">
                <div id="error_message" style="font-size: 15px;font-family: 'open_sanslight'; font-weight: bold;color: #fc064c;margin-top:30px;"></div>
                <div class="clearfix pro_submit_button_outer soc_con_submit_success">
                    <a href="javascript:void(0)" onclick="$('#pro_uploading_in_progress,#body-overlay').hide();" id="submit_button">Okay</a>
                </div>
            </div>
            <br><br><br>
        </div>
    </div>
</div>


<div class="clearfix pro_confirm_go_live pro_page_pop_up" style="z-index: 10;" id="pro_confirm_go_live">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
            <br>
        </div>
        <div class="clearfix soc_con_face_username">

            <h3>You are about to go live on 1Platform TV. Once you are live you cannot undo this action</h3><br>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">
            <a href="javascript:void(0)" id="pro_go_live_confirm">Proceed</a>
        </div>
    </div>
</div>

<div class="clearfix pro_page_pop_up" id="internal_sub_unsub_popup">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">
            <a style="opacity:0;" class="logo8">
                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix soc_con_face_username">
            <div class="pro_pop_text_light text_center">
                If you wish to cancel your account, subscription or change your subscription plan please email us at <a href="mailto:admin@1platform.tv"><span class="pro_text_dark" id="sender_name">admin@1platform.tv</span></a>
            </div>
        </div>
        <br>
    </div>
</div>


<!-- Connect Facebook Account  !-->
<div class="clearfix pro_soc_con_face_outer_sharing pro_page_pop_up" style="z-index: 10;" id="profile-sharing-popup">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix soc_con_face_username">

            <div class="main_headline">Tell people about this amazing project!</div><br>
            <input placeholder="" type="text" class="show_link" value="{{ asset( "project/" . $userCampaign->user->id ) }}" />
            <span class="error"></span>
        </div>
    </div>
</div>

<input type="hidden" name="user_page_link" id="user_page_link" value="{{ $userPageLink }}">
<input type="hidden" name="project_page_link" id="project_page_link" value="{{ asset( "project/" . $userCampaign->user->id ) }}">
<!-- Connect Facebook Account  !-->

<!-- Create new project -->
<div class="clearfix add_video_to_channel pro_page_pop_up" id="post_video_popup_01">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_select_item_before_procced_inner">

            <h3>Add Your Video To Your Channel</h3><br />
            <!--<center>
                <div id="youtube_section">
                    <iframe frameBorder="0" width="100%" height="150" id="post_vid_iframe"
                            src="https://www.youtube.com/embed/0cSXq4TYIIk">
                    </iframe>
                </div>
            </center>!-->

            <div class="text1">All uploads must be music related to you or the platform.You must own the copyright</div>
            <a id="termsLink" href="{{ asset("tc") }}" target="_blank"></a>
            <div class="text2 popup_checkbox_label checkbox_label unchecked single_line_label">You agree to our <a href="#" onclick="document.getElementById('termsLink').click();">terms and conditions</a>
                <input value="1" name="terms_agree" id="terms_agree" type="checkbox">
            </div>
            <div id="replace_chart_entry" class="text2 popup_checkbox_label checkbox_label unchecked">Submit my upload to 1Platform Chart
                <input value="1" name="enter_video" id="enter_video" type="checkbox">
            </div>
            <div class="clearfix pro_confirm_box_outer pro_submit_button_outer soc_con_submit_success" id="post_video_submit_yes">

                <div class="pro_confirm_box_each submit_yes">YES</div>
                <div class="pro_confirm_box_each delete_no" id="post_video_submit_no" onclick="$('.pro_soc_top_close').click()">NO</div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix add_video_to_channel pro_page_pop_up" id="post_video_popup_02">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_select_item_before_procced_inner">

            <h3>You have reached your maximum chart entries</h3><br />

            <div class="text1">You are only allowed one chart entry at a time</div>
            <a id="termsLink" href="{{ asset("tc") }}" target="_blank"></a>
            <div class="text2 popup_checkbox_label checkbox_label unchecked">Please replace my chart entry
                <input value="1" name="replace_video" id="replace_video" type="checkbox">
            </div>
            <div class="clearfix pro_submit_button_outer soc_con_submit_success" id="post_video_submit_yes">

                <a style="cursor: pointer;">Proceed</a>
            </div>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Save profile without a connected atripe account  -->
<div class="clearfix save_pro_no_conn_stripe pro_page_pop_up" id="wait_popup" >

    <div class="clearfix save_pro_no_conn_stripe_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_project_pitch_uploaded_inner">

            <h3>Wait! before saving</h3>
            <h4>Once someone has supported your project you can only edit your title and story, aswell as add new bonuses</h4><br />
            <div class="submit_btn_02 pop_up_btn" style="cursor: pointer;" onclick="$('#profile_tab_05 #save_project_form').submit();">
                <a>Save</a>
            </div>
            <div class="submit_btn_03 pop_up_btn" style="cursor: pointer;" onclick="$('.pro_soc_top_close').click();">
                <a>Wait I need to change somethings</a>
            </div>
        </div>
    </div>
</div>
<!-- Save profile without a connected atripe account  -->

<!-- Continue save profile without a connected atripe account  -->
<div class="clearfix cont_save_pro_no_conn_stripe pro_page_pop_up" id="stripe_popup" style="{{ $stripePopupDisplay }}" >

    <div class="clearfix save_pro_no_conn_stripe_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close" data-stripe="1"></i>
        </div>
        <div class="clearfix pro_project_pitch_uploaded_inner">

            <h4>Your project has been saved but if you <text style="font-weight: bold;">want to accept</text> your payments you need to Connect your stripe account</h4><br />
            <a class="pro_stript_btn" href="{{ $stripeUrl }}"></a><br /><br /><br />
        </div>
    </div>
</div>
<!-- Continue save profile without a connected atripe account  -->

<!-- Share Project to Social Media  -->
<div class="clearfix make_acc_in_secs pro_page_pop_up" >

    <div class="clearfix chart_share_proj_soc_med_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_project_pitch_uploaded_inner">

            <h3>Want to start your own project?<br />Make an account in seconds</h3>
            <img class="big_clock_img defer_loading" src="" data-src="{{ asset("images/icon_accountprofile.png") }}">
        </div>
        <div class="submit_btn_04 pop_up_btn" onclick="$('.pro_soc_top_close').click();">
            <a>Create an account</a>
        </div>
    </div>
</div>
<!-- Share Project to Social Media  -->

<!-- More than 5 products not alloweed -->
<div class="clearfix pro_products_max_limit pro_page_pop_up" id="star_your_music_prod_popup">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix soc_discon_text">
            <br />
            <h3>You Can Only Add 5 Items To Your User Page</h3><br />
            <span class="error"></span>
        </div>
        <div class="clearfix pro_products_max_limit_img">
            <img class="defer_loading" src="" data-src="{{ asset('images/dance_icon_002.png') }}">
        </div><br />
    </div>
</div>
<!-- More than 5 products not alloweed -->

<!-- Create new project -->
<div class="clearfix pro_create_new_project pro_page_pop_up" id="create_new_project_popup" >

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_create_new_project_inner">

            <h3>Are you sure you want to create a
                new project?</h3><br /><br />
            <center>
                <p>
                    You will not be able to edit your
                    current project once you have created
                    a new project.
                </p>
                <br /><br />
            </center>
            <div class="clearfix pro_submit_button_outer soc_con_submit_success">

                <a href="{{ asset("inactivateProject?id=" . $userCampaign->id) }}" id="submit_button">Okay</a>
            </div>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Video Successfully Uploaded -->
<div class="clearfix pro_video_uploaded pro_page_pop_up" id="video_uploaded_popup" style="z-index: 10; {{ $videoUploadedDisplay }}">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_video_uploaded_inner">
            <br />
            <h3>Your video has been successfully uploaded</h3><br />
            <center>
                <img class="pro_video_upload_img defer_loading" src="" data-src="{{ asset('images/dance_icon_004.png') }}"><br />
                <h3 class="pro_video_upload_txt_2">Share to social media</h3><br />
                @if(Session::has('vidId'))
                    <input type="hidden" id="uploadedVidId" value="{{ Session::get('vidId') }}">
                    <input type="hidden" id="uploadedVidUserId" value="{{ $userCampaign->user->id }}">
                    <input type="hidden" id="uploadedVidUserName" value="{{ $userCampaign->user->name }}">
                    <input type="hidden" id="uploadedVidTitle" value="{{ \App\Http\Controllers\CommonMethods::getVideoTitle( Session::get('vidId') ) }}">
                @endif
                <img class="each_video_upload_img defer_loading" src="" data-src="{{ asset('images/pop_face_icon.png') }}" onclick="facebookShareUploadedVideo()">
                <img class="each_video_upload_img defer_loading" src="" data-src="{{ asset('images/pop_twitter_icon.png') }}" onclick="twitterShareUploadedVideo()">
            </center>
        </div>
    </div>
</div>
<!-- Video Successfully Uploaded -->

<!-- Music Career Starts -->
<?php
$firstTimeLoginDisplay = "";

$campUser = $userCampaign->user;
$campUsername = $campUser->username;
?>

@if (Session::has('profile_saved'))
    <?php $firstTimeLoginDisplay = "display: block;"; ?>
@endif

<input type="hidden" name="useremailsharelink" id="useremailsharelink" value="{{ asset('/').$campUsername}}">

<div class="clearfix pro_music_career_starts pro_page_pop_up" id="music_career_popup" style="z-index: 10; {{ $firstTimeLoginDisplay }}">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close firsttime_login_close"></i>
        </div>
        <div class="clearfix pro_music_career_starts_inner">

            <h3>Your profile has been successfully updated</h3><br />
            <center>
                <p class="pro_video_upload_txt_2">Tell everyone about 1Platform</p><br />
                <a onclick="return facebookShare('url')" class="" href="javascript:void(0)">
                    <i class="fa fa-facebook-square" style="color: #000; font-size: 35px; margin-right: 15px;"></i>
                </a>
                <!--<img class="each_video_upload_img defer_loading" src="" data-src="{{ asset('images/pop_google_icon.png') }}" onclick="shareOnGooglePlus();" >!-->
                <a onclick="return twitterShare('url')" class="" href="javascript:void(0)">
                    <i class="fa fa-twitter-square" style="color: #000; font-size: 35px;"></i>
                </a>
            </center>
        </div>
    </div>
</div>
<!-- Music Career Starts -->


<div class="clearfix pro_video_uploaded pro_page_pop_up" id="register_studio_popup_1" style="z-index: 10;">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_video_uploaded_inner">
            <br />
            <h3>You Must Be A Registered Studio Appearing On Google Maps.</h3><br />
            <center>
                <img class="pro_video_upload_img defer_loading" src="" data-src="{{ asset('images/studio_icon.png') }}"><br />
            </center>
            <h3>All Studios Appear In the Studios Tab. This cannot be changed once done.</h3><br />
        </div>


        <div class="clearfix pro_submit_button_outer soc_submit_success">

            <a style="cursor: pointer;" id="register_studio_yes_1">Change My Account To A Studio Account</a>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a style="cursor: pointer;" onclick="$('#register_studio_popup_1').hide();">No</a>
        </div>

    </div>
</div>



<div class="clearfix pro_video_uploaded pro_page_pop_up" id="register_studio_popup_2" style="z-index: 10;">

    <div class="clearfix pro_soc_discon_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="clearfix pro_video_uploaded_inner">
            <br />
            <h3>Are You Sure You Are A Studio?</h3><br />
            <center>
                <img class="pro_video_upload_img defer_loading" src="" data-src="{{ asset('images/studio_icon.png') }}"><br />
            </center>
            <h3>If You Are Not A Registered Studio Your Account Will Be Deleted.</h3><br />
        </div>


        <div class="clearfix pro_submit_button_outer soc_submit_success">

            <a style="cursor: pointer;" id="register_studio_yes_2">Yes</a>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a style="cursor: pointer;" onclick="$('#register_studio_popup_2').hide();">No</a>
        </div>

    </div>
</div>

<!-- Confirm Unsubscribe Pop-up  !-->
<div class="clearfix pro_confirm_unsubscribe_outer pro_page_pop_up" >

    <div class="clearfix pro_confirm_unsubscribe_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
            <br>
        </div>
        <div class="clearfix pro_confirm_delete_text">

            <h3>Your domain subscription will expire within 24 hrs. Are you sure you want to cancel your subscription?</h3>
            <br>
            <span class="error"></span>
        </div>
        <div class="clearfix pro_submit_button_outer soc_submit_success">

            <a onclick="unsubConfirmed()" data-id="" href="javascript:void(0)" id="pro_unsub_submit_yes">Yes</a>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a onclick="unsubCancelled()" href="javascript:void(0)" id="pro_confirm_unsub_submit_no">No</a>
        </div>
    </div>
</div>
<div class="clearfix pro_confirm_undomedia_outer pro_page_pop_up" >

    <div class="clearfix pro_confirm_undomedia_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="pro_soc_top_close fa fa-close"></i>
            <br>
        </div>
        <div class="clearfix pro_confirm_delete_text">

            <h3>Are you sure you want to perform this action?</h3>
            <br>
            <span class="error"></span>
        </div>
        <div class="clearfix pro_submit_button_outer soc_submit_success">

            <a onclick="undoMediaConfirmed()" data-id="" href="javascript:void(0)" id="pro_unsub_submit_yes">Yes</a>
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">

            <a onclick="undoMediaCancelled()" href="javascript:void(0)" id="pro_confirm_unsub_submit_no">No</a>
        </div>
    </div>
</div>
<!-- Confirm Unsubscribe Pop-up  !-->


<div class="clearfix pro_page_pop_up" id="music_private_popup" data-music-id="">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">
            <a style="opacity:0;" class="logo8">
                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="stage_one">
            <div class="clearfix soc_con_face_username">
                <div class="main_headline">Manage music privacy</div><br>
                <div class="new_popup_check_out">
                    <input type="hidden" class="new_popup_check" />
                    <span class="new_popup_check_in">Make this music private</span>
                </div>
                <input class="dummy_field" type="text" name="fakeusernameremembered">
                <input placeholder="Unlock PIN" type="text" id="private_music_pin" />
                <div class="instant_hide error" id="pin_error">Required</div>
            </div>
            <br>
            <div id="save_music_private" class="pro_button">SAVE</div><br>
            <div class="pro_pop_dark_note">
                <a href="#">How music privacy works?</a>
            </div>
        </div>
    </div>
</div>

@if(Session::has('general_user_first_things_first'))
    @php $suggestedUsername = Session::get('general_user_first_things_first') @endphp
@else
    @php $suggestedUsername = '' @endphp
@endif

<div class="clearfix pro_default_username in_progress pro_page_pop_up" style="z-index: 10;{{$suggestedUsername!=''?'display:block;' : ''}}" id="pro_default_username">

    <div class="clearfix pro_soc_con_face_inner">

        <div class="clearfix soc_con_top_logo">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
        </div><br>
        <div class="clearfix soc_con_twit_username">
            @if($user->username == null)
            <h5 style="font-size: 13px;">
                Choose a unique username. This will be used in your website url (i.e https://{{Config('constants.primaryDomain')}}/{{$suggestedUsername}}). We have placed a default username for you
            </h5>
            <br>
            <div class="">
                <input type="text" value="{{$suggestedUsername}}" id="web_username" />
            </div>
            <div class="error instant_hide" id="web_username_error"></div><br>
            @endif
        </div>
        <div class="clearfix pro_submit_button_outer soc_con_submit_success">
            <a href="javascript:void(0)" id="pro_default_currency_submit">Submit</a>
        </div>
    </div>
</div>


