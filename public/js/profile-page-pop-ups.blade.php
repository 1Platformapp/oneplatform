<?php
/**
 * Created by PhpStorm.
 * User: Ahsan Hanif
 * Date: 30-Sep-17
 * Time: 11:02 PM
 */
$userPageLink = asset('/'). \App\Http\Controllers\CommonMethods::getUserEmailInitials( $userCampaign->user_id );
$sharePopupDisplay = "";
$stripePopupDisplay = "";
$videoUploadedDisplay = "";
?>

@if (Session::has('share_project'))
    @if($userCampaign->user->profile->stripe_secret_key == "")
        <?php $stripePopupDisplay = "display: block;";?>
    @else
        <?php $sharePopupDisplay = "display: block;";?>
    @endif
@endif

@if(Session::has('video_uploaded'))
    <?php $videoUploadedDisplay = "display: block;"; ?>
@endif


<!-- Connect Facebook Account  !-->
<div class="pro_soc_con_face_outer pro_page_pop_up clearfix">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <div class="soc_con_face_username clearfix">

            <h3>Facebook Page ID</h3><br>
            <p>Looking for your page ID? Go to the Facebook page that you want to add to the site&gt;click About&gt;Scroll down to the bottom of the page and copy your Facebook page ID</p><br>
            <input placeholder="Facebook Page ID" type="text" id="soc_con_face_username_val" value="" />
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a href="#" id="pro_soc_con_facebook_submit">Connect</a>
        </div>
    </div>
</div>
<!-- Connect Facebook Account  !-->

<!-- Connect Youtube Account  !-->
<div class="pro_soc_con_youtube_outer pro_page_pop_up clearfix" >

    <div class="pro_soc_con_youtube_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <div class="soc_con_youtube_username clearfix">

            <h3>Youtube Profile Username</h3><br>
            <input placeholder="Youtube Profile" type="text" id="soc_con_youtube_username_val" value="" />
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a href="#" id="pro_soc_con_youtube_submit">Connect</a>
        </div>
    </div>
</div>
<!-- Connect Youtube Account  !-->

<!-- Connect Twitter Account  !-->
<div class="pro_soc_con_twit_outer pro_page_pop_up clearfix" >

    <div class="pro_soc_con_twit_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <div class="soc_con_twit_username clearfix">

            <h3>Twitter Account Username</h3><br>
            <input placeholder="Twitter Account" type="text" id="soc_con_twit_username_val" value="" />
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a href="#" id="pro_soc_con_twit_submit">Connect</a>
        </div>
    </div>
</div>
<!-- Connect Twitter Account  !-->

<!-- Connect Twitter Account  !-->
<div class="pro_soc_discon_outer pro_page_pop_up clearfix" >

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="pro_soc_top_close fa fa-close"></i>
        </div>
        <div class="soc_discon_text clearfix">

            <h3>Do You Want To Disconnect Your <span>Youtube</span> Account?</h3><br>
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a data-disconnect-account="" href="#" id="pro_soc_discon_submit_yes">Yes</a>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a href="#" id="pro_soc_discon_submit_no">No</a>
        </div>
    </div>
</div>
<!-- Connect Twitter Account  !-->


<!-- Email Popups -->
<div class="pro_send_email_outer pro_page_pop_up clearfix" >

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_discon_text clearfix">

            <h3>Post a Thank You Note</h3>
            <span class="error"></span>
        </div>
        <div class="soc_share_images clearfix">
            <img id="thank_you_image" class="defer_loading" src="" data-src="{{ asset('images/video_img.png') }}">
            <img class="dance_icon_right defer_loading" src="" data-src="{{ asset('images/dancing-icon-2.png') }}">
        </div>
        <div class="soc_share_buttons clearfix">

            <span>
                <div class="social_supp_btns clearfix">
                        <ul class="clearfix">
                            <li><a id="facebook_share" class="popup_share_icon ch_sup_fb" href="javascript:void(0)"> Share</a> </li>
                            <li><a id="twitter_share" class="popup_share_icon ch_sup_tw" href="javascript:void(0)"> Tweet</a></li>
                        </ul>
                </div>
            </span>
            <a id="thank_via_email_btn">Or send an Email</a>
        </div>

        <div class="email_box clearfix">
            <textarea id="thankyou_email_text"></textarea>
        </div>
        <div class="pro_submit_button_outer email_button clearfix">
            <a id="send_thankyou_email">Send</a>
        </div>
    </div>
</div>
<!-- Email popups end -->

<!-- Profile Form Error Pop up -->
<div class="pro_fill_outer pro_page_pop_up clearfix">

    <div class="pro_fill_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_discon_text clearfix">

            <h3>Wait!! You haven't completed all of your profile information</h3><br />
            <span class="error"></span>
        </div>
        <div class="pro_fill_img clearfix">
            <img class="defer_loading" src="" data-src="{{ asset('images/pupfillprofile.png') }}">
        </div>
    </div>
</div>
<!-- Profile Form Error Pop up -->

<!-- Confirm Delete Pop-up  !-->
<div class="pro_confirm_delete_outer pro_page_pop_up clearfix" >

    <div class="pro_confirm_delete_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_confirm_delete_text clearfix">

            <h3>Are You Sure You Want To Delete This Item?</h3><br>
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_submit_success clearfix">

            <a data-delete-id="" data-delete-item-type="" data-album-status="" data-album-music-id="" href="#" id="pro_delete_submit_yes">Yes</a>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a href="#" id="pro_confirm_delete_submit_no">No</a>
        </div>
    </div>
</div>
<!-- Confirm Delete Pop-up  !-->

<!-- Add/Edit Bonus Pop-up  !-->
<div class="pro_add_edit_bonus_outer pro_page_pop_up clearfix" >

    <div class="pro_confirm_delete_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_confirm_delete_text clearfix">

            <h3><span class="add_edit_text">Add a New</span> Bonus</h3>
            <span class="error"></span>
        </div>
        <form id="add_edit_bonus_form" action="{{ route('add.edit.bonus') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="pro_add_bonus_row_outer pop_up_scroller clearfix cant_edit_fields">

                <label>Title*</label><br>
                <input class="pop_up_bonus_field" placeholder="Bonus Title" type="text" id="pop_up_bonus_title" name="bonus_title" value="" />
                <label>Bonus Thumbnail (Optional)</label><br>
                <img class="pop_up_bonus_thumb defer_loading" src="" data-src="{{ asset('images/p_music_thum_img.png') }}">
                <label>Description*</label><br>
                <textarea class="pop_up_bonus_field" name="bonus_description" id="pop_up_bonus_description"></textarea>
                <label>Amount Of Bonuses Available*</label><br>
                <input class="pop_up_bonus_field" type="text" id="pop_up_bonus_quantity" name="bonus_quantity" value="" />
                <label>Bonus Items*</label><br>
                <input class="pop_up_bonus_field" type="text" id="pop_up_bonus_items" name="bonus_items" value="" />
                <label>Bonus Price*</label><br>
                <div class="proj_bonus_curr_crop_outer">
                    <div class="tot_usd_shiping">
                        <div class="proj_cont_right_inner drop_substi_bon_inner clearfix">
                            <div class="drop_substi_curr">GBP</div>
                            <input value="" class="tot_usd_val pop_up_bonus_field drop_substi_val" type="text" id="pop_up_bonus_price" name="bonus_price" value="" />
                        </div>
                    </div>
                </div>
                <label>Worldwide Shipping</label><br>
                <div class="proj_bonus_curr_crop_outer">
                    <div class="tot_usd_shiping">
                        <div class="proj_cont_right_inner drop_substi_bon_inner clearfix">
                            <div class="drop_substi_curr">GBP</div>
                            <input value="" class="tot_usd_val pop_up_bonus_field drop_substi_val" type="text" id="pop_up_bonus_shipping_worldwide" name="bonus_shipping_worldwide" value="" />
                        </div>
                    </div>
                </div>
                <label>My Country Shipping</label><br>
                <div class="proj_bonus_curr_crop_outer">
                    <div class="tot_usd_shiping">
                        <div class="proj_cont_right_inner drop_substi_bon_inner clearfix">
                            <div class="drop_substi_curr">GBP</div>
                            <input value="" class="tot_usd_val pop_up_bonus_field drop_substi_val" type="text" id="pop_up_bonus_shipping_my_country" name="bonus_shipping_my_country" value="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="pro_submit_button_outer soc_submit_success clearfix">

                <input type="hidden" id="pop_up_bonus_id" name="bonus_id" value="0" />
                <input type="hidden" id="pop_up_campaign_id" name="bonus_campaign_id" value="0" />
                <input type="file" id="pop_up_bonus_file" name="bonus_thumbnail" style="display: none;" onchange="setBonusThumb(this)" />
                <a href="#" class="submit_bonus_form">Submit</a>
            </div>
        </form>
    </div>
</div>
<!-- Add/Edit Bonus Pop-up  !-->

<!-- Change Password  !-->
<div class="pro_change_pass_outer pro_page_pop_up clearfix" >

    <div class="pro_soc_con_twit_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_con_twit_username clearfix">

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
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a href="#" id="pro_change_pass_submit">Submit</a>
        </div>
    </div>
</div>
<!-- Change Twitter Account  !-->

<!-- Soundcloud Stay Tuned Popups -->
<div class="pro_soundcloud_stay_tuned pro_page_pop_up clearfix" >

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_discon_text clearfix">

            <h3>Soundcloud Integration</h3><br />
            <span class="error"></span>
        </div>
        <div class="soc_share_images defer_loading clearfix">
            <img class="defer_loading" src="" data-src="{{ asset('images/thankyou_icon.JPG') }}">
        </div><br />
        <h3>We are working to get it ready for you. Stay tuned.</h3><br>
    </div>
</div>
<!-- Soundcloud Stay Tuned Popup -->

<!-- Orders Tab Contact Details Pop-up -->
<div class="pro_orders_tab_contact_details pro_page_pop_up clearfix" style="" id="contact_popup">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_orders_tab_contact_details_inner clearfix">

            <h4 id="cont_popup_name"></h4>
            <h4 id="cont_popup_email"></h4><br />
            <h4 id="cont_popup_address"></h4>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix">

                <a style="cursor: pointer;" id="submit_button" onclick="$('.pro_soc_top_close').click()">Okay</a>
            </div>
        </div>
    </div>
</div>
<!-- Orders Tab Contact Details Pop-up -->

<!-- Cannot Edit Information Pop-up -->
<div class="pro_cannot_change_info pro_page_pop_up clearfix" id="cant_edit_popup">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_cannot_change_info_inner clearfix">

            <h3>Cannot edit this information</h3><br />
            <center>
                <p>Your project is now live so you cannot
                    change this information.
                </p>
                <br /><img class="show_icon defer_loading" src="" data-src="{{ asset('images/cannot_edit.png') }}">
            </center>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix" onclick="$('.pro_soc_top_close').click()">

                <a style="cursor: pointer;" id="submit_button">Okay</a>
            </div>
        </div>
    </div>
</div>
<!-- Cannot Edit Information Pop-up -->

<!-- Create new project -->
<div class="pro_select_item_before_procced pro_page_pop_up clearfix">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_select_item_before_procced_inner clearfix">

            <h3>Please Add an item to your basket</h3><br />
            <center>
                <p>To make this purchase you must select
                    at least one item.
                </p>
                <br /><img class="show_icon defer_loading" src="" data-src="{{ asset('images/add_item_before_proceed.JPG') }}">
            </center>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix">

                <a href="#" id="submit_button">Okay</a>
            </div>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Create new project -->
<div class="pro_project_pitch_uploaded pro_page_pop_up clearfix" id="pitch_uploaded_popup" style="z-index: 10;">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_project_pitch_uploaded_inner clearfix">

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
<div class="pro_project_pitch_uploaded pro_page_pop_up clearfix" id="bio_video_popup" style="z-index: 10;">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_project_pitch_uploaded_inner clearfix">

            <h3>Your bio video
                has been uploaded</h3><br />
            <center>
                <img class="show_icon defer_loading" src="" data-src="{{ asset('images/project_pitch_uploaded.png') }}">
            </center>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Share Project Pop-up !-->
<div class="remind_login_pop_up pro_page_pop_up clearfix" id="share_project_popup" style="{{ $sharePopupDisplay }}">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close" data-reminder="1"></i>

            <h4 style="padding-bottom: 20px; padding-top: 20px;">
                Your project has successfully been saved. Be sure to Share To Social Media
            </h4>
        </div>

        <ul class="social_btns_outer">

            <li><a class="hm_fb_icon_share" onclick="facebookShareProject();" style="cursor: pointer;"></a></li>
            <li><a class="hm_tw_icon_share" onclick="twitterShareProject();" style="cursor: pointer;"></a></li>
            <li><a class="hm_gm_icon_share" onclick="googleShareProject();" style="cursor: pointer;"></a></li>
            <li><a class="hm_login_icon_share" onclick="$('.pro_soc_top_close').click(); $('#profile-sharing-popup').show();" style="cursor: pointer;"></a></li>

        </ul>
    </div>
</div>
<!-- Share Project Pop-up !-->

<!-- Share Project to Social Media  -->
<div class="chart_share_proj_soc_med pro_page_pop_up clearfix" id="share_project_reminder_popup" >

    <div class="chart_share_proj_soc_med_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_project_pitch_uploaded_inner clearfix">

            <h3>Wait! Projects shared to social media are more successful than those that aren't</h3>
            <h4>With social media campaigns have been proven to be more successful</h4><br />
            <h4>More people will hear about your ptoject if you share it to social media, So more people can support it.</h4><br />
            <h4>You can tell supporters what's happening through social media</h4><br />
            <a style="cursor: pointer;" onclick=" $('.pro_soc_top_close').click(); $('#share_project_popup').show();">
                <img class="share_to_social_media defer_loading" src="" data-src="{{ asset("images/share_on_social.png") }}">
            </a>
        </div>
    </div>
</div>
<!-- Share Project to Social Media  -->

<div class="pro_uploading_in_progress in_progress pro_page_pop_up clearfix" style="z-index: 10;" id="pro_uploading_in_progress">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
        </div>
        <div class="soc_con_face_username clearfix">

            <h3>Please wait. Uploading is in progress...</h3>
            <div id="error_mess" class="instant_hide">
                <div id="error_message" style="text-align: center;color: #fc064c;margin-top:30px;"></div>
                <div class="pro_submit_button_outer soc_con_submit_success clearfix">
                    <a href="javascript:void(0)" onclick="$('#pro_uploading_in_progress,#body-overlay').hide();" id="submit_button">Okay</a>
                </div>
            </div>
            <br><br><br>
        </div>
    </div>
</div>


<div class="pro_initiating_download in_progress pro_page_pop_up clearfix" style="z-index: 10;" id="pro_initiating_download">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
        </div>
        <div class="soc_con_face_username clearfix">

            <h3>We are preparing your download. Do not refresh or navigate away.</h3><br><br><br>
        </div>
    </div>
</div>

<div class="pro_confirm_go_live pro_page_pop_up clearfix" style="z-index: 10;" id="pro_confirm_go_live">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="pro_soc_top_close fa fa-close"></i>
            <br>
        </div>
        <div class="soc_con_face_username clearfix">

            <h3>You are about to go live on The Audition TV. Once you are live you cannot undo this action</h3><br>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">
            <a href="javascript:void(0)" id="pro_go_live_confirm">Proceed</a>
        </div>
    </div>
</div>

@if(Session::has('seller_currency_prompt'))
    @php $showSellerCurrency = 'display: block;'; @endphp
@else
    @php $showSellerCurrency = ''; @endphp
@endif
<div class="pro_default_currency in_progress pro_page_pop_up clearfix" style="z-index: 10;{{$showSellerCurrency}}" id="pro_default_currency">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
        </div><br>
        <div class="soc_con_twit_username clearfix">

            <h3>Start Your Exciting Selling Experience</h3><br>
            <h5 style="text-align: center; font-size: 15px;">
                The currency below will apply for your musics, products, albums, crowdfund bonuses, fan contributions and subscription
            </h5>
            <br><br>
            <div class="">
                <div class="custom_drop_outer each_side_left">
                    <label>GBP</label>
                    <select id="pro_default_currency_value">
                        <option selected value="gbp">GBP</option>
                        <option value="usd">USD</option>
                        <option value="eur">EUR</option>
                    </select>
                    <i class="fa fa-angle-down vertical_center"></i>
                </div>
            </div><br />
            <h5 style="color: #fc064c; font-size: 15px;">
                Note: Once selected, you cannot change it.
            </h5>
            <br /><br>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">
            <a href="javascript:void(0)" id="pro_default_currency_submit">Submit</a>
        </div>
    </div>
</div>


<!-- Connect Facebook Account  !-->
<div class="pro_soc_con_face_outer_sharing pro_page_pop_up clearfix" style="z-index: 10;" id="profile-sharing-popup">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_con_face_username clearfix">

            <h3>Tell people about this amazing project!</h3><br>
            <input placeholder="" type="text" class="show_link" value="{{ asset( "project/" . $userCampaign->user->id ) }}" />
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix" style="background: #fff;">

            <p style="color: #ff4d4d;">Share to social media</p>

            <img class="defer_loading" src="" data-src="{{ asset("img/facebook_share.png") }}" style="display: inline-block; width: 35px; padding-right: 10px; cursor: pointer;" onclick="return facebookShareProject()">
            <img class="defer_loading" src="" data-src="{{ asset("img/google_share.png") }}" style="display: inline-block; padding-right: 10px; cursor: pointer;" onclick="return googleShareProject()">
            <img class="defer_loading" src="" data-src="{{ asset("img/twitter_share.png") }}" style="display: inline-block; width: 25px; cursor: pointer;" onclick="return twitterShareProject()">
        </div>
    </div>
</div>

<input type="hidden" name="user_page_link" id="user_page_link" value="{{ $userPageLink }}">
<input type="hidden" name="project_page_link" id="project_page_link" value="{{ asset( "project/" . $userCampaign->user->id ) }}">
<!-- Connect Facebook Account  !-->

<!-- Create new project -->
<div class="add_video_to_channel pro_page_pop_up clearfix" id="post_video_popup_01">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_select_item_before_procced_inner clearfix">

            <h3>Add Your Video To Your Channel</h3><br />
            <center>
                <div id="youtube_section">
                    <iframe frameBorder="0" width="100%" height="150" id="post_vid_iframe"
                            src="https://www.youtube.com/embed/Ou-12wAIH2Y">
                    </iframe>
                </div>
            </center>

            <div class="text1">Your uploads will appear in your music tab<br>All uploads must be music related to you or the platform.You must own the copyright</div>
            <a id="termsLink" href="{{ asset("tc") }}" target="_blank"></a>
            <div class="text2 popup_checkbox_label checkbox_label unchecked single_line_label">You agree to our <a href="#" onclick="document.getElementById('termsLink').click();">terms and conditions</a>
                <input value="1" name="terms_agree" id="terms_agree" type="checkbox">
            </div>
            <div id="replace_chart_entry" class="text2 popup_checkbox_label checkbox_label unchecked">Submit my upload to The Audition Chart
                <input value="1" name="enter_video" id="enter_video" type="checkbox">
            </div>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix" id="post_video_submit_yes">

                <a style="cursor: pointer;">Yes</a>
            </div>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix" id="post_video_submit_no" onclick="$('.pro_soc_top_close').click()">

                <a style="cursor: pointer;">No</a>
            </div>
        </div>
    </div>
</div>

<div class="add_video_to_channel pro_page_pop_up clearfix" id="post_video_popup_02">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_select_item_before_procced_inner clearfix">

            <h3>You have reached your maximum chart entries</h3><br />

            <div class="text1">You are only allowed one chart entry at a time</div>
            <a id="termsLink" href="{{ asset("tc") }}" target="_blank"></a>
            <div class="text2 popup_checkbox_label checkbox_label unchecked">Please replace my chart entry
                <input value="1" name="replace_video" id="replace_video" type="checkbox">
            </div>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix" id="post_video_submit_yes">

                <a style="cursor: pointer;">Proceed</a>
            </div>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Save profile without a connected atripe account  -->
<div class="save_pro_no_conn_stripe pro_page_pop_up clearfix" id="wait_popup" >

    <div class="save_pro_no_conn_stripe_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_project_pitch_uploaded_inner clearfix">

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
<div class="cont_save_pro_no_conn_stripe pro_page_pop_up clearfix" id="stripe_popup" style="{{ $stripePopupDisplay }}" >

    <div class="save_pro_no_conn_stripe_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close" data-stripe="1"></i>
        </div>
        <div class="pro_project_pitch_uploaded_inner clearfix">

            <h4>Your project has been saved but if you <text style="font-weight: bold;">want to accept</text> your payments you need to Connect your stripe account</h4><br />
            <a class="pro_stript_btn" href="{{ $stripeUrl }}"></a><br /><br /><br />
        </div>
    </div>
</div>
<!-- Continue save profile without a connected atripe account  -->

<!-- Share Project to Social Media  -->
<div class="make_acc_in_secs pro_page_pop_up clearfix" >

    <div class="chart_share_proj_soc_med_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_project_pitch_uploaded_inner clearfix">

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
<div class="pro_products_max_limit pro_page_pop_up clearfix" id="star_your_music_prod_popup">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}" />
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_discon_text clearfix">
            <br />
            <h3>You Can Only Add 5 Items To Your User Page</h3><br />
            <span class="error"></span>
        </div>
        <div class="pro_products_max_limit_img clearfix">
            <img class="defer_loading" src="" data-src="{{ asset('images/dance_icon_002.png') }}">
        </div><br />
    </div>
</div>
<!-- More than 5 products not alloweed -->

<!-- Create new project -->
<div class="pro_create_new_project pro_page_pop_up clearfix" id="create_new_project_popup" >

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_create_new_project_inner clearfix">

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
            <div class="pro_submit_button_outer soc_con_submit_success clearfix">

                <a href="{{ asset("inactivateProject?id=" . $userCampaign->id) }}" id="submit_button">Okay</a>
            </div>
        </div>
    </div>
</div>
<!-- Create new project -->

<!-- Video Successfully Uploaded -->
<div class="pro_video_uploaded pro_page_pop_up clearfix" id="video_uploaded_popup" style="z-index: 10; {{ $videoUploadedDisplay }}">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_video_uploaded_inner clearfix">
            <br />
            <h3>Your video has successfully been uploaded</h3><br />
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
                <img class="each_video_upload_img defer_loading" src="" data-src="{{ asset('images/pop_google_icon.png') }}" onclick="googleShareUploadedVideo()">
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
$emailInitial = explode("@", $campUser->email);
?>

@if (Session::has('profile_saved'))
    <?php $firstTimeLoginDisplay = "display: block;"; ?>
@endif

<input type="hidden" name="useremailsharelink" id="useremailsharelink" value="{{ asset("/") . $emailInitial[0] }}">

<div class="pro_music_career_starts pro_page_pop_up clearfix" id="music_career_popup" style="z-index: 10; {{ $firstTimeLoginDisplay }}">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close firsttime_login_close"></i>
        </div>
        <div class="pro_music_career_starts_inner clearfix">
            <br />
            <h3>Your Audition TV profile has successfully been updated</h3><br />
            <center>
                <img class="pro_video_upload_img defer_loading" src="" data-src="{{ asset('images/dance_icon_004.png') }}"><br />
                <h3 class="pro_video_upload_txt_2">Tell everyone about The Audition</h3><br />
                <img class="each_video_upload_img defer_loading" src="" data-src="{{ asset('images/pop_face_icon.png') }}" onclick="shareOnFacebook();">
                <img class="each_video_upload_img defer_loading" src="" data-src="{{ asset('images/pop_google_icon.png') }}" onclick="shareOnGooglePlus();" >
                <img class="each_video_upload_img defer_loading" src="" data-src="{{ asset('images/pop_twitter_icon.png') }}" onclick="shareOnTwitter();" >
            </center>
        </div>
    </div>
</div>
<!-- Music Career Starts -->


<div class="pro_video_uploaded pro_page_pop_up clearfix" id="register_studio_popup_1" style="z-index: 10;">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_video_uploaded_inner clearfix">
            <br />
            <h3>You Must Be A Registered Studio Appearing On Google Maps.</h3><br />
            <center>
                <img class="pro_video_upload_img defer_loading" src="" data-src="{{ asset('images/studio_icon.png') }}"><br />
            </center>
            <h3>All Studios Appear In the Studios Tab. This cannot be changed once done.</h3><br />
        </div>


        <div class="pro_submit_button_outer soc_submit_success clearfix">

            <a style="cursor: pointer;" id="register_studio_yes_1">Change My Account To A Studio Account</a>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a style="cursor: pointer;" onclick="$('#register_studio_popup_1').hide();">No</a>
        </div>

    </div>
</div>



<div class="pro_video_uploaded pro_page_pop_up clearfix" id="register_studio_popup_2" style="z-index: 10;">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_video_uploaded_inner clearfix">
            <br />
            <h3>Are You Sure You Are A Studio?</h3><br />
            <center>
                <img class="pro_video_upload_img defer_loading" src="" data-src="{{ asset('images/studio_icon.png') }}"><br />
            </center>
            <h3>If You Are Not A Registered Studio Your Account Will Be Deleted.</h3><br />
        </div>


        <div class="pro_submit_button_outer soc_submit_success clearfix">

            <a style="cursor: pointer;" id="register_studio_yes_2">Yes</a>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a style="cursor: pointer;" onclick="$('#register_studio_popup_2').hide();">No</a>
        </div>

    </div>
</div>

<!-- Confirm Unsubscribe Pop-up  !-->
<div class="pro_confirm_unsubscribe_outer pro_page_pop_up clearfix" >

    <div class="pro_confirm_unsubscribe_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="pro_soc_top_close fa fa-close"></i>
            <br>
        </div>
        <div class="pro_confirm_delete_text clearfix">

            <h3>Your domain subscription will expire within 24 hrs. Are you sure you want to cancel your subscription?</h3>
            <br>
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_submit_success clearfix">

            <a onclick="unsubConfirmed()" data-id="" href="javascript:void(0)" id="pro_unsub_submit_yes">Yes</a>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a onclick="unsubCancelled()" href="javascript:void(0)" id="pro_confirm_unsub_submit_no">No</a>
        </div>
    </div>
</div>
<div class="pro_confirm_undomedia_outer pro_page_pop_up clearfix" >

    <div class="pro_confirm_undomedia_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
            <i class="pro_soc_top_close fa fa-close"></i>
            <br>
        </div>
        <div class="pro_confirm_delete_text clearfix">

            <h3>Are you sure you want to perform this action?</h3>
            <br>
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_submit_success clearfix">

            <a onclick="undoMediaConfirmed()" data-id="" href="javascript:void(0)" id="pro_unsub_submit_yes">Yes</a>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a onclick="undoMediaCancelled()" href="javascript:void(0)" id="pro_confirm_unsub_submit_no">No</a>
        </div>
    </div>
</div>
<!-- Confirm Unsubscribe Pop-up  !-->


