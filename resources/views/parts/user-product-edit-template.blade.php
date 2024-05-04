<form data-id="prod_gig_form_{{ $product->id }}" action="{{ route('save.user.profile_prod_gigs') }}" method="POST" enctype="multipart/form-data" style="display: none;">
    {{ csrf_field() }}

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="pro_music_info">
        <label>
            Edit Product Information
            <i class="fa fa-times edit_elem_close"></i>
        </label>

        @if($product->type == 'personal')

        <div class="pro_upload_video music_thum_sec clearfix">
            <div class="pro_left_video_img">
                <span class="upload_vieo_img" onclick="$('#product_thumb_{{ $product->id }}').trigger('click'); return false;"> <img src="{{$commonMethods::getUserProductThumbnail($userProduct->id)}}" alt="#" id="display-product-thumb_{{ $product->id }}" style="max-width: 258px; cursor: pointer;" /></span>
                <a style="color:#ec2450; cursor: pointer;" onclick="$('#product_thumb_{{ $product->id }}').trigger('click'); return false;">Add Thumbnail</a>
                <input accept="image/*" type="file" style="display: none;" name="product_thumb" id="product_thumb_{{ $product->id }}" class="product_thumb" data-prodid="{{ $product->id }}">
            </div>

            <div class="pro_right_video_det">
                <p>Add your image here to represent the best visual for your product
                </p>
            </div>

        </div>

        @endif

    </div>

    @if($product->type == 'personal')
    <div class="pro_stream_input_each">
        <input placeholder="Product Title" type="text" class="pro_stream_input product_title" name="product_title" value="{{ $product->title }}">
    </div>

    @if($user->isCotyso())
    <div class="pro_stream_input_each">
        <div class="stream_sec_opt_outer">
            <select class="" name="pro_product_voucher">
                <option value="">Choose Voucher</option>
                @foreach($vouchers as $key => $voucher)
                    <option {{$product->voucher_id == $voucher['id'] ? 'selected' : ''}} value="{{$voucher['id']}}">
                        {{$voucher['name']}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    @endif

    <div class="pro_stream_input_each">
        <textarea placeholder="Description" class="pro_news_textarea" name="product_description">{{$product->description}}</textarea>
    </div>

    <div class="pro_stream_input_each">
        <textarea placeholder="Add items as bullets separated by comma i.e item 1,item 2,item 3" class="pro_news_textarea" name="product_includes">{{$product->includes}}</textarea>
    </div>

    <div class="pro_stream_input_each">
        <input class="pro_stream_input" type="number" placeholder="Product Quantity (Leave empty if unlimited or does not apply)" name="product_amount_available" min="1" value="{{ $product->items_available }}" />
    </div>

    <div class="pro_stream_input_row">
        <div class="pro_stream_input_each">
            <div class="stream_sec_opt_outer">
                <select class="pro_product_price_option" name="pro_product_price_option">
                    <option value="">Choose Price</option>
                    <option {{$product->price_option == 'addprice' ? 'selected' : ''}} value="addprice">Add price</option>
                    <option {{$product->price_option == 'poa' ? 'selected' : ''}} value="poa">POA</option>
                </select>
            </div>
        </div>
        <div class="pro_stream_input_each">
            <input class="product_price pro_stream_input" type="number" placeholder="Price" name="product_price" min="1" value="{{ $product->normal_price }}" {{$product->price_option == 'addprice' ? '' : 'disabled'}} />
        </div>
    </div>

    <div class="pro_price_timer">
        @if(!$product->special_price)
    	<div class="pro_action_btn add_timer">Add Special Price Offer</div>
        @else
        <div class="pro_action_btn remove_timer">Remove Special Price Offer</div>
        @endif
    	<div class="pro_price_timer_body {{!$product->special_price ? 'instant_hide' : ''}}">
    		<div class="pro_stream_input_row">
                <div class="pro_stream_input_row">
                    <div class="pro_stream_input_each">
                        <input class="product_timer_price pro_stream_input" type="number" placeholder="Enter price" name="product_timer_price" value="{{$product->special_price ? $product->special_price['price'] : ''}}" />
                    </div>
                    @if($userPersonalDetails['countryCode'] != '')
                        @php $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $userPersonalDetails['countryCode']) @endphp
                    @else
                        @php $timezones = \DateTimeZone::listIdentifiers() @endphp
                    @endif
                    <div class="pro_stream_input_each">
                        <select class="product_timer_timezone pro_stream_input" name="product_timer_timezone">
                            <option value="">Select your timezone</option>
                            @foreach($timezones as $timezone)
                                <option {{$product->special_price && $product->special_price['timezone'] == $timezone ? 'selected' : ''}} value="{{$timezone}}">{{$timezone}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    		    <div class="pro_stream_input_row">
    		        <div class="pro_stream_input_each">
    		           <input class="product_timer_start_date_time pro_stream_input" type="text" placeholder="Select start date & time" name="product_timer_start_date_time" value="{{$product->special_price ? $product->special_price['start_date_time'] : ''}}" readonly />
    		        </div>
    		        <div class="pro_stream_input_each">
    		            <input class="product_timer_end_date_time pro_stream_input" type="text" placeholder="Select end date & time" name="product_timer_end_date_time" value="{{$product->special_price ? $product->special_price['end_date_time'] : ''}}" readonly />
    		        </div>
    		    </div>
    		</div>
    	</div>
    </div>

    <div class="pro_stream_input_row">
        <div class="pro_stream_input_each">
            <div class="stream_sec_opt_outer">
                <select class="pro_product_shipping_option" name="pro_product_shipping_option">
                    <option value="">Does this product require shipping?</option>
                    <option {{$product->requires_shipping == 1 ? 'selected' : ''}} value="yes">Yes, this product requires shipping</option>
                    <option {{$product->requires_shipping == 1 ? '' : 'selected'}} value="no">No</option>
                </select>
            </div>
        </div>
        <div class="pro_stream_input_row">
            <div class="pro_stream_input_each">
                <input class="local_delivery pro_stream_input" type="number" min="1" placeholder="Local Delivery" name="local_delivery" value="{{ $product->requires_shipping == 1 ? $product->local_delivery : '' }}" {{$product->requires_shipping == 1 ? '' : 'disabled'}} />
            </div>
            <div class="pro_stream_input_each">
                <input class="international_shipping pro_stream_input" type="number" min="1" placeholder="International Shipping" name="international_shipping" value="{{ $product->requires_shipping == 1 ? $product->international_shipping : '' }}" {{$product->requires_shipping == 1 ? '' : 'disabled'}} />
            </div>
        </div>
    </div>
    <div class="pro_stream_input_row">
        <div class="pro_stream_input_each">
            <div class="stream_sec_opt_outer">
                <select class="pro_product_ticket_option" name="pro_product_ticket_option">
                    <option value="">Is this product a ticket for a gig/event?</option>
                    <option {{$product->is_ticket == 1 ? 'selected' : ''}} value="yes">Yes, this product is a ticket for a gig/event</option>
                    <option {{$product->is_ticket == 1 ? '' : 'selected'}} value="no">No</option>
                </select>
            </div>
        </div>
        <div class="pro_stream_input_row">
            <div class="pro_stream_input_each">
               <input class="product_ticket_date_time pro_stream_input" type="text" placeholder="Date And Time" name="date_time" value="{{ $product->date_time }}" {{$product->is_ticket == 1 ? '' : 'disabled'}} />
            </div>
            <div class="pro_stream_input_each">
                <input class="product_ticket_location pro_stream_input" type="text" placeholder="Location/city" name="location" value="{{ $product->location }}" {{$product->is_ticket == 1 ? '' : 'disabled'}} />
            </div>
        </div>
    </div>

    <div class="pro_stream_input_each">
        <textarea class="product_ticket_terms pro_news_textarea" placeholder="Ticket terms and conditions (if any)" name="terms_conditions" {{$product->is_ticket == 1 ? '' : 'disabled'}} >{{$product->is_ticket == 1 ? $product->terms_conditions : ''}}</textarea>
    </div>

    @elseif($userProduct->type == 'custom' && $userProduct->customProduct())

    @php $customProduct = $userProduct->customProduct() @endphp
    @php $customProductlug = str_slug($customProduct->name) @endphp
    <div data-prod-id="{{$customProduct->id}}" class="pro_design_st_3_outer pro_edit_design_st_3_outer">
        <div class="pro_design_st_3_each">
            <div data-background="{{$commonMethods::getUserProductThumbnail($userProduct->id)}}" class="pro_design_st4_prod_outer">

            </div>

            <div class="port_each_field">
                <div class="port_field_label">
                    <div class="port_field_label_text">Name</div>
                </div>
                <div class="port_field_body">
                    <input type="text" class="port_field_text" placeholder="Enter Product Name" name="pro_edit_prod_name" value="{{$userProduct->title}}">
                </div>
            </div>

            <div class="port_each_field">
                <div class="port_field_label">
                    <div class="port_field_label_text">Description</div>
                </div>
                <div class="pro_stream_input_each">
                    <textarea placeholder="Write here" type="text" class="pro_news_textarea" name="pro_edit_prod_description">{{$userProduct->description}}</textarea>
                </div>
            </div>

            <div class="port_each_field">
                <div class="port_field_label">
                    <div class="port_field_label_text">Default Color</div>
                </div>
                <div class="port_field_body pro_stream_input_each">
                    <div class="stream_sec_opt_outer">
                        <select name="pro_edit_prod_color_default">
                            @foreach($customProduct->colors as $color)
                            @php $colorSlug = str_slug($color) @endphp
                            <option {{$userProduct->design['default_color'] == $colorSlug ? 'selected' : ''}} value="{{$colorSlug}}">{{$color}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @php $pricing = $commonMethods->customProductPricing($customProduct, $userProduct->user->profile->default_currency, $userProduct->price) @endphp
            <div class="port_each_field">
                <div class="port_field_label">
                    <div class="port_field_label_text">Price (min <span class="pro_edit_design_min_price">{{$pricing['min_price']}} {{strtoupper($userProduct->user->profile->default_currency)}}</span>)</div>
                </div>
                <div class="port_field_body">
                    <input type="text" class="port_field_text" placeholder="Enter Price" name="pro_edit_prod_price" value="{{$userProduct->price}}">
                </div>
            </div>
            <div class="pro_design_st_5_commission">
                <div class="pro_design_st_5_comm">
                    <div class="pro_edit_design_st_5_comm_txt">Your commission</div>
                    <div class="pro_edit_design_st_5_comm_val">{{$pricing['commission']}} {{strtoupper($userProduct->user->profile->default_currency)}}</div>
                </div>
                <div class="pro_edit_design_st_5_comm_calc">Recalculate</div>
            </div>
        </div>
        <div class="pro_design_st_3_each">
            <div class="pro_design_st3_prod_options">
                @foreach($userProduct->design['colors'] as $color)
                @php $colorSlug = str_slug($color['name']) @endphp
                <div class="pro_design_st4_prod_option_each">
                    <div class="st3_prod_option_thumb">
                        <img src="{{asset('prints').'/uf_'.$userProduct->user->id.'/designs/'.$color['image']}}" />
                    </div>
                    <div class="st4_prod_option_action">
                        <div class="st4_prod_option_field">
                            @php $checked = $color['status'] == 1 ? 'checked' : '' @endphp
                            <input {{$checked}} type="checkbox" value="{{$colorSlug}}" name="pro_edit_prod_colors[]" />
                        </div>
                        <div class="st4_prod_option_name">
                            {{$color['name']}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="save_product_outer edit_profile_btn_1 clearfix">
        <a href="javascript:void(0)">Submit</a>
    </div>

</form>
