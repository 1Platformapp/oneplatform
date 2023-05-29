
        function playAudioTrack(spectrum, audioFile, autoPlay = false){

            $('#play').addClass('fa-spinner').addClass('fa-spin').addClass('disabled').removeClass('fa-pause');
            $('.each_loop,.each_stem').removeClass('active');
            var defAudioPlayer = document.getElementById('def_audio');
            var defAudioSource = document.getElementById('def_audio_source');

            var browserWidth = $( window ).width();
            if( browserWidth > 767 ) {

                if(spectrum){

                    spectrum.destroy();
                }

                var Spectrum = WaveSurfer.create({
                    container: document.querySelector('#audio-spectrum'),
                    progressColor: "#27282A",
                    barHeight: 1,
                    barWidth: 2,
                    responsive: true,
                    audioRate: 1,     //speed of the play
                    waveColor: "#e0e0e0",
                    hideScrollbar: true,
                    height: 35,
                    normalize: true,
                });

                Spectrum.load(audioFile);

                Spectrum.on('audioprocess', function () {
                    
                    var currentTime = Spectrum.getCurrentTime();
                    $('#time').text(getTime(currentTime));
                });

                Spectrum.on('finish', function () {
                    
                    $('#next').trigger('click');
                });

                Spectrum.on('ready', function () {

                    finalPreparations(autoPlay, Spectrum);
                });

            }else{

            	defAudioSource.src = audioFile;
	            defAudioPlayer.load();
	            defAudioPlayer.oncanplay = function() {
	                finalPreparations(autoPlay, defAudioPlayer);
	            };
            }


            
            $('#play').unbind( "click" ).click(function(){

            	if($(this).hasClass('disabled')){

                }else{

                    if( browserWidth > 767 ) {

                        var duration = Spectrum.getDuration();
                        $('#end_time').text(getTime(duration));

                        if(Spectrum.isPlaying()){
                            $('#play').addClass('fa-play').removeClass('fa-pause');
                        }else{
                            $('#play').removeClass('fa-spinner').removeClass('fa-spin').removeClass('fa-play').addClass('fa-pause');
                        }

                        Spectrum.playPause();
                    }else{

                        if (defAudioPlayer.duration > 0 ) {

                            if(defAudioPlayer.paused){
                                defAudioPlayer.play();
                                $('#play').removeClass('fa-spinner').removeClass('fa-spin').removeClass('fa-play').addClass('fa-pause');
                            }else{
                                defAudioPlayer.pause();
                                $('#play').addClass('fa-play').removeClass('fa-pause');
                            }
                        }
                    }
                }
            });

            $('#mute').unbind( "click" ).click(function(){

            	if( browserWidth > 767 ) {

                    Spectrum.toggleMute();

                    if(Spectrum.getMute()){
                        $('#mute').addClass('fa-volume-off').removeClass('fa-volume-up');
                    }else{
                        $('#mute').addClass('fa-volume-up').removeClass('fa-volume-off');
                    }
                }else{

                    if(defAudioPlayer.muted){
                        defAudioPlayer.muted = false;
                        $('#mute').addClass('fa-volume-up').removeClass('fa-volume-off');
                    }else{
                        defAudioPlayer.muted = true;
                        $('#mute').addClass('fa-volume-off').removeClass('fa-volume-up');
                    }
                }
            });

            if( browserWidth > 767 ) {

                return Spectrum;
            }else{

                return defAudioPlayer;
            }
        }

        function finalPreparations(autoPlay, spec){

            var browserWidth = $( window ).width();

            // pause video player instance if any
            if(typeof mediaInstance != typeof undefined && mediaInstance != false){

                mediaInstance.pause();
            }

            if (typeof window.currentAudioElement !== 'undefined'){

                var thiss = window.currentAudioElement;
                thiss.find('.play_now').removeClass('instant_hide');
                thiss.find('.loading_smg').addClass('instant_hide');
                thiss.removeClass('audio_loading');
                delete window.currentAudioElement;
                musicHoverSupport();
            }

            $('#play').removeClass('disabled');

            if(autoPlay){

                if( browserWidth > 767 ) {

                    var duration = spec.getDuration();
                    $('#end_time').text(getTime(duration));

                    if(spec.isPlaying()){
                        $('#play').addClass('fa-play').removeClass('fa-pause');
                    }else{
                        $('#play').removeClass('fa-spinner').removeClass('fa-spin').removeClass('fa-play').addClass('fa-pause');
                    }

                    spec.playPause();
                }else{

                    if (spec.duration > 0 ) {

                    	$('#end_time').text(getTime(spec.duration));
                        spec.play();
                        $('#play').removeClass('fa-spinner').removeClass('fa-spin').removeClass('fa-play').addClass('fa-pause');
                    }
                }
            }
        }

        function getTime(t) {
            var m=~~(t/60), s=~~(t % 60);
            return (m<10?"0"+m:m)+':'+(s<10?"0"+s:s);
        }


        function updateAndPlayAudioPlayer(sourceElement, audioFile, autoPlay){
                
            var thiss = sourceElement;
            var defAudioPlayer = document.getElementById('def_audio');
            var defAudioSource = document.getElementById('def_audio_source');

            if(thiss.find('.play_now').length){
                window.currentAudioElement = sourceElement;
                thiss.addClass('audio_loading');
                thiss.find('.play_now').addClass('instant_hide');
                thiss.find('.loading_smg').removeClass('instant_hide');
                thiss.find('.summary').unbind('hover mouseenter mouseleave');
            }

            if(thiss.prev().hasClass('each-music')){
                var prevMusic = thiss.prev();
            }else{ prevMusic = null; }
            if(thiss.next().hasClass('each-music')){
                var nextMusic = thiss.next();
            }else{ nextMusic = null; }
            if(prevMusic !== null){
                $('.ap_outer #audio-player').attr('data-prevmusicid', prevMusic.attr('data-musicid'));
                $('#back').removeClass('disabled');
            }else{
                $('.ap_outer #audio-player').attr('data-prevmusicid', 0);
                $('#back').addClass('disabled');
            }
            if(nextMusic !== null){
                $('.ap_outer #audio-player').attr('data-nextmusicid', nextMusic.attr('data-musicid'));
                $('#next').removeClass('disabled');
            }else{
                $('.ap_outer #audio-player').attr('data-nextmusicid', 0);
                $('#next').addClass('disabled');
            }
            
            $('.ap_outer #audio-player').attr('data-musicid', thiss.attr('data-musicid'));
            $('.ap_outer .ap_track_banner').attr('src', '/user-music-thumbnails/'+thiss.attr('data-thumbnail-player'));
            $('.ap_outer .ap_track_title').html(thiss.find('.thismusic_song_name').text()+'<br>'+thiss.find('.thismusic_user_name').text());          

            if(thiss.find('.music_actions .fav_np').hasClass('active')){
                $('.ap_outer .track_fav').addClass('active');
            }else{
                $('.ap_outer .track_fav').removeClass('active');
            }

            $('.ap_outer').show(); 

            if(typeof spectrum !== 'undefined'){
                spectrum = playAudioTrack(spectrum, audioFile, autoPlay);
            }else{
                spectrum = playAudioTrack(null, audioFile, autoPlay);
            }            
        }

        $('document').ready(function(){

            $('body').delegate( '.each_loop', 'click', function(e){

                var thiss = $(this);
                if(thiss.parents('.each-music').length){

                    var parent = thiss.parents('.each-music');
                }else{

                    var parent = thiss.parents('.each-album-music');
                }
                updateAndPlayAudioPlayer(parent, '/user-music-files/loops/' + thiss.attr('data-musicfile'), true);
                thiss.addClass('active');
            });

            $('body').delegate( '.each_stem', 'click', function(e){
                
                var thiss = $(this);
                if(thiss.parents('.each-music').length){

                    var parent = thiss.parents('.each-music');
                }else{

                    var parent = thiss.parents('.each-album-music');
                }
                updateAndPlayAudioPlayer(parent, '/user-music-files/stems/' + thiss.attr('data-musicfile'), true);
                thiss.addClass('active');
            });

            $('#back').click(function(){

                if($(this).hasClass('disabled')){

                }else{

                    var prevTrack = $('.ap_outer #audio-player').attr('data-prevmusicid');
                    if($('.each-music[data-musicid="'+prevTrack+'"]').length){

                        var thiss = $('.each-music[data-musicid="'+prevTrack+'"]');
                        if($('.each-music.active_video_list_chan_tab').length){
                            $('.each-music.active_video_list_chan_tab').first().find('.add_to_cart_item').slideUp(function(){

                                $('.each-music.active_video_list_chan_tab').first().removeClass('active_video_list_chan_tab');
                            });
                        }
                        updateAndPlayAudioPlayer(thiss, '/user-music-files/' + thiss.attr('data-musicfile'), true);
                    }
                }
            });

            $('#next').click(function(){

                if($(this).hasClass('disabled')){

                }else{
                    var nextTrack = $('.ap_outer #audio-player').attr('data-nextmusicid');
                    if($('.each-music[data-musicid="'+nextTrack+'"]').length){

                        var thiss = $('.each-music[data-musicid="'+nextTrack+'"]');
                        if($('.each-music.active_video_list_chan_tab').length){
                            $('.each-music.active_video_list_chan_tab').first().find('.add_to_cart_item').slideUp(function(){

                                $('.each-music.active_video_list_chan_tab').first().removeClass('active_video_list_chan_tab');
                            });
                        }
                        updateAndPlayAudioPlayer(thiss, '/user-music-files/' + thiss.attr('data-musicfile'), true);
                    }
                }
            });
        });