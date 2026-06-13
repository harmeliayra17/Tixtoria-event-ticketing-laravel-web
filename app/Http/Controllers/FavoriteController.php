<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $userId = $request->user()->id;

        $existingFavorite = Favorite::where('id_user', $userId)
                                    ->where('id_event', $request->event_id)
                                    ->first();

        if ($existingFavorite) {
            session()->flash('error', 'Event is already in your favorites.');
            return redirect()->back();
        }

        Favorite::create([
            'id_user' => $userId,
            'id_event' => $request->event_id,
        ]);

        session()->flash('success', 'Event added to favorites.');
        return redirect()->back();
    }

    public function index()
    {
        $user = Auth::user();
        $favorites = Favorite::where('id_user', $user->id)->with('event')->get();
        return view('user.favorites', compact('favorites'));
    }
}
