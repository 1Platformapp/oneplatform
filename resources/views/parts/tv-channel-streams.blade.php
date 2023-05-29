
    @php

    date_default_timezone_set("Europe/London");
    
    if(isset($channel)){

        $where = array(array('video_channel_id', $channel->id)); 
    }else if(isset($tvStream)){
        $tvStream = \App\Models\VideoStream::find($tvStream->id);
        $channel = \App\Models\VideoChannel::find($tvStream->video_channel_id);
        $where = array(array('video_channel_id', $channel->id), array('id' ,'!=', $tvStream->id)); 
    }else{

        $where = array();
    }

    $streams = \App\Models\VideoStream::with('channel')->where($where)->orderBy('live_start_date_time', 'desc')->get();

    $liveStreams = $pastStreams = $upcomingStreams = array();
    foreach ($streams as $key => $stream) {
        if($stream->source == 'youtube'){

            if(strtotime($stream->live_start_date_time) <= time() && strtotime($stream->live_end_date_time) > time()){
                $liveStreams[$key]['id'] = $stream->id;
                $liveStreams[$key]['name'] = $stream->name;
                $liveStreams[$key]['start_date_time'] = $stream->live_start_date_time;
                $liveStreams[$key]['end_date_time'] = $stream->live_end_date_time;
                $liveStreams[$key]['channel_name'] = $stream->channel->title;
                $liveStreams[$key]['youtube_link'] = $stream->youtube_link;
                $liveStreams[$key]['youtube_id'] = $stream->youtube_id;
                $liveStreams[$key]['description'] = $stream->description;
                $liveStreams[$key]['images'] = explode(', ', $stream->images);
                $liveStreams[$key]['default_thumb'] = $stream->default_thumb;
                $liveStreams[$key]['time_formatted'] = $stream->timeFormatted();
            }else if(strtotime($stream->live_start_date_time) < time() && strtotime($stream->live_end_date_time) <= time()){
                $pastStreams[$key]['id'] = $stream->id;
                $pastStreams[$key]['name'] = $stream->name;
                $pastStreams[$key]['start_date_time'] = $stream->live_start_date_time;
                $pastStreams[$key]['end_date_time'] = $stream->live_end_date_time;
                $pastStreams[$key]['channel_name'] = $stream->channel->title;
                $pastStreams[$key]['youtube_link'] = $stream->youtube_link;
                $pastStreams[$key]['youtube_id'] = $stream->youtube_id;
                $pastStreams[$key]['description'] = $stream->description;
                $pastStreams[$key]['images'] = explode(', ', $stream->images);
                $pastStreams[$key]['default_thumb'] = $stream->default_thumb;
                $pastStreams[$key]['time_formatted'] = $stream->timeFormatted();
                $pastStreams[$key]['source'] = 'youtube';
            }else if(strtotime($stream->live_start_date_time) > time() && strtotime($stream->live_end_date_time) > time()){
                $upcomingStreams[$key]['id'] = $stream->id;
                $upcomingStreams[$key]['name'] = $stream->name;
                $upcomingStreams[$key]['start_date_time'] = $stream->live_start_date_time;
                $upcomingStreams[$key]['end_date_time'] = $stream->live_end_date_time;
                $upcomingStreams[$key]['channel_name'] = $stream->channel->title;
                $upcomingStreams[$key]['youtube_link'] = $stream->youtube_link;
                $upcomingStreams[$key]['youtube_id'] = $stream->youtube_id;
                $upcomingStreams[$key]['description'] = $stream->description;
                $upcomingStreams[$key]['images'] = explode(', ', $stream->images);
                $upcomingStreams[$key]['default_thumb'] = $stream->default_thumb;
                $upcomingStreams[$key]['time_formatted'] = $stream->timeFormatted();
            }
        }else if($stream->source == 'google_drive'){

            $pastStreams[$key]['id'] = $stream->id;
            $pastStreams[$key]['name'] = $stream->name;
            $pastStreams[$key]['start_date_time'] = $stream->live_start_date_time;
            $pastStreams[$key]['end_date_time'] = $stream->live_end_date_time;
            $pastStreams[$key]['channel_name'] = $stream->channel->title;
            $pastStreams[$key]['google_file_id'] = $stream->google_file_id;
            $pastStreams[$key]['description'] = $stream->description;
            $pastStreams[$key]['images'] = explode(', ', $stream->images);
            $pastStreams[$key]['default_thumb'] = $stream->default_thumb;
            $pastStreams[$key]['time_formatted'] = $stream->timeFormatted();
            $pastStreams[$key]['source'] = 'google_drive';
        }
    }

    @endphp
        
    @if(count($liveStreams) > 0)
    <div class="stream_contain_outer live_streams">
        <div class="stream_contain_inner">
            @foreach($liveStreams as $key => $stream)
            <div class="each_stream_outer" data-id="{{ $stream['id'] }}">
                @if($loop->first)
                <div class="stream_contain_sub_head">Live Shows</div>
                @endif
                <div class="each_stream_inner tv_page_stream">
                    <div class="each_stream_left">
                        <a class="stream_thumb" href="javascript:void(0)">
                            <img src="{{strpos($stream['youtube_link'], 'vimeo') !== false ? $stream['default_thumb'] : 'https://img.youtube.com/vi/'.$stream['youtube_id'].'/0.jpg'}}" />
                        </a>
                        <ul class="stream_det">
                            <li class="stream_title">{{str_limit($stream['name'], 45)}}</li>
                            <li class="stream_time">
                                {{$stream['time_formatted']}}
                            </li>
                            <li class="stream_channel">{{ $stream['channel_name'] }}</li>
                        </ul>
                    </div>
                    <div class="each_stream_right">
                        <a class="stream_live" href="javascript:void(0)">LIVE</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @php $upcomingStreams = count($upcomingStreams) ? array_reverse($upcomingStreams) : array() @endphp
    @if(count($upcomingStreams) > 0)
    <div class="stream_contain_outer upcoming_streams">
        <div class="stream_contain_inner">
            @foreach($upcomingStreams as $key2 => $stream)
            <div class="each_stream_outer" data-id="{{ $stream['id'] }}">
                @if($loop->first)
                <div class="stream_contain_sub_head">Upcoming Shows</div>
                @endif
                <div class="each_stream_inner tv_page_stream">
                    <div class="each_stream_left">
                        <a class="stream_thumb" href="javascript:void(0)">
                            <img src="{{strpos($stream['youtube_link'], 'vimeo') !== false ? $stream['default_thumb'] : 'https://www.duong.1platform.tv/public/stream-images/thumbs/one/'.$stream['default_thumb']}}" />
                        </a>
                        <ul class="stream_det">
                            <li class="stream_title">{{str_limit($stream['name'], 45)}}</li>
                            <li class="stream_time">
                                {{$stream['time_formatted']}}
                            </li>
                            <li class="stream_channel">{{ $stream['channel_name'] }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(count($pastStreams) > 0)
    <div class="stream_contain_outer past_streams">
        <div class="stream_contain_inner">
            @foreach($pastStreams as $key3 => $stream)
            <div class="each_stream_outer" data-id="{{ $stream['id'] }}">
                @if($loop->first)
                <div class="stream_contain_sub_head">Past Shows</div>
                @endif
                @if($stream['source'] == 'youtube')
                    @if($stream['default_thumb'] !== NULL)
                        @php $thumb = 'https://www.duong.1platform.tv/public/stream-images/thumbs/one/'.$stream['default_thumb'] @endphp
                    @else
                        @php $thumb = 'https://img.youtube.com/vi/'.$stream['youtube_id'].'/0.jpg' @endphp
                    @endif
                @elseif($stream['source'] == 'google_drive')
                    @if($stream['default_thumb'] !== NULL)
                        @php $thumb = 'https://www.duong.1platform.tv/public/stream-images/thumbs/one/'.$stream['default_thumb'] @endphp
                    @else
                        @php $file = 'https://drive.google.com/thumbnail?id='.$stream['google_file_id'].'&authuser=0&sz=w320-h180-n-k-rw' @endphp
                    @endif
                @endif
                <div class="each_stream_inner tv_page_stream">
                    <div class="each_stream_left">
                        <a class="stream_thumb" href="javascript:void(0)">
                            <img src="{{$thumb}}" />
                        </a>
                        <ul class="stream_det">
                            <li class="stream_title">{{str_limit($stream['name'], 45)}}</li>
                            <li class="stream_time">
                                {{$stream['time_formatted']}}
                            </li>
                            <li class="stream_channel">{{ $stream['channel_name'] }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif