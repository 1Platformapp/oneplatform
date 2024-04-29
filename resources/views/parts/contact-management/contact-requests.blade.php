@php

    $chatGroups = $user->chatGroups();

@endphp

<div class="mt-12 each-stage-det instant_hide" data-stage-ref="contact-requests">

    <div class="btn_list_outer">
        @foreach($user->contactRequests as $contactRequest)
            @if(!$contactRequest->contactUser || !$contactRequest->agentUser)
                @php continue @endphp
            @endif
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
