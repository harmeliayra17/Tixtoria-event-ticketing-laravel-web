<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
   public function store(Request $request, $eventId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk memesan.');
        }

        // Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:bank_transfer,credit_card,paypal',
        ]);

        // Ambil event berdasarkan ID
        $event = Event::findOrFail($eventId);

        if ($event->quota < $request->quantity) {
            return redirect()->back()->with('error', 'Kuota tidak mencukupi untuk reservasi Anda.');
        }

        if ($event->price < 0) {
            return redirect()->back()->with('error', 'Harga tiket tidak valid.');
        }

        $totalPrice = $event->price * $request->quantity;

        // Simpan data booking dan kurangi kuota dalam transaksi
        DB::transaction(function () use ($request, $event, $totalPrice) {
            // Buat booking
            Booking::create([
                'id_user' => Auth::id(),
                'id_event' => $event->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            // Kurangi kuota event
            $event->decrement('quota', $request->quantity);
        });

        return back()->with('success', 'Event added to favorites.');
    }
}
