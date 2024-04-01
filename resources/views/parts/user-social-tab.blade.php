<br><br>

<div class="social_ma_outer">

	@if($user->profile->social_facebook != '' || $user->profile->social_twitter != '')
	<div class="flex flex-col clearfix gap-1 border-black md:flex-row border-y-2">
		@if($user->profile->social_facebook != '')
		<div class="w-full md:w-1/2 genHeight h-550">
			<div class="social_ma_head">Facebook</div>
			<iframe class="w-full h-550" src="https://www.facebook.com/plugins/page.php?href={{urlencode($user->profile->social_facebook)}}&tabs=timeline&width=500&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=2036609159758654" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
		</div>
		@endif
		@if($user->profile->social_facebook != '' && $user->profile->social_twitter != '')
		<!-- <div class="each_social_separator"></div> -->
		@endif
		@if($user->profile->social_twitter != '')
		<div class="w-full md:w-1/2 genHeight h-550">
			<div class="social_ma_head">Twitter</div>
		    <div id="twitter-feed1" class="w-full"></div>
		    <input type="hidden" id="social_twitter_username" value="{{$user->profile->social_twitter}}">
		    <input type="hidden" id="social_twitter_display_limit" value="{{$commonMethods->getSocialTabTweetsDisplayLimit()}}">
		</div>
		@endif
	</div>
	@endif

	@if($user->profile->social_spotify_artist_id != '' || $user->profile->social_youtube != '')
	<div class="flex flex-col clearfix gap-1 border-black md:flex-row border-y-2">
		@if($user->profile->social_spotify_artist_id != '')
		<div class="w-full md:w-1/2">
			<div class="social_ma_head">Spotify</div>
			<div id="embed-iframe" data-artist-id="{{$user->profile->social_spotify_artist_id}}"></div>
			<!-- <div id="spotify-follow-button-contain"></div> -->
		</div>
		@endif
		@if($user->profile->social_spotify_artist_id != '' && $user->profile->social_youtube != '')
		<!-- <div class="each_social_separator"></div> -->
		@endif
		@if($user->profile->social_youtube != '')
		<div class="w-full md:w-1/2">
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
function loadTwitterFeed() {
    var twitterprofile = $('#social_twitter_username').val();
    if (twitterprofile.length) {
        $.getScript('https://platform.twitter.com/widgets.js', function() {
            $('#twitter-feed1').html('<a class="twitter-timeline" href="https://twitter.com/' + twitterprofile + '?ref_src=twsrc%5Etfw">Tweets by ' + twitterprofile + '</a>');
        });
    }
}

function loadSpotifyIframe() {
    const artistID = $('#embed-iframe').attr('data-artist-id');
    if (artistID) {
        window.onSpotifyIframeApiReady = (IFrameAPI) => {
            const element = document.getElementById('embed-iframe');
            const options = {
                uri: 'spotify:artist:' + artistID,
            };
            const callback = (EmbedController) => {};
            IFrameAPI.createController(element, options, callback);
        };
    }
}

try {
    loadTwitterFeed();
} catch (error) {
    console.error('Error loading Twitter feed:', error);
}

try {
    loadSpotifyIframe();
} catch (error) {
    console.error('Error loading Spotify iframe:', error);
}

</script>

<style scoped>
.h-550 { height: 550px;}
.genHeight { overflow-y: auto; overflow-x: hidden; }
.genHeight::-webkit-scrollbar { width: 4px; }
.genHeight::-webkit-scrollbar-track { box-shadow: inset 0 0 3px grey; border-radius: 10px; }
.genHeight::-webkit-scrollbar-thumb { background: black; border-radius: 10px; }
</style>