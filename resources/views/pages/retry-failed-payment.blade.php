@extends('templates.advanced-template')

@section('pagetitle') Retry Your Failed Payment @endsection

@section('page-level-css')
    <link rel="stylesheet" href="{{asset('css/project.css')}}"></link>
    
    <style>

        .user_checkout_bonus { display: flex; align-items: center; flex-direction: row; margin-bottom: 15px; }
        .user_checkout_bonus_thumb img { max-width: 120px; }
        .user_checkout_bonus_det { margin-left: 10px; line-height: 30px; }
        .panel .project_name { text-align: unset !important; border-bottom: 1px solid #fff; padding-bottom: 5px }
        .user_checkout_total { font-size: 15px; border-top: 1px solid #fff; margin-top: 20px; padding-top: 35px; }
        .user_checkout_total .user_checkout_subtotal { margin-bottom: 10px; display: flex; flex-direction: row; justify-content: space-between; }
        .proj_notice_para { font-size: 14px; color: #fff; line-height: 22px; font-family: Open Sans, sans-serif; margin-top: 20px; }
        .proj_notice_head { margin-bottom: 5px; color: #fff; font-family: Open Sans, sans-serif; font-size: 16px; margin-top: 10px; border-bottom: 2px solid rgb(230, 230, 230); padding: 0 0 10px 0; }
        .proj_notice_head_two { background: #818181; color: #fff; padding: 6px; margin-top: 20px; }
        .failed_link { color: #5469d4; }
        .proj_cnter_story_sec_oter { min-height: 500px; }
        .failed_checkout_action_btn { margin-top: 55px; margin-bottom: 55px; padding: 8px; color: #fff; border: 1px solid #fff; text-align: center; text-transform: uppercase; cursor: pointer; }
        .failed_checkout_action_btn.disabled { opacity: 0.5; cursor: not-allowed; }
    </style>

@stop



@section('page-level-js')
    
    <script src="https://js.stripe.com/v3/"></script>

	<script type="text/javascript">
		
		$('document').ready(function(){

			var stripe = Stripe($('#stripe_publishable_key').val(), { stripeAccount: atob($('#connect_account_id').val())});
			var clientSecret = atob($('#intent_client_secret').val());
			var paymentMethodId = atob($('#intent_payment_method_id').val());

			if($('#proceed_new_payment').length){
				var elements = stripe.elements();
				var baseStyles = {'fontFamily': 'Open sans, sans-serif','fontSize': '14px','color': '#fff','lineHeight': '31px'};
				var invalidStyles = {'color': '#fc064c'};
				var eCardNumber = elements.create('cardNumber', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
				var eCardCvc = elements.create('cardCvc', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
				var eCardExpiry = elements.create('cardExpiry', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
				var elements = stripe.elements();
				var style = {
				    base: {'fontFamily': 'Open sans, sans-serif','fontSize': '14px','color': '#fff','lineHeight': '31px'},
				    invalid: {'color': '#fc064c'}
				};
				if($('#m_e_card_number').length){
					eCardNumber.mount('#m_e_card_number');
				}
				if($('#m_e_card_cvc').length){
					eCardCvc.mount('#m_e_card_cvc');
				}
				if($('#m_e_card_expiry').length){
					eCardExpiry.mount('#m_e_card_expiry');
				}

				$('body').delegate('#proceed_new_payment:not(.disabled)', 'click', function(e){

					if(confirm('Are you sure to proceed?')){

						if(validateCardDetails()){
							$('.failed_checkout_action_btn').addClass('disabled');
							initiatePayment(stripe, eCardNumber);
						}
					}
				});
			}else{
				$('body').delegate('#proceed_payment_attempt:not(.disabled)', 'click', function(e){

					if(confirm('Are you sure to proceed?')){

						$('.failed_checkout_action_btn').addClass('disabled');
						stripe.confirmCardPayment(clientSecret, {
						 	payment_method: paymentMethodId
						}).then(function(result) {
						 	if(result.error){
						    	alert(result.error.message);
						    	$('.failed_checkout_action_btn').removeClass('disabled');
						  	}else{
						  		var formData = new FormData();
						  		formData.append('intent', result.paymentIntent.id);
						  		retryPostPayment(formData);
						  	}
						});
					}
				});
			}
		});

		function retryPostPayment(formData){

		    $.ajax({
		        url: '/retry-post-payment',
		        type: 'POST',
		        data: formData,
		        contentType:false,
		        cache: false,
		        processData: false,
		        dataType: 'json',
		        success: function (response) {
		            if(response.success){
		                window.location = response.url;
		            }else{
		                alert(response.error);
		                $('.failed_checkout_action_btn').removeClass('disabled');
		            }
		        }
		    });
		}

		function initiatePayment(stripe, eCardNumber){

			var checkoutId = $('#checkout_id').val();
			var formData = new FormData();
			formData.append('customer', 'current');
			formData.append('type', 'crowdfund');
			formData.append('source', 'checkout_'+checkoutId);

			$.ajax({
			    url: '/prepare-fake-basket',
			    type: 'POST',
			    data: formData,
			    contentType:false,
			    cache: false,
			    processData: false,
			    dataType: 'json',
			    success: function (response) {
			        if(response.success){
			            
			            var paymentData = {
			                userdata: $('#monies_form').serialize(),
			                type: 'crowdfund',
			                failedcheckout: checkoutId
			            };

			            fetch('/prepare-payment',{
			                method: 'POST',
			                headers: {
			                    'Content-Type': 'application/json',
			                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			                },
			                body: JSON.stringify(paymentData)
			            })
			            .then(function(result){
			                return result.json();
			            })
			            .then(function(data){
			                payWithCard(stripe, eCardNumber, data.clientSecret);
			            });

			        }else{
			            alert(response.error);
			            $('.failed_checkout_action_btn').removeClass('disabled');
			        }
			    }
			});
		}

		function payWithCard(stripe, card, clientSecret){

			var checkoutId = $('#checkout_id').val();
		    stripe
		    .confirmCardPayment(clientSecret, {
		        payment_method: {
		            card: card
		        }
		    })
		    .then(function(result){
		        if(result.error){
		            $('.failed_checkout_action_btn').removeClass('disabled');
		            alert(result.error.message);
		        }else{
		            var formData = new FormData();
		            formData.append('intent', result.paymentIntent.id);
		            formData.append('userdata', $('#monies_form').serialize());
		            formData.append('type', 'crowdfund');
		            formData.append('failedcheckout', checkoutId);
		            postPayment(formData);
		        }
		    });
		}

		function postPayment(formData){

		    $.ajax({
		        url: '/post-payment',
		        type: 'POST',
		        data: formData,
		        contentType:false,
		        cache: false,
		        processData: false,
		        dataType: 'json',
		        success: function (response) {
		            if(response.success){
		                window.location = response.url;
		            }else{
		                alert(response.error);
		                $('.failed_checkout_action_btn').removeClass('disabled');
		            }
		        }
		    });
		}

		function validateCardDetails(){

			var success = true;
            var cardName = $('#card_holder_name');
            if(cardName.val() == ''){
            	success = false;
            	$('#m_e_error').removeClass('instant_hide').text(' (Card name is required)');
            }

            return success;
        }
	</script>   

@stop



@section('header')

    @include('parts.header')

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
            {{ (is_array(Session::get('success'))) ? Session::get('success')[0] : Session::get('success') }}
        </div>

    @endif

@stop



@section('social-media-html')


@stop


@section('audio-player')

    @include('parts.audio-player')

@stop


@section('top-center')
    
    <div class="ch_center_outer user_hm_center">

    	<h4 class="clearfix"> Retry your failed payment  </h4>
        <div class="proj_cnter_story_sec_oter btm_center_outer_checkout">
        	<div class="proj_notice_head">
                Decline Code: <a class="failed_link" target="_blank" href="https://stripe.com/docs/declines/codes">{{$checkout->error}}</a>
            </div>
            <div class="proj_notice_para">
                You don't need to worry about it. We will help you complete this checkout.
            </div>
            @if($paymentMethodDetails)
            <div class="proj_notice_head_two">Your Card Details</div>
            <div class="proj_notice_para">
                <i class="fa fa-credit-card"></i>&nbsp;&nbsp;
                {{isset($paymentIntent['metadata']['CardHolderName']) ? $paymentIntent['metadata']['CardHolderName'].' - ' : ''}}
                **** {{$paymentMethodDetails['card']['last4']}} - 
                {{$paymentMethodDetails['card']['exp_month']}} / 
                {{$paymentMethodDetails['card']['exp_year']}}
            </div>
            @endif
            <div class="proj_notice_head_two">Retry Payment</div>
            @if($checkout->error == 'authentication_required')
            <div class="proj_notice_para">
                As per your decline code, your card issuer need you to authenticate this payment before we could process it. Please click on the following button to complete this step.
            </div>
            <div id="proceed_payment_attempt" class="failed_checkout_action_btn">Authenticate</div>
            @elseif($checkout->error == 'approve_with_id' || $checkout->error == 'issuer_not_available' || $checkout->error == 'processing_error' || $checkout->error == 'reenter_transaction' || $checkout->error == 'try_again_later') 
            <div class="proj_notice_para">
                Your decline code suggests we can make an attempt for the payment again.
            </div>
            <div id="proceed_payment_attempt" class="failed_checkout_action_btn">Pay</div>
            @elseif($checkout->error == 'expired_card' || $checkout->error == 'incorrect_number' || $checkout->error == 'incorrect_cvc' || $checkout->error == 'incorrect_pin' || $checkout->error == 'incorrect_zip' || $checkout->error == 'insufficient_funds' || $checkout->error == 'invalid_cvc' || $checkout->error == 'invalid_expiry_month' || $checkout->error == 'invalid_expiry_year' || $checkout->error == 'invalid_number' || $checkout->error == 'invalid_pin' || $checkout->error == 'offline_pin_required' || $checkout->error == 'online_or_offline_pin_required' || $checkout->error == 'pin_try_exceeded' || $checkout->error == 'testmode_decline' || $checkout->error == 'withdrawal_count_limit_exceeded')
            <div class="proj_notice_para">
                Your decline code suggests you need to re enter your card details to make this payment successful.
            </div>
            <form id="monies_form" action="" method="post">
            	<div class="proj_cntr_contribut_sec_otr">
            		<ul>
            			<li>&nbsp;</li>
            			<li>
            			    <b>Credit Card Details * <span id="m_e_error" class="instant_hide"></span></b>
            			    <div class="proj_cont_flt_outer clearfix">
            			        <div class="proj_cont_left_inp_outer">
            			            <input type="text" placeholder="Name On Card" name="card_holder_name" id="card_holder_name"  />
            			        </div>
            			        <div id="m_e_card_number" class="proj_cont_right_inp_outer m_e_card_elem"></div>
            			    </div>
            			</li>
            			<li class="proj_credit_card_outer">
            			    <div class="proj_cont_flt_outer clearfix">
            			        <div id="m_e_card_cvc" class="proj_cont_left_inp_outer m_e_card_elem"></div>
            			        <div id="m_e_card_expiry" class="proj_cont_right_inp_outer m_e_card_elem"></div>
            			    </div>
            			</li>
            		</ul>
            	</div>
            	@php $metaData = $paymentIntent['metadata'] @endphp
            	@php $country = \App\Models\Country::where(['name' => $metaData['Country']])->first() @endphp
            	<input type="hidden" name="name" value="{{$metaData['FirstName']}}">
            	<input type="hidden" name="surname" value="{{$metaData['Surname']}}">
            	<input type="hidden" name="street" value="{{$metaData['Street']}}">
            	<input type="hidden" name="country" value="{{$country ? $country->id : 0}}">
            	<input type="hidden" name="city" value="{{$metaData['City']}}">
            	<input type="hidden" name="zip" value="{{$metaData['Postcode']}}">
            	<input type="hidden" name="comment" value="{{$metaData['Comment']}}">
            	<input type="hidden" name="delivery_cost" value="{{$metaData['DeliveryCost']}}">
            </form>
            <div id="proceed_new_payment" class="failed_checkout_action_btn">Pay</div>
            @elseif($checkout->error == 'call_issuer' || $checkout->error == 'card_not_supported' || $checkout->error == 'card_velocity_exceeded' || $checkout->error == 'currency_not_supported' || $checkout->error == 'do_not_honor' || $checkout->error == 'do_not_try_again' || $checkout->error == 'invalid_account' || $checkout->error == 'invalid_amount' || $checkout->error == 'new_account_information_available' || $checkout->error == 'no_action_taken' || $checkout->error == 'not_permitted' || $checkout->error == 'pickup_card' || $checkout->error == 'restricted_card' || $checkout->error == 'revocation_of_all_authorizations' || $checkout->error == 'revocation_of_authorization' || $checkout->error == 'security_violation' || $checkout->error == 'service_not_allowed' || $checkout->error == 'transaction_not_allowed')
            <div class="proj_notice_para">
                Your decline code suggests you should contact your card issuer and mention your decline code to them.
            </div>
            @elseif($checkout->error == 'fraudulent' || $checkout->error == 'generic_decline' || $checkout->error == 'lost_card' || $checkout->error == 'merchant_blacklist' || $checkout->error == 'stolen_card' || $checkout->error == 'stop_payment_order')
            <div class="proj_notice_para">
                Your decline code suggests we can do nothing to make this payment successful.
            </div>
            @else
            <div class="proj_notice_para">
                Your decline code is not known to us.
            </div>
            @endif
        </div>
    </div>

@stop



<!-- Right Bar !-->

@section('top-right')

    

@stop



<!-- Left Bar !-->

@section('top-left')

    <div class="ch_tab_sec_outer">

        <div class="panel">
            <h2 class="project_name">Your Checkout On {{date('d/m/Y h:s A', strtotime($checkout->created_at))}}</h2>
            <br><br>
            <div class="cart_items_outer">
                <div class="user_musics_outer">
                    <div class="music_main_outer">
                        @php $subtotal = $shipping = 0 @endphp
                        @foreach($checkout->crowdfundCheckoutItems as $item)
                            @php $currSym = $commonMethods->getCurrencySymbol($checkout->currency) @endphp
                            @if($item->type == 'bonus' && $item->bonus)
                                <div class="user_checkout_bonus">
                                    <div class="user_checkout_bonus_thumb">
                                        <img src="{{asset('user-bonus-thumbnails').'/'.$item->bonus->thumbnail}}">
                                    </div>
                                    <div class="user_checkout_bonus_det">
                                        <div class="user_checkout_bonus_name">
                                            {{$item->name}}
                                        </div>
                                        <div class="user_checkout_bonus_price">
                                            {{$currSym.$item->price}}
                                        </div>
                                    </div>
                                </div>
                            @elseif($item->type == 'donation')
                                <div class="user_checkout_bonus">
                                    <div class="user_checkout_bonus_thumb">
                                        <img src="">
                                    </div>
                                    <div class="user_checkout_bonus_det">
                                        <div class="user_checkout_bonus_name">
                                            Donation to {{$checkout->user->name}}
                                        </div>
                                        <div class="user_checkout_bonus_price">
                                            {{$currSym.$item->price}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @php $subtotal += $item->price @endphp
                            @php $shipping += $item->delivery_cost @endphp
                        @endforeach
                        <div class="user_checkout_total">
                            <div class="user_checkout_subtotal">
                                <div class="sub_each">
                                    Sub Total
                                </div>
                                <div class="sub_each">
                                    {{$currSym.$subtotal}}
                                </div>
                            </div>
                            <div class="user_checkout_subtotal">
                                <div class="sub_each">
                                    Shipping
                                </div>
                                <div class="sub_each">
                                    {{$currSym.$shipping}}
                                </div>
                            </div>
                            <div class="user_checkout_subtotal">
                                <div class="sub_each">
                                    Grand Total
                                </div>
                                <div class="sub_each">
                                    {{$currSym.$checkout->amount}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop



@section('bottom-row-full-width')

@stop

@section('miscellaneous-html')

    <div id="body-overlay"></div>
    <input type="hidden" id="stripe_publishable_key" value="{{config('constants.stripe_key_public')}}">
    <input type="hidden" id="connect_account_id" value="{{base64_encode($checkout->user->profile->stripe_user_id)}}">
    <input type="hidden" id="intent_client_secret" value="{{base64_encode($paymentIntent['client_secret'])}}">
    <input type="hidden" id="intent_payment_method_id" value="{{$paymentMethodDetails ? base64_encode($paymentIntent['charges']['data'][0]['payment_method']) : ''}}">
    <input type="hidden" id="checkout_id" value="{{$checkout->id}}">
@stop