@extends('templates.basic-template')


@section('pagetitle') 1Platform @endsection


@section('page-level-css')

    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" media="none" class="switchmediaall">

    <style type="text/css">

        @-webkit-keyframes salesfeed-scale {
            0% { width: 0; }
            100% { width: 12.1%; }
        }
        @-moz-keyframes salesfeed-scale {
            0% { width: 0; }
            100% { width: 12.1%; }
        }
        @keyframes salesfeed-scale {
            0% { width: 0; }
            100% { width: 12.1%; }
        }

        .smart_ani_outer .smart_ani_inner { position: relative; }
        .smart_ani_outer .ani_each_bullet { display: inline-block; font-size: 7px; margin: 0 5px; }
        .smart_ani_outer .ani_each_bullet:not(.active) i { color: #fff; }
        .smart_ani_outer .ani_each_bullet.active i { color: #fc064c; }
        .smart_ani_outer .ani_bullets_outer { position: absolute; bottom: 20px; left: 0; right: 0; text-align: center; width: 100px; margin-left: auto; margin-right: auto; }

        .each_section { position: relative; }
        .each_section_inner { padding-right: 90px; padding-left: 90px; position: relative; }
        .section_overlay { z-index: 0.5; width: 100%; height: 100%; position: absolute; top: 0; left: 0; background: #000; opacity: 0; }
        .each_section .section_head_img { z-index: 1; position: absolute; top: 67px; left: 153px; }
        .each_section .section_head_btn { transition: 0.7s all ease-in-out; z-index: 1; position: absolute; top: 72px; right: 156px; font-size: 18px; font-family: 'open_sanslight'; font-weight: bold; cursor: pointer; padding: 5px 60px; text-align: center; }
        .each_section .section_head_btn a { color: #fff; }
        .each_section .section_mood_img { z-index: 1; position: absolute; }
        .each_section .section_nav_up { z-index: 1; position: absolute; bottom: 20px; right: 190px; cursor: pointer; }
        .each_section .section_head_btn:hover { background: #999 !important; }

        #main_section { padding-top: 60px; padding-bottom: 60px; background: #f9f9f9; }
        #main_section .each_nav { cursor: pointer; display: inline-block; background: #777; width: 12.1%; }
        #main_section .nav_position { font-family: 'open_sanslight'; font-weight: bold; font-size: 61px; text-align: center; color: #fff; border-bottom: 2px solid #fff; margin: 0 15px; }
        #main_section .nav_content { font-size: 20px; color: #fff; margin: 10px; text-align: center; font-family: 'open_sansregular'; }

        .main_carosel_outer { margin-top: 30px; position: relative;}
        .main_carosel_outer .carosel_project { white-space: nowrap; overflow: hidden; font-size: 11px; color: #777; font-family: Open sans, sans-serif; margin: 5px 0; }
        .main_carosel_outer .carosel_user_name { white-space: nowrap; overflow: hidden; color: #000; font-family: Open sans, sans-serif; font-size: 14px; }
        .main_carosel_outer .carosel_section { padding: 5px 5px 20px 5px; }
        .main_carosel_outer .carosel_thumb { max-height: 72px; overflow: hidden; }
        .main_carosel_outer .carosel_thumb img { max-width: 100%; }
        .main_carosel_outer .carosel_amount_raised { display: inline-block; font-size: 11px; font-family: Open sans, sans-serif; color: #777; }
        .main_carosel_outer .carosel_percent img { max-width: 13px; display: inline-block; }
        .main_carosel_outer .carosel_products { margin-top: 15px; }
        .main_carosel_outer .carosel_products i { font-size: 14px; display: inline-block; color: #777; }
        .main_carosel_outer .carosel_products_total { display: inline-block; font-size: 11px; color: #999; font-family: Open sans, sans-serif; }
        .main_carosel_outer .each_carosel { white-space: nowrap; overflow: hidden; width: 12%; margin-left: 4px; background: #fff; float: left; }
        .main_carosel_inner .each_carosel:first-child { margin-left: 0 !important; }
        .main_carosel_outer .carosel_load_more { margin: 40px auto 20px auto; width: 90%; padding: 5px 10px; border: 1px solid #fff; color: #fff;  font-family: 'open_sanslight'; font-weight: bold; font-size: 18px; text-align: center; cursor: pointer; }
        .main_carosel_inner .each_carosel .spacer { color: #fff; display: block; }

        .smart_carosel { 
            white-space: nowrap;
            overflow: hidden; 
            animation-fill-mode: forwards; 
            width: 100%; 
            -webkit-animation: fade-in .33s ease-in; 
            -moz-animation: fade-in .33s ease-in; 
            animation: fade-in .33s ease-in; 
            -webkit-animation-fill-mode: forwards; 
            -moz-animation-fill-mode: forwards;  
            animation-fill-mode: forwards; 
            -webkit-transform: translateZ(0);
            transform: translateZ(0); 
        }

        .smart_carosel .each_carosel {
            vertical-align: top;
            min-height: 225px;
            -webkit-animation: salesfeed-scale 0.33s ease-out;
            -moz-animation: salesfeed-scale 0.33s ease-out;
            animation: salesfeed-scale 0.33s ease-out;
            -webkit-animation-fill-mode: forwards;
            -moz-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
            -ms-transform-origin: 0 50% 50%;
            -webkit-transform-origin: 0 50% 50%;
            transform-origin: 0 50% 50%;
        }

        

        .each_main_box { height: 466px; overflow: hidden; z-index: 2; width: 33%; display: inline-block; vertical-align: top; padding: 0 4px; }
        .each_main_box .each_main_box_inner { position: relative; padding: 20px; background: rgb(204, 204, 204); background: rgba(204, 204, 204, 0.5);}
        .each_main_box .box_head { font-family: 'open_sanslight'; font-weight: bold; padding-bottom: 3px; width: fit-content; margin: 0 auto; font-size: 38px; border-bottom:2px solid #fff; }
        .each_main_box_inner .box_text_group { margin-bottom: 50px; font-size: 21px; color: #fff; line-height: 25px; height: 75px; overflow: hidden; }
        .each_main_box_inner > .box_text_group { margin-top: 20px; }
        .each_main_box_inner > .box_text_group ~ .box_text_group { margin-top: 0; }

        .each_section_separation { margin: 180px 0; }
        .each_section_separation img { margin: 0 auto; }

        @media (min-width:320px) and (max-width: 767px) {

            .content_outer { margin-top: 0 !important; }
            #main_section { padding-top: 20px !important; padding-bottom: 20px !important; }
            #main_section .each_nav { display: flex; align-items: center; width: 100% !important; margin-bottom: 20px; position: relative; padding: 10px 0; }
            #main_section .nav_position { font-family: 'open_sanslight' !important; font-weight: bold; position: absolute; font-size: 30px !important; border-bottom: 0 !important; }
            #main_section .nav_content { margin: 0 auto !important; width: fit-content; border-bottom: 2px solid #fff; font-family: 'open_sanslight' !important; font-weight: bold; padding: 5px 0; font-size: 15px !important; }

            #main_section .main_carosel_outer { padding: 0 5px; }
            #main_section .main_carosel_inner .each_carosel { float: none !important; width: 100% !important; margin-left: unset !important; margin-bottom: 10px; }
            #main_section .main_carosel_inner .each_carosel .carosel_thumb { float: left; }
            #main_section .main_carosel_inner .each_carosel .carosel_section { float: right; padding-bottom: 0 !important; }
            #main_section .main_carosel_inner .each_carosel .carosel_section .carosel_products { display: inline; }
            #main_section .main_carosel_inner .each_carosel .carosel_section .carosel_percent { display: inline; }
            #main_section .main_carosel_inner .each_carosel .carosel_section .carosel_percent i { font-size: 25px !important; }
            #main_section .main_carosel_inner .each_carosel .carosel_section .carosel_percent img { width: 25px !important; }
            #main_section .main_carosel_inner .each_carosel .spacer { display: none; }

            .each_section .section_head_img { display: flex; align-items: center; height: 125px; top: 0 !important; left: 0 !important; width: 100%; padding: 40px 0; background: #333; }
            .each_section .section_head_img img { margin: 0 auto; max-width: 300px; height: 26px; }
            .each_section .section_head_btn { right: unset !important; left: 50%; top: unset !important; bottom: 70px; transform: translate(-50%, -50%); width: 90%; text-align: center; padding: 5px 0 !important ;}
            .each_section .each_main_box { height: auto !important; width: 100% !important; padding: 0 !important; margin-bottom: 15px; }
            .each_section .each_section_inner { padding-top: 125px !important; padding-right: 0 !important; padding-left: 0 !important; }
            .each_section .section_nav_up { right: 0; transform: translate(0%, -38%); }
            .each_section .section_overlay { background: unset !important; }
            .each_section .section_mood_img { transform: translate(-50%, 130%); left: 50% !important; bottom: unset !important; top: unset !important; right: unset !important; }
            
            .each_section_separation { display: none; }
            .each_section_separation img { display: none; }

            #main_section .each_section_inner { padding-top: 0 !important; }

            .main_carosel_outer .carosel_thumb { max-height: 81px !important;}

            .each_main_box_inner .box_text_group { font-size: 15px !important; height: auto !important; }

            .section_mood_img img { max-height: 80px; margin: 50px auto; }

        }

        @media (min-width:360px) and (max-width: 767px) {

            #main_section .main_carosel_inner .each_carosel .carosel_thumb { width: 40%; }
            #main_section .main_carosel_inner .each_carosel .carosel_section { width: 60%; }
            #main_section .main_carosel_inner .carosel_project { margin: 2px 0 !important; }
        }

        @media (width:768px) {

            .each_section_inner { padding-left: 0 !important; padding-right: 0 !important; }
            #main_section .each_nav { width: 12% !important; }
            .smart_carosel .each_carosel { min-height: 210px !important; }
            .main_carosel_outer .carosel_user_name { font-size: 12px !important; }
            .main_carosel_outer .carosel_amount_raised, .main_carosel_outer .carosel_products_total, .main_carosel_outer .carosel_project { font-size: 11px !important; }
            .main_carosel_outer .carosel_thumb { max-height: 55px !important; }
            #main_section .nav_content { font-size: 14px !important; }
            .main_carosel_outer .each_carosel { max-width: 12%; }
            .main_carosel_outer .carosel_products i { font-size: 18px !important; }
            .main_carosel_outer .carosel_percent img { width: 20px !important; }
            .each_section .section_head_img { left: 5px !important; max-width: 50%; }
            .each_section .section_head_btn { right: 5px !important; width: 46%; padding: 5px 10px !important; }
            .each_section_separation { margin: 100px 0 !important; }
            #main_section .nav_position { font-size: 50px !important; }
        }

        @media (width:1024px) {

            .each_section_inner { padding-left: 0 !important; padding-right: 0 !important; }
            #main_section .each_nav { width: 12.1% !important; }
            .smart_carosel .each_carosel { min-height: 210px !important; }
            .main_carosel_outer .carosel_user_name { font-size: 13px !important; }
            .main_carosel_outer .carosel_amount_raised, .main_carosel_outer .carosel_products_total, .main_carosel_outer .carosel_project { font-size: 12px !important; }
            .main_carosel_outer .carosel_thumb { max-height: 72px !important; }
            #main_section .nav_content { font-size: 15px !important; }
            .main_carosel_outer .each_carosel { max-width: 12.1%; }
            .main_carosel_outer .carosel_products i { font-size: 19px !important; }
            .main_carosel_outer .carosel_percent img { width: 22px !important; }
            .each_section .section_head_img { left: 5px !important; max-width: 50%; }
            .each_section .section_head_btn { right: 5px !important; width: 40%; padding: 5px 10px !important; }
            .each_section_separation { margin: 100px 0 !important; }
            #main_section .nav_position { font-size: 55px !important; }
        }

        @media (width:320px){

            #main_section .main_carosel_inner .each_carosel .carosel_thumb { width: 45%; }
            #main_section .main_carosel_inner .each_carosel .carosel_section { width: 55%; }
            #main_section .main_carosel_inner .each_carosel .carosel_section .hide_ex_sm { display: none; }
            #main_section .main_carosel_inner .carosel_project { margin: 2px 0 !important; }

        }

        @media (min-width:321px) and (max-width: 360px) {

            #main_section .main_carosel_inner .each_carosel .carosel_thumb { width: 45%; }
            #main_section .main_carosel_inner .each_carosel .carosel_section { width: 55%; }
            #main_section .main_carosel_inner .each_carosel .carosel_section .hide_ex_sm { display: none; }
            #main_section .main_carosel_inner .carosel_project { margin: 2px 0 !important; }
            
        }

        @media (min-width:361px) and (max-width: 767px) {
        }

        @media (min-width:1900px) {

            .each_main_box { height: 416px; }
            .each_main_box_inner .box_text_group { height: 55px; }
        }
    </style>
@stop



@section('page-level-js')
    
    <script type="text/javascript">

        window.pauseCarosel = 0;
        window.startCarosel = parseInt({{$startCarosel}});

    </script>

    <script type="text/javascript">

        
        var browserWidth = $( window ).width();

        $('document').ready(function(){

            $('.section_nav_up').click(function(){
                $('html, body').animate({ scrollTop: 0 }, 2000, function () { });
            });

            if(browserWidth <= 767){
                $('.main_carosel_inner.smart_carosel').removeClass('smart_carosel');
                $('.each_section').each(function(){
                    var thiss = $(this);
                    if(thiss.find('.section_mood_img').length){
                        thiss.find('.section_mood_img').insertAfter(thiss);
                    }
                    if(thiss.find('.section_nav_up').length){
                        thiss.find('.section_nav_up').insertAfter(thiss.find('.main_box_outer .each_main_box:last-child'));
                    }
                });
            }else{

                $('.main_carosel_inner .each_carosel:nth-child(8)').nextAll('.each_carosel').remove();
            }


            $('.smart_carosel').mouseenter(function () {
                window.pauseCarosel = 1;
            });
            $('.smart_carosel').mouseleave(function () {
                window.pauseCarosel = 0;
            });

            $('#main_section .each_nav').click(function(){

                var offset = (browserWidth <= 767) ? 44 : 0;
                var target = $('#'+$(this).attr('data-target'));
                $([document.documentElement, document.body]).animate({
                    scrollTop: target.offset().top - offset
                }, 2000);
            });

            setInterval(function(){
                
                smartAnimation();

                if(browserWidth > 767){
                    if(typeof window.startCarosel !== 'undefined' && window.startCarosel == 1 && typeof window.pauseCarosel !== 'undefined' && window.pauseCarosel == 0 ){
                        smartCarosel();
                    }
                }
            }, 5000);

            
        });

        function smartCarosel(){

            var items = [];
            $('#main_section .main_carosel_inner .each_carosel').each(function(){

                items.push($(this).attr('data-id'));
            });
            var allItems = items.join(',');
            $.ajax({

                url: '/loadMyRequestData',
                type: 'POST',
                data: {'load_type': 'smart_carosel_next_item', 'load': '', 'allItems': allItems},
                cache: false,
                dataType: 'html',
                success: function (response) {

                    if(response.trim() != ''){
                        $(response).prependTo($('#main_section .main_carosel_inner'));
                        $('#main_section .main_carosel_inner .each_carosel').last().remove();
                    }
                }
            });
        }



        function smartAnimation(){

            var current = $('.ani_each_item.active');
            var next = $('.ani_each_item.active').next();
            var currentBullet = $('.ani_each_bullet.active');
            var nextBullet = $('.ani_each_bullet.active').next();

            if(next.length == 0){
                var next = $('.ani_each_item:first-child');
                var nextBullet = $('.ani_each_bullet:first-child');
            }
            current.removeClass('active').fadeOut(1000,function(){
                next.addClass('active').fadeIn(1000);
                currentBullet.removeClass('active');
                nextBullet.addClass('active');
            });
        }

        function switchBanners(){
            var banner = $('.ani_each_item_img').attr('src');
            if( browserWidth <= 767 && !banner.includes('_res') ) {
                $('.smart_ani_outer .ani_each_item_img').each(function(index){
                    if(index == 0)
                        $(this).attr('src', '/images/banner8_res.jpg');
                    if(index == 1)
                        $(this).attr('src', '/images/banner4_res.jpg');
                    if(index == 2)
                        $(this).attr('src', '/images/banner5_res.jpg');
                    if(index == 3)
                        $(this).attr('src', '/images/banner6_res.jpg');
                    if(index == 4)
                        $(this).attr('src', '/images/banner7_res.jpg');
                });
            }else if( browserWidth >= 1900 && !banner.includes('_xl') ) {
                $('.smart_ani_outer .ani_each_item_img').each(function(index){
                    if(index == 0)
                        $(this).attr('src', '/images/banner8_xl.jpg');
                    if(index == 1)
                        $(this).attr('src', '/images/banner4_xl.jpg');
                    if(index == 2)
                        $(this).attr('src', '/images/banner5_xl.jpg');
                    if(index == 3)
                        $(this).attr('src', '/images/banner6_xl.jpg');
                    if(index == 4)
                        $(this).attr('src', '/images/banner7_xl.jpg');
                });
            }
        }

    </script>
@stop


@section('preheader')

    <div class="smart_ani_outer pre_header_banner">
        <div class="smart_ani_inner">
            <div class="ani_items_outer">
                <div class="ani_each_item active">
                    <a class="ani_each_item_link" href="javascript:void(0)">
                        <img class="ani_each_item_img" src="{{asset('images/banner8.jpg')}}" />
                    </a>
                </div>
                <div class="ani_each_item" style="display: none;">
                    <a class="ani_each_item_link" href="{{route('chart')}}">
                        <img class="ani_each_item_img" src="{{asset('images/banner4.jpg')}}" />
                    </a>
                </div>
                <div class="ani_each_item" style="display: none;">
                    <a class="ani_each_item_link" href="{{route('tv')}}">
                        <img class="ani_each_item_img" src="{{asset('images/banner5.jpg')}}" />
                    </a>
                </div>
                <div class="ani_each_item" style="display: none;">
                    <a class="ani_each_item_link" href="{{route('live')}}">
                        <img class="ani_each_item_img" src="{{asset('images/banner6.jpg')}}" />
                    </a>
                </div>
                <div class="ani_each_item" style="display: none;">
                    <a class="ani_each_item_link" href="{{route('search')}}">
                        <img class="ani_each_item_img" src="{{asset('images/banner7.jpg')}}" />
                    </a>
                </div>
            </div>
            <div class="ani_bullets_outer">
                <div class="ani_each_bullet active"><i class="fa fa-circle"></i></div>
                <div class="ani_each_bullet"><i class="fa fa-circle"></i></div>
                <div class="ani_each_bullet"><i class="fa fa-circle"></i></div>
                <div class="ani_each_bullet"><i class="fa fa-circle"></i></div>
                <div class="ani_each_bullet"><i class="fa fa-circle"></i></div>
            </div>
        </div>
    </div>

    <script>
        switchBanners();
    </script>
@stop


@section('header')


    @include('parts.header')

@stop



@section('flash-message-container')



    

@stop



@section('social-media-html')

@stop





@section('page-content')


    <div id="main_section" class="each_section">
        <div class="each_section_inner">
            <div class="main_carosel_outer">
                <div class="main_carosel_inner smart_carosel clearfix">
                    @foreach($carosel as $item)
                        @include('parts.smart-carosel-item', ['item' => $item])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    

@stop


@section('footer')

@stop