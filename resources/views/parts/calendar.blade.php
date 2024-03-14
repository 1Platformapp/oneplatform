<div class="calendar-container">
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
            <div class="flex md:flex-row gap-x-2 gap-y-4 flex-col mt-8">
                <button type="button" class="add-event w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 outline-none">Add event</button>
                <button type="button" class="show-all-events w-full rounded-md bg-white px-3 py-2 text-sm font-semibold border text-indigo-600 shadow outline-none">Show all events</button>
            </div>
        </div>
        <ol id="selected-date-events" class="mt-4 divide-y divide-gray-200 text-sm leading-6 lg:col-span-7 xl:col-span-8"></ol>
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
                <div class="event-participants-show mx-auto max-w-md sm:max-w-3xl">
                    <div>
                        <div class="text-center">
                            <h2 class="mt-2 text-base font-semibold leading-6 text-gray-900">All participants</h2>
                            <p class="event-title mt-1 text-sm text-gray-500">Recording session</p>
                        </div>
                    </div>
                    <div class="mt-10">
                        <ul role="list" class="participants-large mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="add_event_popup pro_page_pop_up new_popup clearfix" style="z-index: 10; max-height:600px; overflow:auto">
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
                           <h2 class="mt-2 text-base font-semibold leading-6 text-gray-900">Add event</h2>
                           <div class="soc_con_face_username"><span id="current-date"></span></div>
                        </div>
                    </div>
                    <div class="mt-10 mb-16">
                        <div class="participant-form mt-10 grid grid-cols-1">
                            <div class="w-full">
                                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Event title</label>
                                <div class="mt-2">
                                    <input type="text" id="title" placeholder="e.g recording session" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm border border-solid border-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="w-full mt-2">
                                <label for="date-time" class="block text-sm font-medium leading-6 text-gray-900">Event date and time</label>
                                <div class="mt-2">
                                    <input type="text" id="date-time" placeholder="e.g Jan 10, 2024, 8PM - 5PM" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm border border-solid border-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="w-full mt-2">
                                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Event location</label>
                                <div class="mt-2">
                                    <input type="text" id="location" placeholder="e.g Cotyso studios, manchester" class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm border border-solid border-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            @if(!isset($partner))
                            <div class="w-full mt-2">
                                <label for="search-participants" class="block text-sm font-medium leading-6 text-gray-900">Participants</label>
                                <div class="relative participants-search-outer mt-2">
                                    <input type="text" id="search-participants" placeholder="search here..." class="block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                    <ul class="participants-search-result-outer hidden absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox"></ul>
                                </div>
                                <div class="flex mt-2">
                                    <ul role="list" class="all-participants mt-4 divide-y divide-gray-200 border-b border-t border-gray-200 w-full">
                                        @foreach ($user->contacts as $contact)
                                        @if(!$contact->contactUser || !$contact->agentUser)
                                            @php continue @endphp
                                        @endif
                                        @php
                                            $contactUser = $contact->contactUser;
                                            $contactPDetails = $commonMethods->getUserRealDetails($contactUser->id)
                                        @endphp

                                        <li base-id="{{$contactUser->id}}" class="each-participant hidden flex items-center justify-between space-x-3 py-4">
                                            <div class="flex min-w-0 flex-1 items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full" src="{{$contactPDetails['image']}}" alt="{{$contactPDetails['name']}}">
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="participant-name truncate text-sm font-medium text-gray-900">{{$contactPDetails['name']}}</p>
                                                    <p class="truncate text-sm font-medium text-gray-500">@ {{$contactUser->username}}</p>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="participant-remove relative cursor-pointer rounded-md hover:text-gray-500 outline-none">
                                                    <span class="absolute -inset-2.5"></span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                            <button type="button" class="add-participant-submit w-24 ml-auto mt-4 rounded bg-indigo-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 outline-none">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="event-summary" class="element_sample">
        <li class="relative flex space-x-6 py-6 xl:static">
            <div class="flex-auto">
                <h3 class="event-title pr-10 font-semibold text-gray-600 xl:pr-0"></h3>
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
                                <time class="event-date-time" datetime=""></time>
                            </dd>
                        </div>
                        <div class="mt-2 flex items-start space-x-3 xl:ml-3.5 xl:mt-0 xl:border-l xl:border-gray-400 xl:border-opacity-50 xl:pl-3.5">
                            <dt class="mt-0.5">
                                <span class="sr-only">Location</span>
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                            </dt>
                            <dd class="event-location"></dd>
                        </div>
                    </dl>
                    <div class="participants-container relative mt-2 flex flex-col justify-center space-y-3 w-full">
                        <dl class="flex flex-none sm:w-auto">
                            <div class="participants-small cursor-pointer flex -space-x-0.5"></div>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="absolute right-0 top-6 xl:relative xl:right-auto xl:top-auto xl:self-center">
                <div class="dropdown-icon">
                    <button type="button" class="-m-2 flex items-center rounded-full p-2 text-gray-500 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                        </svg>
                    </button>
                </div>

                <div class="hidden dropdown-menu absolute right-0 z-10 mt-2 w-36 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-0-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <div class="event-edit cursor-pointer hover:bg-gray-100 text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-0">Edit</div>
                        <div class="event-delete cursor-pointer hover:bg-gray-100 text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-1">Delete</div>
                    </div>
                </div>
            </div>
        </li>
    </div>
    <input id="current-user" type="hidden" value="{{$user->id}}" />
    <input id="current-partner" type="hidden" value="{{isset($partner) ? $partner->id : ''}}" />
</div>

<script>

   $(document).ready(function () {
        $(document).click(function (event) {
            if (!$(event.target).closest('.dropdown-menu').length) {
                $('.dropdown-menu').addClass('hidden');
            }
        });

        $(document).click(function (event) {
            if (!$(event.target).closest('.participants-search-result-outer').length) {
                $('.participants-search-result-outer').addClass('hidden');
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
                .addClass('bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10 current-month')
                .append($('<time>')
                    .attr('datetime', `${day}-${month + 1}-${year}`)
                    .addClass('mx-auto flex h-7 w-7 items-center justify-center rounded-full' +
                        (day === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear() ? ' font-semibold text-indigo-600 today' : '') +
                        (day === currentDate.getDate() + 1 && month === currentDate.getMonth() && year === currentDate.getFullYear() ? ' font-semibold text-white bg-gray-900 selected-date ' : '')
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

        $('#prev-month').off('click').on('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });

        $('#next-month').off('click').on('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });

        renderCalendar(currentMonth, currentYear);
        fetchCalendarEvents($('time.selected-date').attr('datetime'));

        $('body').undelegate('.participants-small', 'click').delegate('.participants-small', 'click', function(e){

            var parent = $(this).closest('li');
            $('.participants_popup .event-participants-show .event-title').text(parent.find('.event-title').text());
            $('.event-participants-show .participants-large').html('');
            parent.find('.participants-small dd').each(function(){
                var name = $(this).attr('data-name');
                var imageSrc = $(this).find('img').attr('src');
                var username = $(this).attr('data-username');
                $('.event-participants-show .participants-large').append('<li><button type="button" class="group flex w-full items-center justify-between space-x-3 rounded-full border border-gray-300 p-2 text-left shadow-sm outline-none"><span class="flex min-w-0 flex-1 items-center space-x-3"><span class="block flex-shrink-0"><img class="h-10 w-10 rounded-full" src="'+imageSrc+'" alt=""></span><span class="block min-w-0 flex-1"><span class="block truncate text-sm font-medium text-gray-900">'+name+'</span><span class="block truncate text-sm font-medium text-gray-500">@'+username+'</span></span></span></button></li>');
            });
            $('.participants_popup,#body-overlay').show();
        });

        $('.add-event').off('click').on('click', function() {
            var selectedDate = $('.isolate button.current-month time.selected-date');

            if (!selectedDate.length) {
                alert('Please select a date');
            } else {

                $('.add_event_popup').removeAttr('edit');
                $('.add_event_popup #title').val('');
                $('.add_event_popup #date-time').val('');
                $('.add_event_popup #location').val('');
                $('.all-participants .each-participant').addClass('hidden');

                $('.add_event_popup #current-date').text('Date: ' + $('.isolate button.current-month time.selected-date').attr('datetime'));
                $('.add_event_popup,#body-overlay').show();
            }
        });

        $('.show-all-events').off('click').on('click', function() {

            fetchCalendarEvents('*');
            $('.isolate button.current-month time.selected-date').removeClass('text-white bg-gray-900 selected-date font-semibold');
        });

        $('body').undelegate('.participants-search-result', 'click').delegate('.participants-search-result', 'click', function(e){
            var id = $(this).attr('data-id');
            $('.all-participants .each-participant[base-id="'+id+'"]').removeClass('hidden');
            $('.participants-search-result-outer').addClass('hidden');
            $('#search-participants').val('');
        });

        $('body').undelegate('.pro_soc_top_close', 'click').delegate('.pro_soc_top_close', 'click', function(e){
            $('#body-overlay').click();
        });

        $('body').undelegate('.participant-remove', 'click').delegate('.participant-remove', 'click', function(e){
            var target = $(this).closest('.each-participant');
            if (target.length > 0) {
                target.addClass('hidden');
            }
        });

        $('#search-participants').off('input').on('input', function () {
            var thiss = $(this)
            var searchTerm = $(this).val();
            $('.participants-search-result-outer').html('').addClass('hidden');

            if (searchTerm.length > 0) {
                thiss.closest('.calendar-container').find('.all-participants .participant-name').each(function () {
                    var participantText = $(this).text().toLowerCase();
                    console.log(participantText);
                    if (participantText.includes(searchTerm)) {
                        var id = $(this).closest('.each-participant').attr('base-id');
                        var count = $('.participants-search-result[data-id="'+id+'"]');
                        if (count.length == 0) {
                            $('.participants-search-result-outer').append('<li data-id="'+id+'" class="participants-search-result relative cursor-pointer hover:bg-gray-200 select-none py-2 pl-3 pr-9 text-gray-900 text-sm" role="option" tabindex="-1"><span class="block truncate">'+participantText+'</span></li>').removeClass('hidden');
                        }
                    }
                });
            }
        });

        $('body').undelegate('.isolate button.current-month', 'click').delegate('.isolate button.current-month', 'click', function(e){
            var thiss = $(this);
            $('.isolate button.current-month time.selected-date').removeClass('selected-date font-semibold bg-gray-900 text-white').addClass('text-gray-900 bg-white');
            $('.isolate button.current-month time.today').addClass('font-semibold');
            thiss.find('time').addClass('selected-date font-semibold bg-gray-900 text-white').removeClass('text-gray-900 bg-white');

            fetchCalendarEvents(thiss.find('time').attr('datetime'));
        });

        $('body').undelegate('.participant-form .add-participant-submit:not(.busy)', 'click').delegate('.participant-form .add-participant-submit:not(.busy)', 'click', function(e){

            var thiss = $(this);
            var error = false;
            var title = $('.participant-form #title');
            var dateTimeInput = $('.participant-form #date-time');
            var location = $('.participant-form #location');
            var dateTime = $('.isolate button.current-month time.selected-date');
            var edit = $('.add_event_popup').attr('edit');

            $('.participant-form input').removeClass('error_field');
            if (title.val().length == 0) {
                error = true;
                title.addClass('error_field');
            }
            if (location.val().length == 0) {
                error = true;
                location.addClass('error_field');
            }

            var participants = [];
            $('.all-participants .each-participant:not(.hidden)').each(function(){
                participants.push($(this).attr('base-id'));
            });

            if (!error) {

                thiss.addClass('busy');
                var formData = new FormData();
                formData.append('title', title.val());
                formData.append('location', location.val());
                formData.append('dateTimeInput', dateTimeInput.val());
                formData.append('dateTime', dateTime.attr('datetime'));
                formData.append('participants', participants);

                var uri = 'create';
                if (edit !== undefined) {
                    formData.append('edit', edit);
                    uri = 'update';
                }

                $.ajax({

                    url: '/dashboard/calendar/' + uri,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            $('.pro_page_pop_up,#body-overlay').hide();
                            fetchCalendarEvents(dateTime.attr('datetime'));
                        }
                    },
                    complete: function () {
                        thiss.removeClass('busy');
                    }
                });
            }
        });

        $('body').undelegate('.dropdown-icon', 'click').delegate('.dropdown-icon', 'click', function(event){
            event.stopPropagation();
            const dropdownMenu = $(this).parent().find('.dropdown-menu');
            dropdownMenu.toggleClass('hidden');
        });

        $('body').undelegate('.event-edit', 'click').delegate('.event-edit', 'click', function(event){
            var event = $(this).closest('li');
            var edit = event.find('.event-title').attr('data-id');
            var title = event.find('.event-title').text();
            var location = event.find('.event-location').text();
            var dateTimeInput = event.find('.event-date-time').text();

            $('.all-participants .each-participant').addClass('hidden');
            event.find('.participants-small dd').each(function(){
                var id = $(this).attr('data-user-id');
                $('.all-participants .each-participant[base-id="'+id+'"]').removeClass('hidden');
            });

            $('.add_event_popup #title').val(title);
            $('.add_event_popup #date-time').val(dateTimeInput);
            $('.add_event_popup #location').val(location);
            $('.add_event_popup #current-date').text('');

            $('.add_event_popup').attr('edit', edit);
            $('.add_event_popup,#body-overlay').show();
        });

        $('body').undelegate('.event-delete', 'click').delegate('.event-delete', 'click', function(e){

            e.preventDefault();
            var event = $(this).closest('li');
            var id = event.find('.event-title').attr('data-id');
            $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', id);
            $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'calendar-event');

            if (id) {
                $('.pro_confirm_delete_outer, #body-overlay').show();
            }
        });

        function fetchCalendarEvents(date){
            var currentUser = $('#current-user');
            var currentPartner = $('#current-user').val();
            var formData = new FormData();
            formData.append('date', date);

            $.ajax({

                url: '/dashboard/calendar/read',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {

                    if (response.success && response.data) {

                        $('#selected-date-events').html('');
                        response.data.forEach(function(ev) {
                            console.log(ev);
                            var event = $('.element_sample#event-summary').clone();
                            event.find('.event-title').attr('data-id', ev.id);
                            event.find('.event-title').text(ev.title);

                            if(ev.user_id != currentUser.val()) {
                                event.find('.dropdown-icon').parent().addClass('hidden');
                            }

                            if (ev.date_time_input) {
                                event.find('.event-date-time').text(ev.date_time_input);
                            } else {
                                event.find('.event-date-time').text(date);
                            }
                            event.find('.event-location').text(ev.location);
                            var participants = '';
                            if (ev.participant_users.length) {
                                ev.participant_users.forEach(function(part) {
                                    console.log(part);
                                    if (currentPartner == '' || currentPartner == part.id) {
                                        participants += '<dd data-id="'+part.id+'" data-user-id="'+part.user_id+'" data-username="'+part.username+'" data-name="'+part.name+'"><img class="h-6 w-6 rounded-full bg-gray-50 ring-2 ring-white" src="'+part.image+'" alt=""></dd>';
                                    }
                                });
                                event.find('.participants-small').html(participants);
                            }
                            $('#selected-date-events').append(event.find('li').prop('outerHTML'));
                        });
                    }
                }
            });
        }
    });
</script>

<style>
    .add-participant-submit.busy {
        cursor: not-allowed;
    }
</style>
