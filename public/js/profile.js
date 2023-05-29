        var subTab = '{{$subTab}}';
        var thank_you_user_id=thank_you_user_name=thank_you_user_photo=thank_you_user_share_url=type_id=payment_type=thank_you_user_email=thank_you_type=thank_you_id="";
        var browserWidth = $( window ).width();
        
        if(window.appCards == '1'){
            sessionStorage.removeItem('preload_subcat');
            sessionStorage.removeItem('preload_cat');
            sessionStorage.removeItem('proCat');
            sessionStorage.removeItem('proSubCat');
        }

        if(subTab != '' && browserWidth <= 767){

            /*$('html, body').animate({scrollTop: $('.pro_right_tb_det_outer').offset().top-60}, 'slow', function(){

                var position = $(".tb_sub_each.active:first").filter(":first").position().left;
                $('.pro_pg_tb_sub_outer').animate({
                    scrollLeft: position
                }, '20000');
            });*/
        }

        function updatePortThumb(elem){

            var data = elem.files[0];
            if(data.size > 5*1024*1024) {
                alert('File cannot be more than 5MB');
                $(elem).val('');
                return false;
            }

            if(elem.files && elem.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {

                    $(elem).parent().find('.custom_file_thumb').attr('src', e.target.result);
                }
                reader.readAsDataURL(elem.files[0]);
            }

        }

        function starMyProduct(elem, id, csrf_token){

            var product = $(elem);
            var currentSrc = product.attr('class');
            if( currentSrc.indexOf('featured') !== -1 ){

                var action = 'unfeature';
            }else{

                var action = 'feature';
            }

            var formData = new FormData();
            var token = csrf_token;
            formData.append('_token', token);
            formData.append('id', id);
            formData.append('action', action);

            $.ajax({

                url: '/starMyProduct',
                type: "POST",
                data: formData,
                dataType: 'html',
                contentType:false,
                cache: false,
                processData: false,
                success: function(data){

                    if( data == 1 ){

                        if( action == 'unfeature' ){

                            var newSrc = currentSrc.replace("m_btm_star_featured", "m_btm_star");
                        }else{

                            var newSrc = currentSrc.replace("m_btm_star", "m_btm_star_featured");
                        }

                        product.attr('class', newSrc);
                    }else if (data == 'Error: You have reached maximum limit of 5'){

                        alert(data);

                    }
                }
            });
        }

        $(document).ready(function() {

            $('.pro_explainer_each').click(function(){

                var thiss = $(this);
                var fileId = atob(thiss.attr('data-explainer-file'));
                var title = thiss.attr('data-explainer-title');
                var description = thiss.attr('data-explainer-description');
                var container = thiss.closest('.pro_explainer_outer').find('.pro_explainer_video_contain div:first-child').attr('id');
                $('.pro_explainer_each').removeClass('active');
                thiss.addClass('active');

                if(window.jwplayer !== 'undefined' && $('#'+container).hasClass('jwplayer')){

                    window.jwplayer(container).remove();
                }

                $('.pro_explainer_video_contain div:first-child').html('').attr('class', '');
                $('.pro_explainer_video').addClass('instant_hide');
                thiss.closest('.pro_explainer_outer').find('.pro_explainer_video').removeClass('instant_hide');
                playJWPVideo(container, fileId, true, false, title, description, false, true, true);
            });
            
            var simplepicker = new SimplePicker({
              zIndex: 10
            });

            if(window.notifications == '1'){

                $('.hrd_notif_outer').addClass('active');
                $('body').addClass('lock_page');
                $('#body-overlay').show();
            }

            $('.usr_men_seller_help').click(function(){

                $('.pro_left_sec_outer').show();
                $('.pro_right_sec_outer').hide();
                $('body').removeClass('lock_page');
                $('.hrd_cart_outer,.tv_slide_out_outer,.hrd_usr_men_outer,.hrd_notif_outer').removeClass('active');
                $('#body-overlay').hide();
            });

            $('body').delegate('.pro_tray_tab_each', 'click', function(e){

                var value = $(this).attr('data-key');
                $(this).closest('.sub_cat_data').find('.pro_tray_tab_content').addClass('instant_hide');
                $(this).closest('.sub_cat_data').find('.pro_tray_tab_each').removeClass('active');
                $('.pro_tray_tab_content[data-value="'+value+'"]').removeClass('instant_hide');
                $(this).addClass('active');
            });
            
            if(sessionStorage.getItem('appDialog') === null && $('.app_dialog').length){

                $('.app_dialog').show();
            }

            $('.app_dialog_tool').click(function(){

                $('.app_dialog').hide();
                sessionStorage.setItem('appDialog', '1');
            });

            $('.product_timer_start_date_time,.product_timer_end_date_time').click(function(){
                if($(this).hasClass('product_timer_start_date_time')){
                    window.simplePickerElement = '.product_timer_start_date_time';
                }
                if($(this).hasClass('product_timer_end_date_time')){
                    window.simplePickerElement = '.product_timer_end_date_time';
                }
                simplepicker.open();
            });

            simplepicker.on('submit', (date, readableDate) => {
                if(typeof window.simplePickerElement !== 'undefined' && window.simplePickerElement && window.simplePickerElement != ''){
                    var elem = $(window.simplePickerElement);
                    elem.val(readableDate);
                    delete window.simplePickerElement;
                }
            });

            $('body').delegate('.ind_con_each_nav:not(.disabled),.ind_con_search_submit', 'click', function(e){

                if($(this).hasClass('ind_con_each_nav')){
                    var page = $(this).attr('data-key');
                    $(this).addClass('disabled');
                }else{
                    var page = '';
                }
                
                var category = $('#ind_con_search_by_category').val();
                var city = $('#ind_con_search_by_city').val();
                var find = category+'_'+city+'_'+page;

                $.ajax({

                    url: "/informationFinder",
                    dataType: "json",
                    type: 'post',
                    data: {'find_type': 'industry_contacts', 'find': find, 'identity_type': 'subscriber', 'identity': ''},
                    success: function(response) { 
                        if(response.success == 1){
                            $('.ind_con_result_outer').html(response.data.data);
                        }else{
                            alert(data.error);
                        }
                    },
                    complete: function(response){
                        $(this).removeClass('disabled');
                    }
                });
            });

            $('body').delegate('.ind_con_each_action.details', 'click', function(e){

                var find = $(this).closest('.ind_con_each_outer').attr('data-id');

                $.ajax({

                    url: "/informationFinder",
                    dataType: "json",
                    type: 'post',
                    data: {'find_type': 'industry_contact_details', 'find': find, 'identity_type': 'subscriber', 'identity': ''},
                    success: function(response) { 
                        if(response.success == 1){
                            
                            $('.ind_con_details_popup .pro_pop_ind_con_each').addClass('instant_hide').find('.item_name').text('');
                            $('.ind_con_details_popup .pro_pop_head').text('').addClass('instant_hide');

                            if(response.data.name != ''){
                                $('.ind_con_details_popup .pro_pop_head').text(response.data.name).removeClass('instant_hide');
                            }
                            if(response.data.address != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="address"] .item_name').text(response.data.address);
                            }
                            if(response.data.email != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="email"]').removeClass('instant_hide').find('.item_name').text(response.data.email);
                            }
                            if(response.data.phone != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="phone"]').removeClass('instant_hide').find('.item_name').text(response.data.phone);
                            }
                            if(response.data.website != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="website"]').removeClass('instant_hide').find('.item_name').html(response.data.website);
                            }
                            if(response.data.facebook != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="facebook"]').removeClass('instant_hide').find('.item_name').html(response.data.facebook);
                            }
                            if(response.data.twitter != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="twitter"]').removeClass('instant_hide').find('.item_name').html(response.data.twitter);
                            }
                            if(response.data.instagram != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="instagram"]').removeClass('instant_hide').find('.item_name').html(response.data.instagram);
                            }
                            if(response.data.youtube != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="youtube"]').removeClass('instant_hide').find('.item_name').html(response.data.youtube);
                            }
                            if(response.data.soundcloud != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="soundcloud"]').removeClass('instant_hide').find('.item_name').html(response.data.soundcloud).removeClass('instant_hide');
                            }
                            if(response.data.information != ''){
                                $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="information"]').removeClass('instant_hide').find('.item_name').html(response.data.information);
                            }
                            
                            $('.ind_con_details_popup, #body-overlay').show();
                        }else{
                            alert(response.error);
                        }
                    }
                });
            });
            $('body').delegate('.ind_con_each_action.favourites:not(.disabled)', 'click', function(e){

                var thiss = $(this);
                thiss.addClass('disabled');
                var id = thiss.closest('.ind_con_each_outer').attr('data-id');

                $.ajax({

                    url: "/toggle-ind-con-fav",
                    dataType: "json",
                    type: 'post',
                    data: {'id': id},
                    success: function(response) { 
                        if(response.success == 1){
                            
                            if(response.action == 'removed'){
                                thiss.removeClass('added').find('span').text(' Add to Favourites');
                            }else{
                                thiss.addClass('added').find('span').text(' Added to Favourites');
                            }
                        }else{
                            alert(response.error);
                        }
                    },
                    complete: function(response){
                        thiss.removeClass('disabled');
                    }
                });
            });
            

            $('.edit_port_close').click(function(){

                $(this).closest('form').hide();
            });

            $('.add_element').click(function(e){
                e.preventDefault();
                var thiss = $(this);
                var id = thiss.attr('data-id');

                var currentOrder = thiss.closest('form').find('.port_field_checked').last().attr('data-order');
                if(currentOrder === undefined){ currentOrder = 0; }

                var order = parseInt(currentOrder) + 1;

                if(id == 'paragraph'){
                    var element = $('#paragraph_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('paragraph');
                }
                if(id == 'image'){
                    var element = $('#image_sample');
                    element.find('input[type=file]').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('image');
                }
                if(id == 'youtube'){
                    var element = $('#youtube_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('youtube');
                }
                if(id == 'heading'){
                    var element = $('#heading_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('heading');
                }
                if(id == 'spotify'){
                    var element = $('#spotify_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('spotify');
                }

                element.find('.port_each_field').addClass('port_field_checked').attr('data-order', order);
                if(thiss.closest('form').find('.port_each_field.port_field_checked').length){
                    $(element.html()).insertAfter(thiss.closest('form').find('.port_each_field.port_field_checked').last());    
                }else{
                    $(element.html()).insertBefore(thiss.closest('form').find('.port_each_field').last());
                }
                
                element.find('.port_each_field').removeClass('port_field_checked').removeAttr('data-order');

            });

            $('#portfolio_section .port_wid_head').click(function(){

                $(this).closest('.add_port_wid_outer').find('.port_wid_drop_outer').toggle();
            });

            $('.port_wid_drop_inner .head i').click(function(){

                $(this).closest('.add_port_wid_outer').find('.port_wid_drop_outer').toggle();
            });

            $('body').delegate('.custom_file_thumb', 'click', function(e){

                $(this).parent().find('.port_file_input').trigger('click');
            });

            $('body').delegate('.port_field_remove', 'click', function(e){

                if(confirm('Are you sure?')){

                    $(this).closest('.port_field_checked').remove();
                }
            });


            $('.save_service_outer').click(function(){

                var form = $(this).closest('form');
                form.find('.has-danger').removeClass('has-danger');
                var error = 0;
                var service = form.find('.pro_service_search');
                var priceOption = form.find('.pro_service_price_option');
                var price = form.find('.pro_service_price');
                var priceInterval = form.find('.pro_service_price_interval');

                if(service.val() == ''){

                    error = 1;
                    service.closest('.pro_stream_input_each').addClass('has-danger');
                }
                if(priceOption.val() == ''){

                    error = 1;
                    priceOption.closest('.pro_stream_input_each').addClass('has-danger');
                }
                if(priceOption.val() == 1 && price.val() == ''){

                    error = 1;
                    price.closest('.pro_stream_input_each').addClass('has-danger');
                }
                if(priceOption.val() == 1 && priceInterval.val() == ''){

                    error = 1;
                    priceInterval.closest('.pro_stream_input_each').addClass('has-danger');
                }
                
                if(!error){

                    form.submit();
                }
            });


            $(".live_stream_thumb,.album_thumb").change(function(){

                var id = $(this).closest('.pro_left_video_img').find('.upload_vieo_img img').attr('id');
                readURL(this, id);
            });

            $('.display-stream-thumb').click(function(){

                $(this).closest('.pro_left_video_img').find('.live_stream_thumb').trigger('click');
            });

            $('.display-album-thumb').click(function(){

                $(this).closest('.pro_left_video_img').find('.album_thumb').trigger('click');
            });

            $('#add_agreement_license_end_term').change(function(){

                if($(this).val() == 'custom'){
                    $('#add_agreement_popup #add_agreement_end_term').attr('disabled', false).focus();
                }else{
                    $('#add_agreement_popup #add_agreement_end_term').val('').attr('disabled', true);
                }
            });

            $('#proffer_project_select_end_term').change(function(){

                if($(this).val() == 'custom'){
                    $('#proffer_project_popup #proffer_project_end_term').attr('disabled', false).focus();
                }else{
                    $('#proffer_project_popup #proffer_project_end_term').val('').attr('disabled', true);
                }
            });

            

            $('#profile_tab_01 #musical_section input[name="skill"],#profile_tab_01 #musical_section input[name="sec_skill"]').keyup(function(e) {

                var thiss = $(this);
                thiss.closest('.pro_inp_right').find('.pro_custom_drop_res').addClass('instant_hide');
                if(thiss.val().trim().length > 2){
                    $.ajax({
                        url: '/searchSkills',
                        dataType: 'json',
                        type: 'POST',
                        data: {'string' : thiss.val()},
                        success:function(data){
                            if(data.success){

                                var resultsRows = JSON.parse( JSON.stringify( data.result ) );
                                var response = '';
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var skillName = eachResultRow['value'];
                                        var skillId = eachResultRow['id'];
                                        response += '<li data-id="'+ skillId +'">'+ skillName +'</li>';
                                    }
                                }

                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = ''; }

                                if(response != ''){
                                    thiss.closest('.pro_inp_right').find('.pro_custom_drop_res').removeClass('instant_hide');
                                    thiss.closest('.pro_inp_right').find('.pro_custom_drop_res ul').html(response);
                                }
                            }else{
                                alert(data.error);
                            }
                        }
                    });
                }
            });

            $('.license_custom_price_outer input').keyup(function(e) {

                e.preventDefault();
                var price = $(this).val();
                $('.each_license .license_check_outer input[type=checkbox]:checked').each(function(){
                    var thiss = $(this).parent().parent();
                    thiss.find('.p_lic_right').val(price);
                });
            });

            $('.license_fill_options_each').click(function(){

                var value = $(this).attr('data-id');
                var container = $(this).closest('.pro_m_license_pric_sec');

                if(value == '4'){
                    container.find('.license_custom_price_outer input').val('').focus();
                    $('.each_license .license_check_outer input[type=checkbox]').prop('checked', true);
                }

                if(value == '1'){

                    container.find('.each_license .license_check_outer input[type=checkbox]').prop('checked', false);
                    container.find('.each_license').each(function(){

                        var thiss = $(this);
                        thiss.find('.p_lic_right').val(thiss.attr('data-price')=='POA'?'POA':parseFloat(thiss.attr('data-price')));
                    });
                }

                if(value == '2'){

                    container.find('.each_license .license_check_outer input[type=checkbox]').prop('checked', false);
                    container.find('.each_license').each(function(){

                        var thiss = $(this);
                        thiss.find('.p_lic_right').val(0);
                    });
                }

                if(value == '3'){

                    container.find('.each_license .license_check_outer input[type=checkbox]').prop('checked', false);
                    container.find('.each_license').each(function(){

                        var thiss = $(this);
                        thiss.find('.p_lic_right').val('POA');
                    });
                }

                if(value == '5'){

                    container.find('.each_license .license_check_outer input[type=checkbox]').prop('checked', false);
                    container.find('.each_license').each(function(){

                        var thiss = $(this);
                        thiss.find('.p_lic_right').val('');
                    });
                }
            });

            $('#musical_intro_btn').click(function(){

                $('.musical_intro').addClass('instant_hide');
                $('.musical_detail').removeClass('instant_hide');
            });

            $('#post_video_popup_02 #post_video_submit_yes').click(function(){

                if($('#post_video_popup_02 #replace_video').attr("checked")){
                    $('#post_video_popup_01 #replace_chart_entry').addClass('checked').removeClass('unchecked');
                    $('#post_video_popup_01 #replace_chart_entry').find('input[type=checkbox]').prop( "checked", true );
                }

                $('#post_video_popup_02,.body-overlay').hide();
                $('#post_video_popup_01,.body-overlay').show();
            });

            $('#post_video_popup_01 #replace_chart_entry').click(function(){

                var thiss = $(this);
                if(thiss.hasClass('checked')) {
                   
                   thiss.addClass('unchecked').removeClass('checked');
                   thiss.find('input[type=checkbox]').attr("checked", false);
                   $.ajax({

                        url: '/informationFinder',
                        type: "POST",
                        data: {'find_type': 'user_chart_entries', 'find': '', 'identity_type': 'self', 'identity': ''},
                        dataType: 'json',
                        success: function(response){
                            if(response.success == 1){
                                if(response.data.chartEntries > 0){
                                    $('#post_video_popup_01,.body-overlay').hide();
                                    $('#post_video_popup_02,.body-overlay').show();
                                }else{
                                    thiss.addClass('checked').removeClass('unchecked');
                                    thiss.find('input[type=checkbox]').prop("checked", true);
                                }
                            }else{
                                alert(response.error);
                            }
                        }
                    });
                };
            });

            $(".send_thankyou").click(function(){

                var thiss = $(this);
                
                var identity = thiss.attr('data-identity');
                var find = identity;
                var identityType = thiss.attr('data-identity-type');
                if(identityType == 'checkout_user'){
                    var findType = 'thank_customer';
                }else if(identityType == 'subscription_user'){
                    var findType = 'thank_subscriber';
                }

                $.ajax({

                    url: "/informationFinder",
                    dataType: "json",
                    type: 'post',
                    data: {'find_type': findType, 'find': find, 'identity_type': identityType, 'identity': identity},
                    success: function(response) { 
                        if(response.success == 1){
                            var customer = response.data.id;
                            var email = response.data.email;
                            var name = response.data.name;
                            var userHomeLink = response.data.profilePageLink;
                            var originalImage = response.data.profileImageOriginal;
                            
                            thank_you_user_name = name;
                            thank_you_user_id = customer;
                            thank_you_user_email = email;
                            thank_you_user_photo = originalImage;
                            thank_you_user_share_url = userHomeLink;
                            thank_you_type = identityType;
                            thank_you_id = identity;
                            type_id = '';
                            payment_type = '';

                            $(".soc_share_images").show();
                            $(".soc_share_buttons").show();
                            $(".email_box").hide();
                            $(".email_button").hide();
                            $('.pro_send_email_outer #thank_you_image').attr('src', thank_you_user_photo);
                            $(".pro_send_email_outer").show();
                            $('#body-overlay').show();
                        }else{
                            alert(response.error);
                        }
                    }
                });
            });

            $(".cancel_subscription").click(function(){

                if(confirm('Do you really want to end this subscription?')){
                    var thiss = $(this);
                    var identity = thiss.attr('data-identity');
                    $.ajax({

                        url: "/cancelSubscription",
                        dataType: "json",
                        type: 'post',
                        data: {'id': identity},
                        success: function(response) { 
                            if(response.success == 1){
                                alert('Subscription has been sucessfully cancelled');
                                thiss.closest('.my_sub_sec_list').remove();
                            }else{
                                alert(response.error);
                            }
                        }
                    });
                }
            });

            $(".details_subscription").click(function(){

                var thiss = $(this);
                var identity = thiss.attr('data-identity');
                var identityType = thiss.attr('data-identity-type');
                var find = thiss.attr('data-find');
                var findType = thiss.attr('data-find-type');

                $.ajax({

                    url: "/informationFinder",
                    dataType: "json",
                    type: 'post',
                    data: {'find_type': findType, 'find': find, 'identity_type': identityType, 'identity': identity},
                    success: function(response) { 
                        if(response.success == 1){

                            var image = response.data.image;
                            var heading = response.data.heading;
                            var bulletOne = response.data.bulletOne;
                            var bulletTwo = response.data.bulletTwo;
                            var bulletThree = response.data.bulletThree;

                            $('#subscription_offers_popup .profile_img').attr('src', image);
                            $('#subscription_offers_popup .profile_heading').text(heading);
                            $('#subscription_offers_popup .bullet_one').text(bulletOne);
                            $('#subscription_offers_popup .bullet_two').text(bulletTwo);
                            $('#subscription_offers_popup .bullet_three').text(bulletThree);

                            $('#subscription_offers_popup,#body-overlay').show();
                        }else{
                            alert(response.error);
                        }
                    }
                });
            });

            $("#facebook_share").click(function () {

                var baseUrl = $('#base_url').val();
                $('#url_share_user_name').val(thank_you_user_name);
                $('#url_share_link').val(baseUrl+'url-share/'+'profilethankyou_'+thank_you_user_id+'_'+window.currentUserId+'_'+thank_you_type+'_'+thank_you_id+'/'+encodeURIComponent('Thank You '+thank_you_user_name)+'/'+btoa(thank_you_user_photo));
                facebookShare('url');
            });

            $("#twitter_share").click(function () {

                var baseUrl = $('#base_url').val();
                $('#url_share_user_name').val(thank_you_user_name);
                $('#url_share_link').val(baseUrl+'url-share/'+'profilethankyou_'+thank_you_user_id+'_'+window.currentUserId+'_'+thank_you_type+'_'+thank_you_id+'/'+encodeURIComponent('Thank You '+thank_you_user_name)+'/'+btoa(thank_you_user_photo));
                twitterShare('url');
            });

            $("#share_project_popup .hm_fb_icon_share").click(function () {

                var baseUrl = $('#base_url').val();
                var name = encodeURIComponent($(this).closest('#share_project_popup').attr('data-name'));
                var imageName = $(this).closest('#share_project_popup').attr('data-share-image');
                var elm = '/'+name+'/'+btoa(imageName);
                
                $('#url_share_link').val(baseUrl+'url-share/'+'project_'+window.currentUserId+elm);
                facebookShare('url');
                
            });

            $("#share_project_popup .hm_tw_icon_share").click(function () {

                var baseUrl = $('#base_url').val();
                var name = encodeURIComponent($(this).closest('#share_project_popup').attr('data-name'));
                var imageName = $(this).closest('#share_project_popup').attr('data-share-image');
                var elm = '/'+name+'/'+btoa(imageName);
                
                $('#url_share_link').val(baseUrl+'url-share/'+'project_'+window.currentUserId+elm);
                twitterShare('url');
            });

            $("#thank_via_email_btn").click(function () {

                $("#thankyou_email_text").text("");

                $(".soc_share_images").hide();

                $(".soc_share_buttons").hide();

                $(".email_box").show();

                $(".email_button").show();

            });

            $("#send_thankyou_email").click(function () {

                var message = $("#thankyou_email_text").val();

                if(message != ''){

                    var formData = new FormData();
                    formData.append('email', thank_you_user_email);
                    formData.append('name', thank_you_user_name);
                    formData.append('message', message);
                    formData.append('type_id', type_id);
                    formData.append('payment_type', payment_type);

                    $.ajax({

                        url: '/sendThanksEmail',
                        type: "POST",
                        data: formData,
                        dataType: 'html',
                        contentType:false,
                        cache: false,
                        processData: false,

                        success: function(data){

                            $(".pro_send_email_outer").hide();
                            $('#body-overlay').hide();
                            $("#thankyou_email_text").val('');
                        }
                    });
                }
            });


            $('.loop_file_button').click(function(e){

                e.preventDefault();
                var name = $(this).data('name');
                $('input[id="'+name+'"]').trigger('click');
            });

            $('.loop_file_name').click(function(e){

                e.preventDefault();
                var thiss = $(this);
                var name = thiss.parent().find('.loop_file_button').data('name');
                if(thiss.hasClass('loop_edit')){

                    //delete the loop/stem from db via ajax
                    $.ajax({

                        url: "/removeMusicTrack",
                        dataType: "json",
                        type: 'post',
                        data: {'track' : name},
                        success: function(data) {
                            if(data.success == 1){
                                $('input[id="'+name+'"]').val('');
                                thiss.addClass('instant_hide');
                                thiss.parent().find('.loop_file_button').removeClass('instant_hide');
                            }else{
                                alert(data.error);
                            }
                        }
                    });
                }else{

                    $('input[id="'+name+'"]').val('');
                    thiss.addClass('instant_hide');
                    thiss.parent().find('.loop_file_button').removeClass('instant_hide');
                }
            });

            $("input[name=cou_id]").bind('keyup', function(event){

                var thiss = $(this);
                thiss.closest('.pro_inp_outer').find('.country_results').addClass('instant_hide');
                if(thiss.val().trim().length > 2){
                    $.ajax({
                        url: '/searchCountries',
                        dataType: 'json',
                        type: 'POST',
                        data: {'string' : thiss.val()},
                        success:function(data){
                            if(data.success){

                                var resultsRows = JSON.parse( JSON.stringify( data.result ) );
                                
                                if(data.totalRecords == 0){
                                    var response = '<li data-id="0">No result</li>';
                                }else{
                                    var response = '';
                                }
                                
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var name = eachResultRow['name'];
                                        var id = eachResultRow['id'];
                                        response += '<li data-id="'+ id +'">'+ name +'</li>';
                                    }
                                }

                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = '<li data-id="0">Could not find any matching records</li>'; }

                                thiss.closest('.pro_inp_outer').find('.country_results .pro_country_list_drop ul').html(response);
                                thiss.closest('.pro_inp_outer').find('.country_results').removeClass('instant_hide');
                            }else{
                                alert(data.error)
                            }
                        }
                    });
                }
            });

            $("input[name=cit_id]").bind('keyup', function(event){

                var thiss = $(this);
                thiss.closest('.pro_inp_outer').find('.city_results').addClass('instant_hide');
                if(thiss.val().trim().length > 2){
                    $.ajax({
                        url: '/searchCities',
                        dataType: 'json',
                        type: 'POST',
                        data: {'string' : thiss.val()},
                        success:function(data){
                            if(data.success){

                                var resultsRows = JSON.parse( JSON.stringify( data.result ) );
                                
                                if(data.totalRecords == 0){
                                    var response = '<li data-id="0">No result</li>';
                                }else{
                                    var response = '';
                                }
                                
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var name = eachResultRow['name'];
                                        var id = eachResultRow['id'];
                                        response += '<li data-id="'+ id +'">'+ name +'</li>';
                                    }
                                }

                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = '<li data-id="0">Could not find any matching records</li>'; }

                                thiss.closest('.pro_inp_outer').find('.city_results .pro_city_list_drop ul').html(response);
                                thiss.closest('.pro_inp_outer').find('.city_results').removeClass('instant_hide');
                            }else{
                                alert(data.error)
                            }
                        }
                    });
                }
            });

            $("input[name=instruments]").bind('click keyup', function(event) {

                var thiss = $(this);
                thiss.closest('.pro_music_instruments_outer').find('.music_instruments_results').addClass('instant_hide');
                if(thiss.val().trim().length > 2){
                    $.ajax({
                        url: '/searchInstruments',
                        dataType: 'json',
                        type: 'POST',
                        data: {'string' : thiss.val()},
                        success:function(data){
                            if(data.success){

                                var resultsRows = JSON.parse( JSON.stringify( data.result ) );
                                var response = '<li data-id="0">No instruments</li>';
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var skillName = eachResultRow['value'];
                                        var skillId = eachResultRow['id'];
                                        response += '<li data-id="'+ skillId +'">'+ skillName +'</li>';
                                    }
                                }

                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = '<li data-id="0">Could not find any matching records</li>'; }

                                thiss.closest('.pro_music_instruments_outer').find('.music_instruments_results').removeClass('instant_hide');
                                thiss.closest('.pro_music_instruments_outer').find('.music_instruments_results .pro_instruments_list_drop ul').html(response);
                            }else{
                                alert(data.error)
                            }
                        }
                    });
                }
            });

            $("input[name=pro_service]").bind('keyup', function(event) {

                var thiss = $(this);
                thiss.closest('.pro_stream_input_each').find('.pro_services_results').addClass('instant_hide');
                if(thiss.val().trim().length > 2){
                    $.ajax({
                        url: '/searchServices',
                        dataType: 'json',
                        type: 'POST',
                        data: {'string' : thiss.val()},
                        success:function(data){
                            if(data.success){

                                var resultsRows = JSON.parse( JSON.stringify( data.result ) );
                                var response = '';
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var skillName = eachResultRow['name'];
                                        var skillId = eachResultRow['id'];
                                        response += '<li data-id="'+ skillId +'">'+ skillName +'</li>';
                                    }
                                }

                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = ''; }

                                if(totalMatchingRecords){
                                    thiss.closest('.pro_stream_input_each').find('.pro_services_results').removeClass('instant_hide');
                                    thiss.closest('.pro_stream_input_each').find('.pro_services_results .pro_services_list_drop ul').html(response);
                                }
                            }else{
                                alert(data.error)
                            }
                        }
                    });
                }
            });
            
            $("input[name=more_moods]").bind('click keyup', function(event) {

                var thiss = $(this);
                thiss.closest('.pro_music_moods_outer').find('.music_moods_results').addClass('instant_hide');
                if(thiss.val().trim().length > 2){
                    $.ajax({
                        url: '/searchMoods',
                        dataType: 'json',
                        type: 'POST',
                        data: {'string' : thiss.val()},
                        success:function(data){
                            if(data.success){

                                var resultsRows = JSON.parse( JSON.stringify( data.result ) );
                                var response = '<li data-id="0">No moods</li>';
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var skillName = eachResultRow['name'];
                                        var skillId = eachResultRow['id'];
                                        response += '<li data-id="'+ skillId +'">'+ skillName +'</li>';
                                    }
                                }

                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = '<li data-id="0">Could not find any matching records</li>'; }

                                thiss.closest('.pro_music_moods_outer').find('.music_moods_results').removeClass('instant_hide');
                                thiss.closest('.pro_music_moods_outer').find('.music_moods_results .pro_moods_list_drop ul').html(response);
                            }else{
                                alert(data.error)
                            }
                        }
                    });
                }
            });

            $("input[name=further_skills]").bind('click keyup', function(event) {

                var thiss = $(this);
                $('.pro_further_skill_list_drop_outer').addClass('instant_hide');
                if(thiss.val().trim().length > 2){
                    $.ajax({
                        url: '/searchInstruments',
                        dataType: 'json',
                        type: 'POST',
                        data: {'string' : thiss.val()},
                        success:function(data){
                            if(data.success){

                                var resultsRows = JSON.parse( JSON.stringify( data.result ) );
                                var response = '<li data-id="0">No instruments</li>';
                                for (var id in resultsRows) {

                                    if (resultsRows.hasOwnProperty(id)) {

                                        var eachResultRow = JSON.parse(JSON.stringify(resultsRows[id]));
                                        var skillName = eachResultRow['value'];
                                        var skillId = eachResultRow['id'];
                                        response += '<li data-id="'+ skillId +'">'+ skillName +'</li>';
                                    }
                                }

                                var totalMatchingRecords = data.totalRecords;
                                if( totalMatchingRecords ) { response = response; }
                                else { response = '<li data-id="0">Could not find any matching records</li>'; }

                                $('.pro_further_skill_list_drop_outer').removeClass('instant_hide');
                                $('.pro_further_skill_list_drop_outer .pro_further_skill_list_drop ul').html(response);
                            }else{
                                alert(data.error)
                            }
                        }
                    });
                }
            });

            $('body').click(function(e){

                if ($(e.target).is(':not(li)')) {

                    $(".pro_custom_drop_res").addClass('instant_hide');
                    $('input[name="further_skills"],input[name="more_moods"],input[name="instruments"]').val('');
                }
            });

            $('body').delegate('.pro_further_skill_list_drop_outer ul li', 'click', function(e){

                var text = $(this).text();
                if($(this).attr('data-id') == '0'){

                }else{
                    
                    $('#further_skill_each_item_temp').find('.profile_custom_drop_title').text(text);
                    var html = $('#further_skill_each_item_temp').html();
                    $('#further_skills_results').append(html);
                }

                $('input[name="further_skills"]').val('');
                $('.pro_further_skill_list_drop_outer').addClass('instant_hide');
            });

            $('body').delegate('.country_results ul li', 'click', function(e){

                var value = $(this).attr('data-id');
                if(value == '0'){

                    $('input[name="country_id"]').val('');
                    $('input[name="cou_id"]').val('');
                }else{
                    
                    $('input[name="country_id"]').val(value);
                    $('input[name="cou_id"]').val($(this).text());
                }

                $('.country_results').addClass('instant_hide');
            });

            $('body').delegate('.city_results ul li', 'click', function(e){

                var value = $(this).attr('data-id');
                if(value == '0'){

                    $('input[name="city_id"]').val('');
                    $('input[name="cit_id"]').val('');
                }else{
                    
                    $('input[name="city_id"]').val(value);
                    $('input[name="cit_id"]').val($(this).text());
                }

                $('.city_results').addClass('instant_hide');
            });

            $('body').delegate('.music_instruments_results ul li', 'click', function(e){

                var thiss = $(this);
                var text = thiss.text();
                if(thiss.attr('data-id') == '0'){

                }else{
                    
                    $('#further_skill_each_item_temp').find('.profile_custom_drop_title').text(text);
                    var html = $('#further_skill_each_item_temp').html();
                    thiss.closest('.pro_music_instruments_outer').find('.music_instruments_saved').append(html);
                }

                thiss.closest('.pro_music_instruments_outer').find('input[name="instruments"]').val('');
                thiss.closest('.pro_music_instruments_outer').find('.music_instruments_results').addClass('instant_hide');
            });

            $('body').delegate('.pro_services_results ul li', 'click', function(e){

                var thiss = $(this);
                var text = thiss.text();
                if(thiss.attr('data-id') == '0'){

                }else{
                    thiss.closest('.pro_stream_input_each').find('input[name="pro_service"]').val(text);
                }

                thiss.closest('.pro_stream_input_each').find('.pro_services_results').addClass('instant_hide');
            });

            $('body').delegate('.pro_main_skill_list_drop ul li,.pro_sec_skill_list_drop ul li', 'click', function(e){

                var thiss = $(this);
                var text = thiss.text();
                if(thiss.attr('data-id') == '0'){

                }else{
                    thiss.closest('.pro_inp_right').find('input[type="text"]').val(text);
                }

                thiss.closest('.pro_inp_right').find('.pro_custom_drop_res').addClass('instant_hide');
            });

            $('body').delegate('.music_moods_results ul li', 'click', function(e){

                var thiss = $(this);
                var text = thiss.text();
                if(thiss.attr('data-id') == '0'){

                }else{
                    
                    $('#further_skill_each_item_temp').find('.profile_custom_drop_title').text(text);
                    var html = $('#further_skill_each_item_temp').html();
                    thiss.closest('.pro_music_moods_outer').find('.music_moods_saved').append(html);
                }

                thiss.closest('.pro_music_moods_outer').find('input[name="more_moods"]').val('');
                thiss.closest('.pro_music_moods_outer').find('.music_moods_results').addClass('instant_hide');
            });

            $('body').delegate('.profile_custom_drop_each .profile_custom_drop_icon', 'click', function(e){

                var thiss = $(this);
                if(confirm('Are you sure?')){
                    thiss.closest('.profile_custom_drop_each').remove();
                }
            });

        });

        