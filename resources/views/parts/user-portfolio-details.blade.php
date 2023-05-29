
<div data-id="{{$portfolio->id}}" class="portfolio_det_each">
	<div class="portfolio_det_action_outer">
		<div class="portfolio_nav_outer">
			<div class="portfolio_det_nav port_det_nav_back">
				<i class="fa fa-caret-left"></i>
			</div>
			<div class="portfolio_det_nav port_det_nav_next">
				<i class="fa fa-caret-right"></i>
			</div>
		</div>
		<div class="portfolio_det_close">
			<i class="fa fa-times"></i>
		</div>
	</div>
	<div class="port_head">
		<div class="port_front_title">
			{{$portfolio->title}}
		</div>
		@if($portfolio->product && $portfolio->product->user->id == $portfolio->user->id)
		@php $ticketsLeft = $portfolio->product->quantity !== NULL ? $portfolio->product->items_available - $portfolio->product->items_claimed : NULL @endphp
		<div data-type="product" data-price="{{$portfolio->product->price !== NULL ? base64_encode($portfolio->product->price) : base64_encode($portfolio->product->price_option)}}" data-id="{{$portfolio->product->id}}" class="port_add_basket {{$ticketsLeft !== NULL && $ticketsLeft <= 0 ? 'disabled' : ''}}">
			@if($portfolio->product->price_option == 'poa')
			<i class="fa fa-comments"></i>&nbsp;Negotiate price
			@else
			<svg type="primary" name="port_add_basket_{{$portfolio->id}}" class="ccart_ic cport_ic">
				<use xlink:href="#port_add_basket_{{$portfolio->id}}">
				    <svg viewBox="0 0 13 15" id="port_add_basket_{{$portfolio->id}}">
				        <path d="M13.125 1.75c.875 0 .875.875.875 1.137l-1.75 6.126c-.175.35-.525.612-.875.612h-8.75c-.525 0-.875-.35-.875-.875v-7H.875a.875.875 0 1 1 0-1.75h1.75C3.15 0 3.5.35 3.5.875v7h7.263L11.987 3.5H6.125a.875.875 0 1 1 0-1.75h7zM2.625 14a1.313 1.313 0 1 1 0-2.625 1.313 1.313 0 0 1 0 2.625zm7.875 0a1.313 1.313 0 1 1 0-2.625 1.313 1.313 0 0 1 0 2.625z"></path>
				    </svg>
				</use>
			</svg>&nbsp;
				@if($ticketsLeft !== NULL && $ticketsLeft <= 0)
				Sold out
				@else
				Add to cart - {{$commonMethods->getCurrencySymbol(strtoupper($portfolio->product->user->profile->default_currency))}}{{$portfolio->product->price}}
				@endif
			@endif
		</div>
		@endif
	</div>
	
	<div class="portfolio_det_in">
		@if(count($portfolio->elements))
			<div class="portfolio_det_each_side">
			@foreach($portfolio->elements as $key => $element)
				@if($element->type == 'image')
					<div class="portfolio_det_elem_each">
						<img class="port_front_img" src="{{asset('portfolio-images/'.$element->value)}}">
					</div>
					@elseif($element->type == 'paragraph')
					<div class="portfolio_det_elem_each">
						<p class="port_front_para">{!! nl2br($element->value) !!}</p>
					</div>
					@elseif($element->type == 'youtube')
					<div class="portfolio_det_elem_each">
						<iframe allowfullscreen="allowfullscreen" id="ytplayer" type="text/html" height="360"
						  src="https://www.youtube.com/embed/{{$commonMethods->getYoutubeVideoId($element->value)}}?autoplay=0&origin={{config('constants.primaryDomain')}}&rel=0"
						  frameborder="0"></iframe>
					</div>
					@elseif($element->type == 'heading')
					<div class="portfolio_det_elem_each">
						<div class="port_front_heading">{{$element->value}}</div>
					</div>
					@elseif($element->type == 'spotify')
					<div class="portfolio_det_elem_each">
						<iframe src="{{str_replace('https://open.spotify.com/', 'https://open.spotify.com/embed/', $element->value)}}" width="100%" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
					</div>
					@endif
			@endforeach
			</div>
		@endif
	</div>
</div>