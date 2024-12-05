<?php

// App/Http/Middleware/ShareAdminData.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareUserData
{
    public function handle($request, Closure $next)
    {
        // Cek jika user sudah login dan memiliki role admin
        if (Auth::check() && Auth::user()->role === 'user') {
            $user = Auth::user();
            $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';

            // Membagikan data ke semua tampilan (views)
            View::share('profileUrl', $profileUrl);
        }

        return $next($request);
    }
}
