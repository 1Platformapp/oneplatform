/**
 * Created by Ahsan Hanif on 01-Oct-17.
 */
function initializeInstagramFancybox(){

    $(".instagram-fancybox").fancybox({
        nextEffect : 'fade',
        prevEffect : 'fade',
        closeExisting: true,
        afterLoad: function() {
            this.title = '<span style="font-weight: bold">' + $(this.element).attr('data-location') + '</span>' + '<br />' + $(this.element).attr('data-caption') + '<br />' + this.title + ' <a style="text-decoration: none; font: 13px Helvetica,Arial,sans-serif; color: #325d81; font-weight: bold;" target="_blank" href="' + $(this.element).attr('data-link') + '"> View On Instagram</a>';
        },
        helpers : {
            title   : {
                type: 'inner'
            },
            thumbs  : {
                width   : 50,
                height  : 50
            }
        }
    });
}
function fillSocialTabWithInstagramFeed(mainTabUserId){

    $.ajax({

        url: '/loadMyRequestData',
        type: 'POST',
        data: {'load_type': 'insta_feed', 'load': mainTabUserId},
        cache: false,
        dataType: 'html',
        success: function (response) {

            $('.instagram_feed_outer #instagram_id').html(response);
        }
    });
}
