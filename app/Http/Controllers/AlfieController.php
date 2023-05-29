<?php

namespace App\Http\Controllers;



use App\Models\CustomerBasket;
use App\Models\EmbedCode;
use App\Models\Profile;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use App\Models\Competition;
use App\Http\Controllers\CommonMethods;

use DB;
use Auth;
use App\Models\User;


class AlfieController extends Controller

{

    public function index( Request $request )

    {
        $scrollerSlides = \App\Models\ScrollerSetting::all();

        $videos = [];
        $videoId = null;
        $commonMethods = new CommonMethods();

        $user = User::find(244);
        $userId = $user->id;

        $videos = $user->profile->competitionVideos;
        $firstVideoId = $videos->first()->video_id;
        $defaultVideoId = ( $videoId ) ? $videoId : $firstVideoId;

        $userCampaignDetails = $commonMethods->getUserCampaignDetails($userId);
        $userPersonalDetails = $commonMethods->getUserPersonalDetails($userId);
        $userSocialAccountDetails = $commonMethods::getUserSocialAccountDetails($userId);
        $verticalSliderItems = \App\Models\ScrollerSetting::all();

        $musics = $user->musics;
        $products = $user->products;
        $myChannelVideos = $user->profile->competitionVideos;
        $checkouts = $user->checkouts;
        $basket = $commonMethods::getCustomerBasket();
        $fbUserProfiles = Profile::where("social_facebook", '<>',  "")->get();
        $youtubeUserProfiles = Profile::where("social_youtube", '<>',  "")->get();
        $embadCodeObj = EmbedCode::find(3);
        $albums = $user->albums;
        $allPastProjects = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'inactive')->orderBy('id', 'desc')->get();

        $data   = [
            'scrollerSlides' => $scrollerSlides,
            'videos' => $videos,
            'user' => $user,
            'commonMethods' => $commonMethods,
            'userCampaignDetails' => $userCampaignDetails,
            'userPersonalDetails' => $userPersonalDetails,
            'verticalSliderItems' => $verticalSliderItems,
            'musics' => $musics,
            'products' => $products,
            'myChannelVideos' => $myChannelVideos,
            'checkouts' => $checkouts,
            'basket' => $basket,
            'defaultVideoId' => $defaultVideoId,
            'userSocialAccountDetails' => $userSocialAccountDetails,
            'fbUserProfiles' => $fbUserProfiles,
            'youtubeUserProfiles' => $youtubeUserProfiles,
            'embadCodeObj' => $embadCodeObj,
            'allPastProjects' => $allPastProjects,
            'albums' => $albums

        ];

        return view( 'pages.alfie', $data );

    }

}

