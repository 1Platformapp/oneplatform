<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if($_SERVER['REQUEST_URI'] == '/register'){
                    if(Auth::check() && !Auth::user()->hasActivePaidSubscription()){
                        if(Auth::user()->hasActiveFreeSubscription()){
                            return redirect(route('user.startup.wizard', ['action' => 'upgrade-subscription']));
                        }else{
                            return redirect(route('user.startup.wizard'));
                        }
                    }else{
                        return redirect(route('agency.dashboard'));
                    }
                }
                return redirect(route('site.home'));
            }
        }

        return $next($request);
    }
}
