<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SingingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CommonMethods;
use App\Http\Controllers\IndustryContactController;
use App\Http\Controllers\AgentContactController;
use App\Http\Controllers\BispokeLicenseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\TvController;
use App\Http\Controllers\GoogleDriveStorage;
use App\Http\Controllers\ProfferProjectController;
use App\Http\Controllers\ProfferProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\AlfieController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ManagementPlanController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TestController;

$domainSubscribers = App\Models\CustomDomainSubscription::where('status', 1)->get();
foreach ($domainSubscribers as $key => $domainSubscriber) {

    Route::domain($domainSubscriber->domain_url)->group(function () use ($domainSubscriber) {

        if($domainSubscriber->domain_url == 'www.singingexperience.co.uk'){

            Route::get('personalized-checkout', [ProjectController::class, 'personalizedCheckout'])->name('personalized.checkout');
            Route::get('Parties/1/kids-popstar-party', [SingingController::class, 'reinstateAction'])->name('parties.kids.pop.star.party');
            Route::get('Parties/11/Hen-Party', [SingingController::class, 'reinstateAction'])->name('parties.hen.party');
            Route::get('stag-parties-manchester', [SingingController::class, 'reinstateAction'])->name('stag.parties.manchester');
            Route::get('Parties/15/Corporate-Party', [SingingController::class, 'reinstateAction'])->name('parties.corporate.party');
            Route::get('music-studio-manchester', [SingingController::class, 'reinstateAction'])->name('music.studio.manchester');
            Route::get('studios-near-me', [SingingController::class, 'reinstateAction'])->name('studios.near.me');
            Route::get('manchester-singing-studio', [SingingController::class, 'reinstateAction'])->name('manchester.singing.studio');
            Route::get('studio-recording-near-me', [SingingController::class, 'reinstateAction'])->name('studio.recording.near.me');
            Route::get('songwriter/25/Live-Lounge-1', [SingingController::class, 'reinstateAction'])->name('song.writing.full.day');
            Route::get('songwriters-Manchester', [SingingController::class, 'reinstateAction'])->name('song.writing.half.day');
            Route::get('cover-shoots', [SingingController::class, 'reinstateAction'])->name('cover.shoots');
            Route::get('video-shoots/33/PopStar-Party-Video', [SingingController::class, 'reinstateAction'])->name('videos.pop.star.party.video');
            Route::get('video-shoots/30/music-video', [SingingController::class, 'reinstateAction'])->name('videos.music.video');
            Route::get('videos', [SingingController::class, 'reinstateAction'])->name('videos.general');
            Route::get('Band-studio-recording', [SingingController::class, 'reinstateAction'])->name('bands.general');
            Route::get('bands/21/Discovery', [SingingController::class, 'reinstateAction'])->name('bands.discovery');
            Route::get('bands', [SingingController::class, 'reinstateAction'])->name('bands.mini');
            Route::get('special/37/Gifts-for-Musicians', [SingingController::class, 'reinstateAction'])->name('musicians.gifts.for.musicians');
            Route::get('musicians/16/Guitarists', [SingingController::class, 'reinstateAction'])->name('musicians.guitarists');
            Route::get('recording-studio-manchester/9/Unplugged', [SingingController::class, 'reinstateAction'])->name('recording.studio.unplugged');
            Route::get('recording-studio-manchester/89/Junior-VIP', [SingingController::class, 'reinstateAction'])->name('recording.studio.junior.vip');
            Route::get('recording-studio-near-me', [SingingController::class, 'reinstateAction'])->name('recording.studio.near.me');
            Route::get('recording-studio-manchester/4/diamond-plus', [SingingController::class, 'reinstateAction'])->name('recording.studio.diamond.package');
            Route::get('recording-studio-manchester/3/music', [SingingController::class, 'reinstateAction'])->name('recording.studio.silver.package');
            Route::get('recording-studio-manchester', [SingingController::class, 'reinstateAction'])->name('recording.general');
            Route::get('singer', [SingingController::class, 'reinstateAction'])->name('singers.general');
            Route::get('musicians', [SingingController::class, 'reinstateAction'])->name('musicians.general');
            Route::get('cover-shoots/72/Family-Shoot', [SingingController::class, 'reinstateAction'])->name('cover.shoots.family');
            Route::get('parties', [SingingController::class, 'reinstateAction'])->name('parties.general');
            Route::get('special/36/Kids-Popstar-Party-Ideas-singing-studios', [SingingController::class, 'reinstateAction'])->name('parties.kids.popstar.party-ideas');
            Route::get('faq', [SingingController::class, 'faq'])->name('se.faq');
        }

        Route::get('/', function(){

            return App::call('App\Http\Controllers\ProfileController@userDashboard', ['userParams' => 'customDomain']);
        })->name('custom.domain.home');
    });
}

Route::get('item/{itemType}/{itemId}/{itemSlug}', [ChartController::class, 'itemShareOld'])->name('item.share.old');
Route::get('product/{itemSlug}', [ChartController::class, 'itemShare'])->name('item.share.product');
Route::get('track/{itemSlug}', [ChartController::class, 'itemShare'])->name('item.share.track');
Route::post('update-user-chat-switch', [ProfileController::class, 'updateUserChatSwitch'])->name('update.user.chat.switch');
Route::post('user-home-default-tab', [ProfileController::class, 'userHomeDefaultTab'])->name('user.home.default.tab');
Route::post('user-home-feature-tab', [ProfileController::class, 'userHomeFeatureTab'])->name('user.home.feature.tab');
Route::post('user-home-hideshow-tab', [ProfileController::class, 'userHomeTabHideShow'])->name('user.home.hideshow.tab');
Route::post('postCustomerBasket', [ChartController::class, 'postCustomerBasket'])->name('post.customer.basket');
Route::get('convert-currency', [CommonMethods::class, 'currencyConverter'])->name('convert-currency');
Route::post('informationFinder', [ChartController::class, 'informationFinder'])->name('information.finder');
Route::post('loadMyRequestData', [ChartController::class, 'loadMyRequestData'])->name('load.data');
Route::post('undoCustomerBasket', [ChartController::class, 'undoCustomerBasket'])->name('undo.customer.basket');
Route::post('deleteBasketItem', [CommonMethods::class, 'deleteBasketItem'])->name('deleteBasketItem');
Route::post('solvePriceDisparity', [ProfileController::class, 'solvePriceDisparity'])->name('solve.price.disparity');
Route::get('get-spotify-content', [ProfileController::class, 'getUserSpotifyIframe'])->name('get-user-social-spotify');
Route::get('get-twitter-content/{username}', [ProfileController::class, 'getUserTwitterContent'])->name('user.twitter.content');
Route::post('toggle-favourite-music', [ProfileController::class, 'toggleFavouriteMusic'])->name('toggle.favourite.music');
Route::post('toggle-favourite-product', [ProfileController::class, 'toggleFavouriteProduct'])->name('toggle.favourite.product');
Route::post('toggle-favourite-stream', [ProfileController::class, 'toggleFavouriteStream'])->name('toggle.favourite.stream');
Route::post('toggle-ind-con-fav', [IndustryContactController::class, 'togglefavourite'])->name('toggle.favourite.contact');
Route::get('video-share/{videoId}/{userName}/{url}', [ChartController::class, 'videoShare'])->name('vid.share');
Route::get('url-share/{url}/{userName}/{imageName}', [ChartController::class, 'urlShare'])->name('url.share');
Route::get('item/redirect/{type}/{id}', [ChartController::class, 'itemRedirect'])->name('item.redirect');
Route::post('user-follow-login', [ProfileController::class, 'userFollowLogin'])->name('user.follow.login');
Route::post('user-follow', [ProfileController::class, 'userFollow'])->name('user.follow');
Route::get('switch-account/{code}', [AgentContactController::class, 'switchAccount'])->name('agent.contact.switch.account');
Route::get('agent-contact/details/{code}', [AgentContactController::class, 'showDetails'])->name('agent.contact.details');
Route::post('agent-contact/save-details/{code}/{action}', [AgentContactController::class, 'saveDetails'])->name('agent.contact.details.save');
Route::post('agent-contact/question/delete', [AgentContactController::class, 'deleteQuestion'])->name('agent.contact.delete.question');
Route::post('agent/manage-questionnaire', [AgentContactController::class, 'manageQuestionnaire'])->name('agent.manage.questionnaire');
Route::post('agent/get-questionnaire', [AgentContactController::class, 'getQuestionnaire'])->name('agent.get.questionnaire');
Route::post('agent/monies', [AgencyController::class, 'getMoniesData'])->name('agent.get.monies');
Route::post('agent-contact-request/send', [AgentContactController::class, 'sendRequestToAgent'])->name('agent.contact.send.request');
Route::post('agent-contact-request/delete', [AgentContactController::class, 'deleteRequestToAgent'])->name('agent.contact.delete.request');

Route::prefix('agent-contact')->group(function(){

    Route::post('create', [AgentContactController::class, 'create'])->name('agent.contact.create');
    Route::get('approve-agreement/{id}/{agentId}', [AgentContactController::class, 'approveAgreement'])->name('agent.contact.approve.agreement');
    Route::post('verify-contact-response', [AgentContactController::class, 'verifyContactResponse'])->name('agent.contact.verify.response');
    Route::get('signup/{id}/{agentId}', [AgentContactController::class, 'signup'])->name('agent.contact.signup');
    Route::post('update', [AgentContactController::class, 'update'])->name('agent.contact.update');
    Route::post('add-remove-to-group', [AgentContactController::class, 'addRemoveContactToGroupChat'])->name('agent.contact.add.remove.group');
    Route::post('deleteYourNetworkContact', [AgentContactController::class, 'delete'])->name('delete.agent.network.contact');
});

Route::post('prepare-payment', [ProjectController::class, 'preparePayment'])->name('prepare.payment');
Route::post('post-payment', [ProjectController::class, 'postPayment'])->name('post.payment');
Route::post('process-reminder-login', [ProfileController::class, 'processReminderLogin'])->name('process.reminder.login');

Route::prefix('bispoke-license')->group(function(){

    Route::prefix('message')->group(function(){

        Route::post('list', [BispokeLicenseController::class, 'messages'])->name('bispoke.license.message.list');
        Route::post('send', [BispokeLicenseController::class, 'sendMessage'])->name('bispoke.license.send.message');
    });

    Route::prefix('agreement')->group(function(){

        Route::post('add', [BispokeLicenseController::class, 'addAgreement'])->name('bispoke.license.add.agreement');
        Route::post('response', [BispokeLicenseController::class, 'agreementResponse'])->name('bispoke.license.agreement.response');
    });

});

Route::prefix('paypal')->group(function(){

    Route::get('onboard-redirect', [PayPalController::class, 'onboardRedirect'])->name('paypal.onboard.redirect');
    Route::post('prepare-order', [PayPalController::class, 'prepareCheckout'])->name('paypal.prepare.order');
    Route::get('post-order', [PayPalController::class, 'postCheckout'])->name('paypal.post.order');
    Route::get('post-order-cancel', [PayPalController::class, 'cancelOrder'])->name('paypal.post.order.cancel');
    Route::any('subscribe/{id}', [PayPalController::class, 'prepareSubscription'])->name('paypal.subscribe');
    Route::get('post-subscription', [PayPalController::class, 'postSubscription'])->name('paypal.post.subscription');
    Route::get('post-subscription-cancel', [PayPalController::class, 'cancelOrder'])->name('paypal.post.subscription.cancel');

    Route::get('order-read/{orderId}', [PayPalController::class, 'readOrder'])->name('paypal.order.read');
    Route::get('subscription-read/{subscriptionId}', [PayPalController::class, 'readSubscription'])->name('paypal.subscription.read');
    Route::get('plan-read/{planId}', [PayPalController::class, 'readPlan'])->name('paypal.plan.read');
    Route::get('product-read/{productId}', [PayPalController::class, 'readProduct'])->name('paypal.product.read');
    Route::get('access-token', [PayPalController::class, 'getAccessToken'])->name('paypal.access.token');
});

Route::get('logout', [LoginController::class, 'logout']);
Auth::routes();

Route::prefix('chat')->group(function(){

    Route::post('sendMessage', [ChartController::class, 'sendChatMessage'])->name('send.chat.message');
    Route::get('admin', [ProfileController::class, 'adminChat'])->name('admin.chat');
    Route::post('admin/join', [ProfileController::class, 'chatJoinAdmin'])->name('chat.join.admin');
    Route::post('admin/sendMessage', [ProfileController::class, 'chatAdminSendMessage'])->name('chat.admin.send.message');
});

Route::prefix('email')->group(function(){

    Route::get('expert-request-sent', function () {
        return new App\Mail\ExpertRequest('sent', App\Models\User::all()->first());
    });
    Route::get('expert-request-approved', function () {
        return new App\Mail\ExpertRequest('approved', App\Models\User::all()->first());
    });
    Route::get('expert-request-rejected', function () {
        return new App\Mail\ExpertRequest('rejected', App\Models\User::all()->first());
    });
    Route::get('project-reached-goal', function () {
        return new App\Mail\ProjectUpdate('reachedGoal', App\Models\User::all()->first(), App\Models\UserCampaign::all()->first());
    });
    Route::get('project-nearly-ending', function () {
        return new App\Mail\ProjectUpdate('nearlyEnding', App\Models\User::all()->first(), App\Models\UserCampaign::all()->first());
    });
    Route::get('project-nearly-over', function () {
        return new App\Mail\ProjectUpdate('nearlyOver', App\Models\User::all()->first(), App\Models\UserCampaign::all()->first());
    });
    Route::get('project-over-and-unsuccessful', function () {
        return new App\Mail\ProjectUpdate('overUnsuccessful', App\Models\User::all()->first(), App\Models\UserCampaign::all()->first());
    });
    Route::get('project-over-and-successful', function () {
        return new App\Mail\ProjectUpdate('overSuccessful', App\Models\User::all()->first(), App\Models\UserCampaign::all()->first());
    });
    Route::get('instant-checkout-seller', function () {
        return new App\Mail\InstantCheckout('seller', App\Models\StripeCheckout::find(340));
    });
    Route::get('instant-checkout-buyer', function () {
        return new App\Mail\InstantCheckout('buyer', App\Models\StripeCheckout::all()->first());
    });
    Route::get('reset-password', function () {
        return new App\Mail\ResetPassword(App\Models\User::all()->first(), '123456789');
    });
    Route::get('user-inactive', function () {
        return new App\Mail\User('inactive', App\Models\User::all()->first());
    });
    Route::get('chart-winner', function () {
        return new App\Mail\Chart('winner', App\Models\User::all()->first());
    });
    Route::get('chart-finished', function () {
        return new App\Mail\Chart('finished', App\Models\User::all()->first(), '1');
    });
    Route::get('chart-listed', function () {
        return new App\Mail\Chart('listed', App\Models\User::all()->first());
    });
    Route::get('user-crowdfunder-inactive', function () {
        return new App\Mail\User('crowdfunderInactive', App\Models\User::all()->first());
    });
    Route::get('user-no-crowdfunder-month', function () {
        return new App\Mail\User('noCrowdfunderMonth', App\Models\User::all()->first());
    });
    Route::get('user-email-verified', function () {
        return new App\Mail\User('emailVerified', App\Models\User::all()->first());
    });
    Route::get('user-no-crowdfunder-week', function () {
        return new App\Mail\User('noCrowdfunderWeek', App\Models\User::all()->first());
    });
    Route::get('user-email-verification', function () {
        return new App\Mail\User('emailVerification', App\Models\User::all()->first());
    });
    Route::get('user-initiate-vet', function () {
        return new App\Mail\User('initiateVetting', App\Models\User::all()->first());
    });
    Route::get('user-registration-request', function () {
        return new App\Mail\User('registrationRequest', App\Models\User::all()->first());
    });
    Route::get('user-crowdfund-checkout-buyer', function () {
        return new App\Mail\CrowdfundCheckout('buyer', App\Models\StripeCheckout::all()->first());
    });
    Route::get('user-crowdfund-checkout-seller', function () {
        return new App\Mail\CrowdfundCheckout('seller', App\Models\StripeCheckout::all()->first());
    });
    Route::get('user-crowdfunder-live', function () {
        return new App\Mail\ProjectUpdate('isLive', App\Models\User::all()->first(), App\Models\UserCampaign::all()->first());
    });
    Route::get('thank-you', function () {
        return new App\Mail\ThankYou(App\Models\User::all()->first(), App\Models\User::all()->first(), 'Message Goes Here');
    });
    Route::get('bespoke-license-offer', function () {
        return new App\Mail\License('bespokeOffer', App\Models\User::all()->first(), App\Models\User::all()->first(), App\Models\UserChat::all()->first());
    });
    Route::get('bespoke-license-agreement', function () {
        return new App\Mail\License('bespokeAgreement', App\Models\User::all()->first(), App\Models\User::all()->first(), App\Models\UserChat::find(132));
    });
    Route::get('password-reset-security-token', function () {
        return new App\Mail\SecurePasswordChange(App\Models\User::find(1));
    });
    Route::get('discount-voucher', function () {
        return new App\Mail\Voucher(App\Models\Voucher::all()->first());
    });
    Route::get('agent-contact/create', function () {
        return new App\Mail\AgentContact(App\Models\User::all()->first(), App\Models\AgentContact::all()->first(), [], 'create');
    });
    Route::get('agent-contact/questionnaire', function () {
        return new App\Mail\AgentContact(App\Models\User::all()->first(), App\Models\AgentContact::all()->first(), [], 'questionnaire');
    });
    Route::get('agent-contact/approved/agent', function () {
        return new App\Mail\AgentContact(App\Models\User::all()->first(), App\Models\AgentContact::all()->last(), [''], 'approved-for-agent');
    });
    Route::get('agent-contact/approved/contact', function () {
        return new App\Mail\AgentContact(App\Models\User::all()->first(), App\Models\AgentContact::all()->first(), [''], 'approved-for-contact');
    });
    Route::get('agent-contact/updated', function () {
        return new App\Mail\AgentContact(App\Models\User::all()->first(), App\Models\AgentContact::all()->first(), ['name' => 'Ahsan Hanif', 'email' => 'ahsanhanif99@gmail.com', 'password' => '123456', 'commission' => '20%', 'terms' => 'Terms will go here'], 'update');
    });
    Route::get('agent-contact-request/sent', function () {
        return new App\Mail\AgentContactRequest(App\Models\User::all()->first(), App\Models\User::all()->first());
    });
    Route::get('agent-contact/agent-form-updated', function () {
        return new App\Mail\AgentContact(App\Models\User::all()->first(), App\Models\AgentContact::all()->first(), ['sender' => 'Ahsan Hanif', 'recipient' => 'David Stuart'], 'agent-form-updated');
    });
    Route::get('user-license-verification', function () {
        return new App\Mail\User('licenseVerification', App\Models\User::all()->first());
    });
    Route::get('instant-checkout-admin', function () {
        return new App\Mail\InstantCheckout('admin', App\Models\StripeCheckout::all()->first());
    });
    Route::get('cancel-subscription-subscriber', function () {
        return new App\Mail\CancelSubscription(App\Models\StripeSubscription::all()->first(), 'subscriber');
    });
    Route::get('cancel-subscription-artist', function () {
        return new App\Mail\CancelSubscription(App\Models\StripeSubscription::all()->first(), 'artist');
    });
    Route::get('calendar/participant-added', function () {
        return new App\Mail\CalendarMail(App\Models\CalendarEventParticipant::all()->first());
    });
});

Route::domain(Config::get('constants.primaryDomain'))->group(function () {

    Route::post('cancelSubscription', [ProfileController::class, 'cancelSubscription'])->name('cancel.subscription');

    Route::post('cancel-user-plan', [ProfileController::class, 'cancelUserPlan'])->name('cancel.user.plan');

    Route::prefix('live-stream')->group(function(){

        Route::post('post', [ProfileController::class, 'postLiveStream'])->name('user.live.stream.create');
        Route::post('delete', [ProfileController::class, 'deleteLiveStream'])->name('user.live.stream.delete');
    });

    Route::prefix('stripe')->group(function(){

        Route::post('webhook', [ProfileController::class, 'stripeWebhook'])->name('stripe.webhook');
    });

    Route::post('instant-payment', [ProfileController::class, 'instantPayment'])->name('instant.payment');
    Route::post('change-password-secure', [ProfileController::class, 'changePasswordSecure'])->name('change.password.secure');
    Route::get('restricted', [ProfileController::class, 'restricted'])->name('restricted');
    Route::post('update-user-notifications', [UserNotificationController::class, 'updateNotifications'])->name('update.user.notifications');
    Route::post('create-user-notification', [UserNotificationController::class, 'create'])->name('creat.user.notification');
    Route::get('pci-policy', [ChartController::class, 'pciPolicy'])->name('policy.policy');
    Route::post('deleteUserNews', [ProfileController::class, 'deleteUserNews'])->name('user.news.delete');
    Route::post('album/delete', [ProfileController::class, 'deleteUserAlbum'])->name('user.album.delete');
    Route::post('postCrowdfundBasket', [ProjectController::class, 'postCrowdfundBasket'])->name('post.crowdfund.basket');
    Route::post('get-tv-streams', [TvController::class, 'getTvStreams'])->name('tv.streams');
    Route::post('updateMusicData', [ProfileController::class, 'updateMusicData'])->name('update.music.data');
    Route::post('updateUserEmailPassword', [ProfileController::class, 'updateUserEmailPassword'])->name('update.email.password');
    Route::get('user-story-text/{id}', [ProjectController::class, 'userStoryText'])->name('user.story.text');
    Route::get('master-user', [ChartController::class, 'masterUser'])->name('master.user');
    Route::post('master-user', [ChartController::class, 'masterUser'])->name('post.master.user');
    Route::post('prepare-zip', [ProfileController::class, 'prepareZip'])->name('prepare.zip');
    Route::get('download-zip/{dir}/{fileName}/{downloadAs}', [ProfileController::class, 'downloadZip'])->name('download.zip');
    Route::get('save-user-story-text/{id}', [ProjectController::class, 'saveUserStoryText'])->name('save.user.story.text');
    Route::post('removeUserInstagramApp', [ProfileController::class, 'removeUserSocialInstagram'])->name('user.instagram.remove');
    Route::post('saveUserDomain', [ProfileController::class, 'saveUserDomain'])->name('save.user.domain');
    Route::post('processInternalSubscription', [ProfileController::class, 'processInternalSubscription'])->name('process.internal.subscription');
    Route::post('saveUserMedia', [ProfileController::class, 'saveUserMedia'])->name('save.user.media');
    Route::post('saveUserHomeLayout', [ProfileController::class, 'saveUserHomeLayout'])->name('save.user.home.layout');
    Route::post('saveUserHomeLogo', [ProfileController::class, 'saveUserHomeLogo'])->name('save.user.home.logo');
    Route::post('saveUserPortfolio', [ProfileController::class, 'saveUserPortfolio'])->name('save.user.portfolio');
    Route::post('deleteUserPortfolio', [ProfileController::class, 'deleteUserPortfolio'])->name('user.news.portfolio');

    Route::prefix('profile-setup')->group(function(){

        Route::get('simple', [ProfileSetupController::class, 'index'])->name('profile.simple.setup');
        Route::post('simple', [ProfileSetupController::class, 'index'])->name('profile.simple.setup');
        Route::get('/', [ProfileSetupController::class, 'fullWizard'])->name('profile.setup');
        Route::get('next/{page}', [ProfileSetupController::class, 'forceNext'])->name('profile.setup.with.next');
        Route::post('save-next', [ProfileSetupController::class, 'saveNext'])->name('profile.setup.save.next');
        Route::any('standalone/{page}/{content?}', [ProfileSetupController::class, 'fullWizard'])->name('profile.setup.standalone');
        Route::any('{page}', [ProfileSetupController::class, 'fullWizard'])->name('profile.setup');
    });

    Route::group( [ 'middleware' => [ 'web' ] ], function () {

        Route::prefix('google-cloud')->group(function(){

            Route::prefix('file')->group(function(){

                //Route::get('list', [GoogleDriveStorage::class, 'listFiles'])->name('gd.list.all.files');
                Route::post('upload-as-stream', [GoogleDriveStorage::class, 'uploadFileAsStream'])->name('gd.upload.file.stream');
                Route::get('download-as-stream/{filePath}/{musicId}', [GoogleDriveStorage::class, 'downloadFileAsStream'])->name('gd.download.file.stream');
            });
        });

        Route::prefix('proffer-project')->group(function(){

            Route::post('add', [ProfferProjectController::class, 'create'])->name('proffer.project.add');
            Route::post('response', [ProfferProjectController::class, 'projectResponse'])->name('proffer.project.response');
            Route::get('download-pdf/{filename}/{title}', [ProfferProjectController::class, 'downloadPDF'])->name('proffer.project.download.pdf');
        });

        Route::prefix('proffer-product')->group(function(){

            Route::post('add', [ProfferProductController::class, 'create'])->name('proffer.product.add');
            Route::post('response', [ProfferProductController::class, 'productResponse'])->name('proffer.product.response');
            Route::get('download-pdf/{filename}/{title}', [ProfferProductController::class, 'downloadPDF'])->name('proffer.product.download.pdf');
        });

        Route::post('deleteUserService', [ProfileController::class, 'deleteUserService'])->name('delete.user.service');
        Route::get('search', [SearchController::class, 'index'])->name('search');
        Route::post('search', [SearchController::class, 'index'])->name('search');
        Route::get('chart/{videoId?}', [ChartController::class, 'index'])->name('chart');
        Route::get('me/{page}', [ProfileController::class, 'loadMyPage'])->name('load.my.page');
        Route::get('chart/autoshare/{type}', [ChartController::class, 'autoShare'])->name('chart.auto.share');
        Route::get('tv/{videoId?}', [TvController::class, 'index'])->name('tv');
        Route::get('tv', [TvController::class, 'autoShare'])->name('tv');
        Route::get('live/{videoId?}', [LiveController::class, 'index'])->name('live-with-video');
        Route::get('live', [LiveController::class, 'autoShare'])->name('live');
        Route::get('alfie', [AlfieController::class, 'index'])->name('alfie');
        Route::get('project/preview/{username}', [ProjectController::class, 'preview'])->name('user.project.preview');
        Route::get('project/{username}/{loadCampaign?}', [ProjectController::class, 'index'])->name('user.project');
        Route::get('project/autoshare/{username}/{type}', [ProjectController::class, 'autoShare'])->name('user.project.auto.share');
        Route::get('checkout/{userId}', [ProjectController::class, 'checkout'])->name('user.checkout');
        Route::get('checkout/merge/{customerId}', [ProjectController::class, 'checkoutMerge'])->name('user.checkout.merge');
        Route::post('contribute/{campaignId}', [ProjectController::class, 'contributeUser'])->name('user.contribute');
        Route::post('contributeCheckout', [ProjectController::class, 'contributeCheckout'])->name('user.contributecheckout');
        Route::post('prepare-instant-payment', [ProfileController::class, 'prepareInstantPayment'])->name('prepare.instant.payment');
        Route::post('post-instant-payment', [ProfileController::class, 'postInstantPayment'])->name('post.instant.payment');
        Route::post('retry-post-payment', [ProjectController::class, 'retryPostPayment'])->name('retry.post.payment');
        Route::post('prepare-fake-basket', [ProjectController::class, 'prepareFakeBasket'])->name('prepare.fake.basket');
        Route::get('/', [HomeController::class, 'newHome'])->name('site.home');
        Route::get('home-new', [HomeController::class, 'newHome'])->name('site.home.new');
        Route::post('getTVStreamDetails', [TvController::class, 'getStreamDetails'])->name('tv.stream.details');
        Route::post('saveUserSubscribers', [ProfileController::class, 'saveUserSubscribers'])->name('save.user.subscribers');
        Route::post('getUserCompleteInfo', [ChartController::class, 'getUserCompleteInfo'])->name('user-complete-info');
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('dashboard', [AgencyController::class, 'index'])->name('agency.dashboard');
        Route::get('delete-account', [AgencyController::class, 'deleteAccount'])->name('agency.delete.account');
        Route::get('restore-account/{id}', [AgencyController::class, 'restoreAccount'])->name('agency.restore.account');
        Route::get('dashboard/info/{info}', [AgencyController::class, 'dashboardWithInfo'])->name('agency.dashboard.info');
        Route::get('dashboard/{tab}', [AgencyController::class, 'dashboardWithTab'])->name('agency.dashboard.tab');
        Route::post('dashboard/set-session/{tab}', [AgencyController::class, 'setSession'])->name('agency.dashboard.set.session');
        Route::get('test/send-whatsapp-message', [TestController::class, 'sendWhatsappMessage'])->name('test.send.whatsapp.message');
        Route::get('dashboard/add-contract/preview/{id}', [AgencyController::class, 'addContractFormPreview'])->name('agency.contract.preview');
        Route::get('dashboard/add-contract/{id}/{contact}', [AgencyController::class, 'addContractForm'])->name('agency.contract.add.form');
        Route::get('dashboard/edit-contract/{id}', [AgencyController::class, 'editContractForm'])->name('agency.contract.edit.form');
        Route::get('dashboard/view-contract/{id}', [AgencyController::class, 'viewContractForm'])->name('agency.contract.view.form');
        Route::post('dashboard/create-contract/{id}/{contact}', [AgencyController::class, 'createContract'])->name('agency.contract.create');
        Route::post('dashboard/update-contract/{id}', [AgencyController::class, 'updateContract'])->name('agency.contract.update');
        Route::post('dashboard/approve-contract/{id}', [AgencyController::class, 'approveContract'])->name('agency.contract.approve');
        Route::post('management-plan/submit', [ManagementPlanController::class, 'submit'])->name('management.plan.submit');
        Route::post('dashboard/calendar/create', [CalendarController::class, 'create'])->name('calendar.event.create');
        Route::post('dashboard/calendar/update', [CalendarController::class, 'update'])->name('calendar.event.update');
        Route::post('dashboard/calendar/delete', [CalendarController::class, 'delete'])->name('calendar.event.delete');
        Route::post('dashboard/calendar/read', [CalendarController::class, 'read'])->name('calendar.event.read');
        Route::get('profile/{tab}/{subtab?}', [ProfileController::class, 'profileWithTab'])->name('profile.with.tab');
        Route::post('dashboard/chat', [AgencyController::class, 'userChat'])->name('agency.chat');
        Route::post('dashboard/create-message', [AgencyController::class, 'createMessage'])->name('agency.create.message');
        Route::get('profile/access/{tab}/{info}', [ProfileController::class, 'profileWithTabInfo'])->name('profile.with.tab.info');
        Route::get('startup-wizard/{action?}', [ProfileController::class, 'startupWizard'])->name('user.startup.wizard');
        Route::get('action-required/{type}', [ProfileController::class, 'userActionRequired'])->name('user.action.required');
        Route::post('postUserCompetitionVideo', [ProfileController::class, 'postUserCompetitionVideo'])->name('post-user-competition-video');
        Route::post('saveUserService', [ProfileController::class, 'postUserService'])->name('save.user.service');
        Route::post('getUserChatDetails', [ProfileController::class, 'getUserChatDetails'])->name('get.user.chat.details');
        Route::post('deleteUserCompetitionVideo', [ProfileController::class, 'deleteUserCompetitionVideo'])->name('delete-user-competition-video');
        Route::post('update-seller-settings', [ProfileController::class, 'updateSellerSettings'])->name('update.seller.settings');
        Route::post('payment-failed-notification', [ProjectController::class, 'paymentFailedNotification'])->name('payment.failed.notification');
        Route::get('payment-failed-retry/{id}', [ProjectController::class, 'paymentFailedRetry'])->name('payment.failed.retry');
        Route::get('saveUserProfile', [ProfileController::class, 'getStoryText'])->name('user.get.story_text');
        Route::post('saveUserProfile', [ProfileController::class, 'saveUserProfile'])->name('save.user.profile');
        Route::post('check-voucher-code', [ProfileController::class, 'checkVoucherCode'])->name('check.voucher.code');
        Route::post('saveUserProfileSeo', [ProfileController::class, 'saveUserProfileSeo'])->name('save.user.profile.seo');
        Route::post('saveYourProduct', [ProfileController::class, 'postYourProduct'])->name('save.user.profile_prod_gigs');
        Route::post('sort-items', [ProfileController::class, 'sortItems'])->name('sort.items');
        Route::post('saveYourMusic', [ProfileController::class, 'postYourMusic'])->name('save.user.profile_musics');
        Route::post('saveProductDesign', [ProfileController::class, 'saveProductDesign'])->name('save.user.product.design');
        Route::post('saveYourNews', [ProfileController::class, 'postYourNews'])->name('save.user.profile_news');
        Route::post('album/save', [ProfileController::class, 'postYourAlbum'])->name('user.album.save');
        Route::post('updateYourMusic', [ProfileController::class, 'updateYourMusic'])->name('update.user.profile_musics');
        Route::post('removeMusicTrack', [ProfileController::class, 'removeMusicTrack'])->name('remove.user.music.track');
        Route::post('updateYourProduct', [ProfileController::class, 'updateYourProduct'])->name('update.user.profile_prod_gigs');
        Route::post('deleteYourProduct', [ProfileController::class, 'deleteYourProduct'])->name('delete.user.profile_prod_gigs');
        Route::post('deleteYourMusic', [ProfileController::class, 'deleteYourMusic'])->name('delete.user.profile_musics');
        Route::post('starMyProduct', [ProfileController::class, 'starMyProduct'])->name('star.user.product');
        Route::post('userNewsFeature', [ProfileController::class, 'userNewsFeature'])->name('star.user.news');
        Route::post('album/feature', [ProfileController::class, 'userAlbumFeature'])->name('star.user.album');
        Route::post('starMyMusic', [ProfileController::class, 'starMyMusic'])->name('star.user.music');
        Route::post('addEditToAlbum', [ProfileController::class, 'addEditToAlbum'])->name('add.edit.album');
        Route::post('deleteAlbum', [ProfileController::class, 'deleteAlbum'])->name('add.delete.album');
        Route::post('albumsList', [ProfileController::class, 'albumsList'])->name('list.album');
        Route::get('downLoadMusicFile/{filePath}/{musicId}', [ProfileController::class, 'downLoadMusicFile'])->name('download.music.file');
        Route::get('downLoadProductFile/{name}/{directory}/{title}', [ProfileController::class, 'downLoadProductFile'])->name('download.product.file');
        Route::get('crowdfund', [ProjectController::class, 'crowdfund'])->name('user.crowdfund');
        Route::get('story-text-url', [ProfileController::class, 'getStoryText'])->name('story-text-url');
        Route::post('uploadProfileStoryImages', [ProfileController::class, 'uploadProfileStoryImages'])->name('uploadProfileStoryImages');
        Route::post('removeStoryImage', [ProfileController::class, 'removeStoryImage'])->name('remove.story.image');
        Route::post('connect-user-social-spotify', [ProfileController::class, 'connectUserSocialSpotify'])->name('connect-user-social-spotify');
        Route::post('connect-user-social-twitter', [ProfileController::class, 'connectUserSocialTwitter'])->name('connect-user-social-twitter');
        Route::post('connect-user-social-youtube', [ProfileController::class, 'connectUserSocialYoutube'])->name('connect-user-social-youtube');
        Route::post('connect-user-social-facebook', [ProfileController::class, 'connectUserSocialFacebook'])->name('connect-user-social-facebook');
        Route::post('disconnect-user-social-instagram', [ProfileController::class, 'disconnectUserSocialInstagram'])->name('disconnect-user-social-instagram');
        Route::get('connect-instagram-confirmed', [ProfileController::class, 'connectUserSocialInstagram'])->name('connect-user-social-instagram');
        Route::get('delete-instagram-confirmed', [ProfileController::class, 'deleteUserSocialInstagram'])->name('delete-user-social-instagram');
        Route::post('disconnect-user-social-spotify', [ProfileController::class, 'disconnectUserSocialSpotify'])->name('disconnect-user-social-spotify');
        Route::post('sendThanksEmail', [ProfileController::class, 'sendThanksEmail'])->name('sendThanksEmail');
        Route::get('postGMDet', [ProfileController::class, 'postGMDet'])->name('postGMDet');
        Route::get('updateUserThankStatus', [ProfileController::class, 'updateUserThankStatus'])->name('updateUserThankStatus');
        Route::post('searchCountries', [ProfileController::class, 'searchCountries'])->name('profile-country-dropdown');
        Route::post('searchCities', [ProfileController::class, 'searchCities'])->name('profile-city-dropdown');
        Route::post('searchFurtherSkills', [ProfileController::class, 'searchFurtherSkills'])->name('profile-skills-dropdown');
        Route::post('searchInstruments', [ProfileController::class, 'searchInstruments'])->name('profile-instruments-dropdown');
        Route::post('searchSkills', [ProfileController::class, 'searchSkills'])->name('profile.search.skills');
        Route::post('searchServices', [ProfileController::class, 'searchServices'])->name('profile.services.dropdown');
        Route::post('searchMoods', [ProfileController::class, 'searchMoods'])->name('profile-moods-dropdown');
        Route::post('saveUserProject', [ProfileController::class, 'saveUserProject'])->name('save.user.project');
        Route::post('addEditBonus', [ProfileController::class, 'addEditBonus'])->name('add.edit.bonus');
        Route::post('deleteYourBonus', [ProfileController::class, 'deleteYourBonus'])->name('delete.user.bonus');
        Route::post('postUserProjectVideo', [ProfileController::class, 'postUserProjectVideo'])->name('post.user.project.video');
        Route::post('postUserBioVideo', [ProfileController::class, 'postUserBioVideo'])->name('post.user.bio.video');
        Route::get('admin', [ProfileController::class, 'admin'])->name('admin');
        Route::post('change-password', [ProfileController::class, 'changePassword'])->name('change.user.password');
        Route::get('forget-password', [ForgotPasswordController::class, 'forgetPasswordEmail'])->name('forget.password.email');
        Route::get('reset/{token}', [ForgotPasswordController::class, 'getReset'])->name('reset.password.email');
        Route::get('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');
        Route::post('register-user', [RegisterController::class, 'registerUser'])->name('register.user');
        Route::post('verify-token', [RegisterController::class, 'verifyToken'])->name('verify.token');
        Route::get('activate-user/{token}', [RegisterController::class, 'getActivate'])->name('activate.user');
        Route::get('user-search', [CommonMethods::class, 'postUserSearchResults'])->name('user.search.results');
        Route::get('profile/{userId}/{videoId?}', [ChartController::class, 'getProfile'])->name('get.profile');
        Route::get('stripe_oauth_redirect', [ProfileController::class, 'stripeOauthRedirect'])->name('stripe_oauth_redirect');
        Route::get('terms-and-conditions', [HomeController::class, 'termsConditions'])->name('tc');
        Route::get('bespoke-license-terms', [HomeController::class, 'bespokeLicenseTerms'])->name('bespoke.license.terms');
        Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');
        Route::get('agency-terms', [HomeController::class, 'agencyTerms'])->name('agency.terms');
        Route::get('disclaimer', [HomeController::class, 'disclaimer'])->name('disclaimer');
        Route::get('cookies-policy', [HomeController::class, 'cookiesPolicy'])->name('cookies.policy');
        Route::get('faq', [HomeController::class, 'faq'])->name('faq');
        Route::get('setPwd', [ProfileController::class, 'setPwd'])->name('setPwd');
        Route::get('sendCronjobEmails', [ProjectController::class, 'sendCronjobEmails'])->name('send.cronjob.emails');
        Route::get('runDailyCronjob', [ProjectController::class, 'cronjobDaily'])->name('run.daily.cron');
        Route::get('cronjob/stripe', [ProjectController::class, 'stripeScheduledOperations'])->name('run.stripe.cron');
        Route::get('inactivateProject', [ProfileController::class, 'inactivateProject'])->name('inactivateProject');
        Route::get('updateFirsttimeLogin', [ProfileController::class, 'updateFirsttimeLogin'])->name('updateFirsttimeLogin');
        Route::get('activateStudioAccount', [ProfileController::class, 'activateStudioAccount'])->name('activate-studio-account');
        Route::any('test/{params}', [ProfileController::class, 'userDashboardTest'])->name('user.home.test');
        Route::post('search-social-directory', [ProfileController::class, 'searchSocialDirectoryForMusic'])->name('search.social.directory');
        Route::post('save-user-smart-links', [ProfileController::class, 'saveUserSmartLinks'])->name('save.user.smart.links');
        Route::post('save-user-music-privacy', [ProfileController::class, 'saveUserMusicPrivacy'])->name('save.user.music.privacy');
        Route::post('unlock-user-private-music', [ChartController::class, 'unlockUserPrivateMusic'])->name('unlock.user.private.music');

        Route::prefix('push-notification')->group(function(){

            Route::post('register', [PushNotificationController::class, 'register'])->name('push.notif.create');
            Route::get('user/{redirectUrl}/{userId}', [PushNotificationController::class, 'user'])->name('push.notif.user');
        });
    });

	Route::get('product-list', [HomeController::class, 'productList']);
	Route::get('product-details/{id}', [HomeController::class, 'productDetails']);

    //Route::get('login/facebook', [LoginController::class, 'redirectToProvider']);
    Route::post('login/facebook/callback', [ 'uses' => 'HomeController@handleFacebookJsLogin', 'as' => 'handle.fb.js.login' ]);
    Route::get('login/contribute_facebook', [LoginController::class, 'redirectToProviderContributeFb']);
    Route::get('login/checkout_facebook', [LoginController::class, 'redirectToProviderCheckoutFb']);
    Route::get('login/twitter', [LoginController::class, 'redirectToProviderTwitter']);
    Route::get('login/twitter/callback', [LoginController::class, 'handleProviderCallbackTwitter']);
    Route::get('login/google', [LoginController::class, 'redirectToProviderGoogle']);
    Route::get('login/google/callback', [LoginController::class, 'handleProviderCallbackGoogle']);
    Route::get('connect/instagram', [ProfileController::class, 'connectInstagram']);
    Route::get('login/instagram', [LoginController::class, 'redirectToProviderInstagram']);

    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('user-home', [HomeController::class, 'userHome'])->name('my.user.home');
    Route::get('socialite-login/{type}/{action}', [LoginController::class, 'loginWithAction'])->name('socialite.login.with.action');
    Route::any('{params}', [ProfileController::class, 'userDashboard'])->name('user.home');
    Route::get('preview/{logo}/{layout}/{params}', [ProfileController::class, 'userDashboardPreview'])->name('user.home.preview');
    Route::get('{params}/{tab}', [ProfileController::class, 'userDashboardWithTab'])->name('user.home.tab');
});
