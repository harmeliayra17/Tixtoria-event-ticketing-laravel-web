<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Metode untuk logout
    public function logout()
    {
        // Logout pengguna
        Auth::logout();

        // Mengarahkan kembali ke halaman login atau halaman lain setelah logout
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
