@if(isset($contact) && isset($isFav))
<li data-is-fav="{{$isFav}}" data-id="{{$contact->id}}" class="ind_con_each_outer col-span-1 divide-y divide-gray-200 rounded-lg border">
    <div class="ind_con_each_up flex w-full items-center justify-between space-x-6 p-6">
        <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
                <h3 class="truncate text-sm font-medium text-gray-900">{{$hasActiveSub ? $contact->name : $commonMethods->maskString($contact->name)}}</h3>
                <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                    {{$contact->category() ? $contact->category()->name : ''}}
                </span>
            </div>
            <p class="mt-1 truncate text-sm text-gray-500">{{$contact->city() ? $contact->city()->name : ''}}</p>
        </div>
    </div>
    <div class="ind_con_each_bot">
        <div class="-mt-px flex divide-x divide-gray-200">
            <div class="flex w-0 flex-1 ind_con_each_action details cursor-pointer">
                <div class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-2 rounded-bl-lg border border-transparent py-4 text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i><span>Details</span>
                </div>
            </div>
            @if($isFav)
            <div class="-ml-px flex w-0 flex-1 ind_con_each_action favourites added cursor-pointer">
                <div class="relative inline-flex w-0 flex-1 items-center justify-center gap-2 rounded-br-lg border border-transparent py-4 text-sm text-gray-500">
                    <i class="fas fa-star"></i><span>Added to Favourites</span>
                </div>
            </div>
            @else
            <div class="-ml-px flex w-0 flex-1 ind_con_each_action favourites cursor-pointer">
                <div class="relative inline-flex w-0 flex-1 items-center justify-center gap-2 rounded-br-lg border border-transparent py-4 text-sm text-gray-500">
                    <i class="far fa-star"></i><span>Add to favourites</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</li>
@endif
