<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Http\Controllers\CommonMethods;

    use App\Models\CompetitionVideo;
    use App\Models\EditableLink;
    use App\Models\EmbedCode;
    use App\Models\TVShow;
    use App\Models\VideoChannel;
    use App\Models\VideoStream;
    use App\Models\User;

    use Carbon\Carbon;
    use Auth;
    use Session;


    class TvController extends Controller {


        public function __construct(){

            $this->middleware('user.update.activity');
        }

        
        public function index( Request $request){

            $commonMethods = new CommonMethods();

            date_default_timezone_set("Europe/London");
            
            $streams = VideoStream::with('channel')->where('video_channel_id', 17)->orderBy('live_start_date_time', 'desc')->get();

            $liveStreams = $pastStreams = $upcomingStreams = array();
            foreach ($streams as $key => $stream) {
                
                if($stream->source == 'youtube' && strtotime($stream->live_start_date_time) <= time() && strtotime($stream->live_end_date_time) > time()){
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
                }
            }

            if (Session::has('loadVideo')) {

                $videoInfo = Session::get('loadVideo');
                if($videoInfo != 0){
                    $defaultStreamId = $videoInfo;
                    $defaultStream = VideoStream::where(['id' => $defaultStreamId])->with('channel')->get()->first();
                    $videoId = $defaultStream->youtube_id;
                }else{
                    $defaultStream = null;
                    //$videoId = 'YGpa9Yyop64';
                    $videoId = '';
                }
                Session::forget('loadVideo');
            }else if(count($liveStreams)){
                $defaultStream = VideoStream::where(['id' => $liveStreams[key($liveStreams)]['id']])->with('channel')->get()->first();
                $videoId = $defaultStream->youtube_id;
            }else{
                $defaultStream = null;
                //$videoId = 'YGpa9Yyop64';
                $videoId = '';
            }

            $basket = $commonMethods::getCustomerBasket();

        

            $data     = [

                'streams'  => $streams,

                'defaultStream'  => $defaultStream,

                'commonMethods' => $commonMethods,

                'basket' => $basket,

                'videoId' => $videoId,

                'tvChannels' => VideoChannel::orderBy('id', 'asc')->get(),

            ];

            return view( 'pages.tv', $data );
    }


    protected function _getLinksData()
    {



            $categories = EditableLink::categories()->get();







            foreach( $categories as $cat )



            {



                $cat->children = EditableLink::linksForCategory( $cat->id )->get();



            }







            return $categories;



        }



        protected function getStreamDetails(Request $request)



        {

            $commonMethods = new CommonMethods();

            $streamDetails['hosts'] = '';

            $streamId = $request->get( 'streamId' );

            $stream = VideoStream::find($streamId);

            $streamDetails['id'] = $stream->id;

            $streamDetails['name'] = $stream->name;

            $streamDetails['channel_name'] = $stream->channel->title;

            $streamDetails['live_status'] = (CommonMethods::streamLiveStatus($stream)) ? '1' : '';

            $streamDetails['upcoming_status'] = $stream->upcomingStatus();

            $streamDetails['time'] = $stream->timeFormatted();

            $streamDetails['youtube_video_id'] = $stream->youtube_id;

            $streamDetails['source'] = $stream->source;

            $streamDetails['google_file_id'] = $stream->google_file_id;

            $streamDetails['video_link'] = $stream->source == 'youtube' ? $stream->youtube_link : $stream->google_file_id;

            $streamDetails['thumb'] = $stream->thumb();
            
            $streamDetails['poster'] = $stream->poster();
            
            $streamDetails['images'] = $stream->images;

            $description = str_replace('<p></p>', '', str_replace('&lt;p&gt;&lt;/p&gt;', '', $stream->description));

            $streamDetails['description'] = $description;

            if($stream->hosts && is_array($stream->hosts) && count($stream->hosts)){

                foreach ($stream->hosts as $key => $userId) {
                    
                    $user = User::find($userId);
                    if(!$user){

                        continue;
                    }

                    $streamDetails['hosts'] .= \View::make('parts.tv-host', ['user' => $user, 'commonMethods' => $commonMethods])->render();
                }
            }

            return $streamDetails;

        }


        public function getTvStreams(Request $request)
        {
            $by = $request->get('by');
            $id = $request->get('id');
            
            $return = '';
            if($by == 'channel'){

                $channel = VideoChannel::find($id);
                if($channel->streams){
                    $return .= \View::make('parts.tv-channel-streams', ['channel' => $channel])->render();
                }
            }
            if($by == 'stream'){

                $stream = VideoStream::find($id);
                if($stream){
                    $return .= \View::make('parts.tv-channel-streams', ['tvStream' => $stream])->render();
                }
            }  

            return $return;          
        }



    }



