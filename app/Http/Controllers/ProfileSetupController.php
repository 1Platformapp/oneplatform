<?php

namespace App\Http\Controllers;

use App\Models\CrowdfundBasket;
use App\Models\CustomerBasket;
use App\Models\CampaignPerks as CampaignPerk;
use App\Models\EmbedCode;
use App\Models\UserCampaign as UserCampaign;
use App\Models\Profile;
use App\Models\UserAlbum;
use App\Models\UserMusic;
use App\Models\UserProduct;
use App\Models\StripeCheckout;
use App\Models\StripeSubscription;
use App\Models\UserChatGroup;
use App\Models\City;
use App\Models\Country;
use App\Models\User;

use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\CommonMethods;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PushNotificationController;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use App\Models\Competition;
use App\Models\CompetitionVideo;
use App\Models\VideoStream;
use App\Models\UserChat;
use App\Models\Genre;

use App\Mail\License;
use App\Mail\Agent;

use DB;
use PDF;
use Auth;
use Mail;
use Hash;
use Session;
use Image;

class ProfileSetupController extends Controller
{

    public function __construct(){

        $this->middleware('user.update.activity');
    }

    public function forceNext(Request $request, $page){


        Session::put('forceNext', $page);
        return redirect(route('profile.setup', ['page' => $page]));

    }

    public function saveNext(Request $request){

        if($request->has('page')){

            Session::put('forceNext', $request->get('page'));
        }
        if($request->has('managerChatPage')){

            Session::put('managerChat', $request->get('managerChatPage'));
        }

        return json_encode(['success' => 1, 'page' => Session::get('forceNext')]);
    }

    public function index(Request $request){

        $user = Auth::user();
        $commonMethods = new CommonMethods();
        $genres = Genre::all();

        $data = [
            'genres' => $genres
        ];

        return view('pages.setup.simple.index', $data);
    }

    function isNotFilled($value) {

        return ($value == '' || $value == null) ? true : false;
    }

    public function fullWizard(Request $request, $page){

        $currentUrl = $request->url();
        $isStandalone = (strpos($currentUrl, 'standalone') !== false) ? true : false;

    	if(Auth::check() && !Auth::user()->is_buyer_only){

            $commonMethods = new CommonMethods();
            $user = Auth::user();
            $userPersonalDetails = $commonMethods::getUserRealDetails($user->id);
            $genres = Genre::orderBy('name', 'asc')->get();
            $story_images = $user->profile->story_images;
            $userSocialAccountDetails = $commonMethods::getUserSocialAccountDetails($user->id);
            $authorize_request_body = array(
                'response_type' => 'code',
                'scope' => 'read_write',
                'client_id' => Config('constants.stripe_connect_client_id')
            );
            $stripeUrl = Config('constants.stripe_connect_authorize_uri') . '?' . http_build_query($authorize_request_body) . '&redirect_uri='.Config('services.stripe.redirect').'&stripe_user[email]='.$user->email.'&stripe_user[business_name]='.$user->name.'&stripe_user[url]='.($user->username?route('user.home',['params' => $user->username]):'');
            $agents = User::where('apply_expert', 2)->orderBy('name', 'asc')->get()->filter(function ($user){
                return $user->expert;
            });

            if(Session::has('forceNext')){

                $forceN = Session::get('forceNext');
                Session::forget('forceNext');
                $forceNext = $forceN;
            }else{

                $forceNext = NULL;
            }

            if($request->isMethod('post')){

                if($request->has('pro_service')){

                    $response = (new ProfileController)->postUserService($request);
                }else if($request->has('title') && $request->has('element')){

                    $response = (new ProfileController)->saveUserPortfolio($request);
                }else if($request->has('seo_title')){

                    $response = (new ProfileController)->saveUserProfileSeo($request);
                }else if($request->has('value') && $request->has('pro_stream_tab')){

                    $response = (new ProfileController)->postYourNews($request);
                }else if($request->has('video_url')){

                    $response = (new ProfileController)->postUserCompetitionVideo($request);
                }else if($request->has('product_title') && $request->has('pro_product_price_option')){

                    $response = (new ProfileController)->postYourProduct($request);
                }else{

                    $response = (new ProfileController)->saveUserProfile($request);
                }

                if($page == 'design'){

                    $designError = $user->designStepError();
                    if($designError != ''){
                        Session::put('error', $designError);
                        $page = 'media';
                    }else{
                        $page == 'design';
                    }
                }

                if($page == 'personal' && $user->manager_chat == 1){

                    Session::put('managerChat', 'personal');
                    $nextPage = $page;
                }else{

                    if($page == 'portfolio' || $page == 'service' || $page == 'news'){

                        $nextPage = $page;
                    }else{

                        $nextPage = $user->setupWizardnNext($page);
                    }
                }

                return redirect(route('profile.setup.with.next', ['page' => $nextPage]));
            }

            //$setup = $user->setupProfileWizard();
            // if($page == 'username'){

            //     // step 2 of 19
            //     $title = 'Choose Your Username';
            //     $back = NULL;
            //     $next = NULL;
            //     //$forceNext = 'currency';
            // }else if($page == 'currency'){

            //     // step 3 of 19
            //     if(!$forceNext && $setup['username'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'username']));
            //     }
            //     $title = 'Choose Your Currency';
            //     $back = route('profile.setup.with.next', ['page' => 'username']);
            //     $next = NULL;
            //     //$forceNext = 'personal';
            // }else if($page == 'personal'){

            //     // step 4 of 19
            //     if(!$forceNext && $setup['currency'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'currency']));
            //     }
            //     $title = 'Your Personal Information';
            //     $back = route('profile.setup.with.next', ['page' => 'currency']);
            //     $next = NULL;
            //     //$forceNext = 'media';
            // }else if($page == 'media'){

            //     // step 5 of 19
            //     if(!$forceNext && $setup['personal'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'personal']));
            //     }
            //     $title = 'Add Media Information';
            //     $back = route('profile.setup.with.next', ['page' => 'personal']);
            //     $next = NULL;
            //     //$forceNext = 'design';
            // }else if($page == 'design'){

            //     // step 6 of 19
            //     if(!$forceNext && $setup['media'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'media']));
            //     }
            //     $title = 'Your Website Design';
            //     $back = route('profile.setup.with.next', ['page' => 'media']);
            //     $next = NULL;
            //     //$forceNext = 'bio';
            // }else if($page == 'bio'){

            //     // step 7 of 19
            //     if(!$forceNext && $setup['design'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'design']));
            //     }
            //     $title = 'Add Bio Information';
            //     $back = route('profile.setup.with.next', ['page' => 'design']);
            //     $next = NULL;
            //     //$forceNext = 'portfolio';
            // }else if($page == 'portfolio'){

            //     // step 8 of 19
            //     if(!$forceNext && $setup['bio'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'bio']));
            //     }
            //     $title = 'Add Portfolios';
            //     $back = route('profile.setup.with.next', ['page' => 'bio']);
            //     $next = NULL;
            //     //$forceNext = 'service';
            // }else if($page == 'service'){

            //     // step 9 of 19
            //     if(!$forceNext && $setup['portfolio'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'portfolio']));
            //     }
            //     $title = 'Add Services';
            //     $back = route('profile.setup.with.next', ['page' => 'portfolio']);
            //     $next = route('profile.setup.with.next', ['page' => 'domain']);
            //     //$forceNext = 'domain';
            // }else if($page == 'domain'){

            //     // step 10 of 19
            //     if(!$forceNext && $setup['service'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'service']));
            //     }
            //     $title = 'Connect Personal Domain';
            //     $back = route('profile.setup.with.next', ['page' => 'service']);
            //     $next = route('profile.setup.with.next', ['page' => 'news']);
            //     //$forceNext = 'domain';
            // }else if($page == 'news'){

            //     // step 11 of 19
            //     if(!$forceNext && $setup['domain'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'domain']));
            //     }
            //     $title = 'Add News';
            //     $back = route('profile.setup.with.next', ['page' => 'domain']);
            //     $next = route('profile.setup.with.next', ['page' => 'social']);
            //     //$forceNext = 'social';
            // }else if($page == 'social'){

            //     // step 12 of 19
            //     if(!$forceNext && $setup['news'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'news']));
            //     }
            //     $title = 'Connect Social Accounts';
            //     $back = route('profile.setup.with.next', ['page' => 'news']);
            //     $next = NULL;
            //     //$forceNext = 'video';
            // }else if($page == 'video'){

            //     // step 13 of 19
            //     if(!$forceNext && $setup['social'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'social']));
            //     }
            //     $title = 'Add YouTube Videos';
            //     $back = route('profile.setup.with.next', ['page' => 'social']);
            //     $next = route('profile.setup.with.next', ['page' => 'product']);
            //     //$forceNext = 'product';
            // }else if($page == 'product'){

            //     // step 14 of 19
            //     if(!$forceNext && $setup['videos'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'video']));
            //     }
            //     $title = 'Add Products';
            //     $back = route('profile.setup.with.next', ['page' => 'video']);
            //     $next = route('profile.setup.with.next', ['page' => 'music']);
            //     //$forceNext = 'music';
            // }else if($page == 'music'){

            //     // step 15 of 19
            //     if(!$forceNext && $setup['product'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'product']));
            //     }
            //     $title = 'Upload Music';
            //     $back = route('profile.setup.with.next', ['page' => 'product']);
            //     $next = route('profile.setup.with.next', ['page' => 'agent']);
            //     //$forceNext = 'agent';
            // }else if($page == 'agent'){

            //     // step 16 of 19
            //     if(!$forceNext && $setup['music'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'music']));
            //     }
            //     $title = 'Choose Your Agent';
            //     $back = route('profile.setup.with.next', ['page' => 'music']);
            //     $next = route('profile.setup.with.next', ['page' => 'subscription']);
            //     //$forceNext = 'subscription';
            // }else if($page == 'subscription'){

            //     // step 17 of 19
            //     if(!$forceNext && $setup['getAgent'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'agent']));
            //     }
            //     $title = 'Choose Your Subscription Plan';
            //     $back = route('profile.setup.with.next', ['page' => 'agent']);
            //     $next = route('profile.setup.with.next', ['page' => 'stripe']);
            //     //$forceNext = 'stripe';
            // }else if($page == 'stripe'){

            //     // step 18 of 19
            //     if(!$forceNext && $setup['subscription'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'subscription']));
            //     }
            //     $title = 'Connect Stripe Account';
            //     $back = route('profile.setup.with.next', ['page' => 'subscription']);
            //     $next = route('profile.setup.with.next', ['page' => 'finish']);
            //     //$forceNext = 'finish';
            // }else{

            //     // step 19 of 19
            //     if(!$forceNext && $setup['stripe'] == 0){
            //         return redirect(route('profile.setup', ['page' => 'stripe']));
            //     }
            //     $title = 'Finishing';
            //     $back = route('profile.setup', ['page' => 'stripe']);
            //     $next = NULL;
            //     //$forceNext = NULL;
            // }

            //Session::put('forceNext', $forceNext);

            $data = [

                'user' => $user,
                'userPersonalDetails' => $userPersonalDetails,
                'userSocialAccountDetails' => $userSocialAccountDetails,
                'page' => $page,
                'title' => 'Profile setup wizard',
                'genres' => $genres,
                'story_images' => $story_images,
                'commonMethods' => $commonMethods,
                'domain' => $user->customDomainSubscription,
                'stripeUrl' => $stripeUrl,
                'agents' => $agents,
                'isStandalone' => $isStandalone
            ];

            return view('pages.setup.index', $data);
        }else{

    		return 'No user';
    	}
    }
}

