<div>
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-16">
        <div class="mt-10 text-center lg:col-start-8 lg:col-end-13 lg:row-start-1 lg:mt-9 xl:col-start-9">
            <div class="flex items-center text-gray-900">
                <button id="prev-month" type="button" class="-m-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Previous month</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                    </svg>
                </button>
                    <div id="current-month" class="flex-auto text-sm font-semibold"></div>
                <button id="next-month" type="button" class="-m-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Next month</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 grid grid-cols-7 text-xs leading-6 text-gray-500">
                <div>M</div>
                <div>T</div>
                <div>W</div>
                <div>T</div>
                <div>F</div>
                <div>S</div>
                <div>S</div>
            </div>
            <div class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200 calendar-dates"></div>
            <button type="button" class="mt-8 w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add event</button>
        </div>
        <ol class="mt-4 divide-y divide-gray-200 text-sm leading-6 lg:col-span-7 xl:col-span-8">
            <li class="relative flex space-x-6 py-6 xl:static">
                <div class="flex-auto">
                    <h3 class="pr-10 font-semibold text-gray-600 xl:pr-0">Recording session</h3>
                    <dl class="mt-2 flex flex-col text-gray-500 xl:flex-row">
                        <div class="flex items-start space-x-3">
                            <dt class="mt-0.5">
                                <span class="sr-only">Date</span>
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                                </svg>
                            </dt>
                            <dd>
                                <time datetime="2022-01-10T17:00">Jan 10th, 2022, 8:00 PM - 5:00 PM</time>
                            </dd>
                        </div>
                        <div class="mt-2 flex items-start space-x-3 xl:ml-3.5 xl:mt-0 xl:border-l xl:border-gray-400 xl:border-opacity-50 xl:pl-3.5">
                            <dt class="mt-0.5">
                                <span class="sr-only">Location</span>
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                            </dt>
                            <dd>Cotyso studios</dd>
                        </div>
                    </dl>
                    <div class="participants-container relative mt-2 flex flex-col justify-center space-y-3 w-full">
                        <dl class="flex flex-none sm:w-auto">
                            <div class="participants-small flex -space-x-0.5">
                                <dt class="sr-only">Commenters</dt>
                                <dd>
                                    <img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="https://images.unsplash.com/photo-1505840717430-882ce147ef2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Emma Dorsey">
                                </dd>
                                <dd>
                                    <img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Tom Cook">
                                </dd>
                            </div>
                            <div class="participants-add -ml-0.5 flex items-center justify-center h-6 w-6 rounded-full bg-gray-50 ring-2 ring-gray-50">
                                <svg class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path>
                                </svg>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="absolute right-0 top-6 xl:relative xl:right-auto xl:top-auto xl:self-center">
                    <div class="dropdown-icon">
                        <button type="button" class="-m-2 flex items-center rounded-full p-2 text-gray-500 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                        </svg>
                        </button>
                    </div>

                    <div class="hidden dropdown-menu absolute right-0 z-10 mt-2 w-36 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-0-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <div class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-0">Edit</div>
                            <div class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-1">Delete</div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="relative flex space-x-6 py-6 xl:static">
                <div class="flex-auto">
                    <h3 class="pr-10 font-semibold text-gray-600 xl:pr-0">Photo conference</h3>
                    <div class="flex flex-col">
                        <dl class="mt-2 flex flex-col text-gray-500 xl:flex-row">
                            <div class="flex items-start space-x-3">
                                <dt class="mt-0.5">
                                    <span class="sr-only">Date</span>
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                                    </svg>
                                </dt>
                                <dd>
                                    <time datetime="2022-01-10T17:00">Jan 11th, 2022 at 05:00 PM</time>
                                </dd>
                            </div>
                            <div class="mt-2 flex items-start space-x-3 xl:ml-3.5 xl:mt-0 xl:border-l xl:border-gray-400 xl:border-opacity-50 xl:pl-3.5">
                                <dt class="mt-0.5">
                                    <span class="sr-only">Location</span>
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                    </svg>
                                </dt>
                                <dd>Expo center</dd>
                            </div>
                        </dl>
                        <div class="participants-container relative mt-2 flex flex-col justify-center space-y-3 w-full">
                            <dl class="flex flex-none sm:w-auto">
                                <div class="participants-small flex -space-x-0.5">
                                    <dt class="sr-only">Commenters</dt>
                                    <dd>
                                        <img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="https://images.unsplash.com/photo-1505840717430-882ce147ef2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Emma Dorsey">
                                    </dd>
                                    <dd>
                                        <img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Tom Cook">
                                    </dd>
                                    <dd>
                                        <img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Lindsay Walton">
                                    </dd>
                                    <dd>
                                        <img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Benjamin Russel">
                                    </dd>
                                    <dd>
                                        <img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Hector Gibbons">
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="absolute right-0 top-6 xl:relative xl:right-auto xl:top-auto xl:self-center">
                    <div class="dropdown-icon">
                        <button type="button" class="-m-2 flex items-center rounded-full p-2 text-gray-500 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                        </svg>
                        </button>
                    </div>

                    <div class="hidden dropdown-menu absolute right-0 z-10 mt-2 w-36 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-0-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-0">Edit</a>
                            <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-1">Cancel</a>
                        </div>
                    </div>
                </div>
            </li>
        </ol>
    </div>

    <div class="participants_popup pro_page_pop_up new_popup clearfix" style="z-index: 10; max-height:600px; overflow:auto">
        <div class="pro_soc_con_face_inner clearfix">
            <div style="padding: 10px 20px;" class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="pro_pop_body">
                <div class="mx-auto max-w-md sm:max-w-3xl">
                    <div>
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        <h2 class="mt-2 text-base font-semibold leading-6 text-gray-900">All participants</h2>
                            <p class="mt-1 text-sm text-gray-500">Recording session</p>
                        </div>
                    </div>
                    <div class="mt-10">
                        <ul role="list" class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <li>
                                <button type="button" class="group flex w-full items-center justify-between space-x-3 rounded-full border border-gray-300 p-2 text-left shadow-sm hover:bg-gray-50 outline-none">
                                    <span class="flex min-w-0 flex-1 items-center space-x-3">
                                        <span class="block flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                        </span>
                                        <span class="block min-w-0 flex-1">
                                        <span class="block truncate text-sm font-medium text-gray-900">Lindsay Walton</span>
                                        <span class="block truncate text-sm font-medium text-gray-500">@AgentDavid</span>
                                        </span>
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="group flex w-full items-center justify-between space-x-3 rounded-full border border-gray-300 p-2 text-left shadow-sm hover:bg-gray-50 outline-none">
                                    <span class="flex min-w-0 flex-1 items-center space-x-3">
                                        <span class="block flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                        </span>
                                        <span class="block min-w-0 flex-1">
                                        <span class="block truncate text-sm font-medium text-gray-900">Lindsay Walton</span>
                                        <span class="block truncate text-sm font-medium text-gray-500">@AgentDavid</span>
                                        </span>
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="participants_add_popup pro_page_pop_up new_popup clearfix" style="z-index: 10; max-height:600px; overflow:auto">
        <div class="pro_soc_con_face_inner clearfix">
            <div style="padding: 10px 20px;" class="soc_con_top_logo clearfix">
                <a style="opacity:0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="pro_pop_body">
                <div class="mx-auto max-w-md sm:max-w-3xl">
                    <div>
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        <h2 class="mt-2 text-base font-semibold leading-6 text-gray-900">Add participants</h2>
                            <p class="mt-1 text-sm text-gray-500">Recording sessions</p>
                        </div>
                    </div>
                    <div class="mt-10">
                        <ul role="list" class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <li>
                                <button type="button" class="group flex w-full items-center justify-between space-x-3 rounded-full border border-gray-300 p-2 text-left shadow-sm hover:bg-gray-50 outline-none">
                                    <span class="flex min-w-0 flex-1 items-center space-x-3">
                                        <span class="block flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                        </span>
                                        <span class="block min-w-0 flex-1">
                                        <span class="block truncate text-sm font-medium text-gray-900">Lindsay Walton</span>
                                        <span class="block truncate text-sm font-medium text-gray-500">@AgentDavid</span>
                                        </span>
                                    </span>
                                    <span class="inline-flex h-10 w-10 flex-shrink-0 items-center justify-center">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="group flex w-full items-center justify-between space-x-3 rounded-full border border-gray-300 p-2 text-left shadow-sm hover:bg-gray-50 outline-none">
                                    <span class="flex min-w-0 flex-1 items-center space-x-3">
                                        <span class="block flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                        </span>
                                        <span class="block min-w-0 flex-1">
                                        <span class="block truncate text-sm font-medium text-gray-900">Lindsay Walton</span>
                                        <span class="block truncate text-sm font-medium text-gray-500">@AgentDavid</span>
                                        </span>
                                    </span>
                                    <span class="inline-flex h-10 w-10 flex-shrink-0 items-center justify-center">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        $('.dropdown-icon').click(function (event) {
            event.stopPropagation();
            const dropdownMenu = $(this).parent().find('.dropdown-menu');
            dropdownMenu.toggleClass('hidden');
        });

        $(document).click(function (event) {
            if (!$(event.target).closest('.dropdown-menu').length) {
                $('.dropdown-menu').addClass('hidden');
            }
        });

        const calendarDates = $('.calendar-dates');

        // Initialize the date object
        const currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        function renderCalendar(month, year) {
            // Clear the calendar
            calendarDates.html('');

            // Update the current month display
            $('#current-month').text(`${new Date(year, month).toLocaleString('default', { month: 'long' })} ${year}`);

            // Get the first day of the month
            const firstDay = new Date(year, month, 1);
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Calculate the starting day (0 = Sunday, 1 = Monday, ...)
            const startingDay = firstDay.getDay();

            // Calculate the number of days before and after the current month to complete the ongoing week
            const daysBefore = (startingDay + 6) % 7; // Days before the 1st of the month
            const daysAfter = 7 - ((daysBefore + daysInMonth) % 7); // Days after the last day of the month

            // Create date elements for each day before the 1st of the current month
            let counter = 1;
            for (let i = daysBefore; i > 0; i--) {

                const previousMonthDay = new Date(year, month, 0).getDate() - (daysBefore - counter);
                const dateElement = $('<button>')
                .addClass('bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10')
                .append($('<time>')
                    .attr('datetime', `${year}-${month}-${previousMonthDay}`)
                    .addClass('mx-auto flex h-7 w-7 items-center justify-center rounded-full')
                    .text(previousMonthDay)
                );
                calendarDates.append(dateElement);
                counter++;
            }

            // Create date elements for each day in the current month
            for (let day = 1; day <= daysInMonth; day++) {
                const dateElement = $('<button>')
                .addClass('bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10')
                .append($('<time>')
                    .attr('datetime', `${year}-${month + 1}-${day}`)
                    .addClass('mx-auto flex h-7 w-7 items-center justify-center rounded-full' +
                        (day === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear() ? ' bg-gray-900 font-semibold text-white today' : '')
                    )
                    .text(day)
                );
                calendarDates.append(dateElement);
            }

            // Create date elements for each day after the last day of the current month
            for (let i = 1; i <= daysAfter; i++) {
                const nextMonthDay = i;
                const dateElement = $('<button>')
                .addClass('bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10')
                .append($('<time>')
                    .attr('datetime', `${year}-${month + 2}-${nextMonthDay}`)
                    .addClass('mx-auto flex h-7 w-7 items-center justify-center rounded-full')
                    .text(nextMonthDay)
                );
                calendarDates.append(dateElement);
            }
        }

        // Initial render of the calendar
        renderCalendar(currentMonth, currentYear);

        // Event listeners for previous and next month buttons
        $('#prev-month').on('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });

        $('#next-month').on('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });

        $('.participants-small').on('click', function() {
            $('.participants_popup,#body-overlay').show();
        });

        $('.participants-add').on('click', function() {
            $('.participants_add_popup,#body-overlay').show();
        });
    });
</script>
