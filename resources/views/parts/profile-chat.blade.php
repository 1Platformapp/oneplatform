<div class="pro_pg_tb_det" style="display: block">
    <div class="pro_pg_tb_det_inner">
        <div id="contacts_section" class="sub_cat_data">
            <div class="pro_main_tray">
                <div class="pro_tray_title">{{$isAgent ? 'Agency' : ''}} Dashboard</div>
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
            <form id="add-contact-form" action="{{route('agent.contact.create')}}" method="POST">
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
                    </div><br><br>
                    <div class="pro_m_chech_outer">
                        <input class="add-contact-submit" type="button" value="Submit">
                    </div>
                </div>
            </form>

            <div class="pro_btm_listing_outer">
                <label class="chat_label chat_label_contacts">My Network Contacts
                    @if(count($contacts) > 0)
                        {{'('.count($contacts).')'}}
                    @endif
                </label>
                <label class="chat_label chat_label_personal instant_hide">My Personal Chats
                    @if(count($user->personalChatPartners()) > 0)
                        {{'('.count($user->personalChatPartners()).')'}}
                    @endif
                </label>
                <div class="m_btm_filters_outer">
                    <div class="m_btm_filter_search flex-1">
                        <input data-target="agent_contact_listing" placeholder="Search your contacts by name" type="text" class="m_btm_filter_search_field" />
                    </div>
                    <div class="m_btm_filter_drop flex-1">
                        <select data-target="agent_contact_listing" class="m_btm_filter_dropdown">
                            <option value="">Filter contacts</option>
                            <option value="all">All</option>
                            <option value="All Approved">All Approved</option>
                            <option value="All Unapproved">All Upapproved</option>
                            <option value="Main Network">My Main Network</option>
                        </select>
                    </div>
                    <div class="smart_switch_outer switch_personal_chat flex-1 ml-auto">
                        <div class="smart_switch_txt">Show Personal Chat</div>
                        <label class="smart_switch">
                            <input type="checkbox" />
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
                <div class="btn_list_outer">
                    <div class="chat_filter_container">
                        <div class="chat_filter_tab chat_filter_contacts">
                        @if(count($contacts) > 0)
                            @foreach($contacts as $contact)
                                @if(!$contact->contactUser || !$contact->agentUser)
                                    @php continue @endphp
                                @endif
                                @php
                                    $contactUser = $contact->contactUser;
                                    $agentUser = $contact->agentUser;
                                    $isAgentUser = $user->isAgentOfContact($contact);
                                    $partnerUser = $isAgentUser ? $contactUser : $agentUser;
                                    $contactPDetails = $commonMethods->getUserRealDetails($partnerUser->id)
                                @endphp
                                <div data-partner="{{$partnerUser->id}}" data-approved="{{$contact->approved ? '1' : ''}}" data-form="my-contact-form_{{ $contact->id }}" class="agent_contact_listing music_btm_list no_sorting clearfix">
                                    <div class="edit_elem_top">
                                        <div class="m_btm_list_left">
                                            <div data-image="{{$contactPDetails['image']}}" class="music_btm_thumb">
                                                <div class="music_bottom_load_thumb">Load Image</div>
                                            </div>
                                            <ul class="music_btm_img_det">
                                                <li>
                                                    <a class="filter_search_target" href="">
                                                        {{$partnerUser->name}}
                                                    </a>
                                                </li>
                                                <li>
                                                    <p>
                                                        <br>
                                                        {{$contact->commission ? $contact->commission . '% - ' : ''}} {{$contact->approved ? 'Approved' : ($contact->agreement_sign == 'sent' ? 'Sent to Sign' : 'Not Approved')}}
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
                                                    <a title="Chat" class="m_btn_right_icon_each m_btn_chat active" data-id="{{$contact->id}}">
                                                        <i class="fas fa-comment-dots"></i>
                                                    </a>
                                                </li>
                                                @if($isAgentUser)
                                                <li>
                                                    <a title="Edit" data-id="{{$contact->id}}" class="m_btn_right_icon_each m_btm_edit active">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </li>
                                                @endif
                                                <li>
                                                    @if($partnerUser->username)
                                                    <a target="_blank" title="Website" href="{{route('user.home',['params' => $partnerUser->username])}}" class="m_btn_right_icon_each m_btm_website active">
                                                        <i class="fa fa-globe"></i>
                                                    </a>
                                                    @else
                                                    <a title="Website" href="javascript:void(0)" class="m_btn_right_icon_each m_btm_website">
                                                        <i class="fa fa-globe"></i>
                                                    </a>
                                                    @endif
                                                </li>
                                                @if($isAgentUser)
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
                                                @endif
                                                <li>
                                                    <a data-open="blank" title="View Submission" data-id="{{route('agent.contact.details',['code' => $contact->code])}}" class="m_btn_right_icon_each m_btm_view active">
                                                        <i class="fa fa-file-text-o"></i>
                                                    </a>
                                                </li>
                                                @if($isAgentUser)
                                                <li>
                                                    <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{$contact->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </li>
                                                @endif
                                                @if($contact->approved)
                                                <li>
                                                    <a title="Agreements" class="m_btn_right_icon_each m_btn_files active" data-id="{{$contact->id}}">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a title="Calendar" class="m_btn_right_icon_each m_btn_calendar active" data-id="{{$contact->id}}">
                                                        <i class="fa fa-calendar"></i>
                                                    </a>
                                                </li>
                                                @else
                                                <li>
                                                    <a title="Agreements" class="m_btn_right_icon_each">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a title="Calendar" class="m_btn_right_icon_each">
                                                        <i class="fa fa-calendar"></i>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="edit_elem_bottom">
                                        @if($isAgentUser)
                                        <div class="each_dash_section instant_hide" data-id="contact_edit_{{$contact->id}}">
                                            @include('parts.agent-contact-edit-template', ['contact' => $contact])
                                        </div>
                                        @endif
                                        @if($contact->approved)
                                        <div class="each_dash_section instant_hide" data-id="contact_calendar_{{$contact->id}}">
                                            @include('parts.agent-contact-calendar', ['contact' => $contact])
                                        </div>
                                        <div class="each_dash_section instant_hide" data-id="contact_agreement_{{$contact->id}}">
                                            @include('parts.agent-contact-agreement', ['contact' => $contact, 'contracts' => $contracts])
                                        </div>
                                        @endif
                                        <div class="each_dash_section instant_hide" data-id="contact_chat_{{$contact->id}}">
                                            @include('parts.agent-contact-chat')
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no_results">No records yet</div>
                        @endif
                        </div>
                        <div class="chat_filter_tab chat_filter_personal instant_hide">
                        @if(count($user->personalChatPartners()) > 0)
                            @foreach($user->personalChatPartners() as $partnerId)
                                @php $partner = \App\Models\User::find($partnerId) @endphp
                                @if(!$partner)
                                    @php continue @endphp
                                @endif
                                @php $partnerPDetails = $commonMethods->getUserRealDetails($partnerId) @endphp
                                <div data-form="my-contact-form_{{ $partner->id }}" class="agent_partner_listing music_btm_list no_sorting clearfix">
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="pro_btm_listing_outer">
                <label>My groups</label>
                <div class="btn_list_outer">
                    @if(count($chatGroups))
                    <div class="chat_groups">
                        @foreach($chatGroups as $chatGroup)
                        @php $groupContact = \App\Models\AgentContact::where(['contact_id' => $chatGroup->contact_id, 'agent_id' => $chatGroup->agent_id])->get()->first() @endphp
                        @if($groupContact)
                        <div id="{{$chatGroup->id}}" data-form="my-contact-form_{{ $groupContact->id }}" class="chat_group_listing agent_contact_listing music_btm_list no_sorting clearfix">
                            <div class="edit_elem_top">
                                <div class="m_btm_list_left">
                                    <div class="music_btm_thumb">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <ul class="music_btm_img_det">
                                        <li>
                                            <a class="filter_search_target" href="">
                                                You and {{count($chatGroup->other_members) + 1}} more members in this group
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="m_btm_right_icons">
                                    <ul>
                                        <li>
                                            <a title="Chat" class="m_btn_right_icon_each m_btn_chat active" data-id="{{$groupContact->id}}">
                                                <i class="fas fa-comment-dots"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="edit_elem_bottom">
                                <div class="each_dash_section instant_hide" data-id="contact_chat_{{$groupContact->id}}">
                                    @include('parts.agent-contact-chat')
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            @if(count($user->contactRequests) > 0)
            <div class="pro_btm_listing_outer">
                <label>Network Contact Requests</label>
                <div class="m_btm_filters_outer">
                    <div class="m_btm_filter_search">
                        <input data-target="agent_contact_request_listing" placeholder="Search users by name" type="text" class="m_btm_filter_search_field" />
                    </div>
                </div>
                <div class="btn_list_outer">
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
                </div>
            </div>
            @endif
            @if(!$isAgent)
            <div class="sub_cat_data">
                <div class="pro_music_search pro_music_info no_border">
                    <!--<div class="pro_inp_list_outer">
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
                    </div>!-->
                </div>
                <div class="get_agent_outer">
                    <div class="pro_btm_listing_outer pt-0">
                        <!--<label class="chat_label chat_label_contacts">My Agent</label>
                        <label class="chat_label chat_label_personal instant_hide">My Personal Chats
                            @if(count($user->personalChatPartners()) > 0)
                                {{'('.count($user->personalChatPartners()).')'}}
                            @endif
                        </label>
                        <div class="m_btm_filters_outer">
                            <div class="smart_switch_outer switch_personal_chat flex-1 ml-auto">
                                <div class="smart_switch_txt">Show Personal Chat</div>
                                <label class="smart_switch">
                                    <input type="checkbox" />
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="btn_list_outer">
                            <div class="chat_filter_container">
                                <div class="chat_filter_tab chat_filter_agent">
                                    <div class="chat_my_agent">
                                        @if($agentContact)
                                        @php $myAgent = $agentContact->agentUser @endphp
                                        @php $agentPDetails = $commonMethods->getUserRealDetails($myAgent->id) @endphp
                                        @php $agentContacts = \App\Models\AgentContact::where('agent_id', $myAgent->id)->get() @endphp
                                        <div class="agents_listing agent_contact_listing music_btm_list no_sorting clearfix">
                                            <div class="edit_elem_top">
                                                <div class="m_btm_list_left">
                                                    <div data-image="{{$agentPDetails['image']}}" class="music_btm_thumb">
                                                        <div class="music_bottom_load_thumb">Load Image</div>
                                                    </div>
                                                    <ul class="music_btm_img_det">
                                                        <li>
                                                            <a class="filter_search_target" href="javascript:void(0)">
                                                                {{$myAgent->name}}
                                                            </a>
                                                        </li>
                                                        <li><br>
                                                            <p>
                                                                <i class="fa fa-users"></i>
                                                                    @if($myAgent->id == 727)
                                                                        {{number_format(350 + count($agentContacts))}}
                                                                    @elseif($myAgent->id == 722)
                                                                        {{number_format(175 + count($agentContacts))}}
                                                                    @else
                                                                        {{count($agentContacts)}}
                                                                    @endif
                                                                    network contacts
                                                                @if($agentPDetails['city'] != '')
                                                                &nbsp;&nbsp;<i style="font-size: 17px;" class="fa fa-map-marker"></i> {{$agentPDetails['city']}}
                                                                @endif
                                                                @if($agentContact->approved)
                                                                    <div class="get_agent is_current_agent">Your agent</div>
                                                                @else
                                                                    <div class="get_agent is_pending">Pending</div>
                                                                @endif
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="m_btm_right_icons">
                                                    <ul>
                                                        <li>
                                                            <a title="Chat" class="m_btn_right_icon_each m_btn_chat active" data-id="{{$agentContact->id}}">
                                                                <i class="fas fa-comment-dots"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a data-open="blank" title="View Submission" data-id="{{route('agent.contact.details',['code' => $agentContact->code])}}" class="m_btn_right_icon_each m_btm_view active">
                                                                <i class="fa fa-file-text-o"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a title="Agreements" class="m_btn_right_icon_each m_btn_files active" data-id="{{$myAgent->id}}">
                                                                <i class="fas fa-file-pdf"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a title="Calendar" class="m_btn_right_icon_each m_btn_calendar active" data-id="{{$myAgent->id}}">
                                                                <i class="fa fa-calendar"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a target="_blank" title="Website" href="{{route('user.home',['params' => $myAgent->username])}}" class="m_btn_right_icon_each m_btm_website active">
                                                                <i class="fa fa-globe"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="edit_elem_bottom">
                                                @if($agentContact->approved)
                                                <div class="each_dash_section instant_hide" data-id="contact_calendar_{{$agent->id}}">
                                                    @include('parts.agent-contact-calendar', ['contact' => $agentContact])
                                                </div>
                                                <div class="each_dash_section instant_hide" data-id="contact_agreement_{{$agent->id}}">
                                                    @include('parts.agent-contact-agreement', ['contact' => $agentContact, 'contracts' => $contracts, 'myContracts' => $myContracts])
                                                </div>
                                                @endif
                                                <div class="each_dash_section instant_hide" data-id="contact_chat_{{$agentContact->id}}">
                                                    @include('parts.agent-contact-chat', ['contact' => $agentContact, 'isAgent' => false, 'user' => $user])
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="no_results">You do not have an agent yet</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="chat_filter_tab chat_filter_personal instant_hide">
                                @if(count($user->personalChatPartners()) > 0)
                                    @foreach($user->personalChatPartners() as $partnerId)
                                        @php $partner = \App\Models\User::find($partnerId) @endphp
                                        @if(!$partner)
                                            @php continue @endphp
                                        @endif
                                        @php $partnerPDetails = $commonMethods->getUserRealDetails($partnerId) @endphp
                                        <div data-form="my-contact-form_{{ $partner->id }}" class="agent_partner_listing music_btm_list no_sorting clearfix">
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
                                </div>
                            </div>
                        </div>!-->
                        <label class="chat_label_contacts mt-36">1Platform Agents</label>
                        <div class="chat_filter_agents">
                        @if(count($agents) > 0)
                            @foreach($agents as $agent)
                                @php $agentPDetails = $commonMethods->getUserRealDetails($agent->id) @endphp
                                @php $agentContacts = \App\Models\AgentContact::where('agent_id', $agent->id)->get() @endphp
                                @php $requestSent = \App\Models\AgentContactRequest::where(['agent_user_id' => $agent->id, 'contact_user_id' => $user->id])->first() @endphp
                                <div class="agents_listing agent_contact_listing music_btm_list no_sorting clearfix">
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
                                                        @if($requestSent)
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
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{asset('css/profile.chat.css?v=1.8')}}">
<script>
    $('select[name="pro_contact_already_user"]').change(function(){

        if($(this).val() == '1'){

            $('input[name="pro_contact_already_user_email"]').prop('disabled', false).focus();
        }else{

            $('input[name="pro_contact_already_user_email"]').val('').prop('disabled', true);
        }
    });

    $('.add-contact-submit').click(function(e){

        e.preventDefault();
        var thiss = $(this);
        var error = 0;

        var form = $('#add-contact-form');
        form.find('.pro_stream_input_each.has-danger').removeClass('has-danger');

        var name = form.find('input[name=pro_contact_name]');
        var alreadyUser = form.find('select[name="pro_contact_already_user"]');
        var alreadyUserEmail = form.find('input[name="pro_contact_already_user_email"]');

        if( name.val() == '' ){ error = 1; name.closest('.pro_stream_input_each').addClass('has-danger'); }
        if(alreadyUser.val() == '1' && alreadyUserEmail.val() == ''){

            error = 1;
            alreadyUserEmail.closest('.pro_stream_input_each').addClass('has-danger');
        }

        var browserWidth = $( window ).width();

        if( browserWidth <= 767 ) { var margin = 50; }
        else { var margin = 30+44; }

        if(!error){

            form.submit();
        }
    });

    $('.m_btm_edit, .m_btn_files, .m_btn_calendar, .m_btn_chat').click(function(e){

         var id = $(this).attr('data-id');
         if($(this).hasClass('m_btm_edit')){
            $('.each_dash_section:not(.each_dash_section[data-id="contact_edit_'+id+'"])').addClass('instant_hide');
            $('.each_dash_section[data-id="contact_edit_'+id+'"]').toggleClass('instant_hide');
         }else if($(this).hasClass('m_btn_files')){
            $('.each_dash_section:not(.each_dash_section[data-id="contact_agreement_'+id+'"])').addClass('instant_hide');
            $('.each_dash_section[data-id="contact_agreement_'+id+'"]').toggleClass('instant_hide');
         }else if($(this).hasClass('m_btn_calendar')){
            $('.each_dash_section:not(.each_dash_section[data-id="contact_calendar_'+id+'"])').addClass('instant_hide');
            $('.each_dash_section[data-id="contact_calendar_'+id+'"]').toggleClass('instant_hide');
         }else if($(this).hasClass('m_btn_chat')){
            if($(this).closest('.music_btm_list').hasClass('agent_contact_listing')){

               var elem = $('.each_dash_section[data-id="contact_chat_'+id+'"]');
               var parent = $(this).closest('.agent_contact_listing');
               var type = 'contact-chat';
            }else if($(this).closest('.music_btm_list').hasClass('agent_partner_listing')){

               var elem = $('.each_dash_section[data-id="partner_chat_'+id+'"]');
               var parent = $(this).closest('.agent_partner_listing');
               var type = 'partner-chat';
            }

            parent.find('.each_dash_section').not(elem).addClass('instant_hide');
            elem.toggleClass('instant_hide');

            if(!elem.hasClass('instant_hide')){

               var formData = new FormData();
               formData.append('type', type);
               formData.append('data', id);

               getChatMessages(elem.find('.chat_outer'), formData);
            }
         }
    });

    $('.m_btm_del').click(function(e){

        e.preventDefault();
        var id = $(this).attr('data-del-id');
        $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', id);

        if($(this).closest('.music_btm_list').hasClass('agent_contact_listing')){

            $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'agent-contact');
        }else if($(this).closest('.music_btm_list').hasClass('agent_contact_request_listing')){

            $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'agent-contact-request');
        }

        if(id){

            $('.pro_confirm_delete_outer').show();
            $('#body-overlay').show();
        }
    });

    $('.m_btm_right_icons .m_btm_switch_account').click(function(e){

        var id = $(this).attr('data-id');
        $('#switch_account_popup').attr('data-id', id);
        $('#switch_account_popup,#body-overlay').show();
    });

    $('#proceed_switch_account').click(function(e){

        var id = $('#switch_account_popup').attr('data-id');
        window.location = id;
    });

    $('.m_btm_right_icons .m_btm_view').click(function(e){

        var id = $(this).attr('data-id');
        if(id != ''){

            if($(this).attr('data-open') == 'blank'){

                window.open(id,'_blank');
            }else{
                window.location = id;
            }
        }
    });

    $('.edit_now, .edit_and_send_agree, .edit_and_send_question').click(function(e){

        e.preventDefault();
        var thiss = $(this);
        var error = 0;
        var form = thiss.closest('form');
        var email = form.find('input[name="pro_contact_email"]');
        var questionId = form.find('select[name="pro_contact_questionnaireId"]');
        form.find('.has-danger').removeClass('has-danger');
        if($(this).hasClass('edit_and_send_agree')){

            if(email.val() == ''){
                error = 1;
                email.closest('.pro_stream_input_each').addClass('has-danger');
            }else{
                form.find('input[name="send_email"]').val('1');
            }
        }else if($(this).hasClass('edit_and_send_question')){

            if(email.val() == ''){
                error = 1;
                email.closest('.pro_stream_input_each').addClass('has-danger');
            }else if(questionId.val() == ''){
                error = 1;
                questionId.closest('.pro_stream_input_each').addClass('has-danger');
            }else{
                form.find('input[name="send_email"]').val('2');
            }
        }else{
            form.find('input[name="send_email"]').val('0');
        }

        if(!error){
            form.submit();
        }
    });

    $('.switch_contracts_view').click(function(e){

        var form = $(this).closest('form');
        form.find('.contracts_list').toggleClass('instant_hide');
        form.find('.new_contracts').toggleClass('instant_hide');
        if($(this).attr('data-list') == 'add'){
            $(this).attr('data-list', 'list');
            $(this).text('Add contract');
        }else if($(this).attr('data-list') == 'list'){
            $(this).attr('data-list', 'add');
            $(this).text('My contracts');
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

    $('.chat_main_body .chat_main_body_messages').on('scroll', function() {

        var thiss = $(this);
        var parent = thiss.closest('.chat_outer');
        if(thiss.get(0).scrollTop == 0 && thiss.find('.chat_each_message').length > 0){
            parent.find('.loading_messages').removeClass('instant_hide');
            var firstMessage = thiss.find('.chat_each_message').first();

            if(parent.closest('.music_btm_list').hasClass('agent_contact_listing')){
                var id = parent.closest('.agent_contact_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                $type = 'contact-chat';
            }else if(parent.closest('.music_btm_list').hasClass('agent_partner_listing')){
                var id = parent.closest('.agent_partner_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                $type = 'partner-chat';
            }

            var formData = new FormData();
            formData.append('type', $type);
            formData.append('data', id);
            formData.append('cursor', firstMessage.attr('data-cursor'));
            getChatMessages(parent, formData);
        }
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

    $('body').delegate('.chat_outer:not(.disabled) .refresh_messages', 'click', function(e){

        var element = $(this).closest('.chat_outer');
        element.find('.loading_messages').removeClass('instant_hide');
        element.find('.chat_main_body_messages').html('');

        refreshChat(element);
    });

    $('body').delegate('.chat_outer:not(.disabled) .proffer_project_btn:not(.disabled),.chat_outer:not(.disabled) .add_product_btn:not(.disabled),.chat_outer:not(.disabled) .add_agreement_btn:not(.disabled)', 'click', function(e){

        var element = $(this).closest('.chat_outer');
        var type = null;
        var members = [];
        var purchaseItem = null;
        var purchaseType = null;
        var customers = [];

        if($(this).hasClass('proffer_project_btn')){
            purchaseItem = 'project';
        }else if($(this).hasClass('add_product_btn')){
            purchaseItem = 'product';
        }else if($(this).hasClass('add_agreement_btn')){
            purchaseItem = 'license';
        }

        if(purchaseItem){

            $('#chat_purchase_popup .stage, #chat_purchase_popup .stage_two').addClass('instant_hide');
            if(purchaseItem == 'project'){

                var stage = $('#chat_purchase_popup .stage_one .project');
            }else if(purchaseItem == 'product'){

                var stage = $('#chat_purchase_popup .stage_one .product');
            }else if(purchaseItem == 'license'){

                var stage = $('#chat_purchase_popup .stage_one .license');
            }

            stage.find('.choose_customer_dropdown').find('option').each(function() {
                if($(this).val() != ''){
                    $(this).remove();
                }
            });
            stage.find('input,textarea').val('');

            if(element.closest('.music_btm_list').hasClass('agent_contact_listing') && element.closest('.music_btm_list.agent_contact_listing').attr('data-approved') == '1'){

                var id = element.closest('.agent_contact_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                purchaseType = 'group-purchase';
                customers.push({ key: 'partner', value: element.closest('.music_btm_list.agent_contact_listing').find('.filter_search_target').text() });
                element.find('.chat_member_each_outer:not(.chat_member_add)').each(function(){
                    customers.push({ key: $(this).attr('data-member'), value: $(this).attr('data-name') });
                });
            }else if(element.closest('.music_btm_list').hasClass('chat_group_listing')){

                var id = element.closest('.agent_contact_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                purchaseType = 'group-purchase';
                element.find('.chat_member_each_outer:not(.chat_member_add)').each(function(){
                    customers.push({ key: $(this).attr('data-member'), value: $(this).attr('data-name') });
                });
            }else if(element.closest('.music_btm_list').hasClass('agent_partner_listing')){

                var id = element.closest('.agent_partner_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                purchaseType = 'partner-purchase';
                customers.push({ key: id, value: element.closest('.music_btm_list.agent_partner_listing').find('.filter_search_target').text() });
            }else if(element.closest('.music_btm_list').hasClass('agent_contact_listing') && element.closest('.music_btm_list.agent_contact_listing').attr('data-approved') == ''){

                var id = element.closest('.agent_contact_listing').attr('data-partner');
                purchaseType = 'partner-purchase';
                customers.push({ key: id, value: element.closest('.music_btm_list.agent_contact_listing').find('.filter_search_target').text() });
            }

            for (var i = 0; i < customers.length; i++) {
                stage.find('.choose_customer_dropdown').append($('<option>',{
                    value: customers[i].key,
                    text : customers[i].value
                }));
            }
            $('#chat_purchase_popup').attr({
                'data-type': purchaseType,
                'data-item': purchaseItem,
                'data-id': id
            });
            stage.removeClass('instant_hide');
            $('#chat_purchase_popup .stage_one').removeClass('instant_hide');
            $('#chat_purchase_popup,#body-overlay').show();
        }else{

            alert('Invalid option');
        }
    });

    $('body').delegate('.choose_end_term_dropdown', 'change', function(e){

        if($(this).val() == 'custom'){
            $(this).closest('.pro_pop_multi_row').find('.end_term').attr('disabled', false).focus();
        }else{
            $(this).closest('.pro_pop_multi_row').find('.end_term').val('').attr('disabled', true);
        }
    });

    $('body').delegate('.chat_purchase_send_btn', 'click', function(e){

        var thiss = $(this);
        $('.stage .error').addClass('instant_hide');
        var error = 0;
        var purchaseType = $('#chat_purchase_popup').attr('data-type');
        var purchaseItem = $('#chat_purchase_popup').attr('data-item');
        var purchaseId = $('#chat_purchase_popup').attr('data-id');
        var formData = new FormData();

        if(purchaseItem == 'project'){

            var stage = $('#chat_purchase_popup .stage_one .project');
            var url = '/proffer-project/add';
        }else if(purchaseItem == 'product'){

            var stage = $('#chat_purchase_popup .stage_one .product');
            var url = '/proffer-product/add';
        }else if(purchaseItem == 'license'){

            var stage = $('#chat_purchase_popup .stage_one .license');
            var url = '/bispoke-license/agreement/add';
        }else{

            error = 1;
            alert('Incorrect purchase');
        }

        if(error == 0){

            var customer = stage.find('.choose_customer_dropdown');
            var title = stage.find('.title');
            var endTermSelect = stage.find('.choose_end_term_dropdown');
            var endTerm = stage.find('.end_term');
            var price = stage.find('.price');
            var description = stage.find('.description');
            var product = stage.find('.choose_product');
            var music = stage.find('.choose_agreement_music');
            var license = stage.find('.choose_agreement_license');
            var licenseTerms = stage.find('.license_terms');

            if(stage.find('.choose_customer_dropdown').length > 0){
                if(customer.val() == ''){
                    stage.find('.choose_customer_error').removeClass('instant_hide');
                    error = 1;
                }else{
                    formData.append('customer', customer.val());
                }
            }
            if(stage.find('.title').length > 0){

                if(title.val() == ''){
                    stage.find('.title_error').removeClass('instant_hide');
                    error = 1;
                }else{
                    formData.append('title', title.val());
                }
            }
            if(stage.find('.price').length > 0){

                if(price.val() == ''){
                    stage.find('.price_error').removeClass('instant_hide');
                    error = 1;
                }else{
                    formData.append('price', price.val());
                }
            }
            if(stage.find('.description').length > 0){

                if(description.val() == ''){
                    stage.find('.description_error').removeClass('instant_hide');
                    error = 1;
                }else{
                    formData.append('description', description.val());
                }
            }
            if(stage.find('.choose_end_term_dropdown').length > 0){

                if(endTermSelect.val() == ''){
                    stage.find('.choose_end_term_error').removeClass('instant_hide');
                    error = 1;
                }else if(endTermSelect.val() == 'custom' && endTerm.val() == ''){
                    stage.find('.end_term_error').removeClass('instant_hide');
                    error = 1;
                }else{
                    formData.append('endTermSelect', endTermSelect.val());
                    formData.append('endTerm', endTerm.val());
                }
            }
            if(stage.find('.choose_product').length > 0){
                if(product.val() == ''){
                    stage.find('.choose_product_error').removeClass('instant_hide');
                    error = 1;
                }else{
                    formData.append('product', product.val());
                }
            }
            if(stage.find('.choose_agreement_music').length > 0){
                if(music.val() == ''){
                    stage.find('.choose_agreement_music_error').removeClass('instant_hide');
                    error = 1;
                }else{
                    formData.append('music', music.val());
                }
            }
            if(stage.find('.choose_agreement_license').length > 0){
                if(license.val() == ''){
                    stage.find('.choose_agreement_license_error').removeClass('instant_hide');
                    error = 1;
                }else{
                    formData.append('license', license.val());
                }
            }
            if(stage.find('.license_terms').length > 0){
                formData.append('terms', licenseTerms.val());
            }

            if(error){
                console.log('error');
            }else{

                formData.append('type', purchaseType);
                formData.append('id', purchaseId);

                $.ajax({

                    url: url,
                    dataType: "json",
                    type: 'post',
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if(response.success == 1){
                            var name = customer.find('option:selected').text();
                            $('#chat_purchase_popup .stage_two #sender_name').text(name);
                            $('#chat_purchase_popup .stage_one').addClass('instant_hide');
                            $('#chat_purchase_popup .stage_two').removeClass('instant_hide');
                            $('#chat_purchase_popup input, #chat_purchase_popup textarea').val('');

                            var element = $('div[data-form="my-contact-form_'+purchaseId+'"]');
                            if(element.length == 0){
                                element = $('div[data-partner="'+purchaseId+'"]');
                            }
                            if(element.length){
                                refreshChat(element.find('.chat_outer'));
                            }
                        }else{
                            alert(response.error);
                        }
                    }
                });
            }
        }
    });

    $('body').delegate('.chat_member_add', 'click', function(e){
        var id = $(this).attr('data-id');
        var contact = $(this).closest('.agent_contact_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
        $('#add_chat_group_member_popup #add_chat_group_member').val('');
        $('#add_chat_group_member_popup').attr('data-group', id);
        $('#add_chat_group_member_popup').attr('data-contact', contact);
        $('#add_chat_group_member_popup,#body-overlay').show();
        e.stopPropagation();
    });

    $('body').delegate('.chat_member_remove', 'click', function(e){
        e.stopPropagation();
        var group = $(this).closest('.chat_group_members').find('.chat_member_add').attr('data-id');
        var member = $(this).closest('.chat_member_each_outer');
        if(confirm('Are you sure?')){

            var formData = new FormData();
            formData.append('group', group);
            formData.append('contact', member.attr('data-member'));
            formData.append('action', 'remove');

            $.ajax({

                url: '/agent-contact/add-remove-to-group',
                type: 'POST',
                data: formData,
                contentType:false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (response) {

                    if(response.success){

                        $('.pro_page_pop_up, #body-overlay').hide();
                        member.remove();
                    }else{
                        alert(response.error);
                    }
                }
            });
        }
    });

    $('body').delegate('#send_add_chat_group_member', 'click', function(e){

        var id = $('#add_chat_group_member_popup').attr('data-group');
        var contact = $('#add_chat_group_member_popup').attr('data-contact');
        var contactId = $('#add_chat_group_member').val();
        var contactCode = $('#add_chat_group_member_contact_code').val();
        if(contactId == '' || id == ''){

            alert('Your request data is missing');
        }else{

            var formData = new FormData();
            formData.append('group', id);
            formData.append('contact', contactId);
            formData.append('contactCode', contactCode);
            formData.append('action', 'add');

            $.ajax({

                url: '/agent-contact/add-remove-to-group',
                type: 'POST',
                data: formData,
                contentType:false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (response) {

                    if(response.success){

                        $('.pro_page_pop_up, #body-overlay').hide();
                        var element = $('.agent_contact_listing[data-form="my-contact-form_'+contact+'"]').find('.chat_outer');
                        element.find('.chat_group_members').append(response.html);
                    }else{
                        console.log(response.error);
                    }
                }
            });
        }
    });

    $('#add_chat_group_member').change(function(){

        $('#add_chat_group_member_contact_code_error').addClass('instant_hide');

        if($(this).val() == 'add_by_code'){

            $('#add_chat_group_member_contact_code').prop('disabled', false).focus();
        }else{

            $('#add_chat_group_member_contact_code').prop('disabled', true);
        }
    });

    $('.switch_personal_chat .smart_switch input').change(function(){

        $('.chat_filter_tab, .m_btm_filter_search, .m_btm_filter_drop, .chat_label').addClass('instant_hide');
        if($(this).prop("checked") == true){

            $('.chat_filter_tab.chat_filter_personal, .chat_label_personal').removeClass('instant_hide');
        }else{

            $('.chat_filter_tab.chat_filter_contacts, .chat_label_contacts, .chat_filter_tab.chat_filter_agent, .m_btm_filter_search, .m_btm_filter_drop').removeClass('instant_hide');
        }
    });

    function refreshChat(element){

        if(element.closest('.music_btm_list').hasClass('agent_contact_listing')){

            var id = element.closest('.agent_contact_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
            $type = 'contact-chat';
        }else if(element.closest('.music_btm_list').hasClass('agent_partner_listing')){

            var id = element.closest('.agent_partner_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
            $type = 'partner-chat';
        }
        var formData = new FormData();
        formData.append('type', $type);
        formData.append('data', id);

        getChatMessages(element, formData);
    }

    function getChatMessages(element, formData){

        $.ajax({

            url: '/dashboard/chat',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {

                element.find('.loading_messages').addClass('instant_hide');
                if(response.success){
                    if(response.data.group.messages.length){

                        renderChatMessages(element, formData.get('cursor'), response.data.group);
                    }else if(response.data.private.messages.length){

                        renderChatMessages(element, formData.get('cursor'), response.data.private);
                    }else{

                        if(!formData.get('cursor')){
                            element.find('.chat_main_body_messages').html('<div class="text-sm text-center font-semibold text-gray-500 m-auto">No messages found</div>');
                        }
                    }
                }else{

                    console.log(response.error);
                }
            }
        });
    }

    function renderChatMessages(element, cursor, data){

        if(cursor){

            element.find('.chat_main_body_messages').prepend(data.messages);
            renderScrollHeight(element, cursor);
        }else{

            element.find('.chat_main_body_messages').html(data.messages);
            renderScrollHeight(element);
        }

        if(data.members){

            element.find('.chat_group_members').html(data.members);
        }
    }

    function renderScrollHeight(element, cursor = null){

        if(cursor){

            var height = 0;
            element.find('.chat_main_body_messages .chat_each_message').filter(function() {
                if($(this).attr('data-cursor') < parseInt(cursor)){

                    height += $(this).outerHeight(true);
                }
            });
            element.find('.chat_main_body_messages').animate({ scrollTop: height }, 0);
        }else{

            setTimeout(function(){
                element.find('.chat_main_body_messages').animate({ scrollTop: element.find('.chat_main_body_messages')[0].scrollHeight + 5000 }, 0);
            }, 100);
        }
    }

    function prepareChatUploader(element){

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
            var sizeem = Math.round(size/(1024*1024));
            var sizeek = Math.round(size/(1024));
            item.find('.item_size').text(sizeem > 0 ? sizeem+' MB' : sizeek+' KB');
            item.find('.item_name').text(name);
            item.find('.item_file').removeClass('instant_hide');
        }
        $(html).appendTo($('.pro_pop_chat_upload .pro_body_in'));
        var item = $('.pro_pop_chat_upload .pro_body_in .pro_pop_chat_upload_each').last();
        item.attr('data-type', 'attachment-finalize');
        item.find('.item_name').text('Finalizing');
        item.find('.item_info').removeClass('instant_hide');
    }

    function startChatUploader(element, id = null){

        var popElem = $('.pro_pop_chat_upload .pro_pop_chat_upload_each.waiting').first();
        if(popElem.length){

            popElem.addClass('pending').removeClass('failed');
            popElem.find('.item_status i').addClass('fa-spinner fa-spin').removeClass('fa-check-circle fa-pause');

            var formData = new FormData();
            var dataType = popElem.attr('data-type');

            if(dataType == 'attachment-finalize'){

                var contactId = element.closest('.agent_contact_listing').find('.m_btn_right_icon_each.m_btn_chat').attr('data-id');
                formData.append('chat', id);
                formData.append('contact', contactId);
                formData.append('message', element.find('.new_message').val());
            }else if(dataType == 'attachment-upload'){

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
                success: function (response){

                    if(response.success == 1){
                        popElem.removeClass('pending waiting').addClass('complete');
                        popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-check-circle');
                    }else{
                        popElem.removeClass('pending waiting').addClass('failed');
                        popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-exclamation-triangle');
                    }

                    startChatUploader(element, response.id);
                },
                error: function(response){

                    popElem.removeClass('pending waiting').addClass('failed');
                    popElem.find('.item_status i').removeClass('fa-spinner fa-spin').addClass('fa-exclamation-triangle');
                }
            });
        }else{
            element.find('.attachment_area .close').trigger('click');
            refreshChat(element);

            element.find('.new_message').val('').change();
            element.find('.attachment_area .close').trigger('click');
            $('.pro_pop_chat_upload .pro_pop_chat_upload_each').remove();
            $('.pro_pop_chat_upload,#body-overlay').hide();
            element.find('.submit_btn').removeClass('disabled');
        }
    }

    function chatPurchaseAction(element, type, value, id, account, seller, price, itemId){

        var price = atob(price);
        var curr = $('#pay_quick_popup').attr('data-currency');
        var parent = $(element).closest('.chat_outer');
        var customId;
        var customType;

        if(type == 'project'){

            url = '/proffer-project/response';
            customId = '';
            customType = 'project';
        }else if(type == 'proferred-product'){
            url = '/proffer-product/response';
            customId = '';
            customType = 'product';
        }else if(type == 'instant-license'){
            url = '/bispoke-license/agreement/response';
            customId = 'bespoke_' + id;
            customType = 'license';
        }

        if(value == 'Accepted' || value == 'Declined'){

            if(confirm('Be sure to read the project file before proceding. Are you sure to proceed?')){

                var formData = new FormData();
                formData.append('response', value);
                formData.append(customType, id);

                $.ajax({

                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (response) {
                        if(response.success){

                            if(value == 'Accepted'){
                                if((parent.closest('.music_btm_list').hasClass('agent_contact_listing') && parent.closest('.music_btm_list.agent_contact_listing').attr('data-approved') == '1') || (parent.closest('.music_btm_list').hasClass('chat_group_listing'))){
                                    var response = preparePayInstant(account, id, '#pay_quick_card_number', '#pay_quick_card_expiry', '#pay_quick_card_cvc', 'You are purchasing a ' + customType, 'Price: '+curr+price);
                                    if(response == ''){
                                        $('#pay_quick_popup,#body-overlay').show();
                                    }else{
                                        alert(response);
                                    }
                                }else{
                                    addCartItem(customId, type, 0, 0, 0, price, seller, id);
                                }
                            }else{
                                refreshChat(parent);
                            }
                        }
                    }
                });
            }
        }else if(value == 'addToCart'){

            if((parent.closest('.music_btm_list').hasClass('agent_contact_listing') && parent.closest('.music_btm_list.agent_contact_listing').attr('data-approved') == '1') || (parent.closest('.music_btm_list').hasClass('chat_group_listing'))){
                var response = preparePayInstant(account, id, '#pay_quick_card_number', '#pay_quick_card_expiry', '#pay_quick_card_cvc', 'You are purchasing a ' + customType, 'Price: '+curr+price);
                if(response == ''){
                    $('#pay_quick_popup,#body-overlay').show();
                }else{
                    alert(response);
                }
            }else{
                addCartItem(customId, type, 0, 0, 0, price, seller, id);
            }
        }
    }

    function preparePayInstant(account, id, cardNumberF, cardExpiryF, cardCvcF, mainText, subText){

        var error = '';

        if(account === ''){

            error = 'This seller has not connected the stripe account'
        }else if(account === null){

            window.stripe = Stripe($('#stripe_publishable_key').val());
        }else{

            var account = atob(account);
            window.stripe = Stripe($('#stripe_publishable_key').val(), { stripeAccount: account});
        }

        if(error != ''){

            return error;
        }else{

            var elements = window.stripe.elements();

            var baseStyles = {'fontFamily': 'Open sans, sans-serif','fontSize': '14px','color': '#000','lineHeight': '31px'};
            var invalidStyles = {'color': '#fc064c'};

            window.eCardNumber = elements.create('cardNumber', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
            window.eCardCvc = elements.create('cardCvc', {'style': {'base': baseStyles, 'invalid': invalidStyles}});
            window.eCardExpiry = elements.create('cardExpiry', {'style': {'base': baseStyles, 'invalid': invalidStyles}});

            window.eCardNumber.mount(cardNumberF);
            window.eCardCvc.mount(cardCvcF);
            window.eCardExpiry.mount(cardExpiryF);

            $('#pay_quick_popup #pay_quick_error').text('').removeClass('instant_hide');
            $('#pay_quick_popup').attr('data-id', id);

            if(id.includes('custom_product')){

                var split = subText.split('_');
                $('#pay_quick_popup .pay_item_name').text(limitString(split[4], 40));
                $('#pay_quick_popup .pay_item_price').text(split[2]);
                $('#pay_quick_popup .pay_item_purchase_qua .pay_item_purchase_qua_num').text(split[3]);
                $('#pay_quick_popup .pay_item_purchase_det').text(split[0]);
                if(split[1] != ''){
                    $('#pay_quick_popup .pay_item_purchase_det').text($('#pay_quick_popup .pay_item_purchase_det').text()+' - '+split[1]);
                }
            }else{

                $('#pay_quick_popup .main_headline').text(mainText);
                $('#pay_quick_popup .second_headline').html(subText);
            }
        }

        return '';
    }
</script>
