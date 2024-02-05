<?php



namespace App\Http\Controllers;


use App\Models\CrowdfundBasket;

use App\Models\CustomerBasket;

use App\Models\CampaignPerks as CampaignPerk;

use App\Models\EmbedCode;

use App\Models\UserCampaign as UserCampaign;

use App\Models\InternalSubscription;

use App\Models\Profile;

use App\Http\Controllers\UserNotificationController;

use App\Models\UserAlbum;

use Carbon\Carbon;

use App\Models\UserMusic;

use App\Models\UserProduct;

use App\Models\StripeCheckout;

use App\Models\StripeSubscription;

use App\Models\AgentQuestionnaire;

use App\Models\AgentQuestionnaireElement;

use App\Models\AgentContactRequest;

use App\Mail\AgentContactRequest as AgentContactR;

use App\Models\UserPortfolio;

use App\Models\PortfolioElement;

use App\Models\ContactQuestion;

use App\Models\ContactQuestionElement;

use App\Models\City;

use App\Models\Country;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Auth\AuthController;

use Illuminate\Http\Request;

use App\Models\Competition;

use App\Models\CompetitionVideo;

use App\Models\VideoStream;

use App\Http\Controllers\CommonMethods;

use App\Models\UserChat;

use App\Mail\License;

use App\Mail\Agent;

use App\Models\Address;


use Image;

use DB;

use PDF;

use Auth;

use Mail;

use Hash;

use App\Models\User;

use Session;

use App\Models\AgentContact;

use App\Models\UserChatGroup;

use App\Mail\AgentContact as AgentContactMailer;


class AgentContactController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity');
    }


    public function index(Request $request){


    }

    public function create(Request $request){

        $commonMethods = new CommonMethods();
        $user = Auth::User();
        $error = '';
        $success = '';

        $name = $request->get('pro_contact_name');
        $lastName = $request->get('pro_contact_last_name');
        $skill = $request->get('pro_contact_skill');
        $phone = $request->get('pro_contact_phone');
        $commission = $request->get('pro_contact_commission');
        $terms = $request->get('pro_contact_terms');
        $isAlreadyUser = $request->get('pro_contact_already_user');
        $alreadyUserEmail = $request->get('pro_contact_already_user_email');

        if($isAlreadyUser == '1'){

            $contactUser = User::where(['email' => $alreadyUserEmail, 'active' => 1])->first();
            if(!$contactUser){
                return redirect()->back()->with(['error' => 'The user email is not an email of a valid account at 1Platform']);
            }

            $contactExist = AgentContact::where(function($q) use ($user) {
                $q->where('contact_id', $user->id)->orWhere('agent_id', $user->id);
            })->where('email', $isAlreadyUser)->get()->first();

            if($contactExist){
                return redirect()->back()->with(['error' => 'This person is already in your contact list']);
            }
        }else{

            $contactUser = new User();
            $contactUser->name = trim($name.' '.$lastName);
            $contactUser->first_name = $name;
            $contactUser->surname = $lastName;
            $contactUser->skills = $skill;
            $contactUser->contact_number = $phone;
            $contactUser->email = NULL;
            $contactUser->password = NULL;
            $contactUser->subscription_id = 0;
            $contactUser->active          = 1;
            $contactUser->api_token  = str_random(60);
            $contactUser->save();

            $address             = new Address();
            $address->alias      = 'main address';
            $address->user_id = $contactUser->id;
            $address->save();

            $profile = new Profile();
            $profile->birth_date = Carbon::now();
            $profile->user_id = $contactUser->id;
            $profile->save();

            $userInternalSubscription = new InternalSubscription();
            $userInternalSubscription->user_id = $contactUser->id;
            $userInternalSubscription->subscription_package = 'silver_0_0';
            $userInternalSubscription->subscription_status = 1;
            $userInternalSubscription->save();
        }

        $agentContact = new AgentContact();
        $agentContact->agent_id = $user->id;
        $agentContact->contact_id = $contactUser->id;
        $agentContact->name = trim($name.' '.$lastName);
        $agentContact->terms = $terms;
        $agentContact->commission = $commission;
        $agentContact->code = $agentContact->generateCode();
        $agentContact->email = $isAlreadyUser == '1' ? $alreadyUserEmail : NULL;
        $agentContact->is_already_user = $isAlreadyUser == '1' ? 1 : NULL;

        $agentContact->save();

        return Redirect::back();
    }

    public function update(Request $request){

        $user = Auth::User();
        $error = '';
        $success = '';

        $hasCommission = $request->has('pro_contact_commission');
        $hasTerms = $request->has('pro_contact_terms');
        $hasEmail = $request->has('pro_contact_email');
        $hasQuestionnaire = $request->has('pro_contact_questionnaireId');
        $hasName = $request->has('pro_contact_name');
        $hasLastName = $request->has('pro_contact_last_name');
        $hasSkill = $request->has('pro_contact_skill');
        $hasPhone = $request->has('pro_contact_phone');

        $commission = $request->get('pro_contact_commission');
        $terms = $request->get('pro_contact_terms');
        $email = $request->get('pro_contact_email');
        $questionnaireId = $request->get('pro_contact_questionnaireId');
        $contactId = $request->get('edit');
        $contact = AgentContact::where(['id' => $contactId, 'agent_id' => $user->id])->first();
        $sendEmail = $request->get('send_email');
        $name = $request->get('pro_contact_name');
        $lastName = $request->get('pro_contact_last_name');
        $skill = $request->get('pro_contact_skill');
        $phone = $request->get('pro_contact_phone');


        if($contact){

            if($email != '' && !$contact->is_already_user){

                $userExist = User::where(['email' => $email])->get()->first();
                $agentContact = AgentContact::where(['email' => $email])->get()->first();
                if($userExist || ($agentContact && $agentContact->id != $contactId)){
                    return redirect()->back()->with(['error' => 'Error: cannot duplicate email for un-registered contacts (ref: email_already_exist - '.$email.')']);
                }
            }

            if (($sendEmail == '1' || $sendEmail == '2') && ($contact->email == NULL || $contact->email == '')) {
                return redirect()->back()->with(['error' => 'Your contact information is missing email address. Please add email and try again (ref: email_empty)']);
            }

            $contactCCommission = $contact->commission;
            $contactCTerms = $contact->terms;
            $contactCEmail = $contact->email;

            if ($hasEmail) {
                $contact->email = $email;
            }
            if ($hasTerms) {
                $contact->terms = $terms;
            }
            if ($hasCommission) {
                $contact->commission = $commission;
            }
            if ($hasName || $hasLastName) {
                $contact->name = trim($name.' '.$lastName);
                $contact->contactUser->first_name = $name;
                $contact->contactUser->surname = $lastName;
                $contact->contactUser->name = $contact->name;
            }
            if ($hasPhone) {
                $contact->contactUser->contact_number = $phone;
            }
            if ($hasSkill) {
                $contact->contactUser->skills = $skill;
            }

            $contact->save();
            $contact->contactUser->save();

            if($contact->approved == 1 && (($commission != $contactCCommission && $hasCommission) || ($terms != $contactCTerms && $hasTerms))){

                $result = Mail::to($contact->email)->bcc(Config('constants.bcc_email'))->send(new AgentContactMailer($contact->agentUser, $contact, [], 'update'));
                $contact->c_commission = $commission;
                $contact->c_terms = $terms;
                $contact->review = 1;
                $contact->save();
            }else{

            }

            if($sendEmail == '1'){

                $result = Mail::to($contact->email)->bcc(Config('constants.bcc_email'))->send(new AgentContactMailer($contact->agentUser, $contact, [], 'create'));
                $contact->agreement_sign = 'sent';
                $contact->save();

                $successMessage = 'Your contact has been sent an email with approval';
            }else if($sendEmail == '2'){

                $result = Mail::to($contact->email)->bcc(Config('constants.bcc_email'))->send(new AgentContactMailer($contact->agentUser, $contact, [], 'questionnaire'));
                $contact->questionnaire_id = $questionnaireId;
                $contact->save();

                $questions = ContactQuestion::where('agent_contact_id' , $contact->id)->get();
                if(count($questions)){
                    foreach($questions as $question) {
                        $question->elements->each(function($element) {
                            $element->delete();
                        });
                        $question->delete();
                    }
                }

                $agentQuestionnaire = AgentQuestionnaire::find($questionnaireId);
                foreach($agentQuestionnaire->questions as $key => $question){

                    $contactQuestion = new ContactQuestion();
                    $contactQuestion->agent_contact_id = $contact->id;
                    $contactQuestion->value = $question->value;
                    $contactQuestion->order = $key + 1;
                    $contactQuestion->save();
                }

                $userNotification = new UserNotificationController();
                $request->request->add(['user' => $contact->contactUser->id, 'customer' => $contact->agentUser->id, 'type' => 'contact_questionnaire', 'source_id' => $contact->id]);
                $response = json_decode($userNotification->create($request), true);

                $successMessage = 'Your contact has been sent an email';
            }
        }else{

            return redirect()->back()->with('error', 'no contact found');
        }

        if (isset($successMessage)) {

            return redirect()->back()->with('success', $successMessage);
        } else {
            return redirect()->back();
        }
    }

    public function approveAgreement(Request $request, $id, $agentId){

        $contact = AgentContact::where(['id' => $id, 'agent_id' => $agentId, 'agreement_sign' => 'sent'])->whereNull('approved')->first();
        $review = AgentContact::where(['id' => $id, 'agent_id' => $agentId, 'approved' => 1, 'review' => 1])->first();
        if($contact || $review){

            $data = [

                'contact' => $contact ? $contact : $review,
                'review' => $review ? 1 : 0
            ];

            return view( 'pages.contact-approve-agreement', $data );
        }else{

            $approvedContact = AgentContact::where(['id' => $id, 'agent_id' => $agentId, 'approved' => 1])->first();
            $pendingSignup = User::where(['id' => $approvedContact->contactUser->id])->whereNull('email')->whereNull('password')->first();
            if($approvedContact && $pendingSignup){

                return redirect(route('agent.contact.signup', ['id' => $approvedContact->id, 'agentId' => $approvedContact->agentUser->id]));
            }

            return 'Bad data';
        }
    }

    public function verifyContactResponse(Request $request){

        if($request->has('id') && $request->has('data') && $request->get('data') != ''){

            $contactId = $request->get('id');
            $data = $request->get('data');

            $contact = AgentContact::where(['id' => $contactId, 'agreement_sign' => 'sent'])->whereNull('approved')->first();
            $review = AgentContact::where(['id' => $contactId, 'approved' => 1, 'review' => 1])->first();
            if($contact || $review){

                if($review){
                    $contact = $review;
                    if($contact->agreement_sign && CommonMethods::fileExists(public_path('signatures/').$contact->agreement_sign)){
                        unlink(public_path('signatures/').$contact->agreement_sign);
                    }
                }

                $extension = explode('/', mime_content_type($data))[1];
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                $fileName = rand(100000, 999999).'.'.$extension;
                file_put_contents(public_path('signatures/').$fileName, $imageData);
                $contact->agreement_sign = $fileName;
                $contact->save();

                if($review){
                    $contact->review = NULL;
                    $contact->commission = $contact->c_commission;
                    $contact->terms = $contact->c_terms;
                    $contact->c_commission = NULL;
                    $contact->c_terms = NULL;

                    if($contact->agreement_pdf && CommonMethods::fileExists(public_path('agent-agreements/').$contact->agreement_pdf)){
                        unlink(public_path('agent-agreements/').$contact->agreement_pdf);
                    }
                    $pdfName = strtoupper('aca_'.uniqid()).'.pdf';
                    $fileName = 'agent-agreements/'.$pdfName;
                    $terms = preg_replace('/\r|\n/', '</td></tr><tr><td>', $contact->terms);
                    $data = ['name' => $contact->name, 'email' => $contact->email, 'commission' => $contact->commission, 'terms' => $terms, 'agent' => $contact->agentUser, 'agreementSign' => $contact->agreement_sign];
                    PDF::loadView('pdf.agent-contact-agreement', $data)->setPaper('a4', 'portrait')->setWarnings(false)->save($fileName);
                    $contact->agreement_pdf = $pdfName;

                    $result = Mail::to($contact->agentUser->email)->bcc(Config('constants.bcc_email'))->send(new AgentContactMailer($contact->agentUser, $contact, [''], 'approved-for-agent'));
                    $userNotification = new UserNotificationController();
                    $request->request->add(['user' => $contact->agentUser->id, 'customer' => $contact->contactUser->id, 'type' => 'contact_approved_for_agent', 'source_id' => $contact->id]);
                    $response = json_decode($userNotification->create($request), true);

                    $result = Mail::to($contact->contactUser->email)->bcc(Config('constants.bcc_email'))->send(new AgentContactMailer($contact->agentUser, $contact, [''], 'approved-for-contact'));
                    $userNotification = new UserNotificationController();
                    $request->request->add(['customer' => $contact->agentUser->id, 'user' => $contact->contactUser->id, 'type' => 'contact_approved_for_contact', 'source_id' => $contact->id]);
                    $response = json_decode($userNotification->create($request), true);

                    $contact->save();

                    return redirect(route('login'));
                }

                return redirect(route('agent.contact.signup', ['id' => $contact->id, 'agentId' => $contact->agentUser->id]));
            }else{

                return 'No data';
            }
        }else{

            return 'Bad data';
        }
    }

    public function signup(Request $request, $id, $agentId){

        $contact = AgentContact::where(['id' => $id, 'agent_id' => $agentId])->first();
        if($contact){

            if($contact->approved && $contact->contactUser->email !== NULL && $contact->contactUser->password !== NULL){
                return redirect(route('site.home'));
            }

            if(!$contact->approved && ($contact->agreement_sign == 'sent' || $contact->agreement_sign == NULL)){
                return redirect(route('agent.contact.approve.agreement', ['id' => $id, 'agentId' => $agentId]));
            }

            if($contact->is_already_user){

                $alreadyUser = User::where(['email' => $contact->email, 'active' => 1])->first();
                if(!$alreadyUser){

                    return 'Error: Please contact your agent to know the details of this issue (ref: contact_email_mismatch)';
                }

                $contact->approved = 1;
                $contact->save();

                if($contact->agreement_pdf && CommonMethods::fileExists(public_path('agent-agreements/').$contact->agreement_pdf)){
                    unlink(public_path('agent-agreements/').$contact->agreement_pdf);
                }

                $pdfName = strtoupper('aca_'.uniqid()).'.pdf';
                $fileName = 'agent-agreements/'.$pdfName;
                $terms = preg_replace('/\r|\n/', '</td></tr><tr><td>', $contact->terms);
                $data = ['name' => $contact->name, 'email' => $contact->email, 'commission' => $contact->commission, 'terms' => $terms, 'agent' => $contact->agentUser, 'agreementSign' => $contact->agreement_sign];
                PDF::loadView('pdf.agent-contact-agreement', $data)->setPaper('a4', 'portrait')->setWarnings(false)->save($fileName);
                $contact->agreement_pdf = $pdfName;
                $contact->save();

                $userChatGroup = new UserChatGroup();
                $userChatGroup->agent_id = $contact->agent_id;
                $userChatGroup->contact_id = $contact->contact_id;
                $userChatGroup->save();

                $userChatGroup->mergePersonalChat();

                $result = Mail::to($contact->agentUser->email)->bcc(Config('constants.bcc_email'))->send(new AgentContactMailer($contact->agentUser, $contact, [''], 'approved-for-agent'));
                $userNotification = new UserNotificationController();
                $request->request->add(['user' => $contact->agentUser->id, 'customer' => $contact->contactUser->id, 'type' => 'contact_approved_for_agent', 'source_id' => $contact->id]);
                $response = json_decode($userNotification->create($request), true);

                $result = Mail::to($contact->contactUser->email)->bcc(Config('constants.bcc_email'))->send(new AgentContactMailer($contact->agentUser, $contact, [''], 'approved-for-contact'));
                $userNotification = new UserNotificationController();
                $request->request->add(['customer' => $contact->agentUser->id, 'user' => $contact->contactUser->id, 'type' => 'contact_approved_for_contact', 'source_id' => $contact->id]);
                $response = json_decode($userNotification->create($request), true);

                return redirect(route('login'));
            }else{

                $data = ['id' => $contact->contactUser->id, 'name' => $contact->contactUser->name, 'firstName' => '', 'lastName' => '', 'email' => $contact->email, 'contact' => $contact->contactUser->contact_number];
                Session::put('register.data', $data);
                return redirect(route('register'));
            }
        }else{

            return 'Bad data';
        }
    }

    public function addRemoveContactToGroupChat(Request $request){

        $success = 0;
        $error = 0;
        $html = '';
        $commonMethods = new CommonMethods();

        $action = $request->get('action');
        $contactId = $request->get('contact');
        $contactCode = $request->get('contactCode');
        $groupId = $request->get('group');
        $user = Auth::user();
        $group = UserChatGroup::where(['id' => $groupId, 'agent_id' => $user->id])->first();
        if($contactId == 'add_by_code'){
            $agentContact = AgentContact::where(['code' => $contactCode])->first();
            if($agentContact){

                $contact = $agentContact->contactUser;
                $group->other_agent_id = $agentContact->agentUser->id;
                $contactId = $contact->id;
            }else{
                return json_encode(['success' => 0, 'error' => 'The code is incorrect', 'html' => '']);
            }
        }else{
            $contact = User::find($contactId);
        }

        $html = \View::make('parts.group-chat-member', ['group' => $group, 'member' => $contact, 'commonMethods' => $commonMethods])->render();
        if(isset($group->other_agent_id) && $group->other_agent_id && isset($agentContact)){
            $html .= \View::make('parts.group-chat-member', ['group' => $group, 'member' => $agentContact->agentUser, 'commonMethods' => $commonMethods])->render();
        }

        if($group){

            if($action == 'add'){

                $group->other_members = array_merge($group->other_members, [$contactId]);
                $success = $group->save();
                $sourceId = $group->id;

                $userNotification = new UserNotificationController();
                $request->request->add(['user' => $contactId, 'customer' => $user->id, 'type' => 'agent_group_member_add', 'source_id' => $sourceId]);
                $response = json_decode($userNotification->create($request), true);
            }else if($action == 'remove'){

                if(in_array($contactId, $group->other_members)){
                    $group->other_members = array_diff($group->other_members, [$contactId]);
                    $group->save();
                    $success = true;
                }else{
                    $error = 'This contact does not exist in this group chat';
                }
            }
        }else{

            $error = 'No group found';
        }

        return json_encode(['success' => $success, 'error' => $error, 'html' => $html]);
    }

    public function delete(Request $request){

        $return['error'] = '';
        $return['success'] = 0;
        if( Auth::check() && $request->has('id') ){

            $user = Auth::user();
            $contact = AgentContact::find($request->id);

            if( $contact && $contact->agent_id == $user->id ){

                if($contact->agreement_pdf && CommonMethods::fileExists(public_path('agent-agreements/').$contact->agreement_pdf)){

                    unlink(public_path('agent-agreements/').$contact->agreement_pdf);
                }

                $userChatGroup = UserChatGroup::where(['contact_id' => $contact->contact_id, 'agent_id' => $user->id])->first();
                if($userChatGroup){
                    $userChatGroup->delete();
                }

                if(!$contact->approved && !$contact->is_already_user){

                    $contact->contactUser->profile->delete();
                    $contact->contactUser->address->delete();
                    $contact->contactUser->delete();
                }

                $return['success'] = $contact->delete();
            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

        return json_encode(['success' => $return['success'], 'error' => $return['error']]);
    }

    public function deleteQuestion (Request $request){

        $return['error'] = '';
        $return['success'] = 0;
        $isAllowed = false;
        if($request->has('id')){

            $question = ContactQuestion::find($request->id);

            if($question && $question->agentContact && $question->agentContact->agentUser && $question->agentContact->contactUser){

                if(Auth::check() && Auth::user()->id == $question->agentContact->agentUser->id)
                    $isAllowed = 'agent';
                elseif(!Auth::check() && $question->agentContact->contactUser->email == NULL && $question->agentContact->contactUser->password == NULL && $question->agentContact->approved == NULL)
                    $isAllowed = 'user';
                elseif(Auth::check() && Auth::user()->id == $question->agentContact->contactUser->id)
                    $isAllowed = 'user';
            }

            if($isAllowed){

                $question->elements->each(function($element) {
                	$element->delete();
                });

                $return['success'] = $question->delete();
            }else{

                $return['error'] = 'Delete item and logged in user are mismatched';
            }
        }else{

            $return['error'] = 'No user is logged in';
        }

        if( $return['error'] != '' ){

            Session::flash('error', 'Error: '.$return['error']);
        }

        return json_encode(['success' => $return['success'], 'error' => $return['error']]);
    }

    public function switchAccount(Request $request, $code){

        $agent = Auth::user();
        $contact = AgentContact::where(['agent_id' => $agent->id, 'code' => $code])->first();
        if($contact && $contact->contactUser){

            if(!isset($_SESSION)) {
                session_start();
            }
            if(isset($_SESSION['basket_customer_id'])){
                unset($_SESSION['basket_customer_id']);
            }
            if(isset($_SESSION['avatar'])){
                unset($_SESSION['avatar']);
            }
            Auth::user()->last_activity = null;
            Auth::user()->save();
            Auth::logout();

            Auth::login($contact->contactUser);
            return redirect(route('agency.dashboard'));
        }else{

            return 'Invalid code or authorization issue detected';
        }
    }

    public function getQuestionnaire(Request $request){

        $agent = Auth::user();

        if($request->has('skill')){

            $skill = $request->get('skill');

            $agentQuestionnaire = AgentQuestionnaire::where(['skill' => $skill, 'agent_id' => $agent->id])->first();

            $html = \View::make('parts.agent-questionnaire', ['skill' => $skill, 'questionnaire' => $agentQuestionnaire])->render();

            return json_encode(['data' => $html, 'success' => 1]);
        }else{

            return json_encode(['data' => '', 'error' => 'not enough data for questionnaire']);
        }
    }

    public function getQuestionsBySkill(Request $request){

        $agent = Auth::user();

        if($request->has('skill')){

            $skill = $request->get('skill');

            $agentQuestionnaire = AgentQuestionnaire::where(['agent_id' => $agent->id])->first();

            $html = \View::make('parts.agent-questionnaire', ['skill' => $skill])->render();

            return json_encode(['data' => $html, 'success' => 1]);
        }else{

            return json_encode(['data' => '', 'error' => 'not enough data for questionnaire']);
        }
    }

    public function manageQuestionnaire(Request $request){

        $agent = Auth::user();

        if($request->has('skill')){

            $skill = $request->get('skill');
            $questions = $request->get('question');

            $agentQuestionnaire = AgentQuestionnaire::where(['skill' => $skill, 'agent_id' => $agent->id])->first();
            if(!$agentQuestionnaire){

                $agentQuestionnaire = new AgentQuestionnaire();
                $agentQuestionnaire->agent_id = $agent->id;
                $agentQuestionnaire->skill = $skill;
                $agentQuestionnaire->save();
            }

            if(count($agentQuestionnaire->questions)){

                $agentQuestionnaire->questions->each(function($question) {
                    $question->delete();
                });
            }
            if(is_array($questions) && count($questions)){

                foreach ($questions as $key => $question) {

                    if(trim($question) != ''){

                        $agentQuestionnaireElement = new AgentQuestionnaireElement();
                        $agentQuestionnaireElement->agent_questionnaire_id = $agentQuestionnaire->id;
                        $agentQuestionnaireElement->type = 'text';
                        $agentQuestionnaireElement->value = $question;
                        $agentQuestionnaireElement->save();
                    }
                }
            }

            return redirect()->back();
        }else{

            return redirect()->back()->with('error' , 'not enough data for questionnaire');
        }
    }

    public function saveSkills(Request $request, $code){

        $contact = AgentContact::where(['code' => $code])->first();

        if($contact && $contact->contactUser && $contact->agentUser){

            $skill = $request->get('skill');
            $questions = $request->get('question');

            $agentQuestionnaire = AgentQuestionnaire::where(['skill' => $skill, 'agent_id' => $agent->id])->first();
            if(!$agentQuestionnaire){

                $agentQuestionnaire = new AgentQuestionnaire();
                $agentQuestionnaire->agent_id = $agent->id;
                $agentQuestionnaire->skill = $skill;
                $agentQuestionnaire->save();
            }

            if(count($agentQuestionnaire->questions)){

                $agentQuestionnaire->questions->each(function($question) {
                    $question->delete();
                });
            }
            if(is_array($questions) && count($questions)){

                foreach ($questions as $key => $question) {

                    if(trim($question) != ''){

                        $agentQuestionnaireElement = new AgentQuestionnaireElement();
                        $agentQuestionnaireElement->agent_questionnaire_id = $agentQuestionnaire->id;
                        $agentQuestionnaireElement->type = 'text';
                        $agentQuestionnaireElement->value = $question;
                        $agentQuestionnaireElement->save();
                    }
                }
            }

            return redirect()->back();
        }else{

            return redirect()->back()->with('error' , 'invalid user');
        }
    }

    public function saveDetails(Request $request, $code, $action){

        $contact = AgentContact::where(['code' => $code])->first();

        if(Auth::check() && $contact->agentUser && Auth::user()->id == $contact->agentUser->id)
            $isAllowed = 'agent';
        elseif(!Auth::check() && $contact->contactUser && $contact->contactUser->email == NULL && $contact->contactUser->password == NULL && $contact->approved == NULL)
            $isAllowed = 'user';
        elseif(Auth::check() && Auth::user()->id == $contact->contactUser->id)
            $isAllowed = 'user';
        else
            $isAllowed = false;

        if($isAllowed && $contact && $contact->contactUser && $contact->agentUser){

            if($action == 'add-question'){

            	$contactQuestion = new ContactQuestion();
            	$contactQuestion->agent_contact_id = $contact->id;
            	$contactQuestion->value = $request->question;
            	$contactQuestion->order = count($contact->questions) ? $contact->questions->last()->order + 1 : 1;
            	$contactQuestion->save();

            }else if($action == 'send-notification'){

            	if($isAllowed == 'agent'){

                    $sender = $contact->agentUser;
                    $recipient = $contact->contactUser;
                    $recipientEmail = $contact->contactUser->email ? $contact->contactUser->email : $contact->email;
                }else{

                    $sender = $contact->contactUser;
                    $recipient = $contact->agentUser;
                    $recipientEmail = $recipient->email;
                }

                $result = Mail::to($recipientEmail)->bcc(Config('constants.bcc_email'))->send(new AgentContactMailer($contact->agentUser, $contact, ['sender' => $sender->name, 'recipient' => $recipient->name], 'agent-form-updated'));

            	$userNotification = new UserNotificationController();
            	$request->request->add(['user' => $recipient->id, 'customer' => $sender->id, 'type' => 'agent_form_filled', 'source_id' => $contact->id]);
            	$response = json_decode($userNotification->create($request), true);
            	Session::flash('success', 'A notification has been sent to '.$recipient->name);
            	return response(['success' => 1]);

            }else if($action == 'add-answer'){

            	$questionId = $request->question_id;
            	$question = ContactQuestion::find($questionId);

                if($request->has('question')){

                    $question->value = $request->get('question');
                    $question->save();
                }

            	if($request->has('element')){

            	    $elementKeys = [];
            	    foreach ($request->element as $key => $element){
            	        $order = $key;
            	        $elementKeys[] = $key;
            	        if(isset($element[0])){
            	            if($element[1][0] == 'image'){
            	                $name = 'image';
            	                $value = rand(1000000,9999999).'.'.$element[0][0]->getClientOriginalExtension();
            	                $path = public_path('contact-info-images/'.$value);
            	                Image::make($element[0][0]->getRealPath())->save($path, 60);
            	                $type = 'image';
            	            }else{
            	                $value = $element[0][0];
            	                $type = $element[1][0];
            	            }
            	            $record = ContactQuestionElement::where(['order' => $key, 'contact_question_id' => $question->id])->first();
            	            $pElement = ($record === null) ? new ContactQuestionElement() : $record;

            	            if($record && $record->type == 'image' && CommonMethods::fileExists(public_path('contact-info-images/').$record->value)){

            	                unlink(public_path('contact-info-images/').$record->value);
            	            }

            	            $pElement->contact_question_id = $question->id;
            	            $pElement->type = $type;
            	            $pElement->value = $value;
            	            $pElement->order = $order;
            	            $response = $pElement->save();
            	        }
            	    }

            	    //delete all the elements which were not posted in the form
            	    $tobeDeleted = ContactQuestionElement::whereNotIn('order', $elementKeys)->where(['contact_question_id' => $question->id])->get();
            	    if(count($tobeDeleted)){

            	        foreach ($tobeDeleted as $element) {
            	            if($element->type == 'image' && CommonMethods::fileExists(public_path('contact-info-images/').$element->value)){

            	                unlink(public_path('contact-info-images/').$element->value);
            	            }
            	            $element->delete();
            	        }
            	    }
            	}else{

            	    $tobeDeleted = ContactQuestionElement::where(['contact_question_id' => $question->id])->get();
            	    if(count($tobeDeleted)){

            	        foreach ($tobeDeleted as $element) {
            	            if($element->type == 'image' && CommonMethods::fileExists(public_path('contact-info-images/').$element->value)){

            	                unlink(public_path('contact-info-images/').$element->value);
            	            }
            	            $element->delete();
            	        }
            	    }
            	}

            	//delete empty elements
            	$tobeDeleted = ContactQuestionElement::where(['contact_question_id' => $question->id])->get();
            	if(count($tobeDeleted)){
            	    foreach ($tobeDeleted as $element) {
            	        if($element->value == NULL || $element->value == ''){
            	            $element->delete();
            	        }
            	    }
            	}
            }

            if(isset($question)){
            	return redirect()->back()->with('tab', 'edit')->with('question', $question->id);
            }else{
            	return redirect()->back()->with('tab', 'edit');
            }
        }else{

            return redirect()->back()->with('error' , 'invalid user');
        }
    }

    public function showDetails(Request $request, $code){

        $contact = AgentContact::where(['code' => $code])->first();

        if($contact && $contact->contactUser && $contact->agentUser){

            $data = [

                'contact' => $contact,
                'agent' => $contact->agentUser,
            ];

            return view( 'pages.contact-details-form', $data );
        }else{

            return 'Invalid code or authorization issue detected';
        }
    }

    public function sendRequestToAgent(Request $request){

        $user = Auth::user();
        $success = 0;
        $error = '';

        if($request->has('id') && $user){

            $agentId = $request->get('id');
            $agent = User::find($agentId);
            if($agent){

                $requestExist = AgentContactRequest::where(['contact_user_id' => $user->id, 'agent_user_id' => $agent->id])->first();
                if($requestExist){

                    $error = 'Request already sent';
                }else{

                    $agentContactRequest = new AgentContactRequest();
                    $agentContactRequest->contact_user_id = $user->id;
                    $agentContactRequest->agent_user_id = $agent->id;
                    $agentContactRequest->save();

                    $result = Mail::to($agent->email)->bcc(Config('constants.bcc_email'))->send(new AgentContactR($agent, $user));

                    $userNotification = new UserNotificationController();
                    $request->request->add(['user' => $agent->id, 'customer' => $user->id, 'type' => 'agent_contact_request', 'source_id' => $agentContactRequest->id]);
                    $response = json_decode($userNotification->create($request), true);

                    $success = 1;
                }
            }else{

                $error = 'No agent known';
            }
        }else{

            $error = 'No/Invalid data';
        }

        return json_encode(['error' => $error, 'success' => $success]);
    }

    public function deleteRequestToAgent(Request $request){

        $user = Auth::user();
        $success = 0;
        $error = '';

        if($request->has('id') && $user){

            $id = $request->get('id');
            $request = AgentContactRequest::where(['agent_user_id' => $user->id, 'id' => $id])->first();
            if($request){

                $request->delete();
                $success = 1;
            }else{

                $error = 'No data exist';
            }
        }else{

            $error = 'No/Invalid data';
        }

        return json_encode(['error' => $error, 'success' => $success]);
    }
}

