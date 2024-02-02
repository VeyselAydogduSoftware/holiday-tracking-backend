<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRequestSecurity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if($request->header('ApiSecurityKey') && $request->header('ApiSecurityKey') == settings('api', 'api_security_key')){

            return $next($request);

        }

        return response()->json('Identy Error', 401);

    }
}
