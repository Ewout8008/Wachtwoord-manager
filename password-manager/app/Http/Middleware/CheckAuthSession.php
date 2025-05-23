<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuthSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->get('auth', false)) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
