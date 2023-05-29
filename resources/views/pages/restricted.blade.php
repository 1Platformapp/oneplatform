


@extends('templates.basic-template')


@section('pagetitle') 1Platform TV @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <style type="text/css">
        
        .auto_content { width: 100%; }
        .video_upper_inner { background-image: url(https://www.1platform.tv/images/chart_back_04_2.jpg); background-size: 100%; background-position: center; background-repeat: no-repeat; height: 100vh; }
        #body-overlay-notes { z-index: 11; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #fff; font-family: 'Montserrat', sans-serif; font-size: 14px; position: fixed; }
        .level_1 { font-size: 60px; }
        .level_2 { font-size: 20px; margin-bottom: 20px; margin-top: 20px; }
        .level_3 { background-color: royalblue; padding: 8px 20px;  }
        .level_3 a { color: #fff; text-decoration: none; }
        .content_outer { padding: 0; margin: 0 !important; }
        header { display: none; }

        @media (min-width:320px) and (max-width: 767px) {

            .level_1 { font-size: 30px; }
            .level_2 { font-size: 12px; margin-bottom: 10px; margin-top: 10px; }
            .video_upper_inner { background-size: cover; }
        }

    </style>
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

    <script type="text/javascript">
        
    </script>
@stop

<!-- Page Header !-->
@section('header')
    
@stop


@section('flash-message-container')
@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')
@stop


@section('page-content')

    <div class="hm_video_sec_outer">

        <div class="video_upper_sec">
            <div class="auto_content">
                <div class="video_upper_inner">
                	
                </div>
            </div>
        </div>
    </div>
@stop

@section('miscellaneous-html')

    <div style="display: block;" id="body-overlay"></div>
    <div id="body-overlay-notes">
        <div class="level_1">Restricted Account</div>
        <div class="level_2">There is no more information we can provide</div>
        <div class="level_3">
            <div class="restricted_logout">
                <a href="{{route('logout')}}">Logout</a>
            </div>
        </div>
    </div>
@stop