<?php if(count($user->services)): ?>
<?php $isSearch = isset($search) && $search == 1 ? 1 : 0 ?>
<div data-user-link="<?php echo e(route('user.home.tab', ['params' => $user->username, 'tab' => 6])); ?>" data-user-id="<?php echo e($user->id); ?>" class="panel services_outer colio_outer colio_dark">
    <div class="colio_header"><?php echo e($isSearch ? $user->name."'s" : 'My'); ?> Services</div>
    <div class="services_inner">
        <?php if($isSearch): ?>
            <div class="user_service_hide">
                <i class="fa fa-times"></i>
            </div>
        <?php endif; ?>
        <div class="services_list">
            <?php $__currentLoopData = $user->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="each_user_service">
                <div class="user_service_name"><?php echo e($userService->service_name); ?></div>
                <div class="user_service_price">
                    <?php if($userService->price): ?>
                        <?php echo e($commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))); ?><?php echo e($userService->price); ?>

                        <?php if($userService->price_interval && $userService->price_interval != 'no'): ?>
                            &nbsp;&nbsp;&nbsp;per <?php echo e($userService->price_interval); ?>

                        <?php endif; ?>
                    <?php elseif($userService->price_option == 3): ?>
                        POA
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </div>
        <div class="services_foot">
            <div id="service_store_anchor" class="service_foot_each">
                <div class="service_foot_ic">
                    <i class="fas fa-store-alt"></i>
                </div>
                <div class="service_foot_title">Store</div>
            </div>
            <?php if(!$user->isCotyso()): ?>
            <div id="service_chat_anchor" class="service_foot_each <?php echo e($user->chat_switch == 1 ? '' : 'disabled'); ?>">
                <div class="service_foot_ic">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="service_foot_title">Message</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?><?php /**PATH /opt/lampp/htdocs/platform/resources/views/parts/user-services-panel.blade.php ENDPATH**/ ?>