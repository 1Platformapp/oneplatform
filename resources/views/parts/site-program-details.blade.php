
<div data-id="{{$program->id}}" class="portfolio_det_each">
	<div class="portfolio_det_action_outer">
		<div class="portfolio_nav_outer">
			<div class="portfolio_det_nav port_det_nav_back">
				<i class="fa fa-caret-left"></i>
			</div>
			<div class="portfolio_det_nav port_det_nav_next">
				<i class="fa fa-caret-right"></i>
			</div>
			<a class="portfolio_det_nav" href="{{route('register')}}">
            	<i class="fa fa-comment-dots"></i> 
            	Chat With A Manager Now
            </a>
		</div>
		<div class="portfolio_det_close">
			<i class="fa fa-times"></i>
		</div>
	</div>
	<div class="port_front_title">
		{{$program->title}}
	</div>
	<div class="portfolio_det_in">
		@if(count($program->elements))
			<div class="portfolio_det_each_side">
			@foreach($program->elements as $key => $element)
				@if($element->type == 'image')
					<div class="portfolio_det_elem_each">
						<img class="port_front_img" src="http://duong.1platform.tv/public/program-images/{{$element->value}}">
					</div>
					@elseif($element->type == 'paragraph')
					<div class="portfolio_det_elem_each">
						<p class="port_front_para">{!! nl2br($element->value) !!}</p>
					</div>
					@elseif($element->type == 'youtube')
					<div class="portfolio_det_elem_each">
						<iframe allowfullscreen="allowfullscreen" id="ytplayer" type="text/html" height="360"
						  src="https://www.youtube.com/embed/{{$commonMethods->getYoutubeVideoId($element->value)}}?autoplay=0&origin={{config('constants.primaryDomain')}}"
						  frameborder="0"></iframe>
					</div>
					@elseif($element->type == 'heading')
					<div class="portfolio_det_elem_each">
						<div class="port_front_heading">{{$element->value}}</div>
					</div>
					@endif
			@endforeach
			</div>
		@endif
	</div>
</div>