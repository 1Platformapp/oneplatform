<?php

/**

 * Created by PhpStorm.

 * User: adil

 * Date: 22/09/2017

 * Time: 2:43 PM

 */

$music_thumb = asset('img').'/url-thumb-profile.jpg';

if($userMusic->thumbnail_center != ""){

    $music_thumb = asset('user-music-thumbnails').'/'.$userMusic->thumbnail_center;

}

?>

<div class="ch_video_detail_outer add_to_cart_item add_to_cart_album_{{ $album->id }} clearfix">

    <div class="clearfix">

        <div class="ch_video_detail_left_sec clearfix">
            <?php
            $style = "None";
            if($userMusic->genre){
                $style = $userMusic->genre->name;
            }

            $mood = "None";
            if($userMusic->dropdown_two != ""){
                $mood = $userMusic->dropdown_two;
            }
            ?>
            <ul class="clearfix">
                <li>
                    <mark>Genre</mark>
                    <p>{{ substr($style, 0, 5) }}</p>
                </li>
                <li>
                    <mark>Mood</mark>
                    <p>{{ substr($mood, 0, 5) }}</p>
                </li>
                <li>
                    <mark>BPM</mark>
                    <p>{{ substr($userMusic->bpm, 0, 5) }}</p>
                </li>
                <li>
                    <mark>Time</mark>
                    <p>2:22</p>
                </li>
            </ul>

        </div>

        <div class="ch_video_detail_right_sec">
            <?php $optionsArray = $commonMethods::getLicenceArray($userMusic);?>

            <div class="ch_select_perch_options">
                <text class="license_name">Select Purchase Option</text>
                <select class="licence-dropdown" data-musicid="{{ $userMusic->id }}">
                    <option>Select Purchase Option</option>
                    @foreach($optionsArray as $key=>$value)
                        <?php $keyArray = explode("-", $key); ?>
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="ch_select_perch_options add_to_basket" data-basketuserid="{{ $userMusic->user_id }}" data-productid="0" data-musicid="{{ $userMusic->id }}" data-albumid="{{ $album->id }}" data-basketprice="{{ $album->price }}" data-purchasetype="album">
                <text class="chan_btn_submit">
                    Add To Basket
                </text>
                <text id="top_music_info_{{ $userMusic->id }}" class="music_tot_disp">
                    <font id="sec_one">Total</font> <font class="sec_two">${{ $album->price }}</font>
                </text>
            </div>
        </div>

    </div>

</div>