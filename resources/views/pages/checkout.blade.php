@extends('templates.advanced-template')

@section('pagetitle') {{$user->name}} - Checkout @endsection

@section('page-level-css')
    
    <link rel="stylesheet" href="{{asset('css/project.css?v=2.2')}}"></link>
    <link rel="stylesheet" href="{{asset('css/checkout.css?v=1.7')}}"></link>
    <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}"></link>
    
    @if($user->isCotyso() && $user->home_layout == 'background')
        <link rel="stylesheet" href="{{asset('css/user_home_background.min.css')}}"></link>
    @endif

    <style type="text/css">
        .stripe_power { display: flex; align-items: center; justify-content: flex-end; }
        .stripe_power a { display: block; width: 275px; margin-top: 25px; margin-bottom: 60px; }
        .proj_tect_area_cotyso { border-bottom: 1px dashed #fff; margin-bottom: 50px; }
        
        @media(min-width:320px) and (max-width:767px){
            .stripe_power { justify-content: center; }
            .stripe_power a { margin-bottom: 30px; }
            .proj_tect_area_cotyso b { text-align: center; }
        }
    </style>
@stop



<!-- Page Level Javascript !-->

@section('page-level-js')
    
    @if($user->isCotyso() && $user->home_layout == 'background')
        <script src="{{ asset('js/user_home_background.min.js') }}"></script>
    @endif

    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <script type="application/javascript">

        $(document).ready(function(){

        	$('select[name="country"]').select2();

            var stripe = Stripe($('#stripe_publishable_key').val(), { stripeAccount: $('#connect_account_id').val()});
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

            $('.proj_cont_each_det:not(.disabled)').click(function(){

                var thiss = $(this);
                if(thiss.attr('data-payment-mode') == 'paypal'){
                    $('.credit_card_details,.proj_credit_card_outer').slideUp('slow');
                }else if(thiss.attr('data-payment-mode') == 'stripe'){
                    $('.credit_card_details,.proj_credit_card_outer').slideDown('slow');
                }

                $('#payment_method').val(thiss.attr('data-payment-mode'));
                $('.proj_cont_each_det').removeClass('active');
                thiss.addClass('active');
            });

            if($('#monies_submit').length){
                var formButton = document.getElementById('monies_submit');
                formButton.addEventListener('click', function(event){
                    event.preventDefault();
                    var valid = validatePaymentForm();
                    if(!valid){
                        $('#fill_form_popup,#body-overlay').show();
                    }else{
                        if($('#payment_method').val() == 'stripe' && $('.proj_cont_each_det.active').attr('data-payment-mode') == 'stripe'){

                            initiatePayment(stripe, eCardNumber);
                        }else if($('#payment_method').val() == 'paypal' && $('.proj_cont_each_det.active').attr('data-payment-mode') == 'paypal'){
                            document.getElementById('spinner').classList.remove('hidden');
                            document.getElementById('monies_submit').disabled = true;

                            var paymentData = {
                                userdata: $('#monies_form').serialize(),
                                type: 'instant'
                            };
                            fetch('/paypal/prepare-order',{
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
                                if(data.success == '1'){
                                    window.location.href = data.redirectUrl;
                                }else{
                                    document.getElementById('spinner').classList.add('hidden');
                                    document.getElementById('monies_submit').disabled = false;
                                    alert(data.error);
                                }
                            });
                        }else if(parseFloat($('#total_cost').val()) == 0){
                            var paymentData = {
                                userdata: $('#monies_form').serialize(),
                                paymentMethod: null,
                                type: 'instant'
                            };
                            proceedPreparePayment(paymentData, null, null);
                        }else{

                            alert('Choose your payment method');
                        }
                    }
                });

            }

            $('#not_logged_in').remove();
            
            musicHoverSupport();

            var browserWidth = $( window ).width();
            if( browserWidth <= 767 ) {

                $('.shopping_cart_outer').appendTo('#shopping_cart_filler');
                $('.shopping_suggest_outer').appendTo('#shopping_suggest_filler');
                $('.checkout_outer').appendTo('#checkout_filler');
            }

            $('.tot_usd_sec').data('pre', $('#original_currency').val());

            updateCosting($('#country').val());

            $('#country').change(function () {

                updateCosting($(this).val());
            });

            $(".tot_usd_sec").change(function () {

                var from = $(this).data('pre');//get the pre data

                var to = $(this).val();

                var delCost = 0;

                if($("#user_country").val() == $("#country").val()){

                    delCost = $("#local_cost_" + to).val();

                }


                if($("#country").val() != "" && $("#user_country").val() != $("#country").val()){

                    delCost = $("#international_cost_" + to).val();

                }

                var amount = parseFloat( $("#total_cost_" + to).val() ) + parseFloat(delCost);



                var symbol = "$";

                if(to == "GBP"){

                    symbol = "£";

                }

                if(to == "EUR"){

                    symbol = "€";

                }

                $("#total_cost").val(amount.toFixed(2));

                $("#shipping_cost_area").text(symbol + parseFloat(delCost).toFixed(2));

                $("#delivery_cost").val(parseFloat(delCost).toFixed(2));



                $(this).data('pre', $(this).val());//update the pre data

            });

            $('#cart_scrutiny').click(function(){

                var browserWidth = $( window ).width();
                if(browserWidth <= 767){
                    $('#cart_icon_resp').trigger('click');
                }else{
                    $('.cart_item').trigger('click');
                }
            });


            $('#email,#email_confirmation').focusout(function(){

                var email = $(this).val();
                var emaill = $('#email').val();
                $('#email_error').addClass('instant_hide');
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                
                if(email != '' && email == emaill && regex.test(email)){
                    $.ajax({

                        url: "/informationFinder",
                        dataType: "json",
                        type: 'post',
                        data: {'find_type': 'email_duplication_truth', 'find': email, 'identity_type': 'guest_register', 'identity': ''},
                        success: function(response) { 
                            if(response.success == 1){
                                if(response.data.duplicated == 1){
                                    $('#email_error').text('This email is already registered. You must login with this email to purchase').removeClass('instant_hide');
                                }
                            }else{
                                
                            }
                        }
                    });
                }else{
                    $('#email_error').text('Email or email confirmation is invalid').removeClass('instant_hide');
                }
            });

            $('#password').focusout(function(){

                var password = $(this).val();
                $('#password_error').addClass('instant_hide');

                if(password != '' && password.length < 6){
                    $('#password_error').text('Password must be atleast of 6 characters').removeClass('instant_hide');
                }else if(password == ''){
                    $('#password_error').text('Password is required').removeClass('instant_hide');
                }
            });

            /*$('#city').focusout(function(){

                var city = $(this).val();
                $('#city_error').addClass('instant_hide');
                $("#city").css("border", "1px solid #9daec3");
                
                if(city != ''){
                    $.ajax({

                        url: "/informationFinder",
                        dataType: "json",
                        type: 'post',
                        data: {'find_type': 'city_validation', 'find': city, 'identity_type': 'guest', 'identity': ''},
                        success: function(response) { 
                            if(response.success == 1){
                                
                            }else{
                                $("#city").css("border", "1px solid red");
                                $('#city_error').text(response.error).removeClass('instant_hide');
                            }
                        }
                    });
                }else{
                    $("#city").css("border", "1px solid red");
                    $('#city_error').text('Please enter your city').removeClass('instant_hide');
                }
            });*/

            $('.item_disp_update_price').click(function(){

            	if(confirm('Are you sure?')){

            		var id = $(this).attr('data-id');
            		var formData = new FormData();
            		formData.append('id', id);
            		formData.append('type', 'update_price');
            		$.ajax({

            		    url: "/solvePriceDisparity",
            		    dataType: "json",
            		    type: 'post',
            		    data: formData,
            		    contentType:false,
            		    cache: false,
            		    processData: false,
            		    success: function(response) { 
            		        if(response.success == 1){
            		            location.reload();
            		        }else{
            		            alert(response.error);
            		        }
            		    }
            		});
            	}
            });

            $('.item_disp_remove').click(function(){

            	if(confirm('Are you sure?')){

            		var id = $(this).attr('data-id');
            		var formData = new FormData();
            		formData.append('id', id);
            		formData.append('type', 'remove');
            		$.ajax({

            		    url: "/solvePriceDisparity",
            		    dataType: "json",
            		    type: 'post',
            		    data: formData,
            		    contentType:false,
            		    cache: false,
            		    processData: false,
            		    success: function(response) { 
            		        if(response.success == 1){
            		            location.reload();
            		        }else{
            		            alert(response.error);
            		        }
            		    }
            		});	
            	}
            });

        });

		function updateCosting(id){

			var user_country_id = $("#user_country").val();
			var selectedCurrency = $("#selectedCurrency").val();
			var local_cost = $("#local_cost_" + selectedCurrency).val();
			var international_cost = $("#international_cost_" + selectedCurrency).val();
			var cost = international_cost;
			if(user_country_id == id){

			    cost = local_cost;
			}

			var symbol = "$";
			if(selectedCurrency == "GBP"){

			    symbol = "£";
			}
			if(selectedCurrency == "EUR"){

			    symbol = "€";
			}

			var data = symbol + parseFloat(cost).toFixed(2);
			$("#shipping_cost_area").text(data);
			var totalCost = parseFloat( $("#total_cost_" + selectedCurrency).val() ) + parseFloat(cost);
			$("#total_cost").val( totalCost.toFixed(2) );
			$("#delivery_cost").val(parseFloat(cost).toFixed(2));
		}

        function proceedPreparePayment(paymentData, stripe, eCardNumber){

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
                if(typeof data.free !== 'undefined' && data.free == 1){

                    var formData = new FormData();
                    if(typeof data.stripeCustomer !== 'undefined' && data.stripeCustomer != null){

                        formData.append('stripeCustomer', data.stripeCustomer);
                    }
                    formData.append('free', '1');
                    formData.append('userdata', $('#monies_form').serialize());
                    formData.append('type', 'instant');
                    postPayment(formData);
                }else{
                    payWithCard(stripe, eCardNumber, data.clientSecret);
                }
            });
        }

        function initiatePayment(stripe, eCardNumber){
            document.getElementById('spinner').classList.remove('hidden');
            document.getElementById('monies_submit').disabled = true;

            if($('#sub_n_free').length && $('#sub_n_free').val() == '1'){
                stripe
                .createPaymentMethod({
                    type: 'card',
                    card: eCardNumber,
                })
                .then(function(result3) {
                    if(result3.error){
                        document.getElementById('spinner').classList.add('hidden');
                        document.getElementById('monies_submit').disabled = false;
                        $('#m_e_error').text(result3.error.message).removeClass('instant_hide');
                        $('#fill_form_popup,#body-overlay').show();
                    }else{
                        var paymentData = {
                            userdata: $('#monies_form').serialize(),
                            paymentMethod: result3.paymentMethod.id,
                            type: 'instant'
                        };
                        proceedPreparePayment(paymentData,stripe, eCardNumber);
                    }
                });
            }else{
                var paymentData = {
                    userdata: $('#monies_form').serialize(),
                    type: 'instant'
                };
                proceedPreparePayment(paymentData,stripe, eCardNumber);
            }
        }
        
        function payWithCard(stripe, card, clientSecret){
            stripe
            .confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            })
            .then(function(result){
                if(result.error){
                    document.getElementById('spinner').classList.add('hidden');
                    document.getElementById('monies_submit').disabled = false;
                    $('#m_e_error').text(result.error.message).removeClass('instant_hide');
                    $('#fill_form_popup,#body-overlay').show();
                }else{
                    var formData = new FormData();
                    formData.append('intent', result.paymentIntent.id);
                    formData.append('userdata', $('#monies_form').serialize());
                    formData.append('type', 'instant');
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
                        var url = response.url;
                        if(!/^(?:f|ht)tps?\:\/\//.test(url)){
                            url = 'https://' + url;
                        }
                        window.location = url;
                    }else{
                        alert(response.error);
                        document.getElementById('spinner').classList.add('hidden');
                        document.getElementById('monies_submit').disabled = false;
                    }
                }
            });
        }

        function createToken(){

            stripe.createToken(eCardNumber).then(function(result){

                $('#m_e_error').addClass('instant_hide');
                if(result.error){
                    $('#m_e_error').removeClass('instant_hide').text(' ('+result.error.message+')');
                    $('#fill_form_popup,#body-overlay').show();
                }else{
                    var form = document.getElementById('monies_form');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        };

        function validatePaymentForm(){

            var success = true;

            var totalCostCheck = parseFloat($('#total_cost').val());
            if($('#stripe_key').val() == '0'){

                alert('The user does not yet have a stripe payment account setup at this time. Please contact the user through the 1platform.');
                success = false;
                return false;
            }

            var name = $("#name").val();
            var country = $("#country").val();
            var street = $("#street").val();
            var city = $("#city").val();
            var surname = $('#surname').val();
            var cityError = $("#city_error");
            var zip = $("#zip").val();
            var email = $("#email").val();
            var confirmEmail = $("#email_confirmation").val();
            var password = $("#password").val();
            var cotysoEmail = $('#cotyso_email');
            var contactNumber = $('#contact_number');
            var paymentMethod = $("#payment_method").val();

            $('.field_err').removeClass('field_err');

            if(name == ""){

                $("#name").addClass('field_err');
                success = false;
            }
            if(surname == ''){

                $("#surname").addClass('field_err');
                success = false;
            }
            if(country == ""){

                $("#country").closest('.select2_box_outer').find('.select2-selection--single').addClass('field_err');
                success = false;
            }
            if(city == "" || !cityError.hasClass('instant_hide')){

                $("#city").addClass('field_err');
                success = false;
            }
            if(street == ""){

                $("#street").addClass('field_err');
                success = false;
            }
            if(zip == ""){

                $("#zip").addClass('field_err');
                success = false;
            }

            if(cotysoEmail.length && (cotysoEmail.val() == '' || !validateEmail(cotysoEmail.val()))){

                $("#cotyso_email").addClass('field_err');
                success = false;
            }

            if(contactNumber.length && contactNumber.val() == ''){

                $("#contact_number").addClass('field_err');
                success = false;
            }

            if($("#is_create_new_user").val() == "1"){

                if(email == ''){
                    $("#email").addClass('field_err');
                    success = false;
                }
                if(confirmEmail == ''){
                    $("#email_confirmation").addClass('field_err');
                    success = false;
                }
                if(password == ''){
                    $("#password").addClass('field_err');
                    success = false;
                }
                if(email != '' && confirmEmail != '' && email != confirmEmail){
                    $("#email").addClass('field_err');
                    $("#email_confirmation").addClass('field_err');
                    success = false;
                }
                if(email != '' && confirmEmail != '' && email == confirmEmail && !$('#email_error').hasClass('instant_hide')){
                    $("#email").addClass('field_err');
                    success = false;
                }
                if(password != '' && !$('#password_error').hasClass('instant_hide')){
                    $("#password").addClass('field_err');
                    success = false;
                }
            }

            if($('#checkout_terms_agree').length){

                if(!$('#checkout_terms_agree').is(':checked')) {

                    $("#checkout_terms_agree").closest('li').addClass('error');
                    success = false;
                }else{
                    $("#checkout_terms_agree").closest('li').removeClass('error');
                }
            }

            if(totalCostCheck > 0 && (paymentMethod == '' || $('.proj_cont_each_det.active').length == 0)){

                $("#p_e_error").removeClass('instant_hide').text(' ('+'Choose a payment method'+')');
                success = false;
            }

            if(totalCostCheck > 0 && paymentMethod == 'stripe'){

                var cardName = $('#card_holder_name');
                if(cardName.val() == ''){
                    $('#m_e_error').removeClass('instant_hide').text(' ('+'Card name cannot be empty'+')');
                    success = false;
                }
            }

            $('#comment').val($('#comment').val().replace(/[^a-z !@\-?(),._+=~<>:|;#$'"%&^*0-9]/gi, ''));

            if(success == true){
            	return true;
            }else{
                return false;
            }
        }


        window.currentUserId = {{$user->id}};

    </script>

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



@section('page-background')

    @if($user->isCotyso() && $user->home_layout == 'background')
        <div data-url="/user-media/background/{{$user->custom_background}}" class="pg_back back_inactive"></div>
    @endif

@stop


@section('social-media-html')


@stop


@section('audio-player')

    @include('parts.audio-player')

@stop


@section('top-center')
    	
    @php $sellerDefaultCurrency = strtoupper($user->profile->default_currency); @endphp
    @if($user->isCotyso())
        @php $isCotyso = 1 @endphp
    @else
        @php $isCotyso = 0 @endphp
    @endif
    <div class="ch_center_outer user_hm_center">
        <div class="checkout_outer">
            @if(count($reviewItems) == 0)
            <h4 class="clearfix {{$isCotyso ? 'light' : ''}}"> You're checking out to {{$user->name}}  </h4>
            @else
            <h4 class="clearfix">&nbsp;</h4>
            @endif
            <div class="proj_cnter_story_sec_oter btm_center_outer_checkout">
                @if(count($reviewItems) == 0)
                <form id="monies_form" action="" method="post">

                    <input type="hidden" id="userId" name="userId" value="{{ $user->id }}">
                    <input type="hidden" name="perkIds" id="perkIds">
                    <input type="hidden" name="campaign_id" id="campaign_id" value="{{ $userCampaign->id }}">
                    <input type="hidden" name="subscribed" id="subscribed" value="0">
                    <input type="hidden" name="payment_method" id="payment_method" value="stripe">

                    <div class="proj_cntr_contribut_sec_otr">
                    	<br>
                        <ul>
                            @if(!Auth::user())
                                @if($isCotyso)
                                <li class="proj_photo_textarea_outer proj_tect_area_cotyso">

                                    <div class="clearfix proj_cont_flt_outer">

                                        <div class="proj_cont_left_img_textarea">

                                            <b>Leave a personal  message (it will appear on your voucher)</b>
                                            <textarea maxlength="80"  placeholder="Enter here (Max length: 80 characters)" id="comment" name="comment"></textarea>

                                        </div>
                                    </div>
                                    <b class="faq_check_stat">
                                    	If you have any questions kindly contact us via our online chat below
                                    </b>
                                </li>
                                <li class="proj_create_new_account_outer">
                                    <div class="clearfix proj_create_new_account_inner">
                                        <b>To purchase enter your email and phone number where you can be contacted at</b>
                                    </div>
                                    <input class="dummy_field" type="text" name="email_9">
                                    <div class="clearfix proj_cont_flt_outer">
                                        <div class="clearfix proj_email_outer" id="email_password_section">
                                            <div class="proj_cont_left_inp_outer">
                                                <b>Email *</b>
                                                <input type="text" placeholder="Your Email" name="email" id="cotyso_email" class="evade_auto_fill" />
                                                <span id="email_error" class="instant_hide"></span>
                                            </div>
                                            <div class="proj_cont_right_inp_outer">
                                                <b>Phone Number *</b>
                                                <input type="text" placeholder="Your Phone Number" name="contact_number" id="contact_number" class="evade_auto_fill" />
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @else
                                <input type="hidden" name="is_create_new_user" id="is_create_new_user" value="1">

                                <li class="proj_create_new_account_outer">

                                    <div class="clearfix proj_create_new_account_inner">
                                        <b>To purchase you will need to create an account so you can download your files</b>
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
                                @endif

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

                                        <input type="text" placeholder="Surname" name="surname" id="surname" value="{{$loggedUserDet?$loggedUserDet['surname']:''}}" />

                                    </div>

                                </div>
                                @if(!$isCotyso)
                                <label id="hide_show_details_check" class="proj_checkbox proj_checkbox_unchecked"> <input checked="" type="checkbox" name="make_me_private" /> Hide name/comment from everyone except organiser</label>
                                @endif
                            </li>

                            <li class="proj_address_outer add_margin">

                                

                                <div class="clearfix proj_cont_flt_outer">

                                    <div class="proj_cont_left_inp_outer">

                                        <b>Please Enter Your Shipping Address *</b>

                                        <input type="text" placeholder="Street Address" name="street" id="street" value="{{$loggedUserDet?$loggedUserDet['address']:''}}" />

                                    </div>

                                    <div class="proj_cont_right_inp_outer select2_box_outer">



                                        <input type="hidden" id="delivery_cost" name="delivery_cost" value="0">



                                        <input type="hidden" name="user_country" id="user_country" value="{{ $userPersonalDetails['countryId'] }}">



                                        <input type="hidden" name="local_cost_USD" id="local_cost_USD" value="{{$commonMethods->convert($sellerDefaultCurrency,'USD',$totalProductsLocalDeliveryCost)}}">

                                        <input type="hidden" name="international_cost_USD" id="international_cost_USD" value="{{$commonMethods->convert($sellerDefaultCurrency,'USD',$totalProductsInternationalDeliveryCost)}}">



                                        <input type="hidden" name="local_cost_GBP" id="local_cost_GBP" value="{{$commonMethods->convert($sellerDefaultCurrency,'GBP',$totalProductsLocalDeliveryCost)}}">

                                        <input type="hidden" name="international_cost_GBP" id="international_cost_GBP" value="{{$commonMethods->convert($sellerDefaultCurrency,'GBP',$totalProductsInternationalDeliveryCost)}}">



                                        <input type="hidden" name="local_cost_EUR" id="local_cost_EUR" value="{{$commonMethods->convert($sellerDefaultCurrency,'EUR',$totalProductsLocalDeliveryCost)}}">

                                        <input type="hidden" name="international_cost_EUR" id="international_cost_EUR" value="{{$commonMethods->convert($sellerDefaultCurrency,'EUR',$totalProductsInternationalDeliveryCost)}}">

                                        <b>Choose your country *</b>

                                        <select id="country" name="country">

                                        	<option value="">Choose your country</option>
                                            @foreach($countries as $country)
                                                @if($country->id == 213)
                                                <option {{$loggedUserDet&&$loggedUserDet['countryId']==$country->id?'selected':''}} value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endif
                                            @endforeach

                                            @foreach($countries as $country)
                                                @if($country->id != 213)
                                                <option {{$loggedUserDet&&$loggedUserDet['countryId']==$country->id?'selected':''}} value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endif
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

                            @if($totalCost > 0)

                            <li class="payment_method_option">

                                <b>Choose your payment method * <span id="p_e_error" class="instant_hide"></span></b>

                                <div class="clearfix proj_cont_flt_outer">

                                    <div class="proj_cont_left_inp_outer">
                                        <div data-payment-mode="stripe" class="proj_cont_each_det active">
                                            <div class="proj_det_pic">
                                                <div class="proj_det_stripe_icon">
                                                    <i class="fab fa-cc-mastercard"></i>
                                                    <i class="fab fa-cc-visa"></i>
                                                    <i class="fab fa-cc-amex"></i>
                                                    <i class="fab fa-cc-discover"></i>
                                                </div>
                                            </div>
                                            <div class="proj_det_name">
                                                Pay with credit card
                                            </div>
                                            <div class="proj_det_field">
                                                <div class="proj_det_circle">
                                                    <div class="proj_det_field_dot"></div>
                                                </div>
                                            </div>
                                            <div class="selected">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    @if($user->isCotyso())
                                    <div class="proj_cont_right_inp_outer">
                                        <div data-payment-mode="paypal" class="proj_cont_each_det">
                                            <div class="proj_det_pic">
                                                <div class="proj_det_paypal_icon">
                                                    <i class="fab fa-cc-paypal"></i>
                                                </div>
                                            </div>
                                            <div class="proj_det_name">
                                                Pay with PayPal
                                            </div>
                                            <div class="proj_det_field">
                                                <div class="proj_det_circle">
                                                    <div class="proj_det_field_dot"></div>
                                                </div>
                                            </div>
                                            <div class="selected">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="proj_cont_right_inp_outer">
                                        <div data-payment-mode="" class="proj_cont_each_det disabled">
                                            <div class="proj_det_pic">
                                                <div class="proj_det_paypal_icon">
                                                    <i class="fab fa-cc-paypal"></i>
                                                </div>
                                            </div>
                                            <div class="proj_det_name">
                                                Pay with PayPal (Coming Soon)
                                            </div>
                                            <div class="proj_det_field">
                                                <div class="proj_det_circle">
                                                    <div class="proj_det_field_dot"></div>
                                                </div>
                                            </div>
                                            <div class="selected">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>

                            </li>

                            <li class="credit_card_details">

                                <b>Credit / Debit Card Details * <span id="m_e_error" class="instant_hide"></span></b>

                                <div class="clearfix proj_cont_flt_outer">

                                    <div class="proj_cont_left_inp_outer">

                                        <input type="text" placeholder="Name On Card" name="card_holder_name" id="card_holder_name"  />

                                    </div>

                                    <div id="m_e_card_number" class="proj_cont_right_inp_outer m_e_card_elem"></div>

                                </div>

                            </li>

                            <li class="proj_credit_card_outer">

                                <div class="clearfix proj_cont_flt_outer">

                                    <div id="m_e_card_cvc" class="proj_cont_left_inp_outer m_e_card_elem"></div>

                                    <div id="m_e_card_expiry" class="proj_cont_right_inp_outer m_e_card_elem"></div>

                                </div>

                                <div class="stripe_power">
                                    <a target="_blank" href="https://stripe.com/gb">
                                        <img src="{{asset('images/logo-stripe-secure-payments-1.png')}}" />
                                    </a>
                                </div>
                            </li>
                            @endif
                            @if(!$user->isCotyso())
                            <li class="proj_photo_textarea_outer">

                                <div class="clearfix proj_cont_flt_outer">

                                    <div class="proj_cont_left_img_textarea">

                                    	<b>Leave a comment (Optional)</b>
                                        <textarea maxlength="150" placeholder="Enter here (Max length: 150 characters)" id="comment" name="comment"></textarea>

                                    </div>

                                </div>
                                <b class="faq_check_stat">If you have any questions you can check out our 
                                	<a href="{{route('faq')}}">FAQ</a>
                                </b>
                            </li>
                            @endif

                            @foreach($basket as $b)

                                @if($b->purchase_type == "subscription")
                                    @php
                                        $subscriptionText = 'Includes first month subscription charge: '.$commonMethods->getCurrencySymbol($sellerDefaultCurrency).number_format($b->price, 2);
                                    @endphp

                                    @if($totalCost == $b->price)
                                    <input value="1" type="hidden" name="sub_n_free" id="sub_n_free" />
                                    @endif

                                @endif
                                
                            @endforeach
                            
                            <li class="proj_total_amount_outer">

                                <div class="clearfix proj_cont_flt_outer">

                                    <div class="proj_cont_left_inp_outer tot_ship_left ">

                                        <h4>TOTAL</h4>

                                    </div>

                                    <div class="proj_cont_right_inp_outer tot_usd_shiping">

                                        <div class="clearfix proj_cont_right_inner">

                                            <select class="tot_usd_sec" name="selectedCurrency" id="selectedCurrency">
                                                @if($sellerDefaultCurrency == 'USD')
                                                <option value="USD">USD</option>
                                                @elseif($sellerDefaultCurrency == 'EUR')
                                                <option value="EUR">EUR</option>
                                                @elseif($sellerDefaultCurrency == 'GBP')
                                                <option value="GBP">GBP</option>
                                                @endif
                                            </select>

                                            <input value="{{ $totalCost }}" class="tot_usd_val" type="text" placeholder="0.00" style="background: none !important;" name="total_cost" id="total_cost" readonly />
                                            <span id="short_notice">
                                                {{ (isset($subscriptionText) && $subscriptionText != '') ? $subscriptionText : '' }}
                                            </span>


                                            @if($sellerDefaultCurrency == 'USD')
                                                <input value="{{$commonMethods->convert($sellerDefaultCurrency, "USD", $totalCost)}}" type="hidden" name="total_cost_USD" id="total_cost_USD" />
                                            @elseif($sellerDefaultCurrency == 'EUR')
                                                <input value="{{$commonMethods->convert($sellerDefaultCurrency, "EUR", $totalCost)}}" type="hidden" name="total_cost_EUR" id="total_cost_EUR" />
                                            @elseif($sellerDefaultCurrency == 'GBP')
                                                <input value="{{$commonMethods->convert($sellerDefaultCurrency, "GBP", $totalCost)}}" type="hidden" name="total_cost_GBP" id="total_cost_GBP" />
                                            @endif

                                        </div>

                                        <b>Including the shipping cost <a href="#" id="shipping_cost_area">{{$commonMethods->getCurrencySymbol($sellerDefaultCurrency)}}0</a></b>

                                    </div>

                                </div>

                            </li>

                            @if(!$isCotyso)
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
                            @endif

                            <li class="proj_confirm_payment_btn_outer">

                                <div class="clearfix proj_cont_flt_outer">

                                    <input type="hidden" name="stripe_key" id="stripe_key" value="{{ $user->profile->stripe_secret_key == '' ? '0' : '1' }}">

                                    <input type="hidden" name="userEmails" id="userEmails" value="">

                                    <input id="monies_submit" type="button" value="Confirm Payment" />
 
                                    <i id="spinner" class="hidden fa fa-spinner fa-spin"></i>
                                </div>

                            </li>
                            @if(!$isCotyso)
                            <li class="proj_bottom_description">

                                <div class="clearfix proj_cont_flt_outer">

                                    <p>

                                        1Platform TV does not investigate projects. Project owners are responsible for their projects and ensuring that the project is complete and that all promises are kept. Please contact project owners if you have an issue. Your name, email will be visible to the seller. Shipping address will also be visible where applicable

                                    </p>

                                </div>

                            </li>
                            @endif
                        </ul>

                    </div>
                    <input type="hidden" value="{{$sellerDefaultCurrency}}" id="original_currency">
                </form>
                @else
                    <div class="proj_notice_head">
                        Price Disparity Is Detected In Your Cart Item(s)
                    </div>
                    <div class="proj_notice_para">
                        You don't need to worry about it. Please follow through to know what it is and how to solve.
                    </div>
                    <div class="proj_notice_head_two">What Does It Mean</div>
                    <div class="proj_notice_para">
                        1Platform has detected that the prices of one or more items in your cart are not upto the date. Its normal and can happen due to one or more of the following reasons
                        <ul class="proj_notice_list">
                            <li>
                                when sellers update the price of items from their end
                            </li>
                            <li>
                                when the prices are updated automatically due to the expiration of their special offer (if they have one)
                            </li>
                        </ul>
                    </div>
                    <div class="proj_notice_head_two">How To Solve It</div>
                    <div class="proj_notice_para">
                        We have listed below such items from your cart. Before you are able to checkout you can
                        <ul class="proj_notice_list">
                            <li>
                                click on update price, this will keep the item but with its latest price
                            </li>
                            <li>
                                or click on remove item, this will remove it from your cart
                            </li>
                        </ul>
                    </div>
                    <div class="proj_notice_head_two">Items</div>
                    <br>
                    <div class="proj_items_disp">
                        @foreach($reviewItems as $b)
                            @if($b->purchase_type == 'music')
                                @include('parts.user-checkout-music-template',['basket'=>$b, 'disparity' => '1'])
                            @endif
                            @if($b->purchase_type == 'product')
                                @include('parts.user-checkout-product-template',['basket'=>$b, 'disparity' => '1'])
                            @endif
                            @if($b->purchase_type == 'album')
                                @include('parts.user-checkout-album-template',['basket'=>$b, 'disparity' => '1'])
                            @endif
                            @if($b->purchase_type == 'subscription')
                                @include('parts.user-checkout-row',['basket'=>$b, 'disparity' => '1'])
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="filler" id="shopping_cart_filler"></div>
        <div class="filler" id="shopping_suggest_filler"></div>
        <div class="filler" id="checkout_filler"></div>
    </div>

@stop



<!-- Right Bar !-->

@section('top-right')

    

@stop



<!-- Left Bar !-->

@section('top-left')
    @php $albumsCount = $productsCount = $musicsCount = 0; @endphp
    @foreach($basket as $b)
        @if($b->purchase_type == "music")
            @php $musicsCount++; @endphp
        @endif
        @if($b->purchase_type == "product" || $b->purchase_type == "custom_product")
            @php $productsCount++; @endphp
        @endif
        @if($b->purchase_type == "album")
            @php $albumsCount++; @endphp
        @endif
    @endforeach

    <div class="ch_tab_sec_outer">

        <div class="panel shopping_cart_outer colio_outer colio_dark ">
            <div class="colio_header">Your Shopping Cart&nbsp;&nbsp;<text id="cart_scrutiny"><i class="fa fa-edit"></i></text> </div>
            <div class="cart_items_outer">
                @if($musicsCount)
                <div class="user_musics_outer">
                    <h3 class="tabd2_head">Singles</h3>
                    <div class="music_main_outer">
                        @foreach($basket as $b)
                            @if($b->purchase_type == 'music')
                                @include('parts.user-checkout-music-template',['basket'=>$b])
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
                @if($productsCount)
                <div class="user_videos_outer">
                    <h3 class="tabd2_head">Products</h3>
                    @foreach($basket as $b)
                        @if($b->purchase_type == 'product' || $b->purchase_type == 'custom_product')
                            @include('parts.user-checkout-product-template',['basket'=>$b])
                        @endif
                    @endforeach
                </div>
                @endif
                @if($albumsCount)
                <div class="user_videos_outer">
                    <h3 class="tabd2_head">Albums</h3>
                    @foreach($basket as $b)
                        @if($b->purchase_type == 'album')
                            @include('parts.user-checkout-album-template',['basket'=>$b])
                        @endif
                    @endforeach
                </div>
                @endif
                @foreach($basket as $b)
                    @if($b->purchase_type == 'donation_goalless')
                    <div class="user_videos_outer">
                        <h3 class="tabd2_head">Contribution</h3>
                        @include('parts.user-checkout-row',['basket'=>$b])
                    </div>
                    @endif
                @endforeach
                @foreach($basket as $b)
                    @if($b->purchase_type == 'subscription')
                    <div class="user_videos_outer">
                        <h3 class="tabd2_head">Subscription</h3>
                        @include('parts.user-checkout-row',['basket'=>$b])
                    </div>
                    @endif
                @endforeach
                @foreach($basket as $b)
                    @if($b->purchase_type == 'project')
                    <div class="user_videos_outer">
                        <h3 class="tabd2_head">Project</h3>
                        @include('parts.user-checkout-row',['basket'=>$b])
                    </div>
                    @elseif($b->purchase_type == 'proferred-product')
                    <div class="user_videos_outer">
                        <h3 class="tabd2_head">Product</h3>
                        @include('parts.user-checkout-row',['basket'=>$b])
                    </div>
                    @elseif($b->purchase_type == 'instant-license')
                    <div class="user_videos_outer">
                        <h3 class="tabd2_head">Bespoke License</h3>
                        @include('parts.user-checkout-row',['basket'=>$b])
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @php $user = $basket->first()->user; @endphp
        @if(($musicsCount || $productsCount) && !$user->isCotyso())
        <div class="panel shopping_suggest_outer colio_outer colio_dark ">
            <div class="colio_header">You May Also Like</div>
            <div class="cart_suggestions_outer">
                @if($musicsCount)
                @php $musicSuggestionsCount = 0; @endphp
                <div class="user_musics_outer">
                    <h3 class="tabd2_head">Singles</h3>
                    <div class="music_main_outer">
                        @foreach($user->musics as $userMusic)
                            @if($musicSuggestionsCount == 5) @php break @endphp  @endif
                            @if( !$commonMethods::isBasketItem("music", $userMusic->id) )
                                @include('parts.user-channel-music-template',['music'=>$userMusic])
                                @php $musicSuggestionsCount++ @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
                @if($productsCount)
                @php $productSuggestionsCount = 0; @endphp
                <div class="user_videos_outer">
                    <h3 class="tabd2_head">Products</h3>
                    @foreach($user->products as $userProduct)
                        @if($productSuggestionsCount == 2) @php break @endphp  @endif
                        @if(!$commonMethods::isBasketItem("product", $userProduct->id) )
                            @include('parts.user-channel-product-template',['userProduct'=>$userProduct, 'suggestion' => 1])
                            @php $productSuggestionsCount++ @endphp
                            <br>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

@stop



@section('bottom-row-full-width')

@stop

@section('miscellaneous-html')
    <div class="clearfix pro_page_pop_up" id="bespoke_license_popup" data-music-id="">

        <div class="clearfix pro_soc_con_face_inner">

            <div class="clearfix soc_con_top_logo">
                <a style="opacity:0;" class="logo8">
                    <img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="stage_one">
                <div class="clearfix soc_con_face_username">
                    @guest
                    <div style="text-align: center;" class="main_headline">This feature requires user to login</div>
                    @endguest 
                    @auth
                    <div class="main_headline">Negotiate with the owner</div><br>
                    <textarea id="bispoke_offer" placeholder="Write your proposal here (i.e music name, terms of use, price etc)"></textarea>
                    <div class="instant_hide error" id="bispoke_offer_error">Required</div>
                    @endauth 
                </div>
                <br>
                @auth
                <div id="send_bispoke_license_offer" class="pro_button">SEND PROPOSAL</div>
                <br>
                <div class="pro_pop_dark_note">
                    <a class="inline_info" data-title="1 Platform: World's first bespoke licensing" href="https://www.youtube.com/embed/EksAIXYMEow?autoplay=0&origin={{config('constants.primaryDomain')}}&rel=0">How do license proposals work?</a>
                </div>
                @endauth
            </div>
            @auth
            <div class="stage_two instant_hide">
                <div class="clearfix soc_con_face_username">
                    <div class="pro_pop_text_light">
                        Your proposal has been sent to <span class="pro_text_dark" id="sender_name"></span>. Go to <a href="{{route('profile.with.tab', ['tab' => 'chat'])}}" class="pro_text_dark">chat</a> to read replies or send more messages/details about your proposal.
                    </div>  
                </div>
                <br>
            </div>
            @endauth
        </div>
    </div>
    <div data-currency="£" class="clearfix pro_page_pop_up" id="pay_quick_popup">

        <div class="clearfix pro_soc_con_face_inner">
            <div class="clearfix soc_con_top_logo">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div id="pay_quick_error" class="instant_hide m_e_card_pop_error"></div>
            <br>
            <div class="login_separator slim">
                <div class="login_separator_left"></div>
                <div class="login_separator_center">Your Product</div>
                <div class="login_separator_right"></div>
            </div>
            <div class="clearfix soc_con_face_username">
                <div class="main_headline"></div>
                <div class="second_headline"></div>
                <div class="row pay_quick_item_each">
                    Product: <span id="pay_quick_item_name"></span>
                </div>
                <div class="pro_pop_multi_row pay_quick_item_each">
                    <div class="each_col">
                        Details: <span id="pay_quick_item_details"></span>
                    </div>
                    <div class="each_col">
                        Subtotal: <span id="pay_quick_item_price"></span>
                    </div>
                </div>
                <div class="pro_pop_multi_row pay_quick_item_each pay_quick_item_delivery instant_hide">
                    <div class="each_col">
                        Delivery Cost: <span id="pay_quick_delivery_cost"></span>
                    </div>
                    <div class="each_col">
                        Grand Total: <span id="pay_quick_item_grand_total"></span>
                    </div>
                </div>
            </div>
            <div class="stage_one">
                <div class="clearfix soc_con_face_username">
                    <div class="login_separator slim">
                        <div class="login_separator_left"></div>
                        <div class="login_separator_center">Shipping Address</div>
                        <div class="login_separator_right"></div>
                    </div>
                    <div class="pro_pop_multi_row">
                        <div class="each_col">
                            <input class="dummy_field" type="text" name="fakeusernameremembered">
                            <input placeholder="Your Name" type="text" id="pay_quick_name" value="" />
                        </div>
                        <div class="each_col">
                            <input class="dummy_field" type="text" name="fakeusernameremembered">
                            <input placeholder="Your Email" type="text" id="pay_quick_email" value="">
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
                <br>
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
                </div><br>
                <div id="pay_quick_final" class="pro_button">SUBMIT</div>
            </div>
        </div>
    </div>

    <div class="clearfix pro_fill_outer pro_page_pop_up" id="fill_form_popup">

        <div class="clearfix pro_fill_inner">

            <div class="clearfix soc_con_top_logo">

                <img class="logo8 pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/logo_black.png') }}">
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="clearfix soc_discon_text">

                <h3>Wait!! You haven't filled all of the mandatory information</h3><br />
                <span class="error"></span>
            </div>
            <div class="clearfix pro_fill_img">
                <img class="defer_loading" src="" data-src="{{ asset('images/pupfillprofile.png') }}">
            </div>
        </div>
    </div>
    <div class="clearfix pro_soc_con_face_outer pro_page_pop_up" id="choose-music-license">

        <div class="clearfix pro_soc_con_face_inner">

            <div class="clearfix soc_con_top_logo">

                <a class="logo8"><img alt="image popup" class="pro_soc_top_logo defer_loading" src="#" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="choose_music_license_outer"></div>
            <div class="choose_music_license_submit disabled">Add to cart</div>
        </div>
    </div>
    <div id="body-overlay"></div>
    <input type="hidden" id="stripe_publishable_key" value="{{config('constants.stripe_key_public')}}">
    <input type="hidden" id="connect_account_id" value="{{$basket->first()->user->profile->stripe_user_id}}">
@stop