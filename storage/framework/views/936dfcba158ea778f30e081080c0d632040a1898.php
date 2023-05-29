<!-- Confirm Basket Delete Pop-up  !-->
<div class="pro_page_pop_up clearfix" id="top_basket_popup">
    <input type="hidden" name="basket_del_item_id" id="basket_del_item_id">

    <div class="pro_confirm_delete_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a style="opacity: 0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="<?php echo e(asset('images/1logo8.png')); ?>">
                <div>Platform</div>
            </a>
            <i class="fa fa-times" style="float: right;"></i>
        </div>
        <div class="pro_confirm_delete_text clearfix">

            <div class="main_headline">Are You Sure You Want To Delete This Item?</div><br>
            <span class="error"></span>
        </div>
        <div class="pro_confirm_box_outer pro_submit_button_outer soc_submit_success clearfix">

            <div class="delete_yes pro_confirm_box_each" id="basket_delete_submit_yes">YES</div>
            <div class="delete_no pro_confirm_box_each" onclick="$('#top_basket_popup,#body-overlay').hide()" id="pro_confirm_delete_submit_no">NO</div>
        </div> 
    </div>
</div>
<!-- Confirm Basket Delete Pop-up  !-->

<div class="pro_page_pop_up clearfix" id="add_item_free_popup" >

    <div class="pro_confirm_delete_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <div id="head">
                <div id="head_name">Keri Singer/Songwriter</div>
                <i onclick="$('#add_item_free_popup,#body-overlay').hide()" class="fa fa-times" style="float: right;"></i>
            </div>
        </div>
        <div id="body" class="clearfix">
            <div class="">
                This is free <span id="item_type">product</span>.<br>However you can support <span id="item_owner">Andrew</span> by naming a price for this item.
            </div>
            <div id="price_outer" class="">
                <div class="price_left">
                    Name your price:
                </div>
                <div class="price_right">
                    <div class="price_right_in">
                        <span id="currency">$</span><input type="text" id="price" />
                    </div>
                </div>
            </div>
            <div id="add_to" class="">Add To Basket</div>
        </div>
    </div>
</div>

<!-- Add to basket error Pop-up  !-->
<div class="pro_page_pop_up clearfix" id="basket_error_popup" style="z-index: 10;">
    <div class="pro_confirm_delete_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="<?php echo e(asset('images/1logo8.png')); ?>"><div>Platform</div></a>
            <i class="fa fa-times" style="float: right;"></i>
        </div>
        <div class="pro_confirm_delete_text clearfix">

            <p id="basket_error_message"></p>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix">
            <br>
            <a style="cursor: pointer;" onclick="$('#basket_error_popup,#body-overlay').hide()">Ok</a>
        </div>
    </div>
</div>
<!-- Add to basket error Pop-up  !-->

<?php if(Config('constants.primaryDomain') == $_SERVER['SERVER_NAME']): ?>
<!-- Not Logged In Pop-up !-->
<div class="remind_login_pop_up pro_page_pop_up clearfix" id="not_logged_in">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">
            <a style="opacity:0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="<?php echo e(asset('images/1logo8.png')); ?>"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="main_headline">It appears you're not logged in</div><br>
        <div class="login_separator slim">
            <div class="login_separator_left"></div>
            <div class="login_separator_center">1 Platform Account</div>
            <div class="login_separator_right"></div>
        </div>
        <input class="dummy_field" type="text" name="fakeusernameremembered">
        <input class="dummy_field" type="password" name="fakepasswordremembered">
        <input placeholder="Email address" type="text" id="reminder_login_email" />
        <div class="instant_hide error" id="reminder_email_error">Required</div>
        <input placeholder="Password" type="password" id="reminder_login_password" />
        <div class="instant_hide error" id="reminder_pass_error">Required</div>
        <br><br>
        <div id="submit_reminder_login" class="pro_button">LOGIN</div>
        <br>
        <div class="auth_social_logins_outer">
            <div class="login_register_text_02">
                <span>Creating an account with 1 Platform means you agree to our</span><br class="hide_on_mobile">
                <a href="<?php echo e(route('tc')); ?>">terms and conditions, </a>
                <a href="">privacy policy</a>
            </div>
        </div>
    </div>
</div>
<!-- Not Logged In Pop-up !-->
<?php endif; ?>

<!-- Login before apply Pop-up -->
<div class="pro_cannot_change_info pro_page_pop_up clearfix" id="login_before_apply_popup" style="z-index: 10;">

    <div class="pro_soc_discon_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="<?php echo e(asset('images/1logo8.png')); ?>"><div>Platform</div></a>
            <i class="fa fa-times" style="float: right;"></i>
        </div>
        <div class="pro_cannot_change_info_inner clearfix">

            <div class="header3">Wait!! you need to log in to apply</div><br />
            <br /><img alt="image popup" class="show_icon prevent_pre_loading" src="#" data-src="<?php echo e(asset('images/pupfillprofile.png')); ?>">
            <div class="pro_submit_button_outer soc_con_submit_success clearfix" onclick="window.location.href='<?php echo e(asset("/")); ?>'">

                <a style="cursor: pointer;" id="submit_button">Log In</a>
            </div>
        </div>
    </div>
</div>
<!-- Login before apply Pop-up -->

<div class="search_popup pro_page_pop_up" id="search_popup">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="<?php echo e(asset('images/1logo8.png')); ?>"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_con_face_username clearfix">

            <div class="header3">This page is having some exciting changes come back later</div><br>
        </div>
        <div style="width: 200px; margin: 0 auto;" class="pro_submit_button_outer soc_con_submit_success clearfix">
            <a href="javascript:void(0)" onclick="$('#search_popup,#body-overlay').hide();">Okay</a>
        </div>
    </div>
</div><?php /**PATH /opt/lampp/htdocs/platform/resources/views/parts/basket-popups.blade.php ENDPATH**/ ?>