<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('loggedIn')) {
            return redirect()->route('login')->withErrors(['You must log in first.']);
        }

        return $next($request);
    }
}
