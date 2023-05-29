
@php $disabledd = isset($disabled) && $disabled == 1 ? 1 : 0 @endphp
@php $commonMethods = new \App\Http\Controllers\CommonMethods(); @endphp
@php $ticketsLeft = $userFeatProduct->quantity != NULL ? $userFeatProduct->items_available - $userFeatProduct->items_claimed : NULL @endphp
<div class="feat_product_temp feat_template" id="feat_slide_{{ $count }}">
    <div class="colio_header">My Product</div>
    <div class="user_hm_rt_btm_inner">
        <div class="upper_sec">
            <span class="upper_up_contain">
                <span class="feat_nav_arrow" id="feat_nav_arrow_left" >
                    <i class="fa fa-angle-left"></i>
                </span>
                <img alt="{{$userFeatProduct->title}}" class="defer_loading" src="#" data-src="{{asset('user-product-thumbnails/'.$userFeatProduct->thumbnail_feat)}}">
                <span class="feat_nav_arrow" id="feat_nav_arrow_right" >
                    <i class="fa fa-angle-right"></i>
                </span>
            </span>
            <div class="product_scroll">
                <b>{{ $userFeatProduct->title }}</b>
                <p>
                    {!! nl2br($userFeatProduct->description) !!}

                <?php $includes = explode(",", $userFeatProduct->includes);?>

                @foreach($includes as $include)
                <div class="feat_bullet"><i class="fa fa-circle"></i>&nbsp;&nbsp;{{ trim($include) }}</div>
                @endforeach

                </p>
                <div class="stock_remain">
                    @if($ticketsLeft != NULL)
                        {{$ticketsLeft > 0 ? $ticketsLeft.' Available' : 'Sold out' }}
                    @endif
                </div>
            </div>
        </div>
        <div class="lower_sec">
            <label class="add_ticket feat_prod_add {{$ticketsLeft && $ticketsLeft<=0?'sold_out':''}}" data-productid="{{ !$disabledd && (!$ticketsLeft || $ticketsLeft > 0) ? $userFeatProduct->id : 0 }}" data-basketuserid="{{ !$disabledd && (!$ticketsLeft || $ticketsLeft > 0) ? $userFeatProduct->user->id : 0 }}" data-basketprice="{{ !$disabledd && (!$ticketsLeft || $ticketsLeft > 0) ? $userFeatProduct->price : 0 }}" data-musicid="0" data-purchasetype="product" style="cursor: pointer;">
                {{!$ticketsLeft || $ticketsLeft > 0 ? 'Add product' : 'Sold out'}}
                <strong>{{$commonMethods->getCurrencySymbol(strtoupper($userFeatProduct->user->profile->default_currency))}}{{ $userFeatProduct->price }}</strong>
            </label>
        </div>
    </div>
</div>
