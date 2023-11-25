<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use App\Models\CrowdfundBasket;
use App\Models\UserPortfolio;
use App\Models\AgentContact;
use App\Models\UserChatGroup;
use App\Models\UserChat;
use App\Models\CustomProduct;
use App\Models\CustomerBasket;
use App\Models\CampaignPerks as CampaignPerk;
use App\Models\EmbedCode;
use App\Models\SiteProgram;
use App\Models\SiteProgramElement;
use App\Models\UserCampaign as UserCampaign;
use App\Models\Profile;
use App\Models\UserAlbum;
use App\Models\IndustryContact;
use App\Models\UserMusic;
use App\Models\UserProduct;use App\Models\StripeCheckout;
use App\Models\StripeSubscription;
use App\Models\City;
use App\Models\Country;use App\Models\Competition;
use App\Models\CompetitionVideo;
use App\Models\VideoStream;
use App\Models\User;
use App\Models\Skill;

use App\Http\Controllers\IndustryContactController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommonMethods;
use App\Http\Controllers\UserNotificationController;

use App\Mail\License as LicenseMail;
use App\Mail\Agent as AgentMail;

use DB;
use Hash;
use Auth;
use Session;
use Mail;


class ChartController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity');
    }


    public function index(Request $request)

    {

        $videos = [];

        $commonMethods = new CommonMethods();

        $competition = Competition::first();

        if( $competition ) {

            $videos = $competition->videos()->with( 'profile.user' )->has('profile.user')->where(['show_in_cart' => 1])->whereNotNull('rank')->orderBy('rank','asc')->get();
        }


        if (session::has('loadVideo')) {

            $videoInfo = Session::get('loadVideo');
            Session::forget('loadVideo');
            $explode = explode('~', $videoInfo);
            $userrId = $explode[1];

            $defaultVideoId = $explode[0];
            $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);
            if($userrId > 0){
                $video = CompetitionVideo::where('video_id', $defaultVideoId)->get()->first();
                $user = $video->profile->user;
            }else{
                $user = null;
                $defaultVideoId = $explode[0];
                $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);
            }
        }else{

            $user = null;
            //$defaultVideoId = 'lXro7nXDDy0';
            $defaultVideoId = '0cSXq4TYIIk';
            $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);
        }

        $basket = $commonMethods::getCustomerBasket();

        if($user){

            $userCampaignDetails = $commonMethods->getUserRealCampaignDetails($user->id);

            $userPersonalDetails = $commonMethods->getUserRealDetails($user->id);

            $allPastProjects = userCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();
        }

        if (session::has('chartAutoShare')) {

            $autoShare = Session::get('chartAutoShare');
            Session::forget('chartAutoShare');
        }


        $data   = [

            'videos' => $videos,

            'user' => $user,

            'commonMethods' => $commonMethods,

            'userCampaignDetails' => isset($userCampaignDetails) ? $userCampaignDetails : null,

            'userPersonalDetails' => isset($userPersonalDetails) ? $userPersonalDetails : null,

            'basket' => isset($basket) ? $basket : null,

            'defaultVideoId' => $defaultVideoId,

            'defaultVideoTitle' => $defaultVideoTitle,

            'allPastProjects' => isset($allPastProjects) ? $allPastProjects : null,

            'autoShare' => isset($autoShare) ? $autoShare : null,

        ];

        return view( 'pages.chart', $data );
    }

    public function masterUser(Request $request)
    {

        if ($request->isMethod('post')) {

            $emailAddress = $request->get('email');
            $password = $request->get('password');
            $userEmail = $request->get('fghj');
            $admins = Config('constants.admins');

            if($emailAddress != '' && $password != '' && $userEmail != ''){

                $user = User::where(['email' => $emailAddress])->first();
                $loginUser = User::where(['email' => $userEmail])->orWhere('username', $userEmail)->first();

                if($loginUser){

                    if($user && $user->id == $admins['masteradmin']['user_id']){

                        if($checkpass = Hash::check($request->password, $user->password) ){

                            Auth::login($loginUser);

                            return redirect(route('profile'));
                        }
                    }else{

                        return redirect()->back()->with(['error' => 'Not a master user']);
                    }
                }else{

                    return redirect()->back()->with(['error' => 'Target user not found']);
                }
            }
        }

        $data = [


        ];

        return view( 'pages.master-user', $data );
    }

    public function autoShare($type, Request $request)
    {

        if ($type == null || $type == ''){

            return redirect('site.home');
        }

        Session::put('chartAutoShare', $type);

        return redirect(route('chart'));
    }

    public function pciPolicy(Request $request)
    {

        return view( 'pages.pci-policy' );
    }

    public function videoShare($videoId, $userName, $url, Request $request){

        $referer = $request->headers->get('referer');
        $commonMethods = new CommonMethods();

        if(strpos($url, 'project') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            $user = User::find($userId);
            $redirect = route('user.project', ['username' => $user->username]);
            $image = 'https://img.youtube.com/vi/'.$videoId.'/maxresdefault.jpg';
            $videoTitle = $commonMethods->getVideoTitle($videoId);
        }else if(strpos($url, 'chart') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            $user = User::find($userId);
            $redirect = route('chart');
            $image = 'https://img.youtube.com/vi/'.$videoId.'/maxresdefault.jpg';
            $videoTitle = $commonMethods->getVideoTitle($videoId);
        }else if(strpos($url, 'userhome') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            $user = User::find($userId);
            $redirect = route('user.home', ['params' => $user->username]);
            $image = 'https://img.youtube.com/vi/'.$videoId.'/maxresdefault.jpg';
            $videoTitle = $commonMethods->getVideoTitle($videoId);
        }else if(strpos($url, 'live') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            $user = User::find($userId);
            $redirect = route('live');
            $image = 'https://img.youtube.com/vi/'.$videoId.'/maxresdefault.jpg';
            $videoTitle = $commonMethods->getVideoTitle($videoId);
        }else if(strpos($url, 'tv') !== false){

            $explode = explode('_', $url);
            $user = null;
            $redirect = route('tv');
            $stream = VideoStream::find($videoId);
            $image = $stream ? $stream->poster() : '';
            $videoTitle = $stream ? $stream->channel->title : '';
        }else{

            $user = null;
        }

        if(strpos($referer, 'facebook.com') || strpos($referer, 'https://t.co/') !== false ){

            Session::flash('loadVideo', $videoId.'~'.($user?$user->id:0));
            return redirect($redirect);
        }else{

            $data   = [
                'image' => $image,
                'url' => $url,
                'description' => trim($videoTitle),
                'title' => trim($userName).' - 1Platform TV',
                'videoId' => $videoId,
                'user' => $user,
            ];

            return view( 'parts.video-share', $data );
        }

        return '';
    }

    public function itemRedirect(Request $request, $type, $id){

        if($type == 'home'){

            $user = User::find($id);

            if($user){

                Session::flash('exempt_splash', '1');
                return redirect(route('user.home', ['params' => $user->username]));
            }
        }
    }

    public function itemShareOld($itemType, $itemId, $itemSlug, Request $request){

        $commonMethods = new CommonMethods();

        $itemId = base64_decode($itemId);
        $item = $itemType == 'product' ? UserProduct::where('id', $itemId)->first() : UserMusic::where('id', $itemId)->first();
        if($item){
            if($itemType == 'product'){
                return redirect(route('item.share.product', ['itemSlug' => $item->slug]), 301);
            }else if($itemType == 'track'){
                return redirect(route('item.share.track', ['itemSlug' => $item->slug]), 301);
            }
        }else{
            abort(404);
        }
    }

    public function itemShare($itemSlug, Request $request){

        $referer = $request->headers->get('referer');
        $commonMethods = new CommonMethods();

        $product = UserProduct::where('slug', $itemSlug)->first();
        $music = UserMusic::where('slug', $itemSlug)->first();
        if($product){
            $item = $product;
            $type = 'product';
        }else if($music){
            $item = $music;
            $type = 'track';
        }else{
            $item = null;
        }

        if(isset($item) && $item){

            if($type == 'product'){

                $title = $item->title;
                $thumbnail = $item->thumbnail != '' ? asset('user-product-thumbnails/'.$item->thumbnail) : '';
                $description = $item->description;
            }else if($type == 'track'){

                $title = $item->song_name;
                $thumbnail = $item->thumbnail_feat != '' ? asset('user-music-thumbnails/'.$item->thumbnail_feat) : '';
                $description = 'Artist: '.$item->user->name;
            }

            $data   = [
                'image' => $thumbnail,
                'description' => $description,
                'title' => $title,
                'item' => $item,
                'type' => $type,
                'user' => $item->user,
                'userProfileImage' => $commonMethods->getUserDisplayImage($item->user->id),
                'commonMethods' => $commonMethods,
            ];

            return view('pages.item-details', $data);

        }else{

            return 'something went wrong';
        }
    }

    public function urlShare($url, $userName, $imageName, Request $request){

        $referer = $request->headers->get('referer');
        $commonMethods = new CommonMethods();

        $imageName = base64_decode($imageName);

        if(strpos($url, 'project') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            $user = User::find($userId);
            $redirect = route('user.project', ['username' => $user->username]);
            //$imageName = asset('user-display-images/'.$imageName);
            $imageName = 'https://img.youtube.com/vi/'.$imageName.'/hqdefault.jpg';
            $title = 'Click Here To Support '.$user->name;
            $description = str_limit(strip_tags($user->profile->story_text, '<br>'), 200, '...');
            $description = trim(str_replace('<br>', '.', $description), '.');
        }else if(strpos($url, 'userhome') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            $user = User::find($userId);
            $redirect = route('user.home', ['params' => $user->username]);
            $imageName = asset('user-display-images/'.$imageName);
            $title = $user->name.' - '.$user->skills.' - 1Platform TV';
            $description = str_limit(strip_tags($user->profile->story_text, '<br>'), 200, '...');
            $description = trim(str_replace('<br>', '.', $description), '.');
        }else if(strpos($url, 'chart') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            if($userId > 0){
                $user = User::find($userId);
                $redirect = route('user.home', ['params' => $user->username]);
                $title = $user->name.' - '.$user->skills.' - 1Platform TV';
                $description = str_limit(strip_tags($user->profile->story_text, '<br>'), 200, '...');
                $description = str_replace('<br>', '.', $description);
                $imageName = asset('user-display-images/'.$imageName);
            }else{
                $redirect = route('chart');
                $title = $userName;
                $description = '1Platform TV chart lets you compete you with musicians and singers across the whole platform.';
                $imageName = asset('images/'.$imageName);
            }
        }else if(strpos($url, 'tv') !== false){

            $explode = explode('_', $url);
            $streamId = $explode[1];
            $redirect = route('tv');

            if($streamId != 0){
                $stream = VideoStream::find($streamId);

                $title = $stream->name.' - '.$stream->channel->title;
                $description = $stream->timeFormatted();
                $user = $stream;
            }else{
                $title = '1Platform TV';
                $description = 'Checkout the latest content from 1Platform TV. With interviews, with artists and live performances.';
            }
        }else if(strpos($url, 'live') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            if($userId > 0){
                $user = User::find($userId);
                $imageName = asset('user-display-images/'.$imageName);
                $title = $user->name.' - The Auditon Studio';
                $description = str_limit(strip_tags($user->profile->story_text, '<br>'), 200, '...');
                $description = str_replace('<br>', '.', $description);
                $redirect = route('user.home', ['params' => $user->username]);
            }else{
                $imageName = asset('images/'.$imageName);
                $title = $userName;
                $description = '1Platform is used by professional musicians, singers, studios and music producers worldwide.';
                $redirect = route('live');
            }


        }else if(strpos($url, 'search') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            if($userId > 0){
                $user = User::find($userId);
                $imageName = asset('user-display-images/'.$imageName);
                $title = $user->name.' - The Auditon License';
                $description = str_limit(strip_tags($user->profile->story_text, '<br>'), 200, '...');
                $description = str_replace('<br>', '.', $description);
                $redirect = route('user.home', ['params' => $user->username]);
            }else{
                $imageName = asset('images/'.$imageName);
                $title = $userName;
                $description = '1Platform is used by professional musicians, singers, studios and music producers worldwide.';
                $redirect = route('search');
            }


        }else if(strpos($url, 'profilethankyou') !== false){

            $explode = explode('_', $url);
            $userId = $explode[1];
            $user = $userId ? User::find($userId) : NULL;
            $redirect = $user ? route('user.home', ['params' => $user->username]) : route('site.home');
            $title = $userName;
            $description = 'We thank all our supporters and fans for supporting us on 1Platform TV';

            $sellerId = $explode[2];
            $seller = User::find($sellerId);
            $type = $explode[count($explode)-3];
            $id = end($explode);

            if($seller && $id && $type == 'subscription'){
                $subs = StripeSubscription::find($id);
                $subs->thankyou_sent = 1;
                $subs->save();
            }
            if($seller && $id && $type == 'checkout'){
                $subs = StripeCheckout::find($id);
                $subs->thank_you_sent = 1;
                $subs->save();
            }
        }else{

            $user = null;
        }


        if(strpos($referer, 'facebook.com') || strpos($referer, 'https://t.co/') !== false ){

            if(strpos($url, 'tv') !== false){
                Session::flash('loadVideo', $streamId);
            }
            return redirect($redirect);
        }else{

            $data   = [
                'image' => $imageName,
                'url' => $url,
                'description' => $description,
                'title' => $title,
            ];

            return view( 'parts.url-share', $data );
        }

        return '';
    }


    // public profile page

    public function getProfile(Request $request, $userId, $videoId = null)

    {



        $videos = [];

        $videoId = null;

        $commonMethods = new CommonMethods();

        $user = User::find($userId);



        $competition = Competition::last()->first();

        if( $competition ) {



            $videos = $competition->videos()->with( 'profile.user.address', 'profile.job' )->where("profile_id", $user->profile->id)->orderBy( DB::raw( 'ISNULL(`rank`),`rank`' ) )->get();

        }



        $firstVideoId = "";

        if($videos->first()){

            $firstVideoId = $videos->first()->video_id;

        }



        //$userDetails = $commonMethods->getUserDetailsByVideoId($firstVideoId);







        $defaultVideoId = ( $videoId ) ? $videoId : $firstVideoId;



        $userCampaignDetails = $commonMethods->getUserCampaignDetails($userId);

        $userPersonalDetails = $commonMethods->getUserPersonalDetails($userId);

        $userSocialAccountDetails = $commonMethods::getUserSocialAccountDetails($userId);

        $verticalSliderItems = \App\Models\ScrollerSetting::all();



        $musics = $user->musics;

        $products = $user->products;

        $myChannelVideos = $user->profile->competitionVideos;

        $checkouts = $user->checkouts;

        $basket = $commonMethods::getCustomerBasket();

        $fbUserProfiles = Profile::where("social_facebook", '<>',  "")->get();

        $youtubeUserProfiles = Profile::where("social_youtube", '<>',  "")->get();

        $allPastProjects = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();



        $data   = [



            'videos' => $videos,

            'user' => $user,

            'commonMethods' => $commonMethods,

            'userCampaignDetails' => $userCampaignDetails,

            'userPersonalDetails' => $userPersonalDetails,

            'verticalSliderItems' => $verticalSliderItems,

            'musics' => $musics,

            'products' => $products,

            'myChannelVideos' => $myChannelVideos,

            'checkouts' => $checkouts,

            'basket' => $basket,

            'defaultVideoId' => $defaultVideoId,

            'userSocialAccountDetails' => $userSocialAccountDetails,

            'fbUserProfiles' => $fbUserProfiles,

            'youtubeUserProfiles' => $youtubeUserProfiles,

            'allPastProjects' => $allPastProjects



        ];

        return view( 'pages.public-profile', $data );

    }

    // public profile page



    public function getUserCompleteInfo(Request $request){



        $userId = $request->userId;

        $user = User::find($userId);

        $userCompleteInfo[] = '';

        $view = $view2 = $view3 = $view4 = $view5 = $music_add_to_cart_view = $prod_add_to_cart_view = $iFrame = '';



        $commonMethods = new CommonMethods();

        $userCampaignDetails = $commonMethods::getUserCampaignDetails($userId);

        $userPersonalDetails = $commonMethods::getUserPersonalDetails($userId);

        $userSocialAccountDetails = $commonMethods::getUserSocialAccountDetails($userId);



        $userMusics = $user->musics;

        $userProducts = $user->products;

        $userChannelVideos = $user->profile->competitionVideos;

        $checkouts = $user->checkouts;



        $userSpotifyDetails = $commonMethods::getUserSpotifyDetails($userId);

        if( isset( $userSpotifyDetails['error'] ) && isset( $userSpotifyDetails['error']['message'] ) ){



            if( $userSpotifyDetails['error']['message'] == 'The access token expired' ){



                $commonMethods::refreshUserSpotifyAccessToken($userId);

                $userSpotifyDetails = $commonMethods::getUserSpotifyDetails($userId);

            }

        }

        if( isset( $userSpotifyDetails['uri'] ) && $userSpotifyDetails['uri'] != '' ){



            $iFrame = '<iframe src="https://open.spotify.com/follow/1?uri='.$userSpotifyDetails['uri'].'&size=detail&theme=light" scrolling="no" style="border:none; overflow:hidden; width: 100%;" allowtransparency="true" height="56" frameborder="0"></iframe>';

        }



        $userCompleteInfo['user_name'] = $userPersonalDetails['name'];

        $userCompleteInfo['user_city'] = $userPersonalDetails['city'];

        $userCompleteInfo['user_skills'] = $userPersonalDetails['skills'];

        $userCompleteInfo['user_display_image'] = $userPersonalDetails['user_display_image'];

        $userCompleteInfo['user_campaign_title'] = $userCampaignDetails['user_campaign_title'];

        $userCompleteInfo['user_story_text'] = $userPersonalDetails['story_text'];

        $userCompleteInfo['user_story_images'] = $userPersonalDetails['story_images'];

        $userCompleteInfo['user_total_amount_raised'] = $userCampaignDetails['user_total_amount_raised'];

        $userCompleteInfo['user_project_donators'] = count( $userCampaignDetails['user_project_donators'] );

        $userCompleteInfo['user_campaign_goal'] = $userCampaignDetails['user_campaign_goal'];

        $userCompleteInfo['user_campaign_days_left_upper_text'] = $userCampaignDetails['user_campaign_days_left_upper_text'];

        $userCompleteInfo['user_campaign_days_left_lower_text'] = $userCampaignDetails['user_campaign_days_left_lower_text'];

        $userCompleteInfo['user_campaign_amount_raised_percent'] = $userCampaignDetails['user_campaign_amount_raised_percent'];

        $userCompleteInfo['user_total_products'] = $userCampaignDetails['user_total_products'];

        $userCompleteInfo['user_project_share_link'] = $userPersonalDetails['user_project_share_link'];

        $userCompleteInfo['user_project_share_image'] = $userCampaignDetails['user_project_share_image'];

        $userCompleteInfo['user_facebook_account'] = $userSocialAccountDetails['facebook_account'];

        $userCompleteInfo['user_youtube_account'] = $userSocialAccountDetails['youtube_account'];

        $userCompleteInfo['user_instagram_access_token'] = $userSocialAccountDetails['instagram_user_access_token'];

        $userCompleteInfo['user_instagram_id'] = $userSocialAccountDetails['instagram_user_id'];

        $userCompleteInfo['user_twitter_account'] = $userSocialAccountDetails['twitter_account'];

        $userCompleteInfo['user_spotify_access_token'] = $userSocialAccountDetails['spotify_user_access_token'];

        $userCompleteInfo['user_spotify_refresh_token'] = $userSocialAccountDetails['spotify_user_refresh_token'];

        $userCompleteInfo['user_spotify_iframe'] = $iFrame;

        $userCompleteInfo['project_video'] = $userCampaignDetails['project_video'];

        $userCompleteInfo['user_campaign_goal_text'] = $userCampaignDetails['user_campaign_goal_text'];

        $userCompleteInfo['support_me_link'] = $userCampaignDetails['support_me_link'];

        $userCompleteInfo['user_campaign_amount'] = $userCampaignDetails['user_campaign_amount'];



        foreach($userMusics as $key => $userMusic){



            $view .= \View::make('parts.user-channel-music-template', ['music' => $userMusic, 'commonMethods' => $commonMethods]);

        }

        $userMusicHTML = (string) $view;

        $userAddCartMusicHTML = '';

        foreach($userProducts as $key => $product){



            $view2 .= \View::make('parts.user-channel-product-template', ['userProduct' => $product, 'commonMethods' => $commonMethods]);

        }

        $userProductsHTML = (string) $view2;

        $userAddCartProductHTML = '';

        foreach($userChannelVideos as $key => $video){



            $view3 .= \View::make('parts.user-channel-video-template', ['video' => $video, 'commonMethods' => $commonMethods]);

        }

        $userVideosHTML = (string) $view3;

        $albums = $user->albums;

        $albums_view = '';
        foreach($albums as $key => $album){



            $albums_view .= \View::make('parts.user-channel-album-template', ['album' => $album, 'commonMethods' => $commonMethods]);

        }



        $userAlbumsHTML = (string) $albums_view;



        if(count($checkouts) > 0){



            foreach($checkouts as $key => $checkout){

                if($checkout->customer && $checkout->type == 'crowdfund') {

                    $view4 .= \View::make('parts.user-fan-template', ['fanType' => 'contributer', 'checkout' => $checkout, 'commonMethods' => $commonMethods]);

                }

            }

        }

        $userFansHTML = (string) $view4;

        if(count($checkouts) > 0){



            foreach($checkouts as $key => $checkout){

                if($checkout->customer && $checkout->type == 'instant') {

                    $view5 .= \View::make('parts.user-fan-template', ['fanType' => 'buyer', 'checkout' => $checkout, 'commonMethods' => $commonMethods]);

                }

            }

        }

        $userFansHTML .= (string) $view5;



        $userCompleteInfo['user_music_html'] = $userMusicHTML;

        $userCompleteInfo['user_products_html'] = $userProductsHTML;

        $userCompleteInfo['user_videos_html'] = $userVideosHTML;

        $userCompleteInfo['user_fans_html'] = $userFansHTML;

        $userCompleteInfo['user_albums_html'] = $userAlbumsHTML;

        $userCompleteInfo['user_add_to_cart_music_html'] = $userAddCartMusicHTML;

        $userCompleteInfo['user_add_to_cart_product_html'] = $userAddCartProductHTML;



        return $userCompleteInfo;

    }



    public function postCustomerBasket(Request $request){

        session_start();

        $customer = Auth::user();
        $extraInfo = '';

        if($customer){

            $_SESSION['basket_customer_id'] = $customer->id;

        }else if(!isset($_SESSION['basket_customer_id'])){

            $_SESSION['basket_customer_id'] = time();

        }

        if($request->purchase_type == 'music'){

            $findItem = UserMusic::find($request->music_id);

            if(!$findItem){

                $return["error"] = 'Music does not exist';
                return $return;
            }
            $licenses = config('constants.licenses');
            foreach ($licenses as $key1 => $license) {
                if($license['filename'] == $request->basket_license){
                    $licenseName = $license['input_name'];
                }
            }
            if($request->basket_license == 'Personal Use Only'){
                $licenseName = 'personal_use_only';
            }
            if($licenseName != ''){
                $basketPrice = $findItem->{$licenseName};
            }else{
                $return["error"] = 'Music license is invalid';
                return $return;
            }
        }
        if($request->purchase_type == 'album'){

            $findItem = UserAlbum::find($request->album_id);

            if(!$findItem){

                $return["error"] = 'Album does not exist';
                return $return;
            }

            $basketPrice = $findItem->price;
        }
        if($request->purchase_type == 'product'){

            $findItem = UserProduct::find($request->product_id);

            if(!$findItem){

                $return["error"] = 'Product does not exist';
                return $return;
            }

            $basketPrice = $findItem->price;
        }
        if($request->purchase_type == 'custom_product'){

            $findItem = UserProduct::find($request->product_id);

            if(!$findItem || !$findItem->customProduct() || $findItem->customProduct()->status != 1){

                $return["error"] = 'This product is currently inactive';
                return $return;
            }

            $basketPrice = $findItem->price;
        }
        if($request->purchase_type == 'proferred-product'){

            $findItem = UserChat::where(['id' => $request->chat_id, 'sender_id' => $request->basket_user_id])->whereNotNull('product')->first();

            if(!$findItem || !isset($findItem->product['price'])){

                $return["error"] = 'Product does not exist';
                return $return;
            }

            $basketPrice = $findItem->product['price'];
            $extraInfo = 'chat_'.$findItem->id;
        }
        if($request->purchase_type == 'instant-license'){

            $findItem = UserChat::where(['id' => $request->chat_id, 'sender_id' => $request->basket_user_id])->whereNotNull('agreement')->first();

            if(!$findItem || !isset($findItem->agreement['price'])){

                $return["error"] = 'Music does not exist';
                return $return;
            }

            $basketPrice = $findItem->agreement['price'];
            $extraInfo = 'chat_'.$findItem->id;
        }
        if($request->purchase_type == 'project'){

            $findItem = UserChat::where(['id' => $request->chat_id, 'sender_id' => $request->basket_user_id])->whereNotNull('project')->first();

            if(!$findItem || !isset($findItem->project['price'])){

                $return["error"] = 'Project does not exist';
                return $return;
            }

            $basketPrice = $findItem->project['price'];
            $extraInfo = 'chat_'.$findItem->id;
        }

        $sameUserFlag = true;

        $basketUser = '';

        $currentUser = User::find($request->basket_user_id);

        $buyerUser = User::find($_SESSION['basket_customer_id']);

        $basket = CommonMethods::getCustomerBasket();

        foreach ($basket as $b){

            if($b->user_id != $request->basket_user_id){

                $basketUser = $b->user;

                $sameUserFlag = false;

                break;

            }

        }

        $return = [];

        $return['basketHTML'] = '';

        $return['basketCount'] = '';

        $return['error'] = '';

        $return['basketId'] = '';

        if(!$sameUserFlag){

            $return['error'] = 'You can only purcahse from one store at a time. Please buy or remove the items in your basket from '.$basketUser->name;

            return $return;

        }

        if($request->purchase_type == 'subscription'){

            $subscriptionCheck = CustomerBasket::where('purchase_type', 'subscription')->where('user_id', $request->basket_user_id)->where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 0)->get();
            if(count($subscriptionCheck)){

                $return["error"] = 'subscribed already';
                return $return;
            }

            $basketPrice = $currentUser->subscription_amount;
        }

        if($request->purchase_type == 'donation_goalless'){

            $basketPrice = $request->basket_price;
        }

        if(!$currentUser->internalSubscription || $currentUser->profile->stripe_secret_key == '' ){

            $return["error"] = 'You cannot purchase from this user';
            return $return;
        }

        if($buyerUser && $group = $currentUser->isGroupMateOf($buyerUser)){

            $return['error'] = 'You can only purchase from this user through your agent ('.$group->agent->name.') from your network chat';
            return $return;
        }

        if($basketPrice == 0){

            $basketPrice = $request->basket_price;
        }

        $customerBasket = new CustomerBasket();

        $customerBasket->user_id =  $request->basket_user_id;

        $customerBasket->customer_id =  $_SESSION['basket_customer_id'];

        $customerBasket->product_id =  $request->product_id;

        $customerBasket->music_id =  $request->music_id;

        $customerBasket->purchase_type =  $request->purchase_type;

        $customerBasket->license = $request->purchase_type == 'music' || $request->purchase_type == 'instant-license' ? $request->basket_license : '';

        $customerBasket->extra_info = $extraInfo;

        $customerBasket->price =  $basketPrice;

        $customerBasket->album_id =  $request->album_id;

        $customerBasket->save();

        $basket = CommonMethods::getCustomerBasket();

        $view = '';

        $view = \View::make('parts.smart-cart', ['basket' => $basket])->render();

        $return['basketHTML'] = $view;

        $return['basketCount'] = count($basket);

        $return['basketId'] = $customerBasket->id;

        if($_SERVER['HTTP_HOST'] == config('constants.primaryDomain')){
            $return['checkout'] = route('user.checkout', ['userId' => $customerBasket->user_id]);
            $return['checkoutType'] = 'normal_checkout';
        }else{
            if($basket->first() && $basket->first()->user->isCotyso()){
                $return['checkout'] = 'https://'.$_SERVER['HTTP_HOST'].'/personalized-checkout';
                $return['checkoutType'] = 'normal_checkout';
            }else{
                $return['checkout'] = route('user.checkout.merge', ['customerId' => $customerBasket->customer_id]);
                $return['checkoutType'] = 'merge_checkout';
            }
        }

        return $return;
    }

    public function undoCustomerBasket(Request $request){

        session_start();
        $view = "";

        if(isset($request->basket) && $request->basket != '' && isset($_SESSION['basket_customer_id'])){

            $customerBasket = CustomerBasket::find($request->basket);
            if($customerBasket){
                if($customerBasket->customer_id == $_SESSION['basket_customer_id']){

                    $customerBasket->delete();
                    $message = 'Deleted';

                    $basket = CommonMethods::getCustomerBasket();

                    $view = \View::make('parts.smart-cart', ['basket' => $basket])->render();
                }else{
                    $message = 'You are not the owner';
                }
            }else{
                $message = 'Item Invalid';
            }
        }else{
            $message = 'Data inalid';
        }

        return array('message' => $message, 'basketHTML' => $view);
    }

    public function informationFinder(Request $request){

        $commonMethods = new CommonMethods();
        if ($request->isMethod('post') && $request->has('find') && $request->has('find_type') && $request->has('identity') && $request->has('identity_type')) {

            $user = (Auth::check()) ? Auth::user() : 0;
            $error = '';
            $success = 0;
            $data = null;
            $accessGranted = 0;

            $identity = $request->get('identity');
            $find = $request->get('find');
            $identityType = $request->get('identity_type');
            $findType = $request->get('find_type');

            if($identityType == 'checkout_user'){
                $checkout = StripeCheckout::find($identity);
                if($checkout && $checkout->user && $user && $checkout->user->id == $user->id){
                    if(strpos($findType, 'user_personal_information') !== false){
                        foreach ($user->checkouts as $key => $checkoutt) {
                            if($checkoutt->customer && $checkoutt->customer->id == $find){
                                $accessGranted = 1;
                            }
                        }
                    }else if($findType == 'checkout_customer' || $findType == 'thank_customer'){
                        $accessGranted = 1;
                    }
                }else{
                    $error = 'Given identity is invalid';
                }
            }
            if($identityType == 'checkout_customer'){
                $checkout = StripeCheckout::find($identity);
                if($checkout && $checkout->customer && $user && $checkout->customer->id == $user->id){
                    if(strpos($findType, 'user_personal_information') !== false){
                        if($checkout->user->id == $find){
                            $accessGranted = 1;
                        }
                    }else if($findType == 'checkout_user'){
                        $accessGranted = 1;
                    }
                }else{
                    $error = 'Given identity is invalid';
                }
            }

            if($findType == 'username-availability' || $findType == 'email-availability'){
                $accessGranted = 1;
            }

            if($identityType == 'free_buyer' && $findType == 'user_free_seller_information'){
                $accessGranted = 1;
            }

            if($identityType == 'pod_buyer' && $findType == 'countries'){
                $accessGranted = 1;
            }

            if($identityType == 'guest_register' && $findType == 'email_duplication_truth'){
                $accessGranted = 1;
            }

            if($identityType == 'guest' && $findType == 'city_validation'){
                $accessGranted = 1;
            }

            if(($identityType == 'chart_user' || $identityType == 'studio_user') && $findType == 'url_owner_id'){
                $accessGranted = 1;
            }

            if($findType == 'crowdfund_shipping' && $identityType == 'crowd_funder'){
                $accessGranted = 1;
            }

            if($findType == 'user_services_panel'){
                $accessGranted = 1;
            }

            if($identityType == 'chart_user' && (strpos($findType, 'user_personal_information') !== false || strpos($findType, 'user_campaign_information') !== false)) {

                $video = CompetitionVideo::where('video_id', $identity)->orWhere('link', $identity)->first();
                if($video !== null && $video->profile !== null && $video->profile->user->id == $find){
                    $accessGranted = 1;
                }

            }

            if($identityType == 'user' && $findType == 'contact_code') {

                $user = User::find($identity);
                $group = UserChatGroup::find($find);
                if($user && $group){
                    if($group->contact->id == $user->id || $group->agent->id == $user->id){

                        $contact = AgentContact::where(['contact_id' => $group->contact->id, 'agent_id' => $group->agent->id])->first();
                        $accessGranted = 1;
                    }
                }
            }

            if($identityType == 'studio_user' && (strpos($findType, 'user_personal_information') !== false || strpos($findType, 'user_campaign_information') !== false)) {

                $profile = Profile::where('user_bio_video_id', $identity)->first();
                if($profile !== null && $profile->user->id == $find){
                    $accessGranted = 1;
                }

            }

            if($identityType == 'guest' && $findType == 'portfolio_details') {

                $accessGranted = 1;
            }

            if($identityType == 'guest' && $findType == 'site_program') {

                $accessGranted = 1;
            }

            if($findType == 'user_chart_entries' && $identityType == 'self'){
                $find = Auth::user()->id;
                $accessGranted = 1;
            }

            if($identityType == 'subscription_user'){
                $subscription = StripeSubscription::find($identity);
                if($subscription && $subscription->user && $user && $subscription->user->id == $user->id){
                    if(strpos($findType, 'user_personal_information') !== false){
                        foreach ($user->stripe_subscriptions as $key => $subscriptionn) {
                            if($subscriptionn->customer->id == $find){
                                $accessGranted = 1;
                            }
                        }
                    }else if($findType == 'thank_subscription' || $findType == 'thank_subscriber'){
                        $accessGranted = 1;
                    }
                }else{
                    $error = 'Given identity is invalid';
                }
            }

            if($identityType == 'subscriber' && $findType == 'industry_contacts' && $user && $user->hasActivePaidSubscription()) {

                $accessGranted = 1;
            }

            if($identityType == 'subscriber' && $findType == 'management-plan' && $user) {

                $accessGranted = 1;
            }

            if($identityType == 'subscriber' && $findType == 'contact-management' && $user) {

                $accessGranted = 1;
            }

            if($identityType == 'subscriber' && $findType == 'my-calendar' && $user) {

                $accessGranted = 1;
            }

            if($identityType == 'subscriber' && $findType == 'industry_contact_details' && $user && $user->hasActivePaidSubscription()) {

                $accessGranted = 1;
            }

            if($identityType == 'crowd_funder' && $findType == 'stripe_card_expiration') {

                $user = User::find($identity);
                if($user){
                    $campaignDet = $commonMethods->getUserRealCampaignDetails($user->id);
                    if($campaignDet['isLive'] == 1){
                        $accessGranted = 1;
                    }else{
                        $accessGranted = 0;
                    }
                }else{
                    $accessGranted = 0;
                }
            }

            if($identityType == 'subscription_customer' && $findType == 'subscription_offers'){

                $user = User::find($identity);
                $subscription = StripeSubscription::find($find);
                if($user && $subscription->customer && $subscription->customer->id == $user->id){
                    $accessGranted = 1;
                }else{
                    $accessGranted = 0;
                }
            }

            if($identityType == 'pod_buyer' && $findType == 'pod_delivery_cost'){

                $accessGranted = 1;
            }

            if($accessGranted == 1){
                if($findType == 'username-availability'){
                    $user = User::where('username', $find)->get()->first();
                    $data = '';
                    $error = '';
                    if ($user) {
                        $success = 0;
                    } else {
                        $success = 1;
                    }
                }
                if($findType == 'email-availability'){
                    $user = User::where('email', $find)->get()->first();
                    $data = '';
                    $error = '';
                    if ($user) {
                        $success = 0;
                    } else {
                        $success = 1;
                    }
                }
                if(strpos($findType, 'user_personal_information') !== false){
                    $userr = User::find($find);
                    if($userr){

                        $success = 1;
                        $data = $commonMethods->getUserRealDetails($userr->id);
                    }else{
                        $error = 'Target information does not exist';
                    }
                }
                if(strpos($findType, 'user_free_seller_information') !== false){
                    $userr = User::find($find);
                    if($userr){

                        $success = 1;
                        $data['name'] = $userr->name;
                        $data['currency'] = $userr->profile->default_currency;
                        $data['currencySymbol'] = $commonMethods->getCurrencySymbol(strtoupper($userr->profile->default_currency));
                        $data['skill'] = $userr->skills;
                    }else{
                        $error = 'Target information does not exist';
                    }
                }
                if(strpos($findType, 'user_campaign_information') !== false){
                    $userr = User::find($find);
                    if($userr){

                        $success = 1;
                        $data = $commonMethods->getUserRealCampaignDetails($userr->id);
                    }else{
                        $error = 'Target information does not exist';
                    }
                }
                if($findType == 'email_duplication_truth'){

                    $user = User::where('email', $find)->get();
                    if(count($user)){

                        $data['duplicated'] = 1;
                        $success = 1;
                    }else{
                        $data['duplicated'] = 0;
                        $success = 1;
                    }
                }
                if($findType == 'city_validation'){

                    if(City::where('name', trim($find))->exists()){

                        $success = 1;
                    }else{
                        $cityMatching = DB::select('SELECT name FROM aud_cities WHERE soundex(name)=soundex("'.trim($find).'")');
                        //City::where('name', 'like', '%'.trim($find).'%')->first();
                        if ($cityMatching !== null && count($cityMatching)) {

                            $cityNames = '';
                            foreach ($cityMatching as $key => $cityMatch) {
                                $cityNames .= $cityMatch->name.',';
                                if($key == 2){ break; }
                            }
                            $error = 'Do you mean:'.trim($cityNames, ',');
                        }else{
                            $error = 'Invalid city';
                        }
                        $success = 0;
                    }
                }
                if($identityType == 'chart_user' && $findType == 'url_owner_id'){

                    $video = CompetitionVideo::where('video_id', $find)->orWhere('link', $find)->first();
                    if($video !== null && $video->profile !== null && $video->profile->user !== null){

                        $data['userId'] = $video->profile->user->id;
                        $success = 1;
                    }else{
                        $error = 'Target information does not exist';
                    }
                }
                if($identityType == 'studio_user' && $findType == 'url_owner_id'){

                    $profile = Profile::where('user_bio_video_id', $find)->first();
                    if($profile !== null && $profile->user !== null){

                        $data['userId'] = $profile->user->id;
                        $success = 1;
                    }else{
                        $error = 'Target information does not exist';
                    }
                }
                if(strpos($findType, 'user_chart_entries') !== false){
                    $userr = User::find($find);
                    if($userr){

                        $chartEntries = DB::table('competition_videos')->where(['show_in_cart' => 1, 'profile_id' => $userr->profile->id])->get();
                        $data['chartEntries'] = count($chartEntries);
                        $success = 1;
                    }else{
                        $error = 'Target information does not exist';
                    }
                }
                if($findType == 'crowdfund_shipping' && $find == 'total' && $request->has('user') && $request->has('selected_country')){
                    if(Auth::check()){
                        $customerId = Auth::user()->id;
                    }else if (session::has('crowdfundCustomerId')) {
                        $customerId = Session::get('crowdfundCustomerId');
                    }else{
                        $customerId = 0;
                    }
                    if($customerId){

                        $seller = User::find($request->get('user'));
                        $selectedCountry = $request->get('selected_country');
                        $sellerDefaultCurrency = strtoupper($seller->profile->default_currency);
                        $sellerCountry = ($seller->address) ? $seller->address->country_id : 0;
                        $shippingTotal = 0;

                        $bonuses = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $seller->id, 'type' => 'bonus'])->get();
                        foreach ($bonuses as $key => $basketItem) {
                            $bonus = CampaignPerk::find($basketItem->bonus_id);
                            if($bonus){
                                if($sellerCountry == $selectedCountry){
                                    if($sellerDefaultCurrency != $basketItem->currency){
                                        $bonusShipping = $commonMethods->convert($sellerDefaultCurrency, $basketItem->currency, $bonus->my_country_delivery_cost);
                                    }else{
                                        $bonusShipping = $bonus->my_country_delivery_cost;
                                    }
                                }else{
                                    if($sellerDefaultCurrency != $basketItem->currency){
                                        $bonusShipping = $commonMethods->convert($sellerDefaultCurrency, $basketItem->currency, $bonus->worldwide_delivery_cost);
                                    }else{
                                        $bonusShipping = $bonus->worldwide_delivery_cost;
                                    }
                                }
                                $shippingTotal += $bonusShipping;

                                $basketItem->shipping = $bonusShipping;
                                $basketItem->save();
                            }
                        }
                        $data['shippingTotal'] = $shippingTotal;
                        $success = 1;
                    }else{
                        $error = 'Insufficient data';
                    }
                }
                if(strpos($findType, 'portfolio_details') !== false){
                    $portfolio = UserPortfolio::find($find);
                    if($portfolio){

                        $data2 = \View::make('parts.user-portfolio-details', ['portfolio' => $portfolio, 'commonMethods' => $commonMethods])->render();
                        $data['data'] = $data2;
                        $success = 1;
                    }else{
                        $error = 'Target information does not exist';
                    }
                }
                if(strpos($findType, 'site_program') !== false){
                    $program = SiteProgram::find($find);
                    if($program){

                        $data2 = \View::make('parts.site-program-details', ['program' => $program, 'commonMethods' => $commonMethods])->render();
                        $data['data'] = $data2;
                        $success = 1;
                    }else{
                        $error = 'Target information does not exist';
                    }
                }
                if($findType == 'contact_code'){

                    $data['url'] = route('agent.contact.details', ['code' => $contact->code]);
                    $success = 1;
                }
                if($findType == 'industry_contacts'){

                    $explode = explode('_', $find);

                    if(isset($explode[0]) && $explode[0] != ''){
                        $request->request->add(['category_filter' => $explode[0]]);
                    }
                    if(isset($explode[1]) && $explode[1] != ''){
                        $request->request->add(['city_filter' => $explode[1]]);
                    }
                    if(isset($explode[2]) && $explode[2] != ''){
                        $request->request->add(['page' => $explode[2]]);
                    }
                    if(isset($explode[3]) && $explode[3] == '1'){
                        $request->request->add(['is_fav' => '1']);
                    }

                    $industryContact = new IndustryContactController();
                    $industryContactsArray = json_decode($industryContact->browse($request), TRUE);
                    if(is_array($industryContactsArray) && isset($industryContactsArray['data'])){
                        $data['data'] = $industryContactsArray['data'];
                        $data['total_records'] = $industryContactsArray['total_records'];
                        $success = 1;
                    }else{
                        $error = 'Error';
                    }
                }
                if($findType == 'management-plan'){
                    $skills =
                    $data['data'] = \View::make('parts.management-plans', ['commonMethods' => $commonMethods, 'user' => $user])->render();
                    $success = 1;
                }
                if($findType == 'contact-management'){

                    $skills = Skill::all();
                    $data['data'] = \View::make('parts.contact-management.index', ['commonMethods' => $commonMethods, 'user' => $user, 'skills' => $skills])->render();
                    $success = 1;
                }
                if($findType == 'my-calendar'){

                    $data['data'] = \View::make('parts.calendar', ['commonMethods' => $commonMethods, 'user' => $user])->render();
                    $success = 1;
                }
                if($findType == 'industry_contact_details'){

                    $contact = IndustryContact::find($find);
                    $data['name'] = $contact->name;
                    $data['phone'] = $contact->telephone;
                    $data['email'] = $contact->email;

                    $data['website'] = '';
                    if($contact->website != ''){
                        $data['website'] = '<a target="_blank" href="http://'.$contact->website.'">http://'.$contact->website.'</a>';
                    }
                    if($contact->website2 != ''){
                        $data['website'] .= ' - '.'<a target="_blank" href="http://'.$contact->website2.'">http://'.$contact->website2.'</a>';
                    }
                    $data['website'] = trim($data['website'], ' - ');

                    $data['address'] = '';
                    if($contact->address != ''){
                        $data['address'] = $contact->address;
                    }
                    if($contact->address2 != ''){
                        $data['address'] .= ', '.$contact->address2;
                    }
                    if($contact->address3 != ''){
                        $data['address'] .= ', '.$contact->address3;
                    }
                    if($contact->address4 != ''){
                        $data['address'] .= ', '.$contact->address4;
                    }
                    if($contact->address5 != ''){
                        $data['address'] .= ', '.$contact->address5;
                    }
                    if($contact->postcode != ''){
                        $data['address'] .= ', '.$contact->postcode;
                    }
                    $data['address'] = trim($data['address'], ', ');

                    $data['twitter'] = '';
                    if($contact->twitter != ''){
                        $data['twitter'] = '<a target="_blank" href="https://www.twitter.com/'.$contact->twitter.'">https://www.twitter.com/'.$contact->twitter.'</a>';
                    }
                    $data['facebook'] = '';
                    if($contact->facebook != ''){
                        $data['facebook'] = '<a target="_blank" href="https://www.facebook.com/'.$contact->facebook.'">https://www.facebook.com/'.$contact->facebook.'</a>';
                    }
                    $data['youtube'] = '';
                    if($contact->youtube != ''){
                        $data['youtube'] = '<a target="_blank" href="https://www.youtube.com/'.$contact->youtube.'">https://www.youtube.com/'.$contact->youtube.'</a>';
                    }
                    $data['instagram'] = '';
                    if($contact->instagram != ''){
                        $data['instagram'] = '<a target="_blank" href="https://www.instagram.com/'.$contact->instagram.'">https://www.instagram.com/'.$contact->instagram.'</a>';
                    }
                    $data['soundcloud'] = '';
                    if($contact->soundcloud != ''){
                        $data['soundcloud'] = '<a target="_blank" href="https://www.soundcloud.com/'.$contact->soundcloud.'">https://www.soundcloud.com/'.$contact->soundcloud.'</a>';
                    }

                    $data['information'] = $contact->notes;
                    $success = 1;
                }
                if($findType == 'stripe_card_expiration'){

                    $tokenId = $find;
                    $url = 'https://api.stripe.com/v1/tokens/'.$tokenId;
                    $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                    array_push($headers, 'Stripe-Account: '.$user->profile->stripe_user_id);
                    $fields = [];
                    $token = $commonMethods->stripeCall($url, $headers, $fields, 'GET');
                    $expMonth = $token['card']['exp_month'];
                    $expYear = $token['card']['exp_year'];

                    $projectWillExpireTimestamp = strtotime($campaignDet['willExpireOn']);
                    $cardExpiresTimestamp = strtotime(date($expYear.'-'.$expMonth.'-01 00:00:00'));

                    if($cardExpiresTimestamp < $projectWillExpireTimestamp && $campaignDet['campaignCharity'] != 1){

                        $data['endDate'] = date('d-m-Y', $projectWillExpireTimestamp);
                        $success = 0;
                    }else{
                        $success = 1;
                    }
                }
                if($findType == 'user_services_panel'){

                    $user = User::find($find);
                    if($user){

                        $data2 = \View::make('parts.user-services-panel', ['user' => $user, 'search' => 1, 'commonMethods' => $commonMethods])->render();
                        $data['html'] = $data2;
                        $success = 1;
                    }else{
                        $success = 0;
                    }
                }
                if($findType == 'checkout_customer'){

                    $checkout = StripeCheckout::find($find);
                    if($checkout){

                        $success = 1;
                        $data = [

                            'name' => $checkout->name,
                            'email' => $checkout->email,
                            'address' => $checkout->address,
                            'city' => $checkout->city,
                            'postcode' => $checkout->postcode,
                            'country' => $checkout->country
                        ];
                    }else{
                        $success = 0;
                    }
                }
                if($findType == 'checkout_user'){

                    $checkout = StripeCheckout::find($find);
                    if($checkout){

                        $success = 1;
                        $data = [

                            'name' => $checkout->user->name,
                            'email' => $checkout->user->email
                        ];
                    }else{
                        $success = 0;
                    }
                }
                if($findType == 'thank_customer' || $findType == 'thank_subscriber'){

                    $checkout = ($findType == 'thank_customer') ? StripeCheckout::find($find) : StripeSubscription::find($find);
                    if($checkout){

                        $success = 1;
                        if($checkout->customer){

                           $data = $commonMethods->getUserRealDetails($checkout->customer->id);
                           $data['id'] = $checkout->customer->id;
                        }else{
                            $data = [
                                'id' => 0,
                                'name' => $checkout->name,
                                'email' => $checkout->email,
                                'profilePageLink' => '',
                                'profileImageOriginal' => $commonMethods->getUserDisplayImage(0),
                            ];
                        }
                    }else{
                        $success = 0;
                    }
                }
                if($findType == 'subscription_offers'){

                    $subscription = StripeSubscription::find($find);
                    if($subscription){

                        $success = 1;
                        $data = [

                            'image' => $commonMethods->getUserDisplayImage($subscription->user->id),
                            'heading' => $subscription->user->firstName().'\'s subscription package includes',
                            'bulletOne' => $subscription->user->encourage_bullets[0],
                            'bulletTwo' => $subscription->user->encourage_bullets[1],
                            'bulletThree' => $subscription->user->encourage_bullets[2],
                        ];
                    }else{
                        $success = 0;
                    }
                }
                if($findType == 'countries'){

                    $countries = Country::all();
                    if($countries){

                        if($find != '' && $identityType == 'pod_buyer'){
                            $userProduct = UserProduct::find($find);
                            if($userProduct && $userProduct->user){
                                $data['currencySym'] = $commonMethods->getCurrencySymbol((strtoupper($userProduct->user->profile->default_currency)));
                            }else{
                                $data['currencySym'] = '£';
                            }
                        }else{
                            $data['currencySym'] = '£';
                        }
                        $success = 1;
                        $data['countries'] = '';
                        foreach ($countries as $key => $country) {
                            $data['countries'] .= '<option value="'.$country->id.'">'.$country->name.'</option>';
                        }
                    }else{
                        $success = 0;
                    }
                }
                if($findType == 'pod_delivery_cost'){

                    $product = UserProduct::find($find);
                    if($product && $product->customProduct()){

                        $success = 1;
                        $country = Country::find($identity);
                        $currency = $product->user->profile->default_currency;
                        if($country){

                            $data['deliveryCost'] = $country->id == 213 ? $product->customProduct()->delivery_cost[$currency]['local'] : $product->customProduct()->delivery_cost[$currency]['int'];
                            $data['currencySym'] = $commonMethods->getCurrencySymbol((strtoupper($currency)));
                        }else{
                            $success = 0;
                        }
                    }else{
                        $success = 0;
                    }
                }
            }

        }else{
            $error = 'inappropraite request';
        }

        return json_encode(['data' => $data, 'success' => $success, 'error' => $error]);
    }

    public function loadMyRequestData(Request $request){

        $commonMethods = new CommonMethods();
        if ($request->isMethod('post') && $request->has('load') && $request->has('load_type')) {

            $loadType = $request->load_type;
            $userId = $request->load;
            $user = User::find($userId);

            if($loadType == 'bio' && $user){

                $socialData = \View::make('parts.user-bio-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render();
                $return = $socialData;
            }
            if($loadType == 'social' && $user){

                $socialData = \View::make('parts.user-social-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render();
                $return = $socialData;
            }
            if($loadType == 'music' && $user){

                $musicData = \View::make('parts.user-music-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render();
                $return = $musicData;
            }
            if($loadType == 'video' && $user){

                $videoData = \View::make('parts.user-video-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render();
                $return = $videoData;
            }
            if($loadType == 'products' && $user){

                $productsData = \View::make('parts.user-products-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render();
                $return = $productsData;
            }
            if($loadType == 'fans' && $user){

                $fansData = \View::make('parts.user-fans-tab', ['user' => $user, 'commonMethods' => $commonMethods])->render();
                $return = $fansData;
            }
            if($loadType == 'owl_carosel'){

                $scrollerSlides = \App\Models\ScrollerSetting::all();
                $caroselData = \View::make('parts.scroller-slides', ['scrollerSlides' => $scrollerSlides, 'commonMethods' => $commonMethods])->render();
                $return = $caroselData;
            }
            if($loadType == 'smart_carosel_next_item'){

                $caroselData = '';

                $array = explode(',', $request->allItems);
                $array = is_array($array) ? array_filter($array) : null;
                if($array){
                    $caroselItem = \App\Models\ScrollerSetting::whereNotIn('id', $array)->take(1)->first();
                    if(isset($caroselItem) && $caroselItem){
                        $caroselData = \View::make('parts.smart-carosel-item', ['item' => $caroselItem])->render();
                    }
                }

                $return = $caroselData;
            }
            if($loadType == 'bx_slider'){

                $scrollerSlides = \App\Models\ScrollerSetting::all();
                $caroselData = \View::make('parts.scroller-slides-vertical', ['verticalSliderItems' => $scrollerSlides, 'commonMethods' => $commonMethods])->render();
                $return = $caroselData;
            }
            if($loadType == 'embed_code'){

                $embadCodeObj = EmbedCode::find(1);
                $embadCodeObjData = html_entity_decode($embadCodeObj->code);
                $return = $embadCodeObjData;
            }
            if($loadType == 'double_cards'){

                $cardsData = \View::make('parts.double-card-content', ['page' => $request->load])->render();
                $return = $cardsData;
            }
            if($loadType == 'main_tab_content'){

                $cardsData = \View::make('parts.main-tab-content', ['page' => $request->load])->render();
                $return = $cardsData;
            }
            if($loadType == 'insta_feed' && $user){

                $feed = $user->profile->instagramFeed();
                $return = $feed;
            }
            return $return;
        }
    }

    public function unlockUserPrivateMusic(Request $request){

        $success = '';
        $errorMessage = '';
        $musicHTML = '';

        $commonMethods = new CommonMethods();
        if($request->has('id') && $request->has('pin') && $request->has('type')){

            $musicId = $request->get('id');
            $pin = $request->get('pin');
            $type = $request->get('type');
            $mode = $request->get('mode');

            $music = UserMusic::find($musicId);
            if($music && count($music->privacy) && isset($music->privacy['status']) && $music->privacy['status'] == '1'){

                if($music->privacy['pin'] == $pin){

                    if($type == 'music'){

                        if($mode == '0'){

                            $musicHTML = \View::make('parts.user-channel-music-template', ['commonMethods' => $commonMethods, 'music' => $music])->render();
                        }else if($mode == 1){
                            $musicHTML = \View::make('parts.item-private-details', ['commonMethods' => $commonMethods, 'user' => $music->user, 'item' => $music, 'type' => 'track', 'unlocked' => '1'])->render();
                        }
                    }else if($type == 'album-music'){
                        $musicHTML = \View::make('parts.user-channel-album-music-template', ['user' => $music->user,'commonMethods' => $commonMethods, 'music' => $music])->render();
                    }

                    $success = 1;
                }else{
                    $errorMessage = 'Incorrect PIN';
                }
            }else{

                $errorMessage = 'Data incorrect/unknown';
            }
        }else{

            $errorMessage = 'Missing required data';
        }

        return json_encode(['success'=> $success, 'error' => $errorMessage, 'musicHTML' => $musicHTML]);
    }



    public function sendChatMessage(Request $request){

        $success = 0;
        $error = '';
        $data = ['recipient_name' => ''];

        if($request->has('login_email') && $request->has('login_password')){

            $email = $request->get('login_email');
            $password = $request->get('login_password');

            $user = User::where(['email' => $email])->first();
            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user);
            }else{
                $error = 'Email/Password is not correct';
                $user = null;
            }
        }else if(Auth::check()){

            $user = Auth::user();
        }else{
            $error = 'No user';
            $user = null;
        }

        if($user){

            if($request->has('message') && $request->has('recipient_id')){

                $message = $request->get('message');
                $recipientId = $request->get('recipient_id');
                $type = $request->has('type') ? $request->get('type') : '';
                $recipient = User::find($recipientId);

                if(!$recipient){

                    $error = 'Recipient not found';
                }

                if($error == ''){

                    if($recipient){

                        $currentChat = UserChat::where(['recipient_id' => $recipient->id, 'sender_id' => $user->id])->orderBy('id', 'desc')->get();
                    }

                    $chat = new UserChat();
                    $chat->sender_id = $user->id;
                    $chat->recipient_id = $recipient->id;
                    $chat->is_personal = 1;
                    $chat->message = $message;
                    $chat->music_id = null;

                    $chat->save();
                    $success = 1;

                    if($type == 'init'){
                        $result = Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new LicenseMail('bespokeOffer', $recipient, $user, $chat));
                    }else if($currentChat && $currentChat->first()){
                        $diffDays = $currentChat->first()->created_at->diffInDays();
                        if($diffDays >= 1){
                            $result = Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new AgentMail($chat));
                        }
                    }

                    $userNotification = new UserNotificationController();
                    $request->request->add(['user' => $recipient->id,'customer' => $user->id,'type' => 'chat','source_id' => $chat->id]);
                    $response = json_decode($userNotification->create($request), true);

                    $data['recipient_name'] = $recipient->name;
                }
            }else{

                $error = 'No/insufficient request data';
            }
        }

        return json_encode(['success' => $success, 'error' => $error, 'data' => $data]);
    }
}

