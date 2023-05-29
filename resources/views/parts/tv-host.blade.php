

<div data-id="{{$user->id}}" class="each_search_host_result">
    <div class="each_search_result_thumb">
        <img src="{{$commonMethods->getUserDisplayImage($user->id)}}" />
    </div>
    <div class="each_search_result_det">
        <div class="each_search_det_each">
            <a href="{{route('user.home', ['params' => $user->username])}}">{{$user->name}}</a>
        </div>
        <div class="each_search_det_each">
            {{$user->skills ? $user->skills : ''}}
        </div>
        <div class="each_search_det_each">
            {{$user->level ? $user->level : ''}}
        </div>
    </div>
</div>