<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CalendarEvent;
use Auth;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $eventId = $this->input('edit');
        $event = CalendarEvent::find($eventId);

        if (!$event || $event->user_id != $user->id) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'location' => ['required'],
            'edit' => 'required|exists:calendar_events,id',
        ];
    }
}
