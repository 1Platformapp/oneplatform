@php

    $chatGroups = $user->chatGroups();

@endphp

<div class="mt-12 each-stage-det instant_hide" data-stage-ref="my-groups">
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
