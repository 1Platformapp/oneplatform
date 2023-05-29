@if(count($user->services))
@php $isSearch = isset($search) && $search == 1 ? 1 : 0 @endphp
<div data-user-link="{{route('user.home.tab', ['params' => $user->username, 'tab' => 6])}}" data-user-id="{{$user->id}}" class="panel services_outer colio_outer colio_dark">
    <div class="colio_header">{{$isSearch ? $user->name."'s" : 'My'}} Services</div>
    <div class="services_inner">
        @if($isSearch)
            <div class="user_service_hide">
                <i class="fa fa-times"></i>
            </div>
        @endif
        <div class="services_list">
            @foreach($user->services as $userService)
            <div class="each_user_service">
                <div class="user_service_name">{{$userService->service_name}}</div>
                <div class="user_service_price">
                    @if($userService->price)
                        {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{$userService->price}}
                        @if($userService->price_interval && $userService->price_interval != 'no')
                            &nbsp;&nbsp;&nbsp;per {{$userService->price_interval}}
                        @endif
                    @elseif($userService->price_option == 3)
                        POA
                    @endif
                </div>
            </div>
            @endforeach 
        </div>
        <div class="services_foot">
            <div id="service_store_anchor" class="service_foot_each">
                <div class="service_foot_ic">
                    <i class="fas fa-store-alt"></i>
                </div>
                <div class="service_foot_title">Store</div>
            </div>
            @if(!$user->isCotyso())
            <div id="service_chat_anchor" class="service_foot_each {{$user->chat_switch == 1 ? '' : 'disabled'}}">
                <div class="service_foot_ic">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="service_foot_title">Message</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif