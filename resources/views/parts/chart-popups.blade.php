@php $chartUser = Auth::check() ? Auth::user() : NULL @endphp

<!-- Connect Facebook Account  !-->
<div class="pro_soc_con_face_outer pro_page_pop_up clearfix" style="z-index: 10;" id="chart-sharing-popup-old">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_con_face_username clearfix">

            <div class="header3">Tell people about this amazing video!</div><br>
            <input placeholder="" id="show_link" type="text" class="show_link" value="" readonly />
            <span class="error"></span>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix" style="background: #fff;">

            <p style="color: #ff4d4d;">Share to social media</p>

            <img alt="image popup" class="prevent_pre_loading" src="#" data-src="{{ asset("img/facebook_share.png") }}" style="display: inline-block; width: 35px; padding-right: 10px; cursor: pointer;" onclick="return facebookShare('video')">
            <img alt="image popup" class="prevent_pre_loading" src="#" data-src="{{ asset("img/google_share.png") }}" style="display: inline-block; padding-right: 10px; cursor: pointer;" onclick="return googleShareVideo()">
            <img alt="image popup" class="prevent_pre_loading" src="#" data-src="{{ asset("img/twitter_share.png") }}" style="display: inline-block; width: 25px; cursor: pointer;" onclick="return twitterShare('video')">
        </div>
    </div>
</div>
<!-- Connect Facebook Account  !-->


<div class="pro_soc_con_face_outer pro_page_pop_up clearfix" id="chart-sharing-popup">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="soc_con_face_username clearfix">

            <div class="header3">Share Video With Your Friends</div><br>
        </div>
        <div class="pro_submit_button_outer soc_con_submit_success clearfix" style="background: #fff;">

            <img alt="image popup" class="prevent_pre_loading" src="#" data-src="{{ asset("images/share_to_fb.png") }}" onclick="return facebookShare('video')">
            <img alt="image popup" class="prevent_pre_loading" src="#" data-src="{{ asset("images/share_to_twitter.png") }}" onclick="return twitterShare('video')">
        </div>
    </div>
</div>

<div class="pro_soc_con_face_outer pro_page_pop_up clearfix" id="choose-music-license">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">

            <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="choose_music_license_outer"></div>
        <div class="choose_music_license_submit disabled">Add to cart</div>
    </div>
</div>

<div class="pro_soc_con_face_outer pro_page_pop_up clearfix" id="product_full_image_popup">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <img alt="Product Full Image" src="#" />
    </div>
</div>

<div class="pro_soc_con_face_outer pro_page_pop_up clearfix" style="z-index: 10;" id="new-features-popup">
    <div class="pro_soc_con_face_inner clearfix">
        <div class="soc_con_top_logo clearfix">
            <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
    </div>
    <div class="">
        <div class="soc_con_face_username clearfix">
            <div class="header3"><b>Coming Soon to 1Platform</b><br><br>Join our exciting new features TV &amp; Licensing</div><br>
        </div>
    </div>
</div>




<div class="pro_soc_con_face_outer pro_page_pop_up clearfix" style="z-index: 10;" id="user-follow-popup">
    <div class="pro_soc_con_face_inner clearfix">
        <div class="soc_con_top_logo clearfix">
            <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        @if(Auth::check() && isset($user) && $user && Auth::user()->isFollowerOf($user))
        <div class="follow_go_ahead">
            <div class="soc_con_face_username clearfix">
                <div class="header3">You are following this user</div><br>
            </div>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix">
                <a href="javascript:void(0)" onclick="$('#user-follow-popup .pro_soc_top_close').click()">Okay</a>
            </div>
        </div>
        @elseif(Config('constants.primaryDomain') == $_SERVER['SERVER_NAME'])
        <div class="follow_authenticator {{Auth::check()?'instant_hide':''}}">
            <div class="soc_con_face_username clearfix">
                <div class="header3">It appears you are not logged in!</div><br>
                <span class="error_span instant_hide"></span>
                <input placeholder="Your Email Address" type="text" id="follow_login_email" /><br><br>
                <input placeholder="Your Password" type="password" id="follow_login_password" /><br><br>
            </div>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix">
                <a href="javascript:void(0)" id="follow_login_submit">Login</a>
            </div><br>
            <div class="header3">Don't have an account? <a href="{{route('register')}}">Signup</a></div>
        </div>
        <div class="follow_go_ahead {{Auth::check()?'':'instant_hide'}}">
            <div class="soc_con_face_username clearfix">
                <div class="header3">Tell people about this amazing artist!</div><br>
                <span class="error_span instant_hide"></span>
                <textarea id="follow_message" style="padding: 3px;" placeholder="Write something about this artist"></textarea>
            </div>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix">
                <a href="javascript:void(0)" id="follow_submit">
                    Follow
                </a>
            </div>
        </div>
        @else
        <div class="follow_go_ahead">
            <div class="soc_con_face_username clearfix">
                <div class="header3">You cannot follow this user on this domain</div><br>
            </div>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix">
                <a href="javascript:void(0)" onclick="$('#user-follow-popup .pro_soc_top_close').click()">Okay</a>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="pro_fill_outer pro_page_pop_up clearfix" style="z-index: 10;" id="project-payment-popup">
    <div class="pro_soc_con_face_inner clearfix">
        <div class="soc_con_top_logo clearfix">
            <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="project_fill_form instant_hide">
            <div class="soc_discon_text clearfix">

                <div class="header3">Wait!! You haven't filled all of the mandatory information</div><br />
                <span class="error"></span>
            </div>
            <div class="pro_fill_img clearfix">
                <img alt="image popup" class="prevent_pre_loading" src="#" data-src="{{ asset('images/pupfillprofile.png') }}">
            </div>
        </div>
        <div class="project_go_ahead instant_hide">
            <div class="soc_con_face_username clearfix">
                <div class="header3">Your Purchase Summary</div><br>
                <div class="pop_purchase_summary">
                    <div class="each_summary_item item_bonus clearfix">
                        <div class="summary_item_left">Bonus</div>
                        <div class="summary_item_right">0</div>
                    </div>
                    <div class="each_summary_item item_donation clearfix">
                        <div class="summary_item_left">Donation</div>
                        <div class="summary_item_right">0</div>
                    </div>
                    <div class="each_summary_item item_shipping clearfix">
                        <div class="summary_item_left">Shipping</div>
                        <div class="summary_item_right">0</div>
                    </div>
                    <div class="summary_footer">
                        <div class="summary_footer_item purchase_total clearfix">
                            <div class="summary_item_left">Purchase Total</div>
                            <div class="summary_item_right">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pro_submit_button_outer soc_con_submit_success clearfix">
                <a href="javascript:void(0)" id="project_final_submit">
                    Pay Now
                </a>
            </div>
        </div>
    </div>
</div>
<div class="pro_page_pop_up clearfix" id="bespoke_license_popup" data-music-id="">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">
            <a style="opacity:0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="stage_one">
            <div class="soc_con_face_username clearfix">
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
            <div class="soc_con_face_username clearfix">
                <div class="pro_pop_text_light">
                    Your proposal has been sent to <span class="pro_text_dark" id="sender_name"></span>. Go to <a href="{{route('profile.with.tab', ['tab' => 'chat'])}}" class="pro_text_dark">chat</a> to read replies or send more messages/details about your proposal.
                </div>  
            </div>
            <br>
        </div>
    </div>
</div>

<div class="pro_page_pop_up clearfix" id="chat_message_popup">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">
            <a style="opacity:0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="stage_one">
            <div class="soc_con_face_username clearfix">
                @guest
                <div class="main_headline">Login and send a message</div><br>
                <div class="login_separator slim">
                    <div class="login_separator_left"></div>
                    <div class="login_separator_center">1 Platform Account</div>
                    <div class="login_separator_right"></div>
                </div>
                <input class="dummy_field" type="text" name="fakeusernameremembered">
                <input class="dummy_field" type="password" name="fakepasswordremembered">
                <input placeholder="Email address" type="text" id="chat_message_login_email" />
                <div class="instant_hide error" id="chat_message_email_error">Required</div>
                <input placeholder="Password" type="password" id="chat_message_login_password" />
                <div class="instant_hide error" id="chat_message_pass_error">Required</div>
                @endguest 
                @auth
                <div class="main_headline">Send message and start a chat now</div><br>
                @endauth 
                <textarea id="chat_message" placeholder="Write your message here"></textarea>
                <div class="instant_hide error" id="chat_message_error">Required</div>
            </div>
            <br>
            <div id="send_chat_message" class="pro_button">SEND MESSAGE</div>
            <br>
            <div class="pro_pop_dark_note">
                <a class="inline_info" data-title="1 Platform: World's first bespoke licensing" href="https://www.youtube.com/embed/EksAIXYMEow?autoplay=0&origin={{config('constants.primaryDomain')}}&rel=0">How chat works?</a>
            </div>
        </div>
        <div class="stage_two instant_hide">
            <div class="soc_con_face_username clearfix">
                <div class="pro_pop_text_light">
                    Your message has been sent to <span class="pro_text_dark" id="sender_name"></span>. Go to <a href="{{route('profile.with.tab', ['tab' => 'chat'])}}" class="pro_text_dark">chat</a> to read replies or send more messages.
                </div>  
            </div>
            <br>
        </div>
    </div>
</div>
<div class="pro_page_pop_up new_popup clearfix" style="z-index: 10;" id="inline_info_popup">

    <div class="pro_soc_con_face_inner clearfix">

        <div style="padding: 10px 20px;" class="soc_con_top_logo clearfix">
            <a style="opacity:0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="pro_pop_head"></div>
        <div class="pro_pop_body">
            <br><br><br>
        </div>
    </div>
</div>
<div class="pro_page_pop_up clearfix" id="private_music_unlock_popup" data-type="" data-music-id="" data-mode="0">

    <div class="pro_soc_con_face_inner clearfix">

        <div class="soc_con_top_logo clearfix">
            <a style="opacity:0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="stage_one">
            <div class="soc_con_face_username clearfix">
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

<div class="pro_page_pop_up extend clearfix" id="pay_quick_popup">

    <div class="pro_soc_con_face_inner clearfix">
        <div class="soc_con_top_logo clearfix">
            <a style="opacity:0;" class="logo8">
                <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div id="pay_quick_error" class="instant_hide m_e_card_pop_error"></div>
        <div class="pay_item_details">
            <div class="pay_item_details_left">
                <div class="pay_item_thumb">
                    <img alt="Default thumbnail for item" src="{{asset('images/0011ff.png')}}">
                </div>
            </div>
            <div class="pay_item_details_right">
                <div class="pay_item_det_each pay_item_name"></div>
                <div class="pay_item_det_each pay_item_purchase_det"></div>
                <div class="pay_item_det_each pay_item_purchase_qua">
                    <div class="pay_item_purchase_qua_subt"><i class="fa fa-minus"></i></div>
                    <div class="pay_item_purchase_qua_num"></div>
                    <div class="pay_item_purchase_qua_add"><i class="fa fa-plus"></i></div>
                </div>
                <div class="pay_item_det_each pay_item_price"></div>
            </div>
        </div>
        <div class="stage_one">
            <div class="soc_con_face_username clearfix">
                <div class="login_separator slim">
                    <div class="login_separator_left"></div>
                    <div class="login_separator_center">Shipping Address</div>
                    <div class="login_separator_right"></div>
                </div>
                <div class="pro_pop_multi_row">
                    <div class="each_col">
                        <input class="dummy_field" type="text" name="fakeusernameremembered">
                        <input placeholder="Your Name" type="text" id="pay_quick_name" value="{{$chartUser ? $chartUser->name : ''}}" />
                    </div>
                    <div class="each_col">
                        <input class="dummy_field" type="text" name="fakeusernameremembered">
                        <input placeholder="Your Email" type="text" id="pay_quick_email" value="{{$chartUser ? $chartUser->email : ''}}">
                    </div>
                </div>
                <div class="pro_pop_multi_row">
                    <div class="each_col">
                        <input class="dummy_field" type="text" name="fakeusernameremembered">
                        <input placeholder="Address Line" type="text" id="pay_quick_shipping_address_line" />
                    </div>
                    <div class="each_col">
                        <input class="dummy_field" type="text" name="fakeusernameremembered">
                        <input placeholder="City" type="text" id="pay_quick_shipping_city" />
                    </div>
                </div>
                <div class="pro_pop_multi_row">
                    <div class="each_col">
                        <input placeholder="Postcode" type="text" id="pay_quick_shipping_postcode" />
                    </div>
                    <div class="each_col">
                        <input class="dummy_field" type="text" name="fakeusernamepassword">
                        <select id="pay_quick_shipping_country"></select>
                    </div>
                </div>
            </div>
            <br>
            <div id="pay_quick_proceed_checkout" class="pro_button">PROCEED TO CHECKOUT</div>
        </div>
        <div class="stage_two instant_hide">
            <div class="go_stage_one item_heading edit_shipping_address">
                <i class="fa fa-arrow-left"></i> Edit Shipping Address
            </div>
            <div class="login_separator slim">
                <div class="login_separator_left"></div>
                <div class="login_separator_center">Credit Card Details</div>
                <div class="login_separator_right"></div>
            </div>
            <div id="pay_quick_card_number" class="m_e_card_elem m_e_card_pop"></div>
            <div class="pro_pop_multi_row">
                <div class="each_col">
                    <input class="dummy_field" type="text" name="fakeusernameremembered">
                    <input placeholder="Card Name" type="text" id="pay_quick_card_name" />
                </div>
                <div class="each_col">
                    <div id="pay_quick_card_cvc" class="m_e_card_elem m_e_card_pop"></div>
                </div>
            </div>
            <div class="pro_pop_multi_row">
                <div id="pay_quick_card_expiry" class="m_e_card_elem m_e_card_pop"></div>
            </div>
            <br>
            <div class="login_separator slim">
                <div class="login_separator_left"></div>
                <div class="login_separator_center">Purchase Summary</div>
                <div class="login_separator_right"></div>
            </div>
            <div class="item_price_summary">
                <div class="item_price_each item_price_subtotal">
                    <div class="item_price_sec_title">Subtotal</div>
                    <div class="item_price_sec_val">
                        <div class="item_price_sec_val_sym"></div>
                        <div class="item_price_sec_val_num"></div>      
                    </div>
                </div>
                <div class="item_price_each item_price_shipping">
                    <div class="item_price_sec_title">Shipping</div>
                    <div class="item_price_sec_val">
                        <div class="item_price_sec_val_sym"></div>
                        <div class="item_price_sec_val_num"></div>       
                    </div>
                </div>
                <div class="item_price_each item_price_grand_total">
                    <div class="item_price_sec_title">Total To Pay</div>
                    <div class="item_price_sec_val">
                        <div class="item_price_sec_val_sym"></div>
                        <div class="item_price_sec_val_num"></div>      
                    </div>
                </div>
            </div><br>
            <div id="pay_quick_final" class="pro_button">SUBMIT</div>
        </div>
    </div>
</div>

<div class="pro_page_pop_up clearfix" id="sub_paypal_info">

    <div class="pro_soc_con_face_inner clearfix">
        <div class="soc_con_top_logo clearfix">
            <a style="opacity:0;" class="logo8">
                <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
            </a>
            <i class="fa fa-times pro_soc_top_close"></i>
        </div>
        <div class="stage_one">
        	<form action="{{isset($user) ? route('paypal.subscribe', ['id' => $user->id]) : ''}}" method="post">
        		{{csrf_field()}}
	            <div class="soc_con_face_username clearfix">
	                <div class="main_headline">PayPal Subscription</div>
	                <div class="second_headline">It appears you are not logged in. We need the following information in order to create an account for you to complete this action</div><br>
	                <div id="sub_paypal_info_error" class="instant_hide m_e_card_pop_error">Please fill all the information below</div>
	                <div class="pro_pop_multi_row">
	                    <div class="each_col">
	                        <input class="dummy_field" type="text" name="fakeusernameremembered">
	                        <input placeholder="Enter Your First Name" type="text" id="sub_paypal_info_first_name" name="first_name" />
	                    </div>
	                    <div class="each_col">
	                        <input class="dummy_field" type="text" name="fakeusernameremembered">
	                        <input placeholder="Enter Your Last Name" type="text" id="sub_paypal_info_last_name" name="last_name" />
	                    </div>
	                </div>
	                <div class="pro_pop_row">
	                    <input class="dummy_field" type="text" name="fakeusernameremembered">
	                    <input placeholder="Enter Your Email Address" type="text" id="sub_paypal_info_email" name="email" />
	                </div>
	            </div>
	            <br>
	            <div id="sub_paypal_info_proceed" class="pro_button">PROCEED</div>
	        </form>
        </div>
    </div>
</div>