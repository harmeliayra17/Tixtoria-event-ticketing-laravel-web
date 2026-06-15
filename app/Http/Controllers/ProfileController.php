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
    public function edit(Request $request): View
    {
        return view('user.partials.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($user->role === 'admin') {
            return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
        } elseif ($user->role === 'organizer') {
            return Redirect::route('organizer.profile.edit')->with('status', 'profile-updated');
        }

        return Redirect::route('user.profile.edit')->with('status', 'profile-updated');
    }

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

        return Redirect::to('/');
    }

    public function showProfile(): View
    {
        $user = Auth::user();
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';
        return view('user.partials.sidebar', compact('user', 'profileUrl'));
    }

    public function editAdmin(Request $request): View
    {
        $user = $request->user();
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';
        return view('admin.profile.edit', compact('user', 'profileUrl'));
    }

    public function editOrganizer(Request $request): View
    {
        $user = $request->user();
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';
        return view('organizer.profile.edit', compact('user', 'profileUrl'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';

        $recentBookings = Booking::with(['event.location'])
            ->where('id_user', $user->id)
            ->latest()
            ->take(3)
            ->get();

        $recentFavorites = \App\Models\Favorite::with(['event.category', 'event.location'])
            ->where('id_user', $user->id)
            ->latest()
            ->take(3)
            ->get();

        $bookingsCount = Booking::where('id_user', $user->id)->count();
        $favoritesCount = \App\Models\Favorite::where('id_user', $user->id)->count();

        return view('user.dashboard', compact('user', 'profileUrl', 'recentBookings', 'recentFavorites', 'bookingsCount', 'favoritesCount'));
    }

    public function applyOrganizer(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if (in_array($user->organizer_status, ['none', 'rejected'])) {
            $user->organizer_status = 'pending';
            $user->save();
            return redirect()->back()->with('success', 'Your application to become an organizer has been submitted successfully.');
        }

        return redirect()->back()->with('error', 'You cannot apply at this time.');
    }

    public function showPasswordForm(): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            if ($user->role === 'admin') {
                return Redirect::route('admin.profile.edit');
            } elseif ($user->role === 'organizer') {
                return Redirect::route('organizer.profile.edit');
            }
        }
        return Redirect::route('user.profile.edit');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        if ($user->role === 'admin') {
            return Redirect::route('admin.profile.edit')->with('status', 'password-updated');
        } elseif ($user->role === 'organizer') {
            return Redirect::route('organizer.profile.edit')->with('status', 'password-updated');
        }

        return Redirect::route('user.profile.edit')->with('status', 'password-updated');
    }

    public function bookHistory()
    {
        $user = Auth::user();

        $bookings = Booking::with(['user', 'event'])
            ->where('id_user', $user->id)
            ->latest()
            ->get();

        return view('user.ticket', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('organizer.manageTickets')->with('success', 'Booking status updated successfully.');
    }
}
