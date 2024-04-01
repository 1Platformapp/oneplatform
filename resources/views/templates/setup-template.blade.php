<!doctype html>

<html lang="en">

    <head>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="AR1UIRB4nzeneJoD1RppX4OOJKzdrH3GLDc7O1jix9Q" />
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('pagetitle')</title>
        <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}" class="switchmediaall">
        <link rel="icon" href="/favicon.ico?v=1.1" type="image/x-icon" />
        <link href="/css/style.min.css?v=3.3" rel="stylesheet" type="text/css" />
        <link href="/css/app.css?v=3.68" rel="stylesheet" type="text/css" />
        <link href="/css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <script src="/js/jquery.min.js" type="text/javascript"></script>
        <script type="application/javascript" src="/js/jquery.bxslider.min.js"></script>
        <script defer type="application/javascript" src="/js/my_script.min.js?v=9.9"></script>
        @yield('page-level-css','')
        @yield('page-level-js','')
    </head>

    <body>

        <style>
            .jwplayer.jw-flag-aspect-mode { height:380px !important; }
        </style>

        @yield('seocontent')
        <script>
            var browserWidth = $( window ).width();
            if( browserWidth <= 767 ){

                $('head').append('<link href="/css/responsive.min.css?v=4.8" rel="stylesheet" type="text/css" />');
            }
        </script>

        <div class="wrapper">

            <div class="setup_outer">

                <div class="pro_pg_auto_cont">

                    @yield('flash-message-container','')

                    <div style="max-width: 55%; margin: 40px auto 0 auto;">
                        <div class="back_to_profile">
                            <i class="fa fa-arrow-left"></i>
                            <a style="color: #000;" href="{{route('agency.dashboard')}}">Back to dashboard</a>
                        </div>
                    </div>
                    <div class="clearfix setup_inner">
                        @yield('page-content')
                    </div>
                </div>
            </div>



            <div class="footer_outer">

                @yield('footer','')
            </div>

            <div id="to_top"><i class="fa fa-angle-up"></i></div>
            <input type="hidden" id="platform" value="1">
        </div>

        @yield('miscellaneous-html')

        <script type="text/javascript">
            function loadDeferredTasks() {
                var imgDefer = $('img.defer_loading');
                for (var i=0; i<imgDefer.length; i++) {
                    if(imgDefer[i].getAttribute('data-src')) {
                        imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
                        imgDefer[i].classList.remove('instant_hide');
                    }
                }

                var browserWidth = $( window ).width();
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
