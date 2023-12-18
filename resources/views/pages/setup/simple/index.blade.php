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

                if (username == '' || username.length < 8 || username.length > 20 || regex.test(username)) {
                    return true;
                }

                const isAvailable = await checkAvailability('username', username);
                return !isAvailable;
            } else if (step == 'two') {

                if (firstName == '' || surname == '' || artistName == '' || email == '' || password == '' || password.length < 6 || country == '' || city == '') {
                    return true;
                }

                if (!isValidEmail(email)) {
                    return true;
                }

                const isAvailable = await checkAvailability('email', email);
                return !isAvailable;
            }else if (step == 'three') {

                if (mainSkill == '') {
                    return true;
                }
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
                        $(this).removeClass('is-busy');
                    } else if (currentStep.attr('data-step') == 'two') {
                        if (await validateStep('two')) {
                            console.log('Validation failed');
                            $('#error-span').removeClass('hidden');
                            $(this).removeClass('is-busy');
                            return;
                        }

                        activateStep('three');
                        var recaptchaScriptUrl = 'https://www.google.com/recaptcha/api.js';
                        $('.google-recaptcha').html('<div class="g-recaptcha" data-sitekey="6Lf2wLgnAAAAAAyelpUjpxzAHH9y8ea1k8FrtvCV"></div>');
                        loadScript(recaptchaScriptUrl, function () {});
                        $(this).removeClass('is-busy');
                    } else if (currentStep.attr('data-step') == 'three') {
                        if (await validateStep('three')) {
                            console.log('Validation failed');
                            $('#error-span').removeClass('hidden');
                            return;
                        }

                        $('#register-form').submit();
                    }
                }
            });

            $('body').delegate('.each-step.filled-step', 'click', function(e){
                activateStep($(this).attr('data-step'));
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
                                    var response = '<div class="my-dropdown-item no_results p-3 text-center">No results</div>';
                                }else{
                                    var response = '';
                                }
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var name = eachResultRow['name'] ? eachResultRow['name'] : (eachResultRow['value'] ? eachResultRow['value'] : eachResultRow[1]);
                                        var id = eachResultRow['id'];
                                        response += '<div data-id="'+id+'" class="my-dropdown-item p-3 cursor-pointer hover:bg-gray-50">'+name+'</div>';
                                    }
                                }
                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = '<div class="my-dropdown-item no_results p-3 text-center">No results</div>'; }

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

    <div class="w-full pt-6 pb-6">
        <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Welcome to 1Platform</h2>
        <p class="mt-1 text-sm text-gray-500 text-center">1Platform: Your essential tool for music career success</p>
        <nav aria-label="Progress" class="pt-16 pb-12">
            <ol role="list" class="space-y-4 md:flex md:space-x-8 md:space-y-0">
                <li data-step="one" class="each-step md:flex-1">
                    <div class="each-step-in flex flex-col border-l-4 cursor-pointer border-gray-200 hover:border-gray-300 py-2 pl-4 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                        <span class="each-step-title text-sm font-medium text-gray-500 group-hover:text-gray-700">Step 1</span>
                        <span class="each-step-name text-sm font-medium">Username and currency</span>
                    </div>
                </li>
                <li data-step="two" class="each-step md:flex-1">
                    <div class="each-step-in flex flex-col border-l-4 py-2 pl-4 cursor-pointer border-gray-200 hover:border-gray-300 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                        <span class="each-step-title text-sm font-medium text-gray-500 group-hover:text-gray-700">Step 2</span>
                        <span class="each-step-name text-sm font-medium">Add personal information</span>
                    </div>
                </li>
                <li data-step="three" class="each-step md:flex-1">
                    <div class="each-step-in flex flex-col border-l-4 py-2 pl-4 group cursor-pointer border-gray-200 hover:border-gray-300 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                        <span class="each-step-title text-sm font-medium text-gray-500 group-hover:text-gray-700">Step 3</span>
                        <span class="each-step-name text-sm font-medium">Add media information</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    @if (Session::has('error'))
        <div class="flash-container rounded-md p-4 bg-red-50 text-red-800 mb-4 flex flex-row items-center">
            <div>
                <i class="fa fa-times-circle"></i>
                {{ (is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error') }}
            </div>
            <div class="close-btn cursor-pointer ml-auto text-red-800">
                <i class="fa fa-times"></i>
            </div>
        </div>
    @elseif(Session::has('profile_saved'))
        <div class="flash-container rounded-md p-4 bg-green-50 text-green-800 mb-4 flex flex-row items-center">
            <div>
                <i class="fa fa-check-circle"></i>
                Saved successfully
            </div>
            <div class="close-btn cursor-pointer ml-auto text-green-800">
                <i class="fa fa-times"></i>
            </div>
        </div>
    @endif
    <div class="bg-white rounded-lg">
        <form id="register-form" action="{{route('register.user')}}" method="POST">
            {{csrf_field()}}
            <div class="mx-6 py-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900 mb-2"><span id="step-name"></span></h2>
                <div data-step="one" class="each-step-body space-y-12 sm:space-y-16 hidden">
                    <div class="space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_username" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Username</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">1platform.tv/</span>
                                    <input type="email" id="username" name="username" autocomplete="on" class="w-0 h-0">
                                    <input type="text" name="fake_username" id="fake_username" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="janesmith">
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">The username must be between 8 and 20 characters long and must not contain white spaces</p>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="currency" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Currency</label>
                            <div class="mt-2 sm:col-span-2 ring-1 ring-inset rounded-md ring-gray-300 sm:mt-0">
                                <select id="currency" name="currency" autocomplete="off" class="h-10 block w-full rounded-md border-0 py-1.5 text-gray-900 outline-none bg-transparent sm:text-sm sm:leading-6">
                                    <option value="gbp">GBP</option>
                                    <option value="eur">EUR</option>
                                    <option value="usd">USD</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-step="two" class="each-step-body space-y-12 sm:space-y-16 hidden">
                    <div class="space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="firstname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">First name</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input type="text" id="firstname" name="firstName" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="surname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Surname</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input type="text" id="surname" name="lastName" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="artistname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Artist name</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input value="{{$prefill ? $prefill['name'] : ''}}" type="text" id="artistname" name="name" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">This will be your public name</p>
                            </div>
                        </div>
                        @if(!$prefill)
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="emailaddress" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Email</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input type="text" id="emailaddress" name="email" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        @else
                        <input type="hidden" id="emailaddress" name="email" autocomplete="off" value="{{$prefill['email']}}">
                        @endif
                        <input type="hidden" name="user_id" autocomplete="off" value="{{$prefill['id']}}">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_password" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Password</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input type="password" id="password" name="password" autocomplete="off" class="hidden">
                                    <input type="password" id="fake_password" name="password" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">Must be at least 6 characters long</p>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="countryname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Country</label>
                            <div class="my-dropdown-container relative mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input type="hidden" id="country_id" name="country_id" value="">
                                    <input data-uri="/searchCountries" data-well="country-dropdown" id="country_name" type="text" autocomplete="off" class="platform-searchable block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="Search here">
                                </div>
                                <div class="hidden my-dropdown country-dropdown absolute top-full border pt-2 text-sm divide-y border-t-0 left-0 w-full max-h-[300px] z-50 bg-white flex flex-col">

                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="cityname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">City</label>
                            <div class="my-dropdown-container relative mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input type="hidden" id="city_id" name="city_id" value="">
                                    <input data-uri="/searchCities" data-well="city-dropdown" id="city_name" type="text" autocomplete="off" class="platform-searchable block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="Search here">
                                </div>
                                <div class="hidden my-dropdown city-dropdown absolute top-full border pt-2 text-sm divide-y border-t-0 left-0 w-full max-h-[300px] z-50 bg-white flex flex-col">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-step="three" class="each-step-body space-y-12 sm:space-y-16 hidden">
                    <div class="space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="skillname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Main skill</label>
                            <div class="my-dropdown-container relative mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input data-uri="/searchSkills" data-well="main-skill-dropdown" id="main_skill_name" name="skill" type="text" autocomplete="off" class="platform-searchable block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="Search here">
                                </div>
                                <div class="hidden my-dropdown main-skill-dropdown absolute top-full border pt-2 text-sm divide-y border-t-0 left-0 w-full max-h-[300px] z-50 bg-white flex flex-col">

                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="otherskillname" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Other skill</label>
                            <div class="my-dropdown-container relative mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 outline-none">
                                    <input data-uri="/searchSkills" data-well="other-skill-dropdown" id="other_skill_name" name="sec_skill" type="text" autocomplete="off" class="platform-searchable block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="Search here">
                                </div>
                                <div class="hidden my-dropdown other-skill-dropdown absolute top-full border pt-2 text-sm divide-y border-t-0 left-0 w-full max-h-[300px] z-50 bg-white flex flex-col">

                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="genre" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Genre</label>
                            <div class="mt-2 sm:col-span-2 ring-1 ring-inset rounded-md ring-gray-300 sm:mt-0">
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
                            <div class="mt-2 sm:col-span-2 ring-1 ring-inset rounded-md ring-gray-300 sm:mt-0">
                                <select id="level" name="level" autocomplete="off" class="h-10 block w-full rounded-md border-0 py-1.5 text-gray-900 outline-none bg-transparent sm:text-sm sm:leading-6">
                                    <option value="">Choose an option</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Professional">Professional</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row items-end justify-between">
                    <div class="mt-6 google-recaptcha"></div>
                    <div class="mt-6 flex flex-col justify-end gap-x-6 ml-auto">
                        <button type="button" class="next-btn inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 outline-none">Next</button>
                    </div>
                </div>
                <div class="flex">
                    <p id="error-span" class="mt-3 text-sm leading-6 text-red-600 hidden ml-auto">There is some validation error</p>
                </div>
            </div>
        </form>
    </div>

@endsection
