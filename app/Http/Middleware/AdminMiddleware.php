<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
   
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->id == 2)
        {
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }
}
