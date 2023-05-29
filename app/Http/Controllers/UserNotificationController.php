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

use App\Models\City;

use App\Models\Country;

use App\Models\UserChatGroup;

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

use App\Mail\ProfferedProject;

use App\Models\UserNotification;


use DB;

use PDF;

use Auth;

use Mail;

use Hash;

use App\Models\User;

use Session;



class UserNotificationController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity');
    }
    

    public function index(Request $request){

        
    }

    public function create(Request $request){

        $data = ['success' => 0, 'error' => 0, 'errorMessage' => ''];
        $commonMethods = new CommonMethods();
        
        $customerId = $request->has('customer') ? $request->get('customer') : (Auth::check() ? Auth::user() : NULL);
        $customer = $customerId ? User::find($customerId) : NULL;
        $userId = $request->has('user') ? $request->get('user') : NULL;
        $user = $userId ? User::find($userId) : NULL;
        $type = $request->get('type');
        $sourceId = $request->has('source_id') ? $request->get('source_id') : NULL;

        $notification = new UserNotification();
        $notification->user_id = $user ? $user->id : NULL;
        $notification->customer_id = $customer ? $customer->id : NULL;
        $notification->type = $type;
        $notification->source_table_id = $sourceId;
        $notification->save();
        $data['success'] = 1;

        return json_encode($data);
    }

    public function updateNotifications(Request $request){

        $data = ['success' => 0, 'error' => 0, 'errorMessage' => '', 'html' => '', 'lastChatNotifId' => 0 ];
        $commonMethods = new CommonMethods();
        if($request->isMethod('post')){

            if(Auth::check()){

                $user = Auth::user();
                $mode = $request->get('mode');
                if($mode == 'fetch'){

                    $id = $request->get('id');
                    $query = UserNotification::where('user_id', $user->id);
                    if($id){
                        $query = $query->where('id', '>', $id);
                    }
                    $userNotifs = $query->orderBy('id', 'desc')->get();

                    if(count($userNotifs)){

                        foreach ($userNotifs as $notification) {
                            $data['html'] .= \View::make('parts.user-notification-item', ['notification' => $notification, 'commonMethods' => $commonMethods])->render();

                            if($notification->type == 'chat'){
                                $data['lastChatNotifId'] = $userNotifs->first()->id;
                            }
                        }
                    }

                    if($request->has('fetch_activity_status')){

                        $chatActivity = explode('_', $request->get('fetch_activity_status'));
                        if($chatActivity[0] == 'group'){

                            $group = UserChatGroup::find($chatActivity[1]);
                            if($group->contact && $group->agent){

                                if($user->id == $group->agent_id){
                                    $groupStatus[] = $group->contact->id.'_'.$group->contact->activityStatus();
                                }else if($user->id == $group->contact_id){
                                    $groupStatus[] = $group->agent->id.'_'.$group->agent->activityStatus();
                                }else{
                                    $groupStatus[] = $group->contact->id.'_'.$group->contact->activityStatus();
                                    $groupStatus[] = $group->agent->id.'_'.$group->agent->activityStatus();
                                }

                                if(is_array($group->other_members) && count($group->other_members)){
                                    foreach($group->other_members as $memberId){
                                        if(in_array($user->id, $group->other_members)){
                                            continue;
                                        }
                                        $member = User::find($memberId);
                                        if($member){
                                            $groupStatus[] = $memberId.'_'.$member->activityStatus();
                                        }
                                    }
                                }
                                if($group->otherAgent){
                                    $groupStatus[] = $group->other_agent_id.'_'.$group->otherAgent->activityStatus();
                                }
                                $data['data']['partnerActivityStatus'] = implode('::', $groupStatus);
                            }
                        }else if($chatActivity[0] == 'partner'){

                            $partner = User::find($chatActivity[1]);
                            $data['data']['partnerActivityStatus'] = $partner->activityStatus();
                        }
                    }

                    $data['success'] = 1;
                }else if($mode == 'update'){

                    $update = UserNotification::where(['user_id' => $user->id])->whereNull('seen')->update(['seen' => 1]);
                    $data['success'] = 1;
                }
            }else{

                $data['errorMessage'] = 'User is not logged in';
            }

        }else{

            $data['errorMessage'] = 'Request method not allowed';
        }

        return json_encode($data);
    }
}

