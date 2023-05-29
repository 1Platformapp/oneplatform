<?php $__env->startSection('pagetitle'); ?> 1 Platform | Artists, Producers, Musicians, Content Creators <?php $__env->stopSection(); ?>

<?php $__env->startSection('pagekeywords'); ?> 
    <meta name="keywords" content="artists,musicians,discover music,songs,songwriters,producers,filmmakers,raise money,promote music,sell music, content creators,connect people,networking,distribution,premium streams,creative,business,sell,music,music license,crowdfunding,studios,online store,gigs,merchandise,bespoke license,music industry" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagedescription'); ?> 
    <meta name="description" content="1Platform is for artists to sell music licenses,products,tickets or raise money through crowdfunding. Discover music and support its creators"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('seocontent'); ?>
    <h1 class="main_heading">1 Platform is for artists, producers, musicians, content creators</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-level-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('fontawesome/css/all.min.css')); ?>" >
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/portfolio.min.css')); ?>"></link>
    <link rel="stylesheet" href="<?php echo e(asset('css/site-home.css?v=1.18')); ?>"></link>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-level-js'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/site-home.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('parts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('flash-message-container'); ?>
    <?php if(Session::has('success')): ?>
        <div style="margin: 0;" class="success_span"><?php echo e(Session::get('success')); ?></div>
    <?php endif; ?>

    <?php if(Session::has('music_search_filters')): ?>
        <?php Session::put('remember_music_search_filters', Session::get('music_search_filters')) ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('social-media-html'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('page-content'); ?>

                <div class="auto_content">
                    <div class="dsk_her">
                    	<div class="dsk_left">
							<p class="dsk_main_title">1 Platform Management</p>
	                        <!--<div class="dsk_support_outer">
	                            <div class="dsk_support_each">Artists</div>
	                            <div class="dsk_support_each">Producers</div>
	                            <div class="dsk_support_each">Musicians</div>
	                            <div class="dsk_support_each">Creators</div>
	                            <div class="dsk_support_each">Videographers</div>
	                            <div class="dsk_support_each">Photographers</div>
	                            <div class="dsk_support_each">Marketers</div>
	                            <div class="dsk_support_each">Managers</div>
	                            <div class="dsk_support_each">Agents</div>
	                            <div class="dsk_support_each">Producers</div>
	                            <div class="dsk_support_each">Studios</div>
	                            <div class="dsk_support_each">Tuition</div>
	                        </div>!-->
	                        <p class="dsk_sub_title">
	                            Everything creative & business in one place
	                        </p>
	                        <div class="dsk_tools">
	                            <?php if(!Auth::check()): ?>
	                            <a href="<?php echo e(route('register')); ?>" id="dsk_signup">
	                            	<i class="fa fa-comment-dots"></i> 
	                            	Chat With A Manager Now
	                            </a>
	                            <a href="<?php echo e(route('login')); ?>" id="dsk_signin">Sign in</a>
	                            <?php else: ?>
	                            <a href="<?php echo e(route('profile.with.tab.info', ['tab' => 'edit', 'info' => 'cards'])); ?>" id="dsk_dashboard">
	                                <span id="dsk_dash_left">
	                                    <img src="<?php echo e(asset('images/user-default-thumb.jpg')); ?>" />
	                                </span>
	                                <span>
	                                    MY ACCOUNT
	                                </span>
	                            </a>
	                            <?php endif; ?>
	                        </div>
                    	</div>
                    	<div class="dsk_right">
                    		<video poster="<?php echo e(asset('images/home-poster.jpg')); ?>" controls id="myVideo">
							  <source src="<?php echo e(asset('videos/1platform_revised.mp4')); ?>" type="video/mp4">
							  Your browser does not support HTML5 video.
							</video>
                    	</div>
                    </div>
                    <div class="app_download">
                        <a class="app_download_ic" href="#">
                            <img src="<?php echo e(asset('images/android-app-download.png')); ?>">
                        </a>
                        <a class="app_download_ic" href="#">
                            <img src="<?php echo e(asset('images/ios-app-download.png')); ?>">
                        </a>
                    </div>
                    <?php $slides = \App\Models\ScrollerSetting::all() ?>
                    <?php if(count($slides)): ?>
                    <div class="auth_carosel_section auth_carosel_user">
                        <div class="auth_carosel_in">
                        	<?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        	<?php $details = 0 ?>
                        	<?php
                        		$commonMethods = new \App\Http\Controllers\CommonMethods();
                        		if($slide->type == 'user' and $slide->user and $slide->user->active == 1){
                        			$details = $commonMethods->getUserRealCampaignDetails($slide->user_id);
                        			$thumb = $details['campaignUserInfo']['profileImageCarosel'];
                        			
                        	        if($details['campaignIsLive'] == '1' && $details['campaignStatus'] == 'active'){
                        	            $hasCrowdFundd = 1;
                        	            $link = $details['campaignUserInfo']['projectPage'];
                        	        }else{
                        	            $hasCrowdFundd = 0;
                        	            $link = $details['campaignUserInfo']['homePage'];
                        	        }

                        		}else if($slide->type == 'stream' && $slide->stream){
                        			$details = $slide->stream;
                        			$thumb = 'https://i.ytimg.com/vi/'.$details->youtube_id.'/mqdefault.jpg';
                        			$link = route('tv');
                        		}
                        	?>
                        	<?php if($details): ?>
                            <div data-id="<?php echo e($slide->id); ?>" data-link="<?php echo e($link); ?>" class="auth_each_carosel">
                                <div class="auth_carosel_img">
                                    <img alt="<?php echo e($slide->type == 'user' ? $details['campaignUserInfo']['name'].' is featured on 1platform' : $details->name); ?>" src="<?php echo e($thumb); ?>">
                                </div>
                                <div class="auth_carosel_name">
                                    <?php if($slide->type == 'user'): ?>
                                    	<?php echo e($details['campaignUserInfo']['name']); ?>

                                    <?php elseif($slide->type == 'stream'): ?>
                                    	<?php echo e($details->name); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="auth_carosel_nav">
                            <div class="auth_carosel_nav_each auth_carosel_back disabled">
                                <i class="fa fa-angle-left"></i>
                            </div>
                            <div class="auth_carosel_nav_each auth_carosel_animate animating disabled">
                                <i class="fa fa-play"></i>
                            </div>
                            <div class="auth_carosel_nav_each auth_carosel_next disabled">
                                <i class="fa fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php $programs = \App\Models\SiteProgram::orderBy('order' ,'asc')->get() ?>
                    <?php if(count($programs)): ?>
                    <div class="home_each_section home_section_portfolio">
                    	<h2>Discover <span>1</span>Platform</h2>
                    	<div class="portfolio_outer">
    	                	<div class="portfolio_det_outer"></div>
    	                	<div class="portfolio_each_contain">
    	                		<?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    			                <div data-id="<?php echo e($program->id); ?>" class="portfolio_each site_program">
    			                    <div class="each_port_up">
    			                        <div class="drop"></div>
    			                        <div class="back back_inactive hide_on_mobile" data-url="https://duong.1platform.tv/public/program-images/<?php echo e($program->displayImage()); ?>"></div>
    			                        <img alt="<?php echo e($program->title); ?>" class="defer_loading hide_on_desktop" src="https://duong.1platform.tv/public/program-images/<?php echo e($program->displayImage()); ?>" />
    			                        <span>View Details</span>
    		                            <div class="cloader"><div></div><div></div><div></div></div>
    			                    </div>
    			                    <div class="each_port_down">
    			                        <div class="each_port_name">
    			                            <?php echo e($program->title); ?>

    			                        </div>
    			                    </div>
    			                </div>
    			                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	                	</div>
                    	</div>
                    </div>
                    <?php endif; ?>
                    <?php $packages = config('constants.user_internal_packages') ?>
                    <!--<div class="home_each_section home_section_packages">
                    	<div class="int_sub_outer">
                    	    <div class="int_sub_inner">
                    	        <div class="int_sub_nav_outer hide_on_desktop">
                    	            <div class="int_sub_nav_btn int_nav_btn_prev">
                    	                <i class="fa fa-caret-left"></i>
                    	            </div>
                    	            <div class="int_sub_nav_btn int_nav_btn_next">
                    	                <i class="fa fa-caret-right"></i>
                    	            </div>
                    	        </div>
                    	        <div class="int_sub_liner">
                    	            <div class="int_sub_head">
                    	                <div class="int_sub_head_up">Subscriptions</div>
                    	            </div>
                    	            
                    	            <div class="int_sub_dhead">Price</div>
                    	            <div class="int_sub_offer_outer">
                    	                <div class="int_sub_offer_each"><span class="hide_on_mobile">Choose </span>Payment Plan</div>
                    	                <div class="int_sub_offer_each">&nbsp;</div>
                    	                <div class="int_sub_offer_each">
                    	                    Fee Per Sale
                    	                </div>
                    	                <div class="int_sub_offer_each">
                    	                    <span class="hide_on_mobile">Connect a&nbsp;</span>Custom Domain
                    	                </div>
                    	                <div class="int_sub_offer_each">
                    	                    Max Disk Usage
                    	                </div>
                    	                <div class="int_sub_offer_each">
                    	                    Free From Adverts
                    	                </div>
                    	                <div class="int_sub_offer_each">
                    	                    <span class="hide_on_mobile">Access To&nbsp;</span>Industry Contacts
                    	                </div>
                    	                <div class="int_sub_offer_each">
                    	                    Get Pro Agent
                    	                </div>
                    	            </div>
                    	        </div>
                    	        <div class="int_sub_act_outer">
                    	            
                    	            <div class="int_sub_each pro_hover">
                    	                <div class="int_sub_head">
                    	                    <div class="int_sub_head_up"><?php echo e(ucfirst($packages[0]['name'])); ?></div>
                    	                </div>
                    	                <div class="int_sub_dhead solo">
                    	                    <div class="inner">
                    	                        <p>Free</p>
                    	                    </div>
                    	                </div>
                    	                <div class="int_sub_offer_outer">
                    	                    <div class="int_sub_offer_each">&nbsp;</div>
                    	                    <div class="int_sub_offer_each int_sub_free">
                    	                        <div class="int_sub_confirm">Sign Up</div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <?php echo e($packages[0]['application_fee']); ?>%
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_no">
                    	                            <i class="fa fa-times"></i>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <?php echo e($packages[0]['volume']); ?>GB
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_no">
                    	                            <i class="fa fa-times"></i>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_no">
                    	                            <i class="fa fa-times"></i>
                    	                        </div>
                    	                    </div>
                    	                   	<div class="int_sub_offer_each">
                    	                   	    <div class="int_sub_offer_no">
                    	                   	        <i class="fa fa-times"></i>
                    	                   	    </div>
                    	                   	</div>
                    	                </div>
                    	            </div>
                    	            <div class="int_sub_each pro_hover">
                    	                <div class="int_sub_head">
                    	                    <div class="int_sub_head_up"><?php echo e(ucfirst($packages[1]['name'])); ?></div>
                    	                </div>
                    	                <div class="int_sub_dhead">
                    	                    <div class="inner">
                    	                        <sup>&pound;</sup>
                    	                        <p><?php echo e($packages[1]['pricing']['month']); ?></p>
                    	                    </div>
                    	                    <div class="int_sub_dhead_interval">per month</div>
                    	                </div>
                    	                <div class="int_sub_offer_outer">
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_term_switch">
                    	                            <div data-name="<?php echo e($packages[1]['name']); ?>" data-price="<?php echo e($packages[1]['pricing']['month']); ?>" data-term="month" class="int_sub_term_each active">Monthly</div>
                    	                            <div data-name="<?php echo e($packages[1]['name']); ?>" data-price="<?php echo e($packages[1]['pricing']['year']); ?>" data-term="year" class="int_sub_term_each">Yearly</div>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_confirm int_sub_pay">Sign Up</div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <?php echo e($packages[1]['application_fee']); ?>% 
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_yes">
                    	                            <i class="fa fa-check"></i>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <?php echo e($packages[1]['volume']); ?>GB
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_yes">
                    	                            <i class="fa fa-check"></i>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_yes">
                    	                            <i class="fa fa-check"></i>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_no">
                    	                            <i class="fa fa-times"></i>
                    	                        </div>
                    	                    </div>
                    	                </div>
                    	            </div>
                    	            <div class="int_sub_each pro_hover">
                    	                <div class="int_sub_head">
                    	                    <div class="int_sub_head_up"><?php echo e(ucfirst($packages[2]['name'])); ?></div>
                    	                </div>
                    	                <div class="int_sub_dhead">
                    	                    <div class="inner">
                    	                        <sup>&pound;</sup>
                    	                        <p><?php echo e($packages[2]['pricing']['month']); ?></p>
                    	                    </div>
                    	                    <div class="int_sub_dhead_interval">per month</div>
                    	                </div>
                    	                <div class="int_sub_offer_outer">
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_term_switch">
                    	                            <div data-name="<?php echo e($packages[2]['name']); ?>" data-price="<?php echo e($packages[2]['pricing']['month']); ?>" data-term="month" class="int_sub_term_each active">Monthly</div>
                    	                            <div data-name="<?php echo e($packages[2]['name']); ?>" data-price="<?php echo e($packages[2]['pricing']['year']); ?>" data-term="year" class="int_sub_term_each">Yearly</div>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_confirm int_sub_pay">Sign Up</div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <?php echo e($packages[2]['application_fee']); ?>%  
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_yes">
                    	                            <i class="fa fa-check"></i>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <?php echo e($packages[2]['volume']); ?>GB
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_yes">
                    	                            <i class="fa fa-check"></i>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_yes">
                    	                            <i class="fa fa-check"></i>
                    	                        </div>
                    	                    </div>
                    	                    <div class="int_sub_offer_each">
                    	                        <div class="int_sub_offer_yes">
                    	                            <i class="fa fa-check"></i>
                    	                        </div>
                    	                    </div>
                    	                </div>
                    	            </div>
                    	        </div>
                    	    </div>
                    	</div>
                    </div>!-->
                </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('miscellaneous-html'); ?>

    <div id="body-overlay"></div>

    <style>
    	@media (min-width:320px) and (max-width: 767px) {

    		.home_each_section { padding-top: 0 !important; }
    	}
	</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.basic-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/platform/resources/views/pages/home-new.blade.php ENDPATH**/ ?>