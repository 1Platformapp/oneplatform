<?php
/**
 * Created by PhpStorm.
 * User: adil
 * Date: 22/09/2017
 * Time: 2:45 PM
 */
$prod_thumb = asset('img').'/url-thumb-profile.jpg';
if($userProduct->thumbnail_center != ""){
    $prod_thumb = asset('user-product-thumbnails').'/'.$userProduct->thumbnail_center;
}
?>
<div class="ch_video_detail_outer add_to_cart_item clearfix" id="add_to_cart_product_{{ $userProduct->id }}">
    <div class="clearfix">
        <div class="ch_video_detail_left_sec clearfix">
            <span><img src="{{ $prod_thumb }}" alt="#" /></span>
        </div>
        <div class="ch_video_detail_right_sec">
            <span>
                {{ $userProduct->user->name }}
                <p>Total <text class="tot_val">{{ "$".$userProduct->price }}</text></p>
            </span>
            <p class="right_title">{{ $userProduct->title }}</p>
            <p id="read_more" class="read_more right_description right_product_description">{{ $userProduct->description }}</p>
            <span id="read_more_button">......MORE</span>

            <a class="add_basket_btn" href="#" data-basketuserid="{{ $userProduct->user_id }}" data-productid="{{ $userProduct->id }}"
               data-musicid="0" data-purchasetype="product" data-basketprice="{{ $userProduct->price }}">
                Add To Basket
            </a>
        </div>
    </div>
</div>