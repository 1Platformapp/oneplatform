$('document').ready(function(){

        	$('.auth_carosel_nav_each').removeClass('disabled');

        	setTimeout(initAnimation, 2000);

            $('#login_at_login').click(function(){

                var browserWidth = $( window ).width();
                if( browserWidth >= 767 ) {
                    $('#email_address,#password').val('');
                    $('#email_address').focus();
                }
            });

            $('.int_sub_confirm').click(function(){
            	window.location = '/register';
            });

            $('.auth_each_carosel').click(function(){

                var url = $(this).attr('data-link');
                if(url != ''){
                    window.location.href = url;
                }
            });

            $('.auth_carosel_nav_each:not(.disabled)').click(function(){
                var thiss = $(this);
                var cons = $('.auth_carosel_section').find('.auth_each_carosel:first').outerWidth();
                if(thiss.hasClass('auth_carosel_back')){

                    var position = $('.auth_carosel_section').find('.auth_carosel_in').scrollLeft() - cons;
                    
                }else if(thiss.hasClass('auth_carosel_next')){

                    var position = $('.auth_carosel_section').find('.auth_carosel_in').scrollLeft() + cons;
                }

                doAnimation(position);
            });

            $('.auth_carosel_animate:not(.disabled)').click(function(){

            	if(!$(this).hasClass('animating')){

            		$(this).addClass('animating');
            		$(this).find('i').addClass('fa-pause').removeClass('fa-play');
            		initAnimation();
            	}else{

            		$(this).removeClass('animating');
            		$(this).find('i').removeClass('fa-pause').addClass('fa-play');
            	}
            });
        });

        function initAnimation(){

        	if($('.auth_carosel_animate').hasClass('animating')){

        		if(!$('.auth_carosel_animate i').hasClass('fa-pause')){
        			$('.auth_carosel_animate i').addClass('fa-pause').removeClass('fa-play');
        		}

        		var scrollWidth = $('.auth_carosel_section').find('.auth_carosel_in')[0].scrollWidth;
        		var width = $('.auth_carosel_section').find('.auth_carosel_in').outerWidth();
        		var scrollLeftPosition = $('.auth_carosel_section').find('.auth_carosel_in').scrollLeft();
        		var cons = $('.auth_carosel_section').find('.auth_each_carosel:first').outerWidth();
        		if(scrollWidth - (width + scrollLeftPosition) < 5){
        			var position = 0;
        		}else{
        			var position = $('.auth_carosel_section').find('.auth_carosel_in').scrollLeft() + cons;
        		}

        		doAnimation(position);

        		setTimeout(initAnimation, 3000);
        	}
        }

        function doAnimation(position){

        	$('.auth_carosel_section').find('.auth_carosel_in').animate({
        	    scrollLeft: position
        	}, 400);
        }