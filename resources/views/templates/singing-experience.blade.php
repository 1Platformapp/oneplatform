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
        <title>@yield('pagetitle')</title>
        @yield('pagekeywords', '')
        @yield('pagedescription', '')
        <link rel="icon" href="{{asset('user-media/favicon/user-favicon-5f525dd506526.ico')}}" type="image/x-icon" />
        <link rel="stylesheet" href="{{asset('css/style.min.css?v=3.2')}}" >
        <link rel="canonical" href="{{url()->current()}}">
        <link rel="apple-touch-icon" href="{{asset('apple-touch-icon-se.png')}}">
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/item-details.min.css?v=3.3')}}" >
        <link rel="stylesheet" href="{{asset('singing/css/global.min.css')}}" >
        <script src="{{asset('singing/js/global.min.js')}}"></script>

        @yield('page-level-css','')
        @yield('page-level-js','')

    </head>

    <body>

        <header>

            @yield('header','')

        </header>

        <section>

            @yield('page-content','')

            <aside>

                @yield('miscellaneous-html','')

            </aside>

        </section>

        <aside>

            <div id="body-overlay"></div>

        </aside>

        <footer>

            @yield('footer','')

        </footer>

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-124898766-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-124898766-1');
        </script>
    </body>

</html>
