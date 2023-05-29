<?php



namespace App\Http\Controllers;


use App\Models\CrowdfundBasket;

use App\Models\CustomerBasket;

use App\Models\CampaignPerks as CampaignPerk;

use App\Models\EmbedCode;

use App\Models\UserCampaign as UserCampaign;

use App\Models\Profile;

use App\Http\Controllers\UserNotificationController;

use App\Models\UserAlbum;

use Carbon\Carbon;

use App\Models\UserMusic;

use App\Models\UserProduct;

use App\Models\StripeCheckout;

use App\Models\StripeSubscription;

use App\Models\AgentQuestionnaire;

use App\Models\AgentQuestionnaireElement;

use App\Models\AgentContactRequest;

use App\Mail\AgentContactRequest as AgentContactR;

use App\Models\UserPortfolio;

use App\Models\PortfolioElement;

use App\Models\ContactQuestion;

use App\Models\ContactQuestionElement;

use App\Models\City;

use App\Models\Country;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Auth\AuthController;

use Illuminate\Http\Request;

use App\Models\Competition;

use App\Models\CompetitionVideo;

use App\Models\VideoStream;

use App\Http\Controllers\CommonMethods;

use App\Models\UserChat;

use App\Mail\License;

use App\Mail\Agent;

use App\Models\Address;


use Image;

use DB;

use PDF;

use Auth;

use Mail;

use Hash;

use App\Models\User;

use Session;

use App\Models\AgentContact;

use App\Models\UserChatGroup;

use App\Models\UserReview;

use App\Mail\AgentContact as AgentContactMailer;


class ReviewsController extends Controller

{

    public function __construct(){

        
    }
    

    public function index(Request $request){

        
    }

    public function create(Request $request){

        $user = Auth::user();
        $error = '';
        $success = '';

        $type = $request->get('pro_review_type');
        $name = $request->get('pro_review_name');
        $text = $request->get('pro_review_text');
        $rating = $request->get('pro_review_rating');
        $dateTime = $request->get('pro_review_date_time') != '' ? $request->get('pro_review_date_time') : NULL;
        $link = $request->get('pro_review_link') != '' ? $request->get('pro_review_link') : NULL;

        if($user){

            $userReview = new UserReview();
            $userReview->user_id = $user->id;
            $userReview->type = $type;
            $userReview->name = $name;
            $userReview->text = $text;
            $userReview->rating = $rating;
            $userReview->review_date_time = $dateTime;
            $userReview->link = $link;
            $userReview->save();
        }

        return Redirect::back();
    }

    public function update(Request $request, $id){

        $user = Auth::user();
        $error = '';
        $success = '';

        $userReview = UserReview::find($id);

        if($user && $userReview && $user->id == $userReview->user_id){

            $type = $request->get('pro_review_type');
            $name = $request->get('pro_review_name');
            $text = $request->get('pro_review_text');
            $rating = $request->get('pro_review_rating');
            $status = $request->get('pro_review_status');
            $dateTime = $request->get('pro_review_date_time') != '' ? $request->get('pro_review_date_time') : NULL;
            $link = $request->get('pro_review_link') != '' ? $request->get('pro_review_link') : NULL;

            $userReview->type = $type;
            $userReview->name = $name;
            $userReview->text = $text;
            $userReview->rating = $rating;
            $userReview->review_date_time = $dateTime;
            $userReview->link = $link;
            $userReview->status = $status;
            $userReview->save();
        }

        return Redirect::back();
    }

    public function delete(Request $request){

        $return['error'] = '';
        $return['success'] = 0;
        if(Auth::check() && $request->has('id')){

            $user = Auth::user();
            $userReview = UserReview::find($request->id);

            if($userReview && $userReview->user_id == $user->id){
                
                $return['success'] = $contact->delete();
            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

        return json_encode(['success' => $return['success'], 'error' => $return['error']]);
    }
}

