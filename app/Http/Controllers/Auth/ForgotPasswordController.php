<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Models\UserProduct;
use DB;
use Auth;
use App\Models\User;
use Image;
use Illuminate\Http\Request;
use App\Models\CompetitionVideo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Session;


use App\Models\ContributeDetail;
use App\Models\Test;
use App\Models\ArtistJob;

use App\Models\City;

use App\Models\Competition;

use App\Models\Country;

use App\Models\CustomerBasket;
use App\Models\Genre;

use App\Models\UserMusic;
use Atlx\Models\Address;

use Carbon\Carbon;

use File;

use Lang;

use App\Models\Profile;

use App\Models\VideoStream;
use Hash;

use App\Models\UserCampaign;

use App\Models\CampaignPerks;

use App\Models\StripeSubscription;
use App\Models\StripePerk;
use App\Models\StripeCheckout;
use App\Http\Controllers\CommonMethods;
use Mail;

use App\Mail\ResetPassword;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function forgetPasswordEmail(Request $request){
        // send email here ..
        //return $request->email_address;
        $return = ['success' => 0, 'error' => ''];
        $user = User::where("email", $request->email_address)->first();
        if($user){
            $token = $user->api_token;
            $result = Mail::to($user->email)->bcc(Config('constants.bcc_email'))->send(new ResetPassword($user, $token));
            $return['success'] = 1;
        }else{
            $return['error'] = 'We can\'t find a user with that email address';
        }

        return json_encode($return);
    }

    public function getReset($token){
        $user = User::where("api_token", $token)->first();
        $data = [
            "user" => $user
        ];
        return view( 'pages.reset-password', $data );
    }

    public function resetPassword(Request $request){
        $user = User::find($request->userId);
        $user->password = bcrypt($request->pass);
        $user->save();
        Auth::login($user);
        return redirect('profile');
    }
}
