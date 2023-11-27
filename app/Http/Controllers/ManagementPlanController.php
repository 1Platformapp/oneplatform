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

        $commonMethods = new commonMethods();
        $user = Auth::user();

        $submit = ManagementPlanSubmit::where(['stage_id' => $request->stage, 'task_id' => $request->task, 'user_id' => $user->id, 'type' => $request->type])->get()->first();
        if (!$submit) {
            $submit = new ManagementPlanSubmit();
            $submit->user_id = $user->id;
            $submit->stage_id = $request->stage;
            $submit->task_id = $request->task;
            $submit->type = $request->type;
        }

        if ($request->type == 'notes') {
            $submit->value = $request->data;
        } else if ($request->type == 'status') {
            if ($request->data == 'default') {
                $submit->value = 'urgent';
            } else if ($request->data == 'urgent') {
                $submit->value = 'in-progress';
            } else if ($request->data == 'in-progress') {
                $submit->value = 'completed';
            } else {
                $submit->value = 'default';
            }
        }

        $submit->save();

        return json_encode(['success' => true, 'error' => '', 'value' => $submit->value, 'icon' => $commonMethods->getManagementPlanStatusIcon($submit->value)]);
    }
}



