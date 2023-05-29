@if(isset($contacts) && count($contacts))
	@php $conFavs = (is_array(Auth::user()->favourite_industry_contacts)) ? array_filter(Auth::user()->favourite_industry_contacts) : array() @endphp
	@foreach($contacts as $key => $contact)

		@include('parts.industry-contact-template',['contact' => $contact, 'isFav' => in_array($contact->id, $conFavs) ? 1 : 0])

	@endforeach

	<div class="ind_con_res_footer">
	@if(isset($pageInfo))
		<div class="ind_con_nav_outer">
			@if($pageInfo['first'] != $pageInfo['current'])
				<div data-key="{{$pageInfoEncrypted['first']}}" class="ind_con_each_nav first"><i class="fa fa-angle-double-left"></i> First</div>
			@endif
			@if($pageInfo['prev'] != $pageInfo['current'])
				<div data-key="{{$pageInfoEncrypted['prev']}}" class="ind_con_each_nav prev"><i class="fa fa-angle-left"></i> Prev</div>
			@endif
			@if($pageInfo['next'] != $pageInfo['current'])
				<div data-key="{{$pageInfoEncrypted['next']}}" class="ind_con_each_nav next">Next <i class="fa fa-angle-right"></i></div>
			@endif
			@if($pageInfo['last'] != $pageInfo['current'])
				<div data-key="{{$pageInfoEncrypted['last']}}" class="ind_con_each_nav last">Last <i class="fa fa-angle-double-right"></i></div>
			@endif
		</div>
		<div class="ind_con_page_info_outer">
			Page {{$pageInfo['current']}} of {{$pageInfo['total_pages']}}
		</div>
	@endif
	</div>
	
@else

@endif