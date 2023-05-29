<!-- Email Verification Pop-up  !-->
<?php $regPopupDisplay = "display: none;"?>
@if($activationSent != "")
    <?php $regPopupDisplay = "display: block;"?>
@endif
<div class="forget_pass_popup_outer pro_page_pop_up clearfix" style="{{ $regPopupDisplay }}">

    <div class="forget_pass_popup_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="forget_pass_popup_email_cont clearfix" style="text-align: left; margin-top: 30px;">

            <h3 style="text-align: left;">Email Verification</h3><br>
            <p>Your account has been created please follow the link in the confirmation email to activate your account</p>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">

            <a href="{{ asset("login") }}" id="forget_pass_popup_submit">Return To Sign In</a>
        </div>
    </div>
</div>
<!-- Email Verification Pop-up  !-->