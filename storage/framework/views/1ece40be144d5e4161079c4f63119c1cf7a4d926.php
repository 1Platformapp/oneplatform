
<?php $basket = \App\Http\Controllers\CommonMethods::getCustomerBasket() ?>

<?php if((Route::current()->getName() == 'user.checkout' && $user->isCotyso()) || Route::current()->getName() == 'personalized.checkout'): ?>
    <?php $cotysoCheckout = 1 ?>
<?php else: ?>
    <?php $cotysoCheckout = 0 ?>
<?php endif; ?>
<?php if(Route::current()->getName() == 'search'): ?>
    <?php $tvPage = 1 ?>
<?php else: ?>
    <?php $tvPage = 0 ?>
<?php endif; ?>
<?php if(Route::current()->getName() == 'site.home'): ?>
    <?php $siteHome = 1 ?>
<?php else: ?>
    <?php $siteHome = 0 ?>
<?php endif; ?>
<div class="header_outer">
    <div class="auto_content">
        <div class="header_inner clearfix">
            <?php $logoFile = 'images/1logo8.png' ?>
            <?php $notStandardLogo = 0 ?>
            <?php if(isset($userParams)): ?>
                <?php if(isset($logo)): ?>
                    <?php if($logo == 'standard'): ?>
                        <?php $logoFile = 'images/1logo8.png' ?>
                    <?php elseif($logo == 'custom'): ?>
                        <?php if($user->custom_logo != ''): ?>
                        <?php $logoFile = 'user-media/logo/'.$user->custom_logo ?>
                        <?php else: ?>
                        <?php $logoFile = 'user-media/logo/sample.jpg' ?>
                        <?php endif; ?>
                        <?php $notStandardLogo = 1 ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if($user->home_logo == 'standard'): ?>
                        <?php $logoFile = 'images/1logo8.png' ?>
                    <?php elseif($user->home_logo == 'custom'): ?>
                        <?php $logoFile = 'user-media/logo/'.$user->custom_logo ?>
                        <?php $notStandardLogo = 1 ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php elseif($cotysoCheckout): ?>
                <?php $logoFile = 'user-media/logo/'.$user->custom_logo ?>
                <?php $notStandardLogo = 1 ?>
            <?php endif; ?>

            <?php if(isset($userParams)): ?>      
    	        <?php if($userParams == 'customDomain'): ?>
    	            <?php $showAdvertMenus = 0 ?>
    	        <?php else: ?>
    		        <?php if($user->hasActivePaidSubscription()): ?>
    		            <?php $showAdvertMenus = 0 ?>
    		        <?php else: ?>
    		            <?php $showAdvertMenus = 1 ?>
    		        <?php endif; ?>
    	        <?php endif; ?>
    	    <?php elseif($cotysoCheckout): ?>
    	        <?php $showAdvertMenus = 0 ?>
            <?php elseif($tvPage): ?>
                <?php $showAdvertMenus = 0 ?>
            <?php elseif($siteHome): ?>
                <?php $showAdvertMenus = 0 ?>
            <?php else: ?>
                <?php $showAdvertMenus = 1 ?>
            <?php endif; ?>
            <div class="hrd_left_outer clearfix">
                <ul>
                    <?php if(!isset($user) || !$user->isCotyso() || Route::current()->getName() == 'profile' || Route::current()->getName() == 'profile.with.tab' || Auth::check()): ?>
                    <?php if(!$cotysoCheckout): ?>
                    <li class="hdr_left_menu_item hide_on_mobile">
                        <div class="menu_item header_left_item">
                            <svg type="contrast" width="4px" height="20px">
                            	<svg viewBox="0 0 3 19" id="ellipsisVertical">
                                    <g transform="translate(-1339 -26)">
                                        <circle cx="1.5" cy="1.5" r="1.5" transform="translate(1339 26)"></circle>
                                        <circle cx="1.5" cy="1.5" r="1.5" transform="translate(1339 34)"></circle>
                                        <circle cx="1.5" cy="1.5" r="1.5" transform="translate(1339 42)"></circle>
                                    </g>
                                </svg>
                            </svg>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <li class="hdr_left_menu_item hide_on_mobile">
                        <div class="cart_item header_left_item">
                            <span class="<?php echo e(count($basket)>0?'basket_counter_ok':''); ?>" id="basket_count"><?php echo e(count($basket)); ?></span>
                            <svg class="ccart_ic">
    	                        <svg viewBox="0 0 13 15" id="ccart">
                                    <path d="M13.125 1.75c.875 0 .875.875.875 1.137l-1.75 6.126c-.175.35-.525.612-.875.612h-8.75c-.525 0-.875-.35-.875-.875v-7H.875a.875.875 0 1 1 0-1.75h1.75C3.15 0 3.5.35 3.5.875v7h7.263L11.987 3.5H6.125a.875.875 0 1 1 0-1.75h7zM2.625 14a1.313 1.313 0 1 1 0-2.625 1.313 1.313 0 0 1 0 2.625zm7.875 0a1.313 1.313 0 1 1 0-2.625 1.313 1.313 0 0 1 0 2.625z"></path>
                                </svg>
    	                    </svg>
                        </div>
                    </li>
                    <?php if(Auth::check() && !$cotysoCheckout): ?>
                    <?php $newNotifs = Auth::user()->newNotifications() ?>
                    <li class="hdr_left_menu_item hide_on_mobile">
                        <div class="notif_item header_left_item">
                            <span class="<?php echo e($newNotifs && count($newNotifs) ? 'notif_counter_ok' : ''); ?>" id="notif_count">
                                <?php echo e($newNotifs && count($newNotifs) ? count($newNotifs) : '0'); ?>

                            </span>
                            <i class="fa fa-bell"></i>
                        </div>
                    </li>
                    <?php if(!isset($user) || !$user->isCotyso()): ?>
                    <li class="hdr_left_menu_item hide_on_mobile">
                        <div class="chat_item header_left_item">
                        	<span data-link="<?php echo e(route('profile.with.tab',['tab' => 'chat'])); ?>">
                        	    <i class="fa fa-comments"></i>
                        	</span>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <li class="hdr_left_menu_item logo <?php echo e($notStandardLogo ? 'custom' : ''); ?>">
                        <div class="header_left_item">
                            <?php if(isset($userParams) || (isset($user) && $user->isCotyso())): ?>
                            <a class="<?php echo e(!$notStandardLogo ? 'logo8' : ''); ?>" href="<?php echo e($notStandardLogo && $user->username ? route('user.home',['params' => $user->username]) : (auth::check() && auth::user()->username?route('user.home',['params' => auth::user()->username]):route('login'))); ?>">
                                <img alt="<?php echo e($user->name); ?> picture" src="<?php echo e(asset($logoFile)); ?>">
                                <?php if(!$notStandardLogo): ?>
                                <div>Platform</div>
                                <?php endif; ?>
                            </a>
                            <?php else: ?>
                            <a class="logo8" href="<?php echo e(auth::check() && auth::user()->username?route('user.home',['params' => auth::user()->username]):route('login')); ?>">
                                <img alt="1platform" src="<?php echo e(asset('images/1logo8.png')); ?>" alt="" />
                                <div>Platform</div>
                            </a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
            <?php if($showAdvertMenus): ?>
            <div class="hrd_center_outer hide_on_mobile clearfix">
                <div class="hdr_search_outer">
                    <input readonly class="evade_auto_fill" id="header-search-input" placeholder="Search Music, Artists and Lyrics" type="text">
                </div>
            </div>
            <?php endif; ?>
            <div class="hrd_right_outer clearfix">
                <div class="hdr_right_icon_outer clearfix">
                    <ul>
                        <!--
                        <?php if($showAdvertMenus): ?>
    	                    <?php if(url()->current() == route("tv")): ?>
    	                    <li class="hdr_menu_item tv active real_active hide_on_mobile">
    	                        <a href="<?php echo e(route('tv')); ?>">TV</a>
    	                    </li>
    	                    <?php else: ?>
    	                    <li class="hdr_menu_item tv">
    	                        <a href="<?php echo e(route('tv')); ?>">TV</a>
    	                    </li>
    	                    <?php endif; ?>
                            <?php if(url()->current() == route("chart")): ?>
    	                    <li class="hdr_menu_item chart active real_active hide_on_mobile">
    	                        <a href="<?php echo e(route('chart')); ?>">Chart</a>
    	                    </li>
    	                    <?php else: ?>
    	                    <li class="hdr_menu_item chart hide_on_mobile">
    	                        <a href="<?php echo e(route('chart')); ?>">Chart</a>
    	                    </li>
    	                    <?php endif; ?>
                        	<li><span class="search_res_btn"></span></li>
                        <?php else: ?>
                            <li><span class="search_res_btn hide_on_desktop"></span></li>
                        <?php endif; ?>
                        !-->
                    </ul>
                </div>
            </div>
            <a id="cart_icon_resp" class="menu_opn_btn" href="javascript:void(0)">
                <span class="<?php echo e(count($basket)>0?'basket_counter_ok':''); ?>" id="basket_count_res"><?php echo e(count($basket)); ?></span>
                <svg class="ccart_ic">
                    <svg viewBox="0 0 13 15" id="ccart_res">
                        <path d="M13.125 1.75c.875 0 .875.875.875 1.137l-1.75 6.126c-.175.35-.525.612-.875.612h-8.75c-.525 0-.875-.35-.875-.875v-7H.875a.875.875 0 1 1 0-1.75h1.75C3.15 0 3.5.35 3.5.875v7h7.263L11.987 3.5H6.125a.875.875 0 1 1 0-1.75h7zM2.625 14a1.313 1.313 0 1 1 0-2.625 1.313 1.313 0 0 1 0 2.625zm7.875 0a1.313 1.313 0 1 1 0-2.625 1.313 1.313 0 0 1 0 2.625z"></path>
                    </svg>
                </svg>
            </a>
            <?php if(Auth::check() && !$cotysoCheckout): ?>
            <?php $newNotifs = Auth::user()->newNotifications() ?>
            <a id="notif_icon_resp" class="menu_opn_btn" href="javascript:void(0)">
                <span class="<?php echo e($newNotifs && count($newNotifs) ? 'notif_counter_ok' : ''); ?>" id="notif_count_res">
                    <?php echo e($newNotifs && count($newNotifs) ? count($newNotifs) : '0'); ?>

                </span>
                <i class="fa fa-bell"></i>
            </a>
            <?php if(!isset($user) || !$user->isCotyso()): ?>
            <!--<a id="chat_icon_resp" class="hide_on_desktop" href="<?php echo e(route('profile.with.tab', ['tab' => 'chat'])); ?>">
                <i class="fa fa-comments"></i>
            </a>!-->
            <?php endif; ?>
            <?php endif; ?>
            <?php if(!isset($user) || !$user->isCotyso()): ?>
            <?php if(!$cotysoCheckout): ?>
            <a id="menu_icon_resp" class="menu_opn_btn" href="javascript:void(0)">
                <svg type="contrast" name="ellipsisVerticalRes" width="4px" height="20px">
                    <svg viewBox="0 0 3 19" id="ellipsisVerticalRes">
                        <g transform="translate(-1339 -26)">
                            <circle cx="1.5" cy="1.5" r="2" transform="translate(1339 26)"></circle>
                            <circle cx="1.5" cy="1.5" r="2" transform="translate(1339 34)"></circle>
                            <circle cx="1.5" cy="1.5" r="2" transform="translate(1339 42)"></circle>
                        </g>
                    </svg>
                </svg>
            </a>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<input type="hidden" name="base_url" id="base_url" value="<?php echo e(asset('')); ?>">
<input type="hidden" name="current_url" id="current_url" value="<?php echo e(url()->current()); ?>">
<?php /**PATH /opt/lampp/htdocs/platform/resources/views/parts/header.blade.php ENDPATH**/ ?>