@if($album->musics && count($album->musics) > 0)

    <div class="tab_chanel_list clearfix each-album album_div_01" data-albumid="{{ $album->id }}">
        @php 
            $albumThumb = asset('images/default_thumb_album.png');
            if($album->thumbnail != null && $album->thumbnail != ''){
                $albumThumb = asset('user-album-thumbnails/'.$album->thumbnail);
            }
        @endphp
        <div class="summary album-summary">
            <a class="main_an" href="javascript:void(0)">
                <img class="main_img" src="{{$albumThumb}}" alt="{{$album->name}}" />
            </a>
            <div class="tab_chanel_img_det">
                <a href="javascript:void(0)">{{ $album->user->name }}</a>
                <p>{{ $album->name }}</p>
                <p>{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ $album->price }}</p>
                <div class="vertical_center buy_np fa fa-shopping-cart"></div>
            </div>
        </div>

        <div class="album_tab_lowerSection" style="display: none;">

            @if(is_array($album->musics) && count($album->musics))
                @foreach($album->musics as $musicId)
                    @php $music = \App\Models\UserMusic::find($musicId) @endphp
                    @if($music)
                        @if(count($music->privacy) && $music->privacy['status'] == '1')
                            @include('parts.user-channel-music-private-template',['music' => $music, 'type' => 'album-music'])
                        @else
                            @include('parts.user-channel-album-music-template',['music' => $music])
                        @endif
                    @endif
                @endforeach
            @endif
            <div class="add_to_cart_album clearfix">
                <div class="clearfix">
                    <div class="ch_video_detail_right_sec">
                        <div class="ch_select_perch_options">
                            <text class="license_name">Personal Use Only For Albums</text>
                        </div>
                        <div class="ch_select_perch_options add_to_basket" data-basketuserid="{{ $album->user->id }}" data-productid="0" data-musicid="0" data-albumid="{{ $album->id }}" data-basketprice="{{ $album->price }}" data-purchasetype="album">
                            <text class="chan_btn_submit">
                                Add Album To Basket
                            </text>
                            <text id="top_music_info_{{ $album->id }}" class="music_tot_disp">
                                <font id="sec_one">Total</font> <font class="sec_two">{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ $album->price }}</font>
                            </text>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif