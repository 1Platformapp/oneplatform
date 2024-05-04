<?php


namespace App\Http\Controllers;

use PDF;
use Auth;
use Mail;

use Image;
use Session;
use App\Models\User;
use App\Models\Skill;
use App\Models\Contract;
use App\Models\UserChat;
use App\Models\AgentContact;
use Illuminate\Http\Request;
use App\Models\UserChatGroup;
use App\Models\AgencyContract;
use App\Models\StripeCheckout;

use Illuminate\Support\Facades\DB;

use App\Models\IndustryContactRegion;
use App\Http\Controllers\CommonMethods;
use App\Models\SkillManagementPlanTask;
use App\Models\IndustryContactCategoryGroup;
use App\Http\Controllers\IndustryContactController;
use App\Mail\AgencyContract as AgencyContractMailer;

class AgencyController extends Controller
{
    public function __construct(){

        $this->middleware('agency.authentication');

        $this->middleware('user.update.activity', ['except' => [
            'restricted',
        ]]);
    }

    public function index(Request $request)
    {
        $commonMethods = new CommonMethods();
        $user = Auth::user();
        $isAgent = $user->isAgent();

        $fans = $topSales = [];
        $singlesSold = $albumsSold = $totalRevenue = $productsSold = 0;
        /*$instantPurchases = StripeCheckout::where('customer_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
        $instantSales = StripeCheckout::where('user_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
        $crowdfundPurchases = StripeCheckout::where('customer_id', $user->id)->where('type', 'crowdfund')->orderBy('id' , 'desc')->get();
        $crowdfundSales = StripeCheckout::where('user_id', $user->id)->where('type', 'crowdfund')->orderBy('id' , 'desc')->get();
        $topSales = StripeCheckout::where('user_id', $user->id)->orderBy('id' , 'desc')->take(5)->get();
        foreach ($instantSales as $key => $checkout) {
            foreach ($checkout->instantCheckoutItems as $key => $instantCheckoutItem) {

                if($instantCheckoutItem->type == 'music'){
                    $singlesSold++;
                }
                if($instantCheckoutItem->type == 'album'){
                    $albumsSold++;
                }
                if($instantCheckoutItem->type == 'product'){
                    $productsSold++;
                }
                if($instantCheckoutItem->type == 'custom-product'){
                    $productsSold++;
                }
                if($checkout->customer && !in_array($checkout->customer->id, $fans)){
                	$fans[] = $checkout->customer->id;
                }
            }

            $checkAmount = $checkout->application_fee ? $checkout->amount - $checkout->application_fee : $checkout->amount;
            $totalRevenue += $commonMethods->convert($checkout->currency, strtoupper($user->profile->default_currency), $checkAmount);
        }
        foreach ($crowdfundSales as $key => $checkout) {

            if($checkout->stripe_charge_id){

                $totalRevenue += $commonMethods->convert($checkout->currency, strtoupper($user->profile->default_currency), $checkout->amount);
            }
            if($checkout->customer && !in_array($checkout->customer->id, $fans)){
                $fans[] = $checkout->customer->id;
            }
        }*/

        $contacts = AgentContact::where(function($q) use ($user) {
            $q->where('contact_id', $user->id)->orWhere('agent_id', $user->id);
        })->orderBy('id', 'desc')->get();

        $chatGroups = $user->chatGroups();

        if(!$isAgent){

            if(count($contacts) && $contacts->first()->agentUser){

                $agentContact = $contacts->first();
                $agents = User::where('apply_expert', 2)->where('id', '<>', $contacts->first()->agentUser->id)->get()->filter(function ($user){
                    return $user->expert && $user->expert->status == 1;
                });
            }else{

                $agentContact = NULL;
                $agents = User::where('apply_expert', 2)->get()->filter(function ($user){
                    return $user->expert && $user->expert->status == 1;
                });
                $contacts = [];
            }
        }else{

            $agents = [];
            $agentContact = NULL;
        }

        $myContracts = count($contacts) ? AgencyContract::whereIn('contact_id', $contacts->pluck('id')->all())->get() : [];

        $purchaseParticulars['fans'] = $fans;
        $purchaseParticulars['singles_sold'] = $singlesSold;
        $purchaseParticulars['albums_sold'] = $albumsSold;
        $purchaseParticulars['products_sold'] = $productsSold;
        $purchaseParticulars['total_revenue'] = $totalRevenue;

        if (Session::has('dash-tab')) {
            $tab = Session::get('dash-tab');
        }

        if (Session::has('dash-sub-tab')) {
            $subTab = Session::get('dash-sub-tab');
        }

        if (Session::has('dash-info')) {
            $info = Session::get('dash-info');
        }

        if (Session::has('me-page')) {
            $mePage = Session::get('me-page');
        }

        if($user->expert && $user->apply_expert == 2){

            if($user->expert->pdf == NULL){
                $user->prepareExpertAgreement();
            }
        }

        $data   = [

            'commonMethods' => $commonMethods,
            'user' => $user,
            'purchaseParticulars' => $purchaseParticulars,
            'topSales' => $topSales,
            'contracts' => Contract::all(),
            'agencyContracts' => [],
            'agents' => $agents,
            'isAgent' => $isAgent,
            'myContracts' => $myContracts,
            'chatGroups' => $chatGroups,
            'agentContact' => $agentContact,
            'contacts' => $contacts,
            'tab' => isset($tab) ? $tab : '',
            'subTab' => isset($subTab) ? $subTab : '',
            'info' => isset($info) ? $info : '',
            'mePage' => isset($mePage) ? $mePage : '',
        ];

        return view('pages.admin-home', $data);
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        $user->hide_account = 1;

        $user->save();
        Auth::logout();

        return redirect(route('login'));
    }

    public function restoreAccount($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->hide_account = null;
            $user->save();

            return response(['message' => 'Account restored successfully'], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 504);
        }
    }

    public function dashboardWithTab(Request $request, $tab, $subTab = null)
    {
        Session::flash('dash-tab', $tab);
        if($tab == 'my-transactions') {
            Session::flash('dash-sub-tab', $subTab ? $subTab : '');
        } elseif ($tab == 'contact-management'){
            Session::flash('dash-sub-tab', $request->subTab ?? '');
        }

        return redirect(route('agency.dashboard'));
    }

    public function dashboardWithInfo(Request $request, $info)
    {
        Session::flash('dash-info', $info);
        return redirect(route('agency.dashboard'));
    }

    public function setSession(Request $request, $tab){

        Session::put('dash-tab', $tab);
        return json_encode(['success' => $tab]);
    }

    public function addContractForm(Request $request, $id, $contactId)
    {
        $user = Auth::user();

        if(!$user->hasActivePaidSubscription()){

            return redirect(route('agency.dashboard'));
        }

        $commonMethods = new CommonMethods();
        $contract = Contract::find($id);
        $agentContact = AgentContact::find($contactId);
        if($contract){

            $data   = [

                'commonMethods' => $commonMethods,
                'contract' => $contract,
                'user' => $user,
                'agentContact' => $agentContact,
                'action' => 'add'
            ];

            return view('pages.admin-add-contract', $data);
        }
    }

    public function addContractFormPreview(Request $request, $id)
    {
        $user = Auth::user();

        $commonMethods = new CommonMethods();
        $contract = Contract::find($id);
        if($contract){

            $data   = [

                'commonMethods' => $commonMethods,
                'contract' => $contract,
                'user' => $user,
                'action' => 'add'
            ];

            return view('pages.admin-add-contract-preview', $data);
        }
    }

    public function editContractForm(Request $request, $id)
    {
        $user = Auth::user();

        if(!$user->hasActivePaidSubscription()){

            return redirect(route('agency.dashboard'));
        }

        $commonMethods = new CommonMethods();
        $agencyContract = AgencyContract::find($id);
        $contract = Contract::find($agencyContract->contract_id);
        if($agencyContract && $agencyContract->contact && count($agencyContract->signatures) < 2){

            if(($agencyContract->creator == 'agent' && $agencyContract->contact->agentUser->id == $user->id) || ($agencyContract->creator == 'artist' && $agencyContract->contact->contactUser->id == $user->id)){

                // owner of the contract can edit
                $data   = [

                    'commonMethods' => $commonMethods,
                    'agencyContract' => $agencyContract,
                    'contract' => $contract,
                    'user' => $user,
                    'action' => 'edit'
                ];

                return view('pages.admin-add-contract', $data);
            }else{

                return 'Error: restricted access';
            }
        }else{

            return 'Error: no or restricted access';
        }
    }

    public function viewContractForm(Request $request, $id)
    {
        $commonMethods = new CommonMethods();
        $user = Auth::user();
        $contract = AgencyContract::find($id);
        if($contract && count($contract->signatures) < 2){

            $data   = [

                'commonMethods' => $commonMethods,
                'contract' => $contract,
                'user' => $user
            ];

            return view('pages.admin-view-contract', $data);
        }else{

            return 'Error: no or restricted access';
        }
    }

    public function createContract(Request $request, $id, $contactId)
    {
        $user = Auth::user();

        if(!$user->hasActivePaidSubscription()){

            return 'Unauthorized access';
        }

        $contract = Contract::find($id);
        $agentContact = AgentContact::where(['id' => $contactId, 'approved' => 1])->get()->first();

        if(!$contract){

            return 'Error: no contract found';
        }

        if(!$agentContact){

            return 'Error: contact not approved yet';
        }

        $data = $request->get('data');
        $terms = $request->get('terms');
        $contractName = $request->get('name') != '' ? $request->get('name') : $contract->title;

        $extension = explode('/', mime_content_type($data))[1];
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        $fileName = rand(100000, 999999).'.'.$extension;
        file_put_contents(public_path('signatures/').$fileName, $imageData);
        if($agentContact->agentUser->id == $user->id){
            $signatures = ['agent' => $fileName];
            $creator = 'agent';
            $recipient = $agentContact->contactUser;
            $legalName = ['agent' => $request->get('legalName')];
        }else if($agentContact->contactUser->id == $user->id){
            $signatures = ['artist' => $fileName];
            $creator = 'artist';
            $recipient = $agentContact->agentUser;
            $legalName = ['artist' => $request->get('legalName')];
        }else{
            $signatures = [];
            $creator = '';
        }

        $contractDetails = $request->contractBody ?? '';
        // $contractDetails = ['body' => str_replace(array("'", "\""), " ", $contract->body), 'data' => $request->get('inputData')];

        $agencyContract = new AgencyContract();
        $agencyContract->contact_id = $contactId;
        $agencyContract->contract_id = $id;
        $agencyContract->contract_name = $contractName;
        $agencyContract->contract_details = $contractDetails;
        $agencyContract->signatures = $signatures;
        $agencyContract->custom_terms = $terms;
        $agencyContract->legalNames = $legalName;
        $agencyContract->creator = $creator;

        $agencyContract->save();

        if($recipient && $recipient->email){

            Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new AgencyContractMailer($agencyContract, $recipient, 'contract-created'));
            $userNotification = new UserNotificationController();
            $request->request->add(['user' => $recipient->id, 'customer' => $user->id, 'type' => 'contract_created', 'source_id' => $agencyContract->id]);
            $response = json_decode($userNotification->create($request), true);
        }

        return redirect()->route('agency.dashboard');
    }

    public function updateContract(Request $request, $id)
    {
        $user = Auth::user();

        if(!$user->hasActivePaidSubscription()){

            return 'Unauthorized access';
        }

        $commonMethods = new CommonMethods();
        $agencyContract = AgencyContract::find($id);
        $contract = Contract::find($agencyContract->contract_id);
        if($agencyContract->contact && ($agencyContract->creator == 'agent' && $agencyContract->contact->agentUser->id == $user->id) || ($agencyContract->creator == 'artist' && $agencyContract->contact->contactUser->id == $user->id)){

            // owner of the contract can update
            $terms = $request->get('terms') == '' ? NULL : $request->get('terms');
            $name = $request->get('name') == '' ? $contract->title : $request->get('name');
            $contractDetails = $request->contractBody ?? '';

            $agencyContract->contract_name = $name;
            $agencyContract->custom_terms = $terms;
            $agencyContract->contract_details = $contractDetails;
            $agencyContract->save();

            return redirect()->route('agency.dashboard');
        }
    }

    public function approveContract(Request $request, $id)
    {
        $commonMethods = new CommonMethods();
        $user = Auth::user();
        $agencyContract = AgencyContract::find($id);
        $contract = Contract::find($agencyContract->contract_id);
        if($agencyContract->contact && ($agencyContract->creator == 'agent' && $agencyContract->contact->contactUser->id == $user->id) || ($agencyContract->creator == 'artist' && $agencyContract->contact->agentUser->id == $user->id)){

            // contract can only be approved by contract partner
            $signatures = $agencyContract->signatures;
            $legalNames = $agencyContract->legal_names;

            if((isset($signatures['agent']) && $agencyContract->contact->agentUser->id == $user->id) || isset($signatures['artist']) && $agencyContract->contact->contactUser->id == $user->id){

                return 'Error: cannot re-take your signature';
            }

            $data = $request->get('data');
            $extension = explode('/', mime_content_type($data))[1];
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            $fileName = rand(100000, 999999).'.'.$extension;
            file_put_contents(public_path('signatures/').$fileName, $imageData);

            $contractDetails = $agencyContract->contract_details ?? '';
            // $contractPieces = explode('<<var>>', $agencyContract->contract_details['body']);
            // foreach ($contractPieces as $key => $piece) {

            //     $contractDetails .= $piece;
            //     if(isset($agencyContract->contract_details['data'][$key])){
            //         $contractDetails .= ' ' . $agencyContract->contract_details['data'][$key] . ' ';
            //     }
            // }

            if($agencyContract->contact->agentUser->id == $user->id){

                $signatures['agent'] = $fileName;
                $legalNames['agent'] = $request->get('legalName');
            }else if($agencyContract->contact->contactUser->id == $user->id){

                $signatures['artist'] = $fileName;
                $legalNames['artist'] = $request->get('legalName');
            }

            $pdfName = strtoupper('acnt_'.uniqid()).'.pdf';
            $fileName = 'agent-agreements/'.$pdfName;
            $data = ['contact' => $agencyContract->contact->contactUser, 'legalNames' => $legalNames, 'contractDetails' => $contractDetails, 'agent' => $agencyContract->contact->agentUser, 'contract' => $agencyContract, 'signatures' => $signatures];
            $pdfPath = public_path('agent-agreements').'/'.$pdfName;
            PDF::loadView('pdf.agent-contract-agreement', $data)->setPaper('a4', 'portrait')->setWarnings(false)->save($fileName);

            Mail::to($agencyContract->contact->agentUser->email)->bcc(Config('constants.bcc_email'))->send(new AgencyContractMailer($agencyContract, $agencyContract->contact->agentUser, 'contract-approved-for-agent', $pdfPath));
            $userNotification = new UserNotificationController();
            $request->request->add(['user' => $agencyContract->contact->agentUser->id, 'customer' => $agencyContract->contact->contactUser->id, 'type' => 'contract_approved_for_agent', 'source_id' => $agencyContract->id]);
            $response = json_decode($userNotification->create($request), true);

            Mail::to($agencyContract->contact->contactUser->email)->bcc(Config('constants.bcc_email'))->send(new AgencyContractMailer($agencyContract, $agencyContract->contact->contactUser, 'contract-approved-for-contact', $pdfPath));
            $userNotification = new UserNotificationController();
            $request->request->add(['customer' => $agencyContract->contact->agentUser->id, 'user' => $agencyContract->contact->contactUser->id, 'type' => 'contract_approved_for_contact', 'source_id' => $agencyContract->id]);
            $response = json_decode($userNotification->create($request), true);

            $agencyContract->pdf = $pdfName;
            $agencyContract->signatures = $signatures;
            $agencyContract->contract_details = $contractDetails;
            $agencyContract->approved_at = date('Y-m-d H:i:s');
            $agencyContract->legal_names = $legalNames;
            $agencyContract->save();

            return redirect()->route('agency.dashboard');
        }
    }

    public function userChat(Request $request){

        $user = Auth::user();
        $success = false;
        $data = [
            'private' => ['messages' => []],
            'group' => ['messages' => [], 'members' => []]
        ];

        if(!$request->has('type') || !$request->has('data')){

            return json_encode(array('success' => false, 'error' => 'no or incomplete data'));
        }

        $type = $request->get('type');
        $dataId = $request->get('data');
        $cursor = $request->get('cursor');
        if($type == 'contact-chat'){

            $agentContact = AgentContact::find($dataId);

            if(!$agentContact || !$agentContact->agentUser || !$agentContact->contactUser){

                return json_encode(array('success' => false, 'error' => 'some required data does not exist'));
            }

            $agent = $agentContact->agentUser;
            $artist = $agentContact->contactUser;

            if($agentContact->approved == 1){

                $chatGroup = UserChatGroup::where(['agent_id' => $agent->id, 'contact_id' => $artist->id])->get()->first();

                if(!$chatGroup){

                    return json_encode(array('success' => false, 'error' => 'some required data does not exist'));
                }

                $chatQuery = UserChat::where('group_id', $chatGroup->id);
                if((int ) $cursor > 0){

                    $chatQuery->where('id', '<' , $cursor);
                }
                $chatMessages = $chatQuery->orderBy('id', 'desc')->take(20)->get()->reverse();
                if(count($chatMessages)){

                    foreach ($chatMessages as $key => $chatMessage) {

                        if($chatMessage->sender){
                            $data['group']['messages'][] .= \View::make('parts.chat-partner-message', ['chat' => $chatMessage])->render();
                            $seen = $chatMessage->seen;
                            if(count($seen)){
                                if(!in_array($user->id, $seen)){
                                    $seen[] = $user->id;
                                    $chatMessage->seen = $seen;
                                    $chatMessage->save();
                                }
                            }else{
                                $seen[] = $user->id;
                                $chatMessage->seen = $seen;
                                $chatMessage->save();
                            }
                        }
                    }
                }

                $data['group']['members'] = $chatGroup->getGroupMembers();
                $success = true;
            }else{

                $partner = $user->isAgentOfContact($agentContact) ? $artist : $agent;
                $chatQuery = UserChat::where(function($q) use ($user) {
                        $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id);
                    })->where(function($q) use ($partner) {
                        $q->where('sender_id', $partner->id)->orWhere('recipient_id', $partner->id);
                    });
                if((int ) $cursor > 0){

                    $chatQuery->where('id', '<' , $cursor);
                }
                $chatMessages = $chatQuery->orderBy('id', 'desc')->take(20)->get()->reverse();
                if(count($chatMessages)){

                    foreach ($chatMessages as $key => $chatMessage) {

                        if($chatMessage->sender){

                            $data['private']['messages'][] .= \View::make('parts.chat-partner-message', ['chat' => $chatMessage])->render();
                        }
                    }
                }

                $success = true;
            }
        }else if($type == 'partner-chat'){

            $partner = User::find($dataId);
            $chatQuery = UserChat::where(function($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('recipient_id', $user->id);
                })->where(function($q) use ($partner) {
                    $q->where('sender_id', $partner->id)->orWhere('recipient_id', $partner->id);
                });
            if((int ) $cursor > 0){

                $chatQuery->where('id', '<' , $cursor);
            }
            $chatMessages = $chatQuery->orderBy('id', 'desc')->take(20)->get()->reverse();
            if(count($chatMessages)){

                foreach ($chatMessages as $key => $chatMessage) {

                    if($chatMessage->sender){

                        $data['private']['messages'][] .= \View::make('parts.chat-partner-message', ['chat' => $chatMessage])->render();
                    }
                }
            }

            $success = true;
        }

        return json_encode(['success' => $success, 'data' => $data]);
    }

    public function createMessage(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $contactId = $request->get('contact');
            $partnerId = $request->get('partner');
            $message = $request->get('message');
            $action = $request->get('action');

            if($action == 'attachment-initialize'){
                $chat = new UserChat();
                $chat->sender_id = NULL;
                $chat->group_id = NULL;
                $chat->recipient_id = NULL;
                $chat->message = NULL;
                $chat->music_id = NULL;

                $chat->save();
                $id = $chat->id;
            } else if($action == 'send-message' || $action == 'attachment-finalize') {
                if($action == 'attachment-finalize'){
                    $chat = UserChat::findOrFail($request->get('chat'));
                }else{
                    $chat = new UserChat();
                }

                if($request->has('contact')){
                    $agentContact = AgentContact::findOrFail($contactId);
                    $agent = $agentContact->agentUser;
                    $artist = $agentContact->contactUser;

                    if($agentContact->approved == 1){
                        $chatGroup = UserChatGroup::where(['agent_id' => $agent->id, 'contact_id' => $artist->id])->firstOrFail();
                        $chat->group_id = $chatGroup->id;
                    }else{
                        $partner = $user->isAgentOfContact($agentContact) ? $artist : $agent;
                        $chat->recipient_id = $partner->id;
                    }

                    $agentContact->latest_message_at = date('Y-m-d H:i:s');
                    $agentContact->save();
                }else if($request->has('partner')){
                    $partner = User::findOrFail($partnerId);
                    $chat->recipient_id = $partner->id;
                }

                $chat->sender_id = $user->id;
                $chat->message = $message;
                $chat->music_id = NULL;
                $chat->save();
                $id = $chat->id;

                $response = $chat->sendNotifications();
            } else if($action == 'attachment-upload'){

                $chat = UserChat::findOrFail($request->get('chat'));

                $id = $chat->id;
                $response = $chat->attachFile($request->file('attachment'));
                throw_if(!$response, 'ref: attachment_finish_error');
            }

            DB::commit();
            return json_encode(['success' => true, 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

        // $error = '';

        // if(!$request->has('action')){
        //     $error = 'some required data does not exist (ref: chat_action)';
        // }else if($request->get('action') == 'attachment-finalize' && (!$request->has('chat') || !$request->has('contact') || !$request->has('message'))){
        //     $error = 'some required data does not exist (ref: chat_finalize)';
        // }else if($request->get('action') == 'send-message' && ((!$request->has('contact') && (!$request->has('partner'))) || !$request->has('message'))){
        //     $error = 'some required data does not exist (ref: send_message)';
        // }else if($request->get('action') == 'attachment-upload' && (!$request->has('chat') || !$request->file('attachment'))){
        //     $error = 'some required data does not exist (ref: attachment)';
        // }

        // if($error != ''){

        //     return json_encode(['success' => false, 'error' => $error]);
        // }


        // if($action == 'attachment-initialize'){

        //     $chat = new UserChat();
        //     $chat->sender_id = NULL;
        //     $chat->group_id = NULL;
        //     $chat->recipient_id = NULL;
        //     $chat->message = NULL;
        //     $chat->music_id = NULL;

        //     $chat->save();
        //     $id = $chat->id;
        // }else if($action == 'send-message' || $action == 'attachment-finalize'){

        //     if($action == 'attachment-finalize'){
        //         $chat = UserChat::find($request->get('chat'));
        //     }else{
        //         $chat = new UserChat();
        //     }

        //     if($request->has('contact')){

        //         $agentContact = AgentContact::find($contactId);
        //         if(!$agentContact || !$agentContact->agentUser || !$agentContact->contactUser){
        //             return json_encode(array('success' => false, 'error' => 'some required data does not exist (ref: agent_contact)'));
        //         }

        //         $agent = $agentContact->agentUser;
        //         $artist = $agentContact->contactUser;

        //         if($agentContact->approved == 1){

        //             $chatGroup = UserChatGroup::where(['agent_id' => $agent->id, 'contact_id' => $artist->id])->get()->first();
        //             if(!$chatGroup){
        //                 return json_encode(array('success' => false, 'error' => 'some required data does not exist (ref: chat_group)'));
        //             }

        //             $chat->group_id = $chatGroup->id;
        //         }else{

        //             $partner = $user->isAgentOfContact($agentContact) ? $artist : $agent;
        //             $chat->recipient_id = $partner->id;
        //         }

        //         $agentContact->latest_message_at = date('Y-m-d H:i:s');
        //         $agentContact->save();
        //     }else if($request->has('partner')){

        //         $partner = User::find($partnerId);
        //         if(!$partner){
        //             return json_encode(array('success' => false, 'error' => 'some required data does not exist (ref: agent_partner)'));
        //         }
        //         $chat->recipient_id = $partner->id;
        //     }

        //     $chat->sender_id = $user->id;
        //     $chat->message = $message;
        //     $chat->music_id = NULL;
        //     $chat->save();
        //     $id = $chat->id;

        //     $response = $chat->sendNotifications();
        // }else if($action == 'attachment-upload'){

        //     $chat = UserChat::find($request->get('chat'));
        //     if(!$chat){
        //         return json_encode(array('success' => false, 'error' => 'some required data does not exist (ref: attachment_chat_missing)'));
        //     }

        //     $id = $chat->id;
        //     $response = $chat->attachFile($request->file('attachment'));
        //     if(!$response){
        //         return json_encode(array('success' => false, 'error' => 'some required data does not exist (ref: attachment_finish_error)'));
        //     }
        // }

        // return json_encode(['success' => true, 'id' => $id]);
    }

    public function getMoniesData (Request $request){

        $user = Auth::user();
        $success = false;
        $commonMethods = new CommonMethods();
        $error = '';
        $html = '';

        if($request->has('id') && $request->id != ''){

            $id = $request->get('id');
            $html = \View::make('parts.agent-monies', ['id' => $id, 'user' => $user, 'commonMethods' => $commonMethods])->render();
        }

        return json_encode(['success' => true, 'id' => $id, 'data' => $html]);
    }
}
