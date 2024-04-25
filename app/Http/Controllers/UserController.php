<?php

namespace App\Http\Controllers;

use App\Models\AgentContact;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();

        $contactIds = AgentContact::where('agent_id', $data['agent_id'])->pluck('contact_id')->toArray();

        $users = User::whereIn('id', $contactIds)->filters(['search' => $data['search']])->get();

        return response()->json([
            'users' => $users,
        ]);
    }
}
