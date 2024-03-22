@php $commonMethods = new \App\Http\Controllers\CommonMethods() @endphp

@if($b->purchase_type == 'music')
    <?php
    $thumb = $b->music->thumbnail_left == "" ? asset("img/url-thumb-profile.jpg") : asset("user-music-thumbnails/" . $b->music->thumbnail_left);
    $title = $b->music->song_name;
    if(strpos($b->license, 'bespoke_') !== false){
        $description = 'Bespoke License';
    }else{
        $description = $b->license;
    }
    $price = $b->price;
    ?>
@elseif($b->purchase_type == 'album')
    <?php
    $thumb = !$b->album->thumbnail || $b->album->thumbnail == '' ? asset('images/default_thumb_album.png') : asset('user-album-thumbnails/'.$b->album->thumbnail);
    $title = $b->album->name;
    $description = $b->user->name;
    $price = $b->price;
    ?>
@elseif($b->purchase_type == 'product')
    <?php
    $thumb = $b->product->thumbnail_left == "" ? asset("img/url-thumb-profile.jpg") : asset("user-product-thumbnails/" . $b->product->thumbnail_left);
    $title = $b->product->title;
    $description = $b->product->description;
    $price = $b->price;
    ?>
@elseif($b->purchase_type == 'custom_product')
    <?php
    $thumb = $commonMethods->getUserProductThumbnail($b->product->id, $b->id);
    $title = $b->product->title;
    $metaData = $commonMethods->getBasketProductMetaData($b->id);
    $description = $metaData['size'] != '' ? 'Size: '.$metaData['size'] : '';
    $price = $b->price;
    ?>
@elseif($b->purchase_type == 'subscription')
    <?php
    $thumb = $commonMethods->getUserDisplayImage($b->user->id);
    $title = 'Subscription';
    $description = 'You are subscribing '.$b->user->name;
    $price = $b->price.' p/m';
    ?>
@elseif($b->purchase_type == 'donation_goalless')
    <?php
    $thumb = $commonMethods->getUserDisplayImage($b->user->id);
    $title = 'Donation';
    $description = 'You are donating '.$b->user->name;
    $price = $b->price;
    ?>
@elseif($b->purchase_type == 'project')
    <?php
    $thumb = $b->instantItemThumbnail();
    $title = 'Project';
    $description = $b->instantItemTitle();
    $price = $b->price;
    ?>
@elseif($b->purchase_type == 'project')
    <?php
    $thumb = $b->instantItemThumbnail();
    $title = 'Project';
    $description = $b->instantItemTitle();
    $price = $b->price;
    ?>
@elseif($b->purchase_type == 'instant-license')
    <?php
    $thumb = $b->instantItemThumbnail();
    $title = 'License';
    $description = $b->instantItemTitle();
    $price = $b->price;
    ?>
@elseif($b->purchase_type == 'proferred-product')
    <?php
    $thumb = $b->instantItemThumbnail();
    $title = 'Product';
    $description = $b->instantItemTitle();
    $price = $b->price;
    ?>
@endif
<div class="each_cart_item" data-purchasetype="{{ $b->purchase_type }}" data-basket="{{ $b->id }}">
    <div class="cart_item_left">
        <a href="">
            <img src="{{$thumb}}">
        </a>
    </div>
    <div class="cart_item_right">
        <div class="cart_item_title">
            {{ str_limit($title, 29) }}
        </div>
        <div class="cart_item_description">
            {{ substr($description, 0, 100) }}
        </div>
    </div>
    <div class="cart_item_tool">
        <div class="item_price">
            @if($b->purchase_type == "subscription")
                {{$price}}
            @else
            @if($price>0)
                {{$b->user ? $commonMethods->getCurrencySymbol(strtoupper($b->user->profile->default_currency)) : ''}}{{number_format($price, 2)}}
            @else
                Free
            @endif
            @endif
        </div>
        <div class="item_delete" data-basketid="{{ $b->id }}">Remove</div>
    </div>
</div>
<hr>
