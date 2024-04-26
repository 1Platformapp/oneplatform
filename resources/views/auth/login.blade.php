


@extends('templates.basic-template')


@section('pagetitle') 1 Platform | Login @endsection

@section('pagekeywords')
    <meta name="keywords" content="1platform login,artists,musicians,discover music,songs,songwriters,producers,filmmakers,raise money,promote music,sell music, content creators,connect people,networking,distribution,premium streams,creative,business,sell,music,music license,crowdfunding,studios,online store,gigs,merchandise,bespoke license,music industry" />
    @if(Config('constants.primaryDomain') != $_SERVER['SERVER_NAME'])
    <meta name="robots" content="noindex, nofollow" />
    @endif
@endsection

@section('pagedescription')
    <meta name="description" content="Login to your 1platform account"/>
@endsection

@section('seocontent')
    <h1 class="main_heading">1 Platform Login</h1>
    <h2 class="second_heading">Discover music and support its creators</h2>
    <h3 class="second_heading">Create a networking agency, register networks under your agency and earn commission from each of your network sales</h3>
@endsection

<!-- Page Level CSS !-->
@section('page-level-css')
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}" >
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <style type="text/css">

        .auto_content { width: 100%; }
        .video_upper_inner { background-image: url(https://www.1platform.tv/images/chart_back_04_2.jpg); background-size: cover; background-position: top center; background-repeat: no-repeat; }
        .auth_box_outer { width: 45%; padding: 0 5em 10em; position: relative; top: -60px; }
        .auth_box_outer .form_group input { font-size: 15px; background: #ccc none repeat scroll 0 0; border-radius: 23px; height: 40px; }
        .auth_box_outer .login_button_outer { background-color: #333; box-shadow: unset; border-radius: 27px; }
        .auth_box_outer .login_button_outer input { height: 27px; font-family: 'Montserrat', sans-serif; font-size: 15px; }
        .auth_box_outer { padding-top: 150px; border-radius: 3px; border-color: #818181; opacity: 0.75; background: #444; }
        .register_button_outer a { font-size: 14px !important; font-weight: bold; }
        .register_button_outer { background-color: #818181; box-shadow: unset; border-radius: 27px; height: 37px; display: flex; text-align: center; text-transform: uppercase; align-items: center; justify-content: center; }
        .video_upper_inner { display: flex; flex-direction: column; justify-content: space-between; padding: 0 80px 40px; }
        .auth_top_logo { position: relative; top: 40px; display: flex; align-items: center; justify-content: center; z-index: 1; }
        .auth_social_logins_outer { position: relative; width: 40%; }
        .auth_head_section { width: 40%; margin: 0 auto; text-align: center; position: relative; top: 50px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #fff; z-index: 1; }
        .auth_head_secon { margin-top: 15px; font-size: 12px; }
        .auth_head_main { font-size: 24px; }
        .auth_head_section { font-family: 'Montserrat', sans-serif; }
        .each_port_up { border-radius: 3px; }
        .portfolio_each .back { background-repeat: no-repeat; background-position: center; }

        @media (min-width:320px) and (max-width: 767px) {

            body { background-size: auto; }
            .auth_box_outer { top: -35px; width: unset; padding: 114px 10px !important; margin: 0 10px; }
            .auth_box_outer .form_group input { height: 38px; }
            .auth_box_outer .login_button_outer input { height: 30px; }
            .auth_social_logins_inner { width: 100%; }
            .auth_social_logins_outer { bottom: 127px; width: 90%; }
            .register_button_outer { height: 40px; }
            .auth_head_section { width: 90%; top: 50px; }
            .auth_head_main { font-size: 18px; }
            .auth_head_secon { margin-top: 10px; font-size: 10px; }
            .each_port_up { max-height: 80px; }

            .content_outer { margin-top: 0 !important; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; background: #fff; }
            header { display: none; }
            .auth_container { padding: 15px 25px; margin: 0 10px; }
            .logo_container { display: flex; flex-direction: row; align-items: center; justify-content: center; margin-bottom: 15px; }
            .auth_each_field input { height: 34px; border: 1px solid #000; width: 100%; border-radius: 6px; padding: 5px; color: #000; }
            .auth_each_field input.margin { margin-bottom: 20px; }
            .login_resp .forgot_password { display: inherit; text-align: right; font-size: 12px; margin-top: 10px; }
            .auth_btn_submit input { width: 100%; color: #fff; background: #000; height: 28px; border-radius: 6px; margin-bottom: 15px; margin-top: 20px; }
            .auth_btn_helper a { width: 100%; color: #000; border: 1px solid #000; padding: 5px; border-radius: 5px; display: inline-block; text-align: center; }
            .logo8 img { height: 26px; }
            .logo8 { font-size: 15px; }

            ::-webkit-input-placeholder { color: #000; }
            :-moz-placeholder { color: #000; opacity:  1; }
            ::-moz-placeholder { color: #000; opacity:  1; }
            :-ms-input-placeholder { color: #000; }
            ::-ms-input-placeholder { color: #000; }
            ::placeholder { color: #000; }
        }
        @media (min-width:1366px){

            .each_port_up { max-height: 140px; }
            .auth_social_logins_outer { bottom: 162px; }
            .portfolio_each { flex: 0 1 22%; margin-right: 3%; }
        }
        @media (min-width:1024px) and (max-width: 1365px) {

            .auth_box_outer { width: 60%; }
            .each_port_up { max-height: 140px; }
            .auth_social_logins_outer { bottom: 176px; }
            .login_register_text_02 br { display: none; }
        }
        @media (min-width:1600px) and (max-width: 1920px) {

            .auth_head_section { top: 95px; }
            .auth_box_outer { top: -20px; }
            .auth_social_logins_outer { bottom: 162px; }
            .auth_social_logins_outer { bottom: 130px; }
        }

        .home_section_music { padding: 55px 0 80px 0; text-align: center; font-family: 'Montserrat', sans-serif; }
        .home_section_music h2 { font-size: 43px; }
        .home_section_music h4 { margin-top: 15px; font-size: 20px; }
        .home_section_spacer { background-color: #dbe1e5; min-height: 5px; margin-bottom: 20px; }
        .home_section_portfolio { font-family: 'Montserrat', sans-serif; padding: 20px 30px; }
        .portfolio_outer { font-family: 'Montserrat', sans-serif; }
        .home_section_portfolio h2 { font-size: 20px; margin-bottom: 30px; }
        .home_section_portfolio h2 span { font-size: 30px; }
        .home_section_packages { margin-top: 50px; font-family: 'Montserrat', sans-serif; padding: 20px 30px; }
        .home_section_packages .header { padding: 20px 0; background: #222; color: #fff; }
        .home_section_packages h2 { font-size: 30px; text-align: center; }
        .home_section_packages h4 { text-align: center; margin-top: 15px; font-size: 16px; margin-bottom: 20px; }


        .portfolio_det_elem_each iframe { max-width: 800px; margin: 20px auto 0 auto; }
        .int_sub_liner .int_sub_offer_each, .int_sub_liner .int_sub_dhead { font-weight: normal; }

    </style>
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

    <script type="text/javascript">

        window.fbAsyncInit = function() {
            FB.init({
              appId      : '2410593049051877',
              cookie     : true,
              xfbml      : true,
              version    : 'v5.0'
            });

            FB.AppEvents.logPageView();
        };

        (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "https://connect.facebook.net/en_US/sdk.js";
           fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $('document').ready(function(){
            $('#trig_login_fb').click(function(){

                checkLoginState();
            });
            $('#login_at_login').click(function(){

                var browserWidth = $( window ).width();
                if( browserWidth >= 767 ) {
                    $('#email_address,#password').val('');
                    $('#email_address').focus();
                }
            });

            $('.int_sub_confirm').click(function(){
                window.location = '/register';
            });
        });

        function checkLoginState() {
          FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
          });
        }

        function proceedWithRegisteration(response) {
            FB.api('/me?fields=id,email,name', function(fbUser) {
                if(fbUser.error){
                    alert('This page is being reloaded. Click on facebook login button to verify yourself');
                    location.reload();
                }else{
                    var formData = new FormData();
                    formData.append('fbUserId', fbUser.id);
                    formData.append('fbUserName', fbUser.name);
                    formData.append('fbUserEmail', fbUser.email);
                    $.ajax({

                        url: '/login/facebook/callback',
                        type: 'POST',
                        data: formData,
                        contentType:false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {

                            window.location.href = response;
                        }
                    });
                }
            });
        }

        function statusChangeCallback(response){
            if(response.authResponse && response.status == 'connected'){
                proceedWithRegisteration(response);
            }else{
                FB.login(function(response){
                    if(response.authResponse && response.status == 'connected'){
                        proceedWithRegisteration(response);
                    }
                },{scope: 'public_profile,email'});
            }
        }
    </script>
@stop

<!-- Page Header !-->
@section('header')
    <div class="hide_on_mobile">
        @include('parts.header')
    </div>
@stop


@section('flash-message-container')
    @if (Session::has('success'))
        <div class="success_span">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('music_search_filters'))
        @php Session::put('remember_music_search_filters', Session::get('music_search_filters')) @endphp
    @endif
@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')
@stop


@section('page-content')

            <div class="auto_content">
                <div class="video_in">
                    <div class="login_resp hide_on_desktop">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}" style="width: 75%; margin: 0 auto;">
                            {{ csrf_field() }}
                            <div class="logo_container">
                                <a class="logo8" href="javascript:void(0)">
                                    <img alt="1platform" src="{{asset('images/1logo8.png')}}">
                                    <div>Platform</div>
                                </a>
                            </div>
                            <div class="auth_container">
                                <div class="auth_each_field">
                                    <input placeholder="Enter your email" required type="email" class="form_input margin {{ ($errors->has('email')) ? 'auth_error' : '' }}" value="{{ old('email') }}" name="email" id="email_address" />
                                </div>
                                <div class="auth_each_field">
                                    <input placeholder="Enter your password" required type="password" class="form_input {{ ($errors->has('email')) ? 'auth_error' : '' }}" name="password" id="password" />
                                </div>
                                <div class="auth_each_field">
                                    <a class="forgot_password" href="">Forgot password?</a>
                                </div>
                                <div class="auth_btn_submit">
                                    <input type="submit" value="Log In">
                                </div>
                                <div class="auth_btn_helper">
                                    <a href="{{ route('register') }}">Create an account</a>
                                </div>
                                <div width="400" class="login_register_text_02">
                                    <span>Creating an account with 1Platform<br> means you agree to our</span>
                                    <a href="{{route('tc')}}">terms and conditions, </a>
                                    <a href="{{route('privacy.policy')}}">privacy policy</a>
                                    <div>
                                        <span>Checkout our FAQs</span><br class="hide_on_mobile">
                                        <a href="{{route('faq')}}">here </a>
                                    </div>
                                </div>
                                <!--<a href="{{asset('login/google')}}" class="cursor-pointer bg-black h-[28px] mt-4 rounded-lg gap-3 flex flex-row items-center justify-center">
                                    <span class="text-white mt-[1px]">
                                        <i class="fab fa-google"></i>
                                    </span>
                                    <span class="text-white">Continue with google</span>
                                </a>!-->
                            </div>
                        </form>
                    </div>
                    <div class="video_upper_inner hide_on_mobile">
                        <div class="auth_head_section">
                            <h1 class="auth_head_main">
                                1Platform
                            </h1>
                            <h3 class="auth_head_secon">
                                Your complete suite of music<br>management tools, all in one place.
                            </h3>
                        </div>
                        <div class="auth_box_outer">
                            <div class="auth_box_inner">
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <div class="form_group">
                                        <input placeholder="Enter your email" required type="email" class="form_input {{ ($errors->has('email')) ? 'auth_error' : '' }}" value="{{ old('email') }}" name="email" id="email_address" />
                                    </div>
                                    <div class="form_group">
                                        <input placeholder="Enter your password" required type="password" class="form_input {{ ($errors->has('email')) ? 'auth_error' : '' }}" name="password" id="password" />
                                    </div>
                                    @if ($errors->any())
                                        <div class="relative px-4 py-3 mb-2 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="forgot_password_outer">
                                        <a class="forgot_password" href="">Forgot Your Password?</a>
                                    </div>
                                    <div class="login_button_outer">
                                        <input type="submit" value="LOG IN">
                                    </div><br /><br />
                                    <div class="register_button_outer">
                                        <a href="{{ route('register') }}">Create an account</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="auth_social_logins_outer">
                            <div class="auth_social_logins_inner">
                                <div class="auth_social_each auth_social_fb">
                                    <a id="trig_login_fb" href="javascript:void(0)">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                                <div class="auth_social_each auth_social_twit">
                                    <a href="{{asset('login/twitter')}}">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                                <div class="auth_social_each auth_social_google">
                                    <a href="{{asset('login/google')}}">
                                        <i class="fab fa-google"></i>
                                    </a>
                                </div>
                                <div class="auth_social_each auth_social_insta">
                                    <a href="{{asset('login/instagram')}}">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="login_register_text_02">
                                <span>Creating an account with 1Platform means you agree to our</span><br class="hide_on_mobile">
                                <a href="{{route('tc')}}">terms and conditions, </a>
                                <a href="{{route('privacy.policy')}}">privacy policy</a> <span>,and</span> <a href="{{route('faq')}}">FAQ </a>
                            </div>
                        </div>
                    </div>
                </div>
                @php $packages = config('constants.user_internal_packages') @endphp
                <div class="home_each_section home_section_packages hide_on_mobile">
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
                                    <div class="int_sub_offer_each"><span class="hide_on_mobile">Choose </span>Payment Plan</div>
                                    <div class="int_sub_offer_each">&nbsp;</div>
                                    <div class="int_sub_offer_each">
                                        <span> Fee Per Sale </span>
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
                                            <div class="int_sub_confirm">Sign Up</div>
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
                                            <div class="int_sub_confirm int_sub_pay">Sign Up</div>
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
                                            <div class="int_sub_confirm int_sub_pay">Sign Up</div>
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
                </div>
            </div>
@stop

@section('miscellaneous-html')

    <div id="body-overlay"></div>
    @include('parts.forget-password-pop-ups')
@stop
