/**
 * Created by Ahsan Hanif on 01-Oct-17.
 */
function fillSocialTabWithSpotifyFeed(userId){

    $('#spotify-follow-button-contain').html('');
    $.get( "/get-spotify-content" , { userId: userId} , function( data ) {
        if( data ){

            $('#spotify-follow-button-contain').html(data);
        }
    });
}