@php $counter = 0 @endphp
<form data-id="{{$contact->id}}">
    <div class="pro_music_info">
        <div class="pro_form_title flex items-center">
            <div>Contracts</div>
            <button type="button" data-list="list" class="switch_contracts_view rounded bg-white shadow-lg shadow-custom px-10 py-1 ml-auto text-sm font-semibold text-gray-600 hover:bg-gray-200">
                Add Contract
            </button>
        </div>
        <div class="pro_stream_input_outer">
            <ul role="list" class="contracts_list grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($myContracts as $myContract)
                @if($myContract->contact->contactUser->id == $contact->contact_id && $myContract->contact->agentUser->id == $contact->agent_id)
                @php $signatures = count($myContract->signatures) == 2 @endphp
                @php $counter++ @endphp
                <li class="col-span-1 divide-y divide-gray-200 rounded-lg border">
                    <div class="flex flex-col w-full items-start justify-between p-6">
                        <div class="items-start flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="truncate text-sm font-medium text-gray-900">{{$myContract->contract_name}}</h3>
                                @if($signatures == 2)
                                <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    Signed
                                </span>
                                @elseif(isset($myContract->signatures['agent']))
                                <span class="inline-flex flex-shrink-0 items-center rounded-full bg-yellow-50 px-1.5 py-0.5 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-green-600/20">
                                    Signed by agent
                                </span>
                                @elseif(isset($myContract->signatures['artist']))
                                <span class="inline-flex flex-shrink-0 items-center rounded-full bg-yellow-50 px-1.5 py-0.5 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-green-600/20">
                                    Signed by artist
                                </span>
                                @endif
                            </div>
                        </div>
                        <p class="mt-1 truncate text-sm text-gray-500">
                            {{ $signatures < 2 ? 'Created: '.date('d-m-Y', strtotime($myContract->created_at)) : 'Valid From: '.date('d-m-Y', strtotime($myContract->approved_at)) }}
                        </p>
                    </div>
                    <div>
                        <div class="-mt-px flex divide-x divide-gray-200">
                            @if((($myContract->creator == 'agent' && $isAgent) || ($myContract->creator == 'artist' && !$isAgent)) && count($myContract->signatures) < 2)
                            <div class="flex w-0 flex-1">
                                <a href="{{route('agency.contract.edit.form', ['id' => $myContract->id])}}" target="_blank" class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
                                    <i class="fa fa-pencil text-gray-400"></i>&nbsp;Edit
                                </a>
                            </div>
                            @else
                                @if($signatures < 2)
                                <div class="flex w-0 flex-1">
                                    <a href="{{route('agency.contract.view.form', ['id' => $myContract->id])}}" target="_blank" class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
                                        <i class="fa fa-eye text-gray-400"></i>&nbsp;View
                                    </a>
                                </div>
                                @else
                                <div class="flex w-0 flex-1">
                                    <a href="{{route('agency.contract.add.form', ['id' => $myContract->contract_id, 'contact' => $myContract->contact_id])}}" target="_blank" class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
                                        <i class="fa fa-plus text-gray-400"></i>&nbsp;Create new
                                    </a>
                                </div>
                                @endif
                            @endif
                            <div class="-ml-px flex w-0 flex-1">
                                <a @if($signatures == 2) href="{{asset('agent-agreements').'/'.$myContract->pdf}}" download @endif  class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold {{$signatures == 2 ? 'text-gray-900' : 'text-gray-400 cursor-not-allowed'}}">
                                    <i class="fa fa-download text-gray-400"></i>&nbsp;Download
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
                @endforeach
                @if($counter == 0)
                    <li class="text-gray-300 col-span-3 text-lg">You have no contracts to show</li>
                @endif
            </ul>
            <ul role="list" class="instant_hide new_contracts grid sm:grid-cols-1 md:grid-cols-2 gap-x-8">
                @foreach($contracts as $key => $contract)
                <li class="relative flex justify-between gap-x-6 hover:bg-gray-200 border-b border-gray-200">
                    <a class="flex w-full items-center  text-sm leading-6 px-4 py-4 text-gray-900 gap-x-4 text-sm leading-6 text-gray-900" target="blank" href="{{route('agency.contract.add.form', ['id' => $contract->id, 'contact' => $contact->id])}}">
                        <i class="fas fa-file-pdf text-lg"></i>
                        {{$contract->title}}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</form>
