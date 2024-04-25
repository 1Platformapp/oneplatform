@php $commonMethods = new \App\Http\Controllers\CommonMethods(); @endphp
<?php $musicThumb = $basket->music->thumbnail_left == "" ? asset("img/url-thumb-profile.jpg") : asset( "user-music-thumbnails/" . $basket->music->thumbnail_left );?>
@if(isset($disparity) && $disparity == 1)
    
    <div class="tot_awe_pro_outer">
        <div class="clearfix user_product_summary">
            <div class="user_product_summary_left">
                <div class="user_product_img_thumb">
                    <img class="" src="{{$musicThumb}}">
                </div>
            </div>
            <div class="user_product_summary_right">
                <h3>{{$basket->music->song_name}}</h3>
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
    
    <div class="clearfix tab_chanel_list each-music" data-thumbnail-player="{{ $basket->music->thumbnail_player }}" data-musicid="{{ $basket->music->id }}" data-musicfile="{{ $basket->music->music_file }}">

            <?php
            $style = "None";
            if($basket->music->genre){
                $style = $basket->music->genre->name;
            }

            $mood = "None";
            if($basket->music->dropdown_two != ""){
                $mood = $basket->music->dropdown_two;
            }
            ?>

            <div class="summary">
                <a href="javascript:void(0)">
                    <img class="play_now vertical_center instant_hide " src="{{ asset('images/play_icon.png') }}">
                    <i class="fa fa-spin fa-spinner vertical_center instant_hide loading_smg"></i>
                    <img class="" src="{{ $musicThumb }}" alt="#" />
                </a>
                <div class="tab_chanel_img_det">
                    <div class="upper_music_det">
                        <p class="thismusic_song_name" >{{ $basket->music->song_name }}</p>
                        <p class="thismusic_license_name" >{{ $basket->license }} - {{ $commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency)).$basket->price }}</p>
                        <div class="vertical_center fav_np @if (Auth::check()) {{ is_array(Auth::user()->favourite_musics) && in_array($basket->music->id, Auth::user()->favourite_musics) ? 'active' : '' }} @endif fa fa-heart"></div>
                    </div>
                    <div class="thismusic_wave_img">
                        <img src="{{asset('user-music-waveform/'.$basket->music->waveform_image)}}">
                    </div>
                </div>
            </div>

            <div class="clearfix ch_video_detail_outer add_to_cart_item" style="display: none;">
                <div class="clearfix">
                    <div class="clearfix music_det">
                        <div class="headline">Instruments</div>
                        <div class="detail">
                            <div class="instruments_detail">
                                {{implode(' - ', $basket->music->instruments)}}
                            </div>
                        </div>
                    </div>
                    @if($basket->music->lyrics)
                    <div class="clearfix music_det">
                        <div class="headline">Lyrics</div>
                        <div class="detail">
                            <div class="lyrics_detail">
                                {!!$basket->music->lyrics!!}
                            </div>
                            <div class="lyrics_more instant_hide">Read More</div>
                        </div>
                    </div>
                    @endif
                    @php $musicStems = $musicLoops = [] @endphp
                    @php 
                        $downloads = [];
                        if($basket->music->downloads && is_array($basket->music->downloads) && count($basket->music->downloads)) {
                            $downloads = [array_filter(unserialize($basket->music->downloads))];
                        } else {
                            $downloads = [];
                        }
                    @endphp
                    @if(count($downloads))
                        @foreach($downloads as $key => $item)
                            @if($item['itemtype'] == 'loop_one') @php $hasloop = 1; $loopOne = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'loop_two') @php $hasloop = 1; $loopTwo = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'loop_three') @php $hasloop = 1; $loopThree = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'stem_one') @php $hasstem = 1; $stemOne = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'stem_two') @php $hasstem = 1; $stemTwo = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'stem_three') @php $hasstem = 1; $stemThree = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'stem_four') @php $hasstem = 1; $stemFour = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'stem_five') @php $hasstem = 1; $stemFive = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'stem_six') @php $hasstem = 1; $stemSix = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'stem_seven') @php $hasstem = 1; $stemSeven = $item['dec_fname'] @endphp @endif
                            @if($item['itemtype'] == 'stem_eight') @php $hasstem = 1; $stemEight = $item['dec_fname'] @endphp @endif
                        @endforeach
                    @endif
                    <div class="clearfix music_det">
                        @if(isset($hasloop) && $hasloop == 1)
                        <div class="loop_outer">
                            <div class="loop_inner">
                                <div class="loop_head headline">Loops</div>
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
                        </div>
                        @endif
                        @if(isset($hasstem) && $hasstem == 1)
                        <div class="stem_outer">
                            <div class="stem_inner">
                                <div class="stem_head headline">Stems</div>
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
                        </div>
                        @endif
                    </div>
                </div>
            </div>
    </div>
@endif


