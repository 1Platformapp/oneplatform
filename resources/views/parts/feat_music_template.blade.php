
<div class="feat_music_temp feat_template" id="feat_slide_{{ $count }}">
    <div class="colio_header">My Music</div>
    <div class="user_hm_rt_btm_inner">
        <div class="upper_sec">
            @php $featMusicThumb = $userFeatMusic->thumbnail_feat != '' ? asset('user-music-thumbnails/'.$userFeatMusic->thumbnail_feat) : asset('img/url-thumb-profile.jpg') @endphp
            <span class="upper_up_contain">
                <span class="feat_nav_arrow" id="feat_nav_arrow_left" >
                    <i class="fa fa-angle-left"></i>
                </span>
                <img alt="{{$userFeatMusic->song_name}}" class="defer_loading" src="#" data-src="{{ $featMusicThumb }}">
                <span class="feat_nav_arrow" id="feat_nav_arrow_right" >
                    <i class="fa fa-angle-right"></i>
                </span>
            </span>
            <ul class="feat_music_list clearfix">
                <li>
                    <mark>BPM</mark>
                    <p>{{ $userFeatMusic->bpm != '' ? $userFeatMusic->bpm : 'None' }}</p>
                </li>
                <li>
                    <mark>Mood</mark>
                    <p>{{ $userFeatMusic->dropdown_two != '' ? $userFeatMusic->dropdown_two : 'None' }}</p>
                </li>
                <li>
                    <mark>Style</mark>
                    <p>{{ $userFeatMusic->genre != null ? $userFeatMusic->genre->name : '' }}</p>
                </li>
            </ul>
            <div class="music_scroll">
                <b>{{ $userFeatMusic->song_name }}</b>
                <p>{{ $userFeatMusic->album_name }} </p>
            </div>
        </div>
        <div class="lower_sec">
            <label class="add_ticket feat_music_info" data-musicid="{{ $userFeatMusic->id }}" data-musicfile="{{ $userFeatMusic->music_file }}" data-thumbnail-player="{{ $userFeatMusic->thumbnail_player }}" style="cursor: pointer;">More Info<strong></strong>
                <div class="instant_hide">
                    <span class="thismusic_song_name">{{$userFeatMusic->song_name}}</span>
                    <span class="thismusic_user_name">{{$userFeatMusic->user->name}}</span>
                </div>
            </label>
        </div>
    </div>
</div>
