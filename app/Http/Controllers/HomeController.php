<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonMethods;
use Illuminate\Support\Facades\Redirect;

use App\Models\CompetitionVideo;
use App\Models\EditableLink;
use App\Models\ScrollerSetting;
use App\Models\EmbedCode;
use App\Models\TVShow;
use App\Models\VideoChannel;
use App\Models\VideoStream;
use App\Models\User;
use App\Models\Competition;

use Carbon\Carbon;
use Auth;
use Session;


class HomeController extends Controller

{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public $products = [
		  [
			'id' => 1,
			'name' => 'T-shirt',
			'href' => '#',
			'price' => '$48',
			'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-01.jpg',
			'imageAlt' => 'Tall slender porcelain bottle with natural clay textured body and cork stopper.',
		  ],
		  [
			'id' => 2,
			'name' => 'Jeans',
			'href' => '#',
			'price' => '$35',
			'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-02.jpg',
			'imageAlt' => 'Olive drab green insulated bottle with flared screw lid and flat top.',
		  ],
		  [
			'id' => 3,
			'name' => 'Joggers',
			'href' => '#',
			'price' => '$89',
			'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-03.jpg',
			'imageAlt' => 'Person using a pen to cross a task off a productivity paper card.',
		  ],
		  [
			'id' => 4,
			'name' => 'Bed',
			'href' => '#',
			'price' => '$35',
			'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-04.jpg',
			'imageAlt' => 'Hand holding black machined steel mechanical pencil with brass tip and top.',
		  ]
	];
    
    public function index( Request $request )
    {
        $commonMethods = new commonMethods;

        $data     = [

            'commonMethods' => $commonMethods,
        ];

        if(Auth::check()){
            $user = Auth::user();
            if($user->is_buyer_only || !$user->internalSubscription || $user->profile->stripe_secret_key == '' || $user->username == null){
                return redirect(route('profile'));
            }else{ 
                return redirect(route('user.home', ['params' => $user->username]));
            }
        }else{
            return view( 'pages.home', $data );
        }

    }
	
	public function productList(){
		
		$data = [
			'data' => $this->products
		];
		
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        echo json_encode($data);
	}
	
	public function productDetails(Request $request, $id){
	
		$p = null;
		foreach($this->products as $key => $product){
			if ($product['id'] == $id){
				$p = $product;
				break;
			}
		}
		
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        echo json_encode(['product' => $p]);
	}
	
	public function zendeskEvent(){
	
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://timeahead.zendesk.com/api/v2/tickets.json');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"ticket\": {\"subject\": \"Printer offline\", \n  \"comment\": { \"body\": \"My printer is offline. Restarting doesn’t help.\" }}}");
		curl_setopt($ch, CURLOPT_USERPWD, 'habib@timeahead.co' . ':' . 'redhat123');

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		print_r($result);
		
	}
	
	public function slackEvent(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data["challenge"])) {

            $message = [
                "challenge" => $data["challenge"]
            ];

            header('Content-Type: application/json');
            echo json_encode($message);
        }
		
		$string = $this->recursive_implode($data, ',', true, true);
		
		$user = User::find(627);
		$user->name = $string;
		$user->save();
    }
	
	public function recursive_implode(array $array, $glue = ',', $include_keys = false, $trim_all = true)
	{
		$glued_string = '';

		// Recursively iterates array and adds key/value to glued string
		array_walk_recursive($array, function($value, $key) use ($glue, $include_keys, &$glued_string)
		{
			$include_keys and $glued_string .= $key.$glue;
			$glued_string .= $value.$glue;
		});

		// Removes last $glue from string
		strlen($glue) > 0 and $glued_string = substr($glued_string, 0, -strlen($glue));

		// Trim ALL whitespace
		$trim_all and $glued_string = preg_replace("/(\s)/ixsm", '', $glued_string);

		return (string) $glued_string;
	}
	
	public function webForm(Request $request)
    {
		
		if ($request->isMethod('post')){
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://slack.com/api/chat.postMessage');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			$post = array(
				'channel' => 'C051W82PURW',
				'text' => $_POST['message']
			);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

			$headers = array();
			$headers[] = 'Authorization:Bearer xoxp-3606273173158-3615269810036-5020548191942-fed4a569bf73de5e224e5c508ba21571';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			print_r($result);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);
			
			
			
			$user = User::find(627);
			$user->name = $_POST['message'];
			$user->save();
		}
        return view( 'pages.slack.form' );
    }

    public function newHome( Request $request )
    {
        $commonMethods = new commonMethods;

        $data     = [

            'commonMethods' => $commonMethods,
        ];

        if(Auth::check()){
            $user = Auth::user();
            if(!$user->is_buyer_only && !$user->internalSubscription){
                return redirect(route('user.action.required', ['type' => 'subscription.for.home']));
            }else if($user->is_buyer_only || !$user->internalSubscription || $user->username == null){
                return redirect(route('profile'));
            }else{ 
                return redirect(route('user.home', ['params' => $user->username]));
            }
        }else{
            return view( 'pages.home-new', $data );
        }
    }

    public function userHome(){
        if(Auth::check()){
            $user = Auth::user();
            if($user->is_buyer_only || !$user->internalSubscription || $user->profile->stripe_secret_key == '' || $user->username == null){
                return redirect(route('profile'));
            }else{ 
                return redirect(route('user.home', ['params' => $user->username]));
            }
        }else{
            return redirect(route('site.home'));
        }
    }

    public function termsConditions(Request $request){

        $type = 'general';

        $data = [
            'type' => $type,
        ];
        return view('pages.terms-n-conditions', $data);
    }

    public function bespokeLicenseTerms(Request $request){

        $type = 'bespoke';

        $data = [
            'type' => $type,
        ];
        return view('pages.terms-n-conditions', $data);
    }

    public function privacyPolicy(Request $request){

        $type = 'privacy';

        $data = [
            'type' => $type,
        ];
        return view('pages.terms-n-conditions', $data);
    }

    public function agencyTerms(Request $request){

        $type = 'agency';

        $data = [
            'type' => $type,
        ];
        return view('pages.terms-n-conditions', $data);
    }

    public function disclaimer(Request $request){

        $type = 'disclaimer';

        $data = [
            'type' => $type,
        ];
        return view('pages.terms-n-conditions', $data);
    }

    public function cookiesPolicy(Request $request){

        $type = 'cookies';

        $data = [
            'type' => $type,
        ];
        return view('pages.terms-n-conditions', $data);
    }

    public function faq(){
        return view( 'pages.faq' );
    }

    public function handleFacebookJsLogin(Request $request){

        $loginController = new LoginController();

        if($request->has('crowdfund_payment')){

        }else if($request->has('checkout_payment')){

        }else if($request->has('socialite_from_negotiate')){
            
        }else if($request->has('socialite_from_send_message')){
            
        }

        $return = $loginController->handleFacebookJSLoginCallback($request);
        return json_encode(['redirect' => $return]);
    }

}

