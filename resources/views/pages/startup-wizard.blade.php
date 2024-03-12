
@extends('templates.basic-template')


@section('pagetitle') 1Platform Startup Wizard @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style>

        .p_appli { text-decoration: line-through; color: #dc3545 !important; }
        .coupon_row { position: relative; }
        .coupon_btn { position: absolute; top: 20px; right: 0; background: #818181; color: #fff; height: 35px; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0 10px; font-size: 12px; letter-spacing: 1px; }
        #pay_internal_subscription_popup .second_headline { font-size: 14px !important; }
        #p_price { color: #28a745; }
        .support_card_brands { margin-top: 20px; display: flex; flex-direction: row; align-items: center; justify-content: space-between; }
        .support_card_brands i { font-size: 45px; }
        .support_each_brand#cc_master { color: #D2691E; }
        .support_each_brand#cc_amex { color: royalblue; }
        .support_each_brand#cc_visa { color: #8A2BE2; }
        .support_each_brand#cc_diners { color: #3333ff; }
        .support_each_brand#cc_discover  { color: #e67e00; }
        .startup_back a { color: #000;text-decoration: none; font-size: 15px; }
        @media (min-width:320px) and (max-width: 767px) {

            .coupon_btn { top: 15px; }
        }
        #pay_int_sub_final.disabled { opacity: 0.65; cursor: not-allowed; }
    </style>
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

	<script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">

        $('document').ready(function(){

        	var stripe = Stripe($('#stripe_publishable_key').val());
        	var elements = stripe.elements();

        	var baseStyles = {'fontFamily': 'Open sans, sans-serif','fontSize': '14px','color': '#000','lineHeight': '31px'};
        	var invalidStyles = {'color': '#fc064c'};

        	var eCardNumber = elements.create('cardNumber', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
        	var eCardCvc = elements.create('cardCvc', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
        	var eCardExpiry = elements.create('cardExpiry', {'style': {'base': baseStyles, 'invalid': invalidStyles}});

        	eCardNumber.mount('#m_e_card_number');
        	eCardCvc.mount('#m_e_card_cvc');
        	eCardExpiry.mount('#m_e_card_expiry');

            var browserWidth = $( window ).width();
            if( browserWidth < 767 ) {

                $('.pro_hover').removeClass('pro_hover');
            }

            $('.int_sub_pay').click(function(){

                $('#pay_internal_subscription_popup .error').addClass('instant_hide');
            	var p = $(this).closest('.int_sub_each').find('.int_sub_term_each.active');

            	if(p.length){

                    $('.int_sub_pay.active').removeClass('active');
                    $(this).addClass('active');
            		var term = p.attr('data-term');
            		var name = p.attr('data-name');
            		var price = p.attr('data-price');

            		if(term != '' && name != ''){

                        $('#pay_int_sub_price').removeClass('p_appli');
                        $('#p_price').addClass('instant_hide');
                        $('#int_sub_voucher_code').val('');
            			$('#pay_internal_subscription_popup #pay_int_sub_plan').text(name);
            			$('#pay_internal_subscription_popup #pay_int_sub_price').text('£'+price+' / '+term);
            			$('#pay_internal_subscription_popup, #body-overlay').show();
            		}else{
            			alert('Package invalid');
            		}
            	}else{

            		alert('Choose a package');
            	}
            });

            $('.coupon_btn').click(function(e){

                $('#m_e_error').addClass('instant_hide');
                var discountCode = $('#int_sub_voucher_code');
                $('#pay_int_sub_price').removeClass('p_appli');
                $('#p_price').addClass('instant_hide');

                if(discountCode.val() == ''){

                }else{
                    var originalPrice = $('#pay_int_sub_price').text();
                    var formData = new FormData();
                    formData.append('code', discountCode.val());
                    formData.append('original_price', originalPrice);
                    $('#pay_int_sub_final').addClass('busy');
                    $.ajax({

                        url: '/check-voucher-code',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        enctype: 'multipart/form-data',
                        processData: false,
                        dataType: "json",
                        success: function (response) {

                            $('#pay_int_sub_final').removeClass('busy');
                            if(response.success){

                                var p = $('#pay_int_sub_price').text().split('/');
                                var term = p.slice(-1)[0].trim();
                                $('#pay_int_sub_price').addClass('p_appli');
                                $('#p_price').text('£'+response.final_price+' / '+term).removeClass('instant_hide');
                            }else{
                                $('#m_e_error').removeClass('instant_hide').text(response.error);
                            }
                        },
                        error: function (response) {
                            $('#pay_int_sub_final').removeClass('busy');
                        }
                    });
                }
            });

            // $('.int_sub_free').click(function(e){

            //     e.preventDefault();
            //     if(confirm('Are you sure?')){

            //         var error = 0;

            //         if($(this).hasClass('busy')){

            //             return false;
            //         }

            //         if(!error){

            //             createSubscription(stripe, null, 'purchase_free');
            //         }else{

            //         }
            //     }
            // });

            $('body').delegate('#pay_int_sub_final:not(.disabled)', 'click', function(e){

            	e.preventDefault();

            	if($(this).hasClass('busy')){

            		return false;
            	}

            	var error = 0;
            	var cardName = $('#int_sub_card_name');
                var discountCode = $('#int_sub_voucher_code');
            	$('#m_e_error').addClass('instant_hide');
            	if(cardName.val() == ''){
            		$('#m_e_error').removeClass('instant_hide').text('Card name is required');
            	}else{
            		$('#pay_int_sub_final').addClass('disabled');
            		stripe
                        .createPaymentMethod({
                            type: 'card',
                            card: eCardNumber,
                            billing_details: {
                                name: cardName.val(),
                            },
                        })
                        .then((result) => {
                            if(result.error){
                                alert(result.error.message);
                                $('#pay_int_sub_final').removeClass('disabled');
                            }else{
                                createSubscription(stripe, result.paymentMethod.id);
                            }
                        })
            	}
            });
        });

        function validateCardNumber(number) {

            var regex = new RegExp("^[0-9]{16}$");
            if (!regex.test(number))
            return false;
            return luhnCheck(number);
        }

        function luhnCheck(val) {

            var sum = 0;
            for (var i = 0; i < val.length; i++) {
                var intVal = parseInt(val.substr(i, 1));
                if (i % 2 == 0) {
                    intVal *= 2;
                    if (intVal > 9) {
                        intVal = 1 + (intVal % 10);
                    }
                }
                sum += intVal;
            }

            return (sum % 10) == 0;
        }

        function createSubscription(stripe, paymentMethodId = null, action = '', internalId = null){

            var p = $('.int_sub_pay.active').closest('.int_sub_each').find('.int_sub_term_each.active');
            var term = p.attr('data-term');
            var name = p.attr('data-name');
            var price = p.attr('data-price');
            var discountCode = $('#int_sub_voucher_code');
            var cardName = $('#int_sub_card_name');

            fetch('/processInternalSubscription', {
                method: 'post',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    paymentMethodId: paymentMethodId,
                    package: name+'_'+price+'_'+term,
                    discount: discountCode.val(),
                    cardName: cardName.val(),
                    action: action,
                    internalId: internalId,
                }),
            })
            .then(function(data){
                return data.json();
            })
            .then(function(result){
                if(result.error != ''){
                    alert(result.error);
                    $('#pay_int_sub_final').removeClass('disabled');
                }else{
                	if(paymentMethodId){
                		if(result.data.subscription_status == 'active'){
                	        location.reload();
                	    }else if(result.data.subscription_status == 'incomplete'){
                	    	if(result.data.subscription_payment_intent_status == 'requires_action' || result.data.subscription_payment_intent_status == 'requires_source_action'){
                	    	    window.internal_subscription_id = result.data.internal_subscription_id;
                	    	    stripe
                	    	        .confirmCardPayment(result.data.subscription_payment_intent_client_secret,{
                	    	            payment_method: paymentMethodId,
                	    	        })
                	    	        .then((result2) => {
                	    	            if(result2.error){
                	    	                alert(result2.error.message);
                	    	                $('#pay_int_sub_final').removeClass('disabled');
                	    	            }else{
                	    	                if(result2.paymentIntent.status == 'succeeded'){
                	    	                    createSubscription(stripe, null, 'update_internal', window.internal_subscription_id);
                	    	                    location.reload();
                	    	                }else{
                	    	                	alert('Error: retried payment with status: '+result2.paymentIntent.status);
                	    	                	$('#pay_int_sub_final').removeClass('disabled');
                	    	                }
                	    	            }
                	    	        })
                	    	}else if(result.data.subscription_payment_intent_status == 'requires_payment_method' || result.data.subscription_payment_intent_status == 'requires_source'){
                	    	    alert('The card you provided cannot be charged. Try another card');
                	    	    location.reload();
                	    	}else{
                	    	    location.reload();
                	    	}
                	    }else{

                	    	alert('Error: '+result.data.subscription_status);
                	    	$('#pay_int_sub_final').removeClass('disabled');
                	    }
                	}else{
                		location.reload();
                	}
                }
            })
        }

    </script>
@stop

<!-- Page Header !-->
@section('header')
    @include('parts.header')
@stop

@section('flash-message-container')


@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')
@stop


@section('page-content')

    @if(!isset($action))
        @if($user)
            @if($user->internalSubscription && $user->internalSubscription->subscription_status == 1)
                @php $step = 3; @endphp
            @else
                @php $step = 2; @endphp
            @endif
        @else
            @php $step = 1; @endphp
        @endif
    @elseif($action == 'upgrade-subscription')
        @php $step = 2; @endphp
    @endif

    @php $packages = config('constants.user_internal_packages') @endphp
    <div class="hm_video_sec_outer">

        <div class="video_upper_sec">
            <div class="auto_content">

                <div class="startup_wizard_outer">
                    <div class="startup_wizard_inner">
                        @if(!isset($action))
                        <div class="startup_wizard_head">
                            <div class="wizard_head_each_step complete">
                                <div class="wizard_head_step_left">1</div>
                                <div class="wizard_head_step_right">
                                    <div class="wizard_head_step_right_top">Step 1</div>
                                    <div class="wizard_head_step_right_top">Submit Your Details</div>
                                </div>
                                <div class="wizard_head_step_ok"><i class="fa fa-check-circle"></i></div>
                            </div>
                            <div class="wizard_head_each_step {{$step == '2' ? 'current' : 'complete'}}">
                                <div class="wizard_head_step_left">2</div>
                                <div class="wizard_head_step_right">
                                    <div class="wizard_head_step_right_top">Step 2</div>
                                    <div class="wizard_head_step_right_top">Select Your Subscription Plan</div>
                                </div>
                                @if($step > 2)
                                    <div class="wizard_head_step_ok"><i class="fa fa-check-circle"></i></div>
                                @endif
                            </div>
                            <div class="wizard_head_each_step {{$step == '3' ? 'current' : ''}}">
                                <div class="wizard_head_step_left">3</div>
                                <div class="wizard_head_step_right">
                                    <div class="wizard_head_step_right_top">Step 3</div>
                                    <div class="wizard_head_step_right_top">Connect Your Stripe/PayPal Account</div>
                                </div>
                                @if($step > 3)
                                <div class="wizard_head_step_ok"><i class="fa fa-check-circle"></i></div>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($backBtnUrl != '')
                        <div class="startup_back">
                            <a href="{{$backBtnUrl}}">
                                <i class="fa fa-arrow-left"></i>&nbsp;Back
                            </a>
                        </div>
                        @endif
                        <div class="startup_wizard_body">
                            <div class="startup_wizard_each_content">
                                @if($step == '2')
                                    <div class="int_sub_main_head">Find the Perfect Plan for Your Team</div>
                                    <div class="int_sub_main_head_jun">
                                        Browse our subscription and single song pricing plans below
                                    </div>

                                    <div class="int_sub_outer">
                                        <div class="int_sub_inner">
                                            <div class="int_sub_nav_outer hide_on_desktop">
                                                <div class="int_sub_nav_btn int_nav_btn_prev">
                                                    <i class="fa fa-caret-left"></i>
                                                </div>
                                                <div class="int_sub_nav_btn int_nav_btn_next">
                                                    <i class="fa fa-caret-right"></i>
                                                </div>
                                            </div>
                                            <div class="int_sub_liner">
                                                <div class="int_sub_head">
                                                    <div class="int_sub_head_up">Subscriptions</div>
                                                </div>

                                                <div class="int_sub_dhead">Price</div>
                                                <div class="int_sub_offer_outer">
                                                    <div class="int_sub_offer_each"><span><span class="hide_on_mobile">Choose </span>Payment Plan</span></div>
                                                    <div class="int_sub_offer_each">&nbsp;</div>
                                                    <div class="int_sub_offer_each">
                                                        <span>Fee Per Sale </span>
                                                        <a href="https://stripe.com/gb/pricing" target="_blank">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                                                                <path fill="currentColor" fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0a8 8 0 0 1 16 0m-7 4a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-1-9a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1" clip-rule="evenodd"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="int_sub_offer_each">
                                                        <span class="hide_on_mobile">Connect a&nbsp;</span>Custom Domain
                                                    </div>
                                                    <div class="int_sub_offer_each">
                                                        Max Disk Usage
                                                    </div>
                                                    <div class="int_sub_offer_each">
                                                        Free From Adverts
                                                    </div>
                                                    <div class="int_sub_offer_each">
                                                        <span class="hide_on_mobile">Access To&nbsp;</span>Industry Contacts
                                                    </div>
                                                    <div class="int_sub_offer_each">
                                                        Get Pro Agent
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="int_sub_act_outer">

                                                <div class="int_sub_each pro_hover">
                                                    <div class="int_sub_head">
                                                        <div class="int_sub_head_up">{{ucfirst($packages[0]['name'])}}</div>
                                                    </div>
                                                    <div class="int_sub_dhead solo">
                                                        <div class="inner">
                                                            <p>Free</p>
                                                        </div>
                                                    </div>
                                                    <div class="int_sub_offer_outer">
                                                        <div class="int_sub_offer_each">&nbsp;</div>
                                                        <div class="int_sub_offer_each int_sub_free">
                                                            <div class="int_sub_confirm">Default</div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            {{$packages[0]['application_fee']}}%
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_no">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            {{$packages[0]['volume']}}GB
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_no">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_no">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_no">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="int_sub_each pro_hover">
                                                    <div class="int_sub_head">
                                                        <div class="int_sub_head_up">{{ucfirst($packages[1]['name'])}}</div>
                                                    </div>
                                                    <div class="int_sub_dhead">
                                                        <div class="inner">
                                                            <sup>&pound;</sup>
                                                            <p>{{$packages[1]['pricing']['month']}}</p>
                                                        </div>
                                                        <div class="int_sub_dhead_interval">per month</div>
                                                    </div>
                                                    <div class="int_sub_offer_outer">
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_term_switch">
                                                                <div data-name="{{$packages[1]['name']}}" data-price="{{$packages[1]['pricing']['month']}}" data-term="month" class="int_sub_term_each active">Monthly</div>
                                                                <div data-name="{{$packages[1]['name']}}" data-price="{{$packages[1]['pricing']['year']}}" data-term="year" class="int_sub_term_each">Yearly</div>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_confirm int_sub_pay">Buy</div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            {{$packages[1]['application_fee']}}%
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_yes">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            {{$packages[1]['volume']}}GB
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_no">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_yes">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_no">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="int_sub_each pro_hover">
                                                    <div class="int_sub_head">
                                                        <div class="int_sub_head_up">{{ucfirst($packages[2]['name'])}}</div>
                                                    </div>
                                                    <div class="int_sub_dhead">
                                                        <div class="inner">
                                                            <sup>&pound;</sup>
                                                            <p>{{$packages[2]['pricing']['month']}}</p>
                                                        </div>
                                                        <div class="int_sub_dhead_interval">per month</div>
                                                    </div>
                                                    <div class="int_sub_offer_outer">
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_term_switch">
                                                                <div data-name="{{$packages[2]['name']}}" data-price="{{$packages[2]['pricing']['month']}}" data-term="month" class="int_sub_term_each active">Monthly</div>
                                                                <div data-name="{{$packages[2]['name']}}" data-price="{{$packages[2]['pricing']['year']}}" data-term="year" class="int_sub_term_each">Yearly</div>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_confirm int_sub_pay">Buy</div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            {{$packages[2]['application_fee']}}%
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_yes">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            {{$packages[2]['volume']}}GB
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_yes">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_yes">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="int_sub_offer_each">
                                                            <div class="int_sub_offer_yes">
                                                                <i class="fa fa-check"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($step == '3')
                                    <br><br>
                                    <div class="pro_note_2">
                                        <h2 class="note_head">
                                            Connect Stripe / PayPal account and start receiving monies
                                        </h2>
                                        <div class="note_body">
                                            <p>Without connecting a stripe/paypal account you can still add your musics, albums and products but you will not be able to sell anything.</p>
                                            <p>After you have connected, people can buy from your website and the money will go straight into your connected bank account.</p>
                                            <p>
                                                Click <a target="_blank" href="https://stripe.com/gb/connect">here</a> to learn about stripe connect or <a target="_blank" href="https://stripe.com/gb/pricing">here</a> to learn about stripe pricing.
                                            </p>
                                            <p>
                                                Click <a target="_blank" href="https://www.paypal.com/us/webapps/mpp/merchant-fees">here</a> to learn about PayPal pricing and click <a target="_blank" href="https://www.paypal.com/us/webapps/mpp/security/seller-protection">here</a> to learn about PayPal seller security policy
                                            </p>
                                            <p>When you connect your stripe/paypal account with 1Platform it implies you agree to our <a href="{{route('tc')}}">terms and conditions</a>.</p>
                                        </div>
                                    </div>
                                    <div class="connect_stripe_actions">
                                    	@if($stripeUrl != '')
                                    	<a class="connect_stripe_now" href="{{$stripeUrl}}">Connect a Stripe account now</a>
                                    	@else
                                    	<a class="connect_stripe_now" href="https://dashboard.stripe.com/dashboard">Your Stripe Dashboard</a>
                                    	@endif
                                        @if($paypalUrl != '')
                                    	<a class="connect_stripe_now" href="javascript:void(0)">Connect a PayPal account (Coming soon)</a>
                                    	@else
                                    	<a class="connect_stripe_now" href="https://paypal.com">Your PayPal Dashboard</a>
                                    	@endif
                                        <a class="connect_stripe_skip" href="{{route('profile')}}">Skip this step for now</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>!
@stop


@section('miscellaneous-html')

    <div class="clearfix pro_page_pop_up" id="pay_internal_subscription_popup">

        <div class="clearfix pro_soc_con_face_inner">

            <div class="clearfix soc_con_top_logo">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="stage_one">
                <div class="clearfix soc_con_face_username">
                    <div class="main_headline">Subscription Plan Payment</div>
                    <div class="second_headline">
	                    Package: <span id="pay_int_sub_plan"></span> - <span class="pro_text_dark" id="pay_int_sub_price"></span> <span id="p_price"></span>
	                </div>
	                <div id="m_e_error" class="instant_hide m_e_card_pop_error"></div>
                    <input class="dummy_field" type="text" name="fakeusernameremembered">
                    <input placeholder="Card Name" type="text" id="int_sub_card_name" />
                    <div id="m_e_card_number" class="m_e_card_elem m_e_card_pop"></div>
                    <div class="pro_pop_multi_row">
                        <div class="each_col">
                            <div id="m_e_card_cvc" class="m_e_card_elem m_e_card_pop"></div>
                        </div>
                        <div class="each_col">
                            <div id="m_e_card_expiry" class="m_e_card_elem m_e_card_pop"></div>
                        </div>
                    </div>
                    <div class="pro_pop_multi_row coupon_row">
                        <input class="dummy_field" type="text" name="fakeusernamepassword">
                        <input placeholder="Discount Voucher Code" type="text" id="int_sub_voucher_code" />
                        <div class="coupon_btn">Apply Voucher</div>
                    </div>

                </div>
                <br>
                <div id="pay_int_sub_final" class="pro_button">SUBMIT</div>
                <div class="support_card_brands">
                    <div id="cc_master" class="support_each_brand">
                        <i class="fa fa-cc-mastercard"></i>
                    </div>
                    <div id="cc_amex" class="support_each_brand">
                        <i class="fa fa-cc-amex"></i>
                    </div>
                    <div id="cc_visa" class="support_each_brand">
                        <i class="fa fa-cc-visa"></i>
                    </div>
                    <div id="cc_diners" class="support_each_brand">
                        <i class="fa fa-cc-diners-club"></i>
                    </div>
                    <div id="cc_discover" class="support_each_brand">
                        <i class="fa fa-cc-discover"></i>
                    </div>
                </div>
            </div>
            <div class="stage_two instant_hide">
                <div class="clearfix soc_con_face_username">
                    <div class="pro_pop_text_light">
                        An agreement has been sent to <span class="pro_text_dark" id="sender_name"></span>. The user will be offered to accept or reject this agreement.
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <input type="hidden" id="stripe_publishable_key" value="{{config('constants.stripe_key_public')}}">

    @if(Session::has('seller_first_things_first'))
        @php $showSellerCurrency = 'display: block;'; @endphp
        @php $suggestedUsername = Session::get('seller_first_things_first') @endphp
    @else
        @php $showSellerCurrency = ''; @endphp
        @php $suggestedUsername = '' @endphp
    @endif
    <div class="clearfix pro_default_currency in_progress pro_page_pop_up" style="z-index: 10;{{$showSellerCurrency}}" id="pro_default_currency">

        <div class="clearfix pro_soc_con_face_inner">

            <div class="clearfix soc_con_top_logo">

                <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
            </div><br>
            <div class="clearfix soc_con_twit_username">
                @php $ccounter = 0 @endphp
                <div class="main_headline">Start Your Exciting Selling Experience - But First Things First</div><br>
                @if($user->profile->default_currency == null)
                @php $ccounter++ @endphp
                <h5 style="font-size: 13px;">
                    {{$ccounter}}- The currency below will apply for your musics, products, albums, crowdfund bonuses, fan contributions and subscription. This should be the same currency you setup your stripe account with
                </h5>
                <br>
                <div class="">
                    <select id="pro_default_currency_value">
                        <option selected value="gbp">GBP</option>
                        <option value="usd">USD</option>
                        <option value="eur">EUR</option>
                    </select>
                </div><br />
                @endif
                @if($user->username == null)
                @php $ccounter++ @endphp
                <h5 style="font-size: 13px;">
                    {{$ccounter}}- Choose a unique username. This will be used in your website url (i.e https://{{Config('constants.primaryDomain')}}/{{$suggestedUsername}}). We have placed a default username for you
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
@stop
