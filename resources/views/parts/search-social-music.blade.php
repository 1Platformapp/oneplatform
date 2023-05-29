
	


@if(isset($result))
	@if($result['resultCount'] > 0)
		@foreach($result['results'] as $key => $value)
		    <div class="each_music_search">
		    	<img class="music_search_thumb" src="{{$value['artworkUrl60']}}">
		    	<div class="music_search_body">
		    		<div class="music_search_body_track">{{$value['trackName']}}</div>
		    		<div class="music_search_body_artist">{{$value['artistName']}}</div>
		    		<div class="music_search_body_info">
		    			{{date('Y', strtotime($value['releaseDate'])).' - '.gmdate("i:s", $value['trackTimeMillis'])}}
		    		</div>
		    	</div>
		    	<div class="music_search_actions">
		    		<div data-url="{{urlencode('https://song.link/i/'.$value['trackId'])}}" data-id="{{$value['trackId']}}" class="music_search_action_each add_links">Add Links to my song</div>
		    	</div>
		    </div>         
		@endforeach
	@else
		<div class="music_search_none">No results found</div>
	@endif
@endif
