@php $userCampaignDetails = $commonMethods->getUserRealCampaignDetails($user->id) @endphp
<div class="clearfix social_supp_btns">

    @if($userCampaignDetails['campaignAmount'] > 0)
    <div class="fan_support_btn">
        <div class="fan_support_ic"><img src="{{ asset('images/donate-sign.png') }}" width="40" class="filter brightness-0 invert"></div>
        <div class="fan_support_text"><a href="{{route('user.project', ['username' => $user->username])}}">Support Me</a></div>
    </div>
    @else
    <div class="fan_support_btn support_instant">
        <div class="fan_support_ic"><img src="{{ asset('images/donate-sign.png') }}" width="40" class="filter brightness-0 invert"></div>
        <div class="fan_support_text"><a href="javascript:void(0)">Support Me</a></div>
    </div>
    @endif

</div>



<div class="tab_fan_list_outer">

@if(count($user->followers))
    
    <h3 class="tabd2_head">Followers</h3>
   
    @foreach($user->followers as $follower)
        @if($follower->followerUser)
        <div class="clearfix tab_fan_list">
            <div class="clearfix tab_fan_list_top">
                <a href="{{route('user.home',['params'=>$follower->followerUser->username])}}">
                    <img src="{{ $commonMethods->getUserDisplayImage($follower->followerUser->id) }}" alt="#" />
                </a>
                <div class="tab_fan_list_det">
                    <a href="{{route('user.home',['params'=>$follower->followerUser->username])}}">
                        {{ $follower->followerUser->name }}
                    </a>
                    <p>{{$commonMethods->timeElapsedString($follower->created_at, 1)}}</p>
                </div>
                <div class="tab_fan_list_right"></div>
            </div>
            <p class="tab_fan_list_btm_text">
                {{ $follower->message }}
            </p>
        </div>
        @endif
    @endforeach

@endif

@if(count($user->checkouts) > 0)
    <div class="spacer"></div>
    <h3 class="tabd2_head">Supporters</h3>

    @foreach($user->checkouts as $checkout)

        @if($checkout->type == 'crowdfund' && $checkout->private != 1)

            @if($checkout->customer)

            @include('parts.user-fan-template',['fanType' => 'contributer', 'checkout' => $checkout])

            @endif

        @endif

    @endforeach

    @foreach($user->checkouts as $checkout)

        @if($checkout->type == 'instant' && $checkout->private != 1)

            @if($checkout->customer)

            @include('parts.user-fan-template',['fanType' => 'buyer', 'checkout' => $checkout])

            @endif

        @endif

    @endforeach

@endif

</div>