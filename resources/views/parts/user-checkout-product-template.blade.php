
@php $commonMethods = new \App\Http\Controllers\CommonMethods(); @endphp
@php $ticketsLeft = $basket->product->items_available - $basket->product->items_claimed @endphp
<div class="tot_awe_pro_outer">

    <div class="user_product_summary clearfix">
 
        <div class="user_product_summary_left">
            @if ($basket->product->thumbnail !='')

                <div class="user_product_img_thumb">

                <img class="" src="{{$commonMethods::getUserProductThumbnail($basket->product->id)}}">

                </div>

            @endif
        </div>
        <div class="user_product_summary_right">
            <h3>{{ $basket->product->title }}</h3>
            <p>{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency)).$basket->price}}</p>
        </div>
        @if(isset($disparity) && $disparity == 1)
        <div class="user_product_summary_actions">
            <div data-id="{{$basket->id}}" class="user_product_action_btn item_disp_update_price">
                Update Price - {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency)).$basket->itemOriginalPrice()}}
            </div>
            <div data-id="{{$basket->id}}" class="user_product_action_btn item_disp_remove">
                Remove Item
            </div>
        </div>  
        @endif
    </div>

</div>

