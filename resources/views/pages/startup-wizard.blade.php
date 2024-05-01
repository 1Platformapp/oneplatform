
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
                            if(result.paymentMethod.id){
                                createSubscription(stripe, result.paymentMethod.id);
                            }else{
                                alert(result?.error?.message);
                                $('#pay_int_sub_final').removeClass('disabled');
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
                                                        Network Associates
                                                    </div>
                                                    <div class="int_sub_offer_each">
                                                        Legal Contracts
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
                                                            {{$packages[0]['network_limit']}}
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
                                                            {{$packages[1]['network_limit']}}
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
                                                            {{$packages[2]['network_limit']}}
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
                                        <a class="connect_stripe_skip" href="{{route('agency.dashboard')}}">Skip this step for now</a>
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
                    <input placeholder="Card Name" type="text" class="m_e_card_elem" id="int_sub_card_name" />
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
                    <div id="cc_master" class="flex items-center justify-center w-24 h-16 support_each_brand">
                        <img src="{{asset('cards/mastercard.png')}}" alt="Master Card" class="max-w-full max-h-full" />
                    </div>

                    <div id="cc_amex" class="flex items-center justify-center w-24 h-16 support_each_brand">
                        <i class="text-3xl fa fa-cc-amex"></i>
                    </div>

                    <div id="cc_visa" class="flex items-center justify-center w-24 h-16 support_each_brand">
                        <img src="{{asset('cards/visa.jpg')}}" alt="Visa Card" class="max-w-full max-h-full" />
                    </div>

                    <div id="cc_diners" class="flex items-center justify-center w-24 h-16 support_each_brand">
                        <i class="text-3xl fa fa-cc-diners-club"></i>
                    </div>

                    <div id="cc_discover" class="flex items-center justify-center w-24 h-16 support_each_brand">
                        <svg width="65px" height="65px" viewBox="0 -140 780 780" xmlns="http://www.w3.org/2000/svg" class="max-w-full max-h-full">
                            <g fill-rule="evenodd">
                                <path d="M54.992 0C24.627 0 0 24.63 0 55.004v390.992C0 476.376 24.619 501 54.992 501h670.016C755.373 501 780 476.37 780 445.996V55.004C780 24.624 755.381 0 725.008 0H54.992z" fill="#4D4D4D"/>
                                <path d="M327.152 161.893c8.837 0 16.248 1.784 25.268 6.09v22.751c-8.544-7.863-15.955-11.154-25.756-11.154-19.264 0-34.414 15.015-34.414 34.05 0 20.075 14.681 34.196 35.37 34.196 9.312 0 16.586-3.12 24.8-10.857v22.763c-9.341 4.14-16.911 5.776-25.756 5.776-31.278 0-55.582-22.596-55.582-51.737 0-28.826 24.951-51.878 56.07-51.878zm-97.113.627c11.546 0 22.11 3.72 30.943 10.994l-10.748 13.248c-5.35-5.646-10.41-8.028-16.564-8.028-8.853 0-15.3 4.745-15.3 10.989 0 5.354 3.619 8.188 15.944 12.482 23.365 8.044 30.29 15.176 30.29 30.926 0 19.193-14.976 32.553-36.32 32.553-15.63 0-26.994-5.795-36.458-18.872l13.268-12.03c4.73 8.61 12.622 13.222 22.42 13.222 9.163 0 15.947-5.952 15.947-13.984 0-4.164-2.055-7.734-6.158-10.258-2.066-1.195-6.158-2.977-14.2-5.647-19.291-6.538-25.91-13.527-25.91-27.185 0-16.225 14.214-28.41 32.846-28.41zm234.723 1.728h22.437l28.084 66.592 28.446-66.592h22.267l-45.494 101.686h-11.053l-44.687-101.686zm-397.348.152h30.15c33.312 0 56.534 20.382 56.534 49.641 0 14.59-7.104 28.696-19.118 38.057-10.108 7.901-21.626 11.445-37.574 11.445H67.414V164.4zm96.135 0h20.54v99.143h-20.54V164.4zm411.734 0h58.252v16.8H595.81v22.005h36.336v16.791h-36.336v26.762h37.726v16.785h-58.252V164.4zm71.858 0h30.455c23.69 0 37.265 10.71 37.265 29.272 0 15.18-8.514 25.14-23.986 28.105l33.148 41.766h-25.26l-28.429-39.828h-2.678v39.828h-20.515V164.4zm20.515 15.616v30.025h6.002c13.117 0 20.069-5.362 20.069-15.328 0-9.648-6.954-14.697-19.745-14.697h-6.326zM87.94 181.199v65.559h5.512c13.273 0 21.656-2.394 28.11-7.88 7.103-5.955 11.376-15.465 11.376-24.98 0-9.499-4.273-18.725-11.376-24.681-6.785-5.78-14.837-8.018-28.11-8.018H87.94z" fill="#FFF"/>
                                <path d="m415.13 161.21c30.941 0 56.022 23.58 56.022 52.709v0.033c0 29.13-25.081 52.742-56.021 52.742s-56.022-23.613-56.022-52.742v-0.033c0-29.13 25.082-52.71 56.022-52.71zm364.85 127.15c-26.05 18.33-221.08 149.34-558.75 212.62h503.76c30.365 0 54.992-24.63 54.992-55.004v-157.62z" fill="#F47216"/>
                            </g>
                        </svg>
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
