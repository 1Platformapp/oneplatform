<div class="feat_album_temp feat_template" id="feat_slide_{{ $count }}">
    <div class="colio_header">My Album</div>
    <div class="user_hm_rt_btm_inner">
        <div class="upper_sec">
            @php 
                $albumThumb = asset('images/default_thumb_album.png');
                if($userFeatAlbum->thumbnail_feat != null && $userFeatAlbum->thumbnail_feat != ''){
                    $albumThumb = asset('user-album-thumbnails/'.$userFeatAlbum->thumbnail_feat);
                }
            @endphp
            <span class="upper_up_contain">
                <span class="feat_nav_arrow" id="feat_nav_arrow_left" >
                    <i class="fa fa-angle-left"></i>
                </span>
                <img alt="{{$userFeatAlbum->name}}" class="defer_loading" src="#" data-src="{{ $albumThumb }}">
                <span class="feat_nav_arrow" id="feat_nav_arrow_right" >
                    <i class="fa fa-angle-right"></i>
                </span>
            </span>
            <div class="music_scroll">
                <b>{{ $userFeatAlbum->name }}</b>
                <p>{!! nl2br($userFeatAlbum->description) !!}</p>
            </div>
            <div class="feat_actions">
                <div class="feat_action_btn feat_view_album">View Album</div>
            </div>
        </div>
        <div class="lower_sec">
            <label class="add_ticket feat_album_add" data-productid="0" data-basketuserid="{{$userFeatAlbum->user->id}}" data-basketprice="{{$userFeatAlbum->price}}" data-musicid="0" data-albumid="{{$userFeatAlbum->id}}" data-purchasetype="album" style="cursor: pointer;">
                Add Album
                <strong>{{$commonMethods->getCurrencySymbol(strtoupper($userFeatAlbum->user->profile->default_currency))}}{{ $userFeatAlbum->price }}</strong>
            </label>
        </div>
    </div>
</div>
