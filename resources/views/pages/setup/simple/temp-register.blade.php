@extends('templates.profile-setup-template')

@section('pagetitle') Create an account @endsection


@section('pagekeywords')
@endsection


@section('pagedescription')
@endsection


@section('seocontent')
@endsection


@section('page-level-css')

    <style>

    </style>
@endsection


@section('page-level-js')

    <script>

        let isLoading = false;

        function validateForm () {

            let error = false;
            let errorMessage = '';

            const fullName = $('#fake_name');
            const email = $('#fake_email');
            const password = $('#fake_password');
            const confirmPassword = $('#fake_confirm_password');
            const musicLink = $('#music_link');
            const skill = $('#skill');

            if(fullName.val() == ''){
                errorMessage = 'Full name is required';
                error = true;
            } else if (email.val() == '') {
                errorMessage = 'Email is required';
                error = true;
            } else if (password.val() == '') {
                errorMessage = 'Password is required';
                error = true;
            } else if (confirmPassword.val() == '') {
                errorMessage = 'Confirm password is required';
                error = true;
            } else if (password.val().length < 6) {
                errorMessage = 'Password must be at least 6 characters long';
                error = true;
            } else if (password.val() != '' && password.val().length >= 6 && confirmPassword.val() != '' && password.val() != confirmPassword.val()) {
                errorMessage = 'Passwords do not match';
                error = true;
            } else if (skill.val() == '') {
                errorMessage = 'Skill is required';
                error = true;
            } else if (musicLink.val() == '') {
                errorMessage = 'Work link is required';
                error = true;
            }

            return { error: error, errorMessage: errorMessage };
        }

        function resetForm () {

            $('#fake_name').val('');
            $('#fake_email').val('');
            $('#fake_password').val('');
            $('#fake_confirm_password').val('');
            $('#music_link').val('');
            $('#skill').val('');
        }

        $('document').ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submit_btn').click(function(){

                if (!isLoading) {

                    const response = validateForm();
                    if (response.error) {
                        $('#error-span').text(response.errorMessage).removeClass('hidden');
                        return;
                    }

                    isLoading = true;
                    $('#submit_btn').prop('disabled', true);
                    const fullName = $('#fake_name');
                    const email = $('#fake_email');
                    const password = $('#fake_password');
                    const confirmPassword = $('#fake_confirm_password');
                    const skill = $('#skill');
                    const musicLink = $('#music_link');
                    const industry = $('#industry');

                    const formData = new FormData();
                    formData.append('username', fullName.val().replace(/\s/g,''));
                    formData.append('currency', 'gbp');
                    formData.append('firstName', fullName.val());
                    formData.append('lastName', '');
                    formData.append('name', fullName.val());
                    formData.append('email', email.val());
                    formData.append('industry', industry.val());
                    formData.append('password', password.val());
                    formData.append('skill', skill.val());
                    formData.append('music_url', musicLink.val());

                    fetch('api/vet/user', {
                        method: 'POST',
                        body: formData,
                    })
                    .then((res) => res.json())
                    .then((response) => {

                        isLoading = false;
                        $('#submit_btn').prop('disabled', false);
                        if (response.success) {
                            $('#error-span').addClass('hidden');
                            $('#success-span').removeClass('hidden').text(response.message);
                        } else {
                            $('#error-span').removeClass('hidden').text(response.message);
                            $('#success-span').addClass('hidden');
                        }

                        resetForm();
                    });
                }
            });
        });
    </script>

@endsection

@section('page-content')

<div class="">
    <div class="w-full pt-6 pb-6">
        <h2 class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">Welcome to 1Platform</h2>
        <p class="mt-1 text-sm text-center text-gray-500">Manage, Network and Sell - All in one platform</p>
    </div>
    <div class="bg-white rounded-lg">
        <form action="" method="POST">
            {{csrf_field()}}
            <div class="py-12 mx-6">
                <h2 class="mb-2 text-base font-semibold leading-7 text-gray-900"><span id="step-name"></span></h2>
                <div class="space-y-12 each-step-body sm:space-y-16">
                    <div class="pb-12 space-y-8 border-b border-gray-900/10 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_username" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Choose Your Industry</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <select name="industry" id="industry" class="h-10 block w-full rounded-md border-0 py-1.5 text-gray-900 outline-none bg-transparent sm:text-sm sm:leading-6">
                                        <option selected value="1">Music / Media Industry</option>
                                        <option value="2">Construction Indsustry</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_username" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Full Name</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="text" id="name" name="name" autocomplete="on" class="w-0 h-0">
                                    <input type="text" name="fake_name" id="fake_name" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="Jane Smith">
                                </div>
                                <p class="text-sm leading-6 text-gray-500">This will be your public name</p>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_username" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Email</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="email" id="email" name="email" autocomplete="on" class="w-0 h-0">
                                    <input type="text" name="fake_email" id="fake_email" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="janesmith@example.com">
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_password" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Password</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="password" id="password" name="password" autocomplete="on" class="w-0 h-0">
                                    <input type="password" name="fake_password" id="fake_password" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                                <p class="text-sm leading-6 text-gray-500">Must be at least of 6 characters length</p>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_password" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Confirm Password</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="password" id="confirm_password" name="password" autocomplete="on" class="w-0 h-0">
                                    <input type="password" name="fake_confirm_password" id="fake_confirm_password" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_password" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Your main skill</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="text" name="skill" id="skill" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="fake_password" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Link</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="flex rounded-md shadow-sm outline-none ring-1 ring-inset ring-gray-300">
                                    <input type="text" name="music_link" id="music_link" autocomplete="off" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" placeholder="https://www.mywebsite.com/janesmith-work">
                                </div>
                                <p class="text-sm leading-6 text-gray-500">Add a link here to your work skills and experience</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row justify-between items-center">
                        <div class="flex">
                            <p class="text-xs">
                                Creating an account with 1Platform means you agree to our <br><a class="underline" href="{{route('tc')}}">terms and conditions, </a>
                                <a class="underline" href="{{route('privacy.policy')}}">privacy policy</a> <span>,and</span> <a class="underline" href="{{route('faq')}}">FAQ </a>
                            </p>
                        </div>
                        <div class="flex flex-row lg:justify-end gap-x-6">
                            <button id="submit_btn" type="button" class="inline-flex justify-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm outline-none next-btn hover:bg-indigo-500">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex">
                    <p id="success-span" class="hidden mt-3 ml-auto text-sm leading-6 text-green-600">There is some validation error</p>
                    <p id="error-span" class="hidden mt-3 ml-auto text-sm leading-6 text-red-600">There is some validation error</p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('miscellaneous-html')

@endsection
