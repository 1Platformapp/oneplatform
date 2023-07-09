<?php


namespace App\Http\Controllers;

use App\Http\Controllers\CommonMethods;
use App\Models\User;
use App\Models\UserChat;
use App\Models\AgentContact;
use App\Models\UserChatGroup;
use App\Models\StripeCheckout;

use Illuminate\Http\Request;

use Auth;
use Image;

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
        ];

        return view('pages.admin-home', $data);
    }
}
