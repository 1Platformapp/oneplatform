
var browserWidth = $( window ).width();
if (window.location.hash && window.location.hash == '#_=_') {
    if (window.history && history.pushState) {
        window.history.pushState("", document.title, window.location.pathname);
    } else {
        // Prevent scrolling by storing the page's current scroll offset
        var scroll = {
            top: document.body.scrollTop,
            left: document.body.scrollLeft
        };
        window.location.hash = '';
        // Restore the scroll offset, should be flicker free
        document.body.scrollTop = scroll.top;
        document.body.scrollLeft = scroll.left;
    }
}

var editDelAlbumClicked = 0;

var messageInAud = new Audio('/audio-player/message_in.mp3');

var notifInAud = new Audio('/audio-player/notif_in.mp3');

$(document).ready(function() {

    var browserWidth = $( window ).width();

    var proOfferTimerInstance = new Interval(1000);

    checkApp();

    setTimeout(function(){

        if($('#platform').length && $('#platform').val() == '1'){

            $('.usr_men_cat_each:not(.usr_men_recommend,.usr_men_logout)').addClass('instant_hide');
            $('.m_btn_right_icons').addClass('instant_hide');
        }

    }, 200);

    Audio.prototype.play = (function(play) {
        return function (){
            var audio = this,
                args = arguments,
                promise = play.apply(audio, args);
            if(promise !== undefined) {
                promise.catch(_ => {

                });
            }
        };
    })(Audio.prototype.play);

    if( browserWidth >= 767 ) {

        $('.mobile-only').remove();

    }

    if( browserWidth < 768 ) {

        $(".read-more").on('click', function() {
            if ($(this).parent().hasClass('expanded')) {
                $(this).parent().removeClass('expanded');
                $(this).html('Read more');
            } else {
                $(this).parent().addClass('expanded');
                $(this).html('Read less');
            }
            return false;
        });

        $('body').delegate('.chat_left .chat_each_user', 'click', function(e){

            $("html, body").animate({scrollTop: $('.chat_right').offset().top - 60}, "slow");
        });
    }

    $('.inline_info').click(function(e){

        e.preventDefault();

        var source = $(this).attr('href');
        $('#inline_info_popup .pro_pop_head').text($(this).attr('data-title'));
        $('#inline_info_popup iframe').attr('src', source);
        $('#inline_info_popup,#body-overlay').show();
    });

    $('.ch_sup_feature_tab:not(.chart_disabled)').click(function(){

        var id = $(this).attr('data-id');
        if( browserWidth <= 767 ) {
            var tarElem = '#tab';
        }else{
            var tarElem = '#tabd';
        }

        $('div[data-show="'+tarElem+id+'"]').trigger('click');
        $("html, body").animate({scrollTop: $('div[data-show="'+tarElem+id+'"]').offset().top - 60}, "slow");
    });

    $('.pro_tab_feature').click(function(){

        var thisss = $(this);
        var thiss = $(this).closest('.pro_h_dt_btn_each');

        var formData = new FormData();
        formData.append('data', thiss.attr('data-id'));

        $.ajax({

            url: '/user-home-feature-tab',
            type: 'POST',
            data: formData,
            contentType:false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (response) {

                $('.pro_tab_feature').not(thisss).removeClass('active').addClass('inactive');
                thisss.toggleClass('active');
            }
        });
    });

    $('.pro_tab_hide_show').click(function(){

        var thisss = $(this);
        var thiss = $(this).closest('.pro_h_dt_btn_each');

        var formData = new FormData();
        formData.append('data', thiss.attr('data-id'));

        $.ajax({

            url: '/user-home-hideshow-tab',
            type: 'POST',
            data: formData,
            contentType:false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (response) {

                thisss.toggleClass('active');
            }
        });
    });

    $('.ch_sup_chat:not(.chart_disabled)').click(function(){

        $('#body-overlay,#chat_message_popup').show();
    });

        $('body').delegate('.portfolio_det_nav:not(.disabled)', 'click', function(e){

            var thiss = $(this);
            var currId = $('.portfolio_det_outer .portfolio_det_each').attr('data-id');
            var currPortElem = $('.portfolio_each_contain .portfolio_each[data-id="'+currId+'"]');
            if(currPortElem.length && thiss.hasClass('port_det_nav_back')){

                $('.portfolio_det_nav').addClass('disabled');
                currPortElem.prev().find('.each_port_up span').trigger('click');
            }
            if(currPortElem.length && thiss.hasClass('port_det_nav_next')){

                $('.portfolio_det_nav').addClass('disabled');
                currPortElem.next().find('.each_port_up span').trigger('click');
            }
        });

        $('body').delegate('.portfolio_det_close', 'click', function(e){

            $('.portfolio_det_outer').slideUp('slow');
        });

        $('body').delegate('.portfolio_each:not(.disabled) .each_port_up span', 'click', function(e){

            var portElem = $(this).closest('.portfolio_each');
            var id = portElem.attr('data-id');
            portElem.addClass('port_loading');

            var findType = 'portfolio_details';
            if(portElem.hasClass('site_program')){

                findType = 'site_program';
            }
            $.ajax({

                url: "/informationFinder",
                dataType: "json",
                type: 'post',
                data: {'find_type': findType, 'find': id, 'identity_type': 'guest', 'identity': ''},
                success: function(response) {
                    if(response.success == 1){
                        portElem.removeClass('port_loading');
                        $('.portfolio_det_outer').html(response.data.data);
                        $('html, body').animate({scrollTop: $('.portfolio_outer:first').offset().top - 50}, 500, function(){

                            $('.portfolio_det_outer').slideDown('slow');
                            updatePortDetNav();
                        });
                    }else{
                        alert(data.error);
                    }
                }
            });
        });


    if($('.pro_page_pop_up:visible').length){

        $('#body-overlay').show();
    }

    $('body').delegate('.user_lsa_head', 'click', function(e){

        var thiss = $(this).closest('.user_ls_accord_each').find('.user_lsa_body');
        $('.user_ls_accord_each .user_lsa_body').not(thiss).slideUp();
        thiss.slideToggle(1000);
    });

    $('body').delegate('.each_user_video.empty_video_list .user_live_stream_basic', 'click', function(e){

        e.preventDefault();

        var thiss = $(this).closest('.each_user_video.each_user_live_stream').find('.user_live_stream_det');
        $('.each_user_video.each_user_live_stream .user_live_stream_det').not(thiss).slideUp();
        thiss.slideToggle(1000);

        return false;
    });

    $('.pro_h_dt_btn_each:not(.disabled) .pro_h_dt_btn_top').click(function(){

        var thiss = $(this).closest('.pro_h_dt_btn_each');
        $('.pro_h_dt_btn_each').removeClass('active');
        $('.pro_h_dt_btn_each .check_each_outer i').addClass('instant_hide');
        thiss.addClass('active');
        thiss.find('i').removeClass('instant_hide');

        $.ajax({

            url: '/user-home-default-tab',
            type: 'POST',
            data: {'data': thiss.attr('data-id')},
            cache: false,
            dataType: 'json',
            success: function (response) {
            }
        });
    });

    $('#search_btn,#top-search-field-res').click(function(){

        window.location.href = '/search';
    });

    // check user logged in n show login box
    var notLoggedIn;

    notLoggedIn = setTimeout(function(){
        if($("#show_not_logged_in").val() == '1' && $('#body-overlay').css('display') != 'block' && $('#has_free_sub').length && $('#has_free_sub').val() == '1'){
            $("#not_logged_in, #body-overlay").show();
        }
    }, 120000);





    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });

    $('body').delegate('.each_usr_notif_item', 'click', function(e){

        var link = $(this).attr('data-link');
        if(link != ''){

            window.location.href = link;
        }
    });

    $('body').delegate('.user_follow_outer:not(.disabled)', 'click', function(e){

        if($(this).hasClass('unauth')){
            $('#not_logged_in,#body-overlay').show();
        }else{
            loadMyDeferredImages($("#user-follow-popup img.prevent_pre_loading"));
            $('#user-follow-popup,#body-overlay').show();
        }
    });

    $('#user-follow-popup #follow_login_submit').click(function(){

        var email = $('#user-follow-popup #follow_login_email').val();
        var password = $('#user-follow-popup #follow_login_password').val();

        if(email != '' && password != ''){

            $('#user-follow-popup .follow_authenticator .error_span').addClass('instant_hide');
            $.ajax({

                url: '/user-follow-login',
                type: 'POST',
                data: {'email': email, 'password': password},
                cache: false,
                dataType: 'json',
                success: function (response) {

                    if(response.success == 1){
                        $('#user-follow-popup .follow_authenticator').addClass('instant_hide');
                        $('#user-follow-popup .follow_go_ahead').removeClass('instant_hide');
                    }else{
                        $('#user-follow-popup .follow_authenticator .error_span').text(response.errorMessage).removeClass('instant_hide');
                    }
                }
            });
        }
    });

    $('.each_past_project').click(function(){

        var link = $(this).attr('data-link');
        window.location.href = link;
    });

    $('#follow_submit').click(function(){

        var message = $('#user-follow-popup #follow_message').val();
        $('#user-follow-popup .follow_go_ahead .error_span').addClass('instant_hide');
        $.ajax({

            url: '/user-follow',
            type: 'POST',
            data: {'user': window.currentUserId, 'message': message},
            cache: false,
            dataType: 'json',
            success: function (response) {

                if(response.success == 1){
                    $('#body-overlay,#user-follow-popup').hide();
                    $('#user-follow-popup #follow_message').val('');
                    $('.user_follow_btn .user_follow_inner').text('Following');
                }else{
                    $('#user-follow-popup .follow_go_ahead .error_span').text(response.errorMessage).removeClass('instant_hide');
                }
            }
        });
    });

    $('body').delegate('.notif_item,#notif_icon_resp', 'click', function(e){

        var formData = new FormData();
        formData.append('mode', 'update');
        $.ajax({

            url: '/update-user-notifications',
            dataType: "json",
            type: 'post',
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function(response) {
                if(response.success == 1){

                    $('#notif_count_res,#notif_count').text('').removeClass('notif_counter_ok');
                    $('.user_notif_item_status .noti_status_new').removeClass('noti_status_new').addClass('noti_status_seen').text('Seen');
                }else{
                    alert(data.error);
                }
            }
        });
    });

    $('.each_user_following').click(function(e){

        window.location.href = $(this).attr('data-href');
    });

    $('#go_live_project').click(function(){

        $('#pro_confirm_go_live,#body-overlay').show();
    });

    $('#pro_go_live_confirm').click(function(){

        $('#go_live').val('1');
        $("#profile_tab_05 .pay_btm_btn_outer #save_project").trigger('click');
    });

    $('.trig_click').click(function(){

        var targetId = $(this).data('target-id');

        $("html, body").animate({scrollTop: $('.each_tab_btn[data-show="#'+targetId+'"]').offset().top - 80}, 1500, function(){
            $('.each_tab_btn[data-show="#'+targetId+'"]').trigger('click');
        });
    });

    $('body').delegate('.support_instant a', 'click', function(e){

        e.preventDefault();
        var browseWidth = $( window ).width();
        if($('div[data-show="#tabd2"]').length){
            $('div[data-show="#tabd2"]').trigger('click');
        }
    });

    $('.tab_btns_outer,.tv_tab_btns_outer').delegate( ".each_tab_btn:not(.true_active):not(.disabled)", "mouseenter", function(e){

        $(this).addClass('active').find('.border').show();
    });

    $('.tab_btns_outer,.tv_tab_btns_outer').delegate( ".each_tab_btn:not(.true_active):not(.disabled)", "mouseleave", function(e){

        $(this).removeClass('active').find('.border').hide();
    });

    $('.user_short_hand_tab').delegate( ".user_short_tab_each:not(.true_active):not(.disabled)", "mouseenter", function(e){

        $(this).addClass('active');
    });

    $('.user_short_hand_tab').delegate( ".user_short_tab_each:not(.true_active):not(.disabled)", "mouseleave", function(e){

        $(this).removeClass('active');
    });

    $('.user_short_hand_tab').delegate( ".user_short_tab_each:not(.true_active):not(.disabled)", "click", function(e){

        var thiss = $(this);
        var id = thiss.attr('data-target-id');
        if(browserWidth <= 767){
            var tab = '#tabd';
            var scrollTo = $(".ch_tab_sec_outer.mobile-only").offset().top - 60;
        }else{
            var tab = '#tabd';
            var scrollTo = $(".top_info_box").offset().top - 60;
        }
        $('.each_tab_btn[data-show="'+tab+id+'"]').trigger('click');
        $("html, body").animate({scrollTop: scrollTo}, "slow");
    });

    $('.tab_btns_alt_outer').delegate( ".each_tab_alt_btn:not(.true_active):not(.disabled)", "click", function(e){

        var thiss = $(this);
        var id = thiss.attr('data-target-id');
        if(browserWidth <= 767){
            var tab = '#tabd';
            var scrollTo = $(".ch_tab_sec_outer.mobile-only").offset().top - 60;
        }else{
            var tab = '#tabd';
            var scrollTo = $(".top_info_box").offset().top - 60;
        }
        $('.each_tab_btn[data-show="'+tab+id+'"]').trigger('click');
        $("html, body").animate({scrollTop: scrollTo}, "slow");
    });

    $(window).scroll(function() {
        if($(this).scrollTop() > 500){
            $('.tab_btns_alt_outer').addClass('animate');
        }else{
            $('.tab_btns_alt_outer').removeClass('animate');
        }
    });

    $('.tv_slide_out_outer #tv_slide_continue').click(function(){

        $('.tv_slide_out_outer').toggleClass('active');
        $('body').toggleClass('lock_page');
        $('#body-overlay').toggle();
    });

    $('#news_nav_next').click(function(){

        var next = $('.news_updates_outer').find('.news_update_each:visible:first').next();
        if(next && next.hasClass('news_update_each')){
            $('.news_updates_outer').find('.news_update_each:visible:first').fadeOut('slow', function(){

                next.fadeIn('fast').css('display', 'flex');
            });
        }else{

            $('.news_updates_outer').find('.news_update_each:visible:first').fadeOut('slow', function(){

                $('.news_updates_outer .news_update_each:first').fadeIn('fast').css('display', 'flex');
            });
        }

    });
    $('#news_nav_back').click(function(){

        var prev = $('.news_updates_outer').find('.news_update_each:visible:first').prev();
        if(prev && prev.hasClass('news_update_each')){
            $('.news_updates_outer').find('.news_update_each:visible:first').fadeOut('slow', function(){

                prev.fadeIn('fast').css('display', 'flex');
            });
        }else{

            $('.news_updates_outer').find('.news_update_each:visible:first').fadeOut('slow', function(){

                $('.news_updates_outer .news_update_each:last').fadeIn('fast').css('display', 'flex');
            });
        }

    });

    $('.news_update_link i,.news_update_link span').click(function(){

    var id = $(this).closest('.news_update_link').attr('data-id');
    if(browserWidth <= 767){
    var tab = '#tab';
    var scrollTo = $(".ch_tab_sec_outer.mobile-only").offset().top - 60;
    }else{
    var tab = '#tabd';
    var scrollTo = $(".top_info_box").offset().top - 60;
    }
        $('.each_tab_btn[data-show="'+tab+id+'"]').trigger('click');
    $("html, body").animate({scrollTop: scrollTo}, "slow");
    });

    $('.tab_btns_outer,.tv_tab_btns_outer').delegate( ".each_tab_btn:not(.true_active):not(.disabled)", "click", function(e){

        var thiss = $(this);
        var browserWidth = $( window ).width();
        var mainTabUserId = window.currentUserId;
        var showTabContent = thiss.attr('data-show');
        var pageUrl = window.location.href;

        if(showTabContent != ''){

            if(mainTabUserId){

                $('.user_short_tab_each,.each_tab_alt_btn').removeClass('true_active active');
                $('.user_short_tab_each[data-target-id="'+showTabContent[showTabContent.length -1]+'"],.each_tab_alt_btn[data-target-id="'+showTabContent[showTabContent.length -1]+'"]').addClass('true_active');
                $('.tab_btns_outer .each_tab_btn').removeClass('true_active').removeClass('active').find('.border').hide();
                thiss.parent().parent().find('.ch_tab_det_sec').addClass('instant_hide');
                thiss.addClass('true_active').find('.border').show();
                $(showTabContent).removeClass('instant_hide');

                if($(this).parent().hasClass('tab_dsk')){

                    $('.tab_det_left_sec.tab_det_dsk').find('.lazy_tab_img').show();
                }else{

                    $('.tab_det_left_sec:not(.tab_det_dsk)').find('.lazy_tab_img').show();
                }

                if(pageUrl.indexOf('singingexperience.co.uk') !== -1 || pageUrl.indexOf('/se') !== -1){

                    if(showTabContent == '#tabd1' || showTabContent == '#tabd2' || showTabContent == '#tabd3' || showTabContent == '#tabd4' || showTabContent == '#tabd5'){

                        $('.tab_det_inner').addClass('expanded leave').removeClass('pro10');
                    }else if(showTabContent == '#tabd6'){

                        $('.tab_det_inner').addClass('pro10').removeClass('expanded leave');
                    }
                }

                if(showTabContent == '#tabd4' || showTabContent == '#tab4'){

                    $(showTabContent+' .lazy_tab_content').html('');

                    $.ajax({

                        url: '/loadMyRequestData',
                        type: 'POST',
                        data: {'load_type': 'social', 'load': mainTabUserId},
                        cache: false,
                        dataType: 'html',
                        success: function (response) {

                            $(showTabContent+' .lazy_tab_content').html(response);
                            if($('#twitter-feed1').length){
                                $.getScript('https://platform.twitter.com/widgets.js', function() {
                                    $('#twitter-feed1').html('<a class="twitter-timeline" href="https://twitter.com/cotyso?ref_src=twsrc%5Etfw">Tweets by Cotyso</a>');
                                });
                            }
                            $.getScript('/js/instagram-feed.js?v=1.1', function() {
                                fillSocialTabWithInstagramFeed(mainTabUserId);
                            });
                            $.getScript('/js/spotify-follow-button.js', function() {
                                fillSocialTabWithSpotifyFeed(mainTabUserId);
                            });
                            $.getScript('https://apis.google.com/js/platform.js', function() {
                                $.getScript('/js/youtube-subscribe-button.js?v=1.2', function() {
                                    fillSocialTabWithYoutubeSubscribeButton();
                                });
                            });

                            $('.tab_det_left_sec').find('.lazy_tab_img').hide();
                        }
                    });
                }
                if(showTabContent == '#tabd2' || showTabContent == '#tab2'){

                    $(showTabContent+' .lazy_tab_content').html('');

                    $.ajax({

                        url: '/loadMyRequestData',
                        type: 'POST',
                        data: {'load_type': 'music', 'load': mainTabUserId},
                        cache: false,
                        dataType: 'html',
                        success: function (response) {

                            $(showTabContent+' .lazy_tab_content').html(response);
                            $('.tab_det_left_sec').find('.lazy_tab_img').hide();

                            musicHoverSupport();

                            if (typeof window.autoPlayMusic !== 'undefined' && window.autoPlayMusic && window.autoPlayMusic != '') {
                                autoPlayMyMusic(window.autoPlayMusic);
                            }

                            postUserTabLoaded();
                            return false;
                        }
                    });
                }
                if(showTabContent == '#tabd3' || showTabContent == '#tab3'){

                    $(showTabContent+' .lazy_tab_content').html('');

                    $.ajax({

                        url: '/loadMyRequestData',
                        type: 'POST',
                        data: {'load_type': 'fans', 'load': mainTabUserId},
                        cache: false,
                        dataType: 'html',
                        success: function (response) {

                            $(showTabContent+' .lazy_tab_content').html(response);
                            $('.tab_det_left_sec').find('.lazy_tab_img').hide();
                            return false;
                        }
                    });
                }
                if(showTabContent == '#tabd1' || showTabContent == '#tab1'){

                    $(showTabContent+' .lazy_tab_content').html('');

                    $.ajax({

                        url: '/loadMyRequestData',
                        type: 'POST',
                        data: {'load_type': 'bio', 'load': mainTabUserId},
                        cache: false,
                        dataType: 'html',
                        success: function (response) {

                            $(showTabContent+' .lazy_tab_content').html(response);
                            $('.tab_det_left_sec').find('.lazy_tab_img').hide();

                            setTimeout(function(){

                                loadMyDeferredImages($(showTabContent+' .defer_loading'));
                            }, 3000);

                            return false;
                        }
                    });
                }
                if(showTabContent == '#tabd5' || showTabContent == '#tab5'){

                    $(showTabContent+' .lazy_tab_content').html('');

                    $.ajax({

                        url: '/loadMyRequestData',
                        type: 'POST',
                        data: {'load_type': 'video', 'load': mainTabUserId},
                        cache: false,
                        dataType: 'html',
                        success: function (response) {

                            $(showTabContent+' .lazy_tab_content').html(response);
                            $('.tab_det_left_sec').find('.lazy_tab_img').hide();

                            if(thiss.hasClass('tab_btn_video')){
                                var videoId = thiss.attr('data-video-id');
                                if(typeof videoId !== typeof undefined && videoId !== false && videoId != ''){

                                    mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v='+videoId, mediaInstance, 1);
                                    $('.mejs__container').removeClass('instant_hide');
                                    $('.content_outer').addClass('playing');

                                    if( browserWidth <= 767 ) {
                                        $("html, body").animate({scrollTop: $("body").offset().top}, "slow");
                                    }else{
                                        $("html, body").animate({scrollTop: $(".top_info_box").offset().top - 59}, 'slow');
                                    }
                                }
                            }

                            setTimeout(function(){

                                loadMyDeferredImages($(showTabContent+' .defer_loading'));
                            }, 3000);

                            return false;
                        }
                    });
                }
                if(showTabContent == '#tabd6' || showTabContent == '#tab6'){

                    $(showTabContent+' .lazy_tab_content').html('');

                    $.ajax({

                        url: '/loadMyRequestData',
                        type: 'POST',
                        data: {'load_type': 'products', 'load': mainTabUserId},
                        cache: false,
                        dataType: 'html',
                        success: function (response) {

                            $(showTabContent+' .lazy_tab_content').html(response);
                            $('.tab_det_left_sec').find('.lazy_tab_img').hide();
                            productOfferCountdown(proOfferTimerInstance);
                            setTimeout(function(){

                                loadMyDeferredImages($(showTabContent+' .defer_loading'));
                            }, 3000);
                            return false;
                        }
                    });
                }
            }
        }else{

            if(thiss.hasClass('fly_user_home')){
                window.location.href = $("#base_url").val() +thiss.attr('data-initials');
            }

            if(thiss.hasClass('tab_btn_info')){
                var videoId = $(this).attr('data-video-id');
                if(typeof videoId !== typeof undefined && videoId !== false && videoId != ''){

                    if( browserWidth <= 767 ) {
                        $("html, body").animate({scrollTop: $("body").offset().top - 50}, "slow");
                    }else{
                        $("html, body").animate({scrollTop: $("body").offset().top}, "slow");
                    }
                    mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v='+videoId, mediaInstance, 1);
                }
            }

            if(thiss.hasClass('tab_btn_tv')){

                var imgDefer = $('.tv_slide_out_outer img.lazy_loading');
                for (var i=0; i<imgDefer.length; i++) {
                    if(imgDefer[i].getAttribute('data-src')) {
                        imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
                    }
                }
                $('.tv_slide_out_outer').toggleClass('active');
                $('body').toggleClass('lock_page');
                $('#body-overlay').toggle();
            }
        }

    });


    $('body').delegate('#offer_guide', 'click', function(e){

        var videoId = $(this).attr('data-video-id');
        if(typeof videoId !== typeof undefined && videoId !== false && videoId != ''){

            mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v='+videoId, mediaInstance, 1);

            $('.mejs__container').removeClass('instant_hide');
            $('.content_outer').addClass('playing');

            if( browserWidth <= 767 ) {
                $("html, body").animate({scrollTop: $("body").offset().top}, "slow");
            }else{
                $("html, body").animate({scrollTop: $(".top_info_box").offset().top - 59}, "slow");
            }
        }
    });

    $('.tp_sec_play_project,.top_info_outer').click(function(){

        var videoId = $(this).attr('data-video-id');
        if(typeof videoId !== typeof undefined && videoId !== false && videoId != ''){

            mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v='+videoId, mediaInstance, 1);
            $('.mejs__container').removeClass('instant_hide');
            $('.content_outer').addClass('playing');

            if( browserWidth <= 767 ) {
                $("html, body").animate({scrollTop: $("body").offset().top - 50}, "slow");
            }else{
                $("html, body").animate({scrollTop: $(".top_info_box").offset().top - 59}, "slow");
            }
        }
    });



    $('a[href="#tab2"]').on("click", function(e){

        if( browserWidth <= 767 ) {

            $("a[href='#tab2']").addClass('tab_active');

            $("html, body").animate({scrollTop: $(this).parent().parent().parent().offset().top - 50}, 1000);

        }

        return (false);

    });



    $('a[href="#tab3"]').on("click", function(e){

        if( browserWidth <= 767 ) {

            $("a[href='#tab3']").addClass('tab_active');

            $("html, body").animate({scrollTop: $(this).parent().parent().parent().offset().top - 50}, 1000);

        }

        return (false);

    });



    $('a[href="#tab4"]').on("click", function(e){

        if( browserWidth <= 767 ) {

            $(".a[href='#tab4']").addClass('tab_active');

            $("html, body").animate({scrollTop: $(this).parent().parent().parent().offset().top - 50}, 1000);

        }

        return (false);

    });





    $('body').delegate( ".play_btm_user_goal", "click", function(e){

        window.location.href = $("#base_url").val() + "project/" + window.currentUserId;

    });



    $('body').delegate( "#basket_icon_vid", "click", function(e){

        var browserWidth = $( window ).width();

        if( browserWidth > 767 ) {

            var projectVideo = $("#project_video").val();

            if (projectVideo != "") {

                mediaInstance = playMediaElementVideo(0, projectVideo, mediaInstance, 1);

            }

        } else {

            $(".tab_btns_outer a").removeClass("tab_active");

            $("a[href='#tab2']").addClass('tab_active');

            $(".ch_tab_det_sec").hide();

            $("#tab2").show();

        }

    });





    $('body').delegate( ".user_home_link", "click", function(e){

        var userHomeLink = $("#user_project_share_link").val();

        window.location.href = userHomeLink;

    });



    $(".r_tab_btns_outer a").click(function(){

        $(".r_tab_btns_outer a").removeClass("tab_active");

        $(this).addClass("tab_active");



        var this_id = $(this).attr("href");

        $(".r_tab_det").hide();

        $(this_id).show();

        return (false);



    });








    $(".search_res_btn,#header-search-input,.hdr_search_outer").click(function(e){

        e.preventDefault();

        window.location.href = '/search';
        //$('#search_popup,#body-overlay').show();
    });



    $('body').delegate( ".ch_select_perch_options select", "change", function(e){

        var abc = $(this).val();

        $(this).parent().find("span").text(abc);

    });












    /********   profile_ page   ************/



    $(".pro_select_outer text").click(function(){

        $(".pro_select_outer text").removeClass("pro_gander_active");

        $(this).addClass("pro_gander_active");





    });

    $('body').delegate( ".add_to_album_create_outer", "click", function(e){

        var This = $(this);

        $.post( "/albumsList" , { }, function(data) {



            $(".add_to_album_add_music").slideToggle(500);

            This.toggleClass("drop_down");

            $(".albums_list").html(data);



        });

    });



    $('body').delegate( ".add_to_album_create_inner", "click", function(e){

        $(".add_to_album_create_drop").slideToggle(500);

        $(this).toggleClass("drop_down");

        return (false);

    });



    $('body').delegate( ".add_to_album_edit_dropdown_outer", "click", function(e){

        var This = $(this);

        var music_id = this.dataset.musicid;

        $.post( "/albumsList" , { music_id: music_id }, function(data) {



            $(".add_to_album_edit_drop_outer_" + music_id).slideToggle(500);

            This.toggleClass("drop_down");

            $(".albums_list_edit_" + music_id).html(data);



        });

    });



    $('body').delegate( ".add_to_album_edit_inner", "click", function(e){

        $(".add_to_album_edit_drop").slideToggle(500);

        $(this).toggleClass("drop_down");

        return (false);

    });



    $('body').delegate( ".add_to_album_button", "click", function(e){



        var status = this.dataset.status;

        if(status == "create") {

            var musicId = 0;

            var album_title = $("#album_title").val();

            var album_price = $("#album_price").val();

        } else {

            var musicId = this.dataset.musicid;

            var album_title = $("#album_title_" + musicId).val();

            var album_price = $("#album_price_" + musicId).val();

        }



        $.post( "/addEditToAlbum" , { album_title: album_title, album_price: album_price, music_id: musicId, status: status }, function(data) {



            //location.reload();

            if(data) {

                if(status == "create") {

                    $(".add_to_album_outer").html(data);

                } else {

                    $(".add_to_album_edit_outer_" + musicId).html(data);

                }

            }

        });



    });



    $('body').delegate( ".edit_album_button", "click", function(e){



        var album_id = this.dataset.albumid;

        var status = this.dataset.status;

        if(status == "create") {

            var musicId = 0;

            var album_title = $("#album_title_" + album_id).val();

            var album_price = $("#album_price_" + album_id).val();

        } else {

            var musicId = this.dataset.musicid;

            var album_title = $("#album_title_edit_" + album_id + "_" + musicId).val();

            var album_price = $("#album_price_edit_" + album_id + "_" + musicId).val();

            //alert(musicId + "/" + album_id + "/" + album_title + "/" + album_price + "/" + status)

        }



        $.post( "/addEditToAlbum" , { album_title: album_title, album_price: album_price, album_id: album_id, status: status, music_id: musicId }, function(data) {



            //location.reload();

            if(data) {

                if(status == "create") {

                    $(".add_to_album_outer").html(data);

                } else {

                    $(".add_to_album_edit_outer_" + musicId).html(data);

                }

            }

        });

    });






    $(".music_sec_opt_outer select").change(function(){

        var abc = $(this).find("option:selected").text();

        $(this).parent().find("span").text(abc);



    });

    $(".pro_m_chech_outer #full_ownership").click(function(){

        $(this).removeClass('m_check_error');

        $(this). toggleClass("m_chech_active");

        $("#is_full_ownership").val("0");

        if($(this).hasClass("m_chech_active")){

            $("#is_full_ownership").val("1");

        }

    });

    $('.new_popup_check_out').click(function(){

        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('input.new_popup_check').val('0');
        }else{
            $(this).addClass('active');
            $(this).find('input.new_popup_check').val('1');
        }
    });

    $(".pro_m_chech_outer .bespoke_license_offer").click(function(){

        $(this).removeClass('m_check_error');

        $(this).toggleClass("m_chech_active");

        $(this).parent().parent().find('.allow_bespoke_license_offer').val("0");

        if($(this).hasClass("m_chech_active")){

            $(this).parent().parent().find('.allow_bespoke_license_offer').val("1");

        }

    });

    $(".pro_m_chech_outer #licenses_perpetual").click(function(){

        $(this).removeClass('m_check_error');

        $(this). toggleClass("m_chech_active");

        $("#use_of_licenses_perpetual").val("0");

        if($(this).hasClass("m_chech_active")){

            $("#use_of_licenses_perpetual").val("1");

        }

    });

    $(".pro_m_chech_outer .full_ownership").click(function(){

        $(this). toggleClass("m_chech_active");

        var id = this.dataset.musicid;

        $("#is_full_ownership_" + id).val("0");

        if($(this).hasClass("m_chech_active")){

            $("#is_full_ownership_" + id).val("1");

        }

    });

    $(".pro_m_chech_outer .lisence_perpetual").click(function(){

        $(this). toggleClass("m_chech_active");

        var id = this.dataset.musicid;

        $("#use_of_licenses_perpetual_" + id).val("0");

        if($(this).hasClass("m_chech_active")){

            $("#use_of_licenses_perpetual_" + id).val("1");

        }

    });



    /*********          10/10/17          ****************************************/



    $(".select_outer select").change(function() {

        var aaabbb = $(this).find("option:selected").text();



        $(this).parent().find("span").text(aaabbb);

    });

    /************************************************************************************/


    $('#profile_tab_01 .pro_def_seo_btn_outer .save_profile_outer').click(function(e){

        e.preventDefault();
        var thiss = $(this);
        var error = 0;

        var form = thiss.parent().find('form');
        form.submit();
    });

    $('#profile_tab_01 .save_profile_outer').click(function(e){

        e.preventDefault();
        var thiss = $(this);
        var error = 0;

        $('#profile_tab_01 input').parent().parent().removeClass('error_field');
        $('#profile_tab_01 select').parent().parent().removeClass('error_field');

        var form = thiss.parent().find('form');
        var countryName = $('#profile_tab_01 input[name=cou_id]');
        var cityName = $('#profile_tab_01 input[name=cit_id]');
        var name = $('#profile_tab_01 input[name=name]');
        var firstName = $('#profile_tab_01 input[name=first_name]');
        var surname = $('#profile_tab_01 input[name=surname]');
        var address= $('#profile_tab_01 input[name=address]');
        var postcode = $('#profile_tab_01 input[name=postcode]');
        var genre = $('#profile_tab_01 select[name=genre_id]');
        var level = $('#profile_tab_01 select[name=level]');
        var skill = $('#profile_tab_01 select[name=skill]');
        var currency = $('#profile_tab_01 select[name=default_currency]');


        if(thiss.parent().attr('id') == 'personal_section'){

            if($('#profile_image').val() == ''){

                if( name.length && name.val() == '' ){ error = 1; name.parent().parent().addClass('error_field'); }
                if( firstName.val() == '' ){ error = 1; firstName.parent().parent().addClass('error_field'); }
                if( surname.val() == '' ){ error = 1; surname.parent().parent().addClass('error_field'); }

                if(countryName.val() == ''){

                    $('#profile_tab_01 input[name=country_id]').val('');
                }
                if(cityName.val() == ''){

                    $('#profile_tab_01 input[name=city_id]').val('');
                }
                var country = $('#profile_tab_01 input[name=country_id]');
                var city = $('#profile_tab_01 input[name=city_id]');
                if( country.val() == '' ){ error = 1; country.parent().parent().addClass('error_field'); }
                if( city.val() == '' ){ error = 1; city.parent().parent().addClass('error_field'); }
            }
        }
        if(thiss.parent().hasClass('musical_detail')){

            if( level.val() == '' ){ error = 1; level.parent().parent().addClass('error_field'); }
            if( skill.val() == '' ){ error = 1; skill.parent().parent().addClass('error_field'); }
            if( currency.length && currency.val() == '' ){ error = 1; currency.parent().parent().addClass('error_field'); }

            var instruments = '';
            if($('#further_skills_results .profile_custom_drop_each').length){

                $('#further_skills_results .profile_custom_drop_each').each(function(){

                    instruments += $(this).find('.profile_custom_drop_title').text() + ',';
                });
            }
            $('input[name="further_skills"]').val(instruments);
        }

        if(thiss.parent().attr('id') == 'bio_section'){

            var storyImages = form.find('.upload-demo.ready');
            var storyText = $('#bio_section .user_bio_area').html();
            var formData = new FormData();

            formData.append('story_text', storyText);
            if(storyImages.length){
                storyImages.each(function(index){
                    var id = $(this).attr('data-id');
                    $uploadCrop[id].croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                    }).then(function (resp) {

                        formData.append(id, resp);
                        if(!storyImages.eq(index + 1).length){
                            $('#pro_uploading_in_progress_real,#body-overlay').show();
                            $.ajax({

                                url: '/uploadProfileStoryImages',
                                type: "POST",
                                data: formData,
                                contentType:false,
                                cache: false,
                                processData: false,
                                success: function(data){

                                    if(window.location.href.indexOf('/quick-setup/') !== -1){
                                        window.location.href = '/quick-setup/website-design';
                                    }else if(window.location.href.indexOf('/profile-setup/') !== -1){
                                        window.location.href = '/profile-setup/portfolio';
                                    }else{
                                        location.reload();
                                    }
                                }
                            });
                        }
                    });
                });
            }else{
                $('#pro_uploading_in_progress_real,#body-overlay').show();
                $.ajax({

                    url: '/uploadProfileStoryImages',
                    type: "POST",
                    data: formData,
                    contentType:false,
                    cache: false,
                    processData: false,
                    success: function(data){

                        if(window.location.href.indexOf('/quick-setup/') !== -1){
                            window.location.href = '/quick-setup/website-design';
                        }else if(window.location.href.indexOf('/profile-setup/') !== -1){
                            window.location.href = '/profile-setup/portfolio';
                        }else{
                            location.reload();
                        }
                    }
                });
            }
        }

        var browserWidth = $( window ).width();

        if( browserWidth <= 767 ) { var margin = 50; }
        else { var margin = 30+44; }

        if( error == 1 ){

            $('html, body').animate({

                scrollTop: (($('#profile_tab_01 .error_field').offset().top) - margin)
            },2000, function(){

                $('.pro_fill_outer').show();
                $('#body-overlay').show();
            });
        }else{

            if(thiss.parent().attr('id') == 'bio_section'){

            }else{

                form.submit();
            }
        }
    });

    $('#profile_tab_14 #contacts_section .upload_now').click(function(e){

        e.preventDefault();
        var thiss = $(this);
        var error = 0;

        $('#profile_tab_14 #contacts_section .pro_stream_input_each.has-danger').removeClass('has-danger');

        var form = thiss.closest('form');
        var name = $('#profile_tab_14 #contacts_section input[name=pro_contact_name]');
        var alreadyUser = $('#profile_tab_14 #contacts_section select[name="pro_contact_already_user"]');
        var alreadyUserEmail = $('#profile_tab_14 #contacts_section input[name="pro_contact_already_user_email"]');

        if( name.val() == '' ){ error = 1; name.closest('.pro_stream_input_each').addClass('has-danger'); }
        if(alreadyUser.val() == '1' && alreadyUserEmail.val() == ''){

            error = 1; alreadyUserEmail.closest('.pro_stream_input_each').addClass('has-danger');
        }

        var browserWidth = $( window ).width();

        if( browserWidth <= 767 ) { var margin = 50; }
        else { var margin = 30+44; }

        if(!error){

            form.submit();
        }
    });

    $('#profile_tab_14 #contacts_section .edit_now,#profile_tab_14 #contacts_section .edit_and_send_agree,#profile_tab_14 #contacts_section .edit_and_send_question').click(function(e){

        e.preventDefault();
        var thiss = $(this);
        var error = 0;
        var form = thiss.closest('form');
        form.find('.has-danger').removeClass('has-danger');
        if($(this).hasClass('edit_and_send_agree')){

            form.find('input[name="send_email"]').val('1');
        }else if($(this).hasClass('edit_and_send_question')){

            form.find('input[name="send_email"]').val('2');
            if(form.find('select[name="pro_contact_questionnaireId"]').val() == ''){
                error = 1;
                form.find('select[name="pro_contact_questionnaireId"]').closest('.pro_stream_input_each').addClass('has-danger');
            }
        }else{

            form.find('input[name="send_email"]').val('0');
        }

        if(!error){
            form.submit();
        }
    });

    $('#profile_tab_02 #videos_section .m_btm_del').click(function(e){



        e.preventDefault();

        var videoId = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', videoId);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-url');

        if( videoId ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });

    $('#profile_tab_02 #edit_music_section .m_btm_right_icons .m_btm_del').click(function(e){



        e.preventDefault();

        var musicId = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', musicId);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-music');

        if( musicId ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });

    $('#profile_tab_01 #services_section .m_btm_right_icons .m_btm_del').click(function(e){



        e.preventDefault();

        var serviceId = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', serviceId);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-service');

        if( serviceId ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });

    $('#profile_tab_01 #portfolio_section .m_btm_right_icons .m_btm_del').click(function(e){



        e.preventDefault();

        var id = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', id);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-port');

        if( id ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });

    $('#profile_tab_02 #live_streams_section .m_btm_right_icons .m_btm_del').click(function(e){



        e.preventDefault();

        var id = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', id);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-stream');

        if( id ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });

    $('#profile_tab_02 #my_albums_section .m_btm_right_icons .m_btm_del').click(function(e){



        e.preventDefault();

        var id = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', id);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-album');

        if( id ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });

    $('#profile_tab_02 #my_products_section .pro_prod_outer .m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('#profile_tab_02 #my_products_section form[data-id="prod_gig_form_'+id+'"]').show();
    });

    $('#profile_tab_01 #services_section .m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('#profile_tab_01 #services_section form[data-id="my-service-form_'+id+'"]').show();
    });

    $('#profile_tab_02 #edit_music_section .m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('#profile_tab_02 #edit_music_section form[data-id="my-music-form_'+id+'"]').show();
    });

    $('#profile_tab_01 #portfolio_section .m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('#profile_tab_01 #portfolio_section form[data-id="u_port_form_'+id+'"]').show();
    });

    $('#profile_tab_14 #contacts_section .m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('#profile_tab_14 #contacts_section form[data-id="u_contact_form_'+id+'"]').show();
    });

    $('#profile_tab_02 #live_streams_section .m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('#profile_tab_02 #live_streams_section form[data-id="my-stream-form_'+id+'"]').show();
    });

    $('#profile_tab_02 #my_albums_section .m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('#profile_tab_02 #my_albums_section form[data-id="my-album-form_'+id+'"]').show();
    });

    $('#profile_tab_02 #news_section .m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('#profile_tab_02 #news_section form[data-id="my-news-form_'+id+'"]').show();
    });

    $('#profile_tab_14 #contacts_section .m_btm_right_icons .m_btm_view').click(function(e){

        var id = $(this).attr('data-id');
        if(id != ''){

            if($(this).attr('data-open') == 'blank'){

                window.open(id,'_blank');
            }else{
                window.location = id;
            }
        }
    });

    $('#profile_tab_14 #contacts_section .m_btm_right_icons .m_btm_switch_account').click(function(e){

        var id = $(this).attr('data-id');
        $('#switch_account_popup').attr('data-id', id);
        $('#switch_account_popup,#body-overlay').show();
    });

    $('#proceed_switch_account').click(function(e){

        var id = $('#switch_account_popup').attr('data-id');
        window.location = id;
    });

    $('#profile_tab_02 #my_products_section .pro_prod_outer .m_btm_del').click(function(e){



        e.preventDefault();

        var productId = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', productId);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-product');

        if( productId ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });

    $('#profile_tab_14 #contacts_section .m_btm_del').click(function(e){



        e.preventDefault();

        var id = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', id);

        if($(this).closest('.music_btm_list').hasClass('agent_contact_listing')){

            $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'agent-contact');
        }else if($(this).closest('.music_btm_list').hasClass('agent_contact_request_listing')){

            $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'agent-contact-request');
        }

        if( id ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });

    $('#profile_tab_02 #news_section .m_btm_del').click(function(e){



        e.preventDefault();

        var Id = $(this).attr('data-del-id');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', Id);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-news');

        if( Id ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });



    $('body').delegate( ".delete_album_button", "click", function(e){

        e.preventDefault();

        var albumId = this.dataset.albumid;

        var templateStatus = this.dataset.tempaltestatus;

        var albumMusicId = this.dataset.musicid;

        //alert(templateStatus + "/" + albumMusicId);



        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', albumId);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-album');

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-album-status', templateStatus);

        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-album-music-id', albumMusicId);



        if( albumId ){



            $('.pro_confirm_delete_outer').show();

            $('#body-overlay').show();

        }

    });


    $('body').delegate( ".pro_confirm_delete_outer #pro_delete_submit_yes", "click", function(e){

        e.preventDefault();



        var deleteId = $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id');

        var deleteItemType = $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type');



        if( deleteId && deleteItemType == 'user-url' ){



            $.post( "/deleteUserCompetitionVideo" , { video_id: deleteId }, function(data) {



                location.reload();

            });

        }else if( deleteId && deleteItemType == 'user-music' ){



            $.post( "/deleteYourMusic" , { id: deleteId }, function(data) {



                location.reload();

            });

        }else if( deleteId && deleteItemType == 'user-product' ){



            $.post( "/deleteYourProduct" , { id: deleteId }, function(data) {



                location.reload();

            });

        }else if( deleteId && deleteItemType == 'user-bonus' ){



            $.post( "/deleteYourBonus" , { id: deleteId, campaign_id: $("#user_campaign_id").val() }, function(data) {

                $("#all_bonuses_section").html(data);

                $(".pro_soc_top_close").click();

                //location.reload();

            });

        }else if( deleteId && deleteItemType == 'user-stream' ){



            $.post( "/live-stream/delete" , { id: deleteId }, function(data) {

                location.reload();

            });

        }else if( deleteId && deleteItemType == 'user-news' ){



            $.post( "/deleteUserNews" , { id: deleteId }, function(data) {


                window.location.href = "/profile-setup/standalone/news";

            });

        }else if( deleteId && deleteItemType == 'agent-contact' ){

            var formData = new FormData();
            formData.append('id', deleteId);

            $.ajax({

                url: '/agent-contact/deleteYourNetworkContact',
                type: 'POST',
                data: formData,
                contentType:false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (response) {

                    if(response.success){
                        location.reload();
                    }else{
                        alert(response.error);
                    }
                }
            });

        }else if( deleteId && deleteItemType == 'agent-contact-request' ){



            $.post( "/agent-contact-request/delete" , { id: deleteId }, function(data) {



                location.reload();

            });

        }else if( deleteId && deleteItemType == 'user-port' ){



            $.post( "/deleteUserPortfolio" , { id: deleteId }, function(data) {



                location.reload();

            });

        }else if( deleteId && deleteItemType == 'contact-question' ){



            $.post( "/agent-contact/question/delete" , { id: deleteId }, function(data) {



                location.reload();

            });

        }else if( deleteId && deleteItemType == 'user-service' ){



            $.post( "/deleteUserService" , { id: deleteId }, function(data) {

                location.reload();

            });

        }else if( deleteId && deleteItemType == 'user-album' ){



            $.post( "/album/delete" , { id: deleteId }, function(data) {

                location.reload();

            });

        }else if( deleteId && deleteItemType == 'calendar-event' ){



            $.post( "/dashboard/calendar/delete" , { id: deleteId }, function(data) {



                location.reload();

            });

        }

    });

    $('.pro_confirm_delete_outer #pro_confirm_delete_submit_no').click(function(e){



        e.preventDefault();



        $('.pro_confirm_delete_outer').hide();

        $('#body-overlay').hide();

    });






    $("#post_video_submit_yes").click(function () {

        if( $('#terms_agree').is(":checked") ){

            if( $("#enter_video").is(":checked") ){

                $("#showCart").val("1");

                $('#post_user_video_form').submit();

            } else {

                $("#showCart").val("0");

                $('#post_user_video_form').submit();

            }



        } else {

            alert("Please agree terms and conditions.");

        }

    });



    $('#profile_tab_05 #profile_video_form_submit').click(function(e){



        e.preventDefault();

        $('#profile_tab_05 #profile_video_form_submit').parent().removeClass('error_field_02');

        var videoUrl = $('#profile_tab_05 #profile_video_form_submit').parent().find('input[name=video_url]').val().trim();

        var campaignId = $('#profile_tab_05 #profile_video_form_submit').parent().find('input[name=video_url]').attr('data-campaign-id').trim();

        if( videoUrl != '' ){



            $.post( "/postUserProjectVideo" , { video_url: videoUrl, campaign_id: campaignId }, function(data) {



                //location.reload();

                $("#pitch_uploaded_popup,#body-overlay").show();

            });

        }else{



            $('#profile_tab_05 #profile_video_form_submit').parent().addClass('error_field_02');

        }

    });

    $('#profile_tab_02 #news_section .save_news_outer').click(function(e){

        e.preventDefault();

        var thiss = $(this);
        var error = 0;
        var value = thiss.closest('form').find('textarea[name="value"]');
        $('#profile_tab_02 #news_section .has-danger').removeClass('has-danger');

        if(value.val() == ''){

            error = 1;
            value.parent().addClass('has-danger');
        }

        if(!error){
            thiss.closest('form').submit();
            thiss.closest('form').reset();
        }

    });



    $('#profile_tab_01 #user_bio_video_form_submit').click(function(e){

        e.preventDefault();
        $('#profile_tab_01 #user_bio_video_form_submit').parent().removeClass('error_field_02');
        var videoUrl = $('#profile_tab_01 #user_bio_video_form_submit').parent().find('input[name=bio_video_url]').val().trim();
        var profileId = $('#profile_tab_01 #user_bio_video_form_submit').parent().find('input[name=bio_video_url]').attr('data-profile-id').trim();

        $.post( "/postUserBioVideo" , { video_url: videoUrl, profile_id: profileId }, function(data) {

            $("#bio_video_popup,#body-overlay").show();
        });
    });

    $('#profile_tab_02 #live_streams_section .save_live_stream_outer').click(function(e){

        var thiss = $(this);
        var error = 0;
        var url = thiss.closest('form').find('input[name="pro_stream_url"]');
        $('#profile_tab_02 #live_streams_section .has-danger').removeClass('has-danger');

        if(url.val() == ''){

            error = 1;
            url.parent().addClass('has-danger');
        }

        if(!error){

            thiss.closest('form').submit();
        }
    });

    $('#profile_tab_02 #my_albums_section .save_album_outer').click(function(e){

        var thiss = $(this);
        var error = 0;
        var name = thiss.closest('form').find('input[name="pro_album_name"]');
        var price = thiss.closest('form').find('input[name="pro_album_price"]');
        var thumbnail = thiss.closest('form').find('input[name="album_thumb"]');

        $('#profile_tab_02 #my_albums_section .has-danger').removeClass('has-danger');

        if(name.val() == ''){

            error = 1;
            name.parent().addClass('has-danger');
        }
        if(price.val() == ''){

            error = 1;
            price.parent().addClass('has-danger');
        }
        if(!thiss.closest('form').find('input[name="edit"]').length && thumbnail.val() == ''){

            error = 1;
            thumbnail.parent().addClass('has-danger');
            thumbnail.parent().find('.display-album-thumb').addClass('required');
        }

        if(!error){

            $('#body-overlay,#pro_uploading_in_progress_real').show();
            setTimeout(function() {

                thiss.closest('form').submit();
            }, 500);
        }
    });

    $('#profile_tab_02 #videos_section .save_video_outer').click(function(e){

        e.preventDefault();
        var form = $(this).closest('form');

        if(form.length){

            form.find('.has-danger').removeClass('has-danger');
            var error = 0;
            var url = form.find('.video_url');
            var chart = form.find('.video_chart_entry');

            if(url.val() == '') {
                error = 1;
                url.parent().addClass('has-danger');
            }
            if(url.val() != '' && !matchYoutubeUrl(url.val()) && !matchSoundcloudUrl(url.val())){
                error = 1;
                url.parent().addClass('has-danger');
            }
            if(chart.val() == '') {
                //error = 1;
                //chart.closest('.pro_stream_input_each').addClass('has-danger');
            }

            if( error == 1 ){
                return false;
            }else{

                //proceed with form submission
                $('#body-overlay,#pro_uploading_in_progress_real').show();
                setTimeout(function() {
                    form.submit();
                }, 500);
            }
        }

    });

    $('#profile_tab_02 #my_products_section .save_product_outer').click(function(e){

        e.preventDefault();

        var form = $(this).closest('form');

        if(form.length){

            form.find('.has-danger').removeClass('has-danger');

            var error = 0;

            var name = form.find('.product_title');

            var price = form.find('.product_price');

            var priceOption = form.find('.pro_product_price_option');

            var shippingOption = form.find('.pro_product_shipping_option');

            var ticketOption = form.find('.pro_product_ticket_option');

            var ticketTime = form.find('.product_ticket_date_time');

            var ticketLocation = form.find('.product_ticket_location');

            var localDelivery = form.find('.local_delivery');

            var specialOfferPrice = form.find('.product_timer_price');

            var specialOfferStartDateTime = form.find('.product_timer_start_date_time');

            var specialOfferEndDateTime = form.find('.product_timer_end_date_time');

            var specialOfferTimezone = form.find('.product_timer_timezone');

            var intDelivery = form.find('.international_shipping');

            if(name.val() == ''){ error = 1; name.closest('.pro_stream_input_each').addClass('has-danger'); }

            if(priceOption.val() == 'addprice' && price.val() == ''){
                error = 1;
                price.closest('.pro_stream_input_each').addClass('has-danger');
            }else if(priceOption.val() == ''){
                error = 1;
                priceOption.closest('.pro_stream_input_each').addClass('has-danger');
            }

            if(shippingOption.val() == 'yes' && (localDelivery.val() == '' || intDelivery.val() == '')){
                error = 1;
                if(localDelivery.val() == ''){
                    localDelivery.closest('.pro_stream_input_each').addClass('has-danger');
                }
                if(intDelivery.val() == ''){
                    intDelivery.closest('.pro_stream_input_each').addClass('has-danger');
                }
            }else if(shippingOption.val() == ''){
                error = 1;
                shippingOption.closest('.pro_stream_input_each').addClass('has-danger');
            }

            if(ticketOption.val() == 'yes' && (ticketLocation.val() == '' || ticketTime.val() == '')){
                error = 1;
                if(ticketLocation.val() == ''){
                    ticketLocation.closest('.pro_stream_input_each').addClass('has-danger');
                }
                if(ticketTime.val() == ''){
                    ticketTime.closest('.pro_stream_input_each').addClass('has-danger');
                }
            }else if(ticketOption.val() == ''){
                error = 1;
                ticketOption.closest('.pro_stream_input_each').addClass('has-danger');
            }

            if(specialOfferPrice.length){

                if(specialOfferPrice.val() != ''){
                    if(specialOfferStartDateTime.val() == ''){
                        error = 1;
                        specialOfferStartDateTime.closest('.pro_stream_input_each').addClass('has-danger');
                    }
                    if(specialOfferEndDateTime.val() == ''){
                        error = 1;
                        specialOfferEndDateTime.closest('.pro_stream_input_each').addClass('has-danger');
                    }
                    if(specialOfferTimezone.val() == ''){
                        error = 1;
                        specialOfferTimezone.closest('.pro_stream_input_each').addClass('has-danger');
                    }
                }
            }

            var browserWidth = $( window ).width();

            if( browserWidth <= 767 ) { var margin = 110; }

            else { var margin = 70; }

            if( error == 1 ){

                $('html, body').animate({

                    scrollTop: form.find('.has-danger:first').offset().top - margin

                },1000);
                return false;
            }else{

                //proceed with form submission
                $('#body-overlay,#pro_uploading_in_progress_real').show();
                setTimeout(function() {

                    form.submit();
                }, 500);
            }
        }

    });

    $('#profile_tab_02 #my_albums_section .m_btm_star').click(function(e){

        var id = $(this).attr('data-album-id');
        var elem = $(this);
        if( id ){

            $.post('/album/feature' , { id: id }, function(data) {
                if(data.error == ''){
                    if(elem.hasClass('active')){
                        elem.removeClass('active');
                    }else{
                        elem.addClass('active');
                    }
                }else{
                    console.log(data);
                }

            });
        }
    });

    $('#profile_tab_02 #news_section .m_btm_star').click(function(e){



        var Id = $(this).attr('data-news-id');

        var elem = $(this);

        if( Id ){



            $.post( "/userNewsFeature" , { id: Id }, function(data) {

                if(data.error == ""){

                    if(elem.hasClass("active")){

                        elem.removeClass("active");
                    }else{

                        elem.addClass("active");
                    }

                }else{

                    console.log(data);
                }

            });

        }

    });



    $('#profile_tab_02 #my_products_section .pro_prod_outer .m_btm_star').click(function(e){



        var productId = $(this).attr('data-product-id');

        var elem = $(this);

        if( productId ){



            $.post( "/starMyProduct" , { product_id: productId }, function(data) {



                if(data.error == "You have reached maximum limit of 5"){

                    $("#star_your_music_prod_popup,#body-overlay").show();

                } else if(data.error == ""){

                    if(elem.hasClass("active")){

                        elem.removeClass("active");

                    } else{

                        elem.addClass("active");

                    }

                } else{

                    console.log(data.error);

                }

            });

        }

    });



    $('#profile_tab_02 #edit_music_section .m_btm_right_icons .m_btm_star').click(function(e){



        var musicId = $(this).attr('data-music-id');

        var elem = $(this);

        if( musicId ){



            $.post( "/starMyMusic" , { music_id: musicId }, function(data) {



                if(data.error == "You have reached maximum limit of 5"){

                    $("#star_your_music_prod_popup,#body-overlay").show();

                } else if(data.error == "") {



                    if(elem.hasClass("active")){

                        elem.removeClass("active")

                    } else {

                        elem.addClass("active")

                    }



                } else {

                    console.log(data.error);

                }



            });

        }

    });

    $('body').delegate('.product_poa', 'click', function(e){

        $('#body-overlay,#chat_message_popup').show();
    });

    $('#profile_tab_02 #add_music_section .save_music_outer,#profile_tab_02 #edit_music_section .save_music_outer').click(function(e){

        //alert(this.dataset.musicid)

        var error = 0;

        var message = '<span class="head">You have the following errors:</span>';



        var musicContainer = $(this).closest('form');

        var musicName = musicContainer.find('input[name=song_name]').val();

        var fullOwnerShip = musicContainer.find('#full_ownership');

        var agreeTC = musicContainer.find('#licenses_perpetual');

        var file = musicContainer.find('.music-file').val();

        var musicFileTypeArray = file.split(".");

        var instruments = musicContainer.find('.music_instruments_saved .profile_custom_drop_each');

        var genre = musicContainer.find('select[name="dropdown_one"]').val();

        var mood = musicContainer.find('select[name="dropdown_two"]').val();

        var musicFileType = musicFileTypeArray[musicFileTypeArray.length - 1];

        var licenses = musicContainer.find('.each_license');

        var addFlag = musicContainer.attr('data-add');

        var musicThumb = new Image();

        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

        var intRegex = /^\d+$/;

        if(musicContainer.find('#display-music-thumb').length) {

            musicThumb.src = musicContainer.find('#display-music-thumb').attr('src');

        } else{

            musicThumb.src = musicContainer.find('#display-music-thumb_' + this.dataset.musicid).attr('src');

        }



        musicContainer.find('.has-danger').removeClass('has-danger');

        var browserWidth = $( window ).width();

        if( browserWidth <= 767 ) { var margin = 100; }

        else { var margin = 70; }



        fullOwnerShip.removeClass('m_check_error');

        agreeTC.removeClass('m_check_error');

        if( musicName == '' ){ error = 1; message += 'Music name required<br>'; musicContainer.find('input[name=song_name]').parent().parent().addClass('has-danger'); }

        if( instruments.length == 0 ){ error = 1; message += 'Instruments required<br>'; musicContainer.find('input[name=instruments]').parent().parent().addClass('has-danger'); }

        if( mood == '' ){ error = 1; message += 'Mood required<br>'; musicContainer.find('select[name="dropdown_two"]').parent().parent().addClass('has-danger'); }

        if( genre == '' ){ error = 1; message += 'Genre required<br>'; musicContainer.find('select[name="dropdown_one"]').parent().parent().addClass('has-danger'); }

        if( file == '' && addFlag == '1' ){ error = 1; message += 'Music file required<br>'; musicContainer.find('.pro_file_uploader .upload_vieo_img img').attr('src', '/images/p_music_unfilled.png').addClass('has-danger'); }

        if( !fullOwnerShip.hasClass('m_chech_active') ) { error = 1; message += 'Please verify you have full ownership<br>'; musicContainer.find('#full_ownership').parent().addClass('has-danger'); }

        if( !agreeTC.hasClass('m_chech_active') ) { error = 1; message += 'Please agree to our terms<br>'; musicContainer.find('#licenses_perpetual').parent().addClass('has-danger'); }

        if((musicFileType != "mp3" && musicFileType != "wav") && file != '' &&  addFlag == "1") { error = 1; message += 'Invalid Music Format<br>'; musicContainer.find('.pro_file_uploader .upload_vieo_img img').attr('src', '/images/p_music_unfilled.png').addClass('has-danger'); }

        if(file == '' && addFlag != '1'){

            var src = musicContainer.find('.pro_file_uploader img').attr('src');
            if(src.indexOf('p_music_filled') === -1){
                error = 1; message += 'Music file cannot be empty<br>'; musicContainer.find('.pro_file_uploader .upload_vieo_img img').attr('src', '/images/p_music_unfilled.png').addClass('has-danger');
            }
        }

        if(licenses.length){

            licenses.each(function(){

                if($(this).find('input[type="number"]').length){
                    if($(this).find('input[type="number"]').val() == '' && !$(this).hasClass('optional')){
                        $(this).addClass('has-danger');
                        error = 1;
                    }
                }else if($(this).find('input[type="text"]').length){
                    var xz = $(this).find('input[type="text"]');
                    if( (!$(this).hasClass('optional') && xz.val() == '') || (xz.val() != '' && !(floatRegex.test(xz.val()) || intRegex.test(xz.val())) &&  xz.val().toLowerCase() != 'poa')) {
                        $(this).addClass('has-danger');
                        error = 1;
                    }
                }

            });
        }
        if( error == 0 ){

            //$('#body-overlay').css('display', 'block');

            //$('.pro_uploading_in_progress').css('display', 'block');

            //musicContainer.submit();

            var container = musicContainer.find('.mu_down_uploader');
            if(container.length){

                var musicInstruments = '';
                musicContainer.find('.music_instruments_saved .profile_custom_drop_each').each(function(){

                    musicInstruments += $(this).find('.profile_custom_drop_title').text() + ',';
                });
                musicContainer.find('input[name="instruments"]').val(musicInstruments);
                var musicMoods = '';
                musicContainer.find('.music_moods_saved .profile_custom_drop_each').each(function(){

                    musicMoods += $(this).find('.profile_custom_drop_title').text() + ',';
                });
                musicContainer.find('input[name="more_moods"]').val(musicMoods);

                prepareUploader(container);

                $('.music_zip_upload_popup,#body-overlay').show();
                $('#close_upload').addClass('instant_hide');

                if($('.pro_pop_upload_each.waiting:not(.instant_hide)').length){

                    startUploader(container);
                }
            }else{
                alert('Container not found');
            }
        }

        else{



            $('.js_message_contain .error_span').html(message);

            //$('.js_message_contain').show();

            $('html, body').animate({ scrollTop: musicContainer.find('.has-danger').first().offset().top - margin }, 2000, function () { });

        }

    });

    $("#profile_tab_02 #add_music_section form:not(.zip_form),#profile_tab_02 #edit_music_section form:not(.zip_form)").submit(function(evt) {

        var action = $(this).attr('action');
        var formData = new FormData($(this)[0]);
        $('#pro_uploading_in_progress #error_mess').addClass('instant_hide');
        $('#pro_uploading_in_progress .each_progress').removeClass('done').removeClass('error');

        $.ajax({

            url: action,
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function (response) {

                if(response.success == '1'){
                    $('#pro_uploading_in_progress .each_progress#step_1').addClass('done');
                    updateAudioFileData(response.music);
                }else{
                    $('#pro_uploading_in_progress #error_mess').removeClass('instant_hide').find('#error_message').text(response.error);
                }
            }
        });

        return false;
    });



    $('body').delegate( ".each-music .summary", "click", function(e){

        e.preventDefault();

        var thiss = $(this).parent();
        var music_id = thiss.data('musicid');
        var browserWidth = $( window ).width();

        var lyricsDet = thiss.find('.lyrics_detail');

        $('.active_video_list').removeClass('active_video_list');

        var display = thiss.find('.add_to_cart_item').css('display');

        $('.each-album').find('.album_tab_lowerSection').css('display', 'none');

        $('.each-album').find('.add_to_cart_album').css('display', 'block');

        $('.add_to_cart_item').css('display', 'none');

        thiss.find('.add_to_cart_item').css('display', display);

        var lyricsHeight = 112;
        if(browserWidth <= 767){
            lyricsHeight = 80;
        }

        thiss.find('.add_to_cart_item').slideToggle('slow');

        if(lyricsDet.length && lyricsDet.outerHeight() > lyricsHeight){
            lyricsDet.addClass('overflowing');
            lyricsDet.parent().find('.lyrics_more').removeClass('instant_hide').text('Read More');
        }

        if(!thiss.hasClass('active_video_list_chan_tab')){

            $('.active_video_list_chan_tab').removeClass('active_video_list_chan_tab');
            thiss.addClass('active_video_list_chan_tab');

            if(thiss.data('musicfile') != ''){
                updateAndPlayAudioPlayer(thiss, '/user-music-files/' + thiss.data('musicfile'), true);
            }else{
                alert('File related to this track does not exist');
            }
        }else{

            $('.active_video_list_chan_tab').removeClass('active_video_list_chan_tab');
            if(browserWidth > 767){

                if(typeof spectrum !== 'undefined'){
                    spectrum.pause();
                    $('#play').addClass('fa-play').removeClass('fa-pause');
                    $('.ap_outer').hide();
                }
            }else{

                if(typeof spectrum !== 'undefined' && spectrum.duration > 0){
                    spectrum.pause();
                    $('#play').addClass('fa-play').removeClass('fa-pause');
                    $('.ap_outer').hide();
                }
            }
        }

    });


    $('body').delegate('.fav_np, .ap_outer .track_fav', 'click', function(e){
        var thiss = $(this);
        var music = thiss.parent().parent().parent().parent().attr('data-musicid');
        var filters = $('#search_filters').val();
        $.post('/toggle-favourite-music' , { music: music, filters: filters }, function(data) {

            if(data.response == 'added'){
                thiss.addClass('active');
            }else if(data.response == 'removed'){
                thiss.removeClass('active');
            }else if(data.response == 'user must login'){
                loadMyDeferredImages($("#not_logged_in img.prevent_pre_loading"));
                $('#not_logged_in,#body-overlay').show().find('.quick_notice').removeClass('instant_hide');
            }
        });
    });

    $('body').delegate('.tot_awe_liker', 'click', function(e){
        var thiss = $(this);
        var product = thiss.closest('.tot_awe_pro_outer').find('.add_basket_btn').attr('data-productid');
        $.post('/toggle-favourite-product' , { product: product }, function(data) {

            if(data.response == 'added'){
                thiss.addClass('active');
            }else if(data.response == 'removed'){
                thiss.removeClass('active');
            }else if(data.response == 'user must login'){
                loadMyDeferredImages($("#not_logged_in img.prevent_pre_loading"));
                $('#not_logged_in,#body-overlay').show().find('.quick_notice').removeClass('instant_hide');
            }
        });
    });

    $('body').delegate(".each-album .buy_np", "click", function(e){

        $(this).closest('.each-album').find('.add_to_cart_album .add_to_basket').trigger('click');
    });

    $('body').delegate(".stream_share,.stream_fav,.chat_each_user .chat_user_name a,.each-music .summary .item_share,.chat_each_user .chat_user_pic img,.each-music .summary .fav_np, .each-music .summary .thismusic_user_name, .each-album-music .summary .fav_np,.each-album .buy_np,.each-music .res_left_artist,.each-album-music .res_left_artist", "click", function(e){
        e.stopPropagation();
    });


    $('body').delegate( ".each-music .lyrics_more,.each-album-music .lyrics_more", "click", function(e){

        var thiss = $(this).parent().find('.lyrics_detail');
        if(thiss.length && thiss.hasClass('overflowing')){
            thiss.removeClass('overflowing');
            thiss.parent().find('.lyrics_more').text('Read Less');
        }else{
            thiss.addClass('overflowing');
            thiss.parent().find('.lyrics_more').text('Read More');
        }
    });

    $('body').delegate( ".each-album-music .summary", "click", function(e){

        e.preventDefault();

        var thiss = $(this).parent();
        var lyricsDet = thiss.find('.lyrics_detail');
        var thisAlbum = thiss.parent().parent();
        var music_id = thiss.data('musicid');
        var browserWidth = $( window ).width();

        var display = thiss.find('.add_to_cart_item').css('display');

        $('.add_to_cart_item').css('display', 'none');

        thiss.find('.add_to_cart_item').css('display', display);

        var lyricsHeight = 112;
        if(browserWidth <= 767){
            lyricsHeight = 80;
        }

        thiss.find('.add_to_cart_item ').slideToggle('slow', function(){

            if(lyricsDet.length && lyricsDet.outerHeight() > lyricsHeight){
                lyricsDet.addClass('overflowing');
                lyricsDet.parent().find('.lyrics_more').removeClass('instant_hide').text('Read More');
            }

            if(!thiss.hasClass('active_video_list_chan_tab')){
                alert('wring');
                $('.active_video_list_chan_tab').removeClass('active_video_list_chan_tab');
                thiss.addClass('active_video_list_chan_tab');
                updateAndPlayAudioPlayer(thiss, '/user-music-files/' + thiss.data('musicfile'), true);
            }else{

                $('.active_video_list_chan_tab').removeClass('active_video_list_chan_tab');
                if(browserWidth > 767){

                    if(typeof spectrum !== 'undefined'){
                        spectrum.pause();
                        $('#play').addClass('fa-play').removeClass('fa-pause');
                        $('.ap_outer').hide();
                    }
                }else{

                    if(typeof spectrum !== 'undefined' && spectrum.duration > 0){
                        spectrum.pause();
                        $('#play').addClass('fa-play').removeClass('fa-pause');
                        $('.ap_outer').hide();
                    }
                }
            }
            thisAlbum.addClass('active_video_list_chan_tab');

            if(thisAlbum.find('.add_to_cart_item').not(":hidden").length > 0){

                thisAlbum.find('.add_to_cart_album').slideUp();
            }else{

                thisAlbum.find('.add_to_cart_album').slideDown();
            }
        });

    });



    $('body').delegate( ".each-album .album-summary", "click", function(e){

        e.preventDefault();

        var thiss = $(this).parent();

        var music_id = thiss.data('musicid');

        var album_id = thiss.data('albumid');

        $('.active_video_list').removeClass('active_video_list');

        var display = thiss.find('.album_tab_lowerSection').css('display');

        $('.each-album').find('.album_tab_lowerSection').css('display', 'none');

        $('.add_to_cart_item').css('display', 'none');

        thiss.find('.album_tab_lowerSection').css('display', display);

        thiss.find('.album_tab_lowerSection').slideToggle('slow', function(){

            if(!thiss.hasClass('active_video_list_chan_tab')){

                $('.active_video_list_chan_tab').removeClass('active_video_list_chan_tab');
                thiss.addClass('active_video_list_chan_tab');
            }else{

                $('.active_video_list_chan_tab').removeClass('active_video_list_chan_tab');
            }
        });

    });



    var current_music_licence = '';

    var current_music_price = '';



    $('body').delegate('.ch_select_options .ch_select_perch_options', 'click', function(e){

        var target = $(this).closest('.ch_select_perch_options').find('.license_container');
        var musicId = $(this).closest('.each-music').attr('data-musicid');
        if(target.find('.choose_music_license_contain').length){

        	$('#choose-music-license .choose_music_license_outer').html(target.html());
        	$('#choose-music-license .choose_music_license_submit').removeClass('disabled');
        }else{

        	$('#choose-music-license .choose_music_license_submit').addClass('disabled');
        	$('#choose-music-license .choose_music_license_outer').html('<div class="no_records">This music has no licenses</div>');
        }

        $('#choose-music-license').attr('musicid', musicId);
        $('#choose-music-license,#body-overlay').show();
    });

    $('body').delegate('.choose_music_license_each input[type="radio"]', 'click', function(e){

    	e.stopPropagation();
    });

    $('body').delegate('.choose_music_license_each', 'click', function(e){

        if($(this).find('input[type="radio"]').is(':checked')){
            $(this).find('input[type="radio"]').prop('checked', false);
        }else{
            $(this).find('input[type="radio"]').prop('checked', true);
        }
    });

    $('body').delegate('.choose_music_license_terms_handle', 'click', function(e){

    	var text = $(this).find('span').text();
    	$(this).closest('.choose_music_license_terms_contain').find('.choose_music_license_terms_each').slideToggle();
        $(this).find('span').text(text == 'show terms' ? 'hide terms' : 'show terms');
        $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
    });

    $('body').delegate('.choose_music_license_submit:not(.disabled)', 'click', function(e){

        var radio = $(this).closest('.pro_page_pop_up').find('input[type=radio]:checked');
        var error = 0;
        var errorMessage = '';

        if(radio.length){

            var thiss = $(this);
            var musicId = $(this).closest('.pro_page_pop_up').attr('musicid');
            var music = $('.each-music[data-musicid="'+musicId+'"]');
            var price = radio.closest('.choose_music_license_contain').attr('data-price');

            if(typeof price !== typeof undefined && price !== false && price !== '' && price.indexOf('POA') == -1){

                var splitValue = price.split("::");
                current_music_licence = splitValue[0];
                current_music_price = splitValue[1];
                current_music_price = current_music_price.slice(1);
                var music_id = music.attr('data-musicid');
                var basket_user_id = atob(music.attr('data-userid'));

            }else if(typeof price !== typeof undefined && price !== false && price.indexOf('POA') !== -1){

                current_music_licence = '';
                current_music_price = '';
                error = 1;
                errorMessage = 'This music license is POA (Price On Application). You should chat with its owner to get a quote';
            }else{

            	error = 2;
                errorMessage = 'Music price is unknown';
            }
        }else{

        	error = 3;
        	errorMessage = 'Choose a license to purchase';
        }

        if(!error){

        	$('#choose-music-license,#body-overlay').hide();
        	addCartItem(current_music_licence, 'music', music_id, 0, 0, current_music_price, basket_user_id, 0, '');
        }else{

        	alert(errorMessage);
        	if(error === 1){

        		$('#choose-music-license,#body-overlay').hide();
        		$('#bespoke_license_popup,#body-overlay').show();
        	}
        }
    });

    $('body').delegate( ".add_basket_btn,.add_to_basket,.feat_prod_add,.feat_album_add", "click", function(e){



        e.preventDefault();

        var thiss = $(this);

        var purchase_type = this.dataset.purchasetype;

        var music_id = this.dataset.musicid;

        var product_id = this.dataset.productid;

        var basket_user_id = this.dataset.basketuserid;

        var album_id = 0;

        var error = 0;

        $('.license_err').removeClass('license_err');

        if(this.dataset.purchasetype == "music"){

            var basket_license = current_music_licence;

            var basket_price = current_music_price;

            var meta_data = '';

            if(basket_license == ''){

                error = 1;

                $(this).parent().find('.license_container').closest('.ch_select_perch_options').addClass('license_err');
            }

        } else if(this.dataset.purchasetype == "album"){

            var basket_price = this.dataset.basketprice;

            album_id = this.dataset.albumid;

            var meta_data = '';

        } else if(this.dataset.purchasetype == "product"){

            var basket_license = "";

            var basket_price = this.dataset.basketprice;

            var meta_data = '';

            if(thiss.hasClass('sold_out')){

                error = 1;
            }
        } else if(this.dataset.purchasetype == "custom_product"){

            var basket_license = "";

            var price = this.dataset.basketprice;

            var color = thiss.closest('.tot_awe_pro_outer').find('.tot_awe_color_each.active');

            var size = thiss.closest('.tot_awe_pro_outer').find('.tot_awe_size_each.active');

            var quantity = thiss.closest('.tot_awe_pro_outer').find('.tot_awe_pro_qua').val();

            var account = this.dataset.account;

            var title = thiss.closest('.tot_awe_pro_outer').find('.tot_awe_pro_right h3').text();

            var image = thiss.closest('.tot_awe_pro_outer').find('.tot_awe_pro_left img').attr('data-src');

            if(color.length == 0 || (thiss.closest('.tot_awe_pro_outer').find('.tot_awe_pro_sizes').length > 0 && size.length == 0)){

                error = 1;
            }else{

                var meta_data = 'color_'+color.attr('data-name');
                var colorr = color.attr('data-name');
                if(size.length > 0){
                    meta_data += ':size_'+size.attr('data-name');
                    var sizee = size.text();
                }else{
                    var sizee = '';
                }
            }

            if(!error){

                $.ajax({

                    url: "/informationFinder",
                    dataType: "json",
                    type: 'post',
                    data: {'find_type': 'countries', 'find': product_id, 'identity_type': 'pod_buyer', 'identity': ''},
                    success: function(response) {
                        if(response.success == 1){

                            var curr = response.data.currencySym;
                            $('#pay_quick_popup .pay_item_thumb img').attr('src', image);
                            $('#pay_quick_popup #pay_quick_shipping_country').html(response.data.countries);
                            preparePayInstant(account, 'custom_product_'+product_id, '#pay_quick_popup #pay_quick_card_number', '#pay_quick_popup #pay_quick_card_expiry', '#pay_quick_popup #pay_quick_card_cvc', '', colorr+'_'+sizee+'_'+curr+price+'_'+quantity+'_'+title);
                            $('#pay_quick_popup .stage_one').removeClass('instant_hide');
                            $('#pay_quick_popup .stage_two').addClass('instant_hide');
                            $('#pay_quick_popup,#body-overlay').show();
                            error = 1;
                        }else{
                            alert(data.error);
                        }
                    }
                });
            }
        }

        if(!error && this.dataset.purchasetype != "custom_product"){

            addCartItem(basket_license, purchase_type, music_id, product_id, album_id, basket_price, basket_user_id, 0, meta_data);
        }else{

        }

    });


    $('.post_cart_toast #continue, .post_cart_toast #close').click(function(){

        $('.post_cart_toast').slideUp('fast');
    });

    $('#post_cart_toast #checkout').click(function(){

        var checkoutUrl = $('.checkout_btn').attr('data-link');
        if(checkoutUrl != ''){
            window.location = checkoutUrl;
        }
    });

    $('#post_cart_toast #undo').click(function(){

        var basket = $('#post_cart_toast').attr('data-basket');
        var response = removeCartItem(basket);
        response.success(function (data) {
            if(data.message == 'Deleted'){
                $('#post_cart_toast').attr('data-basket', '').attr('data-user', '').slideUp();
            }else{
                $('#post_cart_toast .message').text(data.message).slideDown();
            }
        });
    });

    $('body').delegate(".checkout_btn", "click", function(e){

        var checkoutUrl = $(this).attr('data-link');
        if(checkoutUrl != ''){
            window.location = checkoutUrl;
        }
    });

    $('body').delegate(".item_delete", "click", function(e){

        $("#basket_del_item_id").val($(this).attr('data-basketid'));

        $('.hrd_cart_outer').toggleClass('active');
        $('body').toggleClass('lock_page');
        $('#body-overlay').toggle();

        loadMyDeferredImages($("#top_basket_popup img.prevent_pre_loading"));
        $("#top_basket_popup,#body-overlay").show();

    });



    $("#basket_delete_submit_yes").click(function () {

        var id = $("#basket_del_item_id").val();
        var formData = new FormData();
        formData.append('id', id);
        $.ajax({

            url: '/deleteBasketItem',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function (response) {
                if(response.success == 1){
                    location.reload();
                }else{
                    alert(response.error);
                }
            }
        });
    });

    $('body').delegate('.stream_fav', 'click', function(e){
        var thiss = $(this);
        var streamId = thiss.closest('.each_stream_outer').attr('data-id');
        $.post('/toggle-favourite-stream' , { stream: streamId }, function(data) {

            if(data.response == 'added'){
                thiss.addClass('active');
            }else if(data.response == 'removed'){
                thiss.removeClass('active');
            }else if(data.response == 'user must login'){
                loadMyDeferredImages($("#not_logged_in img.prevent_pre_loading"));
                $('#not_logged_in,#body-overlay').show().find('.quick_notice').removeClass('instant_hide');
            }
        });
    });

    $('body').on( "click", ".each_stream_outer:not(.each_fav_stream)", function(e) {



        e.preventDefault();



        var browserWidth = $( window ).width();

        var videoId = $(this).attr('data-id');
        var userName = $(this).find('.stream_channel').text();
        var videoTitle = $(this).find('.stream_title').text();

        $('.active_video_list').removeClass('active_video_list');
        $(this).find('.each_stream_inner').addClass('active_video_list');

        var id = $(this).data('id');

        //$("#body-overlay").css({'height':($('body').height())+'px'}).css('display', 'block');

        $.post( "/getTVStreamDetails" , { streamId: id }, function(data) {

            //updating tv stream with ajax return data

            var streamName = data.name;

            var streamTime = data.time;

            var channelName = data.channel_name;

            var youtubeVideoId = data.youtube_video_id;

            var videoLink = data.video_link;

            var source = data.source;

            var thumb = data.thumb;

            var poster = data.poster;

            var streamLiveStatus = data.live_status;

            var streamUpcomingStatus = data.upcoming_status;

            var images = data.images;

            var description = decodeHTMLEntities( data.description );

            var hosts = data.hosts;



            //adding images to stream description

            if(images != ''){

                var imagesArray = images.split(', ');

                for( var i = 0; i < imagesArray.length; i++ ){

                    if(imagesArray[i].trim() != ''){

                        description = description + '<img src="https://www.duong.1platform.tv/public/stream-images/'+ imagesArray[i]+'"><br>';
                    }

                }

            }

            if(youtubeVideoId.trim().length > 1){

                $('.cent_undo_btn').removeClass('instant_hide');
            }else{
                $('.cent_undo_btn').addClass('instant_hide');
            }


            $('.ch_tab_tv_outer .stream_thumb img').attr('src', thumb);

            $('.ch_tab_tv_outer .stream_det .stream_title').text(streamName);

            $('.ch_tab_tv_outer .stream_det .stream_time').text(streamTime);

            $('.ch_tab_tv_outer .stream_det .stream_channel').html(channelName);

            $('.ch_tab_tv_outer .btm_text_stor_outer').html(description);

            $('#stream_channel_name').text(channelName);

            $('.ch_tab_tv_outer .hosts_container').html(hosts);

            $('.ch_left_sec_outer').removeClass('instant_hide');


            if(streamLiveStatus == '1'){

                $('.top_stream_right a').text('LIVE');
                $('.ch_tab_tv_outer .top_stream_outer').addClass('stream_is_live');
            }else{

                $('.top_stream_right a').text('');
                $('.ch_tab_tv_outer .top_stream_outer').removeClass('stream_is_live');
            }

            $('.default_card').addClass('instant_hide');
            $('.default_stream').removeClass('instant_hide');

            var baseUrl = $('#base_url').val();
            var videoTitleFormatted = videoTitle.replace(/[^\w\s!?]/g, ' ');
            var vLink = baseUrl+'video-share/'+videoId+'/'+encodeURIComponent(videoTitleFormatted)+'/'+$('#share_current_page').val()+'_0';
            $('.top_info_right_icon').removeClass('instant_hide');
            $('#video_share_title').val(videoTitleFormatted);
            $('#video_share_link').val(vLink);

            $('.tv_left_outer').removeClass('instant_hide');

            if(source == 'youtube'){

                if(streamUpcomingStatus == '0'){

                    if(videoLink.indexOf('vimeo') !== -1){

                        playVimeoVideo(youtubeVideoId, 1);
                    }else{
                        mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v='+youtubeVideoId, mediaInstance, 1);
                    }
                }else{

                    mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v='+youtubeVideoId, mediaInstance, 0, poster);
                }

            }else{

                playJWPVideo('container_id', videoLink, 1, false, false, '1Platform TV', 'Description here', false, true, true);
            }

            $('.mejs__container').removeClass('instant_hide');
            $('.content_outer').addClass('playing');

            if( browserWidth <= 767 ) {


                $("html, body").animate({scrollTop: $("body").offset().top}, "slow");
            }else{

                $("html, body").animate({scrollTop: $(".top_info_box").offset().top - 59}, "slow");
            }

        }).complete(function() {


            //$("#body-overlay").css('display', 'none');

        });

    });



    // don't be theiko play button

    $('#top_right_button').click(function () {

        if( $("#user_logged_in").val() == "0"){

            loadMyDeferredImages($("#login_before_apply_popup img.prevent_pre_loading"));
            $("#login_before_apply_popup,#body-overlay").show();

        } else {

            mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v=Ou-12wAIH2Y&feature=youtu.be', mediaInstance, 1);

        }

    });



    $('body').on( "click", ".each_user_video", function(e) {

        e.preventDefault();

        var browserWidth = $( window ).width();
        var videoId = $(this).find('.each_user_video_artist').attr('data-stream-id');
        var videoType = $(this).find('.each_user_video_artist').attr('data-stream-type');
        var userName = $(this).find('.each_user_video_artist').text().trim();
        var videoTitle = $(this).find('.tab_chanel_img_det p').text().trim();
        var isLive = $(this).find('.each_user_video_artist').attr('data-stream-live');
        var userOriginalImage = $(this).find('.each_user_video_artist').attr('data-orig-image');

        if(videoId != ''){

            if(isLive == '1'){
                videoId = atob(videoId);
            }

            var baseUrl = $('#base_url').val();
            var videoTitleFormatted = videoTitle.replace(/[^\w\s!?]/g, ' ');
            var link = baseUrl+'video-share/'+videoId+'/'+encodeURIComponent(userName)+'/'+$('#share_current_page').val()+'_'+window.currentUserId;
            var urlLink = baseUrl+'url-share/'+$('#share_current_page').val()+'_'+window.currentUserId+'/'+encodeURIComponent(userName)+'/'+btoa(userOriginalImage);

            if(isLive != '1'){
                $('#video_share_id').val(videoId);
                $('#video_share_title').val(videoTitleFormatted);
                $('#video_share_link').val(link);
            }else{
                $('#video_share_id').val('');
                $('#video_share_title').val('');
                $('#video_share_link').val('');
            }

            $('#url_share_user_name').val(userName);
            $('#url_share_link').val(urlLink);

            $('.each_user_video').removeClass('active_video_list');
            $('.active_video_list_chan_tab').removeClass('active_video_list_chan_tab');
            $('.each_chart_video').removeClass('active_video_list');
            $(this).addClass('active_video_list');

            if($(".ch_video_detail_outer").length){

                $(".ch_video_detail_outer").hide();

                $(".user_hm_cent_bt_outer").show();

            }

            $('.mejs__container').addClass('instant_hide');

            if( videoType == 'soundcloud' ){

                playSoundCloudAudio(videoId, 1);
            }else{

                mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v='+videoId, mediaInstance, 1);
            }

            $('.mejs__container').removeClass('instant_hide');
            $('.content_outer').addClass('playing');


            if( browserWidth <= 767 ) {

                $("html, body").animate({scrollTop: $("body").offset().top}, "slow");
            }else{

                $("html, body").animate({scrollTop: $(".top_info_box").offset().top - 59}, "slow");
            }
        }

    });

    $(".tab_chanel_list.each_chart_video").click(function(e){

        e.preventDefault();
        var browserWidth = $( window ).width();
        var videoId = $(this).find('.each_user_video_artist').attr('data-stream-id');
        var videoType = $(this).find('.each_user_video_artist').attr('data-stream-type');
        var userName = $(this).find('.each_user_video_artist').text().trim();
        var userOriginalImage = $(this).find('.each_user_video_artist').attr('data-orig-image');
        var videoTitle = $(this).find('.tab_chanel_img_det p').text().trim();

        if(videoType == 'youtube' || videoType == 'soundcloud'){

            var identityType = 'chart_user';
        }else if(videoType == 'user_bio_url'){

            var identityType = 'studio_user';
        }

        if(('.top_right_chart').length){

            $('.top_right_chart').removeClass('top_right_chart');
        }

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'url_owner_id', 'find': videoId, 'identity_type': identityType, 'identity': ''},
            success: function(response) {
                if(response.success == 1){
                    var userId = response.data.userId;
                    window.currentUserId = userId;
                    $.ajax({

                        url: "/informationFinder",
                        dataType: "json",
                        type: 'post',
                        data: {'find_type': 'user_personal_information,user_campaign_information', 'find': userId, 'identity_type': identityType, 'identity': videoId},
                        success: function(response2) {
                            if(response2.success == 1){

                                if(browserWidth <= 767){

                                    var userCampaignStory = '<p>'+decodeHTMLEntities(response2.data.campaignUserInfo.storyText)+'</p>';
                                    var userCampaignStoryImages = response2.data.campaignUserInfo.storyImages;
                                    if(userCampaignStoryImages != ''){

                                        var imagesArray = userCampaignStoryImages.split(', ');
                                        for(var i = 0; i < imagesArray.length; i++){

                                            userCampaignStory += '<img class="user_story_image" src="/user-story-images/'+ imagesArray[i]+'">';
                                        }

                                    }

                                    $('#tab1 .bio_sec_percent_image').attr('src', response2.data.mainHeaderImage);
                                    $('#tab1 .full_support_me').attr('href', response2.data.campaignUserInfo.projectPage);
                                    $('#tab1 .tier_one_text_one').text(response2.data.tierOneTextOne);
                                    $('#tab1 .tier_one_text_two').text(response2.data.tierOneTextTwo);
                                    $('#tab1 .tier_two_text_one').text(response2.data.tierTwoTextOne);
                                    $('#tab1 .tier_two_text_two').html(response2.data.tierTwoTextTwo);
                                    $('#tab1 .tier_three_text_one').text(response2.data.tierThreeTextOne);
                                    $('#tab1 .tier_three_text_two').text(response2.data.tierThreeTextTwo);
                                    $('#tab1 .user_campaign_title').text(response2.data.campaignTitle);
                                    $('#tab1 .bio_sec_story_text').html(userCampaignStory);

                                    var userLeftInfo = $('#tab1').parent().parent().find('.user_left_bar_top_info');
                                    userLeftInfo.find('.top_left_user_display_image').attr('src', response2.data.campaignUserInfo.profileImage);
                                    userLeftInfo.find('.user_home_link_left').attr('href', response2.data.campaignUserInfo.homePage);
                                    userLeftInfo.find('.top_left_user_city').text(response2.data.campaignUserInfo.city.substring(0, 21));
                                    userLeftInfo.find('.top_left_user_skills').text(response2.data.campaignUserInfo.skills.substring(0, 21));
                                    userLeftInfo.find('.top_left_user_name').text(response2.data.campaignUserInfo.name.substring(0, 21));

                                    if(response2.data.campaignAmount <= 0){
                                        var targetGoalText = 'Store<br>'+response2.data.campaignProducts;
                                    }else{
                                        var targetGoalText = 'Target<br>'+response2.data.campaignGoal;
                                    }
                                    $('.play_btm_user_img').attr('src', response2.data.campaignUserInfo.profileImage);
                                    $('.play_btm_user_name').html(response2.data.campaignUserInfo.splitName);
                                    $('.play_btm_user_goal').html(targetGoalText);
                                    $('#project_video').val(response2.data.campaignProjectVideoId);

                                }else{

                                    $('.ch_tab_sec_outer .project_name').text(response2.data.projectTitle);
                                    $('.ch_tab_sec_outer .bio_sec_percent_image').removeClass('a_percent').attr('src', response2.data.mainHeaderImage);
                                    $('.ch_tab_sec_outer .fund_raise_status').text(response2.data.mainHeaderTextTwo);
                                    $('.ch_tab_sec_outer .full_support_me').attr('href', response2.data.campaignUserInfo.projectPage);
                                    $('.ch_tab_sec_outer .project_line').text(response2.data.mainHeaderTextOne);
                                    $('.ch_tab_sec_outer .tier_one_text_one').text(response2.data.tierOneTextOne);
                                    $('.ch_tab_sec_outer .tier_one_text_two').text(response2.data.tierOneTextTwo);
                                    $('.ch_tab_sec_outer .tier_two_text_one').text(response2.data.tierTwoTextOne);
                                    $('.ch_tab_sec_outer .tier_two_text_two').html(response2.data.tierTwoTextTwo);
                                    $('.ch_tab_sec_outer .tier_three_text_one').text(response2.data.tierThreeTextOne);
                                    $('.ch_tab_sec_outer .tier_three_text_two').text(response2.data.tierThreeTextTwo);
                                }

                                $('.tab_btns_outer .tab_btn_user_name .border_alter').html(response2.data.campaignUserInfo.splitName);
                                $('.tab_btns_outer .tab_btn_user_name').attr('data-initials',response2.data.campaignUserInfo.emailInitials);
                                $('.ch_tab_sec_outer.mobile-only.instant_hide,.cent_undo_btn').removeClass('instant_hide');
                                $('.each_tab_btn.disabled').removeClass('disabled');
                                $('.each_tab_btn.store .border_alter').html('Store<br>'+response2.data.campaignProducts);


                                var baseUrl = $('#base_url').val();
                                var videoTitleFormatted = videoTitle.replace(/[^\w\s!?]/g, ' ');
                                var link = baseUrl+'video-share/'+videoId+'/'+encodeURIComponent(userName)+'/'+$('#share_current_page').val()+'_'+window.currentUserId;
                                var urlLink = baseUrl+'url-share/'+$('#share_current_page').val()+'_'+window.currentUserId+'/'+encodeURIComponent(userName)+'/'+btoa(userOriginalImage);

                                $('#video_share_id').val(videoId);
                                $('#video_share_title').val(videoTitleFormatted);
                                $('#video_share_link').val(link);

                                $('#url_share_user_name').val(userName);
                                $('#url_share_link').val(urlLink);

                            }else{
                                alert(response2.error);
                            }
                        }
                    });
                }else{
                    alert(response.error);
                }
            }
        });
    });





    $('.pro_add_edit_bonus_outer .pop_up_bonus_thumb').click(function(e){



        e.preventDefault();

        $('.pro_add_edit_bonus_outer #pop_up_bonus_file').trigger('click');

    });







    $(".proj_checkbox").click(function(){



        $(this). toggleClass("proj_checkbox_unchecked");

        $(this). toggleClass("proj_checkbox_checked");



        // project page function here..

        /*if($(this).hasClass("proj_checkbox_checked")){

         //$("#email_password_section").show();

         $("#is_create_new_user").val("1");

         }else{

         //$("#email_password_section").hide();

         $("#is_create_new_user").val("0");

         }*/

    });



    $("#profile_tab_05 .pay_btm_btn_outer #save_project").click(function(e){



        e.preventDefault();



        var projectType = $("#profile_tab_05 input[name='project_type']:checked").val();

        var projectTitle = $("#profile_tab_05 input[name=project_title]").val();

        var projectAmount = $("#profile_tab_05 input[name=project_amount]").val();

        var projectDuration = $("#profile_tab_05 #project_duration").val();

        var extendDuration = $("#profile_tab_05 #extend_duration").val();

        var projectBulletOne = $("#profile_tab_05 input[name=project_bullet_one]").val();

        var projectBulletTwo = $("#profile_tab_05 input[name=project_bullet_two]").val();

        var projectBulletThree = $("#profile_tab_05 input[name=project_bullet_three]").val();

        var projectSubscriptionAmount = $("#profile_tab_05 input[name=project_subscription_amount]").val();

        var isAgreed = $("#profile_tab_05 .proj_cond_check").hasClass('proj_cond_check_active');

        var totalDuration = parseInt(projectDuration) + parseInt(extendDuration);



        $('.js_message_contain').addClass('instant_hide');

        var error = 0;

        var message = '<span class="head">You have the following errors:</span>';



        if( projectType == undefined ){ error = 1; message += 'Project Type Required<br />'; }

        if( projectTitle == '' ){ error = 1; message += 'Project Title Required<br />'; }

        if( projectAmount == '' ){ error = 1; message += 'Project Amount Required<br />'; }

        //if( !isNaN(projectAmount) && projectAmount < 500 ){ error = 1; message += 'Project Amount must not be less than $500<br />'; }

        if( isNaN(projectAmount) ){ error = 1; message += 'Project Amount must be a number<br />'; }

        if( projectDuration == '' || projectDuration < 1 ){ error = 1; message += 'Project Duration Required<br />'; }

        if( !isNaN(projectDuration) && !isNaN(extendDuration) && totalDuration > 60 ){ error = 1; message += '(Project Duration + Extend Duration) should not be greater than 60<br />'; }

        /*if( projectBulletOne == '' || projectBulletTwo == '' || projectBulletThree == '' ){ error = 1; message += 'Encourage Point/s for Subscribers Required<br />'; }*/

        if( projectSubscriptionAmount == '' ){ error = 1; message += 'Project Subscription Amount Required<br />'; }

        if( !isAgreed ){ error = 1; message += 'Please agree to our terms and conditions<br />'; }


        $("#project_story_text").val( $("#full-screen-me").contents().find('.ck.ck-content.ck-editor__editable').html() );


        if (error == 1) {

            $('.js_message_contain .error_span').html(message);

            $('.js_message_contain').removeClass('instant_hide');

            $('html, body').animate({scrollTop: 0}, 1500, function () {

            });

        }else{

            $("#profile_tab_05 #save_project_form").submit();
        }
    });

    $("#profile_tab_05 .pay_btm_btn_outer #preview_project").click(function(e){

        e.preventDefault();
        $('#profile_tab_05 #save_project_form #save_and_preview').val('1');
        $("#profile_tab_05 .pay_btm_btn_outer #save_project").trigger('click');
    });

    $("#profile_tab_02 #subscribers_section #save_subscribers").click(function(e){



        e.preventDefault();



        var projectBulletOne = $("#profile_tab_02 #subscribers_section input[name=project_bullet_one]").val();

        var projectBulletTwo = $("#profile_tab_02 #subscribers_section input[name=project_bullet_two]").val();

        var projectBulletThree = $("#profile_tab_02 #subscribers_section input[name=project_bullet_three]").val();

        var projectSubscriptionAmount = $("#profile_tab_02 #subscribers_section input[name=project_subscription_amount]").val();

        $('.js_message_contain').hide();

        var error = 0;

        var message = '<span class="head">You have the following errors:</span>';



        if (error == 1) {



            $('.js_message_contain .error_span').html(message);

            $('.js_message_contain').show();

            $('html, body').animate({scrollTop: 0}, 1500, function () {

            });

        } else {

            $("#profile_tab_02 #subscribers_section #save_subscribers_form").submit();

        }



    });



    $("#profile_tab_05 .pt_check_box_list").click(function(){

        if($("#is_live").val() == "1"){

            $("#cant_edit_popup, #body-overlay").show();

        } else {

            $("#profile_tab_05 .pt_check_box_list").removeClass('pro_gig_checkbx_select');

            $(this).addClass('pro_gig_checkbx_select');

            $("#profile_tab_05 .pt_check_box_list").find('input[type=radio]').prop("checked", false);

            $(this).find('input[type=radio]').prop("checked", true);

        }

    });



    $("#profile_tab_05 .add_new_bonus").click(function(e){



        /*if($("#is_live").val() == "1"){

         $("#cant_edit_popup").show();

         } else {*/



        e.preventDefault();



        $('.pro_add_edit_bonus_outer input').not('input[name=_token]').val('');

        $('.pro_add_edit_bonus_outer textarea').text('').val('');

        $('.pro_add_edit_bonus_outer .pop_up_bonus_thumb').attr('src', '/images/p_music_thum_img.png');

        $('.pro_add_edit_bonus_outer .add_edit_text').text('Add');



        $('#body-overlay').show();

        $('.pro_add_edit_bonus_outer').show();

        //}

    });



    $('body').delegate( "#profile_tab_05 .proj_acco_bonus .edit_bonus", "click", function(e){

        //$("#profile_tab_05 .proj_acco_bonus .edit_bonus").click(function(e){


        if($("#is_live").val() == "1"){

            $("#cant_edit_popup, #body-overlay").show();

        } else {



            e.preventDefault();

            $('.pro_add_edit_bonus_outer .add_edit_text').text('Edit');



            var bonusId = $(this).attr('data-id');

            var bonusCampaignId = $(this).attr('data-campaign-id');



            if (bonusId && bonusCampaignId) {



                var bonusContainer = $(this).parent().parent().parent().parent().parent();

                var bonusTitle = bonusContainer.find('input[name=bonusTitle]').val();

                var bonusDescription = bonusContainer.find('textarea[name=bonusDescription]').val();

                var bonusItemsAvailable = bonusContainer.find('input[name=bonusQuantity]').val();

                var bonusItemsIncluded = bonusContainer.find('input[name=bonusItemsIncluded]').val();

                var bonusPrice = bonusContainer.find('input[name=bonusPrice]').val();

                var bonusWorldDelivery = bonusContainer.find('input[name=bonusWorldwideDelivery]').val();

                var bonusMyCountryDelivery = bonusContainer.find('input[name=bonusLocalDelivery]').val();



                var bonusCurrency = bonusContainer.find('input[name=currency]').val();

                var bonusMyCountryDeliveryCurrency = bonusContainer.find('input[name=my_country_delivery_cost_currency]').val();

                var bonusbonusWorldDeliveryCurrency = bonusContainer.find('input[name=worldwide_delivery_cost_currency]').val();



                var bonusThumbnail = bonusContainer.find('.proj_bonus_thumb_sec img').attr('src');



                $('.pro_add_edit_bonus_outer #pop_up_bonus_title').val(bonusTitle);

                $('.pro_add_edit_bonus_outer #pop_up_bonus_description').val(bonusDescription);

                $('.pro_add_edit_bonus_outer #pop_up_bonus_quantity').val(bonusItemsAvailable);

                $('.pro_add_edit_bonus_outer #pop_up_bonus_items').val(bonusItemsIncluded);

                $('.pro_add_edit_bonus_outer #pop_up_bonus_price').val(bonusPrice);

                $('.pro_add_edit_bonus_outer #pop_up_bonus_shipping_worldwide').val(bonusWorldDelivery);

                $('.pro_add_edit_bonus_outer #pop_up_bonus_shipping_my_country').val(bonusMyCountryDelivery);



                $('.pro_add_edit_bonus_outer #bonus_price_currency').val( bonusCurrency.toLowerCase() );

                $('.pro_add_edit_bonus_outer #bonus_price_currency').data( "oldvalue", bonusCurrency.toLowerCase() );



                $('.pro_add_edit_bonus_outer #bonus_shipping_worldwide_currency').val(bonusbonusWorldDeliveryCurrency.toLowerCase());

                $('.pro_add_edit_bonus_outer #bonus_shipping_worldwide_currency').data( "oldvalue", bonusbonusWorldDeliveryCurrency.toLowerCase());



                $('.pro_add_edit_bonus_outer #bonus_shipping_my_country_currency').val(bonusMyCountryDeliveryCurrency.toLowerCase());

                $('.pro_add_edit_bonus_outer #bonus_shipping_my_country_currency').data("oldvalue", bonusMyCountryDeliveryCurrency.toLowerCase());



                $('.pro_add_edit_bonus_outer #pop_up_bonus_id').val(bonusId);

                $('.pro_add_edit_bonus_outer #pop_up_campaign_id').val(bonusCampaignId);

                $('.pro_add_edit_bonus_outer .pop_up_bonus_thumb').attr('src', bonusThumbnail);



                $('#body-overlay').show();

                $('.pro_add_edit_bonus_outer').show();

            }

        }

    });





    $("#profile_tab_05 .cant_edit_fields :input, #profile_tab_05 .cant_edit_fields select").focus(function () {

        $(this).data('oldval', $(this).val());

    });



    $("#profile_tab_05 .cant_edit_fields :input, #profile_tab_05 .cant_edit_fields select").change(function () {

        if($("#is_live").val() == "1"){

            $("#cant_edit_popup").show();

            $(this).val( $(this).data('oldval') );

        }

    });



    $('body').delegate( "#profile_tab_05 .proj_acco_bonus .delete_bonus", "click", function(e){

        //$("#profile_tab_05 .proj_acco_bonus .delete_bonus").click(function(e){



        if($("#is_live").val() == "1"){

            $("#cant_edit_popup").show();

        } else {



            e.preventDefault();



            var bonusId = $(this).attr('data-del-id');

            var bonusCampaignId = $(this).attr('data-campaign-id');



            if (bonusId && bonusCampaignId) {



                $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', bonusId);

                $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'user-bonus');



                $('#body-overlay').show();

                $('.pro_confirm_delete_outer').show();

            }

        }

    });



    $("#create_new_project").click(function () {

        $("#create_new_project_popup,#body-overlay").show();

    });



    $(".pro_add_edit_bonus_outer #submit_bonus_form").click(function(e){



        e.preventDefault();



        $('.pop_up_bonus_field').removeClass('error_field');

        var error = 0;



        var bonusTitle = $('.pro_add_edit_bonus_outer #pop_up_bonus_title').val();

        var bonusDescription = $('.pro_add_edit_bonus_outer #pop_up_bonus_description').val();

        var bonusItems = $('.pro_add_edit_bonus_outer #pop_up_bonus_items').val();

        var bonusPrice = $('.pro_add_edit_bonus_outer #pop_up_bonus_price').val();

        var bonusShippingWorldwide = $('.pro_add_edit_bonus_outer #pop_up_bonus_shipping_worldwide').val();

        var bonusShippingMyCountry = $('.pro_add_edit_bonus_outer #pop_up_bonus_shipping_my_country').val();

        $('.pro_add_edit_bonus_outer .error').text('Required').addClass('instant_hide');

        if( bonusTitle == '' ){ error = 1; $('.pro_add_edit_bonus_outer #pop_up_bonus_title_error').removeClass('instant_hide'); }

        if( bonusDescription == '' ){ error = 1; $('.pro_add_edit_bonus_outer #pop_up_bonus_description_error').removeClass('instant_hide'); }

        if( bonusItems == '' ){ error = 1; $('.pro_add_edit_bonus_outer #pop_up_bonus_items_error').removeClass('instant_hide'); }

        if( bonusPrice == '' || isNaN(bonusPrice) || bonusPrice <= 0 ){ error = 1; $('.pro_add_edit_bonus_outer #pop_up_bonus_price_error').text('Invalid Number').removeClass('instant_hide'); }

        if( bonusShippingWorldwide != '' && isNaN(bonusShippingWorldwide) ){ error = 1; $('.pro_add_edit_bonus_outer #pop_up_bonus_shipping_worldwide_error').text('Invalid Number').removeClass('instant_hide'); }

        if( bonusShippingMyCountry != '' && isNaN(bonusShippingMyCountry) ){ error = 1; $('.pro_add_edit_bonus_outer #pop_up_bonus_shipping_my_country_error').text('Invalid number').removeClass('instant_hide'); }



        if( error == 0 ){

            $('#add_edit_bonus_form').submit();

        }

    });



    $("#add_edit_bonus_form").submit(function(evt) {

        $('.pro_add_edit_bonus_outer').hide();

        $('#pro_uploading_in_progress_real,#body-overlay').show();

        var formData = new FormData($(this)[0]);

        formData.append( "_token", $('meta[name="csrf-token"]').attr('content') );

        formData.append("campaign_id", $("#user_campaign_id").val());



        $.ajax({

            url: '/addEditBonus',

            type: 'POST',

            data: formData,

            cache: false,

            dataType: 'html',

            contentType: false,

            enctype: 'multipart/form-data',

            processData: false,

            success: function (response) {

                $("#all_bonuses_section").html(response);

                $('#pro_uploading_in_progress_real,#body-overlay').hide();

            }

        });



        return false;

    });





    $(".proj_dur_sel_sec select").change(function(){



        var proj_dur_sel = $(this).val();

        $(this).parent().find("span").text(proj_dur_sel);

    });



    $(".proj_cond_check").click(function(){

        $(this).toggleClass("proj_cond_check_active");
        if($(this).hasClass('proj_cond_check_active')){

            $(this).find('input[type="checkbox"]').prop("checked", true);
        }else{
            $(this).find('input[type="checkbox"]').prop("checked", false);
        }
        return false;
    });



    $(".proj_accourdiun_outer h2").click(function(){



        $(".proj_acco_det").slideUp();

        $(this).parent().find(".proj_acco_det").slideDown(500);

        return (false);

    });



    // file selection

    $('#story_file').change(function(){



        var input = this;

        dropImage(input.files);

    });



    $("#product_thumb").change(function(){



        readURL(this, 'display-product-thumb');

    });



    $("#music_thumb").change(function(){



        readURL(this, 'display-music-thumb');

    });



    $(".product_thumb").change(function(){



        var id = this.dataset.prodid;



        readURL(this, 'display-product-thumb_' + id);

    });



    $(".music_thumb").change(function(){



        var id = this.dataset.musicid;



        readURL(this, 'display-music-thumb_' + id);

    });



    /* auto hide is ticket fields */

    $("#is_ticket").change(function() {

        if(this.checked) {

            //Do stuff

            $( "#product-gig-list li:nth-child(10)" ).show();

            $( "#product-gig-list li:nth-child(11)" ).show();

            $( "#product-gig-list li:nth-child(12)" ).show();

        }else{

            $( "#product-gig-list li:nth-child(10)" ).hide();

            $( "#product-gig-list li:nth-child(11)" ).hide();

            $( "#product-gig-list li:nth-child(12)" ).hide();

        }

    });

    $("#requires_shipping").change(function() {

        if(this.checked) {

            //Do stuff

            $( "#product-gig-list li:nth-child(7)" ).show();

            $( "#product-gig-list li:nth-child(8)" ).show();

        }else{

            $( "#product-gig-list li:nth-child(7)" ).hide();

            $( "#product-gig-list li:nth-child(8)" ).hide();

        }

    });



    $(".is_ticket").change(function() {

        var id = this.dataset.prodid;

        if(this.checked) {

            //Do stuff

            $( "#li10_" +  id ).show();

            $( "#li11_" +  id ).show();

            $( "#li12_" +  id ).show();

        }else{

            $( "#li10_" +  id ).hide();

            $( "#li11_" +  id ).hide();

            $( "#li12_" +  id ).hide();

        }

    });

    $(".requires_shipping").change(function() {

        var id = this.dataset.prodid;

        if(this.checked) {

            //Do stuff

            $( "#li7_" +  id ).show();

            $( "#li8_" +  id ).show();

        }else{

            $( "#li7_" +  id ).hide();

            $( "#li8_" +  id ).hide();

        }

    });



    $("#profile_tab_01 input[name=password]").click(function() {

        if(window.currentUserId == 1){

            $('#change_pwd_secure_popup,#body-overlay').show();
        }else{

            $('.pro_page_pop_up .error').html('');
            $('#body-overlay').css('display', 'block');
            $('.pro_change_pass_outer').css('display', 'block');
        }

        return false;
    });



    $(".pro_change_pass_outer #pro_change_pass_submit").click(function(e) {



        e.preventDefault();



        var error = 0;

        $('.pro_change_pass_outer .error, .pro_change_pass_outer .success').html('');

        var newPassword = $('.pro_change_pass_outer #pro_change_pass_new');

        var currentPassword = $('.pro_change_pass_outer #pro_change_pass_current');

        var confirmPassword = $('.pro_change_pass_outer #pro_change_pass_confirm');



        if( currentPassword.val() == '' ){ error = 1; currentPassword.parent().find('.error').text('Required'); }

        if( newPassword.val() == '' ){ error = 1; newPassword.parent().find('.error').text('Required'); }

        if( confirmPassword.val() == '' ){ error = 1; confirmPassword.parent().find('.error').text('Required'); }

        if( newPassword.val().length < 6 && newPassword.val() != '' ){ error = 1; newPassword.parent().find('.error').text('Must be atleast of 6 characters'); }

        if( newPassword.val() != confirmPassword.val() && !error ){ error = 1; confirmPassword.parent().find('.error').text('Password not matching'); }



        if( !error ){



            $.post( "/change-password", { new_password: newPassword.val(), confirm_password: confirmPassword.val(), current_password: currentPassword.val() } , function( data ) {



                if( data == 1 ){



                    $('.pro_change_pass_outer .success').text('Saved Successfully');

                    $('.pro_change_pass_outer .error').text('');

                    $('.pro_change_pass_outer input[type=password]').val('');

                }else{



                    $('.pro_change_pass_outer .success').html('<text style="color: red;">'+data+'</text>');

                }

            });

        }



    });



    $("#profile_tab_02 #social_section .pro_soc_icon_singnal").click(function() {

        if( $(this).hasClass( 'not-connected' ) ){

            $('.pro_page_pop_up .error').html('');
            $('#body-overlay,.pro_soc_con_spot_outer').show();
        }else{

            showDisconnectSocialAccount($(this));
        }

        return false;
    });



    $("#profile_tab_02 #social_section .pro_soc_icon_tweet").click(function() {



        var elem = $(this);

        if( elem.hasClass( 'not-connected' ) ){



            $('.pro_page_pop_up .error').html('');

            $('#body-overlay').css('display', 'block');

            $('.pro_soc_con_twit_outer').css('display', 'block');

        }else{



            showDisconnectSocialAccount($(this));

        }

        return false;

    });

    $(".pro_soc_con_spot_outer #pro_soc_con_spot_submit").click(function() {

        $('.pro_soc_con_twit_outer .error').html('');
        var value = $('.pro_soc_con_spot_outer #soc_con_spotify_url_val').val();

        if( value != '' ){

            $.post( "/connect-user-social-spotify", { spotify_artist_url: value } , function( data ) {

                if( data == 1 ){

                    $("#profile_tab_02 #social_section .pro_soc_icon_singnal").removeClass('not-connected').addClass('connected');
                    $('.pro_soc_con_spot_outer #soc_con_spotify_url_val').val('');
                    $('.pro_page_pop_up,#body-overlay').hide();
                }else{

                    $('.pro_soc_con_spot_outer .error').html('Error: ' + data);
                }
            });
        }

        return false;
    });

    $(".pro_soc_con_twit_outer #pro_soc_con_twit_submit").click(function() {



        $('.pro_soc_con_twit_outer .error').html('');

        var twitterUsername = $('.pro_soc_con_twit_outer #soc_con_twit_username_val').val();

        if( twitterUsername.length ){



            $.post( "/connect-user-social-twitter", { twitter_connect_username: twitterUsername } , function( data ) {



                if( data == 1 ){



                    $("#profile_tab_02 #social_section .pro_soc_icon_tweet").removeClass('not-connected').addClass('connected');

                    $('.pro_soc_con_twit_outer #soc_con_twit_username_val').val('');

                    $('.pro_page_pop_up').css('display', 'none');

                    $('#body-overlay').css('display', 'none');

                }else{



                    $('.pro_soc_con_twit_outer .error').html('Error: ' + data);

                }

            });

        }

        return false;

    });



    $("#profile_tab_02 #social_section .pro_soc_icon_inst").click(function() {



        if( $(this).hasClass( 'not-connected' ) ){



            window.location.href = '/connect/instagram';

        }else{



            showDisconnectSocialAccount($(this));

        }

        return false;

    });



    $("#profile_tab_02 #social_section .pro_soc_icon_youtube").click(function() {



        var elem = $(this);

        if( elem.hasClass( 'not-connected' ) ){



            $('.pro_page_pop_up .error').html('');

            $('#body-overlay').css('display', 'block');

            $('.pro_soc_con_youtube_outer').css('display', 'block');

        }else{



            showDisconnectSocialAccount($(this));

        }

        return false;

    });



    $(".pro_soc_con_youtube_outer #pro_soc_con_youtube_submit").click(function() {



        $('.pro_soc_con_youtube_outer .error').html('');

        var channelName = $('.pro_soc_con_youtube_outer #soc_con_youtube_username_val').val();

        if( channelName.length ){



            $.post( "/connect-user-social-youtube", { youtube_connect_username: channelName } , function( data ) {



                if( data == 1 ){



                    $("#profile_tab_02 #social_section .pro_soc_icon_youtube").removeClass('not-connected').addClass('connected');

                    $('.pro_soc_con_youtube_outer #soc_con_youtube_username_val').val('');

                    $('.pro_page_pop_up').css('display', 'none');

                    $('#body-overlay').css('display', 'none');

                }else{



                    $('.pro_soc_con_youtube_outer .error').html('Error: ' + data);

                }

            });

        }



        return false;

    });

    $("#body-overlay, .pro_page_pop_up .pro_soc_top_close").click(function() {

        $('.hrd_cart_outer,.tv_slide_out_outer,.hrd_usr_men_outer,.hrd_notif_outer,.que_men_outer').removeClass('active');
        $('body').removeClass('lock_page');

        if($('.in_progress').is(":visible")){


        }else{

            $("#body-overlay,.pro_page_pop_up").hide();
        }



        if( $(this).attr('data-reminder') ){

            $("#share_project_reminder_popup,#body-overlay").show();

        }



        if( $(this).attr('data-stripe') ){

            $("#share_project_popup,#body-overlay").show();

        }

    });



    $("#profile_tab_02 #social_section .pro_soc_icon_fb").click(function() {



        var elem = $(this);

        if( elem.hasClass( 'not-connected' ) ){



            $('.pro_page_pop_up .error').html('');

            $('#body-overlay').css('display', 'block');

            $('.pro_soc_con_face_outer').css('display', 'block');

        }else{



            showDisconnectSocialAccount($(this));

        }

        return false;

    });



    $(".pro_soc_con_face_outer #pro_soc_con_facebook_submit").click(function() {



        $('.pro_soc_con_face_outer .error').html('');

        var pageId = $('.pro_soc_con_face_outer #soc_con_face_username_val').val();

        if( pageId.length ){



            $.post( "/connect-user-social-facebook", { facebook_connect_username: pageId } , function( data ) {



                if( data == 1 ){



                    $("#profile_tab_02 #social_section .pro_soc_icon_fb").removeClass('not-connected').addClass('connected');

                    $('.pro_soc_con_face_outer #soc_con_face_username_val').val('');

                    $('.pro_page_pop_up').css('display', 'none');

                    $('#body-overlay').css('display', 'none');

                }else{



                    $('.pro_soc_con_face_outer .error').html('Error: ' + data);

                }

            });

        }

        return false;

    });



    $('.pro_soc_discon_outer #pro_soc_discon_submit_yes').click(function(e){



        e.preventDefault();



        var account = $('.pro_soc_discon_outer').find('#pro_soc_discon_submit_yes').attr('data-disconnect-account');

        if( account == 'Instagram' ){



            $.post( "/disconnect-user-social-instagram", { instagram_connect_username: "" } , function( data ) {



                $('#profile_tab_02 #social_section .pro_soc_icon_inst').addClass('not-connected').removeClass('connected');

                $('#profile_tab_02 #social_section .pro_soc_icon_inst').attr('src', '/images/pro_social_inst_0.png');

            });

        }else if( account == 'Twitter' ){



            $.post( "/connect-user-social-twitter", { twitter_connect_username: "" } , function( data ) {



                $('#profile_tab_02 #social_section .pro_soc_icon_tweet').addClass('not-connected').removeClass('connected');

                $('#profile_tab_02 #social_section .pro_soc_icon_tweet').attr('src', '/images/pro_social_twit_0.png');

            });

        }else if( account == 'Youtube' ){



            $.post( "/connect-user-social-youtube", { youtube_connect_username: "" } , function( data ) {



                $('#profile_tab_02 #social_section .pro_soc_icon_youtube').addClass('not-connected').removeClass('connected');

                $('#profile_tab_02 #social_section .pro_soc_icon_youtube').attr('src', '/images/pro_social_youtube_0.png');

            });

        }else if( account == 'Facebook' ){



            $.post( "/connect-user-social-facebook", { facebook_connect_username: "" } , function( data ) {



                $('#profile_tab_02 #social_section .pro_soc_icon_fb').addClass('not-connected').removeClass('connected');

                $('#profile_tab_02 #social_section .pro_soc_icon_fb').attr('src', '/images/pro_social_face_0.png');

            });

        }else if( account == 'Spotify' ){



            $.post( "/disconnect-user-social-spotify" , function( data ) {



                $('#profile_tab_02 #social_section .pro_soc_icon_singnal').addClass('not-connected').removeClass('connected');

                $('#profile_tab_02 #social_section .pro_soc_icon_singnal').attr('src', '/images/pro_social_spot_0.png');

            });

        }else{ }



        $('#body-overlay').css('display', 'none');

        $('.pro_soc_discon_outer').css('display', 'none');

    });



    $('.pro_soc_discon_outer #pro_soc_discon_submit_no').click(function(e){



        e.preventDefault();



        $('#body-overlay').css('display', 'none');

        $('.pro_soc_discon_outer').css('display', 'none');

    });




     $('#profile_tab_02 #add_music_section input[name="music-file"],#profile_tab_02 #edit_music_section input[name="music-file"]').change(function(e){



        e.preventDefault();

        var elem = $(this);

        var filename = elem[0].files[0].name;

        var data = e.originalEvent.target.files[0];

        var extension = e.originalEvent.target.files[0].type;

        if(data.size > 60*1024*1024) {
            elem.val('');
            alert('The file cannot be more than 60MB');
            return false;
        }

        if(extension != 'audio/wav' && extension != 'audio/mp3' && extension != 'audio/mpeg'){
            elem.val('');
            alert('We only support MP3 and WAV audio file formats');
            return false;
        }

        var reader = new FileReader();
        reader.onload = function (event) {
            var audioContext = new (window.AudioContext || window.webkitAudioContext)();
            audioContext.decodeAudioData(event.target.result, function(buffer) {

                var duration = buffer.duration;
                elem.closest('form').find('.music_file_duration').val(duration);
            });
        },
        reader.onerror = function(event) {
            alert(reader.error);
        };

        reader.readAsArrayBuffer(data);

        elem.closest('form').find('.pro_file_uploader .upload_vieo_img img').removeClass('music_file_button').addClass('music_file_label').attr('src', '/images/p_music_filled.png');

        elem.closest('form').find('.p_music_filename').text(filename);
    });

    $('body').delegate('#profile_tab_02 #add_music_section .music_file_label,#profile_tab_02 #edit_music_section .music_file_label', 'click', function(e){

        e.preventDefault();

        $(this).closest('form').find('.music-file').val('');

        $(this).closest('form').find('.pro_file_uploader .upload_vieo_img img').removeClass('music_file_label').addClass('music_file_button').attr('src', '/images/p_music_thum_img.png?v=1.2');

        $(this).closest('form').find('.p_music_filename').text('Upload Music File');
    });

    $('body').delegate('#profile_tab_02 #add_music_section .music_file_button,#profile_tab_02 #edit_music_section .music_file_button', 'click', function(e){

        e.preventDefault();

        $(this).closest('form').find('.music-file[name="music-file"]').trigger('click');
    });

    $('.forgot_password').click(function(e){

        e.preventDefault();

        $('#body-overlay').show();

        //$('.forget_pass_popup_outer').show();

        $('.pro_reset_password').show();

    });

    $('.pro_reset_password .pro_submit_button_outer').click(function(e){

        e.preventDefault();
        $('.pro_reset_password #error').text('').hide();
        var emailAddress = $('.pro_reset_password .pro_reset_pass_field').val();
        $.ajax({

            url: "/forget-password",
            dataType: "json",
            type: 'get',
            data: {'email_address':emailAddress},
            success: function(response) {
                if(!response.success){

                    $('.pro_reset_password #error').text(response.error).show();
                }else{

                    $('.pro_reset_password,.forget_pass_response').hide();
                    $('.forget_pass_popup_response_outer #success,.forget_pass_popup_response_outer').show();
                }
            }
        });
    });

    $('#change_pwd_secure_popup #submit_button').click(function(){

        $('#change_pwd_secure_popup .stage_one .main_error').text('').hide();
        var emailAddress = $('#change_pwd_secure_popup .pro_reset_pass_field').val();
        $.ajax({

            url: "/change-password-secure",
            dataType: "json",
            type: 'post',
            data: {'action' : 'request','email_address':emailAddress},
            success: function(response) {
                if(!response.success){

                    $('#change_pwd_secure_popup .stage_one .main_error').text(response.error).show();
                }else{

                    $('#change_pwd_secure_popup .stage_one').addClass('instant_hide');
                    $('#change_pwd_secure_popup .stage_two').removeClass('instant_hide');
                }
            }
        });
    });

    $('#change_pwd_secure_popup .stage_two #submit_button_two').click(function(){

        $('#change_pwd_secure_popup .stage_two .main_error').text('').hide();
        $('#change_pwd_secure_popup .stage_two .error').addClass('instant_hide');
        var securityToken = $('#change_pwd_secure_popup .stage_two .pro_reset_security_token');
        var newPassword = $('#change_pwd_secure_popup .stage_two .pro_reset_new_password');
        var newPasswordConfirmation = $('#change_pwd_secure_popup .stage_two .pro_reset_new_password_confirmation');
        var error = 0;

        if(securityToken.val() == ''){
            error = 1;
            $('#change_pwd_secure_popup .stage_two #pro_reset_security_token_error').text('Required').removeClass('instant_hide');
        }
        if(newPassword.val() == ''){
            error = 1;
            $('#change_pwd_secure_popup .stage_two #pro_reset_new_password_error').text('Required').removeClass('instant_hide');
        }
        if(newPasswordConfirmation.val() == ''){
            error = 1;
            $('#change_pwd_secure_popup .stage_two #pro_reset_new_password_confirmation_error').text('Required').removeClass('instant_hide');
        }
        if(newPassword.val() != '' && newPassword.val().length < 6){
            error = 1;
            $('#change_pwd_secure_popup .stage_two #pro_reset_new_password_error').text('Password should be atleast 6 characters long').removeClass('instant_hide');
        }
        if(newPassword.val() != '' && newPassword.val().length >= 6 && newPasswordConfirmation.val() != '' && newPassword.val() != newPasswordConfirmation.val()){
            error = 1;
            $('#change_pwd_secure_popup .stage_two #pro_reset_new_password_confirmation_error').text('Password not the same').removeClass('instant_hide');
            $('#change_pwd_secure_popup .stage_two #pro_reset_new_password_error').text('Password not the same').removeClass('instant_hide');
        }

        if(!error){

            $.ajax({

                url: "/change-password-secure",
                dataType: "json",
                type: 'post',
                data: {'action' : 'execute','security_token':securityToken.val(),'new_password':newPassword.val(),'new_password_confirmation':newPasswordConfirmation.val()},
                success: function(response) {
                    if(response.success){

                        $('#change_pwd_secure_popup .stage_two').addClass('instant_hide');
                        $('#change_pwd_secure_popup .stage_three').removeClass('instant_hide');
                    }else{

                        $('#change_pwd_secure_popup .stage_two .main_error').text(response.error).show();
                    }
                }
            });
        }
    });



    // reset password changes..

    $("#reset_pass_popup_submit").click(function(e){

        var pass1 = $("#new_password_one").val();

        var pass2 = $("#new_password_two").val();

        var userId = this.dataset.userid;

        var baseUrl = this.dataset.baseurl;

        if(pass1 != pass2){

            $('.forget_pass_popup_outer .error').text('Passwords mismatch');

        } else if(pass1.length < 6){

            $('.forget_pass_popup_outer .error').text('Password must be 6 characher long');

        } else{

            window.location.href = baseUrl + "reset-password?pass=" + pass1 + "&userId=" + userId;

            /*$.get( "/reset-password", { password: pass1 } , function( data ) {



             $('.forget_pass_response').hide();

             $('.forget_pass_popup_outer').hide();

             $('.forget_pass_popup_response_outer #success').show();

             $('.forget_pass_popup_response_outer').show();

             });*/

        }



    });

    // reset password changes..





    $('.profile_outer,.content_outer,.hdr_right_icon_outer ul li:first').mouseover(function(e){



        $('.usr_men_contain').hide();

    });



    // Project page functions ..

    $('#subscribe_btn').click(function () {

        if(!$(this).hasClass('proj_add_sec_added')) {

            var purchase_type = 'subscription';
            var music_id = 0;
            var product_id = 0;
            var basket_user_id = this.dataset.basketuserid;
            var album_id = 0;
            var error = 0;
            var basket_license = '';
            var basket_price = this.dataset.basketprice;
            addCartItem(basket_license, purchase_type, music_id, product_id, album_id, basket_price, basket_user_id, 0);

        }else{

            var basket = $('.each_cart_item[data-purchasetype="subscription"]').attr('data-basket');
            var response = removeCartItem(basket);
        }
    });

    $('.terms_agree_outer').click(function(){

        $(this).toggleClass('active');
        if($(this).hasClass('active')){

            $(this).find('input[type="checkbox"]').prop('checked', true);
        }else{
            $(this).find('input[type="checkbox"]').prop('checked', false);
        }
    });

    $('.donator_outer .donation_right_in').click(function () {

        if(!$(this).closest('.donator_outer').hasClass('donation_agree')) {

            if($(this).closest('.donator_outer').hasClass('donation_goalless')){
                var purchase_type = 'donation_goalless';
            }else{
                $('.field_err').removeClass('field_err');
                var purchase_type = 'donation_goal';
            }
            var music_id = 0;
            var product_id = 0;
            var basket_user_id = this.dataset.basketuserid;
            var album_id = 0;
            var error = 0;
            var basket_license = '';
            var basket_price = $(this).closest('.donator_outer').find('#donation_amount').val();
            if(basket_price > 0 && purchase_type == 'donation_goalless'){
                addCartItem(basket_license, purchase_type, product_id, music_id, album_id, basket_price, basket_user_id, 0);
            }else if(basket_price > 0 && purchase_type == 'donation_goal'){
                addCrowdFundDonation();
            }
        }else{

            if($(this).closest('.donator_outer').hasClass('donation_goalless')){
                var basket = $('.each_cart_item[data-purchasetype="donation_goalless"]').attr('data-basket');
                var response = removeCartItem(basket);
            }else if($(this).closest('.donator_outer').hasClass('donation_goal')){
                removeCrowdFundDonation();
            }
        }
    });

    $('#add_item_free_popup #add_to').click(function(){

        if(typeof window.pendingAddToCart !== typeof undefined && window.pendingAddToCart !== false){

            var split = window.pendingAddToCart.split(',');
            var basket_license = split[0];
            var purchase_type = split[1];
            var music_id = split[2];
            var product_id = split[3];
            var album_id = split[4];
            var basket_price = split[5];
            var basket_user_id = split[6];
            var chat_id = split[7];
            var meta_data = split[8];

            var volutPrice = $('#add_item_free_popup #price').val();

            basket_price = (volutPrice != '' && parseFloat(volutPrice) > 0) ? volutPrice : basket_price;

            $('#add_item_free_popup,#body-overlay').hide();
            proceedAddCartItem(basket_license, purchase_type, music_id, product_id, album_id, basket_price, basket_user_id, chat_id, meta_data);

            delete window.pendingAddToCart;
        }
    });


    // Project page functions ..

    $('body').delegate( '.make_offer_outer,.item_negotiate', 'click', function(e){

        var id = $(this).closest('.each-music').attr('data-userid');
        $('#bespoke_license_popup').attr('data-recipient', atob(id));
        $('.stage_one').removeClass('instant_hide');
        $('.stage_two').addClass('instant_hide');
        $('#bespoke_license_popup,#body-overlay').show();
    });

    $('#send_bispoke_license_offer').click(function(){

        var thiss = $(this);
        $('#bespoke_license_popup .error').addClass('instant_hide');
        var error = 0;

        var email = $('#bespoke_license_popup #bispoke_login_email');
        var password = $('#bespoke_license_popup #bispoke_login_password');
        var offer = $('#bespoke_license_popup #bispoke_offer');

        if(email.length && email.val() == ''){ error = 1; $('#bispoke_email_error').removeClass('instant_hide'); }
        if(password.length && password.val() == ''){ error = 1; $('#bispoke_pass_error').removeClass('instant_hide'); }
        if(offer.length && offer.val() == ''){ error = 1; $('#bispoke_offer_error').removeClass('instant_hide'); }

        if(!error){

            var formData = new FormData();
            formData.append('recipient', $('#bespoke_license_popup').attr('data-recipient'));
            formData.append('message', offer.val());
            formData.append('type', 'first');
            if(email.length){
                formData.append('login_email', email.val());
            }
            if(password.length){
                formData.append('login_password', password.val());
            }

            $.ajax({

                url: "/bispoke-license/message/send",
                dataType: "json",
                type: 'post',
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.success == 1){
                        $('#bespoke_license_popup input,#bespoke_license_popup textarea').val('');
                        $('.stage_two #sender_name').text($('.each-music:first .thismusic_user_name').text());
                        $('.stage_two').removeClass('instant_hide');
                        $('.stage_one').addClass('instant_hide');
                    }else{
                        alert(response.error);
                    }
                }
            });
        }
    });

    $('#submit_reminder_login').click(function(){

        var thiss = $(this);
        $('#not_logged_in .error').addClass('instant_hide');
        var error = 0;

        var email = $('#not_logged_in #reminder_login_email');
        var password = $('#not_logged_in #reminder_login_password');

        if(email.length && email.val() == ''){ error = 1; $('#reminder_email_error').removeClass('instant_hide'); }
        if(password.length && password.val() == ''){ error = 1; $('#reminder_pass_error').removeClass('instant_hide'); }

        if(!error){

            var formData = new FormData();
            formData.append('login_email', email.val());
            formData.append('login_password', password.val());

            $.ajax({

                url: "/process-reminder-login",
                dataType: "json",
                type: 'post',
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.success == 1){
                        location.reload();
                    }else{
                        alert(response.error);
                    }
                }
            });
        }
    });

    $('#send_chat_message').click(function(){

        var thiss = $(this);
        $('#chat_message_popup .error').addClass('instant_hide');
        var error = 0;

        var email = $('#chat_message_popup #chat_message_login_email');
        var password = $('#chat_message_popup #chat_message_login_password');
        var message = $('#chat_message_popup #chat_message');

        if(email.length && email.val() == ''){ error = 1; $('#chat_message_email_error').removeClass('instant_hide'); }
        if(password.length && password.val() == ''){ error = 1; $('#chat_message_pass_error').removeClass('instant_hide'); }
        if(message.length && message.val() == ''){ error = 1; $('#chat_message_error').removeClass('instant_hide'); }

        if(!error){

            var formData = new FormData();
            formData.append('message', message.val());
            formData.append('type', '');
            if(email.length){
                formData.append('login_email', email.val());
            }
            if(password.length){
                formData.append('login_password', password.val());
            }

            formData.append('recipient_id', window.currentUserId);

            $.ajax({

                url: "/chat/sendMessage",
                dataType: "json",
                type: 'post',
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.success == 1){
                        $('#chat_message_popup input,#chat_message_popup textarea').val('');
                        $('.stage_two #sender_name').text(response.data.recipient_name);
                        $('.stage_two').removeClass('instant_hide');
                        $('.stage_one').addClass('instant_hide');
                    }else{
                        alert(response.error);
                    }
                }
            });
        }
    });

    // read more button

    $('body').delegate( "#read_more_button", "click", function(e){

        if($("#read_more").hasClass("read_more")){

            $("#read_more").removeClass("read_more");

            $(this).text("...LESS");

        }else{

            $("#read_more").addClass("read_more");

            $(this).text("...MORE");

        }

    });

    // read more button



    // chart page sharing button

    $(".cent_undo_btn,.top_info_right_icon,.tp_sec_share_video").click(function () {

        var error = 0;
        var dynamicLink = $('#video_share_link').val();

        if(dynamicLink == ''){ error = 1; }

        if(!error){

            loadMyDeferredImages($("#chart-sharing-popup img.prevent_pre_loading"));
            $("#chart-sharing-popup").show();
            $('#body-overlay').show();
        }
    });



    $('#profile_tab_06 .orders_bottom_arrow').click(function(e){

        e.preventDefault();

        var thisss = $(this);
        var thiss = $(this).parent().parent().find('.profile_orders_slide_win');
        $('#profile_tab_06').find('.profile_orders_slide_win').not(thiss).slideUp('slow');
        thiss.slideToggle('slow');

        $('#profile_tab_06 .orders_bottom_arrow').not(thisss).removeClass('opened').addClass('fa-angle-down');
        if(thisss.hasClass('opened')){

            thisss.removeClass('opened').addClass('fa-angle-down');
        }else{
            thisss.addClass('opened').removeClass('fa-angle-down');
        }
    });

    $('#profile_tab_14 .orders_bottom_arrow').click(function(e){

        e.preventDefault();

        var thisss = $(this);
        var thiss = $(this).parent().parent().find('.profile_orders_slide_win');
        $('#profile_tab_14').find('.profile_orders_slide_win').not(thiss).slideUp('slow');
        thiss.slideToggle('slow');

        $('#profile_tab_14 .orders_bottom_arrow').not(thisss).removeClass('opened').addClass('fa-angle-down');
        if(thisss.hasClass('opened')){

            thisss.removeClass('opened').addClass('fa-angle-down');
        }else{
            thisss.addClass('opened').removeClass('fa-angle-down');
        }
    });




    $('.return_to_top').click(function(e){



        e.preventDefault();

        $("html, body").animate({ scrollTop: 0 }, "slow");

    });



    $('.read_more_actual').click(function(e){



        e.preventDefault();

        $('.read_less_actual').show();

        $('.read_more_actual').hide();

        $('.proj_cntr_sumery_outer').addClass('story_height_restore');

    });

    $('.read_less_actual').click(function(e){



        e.preventDefault();

        $('.read_more_actual').show();

        $('.read_less_actual').hide();

        $('.proj_cntr_sumery_outer').removeClass('story_height_restore');

    });



    // top search ajax ..

    /*$('#top-search,#top-search-field-res').keyup(function(e) {



        e.preventDefault();

        var keyword = $(this).val();

        var searchElement = this.id;

        if( searchElement == 'top-search' ){ var searchContainer = $(this).parent().parent(); }

        else if( searchElement == 'top-search-field-res' ){ var searchContainer = $(this).parent(); }

        if( keyword.length > 0 ){

            $.get("/user-search", {keyword: keyword}, function (data) {



                if(data != ''){

                    searchContainer.find('.no-results').hide();

                    searchContainer.find('.search-users-list').html(data).show();

                    searchContainer.find('#search-result-bar').show();

                }else{



                    searchContainer.find('.search-users-list').hide();

                    searchContainer.find('.no-results').show();

                    searchContainer.find('#search-result-bar').show();

                }

            });

        }else{

            searchContainer.find("#search-result-bar").hide();

        }

    });*/



    $(document).on('click', function (e) {

        if ($(e.target).closest(".hdr_serch_outer").length === 0) {

            $(".top_search_result").hide();

            $(".top_search_result .no-results").hide();

        }

    });



    $('body').delegate( ".user-result", "click", function(e){

        window.location.href = this.dataset.urllink;

    });

    // top search ajax ..



    $('.pro_soc_icon_cloud').click( function(e){

        e.preventDefault();



        $('.pro_soundcloud_stay_tuned').show();

        $('#body-overlay').show();

    });



    /* user home page featured items slider starts*/

    $('.feat_template').css('display', 'none');

    $('#feat_slide_1').css('display', 'block');

    $('body').delegate( "#feat_nav_arrow_right", "click", function(){



        var currentFeatSlide = parseInt( $('.user_hm_rt_btm_otr #feat_current_slide').val() );

        var totalFeatSlides = parseInt( $('.user_hm_rt_btm_otr #feat_total_slides').val() );

        //$('.feat_template').css('display', 'none');

        if( currentFeatSlide < totalFeatSlides ){



            var newFeatSlide = currentFeatSlide + 1;

        }else{



            var newFeatSlide = 1;

        }

        $('#feat_slide_'+currentFeatSlide).fadeOut('slow', 'swing', function(){

            $('#feat_slide_'+newFeatSlide).fadeIn('fast');
            $('.user_hm_rt_btm_otr #feat_current_slide').val(newFeatSlide);
        });

        //$('#feat_slide_'+newFeatSlide).show("slide", { direction: "right" }, 500);

    });

    $('body').delegate( "#feat_nav_arrow_left", "click", function(){



        var currentFeatSlide = parseInt( $('.user_hm_rt_btm_otr #feat_current_slide').val() );

        var totalFeatSlides = parseInt( $('.user_hm_rt_btm_otr #feat_total_slides').val() );

        //$('.feat_template').css('display', 'none');

        if( currentFeatSlide > 1 ){



            var newFeatSlide = currentFeatSlide - 1;

        }else{



            var newFeatSlide = totalFeatSlides;

        }



        $('#feat_slide_'+currentFeatSlide).fadeOut('slow', 'swing', function(){

           $('#feat_slide_'+newFeatSlide).fadeIn('fast');
           $('.user_hm_rt_btm_otr #feat_current_slide').val(newFeatSlide);
        });

    });

    /* user home page featured items slider ends*/



    $(".popup_checkbox_label").click(function(e) {



        e.preventDefault();



        if( $(this).hasClass('unchecked') ){



            $(this).removeClass('unchecked');

            $(this).addClass('checked');

            $(this).find('input[type=checkbox]').attr("checked", true);

        }else{



            $(this).removeClass('checked');

            $(this).addClass('unchecked');

            $(this).find('input[type=checkbox]').attr("checked", false);

        }

    });

    $(".m_btm_edit").click(function(e) {



        var id = $(this).parent().parent().find('.m_btm_star ').attr('data-product-id');


    });



    $("#channel_tab_btn_01").click(function () {

        $(".tab_chanel_list_outer").after($(".user_products_outer"));

    });



    $("#channel_tab_btn_03").click(function () {

        $(".user_products_outer").after($(".tab_chanel_list_outer"));

    });



    // firsttime login close

    $(".firsttime_login_close").click(function () {

        $.get( "/updateFirsttimeLogin" , { value: 0 }, function(data) {



        });

    });





    $(".del-user-account").click(function () {

        var campaignAmount = this.dataset.campaignamount;

        var pastProjectsCount = this.dataset.pastprojectcount;

        if(campaignAmount == 0 && pastProjectsCount == 0) {

            loadMyDeferredImages($("#delete_account_popup img.prevent_pre_loading"));
            $("#delete_account_popup,#body-overlay").show();

        } else {

            loadMyDeferredImages($("#active_project_popup img.prevent_pre_loading"));
            $("#active_project_popup,#body-overlay").show();

        }

    });

    // firsttime login close



    $("#studio_account_type").change(function () {

        if( $(this).val() == "Yes, I need a  professional Studio account" ) {

            $("#register_studio_popup_1,#body-overlay").show();

        } else {

            $("#register_studio_popup_1, #body-overlay").hide();

            $("#personal_info_section").show();

            $("#account_type_lower_section").hide();

            $("#studio_info_section").hide();

        }

    });



    $("#register_studio_yes_1").click(function () {

            $("#register_studio_popup_1").hide();

            $("#register_studio_popup_2,#body-overlay").show();

    });



    $("#register_studio_yes_2").click(function () {

        $.get( "/activateStudioAccount" , {  }, function(data) {

            $("#register_studio_popup_2, #body-overlay").hide();

            $("#register_studio_section").hide();

            $("#register_studio_text_section").show();

            $("#personal_info_section").hide();

            $("#account_type_lower_section").show();

            $("#studio_info_section").show();

        });

    });



    var browseWidth = $( window ).width();

    if( browseWidth <= 767 ){



        $(window).scroll(function() {

            if ($(this).scrollTop() > 300) {

                $('#to_top').fadeIn('slow');

            } else {

                $('#to_top').fadeOut('slow');

            }

        });

    }

    $('#to_top').click(function(){



        $("html, body").animate({ scrollTop: 0 }, "slow");

    });

    $('.pro_plus_icon .icon').click(function(){

        var elem = $(this).parent().find('input').first();
        elem.focus();
        SetCaretAtEnd(elem);
        $('input[name=further_skills]').trigger('keyup');
    });

    $('.hdr_menu_item').mouseenter(function(){

        $(this).addClass('active');
    });

    $('.hdr_menu_item').mouseleave(function(){

        if(!$(this).hasClass('real_active')){
            $(this).removeClass('active');
        }
    });

    $('body').delegate('.double_card', 'click', function(e){

        var cardName = $(this).attr('id');
        if(cardName == 'double_card_chart'){
            window.location.href = '/chart';
        }
        if(cardName == 'double_card_tv'){
            window.location.href = '/tv';
        }
        if(cardName == 'double_card_studio'){
            window.location.href = '/live';
        }
        if(cardName == 'double_card_license'){
            window.location.href = '/search';
        }
        if(cardName == 'double_card_crowdfund'){

            if($('#share_current_page').length && $('#share_current_page').val() == 'userhome'){
                window.location.href = '/project/'+window.currentUserId;
            }else{
                window.location.href = '/crowdfund';
            }
        }
    });

    $('body').delegate('.card_pro_click', 'click', function(e){

        var link = $(this).attr('data-link');
        window.location.href = link;
    });

    $('body').delegate('.card_chart_winner', 'click', function(e){

        var cardName = $(this).attr('id');
        window.location.href = '/'+cardName;
    });


    $('body').delegate('.chat_outer:not(.disabled) #filter_none', 'click', function(e){

        $('.header_each_action').removeClass('active');
        $(this).addClass('active');
        $('.chat_each_message,.chat_join').removeClass('instant_hide');
    });
    $('body').delegate('.chat_outer:not(.disabled) #filter_agreements', 'click', function(e){

        $('.header_each_action').removeClass('active');
        $(this).addClass('active');
        $('.chat_each_message:not(.msg_agreement),.chat_join').addClass('instant_hide');
    });
    $('body').delegate('.chat_outer:not(.disabled) #refresh_messages', 'click', function(e){

        $('#loading_messages').removeClass('instant_hide');
        $('.chat_main_body_messages').html('');

        var formData = new FormData();
        formData.append('action', 'partners');
        refreshChatBox('full', formData);
    });
    $('body').delegate('.chat_outer:not(.disabled) #add_agreement_btn:not(.disabled)', 'click', function(e){

        var elem = $('.chat_each_user.active');
        if(elem.length && $('#profile_tab_14').length){

            $('#add_agreement_select_customer option').each(function() {
                if($(this).val() != ''){
                    $(this).remove();
                }
            });
            if(elem.hasClass('chat_each_group')){

                var main = elem.find('.inner .chat_user_pic');
                $('#add_agreement_select_customer').append($('<option>',{
                    value: main.attr('data-id'),
                    text : main.attr('data-name')
                }));

                elem.find('.chat_member_each_outer:not(.chat_member_add)').each(function(){

                    var value = $(this).attr('data-member');
                    var title = $(this).attr('data-name');
                    if(value != window.currentUserId){
                        $('#add_agreement_select_customer').append($('<option>',{
                            value: value,
                            text : title
                        }));
                    }
                });
            }else{
                $('#add_agreement_select_customer').append($('<option>',{
                    value: elem.attr('data-partner'),
                    text : elem.find('.chat_user_name').text()
                }));
            }

            $('#add_agreement_popup .stage_one input,#add_agreement_popup .stage_one textarea').val('');
            $('#add_agreement_popup .stage_two').addClass('instant_hide');
            $('#add_agreement_popup .stage_one').removeClass('instant_hide');

            var name = $('.chat_each_user.active:first .chat_user_name').text();
            $('#add_agreement_popup #add_agreement_customer_name').text(name);
            $('#add_agreement_popup,#body-overlay').show();
        }else{
            alert('You cannot add agreements yet');
        }
    });

    $('body').delegate('.chat_outer:not(.disabled) #add_product_btn:not(.disabled)', 'click', function(e){

        var elem = $('.chat_each_user.active');
        if(elem.length && $('#profile_tab_14').length){

            $('#add_product_select_customer option').each(function() {
                if($(this).val() != ''){
                    $(this).remove();
                }
            });
            if(elem.hasClass('chat_each_group')){

                var main = elem.find('.inner .chat_user_pic');
                $('#add_product_select_customer').append($('<option>',{
                    value: main.attr('data-id'),
                    text : main.attr('data-name')
                }));

                elem.find('.chat_member_each_outer:not(.chat_member_add)').each(function(){

                    var value = $(this).attr('data-member');
                    var title = $(this).attr('data-name');
                    if(value != window.currentUserId){
                        $('#add_product_select_customer').append($('<option>',{
                            value: value,
                            text : title
                        }));
                    }
                });
            }else{
                $('#add_product_select_customer').append($('<option>',{
                    value: elem.attr('data-partner'),
                    text : elem.find('.chat_user_name').text()
                }));
            }

            $('#add_product_popup .stage_two').addClass('instant_hide');
            $('#add_product_popup .stage_one').removeClass('instant_hide');

            var name = $('.chat_each_user.active:first .chat_user_name').text();
            $('#add_product_popup #add_product_customer_name').text(name);
            $('#add_product_popup,#body-overlay').show();
        }else{
            alert('You cannot offer a project yet');
        }
    });

    $('body').delegate('.chat_outer:not(.disabled) #proffer_project_btn:not(.disabled)', 'click', function(e){

        var elem = $('.chat_each_user.active');
        if(elem.length && $('#profile_tab_14').length){

            $('#proffer_project_select_customer option').each(function() {
                if($(this).val() != ''){
                    $(this).remove();
                }
            });
            if(elem.hasClass('chat_each_group')){

                var main = elem.find('.inner .chat_user_pic');
                $('#proffer_project_select_customer').append($('<option>',{
                    value: main.attr('data-id'),
                    text : main.attr('data-name')
                }));

                elem.find('.chat_member_each_outer:not(.chat_member_add)').each(function(){

                    var value = $(this).attr('data-member');
                    var title = $(this).attr('data-name');
                    if(value != window.currentUserId){
                        $('#proffer_project_select_customer').append($('<option>',{
                            value: value,
                            text : title
                        }));
                    }
                });
            }else{
                $('#proffer_project_select_customer').append($('<option>',{
                    value: elem.attr('data-partner'),
                    text : elem.find('.chat_user_name').text()
                }));
            }

            $('#proffer_project_popup .stage_one input,#proffer_project_popup .stage_one textarea').val('');
            $('#proffer_project_popup .stage_two').addClass('instant_hide');
            $('#proffer_project_popup .stage_one').removeClass('instant_hide');

            var name = $('.chat_each_user.active:first .chat_user_name').text();
            $('#proffer_project_popup #proffer_project_customer_name').text(name);
            $('#proffer_project_popup,#body-overlay').show();
        }else{
            alert('You cannot proffer a project yet');
        }
    });

    $('#send_add_agreement').click(function(){

        var thiss = $(this);
        $('#add_agreement_popup .error').addClass('instant_hide');
        var error = 0;

        var price = $('#add_agreement_popup #add_agreement_price');
        var terms = $('#add_agreement_popup #add_agreement_terms');
        var music = $('#add_agreement_popup #add_agreement_music');
        var endTerm = $('#add_agreement_popup #add_agreement_end_term');
        var endTermSelect = $('#add_agreement_popup #add_agreement_license_end_term');
        var license = $('#add_agreement_popup #add_agreement_license');
        var selectCustomer = $('#add_agreement_popup #add_agreement_select_customer');

        if(price.val() == ''){ error = 1; $('#add_agreement_price_error').removeClass('instant_hide'); }
        if(endTerm.val() == '' && endTermSelect.val() == 'custom'){ error = 1; $('#add_agreement_end_term_error').removeClass('instant_hide'); }
        if(endTermSelect.val() == ''){ error = 1; $('#add_agreement_license_end_term_error').removeClass('instant_hide'); }
        if(music.val() == '' || music.find('option').length == 0){ error = 1; $('#add_agreement_music_error').removeClass('instant_hide'); }
        if(selectCustomer.val() == ''){ error = 1; $('#add_agreement_select_customer_error').removeClass('instant_hide'); }

        if(!error){

            var formData = new FormData();
            formData.append('music', music.val());
            formData.append('terms', terms.val());
            formData.append('license', license.val());
            formData.append('endTermSelect', endTermSelect.val());
            formData.append('endTerm', endTerm.val());
            formData.append('price', price.val());

            var elem = $('.chat_each_user.active:first');
            if(elem.hasClass('chat_each_group')){
                var groupId = elem.attr('data-group');
                formData.append('group', groupId);
                formData.append('groupRecipient', selectCustomer.val());
            }else{
                var partnerId = elem.attr('data-partner');
                formData.append('recipient', partnerId);
            }

            $.ajax({

                url: "/bispoke-license/agreement/add",
                dataType: "json",
                type: 'post',
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.success == 1){
                        var name = selectCustomer.find('option:selected').text();
                        $('#add_agreement_popup .stage_two #sender_name').text(name);
                        $('#add_agreement_popup .stage_one').addClass('instant_hide');
                        $('#add_agreement_popup .stage_two').removeClass('instant_hide');
                        $('#add_agreement_popup input, #add_agreement_popup textarea').val('');

                        var formData = new FormData();
                        if(elem.hasClass('chat_each_group')){
                            formData.append('action', 'group-chat');
                            formData.append('group', groupId);
                        }else{
                            formData.append('action', 'partner-chat');
                            formData.append('partner', partnerId);
                        }
                        refreshChatBox('chat', formData);
                    }else{
                        alert(response.error);
                    }
                }
            });
        }
    });

    $('#send_add_product').click(function(){

        var thiss = $(this);
        $('#add_product_popup .error').addClass('instant_hide');
        var error = 0;

        var selectCustomer = $('#add_product_popup #add_product_select_customer');
        var selectProduct = $('#add_product_popup #add_product_select_product');
        var price = $('#add_product_popup #add_product_price');

        if(selectProduct.val() == ''){ error = 1; $('#add_product_select_product_error').removeClass('instant_hide'); }
        if(price.val() == ''){ error = 1; $('#add_product_price_error').removeClass('instant_hide'); }
        if(selectCustomer.val() == ''){ error = 1; $('#add_product_select_customer_error').removeClass('instant_hide'); }

        if(!error){

            var formData = new FormData();
            var elem = $('.chat_each_user.active:first');
            if(elem.hasClass('chat_each_group')){
                var groupId = elem.attr('data-group');
                formData.append('group', groupId);
                formData.append('groupRecipient', selectCustomer.val());
            }else{
                var partnerId = elem.attr('data-partner');
                formData.append('recipient', partnerId);
            }

            formData.append('product', selectProduct.val());
            formData.append('price', price.val());

            $.ajax({

                url: "/proffer-product/add",
                dataType: "json",
                type: 'post',
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.success == 1){
                        var name = selectCustomer.find('option:selected').text();
                        $('#add_product_popup .stage_two #add_product_customer_name').text(name);
                        $('#add_product_popup .stage_one').addClass('instant_hide');
                        $('#add_product_popup .stage_two').removeClass('instant_hide');
                        $('#add_product_popup input').val('');

                        var formData = new FormData();
                        if(elem.hasClass('chat_each_group')){
                            formData.append('action', 'group-chat');
                            formData.append('group', groupId);
                        }else{
                            formData.append('action', 'partner-chat');
                            formData.append('partner', partnerId);
                        }
                        refreshChatBox('chat', formData);
                    }else{
                        alert(data.error);
                    }
                }
            });
        }
    });

    $('#send_proffer_project').click(function(){

        var thiss = $(this);
        $('#proffer_project_popup .error').addClass('instant_hide');
        var error = 0;

        var title = $('#proffer_project_popup #proffer_project_title');
        var price = $('#proffer_project_popup #proffer_project_price');
        var description = $('#proffer_project_popup #proffer_project_description');
        var endTerm = $('#proffer_project_popup #proffer_project_end_term');
        var endTermSelect = $('#proffer_project_popup #proffer_project_select_end_term');
        var selectCustomer = $('#proffer_project_popup #proffer_project_select_customer');

        if(title.val() == ''){ error = 1; $('#proffer_project_title_error').removeClass('instant_hide'); }
        if(price.val() == ''){ error = 1; $('#proffer_project_price_error').removeClass('instant_hide'); }
        if(endTerm.val() == '' && endTermSelect.val() == 'custom'){ error = 1; $('#proffer_project_end_term_error').removeClass('instant_hide'); }
        if(endTermSelect.val() == ''){ error = 1; $('#proffer_project_end_term_select_error').removeClass('instant_hide'); }
        if(selectCustomer.val() == ''){ error = 1; $('#proffer_project_select_customer_error').removeClass('instant_hide'); }

        if(!error){

            var formData = new FormData();
            var elem = $('.chat_each_user.active:first');
            if(elem.hasClass('chat_each_group')){
                var groupId = elem.attr('data-group');
                formData.append('group', groupId);
                formData.append('groupRecipient', selectCustomer.val());
            }else{
                var partnerId = elem.attr('data-partner');
                formData.append('recipient', partnerId);
            }

            formData.append('title', title.val());
            formData.append('description', description.val());
            formData.append('endTermSelect', endTermSelect.val());
            formData.append('endTerm', endTerm.val());
            formData.append('price', price.val());


            $.ajax({

                url: "/proffer-project/add",
                dataType: "json",
                type: 'post',
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.success == 1){
                        var name = selectCustomer.find('option:selected').text();
                        $('#proffer_project_popup .stage_two #sender_name').text(name);
                        $('#proffer_project_popup .stage_one').addClass('instant_hide');
                        $('#proffer_project_popup .stage_two').removeClass('instant_hide');
                        $('#proffer_project_popup input, #proffer_project_popup textarea').val('');

                        var formData = new FormData();
                        if(elem.hasClass('chat_each_group')){
                            formData.append('action', 'group-chat');
                            formData.append('group', groupId);
                        }else{
                            formData.append('action', 'partner-chat');
                            formData.append('partner', partnerId);
                        }
                        refreshChatBox('chat', formData);
                    }else{
                        alert(response.error);
                    }
                }
            });
        }
    });

    $('body').delegate('.chat_outer:not(.disabled) .chat_each_user.chat_navigator', 'click', function(e){

        var type = $(this).attr('data-type');
        var id = $(this).attr('data-navigate');
        if(type == 'group'){
            var target = $('.chat_each_user[data-group="'+id+'"]');
        }

        target.trigger('click');
    });

    $('body').delegate('.chat_outer:not(.disabled) .chat_each_user:not(.chat_navigator)', 'click', function(e){

        e.preventDefault();
        var thiss = $(this);
        var error = 0;

        if(thiss.hasClass('chat_each_admin')){

            if(thiss.hasClass('protected')){
                $('#body-overlay,#agent_chat_locked').show();
                error = 1;
            }else{
                $('#add_agreement_btn,#proffer_project_btn,#add_product_btn').addClass('disabled');
            }
        }else{

            $('#add_agreement_btn,#proffer_project_btn,#add_product_btn').removeClass('disabled');
        }

        if(!error){

            $('#loading_messages').removeClass('instant_hide');
            $('.chat_main_body_messages').html('');
            if($('#profile_tab_14').length){

                var partner = thiss.attr('data-partner');
                var groupId = thiss.attr('data-group');
                var formData = new FormData();
                var name = thiss.find('.chat_user_name').text();

                if(thiss.hasClass('chat_each_group')){
                    formData.append('group', groupId);
                    formData.append('action', 'group-chat');
                }else{
                    formData.append('partner', partner);
                    formData.append('action', 'partner-chat');
                }
                refreshChatBox('chat', formData, thiss);
                $('.chat_head_name').text(name);
                $('#new_message').val('');
            }else if($('#admin_chat').length){

                var formData = new FormData();
                var name = thiss.find('.chat_user_name').text();
                formData.append('action', 'admin-pair-chat');
                formData.append('pair', thiss.attr('data-sender-id')+':'+thiss.attr('data-recipient-id'));
                refreshChatBox('chat', formData, thiss);
                $('.chat_head_name').text(thiss.find('.chat_user_name:first').text()+' - '+thiss.find('.chat_user_name:last').text());
            }
        }

    });

    $('#chat_attachments').change(function(){

        if(this.files && this.files[0]){
            for(var i = 0; i < this.files.length; i++){
                if(this.files[i].type == 'image/jpeg' || this.files[i].type == 'image/png'){
                    if(this.files[i].size > 5*1024*1024){
                        alert('Your file '+this.files[i].name+' is more than 5MB');
                    }else{
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[i]);
                    }
                }else{
                    if(this.files[i].size > 100*1024*1024){
                        alert('Your file '+this.files[i].name+' is more than 5MB');
                    }else{
                        var extension = this.files[i].name.split('.').pop();
                        $('.attachment_area').append('<div class="each_attach file"><div class="up">File</div><div class="down"><i class="fa fa-file-o"></i></div></div>');
                        $('.chat_main_body_foot').addClass('attachment');
                        $('#new_message').focus();
                    }
                }
            }
        }else{

        }
    });

    $('.chat_main_body_attach').click(function(e){

        e.preventDefault();
        $('#chat_attachments').trigger('click');
    });

    $('.attachment_area .close').click(function(){

        $('#chat_attachments').val('');
        $('.attachment_area .each_attach').remove();
        $('.chat_main_body_foot').removeClass('attachment');
    });

    $('body').delegate('.attachment_visi .each_attach_visi', 'click', function(e){

        if($(this).attr('data-type') == 'image'){
            var src = $(this).find('img').attr('src');
            $('.attach_expand_wrapper .attach_wrap_in .download').attr('href', src);
            $('.attach_expand_wrapper .attach_wrap_in img').attr('src', src);
            $('.attach_expand_wrapper').removeClass('instant_hide');
        }else{
            var down = $(this).attr('data-download');
            $('.attach_expand_wrapper .attach_wrap_in .download').attr('href', 'https://drive.google.com/uc?id='+down+'&export=download')
            $('.attach_expand_wrapper .attach_wrap_in .download')[0].click();
        }
    });

    $('body').delegate('.attach_expand_wrapper .action.close', 'click', function(e){

        $('.attach_expand_wrapper .attach_wrap_in .download').attr('href', 'javascript:void(0)');
        $('.attach_expand_wrapper .attach_wrap_in img').attr('src', '');
        $('.attach_expand_wrapper').addClass('instant_hide');
    });

    $('body').delegate('.chat_outer:not(.disabled) #submit_btn:not(.disabled)', 'click', function(e){

        if($('.chat_each_user.active').length){

            var message = $('#new_message');
            var attachments = $('#chat_attachments');
            if((message.val() != '') || (message.val() == '' && attachments.val() != '')){

                $('.chat_outer #submit_btn').addClass('disabled');
                var totalFiles = document.getElementById('chat_attachments').files.length;

                if(totalFiles > 0){

                    prepareChatUploader();
                    $('.pro_pop_chat_upload,#body-overlay').show();
                    startChatUploader();
                }else{

                    var formData = new FormData();

                    if($('#profile_tab_14').length){

                        var elem = $('.chat_each_user.active:first');
                        if(elem.hasClass('chat_each_group')){
                            var groupId = elem.attr('data-group');
                            formData.append('group', groupId);
                        }else{
                            var partnerId = elem.attr('data-partner');
                            formData.append('recipient', partnerId);
                        }

                        formData.append('message', message.val());

                        $.ajax({

                            url: '/bispoke-license/message/send',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            success: function (response) {

                                $('.chat_outer #submit_btn').removeClass('disabled');

                                if(response.success){

                                    $('.attachment_area .close').trigger('click');

                                    var formData = new FormData();
                                    if(elem.hasClass('chat_each_group')){
                                        formData.append('action', 'group-chat');
                                        formData.append('group', groupId);
                                    }else{
                                        formData.append('action', 'partner-chat');
                                        formData.append('partner', partnerId);
                                    }
                                    refreshChatBox('chat', formData);
                                    $('#new_message').val('').change();
                                }else{
                                    alert(response.error);
                                    $('#new_message').val('').change();
                                }
                            }
                        });
                    }else if($('#admin_chat').length){

                        var pair = $('.chat_each_user.active').attr('data-sender-id')+':'+$('.chat_each_user.active').attr('data-recipient-id');
                        var formData = new FormData();
                        formData.append('message', message.val());
                        formData.append('pair', pair);
                        $.ajax({

                            url: '/chat/admin/sendMessage',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            success: function (response) {
                                if(response.success){
                                    var formData = new FormData();
                                    formData.append('action', 'admin-pair-chat');
                                    formData.append('pair', pair);
                                    refreshChatBox('chat', formData, $('.chat_each_user.active'));
                                    $('#new_message').val('').change();
                                }
                            }
                        });
                    }
                }
            }else{
                alert('message cannot be empty');
            }
        }else{
            alert('You cannot send messages yet');
        }
    });

    if($('#profile_tab_14').length || $('#admin_chat').length) {

        $('#loading_messages').removeClass('instant_hide');
        var formData = new FormData();
        if($('#profile_tab_14').length){
            formData.append('action', 'partners');
        }else{
            formData.append('action', 'admin_chat');
        }

        if(sessionStorage.getItem('pagecontentopener') && sessionStorage.getItem('pagecontentopener') != '' && (sessionStorage.getItem('pagecontentopener').indexOf('group_') !== -1 || sessionStorage.getItem('pagecontentopener').indexOf('partner_') !== -1)){
            formData.append('conversation', sessionStorage.getItem('pagecontentopener'));
            sessionStorage.removeItem('pagecontentopener');
        }

        refreshChatBox('full', formData);
    }

    if($('.notif_item').length || $('#notif_icon_resp').length) {

        setTimeout(refreshNotificationsBox, 30000);
    }

    if($('.notif_service').length) {

        setTimeout(startNotificationsService, 10000);
    }

    $('.chat_switch_outer .smart_switch input').change(function(){

        if($(this).prop("checked") == true){
            var value = 1;
        }else{
            var value = 0;
        }

        var formData = new FormData();
        formData.append('value', value);
        $.ajax({

            url: '/update-user-chat-switch',
            type: 'POST',
            data: formData,
            contentType:false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (response) {

                if(response){

                    if(value == 1){
                        $('.chat_outer').removeClass('disabled');
                    }else{
                        $('.chat_outer').addClass('disabled');
                    }
                }
            }
        });
    });

    $('body').delegate('.chat_outer:not(.disabled) #search_senders', 'keyup', function(e){
        var searchStr = $(this).val().toLowerCase();
        if(searchStr.length > 0){
            $('.chat_each_user:not(.chat_each_admin)').each(function(e){
                if($(this).find('.chat_user_name').text().toLowerCase().indexOf(searchStr) == -1){
                    $(this).addClass('instant_hide');
                }else{
                    $(this).removeClass('instant_hide');
                }
            });
        }else if(searchStr.length == 0){
            $('.chat_each_user').removeClass('instant_hide');
        }
    });

    $('body').delegate('.m_btm_filter_search_field', 'keyup', function(e){
        var searchStr = $(this).val().toLowerCase();
        var target = $(this).attr('data-target');
        if(searchStr.length > 0){
            $('.'+target).each(function(e){
                if($(this).find('.filter_search_target').text().toLowerCase().indexOf(searchStr) == -1){
                    $(this).addClass('instant_hide');
                }else{
                    $(this).removeClass('instant_hide');
                }
            });
        }else if(searchStr.length == 0){
            $('.'+target).removeClass('instant_hide');
        }
    });

    $('.m_btm_filter_dropdown').change(function(){

        var val = $(this).val();
        var target = $(this).attr('data-target');
        if(val == 'all' || val == ''){

            $('.'+target).removeClass('instant_hide');
        }else if(val == 'All Approved'){

            $('.'+target).each(function(e){
                if($(this).attr('data-approved') == '1'){
                    $(this).removeClass('instant_hide');
                }else{
                    $(this).addClass('instant_hide');
                }
            });
        }else if(val == 'All Unapproved'){

            $('.'+target).each(function(e){
                if($(this).attr('data-approved') == ''){
                    $(this).removeClass('instant_hide');
                }else{
                    $(this).addClass('instant_hide');
                }
            });
        }
    });

    $('body').delegate('.chat_each_user.active.unread', 'click', function(e){

        $(this).removeClass('unread');
    });

    $('body').delegate('.private-music', 'click', function(e){

        var id = $(this).attr('data-musicid');
        var type = $(this).attr('data-type');
        $('#private_music_unlock_popup').attr({ 'data-type': type, 'data-music-id': id });
        $('#private_music_unlock_popup,#body-overlay').show();
    });

    $('#unlock_private_music').click(function(){

        var id = $('#private_music_unlock_popup').attr('data-music-id');
        var type = $('#private_music_unlock_popup').attr('data-type');
        var pin = $('#private_music_unlock_popup #unlock_pin').val();
        var mode = $('#private_music_unlock_popup').attr('data-mode');
        $('#private_music_unlock_popup .error').addClass('instant_hide');
        if(id != ''){

            if(pin != ''){

                var formData = new FormData();
                formData.append('id', id);
                formData.append('pin', pin);
                formData.append('type', type);
                formData.append('mode', mode);
                $.ajax({

                    url: '/unlock-user-private-music',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (response) {
                        if(response.success){

                            $('#private_music_unlock_popup').attr({'data-type': '', 'data-music-id': ''});
                            $('#private_music_unlock_popup #unlock_pin').val('');
                            $('#private_music_unlock_popup,#body-overlay').hide();

                            if(type == 'music'){
                                if(mode == '0'){
                                    $('.user_musics_outer .private-music[data-musicid="'+id+'"]').replaceWith(response.musicHTML);
                                    $('.user_musics_outer .each-music[data-musicid="'+id+'"] .summary').trigger('click');
                                }else if(mode == '1'){
                                    $('.item_container').replaceWith(response.musicHTML);
                                }
                            }
                            if(type == 'album-music'){
                                $('.user_album_outer .private-music[data-musicid="'+id+'"]').replaceWith(response.musicHTML);
                                $('.user_album_outer .each-album-music[data-musicid="'+id+'"] .summary').trigger('click');
                            }
                        }else{

                            alert(response.error);
                        }
                    }
                });
            }else{

                $('#private_music_unlock_popup #unlock_pin_error').removeClass('instant_hide');
            }
        }
    });

    $('#join_chat_btn').click(function(){

        if(!$(this).hasClass('disabled')){

            if(confirm('Do you want to join this conversation?')){

                var pair = $('.chat_each_user.active').attr('data-sender-id')+':'+$('.chat_each_user.active').attr('data-recipient-id');
                var formData = new FormData();
                formData.append('id', window.currentUserId);
                formData.append('pair', pair);
                $.ajax({

                    url: '/chat/admin/join',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (response) {
                        if(response.success){

                            var formData = new FormData();
                            formData.append('action', 'admin-pair-chat');
                            formData.append('pair', pair);
                            refreshChatBox('chat', formData, $('.chat_each_user.active'));
                        }else{

                            alert(response.error);
                        }
                    }
                });
            }
        }

    });

    $('.int_sub_nav_btn').click(function(){
        var thiss = $(this);
        var cons = $('.int_sub_each:first').outerWidth();

        if(thiss.hasClass('int_nav_btn_prev')){

            var position = $('.int_sub_act_outer').scrollLeft() - 5 - cons;

        }else if(thiss.hasClass('int_nav_btn_next')){

            var position = $('.int_sub_act_outer').scrollLeft() + 5 + cons;
        }

        $('.int_sub_act_outer').animate({
            scrollLeft: position
        }, 400);
    });

    $('.int_sub_term_each').click(function(){
        $(this).parent().find('.int_sub_term_each').removeClass('active');
        $(this).addClass('active');

        var price = $(this).attr('data-price');
        var term = $(this).attr('data-term');

        $(this).closest('.int_sub_each').find('.int_sub_dhead .inner p').text(price);
        $(this).closest('.int_sub_each').find('.int_sub_dhead .int_sub_dhead_interval').text('per '+term);
    });

    $('body').delegate('#service_store_anchor:not(.disabled)', 'click', function(e){

        var thiss = $(this);
        if(thiss.closest('.services_outer').find('.user_service_hide').length){

            window.location.href = thiss.closest('.services_outer').attr('data-user-link');
        }else{

            $('.user_short_tab_each.st_tb').trigger('click');
        }
    });

    $('body').delegate('#service_chat_anchor:not(.disabled)', 'click', function(e){

        $('#body-overlay,#chat_message_popup').show();
    });

    $('.user_services_opener').click(function(){

        var thiss = $(this);
        var id = thiss.attr('data-id');

        if($('.services_outer[data-user-id='+id+']').length){
            $([document.documentElement, document.body]).animate({
                scrollTop: $('.services_outer[data-user-id='+id+']').first().offset().top - 70
            }, 1000);

            window.currentUserId = id;
        }else{

            $.ajax({
                url: "/informationFinder",
                dataType: "json",
                type: 'post',
                data: {'find_type': 'user_services_panel', 'find': id, 'identity_type': '', 'identity': ''},
                success: function(response) {
                    if(response.success == 1){
                        $('.search_right_outer').prepend(response.data.html);
                        window.currentUserId = id;
                    }
                }
            });
        }
    });

    $('body').delegate('.user_service_hide', 'click', function(e){

        $(this).closest('.services_outer').remove();
    });

    $('.feat_view_album').click(function(){

        if($('.user_short_tab_each[data-target-id="2"]').hasClass('true_active')){

            $('html, body').animate({scrollTop: $('.each_music_head[data-id="albums"]').offset().top - 100}, 500, function(){

                $('.each_music_head[data-id="albums"]').trigger('click');
            });
        }else{

            $('.user_short_tab_each[data-target-id="2"]').trigger('click');
            window.postUserTabLoad = '.each_music_head[data-id="albums"]';
        }
    });

    $('body').delegate('#pay_quick_final:not(.disabled)', 'click', function(e){

        initiateInstantPayment(window.stripe, window.eCardNumber);
    });

    $('.music_bottom_load_thumb').click(function(){

        $(this).addClass('instant_hide');
        var src = $(this).closest('.music_btm_thumb').attr('data-image');
        var img = '<img src="'+src+'">';
        $(this).closest('.music_btm_thumb').append(img);
    });

    $('body').delegate('.port_add_basket:not(.disabled)', 'click', function(e){

        var id = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        var price = atob($(this).attr('data-price'));
        if(type == 'product'){
            if(price == 'poa'){
                $('#body-overlay,#chat_message_popup').show();
            }else{
                $(this).addClass('disabled');
                var purchase_type = 'product';
                var music_id = 0;
                var product_id = id;
                var basket_user_id = window.currentUserId;
                var album_id = 0;
                var basket_license = '';
                var basket_price = price;
                addCartItem(basket_license, purchase_type, music_id, product_id, album_id, basket_price, basket_user_id, 0);
            }
        }
    });

    $('.edit_elem_close').click(function(){

        $(this).closest('form').hide();
    });

    $('.edit_elem_sort_down:not(.disabled),.edit_elem_sort_up:not(.disabled)').click(function(){

        var thiss = $(this);
        var element = thiss.closest('.elem_sortable');
        var formData = new FormData();

        formData.append('element', element.attr('data-sort'));
        if(thiss.hasClass('edit_elem_sort_down') && element.next().length && element.next().hasClass('elem_sortable')){
            var action = 'down';
            formData.append('adjacent', element.next().attr('data-sort'));
        }else if(thiss.hasClass('edit_elem_sort_up') && element.prev().length && element.prev().hasClass('elem_sortable')){
            var action = 'up';
            formData.append('adjacent', element.prev().attr('data-sort'));
        }else{
            var action = '';
        }
        if(action != ''){
            thiss.addClass('disabled');
            $.ajax({

                url: '/sort-items',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    if(response.success){
                        if(action == 'up'){
                            element.prev().insertAfter(element);
                        }else{
                            element.next().insertBefore(element);
                        }
                    }
                },
                complete: function() {
                    thiss.removeClass('disabled');
                }
            });
        }
    });

    $('.pro_price_timer .pro_action_btn.add_timer').click(function(){

        $(this).closest('.pro_price_timer').find('.pro_price_timer_body').toggleClass('instant_hide');
    });

    $('.pro_price_timer .pro_action_btn.remove_timer').click(function(){

        if(confirm('Remove special price for this product? If so, click Ok and then submit')){
            $(this).closest('.pro_price_timer').remove();
        }
    });

    $('#pro_fill_email_submit').click(function(){

        var fillEmail = $('#pro_fill_email_address');
        var fillPassword = $('#pro_fill_password');
        var error = 0;

        if(fillEmail.val() == ''){
            $('#pro_fill_email_error').text('Required').removeClass('instant_hide');
            error = 1;
        }
        if(fillPassword.length && fillPassword.val() == ''){
            $('#pro_fill_password_error').text('Required').removeClass('instant_hide');
            error = 1;
        }

        if(!error){
            var formData = new FormData();
            formData.append('pro_fill_email', fillEmail.val());
            if(fillPassword.length){
                formData.append('pro_fill_password', fillPassword.val());
            }
            $.ajax({

                url: '/updateUserEmailPassword',
                type: 'POST',
                data: formData,
                cache: false,
                dataType: 'json',
                async: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    if(response.success == '1'){

                        location.reload();
                    }else{
                        alert(response.error);
                    }
                }
            });
        }
    });

    $('body').delegate('.stream_share', 'click', function(e){

        var thiss = $(this);
        var stream = thiss.closest('.each_stream_outer');
        var baseUrl = $('#base_url').val();
        var videoTitleFormatted = stream.find('.stream_title').text().replace(/[^\w\s!?]/g, ' ');
        var vLink = baseUrl+'video-share/'+stream.attr('data-id')+'/'+encodeURIComponent(videoTitleFormatted)+'/'+$('#share_current_page').val()+'_0';
        $('.top_info_right_icon').removeClass('instant_hide');
        $('#video_share_title').val(videoTitleFormatted);
        $('#video_share_link').val(vLink);

        loadMyDeferredImages($("#chart-sharing-popup img.prevent_pre_loading"));
        $('#chart-sharing-popup,#body-overlay').show();
    });

    $('body').delegate('.item_share,.product_share', 'click', function(e){

        var thiss = $(this);
        var platform = $('#platform').val();
        $('#share_item_toast').hide();
        if(thiss.hasClass('item_share')){
        	$('#share_item_toast').find('.message').html('Music Share');
        }else if(thiss.hasClass('product_share')){
        	$('#share_item_toast').find('.message').html('Product Share');
        }
        if(platform != '2'){
        	$('#share_item_toast #share_item_mobile_menu').remove();
        }

        $('#share_item_toast').attr('data-item-id', thiss.attr('data-item')).slideDown('fast');
    });

    $('#share_item_mobile_menu').click(function(){

        var baseUrl = $('#base_url').val();
        var itemId = $(this).closest('#share_item_toast').attr('data-item-id');
        var item = $('.item_share[data-item="'+itemId+'"]');
        if(item.length == 0){
        	var item = $('.product_share[data-item="'+itemId+'"]');
        }
        var url = baseUrl+'/'+item.attr('data-opd')+'/'+item.attr('data-type')+'/'+itemId+'/'+item.attr('data-slug');
        var title = item.attr('data-title');

        navigator
            .share({
                title: document.title,
                text: title,
                url: url
            })
            .then(() => console.log('Successful share! 🎉'))
            .catch(err => console.error(err));
    });

    $('#share_item_fb').click(function(){

        var baseUrl = $('#base_url').val();
        baseUrl = baseUrl.replace(/\/$/, '');
        var itemId = $(this).closest('#share_item_toast').attr('data-item-id');
        var item = $('.item_share[data-item="'+itemId+'"]');
        if(item.length == 0){
        	var item = $('.product_share[data-item="'+itemId+'"]');
        }
        var url = baseUrl+'/'+item.attr('data-type')+'/'+item.attr('data-slug');
        var title = item.attr('data-title');
        $('#item_share_link').val(url);
        $('#item_share_title').val(title);

        facebookShare('item');
    });

    $('#share_item_tw').click(function(){

        var baseUrl = $('#base_url').val();
        baseUrl = baseUrl.replace(/\/$/, '');
        var itemId = $(this).closest('#share_item_toast').attr('data-item-id');
        var item = $('.item_share[data-item="'+itemId+'"]');
        if(item.length == 0){
        	var item = $('.product_share[data-item="'+itemId+'"]');
        }
        var url = baseUrl+'/'+item.attr('data-type')+'/'+item.attr('data-slug');
        var title = item.attr('data-title');
        $('#item_share_link').val(url);
        $('#item_share_title').val(title);

        twitterShare('item');
    });

    $('#share_item_copy').click(function(){

        var baseUrl = $('#base_url').val();
        baseUrl = baseUrl.replace(/\/$/, '');
        var itemId = $(this).closest('#share_item_toast').attr('data-item-id');
        var item = $('.item_share[data-item="'+itemId+'"]');
        if(item.length == 0){
        	var item = $('.product_share[data-item="'+itemId+'"]');
        }
        var url = baseUrl+'/'+item.attr('data-type')+'/'+item.attr('data-slug');

        copyToClipboard(url);
        $('#share_item_toast #close').trigger('click');
    });

    $('#pay_quick_proceed_checkout').click(function(){

        var error = 0;
        $('#pay_quick_error').addClass('instant_hide');
        if($('#pay_quick_popup #pay_quick_name').length && $('#pay_quick_popup #pay_quick_name').val() == ''){

            $('#pay_quick_error').removeClass('instant_hide').text('Your name is required');
            error = 1;
        }else if($('#pay_quick_popup #pay_quick_email').length && $('#pay_quick_popup #pay_quick_email').val() == ''){

            $('#pay_quick_error').removeClass('instant_hide').text('Your email is required');
            error = 1;
        }else if($('#pay_quick_popup #pay_quick_shipping_address_line').length && $('#pay_quick_popup #pay_quick_shipping_address_line').val() == ''){

            $('#pay_quick_error').removeClass('instant_hide').text('Shipping address is required');
            error = 1;
        }else if($('#pay_quick_popup #pay_quick_shipping_city').length && $('#pay_quick_popup #pay_quick_shipping_city').val() == ''){

            $('#pay_quick_error').removeClass('instant_hide').text('Shipping city is required');
            error = 1;
        }else if($('#pay_quick_popup #pay_quick_shipping_postcode').length && $('#pay_quick_popup #pay_quick_shipping_postcode').val() == ''){

            $('#pay_quick_error').removeClass('instant_hide').text('Shipping postcode is required');
            error = 1;
        }else if($('#pay_quick_popup #pay_quick_shipping_country').length && $('#pay_quick_popup #pay_quick_shipping_country').val() == ''){

            $('#pay_quick_error').removeClass('instant_hide').text('Shipping country is required');
            error = 1;
        }

        if(!error){

            var thiss = $(this);
            var id = thiss.closest('#pay_quick_popup').attr('data-id');
            var split = id.split('_');
            var identity = $('#pay_quick_popup #pay_quick_shipping_country').val();
            var product = $('.tot_awe_pro_outer .add_basket_btn[data-productid="'+split[2]+'"]');
            $.ajax({
                url: "/informationFinder",
                dataType: "json",
                type: 'post',
                data: {'find_type': 'pod_delivery_cost', 'find': split[2], 'identity_type': 'pod_buyer', 'identity': identity},
                success: function(response) {
                    if(response.success == 1){
                        var deliveryCost = response.data.deliveryCost;
                        var curr = response.data.currencySym;
                        var price = product.attr('data-basketprice');
                        var quantity = product.closest('.tot_awe_pro_outer').find('.tot_awe_pro_qua').val();
                        var subTotal = quantity * price;
                        var grandTotal = subTotal + deliveryCost;

                        $('#pay_quick_popup .item_price_subtotal .item_price_sec_val_sym').text(curr);
                        $('#pay_quick_popup .item_price_subtotal .item_price_sec_val_num').text(subTotal.toFixed(2));
                        $('#pay_quick_popup .item_price_shipping .item_price_sec_val_sym').text(curr);
                        $('#pay_quick_popup .item_price_shipping .item_price_sec_val_num').text(deliveryCost.toFixed(2));
                        $('#pay_quick_popup .item_price_grand_total .item_price_sec_val_sym').text(curr);
                        $('#pay_quick_popup .item_price_grand_total .item_price_sec_val_num').text(grandTotal.toFixed(2));
                        $('#pay_quick_popup .stage_one').addClass('instant_hide');
                        $('#pay_quick_popup .stage_two').removeClass('instant_hide');
                    }
                }
            });
        }
    });

    $('body').delegate('.tot_awe_color_each', 'click', function(e){

        $(this).closest('.tot_awe_colors_in').find('.tot_awe_color_each').removeClass('active');
        $(this).addClass('active');
        $(this).closest('.tot_awe_pro_outer').find('.user_product_img_thumb img').attr('src', $(this).attr('data-image')).attr('data-src', $(this).attr('data-image'));
    });

    $('body').delegate('.tot_awe_pro_expand', 'click', function(e){

        var src = $(this).closest('.tot_awe_pro_outer').find('.user_product_img_thumb img').attr('src');
        $('#product_full_image_popup img').attr('src', src);
        $('#product_full_image_popup,#body-overlay').show();
    });

    $('#pay_quick_popup .edit_shipping_address').click(function(){

        $('#pay_quick_popup .stage_one').removeClass('instant_hide');
        $('#pay_quick_popup .stage_two').addClass('instant_hide');
    });

    $('.pay_item_purchase_qua_add,.pay_item_purchase_qua_subt').click(function(){

        var thiss = $(this);
        var error = 0;
        var popup = $('#pay_quick_popup');
        var id = popup.attr('data-id');
        var explode = id.split('_');
        var productId = explode[2];
        var productElem = $('.add_basket_btn[data-productid="'+productId+'"]').closest('.tot_awe_pro_outer');
        var price = parseInt(productElem.find('.add_basket_btn').attr('data-basketprice'));
        var quantity = parseInt(popup.find('.pay_item_purchase_qua .pay_item_purchase_qua_num').text());
        if(!isNaN(quantity) && thiss.hasClass('pay_item_purchase_qua_add')){
            var newQuantity = quantity + 1;
        }else if(!isNaN(quantity) && thiss.hasClass('pay_item_purchase_qua_subt') && quantity > 1){
            var newQuantity = quantity - 1;
        }else{
            error = 1;
        }

        if(!error){
            $('.pay_item_purchase_qua_num').text(newQuantity);
            productElem.find('.tot_awe_pro_qua').val(newQuantity);
            var subTotal = price * newQuantity;
            var shippingCost = parseInt(popup.find('.item_price_shipping .item_price_sec_val_num').text());
            var grandTotal = shippingCost + subTotal;

            popup.find('.item_price_subtotal .item_price_sec_val_num').text(subTotal.toFixed(2));
            popup.find('.item_price_shipping .item_price_sec_val_num').text(shippingCost.toFixed(2));
            popup.find('.item_price_grand_total .item_price_sec_val_num').text(grandTotal.toFixed(2));
        }
    });


    $('.hdr_left_menu_item .cart_item, #cart_icon_resp, #continue_browse').on("click", function(e){
        var imgDefer = $('.hrd_cart_outer img.lazy_loading');
        for (var i=0; i<imgDefer.length; i++) {
            if(imgDefer[i].getAttribute('data-src')) {
                imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
            }
        }
        $('.hrd_cart_outer').toggleClass('active');
        $('body').toggleClass('lock_page');
        $('#body-overlay').toggle();
    });
    $('.hdr_left_menu_item .menu_item, #menu_icon_resp, #continue_browse_menu').on("click", function(e){
        $('.hrd_usr_men_outer').toggleClass('active');
        $('body').toggleClass('lock_page');
        $('#body-overlay').toggle();
    });
    $('.hdr_left_menu_item .notif_item, #notif_icon_resp, #continue_browse_notif').on("click", function(e){
        $('.hrd_notif_outer').toggleClass('active');
        $('body').toggleClass('lock_page');
        $('#body-overlay').toggle();
    });
    $('body').delegate('#tab2 .each_music_head,#tabd2 .each_music_head', 'click', function(e){
        var thiss = $(this);
        var activeSrc = '';
        var currSrc = thiss.find('img').attr('src');
        if(currSrc.includes('music_tab_01')){
            activeSrc = 'music_tab_01_active.png';
            $('.user_products_outer, .user_album_outer').hide();
            $('#music_and_vidoes2').show();
        }
        if(currSrc.includes('music_tab_02')){
            activeSrc = 'music_tab_02_active.png';
            $('#music_and_vidoes2, .user_products_outer').hide();
            $('.user_album_outer').show();
        }
        if(currSrc.includes('music_tab_03')){
            activeSrc = 'music_tab_03_active.png';
            $('#music_and_vidoes2, .user_album_outer').hide();
            $('.user_products_outer').show();
        }
        if(activeSrc != ''){
            thiss.parent().find('.music_head_img img').each(function(){
                var src = $(this).attr('src');
                var newSrc = src.replace('_active', '');
                $(this).attr('src', newSrc);
            });
            thiss.find('img').attr('src', '/images/'+activeSrc);
        }
    });
    $('.player_bot_tv').click(function(){
        $('a[href="#tab2"]').trigger('click');
    });
    $('.player_bot_play_vid').click(function(){
        var videoToPlay = $(this).find('a').attr('data-video-id');
        if (videoToPlay != "") {
            $('html, body').animate({
                scrollTop: $("#jp_container_1").offset().top - 44
            },'slow');
            mediaInstance = playMediaElementVideo(0, 'https://www.youtube.com/watch?v='+videoToPlay, mediaInstance, 1);
        }
    });
    $('.hrd_cart_outer .cart_main_btn, .hrd_usr_men_outer .usr_men_main_btn, .hrd_notif_outer .notif_main_btn, .hrd_usr_men_outer .each_usr_men_item').click(function(){
        var link = $(this).attr('data-link');
        if(link != ''){
            window.location.href = link;
        }
    });

    $('#pro_default_currency_submit').click(function(){

        if($('#web_username').length){

            var msg = 'Check spelling - Once saved you cannot change these settings. Are you sure to continue?';
        }else{

            var msg = 'Once saved you cannot change these settings. Are you sure to continue?';
        }

        if(confirm(msg)){
            var error = 0;
            var formData = new FormData();
            if($('#pro_default_currency_value').length){
                var currency = $('#pro_default_currency_value').val();
                formData.append('currency', currency);
            }
            if($('#web_username').length){
                $('#web_username_error').addClass('instant_hide');
                var username = $('#web_username').val();
                if(username == ''){
                    error = 1;
                    $('#web_username_error').text('Required').removeClass('instant_hide');
                }
                formData.append('username', username);
            }
            if(!error){
                $.ajax({

                    url: '/update-seller-settings',
                    type: 'POST',
                    data: formData,
                    contentType:false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        if(response.success == 1){
                            location.reload();
                        }else{
                            if($('#web_username_error').length){
                                $('#web_username_error').text(response.error).removeClass('instant_hide');
                            }else{
                                alert(response.error);
                            }
                        }
                    }
                });
            }
        }
    });

    $('body').delegate('.pro_get_start_each_panel,.chat_get_help', 'click', function(e){

        var cat = $(this).attr('data-cat');
        var subcat = $(this).attr('data-sub-cat');
        var pageUrl = window.location.href;
        var baseUrl = $('#base_url').val();

        if(cat == 'tools' || cat == 'orders' || cat == 'chat'){

            window.location.href = '/dashboard';
        }else{

            if($(this).hasClass('pro_get_start_each_panel')){

                var thiss = $('.usr_men_quick_each:not(.active):not(.disabled)[data-cat="'+cat+'"][data-sub-cat="'+subcat+'"]');
            }else{

                var thiss = $(this);
            }

            $('.usr_men_quick_each').removeClass('active');
            thiss.addClass('active');

            if(browserWidth < 767){

                $('.pro_left_sec_outer').hide();
                $('.pro_right_sec_outer').show();
            }

            $('.pro_pg_tb_det').hide();
            sessionStorage.setItem('proCat', cat);
            sessionStorage.setItem('proSubCat', subcat);

            if(!thiss.hasClass('usr_men_setup_wizard') && pageUrl.indexOf(baseUrl+'profile') !== -1){

                var currentPage = 'profile';
            }else{

                var currentPage = baseUrl+$(this).attr('data-link');
            }

            if(cat == 'profile'){

                $('#profile_tab_01').show();
                $('#profile_tab_01 .sub_cat_data').addClass('instant_hide');

                if(subcat == 'edit'){

                    currentPage == 'profile' ? $('#profile_tab_01 #personal_section,#profile_tab_01 #email_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'media'){

                    currentPage == 'profile' ? $('#profile_tab_01 #musical_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'bio'){

                    currentPage == 'profile' ? $('#profile_tab_01 #bio_section,#profile_tab_01 #bio_video_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'design'){

                    currentPage == 'profile' ? $('#profile_tab_01 #home_layout_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'domain'){

                    currentPage == 'profile' ? $('#profile_tab_01 #domain_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'favourites'){

                    currentPage == 'profile' ? $('#profile_tab_01 #favourites_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'portfolio'){

                    currentPage == 'profile' ? $('#profile_tab_01 #portfolio_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'services'){

                    currentPage == 'profile' ? $('#profile_tab_01 #services_section').removeClass('instant_hide') : window.location.href = currentPage;
                }
            }else if(cat == 'media'){

                $('#profile_tab_02').show();
                $('#profile_tab_02 .sub_cat_data').addClass('instant_hide');

                if(subcat == 'add_musics'){

                    currentPage == 'profile' ? $('#profile_tab_02 #add_music_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'song_links'){

                    currentPage == 'profile' ? $('#profile_tab_02 #song_links_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'edit_musics'){

                    currentPage == 'profile' ? $('#profile_tab_02 #edit_music_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'my_albums'){

                    currentPage == 'profile' ? $('#profile_tab_02 #my_albums_section').removeClass('instant_hide') : window.location.href = currentPage;
                    $('#profile_tab_02 #my_albums_section .pro_tray_tab_content').addClass('instant_hide');
                    $('#profile_tab_02 #my_albums_section .pro_tray_tab_content[data-value="album_add"]').removeClass('instant_hide');
                }else if(subcat == 'standard_products'){

                    currentPage == 'profile' ? $('#profile_tab_02 #my_products_section').removeClass('instant_hide') : window.location.href = currentPage;
                    $('#profile_tab_02 #my_products_section .pro_tray_tab_content').addClass('instant_hide');
                    $('#profile_tab_02 #my_products_section .pro_tray_tab_content[data-value="product_add"]').removeClass('instant_hide');
                    $('#profile_tab_02 #my_products_section .pro_options_each').removeClass('active');
                    $('#profile_tab_02 #my_products_section .pro_options_each[data-href="pro_option_one"]').addClass('active');
                    $('#profile_tab_02 #my_products_section .pro_option_body_each').addClass('instant_hide');
                    $('#profile_tab_02 #my_products_section .pro_option_body_each[data-id="pro_option_one"]').removeClass('instant_hide');
                }else if(subcat == 'print_products'){

                    currentPage == 'profile' ? $('#profile_tab_02 #my_products_section').removeClass('instant_hide') : window.location.href = currentPage;
                    $('#profile_tab_02 #my_products_section .pro_tray_tab_content').addClass('instant_hide');
                    $('#profile_tab_02 #my_products_section .pro_tray_tab_content[data-value="product_add"]').removeClass('instant_hide');
                    $('#profile_tab_02 #my_products_section .pro_options_each').removeClass('active');
                    $('#profile_tab_02 #my_products_section .pro_options_each[data-href="pro_option_two"]').addClass('active');
                    $('#profile_tab_02 #my_products_section .pro_option_body_each').addClass('instant_hide');
                    $('#profile_tab_02 #my_products_section .pro_option_body_each[data-id="pro_option_two"]').removeClass('instant_hide');
                }else if(subcat == 'videos'){

                    currentPage == 'profile' ? $('#profile_tab_02 #videos_section').removeClass('instant_hide') : window.location.href = currentPage;
                    $('#profile_tab_02 #videos_section .pro_tray_tab_content').addClass('instant_hide');
                    $('#profile_tab_02 #videos_section .pro_tray_tab_content[data-value="video_add"]').removeClass('instant_hide');
                }else if(subcat == 'social'){

                    currentPage == 'profile' ? $('#profile_tab_02 #social_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'subscribers'){

                    currentPage == 'profile' ? $('#profile_tab_02 #subscribers_section').removeClass('instant_hide') : window.location.href = currentPage;
                }else if(subcat == 'live_streams'){

                    currentPage == 'profile' ? $('#profile_tab_02 #live_streams_section').removeClass('instant_hide') : window.location.href = currentPage;
                    $('#profile_tab_02 #live_streams_section .pro_tray_tab_content').addClass('instant_hide');
                    $('#profile_tab_02 #live_streams_section .pro_tray_tab_content[data-value="premium_add"]').removeClass('instant_hide');
                }else if(subcat == 'news'){

                    currentPage == 'profile' ? $('#profile_tab_02 #news_section').removeClass('instant_hide') : window.location.href = currentPage;
                    $('#profile_tab_02 #news_section .pro_tray_tab_content').addClass('instant_hide');
                    $('#profile_tab_02 #news_section .pro_tray_tab_content[data-value="news_add"]').removeClass('instant_hide');
                }
            }else if(cat == 'crowdfunds'){

                currentPage == 'profile' ? $('#profile_tab_05').show() : window.location.href = currentPage;
            }else if(cat == '' && subcat == ''){

                window.location.href = currentPage;
            }

            $('body').removeClass('lock_page');
            $('.hrd_cart_outer,.tv_slide_out_outer,.hrd_usr_men_outer,.hrd_notif_outer').removeClass('active');
            $('#body-overlay').hide();
        }
    });

    $('body').delegate('.chat_item', 'click', function(e){

        window.location.href = $(this).attr('data-link');
    });

    if(window.location.href.indexOf($('#base_url').val()+'profile') !== -1){

        if(sessionStorage.getItem('preload_cat') && sessionStorage.getItem('preload_cat') != '') {

            var preCat = sessionStorage.getItem('preload_cat');
            sessionStorage.removeItem('preload_cat');
            if(sessionStorage.getItem('preload_subcat') && sessionStorage.getItem('preload_subcat') != '') {

                var preSub = sessionStorage.getItem('preload_subcat');
                sessionStorage.removeItem('preload_subcat');
                $('.usr_men_quick_each[data-sub-cat="'+preSub+'"]').trigger('click');
            }
        }else{
            if(sessionStorage.getItem('proCat') && sessionStorage.getItem('proCat') != '') {
                if (sessionStorage.getItem('proSubCat') && sessionStorage.getItem('proSubCat') != '') {
                    $('.usr_men_quick_each[data-cat="'+sessionStorage.getItem('proCat')+'"][data-sub-cat="'+sessionStorage.getItem('proSubCat')+'"]').click();
                }
            }else{

                //$('.usr_men_quick_each:first').trigger('click');
            }
        }
    }
});

function addCartItem(basket_license, purchase_type, music_id, product_id, album_id, basket_price, basket_user_id, chat_id, meta_data = ''){

    if(parseFloat(basket_price) == 0){

        $.ajax({
            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'user_free_seller_information', 'find': basket_user_id, 'identity_type': 'free_buyer', 'identity': ''},
            success: function(response) {
                if(response.success == 1){
                    var name = response.data.name;
                    var currencySymbol = response.data.currencySymbol;
                    var skill = response.data.skill;

                    $('#add_item_free_popup #head_name').text(name+' - '+skill);
                    $('#add_item_free_popup #item_owner').text(name);
                    $('#add_item_free_popup #currency').text(currencySymbol);

                    if(purchase_type == 'music'){
                        $('#add_item_free_popup #item_type').text('download');
                    }else if(purchase_type == 'album'){
                        $('#add_item_free_popup #item_type').text('album');
                    }else if(purchase_type == 'product'){
                        $('#add_item_free_popup #item_type').text('product');
                    }else if(purchase_type == 'proferred-product'){
                        $('#add_item_free_popup #item_type').text('product');
                    }else if(purchase_type == 'project'){
                        $('#add_item_free_popup #item_type').text('project');
                    }else if(purchase_type == 'instant-license'){
                        $('#add_item_free_popup #item_type').text('download');
                    }

                    $('#add_item_free_popup,#body-overlay').show();

                    window.pendingAddToCart = basket_license+','+purchase_type+','+music_id+','+product_id+','+album_id+','+basket_price+','+basket_user_id+','+chat_id+','+meta_data;
                }
            }
        });
    }else{

        proceedAddCartItem(basket_license, purchase_type, music_id, product_id, album_id, basket_price, basket_user_id, chat_id, meta_data);
    }
}

function proceedAddCartItem(basket_license, purchase_type, music_id, product_id, album_id, basket_price, basket_user_id, chat_id, meta_data){

    if(basket_user_id){

        $.post("/postCustomerBasket", {

            basket_license: basket_license,
            purchase_type: purchase_type,
            music_id: music_id,
            product_id: product_id,
            album_id: album_id,
            basket_price: basket_price,
            basket_user_id: basket_user_id,
            chat_id: chat_id,
            meta_data: meta_data
        }, function(data) {

            if(data.error == ""){

                if($(".cart_is_empty").length){

                    $(".cart_is_empty").addClass('instant_hide');
                }

                $("#cart_icon_resp #basket_count_res,#basket_count").addClass('basket_counter_ok').text(data.basketCount);

                $(".hrd_cart_outer").html(data.basketHTML);

                $('.checkout_btn').removeClass('normal_checkout merge_checkout').addClass(data.checkoutType).attr('data-link', data.checkout);

                var pageUrl = window.location.href;

                if(pageUrl.indexOf('checkout') > -1){

                    location.reload();

                }else if(pageUrl.indexOf('profile') !== -1){

                    window.location.href = '/checkout/' + basket_user_id;
                }else if(pageUrl.indexOf('/product/') !== -1 || pageUrl.indexOf('/track/') !== -1){

                    window.location.href = data.checkout;
                }

                $('#post_cart_toast').hide();
                $('#post_cart_toast').find('.message').html('Added to cart');
                $('#post_cart_toast').attr('data-user', basket_user_id).attr('data-basket', data.basketId).slideDown('fast');

                if(purchase_type == 'subscription'){
                    $('#subscribe_btn.proj_add_sec').addClass('proj_add_sec_added');

                    $('#subscribe_box').removeClass('project_rit_btm_list');

                    $('#subscribe_box').addClass('proj_rit_btm_list_gray');

                    var html = $('#subscribe_btn.proj_add_sec').html();

                    $('#subscribe_btn.proj_add_sec').html(html.replace('Subscribe', 'Added To Cart'));
                }
                if(purchase_type == 'donation_goalless'){
                    $('.donation_goalless').addClass('donation_agree');
                    $('.donation_goalless #donation_amount').attr('readonly', true);

                    var html = $('.donation_goalless .donation_right_in').html();

                    $('.donation_goalless .donation_right_in').html(html.replace('Add To Cart', 'Added To Cart'));
                }
            }else{

                var error = data.error;

                var errorMessage = error;

                $("#basket_error_message").text(errorMessage);

                loadMyDeferredImages($("#basket_error_popup img.prevent_pre_loading"));
                $("#basket_error_popup,#body-overlay").show();
            }

            $('.port_add_basket').removeClass('disabled');
        });
    }
}
function removeCartItem(basket){

    var topBasketItem = $('.each_cart_item[data-basket="'+basket+'"]');
    if(topBasketItem.length){
        return $.post( "/undoCustomerBasket", {

            basket: basket

        }, function(data) {

            $('#post_cart_toast').hide();
            if(data.message == 'Deleted'){
                if(topBasketItem.attr('data-purchasetype') == 'subscription' && $('#subscribe_btn.proj_add_sec').length){
                    var html = $('#subscribe_btn.proj_add_sec').html();
                    $('#subscribe_btn.proj_add_sec').html(html.replace('Added To Cart', 'Subscribe'));

                    $('#subscribe_btn.proj_add_sec').removeClass('proj_add_sec_added');
                    $('#subscribe_box').addClass('project_rit_btm_list');
                    $('#subscribe_box').removeClass('proj_rit_btm_list_gray');
                }
                if(topBasketItem.attr('data-purchasetype') == 'donation_goalless' && $('.donation_goalless').length){
                    var html = $('.donation_goalless .donation_right_in').html();
                    $('.donation_goalless .donation_right_in').html(html.replace('Added To Cart', 'Add To Cart'));

                    $('.donation_goalless').removeClass('donation_agree');
                    $('.donation_goalless #donation_amount').attr('readonly', false);
                }
                $(".hrd_cart_outer").html(data.basketHTML);
                if($('#basket_count').length){
                    var count = parseInt($('#basket_count').text());
                }else{
                    var count = parseInt($('#basket_count_res').text());
                }
                $("#cart_icon_resp #basket_count_res,#basket_count").text((count-1));
            }
        });
    }

    return null;
}


function updateAudioFileData(audioFileName){

    if(typeof Spectrum !== 'undefined' && Spectrum){

        Spectrum.destroy();
    }
    var Spectrum = WaveSurfer.create({
        container: document.querySelector('#sample-audio-spectrum'),
        progressColor: "#fc064c",
        barHeight: 1,
        barWidth: 2,
        responsive: true,
        audioRate: 1,
        waveColor: "#e0e0e0",
        hideScrollbar: true,
        height: 35,
        normalize: true,
    });

    Spectrum.load('/user-music-files/'+audioFileName);

    sessionStorage.setItem('forceBusy', 'generating_waveform');

    Spectrum.on('ready', function () {

        var waveImage = Spectrum.exportImage('png', 10000);

        var formData = new FormData();
        formData.append('music_file_name', audioFileName);
        formData.append('music_waveform_image', waveImage);
        $.ajax({

            url: '/updateMusicData',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            async: false,
            contentType: false,
            processData: false,
            success: function (response) {

                if(response.success == '1'){

                    sessionStorage.removeItem('forceBusy');
                }else{
                    alert('Could not save music waveform');
                }
            }
        });

    });
}

function loadMyDeferredImages(elements){

    for (var i=0; i<elements.length; i++) {
        if(elements[i].getAttribute('data-src')) {
            elements[i].setAttribute('src',elements[i].getAttribute('data-src'));
            elements[i].classList.remove('instant_hide');
        }
    }
}

function SetCaretAtEnd(element) {

    var elem = element[0];
    var elemLen = elem.value.length;
        // For IE Only
        if (document.selection) {
            // Set focus
            elem.focus();
            // Use IE Ranges
            var oSel = document.selection.createRange();
            // Reset position to 0 & then set at end
            oSel.moveStart('character', -elemLen);
            oSel.moveStart('character', elemLen);
            oSel.moveEnd('character', 0);
            oSel.select();
        }
        else if (elem.selectionStart || elem.selectionStart == '0') {
            // Firefox/Chrome
            elem.selectionStart = elemLen;
            elem.selectionEnd = elemLen;
            elem.focus();
        } // if
    }


function showDisconnectSocialAccount(elem){



    if( $(elem).hasClass('pro_soc_icon_inst') ){



        var account = 'Instagram';

    }else if( $(elem).hasClass('pro_soc_icon_tweet') ){



        var account = 'Twitter';

        $('.confirm_password_pupup_twitter_connect').css('display', 'none');

    }else if( $(elem).hasClass('pro_soc_icon_youtube') ){



        var account = 'Youtube';

        $('.confirm_password_pupup_youtube_connect').css('display', 'none');

    }else if( $(elem).hasClass('pro_soc_icon_fb') ){



        var account = 'Facebook';

        $('.confirm_password_pupup_facebook_connect').css('display', 'none');

    }else if( $(elem).hasClass('pro_soc_icon_singnal') ){



        var account = 'Spotify';

    }



    $('.pro_soc_discon_outer #pro_soc_discon_submit_yes').attr('data-disconnect-account', account);

    $('.pro_soc_discon_outer .soc_discon_text h3 span').text(account);

    $('#body-overlay').css('display', 'block');

    $('.pro_soc_discon_outer').css('display', 'block');



}



function playSoundCloudAudio(audioLink, autoPLay){



    $('.mejs__container.mejs__video').css('display', 'none');

    $('#player1_youtube_iframe').attr('src', '');



    //configuring soundcloud player

    var soundcloudPlayer = $('#soundcloudPlayer');

    if( autoPLay ){ var autoPlayOption = 'auto_play=true'; }

    else { var autoPlayOption = 'auto_play=false'; }

    var src = 'https://w.soundcloud.com/player/?url='+ audioLink +'&amp;'+ autoPlayOption +'&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"';

    soundcloudPlayer.attr('src', src).show();

}


function playVimeoVideo(videoId, autoPLay){

    var browserWidth = $( window ).width();
    $('.mejs__container.mejs__video').css('display', 'none');
    $('#player1_youtube_iframe').attr('src', '');

    var player = $('#vimeo_player');

    if( autoPLay ){
        var autoPlayOption = 'autoplay=1&';
    }else{
        var autoPlayOption = '';
    }

    if(browserWidth <= 767){

        $('#vimeo_player').addClass('active');
    }
    $('#vimeo_player').html('<div style="padding:56.25% 0 0 0; position:relative;"><iframe src="https://player.vimeo.com/video/'+videoId+'?'+autoPlayOption+'color=ffffff&title=0&byline=0&portrait=0" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>');
}

function playJWPVideo(container, videoId, autoPLay, mute, title, description, repeat, playback, controls){

    var browserWidth = $( window ).width();
    $('.mejs__container.mejs__video').css('display', 'none');
    $('#player1_youtube_iframe').attr('src', '');

    var player = $('#jw_player');

    if( autoPLay ){
        var autoPlayOption = true;
    }else{
        var autoPlayOption = false;
    }

    window.jwp(container, videoId, autoPlayOption, mute, title, description, repeat, playback, controls);
}



function setProfileThumb(inputField){



    if (inputField.files && inputField.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {

            $('.top_img_profile img').attr('src', e.target.result);

        }

        reader.readAsDataURL(inputField.files[0]);

    }

}

function setBonusThumb(inputField){



    if (inputField.files && inputField.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {

            $('.pro_add_edit_bonus_outer .pop_up_bonus_thumb').attr('src', e.target.result);

        }

        reader.readAsDataURL(inputField.files[0]);

    }

}

function playMediaElementVideo(videoType, videoSrc, mediaElementInstance, autoPlay, poster = null ){

    var browserWidth = $( window ).width();

    if($('#soundcloudPlayer').length){
        $('#soundcloudPlayer').removeAttr('src').hide();
    }
    if($('#vimeo_player').length){
        $('#vimeo_player').removeClass('active').html('');
    }
    if($('#jw_player').hasClass('jwplayer')){

        window.jwplayer('jw_player').remove();
    }

    $('.mejs__container.mejs__video').css('display', 'block');

    if(mediaElementInstance){

        //destroying the current instance
        if(window.location.href.indexOf('/tv') > -1){

        }else{
            mediaElementInstance.remove();
        }
    }

    // destroy audio player instance
    if(browserWidth > 767){

        if(typeof spectrum !== 'undefined'){
            spectrum.pause();
            $('#play').addClass('fa-play').removeClass('fa-pause');
            $('.ap_outer').hide();
        }
    }else{

        if(typeof spectrum !== 'undefined' && spectrum.duration > 0){
            spectrum.pause();
            $('#play').addClass('fa-play').removeClass('fa-pause');
            $('.ap_outer').hide();
        }
    }


    if( videoSrc ){

        $('#player1').css('width','100%').css('height', '100%').attr('src', videoSrc);
    }

    var mediaElements = document.getElementById('player1');

    if(poster){

        //$('#player1').get(0).setAttribute('poster', poster);
    }

    var features = ['playpause', 'current', 'progress', 'duration',

        'markers', 'volume', 'playlist', 'fullscreen'];

    var media = new MediaElementPlayer(mediaElements, {

        // This is needed to make Jump Forward to work correctly

        pluginPath: 'https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.5/',

        shimScriptAccess: 'always',

        autoRewind: false,

        features: features,

        currentMessage: 'Now playing:',

        success: function(mediaElement, domObject) {



            if( autoPlay ){ mediaElement.play(); }

        }

    });



    $(".mejs__controls").css({ "height":"23px" });

    $(".mejs__button > button").css("margin", "5px 6px");

    $(".mejs__time-total").css("margin", "0px");

    $(".mejs__time").css("padding", "10px 6px 0");

    $("#player1_youtube_iframe").css({ "height":"100%" });

    return media;

}

function decodeHTMLEntities(encodedString){



    var textArea = document.createElement('textarea');

    textArea.innerHTML = encodedString;

    return textArea.value;

}

var firstUserFlag = 0;

function facebookShare(type){

    var error = 0;

    if(type == 'video'){
        var dynamicLink = $('#video_share_link').val();
        var dynamicTitle = $('#video_share_title').val();
    }else if(type == 'url'){
        var dynamicLink = $('#url_share_link').val();
        var dynamicTitle = $('#url_share_user_name').val();
    }else if(type == 'item'){
        var dynamicLink = $('#item_share_link').val();
        var dynamicTitle = $('#item_share_title').val();
    }

    if(dynamicLink == ''){ error = 1; }

    if(!error){

        var appId = $('#facebook_app_id').val();
        var pageURL="https://www.facebook.com/dialog/feed?app_id=" + appId + "&link=" + dynamicLink;

        var width = 800;
        var height = 650;
        var left   = ($(window).width()  - width)  / 2;
        var top    = ($(window).height() - height) / 2;

        window.open(pageURL, dynamicTitle, 'toolbar=no, location=no, directories=no, status=no, menubar=yes, scrollbars=no, resizable=no, copyhistory=no, width=' + width + ', height=' + height + ', top=' + top + ', left=' + left);
    }

    return false;
}

function twitterShare(type){

    var error = 0;

    if(type == 'video'){
        var dynamicLink = $('#video_share_link').val();
        var dynamicTitle = $('#video_share_title').val();
    }else if(type == 'url'){
        var dynamicLink = $('#url_share_link').val();
        var dynamicTitle = $('#url_share_user_name').val();
    }else if(type == 'item'){
        var dynamicLink = $('#item_share_link').val();
        var dynamicTitle = $('#item_share_title').val();
    }

    if(dynamicLink == ''){ error = 1; }

    if(!error){

        var link = encodeURIComponent(dynamicLink);

        var via = $('#twitter_user_name').val();
        var description = dynamicTitle.replace(/<(?:.|\n)*?>/gm, '');
        description = description.trim();
        if( description != '' ){
            var text = encodeURIComponent(description+'\n');
        }

        var width  = 600,
            height = 300,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = 'https://twitter.com/share?url='+link+'&via='+via,
            opts   = 'status=1' +
                ',width='  + width  +
                ',height=' + height +
                ',top='    + top    +
                ',left='   + left;

        window.open(url, 'twitter', opts);
    }

    return false;
}

function readURL(input, imageId) {

    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {

            $('#'+imageId).attr('src', e.target.result);

        }

        reader.readAsDataURL(input.files[0]);

    }

}

function postUserTabLoaded(){

    if(typeof window.postUserTabLoad !== typeof undefined && window.postUserTabLoad !== false){

        $(window.postUserTabLoad).trigger('click');
        delete window.postUserTabLoad;
    }
}

function musicHoverSupport(){

    $('.each-music .summary,.each-album-music .summary').hover(function(){

      $(this).find('.play_now').removeClass('instant_hide');

    }, function(){

      $(this).find('.play_now').addClass('instant_hide');

    });
}

function autoPlayMyMusic(musicId){

    var browserWidth = $( window ).width();

    if( browserWidth > 767 ){

        $('#tabd2 .music_main_outer .each-music[data-musicid="'+musicId+'"] .summary').trigger('click');
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#tabd2 .music_main_outer .each-music[data-musicid="'+musicId+'"]').first().offset().top
        }, 1000);
    }else{

        $('#tab2 .music_main_outer .each-music[data-musicid="'+musicId+'"] .summary').trigger('click');

        if($('.read-more.mobile-only').length){
            $('.read-more.mobile-only').trigger('click');
        }

        $([document.documentElement, document.body]).animate({
            scrollTop: $('#tab2 .music_main_outer .each-music[data-musicid="'+musicId+'"]').first().offset().top - 50
        }, 1000);
    }

    delete window.autoPlayMusic;
}



function editAlbumClicked(elementId){

    $(elementId).show();

    editDelAlbumClicked = 1;

}



function deleteAlbumClicked(elementId){

    editDelAlbumClicked = 1;

}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}


var calcTempo = function (buffer) {


}

function agreementAction(value, id, account, seller, price, music){

    var music = atob(music);
    var price = atob(price);
    var curr = $('#pay_quick_popup').attr('data-currency');

    if(value == 'Accepted' || value == 'Declined'){

        if(confirm('Be sure to read the agreement before proceding. Are you sure to proceed?')){

            var partnerId = $('.chat_each_user.active:first').attr('data-partner');

            var formData = new FormData();
            formData.append('response', value);
            formData.append('agreement', id);

            $.ajax({

                url: '/bispoke-license/agreement/response',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    if(response.success){

                        if(value == 'Accepted'){
                            if($('.chat_each_user.active').hasClass('chat_each_group')){
                                preparePayInstant(account, id, '#pay_quick_card_number', '#pay_quick_card_expiry', '#pay_quick_card_cvc', 'You are purchasing a music license', 'Price: '+curr+price);
                                $('#pay_quick_popup,#body-overlay').show();
                            }else{
                                addCartItem('bespoke_'+id, 'instant-license', 0, 0, 0, price, seller, id);
                            }
                        }else{
                            var formData = new FormData();
                            var elem = $('.chat_each_user.active:first');
                            if(elem.hasClass('chat_each_group')){
                                formData.append('action', 'group-chat');
                                formData.append('group', elem.attr('data-group'));
                            }else{
                                formData.append('action', 'partner-chat');
                                formData.append('partner', elem.attr('data-partner'));
                            }
                            refreshChatBox('chat', formData);
                        }
                    }
                }
            });
        }
    }else if(value == 'addToCart'){

        if($('.chat_each_user.active').hasClass('chat_each_group')){
            preparePayInstant(account, id, '#pay_quick_card_number', '#pay_quick_card_expiry', '#pay_quick_card_cvc', 'You are purchasing a music license', 'Price: '+curr+price);
            $('#pay_quick_popup,#body-overlay').show();
        }else{
            addCartItem('bespoke_'+id, 'instant-license', 0, 0, 0, price, seller, id);
        }
    }
}

function profferProductAction(value, id, account, productId, seller, price){

    var price = atob(price);
    var curr = $('#pay_quick_popup').attr('data-currency');

    if(value == 'Accepted' || value == 'Declined'){

        if(confirm('Be sure to read the product file before proceding. Are you sure to proceed?')){


            var formData = new FormData();
            formData.append('response', value);
            formData.append('product', id);

            $.ajax({

                url: '/proffer-product/response',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    if(response.success){

                        if(value == 'Accepted'){

                            if($('.chat_each_user.active').hasClass('chat_each_group')){
                                preparePayInstant(account, id, '#pay_quick_card_number', '#pay_quick_card_expiry', '#pay_quick_card_cvc', 'You are purchasing a product', 'Price: '+curr+price);
                                $('#pay_quick_popup,#body-overlay').show();
                            }else{
                                addCartItem('', 'proferred-product', 0, 0, 0, price, seller, id);
                            }
                        }else{
                            var formData = new FormData();
                            var elem = $('.chat_each_user.active:first');
                            if(elem.hasClass('chat_each_group')){
                                formData.append('action', 'group-chat');
                                formData.append('group', elem.attr('data-group'));
                            }else{
                                formData.append('action', 'partner-chat');
                                formData.append('partner', elem.attr('data-partner'));
                            }
                            refreshChatBox('chat', formData);
                        }
                    }
                }
            });
        }
    }else if(value == 'addToCart'){

        if($('.chat_each_user.active').hasClass('chat_each_group')){
            preparePayInstant(account, id, '#pay_quick_card_number', '#pay_quick_card_expiry', '#pay_quick_card_cvc', 'You are purchasing a product', 'Price: '+curr+price);
            $('#pay_quick_popup,#body-overlay').show();
        }else{
            addCartItem('', 'proferred-product', 0, 0, 0, price, seller, id);
        }
    }
}

var refreshChatAjax = null;

function refreshChatBox(type, formData, elem = false){

    if(typeof refreshChatAjax !== 'undefined' && refreshChatAjax){

        refreshChatAjax.abort();
    }

    var messagesNum = $('.chat_main_body_messages .chat_each_message.msg_in').length;
    refreshChatAjax = $.ajax({

        url: '/getUserChatDetails',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
            if(response.success){
                $('#loading_messages').addClass('instant_hide');
                if(type == 'full'){

                    $('.chat_users_outer').html(response.data.partnersList);

                    if($('#profile_tab_14').length){

                        var name = $('.chat_each_user.active:first .chat_user_name').text();
                        $('.chat_head_name').text(name);
                    }else if($('#admin_chat').length){

                        var nameone = $('.chat_each_user.active:first .chat_each_sender_sec .chat_user_name').text();
                        var nametwo = $('.chat_each_user.active:first .chat_each_recipient_sec .chat_user_name').text();
                        $('.chat_head_name').text(nameone+' - '+nametwo);
                    }

                    if(!$('.chat_each_user.active').length){

                        $('.chat_each_user[data-partner="admin"]').trigger('click');
                    }
                }
                if(type == 'chat'){
                    if(elem){
                        $('.chat_each_user').removeClass('active');
                        elem.addClass('active');
                    }
                }

                if(type != 'update-chat'){

                    if(type == 'previous-chat'){

                        if(response.data.partnerChat != ''){

                            $('.chat_main_body_messages').prepend(response.data.partnerChat);
                            var height = 0;
                            $('.chat_main_body_messages .chat_each_message').filter(function() {
                                if($(this).attr('data-cursor') < parseInt(formData.get('cursor'))){

                                    height += $(this).outerHeight(true);
                                }
                            });
                            $('.chat_main_body_messages').animate({ scrollTop: height }, 0);
                        }
                    }else{

                        $('.chat_main_body_messages').html(response.data.partnerChat);

                        $('.chat_each_user.active').removeClass('unread');
                        $('.chat_main_body_messages').animate({ scrollTop: $('.chat_main_body_messages')[0].scrollHeight + 5000 }, 0);
                        setTimeout(function(){
                            $('.chat_main_body_messages').animate({ scrollTop: $('.chat_main_body_messages')[0].scrollHeight + 5000 }, 0);
                        }, 1500);
                    }
                }else{

                    if(response.data.partnerChat != ''){

                        $('.chat_main_body_messages').append(response.data.partnerChat).animate({ scrollTop: $('.chat_main_body_messages')[0].scrollHeight + 5000 }, 0);
                        setTimeout(function(){
                            $('.chat_main_body_messages').animate({ scrollTop: $('.chat_main_body_messages')[0].scrollHeight + 5000 }, 0);
                        }, 1500);
                    }
                }

                $('.header_each_action').removeClass('active');
                $('.header_each_action:first').addClass('active');

                if($('#admin_chat').length){

                    if(response.data.adminJoinChat == '1'){
                        $('#new_message').removeAttr('disabled');
                        $('#join_chat_btn').addClass('disabled');
                    }else{
                        $('#new_message').attr('disabled', 'disabled');
                        $('#join_chat_btn').removeClass('disabled');
                    }
                }
                if($('.chat_each_user.active:first .chat_user_unseen').length){

                    $('.chat_each_user.active:first .chat_user_unseen').addClass('instant_hide');
                }

                if(browserWidth < 768){
                    $('.chat_outer .hide_on_mobile').remove();
                }else{
                    $('.chat_outer .hide_on_desktop').remove();
                }

                if($('.chat_users_outer .chat_each_user.active').length == 0){

                    $('.chat_each_admin.chat_personal_group').addClass('active');
                }

                if(type == 'full' && $('.chat_each_user.active').prev('.chat_each_user').length){
                    topp = 0;
                    if($('.chat_each_user.active').hasClass('chat_each_group')){
                        var container = $('.chat_partners_outer.chat_group_partners');
                    }else{
                        var container = $('.chat_partners_outer:not(.chat_group_partners)');
                    }
                    container.find('.chat_each_user').each(function(){
                        if(!$(this).hasClass('active')){
                            topp = topp + parseInt($(this).outerHeight(true));
                        }else{
                            topp = topp - parseInt($(this).prev().outerHeight(true));
                            return false;
                        }
                    });
                    container.animate({ scrollTop: topp }, 0);
                }
            }else{

                alert(response.error);
            }
        }
    });
}

function updateChat(){

    if($('#profile_tab_14').length && !$('.chat_outer').hasClass('disabled')){
        var error = 0;
        var display = $('#profile_tab_14').css('display');
        if(display != 'none' && ($('.notif_service').length || ($('.usr_men_quick_each[data-cat="chat"][data-sub-cat="chat_box"]').hasClass('active') && $('#filter_none').hasClass('active')))){

            var elem = $('.chat_each_user.active');
            if(elem.length == 0 || elem.hasClass('chat_each_admin') && elem.hasClass('protected')){

                error = 1;
            }
        }else{

            error = 1;
        }

        if(!error){

            var formData = new FormData();
            if($('.chat_main_body_messages .chat_each_message').length){
                formData.append('cursor', $('.chat_main_body_messages .chat_each_message').last().attr('data-cursor'));
            }else{
                formData.append('cursor', 0);
            }

            if(elem.hasClass('chat_each_group')){
                formData.append('action', 'group-chat');
                formData.append('group', elem.attr('data-group'));
            }else{
                formData.append('action', 'partner-chat');
                formData.append('partner', elem.attr('data-partner'));
            }
            refreshChatBox('update-chat', formData);
        }else{

            setTimeout(updateChat, 10000);
        }
    }else if($('#admin_chat').length){

        var formData = new FormData();
        formData.append('action', 'admin-pair-chat');
        formData.append('pair', $('.chat_each_user.active').attr('data-sender-id')+':'+$('.chat_each_user.active').attr('data-recipient-id'));
        refreshChatBox('update-chat', formData);
    }else{

        setTimeout(updateChat, 10000);
    }
}

function startNotificationsService(){

    var currentNotifId = parseInt($('.notif_service').attr('data-id'));
    var formData = new FormData();
    formData.append('mode', 'fetch');
    formData.append('id', currentNotifId);

    $.ajax({

        url: '/update-user-notifications',
        dataType: "json",
        type: 'post',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function(response) {

            if(response.success == 1){

                if(response.html != ''){

                    if(response.lastChatNotifId > currentNotifId){

                        $('.notif_service').attr('data-id', response.lastChatNotifId);
                        updateChat();
                        notifInAud.currentTime = 0;
                        notifInAud.play();
                    }
                }

                setTimeout(startNotificationsService, 10000);
            }
        }
    });
}

function refreshNotificationsBox(){

    if($('.usr_notif_items_inner .each_usr_notif_item').length){

        var currentNotifId = $('.usr_notif_items_inner .each_usr_notif_item').first().attr('data-id');
    }else{

        var currentNotifId = 0;
    }

    var formData = new FormData();
    formData.append('mode', 'fetch');
    formData.append('id', currentNotifId);

    if(window.location.href.indexOf('dashboard') !== -1 && $('.each_dash_section:not(.instant_hide)').length){
        var id = $('.each_dash_section:not(.instant_hide)').closest('.agent_contact_listing').find('.m_btm_right_icons .m_btn_chat').attr('data-id');
        formData.append('contact', id);
    }

    $.ajax({
        url: '/update-user-notifications',
        dataType: "json",
        type: 'post',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function(response) {
            if(response.success == 1){

                if(response.html != ''){

                    $('#notif_is_empty').remove();
                    $('.usr_notif_items_inner').prepend(response.html);
                    var newNotifs = $('.usr_notif_items_inner .noti_status_new').length;
                    var updateC = 0;
                    if(newNotifs){

                        $('.usr_notif_items_inner .noti_status_new').each(function(){
                            if($(this).closest('.each_usr_notif_item').attr('data-type') == 'chat'){
                                updateC = 1;
                            }
                        });
                        if(window.location.href.indexOf('/dashboard') !== -1 && updateC && $('.each_dash_section:not(.instant_hide)').length){
                            var element = $('.each_dash_section:not(.instant_hide)').find('.chat_outer');
                            refreshChat(element);
                        }
                        $('#notif_count_res,#notif_count').text(newNotifs).addClass('notif_counter_ok');
                        notifInAud.currentTime = 0;
                        notifInAud.play();
                    }
                }

                var timeLapse = window.location.href.indexOf('/dashboard') !== -1 && $('.each_dash_section:not(.instant_hide)').length ? 10000 : 30000;
                setTimeout(refreshNotificationsBox, timeLapse);
            }else{
                console.log(data.error);
            }
        }
    });
}

function roundCssTransformMatrix(element){

        element.style.transform=""; //resets the redifined matrix to allow recalculation, the original style should be defined in the class not inline.
        var mx = window.getComputedStyle(element, null); //gets the current computed style
        mx = mx.getPropertyValue("-webkit-transform") ||
             mx.getPropertyValue("-moz-transform") ||
             mx.getPropertyValue("-ms-transform") ||
             mx.getPropertyValue("-o-transform") ||
             mx.getPropertyValue("transform") || false;
        var values = mx.replace(/ |\(|\)|matrix/g,"").split(",");
        for(var v in values) { values[v]=v>4?Math.ceil(values[v]):values[v]; }

        $(element).css({transform:"matrix("+values.join()+")"});

}

function updatePortDetNav(){

    var currId = $('.portfolio_det_outer .portfolio_det_each').attr('data-id');
    var currPortElem = $('.portfolio_each_contain .portfolio_each[data-id="'+currId+'"]');
    if(currPortElem.length && currPortElem.prev().hasClass('portfolio_each')){

        $('.portfolio_nav_outer .port_det_nav_back').removeClass('disabled');
    }else{

        $('.portfolio_nav_outer .port_det_nav_back').addClass('disabled');
    }

    if(currPortElem.length && currPortElem.next().hasClass('portfolio_each')){

        $('.portfolio_nav_outer .port_det_nav_next').removeClass('disabled');
    }else{

        $('.portfolio_nav_outer .port_det_nav_next').addClass('disabled');
    }
}

function matchYoutubeUrl(url) {
    var url = String(url);
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match && match[2].length == 11) {
        return true;
    }
    return false;
}

function matchSoundcloudUrl(url){
    var url = String(url);
    var regexp = /^https?:\/\/(soundcloud\.com|snd\.sc)\/(.*)$/;
    return url.match(regexp) && url.match(regexp)[2];
}

function Interval(time) {
    var timer = false;
    this.start = function () {
        if (!this.isRunning())
            timer = setInterval(function(){
                var productOffer = $('.tot_awe_pro_offer');
                if(productOffer.length){
                    $(productOffer).each(function(index){
                        var thiss = $(this);
                        var now = parseInt(thiss.attr('data-current'));
                        var endDateTime = parseInt(thiss.attr('data-end'));
                        var distance = endDateTime - now;
                        if(distance > 0){
                            thiss.attr('data-current', now + 1);
                            var days = ('0' + Math.floor(distance / (60 * 60 * 24))).slice(-2);
                            var hours = ('0' + Math.floor((distance % (60 * 60 * 24)) / (60 * 60))).slice(-2);
                            var minutes = ('0' + Math.floor((distance % (60 * 60)) / (60))).slice(-2);
                            var seconds = ('0' + Math.floor(distance % (60))).slice(-2);

                            thiss.find('.pro_countdown_days .big_offer_countdown_bx').first().text(days.substring(0, 1));
                            thiss.find('.pro_countdown_days .big_offer_countdown_bx').last().text(days.substring(1, 2));
                            thiss.find('.pro_countdown_hours .big_offer_countdown_bx').first().text(hours.substring(0, 1));
                            thiss.find('.pro_countdown_hours .big_offer_countdown_bx').last().text(hours.substring(1, 2));
                            thiss.find('.pro_countdown_mins .big_offer_countdown_bx').first().text(minutes.substring(0, 1));
                            thiss.find('.pro_countdown_mins .big_offer_countdown_bx').last().text(minutes.substring(1, 2));
                            thiss.find('.pro_countdown_secs .big_offer_countdown_bx').first().text(seconds.substring(0, 1));
                            thiss.find('.pro_countdown_secs .big_offer_countdown_bx').last().text(seconds.substring(1, 2));
                        }else{
                            clearInterval(timer);
                            timer = false;
                            location.reload();
                        }
                    });
                }
            }, time);
    };
    this.stop = function () {
        clearInterval(timer);
        timer = false;
    };
    this.isRunning = function () {
        return timer !== false;
    };
}

function productOfferCountdown(i){

    if(i.isRunning()){
        i.stop();
    }
    i.start();
}

function initiateInstantPayment(stripe, eCardNumber){

    var cardName = $('#pay_quick_card_name');
    $('#pay_quick_error').addClass('instant_hide');
    if(cardName.val() == ''){

        $('#pay_quick_error').removeClass('instant_hide').text('Card name is required');
    }else{

        var id = $('#pay_quick_popup').attr('data-id');
        var metaData = {'type' : 'chat'};

        if(id.indexOf('custom_product_') !== -1){

            var split = id.split('_');
            var productId = split[split.length - 1];
            var product = $('.tot_awe_pro_outer .add_basket_btn[data-productid="'+productId+'"]');
            if(product.length == 0){

                alert('No product found');
                return false;
            }

            product = product.closest('.tot_awe_pro_outer');
            var color = product.find('.tot_awe_color_each.active');
            var size = product.find('.tot_awe_size_each.active');

            id = '';
            metaData['type'] = 'custom_product';
            metaData['product'] = productId;
            if(size.length > 0){
                metaData['size'] = size.attr('data-name');
            }
            if(color.length > 0){
                metaData['color'] = color.attr('data-name');
            }
            metaData['quantity'] = product.find('.tot_awe_pro_qua').val();
            metaData['shipping_name'] = $('#pay_quick_popup #pay_quick_name').val();
            metaData['shipping_email'] = $('#pay_quick_popup #pay_quick_email').val();
            metaData['shipping_address'] = $('#pay_quick_popup #pay_quick_shipping_address_line').val();
            metaData['shipping_city'] = $('#pay_quick_popup #pay_quick_shipping_city').val();
            metaData['shipping_postcode'] = $('#pay_quick_popup #pay_quick_shipping_postcode').val();
            metaData['shipping_country'] = $('#pay_quick_popup #pay_quick_shipping_country').val();
        }

        $('#pay_quick_final').addClass('disabled');

        stripe.createToken(eCardNumber)
        .then(function(tokenn){
            if(tokenn.error){
                $('#pay_quick_final').removeClass('disabled');
                $('#pay_quick_error').removeClass('instant_hide').text(tokenn.error.message);
            }else{
                metaData['countryCode'] = tokenn.token.card.country;
                $.ajax({
                    url: '/prepare-instant-payment',
                    type: 'POST',
                    data: {id : id, metaData : metaData},
                    cache: false,
                    dataType: 'json',
                    success: function (response) {

                        if(typeof response.error !== 'undefined' && response.error != ''){
                            alert(response.error);
                            $('#pay_quick_final').removeClass('disabled');
                        }else{
                            if(typeof response.free !== 'undefined' && response.free == 1){
                                var formData = new FormData();
                                formData.append('free', '1');
                                formData.append('id', $('#pay_quick_popup').attr('data-id'));
                                postInstantPayment(formData);
                            }else{
                                payInstantPaymentWithCard(stripe, eCardNumber, response.clientSecret, response.seller);
                            }
                        }
                    }
                });
            }
        });
    }
}


function payInstantPaymentWithCard(stripe, card, clientSecret, seller){
    stripe
    .confirmCardPayment(clientSecret, {
        payment_method: {
            card: card
        }
    })
    .then(function(result){
        if(result.error){
            $('#pay_quick_final').removeClass('disabled');
            $('#pay_quick_error').removeClass('instant_hide').text(result.error.message);
        }else{
            var formData = new FormData();
            formData.append('intent', result.paymentIntent.id);
            var id = $('#pay_quick_popup').attr('data-id');
            if(id.indexOf('custom_product_') === -1){

                formData.append('id', id);
            }else{

                formData.append('seller', seller);
                formData.append('address', $('#pay_quick_popup #pay_quick_shipping_address_line').val());
                formData.append('city', $('#pay_quick_popup #pay_quick_shipping_city').val());
                formData.append('postcode', $('#pay_quick_popup #pay_quick_shipping_postcode').val());
                formData.append('country', $('#pay_quick_popup #pay_quick_shipping_country').val());
            }
            postInstantPayment(formData);
        }
    });
}

function postInstantPayment(formData){

    $.ajax({
        url: '/post-instant-payment',
        type: 'POST',
        data: formData,
        contentType:false,
        cache: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if(response.success){
                window.location = response.url;
            }else{
                alert(response.error);
                $('#pay_quick_error').removeClass('instant_hide');
            }
        }
    });
}


function imageIsLoaded(e) {
    $('.attachment_area').append('<div class="each_attach"><img src=' + e.target.result + '></div>');
    $('.chat_main_body_foot').addClass('attachment');
    $('#new_message').focus();
}

function copyToClipboard(text) {
    if (window.clipboardData && window.clipboardData.setData) {
        return clipboardData.setData("Text", text.trim());

    } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
        var textarea = document.createElement("textarea");
        textarea.value = text.trim();
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);

        var isiOSDevice = navigator.userAgent.match(/ipad|iphone/i);
        if (isiOSDevice) {
            var range = document.createRange();
            textarea.contentEditable = true;
            textarea.readOnly = false;
            range.selectNodeContents(textarea);
            var s = window.getSelection();
            s.removeAllRanges();
            s.addRange(range);
            textarea.setSelectionRange(0, 999999);
        } else {
            textarea.select();
        }

        try {
            return document.execCommand("copy");
        } catch (ex) {
            console.warn("Copy to clipboard failed.", ex);
            return false;
        } finally {
            document.body.removeChild(textarea);
        }
    }
}

function limitString(string, limitNum){
    if(parseInt(string.length) > limitNum){
        return string = string.substring(0, limitNum)+'...';
    }else{
        return string;
    }
}

function checkApp(){
	setTimeout(function(){
		if(navigator.share){
			//mobile browser
		 	isNotApp();
		}else{
			if($(window).width() > 767){
				//desktop
				isNotApp();
			}else{
				//mobile app
			}
		}
	}, 100);
}

function isNotApp(){

	if($('#platform').length){

		var browserWidth = $(window).width();
		if(browserWidth <= 767){
			$('#platform').val('2');
		}else{
			$('#platform').val('3');
		}
	}
}
