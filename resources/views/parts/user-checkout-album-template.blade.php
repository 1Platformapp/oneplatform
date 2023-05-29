
@php $commonMethods = new \App\Http\Controllers\CommonMethods(); @endphp
@if(is_array($basket->album->musics) && count($basket->album->musics))
    @php 
        $albumThumb = asset('images/default_thumb_album.png');
        if($basket->album->thumbnail != null && $basket->album->thumbnail != ''){
            $albumThumb = asset('user-album-thumbnails/'.$basket->album->thumbnail);
        }
    @endphp

    @if(isset($disparity) && $disparity == 1)
        <div class="tot_awe_pro_outer">
            <div class="user_product_summary clearfix">
                <div class="user_product_summary_left">
                    <div class="user_product_img_thumb">
                        <img class="" src="{{$albumThumb}}">
                    </div>
                </div>
                <div class="user_product_summary_right">
                    <h3>{{$basket->album->name}}</h3>
                    <p>{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency)).$basket->price}}</p>
                </div>
                <div class="user_product_summary_actions">
                    <div data-id="{{$basket->id}}" class="user_product_action_btn item_disp_update_price">
                        Update Price - {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency)).$basket->itemOriginalPrice()}}
                    </div>
                    <div data-id="{{$basket->id}}" class="user_product_action_btn item_disp_remove">
                        Remove Item
                    </div>
                </div>
            </div>

        </div>    
    @else
        <div class="tab_chanel_list clearfix each-album album_div_01" data-albumid="{{ $basket->album->id }}">

            <div class="summary album-summary">
                <a href="javascript:void(0)">
                    <img class="" src="{{$albumThumb}}" alt="{{$basket->album->name}}" />
                </a>
                <div class="tab_chanel_img_det">
                    <a href="javascript:void(0)">{{ $basket->album->name }}</a>
                    <p>{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ $basket->album->price }}</p>
                </div>
                <div class="music_actions">
                    <div class="buy_np fa fa-shopping-cart vertical_center"></div>
                </div>
            </div>
            <div class="album_tab_lowerSection" style="display: none;">
                <div class="add_to_cart_album clearfix">
                    <div class="clearfix">
                        @foreach($basket->album->musics as $musicId)
                            @php $music = \App\Models\UserMusic::find($musicId) @endphp
                            @if($music)
                                <div class="ch_video_detail_right_sec">
                                    <div class="ch_select_perch_options">
                                        <text class="license_name">{{$music->song_name}} - Personal Use License</text>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    
@endif