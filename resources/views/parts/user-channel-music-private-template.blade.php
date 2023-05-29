@php $playerThumb = $music->thumbnail_player == '' ? 'url-thumb-profile.jpg' : $music->thumbnail_player @endphp
@php $domain = parse_url(request()->root())['host'] @endphp
<div class="tab_chanel_list clearfix each-{{$type}} private-music" data-thumbnail-player="{{ $playerThumb }}" data-type="{{$type}}" data-musicid="{{ $music->id }}">
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

        <div class="summary">
            <a class="main_an" href="javascript:void(0)">
                <img class="play_now vertical_center instant_hide " src="{{ asset('images/play_icon.png') }}">
                <i class="fa fa-spin fa-spinner vertical_center instant_hide loading_smg"></i>
                <img class="main_img" src="{{ $musicThumb }}" alt="#" />
            </a>
            <div class="tab_chanel_img_det">
                <div class="upper_music_det">
                    <a class="thismusic_user_name" href="{{route('user.home.tab',['params'=>$music->user->username, 'tab' => '2'])}}">{{ $music->user->name }}</a>
                    <p class="thismusic_song_name" >{{ $music->song_name }}</p>
                </div>
                <div class="lock_outer vertical_center">
                    <i class="fa fa-lock private_np"></i> Private
                </div>
                <div class="thismusic_wave_img music_sub_tools">
                    <div class="vertical_center fav_np @if (Auth::check()) {{ is_array(Auth::user()->favourite_musics) && in_array($music->id, Auth::user()->favourite_musics) ? 'active' : '' }} @endif fa fa-heart"></div>
                    <div data-title="{{$music->song_name}}" data-opd="item" data-item="{{base64_encode($music->id)}}" data-type="track" data-slug="{{str_slug($music->song_name)}}" class="vertical_center item_share fa fa-share-alt"></div>
                </div>
            </div>
        </div>
</div>