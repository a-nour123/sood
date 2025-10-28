<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
#dd(session('time'));
        $timeout = 120*60 ; // seconds (1 minute)
        if (session()->has('login')) {
	    $login = session('login');
	    if (time() - session('login') > $timeout) {
		#Auth::logout();
		#Session::flush();
		#session(["login" => $login]);
		return app()->call("App\Http\Controllers\SamlController@logout", ['request' => $request]);
            }
        }
        return $next($request);
    }

}
