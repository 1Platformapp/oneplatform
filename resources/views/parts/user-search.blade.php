    @if($users && $users->count())
        @foreach($users as $user)

            <?php $emailInit = explode("@", $user->email); ?>

            <div class="ui-grid-row user-result" data-urllink="{{ asset("/" . $emailInit[0]) }}">
                <div class="ui-grid-col-3"> <img src="{!! $user->getDetails()->photo !!}"> </div>
                <div class="ui-grid-col-3 search_result_name"> {{$user->name}} </div>
                <div class="ui-grid-col-3"> {{$user->city}} </div>
                <div class="ui-grid-col-3"> {{$user->job}} </div>
            </div>

        @endforeach
    @endif