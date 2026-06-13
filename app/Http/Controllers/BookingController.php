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
            return redirect()->route('login')->with('error', 'You must be logged in to book tickets.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:bank_transfer,credit_card,paypal',
        ]);

        $event = Event::findOrFail($eventId);

        if ($event->quota < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient quota for your reservation.');
        }

        if ($event->price < 0) {
            return redirect()->back()->with('error', 'Invalid ticket price.');
        }

        $totalPrice = $event->price * $request->quantity;

        DB::transaction(function () use ($request, $event, $totalPrice) {
            Booking::create([
                'id_user' => Auth::id(),
                'id_event' => $event->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'sender_account_name' => $request->sender_account_name,
                'sender_bank' => $request->sender_bank,
            ]);

            $event->decrement('quota', $request->quantity);
        });

        return back()->with('success', 'Ticket booking successful!');
    }

    public function invoice($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access invoices.');
        }

        $booking = Booking::with(['user', 'event.location', 'event.category'])->findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $booking->id_user) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->status !== 'confirmed') {
            return redirect()->route('user.ticket')->with('error', 'Invoice is only available for confirmed bookings.');
        }

        return view('user.invoice', compact('booking'));
    }

    public function uploadProof(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $booking = Booking::findOrFail($id);

        if (Auth::id() !== $booking->id_user) {
            abort(403, 'Unauthorized access.');
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $booking->payment_proof_path = $path;
        $booking->save();

        return redirect()->back()->with('success', 'Payment proof uploaded successfully.');
    }
}
