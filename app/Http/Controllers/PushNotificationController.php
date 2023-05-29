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

use App\Models\UserDevice;

use App\Mail\AgentContact as AgentContactMailer;


class PushNotificationController extends Controller

{

    public function __construct(){

        
    }

    public function register(Request $request){

        $success = 0;
        $error = '';
        $deviceId = NULL;
        $platform = NULL;
        $userId = NULL;

        if($request->has('platform') && $request->has('deviceId') && $request->has('userId')){

            $platform = base64_decode($request->get('platform'));
            $deviceId = base64_decode($request->get('deviceId'));
            $userId = base64_decode($request->get('userId'));

            $checkDeviceId = UserDevice::where(['device_id' => $deviceId, 'user_id' => $userId])->get()->first();
            if($checkDeviceId){

                $error = 'The device id already exists';
            }else{

                $userDevice = new UserDevice();
                $userDevice->user_id = $userId;
                $userDevice->device_id = $deviceId;
                $userDevice->platform = $platform;
                $userDevice->save();

                $success = 1;
            }
        }else{

            $error = 'No or incomplete data received';
        }

        echo json_encode(['device_id' => $deviceId, 'platform' => $platform, 'user_id' => $userId, 'success' => $success, 'error' => $error]);
    }

    public function user(Request $request, $redirectUrl, $userId){

        $data = [

            'redirectUrl' => base64_decode($redirectUrl)
        ];

        return view('pages.push-notif-register', $data);
        /*$data = array('platform' => 'YW5kcm9pZA==', 'deviceId' => 'YWJjMTIz', 'userId' => 'NjI3');
        $url = 'https://www.1platform.tv/push-notification/register';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch);
        curl_close ($ch);
        print($output);exit;*/
    }

    public function send($deviceId, $title, $message, $platform){

        $from = Config('constants.fcmServerKey');

        $notification = [

            'body' => $message,
            'title' => $title,
            'receiver' => 'erw',
            'icon' => 'https://image.flaticon.com/icons/png/512/270/270014.png',
            'sound' => 'default',
            'platform' => $platform,
            'priority' => 'high',
            'time_to_live' => 86400,
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
        ];

        $fields = [

            'to' => $deviceId,
            'notification' => $notification
        ];
        
        $headers = array(
            'Authorization: key='.$from,
            'Content-Type: application/json'
        );
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

