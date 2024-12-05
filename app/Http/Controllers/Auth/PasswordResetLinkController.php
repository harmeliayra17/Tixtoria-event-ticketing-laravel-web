<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi email dari form reset password
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Mengirimkan link reset password ke pengguna yang sesuai
        $status = Password::sendResetLink(
            $request->only('email') // hanya email yang diminta oleh pengguna
        );

        // Jika status pengiriman berhasil, kembali dengan pesan sukses
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __('Password reset link telah dikirim ke email Anda.'))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]); // Jika gagal, tampilkan error
    }
}
