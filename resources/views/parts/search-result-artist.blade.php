<div class="each_artist clearfix">
    @php
        if($user->accountType)
            $city = \App\Models\City::find($user->accountType->city_id);
        else if($user->address->city_id)
            $city = \App\Models\City::find($user->address->city_id);
        else
            $city = null;
    @endphp
    <div class="each_artist_inner">
        <div class="artist_left">
            <a class="main_img_contain" href="javascript:void(0)">
                <img src="{{ $commonMethods->getUserDisplayImage($user->id) }}" alt="{{ $user->name }}" />
            </a>
        </div>
        <div class="artist_right">
            <a class="artist_user_name" href="javascript:void(0)">
                {{ $user->name }} 
                @if($user->profile->stripe_user_id && $user->profile->stripe_user_id != '')
                <img class="user_connected" title="{{ $user->name }} has connected stripe account" src="{{ asset('img/user_connected.png') }}">
                @endif
            </a>
            <span class="artist_info" ><i class="fa fa-music"></i>{{ ($user->skills && $user->skills != '') ? $user->skills : 'N/A' }}</span>
            <span class="artist_info" ><i class="fa fa-map-marker-alt"></i>{{ ($city) ? $city->name : 'N/A' }}</span>
        </div>
        <div class="artist_actions vertical_center">
            @if(count($user->services))
            <a data-id="{{$user->id}}" class="user_services_opener" href="javascript:void(0)">Services</a>
            @endif
            <a href="{{route('user.home', ['params' => $user->username])}}">View Profile</a>
        </div>
    </div>
</div>
