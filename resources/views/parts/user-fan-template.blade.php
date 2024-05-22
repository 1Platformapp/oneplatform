
@php $userImage = \App\Http\Controllers\CommonMethods::getUserDisplayImage($checkout->customer->id) @endphp

@if( $fanType == 'contributer' )

    <div class="tab_fan_list clearfix">
        <div class="tab_fan_list_top clearfix">
            @if(strpos($userImage, 'general-user') !== false)
            <a style="padding: 26px; border: 1px solid #999" href="#">
                <img style="width: 70px; margin: 0 auto;" src="{{$userImage}}" alt="{{$checkout->customer ? $checkout->customer->name : ''}}" />
            </a>
            @else
            <a href="#">
                <img src="{{$userImage}}" alt="{{$checkout->customer ? $checkout->customer->name : ''}}" />
            </a>
            @endif
            <div class="tab_fan_list_det">
                <a href="{{$checkout->customer && $checkout->customer->username != '' ? route('user.home',['params'=>$checkout->customer->username]) : 'javascript:void(0)'}}">{{ $checkout->customer->name }}</a>
                <p>{{$commonMethods->timeElapsedString($checkout->created_at, 1)}}</p>
            </div>
            <div class="tab_fan_list_right">
                <p>{{ $commonMethods::getCurrencySymbol($checkout->currency) . $checkout->amount }}</p>
            </div>
        </div>
        <p class="tab_fan_list_btm_text">
            {{ $checkout->comment }}
        </p>
    </div>
@elseif( $fanType == 'buyer' )
    <div class="tab_fan_list clearfix">
        <div class="tab_fan_list_top clearfix">
            @if(strpos($userImage, 'general-user') !== false)
            <a style="padding: 26px; border: 1px solid #999" href="#">
                <img style="width: 70px; margin: 0 auto;" src="{{$userImage}}" alt="{{$checkout->customer ? $checkout->customer->name : ''}}" />
            </a>
            @else
            <a href="#">
                <img src="{{$userImage}}" alt="{{$checkout->customer ? $checkout->customer->name : ''}}" />
            </a>
            @endif
            <div class="tab_fan_list_det">
                <a href="{{$checkout->customer && $checkout->customer->username != '' ? route('user.home',['params'=>$checkout->customer->username]) : 'javascript:void(0)'}}">{{ $checkout->customer->name }}</a>
                <p>{{$commonMethods->timeElapsedString($checkout->created_at, 1)}}</p>
            </div>
            <div class="tab_fan_list_right">
                <p>{{ $commonMethods::getCurrencySymbol($checkout->currency) . $checkout->amount }}</p>
            </div>
        </div>
        <p class="tab_fan_list_btm_text">{{ $checkout->comment }}</p>
    </div>
@endif

