<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
class RecordVisitorStatistics
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $user_id = Auth::check() ? Auth::id() : null;
        $destinationLink = $request->fullUrl();
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');
        $visitDate = now();
        $routeName = Route::currentRouteName();
        $routeValue = $request->route() ? json_encode($request->route()->parameters()) : null;

        DB::table('visitor_statistics')->insert([
            'user_id' => $user_id,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'visit_date' => $visitDate,
            'destination_link' => $destinationLink,
            'route_name' => $routeName,
            'route_value' => $routeValue,
            'created_at' => now(),
        ]);

        return $response;
    }
}
