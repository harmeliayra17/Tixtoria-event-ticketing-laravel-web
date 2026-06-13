<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Category;
use App\Models\Location;
use App\Models\Booking;
use App\Http\Requests\CreateEventRequest;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrganizerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $totalEvents = Event::where('user_id', $user->id)->count();

        $totalTicketsSold = Booking::whereHas('event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'confirmed')->sum('quantity');

        $totalRevenue = Booking::whereHas('event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id')
            ->sum(DB::raw('bookings.quantity * events.price'));

        $upcomingEvents = Event::where('user_id', $user->id)
            ->where('date', '>=', now())
            ->withCount(['bookings as tickets_sold' => function ($query) {
                $query->where('status', 'confirmed');
            }])
            ->withSum(['bookings as revenue' => function ($query) {
                $query->where('status', 'confirmed');
            }], DB::raw('bookings.quantity * events.price'))
            ->get();

        $eventNames = Event::where('user_id', $user->id)->pluck('title');
        $eventTicketsSold = Event::where('user_id', $user->id)
            ->withCount(['bookings as tickets_sold' => function ($q) {
                $q->where('status', 'confirmed');
            }])->pluck('tickets_sold');
        $eventRevenues = Event::where('user_id', $user->id)
            ->withSum(['bookings as revenue' => function ($q) {
                $q->where('status', 'confirmed');
            }], DB::raw('bookings.quantity * events.price'))
            ->pluck('revenue');

        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';

        return view('organizer.dashboard', compact(
            'totalEvents',
            'totalTicketsSold',
            'totalRevenue',
            'upcomingEvents',
            'eventNames',
            'eventTicketsSold',
            'eventRevenues',
            'user',
            'profileUrl'
        ));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function organizerIndex(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'organizer') {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $locations = Location::all();

        $search = $request->get('search');
        $date = $request->get('date');
        $city = $request->get('location');
        $categoryId = $request->get('category');

        $eventsQuery = Event::query()->where('user_id', $user->id);

        if ($search) {
            $search = strtolower($search);
            $eventsQuery->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])
                    ->orWhereHas('location', function ($locationQuery) use ($search) {
                        $locationQuery->whereRaw('LOWER(city) LIKE ?', ['%' . $search . '%']);
                    });
            });
        }

        if ($date) {
            $eventsQuery->whereDate('date', '=', $date);
        }

        if ($categoryId) {
            $eventsQuery->where('id_category', $categoryId);
        }

        if ($city) {
            $eventsQuery->whereHas('location', function ($query) use ($city) {
                $query->where('city', 'like', '%' . $city . '%');
            });
        }

        $events = $eventsQuery->orderBy('date', 'desc')->paginate(12);

        if ($search) {
            $title = "Search results for '$search'";
        } elseif ($date) {
            $title = "Events on $date";
        } elseif ($categoryId && $city) {
            $category = $categories->find($categoryId);
            $title = "Events in $city under " . $category->name . " category";
        } elseif ($categoryId) {
            $category = $categories->find($categoryId);
            $title = "Events in " . $category->name . " category";
        } elseif ($city) {
            $title = "Events in $city";
        } else {
            $title = "All Events";
        }

        return view('organizer.manageEvents', compact('events', 'categories', 'locations', 'title'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('organizer.createEvent', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'id_category' => 'required|exists:categories,id',
            'quota' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create an event.');
        }

        $location = Location::create([
            'location_name' => $validated['location_name'],
            'city' => $validated['city'],
            'province' => $validated['province'],
        ]);

        $event = Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'price' => $validated['price'],
            'id_category' => $validated['id_category'],
            'quota' => $validated['quota'],
            'location_id' => $location->id,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            if ($event->image && Storage::exists(str_replace('/storage/', '', $event->image))) {
                Storage::delete(str_replace('/storage/', '', $event->image));
            }
            $path = $request->file('image')->store('events', 'public');
            $event->image = '/storage/' . $path;
            $event->save();
        }

        return redirect()->route('organizer.manageEvents')->with('success', 'Event created successfully');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();
        return view('organizer.editEvent', compact('event', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'price' => 'nullable|numeric',
            'quota' => 'nullable|integer',
            'id_category' => 'required|exists:categories,id',
            'location_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $event = Event::findOrFail($id);

        $event->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time'],
            'price' => $validatedData['price'],
            'quota' => $validatedData['quota'],
            'id_category' => $validatedData['id_category'],
        ]);

        $event->location()->update([
            'location_name' => $validatedData['location_name'],
            'city' => $validatedData['city'],
            'province' => $validatedData['province'],
        ]);

        if ($request->hasFile('image')) {
            if ($event->image && Storage::exists(str_replace('/storage/', '', $event->image))) {
                Storage::delete(str_replace('/storage/', '', $event->image));
            }
            $path = $request->file('image')->store('events', 'public');
            $event->image = '/storage/' . $path;
            $event->save();
        }

        return redirect()->route('organizer.manageEvents')->with('success', 'Event updated successfully!');
    }

    public function manageTickets()
    {
        $user = Auth::user();

        $bookings = Booking::with(['user', 'event'])
            ->whereHas('event', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->get();

        return view('organizer.manageTickets', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        if ($request->status === 'confirmed') {
            return redirect()->route('organizer.manageTickets')
                ->with('show_invoice_id', $booking->id)
                ->with('success', 'Booking status updated successfully.');
        }

        return redirect()->route('organizer.manageTickets')
            ->with('success', 'Booking status updated successfully.');
    }

    public function dashboardAdmin()
    {
        $totalEvents = Event::count();
        $totalTicketsSold = Booking::where('status', 'confirmed')->sum('quantity');

        $totalRevenue = Booking::where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id')
            ->sum(DB::raw('bookings.quantity * events.price'));

        $upcomingEvents = Event::where('date', '>=', now())
            ->withCount(['bookings as tickets_sold' => function ($query) {
                $query->where('status', 'confirmed');
            }])
            ->withSum(['bookings as revenue' => function ($query) {
                $query->where('status', 'confirmed');
            }], DB::raw('bookings.quantity * events.price'))
            ->get();

        $eventNames = Event::pluck('title');
        $eventTicketsSold = Event::withCount(['bookings as tickets_sold' => function ($query) {
            $query->where('status', 'confirmed');
        }])->pluck('tickets_sold');

        $eventRevenues = Event::withSum(['bookings as revenue' => function ($query) {
            $query->where('status', 'confirmed');
        }], DB::raw('bookings.quantity * events.price'))
            ->pluck('revenue');

        return view('organizer.dashboard', compact(
            'totalEvents',
            'totalTicketsSold',
            'totalRevenue',
            'upcomingEvents',
            'eventNames',
            'eventTicketsSold',
            'eventRevenues'
        ));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,gif|max:5120',
        ]);

        $booking = Booking::findOrFail($id);
        if ($booking->event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $booking->payment_proof_path = $path;
        $booking->save();

        return redirect()->back()->with('success', 'Payment proof uploaded successfully.');
    }

    public function showInvoice($id)
    {
        $booking = Booking::with(['user', 'event'])->findOrFail($id);
        if ($booking->event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
        return view('organizer.invoice', compact('booking'));
    }
}