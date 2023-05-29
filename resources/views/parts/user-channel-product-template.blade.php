@php $ticketsLeft = $userProduct->quantity !== NULL ? $userProduct->items_available - $userProduct->items_claimed : NULL @endphp
@php $domain = parse_url(request()->root())['host'] @endphp

<div class="tot_awe_pro_outer">
    <div class="tot_awe_pro_upper">
        <div class="tot_awe_pro_top">
            <div class="tot_awe_pro_left">
                @if($userProduct->thumbnail !='')
                    <div class="user_product_img_thumb">
                        <img alt="{{$userProduct->title}}" class="defer_loading" src="#" data-src="{{$commonMethods::getUserProductThumbnail($userProduct->id)}}">
                    </div>
                @endif
            </div>
            <div class="tot_awe_pro_right">
                <div class="tot_awe_pallete hide_on_desktop">
                    @if(!$userProduct->user->isCotyso())
                    <div title="Like" class="tot_awe_pallete_each tot_awe_liker @if (Auth::check()) {{ is_array(Auth::user()->favourite_products) && in_array($userProduct->id, Auth::user()->favourite_products) ? 'active' : '' }} @endif">
                        <i class="fa fa fa-heart"></i>
                    </div>
                    @endif
                    <div title="Share" data-slug="{{str_slug($userProduct->title)}}" data-title="{{$userProduct->title}}" data-item="{{base64_encode($userProduct->id)}}" data-opd="item" data-type="product" class="tot_awe_pallete_each product_share">
                        <i class="fa fa-share-alt"></i>
                    </div>
                    <div title="Full details" class="tot_awe_pallete_each">
                        <a class="tot_awe_stand" href="{{$userProduct->slug != '' ? route('item.share.product', ['itemSlug' => $userProduct->slug]) : 'javascript:void(0)'}}">
                            <i class="fa fa-link"></i>
                        </a>
                    </div>
                    @if($userProduct->type == 'custom')
                    <div class="tot_awe_pallete_each">
                        <div class="tot_awe_pro_expand">
                            <i class="fa fas fa-expand"></i>
                        </div>
                    </div>
                    @endif
                </div>
                <h3 class="tot_awe_title">{{ $userProduct->title }}</h3>
                <div class="tot_awe_purchase">
                    @if($userProduct->special_price && $userProduct->special_price['price'] != $userProduct->normal_price && !isset($suggestion))
                    @php date_default_timezone_set($userProduct->special_price['timezone']) @endphp 
                    @if(strtotime($userProduct->special_price['start_date_time']) <= strtotime(now()) && strtotime($userProduct->special_price['end_date_time']) > strtotime(now()))
                        @php $hasSpecialPrice = 1 @endphp
                        <div data-current="{{strtotime(now())}}" data-start="{{strtotime($userProduct->special_price['start_date_time'])}}" data-end="{{strtotime($userProduct->special_price['end_date_time'])}}" class="tot_awe_pro_offer">
                            <div class="tot_awe_pro_offer_right">
                                <div class="tot_awe_pro_offer_countdown">
                                    <div class="big_offer_cowntdown_each pro_countdown_days">
                                        <div class="big_offer_cowntdown_up">
                                            <div class="big_offer_countdown_bx"></div>
                                            <div class="big_offer_countdown_bx"></div>
                                        </div>
                                        <div class="big_offer_cowntdown_down">
                                            Days
                                        </div>
                                    </div>
                                    <div class="big_offer_cowntdown_each pro_countdown_hours">
                                        <div class="big_offer_cowntdown_up">
                                            <div class="big_offer_countdown_bx"></div>
                                            <div class="big_offer_countdown_bx"></div>
                                        </div>
                                        <div class="big_offer_cowntdown_down">
                                            Hr
                                        </div>
                                    </div>
                                    <div class="big_offer_cowntdown_each pro_countdown_mins">
                                        <div class="big_offer_cowntdown_up">
                                            <div class="big_offer_countdown_bx"></div>
                                            <div class="big_offer_countdown_bx"></div>
                                        </div>
                                        <div class="big_offer_cowntdown_down">
                                            Min
                                        </div>
                                    </div>
                                    <div class="big_offer_cowntdown_each pro_countdown_secs">
                                        <div class="big_offer_cowntdown_up">
                                            <div class="big_offer_countdown_bx"></div>
                                            <div class="big_offer_countdown_bx"></div>
                                        </div>
                                        <div class="big_offer_cowntdown_down">
                                            Sec
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @php $hasSpecialPrice = 0 @endphp
                    @endif
                    @else 
                        @php $hasSpecialPrice = 0 @endphp
                    @endif
                    @if($userProduct->price_option == 'addprice' || $userProduct->type == 'custom')
                    <div class="teb_chan_moreinfo_sec_outer add_basket_btn {{$hasSpecialPrice?'':'btn_full'}} {{$ticketsLeft !== null && $ticketsLeft <= 0 ? 'sold_out' : ''}}" data-basketuserid="{{$ticketsLeft === null || $ticketsLeft > 0 ? $userProduct->user_id : 0 }}"
                                   data-musicid="0" data-purchasetype="{{$userProduct->type == 'custom' ? 'custom_product' : 'product'}}" data-basketprice="{{$ticketsLeft === null || $ticketsLeft > 0 ? $userProduct->price : 0 }}" data-productid="{{$ticketsLeft === null || $ticketsLeft > 0 ? $userProduct->id : 0 }}" data-account="{{$userProduct->type == 'custom' ? base64_encode($userProduct->user->profile->stripe_user_id) : ''}}">
                        <a class="hide_on_mobile" href="#">{{$ticketsLeft === null || $ticketsLeft > 0 ? 'Add to cart' : 'Sold out'}}</a>
                        <i class="hide_on_desktop fa fa-shopping-cart"></i>
                        <span>
                            @if($userProduct->price != $userProduct->normal_price)
                            <text class="normal_price">
                                {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ $userProduct->normal_price }} 
                            </text>
                            <text class="special_price_offer">
                                &nbsp;now in&nbsp; 
                            </text>
                            @endif
                            {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ $userProduct->price }}
                        </span>
                    </div>
                    @else
                    <div class="teb_chan_moreinfo_sec_outer add_basket_btn {{$user->chat_switch == 1 ? 'product_poa' : ''}} clearfix" style="cursor: pointer;">
                        <a href="#">Send Message To Negotiate</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="tot_awe_pro_bottom">
            <div class="tot_awe_pallete hide_on_mobile">
                @if(!$userProduct->user->isCotyso())
                <div title="Like" class="tot_awe_pallete_each tot_awe_liker @if (Auth::check()) {{ is_array(Auth::user()->favourite_products) && in_array($userProduct->id, Auth::user()->favourite_products) ? 'active' : '' }} @endif">
                    <i class="fa fa fa-heart"></i>
                </div>
                @endif
                <div title="Share" data-slug="{{str_slug($userProduct->title)}}" data-title="{{$userProduct->title}}" data-item="{{base64_encode($userProduct->id)}}" data-opd="item" data-type="product" class="tot_awe_pallete_each product_share">
                    <i class="fa fa-share-alt"></i>
                </div>
                <div title="Details" class="tot_awe_pallete_each">
                    <a class="tot_awe_stand" href="{{$userProduct->slug != '' ? route('item.share.product', ['itemSlug' => $userProduct->slug]) : 'javascript:void(0)'}}">
                        <i class="fa fa-link"></i>
                    </a>
                </div>
                @if($userProduct->type == 'custom')
                <div class="tot_awe_pallete_each">
                    <div class="tot_awe_pro_expand">
                        <i class="fa fas fa-expand"></i>
                    </div>
                </div>
                @endif
            </div>
            <div class="tot_awe_pro_btm">
                @if($userProduct->type == 'personal')
                    <p>
                        {!! nl2br($userProduct->description) !!}
                        @if($userProduct->includes != '')
                            @php $includes = explode(",", $userProduct->includes) @endphp
                            <ul class="main_prod_list">
                                @foreach($includes as $include)
                                <li class="li_bullet">{{ trim($include) }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </p>
                    @if($userProduct->is_ticket == 1)
                    <p>
                        Live at {{$userProduct->location}}<br>
                    </p>
                    @endif
                    <p>{{ $userProduct->date_time }}</p>
                    @if($ticketsLeft != NULL)
                    <p>{{ $ticketsLeft > 0 ? $ticketsLeft.' Available' : 'Sold out' }}</p>
                    @endif
                @elseif($userProduct->type == 'custom')
                    @php $customProduct = $userProduct->customProduct() @endphp
                    @php $ticketsLeft = 1 @endphp
                    @if(isset($userProduct->design['colors']))
                    <div class="tot_awe_pro_colors">
                        <div class="tot_awe_pro_sub_head">Colors</div>
                        <div class="tot_awe_colors_in">
                            @foreach($userProduct->design['colors'] as $color)
                            @if($color['status'] == '0')
                                @php continue @endphp
                            @endif
                            @php $slug = str_slug($color['name']) @endphp
                            <div data-image="/prints/uf_{{$user->id.'/designs/'.$color['image']}}" data-name="{{$color['name']}}" class="tot_awe_color_each {{$slug}} {{str_slug($color['name']) == $userProduct->design['default_color'] ? 'active' : ''}}"></div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($customProduct->sizes !== NULL)
                    <div class="tot_awe_pro_sizes">
                        <div class="tot_awe_pro_sub_head">Size</div>
                        <div class="tot_awe_colors_in">
                            @foreach($customProduct->sizes as $size)
                            <div data-name="{{$size}}" class="tot_awe_color_each tot_awe_size_each {{$size == 'Medium' ? 'active' : ''}}">
                                @if($size == 'Extra Small')
                                XS
                                @elseif($size == 'Small')
                                S
                                @elseif($size == 'Medium')
                                M
                                @elseif($size == 'Large')
                                L
                                @elseif($size == 'Extra Large')
                                XL
                                @elseif($size == 'Double Extra Large')
                                2XL
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="tot_awe_pro_quantity">
                        <div class="tot_awe_pro_sub_head">Quantity</div>
                        <div class="tot_awe_colors_in">
                            <input type="number" min="1" class="tot_awe_pro_qua" value="1" />
                        </div>
                    </div>
                    <p>
                        {!! nl2br($userProduct->description) !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>