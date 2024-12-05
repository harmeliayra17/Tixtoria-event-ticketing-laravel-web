<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Pastikan data user dan profile URL dikirim
        $user = Auth::user();
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';

        // Mengirim data ke view dashboard, termasuk data untuk sidebar
        return view('admin.dashboard', compact('user', 'profileUrl'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function manageTickets()
    {
        // Ambil semua pemesanan tiket dengan relasi user dan event
        $bookings = Booking::with(['user', 'event'])->latest()->get();

        return view('organizer.manageTickets', compact('bookings'));
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
