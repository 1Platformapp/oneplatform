
<div class="tab_chanel_list_outer" id="user_tab_vid">

    <div class="user_videos_outer">

    	@if(count($user->liveStreams))
            @php $counter = 0 @endphp
        	@foreach($user->liveStreams as $stream)

                @if($counter == 0)
                    <h2 class="tabd2_head">Premium Videos</h3>
                @endif

                @include('parts.user-channel-stream-template',['stream' => $stream])

                @php $counter++ @endphp

        	@endforeach
            <br><br><div class="spacer"></div>
    	@endif

        <h2 class="tabd2_head">Video & SoundCloud</h3>
        @foreach($user->uploads as $upload)

            @include('parts.user-channel-video-template',['video'=>$upload])

        @endforeach

    </div>

</div>