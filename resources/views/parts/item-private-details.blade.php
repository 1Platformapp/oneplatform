@if($type == 'track' && !isset($unlocked) && count($item->privacy) && isset($item->privacy['status']) && $item->privacy['status'] == '1')
    @php $isPrivate = 1 @endphp
@else
    @php $isPrivate = 0 @endphp
@endif

@if($type == 'track')
    @if($item->thumbnail_feat != '')
        @php $thumbnail = asset('user-music-thumbnails/'.$item->thumbnail_feat) @endphp
    @else
        @php $thumbnail = asset('img/url-thumb-profile.jpg') @endphp
    @endif
@elseif($type == 'product')
    @php $thumbnail = $commonMethods::getUserProductThumbnail($item->id) @endphp
@endif

@php 
    $currencySym = $commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))
@endphp

<div class="item_container @if($type == 'product') tot_awe_pro_outer @endif {{$type == 'track' ? 'each-music' : ''}}" @if($type == 'track') data-thumbnail-player="{{ $item->thumbnail_player }}" data-musicid="{{ $item->id }}" data-userid="{{base64_encode($item->user->id)}}" @endif @if($type == 'track' && !$isPrivate) data-musicfile="{{ $item->music_file }}" @endif>
    	<div class="item_top @if($type == 'product') tot_awe_pro_left @endif">
    		<div class="item_thumb @if($type == 'product') user_product_img_thumb @endif">
    			<img @if($type == 'product') data-src="{{$thumbnail}}" @endif src="{{$thumbnail}}" />
    		</div>
    		@if($type == 'track')
    		<div class="item_play_btn">
    			<i class="fa fa-play"></i>
    		</div>
    		@endif
    	</div>
    	<div class="item_bottom @if($type == 'product') tot_awe_pro_right @endif">
    		<div class="item_info_box">
    			<div class="item_title">
    				@if($type == 'track')
                        @if(!$isPrivate)
        					@php $style = 'None' @endphp
        					@if($item->genre)
        						@php $style = $item->genre->name @endphp
        					@endif
        					@php $mood = 'None' @endphp
        					@if($item->dropdown_two != '')
        						@php $mood = $item->dropdown_two @endphp
        					@endif
                        @else
                            <div style="font-size: 15px;" class="lock_outer">
                                <i class="fa fa-lock private_np"></i> Private Track
                            </div><br>
                        @endif
    					{{$item->song_name}}
    				@elseif($type == 'product')
    				<h1>{{$item->title}}</h1>

    				@php $ticketsLeft = $item->quantity !== NULL ? $item->items_available - $item->items_claimed : NULL @endphp
    				@if($item->is_ticket == 1)
    				<p>
    				    Live at {{$item->location}}<br>
    				</p>
    				@endif
                    @if($item->date_time)
    				<p>{{ $item->date_time }}</p>
                    @endif
    				@if($ticketsLeft != NULL)
    				<p>{{ $ticketsLeft > 0 ? $ticketsLeft.' Available' : 'Sold out' }}</p>
    				@endif
    				@endif
    			</div>
    			@if($type == 'track' && !$isPrivate)
    			<div class="item_waveform">
    				<img src="{{asset('user-music-waveform/'.$item->waveform_image)}}" />
    			</div>
    			<div class="item_parts">
    				<div class="item_part_each">{{$style}}</div>
    				<div class="item_part_each">{{$mood}}</div>
    				<div class="item_part_each">{{$item->bpm}}</div>
    				<div class="item_part_each">{{$item->formatDuration()}}</div>
    			</div>
    			@endif
    		</div>
    		@if($type == 'track' && !$isPrivate)
    		<section class="item_desc_each">
    			<h2 class="item_desc_head">Instruments</h2>
    			<div class="item_desc_body">
    				{{implode(' - ', $item->instruments)}}
    			</div>
    		</section>
    		<section class="item_desc_each item_desc_expandable">
    			<h2 class="item_desc_head">Lyrics</h2>
    			<div class="item_desc_body">
    				{!! nl2br($item->lyrics) !!}
    			</div>
    			<div class="item_desc_read_more instant_hide"></div>
    		</section>
    		@php $musicStems = $musicLoops = [] @endphp
    		@if(count($item->downloads))
    		    @foreach($item->downloads as $key => $itemm)
    		        @if($itemm['itemtype'] == 'loop_one') @php $hasloop = 1; $loopOne = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'loop_two') @php $hasloop = 1; $loopTwo = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'loop_three') @php $hasloop = 1; $loopThree = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'stem_one') @php $hasstem = 1; $stemOne = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'stem_two') @php $hasstem = 1; $stemTwo = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'stem_three') @php $hasstem = 1; $stemThree = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'stem_four') @php $hasstem = 1; $stemFour = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'stem_five') @php $hasstem = 1; $stemFive = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'stem_six') @php $hasstem = 1; $stemSix = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'stem_seven') @php $hasstem = 1; $stemSeven = $itemm['dec_fname'] @endphp @endif
    		        @if($itemm['itemtype'] == 'stem_eight') @php $hasstem = 1; $stemEight = $itemm['dec_fname'] @endphp @endif
    		    @endforeach
    		@endif
    		@if(isset($hasloop) && $hasloop == 1)
    		<section class="item_desc_each">
    			<h2 class="item_desc_head">Loops</h2>
    			<div class="item_desc_body">
    				@if(isset($loopOne))
    				<div data-musicfile="{{ $loopOne }}" class="each_loop circle">1</div>
    				@endif
    				@if(isset($loopTwo))
    				<div data-musicfile="{{ $loopTwo }}" class="each_loop circle">2</div>
    				@endif
    				@if(isset($loopThree))
    				<div data-musicfile="{{ $loopThree }}" class="each_loop circle">3</div>
    				@endif
    			</div>
    		</section>
    		@endif
    		@if(isset($hasstem) && $hasstem == 1)
    		<section class="item_desc_each">
    			<h2 class="item_desc_head">Stems</h2>
    			<div class="item_desc_body">
    				@if(isset($stemOne))
    				<div data-musicfile="{{ $stemOne }}" class="each_stem circle">1</div>
    				@endif
    				@if(isset($stemTwo))
    				<div data-musicfile="{{ $stemTwo }}" class="each_stem circle">2</div>
    				@endif
    				@if(isset($stemThree))
    				<div data-musicfile="{{ $stemThree }}" class="each_stem circle">3</div>
    				@endif
    				@if(isset($stemFour))
    				<div data-musicfile="{{ $stemFour }}" class="each_stem circle">4</div>
    				@endif
    				@if(isset($stemFive))
    				<div data-musicfile="{{ $stemFive }}" class="each_stem circle">5</div>
    				@endif
    				@if(isset($stemSix))
    				<div data-musicfile="{{ $stemSix }}" class="each_stem circle">6</div>
    				@endif
    				@if(isset($stemSeven))
    				<div data-musicfile="{{ $stemSeven }}" class="each_stem circle">7</div>
    				@endif
    				@if(isset($stemEight))
    				<div data-musicfile="{{ $stemEight }}" class="each_stem circle">8</div>
    				@endif
    			</div>
    		</section>
    		@endif
    		<section class="item_desc_each add_to_cart">
    			<h2 class="item_desc_head">Purchase</h2>
    			<div class="item_desc_body">
    				@if($item->allow_bespoke_license_offer && $item->user->chat_switch == 1)
    				<div class="item_negotiate">Negotiate</div>
    				@endif
    				@php $personalLicK = 'Personal Use Only'.'::'.$currencySym.$item->personal_use_only @endphp
    				@php $personalLicV = 'Personal Use Only'.' ('.$currencySym.$item->personal_use_only.')' @endphp
    				<div class="item_add_to_cart">
    					<div class="item_purchase_option ch_select_options {{$item->allow_bespoke_license_offer && $item->user->chat_switch == 1 ? 'allow_offer' : ''}}">
    						<div class="item_purchase_txt license_name">Choose purchase option</div>
    						<div class="item_purchase_ic">
    							<i class="fa fa-caret-down"></i>
    						</div>
    						<select class="licence-dropdown" data-musicid="{{$item->id}}">
    							<option value="">Select Purchase Option</option>
    							@if($item->personal_use_only !== NULL)
    							<option data-price="{{$personalLicK}}" value="{{$personalLicV}}">   
    							    {{$personalLicV}}
    							</option>
    							@endif
    							@foreach(config('constants.licenses') as $key => $license)
    							    @if($item->{$license['input_name']})
    							    @php 
    							        $licKey = $item->{$license['input_name']} != 'POA' ? $license['filename'].'::'.$currencySym.$item->{$license['input_name']} : 'POA';
    							        $licValue = $license['filename'];
    							        $licValue .= $item->{$license['input_name']} != 'POA' ? ' ('.$currencySym.$item->{$license['input_name']}.')' : ' (POA)';
    							    @endphp 
    							    <option data-price="{{$licKey}}" value="{{$licValue}}">{{$licValue}}</option>
    							    @endif
    							@endforeach
    						</select>
    					</div>
    					<div class="item_cart_btn add_to_basket" data-basketuserid="{{$item->user_id}}" data-productid="0"
                       data-musicid="{{$item->id}}" data-purchasetype="music">
    						<text class="chan_btn_submit item_add_text">
    						    Add To Basket
    						</text>
    						<text id="top_music_info_{{ $item->id }}" class="music_tot_disp item_add_price">
    						    <font id="sec_one"></font> <font class="sec_two"></font>
    						</text>
    					</div>
    				</div>
    			</div>
    		</section>
    		@elseif($type == 'product')

            <section class="item_desc_each add_to_cart">
                <h2 class="item_desc_head">Purchase</h2>
                <div class="item_desc_body">
                    <div class="item_add_to_cart">
                        @if($item->price_option == 'addprice' || $item->type == 'custom')
                            <div class="item_cart_btn add_basket_btn {{$ticketsLeft !== null && $ticketsLeft <= 0 ? 'sold_out' : ''}} clearfix" data-basketuserid="{{$ticketsLeft === null || $ticketsLeft > 0 ? $item->user_id : 0 }}"
                            data-musicid="0" data-purchasetype="{{$item->type == 'custom' ? 'custom_product' : 'product'}}" data-basketprice="{{$ticketsLeft === null || $ticketsLeft > 0 ? $item->price : 0 }}" data-productid="{{$ticketsLeft === null || $ticketsLeft > 0 ? $item->id : 0 }}" data-account="{{$item->type == 'custom' ? base64_encode($user->profile->stripe_user_id) : ''}}" >
                                <div class="item_add_text">
                                    {{$ticketsLeft === null || $ticketsLeft > 0 ? 'Add to cart' : 'Sold out'}}
                                </div>
                                <div class="item_add_price">
                                    @if($item->price != $item->normal_price)
                                    <del class="normal_price">
                                        {{$currencySym}}{{ $item->normal_price }} 
                                    </del>
                                    <span class="special_price_offer">
                                        &nbsp;now&nbsp; 
                                    </span>
                                    @endif
                                    <span>
                                        {{$currencySym}}{{ $item->price }}
                                    </span>
                                </div>
                            </div>
                            @else
                            <div class="item_cart_btn add_basket_btn">
                                <div class="item_add_text {{$item->user->chat_switch == 1 ? 'product_poa' : ''}}">
                                    Send message to negotiate
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

    		@if($item->includes != '')
    		@php $includes = explode(',', $item->includes) @endphp
    		<section class="item_desc_each">
    			<h2 class="item_desc_head">This product includes</h2>
    			<div class="item_desc_body">
    				<ul class="main_prod_list">
    				    @foreach($includes as $include)
    				    <li class="li_bullet">{{ trim($include) }}</li>
    				    @endforeach
    				</ul>
    			</div>
    		</section>
    		@endif
            @if($item->type == 'custom')
                @php $customProduct = $item->customProduct() @endphp
                @php $ticketsLeft = 1 @endphp
                <section class="item_desc_each">
                    <h2 class="item_desc_head">Shipping</h2>
                    <div class="item_desc_body">
                        <p>
                            Within UK: {{$currencySym.$customProduct->delivery_cost[$user->profile->default_currency]['local']}}
                        </p>
                        <p>
                            Outside UK: {{$currencySym.$customProduct->delivery_cost[$user->profile->default_currency]['int']}}
                        </p>
                    </div>
                </section>
                @if(isset($item->design['colors']))
                <section class="item_desc_each tot_awe_pro_colors">
                    <h2 class="item_desc_head">Colors</h2>
                    <div class="item_desc_body tot_awe_colors_in">
                        @foreach($item->design['colors'] as $color)
                        @if($color['status'] == '0')
                            @php continue @endphp
                        @endif
                        @php $slug = str_slug($color['name']) @endphp
                        <div data-image="/prints/uf_{{$user->id.'/designs/'.$color['image']}}" data-name="{{$color['name']}}" class="tot_awe_color_each {{$slug}} {{str_slug($color['name']) == $item->design['default_color'] ? 'active' : ''}}"></div>
                        @endforeach
                    </div>
                </section>
                @endif
                @if($customProduct->sizes !== NULL)
                <section class="item_desc_each tot_awe_pro_sizes">
                    <h2 class="item_desc_head">Sizes</h2>
                    <div class="item_desc_body tot_awe_colors_in">
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
                </section>
                @endif
                <section class="item_desc_each">
                    <h2 class="item_desc_head">Quantity</h2>
                    <div class="item_desc_body">
                        <input type="number" min="1" class="tot_awe_pro_qua" value="1" />
                    </div>
                </section>
            @endif
    		<section class="item_desc_each item_desc_expandable">
    			<h2 class="item_desc_head">Product Description</h2>
    			<div class="item_desc_body">
    				{!! nl2br($item->description) !!}
    			</div>
    			<div class="item_desc_read_more instant_hide"></div>
    		</section>

    		@if($item->requires_shipping == 1)
    		<section class="item_desc_each">
    			<h2 class="item_desc_head">Shipping</h2>
    			<div class="item_desc_body">
    				<p>
    					Local: {{$currencySym.$item->local_delivery}}
    				</p>
    				<p>
    					International: {{$currencySym.$item->international_shipping}}
    				</p>
    			</div>
    		</section>
    		@endif
            @if($user->isCotyso())
                @include('parts.item-singing-intro')
            @endif
    		@endif
    	</div>
    </div>