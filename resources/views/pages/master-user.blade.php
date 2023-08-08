
@extends('templates.basic-template')


@section('pagetitle') 1Platform Login @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <style type="text/css">

        body { background-image: url(https://www.1platform.tv/images/chart_back_04.jpg); background-size: cover; background-position: top center; background-repeat: no-repeat; }
        .auth_box_outer .form_group input { background: #ccc none repeat scroll 0 0; border-radius: 23px; height: 48px; }
        .auth_box_outer .login_button_outer { background-color: #333; box-shadow: unset; border-radius: 27px; }
        .auth_box_outer .login_button_outer input { height: 40px; }
        .auth_box_outer { border: 0; opacity: 0.75; }
        .register_button_outer a { font-size: 14px !important; font-weight: bold; }
        .register_button_outer { text-align: center; background: none; border: none; box-shadow: unset; text-transform: uppercase; }


        @media (min-width:320px) and (max-width: 767px) {

            body { background-size: auto; }
            .auth_box_outer .form_group input { height: 38px; }
            .auth_box_outer .login_button_outer input { height: 30px; }
        }
    </style>
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

    <script type="text/javascript">
        $('document').ready(function(){


        });
    </script>
@stop

<!-- Page Header !-->
@section('header')
    @include('parts.header')
@stop


@section('flash-message-container')
    @if (Session::has('success'))
        <div class="success_span">{{ Session::get('success') }}</div>
    @endif

    @if (Session::has('music_search_filters'))
        @php Session::put('remember_music_search_filters', Session::get('music_search_filters')) @endphp
    @endif

    @if (Session::has('error'))

        <div class="error_span">
            {{ (is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error') }}
        </div>

    @endif
@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')
@stop


@section('page-content')

    <div class="hm_video_sec_outer">

        <div class="video_upper_sec">
            <div class="auto_content">
                <div class="video_upper_inner">
                    <div class="auth_box_outer">

                        <div class="auth_top_logo">
                            <a class="logo8" href="{{route('site.home')}}">
                                <img src="{{asset('images/1logo9.png')}}" alt="" />
                                <div>Platform</div>
                            </a>
                        </div>

                        <div class="auth_box_inner">
                            <form class="form-horizontal" method="POST" action="{{ route('post.master.user') }}">
                                {{ csrf_field() }}

                                <div class="form_group">
                                    <input required id="email_address" type="email" class="form_input" name="email" />
                                </div>
                                <div class="form_group">
                                    <input required id="password" type="password" class="form_input" name="password" />
                                </div>
                                <div class="form_group">
                                    <label style="color:#fff;font-size: 20px; font-weight: bold;">Enter email to login as</label>
                                    <input required style="margin-top: 10px;" type="text" class="form_input" name="fghj" />
                                </div>

                                <div class="login_button_outer">
                                    <input type="submit" value="Log in">
                                </div><br /><br />
                                <div class="register_button_outer">

                                </div>
                                <div class="login_register_text_02">
                                    <span style="color: #fff; font-weight: bold;">Creating an account with the 1Platform TV, means you agree to our </span><a href="{{ asset("tc") }}">terms and conditions, </a><a href="">privacy policy</a>
                                </div>
                            </form>
                            <!--
                            <div class="each_side">
                                <div class="each_soc_login_c">
                                    <a class="hm_fb_icon" href="{{ asset("login/facebook") }}">
                                        <img class="prevent_pre_loading" src="{{asset('images/hm_fb_icon.png')}}" />
                                    </a>
                                </div>
                                <div class="each_soc_login_c">
                                    <a class="hm_tw_icon" href="{{ asset("login/twitter") }}">
                                        <img class="prevent_pre_loading" src="{{asset('images/hm_tw_icon.png')}}" />
                                    </a>
                                </div>
                                <div class="each_soc_login_c">
                                    <a class="hm_gm_icon" href="{{ asset("login/google") }}">
                                        <img class="prevent_pre_loading" src="{{asset('images/hm_gm_icon.png')}}" />
                                    </a>
                                </div>
                                <div class="each_soc_login_c hide_on_mobile">
                                    <a id="login_at_login" class="hm_login_icon" href="javascrit:void(0)">
                                        <img class="prevent_pre_loading" src="{{asset('images/hm_login_icon.png')}}" />
                                    </a>
                                </div>
                            </div>!-->
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
