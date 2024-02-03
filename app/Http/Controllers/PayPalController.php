<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonMethods;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PushNotificationController;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

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

class PayPalController extends Controller
{

    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    public static function environment()
    {
        $clientId = getenv('PAYPAL_CLIENT_ID') ? : 'PAYPAL-SANDBOX-CLIENT-ID';
        $clientSecret = getenv('PAYPAL_CLIENT_SECRET') ? : 'PAYPAL-SANDBOX-CLIENT-SECRET';
        return (Config('constants.paypal_mode') == 'sandbox' ? new SandboxEnvironment($clientId, $clientSecret) : new ProductionEnvironment($clientId, $clientSecret));
    }

    public static function createOrder($data)
    {
        $order = new OrdersCreateRequest();
        $order->prefer('return=representation');
        $order->body = self::getOrderData($data);

        $client = self::client();
        $response = $client->execute($order);

        return $response;
    }

    public static function readOrder($orderId)
    {
        $client = self::client();
        $response = $client->execute(new OrdersGetRequest($orderId));

        return json_decode(json_encode($response->result, JSON_PRETTY_PRINT), TRUE);
    }

    public static function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);

        $client = self::client();
        $response = $client->execute($request);

        return json_decode(json_encode($response->result, JSON_PRETTY_PRINT), TRUE);
    }

    public static function createProduct($productDetails)
    {
        $accessToken = self::getAccessToken();
        $url = Config('constants.paypal_api_uri').'/v1/catalogs/products';
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken,
        ];
        $fields = '{
          "name": "'.$productDetails['name'].'",
          "description": "'.$productDetails['description'].'",
          "type": "'.$productDetails['type'].'",
          "category": "'.$productDetails['category'].'",
          "image_url": "'.$productDetails['image'].'",
          "home_url": "'.$productDetails['home'].'"
        }';

        $response = self::paypalCall($url, $headers, $fields);
        $array = json_decode(json_encode($response, JSON_PRETTY_PRINT), TRUE);

        return $array;
    }

    public static function createPlan($planDetails)
    {
        $accessToken = self::getAccessToken();
        $url = Config('constants.paypal_api_uri').'/v1/billing/plans';
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Prefer: return=representation',
            'Authorization: Bearer '.$accessToken
        ];
        $fields = '{
            "name": "'.$planDetails['name'].'",
            "description": "'.$planDetails['description'].'",
            "product_id": "'.$planDetails['product']['id'].'",
            "quantity_supported": false,
            "billing_cycles": [{
                "frequency": {
                    "interval_unit": "MONTH",
                    "interval_count": 1
                },
                "tenure_type": "REGULAR",
                "sequence": 1,
                "total_cycles": 0,
                "pricing_scheme": {
                    "fixed_price": {
                        "value": "'.$planDetails['price']['value'].'",
                        "currency_code": "'.$planDetails['price']['currency'].'"
                    }
                }
            }],
            "payment_preferences": {
                "auto_bill_outstanding": true,
                "payment_failure_threshold": 2
            }
        }';

        $response = self::paypalCall($url, $headers, $fields);
        $array = json_decode(json_encode($response, JSON_PRETTY_PRINT), TRUE);

        return $array;
    }

    public static function createSubscription($subscriptionDetails)
    {
        $accessToken = self::getAccessToken();
        $url = Config('constants.paypal_api_uri').'/v1/billing/subscriptions';
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Prefer: return=representation',
            'Authorization: Bearer '.$accessToken
        ];
        $fields = '{
		 	"plan_id": "'.$subscriptionDetails['plan']['id'].'",
		  	"subscriber": {
			    "name": {
			      "given_name": "'.$subscriptionDetails['customer']['firstName'].'",
			      "surname": "'.$subscriptionDetails['customer']['lastName'].'"
			    },
			    "email_address": "'.$subscriptionDetails['customer']['email'].'"
			},
		  	"application_context": {
		    	"brand_name": "'.$subscriptionDetails['brandName'].'",
			    "shipping_preference": "NO_SHIPPING",
		    	"user_action": "SUBSCRIBE_NOW",
		    	"return_url": "'.route('paypal.post.subscription').'",
		    	"cancel_url": "'.route('paypal.post.subscription.cancel').'"
		  	},
            "custom_id": "'.$subscriptionDetails['customId'].'"
		}';

        $response = self::paypalCall($url, $headers, $fields);
        $array = json_decode(json_encode($response, JSON_PRETTY_PRINT), TRUE);

        return $array;
    }

    public static function cancelSubscription(StripeSubscription $stripeSubscription)
    {
        $error = $success = '';
        $user = Auth::user();

        if($user){

            if($stripeSubscription->paypal_subscription_id){

                $userType = $stripeSubscription->user->id == $user->id ? 'Artist' : 'Customer';
                $accessToken = self::getAccessToken();
                $url = Config('constants.paypal_api_uri').'/v1/billing/subscriptions/'.$stripeSubscription->paypal_subscription_id.'/cancel';
                $headers = [
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$accessToken,
                ];
                $fields = '{
                  "reason": "Initiated from '.$userType.'\'s end"
                }';

                $response = self::paypalCall($url, $headers, $fields);

                $success = '1';
            }else{

                $error = 'This is not a valid PayPal subscription';
            }
        }else{

            $error = 'No user is logged in';
        }

        return ['error' => $error, 'success' => $success];
    }

    public static function readSubscription($subscriptionId)
    {
        $accessToken = self::getAccessToken();
        $url = Config('constants.paypal_api_uri').'/v1/billing/subscriptions/'.$subscriptionId;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken
        ];
        $fields = '';

        $response = self::paypalCall($url, $headers, $fields, 'GET');

        return json_decode(json_encode($response, JSON_PRETTY_PRINT), TRUE);
    }

    public static function readPlan($planId)
    {
        $accessToken = self::getAccessToken();
        $url = Config('constants.paypal_api_uri').'/v1/billing/plans/'.$planId;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken
        ];
        $fields = '';

        $response = self::paypalCall($url, $headers, $fields, 'GET');

        return json_decode(json_encode($response, JSON_PRETTY_PRINT), TRUE);
    }

    public static function readProduct($productId)
    {
        $accessToken = self::getAccessToken();
        $url = Config('constants.paypal_api_uri').'/v1/catalogs/products/'.$productId;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken
        ];
        $fields = '';

        $response = self::paypalCall($url, $headers, $fields, 'GET');

        return json_decode(json_encode($response, JSON_PRETTY_PRINT), TRUE);
    }

    public function prepareCheckout(Request $request)
    {
    	$success = $error = $redirectUrl = '';

        $commonMethods = new CommonMethods();
        $basket = $commonMethods->getCustomerBasket();
        if(count($basket)){

            if(count($basket) == 1 && $basket->first()->purchase_type == 'subscription'){

                Session::flash('error', 'Error: In order to subscribe using PayPal you must click the button "Pay with PayPal" in subscription area on this page');
                $redirectUrl = route('user.home', ['params' => $basket->first()->user->username]);
                $commonMethods->deleteCustomerBasket();
                return json_encode(['error' => '', 'success' => '1', 'redirectUrl' => $redirectUrl]);
            }

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
            $finalData['type'] = 'normal_checkout';

            $response = self::createOrder($finalData);

            if($response->statusCode !== 201){

                abort(500);
            }

            $array = json_decode(json_encode($response->result, JSON_PRETTY_PRINT), TRUE);
            $firstItem = $basket->first();
            $firstItem->payment_intent_id = 'pyl_'.$array['id'];
            $firstItem->save();

            $success = '1';

            foreach($array['links'] as $link) {

                if($link['rel'] == 'approve'){

                    $redirectUrl = $link['href'];
                }
            }
        }else{

            $error = 'Something went wrong';
        }

        return json_encode(['error' => $error, 'success' => $success, 'redirectUrl' => $redirectUrl]);
    }

    public function postCheckout(Request $request)
    {

        $commonMethods = new CommonMethods();
        $projectController = new ProjectController();
        $basket = $commonMethods->getCustomerBasket();
        if(count($basket)){

            $paypalOrderId = $_GET['token'];
            $sellerUser = $basket->first()->user;
            $order = self::readOrder($paypalOrderId);

            if(is_array($order) && isset($order['status'])){

                if($order['status'] == 'CREATED'){

                    foreach($order['links'] as $link) {

                        if($link['rel'] == 'approve'){

                            return redirect($link['href']);
                        }
                    }
                }else if($order['status'] == 'VOIDED'){

                    return redirect(route('user.home', ['params' => $sellerUser->username]))->with('error', 'All purchase units in the order are voided');
                }else if($order['status'] == 'COMPLETED'){

                    return redirect(route('user.home', ['params' => $sellerUser->username]))->with('error', 'The payment has already been captured for this order '.$order['id']);
                }else if($order['status'] == 'PAYER_ACTION_REQUIRED'){

                    foreach($order['links'] as $link) {

                        if($link['rel'] == 'payer-action'){

                            return redirect($link['href']);
                        }
                    }
                }else{

                    //order is ready to capture
                    $response = self::captureOrder($paypalOrderId);

                    if(!$response || !isset($response['id'])){

                        return redirect(route('user.home', ['params' => $sellerUser->username]))->with('error', 'Error occured while capturing your PayPal payment');
                    }

                    $response = self::readOrder($response['id']);

                    if($response['status'] == 'COMPLETED'){

                        foreach ($response['purchase_units'] as $unit) {

                            $email = $phoneNumber = $password = '';
                            if($unit['reference_id'] == 'seller'){

                                $description = $unit['description'];
                                $explode1 = explode('_', $description);
                                foreach ($explode1 as $eachValueSet) {
                                    if($eachValueSet != ''){
                                        $explode2 = explode('#', $eachValueSet);
                                        if($explode2[0] == 'pass'){
                                            $password = $explode2[1];
                                        }else if($explode2[0] == 'com'){
                                            $comment = $explode2[1];
                                        }else if($explode2[0] == 'name'){
                                            $firstName = $explode2[1];
                                        }else if($explode2[0] == 'sur'){
                                            $lastName = $explode2[1];
                                        }else if($explode2[0] == 'em'){
                                            $email = $explode2[1];
                                        }
                                    }
                                }
                            }
                        }

                        $address = $response['payer']['address']['address_line_1'];
                        $city = $response['payer']['address']['admin_area_2'];
                        $postcode = $response['payer']['address']['postal_code'];
                        $country = $response['payer']['address']['country_code'];
                        $phoneNumber = $response['payer']['address']['address_line_2'] != 'N/A' ? $response['payer']['address']['address_line_2'] : '';
                        $deliveryCost = $response['purchase_units'][0]['amount']['breakdown']['shipping']['value'];

                        $paymentData = [
                            'type' => 'instant',
                            'totalAmount' => $response['purchase_units'][0]['amount']['value'],
                            'firstname' => $firstName,
                            'surname' => $lastName,
                            'street' => $address,
                            'country' => $country,
                            'city' => $city,
                            'postcode' => $postcode,
                            'comment' => $comment,
                            'deliverycost' => $deliveryCost,
                            'email' => $email,
                            'phoneNumber' => $phoneNumber,
                            'password' => $password,
                            'stripefee' => null,
                            'applicationfeeid' => null,
                            'failedcheckout' => 0,
                            'free' => '0',
                        ];

                        $buyerUserResponse = $projectController->createBuyerUser($sellerUser, $paymentData);

                        if($buyerUserResponse){

                        	$basket = $commonMethods::getCustomerBasket();
                        	$savingResponse = $projectController->proceedSavingPayment($request, $basket, null, $paymentData, null, $response);
                            if(Config('constants.primaryDomain') != $_SERVER['SERVER_NAME'] && $sellerUser->customDomainSubscription){
                                $redi = 'https://'.$sellerUser->customDomainSubscription->domain_url;
                            }else{
                                $redi = route('user.home', ['params' => $sellerUser->username]);
                            }
                            return redirect($redi)->with('success', 'Your payment has been sent successfully!<br>Check your email for details<br>Click <a target="_blank" href="https://clients.singingexperience.co.uk?code='.$phoneNumber.'">here</a> to login and start your booking');
                        }else{

                            if(Config('constants.primaryDomain') != $_SERVER['SERVER_NAME'] && $sellerUser->customDomainSubscription){
                                $redi = 'https://'.$sellerUser->customDomainSubscription->domain_url;
                            }else{
                                $redi = route('user.home', ['params' => $sellerUser->username]);
                            }
                        	return redirect($redi)->with('error', 'Error: Credentials cannot be accepted. Please report this error to our admin team for further assistance. Code: '.$response['id']);
                        }
                    }

                    return redirect(route('user.home', ['params' => $sellerUser->username]))->with('error', 'Error occured while capturing your PayPal payment. Code:'.$response['id'].' Status: '.$response['status']);
                }
            }else{

                return redirect(route('user.home', ['params' => $sellerUser->username]))->with('error', 'Unknown order');
            }
        }else{

            return 'No user is logged in';
        }
    }

    public function prepareSubscription(Request $request, $userId)
    {
        $success = $errorMessage = $redirectUrl = '';

        $commonMethods = new CommonMethods();
        $projectController = new ProjectController();
        $user = User::find($userId);
        $customer = Auth::user();

        if($customer){
            $firstName = $customer->name;
            $lastName = '';
            $email = $customer->email;
        }else if(isset($request->first_name)){
            $firstName = $request->first_name;
            $lastName = $request->last_name;
            $email = $request->email;

            $paymentData = [
                'firstname' => $firstName,
                'surname' => $lastName,
                'email' => $email,
                'country' => 0,
                'city' => 0,
                'password' => '123456',
                'street' => '',
                'postcode' => '',
            ];
            $buyerUser = $projectController->createBuyerUser($user, $paymentData);
            if(!$buyerUser){
                $errorMessage = 'The email you provided is already registered. Use that email to login and proceed to subscribe';
            }
        }else{
            $errorMessage = 'No user information';
        }

        if($errorMessage == ''){

            if($user && $user->subscription_amount > 0){

                $productDetails = [
                    'name' => $user->name.' Subscription Product',
                    'description' => 'Subscription product created for '.$firstName.' '.$lastName,
                    'type' => 'SERVICE',
                    'category' => 'SOFTWARE',
                    'image' => $commonMethods->getUserDisplayImage($user->id),
                    'home' => route('user.home', ['params' => $user->username]),
                ];

                $product = self::createProduct($productDetails);

                if(isset($product['id'])){

                    $planDetails = [
                        'product' => $product,
                        'name' => $user->name.' Subscription Plan',
                        'description' => 'Subscription plan created for '.$firstName.' '.$lastName,
                        'price' => [
                            'currency' => strtoupper($user->profile->default_currency),
                            'value' => $user->subscription_amount,
                        ],
                    ];

                    $plan = self::createPlan($planDetails);

                    if(isset($plan['id'])){

                        $subscriptionDetails = [
                            'plan' => $plan,
                            'customer' => [
                                'firstName' => $firstName,
                                'lastName' => $lastName,
                                'email' => $email,
                            ],
                            'brandName' => $firstName.' '.$lastName,
                            'customId' => $user->id,
                        ];

                        $subscription = self::createSubscription($subscriptionDetails);

                        if(isset($subscription['id'])){

                            foreach($subscription['links'] as $link) {

                                if($link['rel'] == 'approve'){

                                    $redirectUrl = $link['href'];
                                }
                            }

                            return redirect($redirectUrl);
                        }else{
                            $errorMessage = 'Subscription error';
                        }
                    }else{
                        $errorMessage = 'Plan error';
                    }
                }else{
                    $errorMessage = 'Product error';
                }
            }else{
                $errorMessage = 'Something went wrong';
            }
        }

        return redirect(route('user.home', ['params' => $user->username]))->with('error', $errorMessage);
    }

    public function postSubscription(Request $request)
    {

        if(isset($_GET['subscription_id'])){

            $commonMethods = new CommonMethods();
            $projectController = new ProjectController();
            $paypalSubscription = self::readSubscription($_GET['subscription_id']);

            if(Auth::check()){

                if(isset($paypalSubscription['id']) && $paypalSubscription['status'] == 'ACTIVE'){

                    $planId = $paypalSubscription['plan_id'];
                    $paypalPlan = self::readplan($planId);

                    $buyerUser = Auth::user();
                    $sellerUser = User::find($paypalSubscription['custom_id']);

                    $amount = $paypalPlan['billing_cycles'][0]['pricing_scheme']['fixed_price']['value'];
                    $currency = $paypalPlan['billing_cycles'][0]['pricing_scheme']['fixed_price']['currency_code'];
                    $interval = $paypalPlan['billing_cycles'][0]['frequency']['interval_unit'];
                    $description = $paypalPlan['description'];
                    $currencySymbol = $commonMethods->getCurrencySymbol($currency);
                    $sellerDetails = $commonMethods->getUserRealDetails($sellerUser->id);
                    $buyerDetails = $commonMethods->getUserRealDetails($buyerUser->id);

                    $subscription = new StripeSubscription;
                    $subscription->plan_currency = $currency;
                    $subscription->plan_amount = $amount;
                    $subscription->plan_interval = strtolower($interval);
                    $subscription->comment = $description;
                    $subscription->application_fee = null;
                    $subscription->user_id = $sellerUser->id;
                    $subscription->customer_id = $buyerUser->id;
                    $subscription->stripe_subscription_id = null;
                    $subscription->paypal_subscription_id = $paypalSubscription['id'];
                    $subscription->save();

                    $stripeCheckOut = new StripeCheckout();
                    $stripeCheckOut->user_id = $sellerUser->id;
                    $stripeCheckOut->customer_id = $buyerUser->id;
                    $stripeCheckOut->user_name = $sellerUser->name;
                    $stripeCheckOut->customer_name = $buyerUser->name;
                    $stripeCheckOut->amount = 0;
                    $stripeCheckOut->currency = $currency;
                    $stripeCheckOut->type = 'instant';
                    $stripeCheckOut->email = $buyerUser->email;
                    $stripeCheckOut->name = trim($buyerUser->first_name.' '.$buyerUser->last_name);
                    $stripeCheckOut->stripe_subscription_id = $subscription->id;
                    $stripeCheckOut->save();

                    $subscriptionCheck = CustomerBasket::where('purchase_type', 'subscription')->where('user_id', $sellerUser->id)->where('customer_id', $buyerUser->id)->where('sold_out', 0)->get();
                    if(count($subscriptionCheck) == 0){
                        $customerBasket = new CustomerBasket();
                        $customerBasket->user_id =  $sellerUser->id;
                        $customerBasket->customer_id = $buyerUser->id;
                        $customerBasket->product_id = 0;
                        $customerBasket->music_id = 0;
                        $customerBasket->album_id = 0;
                        $customerBasket->purchase_type = 'subscription';
                        $customerBasket->license = '';
                        $customerBasket->extra_info = '';
                        $customerBasket->price = $amount;
                        $customerBasket->save();
                    }
                    $basket = $commonMethods->getCustomerBasket();

                    $result = Mail::to($sellerUser->email)->bcc(Config('constants.bcc_email'))->send(new InstantCheckout('seller', $stripeCheckOut));
                    $buyerArray = ['customer' => $buyerUser, 'customerBasket' => $basket, 'user' => $sellerUser, 'bcc' => Config('constants.bcc_email'), 'sellerDetails' => $sellerDetails, 'buyerDetails' => $buyerDetails, 'emaill' => $buyerUser->email];
                    $buyerObj = (object) $buyerArray;
                    $result =  Mail::send('pages.email.basket-buyer-email', ['customer' => $buyerUser, 'user' => $sellerUser, 'customerBasket' => $basket, 'currencySymbol' => $currencySymbol, 'currency' => $currency, 'commonMethods' => $commonMethods, 'checkout' => $stripeCheckOut], function ( $m ) use ($buyerObj){

                        $m->from(Config('constants.from_email'), '1PlatformTV');
                        $m->bcc($buyerObj->bcc);
                        $m->to($buyerObj->customer->email);
                        $m->subject('You are subscribed to '.$buyerObj->user->name);
                    });

                    $result = Mail::to($sellerUser->email)->bcc(Config('constants.bcc_email'))->send(new InstantCheckout('seller', $stripeCheckOut));
                    $userNotification = new UserNotificationController();
                    $request->request->add(['user' => $sellerUser->id, 'customer' => $buyerUser->id, 'type' => 'sale', 'source_id' => $stripeCheckOut->id]);
                    $response = json_decode($userNotification->create($request), true);
                    $redUrl = base64_encode(route('agency.dashboard.tab', ['tab' => 'my-transactions']));
                    if(count($sellerUser->devices)){
                        foreach ($sellerUser->devices as $device) {
                            if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){
                                $fcm = new PushNotificationController();
                                $return = $fcm->send($device->device_id, 'New sale from '.$buyerUser->firstName(), str_limit('Items purchased from your 1platform store', 24), $device->platform, 'sale', $redUrl);
                            }
                        }
                    }

                    CommonMethods::deleteCustomerBasket();
                    if($sellerUser->isCotyso() && $buyerUser->password == 'iscotyso'){
                        $buyerUser->email = NULL;
                        $buyerUser->password = NULL;
                        $buyerUser->active = 0;
                        $buyerUser->contact_number = NULL;
                        $buyerUser->save();
                        Auth::logout($buyerUser);
                    }

                    $message = 'Successfully subscribed to ' . $sellerUser->name;
                    Session::flash('success', $message);
                    if($sellerUser->isCotyso() && !Auth::check()){
                        $domain = parse_url($request->root())['host'];
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
                        Session::flash('page', 'orders');
                        $redirectUrl = route('profile');
                    }

                    return redirect($redirectUrl);
                }else{

                    die('Error: Subscription ID: '.$_GET['subscription_id'].' - Status: '.$paypalSubscription['status']);
                }
            }else{

                die('Error: No logged in user');
            }
        }else{

            die('Unexpected response from PayPal');
        }
    }

    public function cancelOrder(Request $request)
    {

    	$commonMethods = new CommonMethods();
    	$basket = $commonMethods->getCustomerBasket();
    	$basketUser = $basket->first()->user;
    	CommonMethods::deleteCustomerBasket();

    	if($basketUser){
    		return redirect(route('user.home', ['params' => $basketUser->username]))->with('success', 'Your order has been cancelled');
    	}else{
    		return redirect(route('profile'))->with('success', 'Your order has been cancelled');
    	}
    }

    public static function getOrderData($userData){

    	$commonMethods = new CommonMethods();
    	$projectController = new ProjectController();
        $orderDetails = self::getOrderParticulars($userData);
        $seller = User::find($orderDetails['seller']);

        if($seller->isCotyso()){

            $descriptor = 'SingingExperience';
        }else{
            $descriptor = str_limit($seller->username, 22);
        }

        $country = Country::find($userData['country']);
        if($orderDetails['shipping'] > 0){

            $shipping = [
                'shipping' => [
                    'name' => [
                        'full_name' => $userData['name'].' '.$userData['surname'],
                    ],
                    'address' => [
                        'address_line_1' => $userData['street'],
                        'address_line_2' => $userData['city'],
                        'postal_code' => $userData['zip'],
                        'country_code' => $country->code,
                    ],
                ]
            ];
        }else{

            $shipping = [];
        }
        if(isset($userData['contact_number'])){
            $phone = [
            	'phone' => [
            		'phone_type' => 'OTHER',
            		'phone_number' => [
            			'national_number' => $userData['contact_number'],
            		],
            	]
            ];
        }else{
        	$phone = [];
        }
        if(isset($userData['email'])){
            $email = [
            	'email_address' => $userData['email'],
            ];
        }else{
        	$email = [];
        }

        $description = 'com#'.str_limit($userData['comment'], 70).'_name#'.$userData['name'].'_sur#'.$userData['surname'];
        if(isset($userData['email'])){
            $description .= '_em#'.$userData['email'];
        }
        if(isset($userData['password'])){
            $description .= '_pass#'.$userData['password'];
        }

        if($userData['type'] == 'normal_checkout'){
        	$appFee = $projectController->getCheckoutFee('instant', $seller, $orderDetails['total']);
        	$fee = $appFee['platform']['fee'];
        	if($fee > 0){
        		$platformFee = [
        			'platform_fees' => [
        				[
        					'amount' => [
        						'currency_code' => strtoupper($seller->profile->default_currency),
        						'value' => round(floatval($fee), 2),
        					],
        				],
        			],
        		];
        	}else{
        		$platformFee = [];
        	}
        }else{
        	$platformFee = [];
        }

        $data = [

            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.post.order'),
                'cancel_url' => route('paypal.post.order.cancel'),
            ],
            'payer' => [
            	'name' => [
            		'given_name' => $userData['name'],
            		'surname' => $userData['surname'],
            	],
            	'address' => [
            		'address_line_1' => $userData['street'],
                    'address_line_2' => isset($userData['contact_number']) ? $userData['contact_number'] : 'N/A',
            		'admin_area_2' => $userData['city'],
            		'postal_code' => $userData['zip'],
            		'country_code' => $country->code,
            	],
            ],
            'purchase_units' => [
                [
                    'reference_id' => 'seller',
                    'amount' => [
                        'currency_code' => strtoupper($seller->profile->default_currency),
                        'value' => round(floatval($orderDetails['total']), 2),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => strtoupper($seller->profile->default_currency),
                                'value' => round(floatval($orderDetails['subTotal']), 2),
                            ],
                            'shipping' => [
                                'currency_code' => strtoupper($seller->profile->default_currency),
                                'value' => round(floatval($orderDetails['shipping']), 2),
                            ],
                        ],
                    ],
                    'payee' => [
                        'merchant_id' => $orderDetails['seller_merchant_id'],
                    ],
                    'payment_instruction' => [
                    	'disbursement_mode' => 'INSTANT',
                    ],
                    'soft_descriptor' => $descriptor,
                    'items' => $orderDetails['paypalItems'],
                    'description' => $description,
                ]
            ]
        ];

        if(is_array($shipping) && count($shipping)){
        	array_push($data['purchase_units'][0], $shipping);
        }
        if(isset($userData['contact_number'])){
            array_push($data['payer'], $phone);
        }
        if(isset($userData['email'])){
            array_push($data['payer'], $email);
        }
        array_push($data['purchase_units'][0]['payment_instruction'], $platformFee);

        return $data;
    }

    public static function getOrderParticulars($orderData){

        $commonMethods = new CommonMethods();

        if($orderData['type'] == 'normal_checkout'){

            $basket = $commonMethods->getCustomerBasket();
            $basketUser = $basket->first()->user;
            $basketCurrency = $commonMethods->getCurrencySymbol(strtoupper($basketUser->profile->default_currency));

            $total = 0;
            $orderItems = [];
            foreach($basket as $b){

                if($b->purchase_type == 'music'){

                    $itemTitle = $b->music->song_name;
                    $itemDescription = $b->license;
                }else if($b->purchase_type == 'album'){

                    $itemTitle = $b->album->name;
                    $itemDescription = 'Music Album';
                }else if($b->purchase_type == 'product'){

                    $itemTitle = $b->product->title;
                    $itemDescription = 'Product';
                }else if($b->purchase_type == 'donation_goalless'){

                    $itemTitle = 'Donation';
                    $itemDescription = 'You are donating '.$b->user->name;
                }else if($b->purchase_type == 'subscription'){

                    continue;
                }

                $total += $b->price;
                $orderItems[] = [
                    'name' => $itemTitle,
                    'description' => $itemDescription,
                    'quantity' => 1,
                    'unit_amount' => [
                        'currency_code' => strtoupper($basketUser->profile->default_currency),
                        'value' => round(floatval($b->price), 2),
                    ],
                    'category' => 'PHYSICAL_GOODS',
                ];
            }

            $subTotal = $total;
            $total += $orderData['delivery_cost'];

            $return = [
                'total' => $total,
                'currency' => $basketCurrency,
                'subTotal' => $subTotal,
                'shipping' => $orderData['delivery_cost'],
                'seller' => $basketUser->id,
                'paypalItems' => $orderItems,
                'seller_merchant_id' => $basketUser->profile->paypal_merchant_id
            ];
        }

        return $return;
    }

    public static function onboardRedirect(Request $request)
    {
        $merchantId = $_GET['merchantIdInPayPal'];
        $trackingId = $_GET['merchantId'];
        $permissionsGranted = $_GET['permissionsGranted'];
        $consentStatus = $_GET['consentStatus'];
        $isEmailConfirmed = $_GET['isEmailConfirmed'];
        $accountStatus = $_GET['accountStatus'];

        if($permissionsGranted != 'true' || $isEmailConfirmed != 'true' || $consentStatus != 'true' || $accountStatus != 'BUSINESS_ACCOUNT'){

            return redirect(route('user.startup.wizard'));
        }else{

            $explode = explode('_', $trackingId);
            $userId = $explode[2];
            $user = User::find($userId);

            if(!$user || !$user->profile || !($user->profile->paypal_merchant_id == NULL || $user->profile->paypal_merchant_id == '')){

                return redirect(route('profile'))->with('error', 'There is some problem while trying to connect PayPal account');
            }else{

                $user->profile->paypal_merchant_id = $merchantId;
                $user->profile->save();

                return redirect(route('profile'))->with('success', 'You have successfully connected PayPal account');
            }
        }
    }

    public static function getAccessToken()
    {
        $userAuthorization = base64_encode(getenv('PAYPAL_CLIENT_ID').':'.getenv('PAYPAL_CLIENT_SECRET'));
        $url = Config('constants.paypal_api_uri').'/v1/oauth2/token';
        $headers = [
            'Accept: application/json',
            'Accept-Language: en_US',
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.$userAuthorization
        ];
        $fields = http_build_query(['grant_type' => 'client_credentials']);
        $response = self::paypalCall($url, $headers, $fields);

        return isset($response['access_token']) ? $response['access_token'] : NULL;

    }

    public static function getSignupLink(Request $request, $userId)
    {

        $user = User::find($userId);
        $emailAddress = $user->email;
        $trackingId = 'paypal_track_'.$user->id;
        $accessToken = self::getAccessToken();
        $returnUrl = route('paypal.onboard.redirect');
        $renewalUrl = route('user.startup.wizard');
        $logoUrl = asset('images/1a_right_tv.png');
        $url = Config('constants.paypal_api_uri').'/v2/customer/partner-referrals';
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken
        ];
        $fields = '{
          "email": "'.$emailAddress.'",
          "preferred_language_code": "en-US",
          "tracking_id": "'.$trackingId.'",
          "partner_config_override": {
            "partner_logo_url": "'.$logoUrl.'",
            "return_url": "'.$returnUrl.'",
            "return_url_description": "You must return to 1Platform to complete your onboarding process",
            "action_renewal_url": "'.$renewalUrl.'",
            "show_add_credit_card": true
          },
          "operations": [
          {
            "operation": "API_INTEGRATION",
            "api_integration_preference": {
              "rest_api_integration": {
                "integration_method": "PAYPAL",
                "integration_type": "THIRD_PARTY",
                "third_party_details": {
                  "features": [
                    "PAYMENT",
                    "REFUND"
                 ]
                }
              }
            }
          }
        ],
          "legal_consents": [
            {
              "type": "SHARE_DATA_CONSENT",
              "granted": true
            }
          ],
          "products": [
            "EXPRESS_CHECKOUT"
          ]
        }';
        $response = self::paypalCall($url, $headers, $fields);
        $array = json_decode(json_encode($response, JSON_PRETTY_PRINT), TRUE);
        if(isset($array['links'][1]) && isset($array['links'][1]['href']) && isset($array['links'][1]['rel']) && isset($array['links'][1]['rel']) == 'action_url'){

            $signUpUrl = $array['links'][1]['href'];
        }else{

            $signUpUrl = NULL;
        }

        return $signUpUrl;
    }

    public static function paypalCall($url, $headers, $fields, $method = 'POST'){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        if($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }else if($method == 'DELETE'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        $return = json_decode(trim($output), TRUE);

        return $return;
    }
}



