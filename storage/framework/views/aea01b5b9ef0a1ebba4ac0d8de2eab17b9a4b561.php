<?php if(Auth::check()): ?>
<div class="hrd_notif_outer clearfix">

	<div class="usr_men_main_btn_outer">
	    <div class="menu_close mobile-only">
	        <span onclick="$('#notif_icon_resp').trigger('click');" class="menu_close_go"><i class="fa fa-times"></i></span>
	    </div>
	    <div data-link="<?php echo e(route('search')); ?>" id="continue_browse_notif" class="notif_main_btn">
	        <div class="usr_men_main_btn_in">
	            <div class="usr_men_btn_in_text">BROWSE&nbsp;&nbsp;</div>
	        </div>
	    </div>
	    <div data-link="<?php echo e(route('faq')); ?>" id="usr_men_login" class="notif_main_btn">
	        <div class="usr_men_main_btn_in">
	            <div class="usr_men_btn_in_text">HELP</div>
	        </div>
	    </div>
	</div>
	<?php $commonMethods = new \App\Http\Controllers\CommonMethods() ?>
	<div class="usr_notif_items_outer">
		<div class="usr_notif_items_inner">
			<?php if(count(Auth::user()->notifications)): ?>
				<?php $__currentLoopData = Auth::user()->notifications->take(20); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $__env->make('parts.user-notification-item', ['notification' => $notification, 'commonMethods' => $commonMethods], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php else: ?>
				<?php echo $__env->make('parts.user-notification-item', ['notification' => 'none', 'commonMethods' => $commonMethods], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?><?php /**PATH /opt/lampp/htdocs/platform/resources/views/parts/smart-notifications.blade.php ENDPATH**/ ?>