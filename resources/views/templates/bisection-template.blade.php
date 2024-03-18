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

    <link href="/css/style.css?v=4.2" rel="stylesheet" type="text/css" />

    <link href="/css/app.css?v=3.65" rel="stylesheet" type="text/css" />

    <link href="/css/jquery.bxslider.css" rel="stylesheet" type="text/css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <script src="/js/jquery.min.js" type="text/javascript"></script>                        <!--   video layer   -->

    <script type="application/javascript" src="/js/jquery.bxslider.min.js"></script>

    <script defer type="application/javascript" src="/js/my_script.min.js?v=6.78"></script>

    @yield('page-level-css','')

    @yield('page-level-js','')

    <script type="text/javascript">
        var browserWidth = $( window ).width();
        if (window.location.hash && window.location.hash == '#_=_') {
            if (window.history && history.pushState) {
                window.history.pushState("", document.title, window.location.pathname);
            } else {
                // Prevent scrolling by storing the page's current scroll offset
                var scroll = {
                    top: document.body.scrollTop,
                    left: document.body.scrollLeft
                };
                window.location.hash = '';
                // Restore the scroll offset, should be flicker free
                document.body.scrollTop = scroll.top;
                document.body.scrollLeft = scroll.left;
            }
        }
    </script>

</head>

<body onload="if (typeof loadIframe == 'function') { loadIframe(); }">

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

@yield('audio-player')

<!--<div id="body-overlay"></div>!-->

<div class="wrapper_outer">

    <div class="clearfix hrd_cart_outer">
        @include('parts.smart-cart')
    </div>

    @include('parts.smart-notifications')

    @include('parts.smart-user-menu')

    <header>

        @yield('header','')

    </header>



    <div class="profile_outer">

        @if(isset($user) && count($user->devices) == 0)
        <div class="app_dialog" style="display:none">
            <div class="app_dialog_each">
                1Platform will keep you connected the whole time. Download and login to our app
            </div>
            <div class="app_dialog_each">
                <a href="#">
                    <img src="https://www.1platform.tv/images/rsz_1android-download.png" />
                </a>
            </div>
            <div class="app_dialog_each">
                <a href="#">
                    <img src="https://www.1platform.tv/images/rsz_2iphone-app-download.png" />
                </a>
            </div>
            <div class="app_dialog_tool">
                <i class="fa fa-times"></i>
            </div>
        </div>
        @endif

        <div class="pro_pg_auto_cont">



            @yield('flash-message-container','')

            <div class="clearfix profile_inner">



                @yield('top-section','')



                @yield('left-section','')



                @yield('right-section','')



                @yield('bottom-section','')



                @yield('miscellaneous-html','')

                <div data-basket="" data-user="" id="post_cart_toast" class="post_cart_toast">
                    <div class="toast_inner">
                        <div class="message">Added to cart</div>
                        <div id="undo" class="each_option">Undo</div> |
                        <div id="continue" class="each_option">Continue</div> |
                        <div id="checkout" class="each_option">Checkout</div>
                    </div>
                    <div id="close" class="action"><i class="fa fa-times"></i></div>
                </div>

                <div id="share_item_toast" class="post_cart_toast">
                    <div class="toast_inner">
                        <div class="message"></div>
                        <div class="share_body">
                            <div id="share_item_fb" class="each_option">
                                <i class="fab fa fa-facebook-f"></i>
                            </div>
                            <div id="share_item_tw" class="each_option">
                                <i class="fab fa fa-twitter"></i>
                            </div>
                            <div id="share_item_mobile_menu" class="each_option hide_on_desktop">
                                <i class="fa fa-share"></i>
                            </div>
                            <div id="share_item_copy" class="each_option">Copy Link</div>
                        </div>
                    </div>
                    <div id="close" class="action"><i class="fa fa-times"></i></div>
                </div>

            </div>

        </div>

    </div>



    <div class="footer_outer">



        @yield('footer','')

    </div>

    <input type="hidden" id="platform" value="1">

    <div id="to_top"><i class="fa fa-angle-up"></i></div>

</div>

<input type="hidden" id="facebook_app_id" value="{{ config('services.facebook.client_id') }}">

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
