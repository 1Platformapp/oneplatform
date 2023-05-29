@extends('templates.basic-template')

@section('pagetitle') Frequently Asked Questions | 1 Platform TV @endsection

<!-- Page Level CSS !-->
@section('page-level-css')
    
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <style>
        
        .faq_main_outer h3 { font-size: 14px; color: #fff; }
        .faq_main_outer p { font-size: 13px; line-height: 20px; color: #fff; }
        .faq_main_outer { position: relative; width: 100%; padding: 40px 85px; font-family: 'Montserrat', sans-serif; }
        .heading { text-align: center; margin-bottom: 40px; font-size: 23px; background-color: #000; width: 100%; padding: 5px 10px; color: #fff; }
        .heading a { color: #ffc107; text-decoration: none; }
        .heading span { float: left; font-size: 14px; display: flex; align-items: center; justify-content: center; height: 28px; }
        .que_outer { display: flex; flex-direction: row; flex-wrap: wrap; padding-top: 100px; justify-content: space-between; }
        .each_que_outer { width: 100%; margin-bottom: 60px; }
        .que_top,.que_bottom { padding: 10px; }
        .que_bottom { display: none; line-height: 26px; }
        .que_top { cursor: pointer; }
        .back_one .que_top { background-color: #000; }
        .back_one .que_bottom { background-color: #333; }

        @media (min-width:320px) and (max-width: 767px) {
            .each_que_outer { width: 100%; }
            .faq_main_outer { padding: 40px 20px !important; }
            .faq_main_outer p { font-size: 12px; }
            .faq_main_outer h3 { font-size: 12px; line-height: 23px; }
            .heading { font-size: 15px; }
            .heading span { font-size: 13px; height: 18px; }
        }
    </style>

@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

    <!--  initialize horizontal scroller  !-->
    <script src="/js/horizontal-slider.js" type="application/javascript"></script>
    <script>
        $('document').ready(function(){

            $('.que_top').click(function(){
                $(this).closest('.each_que_outer').find('.que_bottom').slideToggle('slow');
            });

            $('.que_top_head button').click(function(){

                window.currentUserId = 1;
                $('#chat_message_popup,#body-overlay').show();
            });
        });
    </script>
@stop

<!-- Page Header !-->
@section('header')

    @include('parts.header')
@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')


@stop


@section('page-content')
    
    @php $faq = \App\Models\PortfolioElement::where('portfolio_id', 286)->orderBy('order', 'asc')->get() @endphp

        <div class="pg_back active"></div>
        <div class="faq_main_outer">
            <h2 class="heading">
                <a href="https://www.singingexperience.co.uk">
                    <span>
                        <i class="fa fa-home"></i>&nbsp;&nbsp;Singing Experience Home
                    </span>
                </a>
                Frequently Asked Questions   
            </h2>

            <div class="que_outer">

                @php $array = [] @endphp

                @if(count($faq))
                    @foreach($faq as $key => $eachFaq)
                        @if($key % 2 == 0)
                            <div class="each_que_outer back_one">
                                <div class="que_top">
                                    
                                    <h3>{{$eachFaq->value}}</h3>
                                    
                                </div>
                        @else
                                <div class="que_bottom">
                                    
                                    <p>{{$eachFaq->value}}</p>
                                    
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
        </div>

@stop

@section('miscellaneous-html')
    @include('parts.chart-popups')
</div>
@stop