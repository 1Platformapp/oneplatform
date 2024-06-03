
@extends('templates.basic-template')


@section('pagetitle') Support Andrew Sheridan @endsection

@section('pagekeywords')
@endsection

@section('pagedescription')
@endsection

@section('seocontent')
@endsection

<!-- Page Level CSS !-->
@section('page-level-css')
<link rel="stylesheet" href="{{asset('css/item-details.min.css?v=3.6')}}" >
@stop

@section('page-level-js')

    <script type="text/javascript">
        $('document').ready(function(){

            var back = $('.page_background').attr('data-url');
            $('.page_background').css('background-image', 'url('+back+')');

            $('#submit_btn').click(function(){

                const name = $('#supporter_name').val();
                const email = $('#supporter_email').val();
                const password = $('#supporter_password').val();
                let nameError = null;
                let emailError = null;
                let passwordError = null;
                let error = null;
                $('.error').addClass('hidden');

                if (name == '') {
                    nameError = 'Name is required';
                }

                if (email == '') {
                    emailError = 'Email is required';
                }

                if (password == '') {
                    passwordError = 'Password is required';
                } else if(password.length < 6) {
                    passwordError = 'Password must be at least 6 characcters long';
                }

                if(nameError) {
                    $('#name_error').text(nameError).removeClass('hidden');
                    error = 1;
                }

                if(passwordError) {
                    $('#password_error').text(passwordError).removeClass('hidden');
                    error = 1;
                }

                if(emailError) {
                    $('#email_error').text(emailError).removeClass('hidden');
                    error = 1;
                } else if(!validateEmail(email)) {
                    $('#email_error').text('Email is invalid').removeClass('hidden');
                    error = 1;
                }

                if (!error) {
                    $.ajax({

                        url: "/supporter-signup",
                        dataType: "json",
                        type: 'post',
                        data: {stage: 'one', name: name, email: email, user_id: {{$user->id}}},
                        success: function(response) {
                            if(response.success == 1){
                                $('.stage-one').addClass('hidden');
                                $('.stage-two').removeClass('hidden');
                            }else{
                                $('#submit_error').text(response.message).removeClass('hidden');
                            }
                        }
                    });
                }
            });

            $('#submit_btn_two').click(function(){

                const code = $('#verify_code').val();
                const name = $('#supporter_name').val();
                const email = $('#supporter_email').val();
                const password = $('#supporter_password').val();
                let codeError = null;
                let error = null;
                $('.error').addClass('hidden');

                if (code == '') {
                    codeError = 'Code is required';
                }

                if(codeError) {
                    $('#verify_code_error').text(codeError).removeClass('hidden');
                    error = 1;
                }

                if (!error) {
                    $.ajax({

                        url: "/supporter-signup",
                        dataType: "json",
                        type: 'post',
                        data: {stage: 'two', code: code, name: name, email: email, password: password},
                        success: function(response) {
                            if(response.success == 1){
                                $('.stage-one, .stage-two').addClass('hidden');
                                $('.show-success').removeClass('hidden');
                            }else{
                                $('#submit_error_verify').text(response.message).removeClass('hidden');
                            }
                        }
                    });
                }
            });
        });
    </script>

@stop

@section('header')

@stop

@section('audio-player')
@stop


@section('flash-message-container')
@stop

@section('social-media-html')
@stop


@section('page-content')

    <aside>
	    <div data-url="{{$user->custom_background ? '/user-media/background/'.$user->custom_background : $userProfileImage}}" class="page_background"></div>

	    <div class="back_link">
	    	<a href="{{route('user.home', ['params' => $user->username])}}">Back to {{$user->firstName()}}'s home</a>
	    </div>
	</aside>

    <main role="main">
        <div class="item_container">
            <div class="item_top">

            </div>
            <div class="item_bottom">
                <div class="item_info_box">
                    <div class="item_title">
                        <h1>Support {{$user->name}}</h1>
                        <p>Create an account to become a supporter</p>
                    </div>
                </div>
                <div class="stage-one flex flex-col bg-white p-4 m-2 gap-8">
                    <div class="flex flex-col rounded-md shadow-sm outline-none gap-2">
                        <label class="text-gray-700 text-sm" for="">Full Name</label>
                        <input type="text" class="py-2 block flex-1 border-0 bg-transparent ring-1 ring-inset ring-gray-300 py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" id="supporter_name" placeholder="Enter your name" />
                        <div id="name_error" class="error hidden text-sm leading-6 text-red-600"></div>
                    </div>
                    <div class="flex flex-col rounded-md shadow-sm outline-none gap-2">
                        <label class="text-gray-700" for="">Email address</label>
                        <input type="text" class="py-2 block flex-1 border-0 bg-transparent ring-1 ring-inset ring-gray-300 py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" id="supporter_email" placeholder="Enter email address" />
                        <div id="email_error" class="error hidden text-sm leading-6 text-red-600"></div>
                    </div>
                    <div class="flex flex-col rounded-md shadow-sm outline-none gap-2">
                        <label class="text-gray-700 text-sm" for="">Password (at least 6 characters long)</label>
                        <input type="password" class="py-2 block flex-1 border-0 bg-transparent ring-1 ring-inset ring-gray-300 py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" id="supporter_password" />
                        <div id="password_error" class="error hidden text-sm leading-6 text-red-600"></div>
                    </div>

                    <button id="submit_btn" type="button" class="inline-flex justify-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm outline-none next-btn hover:bg-indigo-500 ml-auto w-fit my-2">
                        Submit
                    </button>
                    <div id="submit_error" class="error hidden text-sm leading-6 text-red-600"></div>
                </div>
                <div class="stage-two flex flex-col bg-white p-4 m-2 gap-8 hidden">
                    <div class="flex flex-col rounded-md shadow-sm outline-none gap-2">
                        <label class="text-gray-700 text-sm" for="">Verification code from your email</label>
                        <input type="text" class="py-2 block flex-1 border-0 bg-transparent ring-1 ring-inset ring-gray-300 py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 outline-none sm:text-sm sm:leading-6" id="verify_code" placeholder="Enter your code" />
                        <div id="verify_code_error" class="error hidden text-sm leading-6 text-red-600"></div>
                    </div>

                    <button id="submit_btn_two" type="button" class="inline-flex justify-center px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm outline-none next-btn hover:bg-indigo-500 ml-auto w-fit my-2">
                        Submit
                    </button>
                    <div id="submit_error_verify" class="error hidden text-sm leading-6 text-red-600"></div>
                </div>
                <div class="show-success flex flex-col bg-white p-4 m-2 gap-8 hidden text-green-600">
                    Your request has been successfully sent to {{$user->firstName()}}. You will be notified once it is accepted
                </div>
            </div>
        </div>
	</main>
@stop

@section('miscellaneous-html')

	@include('parts.basket-popups')
	@include('parts.chart-popups')
@stop

@section('footer')

    @if($user->isCotyso())
        @include('parts.singing-footer')
    @endif

@stop
