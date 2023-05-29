<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserUpdateActivity
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
        if(Auth::check()){

            $user = Auth::user();
            
            /*$accessGranted = 0;
            if($user->security_level == 10){

                $adminIp = Config('constants.admin_ip');
                $userIp = $_SERVER['REMOTE_ADDR'];
                foreach ($adminIp as $key => $ip) {
                    if($userIp == $ip['ip']){
                        $accessGranted = 1;
                    }
                }
            }else{
                $accessGranted = 1;
            }
            if(!$accessGranted){

                return redirect(route('restricted'));
            }*/

            $user->last_activity = date('Y-m-d H:i:s');
            $user->save();
        }

        return $next($request);
    }
}
