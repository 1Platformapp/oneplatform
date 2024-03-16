$('#search_social_music_directory input').keyup(function(){

        var string = $(this).val();
        if(string.length >= 3){
            $('#cancel_search_social_music').addClass('instant_hide');
            $('#search_busy').removeClass('instant_hide');
            var formData = new FormData();
            formData.append('search', string);
            $.ajax({

                url: '/search-social-directory',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    if(response.success){
                        $('.pro_music_search_results').html(response.result).removeClass('instant_hide');
                    }
                    $('#cancel_search_social_music').removeClass('instant_hide');
                    $('#search_busy').addClass('instant_hide');
                }
            });
        }else{
            $('.pro_music_search_results').html('').addClass('instant_hide');
        }
    });

    $('#cancel_search_social_music').click(function(){
        $('.pro_music_search_results').html('').addClass('instant_hide');
        $('#search_social_music_directory input').val('');
    });

    $('body').delegate('#add_music_section .each_license_terms_handle', 'click', function(e){

        $(this).closest('.each_license_terms').find('.each_license_terms_each').slideToggle();
        $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
    });

    $('body').delegate('#edit_music_section .each_license_terms_handle', 'click', function(e){

        var target = $(this).closest('.each_license');
        var licenseName = target.find('.p_lic_left').text();
        var source = $('#add_music_section').find('.p_lic_left:contains("'+licenseName+'")');
        if(source.length){
            source = source.closest('.each_license');
        }
        if(source.length){

            var html = source.find('.each_license_terms_each').html();
            target.find('.each_license_terms_each').html(html);
            target.find('.each_license_terms .each_license_terms_each').slideToggle();
            target.find('.each_license_terms .each_license_terms_handle').find('i').toggleClass('fa-angle-down fa-angle-up');
        }
    });

    $('body').delegate( ".add_links", "click", function(e){

        var thiss = $(this);
        var url = thiss.attr('data-url');
        var frameUrl = 'https://embed.song.link/?url='+url+'&theme=light';
        var formData = new FormData();
        formData.append('url', frameUrl);
        formData.append('action', 'add');

        $.ajax({

            url: '/save-user-smart-links',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if(response.success){
                    $('.smart_links_frame_contain').html('<iframe style="margin-top: 20px;" id="smart_links_frame" width="100%" height="52" src="'+frameUrl+'&theme=light" frameborder="0" allowfullscreen sandbox="allow-same-origin allow-scripts allow-presentation allow-popups allow-popups-to-escape-sandbox"></iframe>');
                    $('#remove_smart_links').removeClass('instant_hide');
                }
                $('#cancel_search_social_music').click();
            }
        });
    });

    $('#remove_smart_links').click(function(){
        if(confirm("Are you sure?")){

            var formData = new FormData();
            formData.append('action', 'remove');
            $.ajax({

                url: '/save-user-smart-links',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    if(response.success){
                        $('.smart_links_frame_contain').html('');
                        $('#remove_smart_links').addClass('instant_hide');
                    }
                }
            });
        }
    });

    $('document').ready(function(){

        $('.mu_down_each .mu_down_file_button').click(function(){

            var thiss = $(this);
            if(thiss.parent().hasClass('active') || thiss.parent().hasClass('mu_filled')){

                if(thiss.parent().hasClass('mu_filled')){
                    thiss.parent().addClass('mu_to_be_deleted');
                }
                thiss.parent().removeClass('active').removeClass('mu_filled');
                thiss.parent().find('.mu_down_file').val('');
                thiss.parent().find('.mu_down_file_name').addClass('instant_hide');
                thiss.parent().find('.mu_down_btn_text').removeClass('instant_hide');
            }else{
                thiss.parent().find('.mu_down_file').trigger('click');
            }
        });

        $('.mu_down_file').change(function(e){

            e.preventDefault();

            var elem = $(this);
            var filename = elem[0].files[0].name;
            var data = e.originalEvent.target.files[0];
            var extension = data.type;

            if(data.size > 60*1024*1024) {
                elem.val('');
                alert('File cannot be more than 60MB');
                return false;
            }

            if(extension != 'audio/wav' && extension != 'audio/mp3' && extension != 'audio/mpeg'){
                elem.val('');
                alert('We only support MP3 and WAV audio file formats');
                return false;
            }

            elem.parent().removeClass('mu_to_be_deleted');
            elem.parent().addClass('active');
            elem.parent().find('.mu_down_file_name').text(filename).removeClass('instant_hide');
            elem.parent().find('.mu_down_btn_text').addClass('instant_hide');
        });

        $('#close_upload').click(function(){

            sessionStorage.setItem('preload_cat', 'media');
            sessionStorage.setItem('preload_subcat', 'edit_musics');
            
            location.reload();
            // if(window.location.href.indexOf('/quick-setup/') !== -1){
            //     window.location.href = '/quick-setup/add-products';
            // }else{
            //     window.location.href = '/profile';
            // }
        });
        $('.m_btm_private').click(function(){

            var thiss = $(this);
            var id = thiss.attr('data-music-id');
            var pin = thiss.attr('data-music-pin');
            if(id != ''){

                $('#music_private_popup').attr('data-music-id', id);
                if(thiss.hasClass('active')){
                    $('#music_private_popup .new_popup_check_out').addClass('active');
                    $('#music_private_popup .new_popup_check_out .new_popup_check:first').val('1');
                }else{
                    $('#music_private_popup .new_popup_check_out').removeClass('active');
                    $('#music_private_popup .new_popup_check_out .new_popup_check:first').val('0');
                }
                $('#music_private_popup #private_music_pin').val(pin);
                $('#music_private_popup,#body-overlay').show();
            }
        });

        $('#save_music_private').click(function(){

            var error = 0;
            var pin = $('#music_private_popup #private_music_pin').val();
            var musicId = $('#music_private_popup').attr('data-music-id');
            var status = $('#music_private_popup .new_popup_check_out .new_popup_check:first').val();
            $('#music_private_popup .error').addClass('instant_hide');
            if(status == '1' && pin == ''){

                error = 1;
                $('#pin_error').removeClass('instant_hide');
            } 

            if(!error){

                var formData = new FormData();
                formData.append('music_id', musicId);
                formData.append('status', status);
                formData.append('pin', pin);
                $.ajax({

                    url: '/save-user-music-privacy',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (response) {
                        var musicLockIcon = $('.m_btm_private[data-music-id="'+musicId+'"]');
                        if(response.success){
                            if(status == '1'){

                                musicLockIcon.addClass('active');
                                musicLockIcon.attr('data-music-pin', pin);
                            }else{
                                musicLockIcon.removeClass('active');
                                musicLockIcon.attr('data-music-pin', pin);
                            }
                        }
                        $('#music_private_popup,#body-overlay').hide();
                    }
                });
            }  
        });

        $('.music_license_expand .music_license_button').click(function(){

        	$(this).closest('.music_license_expand').find('.music_license_expansion').slideToggle('slow');
        });

        $('.music_license_rail_button').click(function(){

        	$(this).closest('.music_license_rail_each').find('.music_license_rail_expansion').slideToggle('slow');
        });

        $('.pro_product_price_option').change(function(){

            var value = $(this).val();
            var form = $(this).closest('form');
            if(value != 'addprice'){
                form.find('.product_price').val('');
                form.find('.product_price').attr('disabled', 'disabled');
            }else{
                form.find('.product_price').removeAttr('disabled');
                form.find('.product_price').focus();
            }
        });

        $('.pro_product_shipping_option').change(function(){

            var value = $(this).val();
            var form = $(this).closest('form');
            if(value != 'yes'){
                form.find('.local_delivery,.international_shipping').val('');
                form.find('.local_delivery,.international_shipping').attr('disabled', 'disabled');
            }else{
                form.find('.local_delivery,.international_shipping').removeAttr('disabled');
                form.find('.local_delivery').focus();
            }
        });

        $('.pro_product_ticket_option').change(function(){

            var value = $(this).val();
            var form = $(this).closest('form');
            if(value != 'yes'){
                form.find('.product_ticket_date_time,.product_ticket_location,.product_ticket_terms').val('');
                form.find('.product_ticket_date_time,.product_ticket_location,.product_ticket_terms').attr('disabled', 'disabled');
            }else{
                form.find('.product_ticket_date_time,.product_ticket_location,.product_ticket_terms').removeAttr('disabled');
                form.find('.product_ticket_date_time').focus();
            }
        });

        $('#upload_design_rr,#upload_design_rl').click(function(){

        	var image = $('.d_manipulator_elem');
        	var angle = parseInt(image.attr('data-rotate'));

        	angle = ($(this).attr('id') == 'upload_design_rr') ? angle + 3 : angle - 3;
        	image.attr('data-rotate', angle);

	     	image.css({
	     	      'transform': 'rotate(' + angle + 'deg)',
	     	      '-ms-transform': 'rotate(' + angle + 'deg)',
	     	      '-moz-transform': 'rotate(' + angle + 'deg)',
	     	      '-webkit-transform': 'rotate(' + angle + 'deg)',
	     	      '-o-transform': 'rotate(' + angle + 'deg)'
	     	    }); 
	   	});

	   	$('#upload_design_zi,#upload_design_zo').click(function(){

        	var image = $('.d_manipulator_elem');
        	var width = parseInt(image.first().width());

        	var newWidth = ($(this).attr('id') == 'upload_design_zi') ? width + 3 : width - 3;
        	if(newWidth > 0){

        		image.css({'width': newWidth+'px'}); 
        	}
	   	});

	   	$('#upload_design_refresh').click(function(){

        	var image = $('.d_manipulator_elem');
        	image.attr('data-rotate', '0');
        	
	     	image.css({
	     	      'transform': '',
	     	      '-ms-transform': '',
	     	      '-moz-transform': '',
	     	      '-webkit-transform': '',
	     	      '-o-transform': '',
	     	      'left': 0,
	     	      'top': 0,
	     	    });

	     	image.css('width', 'auto');
	   	});

	   	$('#upload_design_center').click(function(){

	   		var image = $('.d_manipulator_elem');
	   		var parent = $('.d_manipulator_area');

	   		var top = (parseInt(parent.css('height').replace(/px/g,''))/2) - (parseInt(image.css('height').replace(/px/g,'')/2));
	   		var left = (parseInt(parent.css('width').replace(/px/g,''))/2) - (parseInt(image.css('width').replace(/px/g,'')/2));

        	image.attr('data-rotate', '0');
        	
	     	image.css({
	     		'left': left,
	     	    'top': top,
	     	});
	   	});

	   	$('.pro_options_each').click(function(){

	   		$('.pro_options_each').removeClass('active');
	   		$(this).addClass('active');

	   		var href = $('.pro_options_each.active').attr('data-href');
	   		$('.pro_option_body_each').addClass('instant_hide');
	   		$('.pro_option_body_each[data-id="'+href+'"]').removeClass('instant_hide');
	   	});

	   	$('.pro_design_exist_each').click(function(){

	   		$(this).find('input[type="radio"]').prop("checked", true);
	   	});

        $('#pro_design_file').change(function(e){

            var data = e.originalEvent.target.files[0];

            if(data.size > 10*1024*1024){
                
                $(this).val('');
                alert('File size cannot be more than 10MB');
                return false;
            }

            var thiss = $(this);
            var _URL = window.URL || window.webkitURL;
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function () {
                    if(this.width < 800 || this.height < 800){
                        $('#pro_design_file').val('');
                        alert('Image dimension should be at least 800px on either side');
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        $('input[name="pro_prod_value"]').change(function(){

            var prodRadio = $('input[name="pro_prod_value"]:checked');
            var parent = prodRadio.closest('.pro_design_st3_prod_option_each');
            var image = parent.find('.st3_prod_option_thumb img').attr('src');
            $('.d_manipulator_in').css('background-image', 'url('+image+')');
            var left = parseInt(parent.attr('data-pos-left'));
            var top = parseInt(parent.attr('data-pos-top'));
            var width = parseInt(parent.attr('data-width'));
            var height = parseInt(parent.attr('data-height'));

            $('.d_manipulator_area').css({
            	'left' : left,
            	'top' : top,
            	'width' : width,
            	'height' : height,
            });

            $('#upload_design_refresh').trigger('click');
        });

        $('.save_design_step_one').click(function(){

            $('#pro_design_st1_error').addClass('instant_hide');
            var designNewFile = $('#pro_design_file');
            var designExistingFile = $('input[name="pro_design_value"]:checked');
            if(designNewFile.val() == '' && (designExistingFile.length == 0 || designExistingFile.val() == '')){
                $('#pro_design_st1_error').removeClass('instant_hide');
                $('html, body').animate({scrollTop: $('#pro_design_st1_error').offset().top - 80}, 'slow');
            }else{

            	$('.pro_design_expand:not(:first-of-type)').removeClass('enabled');
            	$('.pro_design_expand').find('.music_license_button').removeClass('complete');
            	$('.pro_design_expand').find('.pro_design_expansion').addClass('instant_hide');

                if(designNewFile.val() != ''){
                    var formData = new FormData();
                    formData.append('pro_design_file', designNewFile[0].files[0]);
                    $('#pro_uploading_in_progress_real,#body-overlay').show();
                }else{
                    var formData = new FormData();
                    formData.append('pro_design_exist_file', designExistingFile.val());
                }
                formData.append('step', '1');
                sendDesignAjax(formData);
            }
        });

        $('.save_design_step_two').click(function(){

        	var browserWidth = $( window ).width();
            var designProcess = $('input[name="pro_design_st2"]:checked');
            var image = designProcess.closest('.pro_design_st_2_each').find('.pro_design_st2_thumb img').attr('src');

            var stepElem = $('.pro_design_expand[data-id="pro_design_st3"]');
            $('.pro_design_expand[data-id="pro_design_st2"] .music_license_button').addClass('complete');
            stepElem.addClass('enabled');
            stepElem.find('.pro_design_expansion').removeClass('instant_hide');

            $('.d_manipulator_elem').attr('src', image).css('display', 'inherit');
            $('.d_manipulator_elem').draggableTouch('disable', $('.d_manipulator_area'));
            $('.d_manipulator_elem').draggableTouch('', $('.d_manipulator_area'));

            var firstPro = $('.pro_m_license_pric_sec[data-id="pro_design_st3"] .pro_design_st3_prod_option_each:first-child');
            var FPLeft = parseInt(firstPro.attr('data-pos-left'));
            var FPTop = parseInt(firstPro.attr('data-pos-top'));
            var FPWidth = parseInt(firstPro.attr('data-width'));
            var FPHeight = parseInt(firstPro.attr('data-height'));

            firstPro.find('input[type="radio"]').prop('checked', true);

            $('.d_manipulator_in').css({
            	'background-image': 'url('+firstPro.find('.st3_prod_option_thumb img').attr('src')+')'
            });

            $('.d_manipulator_in .d_manipulator_area').css({
            	'top' : FPTop,
            	'left' : FPLeft,
            	'width' : FPWidth,
            	'height' : FPHeight
            });

            $('html, body').animate({scrollTop: stepElem.offset().top - 60}, 'slow');
        });

        $('.save_design_step_three').click(function(){

            var designProduct = $('input[name="pro_prod_value"]:checked');
            var designProcess = $('input[name="pro_design_st2"]:checked');
            var image = designProduct.closest('.pro_design_st3_prod_option_each').find('.st3_prod_option_thumb img').attr('src');
            var design = designProcess.closest('.pro_design_st_2_each').find('.pro_design_st2_thumb img').attr('src');
            var product = designProduct.closest('.pro_design_st3_prod_option_each').attr('data-type');

            var manipElem = $('.d_manipulator_elem');
            var manipulator = $('.d_manipulator_area');
            
            if($('.d_manipulator_elem').overflowing('.d_manipulator_area')){

            	alert('Warning: Your design image partly lies outside the allowed area. To ensure accurate printing, we recommend to keep your design inside of it');
            }

            var top = parseInt(manipElem.css('top').replace(/px/g,'')) + parseInt(manipulator.css('top').replace(/px/g,''));
            var left = parseInt(manipElem.css('left').replace(/px/g,'')) + parseInt(manipulator.css('left').replace(/px/g,''));
            var width = parseInt(manipElem.width());
            var height = parseInt(manipElem.height());
            var angle = getRotationDegrees($('.d_manipulator_elem'));

            var stepElem = $('.pro_design_expand[data-id="pro_design_st4"]');
            $('.pro_design_expand[data-id="pro_design_st3"] .music_license_button').addClass('complete');
            stepElem.addClass('enabled');
            stepElem.find('.pro_design_expansion').removeClass('instant_hide');

            $('.pro_m_license_pric_sec[data-id="pro_design_st4"] .pro_design_st4_prod_outer').css({
                'background-image': 'url('+image+')'
            });

            $('.pro_m_license_pric_sec[data-id="pro_design_st4"] .pro_design_st4_prod_outer img').attr('src', design).css({

                'left' : left,
                'top' : top,
                'width': width,
                'height': height,
                'transform': 'rotate('+angle+'deg)'
            });

            $('.pro_m_license_pric_sec[data-id="pro_design_st4"] .pro_design_st3_prod_options').addClass('instant_hide');

            $('.pro_m_license_pric_sec[data-id="pro_design_st4"] .pro_design_st3_prod_options[data-colors-for="'+product+'"]').removeClass('instant_hide')
            .find('.st3_prod_option_thumb img').each(function(){

            	$(this).attr('src', $(this).attr('data-src'));
            });

            $('select[name="pro_prod_color_default"]').html('');
            $('.pro_m_license_pric_sec[data-id="pro_design_st4"] .pro_design_st3_prod_options[data-colors-for="'+product+'"] .pro_design_st4_prod_option_each').each(function(){

            	var thiss = $(this);
            	var name = thiss.find('.st4_prod_option_name').text().trim();
            	var value = thiss.find('.st4_prod_option_field input[type="checkbox"]').val();
            	$('select[name="pro_prod_color_default"]').html($('select[name="pro_prod_color_default"]').html()+'<option value="'+value+'">'+name+'</option>');
            });

            $('html, body').animate({scrollTop: stepElem.offset().top - 60}, 'slow');
        });

        $('.pro_design_st3_prod_option_each .st3_prod_option_thumb,.pro_design_st3_prod_option_each .st3_prod_option_name').click(function(){

        	$(this).closest('.pro_design_st3_prod_option_each').find('input[name="pro_prod_value"]').prop('checked', true);
        	$('input[name="pro_prod_value"]').trigger('change');
        });

        $('.pro_design_st4_prod_option_each .st3_prod_option_thumb').click(function(){

            var thiss = $(this);
        	var src = thiss.find('img').attr('src');
        	thiss.closest('.pro_design_st_3_outer').find('.pro_design_st4_prod_outer').css('background-image', 'url('+src+')');
        });

        $('.st4_prod_option_name').click(function(){

        	var checkbox = $(this).closest('.st4_prod_option_action').find('input[type="checkbox"]');
        	checkbox.prop('checked', !checkbox.prop('checked'));
        });

        $('.pro_design_st2_thumb,.pro_dst2_picker_name').click(function(){
        	$(this).closest('.pro_design_st_2_each').find('.pro_dst2_picker_field input[type="radio"]').prop('checked', true);
        });

        $('.save_design_step_four').click(function(){

        	var formData = new FormData();
        	formData.append('pro_prod_value', $('input[name="pro_prod_value"]:checked').val());
        	formData.append('step', '4');
        	sendDesignAjax(formData);
        });

        $('.pro_design_st_5_comm_calc').click(function(){

            var formData = new FormData();
            formData.append('pro_prod_value', $('input[name="pro_prod_value"]:checked').val());
            formData.append('pro_base_price', $('input[name="pro_prod_price"]').val());
            formData.append('step', '5');
            sendDesignAjax(formData);
        });

        $('.pro_edit_design_st_5_comm_calc').click(function(){

            var formData = new FormData();
            formData.append('pro_prod_value', $(this).closest('.pro_design_st_3_outer').attr('data-prod-id'));
            formData.append('pro_base_price', $(this).closest('.pro_design_st_3_outer').find('input[name="pro_edit_prod_price"]').val());
            formData.append('step', 'edit');
            sendDesignAjax(formData);
        });

        $('.save_design_step_five').click(function(){

            var prodDesign = $('#pro_prod_design').val();
            var prodName = $('input[name="prod_name"]').val();
            //var prodType = $('input[name="pro_design_st2"]:checked').val();
            var prodType = 2;
            var prodValue = $('input[name="pro_prod_value"]:checked').val();
            var manipulator = $('.d_manipulator_area');
            var manipuatorElem = $('.d_manipulator_elem');
            var top = parseInt(manipuatorElem.css('top').replace(/px/g,'')) + parseInt(manipulator.css('top').replace(/px/g,''));
            var left = parseInt(manipuatorElem.css('left').replace(/px/g,'')) + parseInt(manipulator.css('left').replace(/px/g,''));
            var width = parseInt(manipuatorElem.width());
            var height = parseInt(manipuatorElem.height());
            var angle = getRotationDegrees($('.d_manipulator_elem'));
            var colorsParent = $('.pro_m_license_pric_sec[data-id="pro_design_st4"] .pro_design_st3_prod_options:not(.instant_hide)');
            var colors = '';
            colorsParent.find('input[type="checkbox"]:checked').each(function(){
                colors += $(this).val()+',';
            });
            var prodColorDefault = $('select[name="pro_prod_color_default"]').val();
            var prodPrice = $('input[name="pro_prod_price"]').val();

            var success = 1;
            var message = '';
            if(prodDesign == ''){

                success = 0;
                message = 'Choose your design image';
            }
            if(prodType == ''){

                success = 0;
                message = 'Choose design type';
            }
            if(prodValue == ''){

                success = 0;
                message = 'Choose your design image';
            }
            if(colors == ''){

                success = 0;
                message = 'Choose product color(s)';
            }
            if(prodPrice <= 0 || prodPrice == ''){

                success = 0;
                message = 'Product price is required';
            }

            if(success){

                var formData = new FormData();
                formData.append('prodDesign', prodDesign);
                formData.append('prodName', prodName);
                formData.append('prodType', prodType);
                formData.append('prod', prodValue);
                formData.append('top', top);
                formData.append('left', left);
                formData.append('width', width);
                formData.append('height', height);
                formData.append('angle', angle);
                formData.append('prodColors', colors.trim(','));
                formData.append('prodDefaultColor', prodColorDefault);
                formData.append('prodPrice', prodPrice);
                formData.append('step', '5b');

                sendDesignAjax(formData);
            }else{
                alert(message);
            }
        });

        $('.pro_edit_design_st_3_outer .pro_design_st4_prod_outer').each(function(){

            $(this).css('background-image', 'url('+$(this).attr('data-background')+')');
        });

        $('.stream_sec_opt_check_each label').click(function(){
            var checkbox = $(this).closest('.stream_sec_opt_check_each').find('input[type="checkbox"]');
            checkbox.prop('checked') == true ? checkbox.prop('checked', false) : checkbox.prop('checked', true);
        });
    });

    function sendDesignAjax(formData){

        var step = formData.get('step');
        $.ajax({

            url: '/saveProductDesign',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            enctype: 'multipart/form-data',
            success: function (response) {
                
                if(response.success == 1){

                    if(step == '1'){

                        var image = '/prints/'+response.data.dir+'/templates/'+response.data.image_name;
                        var stepElem = $('.pro_design_expand[data-id="pro_design_st3"]');
                        $('.pro_design_expand[data-id="pro_design_st1"] .music_license_button').addClass('complete');
                        stepElem.addClass('enabled');
                        stepElem.find('.pro_design_expansion').removeClass('instant_hide');

                        $('.d_manipulator_elem').attr('src', image).css('display', 'inherit');
                        $('.d_manipulator_elem').draggableTouch('disable', $('.d_manipulator_area'));
                        $('.d_manipulator_elem').draggableTouch('', $('.d_manipulator_area'));

                        var firstPro = $('.pro_m_license_pric_sec[data-id="pro_design_st3"] .pro_design_st3_prod_option_each:first-child');
                        var FPLeft = parseInt(firstPro.attr('data-pos-left'));
                        var FPTop = parseInt(firstPro.attr('data-pos-top'));
                        var FPWidth = parseInt(firstPro.attr('data-width'));
                        var FPHeight = parseInt(firstPro.attr('data-height'));

                        firstPro.find('input[type="radio"]').prop('checked', true);

                        $('.d_manipulator_in').css({
                            'background-image': 'url('+firstPro.find('.st3_prod_option_thumb img').attr('src')+')'
                        });

                        $('.d_manipulator_in .d_manipulator_area').css({
                            'top' : FPTop,
                            'left' : FPLeft,
                            'width' : FPWidth,
                            'height' : FPHeight
                        });

                        $('html, body').animate({scrollTop: stepElem.offset().top - 60}, 'slow');

                        var imagePath = '/prints/'+response.data.dir+'/templates/'+response.data.image_name;
                        var imageGreyPath = '/prints/'+response.data.dir+'/templates/black/'+response.data.image_grey_name;

                        $('.pro_design_expand[data-id="pro_design_st2"]').find('#fixed_color_design_file img').attr('src', imagePath);
                        $('.pro_design_expand[data-id="pro_design_st2"]').find('#flexible_color_design_file img').attr('src', imageGreyPath);

                        //$('.pro_design_expand[data-id="pro_design_st1"] .music_license_button').addClass('complete');
                        //stepElem.addClass('enabled');
                        //stepElem.find('#fixed_color_design_file img').attr('src', imagePath);
                        //stepElem.find('#flexible_color_design_file img').attr('src', imageGreyPath);
                        //stepElem.find('.pro_design_expansion').removeClass('instant_hide');
                        $('#pro_prod_design').val(response.data.id);

                        $('#pro_uploading_in_progress_real,#body-overlay').hide();
                    }else if(step == '4' || step == '5'){

                    	$('.pro_design_st_5_comm_val').text(response.data.commission+' '+response.data.currency);

                        if(step == '4'){
                            $('.pro_design_min_price').text(response.data.min_price+' '+response.data.currency);
                            $('input[name="pro_prod_price"]').val(response.data.recommended_price);
                        }

                    	var stepElem = $('.pro_design_expand[data-id="pro_design_st5"]');
                    	$('.pro_design_expand[data-id="pro_design_st4"] .music_license_button').addClass('complete');
                    	stepElem.addClass('enabled');
                    	stepElem.find('.pro_design_expansion').removeClass('instant_hide');
                    }else if(step == 'edit'){

                        $('.pro_edit_design_st_5_comm_val').text(response.data.commission+' '+response.data.currency);
                        $('.pro_edit_design_min_price').text(response.data.min_price+' '+response.data.currency);
                    }else if(step == '5b'){

                        location.reload();
                    }

                    if(step != '5' && step != '5b' && step != 'edit'){
                        $('html, body').animate({scrollTop: stepElem.offset().top - 60}, 'slow');
                    }
                }else{
                    alert(response.error);
                }
            }
        });
    }

    function getRotationDegrees(obj) {
        var matrix = obj.css("-webkit-transform") ||
        obj.css("-moz-transform")    ||
        obj.css("-ms-transform")     ||
        obj.css("-o-transform")      ||
        obj.css("transform");
        if(matrix !== 'none') {
            var values = matrix.split('(')[1].split(')')[0].split(',');
            var a = values[0];
            var b = values[1];
            var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
        } else { var angle = 0; }

        return (angle < 0) ? angle + 360 : angle;
    }

    function searchHere(elem){
        $('#search_social_music_directory input').keyup();
    }

    function startUploader(container){

        var popElem = $('.pro_pop_upload_each.waiting:not(.instant_hide)').first();
        popElem.addClass('pending').removeClass('failed');
        popElem.find('.item_status i').addClass('fa-spinner').addClass('fa-spin').removeClass('fa-check-circle').removeClass('fa-pause');
        var formContainer = container.closest('form');

        if(popElem.attr('data-type') == 'main'){

            var musicId = $('.music_zip_upload_popup').attr('data-music');

            if(musicId != ''){
                var formData = new FormData();
                formData.append('mu_down_file', formContainer.find('.music-file')[0].files[0]);
                formData.append('mu_down_id', musicId);
                var type = 'main';
            }
        }else if(popElem.attr('data-type') == 'music_info'){

            var formData = new FormData(formContainer[0]);
            formContainer.find('.mu_down_file').each(function(i, field) {
                var fname = $(field).attr('name');
                if(fname) { formData.delete(fname); }
            });
            formData.delete('music-file');
            var type = 'music_info';
        }else if(popElem.attr('data-type') == 'music_file_delete'){

            var elem = container.find('.mu_down_each.mu_to_be_deleted');
            var musicId = $('.music_zip_upload_popup').attr('data-music');
            var deleteData = '';
            $(elem).each(function(){
                deleteData = deleteData + $(this).attr('data-type')+':';
            });
            if(musicId != ''){
                var formData = new FormData();
                formData.append('mu_delete_data', deleteData);
                formData.append('mu_down_id', musicId);
                var type = 'delete_files';
            }
        }else{

            var elem = container.find('.mu_down_each.active[data-type="'+popElem.attr('data-type')+'"]').first();
            var musicId = $('.music_zip_upload_popup').attr('data-music');

            if(musicId != ''){
                var formData = new FormData();
                formData.append('mu_down_file', elem.find('.mu_down_file')[0].files[0]);
                formData.append('mu_down_id', musicId);
                var type = elem.attr('data-type');
            }
        }

        formData.append('type', type);

        $.ajax({

            url: formContainer.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            enctype: 'multipart/form-data',
            success: function (response) {
                
                sessionStorage.removeItem('forceBusy');

                if(type == 'music_info'){

                    $('.music_zip_upload_popup').attr('data-music', response.data.music_id);
                }
                if(type == 'main'){

                    updateAudioFileData(response.data.music_mp3);
                }

                if(sessionStorage.getItem('forceBusy') && sessionStorage.getItem('forceBusy') != ''){

                	var forceBusy = setInterval(function() {
						if(!sessionStorage.getItem('forceBusy')){

							clearInterval(forceBusy);
							postSuccess(response, popElem, container);
						}
					}, 1000);
                }else{

                	postSuccess(response, popElem, container);
                }
            },
            error: function(response){
                
                popElem.removeClass('pending').removeClass('waiting').addClass('failed');
                popElem.find('.item_status i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-exclamation-triangle');

                if($('.pro_pop_upload_each.waiting:not(.instant_hide)').length){
                    startUploader(container);
                }else{
                    $('#close_upload').removeClass('instant_hide');
                }
            }
        });
    }

    function postSuccess(response, popElem, container) {

    	if(response.success){
    	    popElem.removeClass('pending').removeClass('waiting').addClass('complete');
    	    popElem.find('.item_status i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-check-circle');
    	}else{
    	    popElem.removeClass('pending').removeClass('waiting').addClass('failed');
    	    popElem.find('.item_status i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-exclamation-triangle');
    	}

    	if($('.pro_pop_upload_each.waiting:not(.instant_hide)').length){
    	    startUploader(container);
    	}else{
    	    $('#close_upload').removeClass('instant_hide');
    	}
    }
    function prepareUploader(container){

        var eachActive = container.find('.mu_down_each.active');
        if(eachActive.length){
            eachActive.each(function(){

                var thiss = $(this);
                var type = thiss.attr('data-type');
                var item = $('.pro_pop_upload_each[data-type="'+type+'"]');
                var size = thiss.find('.mu_down_file')[0].files[0].size;
                var name = thiss.find('.mu_down_file')[0].files[0].name;
                var sizee = size/(1024*1024);
                item.find('.item_size').text(Math.round(sizee)+' MB');
                item.find('.item_name').text(name);
                item.removeClass('instant_hide');
            });
        }
        var formContainer = container.closest('form');
        var mainFile = formContainer.find('.music-file');
        if(mainFile.length && mainFile.val() != ''){

            var item = $('.pro_pop_upload_each[data-type="main"]');
            var size = mainFile[0].files[0].size;
            var name = mainFile[0].files[0].name;
            var sizee = size/(1024*1024);
            item.find('.item_size').text(Math.round(sizee)+' MB');
            item.find('.item_name').text(name);
            item.removeClass('instant_hide');
        }

        var deleteFile = formContainer.find('.mu_to_be_deleted');
        if(deleteFile.length){

            $('.music_zip_upload_popup .pro_pop_upload_each[data-type="music_file_delete"]').removeClass('instant_hide');
        }
    }