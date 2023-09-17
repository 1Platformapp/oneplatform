<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonMethods;

use App\Http\Requests\ManagementPlanSubmitRequest;
use App\Models\ManagementPlanSubmit;
use Auth;

class ManagementPlanController extends Controller
{
    public static function submit(ManagementPlanSubmitRequest $request){

        $user = Auth::user();

        $submit = ManagementPlanSubmit::where(['stage_id' => $request->stage, 'task_id' => $request->task, 'user_id' => $user->id, 'type' => $request->type])->get()->first();
        if (!$submit) {
            $submit = new ManagementPlanSubmit();
            $submit->user_id = $user->id;
            $submit->stage_id = $request->stage;
            $submit->task_id = $request->task;
            $submit->type = $request->type;
        }

        $submit->value = $request->data;
        $submit->save();

        return json_encode(['success' => true, 'error' => '']);
    }
}



