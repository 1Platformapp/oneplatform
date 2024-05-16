@extends('templates.profile-setup-template')

@section('pagetitle') Profile setup wizard @endsection


@section('pagekeywords')
@endsection


@section('pagedescription')
@endsection


@section('seocontent')
@endsection


@section('page-level-css')

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
        #pay_int_sub_plan { text-transform: capitalize; }
    </style>
@endsection


@section('page-level-js')

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>

        function loadScript(src, callback) {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = src;
            script.onload = callback;
            document.head.appendChild(script);
        }

        function activateStep(step) {
            var parent = $('.each-step[data-step="'+step+'"]');
            $('.each-step:not(.filled-step)')
                .removeClass('current-step')
                .find('.each-step-in').removeClass('cursor-pointer border-gray-200 hover:border-gray-300 border-indigo-600 hover:border-indigo-800')
                .find('.each-step-title').removeClass('cursor-pointer text-gray-500 group-hover:text-gray-700 text-indigo-600 group-hover:text-indigo-800');

            $('.each-step').removeClass('current-step');
            parent
                .addClass('current-step')
                .find('.each-step-in').addClass('border-indigo-600').removeClass('cursor-pointer border-gray-200 hover:border-gray-300 hover:border-indigo-800')
                .find('.each-step-title').addClass('text-indigo-600').removeClass('text-gray-500 group-hover:text-gray-700 group-hover:text-indigo-800');

            $('.each-step-body').addClass('hidden');
            $('.each-step-body[data-step="'+step+'"]').removeClass('hidden');
            $('#step-name').text('Step: ' + parent.find('.each-step-name').text());
        }

        function filledStep(step) {
            var parent = $('.each-step[data-step="'+step+'"]');
            parent
                .addClass('filled-step')
                .find('.each-step-in').addClass('cursor-pointer border-indigo-600 hover:border-indigo-800').removeClass('border-gray-200 hover:border-gray-300')
                .find('.each-step-title').addClass('cursor-pointer text-indigo-600 group-hover:text-indigo-800').removeClass('text-gray-500 group-hover:text-gray-700');
        }

        function isValidEmail (email) {
            const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i
            return emailRegex.test(email)
        }

        async function validateStep(step) {

            const username = $('#fake_username').val();
            const firstName = $('#firstname').val();
            const surname = $('#surname').val();
            const artistName = $('#artistname').val();
            const email = $('#emailaddress').val();
            const password = $('#fake_password').val();
            const country = $('#country_id').val();
            const city = $('#city_id').val();
            const mainSkill = $('#main_skill_name').val();
            var regex = /\s/;

            if (step == 'one') {

                if ($('#fake_username').length && (username == '' || username.length < 8 || username.length > 20 || regex.test(username))) {
                    return true;
                }

                if ($('#fake_username').length) {
                    const isAvailable = await checkAvailability('username', username);
                    return !isAvailable;
                }

                return false;
            } else if (step == 'two') {

                if (firstName == '' || surname == '' || artistName == '' || ($('#emailaddress').length && email == '') || password == '' || password.length < 6 || country == '' || city == '') {
                    return true;
                }

                if ($('#emailaddress').length && email != '' && !isValidEmail(email)) {
                    return true;
                }

                if ($('#emailaddress').length) {

                    const isAvailable = await checkAvailability('email', email);
                    return !isAvailable;
                }

                return false;
            }else if (step == 'three') {
                if (mainSkill == 'null' || mainSkill == null) {
                    return true;
                }

                return false;
            }
        }

        async function checkAvailability (type, value) {

            return new Promise((resolve, reject) => {
                let find = value;
                let findType = null;

                if (type == 'username') {
                    findType = 'username-availability';
                } else if (type == 'email') {
                    findType = 'email-availability';
                }

                if (findType) {
                    $.ajax({
                        url: '/informationFinder',
                        dataType: "json",
                        type: 'post',
                        data: {'find_type': findType, 'find': find, 'identity_type': 'guest', 'identity': ''},
                        success: function(response) {
                            console.log(response);
                            if (response.success !== 1) {
                                resolve(false);
                            } else {
                                resolve(true);
                            }
                        },
                        error: function(xhr, status, error) {
                            reject(error);
                        }
                    });
                }
            });
        }

        async function proceedWithUserRegistration () {
            const formData = new FormData();

            formData.append('fake_username', $('#fake_username').val());
            formData.append('currency', $('#currency').val());
            formData.append('firstName', $('#firstname').val());
            formData.append('lastName', $('#surname').val());
            formData.append('name', $('#artistname').val());
            formData.append('email', $('#emailaddress').val());
            formData.append('password', $('#fake_password').val());
            formData.append('country_id', $('#country_id').val());
            formData.append('city_id', $('#city_id').val());
            formData.append('skill', $('#main_skill_name').val());
            formData.append('sec_skill', $('#other_skill_name').val());
            formData.append('genre_id', $('#genre').val());
            formData.append('level', $('#level').val());
            formData.append('user_id', $('#user_id').val());
            formData.append('g-recaptcha-response', grecaptcha.getResponse());

            const response = await fetch('/api/register/user', {
                method: 'POST',
                body: formData,
            });

            const res = await response.json();
            return res;
        }

        function subscribeUser () {

            $.getScript('https://js.stripe.com/v3/', function() {

                window.stripe = Stripe($('#stripe_publishable_key').val());
                var elements = stripe.elements();

                var baseStyles = {'fontFamily': 'Open sans, sans-serif','fontSize': '14px','color': '#000','lineHeight': '31px'};
                var invalidStyles = {'color': '#fc064c'};

                window.eCardNumber = elements.create('cardNumber', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
                window.eCardCvc = elements.create('cardCvc', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
                window.eCardExpiry = elements.create('cardExpiry', {'style': {'base': baseStyles, 'invalid': invalidStyles}});

                window.eCardNumber.mount('#m_e_card_number');
                window.eCardCvc.mount('#m_e_card_cvc');
                window.eCardExpiry.mount('#m_e_card_expiry');

                $('#pay_int_sub_price').removeClass('p_appli');
                $('#p_price').addClass('instant_hide');
                $('#int_sub_voucher_code').val('');
                $('#pay_internal_subscription_popup, #body-overlay').show();
            });
        }

        function createSubscription(paymentMethodId, userId, internalId, redirect = null){

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
                    package: window.name+'_'+window.price+'_'+window.term,
                    discount: discountCode.val(),
                    cardName: cardName.val(),
                    action: '',
                    internalId: internalId,
                    user_id: userId
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
                            handlePostRegister(redirect);
                        }else if(result.data.subscription_status == 'incomplete'){
                            if(result.data.subscription_payment_intent_status == 'requires_action' || result.data.subscription_payment_intent_status == 'requires_source_action'){
                                window.internal_subscription_id = result.data.internal_subscription_id;
                                window.stripe
                                    .confirmCardPayment(result.data.subscription_payment_intent_client_secret,{
                                        payment_method: paymentMethodId,
                                    })
                                    .then((result2) => {
                                        if(result2.error){
                                            alert(result2.error.message);
                                            $('#pay_int_sub_final').removeClass('disabled');
                                        }else{
                                            if(result2.paymentIntent.status == 'succeeded'){
                                                createSubscription(paymentMethodId, userId, window.internal_subscription_id, redirect);
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
                        console.log('unknown')
                    }
                }
            })
        }

        function handlePostRegister (redirect) {

            alert('Account created');
            $('#spinner').removeClass('fa fa-spinner fa-spin');
            document.getElementById('submit_btn').disabled = false;
            $('#submit_btn').removeClass('is-busy');
            if(redirect) {
                $('#login_email_address').val($('#emailaddress').val());
                $('#login_password').val($('#fake_password').val());
                $('#login-form').submit();
                // window.location.href = data.redirect;
            }
        }

        async function registerUser() {

            const prefill = $('#prefill').val();
            if (!prefill || prefill == '') {
                subscribeUser();
            } else {
                proceedWithUserRegistration().then((response) => {
                    handlePostRegister(response.redirect);
                });
            }
        }

        var captchaArray=[];
        captchaArray.push("VQ7W3");
        captchaArray.push("A1234");
        captchaArray.push("A32BD");
        captchaArray.push("LD673");
        captchaArray.push("PQ78V");
        captchaArray.push("MX81W");
        var captchaNumber;

        function myFunction() {
            captchaNumber = Math.floor(Math.random() * 6);
            const imgCaptcha = document.getElementById('imgCaptchaPlace');
            const asset = window.location.href.includes('127.0.0.1') ? "{{ asset('captcha_images') }}/" : "{{ asset('public/captcha_images') }}/";
            imgCaptcha.src = asset + captchaNumber + "_cpt";
        }

        $('document').ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var step = 'one';
            activateStep(step);
            $('.each-step[data-step="'+step+'"]').prevAll().each(function(){
                filledStep($(this).attr('data-step'));
            });

            $('body').delegate('.pro_soc_top_close', 'click', function(){
                $('#pay_internal_subscription_popup, #body-overlay').hide();
            });

            $('body').delegate('.current-plan', 'click', function(){

                const current = $(this);

                $('.current-plan').removeClass('border-indigo-600').addClass('border-gray-300');
                current.removeClass('border-gray-300').addClass('border-indigo-600');

                window.term = current.attr('data-term');
                window.name = current.attr('data-name');
                window.price = current.attr('data-price');
            });

            $('body').delegate('.back-btn', 'click', function(){
                var currentStep = $('.each-step.current-step');

                if (currentStep.length) {
                    if (currentStep.attr('data-step') == 'three') {
                        $('.google-recaptcha').html('');
                        activateStep('two');
                    } else if (currentStep.attr('data-step') == 'two') {
                        $(this).addClass('hidden');
                        activateStep('one');
                    }
                }
            });

            $('body').delegate('.next-btn:not(.is-busy)', 'click', async function(e){
                $(this).addClass('is-busy');
                const username = $('#username');
                var regex = /\s/;
                let error = false;
                var currentStep = $('.each-step.current-step');
                $('#error-span').addClass('hidden');

                if (currentStep.length) {
                    if (currentStep.attr('data-step') == 'one') {

                        if (await validateStep('one')) {
                            console.log('Validation failed');
                            $('#error-span').removeClass('hidden');
                            $(this).removeClass('is-busy');
                            return;
                        }

                        activateStep('two');
                        $('.back-btn').removeClass('hidden');
                        $(this).removeClass('is-busy');
                    } else if (currentStep.attr('data-step') == 'two') {
                        if (await validateStep('two')) {
                            console.log('Validation failed');
                            $('#error-span').removeClass('hidden');
                            $(this).removeClass('is-busy');
                            return;
                        }
                        myFunction();
                        activateStep('three');
                        var recaptchaScriptUrl = 'https://www.google.com/recaptcha/api.js';
                        $('.google-recaptcha').html('<div class="g-recaptcha" data-sitekey="6Lf2wLgnAAAAAAyelpUjpxzAHH9y8ea1k8FrtvCV"></div>');
                        loadScript(recaptchaScriptUrl, function () {});
                        $(this).removeClass('is-busy');
                    } else if (currentStep.attr('data-step') == 'three') {
                        if (await validateStep('three')) {
                            console.log('Validation failed');
                            $('#error-span').removeClass('hidden');
                            $(this).removeClass('is-busy');
                            return;
                        }
                        if($("#captcha").val() == captchaArray[captchaNumber]) {
                            // Continue
                        } else {
                            alert('Captcha Failed');
                            $(this).removeClass('is-busy');
                            return
                        }

                        let hitApi = $('#register-form').attr('data-api-hit');

                        if(hitApi) {
                            $('#spinner').addClass('fa fa-spinner fa-spin');
                            document.getElementById('submit_btn').disabled = true;

                            await registerUser();
                        } else {
                            $('#register-form').submit();
                        }
                    }
                }
            });

            $('body').delegate('.each-step.filled-step', 'click', function(e){
                activateStep($(this).attr('data-step'));
            });

            $('#token-verify').click(function () {
                var token = $('#verification-token').val();

                $.ajax({
                        url: '/verify-token',
                        dataType: 'json',
                        type: 'POST',
                        data: {'token' : token},
                        success: function (data){
                            if(data.isTokenVerified) {
                                $('#token-content').addClass('hidden');
                                $('#register-content').removeClass('hidden');
                            }
                        }
                    });
            });

            $(".platform-searchable").bind('keyup', function(event){
                var thiss = $(this);
                var well = thiss.closest('.my-dropdown-container').find('.'+thiss.attr('data-well'));
                well.addClass('hidden');
                if(thiss.val().trim().length > 2){
                    $.ajax({
                        url: thiss.attr('data-uri'),
                        dataType: 'json',
                        type: 'POST',
                        data: {'string' : thiss.val()},
                        success:function(data){
                            if(data.success){
                                var resultsRows = JSON.parse( JSON.stringify( data.result ) );
                                if(data.totalRecords == 0){
                                    var response = '<div class="p-3 text-center my-dropdown-item no_results">No results</div>';
                                }else{
                                    var response = '';
                                }
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var name = eachResultRow['name'] ? eachResultRow['name'] : (eachResultRow['value'] ? eachResultRow['value'] : eachResultRow[1]);
                                        var id = eachResultRow['id'];
                                        response += '<div data-id="'+id+'" class="p-3 cursor-pointer my-dropdown-item hover:bg-gray-50">'+name+'</div>';
                                    }
                                }
                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = '<div class="p-3 text-center my-dropdown-item no_results">No results</div>'; }

                                well.html(response).removeClass('hidden');
                            }else{
                                alert(data.error)
                            }
                        }
                    });
                }
            });

            $('body').delegate('.my-dropdown-item', 'click', function(e){
                var thiss = $(this);
                if (thiss.closest('.my-dropdown').hasClass('country-dropdown')) {
                    $('#country_name').val(thiss.text());
                    $('#country_id').val(thiss.attr('data-id'));
                } else if (thiss.closest('.my-dropdown').hasClass('city-dropdown')) {
                    $('#city_name').val(thiss.text());
                    $('#city_id').val(thiss.attr('data-id'));
                } else if (thiss.closest('.my-dropdown').hasClass('main-skill-dropdown')) {
                    $('#main_skill_name').val(thiss.text());
                } else if (thiss.closest('.my-dropdown').hasClass('other-skill-dropdown')) {
                    $('#other_skill_name').val(thiss.text());
                }
                thiss.closest('.my-dropdown').html('').addClass('hidden');
            });

            $('.close-btn').click(function(){
                $('.flash-container').remove();
            });

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
                    window.stripe.createPaymentMethod({
                        type: 'card',
                        card: window.eCardNumber,
                        billing_details: {
                            name: cardName.val(),
                        },
                    }).then((result) => {
                        if(result.paymentMethod.id){
                            proceedWithUserRegistration().then((response) => {
                                createSubscription(result.paymentMethod.id, response.id, null, response.redirect);
                            });
                        }else{
                            alert(result?.error?.message);
                            $('#pay_int_sub_final').removeClass('disabled');
                        }
                    })
                }
            });
        });
    </script>

@endsection

@section('page-content')
<div id="token-content" class="flex items-center justify-center h-screen hidden">
    <div class="w-full max-w-md pt-6 pb-6">
        <h2 class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">Welcome to 1Platform</h2>
        <p class="mt-1 text-sm text-center text-gray-500">1Platform: Your essential tool for music career success</p>
        <div class="flex flex-col mt-6">
            <div class="mb-4">
                <label for="token" class="block text-sm font-medium text-gray-600">Token</label>
                <input type="text" id="verification-token" placeholder="Enter Token" class="w-full p-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="flex items-center justify-center ml-auto">
                <button id="token-verify" type="submit" class="px-4 py-2 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

<div id="register-content" class="">
    <div class="w-full pt-6 pb-6">
        <h2 class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">Welcome to 1Platform</h2>
        <p class="mt-1 text-sm text-center text-gray-500">1Platform: Your essential tool for music career success</p>
        <nav aria-label="Progress" class="pt-16 pb-12">
            <ol role="list" class="space-y-4 md:flex md:space-x-8 md:space-y-0">
                <li data-step="one" class="each-step md:flex-1">
                    <div class="flex flex-col py-2 pl-4 border-l-4 border-gray-200 cursor-pointer each-step-in hover:border-gray-300 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                        <span class="text-sm font-medium text-gray-500 each-step-title group-hover:text-gray-700">Step 1</span>
                        <span class="text-sm font-medium each-step-name">Username and currency</span>
                    </div>
                </li>
                <li data-step="two" class="each-step md:flex-1">
                    <div class="flex flex-col py-2 pl-4 border-l-4 border-gray-200 cursor-pointer each-step-in hover:border-gray-300 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                        <span class="text-sm font-medium text-gray-500 each-step-title group-hover:text-gray-700">Step 2</span>
                        <span class="text-sm font-medium each-step-name">Add personal information</span>
                    </div>
                </li>
                <li data-step="three" class="each-step md:flex-1">
                    <div class="flex flex-col py-2 pl-4 border-l-4 border-gray-200 cursor-pointer each-step-in group hover:border-gray-300 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                        <span class="text-sm font-medium text-gray-500 each-step-title group-hover:text-gray-700">Step 3</span>
                        <span class="text-sm font-medium each-step-name">Add media information</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    @if (Session::has('error'))
        <div class="flex flex-row items-center p-4 mb-4 text-red-800 rounded-md flash-container bg-red-50">
            <div>
                <i class="fa fa-times-circle"></i>
                {{ (is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error') }}
            </div>
            <div class="ml-auto text-red-800 cursor-pointer close-btn">
                <i class="fa fa-times"></i>
            </div>
        </div>
    @elseif(Session::has('profile_saved'))
        <div class="flex flex-row items-center p-4 mb-4 text-green-800 rounded-md flash-container bg-green-50">
            <div>
                <i class="fa fa-check-circle"></i>
                Saved successfully
            </div>
            <div class="ml-auto text-green-800 cursor-pointer close-btn">
                <i class="fa fa-times"></i>
            </div>
        </div>
    @endif
    <div class="bg-white rounded-lg">
        <form id="register-form" data-api-hit="{{auth::user() ? false : true}}" action="{{auth::user() ? route('profile.simple.setup') : route('register.user')}}" method="POST">
            {{csrf_field()}}
            <div class="py-12 mx-6">
                <h2 class="mb-2 text-base font-semibold leading-7 text-gray-900"><span id="step-name"></span></h2>
                <div data-step="one" class="hidden space-y-12 each-step-body sm:space-y-16">
                    <div class="pb-12 space-y-8 border-b border-gray-900/10 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_username" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Username</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <span class="flex items-center pl-3 text-gray-500 select-none sm:text-sm">1platform.tv/</span>
                                    <input type="email" id="username" name="username" autocomplete="on" class="w-0 h-0">
                                    @if(!isset($user->username) || $user->username == NULL || $user->username == '')
                                    <input type="text" name="fake_username" id="fake_username" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="janesmith">
                                    @else
                                    <span class="py-1.5 pl-1 text-gray-900 sm:text-sm sm:leading-6">{{$user->username}}</span>
                                    @endif
                                </div>
                                @if(!isset($user->username) || $user->username == NULL || $user->username == '')
                                <p class="mt-3 text-sm leading-6 text-gray-600">The username must be between 8 and 20 characters long and must not contain white spaces</p>
                                @else
                                <p class="mt-3 text-sm leading-6 text-gray-600">Your username has already been setup by your agent</p>
                                @endif
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="currency" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Currency</label>
                            <div class="mt-2 rounded-md sm:col-span-2 ring-1 ring-inset ring-gray-300 sm:mt-0">
                                <select id="currency" name="currency" autocomplete="off" class="h-10 block w-full rounded-md border-0 py-1.5 text-gray-900 outline-none bg-transparent sm:text-sm sm:leading-6">
                                    <option value="gbp">GBP</option>
                                    <option value="eur">EUR</option>
                                    <option value="usd">USD</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-step="two" class="hidden space-y-12 each-step-body sm:space-y-16">
                    <div class="pb-12 space-y-8 border-b border-gray-900/10 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="firstname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">First name</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="text" id="firstname" name="firstName" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="surname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Surname</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="text" id="surname" name="lastName" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="artistname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Artist name</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input value="{{$prefill ? $prefill['name'] : ''}}" type="text" id="artistname" name="name" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">This will be your public name</p>
                            </div>
                        </div>
                        @if(!$prefill)
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="emailaddress" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Email</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="text" id="emailaddress" name="email" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        @elseif(isset($prefill['email']))
                        <input type="hidden" id="emailaddress" name="email" autocomplete="off" value="{{$prefill['email']}}">
                        @endif
                        <input type="hidden" id="user_id" name="user_id" autocomplete="off" value="{{$prefill['id'] ?? null}}">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_password" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Password</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="password" id="password" name="password" autocomplete="off" class="hidden">
                                    <input type="password" id="fake_password" name="password" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">Must be at least 6 characters long</p>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="countryname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Country</label>
                            <div class="relative mt-2 my-dropdown-container sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="hidden" id="country_id" name="country_id" value="">
                                    <input data-uri="/searchCountries" data-well="country-dropdown" id="country_name" type="text" autocomplete="off" class="platform-searchable block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="Search here">
                                </div>
                                <div class="hidden my-dropdown country-dropdown absolute top-full border pt-2 text-sm divide-y border-t-0 left-0 w-full max-h-[300px] z-50 bg-white flex flex-col">

                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="cityname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">City</label>
                            <div class="relative mt-2 my-dropdown-container sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="hidden" id="city_id" name="city_id" value="">
                                    <input data-uri="/searchCities" data-well="city-dropdown" id="city_name" type="text" autocomplete="off" class="platform-searchable block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="Search here">
                                </div>
                                <div class="hidden my-dropdown city-dropdown absolute top-full border pt-2 text-sm divide-y border-t-0 left-0 w-full max-h-[300px] z-50 bg-white flex flex-col">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-step="three" class="hidden space-y-12 each-step-body sm:space-y-16">
                    @php $skills = \App\Models\Skill::all() @endphp
                    <div class="pb-12 space-y-8 border-b border-gray-900/10 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="skillname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Main skill</label>
                            <div class="relative mt-2 my-dropdown-container sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <select data-well="main-skill-dropdown" id="main_skill_name" name="skill" type="text" autocomplete="off" class="platform-searchable block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                        <option value="null" selected disabled>Select a Skill</option>
                                        @foreach($skills as $skill)
                                            <option value="{{$skill->value}}">{{$skill->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="hidden my-dropdown main-skill-dropdown absolute top-full border pt-2 text-sm divide-y border-t-0 left-0 w-full max-h-[300px] z-50 bg-white flex flex-col">

                                </div> -->
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="otherskillname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Other skill</label>
                            <div class="relative mt-2 my-dropdown-container sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <select data-well="other-skill-dropdown" id="other_skill_name" name="sec_skill" type="text" autocomplete="off" class="platform-searchable block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                        <option value='' selected disabled>Select a Skill</option>
                                        @foreach($skills as $skill)
                                            <option value="{{$skill->value}}">{{$skill->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="hidden my-dropdown other-skill-dropdown absolute top-full border pt-2 text-sm divide-y border-t-0 left-0 w-full max-h-[300px] z-50 bg-white flex flex-col">

                                </div> -->
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="genre" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Genre</label>
                            <div class="mt-2 rounded-md sm:col-span-2 ring-1 ring-inset ring-gray-300 sm:mt-0">
                                <select id="genre" name="genre_id" autocomplete="off" class="h-10 block w-full rounded-md border-0 py-1.5 text-gray-900 outline-none bg-transparent sm:text-sm sm:leading-6">
                                    <option value="">Choose an option</option>
                                    @foreach($genres as $key => $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="level" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Level</label>
                            <div class="mt-2 rounded-md sm:col-span-2 ring-1 ring-inset ring-gray-300 sm:mt-0">
                                <select id="level" name="level" autocomplete="off" class="h-10 block w-full rounded-md border-0 py-1.5 text-gray-900 outline-none bg-transparent sm:text-sm sm:leading-6">
                                    <option value="">Choose an option</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Professional">Professional</option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <div>
                                <label for="level" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Captcha</label>
                                <img id='imgCaptchaPlace' src="{{asset('public/captcha_images/no_captcha_found_cpt')}}"/>
                            </div>
                            <div class="mt-2 rounded-md sm:col-span-2 ring-1 ring-inset ring-gray-300 sm:mt-0">
                                <input id="captcha" type="text" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-start justify-between lg:flex-row">
                    <div class="flex flex-row mt-6">
                        <button id="back_btn" type="button" class="inline-flex justify-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm outline-none back-btn hover:bg-indigo-500">
                            Back
                        </button>
                    </div>
                    <div class="mt-6 google-recaptcha"></div>
                    <div class="flex flex-row mt-6 lg:justify-end gap-x-6">
                        <button id="submit_btn" type="button" class="inline-flex justify-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm outline-none next-btn hover:bg-indigo-500">
                            <i id="spinner" class=""></i>Next
                        </button>
                    </div>
                </div>

                <div class="flex">
                    <p id="error-span" class="hidden mt-3 ml-auto text-sm leading-6 text-red-600">There is some validation error</p>
                </div>
            </div>
        </form>

        <form id="login-form" class="hidden form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form_group">
                <input type="email" class="hidden" hidden name="email" id="login_email_address" />
            </div>
            <div class="form_group">
                <input type="password" class="hidden" hidden name="password" id="login_password" />
            </div>
        </form>
    </div>
</div>
@endsection

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
                        <fieldset>
                            <div class="space-x-2 grid grid-cols-2">
                                <label data-term="month" data-name="{{config('constants.user_internal_packages')[1]['name']}}" data-price="{{config('constants.user_internal_packages')[1]['pricing']['month']}}" class="grid-col current-plan border-indigo-600 cursor-pointer rounded-lg border bg-white px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between">
                                    <span class="flex items-center">
                                        <span class="flex flex-col text-sm">
                                            <span class="font-medium text-gray-900 capitalize">{{config('constants.user_internal_packages')[1]['name']}}</span>
                                            <div class="flex flex-col text-gray-500">
                                                <span class="block sm:inline">{{config('constants.user_internal_packages')[1]['volume']}}GB Disk</span>
                                                <span class="hidden sm:mx-1 sm:inline" aria-hidden="true">&middot;</span>
                                                <span class="block sm:inline">{{config('constants.user_internal_packages')[1]['network_limit']}} Networks</span>
                                            </div>
                                        </span>
                                    </span>
                                    <span class="mt-2 flex text-sm sm:ml-4 sm:mt-0 sm:flex-col sm:text-right">
                                        <span class="font-medium text-gray-900">&pound;{{config('constants.user_internal_packages')[1]['pricing']['month']}}</span>
                                        <span class="ml-1 text-gray-500 sm:ml-0">/mo</span>
                                    </span>
                                </label>
                                <label data-term="month" data-name="{{config('constants.user_internal_packages')[2]['name']}}" data-price="{{config('constants.user_internal_packages')[2]['pricing']['month']}}" class="grid-col current-plan block cursor-pointer rounded-lg border bg-white px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between">
                                    <span class="flex items-center">
                                        <span class="flex flex-col text-sm">
                                            <span class="font-medium text-gray-900 capitalize">{{config('constants.user_internal_packages')[2]['name']}}</span>
                                            <div class="flex flex-col text-gray-500">
                                                <span class="block sm:inline">{{config('constants.user_internal_packages')[2]['volume']}}GB Disk</span>
                                                <span class="hidden sm:mx-1 sm:inline" aria-hidden="true">&middot;</span>
                                                <span class="block sm:inline">{{config('constants.user_internal_packages')[2]['network_limit']}} Networks</span>
                                            </div>
                                        </span>
                                    </span>
                                    <span class="mt-2 flex text-sm sm:ml-4 sm:mt-0 sm:flex-col sm:text-right">
                                        <span class="font-medium text-gray-900">&pound;{{config('constants.user_internal_packages')[2]['pricing']['month']}}</span>
                                        <span class="ml-1 text-gray-500 sm:ml-0">/mo</span>
                                    </span>
                                </label>
                            </div>
                        </fieldset>
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
                <div class="support_card_brands flex">
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
    <input type="hidden" id="stripe_publishable_key" value="{{$commonMethods->getStripePublicKey()}}">
    <input type="hidden" id="prefill" value="{{$prefill ? '1' : ''}}">

@endsection
