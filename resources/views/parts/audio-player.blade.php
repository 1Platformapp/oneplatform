
	<script defer src="{{ asset('audio-player/wavesurfer.min.js') }}"></script>
    <script defer src="{{ asset('audio-player/play.min.js') }}"></script>

    <div class="ap_outer">
        <div class="ap_inner">
            <!--<div id="audio-spectrum"></div>!-->
            <div class="only_player">
                <div class="ap_left">
                    <img alt="Audio music file {{isset($user) ? 'from '.$user->name : ''}}" class="ap_track_banner defer_loading" src="#" data-src="{{asset('images/auditiontv.jpg?v=1.1')}}">
                </div>
                <div id="audio-player" class="ap_right">
                    <div class="ap_track_details">
                        <div class="ap_track_title"></div>
                        <div class="ap_track_tools">
                            <div class="ap_tool ap_back"><i id="back" class="disabled fa fa-step-backward"></i></div>
                            <div class="ap_tool ap_current"><i id="play" class="disabled fa fa-play"></i></div>
                            <div class="ap_tool ap_next"><i id="next" class="disabled fa fa-step-forward"></i></div>
                            <div id="audio-spectrum"></div>
                            <div class="ap_tool ap_track_time hide_on_mobile"><span id="time">00:00</span>/<span id="end_time">00:00</span></div>
                            <div class="ap_tool ap_track_volume"><i id="mute" class="fa fa-volume-up"></i></div>
                            <div class="ap_tool track_fav hide_on_mobile"><i id="heart" class="fa fa-heart"></i></div>
                            <div class="ap_tool track_buy hide_on_mobile"><i id="play" class="fa fa-cart-plus"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ap_default instant_hide">
                <audio id="def_audio" controls="no">
                  <source id="def_audio_source" src="#"></source>
                  Your browser does not support the audio format.
                </audio>
            </div>
        </div>
    </div>