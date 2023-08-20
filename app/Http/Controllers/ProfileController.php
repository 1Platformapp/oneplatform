<?php


namespace App\Http\Controllers;

use App\Http\Controllers\IndustryContactController;
use App\Http\Controllers\CommonMethods;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\GoogleDriveStorage;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PayPalController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use App\Mail\InstantCheckout;
use App\Mail\CancelSubscription;
use App\Mail\ExpertRequest;
use App\Mail\SecurePasswordChange;
use App\Mail\ProjectUpdate;
use App\Mail\User as MailUser;
use App\Mail\Chart;
use App\Mail\ThankYou;

use App\Models\Address;
use App\Models\Service;
use App\Models\PersonalDomain;
use App\Models\AgentTransfer;
use App\Models\InstantCheckoutItem;
use App\Models\CustomDomainSubscription;
use App\Models\InstantCheckoutItemDetail;
use App\Models\UserService;
use App\Models\UserProductDesign;
use App\Models\ContactQuestion;
use App\Models\ContactQuestionElement;
use App\Models\InternalSubscriptionInvoice;
use App\Models\CustomProduct;
use App\Models\Studio;
use App\Models\UserAlbum;
use App\Models\UserProduct;
use App\Models\UserPortfolio;
use App\Models\PortfolioElement;
use App\Models\UserNews;
use App\Models\UserFollow;
use App\Models\IndustryContactRegion;
use App\Models\IndustryContactCategoryGroup;
use App\Models\InternalSubscription;
use App\Models\UserLiveStream;
use App\Models\User;
use App\Models\UserChat;
use App\Models\AgentContact;
use App\Models\Expert;
use App\Models\CompetitionVideo;
use App\Models\UserUpload;
use App\Models\Test;
use App\Models\Profile;
use App\Models\VideoStream;
use App\Models\UserCampaign;
use App\Models\CampaignPerks;
use App\Models\StripeSubscription;
use App\Models\StripeCheckout;
use App\Models\ArtistJob;
use App\Models\City;
use App\Models\Competition;
use App\Models\Voucher;
use App\Models\Country;
use App\Models\CustomerBasket;
use App\Models\Genre;
use App\Models\UserMusic;
use App\Models\UserChatGroup;

use DB;
use Auth;
use Image;
use Session;
use Storage;
use Carbon\Carbon;
use File;
use Lang;
use Hash;
use Mail;
use Response;
use PDF;
use ZipArchive;


class ProfileController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity', ['except' => [
            'restricted',
        ]]);
    }

    public function index(Request $request)
    {
        $commonMethods = new CommonMethods();
        if(Auth::check()){

            $user = Auth::user();

            if($user->id == 627){

            	//$result = Mail::to('ahsanhanif99@gmail.com')->send(new \App\Mail\Agent(UserChat::all()->first()));
        		//exit;

        		//$fcm = new PushNotificationController();
        		//$return = $fcm->send('eyRJ5GFQGkXrgQHrQ3joy2:APA91bGJJj6_Bjqawvz_rdTl1Am0ygeKTJxKlfYEjOOzn-Nr_6ckQuNZfJ0Ftzzt8N_Kn-D3DMXKyb0CwqGk4GODXKUapw5UsOSYKCjaqX3E2jPMMht1Tcmh5ax_RjKXwORzZvKYBqwi', 'Message From Ahsan', 'The night is dark and full of terrors', 'ios');


        		//print($fileName);exit;

            }

            if(isset($request->email_user) && $user->id != $request->email_user){

                return redirect(route('logout'));
            }
        }else{

            return redirect(route('login'));
        }

        if($user->profile->basic_setup != 1 && !$user->is_buyer_only){

            if(Session::has('forceNext')){

                $forceN = Session::get('forceNext');
                Session::forget('forceNext');
                return redirect(route('profile.setup', ['page' => $forceN]));
            }else{

                $setupProfileWizard = $user->setupProfileWizard();

                if($setupProfileWizard['error'] != ''){

                    return redirect(route('profile.setup', ['page' => $setupProfileWizard['error']]));
                }
            }
        }

        if($request->session()->has('remember_music_search_filters')){

            return redirect(route('search'));
        }

        $campaignId = 0;

        if(isset($request->campaignId)){

            $userCampaign = $user->campaigns()->where('id', $request->campaignId)->first();
            $campaignId = $request->campaignId;
        }else{

            $userCampaign = $user->campaigns()->where('status', 'active')->orderBy('id', 'desc')->first();
        }

        if(!$userCampaign){

            $userCampaign = new UserCampaign;
            $userCampaign->user_id = $user->id;
            $userCampaign->save();
        }

        if($request->load_campaign != null){

            $userLoadCampaign = UserCampaign::find($request->load_campaign);
            if($userLoadCampaign && $userLoadCampaign->user_id == $user->id ){

                $userCampaign = $userLoadCampaign;
            }
        }

        $userId = $user->id;
        $userCampaignDetails = $commonMethods->getUserRealCampaignDetails($userId);
        $userPersonalDetails = $commonMethods::getUserRealDetails($userId);
        $userSocialAccountDetails = $commonMethods::getUserSocialAccountDetails($userId);
        $story_images = $user->profile->story_images;
        $genres = Genre::orderBy('name', 'asc')->get();
        $stripeSubscriptions = $user->stripe_subscriptions;
        $liveFlag = count($userCampaign->checkouts) > 0 ? '1' : '0';
        $basket = $commonMethods::getCustomerBasket();

        if($user->internalSubscription && $user->internalSubscription && $user->internalSubscription->subscription_status == 1 && $user->profile->stripe_secret_key != ''){
            $stripeUrl = '';
        }else{

            $stripeUrl = route('user.startup.wizard');
        }

        $allPastProjects = userCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();

        $albums = UserAlbum::all();

        $instantPurchases = StripeCheckout::where('customer_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
        $instantSales = StripeCheckout::where('user_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
        $crowdfundPurchases = StripeCheckout::where('customer_id', $user->id)->where('type', 'crowdfund')->orderBy('id' , 'desc')->get();
        $crowdfundSales = StripeCheckout::where('user_id', $user->id)->where('type', 'crowdfund')->orderBy('id' , 'desc')->get();
        $topSales = StripeCheckout::where('user_id', $user->id)->orderBy('id' , 'desc')->take(5)->get();

        $singlesSold = $albumsSold = $totalRevenue = $productsSold = 0;
        $fans = [];
        foreach ($instantSales as $key => $checkout) {
            foreach ($checkout->instantCheckoutItems as $key => $instantCheckoutItem) {

                if($instantCheckoutItem->type == 'music'){
                    $singlesSold++;
                }
                if($instantCheckoutItem->type == 'album'){
                    $albumsSold++;
                }
                if($instantCheckoutItem->type == 'product'){
                    $productsSold++;
                }
                if($instantCheckoutItem->type == 'custom-product'){
                    $productsSold++;
                }
                if($checkout->customer && !in_array($checkout->customer->id, $fans)){
                	$fans[] = $checkout->customer->id;
                }
            }

            $checkAmount = $checkout->application_fee ? $checkout->amount - $checkout->application_fee : $checkout->amount;
            $totalRevenue += $commonMethods->convert($checkout->currency, strtoupper($user->profile->default_currency), $checkAmount);
        }
        foreach ($crowdfundSales as $key => $checkout) {

            if($checkout->stripe_charge_id){

                $totalRevenue += $commonMethods->convert($checkout->currency, strtoupper($user->profile->default_currency), $checkout->amount);
            }
            if($checkout->customer && !in_array($checkout->customer->id, $fans)){
                $fans[] = $checkout->customer->id;
            }
        }

        $purchaseParticulars['fans'] = $fans;
        $purchaseParticulars['singles_sold'] = $singlesSold;
        $purchaseParticulars['albums_sold'] = $albumsSold;
        $purchaseParticulars['products_sold'] = $productsSold;
        $purchaseParticulars['total_revenue'] = $totalRevenue;

        if($user->hasActivePaidSubscription()){

            //$stripe = new Stripe(Config('constants.stripe_key_secret'), '2016-07-06');
            //$upcomingInvoice = $stripe->invoices()->upcomingInvoice($user->internalSubscription->stripe_customer_id);
        }

        if(isset($userCampaignDetails['campaignProjectVideoId']) && $userCampaignDetails['campaignProjectVideoId'] != ''){

            $userCampaignVideoId = $commonMethods->getYoutubeVideoId($userCampaignDetails['campaignProjectVideoId']);
        }else{
            $userCampaignVideoId = '';
        }

        if($user->hasActivePaidSubscription()){

            $industryContactRegions = IndustryContactRegion::orderBy('id', 'asc')->get();
            $industryContactCategoryGroups = IndustryContactCategoryGroup::orderBy('id', 'asc')->get();
            $industryContact = new IndustryContactController();
            $industryContactsArray = json_decode($industryContact->browse($request), TRUE);
            $industryContacts = is_array($industryContactsArray) && isset($industryContactsArray['data']) ? $industryContactsArray['data'] : '';
        }

        if($user->expert && $user->apply_expertgi295e == 2){

            $agentTransfers = AgentTransfer::where(['agent_id' => $user->id])->orderBy('id', 'desc')->get();
            if($user->expert->pdf == NULL){
                $pdfName = strtoupper('APA_'.uniqid()).'.pdf';
                $fileName = 'agent-agreements/'.$pdfName;
                $data = ['expert' => $user->expert];
                PDF::loadView('pdf.agent-platform-agreement', $data)->setPaper('a4', 'portrait')->setWarnings(false)->save($fileName);
                $user->expert->pdf = $pdfName;
                $user->expert->save();
            }
        }

        $agents = User::where('apply_expert', 2)->orderBy('name', 'asc')->get()->filter(function ($user){
            return $user->expert;
        });

        $loginController = new LoginController();
        $userOS = $loginController->getUserOS();

        $vouchers = [];
        if($user->isCotyso()){
            $database = Config('constants.clients_portal_database');
            $clientsPortalCon = $commonMethods->createDBConnection($database['host'], $database['username'], $database['password'], $database['database']);
            if($clientsPortalCon && $result = mysqli_query($clientsPortalCon, 'SELECT * FROM Voucher ORDER BY id DESC')){
                $assocArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach($assocArray as $key => $value){

                    $vouchers[$value['id']]['id'] = $value['id'];
                    $vouchers[$value['id']]['name'] = $value['name'];
                }
                mysqli_free_result($result);
            }
        }

        $data   = [

            'upcomingInvoice' => isset($upcomingInvoice) ? $upcomingInvoice : NULL,

            'commonMethods' => $commonMethods,

            'purchaseParticulars' => $purchaseParticulars,

            'user' => $user,

            'basket' => $basket,

            'userCampaignDetails' => $userCampaignDetails,

            'userPersonalDetails' => $userPersonalDetails,

            'userSocialAccountDetails' => $userSocialAccountDetails,

            'story_images' => $story_images,

            'userCampaignVideoId' => $userCampaignVideoId,

            'genres' => $genres,

            'stripeSubscriptions' => $stripeSubscriptions,

            'userCampaign' => $userCampaign,

            'stripeUrl' => $stripeUrl,

            'liveFlag' =>$liveFlag,

            'allPastProjects' => $allPastProjects,

            'albums' => $albums,

            'instantPurchases' => $instantPurchases,

            'instantSales' => $instantSales,

            'crowdfundPurchases' => $crowdfundPurchases,

            'crowdfundSales' => $crowdfundSales,

            'domain' => $user->customDomainSubscription,

            'icRegions' => isset($industryContactRegions) ? $industryContactRegions : [],

            'icCategoryGroups' => isset($industryContactCategoryGroups) ? $industryContactCategoryGroups : [],

            'industryContacts' => isset($industryContacts) ? $industryContacts : '',

            'agentTransfers' => isset($agentTransfers) ? $agentTransfers : null,

            'agents' => $agents,

            'userOS' => $userOS,

            'topSales' => $topSales,

            'vouchers' => $vouchers,

        ];

        if(isset($request->page)){

            Session::flash('page', $request->page);

        }

        if($user->is_buyer_only == null && $user->username == null){

            $recommendedUsername = $user->recommendedUsername();
            Session::flash('general_user_first_things_first', $recommendedUsername);
        }

        if($user->profile->stripe_secret_key == ''){

            Session::flash('seller_stripe_prompt', '1');
        }

        if(strpos($user->email, '@social.com') !== false){

            Session::flash('user_has_invalid_email', '1');
        }

        $this->updateUserStripeData($user);

        return view( 'pages.profile', $data );

    }

    public function adminChat(Request $request){

        if(Auth::check() && Auth::user()->id == 1){

            $user = Auth::user();

            $data   = [

                'user' => $user,

            ];

            return view( 'pages.admin-chat', $data );
        }else{

            return redirect(route('profile'));
        }
    }

    public function startupWizard(Request $request, $action = null){

        $referer = request()->headers->get('referer');
        if ($referer && strpos($referer, '/profile-setup/' ) !== false) {

            $backBtnUrl = $referer;
            $backBtnUrl = str_replace('profile-setup', 'profile-setup/next', $backBtnUrl);
        }else{
            $backBtnUrl = '';
        }

        $user = Auth::check() ? Auth::user() : NULL;

        if(!$user){

            return redirect('login');
        }

        if($user->profile->stripe_secret_key == '' && ($user->profile->default_currency == null || $user->username == null)){

            $recommendedUsername = $user->recommendedUsername();
            Session::flash('seller_first_things_first', $recommendedUsername);
        }

        if(!$action){

            if($user->internalSubscription && $user->profile->stripe_secret_key != '' && $user->profile->stripe_secret_key != NULL && $user->profile->paypal_merchant_id != '' && $user->profile->paypal_merchant_id != NULL){

                return redirect(route('profile'));
            }else{

                if($user->profile->stripe_secret_key == '' || $user->profile->stripe_secret_key == NULL){

                    $authorize_request_body = array(
                        'response_type' => 'code',
                        'scope' => 'read_write',
                        'client_id' => Config('constants.stripe_connect_client_id')
                    );
                    $userName = explode("@", preg_replace('/\s+/', ' ', $user->email));
                    $stripeUrl = Config('constants.stripe_connect_authorize_uri') . '?' . http_build_query($authorize_request_body) . '&redirect_uri='.Config('services.stripe.redirect').'&stripe_user[email]='.$user->email.'&stripe_user[business_name]='.$user->name.'&stripe_user[url]='.($user->username?route('user.home',['params' => $user->username]):'');

                }else{

                    $stripeUrl = '';
                }

                if($user->profile->paypal_merchant_id == '' || $user->profile->paypal_merchant_id == NULL){

                    $paypalUrl = PayPalController::getSignupLink($request, $user->id);
                }else{

                    $paypalUrl = '';
                }

                $data = [

                    'user' => $user,

                    'stripeUrl' => $stripeUrl,

                    'paypalUrl' => $paypalUrl,

                    'backBtnUrl' => $backBtnUrl
                ];

                return view( 'pages.startup-wizard', $data );
            }
        }else if($action == 'upgrade-subscription'){

            if(!$user->internalSubscription){

                return redirect(route('profile'));
            }

            $package = explode('_', $user->internalSubscription->subscription_package);
            if($package[0] != 'silver'){

                return redirect(route('profile'));
            }

            $data = [

                'user' => $user,

                'action' => $action,

                'backBtnUrl' => $backBtnUrl
            ];

            return view( 'pages.startup-wizard', $data );
        }
    }

    public function updateUserStripeData(User $user, $action = null){

        $commonMethods = new CommonMethods();

        if($user){

            if(!$action){

                $lastUpdated = $user->profile->stripe_data_last_updated_at;
                if($user->internalSubscription && $user->internalSubscription->stripe_customer_id && $user->internalSubscription->stripe_subscription_id && (!$lastUpdated || strtotime(date('Y-m-d H:i:s')) - strtotime($lastUpdated) >= 86400)){

                    // updates the stripe data once in a day

                    $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                    $url = 'https://api.stripe.com/v1/subscriptions/'.$user->internalSubscription->stripe_subscription_id;
                    $subscription = $commonMethods->stripeCall($url, $headers, [], 'GET');
                    if(isset($subscription['id'])){

                        // updates the subscription
                        $user->internalSubscription->subscription_status = $subscription['status'] == 'active' ? 1 : 0;
                        //$user->internalSubscription->save();
                    }

                    if(isset($subscription['id'])){

                        $url = 'https://api.stripe.com/v1/invoices';
                        $fields = [
                            'subscription' => $subscription['id']
                        ];
                        $invoices = $commonMethods->stripeCall($url, $headers, $fields, 'GET');
                        if(count($invoices['data'])){
                            foreach ($invoices['data'] as $invoice) {
                                $internalInvoice = InternalSubscriptionInvoice::where(['stripe_invoice_id' => $invoice['id']])->first();
                                if(!$internalInvoice){

                                    // creates an invoice
                                    $internalInvoice = new InternalSubscriptionInvoice();
                                    $internalInvoice->stripe_invoice_id = $invoice['id'];
                                    $internalInvoice->internal_subscription_id = $user->internalSubscription->id;
                                    $internalInvoice->amount_due = $invoice['amount_due'];
                                    $internalInvoice->amount_paid = $invoice['amount_paid'];
                                    $internalInvoice->attempt_count = $invoice['attempt_count'];
                                    $internalInvoice->stripe_charge_id = $invoice['charge'] != '' ? $invoice['charge'] : NULL;
                                    $internalInvoice->created_at_stripe = $invoice['created'];
                                    $internalInvoice->currency = $invoice['currency'];
                                    $internalInvoice->pay_invoice_url = $invoice['hosted_invoice_url'] != '' ? $invoice['hosted_invoice_url'] : NULL;
                                    $internalInvoice->download_invoice_url = $invoice['invoice_pdf'] != '' ? $invoice['invoice_pdf'] : NULL;
                                    $internalInvoice->period_start = $invoice['lines']['data'][0]['period']['start'];
                                    $internalInvoice->period_end = $invoice['lines']['data'][0]['period']['end'];
                                    $internalInvoice->next_payment_attempt = $invoice['next_payment_attempt'] == '' ? NULL : $invoice['next_payment_attempt'];
                                    $internalInvoice->status = $invoice['status'];
                                    $internalInvoice->paid_at_stripe = isset($invoice['status_transitions']['paid_at']) && $invoice['status_transitions']['paid_at'] != '' ? $invoice['status_transitions']['paid_at'] : NULL;

                                    $internalInvoice->save();
                                }else if($internalInvoice && ($internalInvoice->status != $invoice['status'] || $internalInvoice->attempt_count != $invoice['attempt_count'])){

                                    //updates an invoice
                                    $internalInvoice->status = $invoice['status'];
                                    $internalInvoice->paid_at_stripe = isset($invoice['status_transitions']['paid_at']) && $invoice['status_transitions']['paid_at'] != '' ? $invoice['status_transitions']['paid_at'] : NULL;
                                    $internalInvoice->next_payment_attempt = $invoice['next_payment_attempt'] == '' ? NULL : $invoice['next_payment_attempt'];
                                    $internalInvoice->amount_due = $invoice['amount_due'];
                                    $internalInvoice->amount_paid = $invoice['amount_paid'];
                                    $internalInvoice->attempt_count = $invoice['attempt_count'];
                                    $internalInvoice->stripe_charge_id = $invoice['charge'] != '' ? $invoice['charge'] : NULL;
                                    $internalInvoice->pay_invoice_url = $invoice['hosted_invoice_url'] != '' ? $invoice['hosted_invoice_url'] : NULL;
                                    $internalInvoice->download_invoice_url = $invoice['invoice_pdf'] != '' ? $invoice['invoice_pdf'] : NULL;
                                    $internalInvoice->next_payment_attempt = $invoice['next_payment_attempt'] == '' ? NULL : $invoice['next_payment_attempt'];

                                    $internalInvoice->save();
                                }
                            }
                        }

                        $user->profile->stripe_data_last_updated_at = date('Y-m-d H:i:s');
                        $user->profile->save();
                    }
                }
            }else if($action == 'cancel_subscription'){

            }
        }
    }

    public function checkVoucherCode(Request $request){

        if ($request->isMethod('post') && $request->has('code') && $request->has('original_price')) {

            $user = Auth::user();
            $success = 0;
            $error = '';
            $data = ['success' => 0, 'error' => '', 'original_price' => 0, 'final_price' => 0];
            if($user){

                $discountCode = $request->get('code');
                $data['original_price'] = $request->get('original_price');
                $originalPrice = str_replace(['+', '-'], '', filter_var($data['original_price'], FILTER_SANITIZE_NUMBER_INT));
                $checkVoucher = Voucher::where(['code' => $discountCode])->first();
                if($checkVoucher){

                    if($checkVoucher->user == NULL || ($checkVoucher->user && $checkVoucher->user->id == $user->id)){

                        if($checkVoucher->used == NULL){

                            $coupons = Config('constants.coupons');
                            if($checkVoucher->percent_off == 25){

                                $data['final_price'] = $originalPrice - ($originalPrice * 0.25);
                                $data['success'] = 1;
                            }else if($checkVoucher->percent_off == 50){

                                $data['final_price'] = $originalPrice - ($originalPrice * 0.5);
                                $data['success'] = 1;
                            }else if($checkVoucher->percent_off == 100){

                                $data['final_price'] = 0;
                                $data['success'] = 1;
                            }else{

                                $data['error'] = 'Coupon unknown discount percentage';
                            }
                        }else{

                            $data['error'] = 'The discount code provided has been used';
                        }
                    }else{

                        $data['error'] = 'You don\'t have permission to use this code';
                    }
                }else{

                    $data['error'] = 'The discount code provided is not valid';
                }
            }else{
                $data['error'] = 'no/protected data';
            }
        }else{
            $data['error'] = 'inappropraite request';
        }

        return json_encode($data);
    }

    public function processInternalSubscription(Request $request){

    	header('Content-Type: application/json');
        $commonMethods = new CommonMethods();
    	$jsonStr = file_get_contents('php://input');
    	$jsonObj = json_decode($jsonStr);

        $user = Auth::user();
        $success = 0;
        $error = '';
        $data = ['subscription_id' => 0, 'subscription_status' => '', 'subscription_payment_intent_status' => '', 'subscription_payment_intent_client_secret' => '', 'internal_subscription_id' => 0];
        if($user && isset($jsonObj->package)){

            $paymentMethodId = $jsonObj->paymentMethodId;
            $package = $jsonObj->package;
            $discountCode = $jsonObj->discount;
            $cardName = $jsonObj->cardName;

            if($paymentMethodId !== null){

                $response = $this->createInternalSubscription($user, $package, $paymentMethodId, $cardName, $discountCode);
                if($response && is_array($response) && isset($response['subscription']) && isset($response['subscription']['error'])){
                    $error = $response['subscription']['error']['message'];
                }else if($response && is_array($response) && isset($response['customer']) && isset($response['subscription']) && $response['subscription']['status'] == 'active'){

                    if($user->internalSubscription){

                        $user->internalSubscription->delete();
                    }

                    $card = $response['paymentMethod']['card'];

                    $userInternalSubscription = new InternalSubscription();
                    $userInternalSubscription->user_id = $user->id;
                    $userInternalSubscription->stripe_subscription_id = $response['subscription']['id'];
                    $userInternalSubscription->stripe_customer_id = $response['customer']['id'];
                    $userInternalSubscription->subscription_status = ($response['subscription']['status'] == 'active') ? 1 : 0;
                    $userInternalSubscription->subscription_card = ['name' => $cardName, 'number' => $card['last4'], 'cvv' => '***', 'expiration_month' => $card['exp_month'], 'expiration_year' => $card['exp_year']];
                    $userInternalSubscription->subscription_package = $package;
                    $userInternalSubscription->save();

                    $data['subscription_id'] = $response['subscription']['id'];
                    $data['subscription_status'] = $response['subscription']['status'];
                    $data['internal_subscription_id'] = $userInternalSubscription->id;

                    $user->is_buyer_only = NULL;
                    $user->save();
                    $success = 1;
                }else if($response && is_array($response) && isset($response['error'])){

                    $error = $response['error'];
                }else if($response && isset($response['subscription']) && $response['subscription']['status'] == 'incomplete'){

                    if($user->internalSubscription){

                        $user->internalSubscription->delete();
                    }

                	$card = $response['paymentMethod']['card'];
                    $paymentIntent = $response['subscription']['latest_invoice']['payment_intent'];
                    $data['subscription_payment_intent_status'] = $paymentIntent['status'];
                    $data['subscription_payment_intent_client_secret'] = $paymentIntent['client_secret'];

                    $userInternalSubscription = new InternalSubscription();
                    $userInternalSubscription->user_id = $user->id;
                    $userInternalSubscription->stripe_subscription_id = $response['subscription']['id'];
                    $userInternalSubscription->stripe_customer_id = $response['customer']['id'];
                    $userInternalSubscription->subscription_status = 0;
                    $userInternalSubscription->subscription_card = ['name' => $cardName, 'number' => $card['last4'], 'cvv' => '***', 'expiration_month' => $card['exp_month'], 'expiration_year' => $card['exp_year']];
                    $userInternalSubscription->subscription_package = $package;
                    $userInternalSubscription->save();

                    $data['subscription_id'] = $response['subscription']['id'];
                    $data['subscription_status'] = $response['subscription']['status'];
                    $data['internal_subscription_id'] = $userInternalSubscription->id;

                    $success = 1;
                }
            }else if($jsonObj->action == 'update_internal'){

                $userInternalSubscription = InternalSubscription::find($jsonObj->internalId);
                if($userInternalSubscription && $userInternalSubscription->user_id == $user->id && $userInternalSubscription->status == 0){
                	$userInternalSubscription->subscription_status = 1;
                	$userInternalSubscription->save();

                    $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                    $url = 'https://api.stripe.com/v1/subscriptions/'.$userInternalSubscription->stripe_subscription_id;
                    $stripeSubscription = $commonMethods->stripeCall($url, $headers, [], 'GET');
                    if(isset($stripeSubscription['metadata']) && count($stripeSubscription['metadata']) && isset($stripeSubscription['metadata']['voucher'])){
                        $voucherId = $stripeSubscription['metadata']['voucher'];
                        $voucher = Voucher::find($voucherId);
                        if($voucher){
                            $voucher->used = 1;
                            $voucher->user_id = $user->id;
                            $voucher->save();
                        }
                    }

                	$success = 1;
                }else{
                	$error = 'invalid internal';
                }
            }else if($jsonObj->action == 'purchase_free'){

                if($user->internalSubscription){

                    $user->internalSubscription->delete();
                }

                $userInternalSubscription = new InternalSubscription();
                $userInternalSubscription->user_id = $user->id;
                $userInternalSubscription->subscription_package = 'silver_0_0';
                $userInternalSubscription->subscription_status = 1;
                $userInternalSubscription->save();

                $user->is_buyer_only = NULL;
                $user->save();
                $success = 1;
            }else{
                $error = 'unknown or invalid action';
            }
        }else{
            $error = 'no/protected data';
        }

        return json_encode(array('success' => $success, 'error' => $error, 'data' => $data));
    }

    public function updateUserChatSwitch(Request $request){

        $user = Auth::user();
        $success = 0;
        $error = '';

        if($user && $request->has('value')){

            $user->chat_switch = $request->get('value');
            $user->save();

            $success = 1;
        }else{

            $error = 'No or protected data';
        }

        return json_encode(array('success' => $success, 'error' => $error));
    }

    public function sortItems(Request $request){

        if ($request->isMethod('post')) {

            $user = Auth::user();
            $success = 0;
            $error = '';
            if($user && $request->has('element') && $request->has('adjacent')){

                $element = $request->get('element');
                $adjacent = $request->get('adjacent');
                $explodeElement = explode('_', $element);
                $explodeAdjacent = explode('_', $adjacent);

                if(count($explodeElement) && count($explodeAdjacent)){
                    if($explodeElement[0] == 'product'){

                        $productId = $explodeElement[1];
                        $adjacentProductId = $explodeAdjacent[1];
                        $userProduct = UserProduct::where(['user_id' => $user->id, 'id' => $productId])->first();
                        $userAdjacentProduct = UserProduct::where(['user_id' => $user->id, 'id' => $adjacentProductId])->first();
                        if($userProduct && $userAdjacentProduct){
                            $productOrder = $userProduct->order;
                            $adjacentProductOrder = $userAdjacentProduct->order;
                            $userProduct->order = $adjacentProductOrder;
                            $userAdjacentProduct->order = $productOrder;
                            $userProduct->save();
                            $userAdjacentProduct->save();
                            $success = 1;
                        }else{
                            $error = 'user is unauthorized for this request';
                        }
                    }else if($explodeElement[0] == 'music'){

                        $musicId = $explodeElement[1];
                        $adjacentMusicId = $explodeAdjacent[1];
                        $userMusic = UserMusic::where(['user_id' => $user->id, 'id' => $musicId])->first();
                        $userAdjacentMusic = UserMusic::where(['user_id' => $user->id, 'id' => $adjacentMusicId])->first();
                        if($userMusic && $userAdjacentMusic){
                            $musicOrder = $userMusic->order;
                            $adjacentMusicOrder = $userAdjacentMusic->order;
                            $userMusic->order = $adjacentMusicOrder;
                            $userAdjacentMusic->order = $musicOrder;
                            $userMusic->save();
                            $userAdjacentMusic->save();
                            $success = 1;
                        }else{
                            $error = 'user is unauthorized for this request';
                        }
                    }else if($explodeElement[0] == 'port'){

                        $portfolioId = $explodeElement[1];
                        $adjacentPortfolioId = $explodeAdjacent[1];
                        $userPortfolio = UserPortfolio::where(['user_id' => $user->id, 'id' => $portfolioId])->first();
                        $userAdjacentPortfolio = UserPortfolio::where(['user_id' => $user->id, 'id' => $adjacentPortfolioId])->first();
                        if($userPortfolio && $userAdjacentPortfolio){
                            $portOrder = $userPortfolio->order;
                            $adjacentPortOrder = $userAdjacentPortfolio->order;
                            $userPortfolio->order = $adjacentPortOrder;
                            $userAdjacentPortfolio->order = $portOrder;
                            $userPortfolio->save();
                            $userAdjacentPortfolio->save();
                            $success = 1;
                        }else{
                            $error = 'user is unauthorized for this request';
                        }
                    }else if($explodeElement[0] == 'qa'){

                        $questionId = $explodeElement[1];
                        $adjacentQuestionId = $explodeAdjacent[1];
                        $question = ContactQuestion::where(['id' => $questionId])->first();
                        $adjacentQuestion = ContactQuestion::where(['id' => $adjacentQuestionId])->first();
                        if($question && $adjacentQuestion){
                            $questionOrder = $question->order;
                            $adjacentQuestionOrder = $adjacentQuestion->order;
                            $question->order = $adjacentQuestionOrder;
                            $adjacentQuestion->order = $questionOrder;
                            $question->save();
                            $adjacentQuestion->save();
                            $success = 1;
                        }else{
                            $error = 'user is unauthorized for this request';
                        }
                    }else if($explodeElement[0] == 'qans'){

                        $questionElementId = $explodeElement[1];
                        $adjacentQuestionElementId = $explodeAdjacent[1];
                        $questionElement = ContactQuestionElement::where(['id' => $questionElementId])->first();
                        $adjacentQuestionElement = ContactQuestionElement::where(['id' => $adjacentQuestionElementId])->first();
                        if($questionElement && $adjacentQuestionElement){
                            $questionElementOrder = $questionElement->order;
                            $adjacentQuestionElementOrder = $adjacentQuestionElement->order;
                            $questionElement->order = $adjacentQuestionElementOrder;
                            $adjacentQuestionElement->order = $questionElementOrder;
                            $questionElement->save();
                            $adjacentQuestionElement->save();
                            $success = 1;
                        }else{
                            $error = 'user is unauthorized for this request';
                        }
                    }else{
                        $error = 'incomplete data';
                    }
                }else{
                    $error = 'inappropraite data';
                }
            }else{
                $error = 'no/protected data';
            }
        }else{
            $error = 'inappropraite request';
        }

        return json_encode(array('success' => $success, 'error' => $error));
    }


    public function createInternalSubscription($user, $package, $paymentMethodId, $cardName, $discountCode){

    	$commonMethods = new CommonMethods();

        $package = explode('_', $package);
        $packagess = Config('constants.user_internal_packages');
        if($package[0] == 'gold' && $package[2] == 'month'){
            // stripe nickname => Gold Package (£15/month)
            $planId = $packagess[1]['plans']['month'];
        }else if($package[0] == 'gold' && $package[2] == 'year'){
            // stripe nickname => Gold Package (£150/year)
            $planId = $packagess[1]['plans']['year'];
        }else if($package[0] == 'platinum' && $package[2] == 'month'){
            // stripe nickname => Platinum Package (£65/month)
            $planId = $packagess[2]['plans']['month'];
        }else if($package[0] == 'platinum' && $package[2] == 'year'){
            // stripe nickname => Platinum Package (£650/year)
            $planId = $packagess[2]['plans']['year'];
        }else{
            $planId = '';
        }

        if($planId != ''){

            $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
            try {

                $url = 'https://api.stripe.com/v1/customers';
                $fields = [
                    'name' => $cardName
                ];
                $stripeCustomer = $commonMethods->stripeCall($url, $headers, $fields);

                $url = 'https://api.stripe.com/v1/payment_methods/'.$paymentMethodId.'/attach';
                $fields = [
                    'customer' => $stripeCustomer['id'],
                ];
                $commonMethods->stripeCall($url, $headers, $fields);

                $url = 'https://api.stripe.com/v1/customers/'.$stripeCustomer['id'];
                $fields = [
                    'invoice_settings' => ['default_payment_method' => $paymentMethodId],
                ];
                $commonMethods->stripeCall($url, $headers, $fields);

                $url = 'https://api.stripe.com/v1/payment_methods/'.$paymentMethodId;
                $paymentMethod = $commonMethods->stripeCall($url, $headers, [], 'GET');

                if($discountCode != ''){

                    $admins = Config('constants.admins');
                    $checkVoucher = Voucher::where(['code' => $discountCode])->first();
                    if($checkVoucher){

                        if($checkVoucher->user == NULL || ($checkVoucher->user && $checkVoucher->user->id == $user->id)){

                            if($checkVoucher->used == NULL){

                                $coupons = Config('constants.coupons');
                                if($user->id == $admins['masteradmin']['user_id']){

                                    $couponId = $coupons[4]['id'];
                                }else if($checkVoucher->percent_off == 25){

                                    $couponId = $coupons[3]['id'];
                                }else if($checkVoucher->percent_off == 50){

                                    $couponId = $coupons[2]['id'];
                                }else if($checkVoucher->percent_off == 100){

                                    $couponId = $coupons[1]['id'];
                                }else{

                                    return array('error' => 'Coupon unknown discount percentage');
                                }

                                $url = 'https://api.stripe.com/v1/subscriptions';
                                $fields = [
                                	'customer' => $stripeCustomer['id'],
                                    'items' => [['price' => $planId]],
                                    'coupon' => $couponId,
                                    'payment_behavior' => 'allow_incomplete',
                                    'expand' => ['latest_invoice.payment_intent'],
                                    'metadata' => ['voucher' => $checkVoucher->id]
                                ];
                                $subscription = $commonMethods->stripeCall($url, $headers, $fields);

                                if(is_array($subscription) && isset($subscription['status']) && $subscription['status'] == 'active'){

                                    $checkVoucher->user_id = $user->id;
                                    $checkVoucher->used = 1;
                                    $checkVoucher->save();
                                }
                            }else{

                                return array('error' => 'The discount code provided has been used');
                            }
                        }else{

                            return array('error' => 'You don\'t have permission to use this code');
                        }
                    }else{

                        return array('error' => 'The discount code provided is not valid');
                    }
                }else{

                    $url = 'https://api.stripe.com/v1/subscriptions';
                    $fields = [
                    	'customer' => $stripeCustomer['id'],
                        'items' => [['price' => $planId]],
                        'payment_behavior' => 'allow_incomplete',
                        'expand' => ['latest_invoice.payment_intent'],
                    ];
                    $subscription = $commonMethods->stripeCall($url, $headers, $fields);
                }

                return array('customer' => $stripeCustomer, 'subscription' => $subscription, 'paymentMethod' => $paymentMethod);
            }catch(\Exception $ex){

                return array('error' => $ex->getMessage());
            }
        }else{
            return array('error' => 'Payment details are not complete');
        }
    }

    public function userDashboardPreview($logo, $layout, $userParams, Request $request)
    {

        $user = User::where('username', $userParams)->where('active' , '1')->first();

        if(!$user){
            return redirect(route('site.home'));
        }

        $videos = [];

        $commonMethods = new CommonMethods();

        $competition = Competition::first();

        if( $competition ) {

            $videos = $competition->videos()->where('show_in_cart', 1)->with( 'profile.user.address', 'profile.job' )->orderBy( DB::raw( 'ISNULL(`rank`),`rank`' ) )->get();
        }

        $userVideo = $competition->videos()->where('profile_id', $user->profile->id)->orderBy( 'id', 'desc' )->first();

        $projectVideo = $user->profile->user_bio_video_url != "" ? Youtube::parseVIdFromURL($user->profile->user_bio_video_url) : "";

        $defaultVideoId = '0cSXq4TYIIk';

        if($userVideo) {

            $defaultVideoId = $userVideo->video_id;

        }

        if($projectVideo !==''){

            $defaultVideoId =  $projectVideo;

        }

        $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);

        $userCampaignDetails = $commonMethods->getUserRealCampaignDetails($user->id);

        $userPersonalDetails = $commonMethods->getUserRealDetails($user->id);



        $musics = $user->musics;

        $products = $user->products;

        $myChannelVideos = $user->profile->competitionVideos;

        $checkouts = $user->checkouts;

        $basket = $commonMethods::getCustomerBasket();


        $whereClause = ['user_id' => $user->id, 'featured' => '1'];

        $userFeatMusics = UserMusic::where($whereClause)->get();

        $userFeatProducts = UserProduct::where($whereClause)->get();

        $userFeatAlbums = UserAlbum::where($whereClause)->get();

        $albums = $user->albums;

        $loadUserTab = '0';

        if (session::has('loadVideo')) {

            $videoInfo = Session::get('loadVideo');
            Session::forget('loadVideo');
            $explode = explode('~', $videoInfo);
            $defaultVideoId = $explode[0];
            $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);
        }


        $data   = [

            'videos' => $videos,

            'user' => $user,

            'userParams' => $userParams,

            'commonMethods' => $commonMethods,

            'userCampaignDetails' => $userCampaignDetails,

            'userPersonalDetails' => $userPersonalDetails,

            'musics' => $musics,

            'products' => $products,

            'myChannelVideos' => $myChannelVideos,

            'checkouts' => $checkouts,

            'basket' => $basket,

            'defaultVideoId' => $defaultVideoId,

            'defaultVideoTitle' => $defaultVideoTitle,

            'userFeatMusics' => $userFeatMusics,

            'userFeatProducts' => $userFeatProducts,

            'userFeatAlbums' => $userFeatAlbums,

            'albums' => $albums,

            'loadUserTab' => $loadUserTab,

            'layout' => $layout,

            'logo' => $logo,

        ];

        return view( 'pages.user-home-preview', $data );

    }

    public function userDashboardWithTab($params, $tab){

        Session::flash('loadUserTabTop', $tab);
        return redirect(route('user.home', ['params' => $params]));
    }

    public function profileWithTab($tab, $subTab = null){

        Session::flash('page', $tab);
        if($subTab){
            Session::flash('subTab', $subTab);
        }

        return redirect(route('profile'));
    }

    public function profileWithTabInfo($tab, $info){

        Session::flash('page', $tab);
        if($tab == 'chat'){

            $explode = explode('_', $info);
            if($explode[0] == 'conv'){

                $chat = UserChat::find($explode[1]);
                if($chat){
                	if($chat->group){
                	    Session::flash('pagecontentopener', 'group_'.$chat->group->id);
                	}else{
                	    Session::flash('pagecontentopener', 'partner_'.$chat->id);
                	}
                }
            }
        }else if($tab == 'edit' && $info == 'notifications'){

            Session::flash('notificationsopener', '1');
        }else if($tab == 'edit' && $info == 'cards'){

            Session::flash('cardsopener', '1');
        }

        return redirect(route('profile'));
    }

    public function changePasswordSecure(Request $request){

        $return = ['success' => 0, 'error' => ''];
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 30;

        if($request->has('email_address') && $request->get('action') == 'request'){

            $email = $request->get('email_address');
            $user = User::where(['email' => $email, 'security_level' => 10])->first();
            if($user){

                if(Auth::check() && Auth::user()->id == $user->id){

                    $secureToken = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
                    $user->security_token = $secureToken;
                    $user->security_token_expiration = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')." +15 minutes"));
                    $user->save();
                    $result = Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new SecurePasswordChange($user));

                    $return['success'] = 1;
                }else{

                    $return['error'] = 'You are not authorised to make this request';
                }
            }else{

                $return['error'] = 'This is not a valid secure account email';
            }
        }else if($request->get('action') == 'execute' && $request->has('security_token') && $request->has('new_password') && $request->has('new_password_confirmation')){

            $user = Auth::user();
            $securityToken = $request->get('security_token');
            $newPassword = $request->get('new_password');
            $newPasswordConfirmation = $request->get('new_password_confirmation');
            if($newPassword == $newPasswordConfirmation && strlen($newPassword) >= 6){

                if($user->security_token == $securityToken){

                    $now = strtotime(date('Y-m-d H:i:s'));
                    $securityTokenExpiration = strtotime($user->security_token_expiration);
                    if($now <= $securityTokenExpiration){

                        $user->security_token = NULL;
                        $user->security_token_expiration = NULL;
                        $user->password = bcrypt($newPassword);
                        $user->save();

                        $return['success'] = 1;
                    }else{

                        $return['error'] = 'Your security token has expired';
                    }
                }else{

                    $return['error'] = 'Your security token is not valid';
                }
            }else{

                $return['error'] = 'Your new password is not valid. Make sure it is atleast 6 characters long and its confrmation is properly filled';
            }

        }else{
            $return['error'] = 'No or incomplete request';
        }

        return json_encode($return);
    }

    public function userDashboard($userParams)

    {

        $commonMethods = new CommonMethods();

        if($userParams == 'customDomain'){

            //$result = Mail::to('sheikh.muhammad.hanif.99@gmail.com')->send(new \App\Mail\Agent(UserChat::all()->first()));


            // routed from user custom domain
            $serverName = $_SERVER['SERVER_NAME'];
            $customDomainActiveSubscription = CustomDomainSubscription::where(['domain_url' => $serverName, 'status' => 1])->get()->first();
            if($customDomainActiveSubscription !== null){

                if(!$customDomainActiveSubscription->user){

                    return redirect(route('site.home'));
                }

                $user = $customDomainActiveSubscription->user;

                if($user->hasActivePaidSubscription()){

                }else{

                    return redirect(route('user.home', ['params' => $user->username]));
                }
            }

            if(!isset($_SESSION)) {
                session_start();
            }
            $mergeCartId =isset($_SESSION['basket_customer_id'])?$_SESSION['basket_customer_id']:time()+rand(10000, 99999);
            Session::flash('mergeCart', $mergeCartId);

            if($user->default_tab_home != null && $user->default_tab_home != ''){
                Session::flash('loadUserTab', $user->default_tab_home);
            }

        }else if($userParams != ''){

            $user = User::where('username', $userParams)->where('active' , '1')->first();

            if(!$user){

                if(Auth::check()){

                    return redirect(route('profile'));
                }
                return redirect(route('site.home'));
            }

            if($user->default_tab_home != null && $user->default_tab_home != ''){
                Session::flash('loadUserTab', $user->default_tab_home);
            }
        }

        if($user->is_buyer_only || !$user->internalSubscription){

            if(Auth::check()){

                return redirect(route('profile'));
            }
            return redirect(route('site.home'));
        }

        $projectVideo = $user->profile->user_bio_video_url != "" ? Youtube::parseVIdFromURL($user->profile->user_bio_video_url) : "";

        $defaultVideoId = '0cSXq4TYIIk';

        if($projectVideo !== ''){

            $defaultVideoId =  $projectVideo;
        }

        $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);

        $userCampaignDetails = $commonMethods->getUserRealCampaignDetails($user->id);

        $userPersonalDetails = $commonMethods->getUserRealDetails($user->id);

        $myChannelVideos = $user->profile->competitionVideos;

        $basket = $commonMethods::getCustomerBasket();

        $whereClause = ['user_id' => $user->id, 'featured' => '1'];

        $userFeatMusics = UserMusic::where($whereClause)->get();

        $userFeatAlbums = UserAlbum::where($whereClause)->get();

        $userFeatProducts = UserProduct::where($whereClause)->get();

        $allPastProjects = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();

        if (session::has('loadUserTab')) {

            $loadUserTab = Session::get('loadUserTab');
            Session::forget('loadUserTab');
        }else{
            $loadUserTab = '0';
        }

        if (session::has('loadUserTabTop')) {

            $loadUserTab = Session::get('loadUserTabTop');
            Session::forget('loadUserTabTop');
        }

        if (session::has('loadVideo')) {

            $videoInfo = Session::get('loadVideo');
            Session::forget('loadVideo');
            $explode = explode('~', $videoInfo);
            $defaultVideoId = $explode[0];
            $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);
        }

        if(Session::has('show_popup') && Session::get('show_popup') != ''){
            $showPopup = Session::get('show_popup');
            Session::forget('show_popup');
        }else{
            $showPopup = '';
        }

        $referer = request()->headers->get('referer');
        if($referer != '' && $user->profile->splash && isset($user->profile->splash['type'])){

            if($user->profile->splash['type'] == 'product'){
                $item = UserProduct::find($user->profile->splash['id']);
            }else{
                $item = UserMusic::find($user->profile->splash['id']);
            }

            if($user->profile->splash['type'] == 'music'){
                $splashUrl = route('item.share.track', ['itemSlug' => str_slug($item->song_name)]);
            }else{
                $splashUrl = route('item.share.product', ['itemSlug' => str_slug($item->title)]);
            }
            if($referer == $splashUrl){
                Session::now('exempt_splash', '1');
            }
        }

        $this->updateUserStripeData($user);

        $userDStatus = $user->internalSubscription && $user->profile->stripe_user_id ? 0 : 1;

        if($user->isCotyso()){

        	Session::flash('notice', 'You will receive an E-voucher for print immediately after your purchase');
        }


        $data   = [

            'user' => $user,

            'userParams' => $userParams,

            'commonMethods' => $commonMethods,

            'userCampaignDetails' => $userCampaignDetails,

            'userPersonalDetails' => $userPersonalDetails,

            'myChannelVideos' => $myChannelVideos,

            'basket' => $basket,

            'defaultVideoId' => $defaultVideoId,

            'defaultVideoTitle' => $defaultVideoTitle,

            'userFeatMusics' => $userFeatMusics,

            'userFeatAlbums' => $userFeatAlbums,

            'userFeatProducts' => $userFeatProducts,

            'allPastProjects' => $allPastProjects,

            'loadUserTab' => $loadUserTab,

            'showPopup' => $showPopup,

            'userDStatus' => $userDStatus,

        ];

        return view( 'pages.user-home', $data );

    }



    public function postUserCompetitionVideo(Request $request)

    {

        $commonMethods = new CommonMethods();
        $return['error'] = $return['success'] = '';
        $error = '';


        if( Auth::check() ){

            $user = Auth::user();
            $videoUrl = $request->video_url;

            if(strlen($videoUrl)){

                if( CompetitionVideo::isValidURL( $videoUrl )){

                    $videoType = 'youtube';
                }else if( strpos($videoUrl, 'soundcloud.com' ) !== false ){

                    $videoType = 'soundcloud';
                }else{

                    $return['error'] = 'Video Url is invalid';
                }
            }else{

                $return['error'] = 'Video Url is empty';
            }
        }else{

            $return['error'] = 'User not authorised';
        }

        if( $return['error'] == '' ){

            $upload = new UserUpload();
            $upload->user_id = $user->id;
            $upload->link = $videoUrl;
            $upload->video_id = CompetitionVideo::isValidURL($videoUrl);
            $upload->type = $videoType;
            if($videoType == 'youtube'){

                $upload->fillYoutubeData();
            }
            if($videoType == 'soundcloud'){

                $request->showCart = 0;
            }
            $upload->artist = $user->name;
            $return['success'] = $upload->save();

            $userChartEntries = DB::table('competition_videos')->where(['show_in_cart' => 1, 'profile_id' => $user->profile->id])->get();

            if($request->showCart == 1){

                $pendingChartEntry = CompetitionVideo::where(['show_in_cart' => 0, 'profile_id' => $user->profile->id])->orderBy('id', 'desc')->first();
                if($pendingChartEntry){

                    $pendingChartEntry->delete();
                }

                $vid  = [

                    'title'        => '',
                    'artist'       => '',
                    'likes'        => 0,
                    'dislikes'     => 0,
                    'show_in_cart' => count($userChartEntries) ? 0 : $request->showCart,
                    'link'         => $videoUrl,
                    'video_id'     => CompetitionVideo::isValidURL( $videoUrl),
                    'type'         => $videoType
                ];
                $video = \App\Models\CompetitionVideo::create( $vid );

                if( $video ) {

                    ( $vid['type'] == 'youtube' ) ? $video->fillYoutubeData() : $video->fillSoundcloudData();
                    $video->artist = $user->name;
                    $user->profile->competitionVideos()->save( $video );
                    if( $competition = \App\Competition::first() ) {

                        $competition->videos()->save( $video );
                    }
                    $return['success'] = $video->save();

                    if($video->show_in_cart == 1){

                        Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new Chart('listed', $user));
                    }
                }
            }

            Session::flash('video_uploaded', '1');
            Session::flash('vidId', $upload->video_id);
        }else{

            Session::flash('error', 'Error: '.$return['error']);
        }



        //return $return;



        return Redirect::back()->with("page", "uploads");

    }



    public function deleteUserCompetitionVideo(Request $request){



        $return['error'] = $return['success'] = '';

        if( Auth::check() ){



            $user = Auth::user();

            $profileId = $user->profile->id;

            $video = UserUpload::find( $request->video_id );

            if( $video && $video->user_id == $user->id ){



                $return['success'] = $video->delete();

            }else{



                $return['error'] = 'Delete item and logged in user mismatch';

            }

        }else{



            $return['error'] = 'No user is logged in';

        }



        if( $return['error'] != '' ){



            Session::flash('error', 'Error: '.$return['error']);

        }



        Session::flash('page', 'uploads');

    }



    public function changePassword(Request $request)

    {



        $user = Auth::User();



        if( strlen(trim( $request->get('new_password'))) > 0 ){



            if( !$checkpass = Hash::check($request->current_password, Auth::user()->password) ){



                return 'Current password is incorrect';

            }else{



                if( strlen(trim( $request->get('new_password'))) >= 6 ){



                    $user->password = bcrypt( trim( $request->get('new_password')) );

                    //saving user password

                    $user->save();

                    return '1';

                }else{



                    return 'Password must be atleast 6 characters long';

                }

            }

        }

        return 'error';



    }

    public function saveUserProfileSeo(Request $request){

        $commonMethods = new CommonMethods();
        $user = Auth::User();
        $error = '';
        $success = '';
        $referer = request()->headers->get('referer');

        if($request->has('seo_title')){

            $user->profile->seo_title = $request->seo_title;
        }

        if($request->has('seo_keywords')){

            $user->profile->seo_keywords = $request->seo_keywords;
        }

        if($request->has('seo_description')){

            $user->profile->seo_description = $request->seo_description;
        }

        if($request->has('seo_h1')){

            $user->profile->seo_h1 = $request->seo_h1 != '' ? $request->seo_h1 : NULL;
        }

        $user->profile->save();

        return Redirect::back();
    }



    public function saveUserProfile(Request $request)

    {

        //ini_set('memory_limit', '512M');

        $commonMethods = new CommonMethods();

        $referer = request()->headers->get('referer');

        $user = Auth::User();



        $error = '';

        $success = '';

        if($request->has('name')){

            $user->name = $request->name;
        }

        if($request->has('first_name')){

            $user->first_name = $request->first_name;
        }

        if($request->has('surname')){

            $user->surname = $request->surname;
        }

        if($request->has('address')){

            $user->address->address_01 = $request->address;
        }

        if($request->has('country_id')){

            $user->address->country_id = $request->country_id;
        }

        if($request->has('city_id')){

            $user->address->city_id = $request->city_id;
        }

        if($request->has('postcode')){

            $user->address->post_code = $request->postcode;
        }

        if($request->has('genre_id')){

            $user->profile->genre_id = $request->genre_id;
        }

        if($request->has('skill')){

            $user->skills = $request->skill;
        }

        if($request->has('sec_skill')){

            $user->sec_skill = $request->sec_skill;
        }

        if($request->has('apply_for_expert')){

            $sendExpertEmail = $user->apply_expert != 1 && $request->apply_for_expert == 1 ? 1 : 0;
            $user->apply_expert = $request->apply_for_expert;
        }

        if($request->has('company')){

            $user->company = $request->company;
        }

        if($request->has('website')){

            $user->profile->website = $request->website;
        }

        if($request->has('phone')){

            $user->contact_number = $request->phone;
        }

        if($request->has('hear_about')){

            $user->hear_about = $request->hear_about;
        }

        if($request->has('maps_url')){

            $user->maps_url = $request->maps_url;
        }

        if($request->has('further_skills')){

            $furtherSkills = trim($request->further_skills);
            $furtherSkillIds = array();

            if( $furtherSkills != '' ){

                $explodeFurtherSkills = array_filter(explode(',', $furtherSkills));

                    foreach ($explodeFurtherSkills as $key => $furtherSkill) {

                        if( $furtherSkill != '' ){

                            $id = DB::table('music_instrument')->where('value', '=', $furtherSkill)->value('id');
                            if( $id ){
                                $furtherSkillIds[] = $id;
                            }
                        }
                    }
                }

            $furtherSkillIds = array_filter($furtherSkillIds);
            $user->further_skills = implode('-', $furtherSkillIds);
        }

        if($request->has('level')){

            $user->level = $request->level;
        }

        if( strlen(trim( $request->get('password'))) > 0 ){

            if( strlen(trim( $request->get('password'))) >= 6 ){

                $user->password = bcrypt( trim( $request->get('password')) );
            }else{

                $error .= '<span>Password Error: Must be alteast 6 characters long</span>';
            }
        }

        if($request->has('username')){

            $username = $request->get('username');
            $duplication = User::where('id', '!=' , $user->id)->where('username', $username)->first();
            if($duplication){
                Session::flash('error', 'Username already exists in our system. Choose another');
            }else{

                $user->username = $request->username;
            }
        }

        if($request->has('currency')){

            $user->profile->default_currency = $request->currency;
        }

        if($request->has('setup_finish')){

            $setupProfileWizard = $user->setupProfileWizard();

            if($setupProfileWizard['error'] == 'finish'){

                $user->profile->basic_setup = 1;
                $user->manager_chat = NULL;
            }
        }

        /*$input['email'] = $request->email_address;
        $validator = Validator::make($input, ['email' => 'required|unique:users,email,' . $user->id]);
        if ($validator->fails()) {

            $error .= '<span>Error: '.$validator->messages()->first().'</span>';
        }else{
            $user->email = $request->email_address;
        }
        */

        $imageName = $user->profile->profile_display_image;

        if($request->hasFile( 'profile_image' )){

            $profileImage = $request->file('profile_image');
            $extention = $profileImage->getClientOriginalExtension();
            $allowedExtensions = ['jpg', 'png', 'jpeg'];
            if(in_array($extention, $allowedExtensions)){

                $originalImageName = "user-orig-" . uniqid() . "." . $extention;
                $imageName = "user-dp-" . uniqid() . "." . $extention;
                $sliderImageName = "user-dp-slider" . uniqid() . "." . $extention;
                $cardImageName = "user-card-" . uniqid() . "." . $extention;

                $originalImagePath = public_path( 'user-display-images/' ).$originalImageName;
                $imagePath = public_path( 'user-display-images/' ).$imageName;
                $sliderImagePath = public_path( 'user-display-images/' ).$sliderImageName;
                $cardImagePath = public_path( 'user-display-images/' ).$cardImageName;

                $result = Image::make($profileImage)->resize(2000, null,function($constraint){$constraint->aspectRatio(); $constraint->upsize();})->save( $originalImagePath,60);
                $result = Image::make( $profileImage )->fit( 211,126 )->save( $imagePath,60);
                $result = Image::make( $profileImage )->fit( 200,113 )->save( $sliderImagePath,60);
                $result = Image::make($profileImage)->resize(650, null,function($constraint){$constraint->aspectRatio(); $constraint->upsize();})->save( $cardImagePath,60);


                if($user->profile->profile_display_image != "" && CommonMethods::fileExists(public_path( 'user-display-images/' ) . $user->profile->profile_display_image)) {

                    unlink(public_path('user-display-images/') . $user->profile->profile_display_image);
                }
                if($user->profile->profile_display_image_slider != "" && CommonMethods::fileExists(public_path( 'user-display-images/' ) . $user->profile->profile_display_image_slider)) {

                    unlink(public_path('user-display-images/') . $user->profile->profile_display_image_slider);
                }
                if($user->profile->profile_display_image_original != "" && CommonMethods::fileExists(public_path( 'user-display-images/' ) . $user->profile->profile_display_image_original)) {

                    unlink(public_path('user-display-images/') . $user->profile->profile_display_image_original);
                }
                if($user->profile->profile_display_image_card != "" && CommonMethods::fileExists(public_path( 'user-display-images/' ) . $user->profile->profile_display_image_card)) {

                    unlink(public_path('user-display-images/') . $user->profile->profile_display_image_card);
                }


                $user->profile->profile_display_image_original = $originalImageName;
                $user->profile->profile_display_image = $imageName;
                $user->profile->profile_display_image_slider = $sliderImageName;
                $user->profile->profile_display_image_card = $cardImageName;
            }
        }

        if($request->hasFile('pro_favicon_ico')){

            $icon = $request->file('pro_favicon_ico');
            $extention = $icon->getClientOriginalExtension();
            $allowedExtensions = ['ico'];
            if(in_array($extention, $allowedExtensions)){

                $faviconName = 'user-favicon-'.uniqid().'.'.$extention;
                $faviconPath = public_path('user-media/favicon/').$faviconName;
                if(move_uploaded_file($_FILES['pro_favicon_ico']['tmp_name'], $faviconPath)){

                    if($user->favicon_icon && CommonMethods::fileExists(public_path('user-media/favicon/').$user->favicon_icon)) {

                        unlink(public_path('user-media/favicon/').$user->favicon_icon);
                    }
                    $user->favicon_icon = $faviconName;
                }
            }
        }

        if($request->has('pro_splash_item')){

            $value = $request->get('pro_splash_item');
            if($value == ''){

                $user->profile->splash = null;
            }else{
                $explode = explode('_', $value);
                $id = $explode[1];
                $it = $explode[0];
                if($it == 'product'){

                    $item = UserProduct::where(['id' => $id, 'user_id' => $user->id])->get()->first();
                }else if($it == 'music'){

                    $item = UserMusic::where(['id' => $id, 'user_id' => $user->id])->get()->first();
                }

                if($item){

                    $user->profile->splash = ['type' => $it, 'id' => $id];
                }
            }
        }

        $user->save();
        $user->address->save();
        $user->profile->save();

        if( $error != '' ){

            Session::flash('error', $error);
        }

        if(isset($sendExpertEmail) && $sendExpertEmail){

            $result = Mail::to(config('constants.admin_email'))->bcc(Config('constants.bcc_email'))->send(new ExpertRequest('sent', $user));
        }

        Session::flash('profile_saved', '1');
        return Redirect::back()->with('page', '');
    }

    public function deleteUserPortfolio(Request $request){

        $return['error'] = $return['success'] = '';

        if( Auth::check() && $request->has('id') ){

            $user = Auth::user();
            $portfolio = UserPortfolio::find($request->id);

            if( $portfolio && ($portfolio->user_id == $user->id) || $user->isAgentOf($portfolio->user) ){

                if($portfolio->thumbnail && CommonMethods::fileExists(public_path('portfolio-images/').$portfolio->thumbnail)){

                    unlink(public_path('portfolio-images/').$portfolio->thumbnail);
                }

                if($portfolio->elements){

                    foreach ($portfolio->elements as $key => $element) {
                        if($element->type == 'image' && CommonMethods::fileExists(public_path('portfolio-images/').$element->value)){

                            unlink(public_path('portfolio-images/').$element->value);
                        }
                        $element->delete();
                    }
                }
                $return['success'] = $portfolio->delete();
            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

    }

    public function deleteUserService(Request $request){

        $return['error'] = $return['success'] = '';

        if( Auth::check() && $request->has('id') ){

            $user = Auth::user();
            $service = UserService::where(['id' => $request->id, 'user_id' => $user->id])->first();

            if( $service ){

                $return['success'] = $service->delete();
            }else{

                $return['error'] = 'Delete item does not exist';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

    }


    public function saveUserPortfolio(Request $request){

        if(Auth::check()){

            $user = Auth::user();

            if($request->has('port_sandbox')){

                $user = User::find($request->get('port_sandbox'));
            }

            if($request->has('portfolio_id')){

                $portfolioId = $request->get('portfolio_id');
                $portfolio = UserPortfolio::find($portfolioId);
                $portfolio->is_live = $request->has('live') && ($request->get('live') == 0 || $request->get('live') == '') ? 0 : 1;
            }else{

                $portfolio = new UserPortfolio();
                $portfolio->user_id = $user->id;

                $lastPortfolio = UserPortfolio::where('user_id', $user->id)->orderBy('id', 'desc')->get()->first();
                $portfolio->order = $lastPortfolio ? $lastPortfolio->order + 1 : 1;
                $portfolio->is_live = $request->has('port_sandbox') ? 0 : 1;
            }

            $portThumbData = $request->get('port_thumb_data');
            if($portThumbData != ''){

                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $portThumbData));
                if($request->has('portfolio_id') && $portfolio->thumbnail && CommonMethods::fileExists(public_path('portfolio-images/').$portfolio->thumbnail)){

                    unlink(public_path('portfolio-images/').$portfolio->thumbnail);
                }
                $fileName = rand(100000, 999999).'.png';
                file_put_contents(public_path('portfolio-images/').$fileName, $imageData);
                $portfolio->thumbnail = $fileName;
            }

            $portfolio->title = $request->get('title');
            $portfolio->product_id = $request->get('product') == '' ? NULL : $request->get('product');
            $response = $portfolio->save();

            if($response && $request->has('element')){

                $elementKeys = [];
                foreach ($request->element as $key => $element){
                    $order = $key;
                    $elementKeys[] = $key;
                    if(isset($element[0])){
                        if($element[1][0] == 'image'){
                            $name = 'image';
                            $value = rand(1000000,9999999).'.'.$element[0][0]->getClientOriginalExtension();
                            $path = public_path('portfolio-images/'.$value);
                            Image::make($element[0][0]->getRealPath())->save($path, 60);
                            $type = 'image';
                        }else{
                            $value = $element[0][0];
                            $type = $element[1][0];
                        }
                        $record = PortfolioElement::where(['order' => $key, 'portfolio_id' => $portfolio->id])->first();
                        $pElement = ($record === null) ? new PortfolioElement() : $record;

                        if($record && $record->type == 'image' && CommonMethods::fileExists(public_path('portfolio-images/').$record->value)){

                            unlink(public_path('portfolio-images/').$record->value);
                        }

                        if($type == 'youtube' && $value != ''){

                            //validate youtube link
                            if(!CommonMethods::validateYoutubeLink($value)){

                                return Redirect::back()->with('error', 'Invalid youtube video link');
                            }
                        }

                        $pElement->portfolio_id = $portfolio->id;
                        $pElement->type = $type;
                        $pElement->value = $value;
                        $pElement->order = $order;
                        $response = $pElement->save();
                    }
                }

                //delete all the elements which were not posted in the form
                $tobeDeleted = PortfolioElement::whereNotIn('order', $elementKeys)->where(['portfolio_id' => $portfolio->id])->get();
                if(count($tobeDeleted)){

                    foreach ($tobeDeleted as $element) {
                        if($element->type == 'image' && CommonMethods::fileExists(public_path('portfolio-images/').$element->value)){

                            unlink(public_path('portfolio-images/').$element->value);
                        }
                        $element->delete();
                    }
                }
            }else{

                $tobeDeleted = PortfolioElement::where(['portfolio_id' => $portfolio->id])->get();
                if(count($tobeDeleted)){

                    foreach ($tobeDeleted as $element) {
                        if($element->type == 'image' && CommonMethods::fileExists(public_path('portfolio-images/').$element->value)){

                            unlink(public_path('portfolio-images/').$element->value);
                        }
                        $element->delete();
                    }
                }
            }

            //delete empty elements
            $tobeDeleted = PortfolioElement::where(['portfolio_id' => $portfolio->id])->get();
            if(count($tobeDeleted)){
                foreach ($tobeDeleted as $element) {
                    if($element->value == NULL || $element->value == ''){
                        $element->delete();
                    }
                }
            }
        }else{

            $error = 'User not logged in';
        }

        return Redirect::back();
    }

    public function postYourProduct(Request $request){

        $user = Auth::user();
        $commonMethods = new CommonMethods();

        if($request->has('product_id')){

            $userProduct = UserProduct::where(['id' => $request->get('product_id'), 'user_id' => $user->id])->first();
            if(!$userProduct){

                return redirect()->back()->with('error', 'Target product does not exist');
            }
        }else{

            $userFirstProduct = UserProduct::where(['user_id' => $user->id])->orderBy('order', 'desc')->first();
            $userProduct = new UserProduct();
            if($userFirstProduct){
                $order = ((int)$userFirstProduct->order) + 1;
            }else{
                $order = 1;
            }
            $userProduct->order = $order;
        }

        if($userProduct->type && $userProduct->type == 'custom'){

            $product = CustomProduct::where(['id' => $userProduct['design']['product_id'], 'status' => 1])->first();
            $design = UserProductDesign::where(['id' => $userProduct['design']['design_id'], 'user_id' => $user->id])->first();

            if($product && $design){

                $title = $request->get('pro_edit_prod_name');
                $description = $request->get('pro_edit_prod_description');
                $price = $request->get('pro_edit_prod_price');
                $colors = $request->get('pro_edit_prod_colors');
                $defaultColor = $request->get('pro_edit_prod_color_default');
                $productPricing = $commonMethods->customProductPricing($product, $user->profile->default_currency, $price);
                $col = [];

                if(isset($productPricing['error']) && $productPricing['error'] != ''){

                    return redirect()->back()->with('error', $productPricing['error']);
                }

                if(in_array($defaultColor, $colors)){

                    foreach($userProduct->design['colors'] as $key => $color){

                        $colorSlug = str_slug($color['name']);

                        $col[$key]['name'] = $color['name'];
                        $col[$key]['image'] = $color['image'];
                        $col[$key]['status'] = !in_array($colorSlug, $colors) ? 0 : 1;

                        if($defaultColor != $userProduct['design']['default_color'] && $colorSlug == $defaultColor){

                            $productDesignLeftImage = rand(10000, 99999).'.jpg';
                            $productDesignFeatImage = rand(10000, 99999).'.jpg';
                            $resizedDesignPath = 'prints/uf_'.$user->id.'/designs/resized/';
                            $fullDesignPath = 'prints/uf_'.$user->id.'/designs/';

                            if($userProduct->thumbnail_left != '' && CommonMethods::fileExists(public_path($resizedDesignPath).$userProduct->thumbnail_left)){

                                unlink(public_path($resizedDesignPath).$userProduct->thumbnail_left);
                            }
                            if($userProduct->thumbnail_left != '' && CommonMethods::fileExists(public_path($resizedDesignPath).$userProduct->thumbnail_left)){

                                unlink(public_path($resizedDesignPath).$userProduct->thumbnail_left);
                            }
                            Image::make(public_path($fullDesignPath.$color['image']))->fit( 100,60 )->save($resizedDesignPath.$productDesignLeftImage,60);
                            Image::make(public_path($fullDesignPath.$color['image']))->resize(780, null,function($constraint){$constraint->aspectRatio();})->save($resizedDesignPath.$productDesignFeatImage,60);

                            $userProduct->thumbnail = $color['image'];
                            $userProduct->thumbnail_left = $productDesignLeftImage;
                            $userProduct->thumbnail_feat = $productDesignFeatImage;
                        }
                    }

                    $designDetails = [
                        'product_id' => $userProduct['design']['product_id'],
                        'design_id' => $userProduct['design']['design_id'],
                        'design_type' => $userProduct['design']['design_type'],
                        'colors' => $col,
                        'default_color' => $defaultColor,
                        'design_pos' => [
                            'top' => $userProduct['design']['design_pos']['top'],
                            'left' => $userProduct['design']['design_pos']['left'],
                            'width' => $userProduct['design']['design_pos']['width'],
                            'height' => $userProduct['design']['design_pos']['height'],
                            'angle' => $userProduct['design']['design_pos']['angle'],
                        ]
                    ];

                    $userProduct->design = $designDetails;
                    $userProduct->price = $price;
                    $userProduct->normal_price = $price;
                    $userProduct->title = $title;
                    $userProduct->slug = str_slug($userProduct->title);
                    $userProduct->description = $description;
                }else{
                    return redirect()->back()->with('error', 'You must make your default color available or choose another default');
                }
            }else{
                return redirect()->back()->with('error', 'Target product is not found');
            }
        }else{

            if( $request->hasFile( 'product_thumb' )) {

                $photo = $request->file('product_thumb');
                if(!$commonMethods->userCanUploadFile($user, $request, 'product_thumb')){

                    return Redirect::back()->with("page", "prods")->with("error", "Error: Your package storage limit has reached");
                }
                $uniqueId = uniqid();
                $ext = $request->file('product_thumb')->getClientOriginalExtension();
                $thumbnailLeftPath = public_path( 'user-product-thumbnails/' ).'left-thumbnail-user-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                $thumbnailPath = public_path( 'user-product-thumbnails/' ).'thumbnail-user-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                $thumbnailFeatPath = public_path( 'user-product-thumbnails/' ).'thumbnail-feat-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                $result = Image::make($photo)->fit( 100,60 )->save($thumbnailLeftPath,60);
                $result = Image::make($photo)->resize(780, null,function($constraint){$constraint->aspectRatio();})->save( $thumbnailPath,60);
                $result = Image::make($photo)->resize(450, null,function($constraint){$constraint->aspectRatio();})->save( $thumbnailFeatPath,60);

                if($userProduct->thumbnail_left != '' && CommonMethods::fileExists(public_path('user-product-thumbnails/').$userProduct->thumbnail_left)){

                    unlink(public_path('user-product-thumbnails/').$userProduct->thumbnail_left);
                }
                if($userProduct->thumbnail != '' && CommonMethods::fileExists(public_path('user-product-thumbnails/').$userProduct->thumbnail)) {

                    unlink(public_path('user-product-thumbnails/').$userProduct->thumbnail);
                }
                if($userProduct->thumbnail_feat != '' && CommonMethods::fileExists(public_path('user-product-thumbnails/').$userProduct->thumbnail_feat)){

                    unlink(public_path('user-product-thumbnails/').$userProduct->thumbnail_feat);
                }

                $userProduct->thumbnail_left = 'left-thumbnail-user-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                $userProduct->thumbnail = 'thumbnail-user-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                $userProduct->thumbnail_feat = 'thumbnail-feat-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
            }

            if($request->has('product_timer_price') && $request->get('product_timer_price') != '') {

                $specialOfferPrice = $request->get('product_timer_price');
                $specialOfferStartDateTime = str_replace('Febuary', 'February', $request->get('product_timer_start_date_time'));
                $specialOfferEndDateTime = str_replace('Febuary', 'February', $request->get('product_timer_end_date_time'));
                $specialOfferTimezone = $request->get('product_timer_timezone');
                $userProduct->special_price = ['price' => $specialOfferPrice, 'start_date_time' => $specialOfferStartDateTime, 'end_date_time' => $specialOfferEndDateTime, 'timezone' => $specialOfferTimezone];
            }else{
                $userProduct->special_price = NULL;
            }

            $userProduct->title = $request->product_title;
            $userProduct->description = ( $request->product_description != '' ) ? $request->product_description : '';
            $userProduct->quantity = ( $request->product_amount_available != '' ) ? $request->product_amount_available : null;
            $userProduct->items_available = ( $request->product_amount_available != '' ) ? $request->product_amount_available : null;
            $userProduct->price = $request->pro_product_price_option == 'addprice' ? $request->product_price : NULL;
            $userProduct->normal_price = $request->pro_product_price_option == 'addprice' ? $request->product_price : NULL;
            $userProduct->price_option = $request->pro_product_price_option;
            $userProduct->includes = ( $request->product_includes != '' ) ? $request->product_includes : '';

            if($request->pro_product_ticket_option == 'yes'){

                $userProduct->is_ticket = 1;
                $userProduct->date_time = $request->date_time;
                $userProduct->location = $request->location;
                $userProduct->terms_conditions = $request->terms_conditions;
            }else{

                $userProduct->is_ticket = 0;
                $userProduct->date_time = NULL;
                $userProduct->location = NULL;
                $userProduct->terms_conditions = NULL;
            }

            if($request->pro_product_shipping_option == 'yes'){

                $userProduct->requires_shipping = 1;
                $userProduct->local_delivery = $request->local_delivery;
                $userProduct->international_shipping = $request->international_shipping;
            }else{

                $userProduct->requires_shipping = 0;
                $userProduct->local_delivery = 0;
                $userProduct->international_shipping = 0;
            }
        }

        $userProduct->user_id = $user->id;
        $userProduct->voucher_id = $request->has('pro_product_voucher') ? $request->get('pro_product_voucher') : NULL;
        $userProduct->slug = str_slug($userProduct->title);
        $userProduct->save();
        return Redirect::back();
    }


    public function getFileExtension($fileName){

        $fileDetails = explode('.',$fileName);
        return end($fileDetails);
    }

    public function postLiveStream(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();

        $user = Auth::user();

        if($user && $request->has('pro_stream_url')){

            $url = $request->get('pro_stream_url');
            $product = $request->get('pro_stream_product');
            $music = $request->get('pro_stream_music');
            $moreViewers = $request->get('pro_stream_more_viewers');

            if($request->has('edit')){

                $streamId = $request->get('edit');
                $stream = UserLiveStream::find($streamId);
            }else{

                $stream = new UserLiveStream();
            }

            $stream->user_id = $user->id;
            $stream->url = $url;
            $stream->product = $product != '' ? $product : NULL;
            $stream->music = $music != '' ? $music : NULL;
            $stream->more_viewers = $moreViewers;

            if( $request->hasFile( 'live_stream_thumb' )) {

                if($request->has('edit') && $stream->thumbnail != '' && CommonMethods::fileExists(public_path( 'user-stream-thumbnails/' ).$stream->thumbnail)) {
                    unlink(public_path('user-stream-thumbnails/').$stream->thumbnail);
                }

                $photo = $request->file('live_stream_thumb');

                $uniqueId = uniqid();
                $ext = $this->getFileExtension($_FILES["live_stream_thumb"]['name']);
                $filename = $uniqueId.'.'.$ext;
                $thumbnailPath = public_path( 'user-stream-thumbnails/' ).$filename;
                $result = Image::make($photo)->resize(105, null,function($constraint){$constraint->aspectRatio();})->save( $thumbnailPath,60);

                $stream->thumbnail = $filename;
            }

            $stream->save();
        }else{

            $error = 'Data incomplete';
        }

        return redirect()->back();

    }

    public function postYourNews(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();

        $user = Auth::user();

        if($user && $request->has('value')){

            $value = $request->get('value');
            $tab = $request->get('pro_stream_tab');

            if($request->has('news_id')){

                $newsId = $request->get('news_id');
                $news = UserNews::find($newsId);
            }else{

                $news = new UserNews();
                $news->user_id = $user->id;
            }

            $news->value = $value;
            $news->tab = $tab;
            $news->save();

            $success = 1;

            return redirect()->back();
        }else{

            return redirect()->back()->with('error', 'Request missing data');
        }
    }

    public function postYourAlbum(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();

        $user = Auth::user();

        if($user && $request->has('pro_album_name')){

            $name = $request->get('pro_album_name');
            $price = $request->get('pro_album_price');
            $addAsProduct = $request->get('pro_album_product');
            $description = $request->get('pro_album_description');
            $musics = $request->get('pro_album_musics');

            if($request->has('edit')){

                $id = $request->get('edit');
                $album = UserAlbum::find($id);
            }else{

                $album = new UserAlbum();
                $album->user_id = $user->id;
            }
            $album->name = $name;
            $album->price = $price;
            $album->description = $description != '' ? $description : null;
            $album->is_product = $addAsProduct == 1 ? 1 : null;
            $album->musics = is_array($musics) ? $musics : array();
            $album->save();

            if( $request->hasFile( 'album_thumb' )) {

                if($request->has('edit') && $album->thumbnail != '' && CommonMethods::fileExists(public_path( 'user-album-thumbnails/' ).$album->thumbnail)) {
                    unlink(public_path('user-album-thumbnails/').$album->thumbnail);
                }
                if($request->has('edit') && $album->thumbnail_feat != '' && CommonMethods::fileExists(public_path( 'user-album-thumbnails/' ).$album->thumbnail_feat)) {
                    unlink(public_path('user-album-thumbnails/').$album->thumbnail_feat);
                }

                $photo = $request->file('album_thumb');

                $uniqueId = uniqid();
                $uniqueId2 = uniqid();
                $ext = $this->getFileExtension($_FILES["album_thumb"]['name']);
                $filename = $uniqueId.'.'.$ext;
                $filename2 = $uniqueId2.'.'.$ext;
                $thumbnailPath = public_path( 'user-album-thumbnails/' ).$filename;
                $thumbnailPathFeat = public_path( 'user-album-thumbnails/' ).$filename2;
                $result = Image::make($photo)->resize(120, null,function($constraint){$constraint->aspectRatio();})->save( $thumbnailPath,60);
                $result2 = Image::make($photo)->resize(450, null,function($constraint){$constraint->aspectRatio();})->save( $thumbnailPathFeat,60);

                $album->thumbnail = $filename;
                $album->thumbnail_feat = $filename2;
                $album->save();
            }

            $success = 1;

            return redirect()->back();
        }else{

            return redirect()->back()->with('error', 'Request missing data');
        }
    }

    public function userNewsFeature(Request $request){

        $return['success'] = $return['error'] = '';
        $commonMethods = new CommonMethods();

        $user = Auth::user();

        if($user && $request->has('id')){

            $newsId = $request->get('id');
            $news = UserNews::find($newsId);

            if($news && $news->user->id == $user->id){

                $news->featured = $news->featured ? 0 : 1;
                $news->save();

                $return['success'] = 1;
            }else{

                $return['error'] = 'Request declined authorization';
            }
        }else{

            $return['error'] = 'Request missing data';
        }

        return $return;
    }

    public function userAlbumFeature(Request $request){

        $return['success'] = $return['error'] = '';
        $commonMethods = new CommonMethods();

        $user = Auth::user();

        if($user && $request->has('id')){

            $albumId = $request->get('id');
            $album = UserAlbum::find($albumId);

            if($album && $album->user->id == $user->id){

                $album->featured = $album->featured ? NULL : 1;
                $album->save();

                $return['success'] = 1;
            }else{

                $return['error'] = 'Request declined authorization';
            }
        }else{

            $return['error'] = 'Request missing data';
        }

        return $return;
    }

    public function saveProductDesign(Request $request){

        $success = 0;
        $data = [];
        $error = '';
        $commonMethods = new CommonMethods();

        $user = Auth::user();
        $mainFolder = 'prints/uf_'.$user->id;

        if($user){

            if($request->step == '1'){

                if($request->has('pro_design_file')){

                    $image = $request->file('pro_design_file');
                    $ext = $image->getClientOriginalExtension();

                    if($ext != 'jpg' && $ext != 'png' && $ext != 'gif'){

                        $response = ['success' => 0, 'error' => 'image file is not supported', 'data' => 0];
                    }

                    if(!file_exists(public_path($mainFolder))){

                        mkdir($mainFolder, 0777, true);
                        mkdir($mainFolder.'/templates', 0777, true);
                        mkdir($mainFolder.'/templates/resized', 0777, true);
                        mkdir($mainFolder.'/templates/black', 0777, true);
                        mkdir($mainFolder.'/designs', 0777, true);
                        mkdir($mainFolder.'/designs/resized', 0777, true);
                    }

                    $imageName = rand(100000,999999).'.'.$ext;
                    Image::make($image)->save(public_path($mainFolder.'/templates/'.$imageName));
                    $imageGrey = $commonMethods->convertToBlackAndWhite($mainFolder.'/templates/'.$imageName);

                    if($imageGrey['success'] == 1){

                        $productDesign = new UserProductDesign();
                        $productDesign->user_id = $user->id;
                        $productDesign->file_name = $imageName;
                        $productDesign->grey_file_name = $imageGrey['data'];
                        $productDesign->save();

                        $response = ['success' => 1, 'error' => '', 'data' => ['image_name' => $imageName, 'image_grey_name' => $imageGrey['data'], 'dir' => 'uf_'.$user->id, 'id' => $productDesign->id]];
                    }else{
                        $response = ['success' => 0, 'error' => $imageGrey['error'], 'data' => 0];
                    }

                }else if($request->has('pro_design_exist_file')){

                    $designImage = UserProductDesign::where(['user_id' => $user->id, 'id' => $request->pro_design_exist_file])->first();
                    if($designImage){

                        $response = ['success' => 1, 'error' => '', 'data' => ['image_name' => $designImage->file_name, 'image_grey_name' => $designImage->grey_file_name, 'dir' => 'uf_'.$user->id, 'id' => $designImage->id]];
                    }else{
                        $response = ['success' => 0, 'error' => 'No such image in user repo', 'data' => 0];
                    }
                }else{
                    $response = ['success' => 0, 'error' => 'Step 1: No data', 'data' => 0];
                }
            }else if($request->step == '2'){


            }else if($request->step == '3'){


            }else if($request->step == '4'){

                $productId = $request->get('pro_prod_value');
                $product = CustomProduct::where(['id' => $productId, 'status' => 1])->first();
                if($product){

                    $productPricing = $commonMethods->customProductPricing($product, $user->profile->default_currency);

                    $response = ['success' => 1, 'error' => '', 'data' => ['min_price' => $productPricing['min_price'], 'commission' => $productPricing['commission'], 'recommended_price' => $productPricing['recommended_price'], 'currency' => $productPricing['currency']]];
                }else{
                    $response = ['success' => 0, 'error' => 'No such product', 'data' => 0];
                }
            }else if($request->step == '5' || $request->step == 'edit'){

                $productId = $request->get('pro_prod_value');
                $basePrice = $request->get('pro_base_price');
                $product = CustomProduct::where(['id' => $productId, 'status' => 1])->first();
                if($product){

                    $productPricing = $commonMethods->customProductPricing($product, $user->profile->default_currency, $basePrice);

                    $response = ['success' => $productPricing['success'], 'error' => $productPricing['error'], 'data' => ['min_price' => $productPricing['min_price'], 'commission' => $productPricing['commission'], 'recommended_price' => $productPricing['recommended_price'], 'currency' => $productPricing['currency']]];
                }else{
                    $response = ['success' => 0, 'error' => 'No such product', 'data' => 0];
                }
            }else if($request->step == '5b'){

                $designId = $request->get('prodDesign');
                $prodName = $request->get('prodName');
                $prodType = $request->get('prodType');
                $top = $request->get('top');
                $left = $request->get('left');
                $width = $request->get('width');
                $height = $request->get('height');
                $productId = $request->get('prod');
                $angle = $request->get('angle');
                $colors = explode(',', $request->get('prodColors'));
                $defaultColor = $request->get('prodDefaultColor');
                $price = $request->get('prodPrice');
                $product = CustomProduct::where(['id' => $productId, 'status' => 1])->first();
                $design = UserProductDesign::where(['id' => $designId, 'user_id' => $user->id])->first();

                if($product){

                    if($design){

                        $productPricing = $commonMethods->customProductPricing($product, $user->profile->default_currency, $price);
                        if($productPricing['success'] == 1){

                            if($price >= $productPricing['min_price']){

                                if(in_array($defaultColor, $colors) && count($colors)){

                                    foreach($product->colors as $key => $color){

                                        $colorSlug = str_slug($color);
                                        if($colorSlug != ''){

                                            $productNameSlug = str_slug($product->name, '-');
                                            $designImageName = $prodType == 1 ? 'black/'.$design->grey_file_name : $design->file_name;
                                            $productImagePath = 'images/test/design/'.$productNameSlug.'/image-'.$colorSlug.'.jpg';
                                            $designImagePath = 'prints/uf_'.$user->id.'/templates/'.$designImageName;

                                            $response = $commonMethods->mergeImages($productImagePath, $designImagePath, $left, $top, $angle, $width);

                                            if($response['success'] == 1){
                                                $col[$key]['name'] = $color;
                                                $col[$key]['image'] = $response['data'];
                                                $col[$key]['status'] = in_array($colorSlug, $colors) ? 1 : 0;

                                                if($colorSlug == $defaultColor){
                                                    $productDesignImage = $response['data'];
                                                    $productDesignLeftImage = rand(10000, 99999).'.jpg';
                                                    $productDesignFeatImage = rand(10000, 99999).'.jpg';
                                                    $resizedDesignPath = 'prints/uf_'.$user->id.'/designs/resized/';
                                                    $fullDesignPath = 'prints/uf_'.$user->id.'/designs/';
                                                    Image::make(public_path($fullDesignPath.$response['data']))->fit( 100,60 )->save($resizedDesignPath.$productDesignLeftImage,60);
                                                    Image::make(public_path($fullDesignPath.$response['data']))->resize(780, null,function($constraint){$constraint->aspectRatio();})->save($resizedDesignPath.$productDesignFeatImage,60);
                                                }
                                            }
                                        }
                                    }

                                    if($response['success'] == 1){
                                        $firstProduct = UserProduct::where(['user_id' => $user->id])->orderBy('order', 'desc')->first();
                                        $order = $firstProduct ? ((int)$firstProduct->order) + 1 : 1;
                                        $designDetails = [
                                            'product_id' => $productId,
                                            'design_id' => $designId,
                                            'design_type' => $prodType,
                                            'colors' => $col,
                                            'default_color' => $defaultColor,
                                            'design_pos' => [
                                                'top' => $top,
                                                'left' => $left,
                                                'width' => $width,
                                                'height' => $height,
                                                'angle' => $angle,
                                            ]
                                        ];

                                        $userProduct = new UserProduct();
                                        $userProduct->user_id = $user->id;
                                        $userProduct->title = $prodName != '' ? $prodName : $product->name;
                                        $userProduct->description = $product->description;
                                        $userProduct->price = $price;
                                        $userProduct->normal_price = $price;
                                        $userProduct->thumbnail = $productDesignImage;
                                        $userProduct->thumbnail_left = $productDesignLeftImage;
                                        $userProduct->thumbnail_feat = $productDesignFeatImage;
                                        $userProduct->order = $order;
                                        $userProduct->type = 'custom';
                                        $userProduct->design = $designDetails;
                                        $userProduct->slug = str_slug($userProduct->title);
                                        $userProduct->save();

                                        $response['success'] = 1;
                                    }
                                }else{
                                    $response = ['success' => 0, 'error' => 'You must make your default color available or choose another default', 'data' => 0];
                                }
                            }else{
                                $response = ['success' => 0, 'error' => 'Product price cannot be lower than '.$productPricing['min_price'], 'data' => 0];
                            }
                        }else{
                            $response = ['success' => 0, 'error' => $productPricing['error'], 'data' => 0];
                        }
                    }else{
                        $response = ['success' => 0, 'error' => 'No such design', 'data' => 0];
                    }
                }else{
                    $response = ['success' => 0, 'error' => 'No such product', 'data' => 0];
                }
            }else{
                $response = ['success' => 0, 'error' => 'invalid request', 'data' => 0];
            }
        }else{
            $response = ['success' => 0, 'error' => 'No user known', 'data' => 0];
        }

        return json_encode($response);
    }

    public function postYourMusic(Request $request){

        $success = 0;
        $musicHasLicense = 0;
        $data = [];
        $error = '';
        $commonMethods = new CommonMethods();
        $cloudStorage = new GoogleDriveStorage();

        $user = Auth::user();

        if($user && $request->has('type')){

            $type = $request->get('type');
            if($type == 'music_info'){

                if($request->has('music_id')){

                    $musicId = $request->get('music_id');
                    $userMusic = UserMusic::find($musicId);
                }else{
                    $userFirstMusic = UserMusic::where(['user_id' => $user->id])->orderBy('order', 'desc')->first();
                    $userMusic = new UserMusic();
                    $userMusic->user_id = $user->id;
                    if($userFirstMusic){
                        $order = ((int)$userFirstMusic->order) + 1;
                    }else{
                        $order = 1;
                    }
                    $userMusic->order = $order;
                }

                $userMusic->song_name = $request->song_name != NULL ? $request->song_name : "";
                $userMusic->album_name = $request->album_name != NULL ? $request->album_name : "";
                $userMusic->bpm = $request->bpm != NULL ? $request->bpm : "";
                $userMusic->dropdown_one = $request->dropdown_one != NULL ? $request->dropdown_one: "";
                $userMusic->more_moods = $request->more_moods != NULL ? $request->more_moods: "";
                $userMusic->lyrics = $request->has('lyrics') && $request->lyrics != '' ? $request->lyrics: NULL;
                $userMusic->dropdown_two = $request->dropdown_two != NULL ? $request->dropdown_two: "";
                $userMusic->personal_use_only = $request->personal_use_only != '' ? $request->personal_use_only: NULL;
                $userMusic->duration = $request->duration;
                $userMusic->slug = str_slug($userMusic->song_name);

                foreach (Config('constants.licenses') as $key2 => $eachLicense) {

                    if($request->has($eachLicense['input_name'])){

                        $userMusic->{$eachLicense['input_name']} = $request->get($eachLicense['input_name']) != '' ? strtoupper($request->get($eachLicense['input_name'])) : NULL;
                        $musicHasLicense = 1;
                    }else{

                        $userMusic->{$eachLicense['input_name']} = NULL;
                    }
                }

                if($request->is_full_ownership == 1){
                    $userMusic->is_full_ownership = $request->is_full_ownership != NULL ? $request->is_full_ownership: "";
                }
                if($request->use_of_licenses_perpetual == 1){
                    $userMusic->use_of_licenses_perpetual = $request->use_of_licenses_perpetual != NULL ? $request->use_of_licenses_perpetual: "";
                }

                $userMusic->allow_bespoke_license_offer = $request->allow_bespoke_license_offer == 1 ? 1 : NULL;
                $userMusic->instruments = array_filter(explode(',', trim($request->instruments)));

                if($request->hasFile( 'music_thumb')){

                    if($request->has('music_id')){

                        if($userMusic->thumbnail_left != "" && CommonMethods::fileExists(public_path( 'user-music-thumbnails/' ).$userMusic->thumbnail_left)) {
                            unlink(public_path('user-music-thumbnails/') . $userMusic->thumbnail_left);
                        }
                        if($userMusic->thumbnail_player != "" && CommonMethods::fileExists(public_path( 'user-music-thumbnails/' ).$userMusic->thumbnail_player)) {
                            unlink(public_path('user-music-thumbnails/') . $userMusic->thumbnail_player);
                        }
                        if($userMusic->thumbnail_feat != "" && CommonMethods::fileExists(public_path( 'user-music-thumbnails/' ).$userMusic->thumbnail_feat)) {
                            unlink(public_path('user-music-thumbnails/') . $userMusic->thumbnail_feat);
                        }
                    }

                    $photo = $request->file('music_thumb');
                    $uniqueId = uniqid();
                    $ext = $request->file('music_thumb')->getClientOriginalExtension();

                    $thumbnailLeftPath = public_path( 'user-music-thumbnails/' ).'left-thumbnail-user-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                    $thumbnailAudioPlayerPath = public_path( 'user-music-thumbnails/' ).'player-thumbnail-user-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                    $thumbnailFeatPath = public_path( 'user-music-thumbnails/' ).'thumbnail-feat-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;

                    $result = Image::make( $photo )->fit( 105,105 )->save( $thumbnailLeftPath,60);
                    $result = Image::make( $photo )->fit( 150,90 )->save( $thumbnailAudioPlayerPath,60);
                    $result = Image::make( $photo )->resize(450, null,function($constraint){$constraint->aspectRatio();})->save( $thumbnailFeatPath,60);

                    $userMusic->thumbnail_left = 'left-thumbnail-user-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                    $userMusic->thumbnail_player = 'player-thumbnail-user-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                    $userMusic->thumbnail_feat = 'thumbnail-feat-'.$user->id.'-uniquid-'.$uniqueId.'-pp'.'.'.$ext;
                }

                $userMusic->save();

                $data['music_id'] = $userMusic->id;

                if(!$user->has_music_license && $musicHasLicense){

                    $userNotification = new UserNotificationController();
                    $request->request->add(['user' => 727, 'customer' => $user->id, 'type' => 'music_license_verification', 'source_id' => $user->id]);
                    $response = json_decode($userNotification->create($request), true);

                    $result = Mail::to(Config('constants.admin_email'))->bcc(Config('constants.bcc_email'))->send(new MailUser('licenseVerification', $user));

                    session(['music_license_notice' => '1']);
                }

                $success = 1;
            }else if($request->hasFile('mu_down_file') && $request->has('mu_down_id')){

                $extension = $this->getFileExtension($_FILES["mu_down_file"]['name']);
                $size = $request->file('mu_down_file')->getSize();
                $musicId = $request->get('mu_down_id');
                $music = UserMusic::find($musicId);
                $itemType = $request->get('type');

                $musicArray = $music->downloads;
                if(count($musicArray)){

                    $contents = collect(Storage::cloud()->listContents('/', false));
                    foreach ($musicArray as $key => $download) {

                        if($download['itemtype'] == $itemType){

                            if(strpos($download['itemtype'], 'loop') !== false){
                                $UnFileDir = 'loops/';
                            }else if(strpos($download['itemtype'], 'stem') !== false){
                                $UnFileDir = 'stems/';
                            }else{
                                $UnFileDir = '';
                            }

                            $UnFileName = public_path('user-music-files/'.$UnFileDir.$download['dec_fname']);
                            if(CommonMethods::fileExists($UnFileName)) {
                                unlink($UnFileName);
                            }

                            $file = $contents
                                ->where('type', '=', 'file')
                                ->where('filename', '=', $download['filename'])
                                ->first();
                            if($file && is_array($file) && count($file)){
                                Storage::cloud()->delete($file['path']);
                            }

                            unset($musicArray[$key]);

                            $music->downloads = $musicArray;
                            $music->save();
                        }
                    }
                }
                if($music && $music->user->id == $user->id){
                    if($extension == 'wav'){

                        //$userFolder = $user->googleDriveFolder($cloudStorage);
                        //$request->request->add(['dir', $userFolder]);
                        $response = $cloudStorage->uploadFileAsStream($request);
                        $response = json_decode($response, true);
                        $success = $response['success'];
                        $error = $response['error'];
                        $data['music_mp3'] = $response['music_mp3'];
                    }else if($extension == 'mp3'){

                        $file = $request->file('mu_down_file');

                        if($commonMethods->userCanUploadFile($user, $request, 'mu_down_file')){

                            $fileName = 'user-music-'.uniqid().'.'.$extension;
                            if(strpos($itemType, 'loop') !== false){
                                $decFDir = 'loops/';
                            }else if(strpos($itemType, 'stem') !== false){
                                $decFDir = 'stems/';
                            }else{
                                $decFDir = '';
                            }
                            $file->move(public_path('user-music-files/'.$decFDir), $fileName);

                            $fileDetails = [
                                'filename' => $fileName,
                                'type' => 'file',
                                'mimetype' => 'audio/mp3',
                                'path' => asset('user-music-files/'.$fileName),
                                'size' => $size,
                                'decFName' => $fileName,
                            ];
                            $music->addDownloadItem($fileDetails, $itemType, 'local', $fileName);
                            $data['music_mp3'] = $fileName;
                            $success = 1;
                        }else{
                            $error = 'Error: Your package storage limit has reached';
                        }
                    }

                    if($itemType == 'main'){
                        $music->music_file = $data['music_mp3'];
                        $music->save();
                    }
                    $data['music_id'] = $musicId;
                }else{

                    $error = 'music not found';
                }
            }else if($type == 'delete_files'){

                $deleteData = $request->get('mu_delete_data');
                $musicId = $request->get('mu_down_id');

                $music = UserMusic::find($musicId);
                if($music && $music->user->id == $user->id){

                    $deleteExplode = explode(':', $deleteData);
                    $musicArray = $music->downloads;
                    $contents = collect(Storage::cloud()->listContents('/', false));

                    foreach ($deleteExplode as $key => $value) {

                        if(count($musicArray)){

                            foreach ($musicArray as $key => $download) {

                                if($download['itemtype'] == $value){

                                    if(strpos($download['itemtype'], 'loop') !== false){
                                        $UnFileDir = 'loops/';
                                    }else if(strpos($download['itemtype'], 'stem') !== false){
                                        $UnFileDir = 'stems/';
                                    }else{
                                        $UnFileDir = '';
                                    }

                                    $UnFileName = public_path('user-music-files/'.$UnFileDir.$download['dec_fname']);
                                    if(CommonMethods::fileExists($UnFileName)) {
                                        unlink($UnFileName);
                                    }

                                    $file = $contents
                                        ->where('type', '=', 'file')
                                        ->where('filename', '=', $download['filename'])
                                        ->first();
                                    if(count($file)){
                                        Storage::cloud()->delete($file['path']);
                                    }

                                    unset($musicArray[$key]);

                                    $music->downloads = $musicArray;
                                    $music->save();
                                }
                            }
                        }
                    }
                    $success = 1;
                }else{
                    $error = 'music not found';
                }
            }else{

                $error = 'No known action';
            }
        }else{
            $error = 'Request incomplete';
        }

        return json_encode(['success' => $success, 'error' => $error, 'data' => $data]);
    }


    public function removeMusicTrack(Request $request){

        if ($request->isMethod('post')) {

            $user = Auth::user();
            $success = 0;
            $error = '';
            if($user && $request->has('track') && $request->track != ''){

                $track = $request->track;
                $explode = explode('_', $track);
                if(count($explode) == 4){

                    $musicId = (int) $explode[0];
                    $trackType = $explode[1];
                    $trackIndex = (int) $explode[3] - 1;
                    $music = UserMusic::find($musicId);
                    if($music && $music->user_id == $user->id){

                        if($trackType == 'loop'){

                            $tracks = $music->loops;
                            if(is_array($tracks) && count($tracks) && isset($tracks[$trackIndex])){

                                if(CommonMethods::fileExists(public_path( 'user-music-files/loops/' ).$tracks[$trackIndex])) {

                                    unlink(public_path('user-music-files/loops/').$tracks[$trackIndex]);
                                }
                                $tracks[$trackIndex] = '';
                                $music->loops = $tracks;
                                $music->save();

                                $success = 1;
                            }
                        }
                        if($trackType == 'stem'){

                            $tracks = $music->stems;
                            if(is_array($tracks) && count($tracks) && isset($tracks[$trackIndex])){

                                if(CommonMethods::fileExists(public_path( 'user-music-files/stems/' ).$tracks[$trackIndex])) {

                                    unlink(public_path('user-music-files/stems/').$tracks[$trackIndex]);
                                }
                                $tracks[$trackIndex] = '';
                                $music->stems = $tracks;
                                $music->save();
                                $success = 1;
                            }
                        }
                    }else{
                        $error = 'target music could not be identified';
                    }
                }else{
                    $error = 'insufficient/unexpected data';
                }
            }else{
                $error = 'no/protected data';
            }
        }else{
            $error = 'inappropraite request';
        }

        return json_encode(array('success' => $success, 'error' => $error));
    }

    public function userFollowLogin(Request $request){

        if ($request->isMethod('post')) {

            $user = Auth::user();
            $success = 0;
            $errorMessage = '';
            if(!$user && $request->has('email') && $request->email != '' && $request->has('password') && $request->password != ''){

                $email = $request->email;
                $password = $request->password;

                if (Auth::attempt(array('email' => $email, 'password' => $password))){
                    $success = 1;
                }else{
                    $errorMessage = 'Incorrect credentials';
                    $success = 0;
                }
            }else{
                $errorMessage = 'No/protected data';
                $success = 0;
            }
        }else{
            $errorMessage = 'inappropraite request';
            $success = 0;
        }

        return json_encode(array('success' => $success, 'errorMessage' => $errorMessage));
    }

    public function userFollow(Request $request){

        if ($request->isMethod('post')) {

            $user = Auth::user();
            $success = 0;
            $errorMessage = '';
            if($user && $request->has('user') && User::find($request->user)){

                $followee = User::find($request->user);
                $follower = $user;
                $message = $request->has('message') ? $request->message : null;

                if(!UserFollow::where(['followee_user_id' => $followee->id, 'follower_user_id' => $follower->id])->exists()){

                    $userFollow = new UserFollow();
                    $userFollow->followee_user_id = $followee->id;
                    $userFollow->follower_user_id = $follower->id;
                    $userFollow->message = $message;
                    $userFollow->save();

                    $userNotification = new UserNotificationController();
                    $request->request->add(['user' => $followee->id, 'customer' => $follower->id, 'type' => 'follow', 'source_id' => $userFollow->id]);
                    $response = json_decode($userNotification->create($request), true);

                    $success = 1;
                }else{
                    $errorMessage = 'You are already following this user';
                    $success = 0;
                }
            }else{
                $errorMessage = 'No/protected data';
                $success = 0;
            }
        }else{
            $errorMessage = 'Inappropraite request';
            $success = 0;
        }

        return json_encode(array('success' => $success, 'errorMessage' => $errorMessage));
    }

    public function updateUserEmailPassword(Request $request){

        $success = $error = '';

        if(Auth::check() && $request->has('pro_fill_email') && $request->has('pro_fill_password')){

            $email = $request->get('pro_fill_email');
            $password = $request->get('pro_fill_password');
            $user = Auth::user();

            $emailExist = User::where('email', $email)->get()->first();
            if(!$emailExist){

                $user->email = $email;
                $user->password = bcrypt($password);
                $user->save();

                $success = 1;
                $error = '';
            }else{
                $success = 0;
                $error = 'Your given email already exists';
            }
        }else{
            $success = 0;
            $error = 'No data';
        }

        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function updateMusicData(Request $request){

        $success = $error = '';

        if($request->has('music_file_name') && $request->has('music_waveform_image')){

            $musicFileName = $request->get('music_file_name');
            $musicWaveFormImageBase64 = $request->get('music_waveform_image');

            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $musicWaveFormImageBase64));
            if($imageData !== false){

                $fileName = rand(100000, 999999).'.png';
                file_put_contents(public_path('user-music-waveform/').$fileName, $imageData);
            }else{

                $fileName = null;
            }

            $music = UserMusic::where('music_file', $musicFileName)->get()->first();
            if($music){

                if($fileName){

                    if($music->waveform_image != '' && CommonMethods::fileExists(public_path('user-music-waveform/') . $music->waveform_image)) {
                        unlink(public_path('user-music-waveform/') . $music->waveform_image);
                    }
                    $music->waveform_image = $fileName;
                }

                $music->save();
                $success = 1;
                $error = '';
            }else{
                $success = 0;
                $error = 'No music found';
            }
        }else{
            $success = 0;
            $error = 'No data';
        }

        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function deleteLiveStream(Request $request){

        $return['error'] = $return['success'] = '';

        if( Auth::check() && $request->has('id') ){

            $user = Auth::user();
            $stream = UserLiveStream::find($request->id);

            if( $stream && $stream->user_id == $user->id ){

                if($stream->thumbnail != '' && CommonMethods::fileExists(public_path('user-stream-thumbnails/').$stream->thumbnail)) {

                    unlink(public_path('user-stream-thumbnails/').$stream->thumbnail);
                }

                $return['success'] = $stream->delete();
            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

    }

    public function deleteUserNews(Request $request){

        $return['error'] = $return['success'] = '';

        if( Auth::check() && $request->has('id') ){

            $user = Auth::user();
            $news = UserNews::find($request->id);

            if( $news && $news->user_id == $user->id ){

                $return['success'] = $news->delete();
            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

    }

    public function deleteUserAlbum(Request $request){

        $return['error'] = $return['success'] = '';

        if( Auth::check() && $request->has('id') ){

            $user = Auth::user();
            $album = UserAlbum::find($request->id);

            if( $album && $album->user_id == $user->id ){

                if($album->thumbnail != '' && CommonMethods::fileExists(public_path( 'user-album-thumbnails/' ).$album->thumbnail)) {
                    unlink(public_path('user-album-thumbnails/').$album->thumbnail);
                }
                if($album->thumbnail_feat != '' && CommonMethods::fileExists(public_path( 'user-album-thumbnails/' ).$album->thumbnail_feat)) {
                    unlink(public_path('user-album-thumbnails/').$album->thumbnail_feat);
                }

                $customerBasket = CustomerBasket::where(['purchase_type' => 'album'])->get();
                foreach($customerBasket as $b){

                    if($b->album_id == $album->id){

                        $b->delete();
                    }
                }

                $return['success'] = $album->delete();
            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

    }

    public function postUserService(Request $request){

        if( Auth::check() && $request->has('pro_service') ){

            $user = Auth::user();
            $servicee = $request->pro_service;
            $priceOption = $request->pro_service_price_option;
            $price = $request->pro_service_price;
            $priceInterval = $request->pro_service_price_interval;

            if($request->has('edit')){
                $serviceId = $request->edit;
                $service = UserService::where(['id' => $serviceId, 'user_id' => $user->id])->first();
                if(!$service){
                    return redirect()->back()->with('error', 'Unknown user or service');
                }
            }else{
                $service = new UserService();
            }

            $service->user_id = $user->id;
            $service->service_name = $servicee == '' ? NULL : $servicee;
            $service->price_option = $priceOption == '' ? NULL : $priceOption;
            $service->price = $price == '' ? NULL : $price;
            $service->price_interval = $priceInterval == '' ? NULL : $priceInterval;

            $service->save();
        }else{

            return redirect()->back()->with('error', 'Unknown user or service');
        }

        return redirect()->back();
    }

    public function deleteYourProduct(Request $request){

        $return['error'] = $return['success'] = '';

        if(Auth::check()){

            $user = Auth::user();
            $product = UserProduct::find($request->id);

            if($product && $product->user_id == $user->id){

                if($product->type == 'custom'){

                    $designsPath = 'prints/uf_'.$user->id.'/designs/';

                    if($product->thumbnail_left != '' && CommonMethods::fileExists(public_path($designsPath.'resized/').$product->thumbnail_left)){

                        unlink(public_path($designsPath.'resized/').$product->thumbnail_left);
                    }
                    if($product->thumbnail_feat != '' && CommonMethods::fileExists(public_path($designsPath.'resized/').$product->thumbnail_feat)){

                        unlink(public_path($designsPath.'resized/').$product->thumbnail_feat);
                    }

                    foreach($product->design['colors'] as $key => $color){

                        if(CommonMethods::fileExists(public_path($designsPath).$color['image'])){

                            unlink(public_path($designsPath).$color['image']);
                        }
                    }
                }else{

                    if($product->thumbnail_left != '' && CommonMethods::fileExists(public_path('user-product-thumbnails/').$product->thumbnail_left)){

                        unlink(public_path('user-product-thumbnails/').$product->thumbnail_left);
                    }
                    if($product->thumbnail_center != '' && CommonMethods::fileExists(public_path('user-product-thumbnails/').$product->thumbnail_center)){

                        unlink(public_path('user-product-thumbnails/').$product->thumbnail_center);
                    }
                    if($product->thumbnail != '' && CommonMethods::fileExists(public_path('user-product-thumbnails/').$product->thumbnail)){

                        unlink(public_path('user-product-thumbnails/').$product->thumbnail);
                    }
                }

                $customerBasket = CustomerBasket::where(['purchase_type' => 'product'])->get();
                foreach($customerBasket as $b){

                    if($b->product_id == $product->id){

                        $b->delete();
                    }
                }

                $return['success'] = $product->delete();
            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if($return['error'] != ''){

            Session::flash('error', 'Error: '.$return['error']);
        }

        Session::flash('page', 'prods');
    }



    public function starMyProduct(Request $request){



        $return['success'] = $return['error'] = '';

        $user = Auth::user();

        $productId = $request->product_id;

        $product = UserProduct::find($productId);



        if( Auth::check() ){



            if( $product && $product->user_id == $user->id ){



                $featuredStatus = $product->featured;

                if( $featuredStatus == '1' ){



                    $return['success'] = DB::table('user_products')->where('id', $productId)->update(['featured' => '0']);

                }else{



                    $userFeaturedProductsCount = UserProduct::where(['user_id' => $user->id, 'featured' => '1'])->get()->count();

                    $userFeaturedMusicCount = UserMusic::where(['user_id' => $user->id, 'featured' => '1'])->get()->count();



                    if( $userFeaturedProductsCount + $userFeaturedMusicCount >= 5 ){



                        $return['error'] = 'You have reached maximum limit of 5';

                    }else{



                        $return['success'] = DB::table('user_products')->where('id', $productId)->update(['featured' => '1']);

                    }

                }

            }else{



                $return['error'] = 'This user is not the owner of this product';

            }

        }else{



            $return['error'] =  'No user is available';

        }



        /*if( $return['error'] != '' ){



            Session::flash('error', 'Error: '.$return['error']);

        }

        Session::flash('page', 'prods');*/

        return $return;

    }



    public function deleteYourMusic(Request $request){

        $return['error'] = $return['success'] = '';

        if( Auth::check() || $request->has('easy_delete') ){

            $user = Auth::check() ? Auth::user() : null;
            $music = UserMusic::find($request->id);
            $downloads = $music->downloads;
            $easyDelete = $request->has('easy_delete') ? $request->get('easy_delete') : '';

            if( $music && ($easyDelete == '1' || $music->user_id == $user->id) ){

                $customerBasket = CustomerBasket::where(['purchase_type' => 'music'])->get();
                foreach($customerBasket as $b){

                    if($b->music_id == $music->id){

                        $b->delete();
                    }
                }

                $purchasedMusics = InstantCheckoutItem::where("source_table_id", $music->id)->where('type', 'music')->get();
                if(count($purchasedMusics) == 0){

                    if($music->thumbnail_left != "" && CommonMethods::fileExists(public_path('user-music-thumbnails/') . $music->thumbnail_left)) {

                        unlink(public_path('user-music-thumbnails/') . $music->thumbnail_left);
                    }
                    if($music->thumbnail_center != "" && CommonMethods::fileExists(public_path('user-music-thumbnails/') . $music->thumbnail_center)) {

                        unlink(public_path('user-music-thumbnails/') . $music->thumbnail_center);
                    }
                    if($music->thumbnail != "" && CommonMethods::fileExists(public_path('user-music-thumbnails/') . $music->thumbnail)) {

                        unlink(public_path('user-music-thumbnails/') . $music->thumbnail);
                    }

                    if($music->music_file != '' && CommonMethods::fileExists(public_path('user-music-files/') . $music->music_file)) {

                        unlink(public_path('user-music-files/') . $music->music_file);

                        if(count($downloads)){

                            $contents = collect(Storage::cloud()->listContents('/', false));
                            foreach ($downloads as $key => $download) {

                                if(strpos($download['itemtype'], 'loop') !== false){
                                    $UnFileDir = 'loops/';
                                }else if(strpos($download['itemtype'], 'stem') !== false){
                                    $UnFileDir = 'stems/';
                                }else{
                                    $UnFileDir = '';
                                }

                                $UnFileName = public_path('user-music-files/'.$UnFileDir.$download['dec_fname']);
                                if(CommonMethods::fileExists($UnFileName)) {
                                    unlink($UnFileName);
                                }

                                $file = $contents
                                    ->where('type', '=', 'file')
                                    ->where('filename', '=', $download['filename'])
                                    ->first();
                                if($file && is_array($file) && count($file)){
                                    Storage::cloud()->delete($file['path']);
                                }
                            }
                        }
                    }

                    $return['success'] = $music->delete();
                }else{

                    $music->user_id = null;
                    $return['success'] = $music->save();
                }

            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

        Session::flash('page', 'musics');
    }



    public function starMyMusic(Request $request){



        $return['success'] = $return['error'] = '';

        $user = Auth::user();

        $musicId = $request->music_id;

        $music = UserMusic::find($musicId);



        if( Auth::check() ){



            if( $music && $music->user_id == $user->id ){



                $featuredStatus = $music->featured;

                if( $featuredStatus == '1' ){



                    $return['success'] = DB::table('user_musics')->where('id', $musicId)->update(['featured' => '0']);

                }else{



                    $userFeaturedProductsCount = UserProduct::where(['user_id' => $user->id, 'featured' => '1'])->get()->count();

                    $userFeaturedMusicCount = UserMusic::where(['user_id' => $user->id, 'featured' => '1'])->get()->count();

                    if( $userFeaturedProductsCount + $userFeaturedMusicCount >= 5 ){



                        $return['error'] = 'You have reached maximum limit of 5';

                    }else{



                        $return['success'] = DB::table('user_musics')->where('id', $musicId)->update(['featured' => '1']);

                    }

                }

            }else{



                $return['error'] = 'This user is not the owner of this music';

            }

        }else{



            $return['error'] =  'No user is available';

        }



        /*if( $return['error'] != '' ){



            Session::flash('error', 'Error: '.$return['error']);

        }

        Session::flash('page', 'musics');*/

        return $return;

    }



    public function getStoryText(){

        $user = Auth::user();

        $profile = $user->profile;

        $campaign = $user->campaigns()->where('status', 'active')->orderBy('id', 'desc')->first();

        return view( 'parts.editor-contents', ['profile'=> $profile, 'campaign'=> $campaign] );





        /*$user = Auth::user();

        if($user){

            echo html_entity_decode($user->profile->story_text);

        }

        echo "";*/

    }



    public function uploadProfileStoryImages(Request $request){

        $user = Auth::user();

        $user->profile->story_text = $request->story_text;

        $storyImages = explode(',', $user->profile->story_images);

        if($request->has('story_image_0')){

            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->get('story_image_0')));
            if(isset($storyImages[0]) && $storyImages[0] != '' && CommonMethods::fileExists(public_path('user-story-images/').$storyImages[0])){

                unlink(public_path('user-story-images/').$storyImages[0]);
            }
            $fileName = rand(100000, 999999).'.png';
            file_put_contents(public_path('user-story-images/').$fileName, $imageData);
            $storyImagesNew[0] = $fileName;
        }else{
            $storyImagesNew[0] = isset($storyImages[0]) ? $storyImages[0] : '';
        }

        if($request->has('story_image_1')){

            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->get('story_image_1')));
            if(isset($storyImages[1]) && $storyImages[1] != '' && CommonMethods::fileExists(public_path('user-story-images/').$storyImages[1])){

                unlink(public_path('user-story-images/').$storyImages[1]);
            }
            $fileName = rand(100000, 999999).'.png';
            file_put_contents(public_path('user-story-images/').$fileName, $imageData);
            $storyImagesNew[1] = $fileName;
        }else{
            $storyImagesNew[1] = isset($storyImages[1]) ? $storyImages[1] : '';
        }

        if($request->has('story_image_2')){

            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->get('story_image_2')));
            if(isset($storyImages[2]) && $storyImages[2] != '' && CommonMethods::fileExists(public_path('user-story-images/').$storyImages[2])){

                unlink(public_path('user-story-images/').$storyImages[2]);
            }
            $fileName = rand(100000, 999999).'.png';
            file_put_contents(public_path('user-story-images/').$fileName, $imageData);
            $storyImagesNew[2] = $fileName;
        }else{
            $storyImagesNew[2] = isset($storyImages[2]) ? $storyImages[2] : '';
        }

        $user->profile->story_images = implode(',', $storyImagesNew);

        $user->profile->save();

    }

    public function removeStoryImage(Request $request){

        $success = 0;
        $error = '';

        if($request->has('id')){

           if(!Auth::check()){

               $error = 'You are already logged in';
               $success = 0;
           }else{

                $user = Auth::user();
                $id = $request->get('id');
                $storyImagesNew = explode(',', $user->profile->story_images);
                if($id == 'story_image_0'){
                    if(CommonMethods::fileExists(public_path('user-story-images/').$storyImagesNew[0])){
                        unlink(public_path('user-story-images/').$storyImagesNew[0]);
                    }
                    $storyImagesNew[0] = '';
                }else if($id == 'story_image_1'){
                    if(CommonMethods::fileExists(public_path('user-story-images/').$storyImagesNew[1])){
                        unlink(public_path('user-story-images/').$storyImagesNew[1]);
                    }
                    $storyImagesNew[1] = '';
                }else if($id == 'story_image_2'){
                    if(CommonMethods::fileExists(public_path('user-story-images/').$storyImagesNew[2])){
                        unlink(public_path('user-story-images/').$storyImagesNew[2]);
                    }
                    $storyImagesNew[2] = '';
                }else{
                    $error = 'unknown parameter';
                }

                if($error == ''){

                    $storyImagesNew[0] = isset($storyImagesNew[0]) ? $storyImagesNew[0] : '';
                    $storyImagesNew[1] = isset($storyImagesNew[1]) ? $storyImagesNew[1] : '';
                    $storyImagesNew[2] = isset($storyImagesNew[2]) ? $storyImagesNew[2] : '';
                    $user->profile->story_images = implode(',', $storyImagesNew);
                    $user->profile->save();

                    $success = 1;
                }
           }
        }else{

            $error = 'No data';
        }

        return json_encode(['success' => $success, 'error' => $error]);
    }




    public function connectUserSocialSpotify(Request $request){

        if(Auth::user()){

            $user = Auth::user();
            $spotifyArtistUrl = $request->spotify_artist_url;
            $user = User::find($user->id);
            $spotifyArtistId = str_replace(['open.spotify.com','artist','http://', 'https://', '/', 'www.'], '', $spotifyArtistUrl);
            $user->profile->social_spotify_artist_id = $spotifyArtistId;
            $user->profile->save();
            return '1';
        }else{

            return false;
        }

        return false;
    }



    public function disconnectUserSocialSpotify(Request $request){

        if( Auth::user() ){

            $user = Auth::user();
            $user->profile->social_spotify_artist_id = '';
            $user->profile->save();
            return '1';
        }
    }



    public function connectUserSocialTwitter(Request $request){

        if( Auth::user() ){

            $user = Auth::user();
            $twitterUsername = $request->twitter_connect_username;
            $user = User::find($user->id);
            $twitterUsername = str_replace(['twitter.com','http://', 'https://', '/', 'www.'], '', $twitterUsername);
            return DB::table('profiles')

                ->where('user_id', $user->id)

                ->update(['social_twitter' => $twitterUsername]);
        }else{

            return false;
        }

        return false;
    }

    public function connectInstagram()
    {

        $instaClientId = config('services.instagram.client_id');
        $instaRedirect = config('services.instagram.redirect');
        $redirectUrl = 'https://api.instagram.com/oauth/authorize/?client_id='.$instaClientId.'&redirect_uri='.$instaRedirect.'&scope=user_profile,user_media&response_type=code';
        return redirect($redirectUrl);
    }

    public function connectUserSocialInstagram(Request $request){

        if( $request->error == 'access_denied' ){

            echo 'Error: Instagram returned an error. Reason: '.$request->error_reason;
        }else{

            $instaClientId = config('services.instagram.client_id');
            $instaRedirect = config('services.instagram.redirect');
            $instaClientSecret = config('services.instagram.client_secret');

            $data = array('code' => $request->code, 'redirect_uri' => $instaRedirect, 'grant_type' => 'authorization_code', 'client_secret' => $instaClientSecret, 'client_id' => $instaClientId);
            $url = 'https://api.instagram.com/oauth/access_token';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec ($ch);
            curl_close ($ch);
            $return = json_decode(trim($output), TRUE);
            $userAccessTokenSL = $return['access_token'];
            $userId = $return['user_id'];

            $url3 = 'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret='.$instaClientSecret.'&access_token='.$userAccessTokenSL;
            $ch3 = curl_init($url3);
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
            $output32 = curl_exec($ch3);
            curl_close ($ch3);
            $return3 = json_decode(trim($output32), TRUE);

            if( strlen($userAccessTokenSL) && strlen($userId) ){

                if( Auth::user() ){

                    $user = Auth::user();
                    $user->profile->social_instagram_user_access_token_sl = isset($return3['access_token']) ? $userAccessTokenSL : NULL;
                    $user->profile->social_instagram_user_access_token_ll = isset($return3['access_token']) ? $return3['access_token'] : NULL;
                    $user->profile->social_instagram_ll_token_date_time = isset($return3['access_token']) ? date('Y-m-d H:i:s') : NULL;
                    $user->profile->social_instagram_user_id = isset($return3['access_token']) ? (string)$userId : NULL;

                    $user->profile->save();

                    return redirect(route('profile'));

                }else{

                    $redirectUrl = "/dashboard";
                    $isBuyerOnly = NULL;

                    if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'negotiate_') !== false){
                        $socialiteFrom = explode('_', Session::get('socialite_from'));
                        $socialiteFromUser = User::find($socialiteFrom[1]);
                        $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
                        Session::forget('socialite_from');
                        Session::flash('show_popup', '#bespoke_license_popup');
                        $isBuyerOnly = 1;
                    }

                    $loginUser = User::where('email', $userId.'@social.com')->first();
                    if(!$loginUser){

                        $url4 = 'https://graph.instagram.com/'.$userId.'?fields=id,username&access_token='.$userAccessTokenSL;
                        $ch4 = curl_init($url4);
                        curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
                        $output4 = curl_exec($ch4);
                        curl_close ($ch4);
                        $return4 = json_decode(trim($output4), TRUE);

                        $loginUser = new User();
                        $loginUser->name            = $return4['username'];
                        $loginUser->email           = $userId.'@social.com';
                        $loginUser->password        = NULL;
                        $loginUser->subscription_id = 0;
                        $loginUser->active          = 1;
                        $loginUser->api_token       = str_random(60);
                        $loginUser->is_buyer_only   = $isBuyerOnly;
                        $loginUser->save();

                        $address             = new Address();
                        $address->alias      = 'main address';
                        $address->user_id = $loginUser->id;
                        $address->save();

                        $profile = new Profile();
                        $profile->birth_date = Carbon::now();
                        $profile->user_id = $loginUser->id;
                        $profile->save();
                    }

                    Auth::login($loginUser);
                    return redirect($redirectUrl);
                }
            }else{

                echo 'Error: Instagram returned unexpected output';
            }
        }
    }

    public function processReminderLogin(Request $request){

        $success = 0;
        $error = '';

        if($request->has('login_email') && $request->has('login_password')){

           if(Auth::user()){

               $error = 'You are already logged in';
               $success = 0;
           }else{

               $email = $request->login_email;
               $password = $request->login_password;

               $user = User::where(['email' => $email])->first();
               if ($user && Hash::check($password, $user->password)) {
                   Auth::login($user);
                   $success = 1;
               }else{
                   $error = 'Email/Password is not correct';
               }
           }
        }else{

            $error = 'No data';
        }


        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function disconnectUserSocialInstagram(Request $request){



        if( Auth::user() ){

            $user = Auth::user();

            $username = $request->instagram_connect_username;

            $user = User::find($user->id);

            DB::table('profiles')

                ->where('user_id', $user->id)

                ->update(['social_instagram_user_id' => '','social_instagram_username' => '', 'social_instagram_profile_picture' => '', 'social_instagram_user_access_token' => '']);

        }else{



        }

    }

    public function removeUserSocialInstagram(Request $request){

        $return = 0;

        if ($request->isMethod('post') && $request->has('id')){

            $userProfile = Profile::where('social_instagram_user_id', $request->get('id'))->first();
            if($userProfile){

                $return = DB::table('profiles')

                    ->where('social_instagram_user_id', $request->get('id'))

                    ->update(['social_instagram_user_id' => '','social_instagram_username' => '', 'social_instagram_profile_picture' => '', 'social_instagram_user_access_token' => '']);

            }
        }

        return json_encode(array('return' => $return));

    }

    public function connectUserSocialYoutube(Request $request){



        if( Auth::user() ){

            $user = Auth::user();

            $username = $request->youtube_connect_username;

            $user = User::find($user->id);

            return DB::table('profiles')

                ->where('user_id', $user->id)

                ->update(['social_youtube' => $username]);

        }else{

            return 0;

        }

    }



    public function connectUserSocialFacebook(Request $request){



        if( Auth::user() ){

            // if page exists..

            if($request->facebook_connect_username == ""){

                $user = Auth::user();

                $username = $request->facebook_connect_username;

                $user = User::find($user->id);

                DB::table('profiles')

                    ->where('user_id', $user->id)

                    ->update(['social_facebook' => $username]);

            }else{

               $user = Auth::user();

                        $username = $request->facebook_connect_username;

                        $user = User::find($user->id);



                        return DB::table('profiles')

                            ->where('user_id', $user->id)

                            ->update(['social_facebook' => $username]);

            }

        }

    }

    public static function getUserSpotifyIframe(Request $request){

        $iFrame = '';
        $commonMethods = new commonMethods;
        if($request->userId){

            $user = User::find($request->userId);
        }else{

            return '';
        }

        if($user && $user->profile && $user->profile->social_spotify_artist_id != ''){

            $iFrame = '<iframe src="https://open.spotify.com/follow/1?uri=spotify:artist:'.$user->profile->social_spotify_artist_id.'&size=detail&theme=dark" scrolling="no" style="border:none; overflow:hidden; width: 100%;" allowtransparency="true" height="56" frameborder="0"></iframe>';
            return $iFrame;
        }else{

            return '';
        }

        return $iFrame;
    }



    public function updateUserThankStatus(Request $request)

    {

        if( !$request->updateId || !$request->updateTable ){



            return 'error';

        }else{



            if($request->updateTable == 'subscription'){



                $subs = StripeSubscription::find($request->updateId);

                $subs->thank_you_sent = 1;

                $subs->save();

            }else{



                $perk = StripePerk::find($request->updateId);

                $perk->thank_you_sent = 1;

                $perk->save();

            }



            return 'success';

        }

    }



    protected function sendThanksEmail(Request $request)

    {

        $result = 0;

        $username = $request->username;

        $email = $request->email;

        $message = $request->message;

        $name = $request->name;

        if($email && Auth::check()){

            $result = Mail::to($email)->bcc(Config('constants.bcc_email'))->send(new ThankYou(Auth::user(), $name, $message));

            $payment_type = $request->payment_type;
            $type_id = $request->type_id;
            if($payment_type == 'subscription' && $type_id != ''){

                $subs = StripeSubscription::find($type_id);

                if($subs){

                    $subs->thank_you_sent = 1;
                    $subs->save();
                }
            }else if($payment_type == 'perk' && $type_id != ''){

                $perk = StripePerk::find($type_id);

                if($perk){
                    $perk->thank_you_sent = 1;
                    $perk->save();
                }
            }else if($type_id != ''){

                $perk = StripeCheckout::find($type_id);

                if($perk){
                    $perk->thank_you_sent = 1;
                    $perk->save();
                }
            }
        }

        return $result;

    }

    protected function searchCountries(Request $request)

    {



        $searchString = trim($request->string);

        $return2[] = array();

        $result = null;



        if( $searchString != '' ){

            $result = DB::table('countries')->where('name', 'like', $searchString.'%')->orderBy('name', 'asc')->get();

        } else {

            $result = DB::table('countries')->orderBy('name', 'asc')->get();

        }

        foreach ($result as $key => $country) {

            $return2[] = $country;

        }

        $return2 = array_filter($return2);



        $get_total_rows = count($result);

        $return = array(

            "result" => $return2,

            "totalRecords" => $get_total_rows,

            "success" => 1,

        );

        return json_encode($return);

    }

    protected function searchCities(Request $request)

    {



        $searchString = trim($request->string);

        $return2[] = array();

        $result = null;



        if( $searchString != '' ){

            $result = DB::table('cities')->where('name', 'like', $searchString.'%')->orderBy('name', 'asc')->get();



        } else{

            $result = DB::table('cities')->orderBy('name', 'asc')->get();

        }

        foreach ($result as $key => $country) {



            $return2[] = $country;

        }

        $return2 = array_filter($return2);



        $get_total_rows = count($result);

        $return = array(

            "result" => $return2,

            "totalRecords" => $get_total_rows,

            "success" => 1

        );

        return json_encode($return);

    }



    protected function searchFurtherSkills(Request $request)

    {



        $searchString = trim($request->string);

        $return2[] = array();

        $result = null;



        if( $searchString != '' ){



            $result = DB::table('user_further_skills')->where('value', 'like', $searchString.'%')->orderBy('value', 'asc')->get();

        }

        else {

            $result = DB::table('user_further_skills')->orderBy('value', 'asc')->get();

        }

        foreach ($result as $key => $country) {



            $return2[] = $country;

        }

        $return2 = array_filter($return2);

        $get_total_rows = count($result);

        $return = array(

            "result" => $return2,

            "totalRecords" => $get_total_rows

        );

        return json_encode($return);

    }

    protected function searchInstruments(Request $request)

    {



        $searchString = trim($request->string);

        $return2[] = array();

        $result = null;



        if( $searchString != '' ){



            $result = DB::table('music_instrument')->where('value', 'like', '%'.$searchString.'%')->orderBy('value', 'asc')->get();

        }

        else {

            $result = DB::table('music_instrument')->orderBy('value', 'asc')->get();

        }

        foreach ($result as $key => $country) {



            $return2[] = $country;

        }

        $return2 = array_filter($return2);

        $get_total_rows = count($result);

        $return = array(

            "result" => $return2,

            "totalRecords" => $get_total_rows,

            "success" => 1,

        );

        return json_encode($return);

    }

    protected function searchSkills(Request $request){

        $searchString = trim($request->string);
        $return2[] = array();
        $result = null;

        if($searchString != ''){

            $result = DB::table('skills')->where('value', 'like', '%'.$searchString.'%')->orderBy('value', 'asc')->get();
        }else{

            $result = DB::table('skills')->orderBy('value', 'asc')->get();
        }

        foreach ($result as $key => $country) {

            $return2[] = $country;
        }

        $return2 = array_filter($return2);
        $get_total_rows = count($result);
        $return = array(

            "result" => $return2,
            "totalRecords" => $get_total_rows,
            "success" => 1,
        );

        return json_encode($return);
    }


    protected function searchServices(Request $request){

        $searchString = trim($request->string);
        $return2[] = array();
        $result = null;

        if($searchString != ''){

            $result = DB::table('services')->where('name', 'like', '%'.$searchString.'%')->orderBy('name', 'asc')->get();
        }else{

            $result = DB::table('services')->orderBy('name', 'asc')->get();
        }

        foreach ($result as $key => $country) {

            $return2[] = $country;
        }

        $return2 = array_filter($return2);
        $get_total_rows = count($result);
        $return = array(

            "result" => $return2,
            "totalRecords" => $get_total_rows,
            "success" => 1,
        );

        return json_encode($return);
    }

    protected function searchMoods(Request $request)

    {



        $searchString = trim($request->string);

        $return2[] = array();

        $result = null;



        if( $searchString != '' ){



            $result = DB::table('moods')->where('name', 'like', '%'.$searchString.'%')->orderBy('name', 'asc')->get();

        }

        else {

            $result = DB::table('moods')->orderBy('name', 'asc')->get();

        }

        foreach ($result as $key => $country) {



            $return2[] = $country;

        }

        $return2 = array_filter($return2);

        $get_total_rows = count($result);

        $return = array(

            "result" => $return2,

            "totalRecords" => $get_total_rows,

            "success" => 1,

        );

        return json_encode($return);

    }



    public function saveUserProject(Request $request){



        $return['success'] = $return['error'] = '';

        $user = Auth::user();

        $commonMethods = new CommonMethods();

        if (Auth::check()) {



            $campaign = $commonMethods->getUserRealCampaignDetails($user->id);
            $userCampaign = userCampaign::find($campaign['id']);

            if(!$campaign['campaignTitle'] || $campaign['campaignTitle'] == ''){

                $userCampaign->created_at = date('Y-m-d H:i:s');
            }


            $userCampaign->title = ( $request->project_title != null ) ? $request->project_title : '';

            $userCampaign->is_charity = ( $request->project_type != null ) ? $request->project_type : 0;

            $userCampaign->amount = ( $request->project_amount != null ) ? $request->project_amount : 0;

            $userCampaign->currency = strtoupper($user->profile->default_currency);

            $userCampaign->duration = ( $request->project_duration != null ) ? $request->project_duration : 0;

            $userCampaign->extend_duration = ( $request->extend_duration != null ) ? $request->extend_duration : 0;

            $userCampaign->new_story_text = ( $request->project_story_text != null ) ? $request->project_story_text : '';


            if($request->has('go_live') && $request->get('go_live') == '1'){

                $userCampaign->is_live = 1;
                $projectIsLiveNow = 1;
            }


            if( $request->terms_agree == '1' ){



                $return['success'] = $userCampaign->save();

                if(isset($projectIsLiveNow) && $projectIsLiveNow == 1){

                    $result = Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new ProjectUpdate('isLive', $user, $userCampaign));
                }

            }else{



                $return['error'] = 'Please agree to our terms and conditions';

            }

        }else{



            $return['error'] = 'No user is logged in';

        }



        if( $return['error'] != ''){



            Session::flash('error', 'Error: '.$return['error']);

        }

        if($request->has('save_and_preview') && $request->get('save_and_preview') == '1'){

            return redirect(route('user.project.preview', ['username' => $user->username]));
        }

        //return $return;

        Session::flash('share_project', '1');

        return Redirect::back()->with("page", "crowdfunds");



    }

    public function saveUserSubscribers(Request $request){



        $return['success'] = $return['error'] = '';

        $user = Auth::user();

        $secretKey = $user->profile->stripe_secret_key;

        if (Auth::check()) {



            $userCampaign = $user->campaigns()->where('status', 'active')->orderBy('id', 'desc')->first();

            if (!$userCampaign){



                $userCampaign = new userCampaign;

                $userCampaign->user_id = $user->id;

                $userCampaign->save();

            }

            if($request->has('encourage_bullets')){

                $user->encourage_bullets = $request->encourage_bullets;
            }

            $user->subscription_currency = strtoupper($user->profile->default_currency);

            if($request->has('subscription_amount')){

                $user->subscription_amount = $request->subscription_amount;
            }


            $user->accept_donations = $request->accept_donations == 1 ? $request->accept_donations : null;

            $user->save();

            return redirect(route('profile'));
        }
    }

    public function addEditBonus(Request $request){



        $return['success'] = $return['error'] = '';

        $user = Auth::user();

        $commonMethods = new CommonMethods();

        if (Auth::check()) {



            $imageName = '';

            if($request->hasFile( 'bonus_thumbnail' )){



                $bonusThumbnail = $request->file('bonus_thumbnail');

                if(!$commonMethods->userCanUploadFile($user, $request, 'bonus_thumbnail')){

                    $return['error'] = "Error: Your package storage limit has reached";
                }

                $extention = $this->getFileExtension($_FILES["bonus_thumbnail"]['name']);

                $allowedExtensions = ['jpg', 'png', 'jpeg'];

                if(in_array($extention, $allowedExtensions)){



                    $imageName = "user-bonus-" . uniqid() . "." . $extention;

                    $imgPath = public_path( 'user-bonus-thumbnails/'.$imageName );

                    //$bonusThumbnail->move(public_path( 'user-bonus-thumbnails/' ), $imageName);

                    //CommonMethods::compress($imgPath, $imgPath, 90);

                    $result = Image::make( $bonusThumbnail )->resize(780, null,function($constraint){$constraint->aspectRatio();})->save( $imgPath,60);

                }

            }



            if($return['error'] == ''){

                if( $request->bonus_id && $request->bonus_campaign_id ){



                    $bonus = CampaignPerks::find($request->bonus_id);

                    $campaign = UserCampaign::find($request->bonus_campaign_id);

                    if( $campaign->user_id == $user->id ){



                        $bonus->title = $request->bonus_title;

                        $bonus->amount = $request->bonus_price;

                        $bonus->currency = strtoupper($user->profile->default_currency);

                        $bonus->description = $request->bonus_description;

                        $bonus->items_available = $request->bonus_quantity;

                        $bonus->items_included = $request->bonus_items;

                        if( $request->bonus_shipping_my_country != null ){



                            $bonus->my_country_delivery_cost = $request->bonus_shipping_my_country;

                            $bonus->my_country_delivery_cost_currency = strtoupper($user->profile->default_currency);

                        }

                        if( $request->bonus_shipping_worldwide != null ){



                            $bonus->worldwide_delivery_cost = $request->bonus_shipping_worldwide;

                            $bonus->worldwide_delivery_cost_currency = strtoupper($user->profile->default_currency);

                        }

                        if( $imageName != '' ){



                            if($bonus->thumbnail != "" && CommonMethods::fileExists(public_path( 'user-bonus-thumbnails/' ).$bonus->thumbnail)) {

                                unlink(public_path('user-bonus-thumbnails/') . $bonus->thumbnail);

                            }



                            $bonus->thumbnail = $imageName;

                        }

                        $return['success'] = $bonus->save();

                    }else{



                        $return['error'] = 'You are not the owner of this bonus';

                    }

                }else{



                    $userCampaign = $user->campaigns()->where('status', 'active')->orderBy('id', 'desc')->first();

                    if (!$userCampaign){



                        $userCampaign = new userCampaign;

                        $userCampaign->user_id = $user->id;

                        $userCampaign->save();

                    }

                    $bonus = new CampaignPerks;

                    $bonus->title = $request->bonus_title;

                    $bonus->campaign_id = $userCampaign->id;

                    $bonus->amount = $request->bonus_price;

                    $bonus->currency = strtoupper($user->profile->default_currency);

                    $bonus->description = $request->bonus_description;

                    $bonus->items_available = $request->bonus_quantity;

                    $bonus->items_included = $request->bonus_items;

                    if( $request->bonus_shipping_my_country != null ){



                        $bonus->my_country_delivery_cost = $request->bonus_shipping_my_country;

                        $bonus->my_country_delivery_cost_currency = strtoupper($user->profile->default_currency);

                    }

                    if( $request->bonus_shipping_worldwide != null ){



                        $bonus->worldwide_delivery_cost = $request->bonus_shipping_worldwide;

                        $bonus->worldwide_delivery_cost_currency = strtoupper($user->profile->default_currency);

                    }if( $imageName != '' ){



                        $bonus->thumbnail = $imageName;

                    }

                    $return['success'] = $bonus->save();

                }
            }

        }else{



            $return['error'] = 'No user is logged in';

        }



        if( $return['error'] != ''){



            //Session::flash('error', 'Error: '.$return['error']);

        }



        //return $return;

        //return Redirect::back()->with("page", "crowdfunds");

        $userCampaign = userCampaign::find($request->campaign_id);

        $data = [

            "userCampaign" => $userCampaign

        ];

        return view( 'parts.all_bonuses_section', $data );



    }



    public function deleteYourBonus(Request $request){



        $return['error'] = $return['success'] = '';



        if( Auth::check() ){



            $user = Auth::user();

            $bonus = CampaignPerks::find($request->id);



            if( $bonus !== null ){



                $campaign = UserCampaign::find($bonus->campaign_id);

                if( $campaign !== null && $campaign->user_id == $user->id ){



                    if($bonus->thumbnail != "" && CommonMethods::fileExists(public_path( 'user-bonus-thumbnails/' ).$bonus->thumbnail)) {

                        unlink(public_path('user-bonus-thumbnails/') . $bonus->thumbnail);

                    }



                    $return['success'] = $bonus->delete();

                }else{



                    $return['error'] = 'You are not the owner of this item';

                }

            }else{



                $return['error'] = 'Delete item does not exist';

            }

        }else{



            $return['error'] = 'No user is logged in';

        }



        if( $return['error'] != '' ){



            Session::flash('error', 'Error: '.$return['error']);

        }



        //Session::flash('page', 'crowdfunds');

        $userCampaign = userCampaign::find($request->campaign_id);

        $data = [

            "userCampaign" => $userCampaign

        ];

        return view( 'parts.all_bonuses_section', $data );

    }



    public function postUserProjectVideo(Request $request)

    {

        $return['error'] = $return['success'] = '';



        if( Auth::check() ){



            $user = Auth::user();



            $videoUrl = $request->video_url;

            if( strlen( $videoUrl ) && $request->campaign_id ){





                if( CompetitionVideo::isValidURL( $videoUrl ) ){



                    $userCampaign = UserCampaign::find($request->campaign_id);

                    if( $userCampaign !== null ){



                        $userCampaign->project_video_url = $videoUrl;

                        $userCampaign->save();

                    }

                }else{



                    $return['error'] = 'Given URL is not a valid youtube video';

                }

            }else{



                $return['error'] = 'Video Url is empty';

            }

        }else{



            $return['error'] = 'User not authorised';

        }



        if( $return['error'] != '' ){



            Session::flash('error', 'Error: '.$return['error']);

        }



        Session::flash('page', 'crowdfunds');

    }



    public function postUserBioVideo(Request $request)

    {

        $return['error'] = $return['success'] = '';

        $commonMethods = new CommonMethods();

        if( Auth::check() ){



            $user = Auth::user();



            $videoUrl = $request->video_url;

            if( $request->profile_id ){





                if( $videoUrl =='' || CompetitionVideo::isValidURL( $videoUrl ) ){



                    $userProfile = Profile::find($request->profile_id);

                    if( $userProfile !== null ){


                        $userProfile->user_bio_video_id = $videoUrl != '' ? Youtube::parseVIdFromURL($videoUrl) : NULL;

                        $userProfile->user_bio_video_title = $videoUrl != '' ? substr($commonMethods->getVideoTitle($userProfile->user_bio_video_id), 0, 40) : NULL;

                        $userProfile->user_bio_video_url = $videoUrl;

                        $userProfile->save();

                    }

                }else{



                    $return['error'] = 'Given URL is not a valid youtube video';

                }

            }else{



                $return['error'] = 'Video Url is empty';

            }

        }else{



            $return['error'] = 'User not authorised';

        }



        if( $return['error'] != '' ){



            Session::flash('error', 'Error: '.$return['error']);

        }



        Session::flash('page', '');

    }



    public function stripeOauthRedirect(Request $request){

        $user = Auth::user();
        $commonMethods = new CommonMethods();

        require_once(app_path().'/includes/stripe/oauth-classes/lib/OAuth2Client.php');

        require_once(app_path().'/includes/stripe/oauth-classes/StripeOAuth.class.php');

        $clientId = Config('constants.stripe_connect_client_id');
        $secretKey = Config('constants.stripe_key_secret');

        $oauth = (new \StripeOAuth($clientId, $secretKey));

        if(isset($_GET['code'])){

            $token = $oauth->getAccessToken($_GET['code']);
            $key = $oauth->getPublishableKey($_GET['code']);
            $user_id = $oauth->getUserId();

            $url = 'https://api.stripe.com/v1/accounts/'.$user_id;
            $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
            $fields = [];
            $stripeAccount = $commonMethods->stripeCall($url, $headers, $fields, 'GET');

            if(isset($stripeAccount['charges_enabled']) && $stripeAccount['charges_enabled'] == '1' && $stripeAccount['details_submitted'] == '1'){
                $continue = 1;
            }else{
                $continue = 0;
            }

            if($continue == 1){

                $profile = $user->profile;

                $profile->stripe_secret_key = $token;

                $profile->stripe_publishable_key = $key;

                $profile->stripe_user_id = $user_id;

                $profile->save();

                return redirect(route('profile.with.tab', ['tab' => 'orders']));
            }else{

                return Redirect::to('profile')->with( 'error', 'Please fill in all the details and authorize access to 1Platform TV');
            }
        }else{

            return Redirect::to('profile')->with( 'error', 'Please fill in all the details and authorize access to 1Platform TV');
        }

    }



    public function admin(Request $request){

        ?>

        <iframe src="http://duong.1platform.tv/goAdmin" style="width: 100%; border: none; height: 1000px;"></iframe>

        <?php

    }



    public function setPwd(){

        $user = User::find(1);

        $user->password = bcrypt("123456");

        $user->save();

    }



    public function inactivateProject(Request $request){

        $campaign = userCampaign::find($request->id);

        $campaign->status = "inactive";

        $campaign->save();

        return Redirect::back();

    }



    public function updateFirsttimeLogin(Request $request){

        $user = Auth::user();

        $user->firstlogintime = $request->value;

        $user->save();

    }



    public function downLoadMusicFile($filePath, $musicId){

        $extensions = [
            'application/x-rar'            => 'rar',
            'application/rar'              => 'rar',
            'application/x-rar-compressed' => 'rar',
            'application/zip'              => 'zip',
            'application/x-compressed'     => '7zip',
            'audio/x-wav'                  => 'wav',
            'audio/wav'                    => 'wav',
            'audio/mp3'                    => 'mp3',
            'text/plain'                   => 'txt',
            'audio/mpeg'                   => 'mp3',
            'image/png'                    => 'png',
            'image/jpeg'                   => 'jpg',
            'image/jpg'                    => 'jpg',
            'application/pdf'              => 'pdf',
            'application/x-pdf'            => 'pdf',
        ];

        if($filePath && $musicId){

            $music = UserMusic::find($musicId);
            $musicArray = $music->downloads;
            foreach ($musicArray as $key => $item) {
                if($item['dec_fname'] == $filePath){
                    $type = $item['itemtype'];
                    $size = $item['size'];
                    $mime = $item['mimetype'];
                }
            }

            if(strpos($filePath, 'LIC_') !== false && strpos($filePath, '.pdf') !== false){

                $type = 'License';
                $sourceFile = strpos($filePath, 'STAN_') !== false ? public_path('standard-licenses/'.$filePath) : public_path('bespoke-licenses/'.$filePath);
                $mime = 'application/pdf';
            }


            if($type != ''){

                $explode = explode('_', $type);
                $explode[0] = $explode[0] == 'main' ? '' : ucfirst(str_replace('_', ' ', $type)).' - ';

                if($music->user){
                    $filename = $explode[0].trim($music->song_name).' - '.trim($music->user->name).' - 1Platform TV.'.$extensions[$mime];
                }else{
                    $filename = $explode[0].trim($music->song_name).' - 1Platform TV.'.$extensions[$mime];
                }


                if(strpos($type, 'loop') !== false){
                    $decFDir = 'loops/';
                }else if(strpos($type, 'stem') !== false){
                    $decFDir = 'stems/';
                }else{
                    $decFDir = '';
                }
                $sourceFile = !isset($sourceFile) ? public_path('user-music-files/'.$decFDir.$filePath) : $sourceFile;

                header("Content-Length: " . filesize($sourceFile));

                header('Content-Type: application/octet-stream');

                header('Content-Disposition: attachment; filename='.$filename);

                readfile($sourceFile);

                exit;

            }else{
                $error = 'File not found';
            }
        }else{
            $error = 'Missing required data';
        }

        return $error;

    }



    public function downLoadProductFile($fileName, $directory, $title){

        $path = $directory.'/'.$fileName;



        $explodedFileName = explode(".", $fileName);

        header('Content-Length: '.filesize($path));

        header('Content-Type: application/octet-stream');

        header('Content-Disposition: attachment; filename=' . str_replace(" ","-", $title) . "." . $explodedFileName[sizeof($explodedFileName) -1]);



        readfile($path);

        exit;

    }



    public function activateStudioAccount(){

        $user = Auth::user();

        $user->profile->account_type = "Yes, I need a  professional Studio account";

        $user->profile->save();

    }

    public function toggleFavouriteMusic(Request $request)
    {
        $success = $response = '';
        $musicId = $request->music;
        $searchFilters = $request->filters;
        if( $musicId !== null ){

            if(Auth::check()){

                $music = UserMusic::findorFail($musicId);
                $user = Auth::user();
                if($music) {

                    $userFavouriteMusics = (is_array($user->favourite_musics)) ? $user->favourite_musics : array();
                    if (($key = array_search($musicId, $userFavouriteMusics)) !== false) {
                        unset($userFavouriteMusics[$key]);
                        $response = 'removed';
                    }else{
                        $userFavouriteMusics[] = $musicId;
                        $response = 'added';
                    }
                    $user->favourite_musics = $userFavouriteMusics;
                    $success = $user->save();
                }else{
                    // music does not exist
                    $response = 'no music found';
                }
            }else{
                // no music id was provided
                $request->session()->flash('music_search_filters', $searchFilters);
                $response = 'user must login';
            }
        }else{
            // no music id was provided
            $response = 'no music id provided';
        }

        return response()->json(['response' => $response, 'success' => $success]);
    }

    public function toggleFavouriteProduct(Request $request)
    {
        $success = $response = '';
        $productId = $request->product;
        if($productId !== null){

            if(Auth::check()){

                $product = UserProduct::findorFail($productId);
                $user = Auth::user();
                if($product) {

                    $userFavouriteProducts = (is_array($user->favourite_products)) ? $user->favourite_products : array();
                    if (($key = array_search($productId, $userFavouriteProducts)) !== false) {
                        unset($userFavouriteProducts[$key]);
                        $response = 'removed';
                    }else{
                        $userFavouriteProducts[] = $productId;
                        $response = 'added';
                    }
                    $user->favourite_products = $userFavouriteProducts;
                    $success = $user->save();
                }else{
                    // music does not exist
                    $response = 'no product found';
                }
            }else{
                // no product id was provided
                $response = 'user must login';
            }
        }else{
            // no product id was provided
            $response = 'no music id provided';
        }

        return response()->json(['response' => $response, 'success' => $success]);
    }

    public function toggleFavouriteStream(Request $request)
    {
        $success = $response = '';
        $streamId = $request->stream;
        if( $streamId !== null ){

            if(Auth::check()){

                $stream = VideoStream::findorFail($streamId);
                $user = Auth::user();
                if($stream) {

                    $userFavouriteStreams = (is_array($user->favourite_streams)) ? $user->favourite_streams : array();
                    if (($key = array_search($streamId, $userFavouriteStreams)) !== false) {
                        unset($userFavouriteStreams[$key]);
                        $response = 'removed';
                    }else{
                        $userFavouriteStreams[] = $streamId;
                        $response = 'added';
                    }
                    $user->favourite_streams = $userFavouriteStreams;
                    $success = $user->save();
                }else{
                    // stream does not exist
                    $response = 'no stream found';
                }
            }else{
                // no stream id was provided
                $response = 'user must login';
            }
        }else{
            // no stream id was provided
            $response = 'no stream id provided';
        }

        return response()->json(['response' => $response, 'success' => $success]);
    }

    public function getUserTwitterContent($username)
    {

        session_start();
        require_once("twitter-custom-embedded-feed/twitteroauth/twitteroauth/twitteroauth.php");

        $twitterUsername = trim($username);
        $twitteruser = $twitterUsername;
        $notweets = 10000;
        $consumerkey = "0t1RRRh4TtDdqXZrjnzqX1mwc";
        $consumersecret = "R8KFwit0M6EE0yMD9OxmoT74VKmlS7Lr09ZnjxPXuPa71A4FJg";
        $accesstoken = "2491516098-eBEhuseamO5TXqUbohkG4TVI55ZXnAKuj1DFVUa";
        $accesstokensecret = "52KPbQWWZodK6rEj8uHd70B9gnsZKmkYa2ctM7UXyjIDu";

        function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
          $connection = new \TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
          return $connection;
        }

        $connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

        $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);

        echo json_encode($tweets);
    }

    public function saveUserDomain(Request $request){

        $success = 0;
        $errorMessage = '';
        if(Auth::check()){
            $user = Auth::user();
            $customDomain = $user->customDomainSubscription;
            if(!$customDomain){
                $customDomain = new CustomDomainSubscription();
                $customDomain->user_id = $user->id;
            }

            if($request->has('id')){

                $id = $request->get('id');
                if($id == 'my_url' && $request->get('domain_url') != ''){

                    $customDomain->domain_url = $request->get('domain_url');
                    $customDomain->save();

                    $success = 1;
                }else if($id == 'dns_updated'){
                    $customDomain->dns_updated = 1;
                    $customDomain->save();

                    $success = 1;
                }else{
                    $errorMessage = 'Your request is missing required data';
                }
            }else{
                $errorMessage = 'Insufficient data';
            }

            if($customDomain->domain_url !== null && $customDomain->status === null && $customDomain->dns_updated == 1 && $customDomain->admin_notified === null){

                // notify admin
                $adminEmail = Config('constants.admin_email');
                $bccEmail = Config('constants.bcc_email');
                $result = Mail::send('pages.email.domain-connected-admin-notification', ['user' => $user, 'recipient' => $adminEmail], function ($m) use ($adminEmail,$bccEmail) {
                    $m->bcc($bccEmail);
                    $m->to($adminEmail, '1Platform TV');
                    $m->subject('Domain Requires Your Approval');
                });
                $customDomain->admin_notified = 1;
                $customDomain->save();
            }
        }else{

            $errorMessage = 'No user logged in';
        }
        return json_encode(['success'=> $success, 'errorMessage' => $errorMessage]);
    }

    public function searchSocialDirectoryForMusic(Request $request){

        $success = '';
        $errorMessage = '';

        if($request->has('search')){

            $string = $request->get('search');
            $search = urlencode($string);

            $surl2 = "https://itunes.apple.com/search?term=".$search."&country=US&entity=song&callback=__jp2";
            $sch2 = curl_init($surl2);
            curl_setopt($sch2,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($sch2,CURLOPT_RETURNTRANSFER,1);
            $sresponse = curl_exec($sch2);
            curl_close($sch2);

            $sresponse = str_replace(");","",$sresponse);
            $sresponse = str_replace("__jp2(","",$sresponse);
            $results = json_decode($sresponse, true);

            $html = \View::make('parts.search-social-music', ['result' => $results])->render();

            $success = 1;
        }else{

            $errorMessage = 'Missing required data';
        }

        return json_encode(['success'=> $success, 'errorMessage' => $errorMessage, 'result' => $html]);
    }

    public function saveUserSmartLinks(Request $request){

        $success = '';
        $errorMessage = '';

        if(Auth::check()){

            $user = Auth::user();
            if($request->has('url') && $request->has('action') && $request->get('action') == 'add'){

                $user->music_smart_links_url = $request->get('url');
                $user->save();

                $success = 1;
            }else if( $request->has('action') && $request->get('action') == 'remove'){
                $user->music_smart_links_url = NULL;
                $user->save();

                $success = 1;
            }else{

                $errorMessage = 'Missing required data';
            }
        }else{
            $errorMessage = 'No user';
        }

        return json_encode(['success'=> $success, 'errorMessage' => $errorMessage]);
    }

    public function saveUserMusicPrivacy(Request $request){

        $success = '';
        $errorMessage = '';

        if(Auth::check()){

            $user = Auth::user();
            if($request->has('music_id') && $request->has('status') && $request->has('pin')){

                $musicId = $request->get('music_id');
                $status = $request->get('status') == '1' ? 1 : 0;
                $pin = $request->get('pin');

                $music = UserMusic::find($musicId);
                if($music && $music->user->id == $user->id){

                    $music->privacy = ['status' => $status, 'pin' => $pin];
                    $music->save();
                    $success = 1;
                }else{

                    $error = 'Data incorrect/unknown';
                }
            }else{

                $errorMessage = 'Missing required data';
            }
        }else{
            $errorMessage = 'No user';
        }

        return json_encode(['success'=> $success, 'errorMessage' => $errorMessage]);
    }

    public function saveUserMedia(Request $request){

        $success = 0;
        $errorMessage = '';
        $imageSrc = '';
        if(Auth::check()){
            $user = Auth::user();

            if($request->has('id')){

                $id = $request->get('id');
                if($id == 'custom_logo' && $request->hasFile('logo')){

                    $image = $request->file('logo');
                    $extention = $image->getClientOriginalExtension();
                    $allowedExtensions = ['jpg', 'png', 'jpeg'];

                    if(in_array($extention, $allowedExtensions)){

                        $imageName = "user-custom-logo-" . uniqid() . "." . $extention;
                        $imagePath = public_path('user-media/logo/').$imageName;
                        $result = Image::make($image)->save($imagePath,60);

                        if($user->custom_logo != '' && CommonMethods::fileExists(public_path('user-media/logo/').$user->custom_logo)){

                            unlink(public_path('user-media/logo/').$user->custom_logo);
                        }

                        $user->custom_logo = $imageName;
                        $user->save();

                        $success = 1;
                        $imageSrc = asset('user-media/logo/'.$user->custom_logo);
                    }else{
                        $errorMessage = 'Logo image format is not supported';
                    }
                }else if($id == 'custom_banner' && $request->hasFile('banner')){

                    $image = $request->file('banner');
                    $extention = $image->getClientOriginalExtension();
                    $allowedExtensions = ['jpg', 'png', 'jpeg'];

                    if(in_array($extention, $allowedExtensions)){

                        $imageName = "user-custom-banner-" . uniqid() . "." . $extention;
                        $imagePath = public_path('user-media/banner/').$imageName;
                        $result = Image::make($image)->save($imagePath,60);

                        if($user->custom_banner != '' && CommonMethods::fileExists(public_path('user-media/banner/').$user->custom_banner)){

                            unlink(public_path('user-media/banner/').$user->custom_banner);
                        }

                        $user->home_layout = 'banner';
                        $user->custom_banner = $imageName;
                        $user->save();

                        $success = 1;
                        $imageSrc = asset('user-media/banner/'.$user->custom_banner);
                    }else{
                        $errorMessage = 'Banner image format is not supported';
                    }
                }else if($id == 'custom_background' && $request->hasFile('background')){

                    $image = $request->file('background');
                    $extention = $image->getClientOriginalExtension();
                    $allowedExtensions = ['jpg', 'png', 'jpeg'];

                    if(in_array($extention, $allowedExtensions)){

                        $imageName = 'user-custom-background-'.uniqid().'.jpg';
                        $imagePath = public_path('user-media/background/').$imageName;
                        $result = Image::make($image)->save($imagePath,60,'jpg');

                        if($user->custom_background != '' && CommonMethods::fileExists(public_path('user-media/background/').$user->custom_background)){

                            unlink(public_path('user-media/background/').$user->custom_background);
                        }

                        $user->home_layout = 'background';
                        $user->custom_background = $imageName;
                        $user->save();

                        $success = 1;
                        $imageSrc = asset('user-media/background/'.$user->custom_background);
                    }else{
                        $errorMessage = 'Banner image format is not supported';
                    }
                }else if($id == 'unsub_logo' && $user->custom_logo != ''){
                    if(CommonMethods::fileExists(public_path('user-media/logo/').$user->custom_logo)){

                        unlink(public_path('user-media/logo/').$user->custom_logo);
                    }
                    $user->custom_logo = null;
                    $user->save();

                    $success = 1;
                }else if($id == 'unsub_banner' && $user->custom_banner != ''){
                    if(CommonMethods::fileExists(public_path('user-media/banner/').$user->custom_banner)){

                        unlink(public_path('user-media/banner/').$user->custom_banner);
                    }
                    $user->custom_banner = null;
                    $user->save();

                    $success = 1;
                }else{
                    $errorMessage = 'Your request is missing required data';
                }
            }else{
                $errorMessage = 'Insufficient data';
            }

        }else{

            $errorMessage = 'No user logged in';
        }
        return json_encode(['success'=> $success, 'errorMessage' => $errorMessage, 'image' => $imageSrc]);
    }

    public function saveUserHomeLayout(Request $request){

        $success = 0;
        $errorMessage = '';
        if(Auth::check()){
            $user = Auth::user();

            if($request->has('id')){

                $id = $request->get('id');
                if($id == 'h_l_standard_content'){

                    $user->home_layout = 'standard';
                    $user->save();
                    $success = 1;
                }else if($id == 'h_l_background_content'){

                    $user->home_layout = 'background';
                    $user->save();
                    $success = 1;
                }else if($id == 'h_l_banner_content'){

                    $user->home_layout = 'banner';
                    $user->save();
                    $success = 1;
                }else{
                    $errorMessage = 'Your request is missing required data';
                }
            }else{
                $errorMessage = 'Insufficient data';
            }

        }else{

            $errorMessage = 'No user logged in';
        }
        return json_encode(['success'=> $success, 'errorMessage' => $errorMessage]);
    }

    public function saveUserHomeLogo(Request $request){

        $success = 0;
        $errorMessage = '';
        if(Auth::check()){
            $user = Auth::user();

            if($request->has('id')){

                $id = $request->get('id');
                if($id == 'h_logo_standard_content'){

                    $user->home_logo = 'standard';
                    $user->save();
                    $success = 1;
                }else if($id == 'h_logo_custom_content'){

                    $user->home_logo = 'custom';
                    $user->save();
                    $success = 1;
                }else{
                    $errorMessage = 'Your request is missing required data';
                }
            }else{
                $errorMessage = 'Insufficient data';
            }

        }else{

            $errorMessage = 'No user logged in';
        }
        return json_encode(['success'=> $success, 'errorMessage' => $errorMessage]);
    }

    public function prepareZip(Request $request)
    {

        $success = 0;
        $downloadLink = '';
        $errorMessage = '';
        $cloudDownloads = '';

        if($request->has('type')){

            $commonMethods = new CommonMethods();
            $downloadAs = $request->has('download_as') ? $request->get('download_as') : uniquid();
            if($request->get('type') == 'music' && $request->has('user') && $request->has('checkout_item')){

                $userId = $request->get('user');
                $checkoutItemId = $request->get('checkout_item');
                $user = User::find($userId);
                $checkoutItem = InstantCheckoutItem::find($checkoutItemId);

                if($user !== null && $checkoutItem !== null && $checkoutItem->type == 'music'){

                    $music = UserMusic::find($checkoutItem->source_table_id);
                    if($music && $user->isBuyerOf('music', $music->id)){

                        if($checkoutItem->license != 'Personal Use Only'){

                            // dont create zip locally if license is not personal
                            $success = 1;
                            if(count($music->downloads)){
                                foreach ($music->downloads as $item) {
                                    $cloudDownloads .= '#'.$item['path'].'::'.$item['itemtype'].'::'.$item['size'].'::'.$item['source'].'::'.$item['dec_fname'];
                                }

                                if($checkoutItem->license_pdf != null){

                                    $dirName = strpos($checkoutItem->license, 'bespoke_') !== false ? 'bespoke-licenses/' : 'standard-licenses/';
                                    $licenseFile = strpos($checkoutItem->license, 'bespoke_') !== false ? asset($dirName.$checkoutItem->license_pdf) : asset($dirName.$checkoutItem->license_pdf);
                                    $cloudDownloads .= '#'.'::license::'.filesize(public_path($dirName.$checkoutItem->license_pdf)).'::local::'.$checkoutItem->license_pdf;
                                }
                            }
                        }else{

                            try{

                                $zipFileName = 'music_'.$checkoutItem->source_table_id.'.zip';
                                if($commonMethods->fileExists(public_path('user-music-downloads/'.$zipFileName))){
                                    unlink(public_path('user-music-downloads/'.$zipFileName));
                                }
                                $zip = new ZipArchive;
                                $publicDir = public_path();
                                if($zip->open($publicDir.'/user-music-downloads/'.$zipFileName, ZipArchive::CREATE) === TRUE){

                                    if($checkoutItem->stripeCheckout && $checkoutItem->stripeCheckout->user){

                                        $filename = $checkoutItem->stripeCheckout->user->name.' - 1Platform TV';
                                    }else{

                                        $filename = $checkoutItem->name.' - 1Platform TV';
                                    }

                                    $zip->addFile($publicDir.'/user-music-files/'.$checkoutItem->file_name, $checkoutItem->name.' - '.$filename.'.mp3');

                                    if($checkoutItem->license && $checkoutItem->license != ''){

                                        if(strpos($checkoutItem->license, 'bespoke_') !== false){
                                            $licExplodeId = explode('_', $checkoutItem->license);
                                            $chat = UserChat::find($licExplodeId[1]);
                                            $zip->addFile($publicDir.'/bespoke-licenses/'.$chat->agreement['filename'], 'Bespoke License.pdf');
                                        }else{
                                            $zip->addFile($publicDir.'/standard-licenses/'.$checkoutItem->license_pdf, 'License.pdf');
                                        }
                                    }

                                    if(count($checkoutItem->checkoutDetails)){
                                        foreach($checkoutItem->checkoutDetails as $key => $checkoutItemDetail){
                                            if($checkoutItemDetail->type == 'loop' && $commonMethods->fileExists(public_path('user-music-files/loops/'.$checkoutItemDetail->file_name))){
                                                $zip->addFile($publicDir.'/user-music-files/loops/'.$checkoutItemDetail->file_name, $checkoutItemDetail->name.' - '.$filename.'.mp3');
                                            }else if($checkoutItemDetail->type == 'stem' && $commonMethods->fileExists(public_path('user-music-files/stems/'.$checkoutItemDetail->file_name))){
                                                $zip->addFile($publicDir.'/user-music-files/stems/'.$checkoutItemDetail->file_name, $checkoutItemDetail->name.' - '.$filename.'.mp3');
                                            }
                                        }
                                    }
                                    $zip->close();

                                    $success = 1;
                                    $downloadLink = route('download.zip', ['dir' => 'user-music-downloads', 'fileName' => $zipFileName, 'downloadAs' => $downloadAs]);
                                }else{

                                    $errorMessage = 'Could not create a zip file';
                                }
                            }catch (\Exception $e) {
                                $errorMessage = $e->getMessage();
                            }
                        }
                    }else{
                        $errorMessage = 'You are not authorized';
                    }
                }else{
                    $errorMessage = 'Your request has incorrect data';
                }
            }else if($request->get('type') == 'album' && $request->has('user') && $request->has('checkout_item')){

                $userId = $request->get('user');
                $checkoutItemId = $request->get('checkout_item');
                $user = User::find($userId);
                $checkoutItem = InstantCheckoutItem::find($checkoutItemId);

                if($user !== null && $checkoutItem !== null && $checkoutItem->stripeCheckout->customer->id == $user->id && $checkoutItem->type == 'album'){

                    $zipFileName = 'album_'.$checkoutItem->source_table_id.'.zip';
                    if($commonMethods->fileExists(public_path('user-music-downloads/'.$zipFileName))){
                        unlink(public_path('user-music-downloads/'.$zipFileName));
                    }

                    try {

                        $zip = new ZipArchive;
                        $publicDir = public_path();
                        if($zip->open($publicDir.'/user-music-downloads/'.$zipFileName, ZipArchive::CREATE) === TRUE){

                            if(count($checkoutItem->checkoutDetails)){
                                foreach ($checkoutItem->checkoutDetails as $key => $checkoutItemDetail){
                                    if($checkoutItemDetail->type == 'music' && $commonMethods->fileExists(public_path('user-music-files/'.$checkoutItemDetail->file_name))){
                                        if($checkoutItem->stripeCheckout && $checkoutItem->stripeCheckout->user){
                                            $filenamee = $checkoutItemDetail->name.' - '.$checkoutItem->stripeCheckout->user->name.' - 1Platform TV.mp3';
                                        }else{
                                            $filenamee = $checkoutItemDetail->name.' - 1Platform TV.mp3';
                                        }

                                        $zip->addFile($publicDir.'/user-music-files/'.$checkoutItemDetail->file_name, $filenamee);
                                    }
                                }
                            }
                        }

                        $success = 1;
                        $downloadLink = route('download.zip', ['dir' => 'user-music-downloads', 'fileName' => $zipFileName, 'downloadAs' => $downloadAs]);
                    }catch(\Exception $e) {

                        $errorMessage = $e->getMessage();
                    }
                }else{
                    $errorMessage = 'Your request has incorrect data';
                }
            }else{
                $errorMessage = 'Your request has insufficient data';
            }
        }else{
            $errorMessage = 'Your request is missing data';
        }

        return json_encode(['success'=> $success, 'download_link'=> $downloadLink, 'errorMessage' => $errorMessage, 'cloud_download' => $cloudDownloads]);
    }

    public function downloadZip($dir, $fileName, $downloadAs)
    {

        $path = $dir.'/'.$fileName;

        $downloadAs = str_replace(" ","-", $downloadAs);

        $explodedFileName = explode(".", $fileName);

        header("Content-Length: " . filesize($path));

        header('Content-Type: application/octet-stream');

        header('Content-Disposition: attachment; filename='.$downloadAs.".".$explodedFileName[sizeof($explodedFileName) -1]);

        readfile($path);

        exit;
    }

    public function updateSellerSettings(Request $request){

        if ($request->isMethod('post')) {

            $user = Auth::user();
            $success = 0;
            $error = '';

            if($user && $request->has('username')){
                $username = $request->get('username');
                $duplication = User::where('id', '!=' , $user->id)->where('username', $username)->first();
                if($duplication){
                    $error = 'This username already exists';
                    $success = 0;
                }else{

                    $user->username = $username;
                    $user->save();
                    $success = 1;
                }
            }
            if($user && $request->has('currency')){
                $currency = $request->get('currency');
                $user->profile->default_currency = $currency;
                $user->profile->save();
                $success = 1;
            }
        }else{
            $error = 'inappropraite request';
        }

        return json_encode(array('success' => $success, 'error' => $error));
    }

    public function userHomeDefaultTab(Request $request){

        if ($request->isMethod('post')) {

            $user = Auth::user();
            $success = 0;
            $error = '';
            if($user && $request->has('data')){

                $id = $request->get('data');
                $user->default_tab_home = $id;
                $user->save();
                $success = 1;
            }else{
                $error = 'no/protected data';
            }
        }else{
            $error = 'inappropraite request';
        }

        return json_encode(array('success' => $success, 'error' => $error));
    }

    public function userHomeFeatureTab(Request $request){

        if ($request->isMethod('post')) {

            $user = Auth::user();
            $success = 0;
            $error = '';
            if($user && $request->has('data')){

                $id = $request->get('data');
                $user->feature_tab_home = $user->feature_tab_home == $id ? NULL : $id;
                $user->save();
                $success = 1;
            }else{
                $error = 'no/protected data';
            }
        }else{
            $error = 'inappropraite request';
        }

        return json_encode(array('success' => $success, 'error' => $error));
    }

    public function userHomeTabHideShow(Request $request){

        if ($request->isMethod('post')) {

            $user = Auth::user();
            $success = 0;
            $error = '';
            if($user && $request->has('data')){

                $id = $request->get('data');
                $value = $user->hidden_tabs_home;

                if($value && count($value) && in_array($id, $value)){

                    $pos = array_search($id, $value);
                    unset($value[$pos]);
                }else{

                    $value[] = $id;
                }

                $user->hidden_tabs_home = $value;
                $user->save();
                $success = 1;
            }else{
                $error = 'no/protected data';
            }
        }else{
            $error = 'inappropraite request';
        }

        return json_encode(array('success' => $success, 'error' => $error));
    }

    public function chatJoinAdmin(Request $request){

        $user = Auth::user();
        $success = 0;
        $error = '';
        $admins = Config('constants.admins');
        if($user && $user->id == $admins['masteradmin']['user_id'] && $request->has('pair')){

            $pair = $request->get('pair');
            $explode = explode(':', $pair);
            $userOne = User::find($explode[0]);
            $userTwo = User::find($explode[1]);

            if($userOne && $userTwo){

                $chat = new UserChat();
                $chat->admin_id = $user->id;
                $chat->admin_join_chat = 1;
                $chat->pair_user_one = $explode[0];
                $chat->pair_user_two = $explode[1];
                $chat->save();

                $success = 1;
            }else{

                $error = 'Users not found';
            }
        }else{
            $error = 'no/protected data';
        }

        return json_encode(array('success' => $success, 'error' => $error));
    }

    public function chatAdminSendMessage(Request $request){

        $success = 0;
        $error = '';

        if(Auth::check() && Auth::user()->id == 1){

            $user = Auth::user();
        }else{
            $error = 'No user';
            $user = null;
        }

        if($user){

            if($request->has('message') && $request->has('pair')){

                $message = $request->get('message');
                $pair = $request->get('pair');
                $type = $request->has('type') ? $request->get('type') : '';
                $explode = explode(':', $pair);

                if($error == ''){

                    $chat = new UserChat();
                    $chat->admin_id = $user->id;
                    $chat->pair_user_one = $explode[0];
                    $chat->pair_user_two = $explode[1];
                    $chat->message = $message;
                    $chat->music_id = null;

                    $chat->save();

                    $success = 1;
                }
            }else{

                $error = 'No/insufficient request data';
            }
        }

        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function getUserChatDetails(Request $request){

        $user = Auth::user();
        $success = 0;
        $preloadId = 0;
        $error = '';
        $data = ['partnersList' => '', 'partnerChat' => '', 'partnerActivityStatus' => ''];
        $commonMethods = new CommonMethods();
        $admins = Config('constants.admins');
        $partnerId = $partnerChatDate = $partnerChatNote = [];

        if($user && $request->has('action')){

            $action = $request->get('action');
            $conversation = $request->has('conversation') ? $request->get('conversation') : NULL;
            if($action == 'partners'){

                $userChatGroups = $user->chatGroups();

                $chats = UserChat::where(function($q) use ($user) {
                            $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id);
                        })->whereNull('group_id')->orderBy('id', 'desc')->get();
                if($chats->first()){

                    $partnerId = $partnerChatDate = $partnerChatNote = [];
                    foreach ($chats as $key => $chat) {

                        if($chat->recipient && $chat->recipient->id == $user->id){

                            if($chat->sender && !in_array($chat->sender->id, $partnerId) && $chat->recipient->id != $chat->sender->id){
                                $partnerId[] = $chat->sender->id;
                                $partnerChatDate[] = $chat->created_at;
                                $partnerChatNote[] = !$chat->agreement ? str_limit($chat->message, 24) : 'agreement';
                            }
                        }else if($chat->sender && $chat->sender->id == $user->id){
                            if($chat->recipient && !in_array($chat->recipient->id, $partnerId) && $chat->recipient->id != $chat->sender->id){
                                $partnerId[] = $chat->recipient->id;
                                $partnerChatDate[] = $chat->created_at;
                                $partnerChatNote[] = !$chat->agreement ? str_limit($chat->message, 24) : 'agreement';
                            }
                        }
                    }

                    if($user->apply_expert == 2 && $user->expert){
                        $agentContacts = AgentContact::where(['agent_id' => $user->id, 'approved' => 1])->get();
                        if(count($agentContacts)){
                            foreach ($agentContacts as $key => $contact) {
                                if($contact->contactUser)
                                $partnerId = array_diff($partnerId, [$contact->contactUser->id]);
                            }
                        }
                    }else{
                        $agentContact = AgentContact::where(['contact_id' => $user->id, 'approved' => 1])->first();
                        if($agentContact && $agentContact->agentUser){
                            if($agentContact->agentUser)
                            $partnerId = array_diff($partnerId, [$agentContact->agentUser->id]);
                        }else{
                            //$partnerId = array_diff($partnerId, [$admins['1platformagent']['user_id']]);
                        }
                    }
                }

                if($conversation && strrpos($conversation, 'group_') !== false){

                    $explode = explode('_', $conversation);
                    $preloadId = $explode[1];
                    if(in_array($preloadId, $userChatGroups)){
                        $groupChats = UserChat::where('group_id', $preloadId)->orderBy('id', 'desc')->take(20)->get()->reverse();
                        if(count($groupChats)){
                            foreach ($groupChats as $chat) {

                                if($chat->sender){
                                    $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $chat])->render();
                                }
                            }
                        }
                    }
                }else if($conversation && strrpos($conversation, 'partner_') !== false){

                	$explode = explode('_', $conversation);
                	$pchat = UserChat::find($explode[1]);
                	$preloadId = $pchat->recipient->id == $user->id ? $pchat->sender->id : $pchat->recipient->id;
                	if(in_array($preloadId, $partnerId)){
                	    $cchats = UserChat::where(function($q) use ($user) {
                	                $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id)->orWhere('pair_user_one', $user->id)->orWhere('pair_user_two', $user->id);
                	            })->where(function($q) use ($preloadId) {
                	                $q->where('sender_id', $preloadId)->orWhere('recipient_id', $preloadId)->orWhere('pair_user_one', $preloadId)->orWhere('pair_user_two', $preloadId);
                	            })->orderBy('id', 'desc')->take(20)->get()->reverse();
                	    if(count($cchats)){
                	        foreach ($cchats as $chat) {
                	            $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $chat])->render();
                	        }
                	    }
                	}
                }

                $userPersonalGroup = $user->personalGroup();
                if($data['partnerChat'] == '' && isset($userPersonalGroup) && $userPersonalGroup){

                    $groupChats = UserChat::where('group_id', $userPersonalGroup->id)->orderBy('id', 'desc')->take(20)->get()->reverse();
                    if(count($groupChats)){
                        foreach ($groupChats as $chat) {

                            if($chat->sender){
                                $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $chat])->render();
                                $seen = $chat->seen;
                                if(count($seen)){
                                    if(!in_array($user->id, $seen)){
                                        $seen[] = $user->id;
                                        $chat->seen = $seen;
                                        $chat->save();
                                    }
                                }else{
                                    $seen[] = $user->id;
                                    $chat->seen = $seen;
                                    $chat->save();
                                }
                            }
                        }
                    }
                }

                $groupFirst = 0;
                if(count($userChatGroups)){

                    foreach ($userChatGroups as $key3 => $groupId) {

                        if($userPersonalGroup && $userPersonalGroup->id == $groupId){
                            continue;
                        }

                        $groupFirst = $groupFirst == 0 ? 1 : 2;

                        $chatGroup = UserChatGroup::find($groupId);

                        $data['partnersList'] .= \View::make('parts.group-chat-partner', ['group' => $chatGroup, 'first' => $groupFirst, 'key' => $key3, 'firstEver' => $data['partnerChat'] == '' && $preloadId == 0 ? 1 : 0, 'commonMethods' => $commonMethods, 'length' => count($userChatGroups), 'preloadId' => $preloadId])->render();

                        if($key3 == 0 && $data['partnerChat'] == ''){
                            $groupChats = UserChat::where('group_id', $groupId)->orderBy('id', 'desc')->take(20)->get()->reverse();
                            if(count($groupChats)){
                                foreach ($groupChats as $chat) {

                                    if($chat->sender){
                                        $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $chat])->render();
                                    }
                                }
                            }
                        }

                    }
                }

                if(count($partnerId)){

                    foreach ($partnerId as $key => $value) {

                        $partner = User::find($value);
                        $data['partnersList'] .= \View::make('parts.chat-partner', ['user' => $partner, 'last' => $key === key(array_slice($partnerId, -1, 1, true)) ? 1 : 0, 'first' => $key === key($partnerId) ? 1 : 0, 'partnerChatDate' => $partnerChatDate[$key], 'partnerChatNote' => $partnerChatNote[$key], 'commonMethods' => $commonMethods, 'firstEver' => $data['partnerChat'] == '' && $preloadId == 0 ? 1 : 0, 'preloadId' => $preloadId])->render();
                        if($key === key($partnerId) && $data['partnerChat'] == ''){

                            $firstPartnerChats = UserChat::where(function($q) use ($user) {
                                        $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id)->orWhere('pair_user_one', $user->id)->orWhere('pair_user_two', $user->id);
                                    })->where(function($q) use ($partner) {
                                        $q->where('sender_id', $partner->id)->orWhere('recipient_id', $partner->id)->orWhere('pair_user_one', $partner->id)->orWhere('pair_user_two', $partner->id);
                                    })->orderBy('id', 'desc')->take(20)->get()->reverse();
                            if(count($firstPartnerChats)){

                                foreach ($firstPartnerChats as $firstPartnerChat) {

                                    $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $firstPartnerChat, 'partner' => $partner, 'commonMethods' => $commonMethods])->render();
                                }
                            }
                        }
                    }
                }

                if($data['partnerChat'] == ''){

                    $data['partnerChat'] .= '<div class="no_results">No messages yet</div>';
                }

                $success = 1;
            }else if($action == 'partner-chat' && $request->has('partner')){

                $partnerId = $request->get('partner');
                $cursor = $request->has('cursor') ? $request->get('cursor') : 0;
                if($partnerId == 'admin'){

                    $partnerId = 1;
                }else if($partnerId == 'agent'){

                    $subDetails = $user->internalSubscriptionDetails();
                    if($subDetails['status'] == 1 && $subDetails['name'] == 'platinum'){
                        $partnerId = $admins['1platformagent']['user_id'];
                    }else{
                        $partnerId = 0;
                    }
                }

                $partner = User::find($partnerId);
                if($partner){

                    $chats = UserChat::where(function($q) use ($user) {
                                $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id)->orWhere('pair_user_one', $user->id)->orWhere('pair_user_two', $user->id);
                            })->where(function($q) use ($partner) {
                                $q->where('sender_id', $partner->id)->orWhere('recipient_id', $partner->id)->orWhere('pair_user_one', $partner->id)->orWhere('pair_user_two', $partner->id);
                            })->where('id', '>', $cursor)->orderBy('id', 'desc')->take(20)->get()->reverse();
                    if($chats->first()){

                        foreach ($chats as $key => $chat) {

                            $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $chat])->render();
                        }
                    }
                    $success = 1;
                }else{
                    $success = 0;
                    $error = 'No partner known';
                }
            }else if($action == 'group-chat' && $request->has('group')){

                $groupId = $request->get('group');
                $group = UserChatGroup::find($groupId);
                $cursor = $request->has('cursor') ? $request->get('cursor') : 0;
                if($group){

                    if($group->contact && $group->agent){

                        $chats = UserChat::where('group_id', $groupId)->where('id', '>', $cursor)->orderBy('id', 'desc')->take(20)->get()->reverse();
                        if($chats->first()){

                            foreach ($chats as $key => $chat) {

                                if($chat->sender){
                                    $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $chat])->render();
                                    $seen = $chat->seen;
                                    if(count($seen)){
                                        if(!in_array($user->id, $seen)){
                                            $seen[] = $user->id;
                                            $chat->seen = $seen;
                                            $chat->save();
                                        }
                                    }else{
                                        $seen[] = $user->id;
                                        $chat->seen = $seen;
                                        $chat->save();
                                    }
                                }
                            }
                        }
                        $success = 1;
                    }else{
                        $success = 0;
                        $error = 'No agent/contact known';
                    }
                }else{
                    $success = 0;
                    $error = 'No group known';
                }
            }else if($action == 'admin_chat' && $user->id == $admins['masteradmin']['user_id']){

                $pairs = [];
                $counter = 0;
                $pairsCounter = 0;
                $data['adminJoinChat'] = '';
                $distictSenders = UserChat::select('sender_id')->distinct('sender_id')->whereNotNull('sender_id')->orderBy('id','desc')->get()->toArray();
                $distictRecipients = UserChat::select('recipient_id')->distinct('recipient_id')->whereNotNull('recipient_id')->orderBy('id','desc')->get()->toArray();
                if(count($distictSenders) && count($distictRecipients)){
                    foreach ($distictSenders as $key => $sender) {
                        $senderId = $sender['sender_id'];
                        foreach ($distictRecipients as $key2 => $recipient) {
                            $recipientId = $recipient['recipient_id'];
                            if($recipientId != $senderId){

                                if(!in_array($senderId.':'.$recipientId, $pairs) && !in_array($recipientId.':'.$senderId, $pairs)){
                                    $pairs[] = $senderId.':'.$recipientId;
                                }
                            }
                        }
                    }

                    foreach ($pairs as $key2 => $pair) {

                        $pairsCounter++;
                        $explode = explode(':',$pair);

                        $chats = UserChat::where(function($q) use ($explode) {
                                $q->where('sender_id', $explode[0])->orWhere('recipient_id', $explode[0])->orWhere('pair_user_one', $explode[0])->orWhere('pair_user_two', $explode[0]);
                            })->where(function($q) use ($explode) {
                                $q->where('sender_id', $explode[1])->orWhere('recipient_id', $explode[1])->orWhere('pair_user_one', $explode[1])->orWhere('pair_user_two', $explode[1]);
                            })->orderBy('id', 'asc')->get();
                        if(count($chats)){

                            foreach ($chats as $key => $chat) {

                                if(($chat->admin) || ($chat->sender && $chat->recipient)){

                                    if($key == 0){

                                        $data['partnersList'] .= \View::make('parts.admin-chat-partner', ['chat' => $chat, 'commonMethods' => $commonMethods, 'counter' => $counter])->render();
                                        $counter++;
                                    }

                                    if($pairsCounter == 1){

                                        $data['partnerChat'] .= \View::make('parts.admin-chat-partner-message', ['chat' => $chat])->render();
                                        if($chat->admin_join_chat){

                                            $data['adminJoinChat'] = 1;
                                        }
                                    }

                                }
                            }
                        }
                    }
                }

                $success = 1;
            }else if($action == 'admin-pair-chat' && $user->id == $admins['masteradmin']['user_id']){

                $data['adminJoinChat'] = '';
                $pair = $request->get('pair');
                $explode = explode(':',$pair);
                $chats = UserChat::where(function($q) use ($explode) {
                        $q->where('sender_id', $explode[0])->orWhere('recipient_id', $explode[0])->orWhere('pair_user_one', $explode[0])->orWhere('pair_user_two', $explode[0]);
                    })->where(function($q) use ($explode) {
                        $q->where('sender_id', $explode[1])->orWhere('recipient_id', $explode[1])->orWhere('pair_user_one', $explode[1])->orWhere('pair_user_two', $explode[1]);
                    })->orderBy('id', 'asc')->get();
                $pairS = User::find($explode[0]);
                $pairR = User::find($explode[1]);
                if(count($chats)){

                    foreach ($chats as $key => $chat) {

                        if(($chat->admin) || ($chat->sender && $chat->recipient)){

                            $data['partnerActivityStatus'] = $pairS->activityStatus().':'.$pairR->activityStatus();
                            $data['partnerChat'] .= \View::make('parts.admin-chat-partner-message', ['chat' => $chat])->render();
                            if($chat->admin_join_chat){

                                $data['adminJoinChat'] = 1;
                            }
                        }
                    }
                }
                $success = 1;
            }else if($action == 'previous-chat'){

            	$cursor = $request->has('cursor') ? $request->get('cursor') : 0;
            	$chat = UserChat::where(['id' => $cursor])->get()->first();
            	if($chat){

            		$group = $chat->group;
            		if($group){

            			if($group->contact && $group->agent){

            			    $chats = UserChat::where('group_id', $group->id)->where('id', '<', $cursor)->orderBy('id', 'desc')->take(20)->get()->reverse();
            			    if($chats->first()){

            			        foreach ($chats as $key => $chat) {

            			            if($chat->sender){
            			                $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $chat])->render();
            			            }
            			        }
            			    }
            			    $success = 1;
            			}
            		}else{

            			if($chat->recipient->id == $user->id){

            				$partnerId = $chat->sender->id;
            			}else if($chat->sender->id == $user->id){

            				$partnerId = $chat->recipient->id;
            			}else{
            				$partnerId = 0;
            			}

            			$partner = User::find($partnerId);
            			if($partner){

            			    $chats = UserChat::where(function($q) use ($user) {
            			                $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id)->orWhere('pair_user_one', $user->id)->orWhere('pair_user_two', $user->id);
            			            })->where(function($q) use ($partner) {
            			                $q->where('sender_id', $partner->id)->orWhere('recipient_id', $partner->id)->orWhere('pair_user_one', $partner->id)->orWhere('pair_user_two', $partner->id);
            			            })->where('id', '<', $cursor)->orderBy('id', 'desc')->take(20)->get()->reverse();
            			    if($chats->first()){

            			        foreach ($chats as $key => $chat) {

            			            $data['partnerChat'] .= \View::make('parts.chat-partner-message', ['chat' => $chat])->render();
            			        }
            			    }
            			    $success = 1;
            			}
            		}
            	}
            }else{
                $error = 'bad request data';
            }
        }else{
            $error = 'no or missing request data';
        }

        return json_encode(array('success' => $success, 'error' => $error, 'data' => $data));
    }

    public function restricted(Request $request)
    {
        if(Auth::check()){

            $data = [

            ];

            return view( 'pages.restricted', $data );
        }else{

            return redirect('login');
        }
    }

    public function stripeWebhook(Request $request){

        require_once(app_path().'/includes/stripe2/stripe-php-7/init.php');

        \Stripe\Stripe::setApiKey(Config('constants.stripe_key_secret'));
        $endpoint_secret = Config('constants.stripe_webhook_secret');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'charge.succeeded':

                $commonMethods = new CommonMethods();
                $charge = $event->data->object;

                break;
            case 'balance.available':

                $commonMethods = new CommonMethods();
                $balance = $event->data->object;
                $balanceAmount = $balance['available'][0]['amount'];
                $balanceDynamic = $balanceAmount;
                if($balanceAmount > 0){
                    $agentTransfers = AgentTransfer::whereNull('status')->where('amount', '>', 0)->get();
                    if(count($agentTransfers)){
                        foreach ($agentTransfers as $key => $agentTransfer) {
                            $agent = User::find($agentTransfer->agent_id);
                            if($agent && $agent->expert && $agent->apply_expert == 2 && $agent->profile->stripe_user_id != ''){
                                if($balanceDynamic >= $agentTransfer->amount && $agentTransfer->stripe_application_fee_id){

                                    //first make sure the platform has not refunded the source application fee
                                    $url = 'https://api.stripe.com/v1/application_fees/'.$agentTransfer->stripe_application_fee_id;
                                    $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                                    $fields = [];
                                    $fee = $commonMethods->stripeCall($url, $headers, $fields, 'GET');
                                    if(!$fee['refunded']){

                                        $url = 'https://api.stripe.com/v1/transfers';
                                        $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                                        $fields = [
                                            'amount' => $agentTransfer->amount,
                                            'currency' => $agentTransfer->currency,
                                            'destination' => $agent->profile->stripe_user_id,
                                            'description' => $agentTransfer->description,
                                        ];
                                        $transfer = $commonMethods->stripeCall($url, $headers, $fields);
                                        if(isset($transfer['id']) && isset($transfer['amount']) && $transfer['amount'] > 0){
                                            $agentTransfer->status = 1;
                                            $agentTransfer->stripe_transfer_id = $transfer['id'];
                                            $agentTransfer->save();

                                            $balanceDynamic = $balanceDynamic - $agentTransfer->amount;
                                        }else{
                                            $agentTransfer->error = 'Transfer error';
                                            $agentTransfer->save();
                                        }
                                    }else{
                                        $agentTransfer->error = 'Application fee has been refunded';
                                        $agentTransfer->save();
                                    }
                                }else{
                                    $agentTransfer->error = 'Balance is insufficient';
                                    $agentTransfer->save();
                                }
                            }else{
                                $agentTransfer->error = 'Agent problems';
                                $agentTransfer->save();
                            }
                        }
                    }
                }
                break;
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }

        http_response_code(200);
    }

    public function solvePriceDisparity(Request $request){

        if($request->isMethod('post') && $request->has('id') && $request->has('type')){

            $success = 0;
            $error = '';
            $data = ['success' => 0, 'error' => ''];
            $id = $request->get('id');
            $type = $request->get('type');

            $customerBasket = CustomerBasket::find($id);
            if($customerBasket){

                if($type == 'update_price'){

                    $actualPrice = $customerBasket->itemOriginalPrice();
                    if(is_numeric($actualPrice)){
                        $customerBasket->price = $actualPrice;
                        $customerBasket->save();
                        $data['success'] = 1;
                    }else{
                        $data['error'] = 'incorrect actual price';
                    }
                }else if($type == 'remove'){

                    $customerBasket->delete();
                    $data['success'] = 1;
                }else{
                    $data['error'] = 'unknown parameters';
                }
            }else{
                $data['error'] = 'no basket item';
            }
        }else{
            $data['error'] = 'inappropraite request';
        }

        return json_encode($data);
    }

    public function postInstantPayment(Request $request){

        $commonMethods = new CommonMethods();
        $success = 0;
        $error = '';
        $redirectUrl = '';
        if($request->has('id') && $request->get('id') != ''){

            $chatId = $request->get('id');
            $chat = UserChat::find($chatId);
            if($chat && $chat->sender && $chat->sender->profile->stripe_user_id != ''){

                if($request->has('intent')){
                    $intentId = $request->get('intent');
                    $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                    array_push($headers, 'Stripe-Account: '.$chat->sender->profile->stripe_user_id);

                    $url = 'https://api.stripe.com/v1/payment_intents/'.$intentId;
                    $fields = [];
                    $paymentIntent = $commonMethods->stripeCall($url, $headers, $fields, 'GET');
                    if($paymentIntent && isset($paymentIntent['id']) && isset($paymentIntent['metadata']['ReferenceID']) && $paymentIntent['metadata']['ReferenceID'] == $chatId && $paymentIntent['status'] == 'succeeded'){

                        $metaData = $paymentIntent['metadata'];
                        $sellerId = $metaData['Seller'];
                        $buyerId = $metaData['Buyer'];
                        $agentId = $metaData['Agent'];
                        $agentTwoId = $metaData['AgentTwo'] != 'None' ? $metaData['AgentTwo'] : NULL;
                        $platformShare = $metaData['1PlatformShare'];
                        $agentShare = $metaData['AgentShare'];
                        $agentTwoShare = $metaData['AgentTwoShare'] != 'None' ? $metaData['AgentTwoShare'] : 0;

                        $buyer = User::find($buyerId);
                        $seller = User::find($sellerId);
                        $agent = User::find($agentId);
                        $agentTwo = $agentTwoId ? User::find($agentTwoId) : NULL;
                        $agentContact = AgentContact::where(['contact_id' => $seller->id, 'agent_id' => $agent->id])->first();
                        $buyerContact = $agentTwo ? AgentContact::where(['contact_id' => $buyer->id, 'agent_id' => $agentTwo->id])->first() : NULL;

                        if(isset($paymentIntent['charges']) && isset($paymentIntent['charges']['data'][0])){
                            $charge = $paymentIntent['charges']['data'][0];
                            $applicationFeeId = $charge['application_fee'];
                        }else{
                            $applicationFeeId = NULL;
                            $charge['id'] = NULL;
                        }

                        if($chat->agreement != NULL){
                            $details = $chat->agreement;
                            $type = 'music';
                            $music = UserMusic::find($details['music']);
                        }else if($chat->project != NULL){
                            $details = $chat->project;
                            $type = 'project';
                        }else{
                            $details = $chat->product;
                            $type = 'proferred-product';
                        }
                        $itemTitle = $type == 'music' ? 'Bespoke License' : $details['title'];

                        $totalPrice = $paymentIntent['amount']/100;
                        $totalApplicationFee = $paymentIntent['application_fee_amount']/100;
                        $currSym = $commonMethods->getCurrencySymbol(strtoupper($seller->profile->default_currency));

                        if($agent && $agentShare > 0){
                            $agentTransferDetails = 'Agent instant checkout fee from seller. Agent: '.$agent->id.' - '.$agent->name.' - '.$currSym.$agentShare.' @'.$agentContact->commission.'%'.'. Buyer: '.$buyer->id.' - '.$buyer->name.'. Seller: '.$seller->id.' - '.$seller->name.'. Charge: '.$charge['id'].'. Application Fee: '.$applicationFeeId;
                            $agentTransfer = new AgentTransfer();
                            $agentTransfer->agent_id = $agent->id;
                            $agentTransfer->type = 'chat-instant';
                            $agentTransfer->amount = round($agentShare * 100);
                            $agentTransfer->currency = $seller->profile->default_currency;
                            $agentTransfer->description = $agentTransferDetails;
                            $agentTransfer->stripe_application_fee_id = $applicationFeeId;
                            $agentTransfer->save();
                        }

                        if($agentTwo && $agentTwoShare > 0){
                            $agentTransferDetails = 'Agent two instant checkout fee from seller. Agent: '.$agent->id.' - '.$agent->name.' - '.$currSym.$agentShare.'. Agent Two: '.$agentTwo->id.' - '.$agentTwo->name.' - '.$currSym.$agentTwoShare.' @50%'.'. Buyer: '.$buyer->id.' - '.$buyer->name.'. Seller: '.$seller->id.' - '.$seller->name.'. Charge: '.$charge['id'].'. Application Fee: '.$applicationFeeId;
                            $agentTransfer = new AgentTransfer();
                            $agentTransfer->agent_id = $agentTwo->id;
                            $agentTransfer->type = 'chat-instant';
                            $agentTransfer->amount = round($agentTwoShare * 100);
                            $agentTransfer->currency = $seller->profile->default_currency;
                            $agentTransfer->description = $agentTransferDetails;
                            $agentTransfer->stripe_application_fee_id = $applicationFeeId;
                            $agentTransfer->save();
                        }

                        $buyerDetails = $commonMethods->getUserRealDetails($buyer->id);

                        $stripeCheckOut = new StripeCheckout();
                        $stripeCheckOut->user_id = $seller->id;
                        $stripeCheckOut->customer_id = $buyer->id;
                        $stripeCheckOut->user_name = $seller->name;
                        $stripeCheckOut->customer_name = $buyer->name;
                        $stripeCheckOut->amount = $totalPrice;
                        $stripeCheckOut->currency = strtoupper($seller->profile->default_currency);
                        $stripeCheckOut->type = 'instant';
                        $stripeCheckOut->stripe_charge_id = $charge['id'];
                        $stripeCheckOut->stripe_payment_id = $paymentIntent['id'];
                        $stripeCheckOut->application_fee = $totalApplicationFee;
                        $stripeCheckOut->name = $buyer->name;
                        $stripeCheckOut->email = $buyer->email;
                        $stripeCheckOut->city = $buyerDetails['city'];
                        $stripeCheckOut->address = $buyerDetails['address'];
                        $stripeCheckOut->country = $buyerDetails['country'];
                        $stripeCheckOut->postcode = $buyerDetails['postcode'];
                        $stripeCheckOut->comment = NULL;
                        $stripeCheckOut->save();

                        $userNotification = new UserNotificationController();
                        $request->request->add(['user' => $seller->id, 'customer' => $buyer->id, 'type' => 'sale', 'source_id' => $stripeCheckOut->id]);
                        $response = json_decode($userNotification->create($request), true);

                        $instantCheckoutItem = new InstantCheckoutItem();
                        $instantCheckoutItem->stripe_checkout_id = $stripeCheckOut->id;
                        $instantCheckoutItem->type = $type;
                        $instantCheckoutItem->price = $totalPrice;
                        if($type == 'music'){
                            $instantCheckoutItem->name = $music->song_name;
                            $instantCheckoutItem->source_table_id = $music->id;
                            $instantCheckoutItem->description = $music->album_name;
                            $instantCheckoutItem->file_name = $music->music_file;
                            $instantCheckoutItem->license = 'bespoke_'.$chat->id;
                            $instantCheckoutItem->license_pdf = $details['filename'];
                        }else if($type == 'project'){
                            $instantCheckoutItem->name = $details['title'];
                            $instantCheckoutItem->description = $chat->message;
                            $instantCheckoutItem->file_name = $details['filename'];
                        }else if($type == 'proferred-product'){
                            $instantCheckoutItem->name = $details['title'];
                            $instantCheckoutItem->file_name = $details['filename'];
                        }
                        $instantCheckoutItem->save();

                        if($type == 'music' && $music !== null && is_array($music->loops) && count($music->loops)){
                            foreach ($music->loops as $loop) {
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
                        if($type == 'music' && $music !== null && is_array($music->stems) && count($music->stems)){
                            foreach ($music->stems as $stem) {
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

                        $result = Mail::to($seller->email)->bcc(Config('constants.bcc_email'))->send(new InstantCheckout('seller', $stripeCheckOut));
                        $buyerArray = ['customer' => $buyer, 'user' => $seller, 'bcc' => Config('constants.bcc_email'), 'type' => $type, 'filename' => $details['filename']];
                        $buyerObj = (object) $buyerArray;
                        $item = ['type' => $type, 'title' => $itemTitle, 'price' => $details['price'], 'currSym' => $currSym];
                        $result =  Mail::send('pages.email.basket-buyer-email', ['customer' => $buyer, 'user' => $seller, 'item' => $item, 'checkout' => $stripeCheckOut], function ($m) use ($buyerObj){

                            $m->from(Config('constants.from_email'), '1PlatformTV');
                            $m->bcc($buyerObj->bcc);
                            $m->to($buyerObj->customer->email, $buyerObj->customer->name);
                            if($buyerObj->type == 'music'){
                                $m->attach(public_path('bespoke-licenses/'.$buyerObj->filename));
                            }
                            if($buyerObj->type == 'project'){
                                $m->attach(public_path('proffered-project/'.$buyerObj->filename));
                            }
                            if($buyerObj->type == 'proferred-product'){
                                $m->attach(public_path('proffered-product/'.$buyerObj->filename));
                            }
                            $m->subject('Your Order at 1Platform');
                        });

                        $message = 'Successfully sent money to ' . $seller->name;
                        Session::flash('success', $message);
                        Session::flash('page', 'orders');
                        $redirectUrl = route('profile');

                        if(count($seller->devices)){

                            foreach ($seller->devices as $device) {

                                if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                                    $fcm = new PushNotificationController();
                                    $return = $fcm->send($device->device_id, 'New sale from '.$buyer->firstName(), str_limit('Item purchased from your chat store', 24), $device->platform);
                                }
                            }
                        }

                        $success = 1;
                    }else{
                        $error = 'Payment Intent Error';
                    }
                }else if($request->has('free')){


                }else{
                    $error = 'Free Error';
                }
            }else{
                $error = 'Invalid data';
            }
        }else if($request->has('seller') && $request->has('intent')){

            $seller = User::find($request->get('seller'));
            if($seller && $seller->profile->stripe_user_id != ''){
                $intentId = $request->get('intent');
                $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                array_push($headers, 'Stripe-Account: '.$seller->profile->stripe_user_id);

                $url = 'https://api.stripe.com/v1/payment_intents/'.$intentId;
                $fields = [];
                $paymentIntent = $commonMethods->stripeCall($url, $headers, $fields, 'GET');
                if($paymentIntent && isset($paymentIntent['id']) && isset($paymentIntent['metadata']['ReferenceID']) && $paymentIntent['status'] == 'succeeded'){

                    $metaData = $paymentIntent['metadata'];
                    $sellerId = $metaData['Seller'];
                    $buyerId = $metaData['Buyer'];
                    $productId = $metaData['ReferenceID'];
                    $customProductId = $metaData['CustomProduct'];
                    $platformShare = $metaData['1PlatformShare'];
                    $deliveryCost = $metaData['DeliveryCost'];
                    $deliveryCostType = $metaData['DeliveryCostType'];
                    $sellerShare = $metaData['SellerShare'];
                    $stripeFee = $metaData['StripeFee'];
                    $quantity = $metaData['Quantity'];
                    $color = $metaData['Color'];
                    $size = $metaData['Size'];
                    $totalPrice = $paymentIntent['amount']/100;

                    $buyer = $buyerId ? User::find($buyerId) : NULL;
                    $seller = User::find($sellerId);
                    $product = UserProduct::find($productId);
                    $customProduct = CustomProduct::find($customProductId);
                    $currSym = $commonMethods->getCurrencySymbol(strtoupper($seller->profile->default_currency));

                    if(isset($paymentIntent['charges']) && isset($paymentIntent['charges']['data'][0])){
                        $charge = $paymentIntent['charges']['data'][0];
                        $applicationFeeId = $charge['application_fee'];
                    }else{
                        $applicationFeeId = NULL;
                        $charge['id'] = NULL;
                    }

                    $stripeCheckOut = new StripeCheckout();
                    $stripeCheckOut->user_id = $seller->id;
                    $stripeCheckOut->customer_id = $buyer ? $buyer->id : 0;
                    $stripeCheckOut->user_name = $seller->name;
                    $stripeCheckOut->customer_name = $buyer ? $buyer->name : $metaData['Name'];
                    $stripeCheckOut->amount = $totalPrice;
                    $stripeCheckOut->currency = strtoupper($seller->profile->default_currency);
                    $stripeCheckOut->type = 'custom-product';
                    $stripeCheckOut->stripe_fee = $stripeFee;
                    $stripeCheckOut->stripe_charge_id = $charge['id'];
                    $stripeCheckOut->stripe_payment_id = $paymentIntent['id'];
                    $stripeCheckOut->application_fee = $platformShare;
                    $stripeCheckOut->delivery_cost = $deliveryCost;
                    $stripeCheckOut->delivery_cost_type = $deliveryCostType;
                    $stripeCheckOut->name = $metaData['Name'];
                    $stripeCheckOut->email = $metaData['Email'];
                    $stripeCheckOut->city = $metaData['City'];
                    $stripeCheckOut->address = $metaData['Address'];
                    $stripeCheckOut->country = $metaData['Country'];
                    $stripeCheckOut->postcode = $metaData['Postcode'];
                    $stripeCheckOut->comment = NULL;
                    $stripeCheckOut->save();

                    $userNotification = new UserNotificationController();
                    $request->request->add(['user' => $seller->id, 'customer' => ($buyer ? $buyer->id : 0), 'type' => 'sale', 'source_id' => $stripeCheckOut->id]);
                    $response = json_decode($userNotification->create($request), true);

                    $instantCheckoutItem = new InstantCheckoutItem();
                    $instantCheckoutItem->stripe_checkout_id = $stripeCheckOut->id;
                    $instantCheckoutItem->type = 'custom-product';
                    $instantCheckoutItem->price = $totalPrice;
                    $instantCheckoutItem->quantity = $quantity;
                    $instantCheckoutItem->color = $color != 'None' ? $color : NULL;
                    $instantCheckoutItem->size = $size;
                    $instantCheckoutItem->name = $product->title;
                    $instantCheckoutItem->source_table_id = $product->id;
                    $instantCheckoutItem->description = $product->description;
                    $instantCheckoutItem->save();

                    $result = Mail::to($seller->email)->bcc(Config('constants.bcc_email'))->send(new InstantCheckout('seller', $stripeCheckOut));
                    $buyerArray = ['customer' => $buyer, 'user' => $seller, 'bcc' => Config('constants.bcc_email'), 'type' => 'custom-product', 'filename' => '', 'shippingemail' => $metaData['Email'], 'shippingname' => $metaData['Name']];
                    $buyerObj = (object) $buyerArray;
                    $item = ['type' => 'custom-product', 'title' => $product->title, 'price' => $totalPrice, 'currSym' => $currSym, 'quantity' => $quantity, 'color' => $color, 'size' => $size];
                    $result =  Mail::send('pages.email.basket-buyer-email', ['customer' => $buyer, 'user' => $seller, 'item' => $item, 'checkout' => $stripeCheckOut], function ($m) use ($buyerObj){

                        $m->from(Config('constants.from_email'), '1PlatformTV');
                        $m->bcc($buyerObj->bcc);
                        $m->to($buyerObj->customer ? $buyerObj->customer->email: $buyerObj->shippingemail, $buyerObj->customer ? $buyerObj->customer->name : $buyerObj->shippingname);
                        $m->subject('Your Order at 1Platform');
                    });
                    $result = Mail::to(config('constants.admin_email'))->bcc(Config('constants.bcc_email'))->send(new InstantCheckout('admin', $stripeCheckOut));

                    $message = 'Successfully sent money to ' . $seller->name;
                    Session::flash('success', $message);
                    Session::flash('page', 'orders');
                    $redirectUrl = Auth::check() ? route('profile') : route('user.home',['params' => $seller->username]);

                    if(count($seller->devices)){

                        foreach ($seller->devices as $device) {

                            if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                                $fcm = new PushNotificationController();
                                $return = $fcm->send($device->device_id, 'New sale from '.$buyer->firstName(), str_limit('Item purchased from your online store', 24), $device->platform);
                            }
                        }
                    }

                    $success = 1;
                }else{
                    $error = 'Payment Intent Error';
                }
            }else{

                $error = 'No valid seller found';
            }
        }else{
            $error = 'No Data';
        }

        echo json_encode(['success' => $success, 'error' => $error, 'url' => $redirectUrl]);
    }

    public function prepareInstantPayment(Request $request){

        $totalAmount = 0;
        $commonMethods = new CommonMethods();

        if($request->has('id') && $request->get('id') != ''){

            $chatId = $request->get('id');
            $chat = UserChat::find($chatId);

            $paymentDet = $this->verifyInstantPaymentAndGetData('chat', $chat->id);
            if($paymentDet && is_array($paymentDet)){

                $paymentData = (object) $paymentDet;
                $seller = User::find($paymentData->sellerId);
                $buyer = User::find($paymentData->buyerId);
                $agent = User::find($paymentData->agentId);
                $agentTwo = $paymentData->agentTwoId ? User::find($paymentData->agentTwoId) : NULL;
                $agentContact = $paymentData->agentContactId ? AgentContact::find($paymentData->agentContactId) : NULL;
                $buyerContact = $paymentData->buyerContactId ? AgentContact::find($paymentData->buyerContactId) : NULL;
            }else{
                http_response_code(500);
                return json_encode(['error' => 'verification error']);
            }

            if($chat->agreement != NULL){
                $details = $chat->agreement;
            }else if($chat->project != NULL){
                $details = $chat->project;
            }else{
                $details = $chat->product;
            }


            try{

                $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                array_push($headers, 'Stripe-Account: '.$seller->profile->stripe_user_id);
                $createPaymentIntent = 1;

                $fee = $paymentData->platformShare + $paymentData->agentShare;
                if($paymentData->agentTwoShare){
                    $fee += $paymentData->agentTwoShare;
                }

                $metaData = [
                    'Buyer' => $buyer->id,
                    'Seller' => $seller->id,
                    'Agent' => $agent->id,
                    'AgentTwo' => $agentTwo ? $agentTwo->id : 'None',
                    '1PlatformShare' => $paymentData->platformShare,
                    'AgentShare' => $paymentData->agentShare,
                    'AgentTwoShare' => $paymentData->agentTwoShare ? $paymentData->agentTwoShare : 'None',
                    'ReferenceID' => $chatId,
                    'Type' => 'Chat Instant',
                ];

                $existingIntentId = $chat->payment_intent_id;
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
                if(!$createPaymentIntent){

                    $url = 'https://api.stripe.com/v1/payment_intents/'.$existingIntentId;
                    $fields = [
                        'amount' => $details['price']*100,
                        'currency' => $seller->profile->default_currency,
                        'application_fee_amount' => intval($fee*100),
                        'metadata' => $metaData
                    ];
                    $paymentIntent = $commonMethods->stripeCall($url, $headers, $fields);
                    if(isset($paymentIntent['error'])){
                        http_response_code(500);
                        return json_encode(['error' => $paymentIntent['error']['message']]);
                    }
                }else{

                    $url = 'https://api.stripe.com/v1/payment_intents';
                    $fields = [
                        'amount' => $details['price']*100,
                        'currency' => $seller->profile->default_currency,
                        'application_fee_amount' => intval($fee*100),
                        'payment_method_types' => ['card'],
                        'metadata' => $metaData
                    ];
                    $paymentIntent = $commonMethods->stripeCall($url, $headers, $fields);
                    if(isset($paymentIntent['error'])){
                        http_response_code(500);
                        return json_encode(['error' => $paymentIntent['error']['message']]);
                    }else{
                        $chat->payment_intent_id = $paymentIntent['id'];
                        $chat->save();
                    }
                }
                $output = [
                    'clientSecret' => $paymentIntent['client_secret'],
                    'seller' => $seller->id,
                ];
                return json_encode($output);
            }catch(\Exception $e){
                http_response_code(500);
                return json_encode(['error' => $e->getMessage()]);
            }
        }else if($request->has('metaData')){

            $data = $request->get('metaData');
            if(isset($data['type']) && $data['type'] == 'custom_product'){

                $paymentDet = $this->verifyInstantPaymentAndGetData($data['type'], $data['product'].'_'.$data['quantity'].'_'.$data['countryCode'].'_'.$data['shipping_country']);

                $seller = User::find($paymentDet['sellerId']);
                $buyer = $paymentDet['buyerId'] ? User::find($paymentDet['buyerId']) : NULL;
                $product = UserProduct::find($paymentDet['productId']);

                $metaData = [
                    'Buyer' => $buyer ? $buyer->id : 0,
                    'Seller' => $seller->id,
                    'CustomProduct' => $product->customProduct()->id,
                    '1PlatformShare' => $paymentDet['platformShare'],
                    'SellerShare' => $paymentDet['sellerShare'],
                    'DeliveryCost' => $paymentDet['deliveryCost'],
                    'DeliveryCostType' => $paymentDet['deliveryCostType'],
                    'StripeFee' => $paymentDet['stripeFee'],
                    'Currency' => $seller->profile->default_currency,
                    'ReferenceID' => $product->id,
                    'Quantity' => $data['quantity'],
                    'Color' => isset($data['color']) ? $data['color'] : 'None',
                    'Size' => isset($data['size']) ? $data['size'] : 'None',
                    'Name' => $data['shipping_name'],
                    'Email' => $data['shipping_email'],
                    'Address' => $data['shipping_address'],
                    'City' => $data['shipping_city'],
                    'Postcode' => $data['shipping_postcode'],
                    'Country' => $data['shipping_country'],
                    'Type' => 'Custom Product',
                ];

                $url = 'https://api.stripe.com/v1/payment_intents';
                $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                array_push($headers, 'Stripe-Account: '.$seller->profile->stripe_user_id);
                $fields = [
                    'amount' => $paymentDet['total']*100,
                    'currency' => $seller->profile->default_currency,
                    'application_fee_amount' => intval(($paymentDet['platformShare']+$paymentDet['deliveryCost'])*100),
                    'payment_method_types' => ['card'],
                    'metadata' => $metaData
                ];
                $paymentIntent = $commonMethods->stripeCall($url, $headers, $fields);
                if(isset($paymentIntent['error'])){
                    http_response_code(500);
                    return json_encode(['error' => $paymentIntent['error']['message']]);
                }

                $output = [
                    'clientSecret' => $paymentIntent['client_secret'],
                    'seller' => $seller->id,
                ];

                return json_encode($output);
            }else{

                http_response_code(500);
                return json_encode(['error' => 'no or invalid data']);
            }
        }else{
            http_response_code(500);
            return json_encode(['error' => 'no or invalid data']);
        }
    }

    public function chatHasPaybleItem($chatId){

        $chat = UserChat::find($chatId);
        if($chat && $chat->sender && $chat->recipient && $chat->group && $chat->group->agent && $chat->sender->profile->stripe_user_id != '' && ($chat->agreement != NULL || $chat->project != NULL || $chat->product != NULL)){

            $seller = $chat->sender;
            $buyer = $chat->recipient;
            $agent = $chat->group->agent;
            $agentTwo = $chat->group->otherAgent;
            $agentContact = AgentContact::where(['contact_id' => $seller->id, 'agent_id' => $agent->id])->first();
            if(!$agentContact && $agentTwo){
                $agentContact = AgentContact::where(['contact_id' => $seller->id, 'agent_id' => $agentTwo->id])->first();
                $agent = $chat->group->otherAgent;
                $agentTwo = $chat->group->agent;
            }
            if($agentTwo){
                $buyerContact = AgentContact::where(['contact_id' => $buyer->id, 'agent_id' => $agentTwo->id])->first();
                if(!$buyerContact || $agentTwo->profile->stripe_user_id == ''){
                    $agentTwo = NULL;
                }
            }
            $agentExpert = Expert::where(['user_id' => $agent->id])->first();
            if(($agentContact || $seller->id == $agent->id) && $agentExpert){

                return [
                    'seller' => $seller,
                    'buyer' => $buyer,
                    'agent' => $agent,
                    'agentTwo' => $agentTwo,
                    'agentContact' => $agentContact,
                    'buyerContact' => isset($buyerContact) ? $buyerContact : NULL,
                    'chat' => $chat,
                ];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function verifyInstantPaymentAndGetData($mode, $id){

        $commonMethods = new CommonMethods();

        if($mode == 'chat'){

            $chatId = $id;
            $chatDet = $this->chatHasPaybleItem($chatId);
            if($chatDet && is_array($chatDet)){

                $chatDetails = (object) $chatDet;
                if($chatDetails->chat->agreement != NULL){
                    $details = $chatDetails->chat->agreement;
                }else if($chatDetails->chat->project != NULL){
                    $details = $chatDetails->chat->project;
                }else{
                    $details = $chatDetails->chat->product;
                }

                $totalPrice = $details['price'];
                $platformFromSeller = $totalPrice * (3/100);
                $agentFromSeller = $chatDetails->agentContact && $chatDetails->agentContact->commission ? $totalPrice * ($chatDetails->agentContact->commission/100) : 0;
                $agentFinalShare = $chatDetails->buyer->id == $chatDetails->agent->id ? 0 : $agentFromSeller;

                if($chatDetails->agentTwo && $chatDetails->buyerContact){
                    $agentTwoFinalShare = $agentFinalShare * (50/100);
                    $agentFinalShare = $agentFinalShare - $agentTwoFinalShare;
                    $agentTwoExpert = $chatDetails->agentTwo->expert;
                    $platformFromAgentTwo = $agentTwoFinalShare * ($agentTwoExpert->commission/100);
                    $agentTwoFinalShare = $agentTwoFinalShare - $platformFromAgentTwo;
                }

                $platformFromAgent = $chatDetails->agent->expert->commission ? $agentFinalShare * ($chatDetails->agent->expert->commission/100) : 0;
                $agentFinalShare = $agentFinalShare - $platformFromAgent;

                $platformFinalShare = $platformFromSeller + $platformFromAgent;
                if(isset($platformFromAgentTwo)){
                    $platformFinalShare = $platformFinalShare + $platformFromAgentTwo;
                }

                return [
                    'platformShare' => $platformFinalShare,
                    'agentShare' => $agentFinalShare,
                    'agentTwoShare' => isset($agentTwoFinalShare) ? $agentTwoFinalShare : NULL,
                    'sellerId' => $chatDetails->seller->id,
                    'buyerId' => $chatDetails->buyer->id,
                    'agentId' => $chatDetails->agent->id,
                    'agentTwoId' => $chatDetails->agentTwo ? $chatDetails->agentTwo->id : NULL,
                    'agentContactId' => $chatDetails->agentContact ? $chatDetails->agentContact->id : NULL,
                    'buyerContactId' => $chatDetails->buyerContact ? $chatDetails->buyerContact->id : NULL,
                    'chatId' => $chatDetails->chat->id,
                ];
            }else{

                return false;
            }
        }else if($mode == 'custom_product'){

            $explode = explode('_', $id);
            $productId = $explode[0];
            $quantity = $explode[1];
            $countryCode = $explode[2];
            $shippingCountryId = $explode[3];
            $product = UserProduct::find($productId);
            $customProduct = $product->customProduct();
            $countryIsEU = $commonMethods->isEU($countryCode);
            $currency = $product->user->profile->default_currency;
            if($product && $customProduct && $customProduct->status == 1){

                $productPricing = $commonMethods->customProductPricing($customProduct, $currency, $product->price);
                $deliveryCost = $shippingCountryId == 213 ? $customProduct->delivery_cost[$currency]['local'] : $customProduct->delivery_cost[$currency]['int'];
                $total = ($product->price * $quantity) + $deliveryCost;
                $commission = $productPricing['commission'] * $quantity;
                $platformShare = $total - ($commission + $deliveryCost);
                $stripeFee = $countryIsEU ? ((0.014 * $total) + 0.2) : ((0.029 * $total) + 0.2);

                $commission = $commission - ($stripeFee/2);
                $platformShare = $platformShare - ($stripeFee/2);

                return [
                    'platformShare' => $platformShare,
                    'sellerShare' => $commission,
                    'sellerId' => $product->user->id,
                    'buyerId' => Auth::check() ? Auth::user()->id : NULL,
                    'productId' => $product->id,
                    'customProductId' => $customProduct->id,
                    'total' => $total,
                    'stripeFee' => $stripeFee,
                    'deliveryCost' => $deliveryCost,
                    'deliveryCostType' => $shippingCountryId == 213 ? 'local' : 'international',
                ];
            }else{

                return false;
            }
        }else{

            return false;
        }
    }

    public function cancelSubscription(Request $request)
    {
        $commonMethods = new CommonMethods();
        $error = '';
        $success = 0;
        if($request->isMethod('post') && $request->has('id')){

            $id = $request->get('id');
            $user = Auth::user();
            $stripeSubscription = StripeSubscription::find($id);

            if($stripeSubscription){

                if(($stripeSubscription->user && $stripeSubscription->user->id == $user->id) || ($stripeSubscription->customer && $stripeSubscription->customer->id == $user->id)){

                    if($stripeSubscription->stripe_subscription_id){

                        $headers = ['Authorization: Bearer '.Config('constants.stripe_key_secret')];
                        array_push($headers, 'Stripe-Account: '.$stripeSubscription->user->profile->stripe_user_id);
                        $url = 'https://api.stripe.com/v1/subscriptions/'.$stripeSubscription->stripe_subscription_id;
                        $subscription = $commonMethods->stripeCall($url, $headers, [], 'GET');
                        if($subscription && isset($subscription['status']) && $subscription['status'] != 'canceled'){
                            $url = 'https://api.stripe.com/v1/subscriptions/'.$stripeSubscription->stripe_subscription_id;
                            $subscription = $commonMethods->stripeCall($url, $headers, [], 'DELETE');

                            if($stripeSubscription->customer->email){

                                $subCusEmail = $stripeSubscription->customer->email;
                            }else{

                                $stripeCheckout = StripeCheckout::where(['stripe_subscription_id' => $stripeSubscription->id, 'customer_id' => $stripeSubscription->customer->id])->first();
                                if($stripeCheckout && $stripeCheckout->email){
                                    $subCusEmail = $stripeCheckout->email;
                                }else{
                                    $subCusEmail = null;
                                }
                            }

                            if($subCusEmail){
                                $result = Mail::to($subCusEmail)->bcc(Config('constants.bcc_email'))->send(new CancelSubscription($stripeSubscription, 'subscriber'));
                            }
                            $result = Mail::to($stripeSubscription->user->email)->bcc(Config('constants.bcc_email'))->send(new CancelSubscription($stripeSubscription, 'artist'));

                            $stripeSubscription->delete();
                            $success = 1;
                        }else if(isset($subscription['status']) && $subscription['status'] == 'canceled'){
                            $error = 'Subscription is already canceled';
                        }else{
                            $error = $subscription['error'];
                        }
                    }else if($stripeSubscription->paypal_subscription_id){

                        $cancelSubscription = PayPalController::cancelSubscription($stripeSubscription);
                        if($cancelSubscription['error'] == ''){

                            $stripeSubscription->delete();
                            $success = 1;
                        }else{
                            $error = $cancelSubscription['error'];
                        }
                    }
                }else{
                    $error = 'You are not authorised';
                }
            }else{
                $error = 'Subscription not found';
            }
        }else{
            $error = 'inappropraite request';
        }

        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function userActionRequired(Request $request, $type)
    {
        $commonMethods = new CommonMethods();

        $data = [

            'type' => $type
        ];

        return view( 'pages.pre-action', $data );
    }

}

