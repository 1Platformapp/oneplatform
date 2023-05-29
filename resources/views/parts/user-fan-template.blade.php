
@if( $fanType == 'contributer' )

    <div class="tab_fan_list clearfix">
        <div class="tab_fan_list_top clearfix">
            <a href="#"><img src="{{ \App\Http\Controllers\CommonMethods::getUserDisplayImage($checkout->customer->id) }}" alt="#" /></a>
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
            <a href="#"><img src="{{ \App\Http\Controllers\CommonMethods::getUserDisplayImage($checkout->customer->id) }}" alt="#" /></a>
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

