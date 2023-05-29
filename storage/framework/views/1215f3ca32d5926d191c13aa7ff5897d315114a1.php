<?php $playerThumb = $music->thumbnail_player == '' ? 'url-thumb-profile.jpg' : $music->thumbnail_player ?>
<?php $domain = parse_url(request()->root())['host'] ?>
<?php $comm = new \App\Http\Controllers\CommonMethods() ?>
<div class="tab_chanel_list clearfix each-music" data-thumbnail-player="<?php echo e($playerThumb); ?>" data-musicid="<?php echo e($music->id); ?>" data-userid="<?php echo e(base64_encode($music->user->id)); ?>" data-musicfile="<?php echo e($music->music_file && $music->music_file != '' && $comm->fileExists(public_path('user-music-files/'.$music->music_file)) && filesize(public_path('user-music-files/'.$music->music_file)) > 0 ? $music->music_file : ''); ?>">
    <?php $musicThumb = $music->thumbnail_left == '' ? asset('img/url-thumb-profile.jpg') : asset('user-music-thumbnails/'.$music->thumbnail_left) ?>
    <?php $style = $music->genre ? $music->genre->name : 'None' ?>
    <?php $mood = $music->dropdown_two != '' ? $music->dropdown_two : 'None' ?>
    <?php $defaultCurrSym = $comm->getCurrencySymbol(strtoupper($music->user->profile->default_currency)); ?>

        <div class="summary">
            <a class="main_an" href="javascript:void(0)">
                <img class="play_now vertical_center instant_hide " src="<?php echo e(asset('images/play_icon.png')); ?>">
                <i class="fa fa-spin fa-spinner vertical_center instant_hide loading_smg"></i>
                <img class="main_img" src="<?php echo e($musicThumb); ?>" alt="#" />
            </a>
            <div class="tab_chanel_img_det">
                <div class="upper_music_det">
                    <a class="thismusic_user_name" href="<?php echo e($music->user && $music->user->username ? route('user.home.tab',['params'=>$music->user->username, 'tab' => '2']) : 'javascript:void(0)'); ?>"><?php echo e($music->user->name); ?></a>
                    <p class="thismusic_song_name" ><?php echo e($music->song_name); ?></p>
                    <div class="vertical_center fav_np <?php if(Auth::check()): ?> <?php echo e(is_array(Auth::user()->favourite_musics) && in_array($music->id, Auth::user()->favourite_musics) ? 'active' : ''); ?> <?php endif; ?> fa fa-heart"></div>
                    <div data-title="<?php echo e($music->song_name); ?>" data-opd="item" data-item="<?php echo e(base64_encode($music->id)); ?>" data-type="track" data-slug="<?php echo e(str_slug($music->song_name)); ?>" class="vertical_center item_share fa fa-share-alt"></div>
                </div>
                <div class="thismusic_wave_img">
                    <?php if($music->waveform_image && $music->waveform_image != '' && $comm->fileExists(public_path('user-music-waveform/'.$music->waveform_image))): ?>
                    <img src="<?php echo e(asset('user-music-waveform/'.$music->waveform_image)); ?>">
                    <?php endif; ?>
                </div>
                <div class="lower_music_det">
                    <div class="each_lower_det"><?php echo e($style); ?></div>
                    <div class="each_lower_det"><?php echo e($mood); ?></div>
                    <div class="each_lower_det"><?php echo e($music->bpm); ?></div>
                    <div class="each_lower_det"><?php echo e($music->formatDuration()); ?></div>
                    <div class="each_lower_det">
                        <div class="personal_lic">
                        	<?php if($music->personal_use_only != ''): ?>
	                            <?php if($music->personal_use_only > 0): ?>
	                            	<?php echo e($defaultCurrSym.$music->personal_use_only); ?>

	                            <?php else: ?>
	                            	Free 
	                            <?php endif; ?>
	                            <i class="fa fa-shopping-cart"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="res_right hide_on_desktop">
                    <div class="res_right_each_text"><?php echo e($style); ?></div>
                    <div class="res_right_each_text"><?php echo e($mood); ?></div>
                    <div class="res_right_each_text"><?php echo e($music->bpm); ?></div>
                    <div class="res_right_each_text"><?php echo e($music->formatDuration()); ?></div>
                </div>
                <div class="res_left hide_on_desktop">
                	<div class="res_left_each res_left_artist">
                		By <a href="<?php echo e($music->user && $music->user->username ? route('user.home', ['params' => $music->user->username]) : 'javascript:void(0)'); ?>"><?php echo e(strtoupper($music->user->name)); ?></a>
                	</div>
                	<?php if($music->personal_use_only != ''): ?>
                    <div class="res_left_each res_left_shop">
                    	<div class="res_left_icon"><i class="fa fa-shopping-cart"></i></div>
                    	<div class="res_left_text">
                    	    <?php if($music->personal_use_only > 0): ?>
                    	    <?php echo e($comm->getCurrencySymbol(strtoupper($music->user->profile->default_currency)).$music->personal_use_only); ?>

                    	    <?php else: ?>
                    	    Free 
                    	    <?php endif; ?>
                    	</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="ch_video_detail_outer add_to_cart_item clearfix" style="display: none;">
            <div class="clearfix">
                <div class="music_det clearfix">
                    <div class="headline">Instruments</div>
                    <div class="detail">
                        <div class="instruments_detail">
                            <?php echo e(implode(' - ', $music->instruments)); ?>

                        </div>
                    </div>
                </div>
                <?php if($music->lyrics): ?>
                <div class="music_det clearfix">
                    <div class="headline">Lyrics</div>
                    <div class="detail">
                        <div class="lyrics_detail">
                            <?php echo nl2br($music->lyrics); ?>

                        </div>
                        <div class="lyrics_more instant_hide">Read More</div>
                    </div>
                </div>
                <?php endif; ?>
                <?php $musicStems = $musicLoops = [] ?>
                <?php if(count($music->downloads)): ?>
                    <?php $__currentLoopData = $music->downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($item['itemtype'] == 'loop_one'): ?> <?php $hasloop = 1; $loopOne = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'loop_two'): ?> <?php $hasloop = 1; $loopTwo = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'loop_three'): ?> <?php $hasloop = 1; $loopThree = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'stem_one'): ?> <?php $hasstem = 1; $stemOne = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'stem_two'): ?> <?php $hasstem = 1; $stemTwo = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'stem_three'): ?> <?php $hasstem = 1; $stemThree = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'stem_four'): ?> <?php $hasstem = 1; $stemFour = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'stem_five'): ?> <?php $hasstem = 1; $stemFive = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'stem_six'): ?> <?php $hasstem = 1; $stemSix = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'stem_seven'): ?> <?php $hasstem = 1; $stemSeven = $item['dec_fname'] ?> <?php endif; ?>
                        <?php if($item['itemtype'] == 'stem_eight'): ?> <?php $hasstem = 1; $stemEight = $item['dec_fname'] ?> <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <div class="music_det clearfix">
                    <?php if(isset($hasloop) && $hasloop == 1): ?>
                    <div class="loop_outer">
                        <div class="loop_inner">
                            <div class="loop_head headline">Loops</div>
                            <?php if(isset($loopOne)): ?>
                            <div data-musicfile="<?php echo e($loopOne); ?>" class="each_loop circle">1</div>
                            <?php endif; ?>
                            <?php if(isset($loopTwo)): ?>
                            <div data-musicfile="<?php echo e($loopTwo); ?>" class="each_loop circle">2</div>
                            <?php endif; ?>
                            <?php if(isset($loopThree)): ?>
                            <div data-musicfile="<?php echo e($loopThree); ?>" class="each_loop circle">3</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($hasstem) && $hasstem == 1): ?>
                    <div class="stem_outer">
                        <div class="stem_inner">
                            <div class="stem_head headline">Stems</div>
                            <?php if(isset($stemOne)): ?>
                            <div data-musicfile="<?php echo e($stemOne); ?>" class="each_stem circle">1</div>
                            <?php endif; ?>
                            <?php if(isset($stemTwo)): ?>
                            <div data-musicfile="<?php echo e($stemTwo); ?>" class="each_stem circle">2</div>
                            <?php endif; ?>
                            <?php if(isset($stemThree)): ?>
                            <div data-musicfile="<?php echo e($stemThree); ?>" class="each_stem circle">3</div>
                            <?php endif; ?>
                            <?php if(isset($stemFour)): ?>
                            <div data-musicfile="<?php echo e($stemFour); ?>" class="each_stem circle">4</div>
                            <?php endif; ?>
                            <?php if(isset($stemFive)): ?>
                            <div data-musicfile="<?php echo e($stemFive); ?>" class="each_stem circle">5</div>
                            <?php endif; ?>
                            <?php if(isset($stemSix)): ?>
                            <div data-musicfile="<?php echo e($stemSix); ?>" class="each_stem circle">6</div>
                            <?php endif; ?>
                            <?php if(isset($stemSeven)): ?>
                            <div data-musicfile="<?php echo e($stemSeven); ?>" class="each_stem circle">7</div>
                            <?php endif; ?>
                            <?php if(isset($stemEight)): ?>
                            <div data-musicfile="<?php echo e($stemEight); ?>" class="each_stem circle">8</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(!isset($hasloop) && !isset($hasstem)): ?>
                        <div class="no_stem_loop">No stems / loops are available for this track</div>
                    <?php endif; ?>
                </div>
                <div class="ch_video_detail_right_sec">
                    <div class="ch_select_options <?php echo e($music->allow_bespoke_license_offer && $music->user->chat_switch == 1 ? 'allow_offer' : ''); ?>">
                        <?php $__currentLoopData = config('constants.licenses'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($music->{$license['input_name']}): ?> 
                                <?php $hasLicensePrice = 1 ?> 
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="ch_select_perch_options">
                            <text class="license_name">
                            	<div class="license_text">Select Purchase Option</div>
                            	<div class="license_icons"><i class="fa fa-shopping-cart"></i></div>
                            </text>
                            <div class="license_container instant_hide">
                                <?php $personalLicK = 'Personal Use Only'.'::'.$defaultCurrSym.$music->personal_use_only ?>
                                <?php $personalLicV = 'Personal Use Only'.' ('.$defaultCurrSym.$music->personal_use_only.')' ?>
                                <?php if($music->personal_use_only !== NULL): ?>
                                <div class="choose_music_license_contain" data-price="<?php echo e($personalLicK); ?>" value="<?php echo e($personalLicV); ?>">
                                    <div class="choose_music_license_each">
                                        <div class="choose_music_license_input">
                                            <input type="radio" name="choose_music_license" />
                                        </div>
                                        <label class="choose_music_license_name">
                                            Personal Use Only
                                        </label>
                                        <label class="choose_music_license_price">
                                            <?php echo e($defaultCurrSym.$music->personal_use_only); ?>

                                        </label>
                                    </div>
                                    <div class="choose_music_license_terms_contain">
                                        <div class="choose_music_license_terms_handle">
                                            <i class="fa fa-angle-down"></i> 
                                            <span>show terms</span>
                                        </div>
                                        <div class="choose_music_license_terms_each">
                                            <div class="choose_music_license_topen">
                                                <div class="choose_music_license_topen_text">
                                                    For your personal use only
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if($music->user->has_music_license): ?>
                                <?php $__currentLoopData = config('constants.licenses'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($music->{$license['input_name']}): ?>
                                    <?php 
                                        $licKey = $music->{$license['input_name']} != 'POA' ? $license['filename'].'::'.$defaultCurrSym.$music->{$license['input_name']} : 'POA';
                                        $licValue = $license['filename'];
                                        $licValue .= $music->{$license['input_name']} != 'POA' ? ' ('.$defaultCurrSym.$music->{$license['input_name']}.')' : ' (POA)';
                                    ?> 
                                    <div class="choose_music_license_contain" data-price="<?php echo e($licKey); ?>" value="<?php echo e($licValue); ?>">
                                        <div class="choose_music_license_each">
                                            <div class="choose_music_license_input">
                                                <input type="radio" name="choose_music_license" value="<?php echo e($licValue); ?>" />
                                            </div>
                                            <label class="choose_music_license_name">
                                                <?php echo e($license['name']); ?>

                                            </label>
                                            <label class="choose_music_license_price">
                                                <?php echo e($music->{$license['input_name']} != 'POA' ? $defaultCurrSym.$music->{$license['input_name']} : ' POA'); ?>

                                            </label>
                                        </div>
                                        <?php if($music->{$license['input_name']} != 'POA'): ?>
                                        <div class="choose_music_license_terms_contain">
                                            <div class="choose_music_license_terms_handle">
                                                <i class="fa fa-angle-down"></i> 
                                                <span>show terms</span>
                                            </div>
                                            <div class="choose_music_license_terms_each">
                                                <?php $licenseTermRec = \App\Models\LicenseTerms::find($license['terms_id']) ?>
                                                <?php if($licenseTermRec && count($licenseTermRec->terms)): ?>
                                                    <?php $__currentLoopData = $licenseTermRec->terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="choose_music_license_topen">
                                                            <div class="choose_music_license_topen_text">
                                                                <?php echo e($value); ?>

                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($music->allow_bespoke_license_offer && $music->user->chat_switch == 1): ?>
                        <div class="make_offer_outer">Negotiate</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
</div><?php /**PATH /opt/lampp/htdocs/platform/resources/views/parts/user-channel-music-template.blade.php ENDPATH**/ ?>