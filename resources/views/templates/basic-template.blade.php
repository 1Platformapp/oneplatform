<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="facebook-domain-verification" content="cgl7a7tsl52bqf1y0il3lxntrv09ij" />
        <meta name="google-site-verification" content="AR1UIRB4nzeneJoD1RppX4OOJKzdrH3GLDc7O1jix9Q" />
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Cache-control" content="public">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="/css/app.css?v=3.20" rel="stylesheet" type="text/css" />
        <title>@yield('pagetitle')</title>
        @yield('pagekeywords', '')
        @yield('pagedescription', '')

        @if(\Request::route()->getName() == 'site.home' || \Request::route()->getName() == 'user.home' || \Request::route()->getName() == 'custom.domain.home')
            <link rel="canonical" href="{{asset('')}}">
        @else
            <link rel="canonical" href="{{url()->current()}}">
        @endif

        @if(parse_url(request()->root())['host'] == 'www.singingexperience.co.uk')
        <link rel="apple-touch-icon" href="{{asset('apple-touch-icon-se.png')}}">
        @endif
        <link rel="icon" href="{{asset('favicon.ico?v=1.1')}}" type="image/x-icon" />
        <link href="{{asset('css/style.min.css?v=3.17')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/auth.min.css')}}" rel="stylesheet" type="text/css" />
        <!------------------------>
        <script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
        <script defer type="application/javascript" src="{{asset('js/my_script.min.js?v=6.66')}}"></script>

        @yield('page-level-css','')

        @yield('page-level-js','')

        <style>
            .wrapper_outer.sm_header header { position: fixed; top: 0; left: 0; }
            .wrapper_outer.sm_header .content_outer { padding-top: 50px; }
        </style>

        <script type="text/javascript">
            var browserWidth = $( window ).width();
            if( browserWidth > 767 ){

                $(window).on('scroll', function () {
                    if ($(window).scrollTop() > 200) {
                        $('.wrapper_outer').addClass('sm_header');
                    } else {
                        $('.wrapper_outer').removeClass('sm_header');
                    }
                });
            }
        </script>

    </head>
    <body>

        @yield('seocontent')

        <script>
            var browserWidth = $( window ).width();
            if( browserWidth <= 767 ){

                $('head').append('<link href="/css/responsive.min.css?v=4.8" rel="stylesheet" type="text/css" />');
            }
        </script>

        <aside>

            @yield('audio-player')

        </aside>

        <section class="wrapper_outer">

            <header>

                @yield('header','')

            </header>

            <aside>

                <div class="hrd_cart_outer clearfix">
                    @include('parts.smart-cart')
                </div>

                @include('parts.smart-notifications')

                @include('parts.smart-user-menu')

            </aside>

            <aside>

                @yield('preheader')

            </aside>

            <section>

                <section class="content_outer">

                    <section>

                        <aside>

                            @yield('flash-message-container','')

                        </aside>

                        <aside>

                            @yield('social-media-html','')

                        </aside>

                        <section>

                            @yield('page-content','')

                        </section>

                        <aside>

                            @yield('miscellaneous-html','')

                        </aside>

                    </section>

                    <aside>

                        <div data-basket="" data-user="" id="post_cart_toast" class="post_cart_toast">
                            <div class="toast_inner">
                                <div class="message">Added to cart</div>
                                <div id="undo" class="each_option">Undo</div> |
                                <div id="continue" class="each_option">Continue</div> |
                                <div id="checkout" class="each_option">Checkout</div>
                            </div>
                            <div id="close" class="action"><i class="fa fa-times"></i></div>
                        </div>

                    </aside>

                </section>

            </section>

            <footer>

                @yield('footer','')

            </footer>

            <aside>

                <div id="to_top"><i class="fa fa-angle-up"></i></div>
                <div id="body-overlay"></div>

            </aside>

        </section>

        <input type="hidden" id="platform" value="1">

        <script type="text/javascript">

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function loadDeferredTasks() {

                var browserWidth = $( window ).width();
                var stylesheetDefer = $('link.switchmediaall');
                for (var i=0; i<stylesheetDefer.length; i++) {
                    stylesheetDefer[i].setAttribute('media','all');
                }
                var imgDefer = $('img.defer_loading');
                for (var i=0; i<imgDefer.length; i++) {
                    if(imgDefer[i].getAttribute('data-src')) {
                        imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
                    }
                }
                var backgroundLength = $('.back_inactive').length;
                if(backgroundLength){

                    $('.back_inactive').each(function(){
                        $(this).css('background-image', 'url(' + $(this).attr('data-url') + ')');
                        $(this).removeClass('back_inactive').addClass('active');
                    });
                }

                if( browserWidth > 767 ){


                }
            }

            document.addEventListener("DOMContentLoaded", function(event) {

                setTimeout(function(){

                    loadDeferredTasks();
                }, 3000);

            });
        </script>
    </body>
</html>
