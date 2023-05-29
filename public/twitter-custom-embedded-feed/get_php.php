<?php
session_start();
require_once("twitteroauth/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
 
$twitterUsername = trim($_GET['twitter_username']);
$twitteruser = $twitterUsername;
$notweets = 10000;
$consumerkey = "RuEap7baUGXftm5NSmZIb3TWZ";
$consumersecret = "FcCt4JxRf6Q3UukAU9K4JqyGG3lunMXjOJlu9xhRzcBflykfzZ";
$accesstoken = "2491516098-uzsrO4QjeXQcBQ4GpzAVk3UOiNgYDXuonyS2kWD";
$accesstokensecret = "cNwWCqWqKq9ULZHMt4qEIO0bpHe8GXq4d4SsEaMu7dTMG";
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
 
echo json_encode($tweets);
?>