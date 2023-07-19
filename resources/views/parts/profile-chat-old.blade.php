
@if(Session::has('pagecontentopener'))
    <script>
        var ses = "{{Session::get('pagecontentopener')}}";
        sessionStorage.setItem('pagecontentopener', ses);
    </script>
@endif

<script>

    $('document').ready(function(){

        $('body').delegate('.chat_member_add', 'click', function(e){
            var group = $(this).closest('.chat_each_group').attr('data-group');
            $('#add_chat_group_member_popup').attr('data-group', group);
            $('#add_chat_group_member_popup,#body-overlay').show();
            e.stopPropagation();
        });
        $('body').delegate('.chat_user_link', 'click', function(e){
            e.stopPropagation();
        });

        $('.agent_que_action_btn').click(function(){

            var thiss = $(this);
            if(thiss.attr('data-id') == 'add_question_btn'){

                var element = $('#question_sample');
                thiss.closest('form').find('.element_container').append(element.html());
                thiss.closest('form').find('.element_container .port_each_field:last-child').addClass('port_field_checked');
            }
        });

        $('.save_questionnaire_outer').click(function(){

            $(this).closest('form').submit();
        });

        $('.agent_que_import').change(function(){

            var from = $(this).val();
            var to = $('#profile_tab_14 .agent_questionnaire_outer .orders_bottom_arrow.opened').first().closest('.my_sub_sec').attr('data-skill');
            if(from != ''){

                if(confirm('This action will append questions from '+ from +' into ' + to)){

                    var fromElem = $('.agent_questionnaire_outer .my_sub_sec[data-skill="'+from+'"]');
                    var toElem = $('.agent_questionnaire_outer .my_sub_sec[data-skill="'+to+'"]');
                    if(fromElem.length && toElem.length){

                        var elements = fromElem.find('.profile_orders_slide_win .port_each_field.port_field_checked');
                        if(elements.length){
                            elements.each(function(){
                                var clone = $(this)[0].outerHTML;
                                toElem.find('.profile_orders_slide_win .element_container').append(clone);
                            });
                        }
                    }
                }
            }
        });

        $('select[name="pro_contact_already_user"]').change(function(){

            if($(this).val() == '1'){

                $('input[name="pro_contact_already_user_email"]').prop('disabled', false).focus();
            }else{

                $('input[name="pro_contact_already_user_email"]').prop('disabled', true);
            }
        });

        $('.get_agent:not(.is_current_agent):not(.is_pending):not(.fully_booked)').click(function(){

            var id = $(this).attr('data-id');
            var newAgentName = $(this).closest('.agents_listing').find('.filter_search_target').text();
            var currentAgent = $(this).closest('.btn_list_outer').find('.get_agent.is_current_agent');

            $('#get_agent_popup .stage_two,#get_agent_popup .current_agent').addClass('instant_hide');
            $('#get_agent_popup .stage_one').removeClass('instant_hide');

            $('#get_agent_popup').attr('data-id', id);
            $('#get_agent_popup .new_agent_name').text(newAgentName);
            if(currentAgent.length){
                var currentAgentName = currentAgent.closest('.agents_listing').find('.filter_search_target').text();
            }else{
                var currentAgentName = '';
            }
            if(currentAgentName != ''){
                $('#get_agent_popup .current_agent .current_agent_name').text(currentAgentName);
                $('#get_agent_popup .current_agent').removeClass('instant_hide');
            }

            $('#get_agent_popup,#body-overlay').show();
        });

        $('#proceed_get_agent').click(function(){

            var id = $(this).closest('#get_agent_popup').attr('data-id');
            if(id != ''){

                var formData = new FormData();
                formData.append('id', id);

                $.ajax({

                    url: '/agent-contact-request/send',
                    type: 'POST',
                    data: formData,
                    contentType:false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {

                        if(response.success){

                            $('.agents_listing .get_agent[data-id="'+id+'"]').addClass('is_pending').text('Request sent');
                            $('#get_agent_popup,#body-overlay').hide();
                        }else{
                            alert(response.error);
                        }
                    }
                });
            }
        });

        $('#whatsapp_messenger').click(function(){

            var name = $('.chat_head_name').text().trim();
            var activeChat = $('.chat_each_user.active');
            if(activeChat.length){

                if(activeChat.hasClass('.chat_each_group')){
                    var alertMsg = 'Do you want to message on whatsapp?';
                }else{
                    var alertMsg = 'Do you want to message '+name+' on whatsapp?';
                }
                if(confirm(alertMsg)){

                    window.location.href = 'https://api.whatsapp.com/send/?phone=&text=Your+agent+has+an+important+message+for+you+in+your+1platform+Network+chat%0D%0Ahttps%3A%2F%2Fwww.1platform.tv%2Flogin';
                }
            }
        });

        $('#information_form').click(function(){

        	var group = $('.chat_each_user.chat_each_group.active');
        	if(group.length){
        		$.ajax({
        		    url: "/informationFinder",
        		    dataType: "json",
        		    type: 'post',
        		    data: {'find_type': 'contact_code', 'find': group.attr('data-group'), 'identity_type': 'user', 'identity': window.currentUserId},
        		    success: function(response) {
        		        if(response.success == 1){
        		            window.open(response.data.url, '_blank');
        		        }else{
        		            alert(response.error);
        		        }
        		    }
        		});
        	}
        });

        $('.chat_main_body .chat_main_body_messages').on('scroll', function() {
            if($(this).get(0).scrollTop == 0 && $('.chat_main_body .chat_main_body_messages .chat_each_message').length > 0){
                $('#loading_messages').removeClass('instant_hide');
                var firstMessage = $('.chat_main_body_messages .chat_each_message').first();
                var formData = new FormData();
                formData.append('action', 'previous-chat');
                formData.append('cursor', firstMessage.attr('data-cursor'));
                refreshChatBox('previous-chat', formData);
            }
        });

    });

	function startChatUploader(id = null){

        var popElem = $('.pro_pop_chat_upload .pro_pop_chat_upload_each.waiting').first();
        if(popElem.length){

            popElem.addClass('pending').removeClass('failed');
            popElem.find('.item_status i').addClass('fa-spinner fa-spin').removeClass('fa-check-circle fa-pause');

            var formData = new FormData();

            if(popElem.attr('data-type') == 'initialize' || popElem.attr('data-type') == 'finalize'){

                var elem = $('.chat_each_user.active:first');
                if(elem.hasClass('chat_each_group')){
                    var groupId = elem.attr('data-group');
                    formData.append('group', groupId);
                }else{
                    var partnerId = elem.attr('data-partner');
                    formData.append('recipient', partnerId);
                }
                formData.append('message', $('#new_message').val());
                formData.append('type', popElem.attr('data-type'));
                formData.append('chat', id);
            }else if(popElem.attr('data-type') == 'file'){

                var attachments = document.getElementById('chat_attachments').files;
                formData.append('attachment', attachments[popElem.attr('data-id')]);
                formData.append('chat', id);
            }

            $.ajax({

                url: '/bispoke-license/message/send',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                enctype: 'multipart/form-data',
                success: function (response){

                    if(response.success == 1){
                        popElem.removeClass('pending waiting').addClass('complete');
                        popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-check-circle');
                    }else{
                        popElem.removeClass('pending waiting').addClass('failed');
                        popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-exclamation-triangle');
                    }

                    startChatUploader(response.id);
                },
                error: function(response){

                    popElem.removeClass('pending waiting').addClass('failed');
                    popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-exclamation-triangle');
                }
            });
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
            $('#new_message').val('').change();
            $('.attachment_area .close').trigger('click');
            $('.pro_pop_chat_upload .pro_pop_chat_upload_each').remove();
            $('.pro_pop_chat_upload,#body-overlay').hide();
            $('#submit_btn').removeClass('disabled');
        }
    }

    function prepareChatUploader(){

        var attachments = document.getElementById('chat_attachments').files;
        var html = $('#pro_pop_chat_upload_sample').html();

        $(html).appendTo($('.pro_pop_chat_upload .pro_body_in'));
        var item = $('.pro_pop_chat_upload .pro_body_in .pro_pop_chat_upload_each').last();
        item.attr('data-type', 'initialize');
        item.find('.item_name').text('Initializing');
        item.find('.item_info').removeClass('instant_hide');

        for (var index = 0; index < attachments.length; index++) {
            $(html).appendTo($('.pro_pop_chat_upload .pro_body_in'));
            var item = $('.pro_pop_chat_upload .pro_body_in .pro_pop_chat_upload_each').last();
            item.attr('data-type', 'file');
            item.attr('data-id', index);
            var size = attachments[index].size;
            var name = attachments[index].name;
            var sizeem = Math.round(size/(1024*1024));
            var sizeek = Math.round(size/(1024));
            item.find('.item_size').text(sizeem > 0 ? sizeem+' MB' : sizeek+' KB');
            item.find('.item_name').text(name);
            item.find('.item_file').removeClass('instant_hide');
        }
        $(html).appendTo($('.pro_pop_chat_upload .pro_body_in'));
        var item = $('.pro_pop_chat_upload .pro_body_in .pro_pop_chat_upload_each').last();
        item.attr('data-type', 'finalize');
        item.find('.item_name').text('Finalizing');
        item.find('.item_info').removeClass('instant_hide');
    }
</script>
<?php

$display = 'display: block;';
if($page != 'chat')
    $display = 'display: none;';
?>
@php $admins = config('constants.admins') @endphp
<div id="profile_tab_14" class="pro_pg_tb_det" style="{{$display}}">
    <div class="pro_pg_tb_det_inner">
        <div id="chat_box_section" class="sub_cat_data {{$subTab == '' || $subTab == 'box' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Network Chat</div>
            </div>
            @if(!isset($setupWizard))
            <div class="pro_music_search pro_music_info no_border">
                <div class="pro_inp_list_outer">
                    <div class="pro_explainer_outer">
                        <div class="pro_explainer_inner">
                            <div data-explainer-file="{{base64_encode('1PQ547_fjpiWQo4HzleEfXZcrnqPyJi3L')}}" data-explainer-title="Chat feature explained" data-explainer-description="Learn the benefits of using chat feature" class="pro_explainer_each">
                                <div class="pro_explainer_anim">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                                <div class="pro_explainer_body">
                                    <div class="pro_explainer_title">
                                        Chat feature explained
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro_explainer_video instant_hide">
                            <div class="pro_explainer_video_contain">
                                <div id="jwp_chat"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat_switch_outer">
                <div class="chat_switch_txt">Turn Chat ON/OFF</div>
                <label class="smart_switch">
                  <input type="checkbox" {{$user->chat_switch == 1 ? 'checked' : ''}}>
                  <span class="slider"></span>
                </label>
            </div>
            @endif
            <div class="chat_outer {{$user->chat_switch == 1 ? '' : 'disabled'}}">
                <div class="chat_left">
                    @if(!isset($setupWizard))
                    <div class="chat_search_outer">
                        <div class="chat_search_users">
                            <input id="search_senders" type="text" placeholder="Search users by name" />
                            <input class="dummy_field" />
                            <i class="fa fa-search"></i>
                        </div>
                    </div>

                    @if($user->id != $admins['masteradmin']['user_id'] && $user->id != $admins['1platformagent']['user_id'])
                    <div class="chat_admins_outer">
                        @if(!$user->expert && $user->apply_expert != '2')
                            @php $personalGroup = $user->personalGroup() @endphp
                            @if($personalGroup)
                                @php $agentPDetails = $commonMethods->getUserRealDetails($personalGroup->agent->id) @endphp
                                <div data-group="{{$personalGroup->id}}" class="chat_each_admin chat_each_user chat_each_group chat_personal_group">
                                    <div class="inner">
                                        <div data-id="{{$personalGroup->agent->id}}" class="chat_user_pic">
                                            <img src="{{$agentPDetails['image']}}">
                                            <div class="chat_user_status chat_group_member_status offline">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                        </div>
                                        <div class="chat_user_det">
                                            <div class="chat_user_name">{{$personalGroup->agent->name}}</div>
                                            @php $realContact = \App\Models\AgentContact::where(['contact_id' => $personalGroup->contact->id, 'agent_id' => $personalGroup->agent->id])->first() @endphp
                                            @if($realContact)
                                            <div class="chat_user_link">
                                                <a target="_blank" href="{{route('agent.contact.details',['code' => $realContact->code])}}"><i class="fa fa-file-text-o"></i></a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    @endif
                    @endif
                    <div class="chat_users_outer"></div>
                </div>
                <div class="chat_right">
                    @if(!isset($setupWizard))
                    <div class="chat_main_header">
                        <div class="chat_head_name hide_on_mobile"></div>
                        <div class="chat_main_header_action">
                            <div id="filter_none" class="header_each_action active">
                                <i class="fa fa-comment-o"></i>
                                <span>Chat</span>
                            </div>
                            @if(!isset($setupWizard))
                            <div id="filter_agreements" class="header_each_action">
                                <i class="fa fa-file-pdf-o"></i>
                                <span>Agreements</span>
                            </div>
                            <div id="information_form" class="header_each_action">
                                <i class="fa fa-file-text-o"></i>
                                <span>Form</span>
                            </div>
                            <div id="whatsapp_messenger" class="header_each_action hide_on_desktop">
                                <i class="fa fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="chat_main_body">
                        <div class="attach_expand_wrapper instant_hide">
                            <div class="attach_wrap_in">
                                <div class="close action">
                                    <i class="fa fa-close"></i>
                                </div>
                                <a download href="javascript:void(0)" class="download action">
                                    <i class="fa fa-download"></i>
                                </a>
                                <img src="" />
                            </div>
                            <div class="overlay"></div>
                        </div>
                        @if(!isset($setupWizard))
                        <div id="chat_head_name_res" class="chat_main_header_action hide_on_desktop">
                            <div class="chat_head_name"></div>
                        </div>
                        @endif
                        <img id="loading_messages" class="instant_hide" src="{{asset('images/loading.gif')}}">
                        <div class="chat_main_body_messages"></div>
                        <div class="chat_main_body_foot">
                            <div class="attachment_area">
                                <div class="close">
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <textarea id="new_message" placeholder="Type your message here"></textarea>
                            <div class="chat_main_foot_actions">
                                <div class="chat_main_body_attach">
                                    <i class="fa fa-paperclip"></i>
                                </div>
                                <div class="foot_action_ext_btns">
                                    @if(!isset($setupWizard))
                                    <div id="add_agreement_btn" class="foot_action_btn"><i class="fa fa-plus"></i> License</div>
                                    <div id="add_product_btn" class="foot_action_btn"><i class="fa fa-plus"></i> Product</div>
                                    <div id="proffer_project_btn" class="foot_action_btn"><i class="fa fa-plus"></i> Project</div>
                                    @endif
                                    <div id="refresh_messages" class="foot_action_btn"><i class="fa fa-refresh"></i> Refresh Chat</div>
                                </div>
                                <div id="submit_btn" class="foot_action_btn"><i class="fa fa-paper-plane"></i> Send</div>
                            </div>
                            <input class="instant_hide" type="file" id="chat_attachments" name="attachFiles[]" multiple />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($user->expert && $user->apply_expert == 2)
        <div id="contacts_section" class="sub_cat_data {{$subTab == 'contacts' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Manage Network Contacts</div>
            </div>
            <div class="pro_music_search pro_music_info no_border">
                <div class="pro_note">
                    <ul>
                        <li>Create a new contact in your network</li>
                        <li>Enter the name, email, commission (if any) and terms (if any). The contact person will be offered to accept or decline this agreement. If its accepted the contact person becomes a 1platform user and can login with your given credentials and can connect a bank account and start selling or providing any services</li>
                        <li>You will get a commission (if you have provided one) for each sale your contact person will receive through you</li>
                        <li>After you have created a new contact, you can EDIT and set up an account</li>
                        <li>After you have set up your contact's account, commission amount and terms, go to edit contact, enter the email and submit. This will send out an email to your contact person and will ask for the approval</li>
                    </ul>
                </div>
            </div>
            @if(Session::has('seller_stripe_prompt'))
                @include('parts.pro-stripeless-content', ['page' => 'add agent contacts'])
            @else

                <form id="add_agent_contact_form" action="{{route('agent.contact.create')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="pro_stream_input_outer">
                        <div class="pro_stream_input_each">
                            <input placeholder="Name" type="text" class="pro_stream_input" name="pro_contact_name" />
                        </div>
                        <div class="pro_stream_input_row">
                            <div class="pro_stream_input_each">
                                <div class="stream_sec_opt_outer">
                                    <select name="pro_contact_already_user">
                                        <option value="">Is this person already registered at 1Platform?</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pro_stream_input_each">
                                <input disabled="" placeholder="Email of user registered at 1Platform" type="text" class="pro_stream_input" name="pro_contact_already_user_email">
                            </div>
                        </div>
                        <div class="pro_stream_input_each">
                            <input placeholder="Your Commission (in percentage)" type="number" class="pro_stream_input" name="pro_contact_commission" />
                        </div>
                        <div class="pro_stream_input_each">
                            <textarea placeholder="Write your terms (if any)" type="text" class="pro_contact_textarea" name="pro_contact_terms"></textarea>
                        </div><br><br>
                        <div class="pro_m_chech_outer">
                            <input class="upload_now" type="button" value="Submit">
                        </div>
                    </div>
                </form>

                <div class="pro_btm_listing_outer">
                    <label>My Network Contacts
                        @if(count($user->contacts) > 0)
                            {{'('.count($user->contacts).')'}}
                        @endif
                    </label>
                    <div class="m_btm_filters_outer">
                        <div class="m_btm_filter_search">
                            <input data-target="agent_contact_listing" placeholder="Search your contacts by name" type="text" class="m_btm_filter_search_field" />
                        </div>
                        <div class="m_btm_filter_drop">
                            <select data-target="agent_contact_listing" class="m_btm_filter_dropdown">
                                <option value="">Filter contacts</option>
                                <option value="all">All</option>
                                <option value="All Approved">All Approved</option>
                                <option value="All Unapproved">All Upapproved</option>
                            </select>
                        </div>
                    </div>
                    <div class="btn_list_outer">
                    @if(count($user->contacts) > 0)
                        @foreach($user->contacts as $contact)
                            @if(!$contact->contactUser)
                                @php continue @endphp
                            @endif
                            @php $contactPDetails = $commonMethods->getUserRealDetails($contact->contactUser->id) @endphp
                            <div data-approved="{{$contact->approved ? '1' : ''}}" data-form="my-contact-form_{{ $contact->id }}" class="agent_contact_listing music_btm_list no_sorting clearfix">
                                <div class="edit_elem_top">
                                    <div class="m_btm_list_left">
                                        <div data-image="{{$contactPDetails['image']}}" class="music_btm_thumb">
                                            <div class="music_bottom_load_thumb">Load Image</div>
                                        </div>
                                        <ul class="music_btm_img_det">
                                            <li>
                                                <a class="filter_search_target" href="">
                                                    {{$contact->contactUser ? $contact->contactUser->name : $contact->name}}
                                                </a>
                                            </li>
                                            <li>
                                                <p>
                                                    <br>
                                                    {{$contact->commission}}% - {{$contact->approved ? 'Approved' : ($contact->agreement_sign == 'sent' ? 'Sent to Sign' : 'Not Approved')}}
                                                    {{$contact->review ? ' - '.'Sent to Review' : ''}}
                                                    {{$contactPDetails['city'] != '' ? ' - '.$contactPDetails['city'] : ''}}
                                                    {{$contactPDetails['skills'] != '' ? ' - '.$contactPDetails['skills'] : ''}}
                                                    <br>
                                                    {{$contact->code}}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="m_btm_right_icons">
                                        <ul>
                                            <li>
                                                <a title="Edit" data-id="{{$contact->id}}" class="m_btn_right_icon_each m_btm_edit active">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </li>
                                            <li>
                                                @if($contact->contactUser->username)
                                                <a target="_blank" title="Website" href="{{route('user.home',['params' => $contact->contactUser->username])}}" class="m_btn_right_icon_each m_btm_website active">
                                                    <i class="fa fa-globe"></i>
                                                </a>
                                                @else
                                                <a title="Website" href="javascript:void(0)" class="m_btn_right_icon_each m_btm_website">
                                                    <i class="fa fa-globe"></i>
                                                </a>
                                                @endif
                                            </li>
                                            <li>
                                                @if(!$contact->is_already_user || ($contact->is_already_user && $contact->approved))
                                                <a title="Switch account" data-id="{{route('agent.contact.switch.account',['code' => $contact->code])}}" class="m_btn_right_icon_each m_btm_switch_account active">
                                                    <i class="fa fa-cog"></i>
                                                </a>
                                                @else
                                                <a title="Switch account" data-id="" class="m_btn_right_icon_each m_btm_view">
                                                    <i class="fa fa-cog"></i>
                                                </a>
                                                @endif
                                            </li>
                                            <li>
                                                <a data-open="blank" title="View Submission" data-id="{{route('agent.contact.details',['code' => $contact->code])}}" class="m_btn_right_icon_each m_btm_view active">
                                                    <i class="fa fa-file-text-o"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{$contact->id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="edit_elem_bottom">
                                    @include('parts.agent-contact-edit-template-old', ['contact' => $contact])
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="no_results">No records yet</div>
                    @endif
                    </div>
                </div>

                <div class="pro_btm_listing_outer">
                    <label>Network Contact Requests</label>
                    <div class="m_btm_filters_outer">
                        <div class="m_btm_filter_search">
                            <input data-target="agent_contact_request_listing" placeholder="Search users by name" type="text" class="m_btm_filter_search_field" />
                        </div>
                    </div>
                    <div class="btn_list_outer">
                    @if(count($user->contactRequests) > 0)
                        @foreach($user->contactRequests as $contactRequest)
                            @php $contactPDetails = $commonMethods->getUserRealDetails($contactRequest->contactUser->id) @endphp
                            <div class="agent_contact_request_listing music_btm_list no_sorting clearfix">
                                <div class="edit_elem_top">
                                    <div class="m_btm_list_left">
                                        <div data-image="{{$contactPDetails['image']}}" class="music_btm_thumb">
                                            <div class="music_bottom_load_thumb">Load Image</div>
                                        </div>
                                        <ul class="music_btm_img_det">
                                            <li>
                                                <a class="filter_search_target" href="">
                                                    {{$contactRequest->contactUser->name}}
                                                </a>
                                            </li>
                                            <li>
                                                <p>
                                                    {{$contactRequest->contactUser->email}}
                                                    {{date('d/m/Y h:i A', strtotime($contactRequest->created_at))}}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="m_btm_right_icons">
                                        <ul>
                                            <li>
                                                @if($contactRequest->contactUser->username)
                                                <a target="_blank" title="Website" href="{{route('user.home',['params' => $contactRequest->contactUser->username])}}" class="m_btn_right_icon_each m_btm_website active">
                                                    <i class="fa fa-globe"></i>
                                                </a>
                                                @else
                                                <a title="Website" href="javascript:void(0)" class="m_btn_right_icon_each m_btm_website">
                                                    <i class="fa fa-globe"></i>
                                                </a>
                                                @endif
                                            </li>
                                            <li>
                                                <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{$contactRequest->id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="no_results">No records yet</div>
                    @endif
                    </div>
                </div>
            @endif
        </div>
        <div id="questionnaire_section" class="sub_cat_data {{$subTab == 'questionnaires' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Manage Questionnaires</div>
            </div>
            <div class="pro_music_search pro_music_info no_border">
                <div class="pro_note">
                    <ul>
                        <li>Here you can manage your questionnaire for each skill listed below</li>
                        <li>You can add/remove questions from a questionnaire</li>
                        <li>The questionnaire can be attached to a contact in edit contact section. The contact person will get a link to that questionnaire in email, can fill it up and when the contact submits, you will get notified</li>
                        <li>Questionnaire submission by a contact can be seen individually or a spreadsheet containing all of them can be downloaded</li>
                    </ul>
                </div>
            </div>
            <div class="agent_questionnaire_outer">

                @php $skills = \App\Models\Skill::all() @endphp

                @foreach($skills as $skill)
                    @include('parts.agent-questionnaire', ['skill' => $skill->value])
                @endforeach
            </div>
        </div>
        @endif


        @if(!$user->expert && $user->apply_expert != 2)
        <div id="get_agent_section" class="sub_cat_data {{$subTab == 'get-agent' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Get an Agent</div>
            </div>
            <div class="pro_music_search pro_music_info no_border">
                <div class="pro_inp_list_outer">
                    <div class="pro_explainer_outer">
                        <div class="pro_explainer_inner">
                            <div data-explainer-file="{{base64_encode('1c4BpeAGc83Y5_B5y8l2WgGNmz5Ton0Kh')}}" data-explainer-title="What an agent can do?" data-explainer-description="Connect with professional agent" class="pro_explainer_each">
                                <div class="pro_explainer_anim">
                                    <i class="fa fa-caret-right"></i>
                                </div>
                                <div class="pro_explainer_body">
                                    <div class="pro_explainer_title">
                                        What an agent can do?
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro_explainer_video instant_hide">
                            <div class="pro_explainer_video_contain">
                                <div id="jwp_get_agent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="get_agent_outer">

                <div class="pro_btm_listing_outer">
                    <label>1Platform Agents ({{count($agents)}})</label>
                    <!--<div class="m_btm_filters_outer">
                        <div class="m_btm_filter_search">
                            <input data-target="agents_listing" placeholder="Search agents by name" type="text" class="m_btm_filter_search_field" />
                        </div>
                    </div>!-->
                    <div class="">
                    @if(count($agents) > 0)
                        @foreach($agents as $agent)
                            @php $agentPDetails = $commonMethods->getUserRealDetails($agent->id) @endphp
                            @php $agentContacts = \App\Models\AgentContact::where('agent_id', $agent->id)->get() @endphp
                            @php $isAgent = \App\Models\AgentContact::where(['agent_id' => $agent->id, 'contact_id' => $user->id, 'approved' => 1])->first() @endphp
                            @php $requestSent = \App\Models\AgentContactRequest::where(['agent_user_id' => $agent->id, 'contact_user_id' => $user->id])->first() @endphp
                            <div class="agents_listing music_btm_list no_sorting clearfix">
                                <div class="edit_elem_top">
                                    <div class="m_btm_list_left">
                                        <div data-image="{{$agentPDetails['image']}}" class="music_btm_thumb">
                                            <div class="music_bottom_load_thumb">Load Image</div>
                                        </div>
                                        <ul class="music_btm_img_det">
                                            <li>
                                                <a class="filter_search_target" href="javascript:void(0)">
                                                    {{$agent->name}}
                                                </a>
                                            </li>
                                            <li><br>
                                                <p>
                                                    <i class="fa fa-users"></i>
                                                        @if($agent->id == 727)
                                                            {{number_format(350 + count($agentContacts))}}
                                                        @elseif($agent->id == 722)
                                                            {{number_format(175 + count($agentContacts))}}
                                                        @else
                                                            {{count($agentContacts)}}
                                                        @endif
                                                        network contacts
                                                    @if($agentPDetails['city'] != '')
                                                    &nbsp;&nbsp;<i style="font-size: 17px;" class="fa fa-map-marker"></i> {{$agentPDetails['city']}}
                                                    @endif
                                                    @if($isAgent)
                                                    <div class="get_agent is_current_agent">Your agent</div>
                                                    @elseif($requestSent)
                                                    <div class="get_agent is_pending">Request sent</div>
                                                    @else
                                                    <div data-id="{{$agent->id}}" class="get_agent">Get this agent</div>
                                                    @endif
                                                </p>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="m_btm_right_icons">
                                        <ul>
                                            <li>
                                                <a target="_blank" title="Website" href="{{route('user.home',['params' => $agent->username])}}" class="m_btn_right_icon_each m_btm_website active">
                                                    <i class="fa fa-globe"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="agents_listing music_btm_list no_sorting clearfix">
                            <div class="m_btm_list_left">
                                <div data-image="" class="music_btm_thumb">
                                    <div class="music_bottom_load_thumb">Load Image</div>
                                </div>
                                <ul class="music_btm_img_det">
                                    <li>
                                        <a class="filter_search_target" href="javascript:void(0)">Bradley Kendal</a>
                                    </li>
                                    <li><br>
                                        <p>
                                            <i class="fa fa-users"></i> 500 network contacts
                                            &nbsp;&nbsp;<i style="font-size: 17px;" class="fa fa-map-marker"></i> Birmingham
                                            <div data-id="" class="get_agent fully_booked">Fully booked</div>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="agents_listing music_btm_list no_sorting clearfix">
                            <div class="m_btm_list_left">
                                <div data-image="" class="music_btm_thumb">
                                    <div class="music_bottom_load_thumb">Load Image</div>
                                </div>
                                <ul class="music_btm_img_det">
                                    <li>
                                        <a class="filter_search_target" href="javascript:void(0)">The billingham Agency</a>
                                    </li>
                                    <li><br>
                                        <p>
                                            <i class="fa fa-users"></i> 450 network contacts
                                            &nbsp;&nbsp;<i style="font-size: 17px;" class="fa fa-map-marker"></i> Liverpool
                                            <div data-id="" class="get_agent fully_booked">Fully booked</div>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="agents_listing music_btm_list no_sorting clearfix">
                            <div class="m_btm_list_left">
                                <div data-image="" class="music_btm_thumb">
                                    <div class="music_bottom_load_thumb">Load Image</div>
                                </div>
                                <ul class="music_btm_img_det">
                                    <li>
                                        <a class="filter_search_target" href="javascript:void(0)">New York Agency</a>
                                    </li>
                                    <li><br>
                                        <p>
                                            <i class="fa fa-users"></i> 800 network contacts
                                            &nbsp;&nbsp;<i style="font-size: 17px;" class="fa fa-map-marker"></i> New York City
                                            <div data-id="" class="get_agent fully_booked">Fully booked</div>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="agents_listing music_btm_list no_sorting clearfix">
                            <div class="m_btm_list_left">
                                <div data-image="" class="music_btm_thumb">
                                    <div class="music_bottom_load_thumb">Load Image</div>
                                </div>
                                <ul class="music_btm_img_det">
                                    <li>
                                        <a class="filter_search_target" href="javascript:void(0)">Connections</a>
                                    </li>
                                    <li><br>
                                        <p>
                                            <i class="fa fa-users"></i> 300 network contacts
                                            &nbsp;&nbsp;<i style="font-size: 17px;" class="fa fa-map-marker"></i> Bristol
                                            <div data-id="" class="get_agent fully_booked">Fully booked</div>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="agents_listing music_btm_list no_sorting clearfix">
                            <div class="m_btm_list_left">
                                <div data-image="" class="music_btm_thumb">
                                    <div class="music_bottom_load_thumb">Load Image</div>
                                </div>
                                <ul class="music_btm_img_det">
                                    <li>
                                        <a class="filter_search_target" href="javascript:void(0)">Taxi agency</a>
                                    </li>
                                    <li><br>
                                        <p>
                                            <i class="fa fa-users"></i> 250 network contacts
                                            &nbsp;&nbsp;<i style="font-size: 17px;" class="fa fa-map-marker"></i> Cambridge
                                            <div data-id="" class="get_agent fully_booked">Fully booked</div>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                    <div class="no_results">No records yet</div>
                    @endif
                    </div>
                </div>

            </div>
        </div>
        @endif
    </div>
</div>

<link rel="stylesheet" href="{{asset('css/profile.chat-old.css?v=1.5')}}">
