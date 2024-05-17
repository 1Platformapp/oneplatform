<?php


namespace App\Http\Controllers;

use App\Models\City;
use App\Models\InternalSubscription;
use App\Models\Competition;
use App\Models\Genre;
use App\Models\StripeCheckout;
use App\Models\AgentContact;
use App\Models\CompetitionVideo;
use App\Models\ManagementPlanSubmit;
use App\Models\UserChat;
use App\Models\Country;
use App\Models\CustomProduct;
use App\Models\UserProductDesign;
use App\Models\InstantCheckoutItem;
use App\Models\CustomerBasket;
use App\Models\VideoStream;
use App\Models\UserCampaign;
use App\Models\CampaignPerks;
use App\Models\UserProduct;
use App\Models\UserMusic;
use App\Models\UserAlbum;
use App\Models\User;
use App\Models\EditableLink;
use Illuminate\Support\Facades\File;

use DB;
use Auth;
use Image;

use Illuminate\Http\Request;
use App\Http\Controllers\Browser;
use AmrShawky\Currency;
use Illuminate\Support\Facades\URL;

class CommonMethods extends Controller



{



    /**



     * @param Request $request



     *



     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View



     */


    public function createDBConnection($host, $username, $password, $database){

        $con = mysqli_connect($host, $username, $password, $database);

        if(mysqli_connect_errno()){
          echo 'Failed to connect to MySQL: '.mysqli_connect_error();
          exit();
        }

        return $con;
    }



    public static function getSubmitData($stage, $task, $user, $type){

        $check = ManagementPlanSubmit::where(['stage_id' => $stage, 'task_id' => $task, 'user_id' => $user, 'type' => $type])->get()->first();
        if ($check) {

            return $check->value;
        } else {
            return null;
        }
    }

    public function maskString($inputString) {
        $length = strlen($inputString);

        if ($length <= 3) {
            return $inputString;
        }

        $firstThree = substr($inputString, 0, 3);

        $lastCharacter = substr($inputString, -3);

        $maskedMiddle = str_repeat('*', $length - 4);

        $maskedString = $firstThree . $maskedMiddle . $lastCharacter;

        return $maskedString;
    }

    public static function getManagementPlanStatusIcon($status){

        if (!$status || $status == '' || $status == 'default'){
            return 'far fa-star';
        } else if ($status == 'in-progress'){
            return 'fas fa-running';
        } else if ($status == 'completed'){
            return 'fas fa-star';
        } else if ($status == 'urgent'){
            return 'fas fa-exclamation';
        }

        return '';
    }

    public static function getItemImage($checkoutItemId, $itemId, $itemType){

        $thumb = asset('img/url-thumb-profile.jpg');
        if($itemType == 'music'){

            $music = UserMusic::find($itemId);
            if($music && $music->thumbnail_left != ''){

                $thumb = asset('user-music-thumbnails/'.$music->thumbnail_left );
            }else{

                $thumb = asset('images/default_thumb_music.png');
            }
        }
        if($itemType == 'product'){

            $product = UserProduct::find($itemId);
            if($product && $product->thumbnail != ''){

                $thumb = asset('user-product-thumbnails/'.$product->thumbnail);
            }else{

                $thumb = asset('images/default_thumb_product.png');
            }
        }
        if($itemType == 'album'){

            $album = UserAlbum::find($itemId);
            if($album && $album->thumbnail && $album->thumbnail != ''){

                $thumb = asset('user-album-thumbnails/'.$album->thumbnail);
            }else{

                $thumb = asset('images/default_thumb_album.png');
            }
        }
        if($itemType == 'project'){

            $thumb = asset('images/proffered_project_cart.png');
        }
        if($itemType == 'custom-product'){

            $thumb = asset('images/default_thumb_product.png');
            $product = UserProduct::find($itemId);
            $checkoutItem = InstantCheckoutItem::find($checkoutItemId);
            if($product && $product->type == 'custom' && isset($product->design['colors'])){

                foreach($product->design['colors'] as $color){

                    if($color['name'] == $checkoutItem->color){
                        $thumb = asset('prints/uf_'.$product->user->id.'/designs/'.$color['image']);
                    }
                }
            }
        }

        return $thumb;
    }

    public static function isEU($countrycode) {
        $eu_countrycodes = array(
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL',
            'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV',
            'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'
        );
        return (in_array($countrycode, $eu_countrycodes));
    }

    public static function customProductPricing(CustomProduct $product, $currency, $basePrice = null){

        $return = ['min_price' => 0, 'recommended_price' => 0, 'commission' => 0, 'vat' => 0, 'success' => 0, 'error' => ''];
        $vatPercent = 20;
        $bonusPercent = 58.8;

        $currency = !$currency ? 'gbp' : $currency;
        $costPrice = $currency == 'gbp' ? $product->cost_price_gbp : ($currency == 'usd' ? $product->cost_price_usd : $product->cost_price_eur);

        $return['min_price'] = $costPrice+($costPrice*($vatPercent/100));
        $return['recommended_price'] = $costPrice/(1-($product->user_commission/100));
        $return['recommended_price'] = $return['recommended_price']+$return['recommended_price']*($vatPercent/100);
        $return['recommended_price'] = ceil($return['recommended_price']);
        $referencePrice = $basePrice !== NULL ? $basePrice : $return['recommended_price'];
        $vatExcluding = $referencePrice/(1+($vatPercent/100));
        $return['commission'] = $vatExcluding*($product->user_commission/100);
        $return['vat'] = $referencePrice-$vatExcluding;

        if($referencePrice >= $return['min_price']){

            if($basePrice !== NULL && $basePrice > $return['recommended_price']){

                $return['commission'] += ($basePrice-$return['recommended_price'])*$bonusPercent/100;
            }else if($basePrice !== NULL && $basePrice < $return['recommended_price']){

                if($costPrice-($vatExcluding-$return['commission']) > 0){

                    $return['commission'] -= $costPrice-($vatExcluding-$return['commission']);
                }
            }

            $return['commission'] = round($return['commission'], 2);
            $return['vat'] = round($return['vat'], 2);
            $return['min_price'] = round($return['min_price'], 2);
            $return['currency'] = strtoupper($currency);
            $return['success'] = 1;
            $return['error'] = '';
        }else{
            $return = ['success' => 0, 'min_price' => 0, 'recommended_price' => 0, 'commission' => 0, 'vat' => 0, 'error' => 'Product price cannot be lower than '.round($return['min_price'], 2).' '.strtoupper($currency), 'currency' => strtoupper($currency)];
        }

        return $return;
    }

    public static function convertToBlackAndWhite($imagePath){

        $user = Auth::user();
        $mainFolder = 'prints/uf_'.$user->id;
        try{

            $condicion = getimagesize(asset($imagePath));
            $printImg = rand(10000, 99999);

            if($condicion[2] == 1){
                $im = imagecreatefromgif(asset($imagePath));
                $printImg .= '.gif';
            }
            if($condicion[2] == 2){
                $im = imagecreatefromjpeg(asset($imagePath));
                $printImg .= '.jpg';
            }
            if($condicion[2] == 3){
                $im = imagecreatefrompng(asset($imagePath));
                $printImg .= '.png';
            }

            $pngTransparency = imagecolorallocatealpha($im, 0, 0, 0, 127);

            imagefilter($im, IMG_FILTER_GRAYSCALE);
            imagefilter($im, IMG_FILTER_CONTRAST, -255);

            $im = imageRotate($im, 360, $pngTransparency);

            if($condicion[2] == 1)
            imagegif($im, public_path($mainFolder.'/templates/black/'.$printImg), 100);
            if($condicion[2] == 2)
            imagejpeg($im, public_path($mainFolder.'/templates/black/'.$printImg), 100);
            if($condicion[2] == 3)
            imagepng($im, public_path($mainFolder.'/templates/black/'.$printImg));

            imagedestroy($im);
            return ['success' => 1, 'error' => '', 'data' => $printImg];
        }catch(Exception $e) {

            return ['success' => 0, 'error' => $e->getMessage(), 'data' => NULL];
        }
    }

    public static function mergeImages($imageOneSrc, $imageTwoSrc, $imageOneX, $imageOneY, $imageTwoAngle, $imageTwoWidth){

        $user = Auth::user();
        $mainFolder = 'prints/uf_'.$user->id;

        try {

            if(!file_exists(public_path($mainFolder))){

                return ['success' => 0, 'error' => 'No folder for this user '];
            }

            $extensions = ['image/png' => 'png','image/jpeg' => 'jpg', 'image/jpg' => 'jpg', 'image/gif' => 'gif'];
            $condicion = getimagesize(asset($imageTwoSrc));
            $condicion1 = getimagesize(asset($imageOneSrc));
            if(array_key_exists($condicion['mime'], $extensions)){

                $ext = $extensions[$condicion['mime']];
            }else{

                return ['success' => 0, 'error' => 'Image extension is not supported. '.$condicion['mime'], 'data' => 0];
            }

            $imageTwoName = rand(100000,999999).'.'.$ext;

            if($condicion[0] != $imageTwoWidth){

                Image::make(public_path($imageTwoSrc))->resize($imageTwoWidth, null,function($constraint){$constraint->aspectRatio();})->save(public_path($mainFolder.'/templates/resized/'.$imageTwoName), 100);
                $imageTwoSrc = $mainFolder.'/templates/resized/'.$imageTwoName;
            }

            if($condicion1[2] == 1) //gif
            $im = imagecreatefromgif(asset($imageOneSrc));
            if($condicion1[2] == 2) //jpg
            $im = imagecreatefromjpeg(asset($imageOneSrc));
            if($condicion1[2] == 3) //png
            $im = imagecreatefrompng(asset($imageOneSrc));

            if($condicion[2] == 1) //gif
            $im2 = imagecreatefromgif(asset($imageTwoSrc));
            if($condicion[2] == 2) //jpg
            $im2 = imagecreatefromjpeg(asset($imageTwoSrc));
            if($condicion[2] == 3) //png
            $im2 = imagecreatefrompng(asset($imageTwoSrc));

            if($imageTwoAngle != 0){
                $pngTransparency = imagecolorallocatealpha($im2 , 0, 0, 0, 127);
                $im22 = imageRotate($im2, (360 - $imageTwoAngle), $pngTransparency);
                $im2 = $im22;
            }

            imagecopy($im, $im2, $imageOneX, $imageOneY, 0, 0, imagesx($im2), imagesy($im2));

            $printImg = rand(10000, 99999).'.jpg';
            imagejpeg($im, public_path($mainFolder.'/designs/'.$printImg), 100);
            imagedestroy($im);
            imagedestroy($im2);

            if(file_exists(asset($mainFolder.'/templates/resized/'.$imageTwoName))){

                unlink(public_path($mainFolder.'/templates/resized/'.$imageTwoName));
            }

            return ['success' => 1, 'error' => 0, 'data' => $printImg];

        }catch (Exception $e) {

            return ['success' => 0, 'error' => $e->getMessage(), 'data' => 0];
        }
    }


    public static function getUserRealCampaignDetails($userId){

        $userCampaign = UserCampaign::where('user_id', $userId)->where('status', 'active')->orderBy('id', 'desc')->first();

        if($userCampaign){
            $daysLeft = $userCampaign->daysLeft();
            if($daysLeft <= 0 && $userCampaign->title != ''){

                $userCampaign->status = 'inactive';
                $userCampaign->is_live = 0;
                $userCampaign->save();
            }
        }
        $userCampaign = UserCampaign::where('user_id', $userId)->where('status', 'active')->orderBy('id', 'desc')->first();
        if(!$userCampaign){

            $campaign = new UserCampaign;
            $campaign->user_id = $userId;
            $campaign->amount = $campaign->duration = $campaign->extend_duration = $campaign->non_charity_payment_flag = 0;
            $campaign->title = '';
            $campaign->save();
            $userCampaign = $campaign;
        }

        $campaign = array();

        $campaign = self::getCampaignRealDetails($userCampaign);

        return $campaign;
    }

    public static function getCampaignRealDetails($userCampaign){

        if($userCampaign !== null){

            $userr = $userCampaign->user;
            $amountRaised = $amountRaisedAge = $daysLeft = $successful = $unsuccessful = 0;
            $offeredProducts = $projectStartedSinceDays = $amountRaisedPercent = 0;

            $amountRaisingCustomers = array();
            $instantFans = array();
            foreach($userCampaign->checkouts as $checkout){

                if($checkout->type == 'crowdfund'){
                    //$amountRaised += self::convert($checkout->currency, $userCampaign->currency, $checkout->amount);
                    $amountRaisingCustomers[] = $checkout->customer->id;
                }
            }

            $amountRaised = $userCampaign->amountRaised();

            foreach($userr->checkouts as $checkout){

                if($checkout->type == 'instant' && $checkout->customer){
                    $instantFans[] = $checkout->customer->id;
                }
            }

            if($userCampaign->amount > 0 && $amountRaised > 0){
                $amountRaisedPercent = ($amountRaised/$userCampaign->amount) * 100;
                if($amountRaisedPercent > 100){

                    $amountRaisedPercent = 100;
                }
                $amountRaisedPercent = ceil( $amountRaisedPercent );
            }

            $daysLeft = $userCampaign->daysLeft();

            $successful = $amountRaised >= $userCampaign->amount && $userCampaign->amount > 0 ? 1 : 0;
            $unsuccessful = $amountRaised < $userCampaign->amount && $userCampaign->amount > 0 && $daysLeft <= 0 ? 1 : 0;

            $targetAmount = $userCampaign->amount > 0 ? self::getNumberShortened($userCampaign->amount, 2) : 'N/A';

            foreach ($userr->musics as $key => $music) {
                //$offeredProducts++;
                //$datesArray[] = strtotime($music->created_at);
            }
            foreach ($userr->products as $key => $product) {
                $offeredProducts++;
                $datesArray[] = strtotime($product->created_at);
            }

            if(isset($datesArray) && is_array($datesArray) && count($datesArray) > 0){
                $minimumTime = min($datesArray);
                $date = date("Y-m-d H:i:s", $minimumTime);
                $date = \Carbon\Carbon::parse($date);
                $projectStartedSinceDays = $date->diffInDays();
            }

            $currencySymbol = self::getCurrencySymbol($userCampaign->currency);

            $campaign['campaignUserInfo'] = self::getUserRealDetails($userr->id);

            if($userCampaign->is_live == 1 && $userCampaign->status == 'active'){

                $campaign['tierOneTextOne'] = count($amountRaisingCustomers);
                $campaign['tierOneTextTwo'] = 'Fans supported this';
                $campaign['tierTwoTextOne'] = $currencySymbol.number_format($amountRaised, 0);
                $campaign['tierTwoTextTwo'] = 'Raised of <text class="target_value">'.$currencySymbol.$targetAmount.'</text> Target';
                $campaign['tierThreeTextOne'] = $successful || $unsuccessful ? 'Project status' : $daysLeft;
                $campaign['tierThreeTextTwo'] = $successful ? 'Successful' : ($unsuccessful ? 'Expired' : 'days left');
                $campaign['mainHeaderImage'] = '/percent-images/'.$amountRaisedPercent.'.png';
                $campaign['mainHeaderTextOne'] = '';
                $campaign['mainHeaderTextTwo'] = 'Status '.ucfirst($userCampaign->status);
                $campaign['projectTitle'] = $userr->name."'s Project";
            }else{
                $campaign['tierOneTextOne'] = $offeredProducts;
                $campaign['tierOneTextTwo'] = 'Products available';
                $campaign['tierTwoTextOne'] = 'City';
                $campaign['tierTwoTextTwo'] = $campaign['campaignUserInfo']['city'];
                $campaign['tierThreeTextOne'] = 'Skill';
                $campaign['tierThreeTextTwo'] = $campaign['campaignUserInfo']['skills'];
                $campaign['mainHeaderImage'] = $campaign['campaignUserInfo']['profileImageCard'];
                $campaign['mainHeaderTextOne'] = 'My Music, Products & Licensing';
                $campaign['mainHeaderTextTwo'] = '';
                $campaign['projectTitle'] = $userr->name."'s Store";
            }

            $campaign['campaignIsLive'] = $userCampaign->is_live;
            $campaign['campaignTitle'] = $userCampaign->title;
            $campaign['campaignPercentImage'] = '/percent-images/'.$amountRaisedPercent.'.png';;
            $campaign['campaignGoal'] = $targetAmount!='N/A'?$currencySymbol.$targetAmount:'N/A';
            $campaign['campaignProducts'] = $offeredProducts;
            $campaign['campaignStatus'] = $successful ? 'Successful' : ($unsuccessful ? 'Unsuccessful' : $userCampaign->status);
            $campaign['campaignDonators'] = count($amountRaisingCustomers);
            $campaign['amountRaised'] = $amountRaised;
            $campaign['campaignCharity'] = $userCampaign->is_charity;
            $campaign['campaignAmount'] = $userCampaign->amount;
            $campaign['campaignDuration'] = $userCampaign->duration;
            $campaign['campaignSuccessful'] = $successful;
            $campaign['campaignUnsuccessful'] = $unsuccessful;
            $campaign['campaignDaysLeft'] = $daysLeft;
            $campaign['campaignExtendDuration'] = $userCampaign->extend_duration;
            $campaign['campaignProjectVideoId'] = $userCampaign->project_video_url;
            $campaign['campaignCurrency'] = $userCampaign->currency;
            $campaign['campaignCurrencySymbol'] = $currencySymbol;
            $campaign['isLive'] = $userCampaign->is_live;
            $campaign['id'] = $userCampaign->id;
            $campaign['willExpireOn'] = $userCampaign->willExpireOn();

        }else{

            $campaign = array();
        }

        return $campaign;
    }

    public static function getUserRealDetails($userId){

        $user = User::where('id', $userId)->first();

        $cityId = ($user->address) ? $user->address->city_id : 0;
        $countryId = ($user->address) ? $user->address->country_id : 0;
        $postcode = ($user->address) ? $user->address->post_code : '';

        if(isset($cityId) && $cityId && $cityId != ''){

            $city = City::find($cityId);
        }
        if(isset($countryId) && $countryId && $countryId != ''){

            $country = Country::find($countryId);
        }

        if($user->profile->genre_id){
            $genre = Genre::find($user->profile->genre_id);
            if($genre !== null){
                $genreName = $genre->name;
                $genreId = $genre->id;
            }
        }

        $emailExplode = explode('@',$user->email);
        $userDetails['name'] = $user->name;
        $userDetails['first_name'] = $user->first_name;
        $userDetails['surname'] = $user->surname;
        $userDetails['email'] = $user->email;
        $userDetails['username'] = $user->username;
        $userDetails['profilePageLink'] = isset($emailExplode[0]) && $emailExplode[0] != '' ? route('user.home',['params' => $emailExplode[0]]) : '';
        $userDetails['image'] = self::getUserDisplayImage($user->id);
        $userDetails['address'] = ($user->address) ? $user->address->address_01 : '';
        $userDetails['postcode'] = $postcode;
        $userDetails['city'] = (isset($city) && $city) ? $city->name : '';
        $userDetails['cityId'] = (isset($city) && $city) ? $city->id : '';
        $userDetails['countryId'] = (isset($country) && $country) ? $country->id : '';
        $userDetails['country'] = (isset($country) && $country) ? $country->name : '';
        $userDetails['countryCode'] = (isset($country) && $country) ? $country->code : '';
        $userDetails['storyImages'] = $user->profile->story_images;
        $userDetails['storyText'] = html_entity_decode( $user->profile->story_text );
        $userDetails['splitName'] = preg_replace('/\s/', '<br/>', $userDetails['name'], 1);
        $userDetails['skills'] = $user->skills;
        $userDetails['sec_skill'] = $user->sec_skill;
        $userDetails['homePage'] = $user->username ? route('user.home', ['params' => $user->username]) : '';
        $userDetails['projectPage'] = $user->username && $user->username != '' ? route('user.project', ['username' => $user->username]) : '';
        $userDetails['profileImage'] = self::getUserDisplayImage($user->id);
        $userDetails['profileImageCard'] = self::getUserDisplayImageCard($user->id);
        $userDetails['profileImageCarosel'] = self::getUserDisplayImageCarosel($user->id);
        $userDetails['profileImageOriginal'] = self::getUserDisplayImageOriginal($user->id);
        $userDetails['address'] = ($user->address) ? $user->address->address_01 : '';
        $userDetails['gender'] = $user->profile->gender;
        $userDetails['furtherSkillsIds'] = $user->further_skills;
        $userDetails['furtherSkillsArray'] = self::getUserFurtherSkillsArray($userDetails['furtherSkillsIds']);
        $userDetails['furtherSkillsString'] = (is_array( $userDetails['furtherSkillsArray'] ) && count( $userDetails['furtherSkillsArray'] )) ? implode(',', $userDetails['furtherSkillsArray']) : '';
        $userDetails['level'] = $user->level;
        $userDetails['accountType'] = $user->profile->account_type;
        $userDetails['emailInitials'] = $user->username;
        $userDetails['defaultCurrency'] = $user->profile->default_currency;
        $userDetails['genreId'] = isset($genreId) ? $genreId : '';
        $userDetails['genre'] = isset($genreName) ? $genreName : '';
        $userDetails['hearAbout'] = $user->hear_about;
        $userDetails['bioVideoUrl'] = $user->profile->user_bio_video_url;
        $userDetails['bioVideoId'] = $user->profile->user_bio_video_id;
        $userDetails['website'] = $user->profile->website;
        $userDetails['phone'] = $user->contact_number;
        $userDetails['mapsUrl'] = $user->maps_url;
        $userDetails['company'] = $user->company;

        if(!$user->email){

            $nonExistantCheckout = StripeCheckout::where('customer_id', $user->id)->first();
            if($nonExistantCheckout){

                $userDetails['email'] = $nonExistantCheckout->email;
                $userDetails['address'] = $nonExistantCheckout->address;
                $userDetails['postcode'] = $nonExistantCheckout->postcode;
                $userDetails['city'] = $nonExistantCheckout->city;
                $userDetails['country'] = $nonExistantCheckout->country;
            }
        }

        return $userDetails;
    }

    public static function userCanUploadFile($user, $request, $name){

        $userAllowedVolume = 0;
        $userVolume = self::userDataVolume($user->id);
        $internalPackages = Config('constants.user_internal_packages');
        $userPackage = InternalSubscription::where(['user_id' => $user->id, 'subscription_status' => 1])->first();
        if($userPackage){

            $userPackage = explode('_', $userPackage->subscription_package);
            $userPackage = $userPackage[0];
        }else{
            $userPackage = 'silver';
        }
        foreach ($internalPackages as $internalPackage) {
            if($internalPackage['name'] == $userPackage){
                $userAllowedVolume = $internalPackage['volume'] * 1073741824;
            }
        }
        if($request->file($name)->getSize() + $userVolume['total'] >= $userAllowedVolume){

            return false;
        }

        return true;
    }

    public static function canUserAddNetwork($user)
    {
        $userAllowedNetwork = 0;
        $internalPackages = Config('constants.user_internal_packages');
        $userPackage = InternalSubscription::where(['user_id' => $user->id, 'subscription_status' => 1])->first();
        $userNetworks = $user->contacts()->count();

        if($userPackage){
            $userPackage = explode('_', $userPackage->subscription_package);
            $userPackage = $userPackage[0];
        } else{
            $userPackage = 'silver';
        }

        foreach ($internalPackages as $internalPackage) {
            if($internalPackage['name'] == $userPackage){
                $userAllowedNetwork = $internalPackage['network_limit'];
                break;
            }
        }

        if($userNetworks < $userAllowedNetwork) {
            return true;
        }

        return false;
    }

    public static function userCheckoutApplicationFee($userId){

        $user = User::find($userId);
        $internalPackages = Config('constants.user_internal_packages');
        $userPackage = InternalSubscription::where(['user_id' => $user->id, 'subscription_status' => 1])->first();
        if($userPackage){

            $userPackage = explode('_', $userPackage->subscription_package);
            $userPackage = $userPackage[0];
        }else{
            $userPackage = 'silver';
        }
        foreach ($internalPackages as $internalPackage) {
            if($internalPackage['name'] == $userPackage){
                $fee = $internalPackage['application_fee'];
            }
        }

        return $fee;
    }

    public static function userAgentCheckoutFee($userId){

        $return = ['agent_id' => 0, 'percent' => 0];
        $user = User::find($userId);
        if($user){
            $userContact = AgentContact::where(['contact_id' => $user->id])->first();
            if($userContact && $userContact->contactUser && $userContact->agentUser && $userContact->agentUser->expert && $userContact->agentUser->expert->agent_from_platform_fee_type == 2 && $userContact->approved == 1 && $userContact->contactUser->profile->stripe_user_id != '' && $userContact->agentUser->profile->story_text != '' && $userContact->agentUser->custom_background != ''){
                $userMusics = UserMusic::where(['user_id' => $userContact->agentUser->id])->get();
                $userProducts = UserProduct::where(['user_id' => $userContact->agentUser->id])->get();
                if((count($userMusics) + count($userProducts)) >= 3){

                    $return['agent_id'] = $userContact->agentUser->id;
                    $return['percent'] = $userContact->agentUser->expert->agent_from_platform_fee;
                }
            }
        }

        return $return;
    }

    public static function userDataVolume($userId){

        $return = ['musicData' => 0, 'productData' => 0, 'campaignData' => 0, 'otherData' => 0, 'total' => 0];
        $user = User::find($userId);
        if($user !== null){

            if(count($user->musics)){

                foreach ($user->musics as $userMusic) {

                    if(self::fileExists(public_path('user-music-thumbnails/' . $userMusic->thumbnail_feat))){

                        $return['musicData'] += self::getFileSize(public_path('user-music-thumbnails/' . $userMusic->thumbnail_feat));
                    }
                    if(self::fileExists(public_path('user-music-files/' . $userMusic->music_file))){

                        $return['musicData'] += self::getFileSize(public_path('user-music-files/' . $userMusic->music_file));
                    }
                    if(is_array($userMusic->loops) && count($userMusic->loops)){

                        foreach ($userMusic->loops as $musicLoop) {
                            if(trim($musicLoop) != ''){

                                if(self::fileExists(public_path('user-music-files/loops/' . $musicLoop))){

                                    $return['musicData'] += self::getFileSize(public_path('user-music-files/loops/' . $musicLoop));
                                }
                            }
                        }
                        foreach ($userMusic->stems as $musicStem) {
                            if(trim($musicStem) != ''){

                                if(self::fileExists(public_path('user-music-files/stems/' . $musicStem))){

                                    $return['musicData'] += self::getFileSize(public_path('user-music-files/stems/' . $musicStem));
                                }
                            }
                        }
                    }
                }
                foreach ($user->products as $userProduct) {

                    if(self::fileExists(public_path('user-product-thumbnails/' . $userProduct->thumbnail))){

                        $return['productData'] += self::getFileSize(public_path('user-product-thumbnails/' . $userProduct->thumbnail));
                    }
                }

                $userCampaign = self::getUserRealCampaignDetails($userId);
                $userCampaign = UserCampaign::find($userCampaign['id']);
                if($userCampaign && count($userCampaign->perks)){

                    foreach ($userCampaign->perks as $bonus) {

                        if(self::fileExists(public_path('user-bonus-thumbnails/' . $bonus->thumbnail))){

                            $return['campaignData'] += self::getFileSize(public_path('user-bonus-thumbnails/' . $bonus->thumbnail));
                        }
                    }
                }
            }
        }

        $return['total'] = $return['musicData'] + $return['productData'] + $return['campaignData'];
        return $return;
    }

    public static function getFileSize($file){

        $return = 0;

        $return = filesize($file);
        return $return;
    }


    public static function getCurrencySymbol($currency){
        if( $currency == '' ){
            return '';
        }else if( $currency == 'USD' || $currency == 'usd' ){
            return '$';
        }else if( $currency == 'GBP' || $currency == 'gpp' ){
            return '£';
        }else if( $currency == 'EUR' || $currency == 'eur' ){
            return '€';
        }
    }







    public static function getCurrencies(){







        return array('USD'=>'USD','GBP'=>'GBP','EUR'=>'EUR');



    }







    public static function currencyConverter(Request $request){

        $currencyFrom = $request->input('currencyFrom');
        $currencyTo = $request->input('currencyTo');
        $amount = $request->input('amount');

        if($currencyTo == ''){

            $currencyTo = 'GBP';
        }

        if($currencyFrom == $currencyTo || $amount == 0){

            $valueNOK = $amount;
        }else{

            //$valueNOK = Currency::conv($from = $currencyFrom, $to = $currencyTo, $value = $amount, $decimals = 2);
            //$value = file_get_contents('https://free.currconv.com/api/v7/convert?q='.$currencyFrom.'_'.$currencyTo.'&compact=ultra&apiKey=eb81f53143815dae528c');

            //$obj = json_decode($value, true);
            //$exchangeRate = $obj[$currencyFrom.'_'.$currencyTo];
            //$valueNOK = $exchangeRate * $amount;

            $valueNOK = Currency::convert()->from($currencyFrom)->to($currencyTo)->amount($amount)->get();
        }

        $toGBP = $request->input('toGBP');
        if(isset($toGBP) && $currencyFrom != 'GBP' && $amount != 0){

            //$value = file_get_contents('https://free.currconv.com/api/v7/convert?q='.$currencyFrom.'_GBP'.'&compact=ultra&apiKey=eb81f53143815dae528c');

            //$obj = json_decode($value, true);
            //$exchangeRate = $obj[$currencyFrom.'_'.$currencyTo];
            //$valueNOK = $exchangeRate * $amount;

            //$valueNOK = $valueNOK . ", " . Currency::conv($from = $currencyFrom, $to = "GBP", $value = $amount, $decimals = 2);

            $valueNOK = Currency::convert()->from($currencyFrom)->to($currencyTo)->amount($amount)->get();
        }else if(isset($toGBP)){

            $valueNOK = $valueNOK.', '.$amount;
        }

        return number_format($valueNOK, 2);
    }








    public function isDomainCotyso()
    {
        $currentUrl = URL::current();
        $domain = parse_url($currentUrl, PHP_URL_HOST);

        if ($domain == Config('constants.singingExperienceDomain')) {
            return true;
        } else {
            return false;
        }
    }

    public function getStripePublicKey()
    {
        return $this->isDomainCotyso() ? Config('constants.stripe_live_key_public') : Config('constants.stripe_key_public');
    }

    public function getStripeSecretKey()
    {
        return Config('constants.stripe_payment_mode') == 'live' || $this->isDomainCotyso() ? Config('constants.stripe_live_key_secret') : Config('constants.stripe_key_secret');
    }

    public function getStripeConnectId()
    {
        return Config('constants.stripe_payment_mode') == 'live' || $this->isDomainCotyso() ? Config('constants.stripe_live_connect_client_id') : Config('constants.stripe_connect_client_id');
    }

    public function getStripeWebhookSecret()
    {
        return Config('constants.stripe_payment_mode') == 'live' || $this->isDomainCotyso() ? Config('constants.stripe_live_webhook_secret') : Config('constants.stripe_webhook_secret');
    }


    public static function convert($currencyFrom, $currencyTo, $amount){

        if($currencyTo == ''){

            $currencyTo = 'GBP';
        }

        if($currencyFrom == $currencyTo || $amount == 0){

            return $amount;
        }else{

            /*$content = file_get_contents('https://www.google.com/finance/converter?a='.$amount.'&from='.$currencyFrom.'&to='.$currencyTo);
            $doc = new \DOMDocument;
            @$doc->loadHTML($content);
            $xpath = new \DOMXpath($doc);
            $result = $xpath->query('//*[@id="currency_converter_result"]/span')->item(0)->nodeValue;
            return str_replace(' '.$currencyTo, '', $result);*/
            //To convert a value
            //$valueNOK = Currency::conv($from = $currencyFrom, $to = $currencyTo, $value = $amount, $decimals = 2);
            //$valueNOK = $amount;

            //$value = file_get_contents('https://free.currconv.com/api/v7/convert?q='.$currencyFrom.'_'.$currencyTo.'&compact=ultra&apiKey=eb81f53143815dae528c');

            //$obj = json_decode($value, true);
            //$exchangeRate = $obj[$currencyFrom.'_'.$currencyTo];
            //$valueNOK = $exchangeRate * $amount;

            $valueNOK = Currency::convert()->from($currencyFrom)->to($currencyTo)->amount($amount)->get();

            number_format($valueNOK, 2);
        }
    }



    public function removeEmoji($string){

        // Match Enclosed Alphanumeric Supplement
        $regex_alphanumeric = '/[\x{1F100}-\x{1F1FF}]/u';
        $clear_string = preg_replace($regex_alphanumeric, '', $string);

        // Match Miscellaneous Symbols and Pictographs
        $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clear_string = preg_replace($regex_symbols, '', $clear_string);

        // Match Emoticons
        $regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clear_string = preg_replace($regex_emoticons, '', $clear_string);

        // Match Transport And Map Symbols
        $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clear_string = preg_replace($regex_transport, '', $clear_string);

        // Match Supplemental Symbols and Pictographs
        $regex_supplemental = '/[\x{1F900}-\x{1F9FF}]/u';
        $clear_string = preg_replace($regex_supplemental, '', $clear_string);

        // Match Miscellaneous Symbols
        $regex_misc = '/[\x{2600}-\x{26FF}]/u';
        $clear_string = preg_replace($regex_misc, '', $clear_string);

        // Match Dingbats
        $regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
        $clear_string = preg_replace($regex_dingbats, '', $clear_string);

        return $clear_string;
    }




    public static function getVideoTitle($videoId){

        $commonMethods = new CommonMethods;

        if( $videoId != '' ){



            try{

                $youtube = new Youtube('AIzaSyClmbXrPVdKDFBIEzIcX4ZvblS9tZwA6fE');
                $details = json_decode(json_encode($youtube->getVideoInfo($videoId)), true);
                $title = $commonMethods->removeEmoji(htmlspecialchars_decode($details['snippet']['title']));

            } catch(\Exception $ex){



                return "No Description";



            }



        }else{







            $title = '';



        }







        return $title;



    }

    public static function validateYoutubeLink($value) {

        if(preg_match('/^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/i', $value)){
            return true;
        }

        return false;
    }


    public static function getYoutubeIdFromUrl($url) {

        $parts = parse_url($url);
        if(isset($parts['query'])){
            parse_str($parts['query'], $qs);
            if(isset($qs['v'])){
                return $qs['v'];
            }else if(isset($qs['vi'])){
                return $qs['vi'];
            }
        }
        if(isset($parts['path'])){
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path)-1];
        }
        return false;
    }




    public static function getUserDefaultDisplayImage(){







        return asset('user-display-images').'/general-display-image-2.jpg';



    }







    public static function getUserDefaultDisplayImageSlider(){







        return asset('user-display-images').'/general-display-image-slider.jpg';



    }



    public static function getUserDefaultDisplayImageCarosel(){







        return asset('user-display-images').'/general-display-image-2.jpg';



    }

    public static function getUserDefaultDisplayImageCard(){







        return asset('user-display-images').'/general-display-image-card-02.jpg';



    }







    public static function getUserDisplayImage($userId){







        $user = User::find($userId);



        $userGeneralDisplayImage = self::getUserDefaultDisplayImage();



        $userDisplayImage = $userGeneralDisplayImage;



        if($user) {



            $userDisplayImage = asset('user-display-images') . '/' . $user->profile->profile_display_image;

            $userDisplayImage = ($user->profile->profile_display_image == '' || !self::fileExists(public_path('user-display-images/' . $user->profile->profile_display_image))) ? $userGeneralDisplayImage : $userDisplayImage;



        }







        return $userDisplayImage;



    }



    public static function getUserDisplayImageCard($userId){







        $user = User::find($userId);



        $userGeneralDisplayImage = self::getUserDefaultDisplayImageCard();



        $userDisplayImage = $userGeneralDisplayImage;



        if($user) {



            $userDisplayImage = asset('user-display-images') . '/' . $user->profile->profile_display_image_card;

            $userDisplayImage = ($user->profile->profile_display_image_card == '' || !self::fileExists(public_path('user-display-images/' . $user->profile->profile_display_image_card))) ? $userGeneralDisplayImage : $userDisplayImage;



        }







        return $userDisplayImage;



    }


    public static function getUserDisplayImageCarosel($userId){



        $user = User::find($userId);



        $userGeneralDisplayImage = self::getUserDefaultDisplayImageCarosel();



        $userDisplayImage = $userGeneralDisplayImage;



        if($user) {



            $userDisplayImage = asset('user-display-images') . '/' . $user->profile->profile_display_image_slider;

            $userDisplayImage = ($user->profile->profile_display_image_slider == '' || !self::fileExists(public_path('user-display-images/' . $user->profile->profile_display_image_slider))) ? $userGeneralDisplayImage : $userDisplayImage;



        }







        return $userDisplayImage;



    }


    public static function getUserDisplayImageOriginal($userId){







        $user = User::find($userId);



        $userGeneralDisplayImage = self::getUserDefaultDisplayImage();



        $userDisplayImage = $userGeneralDisplayImage;



        if($user) {



            $userDisplayImage = asset('user-display-images') . '/' . $user->profile->profile_display_image_original;



            $userDisplayImage = ($user->profile->profile_display_image_original == '' || !self::fileExists(public_path('user-display-images/' . $user->profile->profile_display_image_original))) ? $userGeneralDisplayImage : $userDisplayImage;



        }







        return $userDisplayImage;



    }







    public static function getUserDisplayImageSlider($userId){







        $user = User::find($userId);



        $userGeneralDisplayImage = self::getUserDefaultDisplayImageSlider();



        $userDisplayImage = asset('user-display-images').'/'.$user->profile->profile_display_image_slider;



        $userDisplayImage = ( $user->profile->profile_display_image_slider == '' || !self::fileExists(public_path('user-display-images/'.$user->profile->profile_display_image_slider)) ) ? $userGeneralDisplayImage : $userDisplayImage;







        return $userDisplayImage;



    }







    public static function getUserDisplayImageSliderVertical($userId){







        $user = User::find($userId);



        $userGeneralDisplayImage = self::getUserDefaultDisplayImageVerticalSlider();



        $userDisplayImage = asset('user-display-images').'/'.$user->profile->profile_display_image_slider_vertical;



        $userDisplayImage = ( $user->profile->profile_display_image_slider_vertical == '' || !self::fileExists($userDisplayImage) ) ? $userGeneralDisplayImage : $userDisplayImage;







        return $userDisplayImage;



    }







    public static function getUserProfileThumb($userId, $campaignId = 0){







        $user = User::find($userId);



        if($campaignId != 0){



            $userCampaign = \App\Models\UserCampaign::where('user_id', $user->id)->where('id', $campaignId)->first();



        } else {



            $userCampaign = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'active')->orderBy('id', 'desc')->first();



        }



        $userProfileVideoUrl = $userCampaign->project_video_url;



        if( $userProfileVideoUrl != '' ){



            parse_str( parse_url( $userProfileVideoUrl, PHP_URL_QUERY ), $videoIdArray );



            $videoId = $videoIdArray['v'];



            $userProfileThumb = 'https://i.ytimg.com/vi/'.$videoId.'/mqdefault.jpg';



        }else{







            $userProfileThumb = self::getUserDisplayImage($userId);



        }







        return $userProfileThumb;



    }



    public function getYoutubeVideoId($url) {

        if (stristr($url,'youtu.be/')){
            preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID);
            return $final_ID[4];
        }
        else{
            @preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD);
            return $IDD[5];
        }
    }



    public static function convertDatabaseResourceToArray($resource){







        $return = array();



        foreach ($resource as $key => $value){ $return[] = (array) $resource; }



        return $return;



    }



    public static function getUserCampaignDetails($userId, $campaignId = 0){







        $return = array();



        $amountRaisingCustomers = array();



        $amountRaised = $userProducts = $amountRaisedPercent = 0;



        $upperText = $upperText = '';







        if( $userId && $userId != '' ){




            $commonMethods = new CommonMethods();


            $user = User::find($userId);



            if($campaignId != 0){



                $userCampaign = $user->campaigns()->where('id', $campaignId)->first();



            } else {



                $userCampaign = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'active')->orderBy('id', 'desc')->first();



            }



            if( !$userCampaign ){







                $campaign = new UserCampaign;



                $campaign->user_id = $user->id;



                $campaign->amount = $campaign->duration = $campaign->extend_duration = $campaign->subscription_amount =



                $campaign->non_charity_payment_flag = $campaign->non_charity_payment_flag = $campaign->unsuccessful_email_sent =



                $campaign->nearly_ending_email_sent = $campaign->nearly_successful_email_sent = $campaign->successful_owner_email_sent =



                $campaign->successful_supporter_email = 0;



                $campaign->encourage_bullet_one = $campaign->encourage_bullet_two = $campaign->encourage_bullet_three = $campaign->title = '';



                $campaign->save();



            }else{







                $campaign = $userCampaign;



            }






            foreach($campaign->checkouts as $checkout){



                $amountRaised += self::convert($checkout->currency, $campaign->currency, $checkout->amount);



                $amountRaisingCustomers[] = $checkout->customer->id;



            }











            if($campaign->amount > 0){



                $amountRaisedPercent = ($amountRaised/$campaign->amount) * 100;



                if($amountRaisedPercent > 100){



                    $amountRaisedPercent = 100;



                }



            }







            $amountRaisedPercent = ceil( $amountRaisedPercent );



            $amountRaisedNumber = $amountRaised;



            $amountRaised = self::getCurrencySymbol($campaign->currency).number_format($amountRaised);







            $daysLeft = $campaign->duration + $campaign->extend_duration - ( $campaign->created_at->diffInDays() );



            $successfulFlag = false;



            if( $amountRaisedNumber >= $campaign->amount && $campaign->amount > 0 ){



                $successfulFlag = true;



            }







            $unsuccessfulFlag = false;



            if( $amountRaisedNumber < $campaign->amount && $campaign->amount > 0 && $daysLeft <= 0 ){



                $unsuccessfulFlag = true;



            }







            $upperText = $successfulFlag == true || $unsuccessfulFlag == true ? "Project status" : $daysLeft;



            $lowerText = $successfulFlag == true ? "\nSuccessful" : "days left";



            $lowerText = $unsuccessfulFlag == true ? "\nUnsuccessful" : $lowerText;







            $userProducts = count($user->products) + count($user->musics);







        }



        $campaignGoal = $campaign->amount > 0 ? self::getNumberShortened($campaign->amount, 2) : $userProducts;

        $actualTargetAmount = $campaign->amount > 0 ? self::getCurrencySymbol($campaign->currency).self::getNumberShortened($campaign->amount, 2) : 'N/A';

        $actualAmountRaised = $amountRaised;

        $campaignGoalString = self::getCurrencySymbol($campaign->currency).$campaignGoal;



        $targetGoalText = "Target Goal";



        $supportMeLink = asset('project/' . $user->id);







        if($campaign->amount == 0){



            $amountRaised = "Store";







            // Products date



            $datesArray = array();



            if(isset($user->products)){



                foreach($user->products as $product){



                    $datesArray[] = strtotime($product->created_at);



                }



            }







            if(isset($user->musics)){



                foreach($user->musics as $music){



                    $datesArray[] = strtotime($music->created_at);



                }



            }







            $daysBeforeProjectStarted = 0;



            if(count($datesArray) > 0){



                $minimumTime = min($datesArray);



                $date = date("Y-m-d H:i:s", $minimumTime);



                $date = \Carbon\Carbon::parse($date);



                $daysBeforeProjectStarted = $date->diffInDays();



            }



            $lowerText = $daysBeforeProjectStarted > 0 ? $daysBeforeProjectStarted . " days" : $daysBeforeProjectStarted . " day";



            $upperText = "Open for";



            $amountRaisedPercent = 'default-percent';



            $amountRaisingCustomers = [];






            foreach ($campaign->checkouts as $checkout){



                $amountRaisingCustomers[] = $checkout->customer->id;



            }



            $campaignGoalString = $userProducts;



            $targetGoalText = $campaignGoalString > 1 ? "Products available" : "Product available";



            $supportMeLink = "#";



            // Products date



        }







        $return['actual_amount_raised'] = $actualAmountRaised;



        $return['actual_target_goal'] = $actualTargetAmount;



        $return['actual_campaign_currency'] = $campaign->currency;



        $return['actual_campaign_currency_symbol'] = $commonMethods->getCurrencySymbol($campaign->currency);



        $return['user_campaign_title'] = $campaign->title;



        $return['user_campaign_amount'] = $campaign->amount;



        $return['user_total_amount_raised'] = $amountRaised;



        $return['amount_raised_number'] = $amountRaisedNumber;



        $return['user_project_donators'] = array_unique($amountRaisingCustomers);



        $return['user_campaign_goal'] = $campaignGoalString;



        $return['user_campaign_days_left_upper_text'] = $upperText;



        $return['user_campaign_days_left_lower_text'] = $lowerText;



        $return['user_campaign_amount_raised_percent'] =  $amountRaisedPercent;



        $return['user_total_products'] = $userProducts;



        $return['user_project_share_image'] = self::getUserProfileThumb($user->id, $campaignId);



        $return['project_video'] = $campaign->project_video_url;



        $return['user_campaign_goal_text'] = $targetGoalText;



        $return['support_me_link'] = $supportMeLink;



        $return['days_left'] = $daysLeft;



        $return['project_successful'] = $successfulFlag;



        $return['project_unsuccessful'] = $unsuccessfulFlag;



        $return['project_status'] = 'Active';



        $return['project_status_class'] = 'active';



        if ($daysLeft <= 0) {



            $return['project_status'] = $successfulFlag ? 'Successful' : '';



            $return['project_status_class'] = $successfulFlag ? 'success' : 'fail';



        }







        return $return;



    }







    public static function getUserPersonalDetails($userId){







        $return = array();







        $return['country'] = $return['city'] = $return['genre'] = '';



        $return['country_id'] = $return['city_id'] = $return['genre_id'] = 0;







        $user = User::find($userId);



        $return['name'] = $user->name;



        $return['splitname'] = preg_replace('/\s/', '<br/>', $return['name'], 1);



        $return['fullname'] = $user->name;



        $return['email_address'] = $user->email;



        $return['skills'] = $user->skills;



        $return['user_project_share_link'] = asset('/').$user->username;



        $return['base_url'] = asset('/');



        $return['user_display_image'] = self::getUserDisplayImage($userId);


        $return['user_profile_image_original'] = self::getUserDisplayImageOriginal($userId);



        $return['address'] = $user->address->address_01;



        $return['gender'] = $user->profile->gender;







        $userAccountTypeCountry = DB::table('countries')->first();



        $userAccountTypeCity = DB::table('cities')->first();



        $return['user_studio_country'] = $userAccountTypeCountry->name;



        $return['user_studio_country_id'] = $userAccountTypeCountry->id;



        $return['user_studio_city'] = $userAccountTypeCity->name;



        $return['user_studio_city_id'] = $userAccountTypeCity->id;







        if( $user->address->country_id ){







            $country = \App\Models\Country::find($user->address->country_id);



            if( $country ){







                $return['country'] = $country->name;



                $return['country_id'] = $user->address->country_id;







                $return['user_studio_country'] = $return['country'];



                $return['user_studio_country_id'] = $return['country_id'];



            }



        }



        if( $user->address->city_id ){







            $city = \App\Models\City::find($user->address->city_id);



            if( $city ){







                $return['city'] = $city->name;



                $return['city_id'] = $city->id;







                $return['user_studio_city'] = $return['city'];



                $return['user_studio_city_id'] = $return['city_id'];



            }



        }



        if( $user->profile->genre_id ){







            $genre = \App\Genre::find($user->profile->genre_id);



            if( $genre ){







                $return['genre'] = $genre->name;



                $return['genre_id'] = $genre->id;



            }



        }



        $userAccountType = $user->accountType;



        if(count($userAccountType) > 0) {



            $userAccountTypeCountry = Country::find($userAccountType->country_id);



            $userAccountTypeCity = City::find($userAccountType->city_id);







            $return['user_studio_country'] = $userAccountTypeCountry->name;



            $return['user_studio_country_id'] = $userAccountTypeCountry->id;



            $return['user_studio_city'] = $userAccountTypeCity->name;



            $return['user_studio_city_id'] = $userAccountTypeCity->id;



        }







        $return['postcode'] = $user->address->post_code;



        $return['further_skills_ids'] = $user->further_skills;



        $return['further_skills_array'] = self::getUserFurtherSkillsArray($return['further_skills_ids']);



        $return['further_skills'] = (is_array( $return['further_skills_array'] ) && count( $return['further_skills_array'] )) ? implode(',', $return['further_skills_array']) : '';



        $return['level'] = $user->level;



        $return['account_type'] = $user->profile->account_type;



        $return['story_images'] = $user->profile->story_images;



        $return['story_text'] = html_entity_decode( $user->profile->story_text );







        return $return;



    }



    public static function getUserSocialAccountDetails($userId){

        $return = array();
        $user = User::find($userId);

        $return['facebook_account'] = $user->profile->social_facebook;
        $return['youtube_account'] = $user->profile->social_youtube;
        $return['instagram_user_access_token'] = $user->profile->social_instagram_user_access_token_ll;
        $return['instagram_user_access_token_sl'] = $user->profile->social_instagram_user_access_token_sl;
        $return['social_instagram_ll_token_date_time'] = $user->profile->social_instagram_ll_token_date_time;
        $return['instagram_user_id'] = $user->profile->social_instagram_user_id;
        $return['twitter_account'] = $user->profile->social_twitter;
        $return['spotify_artist_id'] = $user->profile->social_spotify_artist_id;

        return $return;
    }



    public static function getNumberShortened($number, $precision=0){







        $return = 0;



        $number = (int) $number;



        if ($number < 1000) {



            // Anything less than a million



            $return = number_format($number);



        }else{



            // Anything equal/greater than a thousand



            $return = number_format($number / 1000, $precision) . 'k';



        }







        return $return;



    }

    public static function getUserDetailsByVideoId($videoId){

        $return = array();
        //fetching the details of user
        $userName = $profileId = $projectTitle = $projectDescription = $userBio = '';
        $amountRaised = $userId = $projectId = $userProducts = 0;
        $amountRaisingCustomers = array();

        $video = DB::table('competition_videos')->where('video_id', '=', $videoId)->get();
        foreach ($video as $abc){ $userName = $abc->artist; $profileId = $abc->profile_id; }
        $userProfile = DB::table('profiles')->where('id', '=', $profileId)->get();
        foreach ($userProfile as $value){ $userId = $value->user_id; }
        $userProducts = DB::table('user_products')->where('user_id', '=', $userId)->get();
        $userActiveCampaign = DB::table('user_campaign')->where('user_id', '=', $userId)->where('status', '=', 'active')->get();
        foreach ($userActiveCampaign as $value){

            $projectId = $value->id;
            $projectTitle = $value->story_title;
            $projectDescription = $value->new_story_text;
            $userBio = $value->story_text;
        }

        if( $userId && $userId != '' ){

            $user = User::find($userId);
            $userCampaign = \App\Models\UserCampaign::where('user_id', $user->id)->where('status', 'active')->orderBy('id', 'desc')->first();
            if( !$userCampaign ){

                $campaign = new UserCampaign;
                $campaign->user_id = $user->id;
                $campaign->save();
            }else{

                $campaign = $userCampaign;
            }

            $checkouts = StripeCheckout::where("user_id", $user->id)->where("type", 'crowdfund')->get();
            foreach($checkouts as $checkout){

                $amountRaised += self::convert($checkout->currency, $campaign->currency, $checkout->amount);
                $amountRaisingCustomers[] = $checkout->customer->id;
            }
            $amountRaised = self::getCurrencySymbol($campaign->currency).number_format($amountRaised);
        }

        //returning the details of user
        $return['user_name'] = $userName;
        $return['profile_id'] = $profileId;
        $return['user_id'] = $userId;
        $return['project_id'] = $projectId;
        $return['project_title'] = $projectTitle;
        $return['project_description'] = html_entity_decode($projectDescription);
        $return['user_bio'] = html_entity_decode($userBio);
        $return['user_total_products'] = count($userProducts);
        $return['user_total_amount_raised'] = $amountRaised;
        $return['user_project_donators'] = $amountRaisingCustomers;

        return $return;
    }

    public static function getRedirectUrlAfterLogin(){

        return '/dashboard';
    }

    public static function getUserBrowser(){

        $return = 'chrome';
        $browser = new Browser();
        if($browser->getBrowser() == Browser::BROWSER_FIREFOX || $browser->getBrowser() == Browser::BROWSER_MOZILLA){

            $return = 'firefox';
        }else if($browser->getBrowser() == Browser::BROWSER_CHROME){

            $return = 'chrome';
        }else if($browser->getBrowser() == Browser::BROWSER_OPERA){

            $return = 'opera';
        }else if($browser->getBrowser() == Browser::BROWSER_IE){

            $return = 'internet explorer';
        }else if($browser->getBrowser() == Browser::BROWSER_SAFARI){

            $return = 'safari';
        }
        return $return;
    }



    public static function getRightLeftHeight($url){

        $return = array();
        $userBrowser = self::getUserBrowser();
        $rightBarHeight = 275;
        $leftBarHeight = 661;
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        $url = $uri_segments[1];
        if( strpos($url, 'chart') !== false ){

            $rightBarHeight = 628;
            $leftBarHeight = 635;
        }else if( strpos($url, 'profile') !== false ){

            $rightBarHeight = 635;
            $leftBarHeight = 635;
        }else if( strpos($url, 'contribute') !== false ){

            $rightBarHeight = 265;
            $leftBarHeight = 272;
        }else if( strpos($url, 'user-home') !== false ){

            $rightBarHeight = 275;
            $leftBarHeight = 661;
        }else if( strpos($url, 'tv') !== false ){

            $rightBarHeight = 628;
            $leftBarHeight = 635;
        }else if( strpos($url, 'live') !== false ){

            $rightBarHeight = 628;
            $leftBarHeight = 635;
        }else if( strpos($url, 'alfie') !== false ){

            $rightBarHeight = 628;
            $leftBarHeight = 635;
        }

        if( $userBrowser == 'firefox' ){

            $rightBarHeight = $rightBarHeight + 3;
            $leftBarHeight = $leftBarHeight + 2;
        }

        $return['right_bar_height'] = $rightBarHeight;
        $return['left_bar_height'] = $leftBarHeight;
        return $return;
    }

    public static function getAmountRaisedDetails($campaign){

        $amountRaised = 0;
        $amountRaisingCustomers = array();
        if($campaign) {

            $checkouts = StripeCheckout::where("user_id", $campaign->user->id)->where("type", 'crowdfund')->get();
            foreach ($checkouts as $checkout) {

                $amountRaised += self::convert($checkout->currency, $campaign->currency, $checkout->amount);
                $amountRaisingCustomers[] = $checkout->customer->id;
            }
        }

        $data = ['amountRaised' => $amountRaised, 'amountRaisingCustomers' => $amountRaisingCustomers];
        return $data;
    }

    public static function getFormattedAmountString($camp){

        if($camp) {

            $campAmount = 0;
            $currencySymbol = self::getCurrencySymbol($camp->currency);
            $campAmount = $camp->amount;
            $amountString = $currencySymbol . $campAmount;
            $k = pow(10, 3);
            $mil = pow(10, 6);
            $bil = pow(10, 9);
            if ($campAmount >= $bil)
                $amountString = $currencySymbol . (number_format($campAmount / $bil, 2)) . 'bil';
            else if ($campAmount >= $mil)
                $amountString = $currencySymbol . (number_format($campAmount / $mil, 2)) . 'mil';
            else if ($campAmount >= $k)
                $amountString = $currencySymbol . (number_format($campAmount / $k, 2)) . 'k';
            else
                $amountString = $currencySymbol . (number_format($campAmount, 2));

            return $amountString;
        }

        return "$0";
    }

    public static function stripHtmlTags($html){

        return strip_tags(preg_replace('/<[^>]*>/','',str_replace(array("&nbsp;","\n","\r"),"",html_entity_decode($html,ENT_QUOTES,'UTF-8'))));
    }

    public static function getSocialTabTweetsDisplayLimit(){

        return '5';
    }

    public static function getUserChannel($userId){

        $url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=" . $userId . "&key=AIzaSyD0R_uyJhq86zCyHdM7YvdhLkkCHC5aqKg";

        $headers = array("content-type"=>"application/json");

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
        $st = curl_exec($ch);
        $result = json_decode($st, TRUE);
        $channelId = "";
        if(isset($result['items'])){

            foreach ($result['items'] as $item){

                $channelId = $item["id"];
                break;
            }
        }

        return $channelId;
    }

    public static function refreshUserSpotifyAccessToken($userId){

        $user = User::find($userId);
        $userRefreshToken = $user->profile->social_spotify_user_refresh_token;
        $clientSecret = '95b7c34eb76e4936827ac479855f9a99';
        $clientId = '6285fcae2a6444ecb43d380def5580f7';
        $url = 'https://accounts.spotify.com/api/token';

        $credentials = $clientId.":".$clientSecret;
        $refreshData = 'grant_type=refresh_token&refresh_token='.$userRefreshToken;

        $refreshHeaders = array(

            "Accept: */*",
            "Content-Type: application/x-www-form-urlencoded",
            "User-Agent: runscope/0.1",
            "Authorization: Basic ".base64_encode($credentials)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $refreshHeaders);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $refreshData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        $newAccessToken = $response['access_token'];
        $return = $response;
        if( $newAccessToken != '' ){

            DB::table('profiles')

                ->where('user_id', $user->id)
                ->update(['social_spotify_user_access_token' => $newAccessToken]);

            $return['error'] = '';
        }else{

            $return['error'] = 'New access token cannot be granted';
        }

        return $return;
    }



    public static function getUserSpotifyDetails($userId){

        $user = User::find($userId);
        $userAccessToken = $user->profile->social_spotify_user_access_token;

        if( $userAccessToken != '' ){

            $surl2 = "https://api.spotify.com/v1/me";
            $sch2 = curl_init($surl2);
            $headers = array(

                "Accept: */*",
                "Content-Type: application/x-www-form-urlencoded",
                "User-Agent: runscope/0.1",
                "Authorization: Bearer ".$userAccessToken
            );

            curl_setopt($sch2, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($sch2,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($sch2,CURLOPT_RETURNTRANSFER,1);
            $sjson_response2=curl_exec($sch2);
            curl_close($sch2);
            $return = json_decode($sjson_response2, TRUE);
        }else{

            $return['error'] = 'No account is connected';
        }

        return $return;
    }







    public static function getLicenceArray($userMusic){






        $commonMethods = new CommonMethods();

        $optionsArray = array();

        $ownerUser = User::find($userMusic->user_id);

        $musicSymbol = $commonMethods->getCurrencySymbol(strtoupper($ownerUser->profile->default_currency));

        if($userMusic->personal_use_only != null){


            if($userMusic->personal_use_only != 0){

                $optionsArray['Personal Use Only::'.$musicSymbol.$userMusic->personal_use_only] = "Personal Use Only (" . $musicSymbol.$userMusic->personal_use_only . ")";
            }else{

                $optionsArray['Personal Use Only::'.$musicSymbol.$userMusic->personal_use_only] = "Personal Use Only (".$musicSymbol."0)";
            }


        }



        if($userMusic->advertise_all_media != null){



            $optionsArray['Advertisement All Media::'.$musicSymbol.$userMusic->advertise_all_media] = "Advertisement All Media (" . $musicSymbol.$userMusic->advertise_all_media . ")";



        }



        if($userMusic->advertise_online != null){



            $optionsArray['Advertisement Online::'.$musicSymbol.$userMusic->advertise_online] = "Advertisement Online (" . $musicSymbol.$userMusic->advertise_online . ")";



        }



        if($userMusic->advertise_radio != null){



            $optionsArray['Advertisement Radio::'.$musicSymbol.$userMusic->advertise_radio] = "Advertisement Radio (" . $musicSymbol.$userMusic->advertise_radio . ")";



        }



        if($userMusic->advertise_tv != null){



            $optionsArray['Advertisement TV::'.$musicSymbol.$userMusic->advertise_tv] = "Advertisement TV (" . $musicSymbol.$userMusic->advertise_tv . ")";



        }



        if($userMusic->app != null){



            $optionsArray['App::'.$musicSymbol.$userMusic->app] = "App (" . $musicSymbol.$userMusic->app . ")";



        }



        if($userMusic->cable_tv != null){



            $optionsArray['Cable TV::'.$musicSymbol.$userMusic->cable_tv] = "Cable TV (" . $musicSymbol.$userMusic->cable_tv . ")";



        }



        if($userMusic->corporate_event != null){



            $optionsArray['Corporate Event/Conference::'.$musicSymbol.$userMusic->corporate_event] = "Corporate Event/Conference (" . $musicSymbol.$userMusic->corporate_event . ")";



        }



        if($userMusic->corporate_video != null){



            $optionsArray['Corporate Video::'.$musicSymbol.$userMusic->corporate_video] = "Corporate Video (" .$musicSymbol. $userMusic->corporate_video . ")";



        }



        if($userMusic->corporate_website != null){



            $optionsArray['Corporate Website::'.$musicSymbol.$userMusic->corporate_website] = "Corporate Website (" . $musicSymbol.$userMusic->corporate_website . ")";



        }



        if($userMusic->crowdfunding_campaign != null){



            $optionsArray['Crowdfunding Campaign::'.$musicSymbol.$userMusic->crowdfunding_campaign] = "Crowdfunding Campaign (" . $musicSymbol.$userMusic->crowdfunding_campaign . ")";



        }



        if($userMusic->film != null){



            $optionsArray['Film::'.$musicSymbol.$userMusic->film] = "Film (" . $musicSymbol.$userMusic->film . ")";



        }



        if($userMusic->film_festival != null){



            $optionsArray['Film Festival::'.$musicSymbol.$userMusic->film_festival] = "Film Festival (" . $musicSymbol.$userMusic->film_festival . ")";



        }



        if($userMusic->film_independent != null){



            $optionsArray['Film Independent::'.$musicSymbol.$userMusic->film_independent] = "Film Independent (" . $musicSymbol.$userMusic->film_independent . ")";



        }



        if($userMusic->film_trailer != null){



            $optionsArray['Film Trailer::'.$musicSymbol.$userMusic->film_trailer] = "Film Trailer (" . $musicSymbol.$userMusic->film_trailer . ")";



        }



        if($userMusic->network_tv != null){



            $optionsArray['Network TV::'.$musicSymbol.$userMusic->network_tv] = "Network TV (" . $musicSymbol.$userMusic->network_tv . ")";



        }



        if($userMusic->online_video != null){



            $optionsArray['Online Video::'.$musicSymbol.$userMusic->online_video] = "Online Video (" . $musicSymbol.$userMusic->online_video . ")";



        }



        if($userMusic->personal_use_website != null){



            $optionsArray['Personal Use Website::'.$musicSymbol.$userMusic->personal_use_website] = "Personal Use Website (" . $musicSymbol.$userMusic->personal_use_website . ")";



        }



        if($userMusic->podcast != null){



            $optionsArray['Podcast::'.$musicSymbol.$userMusic->podcast] = "Podcast (" . $musicSymbol.$userMusic->podcast . ")";



        }



        if($userMusic->professional_website != null){



            $optionsArray['Professional Website::'.$musicSymbol.$userMusic->professional_website] = "Professional Website (" . $musicSymbol.$userMusic->professional_website . ")";



        }



        if($userMusic->retail != null){



            $optionsArray['Retail/In-Store::'.$musicSymbol.$userMusic->retail] = "Retail/In-Store (" . $musicSymbol.$userMusic->retail . ")";



        }



        if($userMusic->telephone != null){



            $optionsArray['Telephone::'.$musicSymbol.$userMusic->telephone] = "Telephone (" . $musicSymbol.$userMusic->telephone . ")";



        }



        if($userMusic->tv_promo != null){



            $optionsArray['TV Promo::'.$musicSymbol.$userMusic->tv_promo] = "TV Promo (" . $musicSymbol.$userMusic->tv_promo . ")";



        }



        if($userMusic->video_game != null){



            $optionsArray['Video Game::'.$musicSymbol.$userMusic->video_game] = "Video Game (" . $musicSymbol.$userMusic->video_game . ")";



        }



        if($userMusic->wedding_live_event_video != null){



            $optionsArray['Wedding/Live Event Video::'.$musicSymbol.$userMusic->wedding_live_event_video] = "Wedding/Live Event Video (" . $musicSymbol.$userMusic->wedding_live_event_video . ")";



        }



        /*if($userMusic->copyright_buyout != null){



            $optionsArray['Copyright Buyout::'.$musicSymbol.$userMusic->copyright_buyout] = "Copyright Buyout (" . $musicSymbol.$userMusic->copyright_buyout . ")";



        }*/



        /*if($userMusic->master_buyout != null){



            $optionsArray['Master Buyout::'.$musicSymbol.$userMusic->master_buyout] = "Master Buyout (" . $musicSymbol.$userMusic->master_buyout . ")";



        }*/







        return $optionsArray;







    }














    public static function getStreamLiveStatement($stream){







        if( $stream === null ){







            return '';



        }







        if( $stream->live_status == '1' ){







            return date( 'M j, Y', strtotime( $stream->live_start_date_time ) ).' - '.date( 'g:i a', strtotime( $stream->live_start_date_time ) );



        }else{







            return '';



        }







    }



    public static function streamLiveStatus($stream){


        date_default_timezone_set("Europe/London");




        if( $stream === null ){







            return false;



        }







        if(strtotime($stream->live_start_date_time) <= time() && strtotime($stream->live_end_date_time) > time()){







            return true;



        }else{







            return false;



        }







    }


    public static function fileExists($file){







        $return = false;


        if (File::exists($file)){







            $return = true;



        }



        return $return;



    }







    public static function getCustomerBasket(){

        if(!isset($_SESSION)) {

            session_start();
        }
        $basket = [];
        if(Auth::user()){

            $authUser = Auth::user();
            if( isset($_SESSION['basket_customer_id']) && $_SESSION['basket_customer_id'] != $authUser->id ){

                $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 0)->get();
                $customerExistingBasket = CustomerBasket::where('customer_id', $authUser->id)->where('sold_out', 0)->first();
                foreach ($basket as $b){

                    if($customerExistingBasket === null || ($customerExistingBasket !== null && $customerExistingBasket->user_id == $b->user_id) ){

                        $b->customer_id = $authUser->id;

                        $b->save();
                    }
                }
            }

            $_SESSION['basket_customer_id'] = $authUser->id;

            $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 0)->get();
        }else if(isset($_SESSION['basket_customer_id'])){

            $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 0)->get();
        }else if (!isset($_SESSION['basket_customer_id'])){

            $_SESSION['basket_customer_id'] = time()+rand(10000, 99999);
            $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 0)->get();
        }

        if(count($basket) > 0) {
            foreach ($basket as $b) {
                if($b->purchase_type == 'music' && !$b->music){
                    $b->delete();
                }elseif($b->purchase_type == 'album' && !$b->album){
                    $b->delete();
                }elseif($b->purchase_type == 'product' && !$b->product){
                    $b->delete();
                }elseif($b->purchase_type == 'custom_product' && !$b->product){
                    $b->delete();
                }elseif($b->purchase_type == 'instant-project' || $b->purchase_type == 'project' || $b->purchase_type == 'instant-product' || $b->purchase_type == 'instant-license'){
                    $explode = explode('_', $b->extra_info);
                    $chat = UserChat::find(isset($explode[1]) ? $explode[1] : 0);
                    if(!$chat){
                        $b->delete();
                    }
                }
            }
        }

        $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 0)->get();

        return $basket;
    }







    public static function getSoldOutCustomerBasket(){



        if(!isset($_SESSION)) {



            session_start();



        }



        $basket = [];



        if(Auth::user()){



            $authUser = Auth::user();



            if( isset($_SESSION['basket_customer_id']) && $_SESSION['basket_customer_id'] != $authUser->id ){



                $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 1)->get();



                foreach ($basket as $b){



                    $b->customer_id = $authUser->id;



                    $b->save();



                }



            }



            $_SESSION['basket_customer_id'] = $authUser->id;



            $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 1)->get();



        } else if(isset($_SESSION['basket_customer_id'])){



            $basket = CustomerBasket::where('customer_id', $_SESSION['basket_customer_id'])->where('sold_out', 1)->get();



        }



        return $basket;



    }







    public static function deleteCustomerBasket(){



        $customerBasket = self::getCustomerBasket();



        foreach($customerBasket as $b){



            //$b->delete();



            $b->sold_out = 1;



            $b->save();



        }



    }







    public static function getUserFurtherSkillsArray($furtherSkillsIds){

        $return = array();
        $explode = explode('-', $furtherSkillsIds);

        foreach ($explode as $key => $skillId) {

            if( $skillId != '' && $skillId ){

                $x = DB::table('music_instrument')->where('id', '=', $skillId)->first();
                if($x){

                    $return[] = $x->value;
                }
            }
        }

        return $return;
    }



    public static function getBasketProductMetaData($basketId){

        $return = [];

        $basket = CustomerBasket::find($basketId);

        if($basket && $basket->product && $basket->meta_data != '' && count($metaData = explode(':', $basket->meta_data)) > 0){

            $colorr = explode('_', $metaData[0]);
            $size = isset($metaData[1]) ? explode('_', $metaData[1]) : '';
            $colorSlug = str_slug($colorr[1]);

            $return['color'] = $colorr[1];

            if(isset($size[1])){

                if($size[1] == 'Extra Small') $return['size'] = 'XS';
                elseif($size[1] == 'Small') $return['size'] = 'S';
                elseif($size[1] == 'Medium') $return['size'] = 'M';
                elseif($size[1] == 'Large') $return['size'] = 'L';
                elseif($size[1] == 'Extra Large') $return['size'] = 'XL';
                elseif($size[1] == 'Double Extra Large') $return['size'] = '2XL';
            }else{

                $return['size'] = '';
            }
        }

        return $return;
    }



    public static function getUserProductThumbnail($productId, $basketId = null){

        $return = asset('img/url-thumb-profile.jpg');
        $userProduct = UserProduct::find($productId);
        $commonMethods = new CommonMethods();

        if( $userProduct ){

            if($basketId == null){

                if( $userProduct->thumbnail != '' ){

                    $return = $userProduct->type == 'personal' ? asset('user-product-thumbnails/'.$userProduct->thumbnail) : asset('prints/uf_'.$userProduct->user->id.'/designs/'.$userProduct->thumbnail);
                }
            }else{

                $basket = CustomerBasket::find($basketId);

                if($basket){

                    $metaData = $commonMethods->getBasketProductMetaData($basket->id);
                    foreach($userProduct->design['colors'] as $color){

                        if($color['name'] == $metaData['color']){
                            $return = asset('prints/uf_'.$userProduct->user->id.'/designs/'.$color['image']);
                            break;
                        }
                    }
                }
            }
        }

        return $return;
    }

    public static function getUserProductLeftThumbnail($productId){

        $return = asset('img/url-thumb-profile.jpg');
        $userProduct = UserProduct::find($productId);

        if( $userProduct ){

            if( $userProduct->thumbnail_left != '' ){

                $return = $userProduct->type == 'personal' ? asset('user-product-thumbnails/'.$userProduct->thumbnail_left) : asset('prints/uf_'.$userProduct->user->id.'/designs/resized/'.$userProduct->thumbnail_left);
            }
        }

        return $return;
    }

    public static function getUserProductDesign($productId){

        $return = asset('img/url-thumb-profile.jpg');
        $userProduct = UserProduct::find($productId);

        if( $userProduct ){

            if( $userProduct->design != NULL && isset($userProduct->design['design_id']) ){

                $design = UserProductDesign::where(['id' => $userProduct->design['design_id']])->first();
                $return = $userProduct->design['design_type'] == '1' ? 'black/'.$design->grey_file_name : $design->file_name;
                $return = asset('prints/uf_'.$userProduct->user->id.'/templates').'/'.$return;
            }
        }

        return $return;
    }







    public function deleteBasketItem(Request $request){

        $basket = CustomerBasket::find($request->id);
        if($basket){

            $basket->delete();
        }

        return json_encode(['success' => 1, 'error' => '']);
    }











    // top search bar ajax controller



    public function postUserSearchResults( Request $request )







    {







        $keyword = $request->get('keyword');







        $users = [];















        if( $keyword )







        {







            $users = User::with( 'profile','address' )->where( 'name', 'LIKE', '%'.$keyword.'%' )->limit( 10 )->get();







        }















        foreach($users as $user)







        {







            $addr = $user->address->first();







            $prof = $user->profile;







            $user->city = '';







            $user->job = 'other';







            if( $addr && $addr->city )







            {







                $user->city = $addr->city->name;







            }







            if( $prof->job )







            {







                $user->job = $prof->job->name;







            }







        }







        $data = [







            'users'   => $users,







            'keyword' => $keyword







        ];



        return view( 'parts.user-search', $data );







    }







    public static function isBasketItem($itemType, $itemId){



        $customerBasket = self::getCustomerBasket();



        foreach ($customerBasket as $basket){



            if($itemType == "music" && $basket->music_id == $itemId){



                return true;



            } else if($itemType == "product" && $basket->product_id == $itemId) {



                return true;



            }



        }



        return false;



    }







    public static function compress($source, $destination, $quality) {







        $info = getimagesize($source);







        if ($info['mime'] == 'image/jpeg')



            $image = imagecreatefromjpeg($source);







        elseif ($info['mime'] == 'image/gif')



            $image = imagecreatefromgif($source);







        elseif ($info['mime'] == 'image/png')



            $image = imagecreatefrompng($source);







        imagejpeg($image, $destination, $quality);







        return $destination;



    }



    public function timeElapsedString( $datetime, $level = 7 ) {

        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'min',
            's' => 'sec',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        $string = array_slice($string, 0, $level);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function custom_http_build_query($params) {
        $query_params = array();
        foreach ($params as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            $query_params[] = urlencode($key) . '=' . urlencode($value);
        }
        return implode('&', $query_params);
    }

    public function createDatabaseBackup($host,$user,$pass,$name,$tables,$except){

        $return = '';
        $tables = $tables == '' ? '*' : $tables;
        $link = mysqli_connect($host,$user,$pass,$name);

        //get all of the tables
        if($tables == '*')
        {
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while($row = mysqli_fetch_row($result))
            {
                if(is_array($except) && in_array($row[0], $except)){
                    continue;
                }
                $tables[] = $row[0];
            }
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }
        //cycle through
        foreach($tables as $table)
        {
            $result = mysqli_query($link, 'SELECT * FROM '.$table);
            $num_fields = mysqli_num_fields($result);

            $return.= 'DROP TABLE `'.$table.'`;';
            $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";

            for ($i = 0; $i < $num_fields; $i++)
            {
                while($row = mysqli_fetch_row($result))
                {
                    $return.= "INSERT INTO `".$table."` VALUES(";
                    for($j=0; $j < $num_fields; $j++)
                    {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = preg_replace("#\n#","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= "'".$row[$j]."'" ; } else { $return.= "'"; }
                        if ($j < ($num_fields-1)) { $return.= ','; }
                    }
                    $return.= ");\n";
                }
            }
            $return.="\n\n\n";
        }

        return $return;
    }

    public function stripeCall($url, $headers, $fields, $method = 'POST'){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        if($method == 'POST'){
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        }else if($method == 'DELETE'){
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        $return = json_decode(trim($output), TRUE);

        return $return;
    }

    public function wrapPaymentIntent($intentId, $headers, $type, $checkoutId){

        $url = 'https://api.stripe.com/v1/payment_intents/'.$intentId;
        $fields = [];
        $paymentIntent = $this->stripeCall($url, $headers, $fields, 'GET');
        if(isset($paymentIntent['id'])){

            $metaData = $paymentIntent['metadata'];
            $metaData['checkoutType'] = $type;
            $metaData['checkoutID'] = $checkoutId;

            $url = 'https://api.stripe.com/v1/payment_intents/'.$intentId;
            $fields = [
                'metadata' => $metaData
            ];
            $this->stripeCall($url, $headers, $fields);
        }
    }

}



