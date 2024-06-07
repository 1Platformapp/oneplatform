<div class="pro_pg_tb_det" style="display: block">
    <div class="pro_pg_tb_det_inner">
        <div id="contacts_section" class="sub_cat_data">
            <div class="flex flex-row bg-[#333] text-white px-2">
                <div class="hidden pro_tray_title lg:flex main-tab-head">My Transactions</div>
				   <!-- <a href="https://wa.me/923356947187?text=I'm%20interested%20in%20your%20car%20for%20sale">Send</a> !-->
                <div class="flex flex-row items-center justify-between w-full gap-2 m_btn_right_icons lg:ml-auto lg:mr-4 text-main-icons lg:gap-8 lg:w-fit">
                    @if(!$user->is_buyer_only)
                    <div class="flex items-center justify-center flex-grow h-full py-2 pr-2 border-r border-gray-main-icons lg:pr-8">
                        <div title="Project List" class="m_btn_right_icon_each m_btn_management_plan active" data-id="management-plan" data-head="Project List">
                            <i class="fas fa-list-ul"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-center flex-grow h-full pr-2 border-r border-gray-main-icons lg:pr-8">
                        <a title="Contact Management" class="m_btn_right_icon_each m_btn_contact_management active" data-id="contact-management" data-head="Contact Management">
                            <i class="fas fa-users"></i>
                        </a>
                    </div>
                    @endif
                    <div class="flex items-center justify-center flex-grow h-full pr-2 border-r border-gray-main-icons lg:pr-8">
                        <a title="Calendar" class="m_btn_right_icon_each m_btn_calendarr active" data-id="my-calendar" data-head="My Calendar">
                            <i class="fa fa-calendar"></i>
                        </a>
                    </div>
                    @if(!$user->is_buyer_only)
                    <div class="flex items-center justify-center flex-grow h-full pr-2 border-r border-gray-main-icons lg:pr-8">
                        <a title="Questions" class="m_btn_right_icon_each m_btn_questionnaires active" data-id="my-questionnaires" data-head="Project Briefs">
                            <i class="far fa-question-circle"></i>
                        </a>
                    </div>
                    <div class="flex items-center justify-center flex-grow h-full pr-2 border-r border-gray-main-icons lg:pr-8">
                        <a title="Contracts" class="m_btn_right_icon_each m_btn_contracts active" data-id="my-contracts" data-head="My Contracts">
                            <i class="far fa-file-pdf"></i>
                        </a>
                    </div>
                    <div class="flex items-center justify-center flex-grow h-full pr-2 border-r border-gray-main-icons lg:pr-8">
                        <a title="Industry contacts" class="m_btn_right_icon_each {{$user->role_id == 1 ? 'm_btn_industry-contacts' : 'm_btn_ind_empty'}} active" data-id="industry-contacts" data-head="Industry Contacts">
                            <i class="fas fa-handshake"></i>
                        </a>
                    </div>
                    @else

                    @endif
                    <div class="flex items-center justify-center flex-grow h-full pr-2 border-r border-gray-main-icons lg:pr-8">
                        <a title="Chat" class="m_btn_right_icon_each m_btn_group_chat active" data-id="supporter-chat" data-head="Chat">
                            <i class="fa fa-comments"></i>
                        </a>
                    </div>
                    <div class="flex items-center justify-center flex-grow h-full pr-2 border-r border-gray-main-icons lg:pr-8">
                        <a title="Transactions" class="m_btn_right_icon_each m_btn_transactions active" data-id="my-transactions" data-head="My Transactions">
                            <i class="fas fa-dollar-sign"></i>
                        </a>
                    </div>
                    @if(!$user->is_buyer_only)
                    <div class="flex items-center justify-center flex-grow h-full border-r border-gray-main-icons lg:pr-8">
                        <a title="Edit profile" class="m_btn_right_icon_each m_btm_profile active" data-id="my-profile" data-head="My Profile">
                            <i class="fa fa-edit"></i>
                        </a>
                    </div>
                    @endif
                    <div class="flex items-center justify-center flex-grow h-full">
                        <a title="Chat with 1Platform admin" class="m_btn_right_icon_each m_btm_admin_chat active" data-id="admin-chat" data-head="Chat with Admin">
                            <img class="w-[20px]" id="admin-chat-icon" src="/public/icons/admin-chat.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
            @if($user->id != config('constants.admins')['1platformagent']['user_id'])
                @php $creativeBriefs = \App\Models\CreativeBrief::where('industry', $user->role_id)->get() @endphp
            @else
                @php $creativeBriefs = \App\Models\CreativeBrief::all() @endphp
            @endif
            @php $skills = \App\Models\Skill::where('user_role_id', $user->role_id)->get() @endphp
            @php $skill = $skills->first(function ($skill) use ($user) {
                return $skill->value == $user->skills;
            });@endphp
            <div class="">
                <div class="clearfix p-0 music_btm_list no_sorting">
                    <div class="md:hidden border-b border-[#ccc] pt-4 pb-2 font-bold main-tab-head">Project List</div>
                    <div class="edit_elem_bottom">
                        <div class="py-12 font-bold text-center loading instant_hide">...Loading please wait</div>
                        <div class="each_dash_section instant_hide" data-value="management-plan">
                            <div>
                                <div class="flex flex-col gap-4 mt-8">
                                    <div class="flex flex-col w-full gap-4">
                                        <div class="flex flex-row items-center justify-between w-full">
                                            <div id="management-plan-head" class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2">
                                                <div class="flex items-center px-6 py-5 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-gray-400">
                                                    <!--<div class="text-black">Listing tasks for &nbsp;</div>!-->
                                                    <select class="todo-select" data-skill-name="{{$skill ? $skill->value : ''}}" data-skill-id="{{$skill ? $skill->id : ''}}">
                                                        @foreach($skills as $skill)
                                                            <option value="{{$skill->id}}">{{$skill->value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="explainer-video-button flex px-6 py-5 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-gray-400">
                                                    <button class="w-full px-4 py-2 font-normal text-black project_list_video_btn">Watch Explainer Video</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-video-url="https://www.youtube.com/embed/PU1DIn6ObGk" class="explainer-video-well w-full bg-white md:col-span-2"></div>
                                    </div>

                                    <div class="border-t border-b border-gray-200">
                                        <nav class="flex -mb-px " aria-label="Tabs">
                                            <div data-stage="one" class="w-1/3 px-1 py-4 text-sm font-medium text-center text-indigo-600 border-b-2 border-indigo-500 cursor-pointer each-stage">Stage 1</div>
                                            <div data-stage="two" class="w-1/3 px-1 py-4 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent cursor-pointer hover:border-gray-300 hover:text-gray-700 each-stage">Stage 2</div>
                                            <div data-stage="three" class="w-1/3 px-1 py-4 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent cursor-pointer hover:border-gray-300 hover:text-gray-700 each-stage">Stage 3</div>
                                            <div data-stage="four" class="w-1/3 px-1 py-4 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent cursor-pointer hover:border-gray-300 hover:text-gray-700 each-stage">Stage 4</div>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <div class="management-plan-well"></div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="contact-management">
                            <div>
                                <div class="flex flex-col gap-4 mt-8">
                                    <div class="flex flex-col">
                                        <div id="contact-head" class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div class="explainer-video-button flex px-6 py-5 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-gray-400">
                                                <button class="w-full px-4 py-2 font-normal text-black project_list_video_btn">Watch Explainer Video</button>
                                            </div>
                                            <div data-video-url="https://www.youtube.com/embed/R_hE0_yKh7o" class="explainer-video-well w-full bg-white md:col-span-2"></div>
                                        </div>
                                    </div>
                                    <div class="border-t border-b border-gray-200">
                                        <nav class="flex -mb-px " aria-label="Tabs">
                                            <div data-stage="my-contacts" class="w-1/3 px-1 py-4 text-sm font-medium text-center text-indigo-600 border-b-2 border-indigo-500 cursor-pointer each-stage disabled">Contacts</div>
                                            <div data-stage="add-contact" class="w-1/3 px-1 py-4 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent cursor-pointer hover:border-gray-300 hover:text-gray-700 each-stage disabled">Add contact</div>
                                            <div data-stage="contact-requests" class="w-1/3 px-1 py-4 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent cursor-pointer hover:border-gray-300 hover:text-gray-700 each-stage disabled">Requests</div>
                                            <div data-stage="my-groups" class="w-1/3 px-1 py-4 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent cursor-pointer hover:border-gray-300 hover:text-gray-700 each-stage disabled">Groups</div>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-management-well"></div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="personal-chat">
                            <div class="personal-chat-well"></div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="supporter-chat">
                            <div class="supporter-chat-well"></div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="my-calendar">
                            <div>
                                <div id="calendar-head" class="flex flex-col gap-4 mt-8">
                                    <div class="flex flex-col">
                                        <div id="contact-head" class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div class="explainer-video-button flex px-6 py-5 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-gray-400">
                                                <button class="w-full px-4 py-2 font-normal text-black project_list_video_btn">Watch Explainer Video</button>
                                            </div>
                                            <div data-video-url="https://www.youtube.com/embed/gKKe8crFi6s" class="explainer-video-well w-full bg-white md:col-span-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-well"></div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="my-questionnaires">
                            <div>
                                <div id="briefs-head" class="flex flex-col gap-4 mt-8">
                                    <div class="flex flex-col gap-4">
                                        <div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div class="flex px-6 py-5 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-gray-400">
                                                <button class="w-full px-4 py-2 font-normal text-black open_contact_tab project_list_video_btn">Go to my network</button>
                                            </div>
                                            <div class="explainer-video-button flex px-6 py-5 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-gray-400">
                                                <button class="w-full px-4 py-2 font-normal text-black project_list_video_btn">Watch Explainer Video</button>
                                            </div>
                                        </div>
                                        <div class="pro_note">
                                            <ul>
                                                <li>Enable seamless collaboration by attaching project briefs easily for your contacts.</li>
                                                <li>Contacts receive personalized email alerts for efficient submission and instant updates upon completion.</li>
                                            </ul>
                                        </div>
                                        @if($user->id != config('constants.admins')['1platformagent']['user_id'])
                                        <div>
                                            <button id="reset-briefs-button" class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm edit_now hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                Reset Briefs
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                    <div data-video-url="https://www.youtube.com/embed/wnxlgkWyVn0" class="explainer-video-well w-full bg-white md:col-span-2"></div>
                                </div>
                                <div class="que-stages stage-one">
                                    <ul role="list" class="grid xs2:grid-cols-2 sm:grid-cols-4 gap-x-4">
                                        @foreach($creativeBriefs as $creativeBrief)
                                        <li data-brief-id="{{$creativeBrief->id}}" class="relative flex justify-between border-b border-gray-200 cursor-pointer questionnaire-skill gap-x-6 hover:bg-gray-200">
                                            <div class="flex items-center w-full px-4 py-4 text-sm leading-6 text-gray-900 gap-x-4">
                                                {{$creativeBrief->title}}
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="que-stages stage-two instant_hide">
                                    <div class="text-lg cursor-pointer que-stage-nav back">
                                        <i class="fas fa-arrow-left"></i>
                                    </div>
                                    <div class="content"></div>
                                </div>
                            </div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="my-contracts">
                            <div>
                                <div id="contracts-head" class="flex flex-col gap-4 mt-8 mb-4">
                                    <div class="flex flex-col gap-4">
                                        <div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div class="explainer-video-button flex px-6 py-5 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-gray-400">
                                                <button class="w-full px-4 py-2 font-normal text-black project_list_video_btn">Watch Explainer Video</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-video-url="https://www.youtube.com/embed/wnxlgkWyVn0" class="explainer-video-well w-full bg-white md:col-span-2"></div>
                                </div>
                                <p>
                                    Click <a href="#" id="toggleContracts" class="text-red-600">here</a> to see how contracts works.
                                </p>
                                <div id="how-contract-works" class="hidden">
                                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                                        <div class="relative flex items-center col-span-1 px-3 py-2 space-x-3 outline-none lg:px-6 lg:py-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">1.</div>
                                                    <div>Subscribe For legal Industry Contracts</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative flex items-center col-span-1 px-3 py-2 space-x-3 outline-none lg:px-6 lg:py-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">2.</div>
                                                    <div>Choose contact from <span class="open-contacts-section font-bold cursor-pointer text-[#fc064c]">here</span>, attach contract</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative flex items-center col-span-1 px-3 py-2 space-x-3 outline-none lg:px-6 lg:py-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">3.</div>
                                                    <div>Add details and requirements and submit</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative flex items-center col-span-1 px-3 py-2 space-x-3 outline-none lg:px-6 lg:py-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">4.</div>
                                                    <div>Contact will receive an email/app notification</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative flex items-center col-span-1 px-3 py-2 space-x-3 outline-none lg:px-6 lg:py-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">5.</div>
                                                    <div>They review and sign</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative flex items-center col-span-1 px-3 py-2 space-x-3 outline-none lg:px-6 lg:py-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">6.</div>
                                                    <div>Both parties receive legally binding digital copy</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($user->hasActivePaidSubscription())

                                @else
                                <div class="flex flex-col gap-4 mx-2 mt-4">
                                    <div class="border border-[#ccc] sm:rounded-lg">
                                        <div class="px-4 py-5 sm:p-6">
                                            <h3 class="text-base font-semibold leading-6 text-[#333]">Upgrade subscription</h3>
                                            <div class="mt-2 max-w-xl text-sm text-[#333]">
                                                <p>You are currently subscribed to a free plan. Upgrade your subscription to unlock this feature</p>
                                            </div>
                                            <div class="mt-5">
                                                <a type="button" href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}" class="inline-flex items-center bg-[#fc064c] rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm">
                                                    Click here
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form>
                                    <div class="px-2 py-4">
                                        <div class="flex items-center mb-3">
                                            <div class="flex-shrink-0 text-[#666] text-lg hidden lg:flex">
                                                <i class="fa fa-info-circle"></i>
                                            </div>
                                            <div class="flex-1 lg:ml-3 md:flex md:justify-between">
                                                <p class="text-sm text-[#333] font-bold">Previews for the contracts are available</p>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                                            @foreach(\App\Models\Contract::where('industry', $user->role_id)->get() as $contract)
                                            <div class="col-span-1 relative flex items-center space-x-3 rounded-lg border border-[#ccc] px-3 py-2 lg:px-6 lg:py-3 shadow-sm outline-none">
                                                <div class="flex-1 min-w-0">
                                                    <a target="blank" href="{{route('agency.contract.preview', ['id' => $contract->id])}}" class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                        <div>{{$contract->title}}</div>
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="industry-contacts">
                            @if($user->role_id == 1)
                            <div>
                                <div id="ind-contacts-head" class="flex flex-col gap-4 mt-8 mb-4">
                                    <div class="flex flex-col gap-4">
                                        <div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div class="explainer-video-button flex px-6 py-5 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-gray-400">
                                                <button class="w-full px-4 py-2 font-normal text-black project_list_video_btn">Watch Explainer Video</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-video-url="https://www.youtube.com/embed/vaV4znttkUE" class="explainer-video-well w-full bg-white md:col-span-2"></div>
                                </div>
                                @if($user->hasActivePaidSubscription())

                                @else
                                <div class="flex flex-col gap-4 mx-2 my-4">
                                    <div class="border border-[#ccc] sm:rounded-lg">
                                        <div class="px-4 py-5 sm:p-6">
                                            <h3 class="text-base font-semibold leading-6 text-[#333]">Upgrade subscription</h3>
                                            <div class="mt-2 text-sm text-[#333]">
                                                <p>You are currently subscribed to a free plan. The details of industry contacts will be masked. Upgrade your subscription to unlock this feature</p>
                                            </div>
                                            <div class="mt-5">
                                                <a type="button" href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}" class="inline-flex items-center bg-[#fc064c] rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm">
                                                    Click here
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="pro_form_title flex flex-col border border-[#ccc] rounded-lg px-3 py-2 lg:px-6 lg:py-3">
                                    <div class="flex items-start mb-3">
                                        <div class="flex-shrink-0 text-[#666] text-lg hidden lg:flex mt-1">
                                            <i class="fa fa-info-circle"></i>
                                        </div>
                                        <div class="flex-1 lg:ml-3 md:flex md:justify-between">
                                            <p class="text-sm text-[#333] font-bold">
                                            Discover over <span class="text-[#fc064c]">{{count(\App\Models\IndustryContact::all())}}</span> industry contacts on 1Platform
                                            including labels, publishers, pluggers, producers and skilled song writers. <br>Each contact is complete with phone numbers, websites
                                            and emails for seamless access and networking
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        @php
                                            $industryContactRegions = \App\Models\IndustryContactRegion::orderBy('id', 'asc')->get();
                                            $industryContactCategoryGroups = \App\Models\IndustryContactCategoryGroup::orderBy('id', 'asc')->get();
                                        @endphp
                                        <div class="flex flex-col py-8 mb-5 space-y-2 border-b border-gray-200 ind_con_search_outer md:space-y-0 md:flex-row md:items-center">
                                            <div class="flex flex-row items-center">
                                                <div class="inline-flex items-center w-1/2 overflow-hidden text-sm text-gray-900 rounded-md ind_con_search_by hover:bg-gray-50 focus-visible:outline-offset-0">
                                                    <select data-type="ind_cont_drop" id="ind_con_search_by_category">
                                                        <option value="">I'm Looking For:</option>
                                                        @foreach($industryContactCategoryGroups as $icCategoryGroup)
                                                        <optgroup label="{{$icCategoryGroup->name}}">
                                                            @if(count($icCategoryGroup->categories))
                                                                @foreach($icCategoryGroup->categories as $icCategory)
                                                                <option value="{{$icCategory->lookup_id}}">{{$icCategory->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="inline-flex items-center w-1/2 overflow-hidden text-sm text-gray-900 rounded-md ind_con_search_by hover:bg-gray-50 focus-visible:outline-offset-0 md:ml-5">
                                                    <select data-type="ind_cont_drop" id="ind_con_search_by_city">
                                                        <option value="">City/Region/Country</option>
                                                        <optgroup label="ANYWHERE FROM">
                                                            <option value="alluk">UK</option>
                                                            <option value="allusa">USA</option>
                                                            <option value="allcanada">Canada</option>
                                                        </optgroup>
                                                        @foreach($industryContactRegions as $icRegion)
                                                        <optgroup label="{{$icRegion->name.' ('.$icRegion->country->abbreviation.')'}}">
                                                        @if(count($icRegion->cities))
                                                            @foreach($icRegion->cities as $icCity)
                                                            <option value="{{$icCity->city_id}}">{{$icCity->name}}</option>
                                                            @endforeach
                                                        @endif
                                                        </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inline-flex items-center justify-center px-3 py-1 ml-auto text-sm text-gray-900 rounded-md cursor-pointer ind_con_search_submit ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0">Search</div>
                                            <div class="!mt-12 md:!mt-0 smart_switch_outer flex-1 switch_industry_contacts md:ml-auto">
                                                <div class="smart_switch_txt">Show Favourite Only</div>
                                                <label class="smart_switch">
                                                    <input type="checkbox" />
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mt-5 industry-contacts-well">
                                            <div class="mt-10 text-center text-md">...Loading</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <p class="text-sm text-[#333] font-bold" style="padding: 20px 0; text-align:center">This section is under construction. Come back later</p>
                            @endif
                        </div>
                        <div class="mt-10 each_dash_section instant_hide" data-value="my-transactions">
                            <div data-video-url="https://www.youtube.com/embed/wnxlgkWyVn0" class="explainer-video-well w-full bg-white md:col-span-2 mb-4"></div>
                            <div class="order-stages stage-one">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class=" explainer-video-button relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm cursor-pointer focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-video"></i>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Watch Explainer Video</p>
                                    </div>
                                    <div data-id="financial-summary" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Financial Summary</p>
                                                <p class="text-sm text-gray-500 truncate">Summary of all of your sales, purchases, subscriptions and crowdfunding</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-subscription-plan" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Subscription Plan</p>
                                                <p class="text-sm text-gray-500 truncate">Your active subscription and payments made towards it</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-purchases" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fa fa-dollar-sign"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Purchases</p>
                                                <p class="text-sm text-gray-500 truncate">All your purchases made from 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!$user->is_buyer_only)
                                    <div data-id="my-sales" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Sales</p>
                                                <p class="text-sm text-gray-500 truncate">All your sales made through 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div data-id="my-premium-videos" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Premium Videos</p>
                                                <p class="text-sm text-gray-500 truncate">Watch premium videos unlocked through your purchases</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-subscriptions" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Subscriptions</p>
                                                <p class="text-sm text-gray-500 truncate">View who you are currently subscribed to at 1Platform</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div data-id="my-crowdfund-purchases" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Crowdfund Purchases</p>
                                                <p class="text-sm text-gray-500 truncate">All your crowdfunding project purchases made from 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!$user->is_buyer_only)
                                    <div data-id="my-crowdfund-sales" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Crowdfund Sales</p>
                                                <p class="text-sm text-gray-500 truncate">All your crowdfunding project sales made through 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-subscribers-donators" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-hand-holding-heart"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Subscribers and Donators</p>
                                                <p class="text-sm text-gray-500 truncate">All your subscribers and donators at 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-patron-hub" class="relative flex items-center px-6 py-5 space-x-3 bg-transparent border border-gray-300 rounded-lg shadow-sm order-stage-head focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-hand-holding-heart"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="cursor-pointer focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Patron Hub</p>
                                                <p class="text-sm text-gray-500 truncate">Setup a patron option that anyone can use to support you</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="order-stages stage-two instant_hide">
                                <div class="text-lg cursor-pointer order-stage-nav back">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                                <div class="content max-h-[800px] overflow-y-auto overflow-x-hidden"></div>
                            </div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="my-profile">
                            <div>
                                <div class="mt-5">
                                    <div class="">
                                        <div class="py-5">
                                            <div class="max-w-full mt-2 text-gray-500 text-md">
                                                <p class="font-bold">Access the 1Platform Wizard to simplify your tasks effortlessly</p>
                                                <p>Accomplish various goals: website creation, portfolio development, product listings, music projects, crowdfunding, setup Stripe, domain connection, music licensing and so much more</p>
                                            </div>
                                            <div class="mt-6 text-sm leading-6">
                                                <a href="{{route('profile.setup', ['page' => 'welcome'])}}" class="font-semibold text-white bg-[#fc064c] px-2 py-2 rounded-md">
                                                    Access
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="admin-chat">
                            <div class="admin-chat-well"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{asset('css/profile.chat.css?v=1.20')}}">
<link rel="stylesheet" href="{{asset('select2/select2.min.css')}}"></link>
<script src="{{ asset('select2/select2.min.js') }}"></script>
<style>

    .m_btn_right_icon_each.real-active { color: lightgreen; }

</style>
<script>

    const element = document.getElementById('toggleContracts')
    if (element) {
        document.getElementById('toggleContracts').addEventListener('click', function(event) {
            event.preventDefault();
            var toggleContent = document.getElementById('how-contract-works');
            if (toggleContent.classList.contains('hidden')) {
                toggleContent.classList.remove('hidden');
            } else {
                toggleContent.classList.add('hidden');
            }
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var defaultSubTab = '';

    $('document').ready(function (){

        const defaultTab = $('#default-dash-tab').val();
        defaultSubTab = $('#default-dash-sub-tab').val();
        const dashboardInfo = $('#dash-info').val();
        const activeTab = defaultTab != '' ? defaultTab : localStorage.getItem('dash-tab-active');

        if (dashboardInfo !== null && dashboardInfo !== '' ) {
            $('.hrd_usr_men_outer').toggleClass('active');
            $('body').toggleClass('lock_page');
            $('#body-overlay').toggle();
        }
        if (activeTab !== null && activeTab != '') {
            $('.m_btn_right_icon_each[data-id="'+activeTab+'"]').trigger('click');
            if (defaultSubTab == 'groups') {
                var element = $('body').find('.each-stage[data-stage="my-groups"]');
                element.removeClass('disabled').trigger('click');
            } else if (defaultSubTab == 'supporters') {
                var element = $('body').find('.each-stage[data-stage="my-supporters"]');
                element.removeClass('disabled').trigger('click');
            } else {
                $('.order-stage-head[data-id="'+defaultSubTab+'"]').trigger('click');
            }
        } else {
            $('.m_btn_management_plan').trigger('click');
        }

        // render me page content

        const mePage = $('#me-page').val();
        if (mePage == 'notifications') {
            $('.hrd_notif_outer').toggleClass('active');
            $('body').toggleClass('lock_page');
            $('#body-overlay').toggle();
        } else if (mePage == 'cart') {
            $('.hrd_cart_outer').toggleClass('active');
            $('body').toggleClass('lock_page');
            $('#body-overlay').toggle();
        }
    });

    const select2Todo = $('select.todo-select').select2();
    let user_skill_id = $('select.todo-select').attr('data-skill-id');
    let user_skill_name = $('select.todo-select').attr('data-skill-name');

    $('body').delegate('.each-task .each-task-det-nav .nav', "click", function(e){
        e.stopPropagation();
    });

    $('body').delegate('.explainer-video-button', 'click', function(e){

        const parent = $(this).closest('.each_dash_section');
        const well = parent.find('.explainer-video-well');

        if (well.html() == '') {
            const iframe = $('<iframe>', {
                class: 'w-full h-full',
                allowfullscreen: 'allowfullscreen',
                mozallowfullscreen: 'mozallowfullscreen',
                msallowfullscreen: 'msallowfullscreen',
                oallowfullscreen: 'oallowfullscreen',
                webkitallowfullscreen: 'webkitallowfullscreen',
                src: well.attr('data-video-url')
            });
            const iframeContainer = $('<div>', {
                class: 'iframe-container'
            });
            iframeContainer.append(iframe);
            well.html(iframeContainer).prepend('<div class="iframe-overlay"></div>');
        } else {
            well.html('');
        }
    });

    $('body').delegate('.each-task .each-task-det-nav', 'click', function(e){

        var plan = $(this).closest('.each-task');
        var target = plan.find('.each-task-det');
        $('.each-task-det').not(target).addClass('instant_hide');
        target.toggleClass('instant_hide');
    });

    $('body').delegate('.each-stage:not(.disabled)', 'click', function(e){
        var stage = $(this).attr('data-stage');
        var target = $('.each-stage-det[data-stage-ref="'+stage+'"]');

        $('.each-stage').not($(this)).addClass('border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700').removeClass('border-indigo-500 text-indigo-600');
        $(this).addClass('border-indigo-500 text-indigo-600').removeClass('border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700');

        $('.each-stage-det').not(target).addClass('instant_hide');
        target.removeClass('instant_hide');
    });

    $('.open_contact_tab').click(function(){
        $('.m_btn_right_icon_each.m_btn_contact_management').click();
    });

    $('.brief_close_btn').click(function(){
        $(this).closest('.brief_video_holder').addClass('instant_hide').find('.inner').html('');
    });

    $('body').delegate('#reset-briefs-button', 'click', function(e){

        if (confirm('Are you sure? You cannot undo this action')) {

            $.ajax({

                url: '/agent/reset-questionnaires',
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    $('.notification .icon').addClass('instant_hide');
                    if (response.success) {
                        $('.notification .success').removeClass('instant_hide');
                        $('.notification .notification-title').text('Success');
                        $('.notification .notification-body').text('Your response has been saved');
                    }else {
                        $('.notification .icon.error').removeClass('instant_hide');
                        $('.notification .notification-title').text('Error');
                        $('.notification .notification-body').text(response.error);
                    }
                    $('.notification').removeClass('hidden');
                }
            });
        }
    });

    $('body').delegate('.each-stage-det .notes-submit', 'click', function(e){

        var parent = $(this).closest('.each-stage-det');
        var stageId = parent.attr('data-id');
        var taskId = $(this).closest('.each-task').attr('data-task');
        var notes = $(this).closest('.each-task').find('.notes').first().val();

        if(notes.length){

            var formData = new FormData();
            formData.append('type', 'notes');
            formData.append('stage', stageId);
            formData.append('task', taskId);
            formData.append('data', notes);

            $.ajax({

                url: '/management-plan/submit',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {

                    $('.notification .icon').addClass('instant_hide');
                    if (response.success) {
                        $('.notification .success').removeClass('instant_hide');
                        $('.notification .notification-title').text('Success');
                        $('.notification .notification-body').text('Your response has been saved');
                    }else {
                        $('.notification .icon.error').removeClass('instant_hide');
                        $('.notification .notification-title').text('Error');
                        $('.notification .notification-body').text(response.error);
                    }
                    $('.notification').removeClass('hidden');
                }
            });
        }
    });

    $('body').delegate('.each-stage-det .status-submit', 'click', function(e){

        var thiss = $(this);
        var parent = thiss.closest('.each-stage-det');
        var stageId = parent.attr('data-id');
        var taskId = thiss.closest('.each-task').attr('data-task');

        var formData = new FormData();
        formData.append('type', 'status');
        formData.append('stage', stageId);
        formData.append('task', taskId);
        formData.append('data', thiss.attr('data-status'));

        $.ajax({

            url: '/management-plan/submit',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {

                $('.notification .icon').addClass('instant_hide');
                if (response.success) {
                    thiss.attr('data-status', response.value);
                    thiss.find('i').attr("class", function(index, existingClasses) {
                        return response.icon;
                    });
                }else {
                    $('.notification .icon.error').removeClass('instant_hide');
                    $('.notification .notification-title').text('Error');
                    $('.notification .notification-body').text(response.error);
                    $('.notification').removeClass('hidden');
                }
            }
        });
    });

    $('body').delegate('.ind_con_each_action.details', 'click', function(e){

        var find = $(this).closest('.ind_con_each_outer').attr('data-id');
        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'industry_contact_details', 'find': find, 'identity_type': 'guest', 'identity': ''},
            success: function(response) {
                if(response.success == 1){

                    $('.ind_con_details_popup .pro_pop_ind_con_each').addClass('instant_hide').find('.item_name').text('');
                    $('.ind_con_details_popup .pro_pop_head').text('').addClass('instant_hide');

                    if(response.data.name != ''){
                        $('.ind_con_details_popup .pro_pop_head').text(response.data.name).removeClass('instant_hide');
                    }
                    if(response.data.address != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="address"] .item_name').text(response.data.address);
                    }
                    if(response.data.email != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="email"]').removeClass('instant_hide').find('.item_name').text(response.data.email);
                    }
                    if(response.data.phone != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="phone"]').removeClass('instant_hide').find('.item_name').text(response.data.phone);
                    }
                    if(response.data.website != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="website"]').removeClass('instant_hide').find('.item_name').html(response.data.website);
                    }
                    if(response.data.facebook != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="facebook"]').removeClass('instant_hide').find('.item_name').html(response.data.facebook);
                    }
                    if(response.data.twitter != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="twitter"]').removeClass('instant_hide').find('.item_name').html(response.data.twitter);
                    }
                    if(response.data.instagram != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="instagram"]').removeClass('instant_hide').find('.item_name').html(response.data.instagram);
                    }
                    if(response.data.youtube != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="youtube"]').removeClass('instant_hide').find('.item_name').html(response.data.youtube);
                    }
                    if(response.data.soundcloud != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="soundcloud"]').removeClass('instant_hide').find('.item_name').html(response.data.soundcloud).removeClass('instant_hide');
                    }
                    if(response.data.information != ''){
                        $('.ind_con_details_popup .pro_pop_ind_con_each[data-type="information"]').removeClass('instant_hide').find('.item_name').html(response.data.information);
                    }

                    $('.ind_con_details_popup, #body-overlay').show();
                }else{
                    alert(response.error);
                }
            }
        });
    });

    $('body').delegate('.ind_con_each_action.favourites:not(.disabled)', 'click', function(e){

        var thiss = $(this);
        thiss.addClass('disabled');
        var id = thiss.closest('.ind_con_each_outer').attr('data-id');

        $.ajax({

            url: "/toggle-ind-con-fav",
            dataType: "json",
            type: 'post',
            data: {'id': id},
            success: function(response) {
                if(response.success == 1){

                    if(response.action == 'removed'){
                        thiss.removeClass('added').find('span').text(' Add to Favourites');
                        thiss.find('i').removeClass('fas').addClass('far');
                    }else{
                        thiss.addClass('added').find('span').text(' Added to Favourites');
                        thiss.find('i').removeClass('far').addClass('fas');
                    }
                }else{
                    alert(response.error);
                }
            },
            complete: function(response){
                thiss.removeClass('disabled');
            }
        });
    });

    $('.m_btn_ind_empty').click(function(e){

        $('.each_dash_section').addClass('instant_hide');
        $('.each_dash_section[data-value="industry-contacts"').removeClass('instant_hide');
    });

    $('.m_btn_management_plan, .m_btn_contact_management, .m_btn_calendarr, .m_btn_group_chat, .m_btn_industry-contacts, .m_btm_admin_chat, .m_btn_personal_chat, .m_btn_transactions, .m_btn_questionnaires, .m_btn_contracts, .m_btm_profile').click(function(e){

        var id = $(this).attr('data-id');
        var heading = $(this).attr('data-head');
        $('.main-tab-head').text(heading);
        localStorage.setItem('dash-tab-active', id);

        $('.each_dash_section:not(.each_dash_section[data-value="'+id+'"])').addClass('instant_hide');
        $('.each_dash_section[data-value="'+id+'"]').toggleClass('instant_hide');

        $('.m_btn_right_icon_each').removeClass('real-active');
        $(this).addClass('real-active');

        if ($(this).hasClass('m_btn_industry-contacts')) {

            if (!$('.each_dash_section[data-value="'+id+'"]').hasClass('instant_hide')) {
                $('.loading').removeClass('instant_hide');
                getIndustryContacts('');
            } else {
                $('.industry-contacts-well').html('');
            }
        }

        if ($(this).hasClass('m_btn_management_plan')) {

            if (!$('.each_dash_section[data-value="'+id+'"]').hasClass('instant_hide')) {
                $('.loading').removeClass('instant_hide');
                getManagementPlan(user_skill_name);
                select2Todo.val(user_skill_id).trigger('change');
            } else {
                $('.management-plan-well').html('');
            }
        }

        if ($(this).hasClass('m_btn_contact_management')) {

            if (!$('.each_dash_section[data-value="'+id+'"]').hasClass('instant_hide')) {
                $('.loading').removeClass('instant_hide');
                getContactManagement(defaultSubTab);
            } else {
                $('.contact-management-well').html('');
                $('.each_dash_section[data-value="contact-management"] .each-stage').first().trigger('click');
                $('.each_dash_section[data-value="contact-management"] .each-stage').addClass('disabled');
            }
        }

        if ($(this).hasClass('m_btn_group_chat')) {

            if (!$('.each_dash_section[data-value="'+id+'"]').hasClass('instant_hide')) {
                $('.loading').removeClass('instant_hide');
                getGroupChat();
            } else {
                $('.supporter-well').html('');
            }
        }

        if ($(this).hasClass('m_btm_admin_chat')) {

            $('#admin-chat-icon').attr('src', '/public/icons/admin-chat-active.svg');
            getAdminChat();
        } else {
            $('#admin-chat-icon').attr('src', '/public/icons/admin-chat.svg');
        }

        if($(this).hasClass('m_btn_calendarr')){

            if (!$('.each_dash_section[data-value="'+id+'"]').hasClass('instant_hide')) {
                $('.loading').removeClass('instant_hide');
                getCalendar();
            } else {
                $('.calendar-well').html('');
            }
        }

        if($(this).hasClass('m_btn_transactions')){

            $('.order-stages.stage-one').removeClass('instant_hide');
            $('.order-stages.stage-two').addClass('instant_hide');
        }

        if($(this).hasClass('m_btn_personal_chat')){

            if (!$('.each_dash_section[data-value="'+id+'"]').hasClass('instant_hide')) {
                $('.loading').removeClass('instant_hide');
                getPersonalChat();
            } else {
                $('.personal-chat-well').html('');
            }
        }
    });

    $('body').delegate('.open-contacts-section', 'click', function(e){
        $('.m_btn_contact_management').trigger('click');
    });

    $('body').delegate('.ind_con_each_nav:not(.disabled),.ind_con_search_submit', 'click', function(e){

        if($(this).hasClass('ind_con_each_nav')){
            var page = $(this).attr('data-key');
            $(this).addClass('disabled');
        }else{
            var page = '';
        }

        var category = $('#ind_con_search_by_category').val();
        var city = $('#ind_con_search_by_city').val();
        var find = category+'_'+city+'_'+page;

        getIndustryContacts(find);
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

    $('body').delegate('.todo-select', 'change', function(){
        var skill = $(this).find(':selected').text();
        localStorage.setItem('todo-skill-text', skill);
        localStorage.setItem('todo-skill-value', $(this).val());
        getManagementPlan(skill);
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

    $('.switch_industry_contacts .smart_switch input').change(function(){

        if($(this).prop("checked") == true){

            getIndustryContacts('___1');
        }else{

            getIndustryContacts('');
        }
    });

    $('.que-stage-nav').click(function(){

        if($(this).hasClass('back')){
            $('.que-stages.stage-one').removeClass('instant_hide');
            $('.que-stages.stage-two').addClass('instant_hide');
        }
    });

    $('.order-stage-nav').click(function(){

        if($(this).hasClass('back')){
            $('.order-stages.stage-one').removeClass('instant_hide');
            $('.order-stages.stage-two').addClass('instant_hide');
        }
    });

    $('.questionnaire-skill').click(function(){
//comehere
        var brief_id = $(this).attr('data-brief-id');
        var formData = new FormData();
        formData.append('brief_id', brief_id);
        $.ajax({
            url: '/agent/get-questionnaire',
            type: 'POST',
            data: formData,
            contentType:false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if(response.success){
                    $('.que-stages.stage-one').addClass('instant_hide');
                    $('.que-stages.stage-two').removeClass('instant_hide').find('.content').html(response.data);
                }else{
                    console.log(response.error);
                }
            }
        });
    });

    $('.order-stage-head').click(function(){

        var id = $(this).attr('data-id');

        //id = defaultSubTab == '' ? id : defaultSubTab;

        if (id == 'my-patron-hub') {
            window.location.href = '/profile-setup/standalone/setup-patron'
        } else {
            var formData = new FormData();
            formData.append('id', id);
            $.ajax({

                url: '/agent/monies',
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if(response.success){
                        $('.order-stages.stage-one').addClass('instant_hide');
                        $('.order-stages.stage-two').removeClass('instant_hide').find('.content').html(response.data);
                    }else{
                        console.log(response.error);
                    }
                }
            });
        }
    });

    async function setSession(tab){
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "/dashboard/set-session/" + tab,
                dataType: "json",
                type: 'post',
                data: {},
                success: function(response) {
                    resolve(true);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function getManagementPlan(skill = ''){

        $('#management-plan-head').addClass('instant_hide');
        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'management-plan', 'find': skill, 'identity_type': 'subscriber', 'identity': ''},
            success: function(response) {

                removeLoading();
                $('#management-plan-head').removeClass('instant_hide');
                if(response.success == 1){
                    $('.management-plan-well').html(response.data.data);
                }else{
                    console.log(data.error);
                    $('.management-plan-well').html(data.error);
                }
            }
        });
    }

    function getPersonalChat(){

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'personal-chat', 'find': '', 'identity_type': 'self', 'identity': ''},
            success: function(response) {

                removeLoading();
                if(response.success == 1){
                    $('.personal-chat-well').html(response.data.data);
                }else{
                    console.log(data.error);
                    $('.personal-chat-well').html(data.error);
                }
            }
        });
    }

    function getContactManagement(defaultSubTab){

        $('#contact-head').addClass('instant_hide');
        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'contact-management', 'find': defaultSubTab, 'identity_type': 'subscriber', 'identity': ''},
            success: function(response) {

                removeLoading();
                $('#contact-head').removeClass('instant_hide');
                if(response.success == 1){
                    $('.contact-management-well').html(response.data.data);
                    $('.each_dash_section[data-value="contact-management"] .each-stage').removeClass('disabled');
                }else{
                    console.log(data.error);
                    $('.contact-management-well').html(data.error);
                }
            }
        });
    }

    function getGroupChat(){

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'supporter-chat', 'find': '', 'identity_type': 'subscriber', 'identity': ''},
            success: function(response) {

                removeLoading();
                if(response.success == 1){
                    $('.supporter-chat-well').html(response.data.data);
                }else{
                    console.log(data.error);
                    $('.supporter-chat-well').html(data.error);
                }
            }
        });
    }

    function getAdminChat(){

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'admin-chat', 'find': '', 'identity_type': 'auth_user', 'identity': 'self'},
            success: function(response) {

                if(response.success == 1){
                    $('.admin-chat-well').html(response.data.data);
                }else{
                    console.log(data.error);
                    $('.admin-chat-well').html(data.error);
                }
            }
        });
    }

    function getCalendar(){

        $('#calendar-head').addClass('instant_hide');
        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'my-calendar', 'find': '', 'identity_type': 'subscriber', 'identity': ''},
            success: function(response) {

                removeLoading();
                $('#calendar-head').removeClass('instant_hide');
                if(response.success == 1){
                    $('.calendar-well').html(response.data.data);
                    $('.each_dash_section[data-value="my-calendar"]').removeClass('instant_hide');
                }else{
                    console.log(data.error);
                    $('.calendar-well').html(data.error);
                }
            }
        });
    }

    function getIndustryContacts(find){

        $('#ind-contacts-head').addClass('instant_hide');
        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'industry_contacts', 'find': find, 'identity_type': 'guest', 'identity': ''},
            success: function(response) {

                removeLoading();
                $('#ind-contacts-head').removeClass('instant_hide');
                if(response.success == 1){
                    $('.industry-contacts-well').html(response.data.data);
                    $('select[data-type="ind_cont_drop"]').select2();
                    if(response.data.total_records == 0){
                        $('.industry-contacts-well').html('<div class="mt-10 text-center">No records found</div>');
                    }
                    $('.ind_con_count').text(response.data.total_records);
                }else{
                    console.log(data.error);
                    $('.industry-contacts-well').html(data.error);
                }
            },
            complete: function(response){
                $(this).removeClass('disabled');
            }
        });
    }

    function removeLoading () {
        $('.loading').addClass('instant_hide');
    }
</script>

<style>
    .select2.select2-container.select2-container--default { width: 100% !important; }
    .iframe-overlay { height: 100px; width: 100%; z-index: 9999999999; }
    .explainer-video-well iframe { height: 400px }
    @media (min-width:320px) and (max-width: 767px) {
        .explainer-video-well iframe { height: 280px }
    }
</style>
