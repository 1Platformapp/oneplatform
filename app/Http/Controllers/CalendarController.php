<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CalendarEvent;
use App\Mail\CalendarMail;
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

class CalendarController extends Controller

{

    public function __construct(){

        $this->middleware('user.update.activity');
    }

    public function create(AddEventRequest $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();
        $user = Auth::user();
        $participants = $request->participants != '' ? explode(',', $request->participants) : [];

        $event = new CalendarEvent();
        $event->user_id = $user->id;
        $event->title = $request->title;
        $event->date_time_input = $request->dateTimeInput;
        $event->date = date('Y-m-d', strtotime($request->dateTime));
        $event->location = $request->location;
        $event->save();

        foreach ($participants as $key => $participantId) {
            $eventParticipant = new CalendarEventParticipant();
            $eventParticipant->user_id = $participantId;
            $eventParticipant->calendar_event_id = $event->id;
            $eventParticipant->save();

            $result = Mail::to($eventParticipant->user->email)->bcc(Config('constants.bcc_email'))->send(new CalendarMail($eventParticipant));
        }

        $success = true;
        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function read(Request $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();
        $user = Auth::user();
        $date = date('Y-m-d', strtotime($request->date));

        $events = CalendarEvent::where(['user_id' => $user->id, 'date' => $date])->orWhereHas('participants', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('participants')->orderBy('id', 'asc')->get();

        $transformedEvents = $events->map(function ($event) {
            if ($event->participants) {
                $event->participant_users = $event->participants->map(function ($participant) {
                    return $participant->user ? ['id' => $participant->id, 'user_id' => $participant->user_id, 'username' => $participant->user->username, 'name' => $participant->user->name, 'image' => CommonMethods::getUserDisplayImage($participant->user_id)] : null;
                });
            } else {
                $event->participant_users = [];
            }

            return $event;
        });

        $success = true;
        return json_encode(['success' => $success, 'error' => $error, 'data' => $transformedEvents]);
    }

    public function update(UpdateEventRequest $request){

        $success = 0;
        $error = '';
        $commonMethods = new CommonMethods();
        $user = Auth::user();
        $participants = $request->participants != '' ? explode(',', $request->participants) : [];

        $event = CalendarEvent::find($request->edit);
        $event->title = $request->title;
        $event->date_time_input = $request->dateTimeInput;
        $event->date = date('Y-m-d', strtotime($request->dateTime));
        $event->location = $request->location;
        $event->save();

        if ($event->participants->count()) {

            foreach ($event->participants as $item) {
                if (!in_array($item->user_id, $participants)) {
                    $item->delete();
                }
            }
        }

        foreach ($participants as $key => $participantId) {

            $exist = CalendarEventParticipant::where(['user_id' => $participantId, 'calendar_event_id' => $event->id])->get()->first();
            if (!$exist) {
                $eventParticipant = new CalendarEventParticipant();
                $eventParticipant->user_id = $participantId;
                $eventParticipant->calendar_event_id = $event->id;
                $eventParticipant->save();

                $result = Mail::to($eventParticipant->user->email)->bcc(Config('constants.bcc_email'))->send(new CalendarMail($eventParticipant));
            }
        }

        $success = true;
        return json_encode(['success' => $success, 'error' => $error]);
    }

    public function delete(DeleteEventRequest $request){

        $success = 0;
        $error = '';

        $event = CalendarEvent::find($request->id);

        if ($event->participants->count()) {
            $event->participants()->delete();
        }

        $event->delete();

        $success = true;
        return json_encode(['success' => $success, 'error' => $error]);
    }
}

