@php
    $basket = $basket ?? \App\Http\Controllers\CommonMethods::getCustomerBasket();
    $basketCurrency = $basketCurrency ?? (count($basket) ?? \App\Http\Controllers\CommonMethods::getCurrencySymbol(strtoupper($basket->first()->user->profile->default_currency)));
    $total = 0;
    foreach($basket as $b){ $total += $b->price;}
@endphp
        @if(strpos(url()->current(), '/project/') !== false)
            <div class="crowdfund_cart_outer">
                <div data-link="" id="crowdfund_cart_checkout" class="cart_main_btn">
                    <div class="cart_main_btn_in">
                        <div class="cart_btn_in_text">Crowdfund Checkout</div>
                    </div>
                </div>
                <div class="crowdfund_cart_headline">
                    Crowdfund checkout is separate and contributes to user's project
                </div>
                <hr>
            </div>
        @endif
        <div class="cart_main_btn_outer">
            @if(count($basket))
            	@if($basket->first()->user->isCotyso() && request()->getHttpHost() != Config('constants.primaryDomain'))
            		@php
	            		$link = 'https://'.request()->getHttpHost().'/personalized-checkout';
	            		$class = 'normal_checkout';
            		@endphp
            	@else
            		@if(isset($userParams) && ($userParams == 'customDomain' || $userParams == 'personalDomain') && Session::has('mergeCart'))
            		    @php
            		        $link = route('user.checkout.merge', ['customerId' => Session::get('mergeCart')]);
            		        $class = 'merge_checkout';
            		    @endphp
            		@else
            		    @if($basket->first()->user)
            		        @php
            		            $link = route('user.checkout', ['userId' => $basket->first()->user->id]);
            		            $class = 'normal_checkout';
            		        @endphp
            		    @else
            		        $link = '';
            		        $class = '';
            		    @endif
            		@endif
            	@endif
            <div data-link="{{$link}}" id="cart_checkout" class="cart_main_btn checkout_btn {{$class}}">
                <div class="cart_main_btn_in">
                    <div class="cart_btn_in_text">CHECKOUT</div>
                </div>
            </div>
            @else
            <div data-link="" id="cart_checkout" class="cart_main_btn">
                <div class="cart_main_btn_in">
                    <div class="cart_btn_in_text">HELP</div>
                </div>
            </div>
            @endif
            <div data-link="" id="continue_browse" class="cart_main_btn">
                <div class="cart_main_btn_in">
                    <div class="cart_btn_in_text">CONTINUE<span class="show_on_large"> BROWSING</span></div>
                </div>
            </div>
        </div>
        <div class="cart_items_outer">
            <div class="cart_items_inner">
                @if(count($basket))
                <hr>
                @foreach($basket as $b)
                    @include('parts.user-top-basket-section', ['b' => $b])
                @endforeach
                <div class="each_cart_item numeric_item">
                    <div class="cart_item_left">
                        <div class="cart_subtotal_head">Subtotal</div>
                    </div>
                    <div class="cart_item_right">
                        <div class="cart_subtotal_val">
                            {{$basketCurrency}} {{$total}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="each_cart_item numeric_item">
                    <div class="cart_item_left">
                        <div class="cart_total_head">Total</div>
                    </div>
                    <div class="cart_item_right">
                        <div class="cart_total_val">
                            {{$basketCurrency}}<size>{{$total}}</size>
                            {{$total}}
                        </div>
                    </div>
                </div>
                @else
                <div id="cart_is_empty" class="each_cart_item">
                    <div class="cart_empty_img">
                        <svg class="ccart_ic">
                            <svg viewBox="0 0 13 15" id="ccart_empty">
                                <path d="M13.125 1.75c.875 0 .875.875.875 1.137l-1.75 6.126c-.175.35-.525.612-.875.612h-8.75c-.525 0-.875-.35-.875-.875v-7H.875a.875.875 0 1 1 0-1.75h1.75C3.15 0 3.5.35 3.5.875v7h7.263L11.987 3.5H6.125a.875.875 0 1 1 0-1.75h7zM2.625 14a1.313 1.313 0 1 1 0-2.625 1.313 1.313 0 0 1 0 2.625zm7.875 0a1.313 1.313 0 1 1 0-2.625 1.313 1.313 0 0 1 0 2.625z"></path>
                            </svg>
                        </svg>
                    </div>
                    <div class="cart_empty_text">
                        Your cart is empty
                    </div>
                </div>
                @endif
            </div>
        </div>

