<?php
/**
 * Created by PhpStorm.
 * User: Ahsan Hanif
 * Date: 13-Sep-17
 * Time: 1:14 AM
 */

namespace App\Http\Controllers\Auth;

use App\Models\CustomerBasket;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\SocialLogin;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Lang;
use Mail;
use Password;
use Socialize;
use Validator;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     * @var string
     */
    protected $redirectTo = '/';
    /**
     * @var string
     */
    protected $loginPath = 'login';
    /**
     * @var string
     */
    protected $redirectAfterLogout = '/';
    /**
     * @var int
     */
    protected $maxLoginAttempts = 10;
    /**
     * @var int
     */
    protected $lockoutTime = 300;


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator( array $data )
    {
        return Validator::make( $data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|confirmed|max:255|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
        // return Validator::make($data,[
        //     'name' => 'required|min:5|max:35',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:3|max:20',
        // ],[
        //     'name.required' => ' The first name field is required.',
        //     'name.min' => ' The first name must be at least 5 characters.',
        //     'name.max' => ' The first name may not be greater than 35 characters.',
        // ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create( array $data, Request $request)
    {
        return $this->_createUser($data, $request);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function login( Request $request )
    {
        $this->validateLogin( $request );
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if( $throttles && $lockedOut = $this->hasTooManyLoginAttempts( $request ) )
        {
            $this->fireLockoutEvent( $request );

            return $this->sendLockoutResponse( $request );
        }

        $credentials = $this->getCredentials( $request );
        if( Auth::guard( $this->getGuard() )->attempt( $credentials, $request->has( 'remember' ) ) )
        {
            $user = Auth::guard( $this->getGuard() )->user();
            $msg = '';
            if( (int)$user->active == 0)
            {
                $msg =  Lang::get( 'auth.inactive' );
            }
            elseif((int)$user->suspend == 1)
            {
                $msg = Lang::get( 'auth.suspended' );
            }
            else
            {
                return $this->handleUserWasAuthenticated( $request, $throttles );
            }
            Auth::guard( $this->getGuard() )->logout();

            return $this->jsonFail( $request,$msg);
        }
        Auth::getDispatcher()->fire( 'auth.fail', [ $credentials, $request ] );
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if( $throttles && !$lockedOut )
        {
            $this->incrementLoginAttempts( $request );
        }

        return $this->jsonFail( $request, $this->getFailedLoginMessage());
    }

    /* Login via fb */
    public function loginFacebook(Request $request){
        try{
            return $this->showPage( 'auth.fblogin' );
        }catch(Exception $e){

            return redirect('/');
        }
    }

    /* Login via fb contribute pafe */
    public function contributeLoginFacebook(Request $request){
        try{
            return $this->showPage( 'auth.fbcontributelogin', ['contributeUserId'=>$request->id, 'basketFlag'=>$request->basketFlag] );
        }catch(Exception $e){

            return redirect('/');
        }
    }

    /* Login via twitter */
    public function loginTwitter(Request $request){
        return $this->showPage( 'auth.twitterlogin' );

    }
    public function endftimelogin(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->firstlogintime = 1;
        $user->save();
        return Response(['success'=>true]);
    }
    public function registerAfterTwitterlogin(Request $request){

        session_start();
        $_SESSION['twitter_redirect'] = $_SESSION['twitter_redirect'] + 1;
        if( isset($_SESSION['data']) ){

            $data = $_SESSION['data'];
            $name = $data->name;
            $password = 'redhat123';
            $emailAddress = $data->screen_name;
            $request['name'] = $name;
            $request['email'] = $emailAddress ;
            $request['email_confirmation'] = $emailAddress;
            $request['password'] = $password;
            $request['password_confirmation'] = $password;
            $request['agree_terms'] = 1;

            $user = \App\Models\User::where('email', $emailAddress)->first();

            if(sizeof($user) == 0){

                $user                  = new User();
                $user->name            = $name;
                $user->email           = $emailAddress;
                $user->password        = bcrypt($password);
                $user->subscription_id = 0;
                $user->active          = 1;

                Auth::getDispatcher()->fire( 'auth.register', [ $user, $request ] );
                $user->save();

                $address             = new Address();
                $address->alias      = 'main address';
                $user->address()->save( $address );

                $profile = new Profile();
                $profile->birth_date = Carbon::now();
                $user->profile()->save($profile);

            }

            Auth::login($user);
            $redirectUrl = \App\Http\Controllers\CommonMethods::getRedirectUrlAfterLogin();
            return redirect($redirectUrl);


        }else{

            $redirectUrl = \App\Http\Controllers\CommonMethods::getRedirectUrlAfterLogin();
            return redirect($redirectUrl);
        }

    }

    public function registerAfterFblogin(Request $request){
        if(!session_id()) {
            session_start();
        }
        require_once(app_path().'/includes/Facebook/autoload.php');

        // new fb login code
        $fb = new \Facebook\Facebook([
            "app_id"=>"2410593049051877",
            "app_secret"=>"af89dde37f7647d76bde6fb24e1b9ab2",
            "default_graph_version"=>"v2.8",
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        $pageId = "";
        if(isset($accessToken)){
            $url = "https://graph.facebook.com/v2.8/me/accounts?access_token=" . $accessToken;
            $headers = array("content-type"=>"application/json");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie-txt");
            curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie-txt");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla 5.0 (Windows U: Windows NT 5.1: en-US rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $st = curl_exec($ch);
            $result = json_decode($st, TRUE);

            foreach($result["data"] as $item){
                $pageId = $item["id"];
                break;
            }


            // get other facebook profile details..
            try{
                $response = $fb->get( '/me?fields=id,first_name,last_name,name,email,age_range,locale,updated_time,link,timezone,verified', $accessToken);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            // get response
            $graphObject = $response->getGraphUser();
            $fbid = $graphObject['id'];              // To Get Facebook ID
            $fbfullname = $graphObject['name']; // To Get Facebook full name
            $femail = $graphObject['email'];    // To Get Facebook email ID
            $ffirstname = $graphObject['first_name'];    // To Get Facebook email ID
            $flastname = $graphObject['last_name'];
            $flocale = $graphObject['locale'];
            $fupdatedtime = $graphObject['updated_time'];
            $flink = $graphObject['link'];
            $ftimezone = $graphObject['timezone'];
            $fverified = $graphObject['verified'];
            $_SESSION['FBID'] = $fbid;
            $_SESSION['FULLNAME'] = $fbfullname;
            $_SESSION['EMAIL'] =  $femail;
            $_SESSION['FIRSTNAME'] = $ffirstname;
            $_SESSION['LASTNAME'] = $flastname;
            $_SESSION['LOCALE'] = $flocale;
            $_SESSION['UPDATED_TIME'] = $fupdatedtime;
            $_SESSION['LINK'] = $flink;
            $_SESSION['TIMEZONE'] = $ftimezone;
            $_SESSION['VERIFIED'] = $fverified;
            $emailAddress = $_SESSION['EMAIL'];
            $_SESSION['AVATAR'] = "https://graph.facebook.com/" . $_SESSION['FBID'] . "/picture";



            // old code starts now...
            $fbId = $_SESSION['FBID'];
            $fname = $_SESSION['FIRSTNAME'];
            $lname = $_SESSION['LASTNAME'];
            $email = $_SESSION['EMAIL'];
            $rand_password = $fname . '@fb12345';
            $request['name'] = $fname . " " . $lname;
            $request['email'] = $email;
            $request['email_confirmation'] = $email;
            $request['password'] = $rand_password;
            $request['password_confirmation'] = $rand_password;
            $request['agree_terms'] = 1;

            $user = \App\Models\User::where('email', $email)->first();
            if(sizeof($user) == 0){
                $user                  = new User();
                $user->name            = $fname . " " . $lname;
                $user->email           = $email;
                $user->password        = bcrypt($rand_password);
                $user->subscription_id = 0;
                $user->active          = 1;

                Auth::getDispatcher()->fire( 'auth.register', [ $user, $request ] );

                $user->save();

                $address             = new Address();
                $address->alias      = 'main address';
                $user->address()->save( $address );

                $profile = new Profile();
                $profile->birth_date = Carbon::now();
                $profile->social_facebook = $pageId;
                $user->profile()->save($profile);
                Auth::login($user);
                $redirectUrl = \App\Http\Controllers\CommonMethods::getRedirectUrlAfterLogin();
                return redirect($redirectUrl);
            }else{
                //echo "<pre>"; print_r($user); exit;
                $user->profile->social_facebook = $pageId;
                $user->profile->save();
                Auth::login($user);
                $redirectUrl = \App\Http\Controllers\CommonMethods::getRedirectUrlAfterLogin();
                return redirect($redirectUrl);
            }
        }

        // new fb login code ends..

    }


    // register after fb login contribute page

    public function registerAfterFbContributeLogin(Request $request){
        if(!session_id()) {
            session_start();
        }
        require_once(app_path().'/includes/Facebook/autoload.php');

        // new fb login code
        $fb = new \Facebook\Facebook([
            "app_id"=>"991758154262077",
            "app_secret"=>"0a52053428b1600bd4fb83c622934eb0",
            "default_graph_version"=>"v2.8",
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        $pageId = "";
        if(isset($accessToken)){
            $url = "https://graph.facebook.com/v2.8/me/accounts?access_token=" . $accessToken;
            $headers = array("content-type"=>"application/json");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie-txt");
            curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie-txt");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla 5.0 (Windows U: Windows NT 5.1: en-US rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $st = curl_exec($ch);
            $result = json_decode($st, TRUE);

            foreach($result["data"] as $item){
                $pageId = $item["id"];
                break;
            }


            // get other facebook profile details..
            try{
                $response = $fb->get( '/me?fields=id,first_name,last_name,name,email,age_range,locale,updated_time,link,timezone,verified', $accessToken);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            // get response
            $graphObject = $response->getGraphUser();
            $fbid = $graphObject['id'];              // To Get Facebook ID
            $fbfullname = $graphObject['name']; // To Get Facebook full name
            $femail = $graphObject['email'];    // To Get Facebook email ID
            $ffirstname = $graphObject['first_name'];    // To Get Facebook email ID
            $flastname = $graphObject['last_name'];
            $flocale = $graphObject['locale'];
            $fupdatedtime = $graphObject['updated_time'];
            $flink = $graphObject['link'];
            $ftimezone = $graphObject['timezone'];
            $fverified = $graphObject['verified'];
            $_SESSION['FBID'] = $fbid;
            $_SESSION['FULLNAME'] = $fbfullname;
            $_SESSION['EMAIL'] =  $femail;
            $_SESSION['FIRSTNAME'] = $ffirstname;
            $_SESSION['LASTNAME'] = $flastname;
            $_SESSION['LOCALE'] = $flocale;
            $_SESSION['UPDATED_TIME'] = $fupdatedtime;
            $_SESSION['LINK'] = $flink;
            $_SESSION['TIMEZONE'] = $ftimezone;
            $_SESSION['VERIFIED'] = $fverified;
            $emailAddress = $_SESSION['EMAIL'];
            $_SESSION['AVATAR'] = "https://graph.facebook.com/" . $_SESSION['FBID'] . "/picture";



            // old code starts now...
            $fbId = $_SESSION['FBID'];
            $fname = $_SESSION['FIRSTNAME'];
            $lname = $_SESSION['LASTNAME'];
            $email = $_SESSION['EMAIL'];
            $rand_password = $fname . '@fb12345';
            $request['name'] = $fname . " " . $lname;
            $request['email'] = $email;
            $request['email_confirmation'] = $email;
            $request['password'] = $rand_password;
            $request['password_confirmation'] = $rand_password;
            $request['agree_terms'] = 1;

            $user = \App\Models\User::where('email', $email)->first();
            $urlString = "";
            if($request->basketFlag == 1){
                $urlString = "?basket=1";
            }
            if(sizeof($user) == 0){
                $user                  = new User();
                $user->name            = $fname . " " . $lname;
                $user->email           = $email;
                $user->password        = bcrypt($rand_password);
                $user->subscription_id = 0;
                $user->active          = 1;

                Auth::getDispatcher()->fire( 'auth.register', [ $user, $request ] );

                $user->save();

                $address             = new Address();
                $address->alias      = 'main address';
                $user->address()->save( $address );

                $profile = new Profile();
                $profile->birth_date = Carbon::now();
                $profile->social_facebook = $fbId;
                $user->profile()->save($profile);

                // user activation
                //$broker = Password::getRepository();
                //$token = $broker->create($user);
                //$this->getActivate($token, $user->email);
                // user activation ends
                //if( $user && $this->_sendFbActivationEmail( $user ))
                //{
                Auth::login($user);
                $redirectUrl = asset("/contribute/" . $request->id . $urlString);
                return redirect($redirectUrl);
                //}
            }else{
                Auth::login($user);
                $redirectUrl = asset("/contribute/" . $request->id . $urlString);
                return redirect($redirectUrl);
            }

        }
    }

    /* Login via fb ends */

    /**
     * @param Request $request
     * @param User    $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticated( Request $request,User $user)
    {
        return $this->jsonSuccess($request,'');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $data = [
            'pageTitle' => 'UserLogin',
            'title'     => 'LogIn'
        ];

        return $this->showPage( 'auth.login', $data );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $data = [
            'pageTitle' => 'User Registration',
            'title'     => 'Register account'
        ];

        return $this->showPage( 'auth.register', $data );
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFormRegister( Request $request)
    {
        $validator = $this->validator( $request->all() );
        if( $validator->fails() )
        {
            return $this->jsonFail($request, $validator->messages());
        }
        $data = $request->only( [ 'name', 'email', 'password', 'agree_terms' ] );


        $user = $this->_createUser( $data, $request );

        //if( $user)
        if( $user && $this->_sendActivationEmail( $user ))
        {
            return $this->jsonSuccess($request, Lang::get( 'auth.registered' ));
        }

        return $this->jsonFail($request, 'Registration Failed !');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Foundation\Validation\ValidationException
     */
    public function postRegister( Request $request )
    {
        $validator = $this->validator( $request->all() );
        if( $validator->fails() )
        {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $data = $request->only( [ 'name', 'email', 'password', 'agree_terms'] );

        $user = $this->_createUser( $data, $request );

        if( $user && $this->_sendActivationEmail($user))
        {

            return $this->jsonSuccess( $request, Lang::get( 'auth.registered' ) );
        }
        return $this->jsonFail( $request, 'Registration Failed !' );
    }

    /**
     * @param Request $request
     * @param null    $token
     * @param null    $email
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getActivate( Request $request, $token = null, $email = null)
    {
        if( is_null( $token ) )
        {
            return redirect('/')->withErrors( ['token'=>Lang::get( 'auth.activate.wrong-token')] );
        }
        else if(is_null($email))
        {
            return redirect( '/' )->withErrors( [ 'email' => Lang::get( 'auth.activate.missing-email' ) ] );
        }

        /** @var $user User */
        $user = User::where('email',$email)->first();

        /* @var $broker DatabaseTokenRepository */
        $broker = Password::getRepository();

        if( is_null( $user ) || $user->active == 1)
        {
            return redirect( '/' )->withErrors( [ 'account' => Lang::get( 'auth.activate.no-account' ) ] );
        }
        elseif( ! $broker->exists( $user, $token ))
        {
            return redirect( '/' )->withErrors( [ 'token' => Lang::get( 'auth.activate.wrong-token' ) ] );
        }

        Password::getRepository()->delete($token);
        $user->active = 1;
        $user->save();

        return redirect( '/login' )->with( 'status', Lang::get( 'auth.activate.done' ) );
    }

    /**
     * @param $request
     * @param $id
     */
    public function getDeleteUser( $id, Request $request)
    {
        $user = Auth::user();

        if( $user && $user->id == $id )
        {
            if( $user->isAdmin() )
            {
                return redirect()->back()->with( 'status', Lang::get( 'auth.account.admin_delete' ) );;
            }

            Auth::logout();
            $user->delete();

            return redirect( '/home' )->with( 'status', Lang::get( 'auth.account.deleted' ) );
        }
        return redirect()->back();
    }
    /**
     * @param         $data
     * @param Request $request
     *
     * @return User
     */
    protected function _createUser($data, Request $request)
    {
        $user                  = new User();
        $user->name            = $data[ 'name' ];
        $user->email           = $data[ 'email' ];
        $user->active           = 1;
        $user->password        = bcrypt( $data[ 'password' ] );
        $user->firstlogintime        = 0;
        $user->subscription_id = 0;

        Auth::getDispatcher()->fire( 'auth.register', [ $user, $request ] );

        $user->save();

        $address             = new Address();
        $address->alias      = 'main address';
        $user->address()->save( $address );

        $profile = new Profile();
        $profile->birth_date = Carbon::now();
        $user->profile()->save($profile);

        return $user;
    }

    /**
     * @param         $serviceUser
     * @param         $service
     * @param Request $request
     *
     * @return User
     */
    protected function _getCreateUser($serviceUser, $service,Request $request)
    {
        if( $systemSocial = SocialLogin::whereService( $service )->where( 'social_id', $serviceUser->id )->first() )
        {
            return $systemSocial->user;
        }

        $systemSocial = new SocialLogin();
        $systemSocial->service = $service;
        $systemSocial->social_id = $serviceUser->id;

        if( !$systemUser = User::whereEmail( $serviceUser->email )->first() )
        {
            $systemUser = $this->_createUser([
                'name' => $serviceUser->name,
                'email' => $serviceUser->email,
                'password' => str_random(15)
            ],$request);
            $this->_sendActivationEmail( $systemUser );
        }

        $systemSocial->user()->associate($systemUser);
        $systemSocial->save();

        return $systemUser;
    }

    /**
     * @param Request $request
     * @param         $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonFail( Request $request,  $message)
    {
        $request->session()->flash( 'status', $message );
        return response()->json( [
            'result'  => 'FAIL',
            'message' => $message
        ] );
    }

    /**
     * @param Request $request
     * @param         $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonSuccess( Request $request,$message)
    {

        $request->session()->flash( 'status', $message );

        return response()->json( [ 'result' => 'OK' ] );
    }

    /**
     * @param $data
     * @param $message
     *
     * @return $this
     */
    private function sendError( $data, $message)
    {
        return redirect()->back()->withErrors( [
            'email' => $message,
        ] );
    }

    /**
     * @param User $user
     */
    protected function _sendActivationEmail(User $user)
    {
        $broker = Password::getRepository();
        $token = $broker->create($user);
        $result =  Mail::send( 'auth.emails.activation', [ 'user' => $user, 'token' => $token ], function ( $m ) use ( $user ){
            /* @var $m Message */
            //$m->from( 'registration@audition.com', 'Audition Portal' );
            //$m->sender( 'registration@audition.com', 'Audition Portal' );
            $m->to( $user->email, $user->name );
            $m->subject( '1Platform account activation!' );
        } );

        return $result;
    }

    protected function _sendFbActivationEmail(User $user)
    {
        $broker = Password::getRepository();
        $token = $broker->create($user);
        $result =  Mail::send( 'auth.emails.fb_activation', [ 'user' => $user, 'token' => $token ], function ( $m ) use ( $user ){
            /* @var $m Message */
            //$m->from( 'registration@audition.com', 'Audition Portal' );
            //$m->sender( 'registration@audition.com', 'Audition Portal' );
            $m->to( $user->email, $user->name );
            $m->subject( '1Platform account activation!' );
        } );

        return $result;
    }


    /**
     * @param         $provider
     * @param Request $request
     *
     * @return mixed
     */
    public function getSocialRedirect($provider, Request $request)
    {
        return Socialize::with( $provider )->scopes( [ 'profile', 'email' ] )->redirect();
    }


    /**
     * @param         $provider
     * @param Request $request
     */
    public function getSocialHandle( $provider, Request $request)
    {
        $user = null;
        try
        {
            $user = Socialize::with( $provider )->user();
        }
        catch( \Exception $e )
        {
            return redirect()->route( 'home' )->withErrors( [
                'error' => Lang::get( 'auth.social.failed' ),
            ] );
        }

        $user = $this->_getCreateUser($user, $provider, $request);

        if( $user->suspend == 0 )
        {
            Auth::login( $user );
        }
        else
        {
            Auth::logout();
            return redirect()->route( 'login' )->withErrors( [
                'error' => Lang::get( 'auth.suspended' ),
            ] );
        }
        $redirectUrl = \App\Http\Controllers\CommonMethods::getRedirectUrlAfterLogin();
        return redirect($redirectUrl);
    }

    public static function getAuthUser(){
        return Auth::user();
    }

    public static function getCustomerBasket(){
        if(!isset($_SESSION)) {
            session_start();
        }
        $basket = null;
        if(Auth::user()){
            $authUser = Auth::user();
            if( isset($_SESSION['basket_customer_id']) && $_SESSION['basket_customer_id'] != $authUser->id ){
                $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->get();
                foreach ($basket as $b){
                    $b->customer_id = $authUser->id;
                    $b->save();
                }
            }
            $_SESSION['basket_customer_id'] = $authUser->id;
            $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->get();
        } else if(isset($_SESSION['basket_customer_id'])){
            $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->get();
        }
        return $basket;
    }

    public static function deleteCustomerBasket(){
        $customerBasket = AuthController::getCustomerBasket();
        foreach($customerBasket as $b){
            $b->delete();
        }
    }
}
