
<div class="pb-12 mt-12 space-y-10 divide-y divide-gray-900/10 contact-edit-container">
    <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3 contact-edit-section">
        <div class="relative px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Edit contact</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 contact-edit-section-comp">You can edit your contact's basic information</p>
            <span class="absolute top-0 right-0 rounded-full p-3 text-center bg-white minw-[25px] h-[25p] flex items-center justify-center cursor-pointer contact-edit-nav">
                <i class="fa fa-chevron-down"></i>
            </span>
        </div>

        <form action="{{route('agent.contact.update')}}" method="POST" class="contact-edit-section-right bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 !m-0">
            {{ csrf_field() }}
            <input type="hidden" name="edit" value="{{$contact->id}}">
            <input type="hidden" name="send_email" value="0">
            <div class="px-4 py-6 sm:p-8">
                <div class="pro_stream_input_outer">
                    <div class="pro_stream_input_row">
                        <div class="pro_stream_input_each">
                            <input value="{{$contact->contactUser->first_name}}" placeholder="First Name" type="text" class="pro_stream_input" name="pro_contact_name" />
                        </div>
                        <div class="pro_stream_input_each">
                            <input value="{{$contact->contactUser->surname}}" placeholder="Last Name" type="text" class="pro_stream_input" name="pro_contact_last_name" />
                        </div>
                    </div>
                    <div class="pro_stream_input_each">
                        <input {{$contact->approved || $contact->is_already_user ? 'readonly' : ''}} value="{{$contact->email}}" placeholder="Email" type="text" class="pro_stream_input" name="pro_contact_email">
                    </div>
                    <div class="pro_stream_input_row">
                        <div class="pro_stream_input_each">
                            <div class="stream_sec_opt_outer">
                                <select name="pro_contact_skill">
                                    <option value="">Choose a skill</option>
                                    @foreach($skills as $skill)
                                    <option {{$contact->contactUser->skills == $skill->value ? 'selected' : ''}} value="{{$skill->value}}">{{$skill->value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pro_stream_input_each">
                            <input value="{{$contact->contactUser->contact_number}}" placeholder="Phone number" type="text" class="pro_stream_input" name="pro_contact_phone" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                <button type="button" class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm edit_now hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3 contact-edit-section">
        <div class="relative px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Join me on 1Platform App!</h2>
            <div class="contact-edit-section-comp pro_music_search pro_music_info no_border">
                <div class="pro_note">
                    <ul>
                        <li>Here you can send your contact an approval to be one of the your contacts in your network</li>
                        <li>
                            If you want to recieve commission from work connected with your contact then add the percentage here.
                            This commission is paid to you from any sales you create in a network chat only not from the user's own account.
                            Refer to <span class="text-blue-500 cursor-pointer join_me_video_btn hover:underline">this video</span> for further details
                        </li>
                        <li class="flex flex-col gap-2 p-2 border join_me_video_holder instant_hide">
                            <div class="ml-auto text-lg cursor-pointer join_me_close_btn">
                                <i class="fa fa-times"></i>
                            </div>
                            <div class="inner"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <span class="absolute top-0 right-0 rounded-full p-3 text-center bg-white minw-[25px] h-[25p] flex items-center justify-center cursor-pointer contact-edit-nav">
                <i class="fa fa-chevron-down"></i>
            </span>
        </div>

        <form action="{{route('agent.contact.update')}}" method="POST" class="bg-white shadow-sm contact-edit-section-right ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            {{ csrf_field() }}
            <input type="hidden" name="edit" value="{{$contact->id}}">
            <input type="hidden" name="send_email" value="0">
            <div class="px-4 py-6 sm:p-8">
                <div class="pro_stream_input_outer">
                    <div class="mb-1 font-medium text-gray-500 text-md">Add commision percentage (optional, leave blank if does not apply)</div>
                    <div class="pro_stream_input_each">
                        <input data-has-terms="{{ $contact->terms && $contact->terms != '' ? '1' : '0' }}" {{ $contact->approved ? 'disabled' : ''}} value="{{$contact->commission}}" placeholder="Your Commission (in %age)" type="number" class="pro_stream_input pro_contact_commission" name="pro_contact_commission" />
                    </div>
                    <div class="mt-2 mb-1 font-medium text-gray-500 text-md">Add your terms and conditions</div>
                    <div class="pro_stream_input_each">
                    <textarea type="text" class="pro_contact_textarea" name="pro_contact_terms">@if($contact->terms && $contact->terms != ''){{ $contact->terms }}@elseif(!$contact->approved) Hi

Hope you are doing well! I wanted to invite you to connect with me on the 1Platform App. It is a cool tool that makes networking easy.

If there is ever a project or anything where I think we could team up, you will get a heads-up through notifications. We can also chat right there in the app.

Once you are in, you can set up your account and use all the features for your career stuff.

Excited to have you on board!  @endif</textarea>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                @if(!$contact->approved)
                <button type="button" class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm edit_with_action edit_and_send_agree hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Send to contact</button>
                @endif
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3 contact-edit-section">
        <div class="relative px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Creative Briefs</h2>
            <div class="contact-edit-section-comp pro_music_search pro_music_info no_border">
                <div class="pro_note">
                    <ul>
                        <li>Share ideas, ask questions and collaborate seamlessly with your contacts.</li>
                        <li>We've included ready-made professional briefs to make your creative journey smoother. Join us for a simple and effective collaboration experience</li>
                        <li>Check your dashboard for a list of all our creative briefs</li>
                    </ul>
                </div>
            </div>
            <span class="absolute top-0 right-0 rounded-full p-3 text-center bg-white minw-[25px] h-[25p] flex items-center justify-center cursor-pointer contact-edit-nav">
                <i class="fa fa-chevron-down"></i>
            </span>
        </div>

        <form action="{{route('agent.contact.update')}}" method="POST" class="bg-white shadow-sm contact-edit-section-right ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            {{ csrf_field() }}
            <input type="hidden" name="edit" value="{{$contact->id}}">
            <input type="hidden" name="send_email" value="0">
            <div class="px-4 py-6 sm:p-8">
                <div class="pro_stream_input_each">
                    <div class="stream_sec_opt_outer">
                        <select name="pro_contact_questionnaireId">
                            <option value="">Choose questionnaire</option>
                            @if(count($user->questionnaires))
                                @foreach($user->questionnaires as $questionnaire)
                                <option {{$questionnaire->id == $contact->questionnaire_id ? 'selected' : ''}} value="{{$questionnaire->id}}">{{$questionnaire->brief->title}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                <button type="button" class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm edit_with_action edit_and_send_question hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Send brief to contact</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3 contact-edit-section">
        <div class="relative px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Manage your contact's account</h2>
            <div class="contact-edit-section-comp pro_music_search pro_music_info no_border">
                <div class="pro_note">
                    <ul>
                        <li>If you are a manager and want to manage your contact's account</li>
                        <li>Jointly oversee your shared contact's account</li>
                        <li>Give full control to your contact</li>
                    </ul>
                </div>
            </div>
            <span class="absolute top-0 right-0 rounded-full p-3 text-center bg-white minw-[25px] h-[25p] flex items-center justify-center cursor-pointer contact-edit-nav">
                <i class="fa fa-chevron-down"></i>
            </span>
        </div>

        <div class="overflow-hidden bg-gray-200 divide-y divide-gray-200 rounded-lg shadow contact-edit-section-right md:col-span-2 sm:grid sm:grid-cols-2 sm:gap-px sm:divide-y-0">
            @php $canSwitchAccount = !$contact->is_already_user || ($contact->is_already_user && $contact->approved) ? true : false @endphp
            <div class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none group relative bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 {{$canSwitchAccount ? 'm_btm_switch_account cursor-pointer' : 'opacity-60 cursor-not-allowed'}}" data-id="{{$canSwitchAccount ? route('agent.contact.switch.account',['code' => $contact->code]) : ''}}">
                <div>
                    <span class="inline-flex p-3 text-teal-700 rounded-lg bg-teal-50 ring-4 ring-white">
                        <svg class="w-6 h-6 text-black shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">
                        <div class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Edit User Home
                        </div>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">Login to your contact's account and manage the profile</p>
                </div>
            </div>
            @php $hasHomePage = $partnerUser->username ? true : false @endphp
            <div class="sm:rounded-tr-lg group relative bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 {{$hasHomePage ? 'cursor-pointer m_btm_navigate_contact_home' : 'cursor-not-allowed opacity-60'}}" data-id="{{$hasHomePage ? route('user.home',['params' => $partnerUser->username]) : ''}}">
                <div>
                    <span class="inline-flex p-3 text-purple-700 rounded-lg bg-purple-50 ring-4 ring-white">
                        <svg class="w-6 h-6 text-black shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                        </svg>
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">
                        <div class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Home Page
                        </div>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">Click to visit the home page of your contact</p>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="text" id="myInput" onchange="handleInputChange()">
<script>

    $('.join_me_video_btn').click(function(){
        $(this).closest('ul').find('.join_me_video_holder').removeClass('instant_hide').find('.inner').html('<iframe width="100%" height="315" src="https://www.youtube.com/embed/P8BcCrT6sxI"></iframe>');
    });

    $('.join_me_close_btn').click(function(){
        $(this).closest('.join_me_video_holder').addClass('instant_hide').find('.inner').html('');
    });

</script>
