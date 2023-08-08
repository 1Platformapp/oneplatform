<?php



namespace App\Http\Controllers;


use App\Models\CrowdfundBasket;

use App\Models\CustomerBasket;

use App\Models\CampaignPerks as CampaignPerk;

use App\Http\Controllers\UserNotificationController;

use App\Models\EmbedCode;

use App\Models\UserCampaign as UserCampaign;

use App\Models\Profile;

use App\Models\AgentContact;

use App\Models\UserAlbum;

use App\Models\UserMusic;

use App\Models\UserProduct;

use App\Models\StripeCheckout;

use App\Models\StripeSubscription;

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

use App\Mail\ProfferedProject;

use App\Mail\ProfferedProduct;

use App\Models\UserChatGroup;


use DB;

use PDF;

use Auth;

use Mail;

use Hash;

use App\Models\User;

use Session;



class ProfferProductController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity');
    }


    public function index(Request $request)

    {


    }

    public function create(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();

        if(Auth::check()){

            $user = Auth::user();
        }

        if($user && $request->has('product') && $request->has('price')){


            $productId = $request->get('product');
            $price = $request->get('price');
            $product = UserProduct::find($productId);
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

            if($recipient && $product && $product->user_id == $user->id){

                $sellerDetails = $commonMethods->getUserRealDetails($user->id);
                $buyerDetails = $commonMethods->getUserRealDetails($recipient->id);
                $data = ['sellerDetails' => $sellerDetails, 'buyerDetails' => $buyerDetails, 'price' => $price, 'product' => $product, 'commonMethods' => $commonMethods];
                $ticketNumber = strtoupper('product_'.uniqid()).'.pdf';
                $fileName = "proffered-product/".$ticketNumber;
                PDF::loadView('pdf.proffer-product', $data)->setPaper('a4', 'portrait')->setWarnings(false)->save($fileName);

                $chat = new UserChat();
                $chat->sender_id = $user->id;
                $chat->recipient_id = $recipient->id;
                $chat->group_id = isset($group) ? $group->id : NULL;
                $chat->message = NULL;
                $chat->product = [
                    'filename'        => $ticketNumber,
                    'id'              => $productId,
                    'price'           => $price,
                    'status'          => 'Pending',
                    'title'           => $product->title,
                ];

                $chat->save();

                $result = Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new ProfferedProduct('create', $user, $recipient, $chat));
                $userNotification = new UserNotificationController();
                $request->request->add(['user' => $recipient->id,'customer' => $user->id,'type' => 'chat','source_id' => $chat->id]);
                $response = json_decode($userNotification->create($request), true);

                $success = 1;
            }else{

                $error = 'No recipient';
            }
        }else{

            $error = 'No/insufficient request data';
        }

        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function productResponse(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();

        if(Auth::check()){

            $user = Auth::user();
        }

        if($user && $request->has('response') && $request->has('product')){

            $chatId = $request->get('product');
            $response = $request->get('response');
            $chat = UserChat::find($chatId);

            if($chat && $chat->recipient->id == $user->id && count($chat->product)){

                $chat->product = [
                    'filename' => $chat->product['filename'],
                    'id'       => $chat->product['id'],
                    'price'    => isset($chat->product['price'])?$chat->product['price']:0,
                    'status'   => $response,
                    'title'    => 'Product',
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

    public function downLoadPDF($filename, $title){

        $path = 'proffered-product/'.$filename;
        $explodedFileName = explode('.', $filename);
        $title .= ' - 1Platform TV';

        header('Content-Length: '.filesize($path));
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$title.'.'.$explodedFileName[sizeof($explodedFileName)-1]);
        readfile($path);
        exit;
    }
}

