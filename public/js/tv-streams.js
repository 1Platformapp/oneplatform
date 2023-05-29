$(document).ready(function() {

    var browserWidth = $( window ).width();
    var loadMoreScroll = 130;
    var loadInitialItemsUpcoming = 3;
    var loadInitialItemsPast = 10;
    var loadMoreItems = 3;

    if( browserWidth <= 767 ) {

        var loadMoreScroll = 70;
    }

    $('.each_stream_outer').hide();
    $(".live_streams .each_stream_outer").show();
    $(".channel_streams_right .each_stream_outer").show();
    $(".channel_streams_center .each_stream_outer").show();
    $(".upcoming_streams .each_stream_outer").slice(0, loadInitialItemsUpcoming).show();
    $(".past_streams .each_stream_outer").slice(0, loadInitialItemsPast).show();

    $(".load_more_streams").on('click', function (e) {
        e.preventDefault();
        var parent = $(this).parent();
        parent.find(".each_stream_outer:hidden").slice(0, loadMoreItems).slideDown( "slow", function() {

            $('html,body').animate({
                scrollTop: $(window).scrollTop() + (loadMoreScroll*loadMoreItems) 
            }, 1000);

        });
        if (parent.find(".each_stream_outer:hidden").length == 0) {
            parent.find(".load_more_streams").fadeOut('slow');
        }
    });
});