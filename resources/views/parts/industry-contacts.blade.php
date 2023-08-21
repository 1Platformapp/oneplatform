

@if(isset($contacts) && count($contacts))
	@php $conFavs = (is_array(Auth::user()->favourite_industry_contacts)) ? array_filter(Auth::user()->favourite_industry_contacts) : array() @endphp
    <ul role="list" class="contracts_list grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
	@foreach($contacts as $key => $contact)
		@include('parts.industry-contact-template',['contact' => $contact, 'isFav' => in_array($contact->id, $conFavs) ? 1 : 0])
	@endforeach
    </ul>

    @if(isset($pageInfo))
    <nav class="flex flex-col-reverse space-y-2 md:flex-row items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6 mt-5" aria-label="Pagination">
        <div class="mt-2 md:mt-0">
            <p class="text-sm text-gray-700">
                Page
                <span class="font-medium">{{$pageInfo['current']}}</span>
                of
                <span class="font-medium">{{$pageInfo['total_pages']}}</span>
            </p>
        </div>
        <div class="flex flex-1 justify-center sm:justify-end space-x-2">
            @if($pageInfo['first'] != $pageInfo['current'])
            <div data-key="{{$pageInfoEncrypted['first']}}" class="ind_con_each_nav first cursor-pointer relative inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0">
                <i class="fas fa-angle-double-left"></i>&nbsp;First
            </div>
            @endif
			@if($pageInfo['prev'] != $pageInfo['current'])
            <div data-key="{{$pageInfoEncrypted['prev']}}" class="ind_con_each_nav prev cursor-pointer relative inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0">
                <i class="fas fa-angle-left"></i>&nbsp;Prev
            </div>
            @endif
			@if($pageInfo['next'] != $pageInfo['current'])
            <div data-key="{{$pageInfoEncrypted['next']}}" class="ind_con_each_nav next cursor-pointer relative inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0">
                Next&nbsp;<i class="fas fa-angle-right"></i>
            </div>
            @endif
			@if($pageInfo['last'] != $pageInfo['current'])
            <div data-key="{{$pageInfoEncrypted['last']}}" class="ind_con_each_nav last cursor-pointer relative inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0">
                Last&nbsp;<i class="fas fa-angle-double-right"></i>
            </div>
            @endif
        </div>
    </nav>
    @endif

@else

@endif
