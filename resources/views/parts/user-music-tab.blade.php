
<div class="hide_on_desktop" data-video-id="R4GUz1XsDqA" id="offer_guide">
    <div class="music_head_img">How to make proposals</div>
</div>

<div class="tab_chan_tp_btns clearfix">

    <div data-id="singles" class="each_music_head">
        <div class="music_head_img">
            <img src="{{asset('images/music_tab_01_active.png?v=1.1')}}">
        </div>
    </div>
    <div data-id="albums" class="each_music_head">
        <div class="music_head_img">
            <img src="{{asset('images/music_tab_02.png?v=1.1')}}">
        </div>
    </div>
    <div class="hide_on_mobile" data-video-id="R4GUz1XsDqA" id="offer_guide">
        <div class="music_head_img">How to make proposals</div>
    </div>

</div>

<div class="tab_chanel_list_outer" id="music_and_vidoes2">
        
    <div class="user_musics_outer">
    	<h3 class="tabd2_head">Singles</h3>
            <div class="music_main_outer">  

                @if($user->music_smart_links_url && $user->music_smart_links_url != '')
                    <iframe style="margin: 25px 0;" width="100%" height="52" src="{{$user->music_smart_links_url}}&theme=light" frameborder="0" allowfullscreen sandbox="allow-same-origin allow-scripts allow-presentation allow-popups allow-popups-to-escape-sandbox"></iframe>
                @endif

                @foreach($user->musics as $userMusic)
                    
                    @if(count($userMusic->privacy) && isset($userMusic->privacy['status']) && $userMusic->privacy['status'] == '1')

                        @include('parts.user-channel-music-private-template',['music'=>$userMusic, 'type' => 'music'])
                    @else

                        @include('parts.user-channel-music-template',['music'=>$userMusic])
                    @endif
                @endforeach
            </div>
    </div>

</div>



<div class="user_album_outer" id="albums_div2" style="display: none;">
    <h3 class="tabd2_head">Albums</h3>
    @foreach($user->albums as $album)

        @include('parts.user-channel-album-template', ['album' => $album])

    @endforeach

</div>