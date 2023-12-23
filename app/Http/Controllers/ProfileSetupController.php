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
        $userData = Session::get('register.data');

        $data = [
            'genres' => $genres,
            'prefill' => $userData
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

                if (!$isStandalone) {

                    return redirect(route('profile.setup.with.next', ['page' => $nextPage]));
                }
            }

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

