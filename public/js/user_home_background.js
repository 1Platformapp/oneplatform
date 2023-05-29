$(document).ready(function() {


    setInterval(function(){

        if($('.feat_template').length > 2){
            //$('.feat_template:visible:first #feat_nav_arrow_right').trigger('click');
        }
    }, 5000);



    $('body').on( "click", ".each_user_video", function(e) {
        $('#soundcloudPlayer, .mejs__container').removeClass('instant_hide');
        $('.content_outer').addClass('playing');
    });
    $('body').on( "click", ".tab_btn_play_project,.tp_sec_play_project,.top_info_outer", function(e) {
        $('.mejs__container').removeClass('instant_hide');
        $('.content_outer').addClass('playing');
    });

});