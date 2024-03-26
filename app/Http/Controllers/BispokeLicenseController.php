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
use App\Models\AgentContact;

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

use App\Mail\License;
use App\Mail\Agent;

use DB;
use PDF;
use Auth;
use Mail;
use Hash;
use Session;
use Image;

class BispokeLicenseController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity');
    }


    public function index(Request $request)

    {


    }

    public function sendMessage(Request $request){

        $success = 0;
        $error = '';
        $id = 0;

        if($request->has('login_email') && $request->has('login_password')){

            $email = $request->get('login_email');
            $password = $request->get('login_password');

            $user = User::where(['email' => $email])->first();
            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user);
            }else{
                $error = 'Email/Password is not correct';
                $user = null;
            }
        }else if(Auth::check()){

            $user = Auth::user();
        }else{
            $error = 'No user';
            $user = null;
        }

        if($user){

            if($request->has('message')){

                $admins = Config('constants.admins');
                $type = $request->has('type') ? $request->get('type') : '';
                $message = $request->get('message');
                $group = NULL;
                if($request->has('music') && $request->get('music') != ''){

                    $musicId = $request->get('music');
                    $music = UserMusic::find($musicId);
                    $recipient = $music->user;
                }else if($request->has('recipient')){
                    $recipientId = $request->get('recipient');
                    if($recipientId == 'admin'){

                        $recipientId = 1;
                    }

                    $recipient = User::find($recipientId);
                    if(!$recipient){

                        $error = 'No recipient known';
                    }
                }else if($request->has('group')){

                    $groupId = $request->get('group');
                    $groupRecipientId = $request->get('groupRecipient');
                    $group = UserChatGroup::find($groupId);
                    $groupRecipient = User::find($groupRecipientId);
                    $recipient = $groupRecipient;
                }else if($request->has('type') == 'platform-manager-first'){

                    $recipient = User::find(config('constants.admins')['1platformagent']['user_id']);
                }else{
                    $error = 'Bad data';
                }

                if($user->chat_switch != 1 || ($recipient && $recipient->chat_switch != 1)){

                    $error = 'Message cannot be delivered';
                }

                if($recipient && $user->id == $recipient->id){

                    $error = 'Message cannot be delivered';
                }

                if($error == ''){

                    if($type == 'initialize'){

                        $chat = new UserChat();
                        $chat->sender_id = NULL;
                        $chat->group_id = NULL;
                        $chat->recipient_id = NULL;
                        $chat->message = NULL;
                        $chat->music_id = NULL;

                        $chat->save();
                    }else{

                        if($group){
                            $currentChat = UserChat::where(['group_id' => $group->id])->orderBy('id', 'desc')->get();
                        }else if($recipient){
                            $currentChat = UserChat::where(['recipient_id' => $recipient->id, 'sender_id' => $user->id])->orderBy('id', 'desc')->get();
                        }else{
                            $currentChat = NULL;
                        }

                        if($type == 'finalize' && $request->has('chat')){
                            $chat = UserChat::find($request->get('chat'));
                        }else{
                            $chat = new UserChat();
                        }

                        $chat->sender_id = $user->id;
                        $chat->group_id = $group ? $group->id : NULL;
                        $chat->recipient_id = $recipient ? $recipient->id : NULL;
                        $chat->message = $message;
                        $chat->music_id = isset($music) && $music ? $music->id : NULL;

                        $chat->save();

                        $redirectUrl = base64_encode(route('agency.dashboard.tab', ['tab' => 'contact-management']));

                        if($recipient && $type == 'first'){
                            $result = Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new License('bespokeOffer', $recipient, $user, $chat));
                            if(count($recipient->devices)){

                                foreach ($recipient->devices as $device) {

                            		if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                            			$fcm = new PushNotificationController();
                            			$return = $fcm->send($device->device_id, 'Message from '.$user->firstName(), str_limit($chat->message, 24), $device->platform, 'chat', $redirectUrl);
                            		}
                            	}
                            }
                        }else if($recipient && $currentChat && $currentChat->first()){
                            $diffMins = $currentChat->first()->created_at->diffInMinutes();
                            if($diffMins >= 15){
                                $result = Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new Agent($chat));

                                if(count($recipient->devices)){

                                	foreach ($recipient->devices as $device) {

                                		if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                                			$fcm = new PushNotificationController();
                                			$return = $fcm->send($device->device_id, 'Message from '.$user->firstName(), str_limit($chat->message, 24), $device->platform, 'chat', $redirectUrl);
                                		}
                                	}
                                }
                            }
                        }else if($recipient && $type == 'platform-manager-first'){

                            // default reply for user from manager
                            $chat = new UserChat();
                            $chat->sender_id = $recipient->id;
                            $chat->group_id = NULL;
                            $chat->recipient_id = $user->id;
                            $chat->message = 'Hi, I am david. I will be with you shortly';
                            $chat->music_id = NULL;
                            $chat->save();

                            $result = Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new Agent($chat));

                            if(count($recipient->devices)){

                                foreach ($recipient->devices as $device) {

                                    if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                                        $fcm = new PushNotificationController();
                                        $return = $fcm->send($device->device_id, 'Message from '.$user->firstName(), str_limit($chat->message, 24), $device->platform, 'chat', $redirectUrl);
                                    }
                                }
                            }
                        }else if($group && count($currentChat) == 0 && $group->contact && $group->agent){
                            //first message in this group
                            $gRecipient = $user->id == $group->contact->id ? $group->agent : $group->contact;
                            $result = Mail::to($gRecipient->email)->bcc(Config('constants.bcc_email'))->send(new Agent($chat));

                            if(count($gRecipient->devices)){

                            	foreach ($gRecipient->devices as $device) {

                            		if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                            			$fcm = new PushNotificationController();
                            			$return = $fcm->send($device->device_id, 'Message from '.$user->firstName(), str_limit($chat->message, 24), $device->platform, 'chat', $redirectUrl);
                            		}
                            	}
                            }
                        }else if($group && count($currentChat) > 0 && $group->contact && $group->agent){
                        	$diffMins = $currentChat->first()->created_at->diffInMinutes();
                        	if($diffMins >= 15){
                        	    $notifMembers = [];
                        	    $notifMembers[] = $group->agent_id;
                        	    $notifMembers[] = $group->contact_id;
                        	    if(count($group->other_members)){
                        	        $notifMembers = array_merge($notifMembers,$group->other_members);
                        	    }
                        	    if(($key = array_search($user->id, $notifMembers)) !== false) {
                        	        unset($notifMembers[$key]);
                        	    }
                        	    foreach ($notifMembers as $value) {
                        	    	$recip = User::find($value);
                        	        $result = Mail::to($recip->email)->bcc(Config('constants.bcc_email'))->send(new Agent($chat));

                        	        if(count($recip->devices)){

                        	        	foreach ($recip->devices as $device) {

                        	        		if(($device->platform == 'android' || $device->platform == 'ios') && $device->device_id != NULL){

                        	        			$fcm = new PushNotificationController();
                        	        			$return = $fcm->send($device->device_id, 'Message from '.$user->firstName(), str_limit($chat->message, 24), $device->platform, 'chat', $redirectUrl);
                        	        		}
                        	        	}
                        	        }
                        	    }
                        	}
                        }

                        if($group && $group->contact && $group->agent){
                        	$notifMembers = [];
                            $notifMembers[] = $group->agent_id;
                            $notifMembers[] = $group->contact_id;
                            if(count($group->other_members)){
                                $notifMembers = array_merge($notifMembers,$group->other_members);
                            }
                            if($group->other_agent_id){
                                $notifMembers[] = $group->other_agent_id;
                            }
                            if(($key = array_search($user->id, $notifMembers)) !== false) {
                                unset($notifMembers[$key]);
                            }
                            foreach ($notifMembers as $value) {
                                $userNotification = new UserNotificationController();
                                $request->request->add(['user' => $value,'customer' => $user->id,'type' => 'chat','source_id' => $chat->id]);
                                $response = json_decode($userNotification->create($request), true);
                            }
                        }else if($recipient){
                            $userNotification = new UserNotificationController();
                            $request->request->add(['user' => $recipient->id,'customer' => $user->id,'type' => 'chat','source_id' => $chat->id]);
                            $response = json_decode($userNotification->create($request), true);
                        }
                    }

                    $id = $chat->id;
                    $success = 1;
                }
            }else if($request->has('attachment') && $request->has('chat')){

                $chat = UserChat::find($request->get('chat'));
                if($chat){

                    $id = $chat->id;
                    $response = $chat->attachFile($request->file('attachment'));
                    if($response === true){
                        $success = 1;
                    }else{
                        $error = $response;
                    }
                }else{
                    $error = 'no chat found';
                }
            }else{

                $error = 'No/insufficient request data';
            }
        }

        return json_encode(['success' => $success, 'error' => $error, 'id' => $id]);
    }

    public function addAgreement(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();

        if(Auth::check()){

            $user = Auth::user();
        }

        if($user && $request->has('terms') && $request->has('music') && $request->has('price') && $request->has('license')){

            $message = $request->get('terms');
            $endTermSelect = $request->get('endTermSelect');
            $endTerm = $request->get('endTerm');
            $musicId = $request->get('music');
            $license = $request->get('license');
            $price = $request->get('price');
            $music = UserMusic::find($musicId);
            $type = $request->get('type');
            $customer = $request->get('customer');

            if($type == 'partner-purchase'){

                $recipientId = $request->get('id');
                $recipient = User::find($recipientId);
            }else if($type == 'group-purchase'){

                $agentContactId = $request->get('id');
                $agentContact = AgentContact::find($agentContactId);

                if(!$agentContact){
                    return json_encode(['success' => 0, 'error' => 'unknown contact']);
                }

                $group = UserChatGroup::where(['agent_id' => $agentContact->agent_id, 'contact_id' => $agentContact->contact_id])->get()->first();

                if(!$group){
                    return json_encode(['success' => 0, 'error' => 'unknown group']);
                }

                if($user->id != $group->contact_id && $user->id != $group->agent_id && !in_array($user->id, $group->other_members)){
                    return json_encode(['success' => 0, 'error' => 'You cannot add project or agreement in this chat']);
                }

                if($customer == 'partner' && $user->isAgent() && $group->contact){
                    $recipient = $group->contact;
                }else if($customer == 'partner' && !$user->isAgent() && $group->agent){
                    $recipient = $group->agent;
                }else{
                    $recipient = User::find($customer);
                }
            }

            if($music && $music->user->id == $user->id && $recipient){

                $sellerDetails = $commonMethods->getUserRealDetails($user->id);
                $buyerDetails = $commonMethods->getUserRealDetails($recipient->id);
                $data = ['sellerDetails' => $sellerDetails, 'buyerDetails' => $buyerDetails, 'terms' => $message, 'endTermSelect' => $endTermSelect, 'endTerm' => $endTerm, 'license' => $license, 'music' => $music, 'price' => $price, 'commonMethods' => $commonMethods];
                $ticketNumber = strtoupper('lic_'.uniqid()).'.pdf';
                $fileName = "bespoke-licenses/".$ticketNumber;
                PDF::loadView('pdf.bespoke-license', $data)->setPaper([0, 0, 700, 1000], 'portrait')->setWarnings(false)->save($fileName);

                $chat = new UserChat();
                $chat->sender_id = $user->id;
                $chat->recipient_id = $recipient->id;
                $chat->group_id = isset($group) ? $group->id : NULL;
                $chat->message = $message;
                $chat->agreement = [
                    'filename'        => $ticketNumber,
                    'music'           => $music->id,
                    'price'           => $price,
                    'status'          => 'Pending',
                    'endTermSelect'   => $endTermSelect,
                    'endTerm'         => $endTerm,
                    'license'         => $license,
                ];

                $chat->save();

                $result = Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new License('bespokeAgreement', $user, $recipient, $chat));
                $userNotification = new UserNotificationController();
                $request->request->add(['user' => $recipient->id,'customer' => $user->id,'type' => 'chat','source_id' => $chat->id]);
                $response = json_decode($userNotification->create($request), true);

                $success = 1;
            }else{

                $error = 'No music';
            }
        }else{

            $error = 'No/insufficient request data';
        }

        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function agreementResponse(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();

        if(Auth::check()){

            $user = Auth::user();
        }

        if($user && $request->has('response') && $request->has('license')){

            $chatId = $request->get('license');
            $response = $request->get('response');
            $chat = UserChat::find($chatId);

            if($chat && $chat->recipient->id == $user->id && count($chat->agreement)){

                $chat->agreement = [
                    'filename' => $chat->agreement['filename'],
                    'music'    => $chat->agreement['music'],
                    'price'    => isset($chat->agreement['price'])?$chat->agreement['price']:0,
                    'status'   => $response,
                ];

                $chat->save();
                $success = 1;
            }else{

                $error = 'Not allowed';
            }
        }else{

            $error = 'No/insufficient request data';
        }

        return json_encode(['success' => $success, 'error' => $error]);
    }
}

