@php $personalChats = isset($adminChat) ? [config('constants.admins')['masteradmin']['user_id']] : $user->personalChatPartners() @endphp
@if(count($personalChats) > 0)

    @foreach($personalChats as $partnerId)
        @php $partner = \App\Models\User::find($partnerId) @endphp
        @if(!$partner)
            @php continue @endphp
        @endif
        @php $partnerPDetails = $commonMethods->getUserRealDetails($partnerId) @endphp
        <div data-form="my-contact-form_{{ $partner->id }}" class="clearfix agent_partner_listing music_btm_list no_sorting">
            <div class="edit_elem_top">
                <div class="m_btm_list_left">
                    <div data-image="{{$partnerPDetails['image']}}" class="music_btm_thumb">
                        <div class="music_bottom_load_thumb">Load Image</div>
                    </div>
                    <ul class="music_btm_img_det">
                        <li>
                            <a class="filter_search_target" href="">
                                {{$partner->name}}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="m_btm_right_icons">
                    <ul>
                        <li>
                            <a title="Chat" class="m_btn_right_icon_each m_btn_chat active" data-id="{{$partner->id}}">
                                <i class="fas fa-comment-dots"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="edit_elem_bottom">
                <div class="each_dash_section instant_hide" data-id="partner_chat_{{$partner->id}}">
                    @include('parts.agent-contact-chat', ['isPersonal' => true])
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="no_results">No records yet</div>
@endif

<script>

    function getChatMessages(element, formData) {

        $.ajax({

            url: '/dashboard/chat',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {

                element.find('.loading_messages').addClass('instant_hide');
                if (response.success) {
                    if (response.data.group.messages.length) {

                        renderChatMessages(element, formData.get('cursor'), response.data.group);
                    } else if (response.data.private.messages.length) {

                        renderChatMessages(element, formData.get('cursor'), response.data.private);
                    } else {

                        if (!formData.get('cursor')) {
                            element.find('.chat_main_body_messages').html('<div class="m-auto text-sm font-semibold text-center text-gray-500">No messages found</div>');
                        }
                    }
                } else {

                    console.log(response.error);
                }
            }
        });
    }

    function renderChatMessages(element, cursor, data) {

        if (cursor) {

            element.find('.chat_main_body_messages').prepend(data.messages);
            renderScrollHeight(element, cursor);
        } else {

            element.find('.chat_main_body_messages').html(data.messages);
            renderScrollHeight(element);
        }

        if (data.members) {

            element.find('.chat_group_members').html(data.members);
        }
    }

    function renderScrollHeight(element, cursor = null) {

        if (cursor) {

            var height = 0;
            element.find('.chat_main_body_messages .chat_each_message').filter(function() {
                if ($(this).attr('data-cursor') < parseInt(cursor)) {

                    height += $(this).outerHeight(true);
                }
            });
            element.find('.chat_main_body_messages').animate({
                scrollTop: height
            }, 0);
        } else {

            setTimeout(function() {
                element.find('.chat_main_body_messages').animate({
                    scrollTop: element.find('.chat_main_body_messages')[0].scrollHeight + 5000
                }, 0);
            }, 100);
        }
    }

    function prepareChatUploader(element) {

        var attachments = element.find('.chat_attachments')[0].files;
        var html = $('#pro_pop_chat_upload_sample').html();

        $(html).appendTo($('.pro_pop_chat_upload .pro_body_in'));
        var item = $('.pro_pop_chat_upload .pro_body_in .pro_pop_chat_upload_each').last();
        item.attr('data-type', 'attachment-initialize');
        item.find('.item_name').text('Initializing');
        item.find('.item_info').removeClass('instant_hide');

        for (var index = 0; index < attachments.length; index++) {
            $(html).appendTo($('.pro_pop_chat_upload .pro_body_in'));
            var item = $('.pro_pop_chat_upload .pro_body_in .pro_pop_chat_upload_each').last();
            item.attr('data-type', 'attachment-upload');
            item.attr('data-id', index);
            var size = attachments[index].size;
            var name = attachments[index].name;
            var sizeem = Math.round(size / (1024 * 1024));
            var sizeek = Math.round(size / (1024));
            item.find('.item_size').text(sizeem > 0 ? sizeem + ' MB' : sizeek + ' KB');
            item.find('.item_name').text(name);
            item.find('.item_file').removeClass('instant_hide');
        }
        $(html).appendTo($('.pro_pop_chat_upload .pro_body_in'));
        var item = $('.pro_pop_chat_upload .pro_body_in .pro_pop_chat_upload_each').last();
        item.attr('data-type', 'attachment-finalize');
        item.find('.item_name').text('Finalizing');
        item.find('.item_info').removeClass('instant_hide');
    }

    function startChatUploader(element, id = null) {

        var popElem = $('.pro_pop_chat_upload .pro_pop_chat_upload_each.waiting').first();
        if (popElem.length) {

            popElem.addClass('pending').removeClass('failed');
            popElem.find('.item_status i').addClass('fa-spinner fa-spin').removeClass('fa-check-circle fa-pause');

            var formData = new FormData();
            var dataType = popElem.attr('data-type');

            if (dataType == 'attachment-finalize') {

                var contactId = element.closest('.agent_partner_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                formData.append('chat', id);
                formData.append('partner', contactId);
                formData.append('message', element.find('.new_message').val());
            } else if (dataType == 'attachment-upload') {

                var attachments = element.find('.chat_attachments')[0].files;
                formData.append('attachment', attachments[popElem.attr('data-id')]);
                formData.append('chat', id);
            }

            formData.append('action', dataType);
            $.ajax({

                url: '/dashboard/create-message',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                enctype: 'multipart/form-data',
                success: function(response) {

                    if (response.success == 1) {
                        popElem.removeClass('pending waiting').addClass('complete');
                        popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-check-circle');
                    } else {
                        popElem.removeClass('pending waiting').addClass('failed');
                        popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-exclamation-triangle');
                    }

                    startChatUploader(element, response.id);
                },
                error: function(response) {
                    popElem.removeClass('pending waiting').addClass('failed');
                    popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-exclamation-triangle');
                }
            });
        } else {
            element.find('.attachment_area .close').trigger('click');
            refreshChat(element);

            element.find('.new_message').val('').change();
            element.find('.attachment_area .close').trigger('click');
            $('.pro_pop_chat_upload .pro_pop_chat_upload_each').remove();
            $('.pro_pop_chat_upload,#body-overlay').hide();
            element.find('.submit_btn').removeClass('disabled');
        }
    }

    function refreshChat(element) {

        if (element.closest('.music_btm_list').hasClass('agent_contact_listing')) {

            var id = element.closest('.agent_contact_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
            $type = 'contact-chat';
        } else if (element.closest('.music_btm_list').hasClass('agent_partner_listing')) {

            var id = element.closest('.agent_partner_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
            $type = 'partner-chat';
        }
        var formData = new FormData();
        formData.append('type', $type);
        formData.append('data', id);

        getChatMessages(element, formData);
    }

    $('document').ready(function(){

        $('.chat_main_body_attach').click(function(e){

            e.preventDefault();
            var parent = $(this).closest('.chat_outer');
            parent.find('.chat_attachments').trigger('click');
        });

        $('.attachment_area .close').click(function(){

            var parent = $(this).closest('.chat_outer');
            parent.find('.chat_attachments').val('');
            parent.find('.attachment_area .each_attach').remove();
            parent.find('.chat_main_body_foot').removeClass('attachment');
        });

        $('.chat_outer .submit_btn').click(function(){

            var thiss = $(this);
            var parent = thiss.closest('.chat_outer');
            var attachments = parent.find('.chat_attachments');
            var message = parent.find('.new_message');

            if($(this).closest('.music_btm_list').hasClass('agent_contact_listing')){

                var id = parent.closest('.agent_contact_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                $type = 'contact';
            }else if($(this).closest('.music_btm_list').hasClass('agent_partner_listing')){

                var id = parent.closest('.agent_partner_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                $type = 'partner';
            }

            if(message.val() != '' || attachments.val() != ''){

                thiss.addClass('disabled');

                if(attachments.val() != ''){

                    prepareChatUploader(parent);
                    $('.pro_pop_chat_upload,#body-overlay').show();
                    startChatUploader(parent);
                }else{

                    var formData = new FormData();
                    formData.append($type, id);
                    formData.append('message', message.val());
                    formData.append('action', 'send-message');

                    $.ajax({

                        url: '/dashboard/create-message',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function (response) {

                            thiss.removeClass('disabled');

                            if(response.success){
                                parent.find('.attachment_area .close').trigger('click');
                                refreshChat(parent);
                            }else{
                                console.log(response.error);
                            }

                            parent.find('.new_message').val('').change();
                        }
                    });
                }
            }
        });

        $('.chat_attachments').change(function(){

            var parent = $(this).closest('.chat_outer');
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
                            parent.find('.attachment_area').append('<div class="each_attach file"><div class="up">File</div><div class="down"><i class="fa fa-file-o"></i></div></div>');
                            parent.find('.chat_main_body_foot').addClass('attachment');
                            parent.find('.new_message').focus();
                        }
                    }
                }
            }
        });

        $('.m_btn_chat').click(function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var mainP = $(this).closest('.music_btm_list');
            if ($(this).hasClass('m_btm_edit')) {
                mainP.find('.each_dash_section:not(.each_dash_section[data-id="contact_edit_' + id + '"])').addClass('instant_hide');
                mainP.find('.each_dash_section[data-id="contact_edit_' + id + '"]').toggleClass('instant_hide');
            } else if ($(this).hasClass('m_btn_files')) {
                mainP.find('.each_dash_section:not(.each_dash_section[data-id="contact_agreement_' + id + '"])').addClass('instant_hide');
                mainP.find('.each_dash_section[data-id="contact_agreement_' + id + '"]').toggleClass('instant_hide');
            } else if ($(this).hasClass('m_btn_calendar')) {
                mainP.find('.each_dash_section:not(.each_dash_section[data-id="contact_calendar_' + id + '"])').addClass('instant_hide');
                // mainP.find('.each_dash_section[data-id="contact_calendar_' + id + '"]').toggleClass('instant_hide');
                if (mainP.find('.each_dash_section[data-id="contact_calendar_' + id + '"]').hasClass('instant_hide')) {
                    getContactCalendar(mainP.find('.each_dash_section[data-id="contact_calendar_' + id + '"]'), id);
                } else {
                    mainP.find('.each_dash_section[data-id="contact_calendar_' + id + '"]').addClass('instant_hide');
                }
            } else if ($(this).hasClass('m_btn_chat')) {
                if (mainP.hasClass('agent_contact_listing')) {

                    var elem = $('.each_dash_section[data-id="contact_chat_' + id + '"]');
                    var parent = $(this).closest('.agent_contact_listing');
                    var type = 'contact-chat';
                } else if (mainP.hasClass('agent_partner_listing')) {

                    var elem = $('.each_dash_section[data-id="partner_chat_' + id + '"]');
                    var parent = $(this).closest('.agent_partner_listing');
                    var type = 'partner-chat';
                }

                parent.find('.each_dash_section').not(elem).addClass('instant_hide');
                elem.toggleClass('instant_hide');

                if (!elem.hasClass('instant_hide')) {

                    var formData = new FormData();
                    formData.append('type', type);
                    formData.append('data', id);

                    getChatMessages(elem.find('.chat_outer'), formData);
                }
            }
        });
    });
</script>
