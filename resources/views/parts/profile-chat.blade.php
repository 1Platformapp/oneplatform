
<div class="pro_pg_tb_det" style="display: block">
    <div class="pro_pg_tb_det_inner">

        <div id="contacts_section" class="sub_cat_data">
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

            <div id='calendar'></div>

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
                                <option value="Main Network">My Main Network</option>
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
                                        </ul>
                                    </div>
                                </div>

                                <div class="edit_elem_bottom">
                                    @include('parts.agent-contact-edit-template', ['contact' => $contact])
                                    @include('parts.agent-contact-calendar', ['contact' => $contact])
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
    </div>
</div>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<link rel="stylesheet" href="{{asset('css/profile.chat.css?v=1.5')}}">
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

    $('.m_btm_edit').click(function(e){

        var id = $(this).attr('data-id');
        $('form[data-id="u_contact_form_'+id+'"]').slideToggle();
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

    $('.m_btm_right_icons .m_btn_calendar').click(function(e){

        var id = $(this).attr('data-id');
        $('div[data-id="u-calendar-'+id+'"]').slideToggle(() => {

            var calendarEl = document.getElementById('calendar-'+id);
            var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    initialDate: '2023-07-07',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    events: [
      {
        title: 'All Day Event',
        start: '2023-07-01'
      },
      {
        title: 'Long Event',
        start: '2023-07-07',
        end: '2023-07-10'
      },
      {
        groupId: '999',
        title: 'Repeating Event',
        start: '2023-07-09T16:00:00'
      },
      {
        groupId: '999',
        title: 'Repeating Event',
        start: '2023-07-16T16:00:00'
      },
      {
        title: 'Conference',
        start: '2023-07-11',
        end: '2023-07-13'
      },
      {
        title: 'Meeting',
        start: '2023-07-12T10:30:00',
        end: '2023-07-12T12:30:00'
      },
      {
        title: 'Lunch',
        start: '2023-07-12T12:00:00'
      },
      {
        title: 'Meeting',
        start: '2023-07-12T14:30:00'
      },
      {
        title: 'Birthday Party',
        start: '2023-07-13T07:00:00'
      },
      {
        title: 'Click for Google',
        url: 'https://google.com/',
        start: '2023-07-28'
      }
    ]
  });
            calendar.render();
        });
    });


</script>
