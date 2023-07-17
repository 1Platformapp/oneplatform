<?php


namespace App\Http\Controllers;

use App\Http\Controllers\CommonMethods;
use App\Models\User;
use App\Models\UserChat;
use App\Models\AgentContact;
use App\Models\UserChatGroup;
use App\Models\StripeCheckout;
use App\Models\Contract;
use App\Models\AgencyContract;
use App\Mail\AgencyContract as AgencyContractMailer;

use Illuminate\Http\Request;

use Auth;
use Image;
use Mail;
use PDF;

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
        $instantPurchases = StripeCheckout::where('customer_id', $user->id)->where(function($q) { $q->where('type', 'instant')->orWhere('type', 'custom-product');})->orderBy('id' , 'desc')->get();
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
        }

        if(!$isAgent){

            $contacts = AgentContact::where(['email' => $user->email])->get();
            if(count($contacts) && $contacts->first()->agentUser){

                $agents = User::where('apply_expert', 2)->orderByRaw("id = ".$contacts->first()->agentUser->id." desc")->get()->filter(function ($user){
                    return $user->expert && $user->expert->status == 1;
                });
            }else{

                $agents = $contacts = [];
            }
        }else{

            $contacts = AgentContact::where(['agent_id' => $user->id])->get();
            $agents = [];
        }

        $myContracts = count($contacts) ? AgencyContract::whereIn('contact_id', $contacts->pluck('id')->all())->get() : [];

        $purchaseParticulars['fans'] = $fans;
        $purchaseParticulars['singles_sold'] = $singlesSold;
        $purchaseParticulars['albums_sold'] = $albumsSold;
        $purchaseParticulars['products_sold'] = $productsSold;
        $purchaseParticulars['total_revenue'] = $totalRevenue;

        $data   = [

            'commonMethods' => $commonMethods,
            'user' => $user,
            'purchaseParticulars' => $purchaseParticulars,
            'topSales' => $topSales,
            'contracts' => Contract::all(),
            'agencyContracts' => [],
            'agents' => $agents,
            'isAgent' => $isAgent,
            'myContracts' => $myContracts
        ];

        return view('pages.admin-home', $data);
    }

    public function addContractForm(Request $request, $id, $contactId)
    {
        $commonMethods = new CommonMethods();
        $user = Auth::user();
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

    public function editContractForm(Request $request, $id)
    {
        $commonMethods = new CommonMethods();
        $user = Auth::user();
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
        $commonMethods = new CommonMethods();
        $user = Auth::user();
        $contract = Contract::find($id);
        $agentContact = AgentContact::find($contactId);
        if($contract){

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

            $contractDetails = '';
            $contractDetails = ['body' => str_replace(array("'", "\""), " ", $contract->body), 'data' => $request->get('inputData')];

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
                $request->request->add(['customer' => $recipient->id, 'user' => $user->id, 'type' => 'contract_created', 'source_id' => $agencyContract->id]);
                $response = json_decode($userNotification->create($request), true);
            }

            return redirect()->route('agency.dashboard');
        }
    }

    public function updateContract(Request $request, $id)
    {
        $commonMethods = new CommonMethods();
        $user = Auth::user();
        $agencyContract = AgencyContract::find($id);
        $contract = Contract::find($agencyContract->contract_id);
        if($agencyContract->contact && ($agencyContract->creator == 'agent' && $agencyContract->contact->agentUser->id == $user->id) || ($agencyContract->creator == 'artist' && $agencyContract->contact->contactUser->id == $user->id)){

            // owner of the contract can update
            $terms = $request->get('terms') == '' ? NULL : $request->get('terms');
            $name = $request->get('name') == '' ? $contract->title : $request->get('name');
            $contractDetails = ['body' => $agencyContract->contract_details['body'], 'data' => $request->get('inputData')];

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

            $contractDetails = '';
            $contractPieces = explode('<<var>>', $agencyContract->contract_details['body']);
            foreach ($contractPieces as $key => $piece) {

                $contractDetails .= $piece;
                if(isset($agencyContract->contract_details['data'][$key])){
                    $contractDetails .= ' ' . $agencyContract->contract_details['data'][$key] . ' ';
                }
            }

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
            PDF::loadView('pdf.agent-contract-agreement', $data)->setPaper('a4', 'portrait')->setWarnings(false)->save($fileName);

            $result = Mail::to($agencyContract->contact->agentUser->email)->bcc(Config('constants.bcc_email'))->send(new AgencyContractMailer($agencyContract, $agencyContract->contact->agentUser, 'contract-approved-for-agent'));
            $userNotification = new UserNotificationController();
            $request->request->add(['user' => $agencyContract->contact->agentUser->id, 'customer' => $agencyContract->contact->contactUser->id, 'type' => 'contract_approved_for_agent', 'source_id' => $agencyContract->id]);
            $response = json_decode($userNotification->create($request), true);

            $result = Mail::to($agencyContract->contact->contactUser->email)->bcc(Config('constants.bcc_email'))->send(new AgencyContractMailer($agencyContract, $agencyContract->contact->contactUser, 'contract-approved-for-contact'));
            $userNotification = new UserNotificationController();
            $request->request->add(['customer' => $agencyContract->contact->agentUser->id, 'user' => $agencyContract->contact->contactUser->id, 'type' => 'contract_approved_for_contact', 'source_id' => $agencyContract->id]);
            $response = json_decode($userNotification->create($request), true);

            $agencyContract->pdf = $pdfName;
            $agencyContract->signatures = $signatures;
            $agencyContract->contract_details = [$contractDetails];
            $agencyContract->approved_at = date('Y-m-d H:i:s');
            $agencyContract->legal_names = $legalNames;
            $agencyContract->save();

            return redirect()->route('agency.dashboard');
        }
    }
}
