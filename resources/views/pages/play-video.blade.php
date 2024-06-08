<html>

	<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.5/mediaelementplayer.min.css" class="switchmediaall">
	    <link rel="stylesheet" href="{{asset('player-element/dist/jump-forward/jump-forward.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/skip-back/skip-back.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/speed/speed.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/chromecast/chromecast.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/context-menu/context-menu.min.css')}}">
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script defer src="{{asset('js/my_script.min.js?v=9.96')}}"></script>
        <style>

        </style>
	</head>

	<body>
        <div class="content_outer">
            <video id="player1" width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader" preload="none">
                <source type="video/youtube" src="https://www.youtube.com/watch?v={{ $id }}" />
            </video>
        </div>

        <script>

            function loadDeferredVideo(){

                if($('.vid_preloader').length){
                    $('.vid_preloader').attr('id', 'player1').removeClass('vid_preloader');
                    var mediaInstancee = playMediaElementVideo(0, 0, 0, 0, 0);
                    return mediaInstancee;
                }

                return 0;
            }

            document.addEventListener("DOMContentLoaded", function(event) {
                setTimeout(function(){

                    $.getScript('https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.5/mediaelement-and-player.js', function() {
                        $.getScript('/player-element/dist/jump-forward/jump-forward.min.js', function() {
                            $.getScript('/player-element/dist/skip-back/skip-back.min.js', function() {
                                $.getScript('/player-element/dist/speed/speed.min.js', function() {
                                    $.getScript('/player-element/dist/chromecast/chromecast.min.js', function() {
                                        $.getScript('/player-element/dist/context-menu/context-menu.min.js', function() {
                                            mediaInstance = loadDeferredVideo();
                                        });
                                    });
                                });
                            });
                        });
                    });
                }, 500);
            })
        </script>
	</body>
</html>
