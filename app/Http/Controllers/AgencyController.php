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
            'agencyContracts' => $agencyContracts
        ];

        return view('pages.admin-home', $data);
    }

    public function addContractForm(Request $request, $id, $contactId = null)
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
                'agentContact' => $agentContact
            ];

            return view('pages.admin-add-contract', $data);
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
            }else if($agentContact->contactUser->id == $user->id){
                $signatures = ['contact' => $fileName];
                $creator = 'contact';
                $recipient = $agentContact->agentUser;
            }else{
                $signatures = [];
                $creator = '';
            }

            $contractDetails = '';
            $contractPieces = explode('<<var>>', $contract->body);
            foreach ($contractPieces as $key => $piece) {

                if($request->has('input-'.$key)){
                    $contractDetails .= $piece . ' ' . $request->get('input-' . $key) . ' ';
                }
            }

            $agencyContract = new AgencyContract();
            $agencyContract->contact_id = $contactId;
            $agencyContract->contract_id = $id;
            $agencyContract->contract_name = $contractName;
            $agencyContract->contract_details = $contractDetails;
            $agencyContract->signatures = $signatures;
            $agencyContract->custom_terms = $terms;
            $agencyContract->creator = $creator;

            $agencyContract->save();

            Mail::to($recipient->email)->bcc(Config('constants.bcc_email'))->send(new AgencyContractMailer($agencyContract, $recipient, 'contract-created'));
            return redirect()->route('agency.dashboard');
        }
    }
}
