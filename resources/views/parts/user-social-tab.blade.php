<br><br>

<div class="social_ma_outer">

	@if($user->profile->social_facebook != '' || $user->profile->social_twitter != '')
	<div class="clearfix social_ma_row">
		@if($user->profile->social_facebook != '')
		<div class="fb-page each_social_item">
			<div class="social_ma_head">Facebook</div>
			<iframe src="https://www.facebook.com/plugins/page.php?href={{urlencode($user->profile->social_facebook)}}&tabs=timeline&width=400&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=2036609159758654" width="100%" height="500" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
		</div>
		@endif
		@if($user->profile->social_facebook != '' && $user->profile->social_twitter != '')
		<div class="each_social_separator"></div>
		@endif
		@if($user->profile->social_twitter != '')
		<div class="twitter_feed_outer each_social_item">
			<div class="social_ma_head">Twitter</div>
		    <div id="twitter-feed1"></div>
		    <input type="hidden" id="social_twitter_username" value="{{$user->profile->social_twitter}}">
		    <input type="hidden" id="social_twitter_display_limit" value="{{$commonMethods->getSocialTabTweetsDisplayLimit()}}">
		</div>
		@endif
	</div>
	@endif
	
	@if($user->profile->social_spotify_artist_id != '' || $user->profile->social_youtube != '')
	<div class="clearfix social_ma_row">
		@if($user->profile->social_spotify_artist_id != '')
		<div class="spotify_follow_button_outer each_social_item">
			<div class="social_ma_head">Spotify</div>
			<div id="embed-iframe" data-artist-id="{{$user->profile->social_spotify_artist_id}}"></div>
			<!-- <div id="spotify-follow-button-contain"></div> -->
		</div>
		@endif
		@if($user->profile->social_spotify_artist_id != '' && $user->profile->social_youtube != '')
		<div class="each_social_separator"></div>
		@endif
		@if($user->profile->social_youtube != '')
		<div class="social_youtube_outer each_social_item">
			<div class="social_ma_head">YouTube</div>
			<br>&nbsp;
		    <div id="yt-button-container-render" data-channelid="{{$user->profile->social_youtube}}"></div>
		</div>
		@endif
	</div>
	@endif

	@if($user->profile->social_instagram_user_id != NULL && $user->profile->social_instagram_user_access_token_ll != NULL)
	<div class="clearfix social_ma_row">
		<div class="instagram_feed_outer each_social_item">
			<div class="social_ma_head">Instagram</div>
			<div id="instagram_id"></div><br />
			<a href="javascript:void(0)" id="load-more-instagram-posts"> Load More </a>
		</div>
	</div>
	@endif
</div>


<script src="https://open.spotify.com/embed/iframe-api/v1" async></script>

<script>
	window.onSpotifyIframeApiReady = (IFrameAPI) => {
		const element = document.getElementById('embed-iframe');
		const artistID = $('#embed-iframe').attr('data-artist-id');
		const options = {
			uri: 'spotify:artist:'+artistID,
		};
		const callback = (EmbedController) => {};
		IFrameAPI.createController(element, options, callback);
	};

</script>
