

<?php

$imgSrc = ( $video->type == 'soundcloud'  ) ? asset('img').'/soundcloud.jpg' : 'https://i.ytimg.com/vi/'.$video->video_id.'/mqdefault.jpg';
?>

<div class="tab_chanel_list each_user_video clearfix">

    <a href="javascript:void(0)">
    	<img class="defer_loading instant_hide" src="#" data-src="{{ $imgSrc }}" alt="{{ substr($video->title, 0, 40) }}" />
    </a>

    <div class="tab_chanel_img_det">
        <a data-stream-type="{{ $video->type }}" data-stream-live="0" data-orig-image="{{$video->user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $video->user->profile->profile_display_image_original}}" data-stream-id="{{ ( $video->type == 'youtube' ) ? $video->video_id : $video->link }}" href="javascript:void(0)" class="each_user_video_artist">{{ $video->user->name }}</a>
        <p>{{ substr($video->title, 0, 40) }}</p>
    </div>

    <div class="tab_chanel_btn">
    </div>

</div>
