
<div class="hide_on_desktop" data-video-id="R4GUz1XsDqA" id="offer_guide">
    <div class="music_head_img">How to make proposals</div>
</div>

<div class="tab_chan_tp_btns clearfix">

    <div data-id="singles" class="each_music_head">
        <div class="music_head_img">
            <img src="<?php echo e(asset('images/music_tab_01_active.png?v=1.1')); ?>">
        </div>
    </div>
    <div data-id="albums" class="each_music_head">
        <div class="music_head_img">
            <img src="<?php echo e(asset('images/music_tab_02.png?v=1.1')); ?>">
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

                <?php if($user->music_smart_links_url && $user->music_smart_links_url != ''): ?>
                    <iframe style="margin: 25px 0;" width="100%" height="52" src="<?php echo e($user->music_smart_links_url); ?>&theme=light" frameborder="0" allowfullscreen sandbox="allow-same-origin allow-scripts allow-presentation allow-popups allow-popups-to-escape-sandbox"></iframe>
                <?php endif; ?>

                <?php $__currentLoopData = $user->musics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userMusic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(count($userMusic->privacy) && isset($userMusic->privacy['status']) && $userMusic->privacy['status'] == '1'): ?>

                        <?php echo $__env->make('parts.user-channel-music-private-template',['music'=>$userMusic, 'type' => 'music'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>

                        <?php echo $__env->make('parts.user-channel-music-template',['music'=>$userMusic], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
    </div>

</div>



<div class="user_album_outer" id="albums_div2" style="display: none;">
    <h3 class="tabd2_head">Albums</h3>
    <?php $__currentLoopData = $user->albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php echo $__env->make('parts.user-channel-album-template', ['album' => $album], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div><?php /**PATH /opt/lampp/htdocs/platform/resources/views/parts/user-music-tab.blade.php ENDPATH**/ ?>