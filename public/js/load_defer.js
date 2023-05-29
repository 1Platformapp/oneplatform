    
    var browserWidth = $( window ).width();
    if( browserWidth <= 767 ){

        $('head').append('<link href="/css/responsive.min.css?v=4.8" rel="stylesheet" type="text/css" />');
    }
    
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
        $('.defer_loading.instant_hide').removeClass('instant_hide');
        var backgroundLength = $('.back_inactive').length;
        if(backgroundLength){

            $('.back_inactive').each(function(){
                $(this).css('background-image', 'url(' + $(this).attr('data-url') + ')');
                $(this).removeClass('back_inactive').addClass('active');
            });
        }

        if($('.page_main_tab_content').length){

            var page = $('#share_current_page').val();
            if(page != 'tv'){ 
                $.ajax({

                    url: '/loadMyRequestData',
                    type: 'POST',
                    data: {'load_type': 'main_tab_content', 'load': page},
                    cache: true,
                    dataType: 'html',
                    success: function (response) {

                        $('.page_main_tab_content').html(response);
                        if(page == 'tv'){ 
                            $.getScript('/js/tv-streams.js', function() {

                            });
                        }
                    }
                });
            }
        }

        if($('.evade_auto_fill').length){
            $('.evade_auto_fill').val('');
        }

        if($('#double_card_container').length){

            $.ajax({

                url: '/loadMyRequestData',
                type: 'POST',
                data: {'load_type': 'double_cards', 'load': $('#share_current_page').val()},
                cache: true,
                dataType: 'html',
                success: function (response) {

                    $('#double_card_container').html(response);
                    var imgDefer = $('#double_card_container img.defer_loading');
                    for (var i=0; i<imgDefer.length; i++) {
                        if(imgDefer[i].getAttribute('data-src')) {
                            imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
                        } 
                    }
                    if(browserWidth <= 767){

                        var cards = $('#double_card_container')[0].outerHTML;
                        
                        if($('.tv_outer').length){
                            $('#double_card_container').remove();
                            $('.tv_center_outer').append(cards);
                        }
                        if($('.live_outer').length){
                            $('#double_card_container').remove();
                            $('.live_center_outer').append(cards);
                        }
                    }
                }
            });
        }

        if( browserWidth > 767 ){

            
        }

        if(window.currentUserId && window.currentUserId == 765){

            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5d9b2a8adb28311764d7a896/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        }

        if( browserWidth <= 767 ) {
            var owlContainer = $('.scroller_outer_res #owl_content');        
        }else{
            var owlContainer = $('.scroller_outer #owl_content'); 
        }
        if(owlContainer.length){

            $.ajax({

                url: '/loadMyRequestData',
                type: 'POST',
                data: {'load_type': 'owl_carosel', 'load': ''},
                cache: true,
                dataType: 'html',
                success: function (response) {

                    owlContainer.html(response);
                    $.getScript('/js/owl.carousel.js', function() {
                        $.getScript('/js/horizontal-slider.js', function() {
                            $("head").append($('<link href="/css/owl.carousel.css" type="text/css" rel="stylesheet" />css/owl.theme.css'));
                        });
                    });
                }
            });
        }

        /*
        if($('.elfsight-app-45289136-ac03-45b8-8763-d5ed5ae9395b').length){

            $("#google-reviews").googlePlaces({
                 placeId: 'ChIJ04bRSrO2e0gR4gC8_d8EJeA' //Find placeID @: https://developers.google.com/places/place-id
               , render: ['reviews']
               , min_rating: 4
               , max_rows:40
            });
        }*/

        if(typeof loadUserTab !== 'undefined' && loadUserTab && loadUserTab != ''){
            $('.user_short_tab_each[data-target-id="'+loadUserTab+'"]').trigger('click');
        }
    }

    function loadDeferredVideo(){

        if($('.vid_preloader').length){
            $('.vid_preloader').attr('id', 'player1').removeClass('vid_preloader');
            var mediaInstancee = playMediaElementVideo(0, 0, 0, 0, 0);
            return mediaInstancee;
        }

        return 0;
    }
    
    var mediaInstance = 0;
    document.addEventListener("DOMContentLoaded", function(event) {

        setTimeout(function(){

            loadDeferredTasks();
        }, 3000);

        setTimeout(function(){

            $.getScript('https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.5/mediaelement-and-player.js', function() {
                $.getScript('/player-element/dist/jump-forward/jump-forward.min.js', function() {
                    $.getScript('/player-element/dist/skip-back/skip-back.min.js', function() {
                        $.getScript('/player-element/dist/speed/speed.min.js', function() {
                            $.getScript('/player-element/dist/chromecast/chromecast.min.js', function() {
                                $.getScript('/player-element/dist/context-menu/context-menu.min.js', function() {
                                    mediaInstance = loadDeferredVideo();
                                });
                            });
                        });
                    });
                });
            });
            if($('#has_free_sub').length && $('#stripe_publishable_key').length){
                $.getScript('https://js.stripe.com/v3/', function() { });
            }
        }, 5000);


        
    });
    //window.onload = loadDeferredTasks;