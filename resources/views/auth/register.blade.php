@extends('templates.setup-template')

@section('pagetitle') Create your account at 1 Platform @endsection


@section('pagekeywords') 
@endsection


@section('pagedescription') 
@endsection


@section('seocontent') 
@endsection


@section('page-level-css')
    
    <link href="{{asset('css/auth.min.css')}}" rel="stylesheet" type="text/css" />

    <style>

        body { background: #fff; }
        .setup_outer { width: 100%; }
        .wrapper { width: 100%; position: relative; }
        .setup_inner { max-width: 55%; margin: 40px auto; padding: 15px; border: 1px solid #ccc; border-radius: 5px; background: #fff; }
        .setup_tray_main { margin-bottom: 20px; }
        .pro_main_tray,#email_section, #bio_section form h2, .no_results, .pro_stripeless_outer { display: none; }
        .setup_tray_main { display: flex; flex-direction: row; align-items: flex-start; justify-content: space-between; padding-bottom: 19px; border-bottom: 1px solid #ccc; }
        .setup_tray_step { font-size: 12px; margin-bottom: 10px; }
        .setup_tray_head { font-size: 17px; }
        .setup_tray_right { display: flex; flex-direction: row; }
        .setup_tray_btn { display: flex; flex-direction: row; padding: 5px; font-size: 12px; border-radius: 3px; cursor: pointer; width: 60px; align-items: center; }
        .setup_tray_btn a { color: #fff; text-decoration: none; }
        .setup_back_btn { background: #000; color: #fff; margin-right: 5px; justify-content: flex-start; }
        .setup_skip_btn { background: #0069d9; color: #fff; justify-content: flex-end; }
        .setup_next_btn { background: #0069d9; color: #fff; justify-content: flex-end; }
        .setup_tray_info { font-size: 15px; margin-top: 8px; line-height: 16px; background: #0069d9; color: white; padding: 8px; }
        .setup_welcome { margin: auto; width: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .setup_welcome_head { font-size: 26px; margin-bottom: 8px; } 
        .setup_welcome_sub_head { font-size: 13px; }
        .setup_welcome .edit_profile_btn_1 { width: 100%; }
        .manager_chat_option { display: flex; flex-direction: row; align-items: center; margin: 50px 0; } 
        .manager_chat_option span {  cursor: pointer; padding: 10px; border: 1px solid #f1f1f1; margin: 0 2px; }

        .reg_error{ float: left; text-align: left; font-size: 12px; color: #fc064c; display: none; }
        .setup_signup input[type="text"],input[type="password"],input[type="url"]{ width: 100%; color: #000; padding: 5px; font-size: 14px; height: 38px; border: 1px solid rgb(230, 230, 230); margin: 2px 0; }
        .setup_signup input[type="submit"] { background-color: rgb(39, 40, 42); color: #fff; padding: 9px; text-align: center; cursor: pointer; width: 99%; margin: 0 auto; display:  block; transition: all 0.1s linear 0s; text-transform: uppercase; border-radius: 3px; }
        .startup_wizard_signup_row { margin-bottom: 19px; }
        #verify_code_outer { position: relative; }
        #verify_code_actual { position: absolute; top: 0; right: 0; bottom: 0; display: flex; margin: 2px 0; align-items: center; justify-content: center; background-color: rgb(39, 40, 42); color: #fff; padding: 9px; text-align: center; }

        @media (min-width:320px) and (max-width: 767px) {

            body { background: none; }
            .setup_inner { margin: unset; border: unset; border-radius: unset; max-width: 100%; }
            .setup_welcome { max-width: 100%; height: 80vh; }

            .startup_wizard_signup_row { margin: 0; }

            .content_outer { margin-top: 0 !important; padding: 0 !important; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; background: #fff; }
            header { display: none; }
            .startup_wizard_head { margin: 0 6px 20px 6px; justify-content: space-between; }
            .wizard_head_each_step { flex: 0 1 32% !important; margin-right: 0px!important; }
        }

    </style>

@endsection


@section('page-level-js')

    <script>

        function validateRegister(){
            var success = true;
            var name = $("#register-form input[name=name]").val();
            var firstName = $("#register-form input[name=firstName]").val();
            var lastName = $("#register-form input[name=lastName]").val();
            var email = $("#register-form input[name=email]").val();
            var contact_number = $("#register-form input[name=contact_number]").val();
            var confirm_email = $("#register-form input[name=email_confirmation]").val();
            var pwd = $("#register-form input[name=password]").val();
            var verify_code = $("#register-form input[name=verify_code]").val();

            $('.reg_error').hide();

            if(name == ''){
                //$("#name_error").text('Name is required').show();
                //success = false;
            }

            if(firstName == ''){
                $("#first_name_error").text('First Name is required').show();
                success = false;
            }

            if(lastName == ''){
                $("#last_name_error").text('Last Name is required').show();
                success = false;
            }

            if(email == ''){
                $("#email_error").text('Email is required').show();
                success = false;
            }
            if(confirm_email == ''){
                $("#confirm_email_error").text('Email confirmation is required').show();
                success = false;
            }
            if(email != '' && confirm_email != '' && email != confirm_email){
                $("#email_error,#confirm_email_error").text('Email do not match').show();
                success = false;
            }
            if(email != '' && confirm_email != '' && email == confirm_email && !validateEmail(email)){
                $("#email_error").text('Email is not valid').show();
                success = false;
            }
            if(verify_code == ''){
                //$("#verify_code_error").text('Required').show();
                //success = false;
            }

            if(pwd == ''){
                $("#pwd_error").text('Password is required').show();
                success = false;
            }else if(pwd.length < 6){
            	$("#pwd_error").text('Password should be at least 6 characters long').show();
                success = false;
            }
            if(contact_number == ''){
                //$("#contact_number_error").text('Contact number is required').show();
                //success = false;
            }
            return success;
        }

        $(document).ready(function(){

            $('.manager_chat_option span').click(function(){

                if($(this).attr('data-manager-action') == 'yes'){
                    
                    $('input[name="managerChat"]').val(1);
                }
                $('.setup_welcome').addClass('instant_hide');
                $('.setup_signup').removeClass('instant_hide');
            });

        });

    </script>

@endsection


@section('flash-message-container')
    
    @if (Session::has('error'))

        <div class="error_span">
            <i class="fa fa-times-circle"></i> 
            {{ (is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error') }}
        </div>
    @endif

@endsection


@section('page-content')
    
    <div class="setup_welcome {{Session::has('error') ? 'instant_hide' : ''}}">
        <div class="setup_logo">
            <img src={{asset('images/test/setup_welcome.gif')}}>
        </div>
        <div class="setup_welcome_head">
            Welcome to 1 Platform
        </div>
        <div class="setup_welcome_sub_head">
            Let's setup your profile on 1 Platform
        </div>
        <div class="manager_chat_option clearfix">
            <span data-manager-action="yes">I Want To Chat With A Manager Now</span>
            <span data-manager-action="no">No thanks, continue</span>
        </div>
    </div>

    <div class="setup_signup {{!Session::has('error') ? 'instant_hide' : ''}}">
        
        <div class="setup_tray_main">
            <div class="setup_tray_left">
                <div class="setup_tray_step">
                    Step 1 of 19
                </div>
                <div class="setup_tray_head">
                    Add name and email
                </div>
            </div>
            <div class="setup_tray_right">
                <div class="setup_tray_btn setup_back_btn">
                    <a href="{{route('register')}}"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back</a>
                </div>
            </div>
        </div>

        <form class="form-horizontal" id="register-form" method="POST" action="{{ route('register.user') }}" onsubmit="return validateRegister()">
            {{ csrf_field() }}
            <input class="dummy_field" type="text" id="email_address_0" name="email_0">
            <input class="dummy_field" type="password" name="fakeusernameremembered">
            <input type="hidden" name="managerChat" value="0" />
            @if(isset($userId) && $userId)
            <input type="hidden" name="user_id" value="{{$userId}}" />
            @endif
            <div class="startup_wizard_signup_row">
                <div class="form_group">
                    <input placeholder="First Name" type="text" class="form_input" value="{{ old('firstName', $firstName) }}" name="firstName" id="first_name" />
                    <span id="first_name_error" class="reg_error"></span>
                </div>
                <div class="form_group">
                    <input placeholder="Last Name" type="text" class="form_input" value="{{ old('lastName', $lastName) }}" name="lastName" id="last_name" />
                    <span id="last_name_error" class="reg_error"></span>
                </div>
            </div>
            <div class="startup_wizard_signup_row">
                <div class="form_group">
                    <input placeholder="Email" type="text" class="form_input {{ ($errors->has('email')) ? 'auth_error' : '' }}" value="{{ old('email', $email) }}" name="email" id="email_address" />
                    <span id="email_error" class="reg_error"></span>
                </div>
                <div class="form_group">
                    <input placeholder="Confirm Email" type="text" class="form_input {{ ($errors->has('email')) ? 'auth_error' : '' }}" value="{{ old('email_confirmation', $email) }}" name="email_confirmation" id="email_address" />
                    <span id="confirm_email_error"  class="reg_error"></span>
                </div>
            </div>
            <div class="startup_wizard_signup_row">
                <div class="form_group">
                    <input placeholder="Password" type="password" class="form_input {{ ($errors->has('password')) ? 'auth_error' : '' }}" name="password" id="password" />
                    <span id="pwd_error" class="reg_error"></span>
                </div>
            </div>
            <div class="login_register_text_02">
                <span>By clicking SUBMIT, you agree to our</span>
                <a href="{{route('tc')}}">terms and conditions, </a>
                <a href="{{route('privacy.policy')}}">privacy policy</a>
            </div><br />
            <div class="">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>


@endsection


@section('miscellaneous-html')

    @php Illuminate\Support\Facades\Session::forget('error'); @endphp

@endsection
