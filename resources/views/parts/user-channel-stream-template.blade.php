
<?php
$commonMethods = new \App\Http\Controllers\CommonMethods();
$streamYoutubeId = $commonMethods->getYoutubeIdFromUrl($stream->url);
$streamYoutubeTitle = $commonMethods->getVideoTitle($streamYoutubeId);
$imgSrc = $stream->thumbnail && $stream->thumbnail != '' ? asset('user-stream-thumbnails/'.$stream->thumbnail) : 'https://i.ytimg.com/vi/'.$streamYoutubeId.'/mqdefault.jpg';
?>

@if(Auth::check() && Auth::user()->canWatchLiveStream($stream->id))
	@php $watch = 1 @endphp
@else
	@php $watch = 0 @endphp
@endif

<div class="tab_chanel_list each_user_video each_user_live_stream {{$watch?'':'empty_video_list'}} clearfix">

	<div class="user_live_stream_basic">
		<a href="javascript:void(0)">
            <img class="defer_loading instant_hide" src="#" data-src="{{$imgSrc}}" alt="{{ substr($streamYoutubeTitle, 0, 40) }}" />
        </a>

		<div class="tab_chanel_img_det">
		    <a data-stream-type="youtube" data-orig-image="" data-stream-live="1" data-stream-id="{{$watch == 1 ? base64_encode($streamYoutubeId) : ''}}" href="javascript:void(0)" class="each_user_video_artist">{{ $stream->user->name }}</a>
		    <p>{{ substr($streamYoutubeTitle, 0, 40) }}</p>
		</div>

		<div class="tab_chanel_btn lock_outer">
			<i class="fa fa-lock private_np"></i> Premium
		</div>
	</div>

    <div class="user_live_stream_det">
    	@if($watch == 0)
    	<div class="user_ls_pre_accord">
    		<div class="user_lspa_title">
    			This is a premium video. To unlock this content please meet one of the requirements below
    		</div>
    	</div>
        @php $counter = 0 @endphp
        @if($stream->music)
        @php $counter++ @endphp
    	<div class="user_ls_accord_each">
    		<div class="user_lsa_head">
    			<div class="user_lsah_name">{{$counter}}- Purchase one or more music licenses</div>
    			<div class="user_lsah_ic"><i class="fa fa-caret-down"></i></div>
    		</div>
    		<div class="user_lsa_body">
    			@foreach($user->musics as $userMusic)
    			    @if($stream->music == 'all' || ($stream->musicc && $stream->musicc->id == $userMusic->id))
    			        @include('parts.user-channel-music-template',['music'=>$userMusic])
                    @endif
    			@endforeach
    		</div>
    	</div>
        @endif
        @if($stream->product)
        @php $counter++ @endphp
    	<div class="user_ls_accord_each">
    		<div class="user_lsa_head">
    			<div class="user_lsah_name">{{$counter}}- Purchase one or more products</div>
    			<div class="user_lsah_ic"><i class="fa fa-caret-down"></i></div>
    		</div>
    		<div class="user_lsa_body">
    			@foreach($user->products as $userProduct)
                    @if($stream->product == 'all' || ($stream->productt && $stream->productt->id == $userProduct->id))
    			        @include('parts.user-channel-product-template',['product'=>$userProduct])
                    @endif
    			@endforeach
    		</div>
    	</div>
        @endif
        @if($stream->more_viewers == 'all_subs' || $stream->more_viewers == 'all_subs_fans_follow')
        @php $counter++ @endphp
    	<div class="user_ls_accord_each">
    		<div class="user_lsa_head">
    			<div class="user_lsah_name">{{$counter}}- Subscribe to {{$user->name}}</div>
    			<div class="user_lsah_ic"><i class="fa fa-caret-down"></i></div>
    		</div>
    		<div class="user_lsa_body">
    			<div class="project_rit_btm_list user_lsa_subscribe_box">
    			    <h4>Subscribe to {{$user->name}}</h4>
    			    @php $encourageBullets = $user->encourage_bullets; @endphp
    			    <div class="subsription_box_heading">Items included to this monthly subscription</div>
    			    <ul class="subsription_box_list">
    			        @if(is_array($encourageBullets) && $encourageBullets[0] != '')
    			        <li><p>{{ $encourageBullets[0] }}</p></li>
    			        @endif
    			        @if(is_array($encourageBullets) && $encourageBullets[1] != '')
    			        <li><p>{{ $encourageBullets[1] }}</p></li>
    			        @endif
    			        @if(is_array($encourageBullets) && $encourageBullets[2] != '')
    			        <li><p>{{ $encourageBullets[2] }}</p></li>
    			        @endif
    			    </ul>
    			    <label class="proj_add_sec {{ isset($isSubscribed) && $isSubscribed == 1 ? 'proj_add_sec_added' : '' }}" id="subscribe_btn" data-basketuserid="{{ $user->id }}" data-basketprice="{{ $user->subscription_amount }}" style="cursor: pointer;">
    			        Subscribe
    			        <b>
    			            {{$commonMethods->getCurrencySymbol(strtoupper($user->profile->default_currency))}}
    			            {{number_format($user->subscription_amount, 2) }} p/m
    			        </b>
    			    </label>
    			</div>
    		</div>
    	</div>
        @endif
        @if($stream->more_viewers == 'all_follow' || $stream->more_viewers == 'all_subs_fans_follow')
        @php $counter++ @endphp
    	<div class="user_ls_accord_each">
    		<div class="user_lsa_head">
    			<div class="user_lsah_name">{{$counter}}- Follow {{$user->name}}</div>
    			<div class="user_lsah_ic"><i class="fa fa-caret-down"></i></div>
    		</div>
    		<div class="user_lsa_body">
    			<div class="panel user_follow_outer user_lsa_follow">
                    <div class="user_follow_btn">
                        <div class="user_follow_inner">
                            {{Auth::check() && $user && Auth::user()->isFollowerOf($user) ? 'Following' : 'Follow' }}
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
        @endif
    	@endif
    </div>
</div>
