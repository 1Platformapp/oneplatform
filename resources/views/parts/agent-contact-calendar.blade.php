<div data-id="u-calendar-{{$contact->id}}" class="">

    <form action="">
        <div class="pro_form_title flex items-center">
            <div>Calendar</div>
        </div>

        @include('parts.calendar', ['commonMethods' => $commonMethods, 'user' => $contact->agentUser, 'partner' => $contact->contactUser])
    </form>
</div>
