@if(isset($contact) && isset($isFav))
<div data-id="{{$contact->id}}" class="ind_con_each_outer">
	<div class="ind_con_each_up">
		<div class="ind_con_each_left">
			<div class="ind_con_each_main_det">
				<div class="ind_con_each_det_category">{{$contact->category() ? $contact->category()->name : ''}}</div>
				<div class="ind_con_each_det_name">{{$contact->name}}</div>
				<div class="ind_con_each_det_city">{{$contact->city() ? $contact->city()->name : ''}}</div>
			</div>
		</div>
	</div>
	<div class="ind_con_each_bot">
	    <div class="ind_con_each_action details">
	    	<i class="fa fa-info-circle"></i>
	    	<span> Details</span>
	    </div>
	    @if($isFav)
		<div class="ind_con_each_action favourites added">
			<i class="fa fa-star"></i>
			<span> Added to Favourites</span>
		</div>
		@else
		<div class="ind_con_each_action favourites">
			<i class="fa fa-star"></i>
			<span> Add to Favourites</span>
		</div>
		@endif
	</div>
</div>
@endif