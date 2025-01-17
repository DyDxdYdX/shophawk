<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithoutCache
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $response = $next($request);

        if (!method_exists($response, 'header')) {
            return $response;
        }

        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', '0');
    }
} 