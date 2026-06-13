<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareAdminData
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $user = Auth::user();
            $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';
            View::share('profileUrl', $profileUrl);
        }

        return $next($request);
    }
}
