
@extends('templates.basic-template')


@section('pagetitle') {{$type == 'track' ? str_limit($item->song_name, 40) : str_limit($item->title, 40) }} - {{$item->user->name}} @endsection

@section('pagekeywords') 
@endsection

@section('pagedescription') 
    @if($type == 'product')
    <meta name="description" content="{{$user->name}} presents {{$item->title}} - {!! str_replace(array('"', "'"), '', strip_tags($item->description)) !!}" />
    @endif
@endsection

@section('seocontent')
@endsection

<!-- Page Level CSS !-->
@section('page-level-css')
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}" >
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/item-details.min.css?v=3.6')}}" >
    
    <meta property="og:url"           content="" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{$title}}" />
    <meta property="og:description"   content="{{$description}}" />
    <meta property="og:image"         content="{{$image}}" />
    <meta property="fb:app_id"        content="{{config('services.facebook.client_id')}}" />

    <meta name="twitter:card"         content="summary_large_image" />
    <meta name="twitter:site"         content="{{'@'.config('services.twitter.user_name')}}" />
    <meta name="twitter:creator"      content="{{'@'.config('services.twitter.user_name')}}" />
    <meta name="twitter:title"        content="{{$title}}" />
    <meta name="twitter:description"  content="{{$description}}" />
    <meta name="twitter:image"        content="{{$image}}" />
@stop

@section('page-level-js')
    
    <script defer src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        $('document').ready(function(){

        	var browserWidth = $( window ).width();

            var back = $('.page_background').attr('data-url');
            $('.page_background').css('background-image', 'url('+back+')');

            $('body').delegate('.each-music .item_play_btn', 'click', function(e){

                var attr = $('.each-music').attr('data-musicfile');
                if(typeof attr === typeof undefined || attr === false){

                    var id = $('.each-music').attr('data-musicid');
                    $('#private_music_unlock_popup').attr({'data-type': 'music','data-mode': '1', 'data-music-id': id });
                    $('#private_music_unlock_popup,#body-overlay').show();
                }else{
                    updateAndPlayAudioPlayer($('.each-music').first(), '/user-music-files/'+$('.each-music').attr('data-musicfile'), true);
                }
            });

            var expandableHeight = 350;
            if(browserWidth <= 767){
                expandableHeight = 200;
            }

            $('.item_desc_expandable').each(function(){

            	if($(this).find('.item_desc_body').outerHeight() > expandableHeight){
            		$(this).addClass('expanded');
            		$(this).find('.item_desc_read_more').removeClass('instant_hide').text('Read More');
            	}
            });

            $('body').delegate('.item_desc_read_more', 'click', function(e){

            	var parent = $(this).closest('.item_desc_expandable');
            	if(parent.hasClass('expanded')){
            	    parent.removeClass('expanded');
            	    parent.find('.item_desc_read_more').text('Read Less');
            	}else{
            	    parent.addClass('expanded');
            	    parent.find('.item_desc_read_more').text('Read More');
            	}
            });
        });

        window.currentUserId = {{$item->user->id}};
    </script>

@stop

@section('header')
    
@stop

@section('audio-player')

    @include('parts.audio-player')

@stop


@section('flash-message-container')
@stop

@section('social-media-html')
@stop


@section('page-content')
    
    @php $domain = parse_url(request()->root())['host'] @endphp
    @php $backLink = $domain == Config('constants.primaryDomain') ? route('user.home', ['params' => $user->username]) : 'https://'.$domain @endphp
    <aside>
	    <div data-url="{{$user->custom_background ? '/user-media/background/'.$user->custom_background : $userProfileImage}}" class="page_background"></div>

	    <div class="back_link">
	    	<a href="{{$backLink}}">Back to {{$item->user->firstName()}}'s home</a>
	    </div>
	</aside>

    <main role="main">
	    @include('parts.item-private-details')
	</main>

	@if($user->isCotyso())
	   @php $randomProducts = \App\Models\UserProduct::where('user_id', $user->id)->whereNotIn('id', [$user->id, 283])->inRandomOrder()->limit(4)->get() @endphp
        @include('parts.item-related-products', ['products' => $randomProducts])
    @endif
@stop

@section('miscellaneous-html')
	
	@include('parts.basket-popups')
	@include('parts.chart-popups')
    <input type="hidden" id="stripe_publishable_key" value="{{config('constants.stripe_key_public')}}">
@stop

@section('footer')
    
    @if($user->isCotyso())
        @include('parts.singing-footer')
    @endif

@stop