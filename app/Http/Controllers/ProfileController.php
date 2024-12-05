<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Booking;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    
    public function edit(Request $request): View
    {
        return view('user.partials.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('user.partials.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/user/dashboard');
    }

    /**
     * Show the user's profile information in the sidebar.
     */
    public function showProfile(): View
    {
        $user = Auth::user();
        
        // Menentukan URL profil, jika tidak ada maka menggunakan gambar default
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';
        
        // Mengirimkan variabel 'user' dan 'profileUrl' ke view sidebar
        return view('user.partials.sidebar', compact('user', 'profileUrl'));
    }

    /**
     * Display the user's dashboard.
     */
    public function dashboard()
    {
        // Pastikan data user dan profile URL dikirim
        $user = Auth::user();
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';

        // Mengirim data ke view dashboard, termasuk data untuk sidebar
        return view('user.dashboard', compact('user', 'profileUrl'));
    }

    /**
     * Display the password change form.
     */
    public function showPasswordForm(): View
    {
        return view('user.partials.update-password-form');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return Redirect::route('user.profile.edit')->with('status', 'password-updated');
    }

    public function bookHistory()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
    
        // Ambil semua pemesanan tiket yang terkait dengan user yang sedang login
        $bookings = Booking::with(['user', 'event'])
            ->where('id_user', $user->id) // Filter hanya pemesanan yang dilakukan oleh user yang sedang login
            ->latest() // Urutkan berdasarkan pemesanan terbaru
            ->get();
    
        return view('user.ticket', compact('bookings'));
    }    

    /**
     * Update status pemesanan tiket.
     */
    public function updateBookingStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        // Cari pemesanan berdasarkan ID
        $booking = Booking::findOrFail($id);

        // Perbarui status
        $booking->status = $request->status;
        $booking->save();

        // Redirect dengan pesan sukses
        return redirect()->route('organizer.manageTickets')->with('success', 'Status pemesanan berhasil diperbarui.');
    }
}
