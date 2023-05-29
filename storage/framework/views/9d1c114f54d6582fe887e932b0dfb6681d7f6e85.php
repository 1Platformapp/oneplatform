<?php $__env->startSection('pagetitle'); ?> 
    <?php if($user->profile->seo_title != ''): ?>
        <?php echo e($user->profile->seo_title); ?> 
    <?php else: ?> 
        <?php echo e($user->name); ?> - Home 
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagekeywords'); ?> 
    <?php if($user->profile->seo_keywords != ''): ?>
        <meta name="keywords" content="<?php echo e($user->profile->seo_keywords); ?>" />
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagedescription'); ?> 
    <?php if($user->profile->seo_description != ''): ?>
        <meta name="description" content="<?php echo e($user->profile->seo_description); ?>"/>
    <?php else: ?> 
        <meta name="description" content="<?php echo e(strip_tags(preg_replace('/\s+/', ' ', $userPersonalDetails['storyText']))); ?>"/>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('seocontent'); ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-level-css'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('css/user-home.min.css?v=3.7')); ?>"></link>
    <link rel="stylesheet" href="<?php echo e(asset('css/portfolio.min.css')); ?>"></link>
    
    <?php if($user->home_layout == 'background'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/user_home_background.min.css')); ?>"></link>
    <?php endif; ?>

    <?php if($user->home_layout == 'banner'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/user_home_banner.css?v=1.0')); ?>"></link>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-level-js'); ?>
    
    <script defer src="/js/video-player.js"></script>
    <script defer src="/js/feat_items_scroller.js"></script>

    <?php if($user->home_layout == 'background'): ?>
        <script src="<?php echo e(asset('js/user_home_background.min.js')); ?>"></script>
    <?php endif; ?>

    <script>
        $('document').ready(function(){
            $('.feat_music_info').click(function(){
                var thiss = $(this);
                var musicFile = thiss.attr('data-musicfile');
                $('.user_short_tab_each[data-target-id="2"]').trigger('click');
                updateAndPlayAudioPlayer(thiss, '/user-music-files/' + musicFile, true);
            });

            $('.fore_close').click(function(){

                $('.pg_fore_out').removeClass('fore_active');
            });

            var browserWidth = $( window ).width();
            if( browserWidth <= 767 ){
                $('.ch_left_sec_outer').replaceWith('<section class="ch_left_sec_outer">' + $('.ch_left_sec_outer').html() +'</section>');
                $('.tab_btns_outer').appendTo('.ch_left_sec_outer');
                $('.tab_det_left_sec').closest('main').appendTo('.ch_left_sec_outer');
                $('.ch_left_sec_outer').appendTo('#ch_left_sec_outer_filler');
                $('.user_hm_rt_btm_otr.feat_outer').parent().appendTo('#feat_outer_filler');
                $('#user_project_outer').appendTo('#save_user_project_filler');
                $('.donator_outer').parent().appendTo('#donator_outer_filler');
                $('.project_rit_btm_bns_otr').parent().appendTo('#subscribe_box_filler');
                $('.user_follow_outer').appendTo('#user_follow_outer_filler');
                $('.user_short_hand_tab_outer').appendTo('#user_short_hand_tab_filler');
                $('.news_updates_outer').appendTo('#news_updates_outer_filler');
                $('.portfolio_outer').insertAfter('#portfolio_outer_filler');
                $('.services_outer').appendTo('#user_services_filler');
                $('#tab1 .bio_sec_story_text').html($('#tabd1 .bio_sec_story_text').html());
            }
            if( browserWidth <= 767 ){
                $('.desktop-only,.hide_on_mobile').remove();
            }else{
                $('.mobile-only,.hide_on_desktop').remove();
            }
            if($('.vid_preloader').length && !$('.vid_preloader').hasClass('instant_hide')){
                $('.content_outer').addClass('playing');
            }
            if($('.each_tab_btn.tab_btn_crowd_fund').hasClass('true_active')){

                var proOfferTimerInstance = new Interval(1000);
                productOfferCountdown(proOfferTimerInstance);
            }
            window.currentUserId = "<?php echo e($user->id); ?>";
            window.loggedInUserId = "<?php echo e(Auth::user()?Auth::user()->id:''); ?>";

            $('.user_sub_paypal a').click(function(){
                if(window.loggedInUserId != ''){
                    window.location.href = '/paypal/subscribe/'+window.currentUserId;
                }else{
                    $('#sub_paypal_info,#body-overlay').show();
                }
            });
            $('#sub_paypal_info_proceed').click(function(){
                if($('#sub_paypal_info_first_name').val() == '' || $('#sub_paypal_info_last_name').val() == '' || $('#sub_paypal_info_email').val() == ''){
                    $('#sub_paypal_info_error').removeClass('instant_hide');
                }else{
                    $(this).closest('form').submit();
                }
            });
        });

        var showPopup = '<?php echo e($showPopup); ?>';
        if(showPopup != ''){
            $(showPopup+',#body-overlay').show();
            if(showPopup == '#bespoke_license_popup'){
                $(showPopup).attr('data-recipient', window.currentUserId);
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('preheader'); ?>

    <?php if($user->home_layout == 'banner' && $user->custom_banner != ''): ?>
        <div style="background: none; width: 100%;" class="pre_header_banner">
            <img class="defer_loading instant_hide" alt="<?php echo e($user->name.'\'s banner'); ?>" style="width: 100%;" src="#" data-src="<?php echo e(asset('user-media/banner/'.$user->custom_banner)); ?>">
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('parts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('imp-notice'); ?>
    <?php if(!$user->hasActivePaidSubscription() && !$user->networkAgent()): ?>
    
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-background'); ?>

    <?php if($user->home_layout == 'background'): ?>
        <div data-url="/user-media/background/<?php echo e($user->custom_background); ?>" class="pg_back back_inactive"></div>
    <?php endif; ?>

    <?php if(!Session::has('exempt_splash') && $user->profile->splash && isset($user->profile->splash['id'])): ?>
        <?php if($user->profile->splash['type'] == 'product'): ?>
            <?php $item = \App\Models\UserProduct::find($user->profile->splash['id']) ?>
        <?php else: ?>
            <?php $item = \App\Models\UserMusic::find($user->profile->splash['id']) ?>
        <?php endif; ?>
        <link class="switchmediaall" href="https://fonts.googleapis.com/css2?family=Potta+One&amp;display=swap" rel="stylesheet">
        <div class="pg_fore_out fore_active">
            <div class="pg_fore"></div>
            <div class="pg_fore_in">
                <div class="fore_actions">
                    <div class="fore_close">
                        <svg data-bbox="25.9 25.9 148.2 148.2" xmlns="http://www.w3.org/2000/svg" viewBox="25.9 25.9 148.2 148.2" role="img">
                            <g>
                                <path d="M171.3 158.4L113 100l58.4-58.4c3.6-3.6 3.6-9.4 0-13s-9.4-3.6-13 0L100 87 41.6 28.7c-3.6-3.6-9.4-3.6-13 0s-3.6 9.4 0 13L87 100l-58.4 58.4c-3.6 3.6-3.6 9.4 0 13s9.4 3.6 13 0L100 113l58.4 58.4c3.6 3.6 9.4 3.6 13 0s3.5-9.5-.1-13z"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="fore_content">
                    <div class="fore_title_main">
                        <?php echo e($user->profile->splash['type'] == 'product' ? $item->title : $item->song_name); ?>

                    </div>
                    <?php if($user->profile->splash['type'] == 'music'): ?>
                        <?php if($item->thumbnail_feat != ''): ?>
                            <?php $thumbnail = asset('user-music-thumbnails/'.$item->thumbnail_feat) ?>
                        <?php else: ?>
                            <?php $thumbnail = asset('img/url-thumb-profile.jpg') ?>
                        <?php endif; ?>
                    <?php elseif($user->profile->splash['type'] == 'product'): ?>
                        <?php if($item->thumbnail != ''): ?>
                            <?php $thumbnail = asset('user-product-thumbnails/'.$item->thumbnail) ?>
                        <?php else: ?>
                            <?php $thumbnail = asset('img/url-thumb-profile.jpg') ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="fore_thumb">
                        <img class="defer_loading instant_hide" alt="<?php echo e($user->profile->splash['type'] == 'product' ? $item->title : $item->song_name); ?>" data-src="<?php echo e($thumbnail); ?>" src="#" />
                    </div>
                    <div class="fore_link">
                        <?php if($user->profile->splash['type'] == 'music'): ?>
                            <a href="<?php echo e(route('item.share.track', ['itemSlug' => str_slug($item->song_name)])); ?>">Listen</a>
                        <?php else: ?>
                            <a href="<?php echo e(route('item.share.product', ['itemSlug' => str_slug($item->title)])); ?>">View</a>
                        <?php endif; ?> 
                    </div>
                </div>
            </div>  
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('social-media-html'); ?>

    <div id="fb-root"></div>
    <input type="hidden" id="share_current_page" value="userhome">

    <?php
        $shareVideoTitle = preg_replace('/[^\w]/', ' ', $defaultVideoTitle);
        $url = 'userhome_'.$user->id;
        $userImageName = $user->profile->profile_display_image_original == '' ? 'user-general-display-image.png' : $user->profile->profile_display_image_original;
        $shareVideoURL = route('vid.share', ['videoId' => $defaultVideoId, 'userName' => $user->name, 'url' => $url]);
        $shareURL = route('url.share', ['userName' => $user->name, 'imageName' => base64_encode($userImageName), 'url' => $url]);
    ?>

    <input type="hidden" id="video_share_id" value="<?php echo e($defaultVideoId); ?>">
    <input type="hidden" id="video_share_link" value="<?php echo e($shareVideoURL); ?>">
    <input type="hidden" id="video_share_title" value="<?php echo e($shareVideoTitle); ?>">
    <input type="hidden" id="url_share_user_name" value="<?php echo e($user->name); ?>">
    <input type="hidden" id="url_share_link" value="<?php echo e($shareURL); ?>">
    <input type="hidden" id="item_share_title" value="">
    <input type="hidden" id="item_share_link" value="">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('audio-player'); ?>

    <?php echo $__env->make('parts.audio-player', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('flash-message-container'); ?>

    <?php if(Session::has('error')): ?>
        <div class="error_span">
            <i class="fa fa-times-circle"></i> 
            <?php echo e((is_array(Session::get('error'))) ? Session::get('error')[0] : Session::get('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(Session::has('success')): ?>
        <div class="success_span">
            <i class="fa fa-check-circle"></i> 
            <?php if(is_array(Session::get('success'))): ?>
                <?php echo Session::get('success')[0]; ?>

            <?php else: ?>
                <?php echo Session::get('success'); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if(!Session::has('success') && !Session::has('error') && Session::has('notice')): ?>
        <div class="success_span notice_span">
            <i class="fa fa-bell"></i> &nbsp;
            <?php if(is_array(Session::get('notice'))): ?>
                <?php echo Session::get('notice')[0]; ?>

            <?php else: ?>
                <?php echo Session::get('notice'); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top-center'); ?>

    <div class="ch_center_outer user_hm_center">
        <aside class="top_info_box hide_on_mobile"> 
            <div class="top_info_right_icon">
                <i class="fa fa-share"></i>
            </div> 
        </aside>
        <div class="tp_center_video_outer">
            <div class="jp-gui">
                
                <video width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader <?php echo e($user->home_layout == 'background' ? 'instant_hide' : ''); ?>" preload="none">
                    <source type="video/youtube" src="https://www.youtube.com/watch?v=<?php echo e($defaultVideoId); ?>" />
                </video>
                <aside class="tab_btns_outer tab_dsk hide_on_mobile clearfix <?php echo e($user->home_layout == 'background' ? 'back_curvs' : ''); ?>">
                    <div class="each_tab_btn tab_btn_user_bio <?php echo e($user->default_tab_home == NULL || $user->default_tab_home == 1 ? 'true_active' : ''); ?>" data-show="#tabd1">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_music <?php echo e(count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 2 ? 'true_active' : ''); ?>" data-show="#tabd2">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_fans <?php echo e(count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 3 ? 'true_active' : ''); ?>" data-show="#tabd3">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_social <?php echo e(count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 4 ? 'true_active' : ''); ?>" data-show="#tabd4">
                        <div class="border"></div>
                    </div>
                    <?php if($userCampaignDetails['campaignIsLive'] == '1' && $userCampaignDetails['campaignStatus'] == 'active'): ?> 
                    <?php $hasCrowdfunder = 1 ?>
                    <?php else: ?>
                    <?php $hasCrowdfunder = 0 ?>
                    <?php endif; ?>
                    <div class="each_tab_btn tab_btn_crowd_fund store <?php echo e(count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 6 ? 'true_active' : ''); ?>" data-show="#tabd6">
                        <div class="border_alter">
                            Store<br><?php echo e($userCampaignDetails['campaignProducts']); ?>

                        </div>
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_video <?php echo e(count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 5 ? 'true_active' : ''); ?>" data-show="#tabd5" data-video-id="<?php echo e($userPersonalDetails['bioVideoId']); ?>">
                        <div class="border"></div>
                    </div>
                    <?php if(!$user->isCotyso()): ?>
                    <div class="each_tab_btn tab_btn_tv" data-show="">
                        <div class="border"></div>
                    </div>
                    <?php endif; ?>
                </aside>
                <aside class="tab_btns_outer tab_shared mobile-only ch_tab_sec_outer clearfix">
                    <div class="each_tab_btn tab_btn_user_bio <?php echo e($user->default_tab_home == NULL || $user->default_tab_home == 1 ? 'true_active' : ''); ?>" data-show="#tabd1">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_music <?php echo e(count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 2 ? 'true_active' : ''); ?>" data-show="#tabd2">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_fans <?php echo e(count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 3 ? 'true_active' : ''); ?>" data-show="#tabd3">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_social <?php echo e(count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 4 ? 'true_active' : ''); ?>" data-show="#tabd4">
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_crowd_fund store <?php echo e(count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 6 ? 'true_active' : ''); ?>" data-show="#tabd6">
                        <div class="border_alter">
                            Store<br><?php echo e($userCampaignDetails['campaignProducts']); ?>

                        </div>
                        <div class="border"></div>
                    </div>
                    <div class="each_tab_btn tab_btn_video <?php echo e(count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 5 ? 'true_active' : ''); ?>" data-show="#tabd5">
                        <div class="border"></div>
                    </div>
                    <?php if(!$user->isCotyso()): ?>
                    <div class="each_tab_btn tab_btn_tv" data-show="">
                        <div class="border"></div>
                    </div>
                    <?php endif; ?>
                </aside>
                <main>
                    <section class="tab_det_left_sec tab_det_dsk tab_det_inner right_height_res expanded <?php if($user->isCotyso()): ?> expanded <?php if($user->default_tab_home != 6): ?> leave <?php else: ?> p10 <?php endif; ?> <?php endif; ?>">
                        <h1 class="page_title">
                            <?php if($user->profile->seo_h1): ?>
                                <?php echo e($user->profile->seo_h1); ?>

                            <?php else: ?>
                            	<?php echo e($user->name); ?>

                            	<?php if($userPersonalDetails['skills'] != ''): ?>
                            		<?php echo e(' is a '.$userPersonalDetails['skills']); ?>

                            	<?php endif; ?>
                            	<?php if($userPersonalDetails['skills'] == '' && $userPersonalDetails['city'] != ''): ?>
                            		<?php echo e(' is'); ?>

                            	<?php endif; ?>
                            	<?php if($userPersonalDetails['city'] != ''): ?>
                            		<?php echo e(' based in '.$userPersonalDetails['city']); ?>

                            	<?php endif; ?>
                            <?php endif; ?>
                        </h1>
                        <aside style="display: none;" class="lazy_tab_img">
                            <img alt="loading" class="defer_loading" style="margin: 0 auto;" src="#" data-src="<?php echo e(asset('img/lazy_loading.gif')); ?>">
                        </aside>
                        <article id="tabd1" class="ch_tab_det_sec bio_sec <?php echo e($user->default_tab_home == NULL || $user->default_tab_home == 1 ? '' : 'instant_hide'); ?>">
                            <div class="lazy_tab_content">
                                <?php if($user->default_tab_home == NULL || $user->default_tab_home == 1): ?>
                                <?php echo \View::make('parts.user-bio-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render(); ?>

                                <?php endif; ?>
                            </div>
                        </article>
                        <article id="tabd2" class="ch_tab_det_sec music_sec <?php echo e($user->default_tab_home == 2 ? '' : 'instant_hide'); ?>">
                            <div class="lazy_tab_content">
                                <?php if($user->default_tab_home == 2): ?>
                                <?php echo \View::make('parts.user-music-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render(); ?>

                                <?php endif; ?>
                            </div>
                        </article>
                        <article id="tabd3" class="ch_tab_det_sec fans_sec <?php echo e($user->default_tab_home == 3 ? '' : 'instant_hide'); ?>">
                            <br><br>
                            <div class="lazy_tab_content">
                                <?php if($user->default_tab_home == 3): ?>
                                <?php echo \View::make('parts.user-fans-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render(); ?>

                                <?php endif; ?>
                            </div>
                        </article>
                        <article id="tabd4" class="ch_tab_det_sec social_sec <?php echo e($user->default_tab_home == 4 ? '' : 'instant_hide'); ?>">
                            <div class="lazy_tab_content">
                                <?php if($user->default_tab_home == 4): ?>
                                <?php echo \View::make('parts.user-social-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render(); ?>

                                <?php endif; ?>
                            </div>
                        </article>
                        <article id="tabd5" class="ch_tab_det_sec <?php echo e($user->default_tab_home == 5 ? '' : 'instant_hide'); ?>">
                            <div class="lazy_tab_content">
                                <?php if($user->default_tab_home == 5): ?>
                                <?php echo \View::make('parts.user-video-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render(); ?>

                                <?php endif; ?>
                            </div>
                        </article>
                        <article id="tabd6" class="ch_tab_det_sec <?php echo e($user->default_tab_home == 6 ? '' : 'instant_hide'); ?>">
                            <div class="lazy_tab_content">
                                <?php if($user->default_tab_home == 6): ?>
                                <?php echo \View::make('parts.user-products-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render(); ?>

                                <?php endif; ?>
                            </div>
                        </article>
                    </section>
                </main>
            </div>
        </div>
        <section>
            <div class="filler" id="ch_left_sec_outer_filler"></div>
            <div class="filler" id="user_services_filler"></div>
            <div class="filler" id="feat_outer_filler"></div>
            <div class="filler" id="news_updates_outer_filler"></div>
            <div class="filler" id="user_short_hand_tab_filler"></div>
            <div class="filler" id="user_follow_outer_filler"></div>
            <div class="filler" id="donator_outer_filler"></div>
            <div class="filler" id="subscribe_box_filler"></div>
            <div class="filler" id="save_user_project_filler"></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top-right'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top-left'); ?>

    <div class="ch_tab_sec_outer">
        <div class="panel main_panel <?php echo e($user->home_layout == 'background' ? 'back_curvs' : ''); ?> colio_outer colio_dark">
            <?php if($user->home_layout != 'background'): ?>
            <div class="desktop-only panel_head">
                <h2 class="project_name"><?php echo e($userPersonalDetails['name']); ?>'s Store</h2>
            </div>
            <?php endif; ?>
            <div class="ch_bag_pric_sec bio_sec">
                <div class="fund_raise_left">
                    <?php if($user->home_layout != 'background'): ?>
                    <img alt="<?php echo e($user->name.'\'s profile image'); ?>" class="bio_sec_percent_image desktop-only" src="<?php echo e($userPersonalDetails['profileImageCard']); ?>" alt="#" />
                    <?php endif; ?>
                    <div class="project_line colio_header"><?php echo e(str_limit($user->name, 23, '...')); ?></div>
                    <div class="fund_raise_status"></div>
                </div>
                <div class="fund_raise_right">
                    <div class="pricing_setail">
                        <ul>
                            <li class="fleft">
                                <div class="tier_one_text_one header3">
                                    <?php echo e($userCampaignDetails['campaignProducts']); ?>

                                </div>
                            </li>
                            <li class="fright">
                                <div class="tier_four_text_one project_txt header3">
                                    <?php if($hasCrowdfunder): ?>
                                        <?php echo e($userCampaignDetails['campaignCurrencySymbol'].$userCampaignDetails['amountRaised'].' / '.$userCampaignDetails['campaignGoal']); ?>

                                    <?php endif; ?>
                                </div>
                            </li>
                            <li class="fleft">
                                <p class="tier_one_text_two">Products available</p>
                            </li>
                            <li class="fright">
                                <p class="tier_four_text_two">
                                <?php if($hasCrowdfunder): ?>
                                    Crowdfund project
                                <?php endif; ?>
                                </p>
                            </li>
                            <li class="fleft">
                                <div class="tier_two_text_one header3">City</div>
                            </li>
                            <?php if(!$user->isCotyso()): ?>
                            <li class="fright">
                                <div class="tier_three_text_one header3">Skill</div>
                            </li>
                            <?php endif; ?>
                            <li class="fleft">
                                <p class="tier_two_text_two"><?php echo e($userPersonalDetails['city']); ?></p>
                            </li>
                            <?php if(!$user->isCotyso()): ?>
                            <li class="fright">
                                <p class="tier_three_text_two"><?php echo e($userPersonalDetails['skills']); ?></p>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="social_btns desktop-only clearfix">
                <ul class="clearfix">
                    <li>
                        <a onclick="return facebookShare('url')" class="ch_sup_fb" href="javascript:void(0)">
                            <i class="fab fa-facebook-f"></i>
                        </a> 
                    </li>
                    <li>
                        <a onclick="return twitterShare('url')" class="ch_sup_tw" href="javascript:void(0)">
                            <i class="fab fa-twitter"></i>
                        </a> 
                    </li>
                    <?php if($user->feature_tab_home): ?>
                    <li>
                        <a data-id="<?php echo e($user->feature_tab_home); ?>" class="ch_sup_feature_tab" href="javascript:void(0)">
                            <?php if($user->feature_tab_home == 2): ?>
                            <i class="fa fa-music"></i>
                            <?php elseif($user->feature_tab_home == 3): ?>
                            <i class="fa fa-hand-holding-heart"></i>
                            <?php elseif($user->feature_tab_home == 4): ?>
                            <i class="fa fa-share-alt"></i>
                            <?php elseif($user->feature_tab_home == 5): ?>
                            <i class="fa fa-play"></i>
                            <?php elseif($user->feature_tab_home == 6): ?>
                            <i class="fa fa-ticket-alt"></i>
                            <?php endif; ?>
                        </a> 
                    </li>
                    <?php endif; ?>
                    <?php if(!$user->isCotyso()): ?>
                    <li>
                        <a class="ch_sup_chat <?php echo e($user->chat_switch == 1 ? '' : 'chart_disabled'); ?>" href="javascript:void(0)">
                            <i class="fa fa-comments"></i>
                        </a> 
                    </li>
                    <?php endif; ?>
                    <li>
                        <a class="ch_sup_fb full_support_me <?php echo e($hasCrowdfunder?'':'chart_disabled'); ?>" href="<?php echo e($hasCrowdfunder ? route('user.project', ['username' => $user->username]) : 'javascript:void(0)'); ?>">
                            <img alt="Support <?php echo e($user->name); ?>" src="<?php echo e(asset('images/fa-users.png')); ?>">
                        </a> 
                    </li>
                </ul>
            </div>
        </div>
        <?php if($user->id == 765): ?>
            <a class="panel se_booking" href="https://www.clients.singingexperience.co.uk">
                Redeem Voucher
            </a>
        <?php endif; ?>
        <div class="panel user_follow_outer <?php echo e(!Auth::check() ? 'unauth' : ''); ?>">
            <div class="user_follow_btn">
                <div class="user_follow_inner">
                    <i class="fa fa-rss"></i> 
                    <?php echo e(Auth::check() && $user && Auth::user()->isFollowerOf($user) ? 'Following' : 'Follow'); ?>

                </div>
            </div>
        </div>
        <?php if(count($user->services)): ?>
            <?php echo $__env->make('parts.user-services-panel', ['user' => $user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <?php 
            $userNews = \App\Models\UserNews::where(['user_id' => $user->id])->orderBy('featured' , 'desc')->get() 
        ?>
        <?php if(count($userNews)): ?>
        <div class="panel news_updates_outer colio_outer colio_dark">
            <div class="colio_header">News update</div>
            <?php $__currentLoopData = $userNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="news_update_each">
                <div class="news_update_date"><?php echo e(date('d/m/Y h:i A', strtotime($news->created_at))); ?></div>
                <div class="news_update_val"><?php echo e($news->value); ?></div>
                <?php if($news->tab): ?>
                <div data-id="<?php echo e($news->tab); ?>" class="news_update_link <?php echo e($news->tab == '6' || $news->tab == '7' ? 'tilted' : ''); ?>">
                    <?php if($news->tab == '6' || $news->tab == '7'): ?>
                    <i class="fa fa-ticket-alt"></i>
                    <?php $tname = $news->tab == '6' ? 'My store' : 'My gigs and tickets' ?>
                    <?php elseif($news->tab == '2'): ?>
                    <i class="fa fa-music"></i>
                    <?php $tname = 'My music' ?>
                    <?php elseif($news->tab == '1'): ?>
                    <i class="fa fa-user"></i>
                    <?php $tname = 'My bio' ?>
                    <?php elseif($news->tab == '3'): ?>
                    <i class="fa fa-hand-holding-heart"></i>
                    <?php $tname = 'My fans' ?>
                    <?php elseif($news->tab == '4'): ?>
                    <i class="fa fa-share-alt"></i>
                    <?php $tname = 'My social family' ?>
                    <?php elseif($news->tab == '5'): ?>
                    <i class="fa fa-play"></i>
                    <?php $tname = 'My videos' ?>
                    <?php endif; ?>
                    <span><?php echo e($tname); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(count($userNews) > 1): ?>
            <div class="news_updates_nav">
                <div id="news_nav_back" class="news_updated_nav_each">
                    <i class="fa fa-angle-left"></i>
                </div>
                <div id="news_nav_next" class="news_updated_nav_each">
                    <i class="fa fa-angle-right"></i>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if(count($userFeatMusics) > 0 || count($userFeatProducts) > 0): ?>
        <div class="panel colio_outer colio_dark">
            <div class="user_hm_rt_btm_otr feat_outer">
                <?php $count = 0; ?>
                <?php $__currentLoopData = $userFeatMusics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userFeatMusic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('parts.feat_music_template', ["userFeatMusic" => $userFeatMusic, "count" => ++$count] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $userFeatAlbums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userFeatAlbum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('parts.feat_album_template', ["userFeatAlbum" => $userFeatAlbum, "count" => ++$count] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $userFeatProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userFeatProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($userFeatProduct->is_ticket == 1): ?>
                        <?php echo $__env->make('parts.feat_ticket_template', ["userFeatProduct" => $userFeatProduct, "count" => ++$count] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php elseif($userFeatProduct->thumbnail != ""): ?>
                        <?php echo $__env->make('parts.feat_product_template', ["userFeatProduct" => $userFeatProduct, "count" => ++$count] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                        <?php echo $__env->make('parts.feat_product_thumbless', ["userFeatProduct" => $userFeatProduct, "count" => ++$count] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($count == 0): ?>
                <?php endif; ?>
                <input type="hidden" id="feat_current_slide" value="1">
                <input type="hidden" id="feat_total_slides" value="<?php echo e($count); ?>">
            </div>
        </div>
        <?php endif; ?>
        <?php if($user->accept_donations == 1): ?>
        <div class="panel colio_outer colio_dark">
            <?php
                $donationValue = 0;
                $donation = false;
                foreach($basket as $key => $item){

                    if($item->purchase_type == 'donation_goalless'){
                        $donationValue = $item->price;
                        $donation = true;
                    }
                }
            ?>
            <div class="donator_outer donation_goalless <?php echo e((!$donation) ? '' : 'donation_agree'); ?>">
                <div class="donator_box clearfix">
                    <div class="colio_header">Make A Contribution</div>
                    <p>Contributions are not associated with perks</p>
                    <div class="donator_inner">
                        <div class="donation_left">
                            <span id="donation_currency"><?php echo e($commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))); ?></span>
                            <input <?php echo e((!$donation) ? '' : 'readonly'); ?> value="<?php echo e((!$donation) ? '' : $donationValue); ?>" type="number" min="0" id="donation_amount" name="donation_amount" class="<?php echo e((!$donation) ? 'evade_auto_fill' : ''); ?>" />
                        </div>
                        <div class="donation_right">
                            <div data-basketuserid="<?php echo e($user->id); ?>" class="donation_right_in">
                                <?php echo e((!$donation) ? 'Add To Cart' : 'Added To Cart'); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($user->subscription_amount != null && $user->subscription_amount > 0): ?>
        <?php if($basket && $basket->contains('purchase_type', 'subscription') && $basket->contains('user_id', $user->id)): ?>
            <?php $isSubscribed = 1 ?>
        <?php endif; ?>
        <div class="panel user_subscribe_outer colio_outer colio_dark">
            <?php $encourageBullets = $user->encourage_bullets; ?>
            <div class="project_rit_btm_bns_otr">
                <div class="<?php echo e(isset($isSubscribed) && $isSubscribed == 1 ? 'proj_rit_btm_list_gray' : 'project_rit_btm_list'); ?>" id="subscribe_box">
                    <div class="colio_header">Subscribe to <?php echo e(str_limit($user->name, 10, '...')); ?></div>
                    <div class="subsription_box_heading">Items included to this monthly subscription</div>
                    <ul class="subsription_box_list">
                        <?php if(is_array($encourageBullets) && $encourageBullets[0] != ''): ?>
                        <li><p><?php echo e($encourageBullets[0]); ?></p></li>
                        <?php endif; ?>
                        <?php if(is_array($encourageBullets) && $encourageBullets[1] != ''): ?>
                        <li><p><?php echo e($encourageBullets[1]); ?></p></li>
                        <?php endif; ?>
                        <?php if(is_array($encourageBullets) && $encourageBullets[2] != ''): ?>
                        <li><p><?php echo e($encourageBullets[2]); ?></p></li>
                        <?php endif; ?>
                    </ul>
                    <label class="proj_add_sec <?php echo e(isset($isSubscribed) && $isSubscribed == 1 ? 'proj_add_sec_added' : ''); ?>" id="subscribe_btn" data-basketuserid="<?php echo e($user->id); ?>" data-basketprice="<?php echo e($user->subscription_amount); ?>" style="cursor: pointer;">
                        <?php echo e(isset($isSubscribed) && $isSubscribed == 1 ? 'Added To Cart' : 'Subscribe'); ?>

                        <b>
                            <?php echo e($commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))); ?>

                            <?php echo e(number_format($user->subscription_amount, 2)); ?> p/m
                        </b>
                    </label>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="panel user_short_hand_tab_outer colio_outer colio_dark">
            <div class="colio_header">Quick Links</div>
            <div class="user_short_hand_tab">
                <div data-target-id="1" class="user_short_tab_each bi_tb true_active">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">BIO</div>
                </div>
                <div data-target-id="2" class="user_short_tab_each mu_tb <?php echo e(count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''); ?>">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">MUSIC</div>
                </div>
                <div data-target-id="3" class="user_short_tab_each fa_tb <?php echo e(count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''); ?>">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">FANS</div>
                </div>
                <div data-target-id="6" class="user_short_tab_each st_tb <?php echo e(count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'disabled' : ''); ?>">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">STORE</div>
                </div>
                <div data-target-id="4" class="user_short_tab_each so_tb <?php echo e(count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''); ?>">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">SOCIAL</div>
                </div>
                <div data-target-id="5" class="user_short_tab_each vi_tb <?php echo e(count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''); ?>">
                    <div class="user_short_tab_icon"></div>
                    <div class="user_short_tab_txt">VIDEOS</div>
                </div>
            </div>
        </div>
        <?php if($userCampaignDetails['isLive']): ?>
        <div id="user_project_outer" data-link="<?php echo e(route('user.project', ['username' => $user->username])); ?>" class="panel card_pro_click user_hm_rt_btm_otr colio_outer colio_dark">
            <div class="ch_bag_pric_sec bio_sec">
                <div class="fund_raise_left">
                    <img alt="<?php echo e($user->name.'\'s crowdfund project'); ?>" class="bio_sec_percent_image a_percent hide_on_mobile" src="<?php echo e($userCampaignDetails['campaignPercentImage']); ?>" alt="#" />
                    <div class="colio_header">My Crowdfunder</div>
                    <div class="fund_raise_status"></div>
                </div>
                <div class="fund_raise_right">
                    <div class="pricing_setail">
                        <ul>
                            <li class="fleft">
                                <div class="tier_one_text_one header3">
                                    <?php echo e($userCampaignDetails['campaignDonators']); ?>

                                </div>
                            </li>
                            <li class="fright">
                                <div class="tier_four_text_one project_txt header3">
                                    <?php echo e(ucfirst($userCampaignDetails['campaignStatus'])); ?>

                                </div>
                            </li>
                            <li class="fleft">
                                <p class="tier_one_text_two">Fans supported this</p>
                            </li>
                            <li class="fright">
                                <p class="tier_four_text_two">Status</p>
                            </li>
                            <li class="fleft">
                                <div class="tier_two_text_one header3">
                                    <?php echo e($userCampaignDetails['campaignCurrencySymbol'].$userCampaignDetails['amountRaised']); ?>

                                </div>
                            </li>
                            <li class="fright">
                                <div class="tier_three_text_one header3">
                                    <?php echo e($userCampaignDetails['campaignDaysLeft']); ?>

                                </div>
                            </li>
                            <li class="fleft">
                                <p class="tier_two_text_two">
                                    Raised of <text class="target_value"><?php echo e($userCampaignDetails['campaignGoal']); ?></text> target
                                </p>
                            </li>
                            <li class="fright">
                                <p class="tier_three_text_two">Days left</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-row-full-width'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('slide'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('miscellaneous-html'); ?>
    <div id="body-overlay"></div>
    <?php echo $__env->make('parts.chart-popups', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <input id="has_free_sub" type="hidden" value="<?php echo e($user->hasActiveFreeSubscription() ? '1' : '0'); ?>" />
    <input type="hidden" id="stripe_publishable_key" value="<?php echo e(config('constants.stripe_key_public')); ?>">
    <div class="tab_btns_alt_outer tab_dsk hide_on_desktop">
        <div class="each_tab_alt_btn tab_alt_btn_user_bio <?php echo e($user->default_tab_home == NULL || $user->default_tab_home == 1 ? 'true_active' : ''); ?>" data-target-id="1">
            <div class="border"></div>
        </div>
        <div class="each_tab_alt_btn tab_alt_btn_music <?php echo e(count($user->hidden_tabs_home) && in_array('2', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 2 ? 'true_active' : ''); ?>" data-target-id="2">
            <div class="border"></div>
        </div>
        <div class="each_tab_alt_btn tab_alt_btn_fans <?php echo e(count($user->hidden_tabs_home) && in_array('3', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 3 ? 'true_active' : ''); ?>" data-target-id="3">
            <div class="border"></div>
        </div>
        <div class="each_tab_alt_btn tab_alt_btn_social <?php echo e(count($user->hidden_tabs_home) && in_array('4', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 4 ? 'true_active' : ''); ?>" data-target-id="4">
            <div class="border"></div>
        </div>
        <?php if($userCampaignDetails['campaignIsLive'] == '1' && $userCampaignDetails['campaignStatus'] == 'active'): ?> 
        <?php $hasCrowdfunder = 1 ?>
        <?php else: ?>
        <?php $hasCrowdfunder = 0 ?>
        <?php endif; ?>
        <div class="each_tab_alt_btn tab_alt_btn_crowd_fund store <?php echo e(count($user->hidden_tabs_home) && in_array('6', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 6 ? 'true_active' : ''); ?>" data-target-id="6">
            <div class="border_alter">
                Store<br><?php echo e($userCampaignDetails['campaignProducts']); ?>

            </div>
            <div class="border"></div>
        </div>
        <div class="each_tab_alt_btn tab_alt_btn_video <?php echo e(count($user->hidden_tabs_home) && in_array('5', $user->hidden_tabs_home) ? 'disabled' : ''); ?> <?php echo e($user->default_tab_home == 5 ? 'true_active' : ''); ?>" data-target-id="5" data-video-id="<?php echo e($userPersonalDetails['bioVideoId']); ?>">
            <div class="border"></div>
        </div>
        <?php if(!$user->isCotyso()): ?>
        <div class="each_tab_alt_btn tab_alt_btn_tv" data-target-id="">
            <div class="border"></div>
        </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    
    <?php if($user->isCotyso()): ?>
        <?php echo $__env->make('parts.singing-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('templates.advanced-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/platform/resources/views/pages/user-home.blade.php ENDPATH**/ ?>