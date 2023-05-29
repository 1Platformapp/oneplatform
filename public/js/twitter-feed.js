/**
 * Created by Ahsan Hanif on 01-Oct-17.
 */
function fillSocialTabWithTwitterFeed(){

    $('#twitter-feed').html('');
    $('#twitter-feed1').html('');

    var displaylimit = parseInt( $('#social_twitter_display_limit').val() );
    var twitterprofile = $('#social_twitter_username').val();
    var screenname = '';
    var showdirecttweets = false;
    var showretweets = true;
    var showtweetlinks = true;
    var showprofilepic = true;
    var showtweetactions = true;
    var showretweetindicator = true;
    var headerHTML = '';
    var loadingHTML = '';

    if( twitterprofile.length ){

        headerHTML += '<div class="twitter_feed_head"><i class="fab fa-twitter"></i>';
        headerHTML += '<a id="twitter-profile-username" href="https://twitter.com/'+twitterprofile+'" target="_blank">@'+twitterprofile+'</a></div>';
        loadingHTML += '<div id="loading-container"><img src="/img/ajax-loader.gif" width="32" height="32" alt="tweet loader" /></div>';

        $.getJSON('/get-twitter-content/'+twitterprofile,
            function(feeds) {
                //alert(feeds);
                var feedHTML = '<div class="twitter_feed_body">';
                var displayCounter = 1;
                for (var i=0; i<feeds.length; i++) {
                    var tweetscreenname = feeds[i].user.name;
                    var tweetusername = feeds[i].user.screen_name;
                    var profileimage = feeds[i].user.profile_image_url_https;
                    var status = feeds[i].text;
                    var isaretweet = false;
                    var isdirect = false;
                    var tweetid = feeds[i].id_str;

                    //If the tweet has been retweeted, get the profile pic of the tweeter
                    if(typeof feeds[i].retweeted_status != 'undefined'){
                        profileimage = feeds[i].retweeted_status.user.profile_image_url_https;
                        tweetscreenname = feeds[i].retweeted_status.user.name;
                        tweetusername = feeds[i].retweeted_status.user.screen_name;
                        tweetid = feeds[i].retweeted_status.id_str;
                        status = feeds[i].retweeted_status.text;
                        isaretweet = true;
                    };


                    //Check to see if the tweet is a direct message
                    if (feeds[i].text.substr(0,1) == "@") {
                        isdirect = true;
                    }

                    //console.log(feeds[i]);

                    //Generate twitter feed HTML based on selected options
                    if (((showretweets == true) || ((isaretweet == false) && (showretweets == false))) && ((showdirecttweets == true) || ((showdirecttweets == false) && (isdirect == false)))) {
                        if ((feeds[i].text.length > 1) && (displayCounter <= displaylimit)) {
                            if (showtweetlinks == true) {
                                status = addlinks(status);
                            }

                            if (displayCounter == 1) {
                                feedHTML += headerHTML;
                                feedHTML += '<div class="twitter_scroll_body">';
                            }

                            feedHTML += '<div onmouseout="hideTweetsAction(this)" onmouseover="showTweetsAction(this)" class="twitter-article" id="tw'+displayCounter+'">';
                            feedHTML += '<div class="twitter-pic"><a href="https://twitter.com/'+tweetusername+'" target="_blank"><img class="user-pic img-circle" src="'+profileimage+'"twitter-feed-icon.png" alt="twitter icon" /></a></div>';
                            feedHTML += '<div class="twitter-text"><div class="tweet-head"><div class="tweet-head-left"><a href="https://twitter.com/'+tweetusername+'" target="_blank">@'+tweetusername+'</a></div><div class="tweet-head-right">'+relative_time(feeds[i].created_at)+'</div></div><div class="tweet-body">'+status+'</div>';

                            if ((isaretweet == true) && (showretweetindicator == true)) {
                                feedHTML += '<div id="retweet-indicator"></div>';
                            }
                            if (showtweetactions == true) {
                                feedHTML += '<div class="twitter-actions"><div class="inside"><div class="intent" id="intent-reply"><a target="_blank" href="https://twitter.com/intent/tweet?in_reply_to='+tweetid+'" title="Reply"></a></div><div class="intent" id="intent-retweet"><a target="_blank" href="https://twitter.com/intent/retweet?tweet_id='+tweetid+'" title="Retweet"></a></div><div class="intent" id="intent-fave"><a target="_blank" href="https://twitter.com/intent/favorite?tweet_id='+tweetid+'" title="Favourite"></a></div></div></div>';
                            }

                            feedHTML += '</div>';
                            feedHTML += '</div>';
                            displayCounter++;
                        }
                    }
                }

                feedHTML += '</div></div>';

                //Add twitter action animation and rollovers

                $('#twitter-feed').html(feedHTML);
                $('#twitter-feed1').html(feedHTML);

            }).error(function(jqXHR, textStatus, errorThrown) {
            var error = "";
            if (jqXHR.status === 0) {
                error = 'Connection problem. Check file path and www vs non-www in getJSON request';
            } else if (jqXHR.status == 404) {
                error = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                error = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                error = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                error = 'Time out error.';
            } else if (exception === 'abort') {
                error = 'Ajax request aborted.';
            } else {
                error = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            alert("error: " + error);

        });
    }

}

function hideTweetsAction(elem){

    $(elem).find('.twitter-actions').removeClass('show');
    $(elem).find('.twitter-pic').find('img').first().removeClass('img-highlighted');
    $(elem).find('.twitter-text').removeClass('highlighted');
}
function showTweetsAction(elem){

    $(elem).find('.twitter-text').addClass('highlighted');
    $(elem).find('.twitter-pic').find('img').first().addClass('img-highlighted');
    $(elem).find('.twitter-actions').addClass('show');
}
function addlinks(data) {
    //Add link to all http:// links within tweets
    data = data.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
        return '<a href="'+url+'"  target="_blank">'+url+'</a>';
    });

    //Add link to @usernames used within tweets
    data = data.replace(/\B@([_a-z0-9]+)/ig, function(reply) {
        return '<a href="http://twitter.com/'+reply.substring(1)+'" style="font-weight:lighter;" target="_blank">'+reply.charAt(0)+reply.substring(1)+'</a>';
    });
    //Add link to #hastags used within tweets
    data = data.replace(/\B#([_a-z0-9]+)/ig, function(reply) {
        return '<a href="https://twitter.com/search?q='+reply.substring(1)+'" style="font-weight:lighter;" target="_blank">'+reply.charAt(0)+reply.substring(1)+'</a>';
    });
    return data;
}

function relative_time(time_value) {
    var values = time_value.split(" ");
    time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
    var parsed_date = Date.parse(time_value);
    var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
    var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
    var shortdate = values[0] + " " + values[1] + " " + values[2] + " " + values[5];
    delta = delta + (relative_to.getTimezoneOffset() * 60);

    if (delta < 60) {
        return '1m';
    } else if(delta < 120) {
        return '1m';
    } else if(delta < (60*60)) {
        return (parseInt(delta / 60)).toString() + 'm';
    } else if(delta < (120*60)) {
        return '1h';
    } else if(delta < (24*60*60)) {
        return (parseInt(delta / 3600)).toString() + 'h';
    } else if(delta < (48*60*60)) {
        //return '1 day';
        return shortdate;
    } else {
        return shortdate;
    }
}