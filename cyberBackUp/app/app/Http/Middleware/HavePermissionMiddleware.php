<?php

namespace App\Http\Middleware;

use App\Models\ServiceDescription;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HavePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $routesToPermission = getRoutesToPermission();
        $routeName = Route::currentRouteName();
        
        if (
            !array_key_exists($routeName, $routesToPermission) ||
            (array_key_exists($routeName, $routesToPermission) && auth()->user()->hasPermission($routesToPermission[$routeName]))
        ) {
            if (getServicesDescrptionKey($routeName)) {
                session(['serviceDescription' => ServiceDescription::where('route', $routeName)->pluck('description')->first()]);
            } else {
                session(['serviceDescription' => null]);
            }

            return $next($request);
        } else {
            if ($request->ajax()) {
                $response = array(
                    'status' => false,
                    'message' => __('locale.YouDonotHavePermissionToDoThat'),
                );
                return response()->json($response, 401);
            } else
                return abort(401);
        }
    }
}
