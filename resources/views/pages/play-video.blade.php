<html>

	<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.5/mediaelementplayer.min.css" class="switchmediaall">
	    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}" class="switchmediaall">
	    <link rel="stylesheet" href="{{asset('player-element/dist/jump-forward/jump-forward.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/skip-back/skip-back.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/speed/speed.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/chromecast/chromecast.min.css')}}">
	    <link rel="stylesheet" href="{{asset('player-element/dist/context-menu/context-menu.min.css')}}">
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.5/mediaelement-and-player.js"></script>
	    <script src="{{asset('js/my_script.min.js?v=9.92')}}"></script>
	</head>

	<body>
        <div class="content_outer">
            <video id="player1" width="578" height="325" style="width: 100%; height: 100%;" class="vid_preloader" preload="none">
                <source type="video/youtube" src="" />
            </video>
        </div>

        <script>

            $.getScript('https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.5/mediaelement-and-player.js', function() {
                $.getScript('/player-element/dist/jump-forward/jump-forward.min.js', function() {
                    $.getScript('/player-element/dist/skip-back/skip-back.min.js', function() {
                        $.getScript('/player-element/dist/speed/speed.min.js', function() {
                            $.getScript('/player-element/dist/chromecast/chromecast.min.js', function() {
                                $.getScript('/player-element/dist/context-menu/context-menu.min.js', function() {
                                    playMediaElementVideo(0, 'https://www.youtube.com/watch?v={{$id}}', null, 1, null);
                                });
                            });
                        });
                    });
                });
            });
        </script>
	</body>
</html>
