<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';

        return view('admin.dashboard', compact('user', 'profileUrl'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function manageTickets()
    {
        $bookings = Booking::with(['user', 'event'])->latest()->get();
        return view('admin.manageTickets', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('admin.manageTickets')->with('success', 'Status booking updated successfully.');
    }

}
