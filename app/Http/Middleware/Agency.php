<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class Agency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){

            return redirect(route('login'));
        }

        $user = Auth::user();

        if($user->apply_expert !== 2){

            return redirect(route('profile'));
        }

        if($user->profile->basic_setup != 1){

            if(Session::has('forceNext')){

                $forceN = Session::get('forceNext');
                Session::forget('forceNext');
                return redirect(route('profile.setup', ['page' => $forceN]));
            }else{

                $setupProfileWizard = $user->setupProfileWizard();

                if($setupProfileWizard['error'] != ''){

                    return redirect(route('profile.setup', ['page' => $setupProfileWizard['error']]));
                }
            }
        }

        return $next($request);
    }
}
