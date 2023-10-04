<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CalendarEvent;
use App\Models\CalendarEventParticipant;
use App\Http\Controllers\CommonMethods;
use App\Http\Requests\AddEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\DeleteEventRequest;
use App\Http\Resources\CalEvPartResource;

use DB;
use PDF;
use Auth;
use Mail;
use Hash;
use Session;

class TestController extends Controller

{


    public function sendWhatsappMessage (Request $request) {

        $url = "https://waba.com.bot/cloud/v1/messages";

        $headers = array("content-type"=>"application/json", "API-KEY" => "651da38e9261c8ad436ac637");
        $jsonPayload = '{
            "to": "923356947187",
            "type": "template",
            "template": {
              "namespace": "your_namespace_id",
              "language": {
                "policy": "deterministic",
                "code": "en"
              },
              "name": "name_here",
              "components": [
                {
                  "type" : "body",
                  "parameters": [
                    {
                      "type": "text",
                      "text": "text_here"
                    },
                    {
                      "type": "text",
                      "text": "text_here"
                    }
                  ]
                }
              ]
            }
          }';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie-txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie-txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla 5.0 (Windows U: Windows NT 5.1: en-US rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        $st = curl_exec($ch);
        $result = json_decode($st, TRUE);

        echo json_encode(['response' => $result]);
    }

}

