<?php

namespace App\Http\Controllers\Auth;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUserOS(){

        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        $isWin = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "windows"));
        $isAndroid = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "android"));
        $isIPhone = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "iphone"));
        $isIPad = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "ipad"));
        $isIOS = $isIPhone || $isIPad ;

        return $isIOS ? 'ios' : ($isAndroid ? 'android' : '');
    }

    public function handleUserProAppRedirect($user, $redirectUrl){

    	$data = $this->getUserOS();
    	if($data == 'android' || $data == 'ios'){

    	    if(count($user->devices)){

    	        return $redirectUrl;
    	    }else{

    	        return route('push.notif.user', ['userId' => $user->id, 'redirectUrl' => base64_encode($redirectUrl)]);
    	    }
    	}else{

    	    return $redirectUrl;
    	}
    }

    protected function redirectTo(){

        $user = Auth::user();
        $url = $this->handleUserProAppRedirect($user, route('agency.dashboard'));
        return $url;
    }

    public function loginWithAction(Request $request){

        $type = $request->type;
        $action = $request->action;

        Session::put('socialite_from', $action);

        if($type == 'facebook'){
            $redirectUrl = '/login/facebook';
        }else if($type == 'twitter'){
            $redirectUrl = '/login/twitter';
        }else if($type == 'instagram'){
            $redirectUrl = '/login/instagram';
        }else if($type == 'google'){
            $redirectUrl = '/login/google';
        }

        return redirect($redirectUrl);
    }

    public function login(Request $request){

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)){

            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $user = User::where('email', $request->email)->first();

        
        $errors = collect();

        if (!$user) {
            $errors->push('Invalid Email or Password');
            return redirect()->back()->withErrors($errors);
        } else if ($user->hide_account != null) {
            $errors->push('Account is deleted');
            return redirect()->back()->withErrors($errors);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1, 'hide_account' => null])) {
            return $this->sendLoginResponse($request);
        }else{
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        if(isset($_GET['error_code']) && $_GET['error_code'] != '' && (int) $_GET['error_code'] > 0){
            return redirect(route('login'));
        }

        if(!isset($_SESSION)) {
            session_start();
        }
        $redirectUrl = "/dashboard";
        $isBuyerOnly = NULL;
        if(Session::has('contributeUserId')){
            $redirectUrl = "/project/" . Session::get('contributeUserId');
            /*if(Session::has('basketFlag') && Session::get('basketFlag') != "0"){
                $redirectUrl = $redirectUrl . "?basket=" . Session::get('basketFlag');
            }*/
        } else if(Session::has('checkoutUserId')){
            $redirectUrl = "/checkout/" . Session::get('checkoutUserId');
        } else if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'negotiate_') !== false){
            $socialiteFrom = explode('_', Session::get('socialite_from'));
            $socialiteFromUser = User::find($socialiteFrom[1]);
            $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
            Session::forget('socialite_from');
            Session::flash('show_popup', '#bespoke_license_popup');
            $isBuyerOnly = 1;
        } else if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'chatmessage_') !== false){
            $socialiteFrom = explode('_', Session::get('socialite_from'));
            $socialiteFromUser = User::find($socialiteFrom[1]);
            $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
            Session::forget('socialite_from');
            Session::flash('show_popup', '#chat_message_popup');
            $isBuyerOnly = 1;
        }
        $user = Socialite::driver('facebook')->stateless()->user();
        $loginUser = User::where(['email' => $user->getEmail(), 'active' => 1])->first();
        if(!$loginUser){
            $inactiveUser = User::where(['email' => $user->getEmail(), 'active' => 0])->first();
            if($inactiveUser){
                $inactiveUser->profile->delete();
                $inactiveUser->address->delete();
                $inactiveUser->delete();
            }
            $loginUser = new User();
            $loginUser->name = $user->getName();
            $loginUser->email = $user->getEmail();
            $_SESSION["avatar"] = $user->getAvatar();
            $loginUser->password = bcrypt($user->getNickname() . "123456");
            $loginUser->subscription_id = 0;
            $loginUser->active          = 1;
            $loginUser->api_token       = str_random(60);
            $loginUser->is_buyer_only   = $isBuyerOnly;
            $loginUser->save();

            $address             = new Address();
            $address->alias      = 'main address';
            //$loginUser->address()->save( $address );
            $address->user_id = $loginUser->id;
            $address->save();

            $profile = new Profile();
            $profile->birth_date = Carbon::now();
            //$loginUser->profile()->save($profile);
            $profile->user_id = $loginUser->id;
            $profile->save();
        } else {
            $_SESSION["avatar"] = $user->getAvatar();
        }
        Auth::login($loginUser);
        $url = $this->handleUserProAppRedirect($loginUser, $redirectUrl);
        return redirect($url);
    }


    public function redirectToProviderContributeFb(Request $request){
        Session::flash('contributeUserId', $request->userId);
        //Session::flash('basketFlag', $request->basketFlag);
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToProviderCheckoutFb(Request $request){
    	Session::flash('checkoutUserId', $request->userId);
        //Session::flash('basketFlag', $request->basketFlag);
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToProviderInstagram()
    {

        $instaClientId = config('services.instagram.client_id');
        $instaRedirect = config('services.instagram.redirect');
        $redirectUrl = 'https://api.instagram.com/oauth/authorize/?client_id='.$instaClientId.'&redirect_uri='.$instaRedirect.'&scope=user_profile,user_media&response_type=code';
        return redirect($redirectUrl);
    }


    public function redirectToProviderTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallbackTwitter()
    {
        if(isset($_GET['denied']) && $_GET['denied'] != ''){
            return redirect(route('login'));
        }

        if(!isset($_SESSION)) {
            session_start();
        }
        $redirectUrl = '/dashboard';
        $isBuyerOnly = NULL;
        if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'negotiate_') !== false){
            $socialiteFrom = explode('_', Session::get('socialite_from'));
            $socialiteFromUser = User::find($socialiteFrom[1]);
            $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
            Session::forget('socialite_from');
            Session::flash('show_popup', '#bespoke_license_popup');
            $isBuyerOnly = 1;
        } else if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'chatmessage_') !== false){
            $socialiteFrom = explode('_', Session::get('socialite_from'));
            $socialiteFromUser = User::find($socialiteFrom[1]);
            $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
            Session::forget('socialite_from');
            Session::flash('show_popup', '#chat_message_popup');
            $isBuyerOnly = 1;
        }

        $user = Socialite::driver('twitter')->user();
        $loginUser = User::where(['email' => $user->nickname.'@social.com', 'active' => 1])->first();
        if(!$loginUser){
            $inactiveUser = User::where(['email' => $user->nickname.'@social.com', 'active' => 0])->first();
            if($inactiveUser){
                $inactiveUser->profile->delete();
                $inactiveUser->address->delete();
                $inactiveUser->delete();
            }
            $loginUser = new User();
            $loginUser->name = $user->name;
            $loginUser->email = $user->nickname.'@social.com';
            $loginUser->password = NULL;
            $loginUser->subscription_id = 0;
            $loginUser->active          = 1;
            $loginUser->api_token       = str_random(60);
            $loginUser->is_buyer_only   = $isBuyerOnly;
            $loginUser->save();

            $address             = new Address();
            $address->alias      = 'main address';
            //$loginUser->address()->save( $address );
            $address->user_id = $loginUser->id;
            $address->save();

            $profile = new Profile();
            $profile->birth_date = Carbon::now();
            //$loginUser->profile()->save($profile);
            $profile->user_id = $loginUser->id;
            $profile->save();
        }
        Auth::login($loginUser);
        $url = $this->handleUserProAppRedirect($loginUser, $redirectUrl);
        return redirect($url);
    }

    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallbackGoogle()
    {

        $redirectUrl = "/dashboard";
        $isBuyerOnly = NULL;
        if(Session::has('contributeUserId')){
            $redirectUrl = "/project/" . Session::get('contributeUserId');
        } else if(Session::has('checkoutUserId')){
            $redirectUrl = "/checkout/" . Session::get('checkoutUserId');
        } else if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'negotiate_') !== false){
            $socialiteFrom = explode('_', Session::get('socialite_from'));
            $socialiteFromUser = User::find($socialiteFrom[1]);
            $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
            Session::forget('socialite_from');
            Session::flash('show_popup', '#bespoke_license_popup');
            $isBuyerOnly = 1;
        } else if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'chatmessage_') !== false){
            $socialiteFrom = explode('_', Session::get('socialite_from'));
            $socialiteFromUser = User::find($socialiteFrom[1]);
            $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
            Session::forget('socialite_from');
            Session::flash('show_popup', '#chat_message_popup');
            $isBuyerOnly = 1;
        }

        $user = Socialite::driver('google')->user();
        $loginUser = User::where(['email' => $user->email, 'active' => 1])->first();
        if(!$loginUser){
            $inactiveUser = User::where(['email' => $user->email, 'active' => 0])->first();
            if($inactiveUser){
                $inactiveUser->profile->delete();
                $inactiveUser->address->delete();
                $inactiveUser->delete();
            }
            $loginUser = new User();
            $loginUser->name = $user->name;
            $loginUser->email = $user->email;
            $loginUser->password = bcrypt("123456");
            $loginUser->subscription_id = 0;
            $loginUser->active          = 1;
            $loginUser->api_token       = str_random(60);
            $loginUser->is_buyer_only   = $isBuyerOnly;
            $loginUser->save();

            $address             = new Address();
            $address->alias      = 'main address';
            //$loginUser->address()->save( $address );
            $address->user_id = $loginUser->id;
            $address->save();

            $profile = new Profile();
            $profile->birth_date = Carbon::now();
            //$loginUser->profile()->save($profile);
            $profile->user_id = $loginUser->id;
            $profile->save();
        }
        Auth::login($loginUser);
        $url = $this->handleUserProAppRedirect($loginUser, $redirectUrl);
        return redirect($url);
    }

    public function handleFacebookJSLoginCallback(Request $request){

        $redirectUrl = route('profile');
        $isBuyerOnly = NULL;
        if(Session::has('contributeUserId')){
            $redirectUrl = route('user.project', ['username' => Session::get('contributeUserId')]);
        }else if(Session::has('checkoutUserId')){
            $redirectUrl = route('user.checkout', ['userId' => Session::get('checkoutUserId')]);
        }else if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'negotiate_') !== false){
            $socialiteFrom = explode('_', Session::get('socialite_from'));
            $socialiteFromUser = User::find($socialiteFrom[1]);
            $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
            Session::forget('socialite_from');
            Session::flash('show_popup', '#bespoke_license_popup');
            $isBuyerOnly = 1;
        }else if(Session::has('socialite_from') && strpos(Session::get('socialite_from'), 'chatmessage_') !== false){
            $socialiteFrom = explode('_', Session::get('socialite_from'));
            $socialiteFromUser = User::find($socialiteFrom[1]);
            $redirectUrl = route('user.home', ['params' => $socialiteFromUser->username]);
            Session::forget('socialite_from');
            Session::flash('show_popup', '#chat_message_popup');
            $isBuyerOnly = 1;
        }
        $userFullName = $request->fbUserName;
        $userFbId = $request->fbUserId;
        $userFbEmail = $request->fbUserEmail;
        $loginUser = User::where(['email' => $userFbEmail, 'active' => 1])->first();
        if(!$loginUser){
            $inactiveUser = User::where(['email' => $userFbEmail, 'active' => 0])->first();
            if($inactiveUser){
                $inactiveUser->profile->delete();
                $inactiveUser->address->delete();
                $inactiveUser->delete();
            }
            $loginUser = new User();
            $loginUser->name = $userFullName;
            $loginUser->email = $userFbEmail;
            $loginUser->password = bcrypt($userFbEmail);
            $loginUser->subscription_id = 0;
            $loginUser->active = 1;
            $loginUser->api_token = str_random(60);
            $loginUser->is_buyer_only = $isBuyerOnly;
            $loginUser->save();

            $address = new Address();
            $address->alias = 'main address';
            $address->user_id = $loginUser->id;
            $address->save();

            $profile = new Profile();
            $profile->birth_date = Carbon::now();
            $profile->user_id = $loginUser->id;
            $profile->save();
        }
        Auth::login($loginUser);
        $url = $this->handleUserProAppRedirect($loginUser, $redirectUrl);
        return redirect($url);
    }

    public function logout(){

        if(Auth::check()){

        	if(!isset($_SESSION)) {
        	    session_start();
        	}

        	if(isset($_SESSION['basket_customer_id'])){
        	    unset($_SESSION['basket_customer_id']);
        	}

        	if(isset($_SESSION['avatar'])){
        	    unset($_SESSION['avatar']);
        	}

        	Auth::user()->last_activity = null;
        	Auth::user()->save();

        	Auth::logout();
        }

        return redirect(route('login'));
    }
}
