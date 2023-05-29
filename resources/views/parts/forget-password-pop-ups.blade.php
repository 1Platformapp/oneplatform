<?php
/**
 * Created by PhpStorm.
 * User: Ahsan Hanif
 * Date: 11-Oct-17
 * Time: 9:26 AM
 */
$verifyEmailDisplay = "";
?>

@if (Session::has('error'))
    <?php $verifyEmailDisplay = "display: block;";?>
@endif

<!-- Forget Password Response Pop-up  !-->
<div class="forget_pass_popup_response_outer pro_page_pop_up clearfix" >

    <div class="forget_pass_popup_response_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="forget_pass_popup_email_cont clearfix">

            <h3>Reset Your Password</h3><br>
            <div class="forget_pass_response" id="success">An email has been sent to your email address so you can reset your password</div>
            <div class="forget_pass_response" id="error">We can't find a user with that e-mail address</div>
        </div>
    </div>
</div>
<!-- Forget Password response Pop-up  !-->

<!-- Forget Password Pop-up  !-->
<div class="forget_pass_popup_outer pro_page_pop_up clearfix" >

    <div class="forget_pass_popup_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="forget_pass_popup_email_cont clearfix">

            <h3>Forgot Your Password</h3><br>
            <input placeholder="Email Address" type="text" id="forget_pass_popup_email_val" value="" />
            <span class="error" style="font-size: 12px;"></span>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a href="#" id="forget_pass_popup_submit" class="forget_pass_popup_submit">Reset Password</a>
        </div>
    </div>
</div>
<!-- Forget Password Pop-up  !-->




<!-- Video Successfully Uploaded -->
<div class="pro_reset_password pro_page_pop_up clearfix" id="reset_pwd_popup" style="z-index: 10;">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_reset_password_inner clearfix">
            <h3>Forgot Your Password</h3><br />
            <input type="text" class="pro_reset_pass_field" placeholder="example@gmail.com" />
            <center>
                <h6 id="error" style="display: none;">We can't find a user with that email address</h6><br />
                <div class="pro_submit_button_outer soc_con_submit_success clearfix">

                    <a style="font-size: 15px; cursor: pointer;" id="submit_button">Reset Password</a>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- Video Successfully Uploaded -->

<!-- Video Successfully Uploaded -->
<div class="pro_video_uploaded pro_page_pop_up clearfix" id="inactive_account_popup" style="z-index: 10; {{ $verifyEmailDisplay }}">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_video_uploaded_inner clearfix">
            <h3>To login please verify your email.</h3><br />
            <center>
                <img class="pro_video_upload_img" src="{{ asset('images/verification-email-dance-icon.png') }}"><br />
            </center>
        </div>
    </div>
</div>
<!-- Video Successfully Uploaded -->
