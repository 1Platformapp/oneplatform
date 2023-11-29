<div class="pro_pg_tb_det" style="display: block">
    <div class="pro_pg_tb_det_inner">
        <div id="contacts_section" class="sub_cat_data">
            <div class="flex flex-row bg-[#666] text-white">
                <div class="pro_tray_title">{{$isAgent ? 'Agency' : ''}} Dashboard</div>
				   <!-- <a href="https://wa.me/923356947187?text=I'm%20interested%20in%20your%20car%20for%20sale">Send</a> !-->
            </div>
            @php $userPDetails = $commonMethods->getUserRealDetails($user->id) @endphp
            @php $skills = \App\Models\Skill::all() @endphp
            <div class="">
                <div class="music_btm_list no_sorting clearfix">
                    <div class="edit_elem_top">
                        <div class="m_btm_list_left">
                            <div class="music_btm_thumb">
                                <img src="{{$userPDetails['image']}}" />
                            </div>
                            <ul class="music_btm_img_det">
                                <li>
                                    <a class="filter_search_target" href="">
                                        {{$user->name}}
                                    </a>
                                </li>
                                <li>
                                    <p>
                                    {{$userPDetails['city'] != '' ? $userPDetails['city'] : ''}}
                                    {{$userPDetails['skills'] != '' ? ' - '.$userPDetails['skills'] : ''}}
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="m_btm_right_icons">
                            <ul>
                                <li>
                                    <a title="Management Plan" class="m_btn_right_icon_each m_btn_management_plan active" data-id="management-plan">
                                        <i class="fas fa-list-ul"></i>
                                    </a>
                                </li>
                                <li>
                                    <a title="Contact Management" class="m_btn_right_icon_each m_btn_contact_management active" data-id="contact-management">
                                        <i class="fas fa-users"></i>
                                    </a>
                                </li>
                                <li>
                                    <a title="Calendar" class="m_btn_right_icon_each m_btn_calendarr active" data-id="my-calendar">
                                        <i class="fa fa-calendar"></i>
                                    </a>
                                </li>
                                <li>
                                    <a title="Questions" class="m_btn_right_icon_each m_btn_questionnaires active" data-id="my-questionnaires">
                                        <i class="far fa-question-circle"></i>
                                    </a>
                                </li>
                                <li>
                                    <a title="Contracts" class="m_btn_right_icon_each m_btn_contracts active" data-id="my-contracts">
                                        <i class="far fa-file-pdf"></i>
                                    </a>
                                </li>
                                <li>
                                    <a title="Industry contacts" class="m_btn_right_icon_each m_btn_industry-contacts active" data-id="my-industry-contacts">
                                        <i class="fas fa-handshake"></i>
                                    </a>
                                </li>
                                <li>
                                    <a title="Transactions" class="m_btn_right_icon_each m_btn_transactions active" data-id="my-transactions">
                                        <i class="fas fa-dollar-sign"></i>
                                    </a>
                                </li>
                                <li>
                                    <a title="Edit profile" title="Edit Profile" class="m_btn_right_icon_each m_btm_profile active" data-id="my-profile">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="edit_elem_bottom">
                        <div class="loading text-center py-12 font-bold instant_hide">...Loading please wait</div>
                        <div class="each_dash_section instant_hide" data-value="management-plan">
                            <div>
                                <div class="mt-10 flex flex-col">
                                    <div class="flex flex-row items-end gap-3 mb-12">
                                        <div class="font-bold text-black">Listing tasks for : </div>
                                        <select class="todo-select w-[16rem]">
                                            @foreach($skills as $skill)
                                                <option {{$userPDetails['skills'] == $skill->value ? 'selected' : ''}} value="{{$skill->id}}">{{$skill->value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="border-b border-gray-200">
                                        <nav class="-mb-px flex " aria-label="Tabs">
                                            <div data-stage="one" class="border-indigo-500 text-indigo-600 w-1/3 border-b-2 py-4 px-1 text-center text-sm font-medium cursor-pointer each-stage">Stage 1</div>
                                            <div data-stage="two" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/3 border-b-2 py-4 px-1 text-center text-sm font-medium cursor-pointer each-stage">Stage 2</div>
                                            <div data-stage="three" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/3 border-b-2 py-4 px-1 text-center text-sm font-medium cursor-pointer each-stage">Stage 3</div>
                                            <div data-stage="four" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/3 border-b-2 py-4 px-1 text-center text-sm font-medium cursor-pointer each-stage">Stage 4</div>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <div class="management-plan-well"></div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="contact-management">
                            <div>
                                <div class="mt-10">
                                    <div class="border-b border-gray-200">
                                        <nav class="-mb-px flex " aria-label="Tabs">
                                            <div data-stage="my-contacts" class="border-indigo-500 text-indigo-600 w-1/3 border-b-2 py-4 px-1 text-center text-sm font-medium cursor-pointer each-stage disabled">Contacts</div>
                                            <div data-stage="add-contact" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/3 border-b-2 py-4 px-1 text-center text-sm font-medium cursor-pointer each-stage disabled">Add contact</div>
                                            <div data-stage="contact-requests" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/3 border-b-2 py-4 px-1 text-center text-sm font-medium cursor-pointer each-stage disabled">Requests</div>
                                            <div data-stage="my-groups" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/3 border-b-2 py-4 px-1 text-center text-sm font-medium cursor-pointer each-stage disabled">Groups</div>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-management-well"></div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="my-calendar">
                            <div class="calendar-well"></div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="my-questionnaires">
                            <div class="mt-10">
                                <div class="flex-1 pro_form_title">Manage Questionnaires</div>
                                <div class="pro_music_search pro_music_info no_border">
                                    <div class="pro_note">
                                        <ul>
                                            <li>Utilizing questionnaires to obtain accurate information fro your contacts can be highly effective</li>
                                            <li>Here you can manage your questionnaire for each skill listed below</li>
                                            <li>You can add/remove questions from a questionnaire</li>
                                            <li>The questionnaire can be attached to a contact in edit contact section. The contact person will get a link to that questionnaire in email, can fill it up and when the contact submits, you will get notified</li>
                                            <li>Questionnaire submission by a contact can be seen individually or a spreadsheet containing all of them can be downloaded</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="que-stages stage-one">
                                    <ul role="list" class="grid xs2:grid-cols-2 sm:grid-cols-4 gap-x-4">
                                        @foreach($skills as $skill)
                                        <li data-skill="{{$skill->value}}" class="relative questionnaire-skill flex justify-between gap-x-6 hover:bg-gray-200 border-b border-gray-200 cursor-pointer">
                                            <div class="flex w-full items-center text-sm leading-6 px-4 py-4 text-gray-900 gap-x-4 text-sm leading-6 text-gray-900">
                                                {{$skill->value}}
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
                            <div class="mt-10">
                                <div class="px-2 py-4">
                                    <div class="flex items-center mb-3">
                                        <div class="flex-shrink-0 text-[#666] text-lg hidden lg:flex">
                                            <i class="fa fa-info-circle"></i>
                                        </div>
                                        <div class="lg:ml-3 flex-1 md:flex md:justify-between">
                                            <p class="text-sm text-[#333] font-bold">Our groundbreaking digital platform is the world's first to facilitate person-to-person contracts</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                                        <div class="col-span-1 relative flex items-center space-x-3 rounded-lg border border-[#666] px-3 py-2 lg:px-6 lg:py-3 shadow-sm outline-none">
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">1.</div>
                                                    <div>Subscribe For legal Industry Contracts</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1 relative flex items-center space-x-3 rounded-lg border border border-[#666] px-3 py-2 lg:px-6 lg:py-3 shadow-sm outline-none">
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">2.</div>
                                                    <div>Choose contact from <span class="open-contacts-section font-bold cursor-pointer text-[#fc064c]">here</span>, attach contract</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1 relative flex items-center space-x-3 rounded-lg border border border-[#666] px-3 py-2 lg:px-6 lg:py-3 shadow-sm outline-none">
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">3.</div>
                                                    <div>Add details and requirements and submit</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1 relative flex items-center space-x-3 rounded-lg border border border-[#666] px-3 py-2 lg:px-6 lg:py-3 shadow-sm outline-none">
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">4.</div>
                                                    <div>Contact will receive an email/app notification</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1 relative flex items-center space-x-3 rounded-lg border border border-[#666] px-3 py-2 lg:px-6 lg:py-3 shadow-sm outline-none">
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">5.</div>
                                                    <div>They review and sign</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1 relative flex items-center space-x-3 rounded-lg border border border-[#666] px-3 py-2 lg:px-6 lg:py-3 shadow-sm outline-none">
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-[#333] flex flex-row items-center gap-2">
                                                    <div class="hidden lg:flex">6.</div>
                                                    <div>Both parties recieve legally binding digital copy</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($user->hasActivePaidSubscription())

                                @else
                                <div class="flex flex-col gap-4 mt-4 mx-2">
                                    <div class="border border-[#666] sm:rounded-lg">
                                        <div class="px-4 py-5 sm:p-6">
                                            <h3 class="text-base font-semibold leading-6 text-[#333]">Upgrade subscription</h3>
                                            <div class="mt-2 max-w-xl text-sm text-[#333]">
                                                <p>You are currently subscribed to a free plan. Upgrade your subscription to unlock this feature</p>
                                            </div>
                                            <div class="mt-5">
                                                <a type="button" href="{{route('user.startup.wizard', ['action' => 'upgrade-subscription'])}}" class="inline-flex items-center bg-[#fc064c] rounded-md bg-white px-3 py-2 text-sm font-semibold text-white shadow-sm">
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
                                            <div class="lg:ml-3 flex-1 md:flex md:justify-between">
                                                <p class="text-sm text-[#333] font-bold">Previews for the contracts are available</p>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                                            @foreach(\App\Models\Contract::all() as $contract)
                                            <div class="col-span-1 relative flex items-center space-x-3 rounded-lg border border-[#666] px-3 py-2 lg:px-6 lg:py-3 shadow-sm outline-none">
                                                <div class="min-w-0 flex-1">
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
                        <div class="each_dash_section instant_hide" data-value="my-industry-contacts">
                        @if($user->hasActivePaidSubscription())
                            <div class="pro_music_info mt-10">
                                <div class="pb-4">
                                1Platform connects the world's most extensive industry network, encompassing labels, publishers, pluggers, producers, skilled songwriters, and many more valuable contacts. You'll find a treasure trove of information, including phone numbers, emails, websites, and social media profiles, all at your fingertips!"
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-8">
                                    <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="min-w-0 flex-1">
                                            <a href="#" class="focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">One Time Contract</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="min-w-0 flex-1">
                                            <a href="#" class="focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Contract Subscription</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro_form_title flex flex-col">
                                    <div class="flex flex-col md:flex-row md:items-center">
                                        <div class="flex-1"><span class="ind_con_count">{{count(\App\Models\IndustryContact::all())}}</span> Industry Contacts Found</div>
                                        <div class="smart_switch_outer flex-1 switch_industry_contacts mt-10 md:mt-0 md:ml-auto">
                                            <div class="smart_switch_txt">Show Favourite Only</div>
                                            <label class="smart_switch">
                                                <input type="checkbox" />
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        @php
                                            $industryContactRegions = \App\Models\IndustryContactRegion::orderBy('id', 'asc')->get();
                                            $industryContactCategoryGroups = \App\Models\IndustryContactCategoryGroup::orderBy('id', 'asc')->get();
                                        @endphp
                                        <div class="ind_con_search_outer flex flex-col space-y-2 md:space-y-0 md:flex-row md:items-center mb-5 border-b border-gray-200 py-4">
                                            <div class="flex flex-row items-center">
                                                <div class="ind_con_search_by overflow-hidden w-1/2 inline-flex items-center rounded-md text-sm text-gray-900 hover:bg-gray-50 focus-visible:outline-offset-0">
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
                                                <div class="ind_con_search_by overflow-hidden w-1/2 inline-flex items-center rounded-md text-sm text-gray-900 hover:bg-gray-50 focus-visible:outline-offset-0 md:ml-5">
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
                                            <div class="ind_con_search_submit inline-flex items-center justify-center rounded-md px-3 py-1 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0 cursor-pointer">Search</div>
                                        </div>
                                        <div class="mt-5 industry-contacts-well">
                                            <div class="text-center text-md mt-10">...Loading</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </div>
                        <div class="each_dash_section mt-10 instant_hide" data-value="my-transactions">
                            <div class="order-stages stage-one">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div data-id="financial-summary" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Financial Summary</p>
                                                <p class="truncate text-sm text-gray-500">Summary of all of your sales, purchases, subscriptions and crowdfunding</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-subscription-plan" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Subscription Plan</p>
                                                <p class="truncate text-sm text-gray-500">Your active subscription and payments made towards it</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-purchases" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fa fa-dollar-sign"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Purchases</p>
                                                <p class="truncate text-sm text-gray-500">All your purchases made from 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-sales" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Sales</p>
                                                <p class="truncate text-sm text-gray-500">All your sales made through 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-premium-videos" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Premium Videos</p>
                                                <p class="truncate text-sm text-gray-500">Watch premium videos unlocked through your purchases</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-subscriptions" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">Subscriptions</p>
                                                <p class="truncate text-sm text-gray-500">View who you are currently subscribed to at 1Platform</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div data-id="my-crowdfund-purchases" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Crowdfund Purchases</p>
                                                <p class="truncate text-sm text-gray-500">All your crowdfunding project purchases made from 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-crowdfund-sales" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Crowdfund Sales</p>
                                                <p class="truncate text-sm text-gray-500">All your crowdfunding project sales made through 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="my-subscribers-donators" class="relative order-stage-head flex items-center space-x-3 rounded-lg border border-gray-300 bg-transparent px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                                        <div class="flex-shrink-0 text-lg">
                                            <i class="fas fa-hand-holding-heart"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="focus:outline-none cursor-pointer">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">My Subscribers and Donators</p>
                                                <p class="truncate text-sm text-gray-500">All your subscribers and donators at 1Platform</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-stages stage-two instant_hide">
                                <div class="text-lg cursor-pointer order-stage-nav back">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                                <div class="content max-h-[600px] overflow-y-auto overflow-x-hidden"></div>
                            </div>
                        </div>
                        <div class="each_dash_section instant_hide" data-value="my-profile">
                            <div>
                                <div class="mt-10">
                                    <div class="bg-white shadow sm:rounded-lg mb-8">
                                        <div class="px-4 py-5 sm:p-6">
                                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-12">What we offer</h3>
                                            <ul role="list" class="grid xs2:grid-cols-2 sm:grid-cols-4 gap-x-4 gap-y-6">
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Create a website, build a portfolio
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Establish an e-shop
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Share song links
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    List services
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Provide news updates
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Connect your domain
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Link your social media accounts
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Add music, create events
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Setup licensing options
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Connect your stripe account
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Confiure patreon
                                                </li>
                                                <li class="relative flex justify-between gap-x-6 border-b border-gray-200 pb-2">
                                                    Launch crowdfunding and much more
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="bg-white shadow sm:rounded-lg">
                                        <div class="px-4 py-5 sm:p-6">
                                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                                <p>Please click on the link below to edit your profile using our profile management wizard</p>
                                            </div>
                                            <div class="mt-3 text-sm leading-6">
                                                <a href="{{route('profile.setup', ['page' => 'welcome'])}}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                                                    Edit profile
                                                    <i style="font-size: 11px;" class="fa fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{asset('css/profile.chat.css?v=1.15')}}">
<link rel="stylesheet" href="{{asset('select2/select2.min.css')}}"></link>
<script src="{{ asset('select2/select2.min.js') }}"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('select.todo-select').select2();

    $('body').delegate('.each-task .each-task-det-nav .nav', "click", function(e){
        e.stopPropagation();
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
            data: {'find_type': 'industry_contact_details', 'find': find, 'identity_type': 'subscriber', 'identity': ''},
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

    $('.m_btn_management_plan, .m_btn_contact_management, .m_btn_calendarr, .m_btn_industry-contacts, .m_btn_transactions, .m_btn_questionnaires, .m_btn_contracts, .m_btm_profile').click(function(e){

        var id = $(this).attr('data-id');
        $('.each_dash_section:not(.each_dash_section[data-value="'+id+'"])').addClass('instant_hide');
        $('.each_dash_section[data-value="'+id+'"]').toggleClass('instant_hide');

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
                getManagementPlan('');
            } else {
                $('.management-plan-well').html('');
            }
        }

        if ($(this).hasClass('m_btn_contact_management')) {

            if (!$('.each_dash_section[data-value="'+id+'"]').hasClass('instant_hide')) {
                $('.loading').removeClass('instant_hide');
                getContactManagement();
            } else {
                $('.contact-management-well').html('');
                $('.each_dash_section[data-value="contact-management"] .each-stage').first().trigger('click');
                $('.each_dash_section[data-value="contact-management"] .each-stage').addClass('disabled');
            }
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
    });

    $('.m_btn_management_plan').trigger('click');


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

        var skill = $(this).attr('data-skill');
        var formData = new FormData();
        formData.append('skill', skill);
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
    });

    function getManagementPlan(skill = ''){

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'management-plan', 'find': skill, 'identity_type': 'subscriber', 'identity': ''},
            success: function(response) {

                removeLoading();
                if(response.success == 1){
                    $('.management-plan-well').html(response.data.data);
                }else{
                    console.log(data.error);
                    $('.management-plan-well').html(data.error);
                }
            }
        });
    }

    function getContactManagement(){

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'contact-management', 'find': '', 'identity_type': 'subscriber', 'identity': ''},
            success: function(response) {

                removeLoading();
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

    function getCalendar(){

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'my-calendar', 'find': '', 'identity_type': 'subscriber', 'identity': ''},
            success: function(response) {

                removeLoading();
                if(response.success == 1){
                    $('.calendar-well').html(response.data.data);
                }else{
                    console.log(data.error);
                    $('.calendar-well').html(data.error);
                }
            }
        });
    }

    function getIndustryContacts(find){

        $.ajax({

            url: "/informationFinder",
            dataType: "json",
            type: 'post',
            data: {'find_type': 'industry_contacts', 'find': find, 'identity_type': 'subscriber', 'identity': ''},
            success: function(response) {

                removeLoading();
                if(response.success == 1){
                    $('.industry-contacts-well').html(response.data.data);
                    $('select[data-type="ind_cont_drop"]').select2();
                    if(response.data.total_records == 0){
                        $('.industry-contacts-well').html('<div class="text-center mt-10">No records found</div>');
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
