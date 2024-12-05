<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);
    
        // Dapatkan id_user dari auth (user yang sedang login)
        $userId = $request->user()->id;
    
        // Cek apakah favorit sudah ada
        $existingFavorite = Favorite::where('id_user', $userId)
                                    ->where('id_event', $request->event_id)
                                    ->first();
    
        if ($existingFavorite) {
            // Simpan pesan error ke session
            session()->flash('error', 'Event is already in your favorites.');
            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
    
        // Simpan favorit baru
        Favorite::create([
            'id_user' => $userId,
            'id_event' => $request->event_id,
        ]);
    
        // Simpan pesan sukses ke session
        session()->flash('success', 'Event added to favorites.');
        // Redirect ke halaman sebelumnya
        return redirect()->back();
    }      

    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data favorit berdasarkan user_id
        $favorites = Favorite::where('id_user', $user->id)->with('event')->get(); // Ganti 'relatedModel' dengan relasi jika ada

        // Kembalikan view dengan data favorit
        return view('user.favorites', compact('favorites'));
    }
}
