
@php $commonMethods = new \App\Http\Controllers\CommonMethods(); @endphp

@if(isset($disparity) && $disparity == 1)
    <div class="tot_awe_pro_outer">
        <div class="user_product_summary clearfix">
            <div class="user_product_summary_left">
                <div class="user_product_img_thumb">
                    <img class="" src="{{$commonMethods->getUserDisplayImage($basket->user->id)}}">
                </div>
            </div>
            <div class="user_product_summary_right">
                @if($basket->purchase_type == 'subscription')
                    <h3>Subscription to {{$basket->user->name}}</h3>
                @endif
                <p>
                    {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency)).$basket->price}}
                    @if($basket->purchase_type == 'subscription')
                        p/m
                    @endif
                </p>
            </div>
            <div class="user_product_summary_actions">
                <div data-id="{{$basket->id}}" class="user_product_action_btn item_disp_update_price">
                    Update Price - {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency)).$basket->itemOriginalPrice().' p/m'}}
                </div>
                <div data-id="{{$basket->id}}" class="user_product_action_btn item_disp_remove">
                    Remove Item
                </div>
            </div> 
        </div>

    </div>
@else
    <div class="tot_awe_pro_outer">

        <div class="user_product_summary clearfix">
     
            <div class="user_product_summary_left">
                <div class="user_product_img_thumb">
                    @if($basket->purchase_type == 'project' || $basket->purchase_type == 'instant-license' || $basket->purchase_type == 'proferred-product')
                    <img class="" src="{{$basket->instantItemThumbnail()}}">
                    @else
                    <img class="" src="{{$commonMethods->getUserDisplayImage($basket->user->id)}}">
                    @endif
                </div>
            </div>
            <div class="user_product_summary_right">
                @if($basket->purchase_type == 'donation_goalless')
                <h3>Contribution to {{$basket->user->name}}</h3>
                @endif
                @if($basket->purchase_type == 'subscription')
                <h3>Subscription to {{$basket->user->name}}</h3>
                @endif
                @if($basket->purchase_type == 'project' || $basket->purchase_type == 'instant-license' || $basket->purchase_type == 'proferred-product')
                <h3>{{$basket->instantItemTitle()}}</h3>
                @endif
                <p>
                    {{$commonMethods->getCurrencySymbol(strtoupper($basket->user->profile->default_currency)).$basket->price}}
                    @if($basket->purchase_type == 'subscription')
                    p/m
                    @endif
                </p>    
            </div>
        </div>

    </div>
@endif


