<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="facebook-domain-verification" content="cgl7a7tsl52bqf1y0il3lxntrv09ij" />
        <meta name="google-site-verification" content="AR1UIRB4nzeneJoD1RppX4OOJKzdrH3GLDc7O1jix9Q" />
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Cache-control" content="public">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo $__env->yieldContent('pagetitle'); ?></title>
        <?php echo $__env->yieldContent('pagekeywords', ''); ?>
        <?php echo $__env->yieldContent('pagedescription', ''); ?>
    
        <?php if(\Request::route()->getName() == 'site.home' || \Request::route()->getName() == 'user.home' || \Request::route()->getName() == 'custom.domain.home'): ?>
            <link rel="canonical" href="<?php echo e(asset('')); ?>">
        <?php else: ?>
            <link rel="canonical" href="<?php echo e(url()->current()); ?>">
        <?php endif; ?>
        
        <?php if(parse_url(request()->root())['host'] == 'www.singingexperience.co.uk'): ?>
        <link rel="apple-touch-icon" href="<?php echo e(asset('apple-touch-icon-se.png')); ?>">
        <?php endif; ?>
        <link rel="icon" href="<?php echo e(asset('favicon.ico?v=1.1')); ?>" type="image/x-icon" />
        <link href="<?php echo e(asset('css/style.min.css?v=3.14')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('css/auth.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!------------------------>
        <script src="<?php echo e(asset('js/jquery.min.js')); ?>" type="text/javascript"></script>
        <script defer type="application/javascript" src="<?php echo e(asset('js/my_script.min.js?v=6.66')); ?>"></script>

        <?php echo $__env->yieldContent('page-level-css',''); ?>

        <?php echo $__env->yieldContent('page-level-js',''); ?>

        <style>
            .wrapper_outer.sm_header header { position: fixed; top: 0; left: 0; }
            .wrapper_outer.sm_header .content_outer { padding-top: 50px; }
        </style>

        <script type="text/javascript">
            var browserWidth = $( window ).width();
            if( browserWidth > 767 ){

                $(window).on('scroll', function () {
                    if ($(window).scrollTop() > 200) {
                        $('.wrapper_outer').addClass('sm_header');
                    } else {
                        $('.wrapper_outer').removeClass('sm_header');
                    }
                });
            }
        </script>
        
    </head>
    <body>

        <?php echo $__env->yieldContent('seocontent'); ?>
        
        <script>
            var browserWidth = $( window ).width();
            if( browserWidth <= 767 ){

                $('head').append('<link href="/css/responsive.min.css?v=4.8" rel="stylesheet" type="text/css" />');
            }
        </script>

        <aside>

            <?php echo $__env->yieldContent('audio-player'); ?>

        </aside>

        <section class="wrapper_outer">

            <header>

                <?php echo $__env->yieldContent('header',''); ?>

            </header>

            <aside>

                <div class="hrd_cart_outer clearfix">
                    <?php echo $__env->make('parts.smart-cart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <?php echo $__env->make('parts.smart-notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('parts.smart-user-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </aside>

            <aside>

                <?php echo $__env->yieldContent('preheader'); ?>

            </aside>

            <section>

                <section class="content_outer">

                    <section>

                        <aside>

                            <?php echo $__env->yieldContent('flash-message-container',''); ?>

                        </aside>

                        <aside>

                            <?php echo $__env->yieldContent('social-media-html',''); ?>

                        </aside>

                        <section>

                            <?php echo $__env->yieldContent('page-content',''); ?>

                        </section>

                        <aside>

                            <?php echo $__env->yieldContent('miscellaneous-html',''); ?>

                        </aside>

                    </section>

                    <aside>

                        <div data-basket="" data-user="" id="post_cart_toast" class="post_cart_toast">
                            <div class="toast_inner">
                                <div class="message">Added to cart</div>
                                <div id="undo" class="each_option">Undo</div> | 
                                <div id="continue" class="each_option">Continue</div> | 
                                <div id="checkout" class="each_option">Checkout</div>
                            </div>
                            <div id="close" class="action"><i class="fa fa-times"></i></div>
                        </div>

                    </aside>
                    
                </section>

            </section>

            <footer>

                <?php echo $__env->yieldContent('footer',''); ?>

            </footer>

            <aside>

                <div id="to_top"><i class="fa fa-angle-up"></i></div>
                <div id="body-overlay"></div>

            </aside>
            
        </section>

        <input type="hidden" id="platform" value="1">

        <script type="text/javascript">

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function loadDeferredTasks() {
                
                var browserWidth = $( window ).width();
                var stylesheetDefer = $('link.switchmediaall');
                for (var i=0; i<stylesheetDefer.length; i++) {
                    stylesheetDefer[i].setAttribute('media','all'); 
                } 
                var imgDefer = $('img.defer_loading');
                for (var i=0; i<imgDefer.length; i++) {
                    if(imgDefer[i].getAttribute('data-src')) {
                        imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
                    } 
                }
                var backgroundLength = $('.back_inactive').length;
                if(backgroundLength){

                    $('.back_inactive').each(function(){
                        $(this).css('background-image', 'url(' + $(this).attr('data-url') + ')');
                        $(this).removeClass('back_inactive').addClass('active');
                    });
                }

                if( browserWidth > 767 ){

                
                } 
            }
            
            document.addEventListener("DOMContentLoaded", function(event) {

                setTimeout(function(){

                    loadDeferredTasks();
                }, 3000);
                
            });
        </script>
    </body>
</html><?php /**PATH /opt/lampp/htdocs/platform/resources/views/templates/basic-template.blade.php ENDPATH**/ ?>