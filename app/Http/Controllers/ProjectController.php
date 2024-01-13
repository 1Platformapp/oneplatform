<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\CommonMethods;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\PayPalController;

use App\Models\CrowdfundCheckoutItem;
use App\Models\InstantCheckoutItemDetail;
use App\Models\CustomDomainSubscription;
use App\Models\UserProduct;
use App\Models\AgentTransfer;
use App\Models\Address;
use App\Models\InstantCheckoutItem;
use App\Models\User;
use App\Models\UserChat;
use App\Models\CompetitionVideo;
use App\Models\CrowdfundBasket;
use App\Models\Test;
use App\Models\ArtistJob;
use App\Models\City;
use App\Models\Competition;
use App\Models\Country;
use App\Models\CustomerBasket;
use App\Models\Genre;
use App\Models\UserMusic;
use App\Models\UserCampaign;
use App\Models\CampaignPerks;
use App\Models\StripeSubscription;
use App\Models\StripeCheckout;
use App\Models\Profile;
use App\Models\VideoStream;

use App\Mail\Payment;
use App\Mail\ProjectUpdate;
use App\Mail\InstantCheckout;
use App\Mail\User as MailUser;
use App\Mail\CrowdfundCheckout;

use DB;
use Auth;
use Image;
use Session;
use PDF;
use Carbon\Carbon;
use File;
use Lang;
use Hash;
use Mail;
use Response;


class ProjectController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity');
    }

    public function index(Request $request, $username, $loadCampaign = null)

    {

        if( $username ){

            $user = User::where('username', $username)->where('active' , '1')->first();

            if(!$user){

                return redirect(route('site.home'));
            }
        }else{

            return redirect(route('login'));
        }

        $basketFlag = '0';

        if(isset($request->basketFlag)){

            $basketFlag = $request->basketFlag;

        }

        if(Auth::check()){
            $customerId = Auth::user()->id;
        }else if (session::has('crowdfundCustomerId')) {
            $customerId = Session::get('crowdfundCustomerId');
        }else{
            Session::put('crowdfundCustomerId', 'guest_'.(time()+rand(10000, 99999)));
            $customerId = Session::get('crowdfundCustomerId');
        }

        $cartItems = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $user->id])->get();

        $commonMethods = new CommonMethods();



        $subtotal = $donation = 0;
        $currency = strtoupper($user->profile->default_currency);
        $bonuses = array();
        foreach ($cartItems as $key => $item) {
            if($item->type == 'bonus'){
                $subtotal += $item->amount;
                $currency = $item->currency;
                $bonuses[] = $item->bonus_id;
            }
            if($item->type == 'donation'){
                $donation = $item->amount;
                $subtotal += $item->amount;
                $currency = $item->currency;
            }
        }

        $crowdfundCart = ['subtotal' => $subtotal , 'bonuses' => $bonuses , 'donation' => $donation, 'currency' => $currency];

        //user campaign to be loaded in crowd funding section

        $userCampaign = $user->campaigns()->where('status', 'active')->orderBy('id', 'desc')->first();

        if (!$userCampaign){

            $userCampaign = new userCampaign;

            $userCampaign->user_id = $user->id;

            $userCampaign->save();

        }

        if($loadCampaign && $loadCampaign != ''){

            $userLoadCampaign = UserCampaign::find($loadCampaign);

            if( $userLoadCampaign && $userLoadCampaign->user_id == $user->id ){

                $userCampaign = $userLoadCampaign;

            }
            $loadPreCampaign = 1;
        }else{
            $loadPreCampaign = 0;
        }

        if($loadPreCampaign == 0 && $userCampaign->amount <= 0){

            return redirect(route('user.home', ['params' => $user->username]));
        }

        if($loadPreCampaign == 0 && ($userCampaign->is_live != 1 || $userCampaign->status != 'active')){

            return redirect(route('user.home', ['params' => $user->username]));
        }


        $userCampaignDetails = $loadCampaign ? $commonMethods->getCampaignRealDetails($userCampaign) : $commonMethods->getUserRealCampaignDetails($user->id);

        $userPersonalDetails = $commonMethods->getUserRealDetails($user->id);

        $projectVideo = $userCampaign->project_video_url;

        $userVideo = $user->profile->user_bio_video_url;



        $userVideoId = $userVideoTitle = '';

        if($projectVideo != ''){

            $url = $projectVideo;

            $userVideoId = $projectVideo != '' ? Youtube::parseVIdFromURL($projectVideo) : '';
        } else {

            if ($userVideo) {

                $userVideoId = $userVideo != '' ? $user->profile->user_bio_video_id : '';
            }

        }

        if(isset($request->videoId)){

            $userVideoId = $request->videoId;
        }

        $userVideoTitle = $commonMethods->getVideoTitle($userVideoId);

        $basket = $commonMethods::getCustomerBasket();

        $countries = Country::all();

        $basket = $commonMethods::getCustomerBasket();

        $allPastProjects = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();

        if (session::has('loadVideo')) {

            $videoInfo = Session::get('loadVideo');
            Session::forget('loadVideo');
            $explode = explode('~', $videoInfo);
            $userVideoId = $explode[0];
            $userVideoTitle = $commonMethods->getVideoTitle($userVideoId);
        }
        if (session::has('projectAutoShare')) {

            $autoShare = Session::get('projectAutoShare');
            Session::forget('projectAutoShare');
        }


        $data   = [

            'commonMethods' => $commonMethods,

            'user' => $user,

            'basket' => $basket,

            'userCampaignDetails' => $userCampaignDetails,

            'userPersonalDetails' => $userPersonalDetails,

            'userCampaign' => $userCampaign,

            'defaultVideoId' => $userVideoId,

            'defaultVideoTitle' => $userVideoTitle,

            'countries' => $countries,

            'basketFlag' => $basketFlag,

            'allPastProjects' => $allPastProjects,

            'userParams' => 'project',

            'loggedUserDet' => Auth::check() ? $commonMethods::getUserRealDetails(Auth::user()->id) : null,

            'autoShare' => isset($autoShare) ? $autoShare : null,

            'crowdfundCart' => $crowdfundCart,

            'loadCampaign' => $loadPreCampaign,

        ];



        return view( 'pages.project', $data );

    }

    public function crowdfund(){

        return view( 'pages.crowdfund' );
    }


    public function preview(Request $request, $username)
    {

        $basketFlag = "0";

        if(isset($request->basketFlag)){

            $basketFlag = $request->basketFlag;

        }



        $commonMethods = new CommonMethods();

        if(!Auth::check() || $username == null){

            return redirect('login');
        }

        $user = User::where(['username' => $username])->get()->first();

        if ( $user->id != Auth::user()->id ) {

            return redirect('profile');
        }

        $userId = $user->id;

        $userCampaign = $user->campaigns()->where('status', 'active')->where('title', '<>', '')->orderBy('id', 'desc')->first();

        if (!$userCampaign){

            return redirect('profile');
        }

        if($userCampaign->is_live == 1){

            return redirect(route('user.project', ['username' => $user->username]));
        }


        $userCampaignDetails = $commonMethods->getUserRealCampaignDetails($user->id);

        $userPersonalDetails = $commonMethods->getUserRealDetails($user->id);

        $projectVideo = $userCampaign->project_video_url;

        $userVideo = $user->profile->user_bio_video_url;



        $userVideoId = $userVideoTitle = "";

        if($projectVideo != ""){

            $url = $projectVideo;

            $userVideoId = $projectVideo != "" ? Youtube::parseVIdFromURL($projectVideo) : "";
        } else {

            if ($userVideo) {

                $userVideoId = $userVideo != "" ? $user->profile->user_bio_video_id : "";
            }

        }

        $userVideoTitle = $commonMethods->getVideoTitle($userVideoId);

        $basket = $commonMethods::getCustomerBasket();

        $countries = Country::all();

        $basket = $commonMethods::getCustomerBasket();

        $allPastProjects = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();

        if(Auth::check()){
            $customerId = Auth::user()->id;
        }else if (session::has('crowdfundCustomerId')) {
            $customerId = Session::get('crowdfundCustomerId');
        }else{
            Session::put('crowdfundCustomerId', 'guest_'.(time()+rand(10000, 99999)));
            $customerId = Session::get('crowdfundCustomerId');
        }

        $cartItems = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId])->get();

        $subtotal = $donation = 0;
        $currency = strtoupper($user->profile->default_currency);
        $bonuses = array();
        foreach ($cartItems as $key => $item) {
            if($item->type == 'bonus'){
                $subtotal += $item->amount;
                $currency = $item->currency;
                $bonuses[] = $item->bonus_id;
            }
            if($item->type == 'donation'){
                $donation = $item->amount;
                $subtotal += $item->amount;
                $currency = $item->currency;
            }
        }

        $crowdfundCart = ['subtotal' => $subtotal , 'bonuses' => $bonuses , 'donation' => $donation, 'currency' => $currency];


        $data   = [

            'commonMethods' => $commonMethods,

            'user' => $user,

            'basket' => $basket,

            'userCampaignDetails' => $userCampaignDetails,

            'userPersonalDetails' => $userPersonalDetails,

            'userCampaign' => $userCampaign,

            'defaultVideoId' => $userVideoId,

            'defaultVideoTitle' => $userVideoTitle,

            'countries' => $countries,

            'basketFlag' => $basketFlag,

            'allPastProjects' => $allPastProjects,

            'loggedUserDet' => Auth::check() ? $commonMethods::getUserRealDetails(Auth::user()->id) : null,

            'crowdfundCart' => $crowdfundCart,

        ];



        return view( 'pages.project-preview', $data );

    }

    public function userStoryText($campaignId)

    {

        //$user = User::find($userId);

        $userCampaign = UserCampaign::find($campaignId);

        $storyText = $userCampaign->new_story_text;

        $data   = [

            'story_text' => $storyText,

        ];

        return view( 'pages.user_story_text', $data );

    }

    public function saveUserStoryText($userId)

    {

        $user = User::find($userId);

        $userCampaign = UserCampaign::where('user_id',$userId)->orderBy('id', 'desc')->first();

        $storyText = $userCampaign->new_story_text;

        $data   = [

            'story_text' => $storyText,

        ];

        return view( 'pages.user_story_text_save', $data );

    }

    public function personalizedCheckout()
    {
        $serverName = $_SERVER['SERVER_NAME'];
        $customDomainActiveSubscription = CustomDomainSubscription::where(['domain_url' => 'www.singingexperience.co.uk'])->get()->first();
        if($customDomainActiveSubscription){

            $user = $customDomainActiveSubscription->user;
            return $this->checkout($user->id, new Request());
        }
    }

    public function checkout($userId, Request $request)

    {

        $basketFlag = "0";

        if(isset($request->basketFlag)){

            $basketFlag = $request->basketFlag;

        }
        $commonMethods = new CommonMethods();

        if($userId == null &&  Auth::check()){

            $user = Auth::user();
        }else if($userId){

            $user = User::find($userId);
        }else{

            return redirect(route('login'));
        }

        $basket = $commonMethods::getCustomerBasket();

        if(!$user){

        	return redirect(route('login'));
        }

        if(count($basket) <= 0){

            return redirect(route('user.home', ['params' => $user->username]));
        }

        $userCampaign = $user->campaigns()->where('status', 'active')->orderBy('id', 'desc')->first();

        if (!$userCampaign){

            $userCampaign = new userCampaign;

            $userCampaign->user_id = $user->id;

            $userCampaign->save();
        }

        if( $request->load_campaign != null ){

            $userLoadCampaign = UserCampaign::find($request->load_campaign);

            if( $userLoadCampaign && $userLoadCampaign->user_id == $user->id ){

                $userCampaign = $userLoadCampaign;
            }
        }

        $userCampaignDetails = $commonMethods::getUserRealCampaignDetails($userId);

        $userPersonalDetails = $commonMethods::getUserRealDetails($userId);

        $userVideo = $user->profile->competitionVideos()->orderBy('id', 'desc')->first();



        $userVideoId = "";

        if($userVideo){

            $userVideoId = $userVideo->id;
        }
        if(isset($request->videoId)){

            $userVideoId = $request->videoId;
        }

        $countries = Country::all();

        $videos = [];

        $basket = $commonMethods::getCustomerBasket();

        $totalProductsLocalDeliveryCost = 0;

        $totalProductsInternationalDeliveryCost = 0;

        $totalCost = 0;

        foreach ($basket as $b){

            if($b->purchase_type == 'product') {

                $totalProductsLocalDeliveryCost = $totalProductsLocalDeliveryCost + $b->product->local_delivery;

                $totalProductsInternationalDeliveryCost = $totalProductsInternationalDeliveryCost + $b->product->international_shipping;
            }else if($b->purchase_type == 'proferred-product'){

                $explode = explode('_', $b->extra_info);
                if(isset($explode[1])){
                    $chat = UserChat::find($explode[1]);
                    if($chat && $chat->product && isset($chat->product['id'])){
                        $pp = UserProduct::find($chat->product['id']);
                        if($pp){
                            $totalProductsLocalDeliveryCost = $totalProductsLocalDeliveryCost + $pp->local_delivery;
                            $totalProductsInternationalDeliveryCost = $totalProductsInternationalDeliveryCost + $pp->international_shipping;
                        }
                    }
                }
            }

            $totalCost += $b->price;
        }

        $allPastProjects = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();

        $reviewItems = $basket->filter(function ($basketItem) {
            return $basketItem->hasPriceDisparity();
        });



        $data   = [

            'commonMethods' => $commonMethods,

            'user' => $user,

            'basket' => $basket,

            'userCampaignDetails' => $userCampaignDetails,

            'userPersonalDetails' => $userPersonalDetails,

            'userCampaign' => $userCampaign,

            'userVideo' => $userVideo,

            'userVideoId' => $userVideoId,

            'countries' => $countries,

            'basketFlag' => $basketFlag,

            'totalProductsLocalDeliveryCost' => $totalProductsLocalDeliveryCost,

            'totalProductsInternationalDeliveryCost' => $totalProductsInternationalDeliveryCost,

            'totalCost'=>$totalCost,

            'allPastProjects' => $allPastProjects,

            'loggedUserDet' => Auth::check() ? $commonMethods::getUserRealDetails(Auth::user()->id) : null,

            'reviewItems' => $reviewItems,
        ];



        return view( 'pages.checkout', $data );

    }


    public function checkoutMerge($customerId, Request $request)
    {

        $commonMethods = new CommonMethods();

        if ($customerId == null || $customerId == ''){

            return redirect('site.home');
        }

        $mergeCartItems = CustomerBasket::where('customer_id', $customerId)->get();
        if(count($mergeCartItems) <= 0){

            return redirect('site.home');
        }

        if(!isset($_SESSION)) {
            session_start();
        }

        //$commonMethods->deleteCustomerBasket();
        foreach ($mergeCartItems as $key => $mergeCartItem) {

            $_SESSION['basket_customer_id'] = $mergeCartItem->customer_id;
            $user = User::find($mergeCartItem->user_id);
            $mergeCartItem->sold_out = 0;
            $mergeCartItem->save();

            $customer = User::find($_SESSION['basket_customer_id']);
            if(!Auth::check() && $customer){
                Auth::login($customer);
            }
        }

        return redirect(route('user.checkout', ['userId' => $user->id]));
    }

    public function autoShare($userId, $type, Request $request)
    {

        if ($type == null || $type == ''){

            return redirect('site.home');
        }

        Session::put('projectAutoShare', $type);

        $user = User::find($userId);

        return redirect(route('user.project', ['username' => $user->username]));
    }

    public function fillPurchasedBasket( $b, $checkoutId, $checkoutCurrency, $basketUserCurrency ){

        $commonMethods = new CommonMethods();

        $instantCheckoutItem = new InstantCheckoutItem();

        $instantCheckoutItem->stripe_checkout_id = $checkoutId;

        $instantCheckoutItem->type = $b->purchase_type;

        $instantCheckoutItem->price = $checkoutCurrency?$commonMethods->convert($basketUserCurrency, $checkoutCurrency, $b->price):0;

        if($b->purchase_type == 'product' || $b->purchase_type == 'proferred-product'){

            if($b->product){
                $product = $b->product;
            }else{
                $explode = explode('_', $b->extra_info);
                $chat = UserChat::find($explode[1]);
                $product = UserProduct::find($chat->product['id']);
            }

            $instantCheckoutItem->name = $product->title;

            $instantCheckoutItem->source_table_id = $product->id;

            $instantCheckoutItem->description = str_limit($product->description, '100');

            $instantCheckoutItem->file_name = $b->buyer_ticket_file;

        }else if($b->purchase_type == 'music' || $b->purchase_type == 'instant-license'){

            if($b->music){
                $music = $b->music;
            }else{
                $explode = explode('_', $b->extra_info);
                $chat = UserChat::find($explode[1]);
                $music = UserMusic::find($chat->agreement['music']);
            }

            $instantCheckoutItem->name = $music->song_name;

            $instantCheckoutItem->source_table_id = $music->id;

            $instantCheckoutItem->description = $music->album_name;

            $instantCheckoutItem->file_name = $music->music_file;

            $instantCheckoutItem->license = $b->license;

            $instantCheckoutItem->license_pdf = $b->license_pdf;

            $instantCheckoutItem->type = 'music';

        }else if($b->purchase_type == 'album'){

            $album = $b->album;

            $instantCheckoutItem->source_table_id = $b->album->id;

            $instantCheckoutItem->license = 'standard-album-personal-license';

            $instantCheckoutItem->name = $album->name;

        }else if($b->purchase_type == 'donation_goalless'){


        }else if($b->purchase_type == 'project'){

            $instantCheckoutItem->name = $b->instantItemTitle();

            $instantCheckoutItem->description = $b->instantItemDescription();

            $instantCheckoutItem->file_name = $b->instantItemFile();
        }

        $instantCheckoutItem->save();

        if($b->purchase_type == 'album'){

            if(is_array($b->album->musics) && count($b->album->musics)){

                foreach ($b->album->musics as $key2 => $musicId) {

                    $music = UserMusic::find($musicId);

                    if($music){

                        $instantCheckoutItemDetail = new InstantCheckoutItemDetail();

                        $instantCheckoutItemDetail->instant_checkout_item_id = $instantCheckoutItem->id;

                        $instantCheckoutItemDetail->source_table_id = $music->id;

                        $instantCheckoutItemDetail->name = $music->song_name;

                        $instantCheckoutItemDetail->type = 'music';

                        $instantCheckoutItemDetail->description = $b->album->name;

                        $instantCheckoutItemDetail->file_name = $music->music_file;

                        $instantCheckoutItemDetail->license = 'standard-album-personal-license';

                        $instantCheckoutItemDetail->save();
                    }
                }
            }
        }
        if($b->purchase_type == 'music' || $b->purchase_type == 'instant-music'){

            if($b->music){
                $music = $b->music;
            }else{
                $explode = explode('_', $b->extra_info);
                $chat = UserChat::find($explode[1]);
                $music = UserMusic::find($chat->agreement['music']);
            }

            if($music && is_array($music->loops) && count($music->loops)){

                foreach ($music->loops as $key => $loop) {

                    if(trim($loop) != ''){
                        $instantCheckoutItemDetail = new InstantCheckoutItemDetail();

                        $instantCheckoutItemDetail->instant_checkout_item_id = $instantCheckoutItem->id;

                        $instantCheckoutItemDetail->source_table_id = $music->id;

                        $instantCheckoutItemDetail->name = null;

                        $instantCheckoutItemDetail->type = 'loop';

                        $instantCheckoutItemDetail->description = 'loop for music: '.$music->song_name;

                        $instantCheckoutItemDetail->file_name = $loop;

                        $instantCheckoutItemDetail->license = null;

                        $instantCheckoutItemDetail->save();
                    }
                }
            }
        }

        if($b->purchase_type == 'music' || $b->purchase_type == 'instant-music'){

            if($b->music){
                $music = $b->music;
            }else{
                $explode = explode('_', $b->extra_info);
                $chat = UserChat::find($explode[1]);
                $music = UserMusic::find($chat->agreement['music']);
            }

            if($music && is_array($music->stems) && count($music->stems)){

                foreach ($music->stems as $key => $stem) {

                    if(trim($stem) != ''){

                        $instantCheckoutItemDetail = new InstantCheckoutItemDetail();

                        $instantCheckoutItemDetail->instant_checkout_item_id = $instantCheckoutItem->id;

                        $instantCheckoutItemDetail->source_table_id = $music->id;

                        $instantCheckoutItemDetail->name = null;

                        $instantCheckoutItemDetail->type = 'stem';

                        $instantCheckoutItemDetail->description = 'stem for music: '.$music->song_name;

                        $instantCheckoutItemDetail->file_name = $stem;

                        $instantCheckoutItemDetail->license = null;

                        $instantCheckoutItemDetail->save();
                    }
                }
            }
        }

    }



    public function registerBeforeContribute($paymentData){

        $user = User::where('email', $paymentData['email'])->first();
        if(!$user){

            $city = City::where('name', 'like', '%'.$paymentData['city'].'%')->first();
            $country = Country::where('code', $paymentData['country'])->first();
            $user                  = new User();
            $user->is_buyer_only   = 1;
            $user->email           = $paymentData['email'];
            $user->name            = trim($paymentData['firstname'].' '.$paymentData['surname']);
            $user->password        = bcrypt($paymentData['password']);
            $user->subscription_id = 0;
            $user->active          = 1;
            $user->api_token       = str_random(60);
            $user->save();
            $address               = new Address();
            $address->alias        = 'main address';
            $address->address_01   = $paymentData['street'];
            $address->city_id      = $city ? $city->id : 0;
            $address->country_id   = $country ? $country->id : 0;
            $address->post_code    = $paymentData['postcode'];
            $address->user_id      = $user->id;
            $address->save();
            $profile               = new Profile();
            $profile->birth_date   = Carbon::now();
            $profile->user_id      = $user->id;
            $profile->save();

            Auth::login($user);
            return true;
        }else{

            return false;
        }
    }

    public function cronjobDaily(Request $request){

        /* database backup starts */
        $commonMethods = new CommonMethods();
        $tablePrefix = Config('database.connections.mysql.prefix');
        $except = [
            $tablePrefix.'cities',
            $tablePrefix.'countries',
            $tablePrefix.'regions',
            $tablePrefix.'industry_contacts',
            $tablePrefix.'industry_contact_categories',
            $tablePrefix.'industry_contact_cities',
            $tablePrefix.'industry_contact_category_groups',
            $tablePrefix.'industry_contact_regions',
            $tablePrefix.'user_further_skills',
            $tablePrefix.'music_instrument',
        ];
        $return = $commonMethods->createDatabaseBackup(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), '*', $except);
        $dateTime = date('d-m-Y');
        $handle = fopen($dateTime.'.sql','w+');
        fwrite($handle,$return);
        fclose($handle);
        rename($dateTime.'.sql', public_path('database-backup/'.$dateTime).'.sql');
        $lastMonthBackup = date('d-m-Y', strtotime(date('Y-m-d')." -1 month")).'.sql';
        if(CommonMethods::fileExists(public_path('database-backup/'.$lastMonthBackup))) {
            unlink(public_path('database-backup/'.$lastMonthBackup));
        }
        /* database backup ends */

        $users = User::all();

        foreach ($users as $user) {


            if($user->active == 1 && filter_var($user->email, FILTER_VALIDATE_EMAIL)){

                if($user->last_login->diffInDays() % 14 == 0 && $user->last_login->diffInDays() != 0){

                    $result = Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new MailUser('inactive', $user));
                }

                $campaign = $user->campaign();
                if($campaign && $campaign->created_at->diffInDays() >= 7 && $campaign->is_live != 1 && $campaign->title != '' && $campaign->prolonged_inactive_user_email == 0){

                    Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new MailUser('crowdfunderInactive', $user));

                    $campaign->prolonged_inactive_user_email = 1;
                    $campaign->save();
                }

                if($user->created_at->diffInDays() >= 30 && (!$campaign || $campaign->title == '') && $user->no_crowdfunder_month_email == 0){

                    $result = Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new MailUser('noCrowdfunderMonth', $user));

                    $user->no_crowdfunder_month_email = 1;
                    $user->save();
                }

                if($user->created_at->diffInDays() >= 7 && (!$campaign || $campaign->title == '') && $user->no_crowdfunder_week_email == 0){

                    $result = Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new MailUser('noCrowdfunderWeek', $user));

                    $user->no_crowdfunder_week_email = 1;
                    $user->save();
                }
            }
        }

        return Response::json([], 200);
    }

    public function sendCronjobEmails(Request $request){

        $commonMethods = new CommonMethods;

        $campaigns = UserCampaign::where('amount', '>', 0)->where('duration', '>', 0)->get();

        foreach($campaigns as $campaign){

            if($campaign->user){

                $amountRaised = $campaign->amountRaised();
                $amountRaisingCustomers = array();
                $crowdfundCheckouts = StripeCheckout::where('campaign_id', $campaign->id)->where('type', 'crowdfund')->get();

                foreach($crowdfundCheckouts as $checkout){

                    $amountRaisingCustomers[] = $checkout->customer->id;
                }

                $daysLeft = $campaign->daysLeft();
                $supporterIds = array_unique($amountRaisingCustomers);
                $supporters = User::whereIn('id', $supporterIds)->get();

                if($amountRaised >= $campaign->amount && $daysLeft >= 0 && $campaign->successful_supporter_email == 0){

                    foreach($supporters as $supporter){

                        $receiver = $supporter;

                        $user = $campaign->user;

                        if(filter_var($receiver->email, FILTER_VALIDATE_EMAIL)){

                            $result = Mail::to($receiver->email)->bcc(Config('constants.bcc_email'))->send(new ProjectUpdate('reachedGoal', $user, $campaign));

                            $campaign->successful_supporter_email = 1;
                            $campaign->save();
                        }
                    }
                }

                if($amountRaised < $campaign->amount && $daysLeft <= 7 && $campaign->nearly_ending_supporter_email == 0){

                    foreach($supporters as $supporter){

                        $receiver = $supporter;
                        $user = $campaign->user;

                        if(filter_var($receiver->email, FILTER_VALIDATE_EMAIL)){

                            $result = Mail::to($receiver->email)->bcc(Config('constants.bcc_email'))->send(new ProjectUpdate('nearlyEnding', $user, $campaign));

                            $campaign->nearly_ending_supporter_email = 1;
                            $campaign->save();
                        }
                    }
                }

                if($amountRaised < $campaign->amount && $daysLeft <= 10 && $campaign->nearly_ending_user_email == 0){

                    $user = $campaign->user;

                    if(filter_var($user->email, FILTER_VALIDATE_EMAIL)){

                        $result = Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new ProjectUpdate('nearlyOver', $user, $campaign));

                        $campaign->nearly_ending_user_email = 1;
                        $campaign->save();
                    }
                }

                if($amountRaised < $campaign->amount  && $daysLeft <= 0 && $campaign->unsuccessful_user_email == 0){

                    $campaign->status = 'inactive';
                    $campaign->is_live = 0;
                    $receiver = $campaign->user;

                    if(filter_var($receiver->email, FILTER_VALIDATE_EMAIL)){

                        $result = Mail::to($receiver->email)->bcc(Config('constants.bcc_email'))->send(new ProjectUpdate('overUnsuccessful', $campaign->user, $campaign));

                        $campaign->unsuccessful_user_email = 1;
                        $campaign->save();
                    }
                }

                if($amountRaised >= $campaign->amount  && $daysLeft >= 0 && $campaign->successful_user_email == 0){

                    $receiver = $campaign->user;

                    if(filter_var($receiver->email, FILTER_VALIDATE_EMAIL)){

                        $result = Mail::to($receiver->email)->bcc(Config('constants.bcc_email'))->send(new ProjectUpdate('overSuccessful', $campaign->user, $campaign));

                        $campaign->successful_user_email = 1;
                        $campaign->save();
                    }
                }

            }

        }

        $campaigns = UserCampaign::where('amount', '>', 0)->where('duration', '>', 0)->where('is_charity', 0)->where('non_charity_payment_flag', 0)->where('successful_user_email', 1)->get();

        foreach($campaigns as $campaign){

            if($campaign->user && $campaign->user->profile && $campaign->user->profile->stripe_secret_key != ''){

                $daysLeft = $campaign->daysLeft();
                $amountRaised = $campaign->amountRaised();
                $amountRaisingCustomers = array();

                $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                array_push($headers, 'Stripe-Account: '.$campaign->user->profile->stripe_user_id);

                if($amountRaised >= $campaign->amount){

                    $crowdfundCheckouts = StripeCheckout::where('campaign_id', $campaign->id)->where('type', 'crowdfund')->whereNull('stripe_charge_id')->whereNotNull('stripe_customer_id')->whereNotNull('stripe_payment_id')->get();
                    foreach($crowdfundCheckouts as $checkout){

                        $setupIntentId = $checkout->stripe_payment_id;
                        $url = 'https://api.stripe.com/v1/setup_intents/'.$setupIntentId;
                        $fields = [];
                        $setupIntent = $commonMethods->stripeCall($url, $headers, $fields, 'GET');

                        if(isset($setupIntent['id']) && $setupIntent['status'] == 'succeeded' && $setupIntent['payment_method']){

                            $paymentMethodId = $setupIntent['payment_method'];
                            $stripeCustomerId = $checkout->stripe_customer_id;
                            if(count($checkout->crowdfundCheckoutItems) && $checkout->user && $checkout->customer){
                                $sellerUser = $checkout->user;
                                $buyerUser = $checkout->customer;
                                $bonusTotal = $bonusCount = $shippingCost = $donationAmount = 0;
                                $itemIds = [];

                                foreach($checkout->crowdfundCheckoutItems as $checkoutItem){
                                    if($checkoutItem->type == 'bonus'){
                                        $bonusTotal += $checkoutItem->price;
                                        $shippingCost += $checkoutItem->delivery_cost;
                                        $itemIds[] = 'B_'.base64_encode($checkoutItem->bonus->id);
                                    }
                                    if($checkoutItem->type == 'donation'){
                                        $donationAmount = $checkoutItem->price;
                                        $itemIds[] = 'D_'.base64_encode($donationAmount);
                                    }
                                }
                                if($bonusTotal + $donationAmount == $checkout->amount){

                                    $currencySymbol = $commonMethods->getCurrencySymbol($checkout->currency);
                                    $fee = $checkout->application_fee;

                                    $metaData = $setupIntent['metadata'];
                                    $metaData['Buyer'] = $buyerUser->id.': '.$buyerUser->name.' - '.$buyerUser->email;
                                    $metaData['Seller'] = $sellerUser->id.': '.$sellerUser->name.' - '.$sellerUser->email;
                                    $metaData['ReferenceID'] = $checkout->id;

                                    require_once(app_path().'/includes/stripe2/stripe-php-7/init.php');
                                    try{
                                        \Stripe\Stripe::setApiKey(Config('constants.stripe_key_secret'));
                                        $paymentIntent = \Stripe\PaymentIntent::create([
                                            'amount' => $checkout->amount * 100,
                                            'currency' => $checkout->currency,
                                            'customer' => $stripeCustomerId,
                                            'payment_method' => $paymentMethodId,
                                            'application_fee_amount' => intval($fee * 100),
                                            'off_session' => true,
                                            'confirm' => true,
                                            'metadata' => $metaData
                                        ], ['stripe_account' => $campaign->user->profile->stripe_user_id]);

                                        if(isset($paymentIntent['status']) && $paymentIntent['status'] == 'succeeded'){

                                            if(filter_var($sellerUser->email, FILTER_VALIDATE_EMAIL)){
                                                Mail::to($sellerUser->email)->bcc(Config('constants.bcc_email'))->send(new CrowdfundCheckout('seller', $checkout));
                                            }

                                            if(isset($paymentIntent['charges']) && isset($paymentIntent['charges']['data'][0]) && $paymentIntent['charges']['data'][0]['status'] == 'succeeded'){
                                                $charge = $paymentIntent['charges']['data'][0];
                                            }

                                            $checkout->stripe_payment_id = $paymentIntent['id'];
                                            $checkout->stripe_charge_id = isset($charge) ? $charge['id'] : null;
                                            $checkout->save();
                                        }
                                    }catch(\Stripe\Exception\CardException $e){
                                        $errorCode = $e->getError()->code;
                                        $paymentIntentId = $e->getError()->payment_intent->id;
                                        $url = 'https://api.stripe.com/v1/payment_intents/'.$paymentIntentId;
                                        $paymentIntent = $commonMethods->stripeCall($url, $headers, [], 'GET');
                                        if($paymentIntent['last_payment_error'] && isset($paymentIntent['last_payment_error']['decline_code']) && $paymentIntent['last_payment_error']['decline_code'] != ''){
                                        	$errorCode = $paymentIntent['last_payment_error']['decline_code'];
                                        }
                                        $checkout->stripe_payment_id = $paymentIntent['id'];
                                        $checkout->error = $errorCode;
                                        $checkout->error_date_time = date('Y-m-d H:i:s');
                                        $checkout->save();

                                        Mail::to($checkout->customer->email)->bcc(Config('constants.bcc_email'))->send(new Payment($checkout, 'failed'));
                                    }
                                }else{
                                    $checkout->error = 'invalid_price';
                                    $checkout->error_date_time = date('Y-m-d H:i:s');
                                    $checkout->save();
                                }
                            }else{
                                $checkout->error = 'basket_error';
                                $checkout->error_date_time = date('Y-m-d H:i:s');
                                $checkout->save();
                            }
                        }else if(isset($setupIntent['error'])){
                            $checkout->error = $setupIntent['error']['code'].' - '.$setupIntent['error']['message'];
                            $checkout->error_date_time = date('Y-m-d H:i:s');
                            $checkout->save();
                        }else{
                            $checkout->error = 'setup_intent_error';
                            $checkout->error_date_time = date('Y-m-d H:i:s');
                            $checkout->save();
                        }
                    }

                    if($daysLeft <= 0){

                        $campaign->is_live = 0;
                        $campaign->status = 'inactive';
                    }

                    $campaign->non_charity_payment_flag = 1;
                    $campaign->save();
                }
            }
        }

        return Response::json([], 200);
    }

    public function prepareFakeBasket(Request $request){

        $commonMethods = new CommonMethods();
        $error = '';
        $success = 0;

        if($request->has('customer') && $request->has('type') && $request->has('source')){

            if(Auth::check()){
                $customerId = $request->get('customer');
                $customer = $customerId == 'current' ? Auth::user() : User::find($customerId);
                $type = $request->get('type');
                $source = $request->get('source');
                $sourceType = explode('_', $source);
                if($sourceType[0] == 'checkout'){
                    $checkout = StripeCheckout::find($sourceType[1]);
                    if($checkout && count($checkout->crowdfundCheckoutItems) && $checkout->customer->id == $customer->id){

                        if($type == 'crowdfund'){
                            foreach ($checkout->crowdfundCheckoutItems as $key => $crowdfundItem) {

                                if($type == 'bonus' && !$crowdfundItem->bonus){
                                    continue;
                                }

                                $crowdfundBasket = new CrowdfundBasket();
                                $crowdfundBasket->customer_id = $customer->id;
                                $crowdfundBasket->user_id = $checkout->user->id;
                                $crowdfundBasket->type = $crowdfundItem->type;
                                $crowdfundBasket->bonus_id = $crowdfundItem->source_table_id;
                                $crowdfundBasket->shipping = $crowdfundItem->delivery_cost;
                                $crowdfundBasket->currency = $checkout->currency;
                                $crowdfundBasket->amount = $crowdfundItem->price;
                                $crowdfundBasket->save();

                                $success = 1;
                            }
                        }else{
                            $error = 'invalid type param';
                        }
                    }else{
                        $error = 'invalid source';
                    }
                }else{
                    $error = 'invalid source type';
                }
            }else{
                $error = 'not logged in';
            }
        }else{
            $error = 'no data';
        }

        echo json_encode(['success' => $success , 'error' => $error]);
    }

    public function preparePayment(Request $request){

        header('Content-Type: application/json');

        $commonMethods = new CommonMethods();
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);
        $dataa = $jsonObj->userdata;
        $dataArray = explode('&', $dataa);
        $finalData = [];
        foreach ($dataArray as $key => $dataEach) {
            if($dataEach != ''){
                $dataSub = explode('=', $dataEach);
                $finalData[$dataSub[0]] = urldecode($dataSub[1]);
            }
        }

        if($finalData['payment_method'] == 'stripe'){

            $finalData['country'] = Country::find($finalData['country'])->code;

            $totalAmount = 0;
            $hasSubscription = 0;
            $itemIds = [];
            if($jsonObj->type == 'instant'){
                $customerBasket = CommonMethods::getCustomerBasket();
                if($customerBasket->first() && $customerBasket->first()->user){
                    $sellerUser = $customerBasket->first()->user;
                    $buyerUser = $customerBasket->first()->customer;
                    $basketUserCurrency = strtoupper($sellerUser->profile->default_currency);
                    foreach($customerBasket as $key => $basket){
                        if($basket->purchase_type != 'subscription'){
                            $totalAmount += $basket->price;
                            $itemIds[] = base64_encode($basket->id);
                        }else{
                            $itemIds[] = base64_encode($basket->id);
                            $hasSubscription = $basket->price;
                        }
                    }
                    $totalAmount += $finalData['delivery_cost'];
                }else{
                    http_response_code(404);
                    echo json_encode(['error' => 'No seller']);
                }
            }else if($jsonObj->type == 'crowdfund'){
                if(Auth::check()){
                    $customerId = Auth::user()->id;
                }else if (session::has('crowdfundCustomerId')) {
                    $customerId = Session::get('crowdfundCustomerId');
                }else{
                    $customerId = 0;
                }
                if($customerId){
                    $customerBasket = CrowdfundBasket::where(['customer_id' => $customerId])->get();
                    $bonusTotal = $bonusCount = $shippingCost = $donationAmount = 0;
                    if($customerBasket->first() && $customerBasket->first()->user){
                        $sellerUser = $customerBasket->first()->user;
                        $campaign = UserCampaign::where(['user_id' => $sellerUser->id, 'status' => 'active', 'is_live' => 1])->first();
                        $bonusTotal = $bonusCount = $shippingCost = 0;
                        foreach($customerBasket as $basketItem){
                            if($basketItem->type == 'bonus'){
                                $bonusTotal += $basketItem->amount;
                                if($basketItem->shipping > 0){
                                    $shippingCost += $basketItem->shipping;
                                }
                                $bonusCount++;
                                $itemIds[] = 'B_'.base64_encode($basketItem->bonus->id);
                            }else if($basketItem->type == 'donation'){
                                $donationAmount = $basketItem->amount;
                                $itemIds[] = 'D_'.base64_encode($donationAmount);
                            }
                        }
                        $subTotalActual = $bonusTotal + $donationAmount;
                        $totalAmount = $subTotalActual+$shippingCost;
                        $finalData['delivery_cost'] = $shippingCost;
                    }else{
                        http_response_code(404);
                        echo json_encode(['error' => 'No seller']);
                    }
                }else{
                    http_response_code(404);
                    echo json_encode(['error' => 'No buyer']);
                }
            }

            try{
                if($totalAmount){

                    $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                    array_push($headers, 'Stripe-Account: '.$sellerUser->profile->stripe_user_id);
                    $createPaymentIntent = $createSetupIntent = 1;

                    $appFee = $this->getCheckoutFee($jsonObj->type, $sellerUser, $totalAmount);
                    $fee = $appFee['platform']['fee'];
                    $agentFee = $appFee['agent']['fee'];

                    $existingIntentId = $customerBasket->first()->payment_intent_id;
                    if($jsonObj->type == 'crowdfund' && $campaign && $campaign->is_charity != 1 && !isset($jsonObj->failedcheckout)){
                        if($existingIntentId){
                            $url = 'https://api.stripe.com/v1/setup_intents/'.$existingIntentId;
                            $fields = [];
                            $existingSetupIntent = $commonMethods->stripeCall($url, $headers, $fields, 'GET');
                            if(isset($existingSetupIntent['status']) && $existingSetupIntent['status'] == 'requires_payment_method'){
                                $createSetupIntent = 0;
                            }else if(isset($existingSetupIntent['status']) && $existingSetupIntent['status'] != 'succeeded' && $existingSetupIntent['status'] != 'processing'){
                                $url = 'https://api.stripe.com/v1/setup_intents/'.$existingIntentId.'/cancel';
                                $fields = [];
                                $commonMethods->stripeCall($url, $headers, $fields);
                            }
                        }
                    }else{
                        if($existingIntentId){
                            $url = 'https://api.stripe.com/v1/payment_intents/'.$existingIntentId;
                            $fields = [];
                            $existingPaymentIntent = $commonMethods->stripeCall($url, $headers, $fields, 'GET');
                            if(isset($existingPaymentIntent['status']) && $existingPaymentIntent['status'] == 'requires_payment_method'){
                                $createPaymentIntent = 0;
                            }else if(isset($existingPaymentIntent['status']) && $existingPaymentIntent['status'] != 'succeeded' && $existingPaymentIntent['status'] != 'processing'){
                                $url = 'https://api.stripe.com/v1/payment_intents/'.$existingIntentId.'/cancel';
                                $fields = [];
                                $commonMethods->stripeCall($url, $headers, $fields);
                            }
                        }
                    }

                    $metaData['CardHolderName'] = isset($finalData['card_holder_name']) ? $finalData['card_holder_name'] : 'None';
                    $metaData['FirstName'] = $finalData['name'];
                    $metaData['Surname'] = $finalData['surname'];
                    $metaData['Street'] = $finalData['street'];
                    $metaData['Country'] = $finalData['country'];
                    $metaData['City'] = $finalData['city'];
                    $metaData['Postcode'] = $finalData['zip'];
                    $metaData['Comment'] = $finalData['comment'];
                    $metaData['DeliveryCost'] = $finalData['delivery_cost'];
                    $metaData['Email'] = isset($finalData['email']) ? $finalData['email'] : 'None';
                    $metaData['PhoneNumber'] = isset($finalData['contact_number']) ? $finalData['contact_number'] : 'None';
                    $metaData['Password'] = isset($finalData['password']) ? base64_encode($finalData['password']) : 'None';
                    $metaData['Type'] = ucfirst($jsonObj->type);
                    $metaData['Items'] = implode(',', $itemIds);

                    if($jsonObj->type == 'crowdfund' && $campaign && $campaign->is_charity != 1 && !isset($jsonObj->failedcheckout)){
                        if(!$createSetupIntent){
                            $url = 'https://api.stripe.com/v1/setup_intents/'.$existingIntentId;
                            $fields = [
                                'metadata' => $metaData
                            ];
                            $intent = $commonMethods->stripeCall($url, $headers, $fields);
                        }else{
                            $url = 'https://api.stripe.com/v1/customers';
                            $fields = [
                                'name' => trim($finalData['name'].' '.$finalData['surname']),
                                'address' => [
                                    'line1' => $finalData['street'],
                                    'city' => $finalData['city'],
                                    'country' => $finalData['country'],
                                    'postal_code' => $finalData['zip']
                                ]
                            ];
                            $stripeCustomer = $commonMethods->stripeCall($url, $headers, $fields);

                            $url = 'https://api.stripe.com/v1/setup_intents';
                            $fields = [
                                'customer' => $stripeCustomer['id'],
                                'metadata' => $metaData
                            ];
                            $intent = $commonMethods->stripeCall($url, $headers, $fields);
                            $customerBasket->first()->payment_intent_id = $intent['id'];
                            $customerBasket->first()->save();
                        }
                    }else{
                        if(!$createPaymentIntent){
                            $url = 'https://api.stripe.com/v1/payment_intents/'.$existingIntentId;
                            $fields = [
                                'amount' => $totalAmount*100,
                                'currency' => $sellerUser->profile->default_currency,
                                'application_fee_amount' => intval(($fee+$agentFee) * 100),
                                'metadata' => $metaData
                            ];
                            $intent = $commonMethods->stripeCall($url, $headers, $fields);
                        }else{
                            $url = 'https://api.stripe.com/v1/payment_intents';
                            $fields = [
                                'amount' => $totalAmount*100,
                                'currency' => $sellerUser->profile->default_currency,
                                'application_fee_amount' => intval(($fee+$agentFee) * 100),
                                'payment_method_types' => ['card'],
                                'metadata' => $metaData
                            ];
                            if($hasSubscription){
                                $url1 = 'https://api.stripe.com/v1/customers';
                                $fields1 = [
                                    'name' => trim($finalData['name'].' '.$finalData['surname']),
                                    'address' => [
                                        'line1' => $finalData['street'],
                                        'city' => $finalData['city'],
                                        'country' => $finalData['country'],
                                        'postal_code' => $finalData['zip']
                                    ]
                                ];
                                $stripeCustomer = $commonMethods->stripeCall($url1, $headers, $fields1);
                                $fields = array_merge($fields, ['customer' => $stripeCustomer['id'], 'setup_future_usage' => 'off_session']);
                            }

                            $intent = $commonMethods->stripeCall($url, $headers, $fields);
                            $customerBasket->first()->payment_intent_id = $intent['id'];
                            $customerBasket->first()->save();
                        }
                    }
                    $output = [
                        'clientSecret' => $intent['client_secret'],
                    ];
                    echo json_encode($output);
                }else{
                    if($customerBasket->first() && $customerBasket->first()->user){

                        if($hasSubscription && $request->has('paymentMethod')){

                            $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                            array_push($headers, 'Stripe-Account: '.$sellerUser->profile->stripe_user_id);

                            $url1 = 'https://api.stripe.com/v1/customers';
                            $fields1 = [
                                'name' => trim($finalData['name'].' '.$finalData['surname']),
                                'address' => [
                                    'line1' => $finalData['street'],
                                    'city' => $finalData['city'],
                                    'country' => $finalData['country'],
                                    'postal_code' => $finalData['zip']
                                ]
                            ];
                            $stripeCustomer = $commonMethods->stripeCall($url1, $headers, $fields1);

                            $url2 = 'https://api.stripe.com/v1/payment_methods/'.$request->get('paymentMethod').'/attach';
                            $fields = [
                                'customer' => $stripeCustomer['id'],
                            ];
                            $commonMethods->stripeCall($url2, $headers, $fields);

                            $url = 'https://api.stripe.com/v1/customers/'.$stripeCustomer['id'];
                            $fields = [
                                'invoice_settings' => ['default_payment_method' => $request->get('paymentMethod')],
                            ];
                            $commonMethods->stripeCall($url, $headers, $fields);
                        }

                        echo json_encode(['free' => 1, 'stripeCustomer' => (isset($stripeCustomer) ? $stripeCustomer['id'] : null)]);
                    }else{
                        http_response_code(500);
                        echo json_encode(['error' => 'no data']);
                    }
                }
            }catch(\Exception $e){
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        }else if($finalData['payment_method'] == 'paypal'){

            $response = PayPalController::createOrder();
            return $response;
        }else{

            http_response_code(500);
            echo json_encode(['error' => 'unknown payment method']);
        }
    }

    public function postPayment(Request $request){

        $commonMethods = new CommonMethods();
        $success = 0;
        $error = '';
        $redirectUrl = '';

        if($request->has('userdata') && $request->has('type')){

            $data = $request->get('userdata');
            $type = $request->get('type');

            $totalAmount = 0;
            $hasSubscription = 0;

            $dataArray = explode('&', $data);
            $finalData = [];
            foreach ($dataArray as $key => $dataEach) {
                if($dataEach != ''){
                    $dataSub = explode('=', $dataEach);
                    $finalData[$dataSub[0]] = urldecode($dataSub[1]);
                }
            }
            $finalData['country'] = Country::find($finalData['country'])->code;

            if($type == 'instant'){
                $customerBasket = CommonMethods::getCustomerBasket();
                if($customerBasket->first() && $customerBasket->first()->user){
                    $sellerUser = $customerBasket->first()->user;
                    $basketUserCurrency = strtoupper($sellerUser->profile->default_currency);
                    foreach($customerBasket as $key => $basket){
                        if($basket->purchase_type != 'subscription'){
                            $totalAmount += $basket->price;
                        }else{
                            $hasSubscription = $sellerUser->subscription_amount;
                        }
                    }
                }
                $totalAmount += $finalData['delivery_cost'];
            }else if($type == 'crowdfund'){
                if(Auth::check()){
                    $customerId = Auth::user()->id;
                }else if (session::has('crowdfundCustomerId')) {
                    $customerId = Session::get('crowdfundCustomerId');
                }else{
                    $customerId = 0;
                }
                if($customerId){
                    $customerBasket = CrowdfundBasket::where(['customer_id' => $customerId])->get();
                    if($customerBasket->first() && $customerBasket->first()->user){
                        $sellerUser = $customerBasket->first()->user;
                        $campaign = UserCampaign::where(['user_id' => $sellerUser->id, 'status' => 'active', 'is_live' => 1])->first();
                        $bonusTotal = $bonusCount = $shippingCost = $donationAmount = 0;
                        foreach($customerBasket as $basketItem){
                            if($basketItem->type == 'bonus'){
                                $bonusTotal += $basketItem->amount;
                                if($basketItem->shipping > 0){
                                    $shippingCost += $basketItem->shipping;
                                }
                                $bonusCount++;
                                $itemIds[] = 'B_'.base64_encode($basketItem->bonus->id);
                            }else if($basketItem->type == 'donation'){
                                $donationAmount = $basketItem->amount;
                                $itemIds[] = 'D_'.base64_encode($donationAmount);
                            }
                        }
                        $subTotalActual = $bonusTotal + $donationAmount;
                        $totalAmount = $subTotalActual+$shippingCost;
                        $finalData['delivery_cost'] = $shippingCost;
                    }else{
                        http_response_code(404);
                        echo json_encode(['error' => 'No seller']);
                    }
                }else{
                    http_response_code(404);
                    echo json_encode(['error' => 'No buyer']);
                }
            }

            if($request->has('intent')){

                // proceed with stripe's payment intent
                $id = $request->get('intent');
                if($customerBasket->first()->payment_intent_id == $id){
                    $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                    array_push($headers, 'Stripe-Account: '.$sellerUser->profile->stripe_user_id);

                    if($type == 'crowdfund' && $campaign && $campaign->is_charity != 1 && !$request->has('failedcheckout')){
                        $url = 'https://api.stripe.com/v1/setup_intents/'.$id;
                    }else{
                        $url = 'https://api.stripe.com/v1/payment_intents/'.$id;
                    }

                    $fields = [];
                    $paymentIntent = $commonMethods->stripeCall($url, $headers, $fields, 'GET');

                    if($paymentIntent && isset($paymentIntent['id'])){
                        if($paymentIntent['status'] == 'succeeded'){

                            if(isset($paymentIntent['charges']) && isset($paymentIntent['charges']['data'][0])){
                                $charge = $paymentIntent['charges']['data'][0];
                                $url = 'https://api.stripe.com/v1/balance_transactions/'.$charge['balance_transaction'];
                                $fields = [];
                                $balanceTransaction = $commonMethods->stripeCall($url, $headers, $fields, 'GET');
                                if(isset($balanceTransaction['id'])){
                                    $stripeFee = $balanceTransaction['fee'];
                                }else{
                                    $stripeFee = 0;
                                }
                                $applicationFeeId = $charge['application_fee'];
                            }else{
                                $stripeFee = 0;
                                $applicationFeeId = null;
                            }

                            $paymentData = [
                                'totalAmount' => $totalAmount,
                                'type' => $type,
                                'firstname' => $finalData['name'],
                                'surname' => $finalData['surname'],
                                'street' => $finalData['street'],
                                'country' => $finalData['country'],
                                'city' => $finalData['city'],
                                'postcode' => $finalData['zip'],
                                'comment' => $finalData['comment'],
                                'deliverycost' => $finalData['delivery_cost'],
                                'email' => isset($finalData['email']) ? $finalData['email'] : '',
                                'phoneNumber' => isset($finalData['contact_number']) ? $finalData['contact_number'] : '',
                                'password' => isset($finalData['password']) ? $finalData['password'] : '',
                                'stripefee' => $stripeFee,
                                'applicationfeeid' => $applicationFeeId,
                                'failedcheckout' => $request->has('failedcheckout') ? $request->get('failedcheckout') : 0,
                                'free' => '0'
                            ];

                            $buyerUserResponse = $this->createBuyerUser($sellerUser, $paymentData);
                            $buyerUser = Auth::user();
                            if($buyerUserResponse){

                                if($type == 'instant'){
                                    $customerBasket = $commonMethods::getCustomerBasket();
                                }else if($type == 'crowdfund'){
                                    foreach($customerBasket as $basketItem){
                                        $basketItem->customer_id = $buyerUser->id;
                                        $basketItem->save();
                                    }
                                    $customerBasket = CrowdfundBasket::where(['customer_id' => $buyerUser->id])->get();
                                }

                                if($hasSubscription && $paymentIntent['customer']){

                                    $url = 'https://api.stripe.com/v1/customers/'.$paymentIntent['customer'];
                                    $fields = [
                                        'invoice_settings' => ['default_payment_method' => $paymentIntent['payment_method']],
                                    ];
                                    $commonMethods->stripeCall($url, $headers, $fields);

                                    $url = 'https://api.stripe.com/v1/products';
                                    $fields = [
                                        'name' => $buyerUser->name.' subscribes to '.$sellerUser->name,
                                    ];
                                    $product = $commonMethods->stripeCall($url, $headers, $fields);

                                    $url = 'https://api.stripe.com/v1/prices';
                                    $fields = [
                                        'unit_amount' => floatval($hasSubscription) * 100,
                                        'currency'    => $sellerUser->profile->default_currency,
                                        'recurring'   => ['interval' => 'month'],
                                        'product'     => $product['id']
                                    ];
                                    $price = $commonMethods->stripeCall($url, $headers, $fields);
                                    $priceId = $price['id'];

                                    $url = 'https://api.stripe.com/v1/subscriptions';
                                    $platformFeePercent = $commonMethods->userCheckoutApplicationFee($sellerUser->id);
                                    if($platformFeePercent > 0){
                                        $fields = [
                                            'customer' => $paymentIntent['customer'],
                                            'items' => [['price' => $priceId]],
                                            'application_fee_percent' => $platformFeePercent
                                        ];
                                    }else{
                                        $fields = [
                                            'customer' => $paymentIntent['customer'],
                                            'items' => [['price' => $priceId]],
                                        ];
                                    }
                                    $subscription = $commonMethods->stripeCall($url, $headers, $fields);
                                }else{
                                    $subscription = null;
                                }

                                $response = $this->proceedSavingPayment($request, $customerBasket, $paymentIntent, $paymentData, $subscription);
                                $redirectUrl = $response['redirectUrl'];
                                $checkoutId = $response['checkoutId'];
                                $metaData = $paymentIntent['metadata'];
                                $metaData['Buyer'] = $buyerUser->id.': '.$buyerUser->name.' - '.$buyerUser->email;
                                $metaData['Seller'] = $sellerUser->id.': '.$sellerUser->name.' - '.$sellerUser->email;
                                $metaData['ReferenceID'] = $checkoutId;
                                if($subscription && isset($subscription['id'])){
                                    $metaData['HasSubscription'] = $subscription['id'];
                                }
                                $success = 1;
                            }else{
                                $error = 'Your account credentials cannot be accepted';
                            }

                            if($success){

                                $url = 'https://api.stripe.com/v1/payment_intents/'.$id;
                                $fields = [
                                    'metadata' => $metaData
                                ];
                                $paymentIntent = $commonMethods->stripeCall($url, $headers, $fields);
                            }
                        }else{
                            $error = 'payment intent status: '.$paymentIntent['status'];
                        }
                    }else{
                        $error = 'payment intent does not exist';
                    }
                }else{
                    $error = 'something went wrong';
                }
            }else if($request->has('free') && $totalAmount == 0 && $customerBasket->first()){

                // proceed without payment intent
                $paymentData = [
                    'totalAmount' => 0,
                    'type' => 'instant',
                    'firstname' => $finalData['name'],
                    'surname' => $finalData['surname'],
                    'street' => $finalData['street'],
                    'country' => $finalData['country'],
                    'city' => $finalData['city'],
                    'postcode' => $finalData['zip'],
                    'comment' => $finalData['comment'],
                    'deliverycost' => $finalData['delivery_cost'],
                    'email' => isset($finalData['email']) ? $finalData['email'] : '',
                    'phoneNumber' => isset($finalData['contact_number']) ? $finalData['contact_number'] : '',
                    'password' => isset($finalData['password']) ? $finalData['password'] : '',
                    'stripefee' => 0,
                    'applicationfeeid' => null,
                    'failedcheckout' => 0,
                    'free' => '1'
                ];

                $buyerUserResponse = $this->createBuyerUser($sellerUser, $paymentData);
                if($buyerUserResponse){

                	if($request->has('stripeCustomer') && $request->get('stripeCustomer')){

                		$stripeCustomerId = $request->get('stripeCustomer');
                		$buyerUser = Auth::user();
                		$headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                		array_push($headers, 'Stripe-Account: '.$sellerUser->profile->stripe_user_id);

                		$url = 'https://api.stripe.com/v1/products';
                		$fields = [
                		    'name' => $buyerUser->name.' subscribes to '.$sellerUser->name,
                		];
                		$product = $commonMethods->stripeCall($url, $headers, $fields);

                		$url = 'https://api.stripe.com/v1/prices';
                		$fields = [
                		    'unit_amount' => floatval($hasSubscription) * 100,
                		    'currency'    => $sellerUser->profile->default_currency,
                		    'recurring'   => ['interval' => 'month'],
                		    'product'     => $product['id']
                		];
                		$price = $commonMethods->stripeCall($url, $headers, $fields);
                		$priceId = $price['id'];

                		$url = 'https://api.stripe.com/v1/subscriptions';
                		$platformFeePercent = $commonMethods->userCheckoutApplicationFee($sellerUser->id);
                		if($platformFeePercent > 0){
                		    $fields = [
                		        'customer' => $stripeCustomerId,
                		        'items' => [['price' => $priceId]],
                		        'application_fee_percent' => $platformFeePercent
                		    ];
                		}else{
                		    $fields = [
                		        'customer' => $stripeCustomerId,
                		        'items' => [['price' => $priceId]],
                		    ];
                		}
                		$subscription = $commonMethods->stripeCall($url, $headers, $fields);
                	}else{

                		$subscription = null;
                	}

                    $customerBasket = $commonMethods::getCustomerBasket();
                    $response = $this->proceedSavingPayment($request, $customerBasket, null, $paymentData, $subscription);
                    $redirectUrl = $response['redirectUrl'];
                    $checkoutId = $response['checkoutId'];
                    $success = 1;
                }else{
                    $error = 'Your account credentials cannot be accepted';
                }
            }
        }else{
            $error = 'incomplete data';
        }

        echo json_encode(['success' => $success, 'error' => $error, 'url' => $redirectUrl]);
    }

    public function postCrowdfundBasket(Request $request){

        if ($request->isMethod('post')) {

            $success = 0;
            $error = '';
            $data = [];
            $commonMethods = new CommonMethods();

            if($request->has('action') && $request->has('user') && $request->has('type') && $request->has('value') && $request->has('currency')){

                $action = $data['action'] = $request->get('action');
                $type = $data['type'] = $request->get('type');
                $value = $data['value'] = $request->get('value');
                $currency = $data['currency'] = $request->get('currency');
                $userId = $data['user'] = $request->get('user');

                if(Auth::check()){
                    $customerId = Auth::user()->id;
                }else if (session::has('crowdfundCustomerId')) {
                    $customerId = Session::get('crowdfundCustomerId');
                }else{
                    Session::put('crowdfundCustomerId', 'guest_'.(time()+rand(10000, 99999)));
                    $customerId = Session::get('crowdfundCustomerId');
                }

                if($type == 'bonus'){
                    $bonus = CampaignPerks::find($value);
                    if($bonus && $bonus->campaign && $bonus->campaign->user){
                        if($action == 'add'){

                            if(CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'bonus', 'bonus_id' => $bonus->id])->exists()){

                                $error = 'You have already added this item';
                            }else{

                                $bonusUser = $bonus->campaign->user;
                                $countryId = ($bonusUser->address) ? $bonusUser->address->country_id : 0;

                                if($currency == $bonus->currency){
                                    $data['amount'] = $bonus->amount;
                                }else{
                                    $data['amount'] = $commonMethods->convert($bonus->currency, $currency, $bonus->amount);
                                }

                                $crowdfundBasket = new CrowdfundBasket();
                                $crowdfundBasket->customer_id = $customerId;
                                $crowdfundBasket->user_id = $userId;
                                $crowdfundBasket->type = 'bonus';
                                $crowdfundBasket->bonus_id = $bonus->id;
                                $crowdfundBasket->currency = $currency;
                                $crowdfundBasket->amount = $data['amount'];
                                $crowdfundBasket->save();

                                $success = 1;
                            }
                        }else if($action == 'remove'){
                            if(CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'bonus', 'bonus_id' => $bonus->id])->exists()){

                                $crowdfundBasket = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'bonus', 'bonus_id' => $bonus->id])->first();
                                $crowdfundBasket->delete();

                                $success = 1;
                            }else{
                                $error = 'Target does not exist';
                            }
                        }
                    }else{
                        $error = 'Target information does not exist';
                    }
                }else if($type == 'donation'){

                    if($action == 'add'){
                        if(!CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'donation'])->exists()){

                            $seller = User::find($userId);
                            $sellerDefaultCurrency = strtoupper($seller->profile->default_currency);
                            if($sellerDefaultCurrency != $currency){
                                $value = $commonMethods->convert($sellerDefaultCurrency, $currency, $value);
                            }
                            $crowdfundBasket = new CrowdfundBasket();
                            $crowdfundBasket->customer_id = $customerId;
                            $crowdfundBasket->user_id = $userId;
                            $crowdfundBasket->type = 'donation';
                            $crowdfundBasket->currency = $currency;
                            $crowdfundBasket->amount = $value;
                            $crowdfundBasket->save();

                            $data['amount'] = $value;

                            $success = 1;
                        }else{
                            $error = 'You have already added a donation';
                        }
                    }else if($action == 'remove'){
                        if(CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'donation'])->exists()){

                            $crowdfundBasket = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'donation'])->first();
                            $crowdfundBasket->delete();

                            $success = 1;
                        }else{
                            $error = 'Target does not exist';
                        }
                    }
                }else if($type == 'currency'){

                    if($action == 'switch'){
                        $basket = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId])->get();
                        foreach ($basket as $key => $basketItem) {
                            if($basketItem->currency != $value){
                                $basketItem->amount = $commonMethods->convert($basketItem->currency, $value, $basketItem->amount);
                                $basketItem->currency = $value;
                                $basketItem->save();
                            }
                        }
                    }
                }else if($type == 'refresh'){


                }

                $campaign = UserCampaign::where(['status' => 'active', 'is_live' => 1, 'user_id' => $userId])->first();
                $data['grandTotal'] = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId])->sum('amount');
                $data['bonusTotal'] = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'bonus'])->sum('amount');
                $data['bonusCount'] = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'bonus'])->count();
                $data['donationTotal'] = CrowdfundBasket::where(['customer_id' => $customerId, 'user_id' => $userId, 'type' => 'donation'])->sum('amount');
                $data['isCharity'] = $campaign && $campaign->is_charity == 1 ? 1 : 0;
            }else{
                $error = 'incomplete request';
            }
        }else{
            $error = 'inappropraite request';
        }

        return json_encode(array('success' => $success, 'error' => $error, 'data' => $data));
    }

    public function proceedSavingPayment($request, $customerBasket, $paymentIntent, $paymentData, $stripeSubscription, $paypalOrder=null){

        $commonMethods = new CommonMethods();
        $sellerUser = $customerBasket->first()->user;
        $buyerUser = $customerBasket->first()->customer;
        $sellerDetails = $commonMethods->getUserRealDetails($sellerUser->id);
        $buyerDetails = $commonMethods->getUserRealDetails($buyerUser->id);
        $basketUserCurrency = strtoupper($sellerUser->profile->default_currency);
        $selectedCurrencySymbol = $commonMethods->getCurrencySymbol($basketUserCurrency);
        $totalAmount = $paymentData['totalAmount'];
        $appFee = $this->getCheckoutFee($paymentData['type'], $sellerUser, $totalAmount);

        if($paymentData['free'] == '0'){
            $fee = $appFee['platform']['fee'];
            $agent = $appFee['agent']['id'] ? User::find($appFee['agent']['id']) : NULL;
            $agentFee = $appFee['agent']['fee'];
            $agentFeeSkipped = $appFee['agent']['skipped'];
            $applicationFee = $fee+$agentFee;
            if($agent && $agentFee > 0){

                $agentTransferDetails = 'Agent checkout fee from platform. Agent: '.$agent->id.' - '.$agent->name.' - '.$appFee['agent']['percent'].'%'.'. Buyer: '.$buyerUser->id.' - '.$buyerUser->name.'. Seller: '.$sellerUser->id.' - '.$sellerUser->name.'. Intent: '.$paymentIntent['id']?$paymentIntent['id']:''.'. Application Fee: '.$applicationFee;
                $agentTransfer = new AgentTransfer();
                $agentTransfer->agent_id = $agent->id;
                $agentTransfer->type = $paymentData['type'];
                $agentTransfer->amount = round($agentFee * 100);
                $agentTransfer->currency = $basketUserCurrency;
                $agentTransfer->description = $agentTransferDetails;
                $agentTransfer->stripe_application_fee_id = $paymentData['applicationfeeid'];
                $agentTransfer->save();
            }
        }

        if($paymentData['type'] == 'crowdfund'){
            $campaign = UserCampaign::where(['user_id' => $sellerUser->id, 'status' => 'active', 'is_live' => 1])->first();
            if($campaign && $campaign->is_charity != 1 && $paymentData['failedcheckout'] == 0){
                $stripeCustomer = $paymentIntent['customer'];
            }else{
                $stripeCustomer = null;
            }
        }else if($paymentData['type'] == 'instant' && $paymentIntent && $stripeSubscription && isset($stripeSubscription['id'])){
            $stripeCustomer = $paymentIntent['customer'];
        }else{
            $stripeCustomer = null;
        }

        if($paymentIntent && isset($paymentIntent['charges']) && isset($paymentIntent['charges']['data'][0]) && $paymentIntent['charges']['data'][0]['status'] == 'succeeded'){
            $charge = $paymentIntent['charges']['data'][0];
        }

        if($paymentData['failedcheckout'] == 0){
            $stripeCheckOut = new StripeCheckout();
        }else{
            $stripeCheckOut = StripeCheckout::find($paymentData['failedcheckout']);
        }

        $stripeCheckOut->user_id = $sellerUser->id;
        $stripeCheckOut->customer_id = $buyerUser->id;
        $stripeCheckOut->user_name = $sellerUser->name;
        $stripeCheckOut->customer_name = $buyerUser->name;
        $stripeCheckOut->amount = $totalAmount;
        $stripeCheckOut->currency = ($totalAmount > 0) ? strtoupper($basketUserCurrency) : null;
        $stripeCheckOut->type = $paymentData['type'];
        $stripeCheckOut->stripe_charge_id = isset($charge) ? $charge['id'] : null;
        $stripeCheckOut->stripe_customer_id = $stripeCustomer;
        $stripeCheckOut->stripe_payment_id = $paymentIntent ? $paymentIntent['id'] : null;
        $stripeCheckOut->agent_fee = $paymentData['free'] == '0' ? $agentFee : null;
        $stripeCheckOut->agent_fee_skipped = $paymentData['free'] == '0' ? $agentFeeSkipped : null;
        $stripeCheckOut->agent_id = isset($agent) && $agent ? $agent->id : null;
        $stripeCheckOut->stripe_fee = $paymentData['stripefee'];
        $stripeCheckOut->application_fee = $paymentData['free'] == '0' ? $fee : null;
        if($paymentData['failedcheckout'] == 0){
            $stripeCheckOut->campaign_id = isset($campaign) && $campaign ? $campaign->id : null;
        }
        $stripeCheckOut->email = $buyerUser->email ? $buyerUser->email : $paymentData['email'];
        $stripeCheckOut->name = trim($paymentData['firstname'].' '.$paymentData['surname']);
        $stripeCheckOut->city = $paymentData['city'];
        $stripeCheckOut->address = $paymentData['street'];
        $stripeCheckOut->country = $paymentData['country'];
        $stripeCheckOut->postcode = $paymentData['postcode'];
        $stripeCheckOut->comment = $paymentData['comment'];
        $stripeCheckOut->error = null;
        $stripeCheckOut->error_date_time = null;
        if($paypalOrder){
            $stripeCheckOut->paypal_order_id = $paypalOrder['id'];
        }
        $stripeCheckOut->save();

        $userNotification = new UserNotificationController();
        $request->request->add(['user' => $sellerUser->id, 'customer' => $buyerUser->id, 'type' => 'sale', 'source_id' => $stripeCheckOut->id]);
        $response = json_decode($userNotification->create($request), true);

        if($paymentData['type'] == 'instant'){

            foreach($customerBasket as $b){

                if($b->purchase_type == 'product' || $b->purchase_type == 'proferred-product'){

                    if($b->product){
                        $product = $b->product;
                        if($product->voucher_id){
                            $vProduct = $product;
                        }
                    }else{
                        $explode = explode('_', $b->extra_info);
                        $chat = UserChat::find($explode[1]);
                        $product = UserProduct::find($chat->product['id']);
                    }

                    if($product->is_ticket == 1){
                        $ticketNumber = strtoupper('tick_'.uniqid());
                        $fileName = "buyer-ticket-files/" . $ticketNumber . ".pdf";
                        $data = ['product' => $product, 'ticketNumber' => $ticketNumber, 'name' => $paymentData['firstname'], 'address' => $paymentData['street'], 'city' => $paymentData['city'], 'postcode' => $paymentData['postcode']];
                        PDF::loadView('pdf.ticket', $data)->setPaper('a4', 'portrait')->setWarnings(false)->save($fileName);
                        $b->buyer_ticket_file = $fileName;
                        $b->save();
                    }
                    $product->items_claimed = $product->items_claimed+1;
                    $product->save();
                }
            }

            if($sellerUser->isCotyso() && isset($vProduct) && $vProduct->voucher_id){

                $vPhoneNumber = Auth::check() && Config('constants.primaryDomain') == $_SERVER['SERVER_NAME'] && Auth::user()->contact_number ? Auth::user()->contact_number : $paymentData['phoneNumber'];
                $vEmail = Auth::check() && Config('constants.primaryDomain') == $_SERVER['SERVER_NAME'] ? Auth::user()->email : $paymentData['email'];
                $voucherName = $vPhoneNumber.'.pdf';
                $database = Config('constants.clients_portal_database');
                $clientsPortalCon = $commonMethods->createDBConnection($database['host'], $database['username'], $database['password'], $database['database']);
                $duplication = 'SELECT * FROM Client WHERE code = "'.$vPhoneNumber.'"';
                $result = mysqli_query($clientsPortalCon, $duplication);
                $sql = 'INSERT INTO Client (name, code, money, email, voucher_id, gallerySwitch, monetizePrimeTime, voucher_file)
                VALUES ("'.trim($paymentData['firstname'].' '.$paymentData['surname']).'", "'.$vPhoneNumber.'", "0", "'.$vEmail.'", "'.$vProduct->voucher_id.'", "1", "1", "'.$voucherName.'")';

                if($clientsPortalCon && mysqli_query($clientsPortalCon, $sql)){

                    $lastId = mysqli_insert_id($clientsPortalCon);
                    if($result && mysqli_num_rows($result) > 0){

                        $vPhoneNumber = $lastId.$vPhoneNumber;
                        $voucherName = $lastId.$voucherName;
                        $update = 'UPDATE Client SET code = "'.$vPhoneNumber.'", voucher_file = "'.$voucherName.'" WHERE id = '.$lastId;
                        $result2 = mysqli_query($clientsPortalCon, $update);
                        if(!$result2){
                            Session::flash('error', 'Portal update error. Please report this error as it is to our admin team for further assitance');
                        }
                    }

                    $voucherFile = 'vouchers/'.$voucherName;
                    $data = ['experienceTitle' => $vProduct->title, 'code' => $vPhoneNumber, 'comment' => $paymentData['comment']];
                    $view = \View::make('pdf.se-voucher', $data);
                    $pdf = PDF::loadHTML($view)->setPaper('a4', 'portrait')->setWarnings(false)->save($voucherFile);
                }else{
                    Session::flash('error', 'Portal insert error. Please report this error as it is to our admin team for further assitance');
                }

                mysqli_close($clientsPortalCon);
            }

            $buyerArray = ['customer'=>$buyerUser, 'customerBasket'=>$customerBasket, 'user'=>$sellerUser, 'bcc' => Config('constants.bcc_email'), 'sellerDetails'=>$sellerDetails,'buyerDetails' => $buyerDetails, 'emaill' => $paymentData['email']];
            $buyerObj = (object) $buyerArray;

            $result =  Mail::send( 'pages.email.basket-buyer-email', ['customer'=>$buyerUser, 'user'=>$sellerUser, 'customerBasket'=>$customerBasket, 'currencySymbol'=>$selectedCurrencySymbol, 'currency'=>$basketUserCurrency, 'commonMethods'=>$commonMethods, 'checkout' => $stripeCheckOut, 'voucherCode' => isset($voucherFile) ? $vPhoneNumber : NULL], function ( $m ) use ($buyerObj){

                $m->from(Config('constants.from_email'), ($buyerObj->user->isCotyso() ? 'Singing Experience' : '1Platform TV'));
                $m->bcc($buyerObj->bcc);
                $m->to($buyerObj->customer->email ? $buyerObj->customer->email : $buyerObj->emaill, $buyerObj->customer->name);

                foreach($buyerObj->customerBasket as $b){
                    if($b->purchase_type == 'music' || $b->purchase_type == 'instant-license'){
                        if(strpos($b->license, 'bespoke_') !== false){
                            $licExplodeId = explode('_', $b->license);
                            $chat = UserChat::find($licExplodeId[1]);
                            if($chat && count($chat->agreement) && isset($chat->agreement['filename'])){
                                $m->attach(asset('bespoke-licenses/'.$chat->agreement['filename']));
                                $b->license_pdf = $chat->agreement['filename'];
                                $b->save();
                            }
                        }else{
                            if($b->user && $b->customer && $b->music){
                                $stanLicenseName = strtoupper('stan_lic_'.uniqid()).'.pdf';
                                $fileName = "standard-licenses/".$stanLicenseName;
                                $comMe = new CommonMethods();
                                $sellerDetails = (array) $buyerObj->buyerDetails;
                                $buyerDetails = (array) $buyerObj->sellerDetails;
                                $data = ['sellerDetails' => $sellerDetails, 'buyerDetails' => $buyerDetails, 'music' => $b->music, 'licenseName' => $b->license, 'price' => $b->price];
                                PDF::loadView('pdf.standard-license', $data)->setPaper('a4', 'portrait')->setWarnings(false)->save($fileName);
                                $m->attach(asset($fileName));

                                $b->license_pdf = $stanLicenseName;
                                $b->save();
                            }
                        }
                    }
                    if($b->purchase_type == 'project'){
                        $explode = explode('_', $b->extra_info);
                        $chat = UserChat::find($explode[1]);
                        if($chat && count($chat->project) && isset($chat->project['filename'])){
                            $m->attach(asset('proffered-project/'.$chat->project['filename']));
                        }
                    }
                    if($b->purchase_type == 'product' || $b->purchase_type == 'proferred-product'){
                        if($b->buyer_ticket_file && $b->buyer_ticket_file != ''){
                            $m->attach(asset($b->buyer_ticket_file));
                        }
                    }
                }

                $m->subject('Your Order From '.$buyerObj->user->name);
            });

            foreach ($customerBasket as $b) {
                if($b->purchase_type != 'subscription'){
                    $this->fillPurchasedBasket($b, $stripeCheckOut->id, $stripeCheckOut->currency, $basketUserCurrency);
                }
            }

            if($stripeSubscription && isset($stripeSubscription['id'])){

                $subscription = new StripeSubscription;
                $subscription->plan_currency = $stripeSubscription['items']['data'][0]['price']['currency'];
                $subscription->plan_amount = $stripeSubscription['items']['data'][0]['price']['unit_amount']/100;
                $subscription->plan_interval = 'month';
                $subscription->comment = $paymentData['comment'];
                $subscription->application_fee = null;
                $subscription->user_id = $sellerUser->id;
                $subscription->customer_id = $buyerUser->id;
                $subscription->stripe_subscription_id = $stripeSubscription['id'];
                $subscription->save();

                $stripeCheckOut->stripe_subscription_id = $subscription->id;
                $stripeCheckOut->save();
            }

            if($sellerUser->isCotyso() && $buyerUser->password == 'iscotyso'){
                $buyerUser->contact_number = $paymentData['phoneNumber'];
                $buyerUser->save();
            }

            $result = Mail::to($sellerUser->email)->bcc(Config('constants.bcc_email'))->send(new InstantCheckout('seller', $stripeCheckOut));

            CommonMethods::deleteCustomerBasket();
            if($sellerUser->isCotyso() && $buyerUser->password == 'iscotyso'){
                $buyerUser->email = NULL;
                $buyerUser->password = NULL;
                $buyerUser->active = 0;
                $buyerUser->save();
                Auth::logout($buyerUser);
            }

            if(count($sellerUser->devices)){

                foreach ($sellerUser->devices as $device) {

                    if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                        $fcm = new PushNotificationController();
                        $return = $fcm->send($device->device_id, 'New sale from '.$buyerUser->firstName(), str_limit('Items purchased from your 1platform store', 24), $device->platform);
                    }
                }
            }

        }else if($paymentData['type'] == 'crowdfund'){

            $basketBonuses = CrowdfundBasket::where(['customer_id' => $buyerUser->id, 'user_id' => $sellerUser->id, 'type' => 'bonus'])->get();
            foreach($basketBonuses as $basketBonus){
                $bonus = $basketBonus->bonus;
                $crowdfundCheckoutItem = new CrowdfundCheckoutItem();
                $crowdfundCheckoutItem->stripe_checkout_id = $stripeCheckOut->id;
                $crowdfundCheckoutItem->source_table_id = $bonus->id;
                $crowdfundCheckoutItem->type = 'bonus';
                $crowdfundCheckoutItem->price = $basketBonus->amount;
                $crowdfundCheckoutItem->name = $bonus->title;
                $crowdfundCheckoutItem->description = $bonus->description;
                $crowdfundCheckoutItem->items_included = $bonus->items_included;
                $crowdfundCheckoutItem->delivery_cost = $basketBonus->shipping;

                $crowdfundCheckoutItem->save();

                $bonus->items_claimed = $bonus->items_claimed + 1;
                $bonus->save();
            }

            $basketDonation = CrowdfundBasket::where(['customer_id' => $buyerUser->id, 'user_id' => $sellerUser->id, 'type' => 'donation'])->first();
            if($basketDonation && $basketDonation->amount > 0){
                $crowdfundCheckoutItem = new CrowdfundCheckoutItem();
                $crowdfundCheckoutItem->stripe_checkout_id = $stripeCheckOut->id;
                $crowdfundCheckoutItem->type = 'donation';
                $crowdfundCheckoutItem->price = $basketDonation->amount;

                $crowdfundCheckoutItem->save();
            }

            $result = Mail::to($sellerUser->email)->bcc(Config('constants.bcc_email'))->send(new CrowdfundCheckout('seller', $stripeCheckOut));
            $result = Mail::to($buyerUser->email)->bcc(Config('constants.bcc_email'))->send(new CrowdfundCheckout('buyer', $stripeCheckOut));

            CrowdfundBasket::where(['customer_id' => $buyerUser->id, 'user_id' => $sellerUser->id])->delete();

            if(count($sellerUser->devices)){

                foreach ($sellerUser->devices as $device) {

                    if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                        $fcm = new PushNotificationController();
                        $return = $fcm->send($device->device_id, 'New sale from '.$buyerUser->firstName(), str_limit('Corwdfund items purchased from your 1platform store', 24), $device->platform);
                    }
                }
            }
        }

        if($paymentData['type'] == 'crowdfund' && $campaign && $campaign->is_charity != 1 && $paymentData['failedcheckout'] == 0){
            $checkoutMessage = 'Great! Your money will be transferred if the project you supported is successful';
        }else{
            $checkoutMessage = 'Successfully sent money to ' . $sellerUser->name;
        }

        if($sellerUser->isCotyso() && !Auth::check()){
            $domain = parse_url($request->root())['host'];
            if($paymentData['free'] == '1'){
                $message = 'Successfully finished';
                if(Config('constants.primaryDomain') == $_SERVER['SERVER_NAME']){
                    $redirectUrl = route('user.home', ['params' => $sellerUser->username]);
                }else{
                    if($sellerUser->customDomainSubscription){
                        $redirectUrl = $sellerUser->customDomainSubscription->domain_url;
                    }else{
                        $redirectUrl = route('user.home', ['params' => $sellerUser->username]);
                    }
                }
            }else{
                $message = $checkoutMessage;
                if(isset($vPhoneNumber)){
                    $message .= '<br>Check your email for details<br>Click <a target="_blank" href="https://clients.singingexperience.co.uk?code='.$vPhoneNumber.'">here</a> to login and start your booking';
                }
                if(Config('constants.primaryDomain') == $_SERVER['SERVER_NAME']){
                    $redirectUrl = route('user.home', ['params' => $sellerUser->username]);
                }else{
                    if($sellerUser->customDomainSubscription){
                        $redirectUrl = $sellerUser->customDomainSubscription->domain_url;
                    }else{
                        $redirectUrl = route('user.home', ['params' => $sellerUser->username]);
                    }
                }
            }
        }else{
            if($paymentData['free'] == '1'){
                $message = 'Successfully finished';
                Session::flash('page', 'orders');
                $redirectUrl = route('profile');
            }else{
                $message = $checkoutMessage;
                Session::flash('page', 'orders');
                $redirectUrl = route('profile');
            }
        }

        Session::flash('success', $message);
        return ['redirectUrl' => $redirectUrl, 'checkoutId' => $stripeCheckOut->id];
    }

    public function createBuyerUser($sellerUser, $paymentData){

        if(!Auth::check()){
            if($sellerUser && $sellerUser->isCotyso()){

                $user = new User();
                $user->is_buyer_only = 1;
                $user->email = $paymentData['email'];
                $user->name = trim($paymentData['firstname'].' '.$paymentData['surname']);
                $user->first_name = trim($paymentData['firstname']);
                $user->surname = trim($paymentData['surname']);
                $user->password = 'iscotyso';
                $user->active = 1;
                $user->api_token = str_random(60);
                $user->save();
                $address = new Address();
                $address->user_id = $user->id;
                $address->save();
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->save();

                Auth::login($user);
                return true;
            }else{

                return $this->registerBeforeContribute($paymentData);
            }
        }else{
            return true;
        }
    }

    public function getCheckoutFee($type, $sellerUser, $totalAmount){

        $commonMethods = new CommonMethods();
        if($type == 'instant'){

            $platformFeePercent = $commonMethods->userCheckoutApplicationFee($sellerUser->id);
            $agentFeeDetails = $commonMethods->userAgentCheckoutFee($sellerUser->id);
            $agentFeeSkipped = $agentFeePercent = 0;
            if($agentFeeDetails['agent_id']){
                $agent = User::find($agentFeeDetails['agent_id']);
                if($agent && $agentFeeDetails['percent']){
                    if($platformFeePercent > 0){
                        $platformFeePercent = $platformFeePercent - $agentFeeDetails['percent'];
                        $agentFee = ($agentFeeDetails['percent']/100)*$totalAmount;
                        $agentFeePercent = $agentFeeDetails['percent'];
                    }else{
                        $agentFee = 0;
                        $agentFeeSkipped = 1;
                    }
                }else{
                    $agentFee = 0;
                }
            }else{
                $agentFee = 0;
            }
            $fee = ($platformFeePercent/100)*$totalAmount;

            return ['platform' => ['fee' => $fee], 'agent' => ['id' => isset($agent) && $agent ? $agent->id : NULL, 'fee' => $agentFee, 'skipped' => $agentFeeSkipped, 'percent' => $agentFeePercent]];
        }else if($type == 'crowdfund'){

            $platformFeePercent = Config('constants.crowdfund_application_fee');
            $fee = ($platformFeePercent/100)*$totalAmount;

            return ['platform' => ['fee' => $fee], 'agent' => ['id' => NULL, 'fee' => 0, 'skipped' => 0, 'percent' => 0]];
        }
    }

    public function paymentFailedRetry($id){

    	$commonMethods = new CommonMethods();
    	if(Auth::check()){
            $user = Auth::user();
    		if($id){
    		    $response = $this->validateFailedCheckout($id);
    		    if($response){
    		        $stripeCheckout = StripeCheckout::find($id);
                    if($user->id == $stripeCheckout->customer->id){

                        $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                        array_push($headers, 'Stripe-Account: '.$stripeCheckout->user->profile->stripe_user_id);

                        $paymentIntentId = $stripeCheckout->stripe_payment_id;
                        $url = 'https://api.stripe.com/v1/payment_intents/'.$paymentIntentId;
                        $paymentIntent = $commonMethods->stripeCall($url, $headers, [], 'GET');

                        if(isset($paymentIntent['charges']['data']) && isset($paymentIntent['charges']['data'][0]) && isset($paymentIntent['charges']['data'][0]['payment_method_details'])){
                        	$paymentMethodDetails = $paymentIntent['charges']['data'][0]['payment_method_details'];
                        }

                        $data   = [

                            'commonMethods' => $commonMethods,
                            'checkout' => $stripeCheckout,
                            'paymentIntent' => $paymentIntent,
                            'paymentMethodDetails' => isset($paymentMethodDetails) ? $paymentMethodDetails : NULL
                        ];

                        return view( 'pages.retry-failed-payment', $data );
                    }else{
                        echo 'You are not authorized';
                    }
    		    }else{
    		    	echo 'Payment invalid';
    		    }
    		}else{
    			echo 'No data';
    		}
    	}else{
    		return redirect(route('login'));
    	}
    }

    public function retryPostPayment(Request $request){

    	$commonMethods = new CommonMethods();
    	$success = 0;
    	$error = $url = '';

    	if($request->has('intent')){

    		$intentId = $request->get('intent');
    		$checkout = StripeCheckout::where('stripe_payment_id', $intentId)->whereNotNull('error')->first();

    		if($checkout  && $checkout->user && $checkout->customer && Auth::check()){
    			if(Auth::user()->id == $checkout->customer->id){
    				$headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
    				array_push($headers, 'Stripe-Account: '.$checkout->user->profile->stripe_user_id);

    				$url = 'https://api.stripe.com/v1/payment_intents/'.$checkout->stripe_payment_id;
    				$paymentIntent = $commonMethods->stripeCall($url, $headers, [], 'GET');

    				if(isset($paymentIntent['id'])){
    					if($paymentIntent['status'] == 'succeeded'){

    						$charge = $paymentIntent['charges']['data'][0];
    						$checkout->error = NULL;
    						$checkout->error_date_time = NULL;
    						$checkout->stripe_charge_id = $charge['id'];
    						Session::flash('success', 'Your payment has been sent to '.$checkout->user->name);
    						$url = route('profile.with.tab', ['tab' => 'orders']);
    					}else if($paymentIntent['last_payment_error'] && isset($paymentIntent['last_payment_error']['decline_code']) && $paymentIntent['last_payment_error']['decline_code'] != ''){

    						$checkout->error = $paymentIntent['last_payment_error']['decline_code'];
    						$checkout->error_date_time = date('Y-m-d H:i:s');
  							Session::flash('error', $paymentIntent['last_payment_error']['message']);
  							$url = route('payment.failed.retry', ['id' => $checkout->id]);
    					}

    					$checkout->save();
    					$success = 1;
    				}else{
    					$error = 'No payment intent';
    				}
    			}else{
    				$error = 'You are not authorized';
    			}
    		}else{
    			$error = 'No user/checkout';
    		}
    	}else{
    		$error = 'No data';
    	}

    	echo json_encode(['success' => $success, 'error' => $error, 'url' => $url]);
    }

    public function validateFailedCheckout($id){

        $commonMethods = new CommonMethods();
        $checkout = StripeCheckout::find($id);
        if($checkout && $checkout->error && $checkout->stripe_payment_id){

            if(count($checkout->crowdfundCheckoutItems) && $checkout->user && $checkout->user->profile->stripe_user_id != '' && $checkout->customer){
                $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                array_push($headers, 'Stripe-Account: '.$checkout->user->profile->stripe_user_id);

                $paymentIntentId = $checkout->stripe_payment_id;
                $url = 'https://api.stripe.com/v1/payment_intents/'.$paymentIntentId;
                $paymentIntent = $commonMethods->stripeCall($url, $headers, [], 'GET');

                if($paymentIntent['last_payment_error'] && isset($paymentIntent['last_payment_error']['decline_code'])){
                    $return = true;
                }else{
                    $return = false;
                }
            }else{
                $return = false;
            }
        }else{
            $return = false;
        }

        return $return;
    }

    public function paymentFailedNotification(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();
        if($request->has('id') && $request->has('type')){

            $id = $request->get('id');
            $type = $request->get('type');
            $response = $this->validateFailedCheckout($id);
            if($response){

                $stripeCheckout = StripeCheckout::find($id);
                if($type == 'email'){
                    Mail::to($stripeCheckout->customer->email)->bcc(Config('constants.bcc_email'))->send(new Payment($stripeCheckout, 'failed'));
                }else if($type == 'account'){
                    $userNotification = new UserNotificationController();
                    $request->request->add(['user' => $stripeCheckout->customer->id, 'customer' => $stripeCheckout->user->id, 'type' => 'retry_failed_payment', 'source_id' => $stripeCheckout->id]);
                    $response = json_decode($userNotification->create($request), true);
                }
                $success = 1;
                Session::flash('success', 'Your notification has been sent to '.$stripeCheckout->customer->name);
            }else{
                $error = 'unknown error';
            }
        }else{
            $error = 'no data';
        }

        echo json_encode(['success' => $success, 'error' => $error]);
    }
}



?>
