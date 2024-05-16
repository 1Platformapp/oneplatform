<div class="chat_outer border-none {{$user->chat_switch == 1 ? '' : 'disabled'}}">
    <div class="flex flex-row mt-5 chat_group_members"></div>
    <div class="chat_right border-none flex-1 !important">
        <div class="chat_main_body p-0">
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
            <div class="chat_head_name_res chat_main_header_action md:hidden">
                <div class="chat_head_name"></div>
            </div>
            <img class="loading_messages instant_hide" src="{{asset('images/loading.gif')}}">
            <div class="chat_main_body_messages mt-12"></div>
            <div class="chat_main_body_foot">
                <div class="attachment_area">
                    <div class="close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <textarea class="new_message" placeholder="Type your message here"></textarea>
                <div class="chat_main_foot_actions">
                    <div class="chat_main_body_attach">
                        <i class="fa fa-paperclip"></i>
                    </div>
                    @if(!isset($isPersonal))
                    <div class="foot_action_ext_btns gap-2">
                        <div class="add_agreement_btn foot_action_btn text-center"><i class="fa fa-plus"></i> License</div>
                        <div class="add_product_btn foot_action_btn text-center"><i class="fa fa-plus"></i> Product</div>
                        <div class="proffer_project_btn foot_action_btn text-center"><i class="fa fa-plus"></i> Project</div>
                        <div class="refresh_messages foot_action_btn text-center"><i class="fa fa-refresh"></i> Refresh Chat</div>
                    </div>
                    @endif
                    <div class="submit_btn foot_action_btn text-center"><i class="fa fa-paper-plane"></i> Send</div>
                </div>
                <input class="instant_hide chat_attachments" type="file" name="attachFiles[]" multiple />
            </div>
        </div>
    </div>
</div>
