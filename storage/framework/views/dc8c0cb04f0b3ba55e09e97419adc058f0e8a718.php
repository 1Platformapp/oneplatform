
<?php $disabledd = isset($disabled) && $disabled == 1 ? 1 : 0 ?>
<?php $commonMethods = new \App\Http\Controllers\CommonMethods(); ?>
<?php $ticketsLeft = $userFeatProduct->quantity != NULL ? $userFeatProduct->items_available - $userFeatProduct->items_claimed : NULL ?>
<div class="feat_product_temp feat_template" id="feat_slide_<?php echo e($count); ?>">
    <div class="colio_header">My Product</div>
    <div class="user_hm_rt_btm_inner">
        <div class="upper_sec">
            <span class="upper_up_contain">
                <span class="feat_nav_arrow" id="feat_nav_arrow_left" >
                    <i class="fa fa-angle-left"></i>
                </span>
                <img alt="<?php echo e($userFeatProduct->title); ?>" class="defer_loading" src="#" data-src="<?php echo e(asset('user-product-thumbnails/'.$userFeatProduct->thumbnail_feat)); ?>">
                <span class="feat_nav_arrow" id="feat_nav_arrow_right" >
                    <i class="fa fa-angle-right"></i>
                </span>
            </span>
            <div class="product_scroll">
                <b><?php echo e($userFeatProduct->title); ?></b>
                <p>
                    <?php echo nl2br($userFeatProduct->description); ?>


                <?php $includes = explode(",", $userFeatProduct->includes);?>

                <?php $__currentLoopData = $includes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $include): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="feat_bullet"><i class="fa fa-circle"></i>&nbsp;&nbsp;<?php echo e(trim($include)); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </p>
                <div class="stock_remain">
                    <?php if($ticketsLeft != NULL): ?>
                        <?php echo e($ticketsLeft > 0 ? $ticketsLeft.' Available' : 'Sold out'); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="lower_sec">
            <label class="add_ticket feat_prod_add <?php echo e($ticketsLeft && $ticketsLeft<=0?'sold_out':''); ?>" data-productid="<?php echo e(!$disabledd && (!$ticketsLeft || $ticketsLeft > 0) ? $userFeatProduct->id : 0); ?>" data-basketuserid="<?php echo e(!$disabledd && (!$ticketsLeft || $ticketsLeft > 0) ? $userFeatProduct->user->id : 0); ?>" data-basketprice="<?php echo e(!$disabledd && (!$ticketsLeft || $ticketsLeft > 0) ? $userFeatProduct->price : 0); ?>" data-musicid="0" data-purchasetype="product" style="cursor: pointer;">
                <?php echo e(!$ticketsLeft || $ticketsLeft > 0 ? 'Add product' : 'Sold out'); ?>

                <strong><?php echo e($commonMethods->getCurrencySymbol(strtoupper($userFeatProduct->user->profile->default_currency))); ?><?php echo e($userFeatProduct->price); ?></strong>
            </label>
        </div>
    </div>
</div>
<?php /**PATH /opt/lampp/htdocs/platform/resources/views/parts/feat_product_template.blade.php ENDPATH**/ ?>