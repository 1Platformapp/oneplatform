@php

    $chatGroups = $user->chatGroups();

@endphp

<div class="mt-12 each-stage-det instant_hide" data-stage-ref="contact-requests">

    <div class="items-end m_btm_filters_outer md:items-center">
        <div class="flex-1 mt-10 smart_switch_outer switch_supporter_requests md:mt-0 md:ml-auto">
            <div class="smart_switch_txt">Show Supporters</div>
            <label class="smart_switch">
                <input type="checkbox" />
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="btn_list_outer each-request-tab contact-requests">
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

    <div class="btn_list_outer each-request-tab instant_hide supporter-requests">
        @foreach($user->supporterRequests() as $supporterRequest)
            <div class="agent_supporter_request_listing music_btm_list no_sorting clearfix">
                <div class="edit_elem_top">
                    <div class="m_btm_list_left">
                        <div data-image="" class="music_btm_thumb">
                            <div class="music_bottom_load_thumb">No Image</div>
                        </div>
                        <ul class="music_btm_img_det">
                            <li>
                                <a class="filter_search_target" href="">
                                    {{$supporterRequest->supporter_name}}
                                </a>
                            </li>
                            <li>
                                <p>
                                    {{$supporterRequest->supporter_email}}
                                    {{date('d/m/Y h:i A', strtotime($supporterRequest->created_at))}}
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="m_btm_right_icons">
                        <ul>
                            <li>
                                <a title="Approve" class="m_btn_right_icon_each m_btm_approve active" data-id="{{$supporterRequest->id}}">
                                    <i class="fa fa-check"></i>
                                </a>
                            </li>
                            <li>
                                <a title="Delete" class="m_btn_right_icon_each m_btm_del active" data-del-id="{{$supporterRequest->id}}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pro_confirm_approve_outer pro_page_pop_up clearfix" >
        <div class="pro_confirm_delete_inner clearfix">
            <div class="soc_con_top_logo clearfix">
                <a style="opacity: 0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="https://www.recordingexperiences.com/images/1logo8.png">
                    <div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="pro_confirm_delete_text clearfix">
                <div class="main_headline">Are You Sure You Want To Approve This Request?</div><br>
            </div>
            <div class="pro_confirm_box_outer pro_submit_button_outer soc_submit_success clearfix">
                <div class="delete_yes pro_confirm_box_each" data-id="" data-item-type="" id="pro_approve_submit_yes">YES</div>
                <div class="delete_no pro_confirm_box_each" id="pro_confirm_approve_submit_no">NO</div>
            </div>
            <div class="error instant_hide"></div>
        </div>
    </div>
</div>

<script>
    $('.switch_supporter_requests .smart_switch input').change(function(){

        $('.each-request-tab').addClass('instant_hide');
        if($(this).prop("checked") == true){

            $('.each-request-tab.supporter-requests').removeClass('instant_hide');
        }else{

            $('.each-request-tab.contact-requests').removeClass('instant_hide');
        }
    });

    $('#contacts_section .supporter-requests .m_btm_approve').click(function(e){

        e.preventDefault();
        var id = $(this).attr('data-id');
        $('.pro_confirm_approve_outer #pro_approve_submit_yes').attr('data-id', id);

        if($(this).closest('.each-request-tab').hasClass('contact-requests')){

            $('.pro_confirm_approve_outer #pro_approve_submit_yes').attr('data-item-type', 'contact');
        }else if($(this).closest('.each-request-tab').hasClass('supporter-requests')){

            $('.pro_confirm_approve_outer #pro_approve_submit_yes').attr('data-item-type', 'supporter');
        }

        if( id ){

            $('.pro_confirm_approve_outer').show();
            $('#body-overlay').show();
        }
    });
</script>
