<div class="tot_awe_pro_outer">
    <div class="tot_awe_pro_upper">
        <div class="tot_awe_pro_left">
            @php 
                $albumThumb = asset('images/default_thumb_album.png');
                if($album->thumbnail_feat != null && $album->thumbnail_feat != ''){
                    $albumThumb = asset('user-album-thumbnails/'.$album->thumbnail_feat);
                }
            @endphp
            <div class="user_product_img_thumb">
                <img class="" src="{{$albumThumb}}">
            </div>
        </div>

        <div class="tot_awe_pro_right">
            <h3>{{ $album->name }}</h3>
            <p>
                {!! nl2br($album->description) !!}
            </p>
        </div>
    </div>
    <div class="teb_chan_moreinfo_sec_outer add_basket_btn clearfix" data-productid="0" data-basketuserid="{{$album->user->id}}" data-basketprice="{{$album->price}}" data-musicid="0" data-albumid="{{$album->id}}" data-purchasetype="album" style="cursor: pointer;">

        <a href="#">Add Album</a>
        <span>{{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}{{ $album->price }}</span>
    </div>

</div>

