<div class="tab_chanel_sub_list clearfix each-album-music" data-thumbnail-player="{{ $music->thumbnail_player }}" data-musicid="{{ $music->id }}" data-musicfile="{{ $music->music_file }}">

    <?php $musicThumb = $music->thumbnail_left == "" ? asset("img/url-thumb-profile.jpg") : asset( "user-music-thumbnails/" . $music->thumbnail_left );?>

    <?php
    $style = "None";
    if($music->genre){
        $style = $music->genre->name;
    }

    $mood = "None";
    if($music->dropdown_two != ""){
        $mood = $music->dropdown_two;
    }
    ?>

    @php 
        $defaultCurrSym = \App\Http\Controllers\CommonMethods::getCurrencySymbol(strtoupper($music->user->profile->default_currency));
    @endphp
    
    <div class="summary">
        <a class="main_an" href="javascript:void(0)">
            <img class="play_now vertical_center instant_hide" src="{{ asset('images/play_icon.png') }}">
            <i class="fa fa-spin fa-spinner vertical_center instant_hide loading_smg"></i>
            <img class="main_img" src="{{ $musicThumb }}" alt="#" />
        </a>

        <div class="tab_chanel_img_det">
            <div class="upper_music_det">
                <a class="thismusic_user_name" href="{{route('user.home.tab',['params'=>$music->user->username, 'tab' => '2'])}}">{{ $music->song_name }}</a>
                <div class="vertical_center fav_np @if (Auth::check()) {{ is_array(Auth::user()->favourite_musics) && in_array($music->id, Auth::user()->favourite_musics) ? 'active' : '' }} @endif fa fa-heart"></div>
            </div>
            <div class="thismusic_wave_img">
                <img src="{{asset('user-music-waveform/'.$music->waveform_image)}}">
            </div>
            <div class="lower_music_det">
                <div class="each_lower_det">{{$style}}</div>
                <div class="each_lower_det">{{$mood}}</div>
                <div class="each_lower_det">{{$music->bpm}}</div>
                <div class="each_lower_det">{{$music->formatDuration()}}</div>
                <div class="each_lower_det">&nbsp;</div>
            </div>
            <div class="res_right hide_on_desktop">
                <div class="res_right_each_text">{{$style}}</div>
                <div class="res_right_each_text">{{$mood}}</div>
                <div class="res_right_each_text">{{$music->bpm}}</div>
                <div class="res_right_each_text">{{$music->formatDuration()}}</div>
            </div>
        </div>
    </div>

    <div class="ch_video_detail_outer add_to_cart_item clearfix" style="display: none;">
        <div class="clearfix">
            <div class="music_det clearfix">
                <div class="headline">Instruments</div>
                <div class="detail">
                    <div class="instruments_detail">
                        {{implode(' - ', $music->instruments)}}
                    </div>
                </div>
            </div>
            @if($music->lyrics)
            <div class="music_det clearfix">
                <div class="headline">Lyrics</div>
                <div class="detail">
                    <div class="lyrics_detail">
                        {!! nl2br($music->lyrics) !!}
                    </div>
                    <div class="lyrics_more instant_hide">Read More</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
