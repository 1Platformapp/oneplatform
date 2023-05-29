<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use App\Http\Controllers\CommonMethods;

use DB;

use PDF;

use Auth;

use Mail;

use Hash;

use Session;

use Image;

use App\Models\User;

use App\Models\UserProduct;



class SingingController extends Controller

{

    public function __construct(){

        
    }
    

    public function index(Request $request)
    {

        
    }

    public function reinstateAction(Request $request){

        $routeName = $request->route()->getName();
        $user = User::find(765);
        $commonMethods = new CommonMethods();

        $data = [

            'user' => $user,
            'commonMethods' => $commonMethods,
            'userProfileImage' => $commonMethods->getUserDisplayImage($user->id),
        ];

        if($routeName == 'parties.kids.pop.star.party'){

            $data['product'] = UserProduct::find(182);
            return view( 'pages.singing.kids-popstar-party', $data);
        }

        if($routeName == 'parties.hen.party'){

            $data['product'] = UserProduct::find(183);
            return view( 'pages.singing.hen-party', $data);
        }

        if($routeName == 'stag.parties.manchester'){

            $data['product'] = UserProduct::find(184);
            return view( 'pages.singing.stag-party-manchester', $data);
        }

        if($routeName == 'parties.corporate.party'){

            $data['product'] = UserProduct::find(185);
            return view( 'pages.singing.corporate-party', $data);
        }

        if($routeName == 'music.studio.manchester'){

            $data['product'] = UserProduct::find(288);
            return view( 'pages.singing.music-studio-manchester', $data);
        }

        if($routeName == 'studios.near.me'){

            $data['product'] = UserProduct::find(304);
            return view( 'pages.singing.studios-near-me', $data);
        }

        if($routeName == 'manchester.singing.studio'){

            $data['product'] = UserProduct::find(300);
            return view( 'pages.singing.manchester-singing-studio', $data);
        }

        if($routeName == 'studio.recording.near.me'){

            $data['product'] = UserProduct::find(299);
            return view( 'pages.singing.studio-recording-near-me', $data);
        }

        if($routeName == 'song.writing.full.day'){

            $data['product'] = UserProduct::find(195);
            return view( 'pages.singing.song-writing-full-day', $data);
        }

        if($routeName == 'song.writing.half.day'){

            $data['product'] = UserProduct::find(194);
            return view( 'pages.singing.song-writing-half-day', $data);
        }

        if($routeName == 'cover.shoots'){

            $data['product'] = UserProduct::find(198);
            return view( 'pages.singing.cover-shoots', $data);
        }

        if($routeName == 'videos.pop.star.party.video'){

            $data['product'] = UserProduct::find(197);
            return view( 'pages.singing.videos-pop-star-party-video', $data);
        }

        if($routeName == 'videos.music.video'){

            $data['product'] = UserProduct::find(191);
            return view( 'pages.singing.videos-music-video', $data);
        }

        if($routeName == 'videos.general'){

            $data['product'] = UserProduct::find(192);
            return view( 'pages.singing.videos-general', $data);
        }

        if($routeName == 'bands.general'){

            $data['product'] = NULL;
            return view( 'pages.singing.bands-general', $data);
        }

        if($routeName == 'bands.discovery'){

            $data['product'] = UserProduct::find(189);
            return view( 'pages.singing.bands-discovery', $data);
        }

        if($routeName == 'bands.mini'){

            $data['product'] = UserProduct::find(188);
            return view( 'pages.singing.bands-mini', $data);
        }

        if($routeName == 'musicians.gifts.for.musicians'){

            $data['product'] = UserProduct::find(187);
            return view( 'pages.singing.musicians-gifts-for-musicians', $data);
        }

        if($routeName == 'musicians.guitarists'){

            $data['product'] = UserProduct::find(186);
            return view( 'pages.singing.musicians-guitarists', $data);
        }

        if($routeName == 'recording.studio.unplugged'){

            $data['product'] = UserProduct::find(193);
            return view( 'pages.singing.recording-studio-unplugged', $data);
        }

        if($routeName == 'recording.studio.junior.vip'){

            $data['product'] = UserProduct::find(281);
            return view( 'pages.singing.recording-studio-junior-vip', $data);
        }

        if($routeName == 'recording.studio.near.me'){

            $data['product'] = UserProduct::find(181);
            return view( 'pages.singing.recording-studio-near-me', $data);
        }

        if($routeName == 'recording.studio.diamond.package'){

            $data['product'] = UserProduct::find(180);
            return view( 'pages.singing.recording-studio-diamond-package', $data);
        }

        if($routeName == 'recording.studio.silver.package'){

            $data['product'] = UserProduct::find(179);
            return view( 'pages.singing.recording-studio-silver-package', $data);
        }

        if($routeName == 'recording.general'){

            $data['product'] = NULL;
            return view( 'pages.singing.recording-general', $data);
        }

        if($routeName == 'singers.general'){

            $data['product'] = NULL;
            return view( 'pages.singing.singers-general', $data);
        }

        if($routeName == 'musicians.general'){

            $data['product'] = NULL;
            return view( 'pages.singing.musicians-general', $data);
        }

        if($routeName == 'cover.shoots.family'){

            $data['product'] = NULL;
            return view( 'pages.singing.cover-shoots-family', $data);
        }

        if($routeName == 'parties.general'){

            $data['product'] = NULL;
            return view( 'pages.singing.parties-general', $data);
        }

        if($routeName == 'parties.kids.popstar.party-ideas'){

            $data['product'] = NULL;
            return view( 'pages.singing.parties-kids-popstar-party-ideas', $data);
        }
    }

    public function faq(Request $request){

        $data = [

            'user' => User::find(765),
            'userParams' => 'customDomain'
        ];

        return view( 'pages.singing.faq', $data);
    }

    public function notExist(Request $request){

        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        die();
    }
}

