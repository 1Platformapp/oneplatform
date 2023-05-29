
@php
	$commonMethods = new \App\Http\Controllers\CommonMethods();
	if($item->type == 'user' and $item->user and $item->user->active == 1){
		$details = $commonMethods->getUserRealCampaignDetails($item->user_id);
		$thumb = $details['campaignUserInfo']['profileImageCarosel'];
		
        if($details['campaignIsLive'] == '1' && $details['campaignStatus'] == 'active'){
            $hasCrowdFundd = 1;
            $link = $details['campaignUserInfo']['projectPage'];
        }else{
            $hasCrowdFundd = 0;
            $link = $details['campaignUserInfo']['homePage'];
        }

	}else if($item->type == 'stream' && $item->stream){
		$details = $item->stream;
		$thumb = 'https://i.ytimg.com/vi/'.$details->youtube_id.'/mqdefault.jpg';
		$link = route('tv');
	}
@endphp

@if(isset($details))
<div data-id="{{$item->id}}" class="each_carosel">
    <a class="clearfix" href="{{$link}}">
        <div class="carosel_thumb">
            <img src="{{$thumb}}" />
        </div>
        <div class="carosel_section">
            <div class="carosel_user_name">
            	@if($item->type == 'user')
            		{{$details['campaignUserInfo']['name']}}
            	@elseif($item->type == 'stream')
            		{{$details->name}}
            	@endif
            </div>
            <div class="carosel_project">
            	@if($item->type == 'user')
            		@if(!$hasCrowdFundd)
            			&nbsp;
            		@else
            			{{$details['campaignTitle']}}
            		@endif
            	@elseif($item->type == 'stream')
            		{{$details->channel->title}}
            	@endif
            </div>
            <div class="carosel_percent">
            	@if($item->type == 'user')
                <img src="{{$hasCrowdFundd?$details['campaignPercentImage']:asset('images/rsz_shop_bag.png')}}">
                @endif
                <div class="carosel_amount_raised">
                	@if($item->type == 'user')
                        @if($hasCrowdFundd)
                		{{$details['campaignCurrencySymbol'].$details['amountRaised']}} <span class="hide_ex_sm">raised</span>
                        @else
                            Store
                        @endif
                	@else
                		&nbsp;
                	@endif
                </div>
            </div>
            <div class="carosel_products">
            	@if($item->type == 'user')
                <i class="fa fa-shopping-cart"></i>
                @else
                <i class="spacer fa fa-shopping-cart"></i>
                @endif
                <div class="carosel_products_total">
                	@if($item->type == 'user')
                		{{$details['campaignProducts']}} <span class="hide_ex_sm">products</span>
                	@else
                		&nbsp;
                	@endif
            	</div>
            </div>
        </div>
    </a>
</div>
@endif