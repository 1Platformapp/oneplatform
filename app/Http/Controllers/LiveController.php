<?php



namespace App\Http\Controllers;







use App\Models\AccountType;

use App\Models\CustomerBasket;

use App\Models\Profile;

use App\Models\UserMusic;

use App\Models\UserProduct;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Auth\AuthController;

use Illuminate\Http\Request;

use App\Models\Competition;

use App\Models\UserCampaign;

use App\Models\Expert;

use App\Http\Controllers\CommonMethods;



use DB;

use Auth;

use App\Models\User;

use Session;







/**



 * Class LiveController



 * @package App\Http\Controllers



 */



class LiveController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity');
    }

    

    public function index( Request $request )
    {
        return redirect()->back();
        $commonMethods = new CommonMethods();

        $experts = Expert::with(['user' => function ($query) {
                $query->where(['apply_expert' => 2, 'active' => 1]);
        }])->orderBy('id', 'desc')->get();

        $basket = $commonMethods::getCustomerBasket();

        if (session::has('loadVideo')) {

            $videoInfo = Session::get('loadVideo');
            Session::forget('loadVideo');
            $explode = explode('~', $videoInfo);
            $userrId = $explode[1];

            if($userrId > 0){
                $userId = $explode[1];
                $user = User::find($userId);
                $defaultVideoId = $user->profile->user_bio_video_id;
                $defaultVideoTitle = $commonMethods->getVideoTitle($user->profile->user_bio_video_url);
            }else{
                $user = null;
                //$defaultVideoId = 'liCiozL6bI0';
                $defaultVideoId = '0cSXq4TYIIk';
                $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);
            }
        }else{

            $user = null;
            $defaultVideoId = '0cSXq4TYIIk';
            //$defaultVideoId = 'liCiozL6bI0';
            $defaultVideoTitle = $commonMethods->getVideoTitle($defaultVideoId);
        }

        if($user){

            $userCampaignDetails = $commonMethods->getUserRealCampaignDetails($user->id);

            $userPersonalDetails = $commonMethods->getUserRealDetails($user->id);

            $allPastProjects = UserCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();
        }


        $data   = [

            'user' => $user,

            'commonMethods' => $commonMethods,

            'userCampaignDetails' => isset($userCampaignDetails) ? $userCampaignDetails : null,

            'userPersonalDetails' => isset($userPersonalDetails) ? $userPersonalDetails : null,

            'basket' => $basket,

            'defaultVideoId' => $defaultVideoId,

            'allPastProjects' => isset($allPastProjects) ? $allPastProjects : null,

            'experts' => $experts,

            'defaultVideoTitle' => $defaultVideoTitle,
        ];







        return view( 'pages.live', $data );



    }



}



