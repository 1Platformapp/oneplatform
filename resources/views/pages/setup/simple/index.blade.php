@extends('templates.profile-setup-template')

@section('pagetitle') Profile setup wizard @endsection


@section('pagekeywords')
@endsection


@section('pagedescription')
@endsection


@section('seocontent')
@endsection


@section('page-level-css')

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

        async function registerUser() {
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

            fetch('api/register/user', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                $('#spinner').removeClass('fa fa-spinner fa-spin');
                document.getElementById('submit_btn').disabled = false;
                $('#submit_btn').removeClass('is-busy');
                if(data.redirect) {
                    $('#login_email_address').val($('#emailaddress').val());
                    $('#login_password').val($('#fake_password').val());
                    $('#login-form').submit();
                    // window.location.href = data.redirect;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
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
            imgCaptcha.src = 'captcha_images/'+captchaNumber+'_cpt';   
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
        });
    </script>

@endsection

@section('page-content')
<div id="token-content" class="flex items-center justify-center hidden h-screen">
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
                                <img id='imgCaptchaPlace' src='captcha_images/no_captcha_found_cpt'/>
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
