<?php



namespace App;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonMethods;
use App\Http\Controllers\ProfileController;
use File;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

use App\Models\UserCampaign;
use App\Models\UserLiveStream;
use App\Models\User;
use App\Models\UserChatGroup;


/**

 * Class User

 * @package App

 */

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable

{

    use Notifiable;

    protected $dates = [ 'last_login' ];

    /**

     * The database table used by the model.

     * @var string

     */

    protected $table = 'users';



    /**

     * The attributes that are mass assignable.

     * @var array

     */

    protected $fillable = [ 'name', 'email', 'password', 'active', 'suspend','subscription_id' ];



    /**

     * The attributes excluded from the model's JSON form.

     * @var array

     */

    protected $hidden = [ 'password', 'remember_token' ];



    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasMany

     */

    public function address()

    {

        return $this->hasOne( Address::class );

    }


    public function internalSubscription()

    {

        return $this->hasOne( InternalSubscription::class );

    }

    public function region()
    {

        return $this->hasOne( Region::class );

    }

    public function expert()
    {

        return $this->hasOne( Expert::class );

    }

    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasMany

     */


    public function namePartOne(){

        $return = '';
        $explode = explode(' ', trim($this->name));
        $return = $explode[0];

        return $return;
    }


    public function vouchers()

    {

        return $this->hasMany( Voucher::class );

    }


    public function services()

    {

        return $this->hasMany( UserService::class );

    }


    public function canWatchLiveStream($streamId)
    {   
        $success = 0;
        $stream = UserLiveStream::find($streamId);
        if($stream && $stream->user){
            $user = $stream->user;

            if(($stream->more_viewers == 'all_subs_fans_follow' || $stream->more_viewers == 'all_fans') && count($user->checkouts)){

                foreach($user->checkouts as $checkout){

                    if($checkout->type == 'crowdfund' || $checkout->type == 'instant'){

                        if($checkout->customer && $checkout->customer->id == $this->id && $checkout->user && $checkout->user->id == $user->id){

                            $success = 1;
                        }   
                    }
                }
            }

            if(($stream->more_viewers == 'all_subs_fans_follow' || $stream->more_viewers == 'all_subs') && count($user->stripe_subscriptions) && !$success){

                foreach($user->stripe_subscriptions as $subscription){

                    if($subscription->customer && $subscription->customer->id == $this->id){

                        $success = 1;
                    }   
                }
            }

            if(($stream->more_viewers == 'all_subs_fans_follow' || $stream->more_viewers == 'all_follow') && count($user->followers) && !$success){

                foreach($user->followers as $follow){

                    if($follow->followerUser && $follow->followerUser->id == $this->id){

                        $success = 1;
                    } 
                }
            }

            if(!$success){

                foreach($user->checkouts as $checkout){

                    if($checkout->type == 'instant' && $checkout->customer && $checkout->customer->id == $this->id){

                        if(count($checkout->instantCheckoutItems)){

                            foreach ($checkout->instantCheckoutItems as $instantItem) {
                                
                                if($stream->product && $instantItem->type == 'product'){

                                    if($stream->product == 'all' || ($stream->productt && $stream->productt->id == $instantItem->source_table_id)){

                                        $success = 1;
                                    }
                                }
                                if($stream->music && $instantItem->type == 'music'){

                                    if($stream->music == 'all' || ($stream->musicc && $stream->musicc->id == $instantItem->source_table_id)){

                                        $success = 1;
                                    }
                                }
                            }
                        }  
                    }
                }
            }
        }

        return $success;
    }

    public function newNotifications()
    {
        $return = null;

        $newNotifs = UserNotification::where(['user_id' => $this->id])->whereNull('seen')->get();
        if(count($newNotifs)){

            $return = $newNotifs;
        }

        return $return;
    }

    public function activityStatus()
    {
        if($this->last_activity){

            $lastSec = strtotime(date('Y-m-d H:i:s')) - 60;
            if($lastSec <= strtotime($this->last_activity)){
                $status = 'online';
            }else{
                $status = 'inactive';
            }
        }else{
            $status = 'offline';
        }

        return $status;
    }

    public function isSearchable()
    {

        $return = 0;

        if($this->profile->is_searchable == 1 && $this->active == 1 && $this->private == NULL){

            $return = 1;
        }
        return $return;
    }

    public function hasActivePaidSubscription()
    {

        $return = 0;

        if($this->internalSubscription && $this->internalSubscription->stripe_customer_id && $this->internalSubscription->stripe_subscription_id && $this->internalSubscription->subscription_status == 1){

            $return = 1;
        }
        return $return;
    }

    public function hasActiveFreeSubscription()
    {

        $return = 0;

        if($this->internalSubscription && $this->internalSubscription->subscription_status == 1 && strpos($this->internalSubscription->subscription_package, 'silver') !== false){

            $return = 1;
        }
        return $return;
    }

    public function setEncourageBulletsAttribute($value)
    {
        $this->attributes['encourage_bullets'] = serialize($value);
    }

    public function getEncourageBulletsAttribute($value)
    {
        return unserialize($value);
    }


    public function setHiddenTabsHomeAttribute($value)
    {
        $this->attributes['hidden_tabs_home'] = serialize($value);
    }

    public function getHiddenTabsHomeAttribute($value)
    {
        return $value ? array_filter(unserialize($value)) : [];
    }



    /**

     * @return mixed

     */

    public function mainAddress()

    {

        return $this->address()->first();

    }


    public function isBuyerOf($type, $id)

    {

        if($type == 'music'){

            $music = UserMusic::find($id);
            if($music){

                $checkoutItem = InstantCheckoutItem::where(['type' => 'music', 'source_table_id' => $id])->get();
                if(count($checkoutItem)){

                    foreach ($checkoutItem as $key => $item) {
                        if($item->stripeCheckout && $item->stripeCheckout->customer && $item->stripeCheckout->customer->id == $this->id){
                            return true;
                        }
                    }
                }
            }
        }

        if($type == 'album'){

            $album = UserAlbum::find($id);
            if($album){

                $checkoutItem = InstantCheckoutItem::where(['type' => 'album', 'source_table_id' => $id])->get();
                if(count($checkoutItem)){

                    foreach ($checkoutItem as $key => $item) {
                        if($item->stripeCheckout && $item->stripeCheckout->stripe_charge_id != NULL && $item->stripeCheckout->customer && $item->stripeCheckout->customer->id == $this->id){
                            return true;
                        }
                    }
                }
            }
        }

        return false;

    }


    public function news()
    {
        return $this->hasMany( UserNews::class )->orderBy('id', 'desc');
    }


    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasMany

     */

    public function social()

    {

        return $this->hasMany( SocialLogin::class );

    }

    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasOne

     */

    public function customDomainSubscription()

    {

        return $this->hasOne(CustomDomainSubscription::class );

    }

    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasOne

     */

    public function personalDomain()

    {

        return $this->hasOne(PersonalDomain::class );

    }



    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasOne

     */

    public function profile()

    {

        return $this->hasOne(Profile::class);

    }


    public function followers()

    {

        return $this->hasMany( 'App\Models\UserFollow', 'followee_user_id' )->orderBy('id', 'desc');

    }


    public function followings()

    {

        return $this->hasMany( 'App\Models\UserFollow', 'follower_user_id' )->orderBy('id', 'desc');

    }



    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasMany

     */

    public function settings()

    {

        return $this->hasMany( UserSettings::class );

    }



    /**

     * @param Builder $query

     * @param int     $val Active or inactive 1 or 0

     *

     * @return Builder

     */

    public function scopeActive( $query, $val = 1 )

    {

        return $query->where( 'active', '=', $val );

    }



    /**

     * @param Builder $query

     * @param int     $val Suspended or not 1 or 0

     *

     * @return Builder

     */

    public function scopeSuspended( $query, $val = 1 )

    {

        return $query->where( 'suspend', '=', $val );

    }



    /**

     * @param Builder $query

     * @param int     $val string username or email

     *

     * @return Builder

     */

    public function scopeAuthName( $query, $val )

    {

        return $query->where( 'name', '=', $val )->orWhere( 'email', '=', $val );

    }



    /**

     * @param string $key

     */

    public function getSettingsFor($key)

    {

        return $this->settings()->key($key)->first();

    }

    public function isFollowerOf(User $user)
    {

        $match = 0;
        foreach ($user->followers as $followerUser) {
            if($this->id == $followerUser->follower_user_id){
                $match = 1;
                break;
            }
        }

        return $match;
    }

    /**

     * @param string $key

     */

    public function getSettingValueFor( $key)

    {

        $split = AtlxHelper::stringToParams($key);



        $setting = $this->getSettingsFor( $split->section );

        if( $setting)

        {

            $val = json_decode( $setting->value );



            return $split->key ? $val->{$split->key} : $val;

        }



        return null;

    }



    /**

     * @param $key

     */

    public function saveSetting($key, $payload)

    {

        $split = AtlxHelper::stringToParams( $key );



        $setting = $this->getSettingsFor( $split->section );

        $val = null;

        if( !$setting )

        {

            $setting = new UserSettings();

            $setting->key = $split->section;

            $setting->value = '';



            if($split->key)

            {

                $val = new \stdClass();

                $val->{$split->key} = $payload;

            }

            else

            {

                $val = $payload;

            }



            $setting->value = json_encode($val);

            $this->settings()->save($setting);

            return;

        }

        else

        {

            $val = json_decode( $setting->value );

        }



        if($split->key)

        {

            if(!is_object($val))

            {

                $v = new \stdClass();

                $v->old = $val;

                $val = $v;

            }

            $val->{$split->key} = $payload;

        }

        else

        {

            $val = $payload;

        }

        $setting->value = json_encode( $val );

        $setting->save();

    }



    public function delete()

    {

        if( isset( $this->address ) )

        {

            $this->address()->delete();

        }



        if( isset( $this->settings ) )

        {

            $this->settings()->delete();

        }



        if( isset( $this->social ) )

        {

            $this->social()->delete();

        }



        if( isset( $this->profile ) )

        {

            $this->profile->delete();

        }



        //$this->groups()->detach();

        //$this->permissions()->detach();



        return parent::delete();

    }

    public function chatGroups()
    {
        $return = [];
        $chatGroups = UserChatGroup::where('agent_id', $this->id)->orWhere('contact_id', $this->id)->orWhere('other_agent_id', $this->id)->get();
        if(count($chatGroups)){

            foreach ($chatGroups as $chatGroup) {
                $return[] = $chatGroup->id;
            }
        }
        $chatGroups = UserChatGroup::where('other_members', 'like', '%'.$this->id.'%')->get();
        if(count($chatGroups)){

            foreach ($chatGroups as $chatGroup) {
                if(is_array($chatGroup->other_members) && in_array($this->id, $chatGroup->other_members)){
                    $return[] = $chatGroup->id;
                }
            }
        }
        if(count($return)){
            $latestMessage = UserChat::whereIn('group_id', $return)->orderBy('id', 'desc')->first();
            if($latestMessage){
                $firstGroupValue = $latestMessage->group->id;
                $firstGroupKey = array_search($firstGroupValue, $return);
            }else{
                $firstGroupValue = $return[0];
                $firstGroupKey = 0;
            }
            $currentFirstGroupValue = $return[0];
            foreach($return as $key => $value){
                if($key == 0){
                    $valuee = $firstGroupValue;
                }else if($key == $firstGroupKey){
                    $valuee = $currentFirstGroupValue;
                }else{
                    $valuee = $value;
                }
                $return[$key] = $valuee;
            }
        }

        return $return;
    }


    public function isGroupMateOf($user){

    	$return = 0;
    	$chatGroups = UserChatGroup::where('contact_id', $user->id)->get();
    	if(count($chatGroups)){
    		foreach ($chatGroups as $chatGroup) {
    			if(is_array($chatGroup->other_members) && in_array($this->id, $chatGroup->other_members)){
    				$return = $chatGroup;
    			}
    		}
    	}
    	$chatGroups = UserChatGroup::where('contact_id', $this->id)->get();
    	if($return == 0 && count($chatGroups)){
    		foreach ($chatGroups as $chatGroup) {
    			if(is_array($chatGroup->other_members) && in_array($user->id, $chatGroup->other_members)){
    				$return = $chatGroup;
    			}
    		}
    	}

    	return $return;
    }



    /**

     * @return bool

     */

    public function hasProfileFilled()

    {

        $status = 1;
        $commonMethods = new CommonMethods();

        $details = $commonMethods->getUserRealDetails($this->id);

        if($details['name'] == '' || $details['genre'] == '' || $details['skills'] == '' || $details['level'] == '' || $details['furtherSkillsString'] == '' || $details['email'] == '' || $details['postcode'] == '' || $details['city'] == '' || $details['country'] == '' || $details['accountType'] == '' || $this->profile->profile_display_image == ''){

            $status = 0;
        }

        if(trim(strip_tags($details['storyText'])) == '' || trim(strip_tags($details['storyImages'])) == ''){

            $status = 0;
        }

        if(strpos($details['accountType'], 'Yes') !== false){

            if(!$this->accountType || $this->accountType->studio_name == ''){
                $status = 0;
            }
            if($this->studio){
                if($this->studio->studio_website == '' || $this->studio->studio_name == '' || $this->studio->studio_phone == '' || $this->studio->hear_about == ''){
                    $status = 0;
                }
            }else{

                $status = 0;
            }
        }else{
            if($details['address'] == ''){
                $status = 0;
            }
        }

        return $status;

    }

    public function hasMusicalFilled()

    {

        $status = 1;
        $commonMethods = new CommonMethods();

        $details = $commonMethods->getUserRealDetails($this->id);

        if($details['skills'] == '' || $details['level'] == ''){

            $status = 0;
        }

        return $status;

    }

    public function hasBioFilled()

    {

        $status = 1;
        $commonMethods = new CommonMethods();

        $details = $commonMethods->getUserRealDetails($this->id);

        if(trim(strip_tags($details['storyText'])) == '' || trim(strip_tags($details['storyImages'])) == '' || $details['bioVideoUrl'] == ''){

            $status = 0;
        }

        return $status;

    }

    public function hasSocialEmpty(){

        $status = 0;

        if($this->profile->social_facebook == '' && $this->profile->social_twitter == '' && $this->profile->social_instagram_user_id == '' && $this->profile->social_youtube == '' && $this->profile->social_spotify_user_access_token == ''){
            $status = 1;
        }
        return $status;
    }


    public function hasCustomMediaAuthorized(){

        $status = 0;
        if($this->hasProfileFilled() && count($this->uploads) >= 3 && count($this->musics) >= 3 && count($this->products) >= 3 && !$this->hasSocialEmpty()){

            $status = 1;
        }

        return $status;
    }


    public function hasAdvancedAccount()

    {

        $status = 0;
        
        if($this->hasMusicalFilled() || $this->hasBioFilled() || !$this->hasSocialEmpty()){

            $status = 1;
        }

        return $status;

    }


    /**

     * @return string

     */

    public function getPhotoFile( )

    {

        $photofile = 'profilephotos/user-'.$this->id.'-pp.';



        if( File::exists( public_path( $photofile ).'png' ) )

        {

            return asset( $photofile ).'png';

        }

        elseif( File::exists( public_path( $photofile ).'jpg' ) )

        {

            return asset( $photofile ).'jpg';

        }



        return asset( 'img/profile_img.png' );

    }



    /**

     * @return \stdClass

     */

    public function getDetails()

    {

        $address = $this->mainAddress();



        $data           = new \stdClass();

        $data->userid   = $this->id;

        $data->username = $this->name;

        //$data->city     = $address->city?$address->city->name:'';

        $data->website  = $this->profile->website;

        $data->connected_twitter_account  = $this->profile->social_twitter;

        $data->connected_instagram_user_id  = $this->profile->social_instagram_user_id;

        $data->connected_instagram_user_access_token  = $this->profile->social_instagram_user_access_token;

        $data->connected_spotify_user_access_token  = $this->profile->social_spotify_user_access_token;

        $data->job      = $this->profile->job?$this->profile->job->name:'';

        //$data->photo    = $this->getPhotoFile();
        $data->photo = CommonMethods::getUserDisplayImage($this->id);

        return $data;

    }

    public function campaign()
    {

        $return = 0;

        foreach ($this->campaigns as $campaign) {
            
            if($campaign->status == 'active'){
                $return = $campaign;
                break;
            }
        }

        return $return;
    }

    public function city()
    {

        return $this->belongsTo('App\City');

    }

    public function country()
    {

        return $this->belongsTo('App\Country');

    }


    public function campaigns()

    {

        // return $this->hasMany( userCampaign::class );
        return $this->hasMany( userCampaign::class );

    }

    public function agencyCheckouts()
    {

        return $this->hasMany(StripeCheckout::class, 'agent_id', 'id' )->orderBy('id', 'desc');

    }

    public function contributeDetail()

    {

        return $this->hasMany( ContributeDetail::class );

    }

    public function musics()

    {

        return $this->hasMany( UserMusic::class )->orderBy('order', 'asc');

    }

    public function uploads()

    {

        return $this->hasMany( UserUpload::class )->orderBy('id', 'desc');

    }

    public function albums()

    {

        return $this->hasMany( UserAlbum::class )->orderBy('id', 'asc');

    }

    public function notifications()

    {

        return $this->hasMany( UserNotification::class )->orderBy('id', 'desc');

    }

    public function portfolios()

    {

        return $this->hasMany( UserPortfolio::class )->orderBy('order', 'asc');

    }

    public function products()

    {

        return $this->hasMany( UserProduct::class )->orderBy('order', 'asc');

    }

    public function liveStreams()

    {

        return $this->hasMany( UserLiveStream::class )->orderBy('id', 'desc');

    }

    public function checkouts()

    {

        return $this->hasMany( StripeCheckout::class )->orderBy('id', 'desc');

    }


    public function stripe_subscriptions()

    {

        return $this->hasMany( StripeSubscription::class )->orderBy('id', 'desc');

    }


    public function stripe_perks()

    {

        return $this->hasMany( StripePerk::class )->orderBy('id', 'desc');

    }

    public function accountType()

    {

        return $this->hasOne( AccountType::class );

    }

    public function studio()

    {

        return $this->hasOne( Studio::class );

    }

    public function contacts()
    {

        return $this->hasMany( AgentContact::class, 'agent_id' );

    }

    public function contactRequests()
    {

        return $this->hasMany( AgentContactRequest::class, 'agent_user_id' );

    }

    public function questionnaires()
    {

        return $this->hasMany( AgentQuestionnaire::class, 'agent_id' );

    }



    public function setFavouriteMusicsAttribute($value)
    {
        $this->attributes['favourite_musics'] = serialize($value);
    }
    public function getFavouriteMusicsAttribute($value)
    {
        return unserialize($value);
    }

    public function setFavouriteIndustryContactsAttribute($value)
    {
        $this->attributes['favourite_industry_contacts'] = serialize($value);
    }
    public function getFavouriteIndustryContactsAttribute($value)
    {
        return unserialize($value);
    }

    public function firstName(){

        $return = '';
        $explode = explode(' ', $this->name);
        $return = $explode[0];

        return $return;
    }

    public function recommendedUsername(){

        if($this->email != ''){

            $explode = explode('@', $this->email);
            $return = $explode[0];

            $duplication = User::where('id', '!=' , $this->id)->where('username', $return)->first();
            if($duplication){
                $return = $return.rand(100,999);
            }
            $duplication = User::where('id', '!=' , $this->id)->where('username', $return)->first();
            if($duplication){
                $return = $return.rand(100,999);
            }
        }else{

            $return = str_replace(' ', '', $this->name);
            
            $duplication = User::where('id', '!=' , $this->id)->where('username', $return)->first();
            if($duplication){
                $return = $return.rand(100,999);
            }
            $duplication = User::where('id', '!=' , $this->id)->where('username', $return)->first();
            if($duplication){
                $return = $return.rand(100,999);
            }
        }

        return $return;
    }

    public function internalSubscriptionDetails()
    {

        $return = ['name' => '', 'price' => 0, 'period' => '', 'status' => 0];

        if($this->internalSubscription){

            $sub = $this->internalSubscription;
            $explode = explode('_', $sub->subscription_package);
            $return['name'] = $explode[0];
            $return['price'] = $explode[1];
            $return['period'] = $explode[2];
            $return['status'] = $sub->subscription_status;
        }

        return $return;
    }

    public function refreshMusics()
    {

        $commonMethods = new CommonMethods();
        $profileController = new ProfileController();

        if(count($this->musics)){

            $musics = $this->musics;
            foreach ($musics as $key => $music) {
                
                $delete = 0;
                if($music->music_file == ''){
                    $delete = 1;
                }else if(is_array($music->downloads) && count($music->downloads)){
                    foreach ($music->downloads as $key2 => $musicItem){
                        
                        if($musicItem['itemtype'] == 'main'){
                            $dir = '';
                        }else if(strpos($musicItem['itemtype'], 'loop_')){
                            $dir = 'loops/';
                        }else if(strpos($musicItem['itemtype'], 'stem_')){
                            $dir = 'stems/';
                        }
                        $file = public_path('user-music-files/'.$dir.$musicItem['dec_fname']);
                        if($commonMethods->fileExists($file) && filesize($file) <= 0) {
                            $delete = 1;
                            break;
                        }
                    }
                }
                if($delete){
                    $request = new Request(['id' => $music->id, 'easy_delete' => '1' ]);
                    $profileController->deleteYourMusic($request);
                }
            }
        }
    }

    public function googleDriveFolder($cloudStorage){

        $folderName = '';
        $folders = $cloudStorage->listFolders();
        foreach ($folders as $folder) {
            if($folder['name'] == $this->username){
                $folderName = $folder['name'];
            }
        }
        if($folderName == ''){
            $folderResponse = $cloudStorage->createFolder($this->username);
            if($folderResponse){
                $folderName = $this->username;
            }
        }

        return $folderName;
    }

    public function networkAgent(){

        $return = false;

        $agentContact = AgentContact::where(['contact_id' => $this->id])->first();
        if($agentContact){

            $return = $agentContact->agentUser;
        }

        return $return;
    }

    public function isCotyso(){

        if(in_array($this->id, Config('constants.cotysoAccounts'))){

            return true;
        }

        return false;
    }

    public function personalGroup(){

        $return = false;

        $agentContact = AgentContact::where(['contact_id' => $this->id, 'approved' => 1])->first();
        if($agentContact && $agentContact->agentUser){
            $userPersonalGroup = \App\Models\UserChatGroup::where(['contact_id' => $this->id, 'agent_id' => $agentContact->agentUser->id])->whereNull('other_agent_id')->first();
            if($userPersonalGroup && count($userPersonalGroup->otherMembers) == 0){
                $return = $userPersonalGroup;
            }
        }

        return $return;
    }
}

