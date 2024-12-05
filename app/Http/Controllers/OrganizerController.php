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
        // Pastikan data user dan profile URL dikirim
        $user = Auth::user();
        $profileUrl = $user->profile ?? 'https://via.placeholder.com/40';

        // Mengirim data ke view dashboard, termasuk data untuk sidebar
        return view('organizer.dashboard', compact('user', 'profileUrl'));
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

    public function organizerIndex(Request $request)
    {
        // Pastikan user yang login adalah organizer
        $user = Auth::user();

        if ($user->role !== 'organizer') {
            abort(403, 'Unauthorized action.'); // Batasi akses jika bukan organizer
        }

        // Mengambil semua kategori dan lokasi untuk filter
        $categories = Category::all();
        $locations = Location::all();
        
        // Menangkap query pencarian dan parameter filter
        $search = $request->get('search');
        $date = $request->get('date');
        $city = $request->get('location'); // Mendapatkan lokasi dari request
        $categoryId = $request->get('category'); // Mendapatkan kategori dari request

        // Query dasar untuk events
        $eventsQuery = Event::query()
            ->where('user_id', $user->id); // Filter event berdasarkan user ID yang login
        
        // Pencarian berdasarkan nama event atau lokasi
        if ($search) {
            $search = strtolower($search);
            $eventsQuery->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])
                    ->orWhereHas('location', function ($locationQuery) use ($search) {
                        $locationQuery->whereRaw('LOWER(city) LIKE ?', ['%' . $search . '%']);
                    });
            });
        }

        // Filter berdasarkan tanggal
        if ($date) {
            $eventsQuery->whereDate('date', '=', $date);
        }

        // Filter berdasarkan kategori
        if ($categoryId) {
            $eventsQuery->where('id_category', $categoryId); // Sesuaikan nama kolom jika berbeda
        }

        // Filter berdasarkan lokasi
        if ($city) {
            $eventsQuery->whereHas('location', function ($query) use ($city) {
                $query->where('city', 'like', '%' . $city . '%');
            });
        }

        // Mendapatkan hasil akhir dengan sorting berdasarkan tanggal terbaru
        $events = $eventsQuery->orderBy('date', 'desc')->paginate(12); // Menggunakan paginate untuk halaman
        
        // Menentukan judul halaman berdasarkan kondisi filter yang ada
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

        // Mengirimkan data ke view
        return view('organizer.manageEvents', compact('events', 'categories', 'locations', 'title'));
    }

    public function create()
    {
        // Fetch categories from the database
        $categories = Category::all();
    

        // Pass the categories to the view
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
    
        // Menyimpan lokasi terlebih dahulu
        $location = Location::create([
            'location_name' => $validated['location_name'],
            'city' => $validated['city'],
            'province' => $validated['province'],
        ]);
    
        // Menyimpan acara dan mengaitkan dengan lokasi
        $event = Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'price' => $validated['price'],
            'id_category' => $validated['id_category'],
            'quota' => $validated['quota'],
            'location_id' => $location->id, // Menghubungkan lokasi ke acara
            'user_id' => Auth::id(),
        ]);
    
    // Handle image update (if any)
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($event->image && Storage::exists(str_replace('/storage/', '', $event->image))) {
            Storage::delete(str_replace('/storage/', '', $event->image));
        }

        // Simpan gambar baru
        $path = $request->file('image')->store('events', 'public');
        $event->image = '/storage/' . $path; // Tambahkan prefix untuk akses URL
        $event->save();
    }
    
        return redirect()->route('organizer.manageEvents')->with('success', 'Event created successfully');
    }

    public function edit($id)
    {
        // Ambil data event berdasarkan ID
        $event = Event::findOrFail($id);
        $categories = Category::all(); // Assuming you have a Category model

        return view('organizer.editEvent', compact('event', 'categories'));
    }

    // Metode untuk menangani permintaan update event
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
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
    
        // Temukan event berdasarkan ID
        $event = Event::findOrFail($id);

    
        // Update data event
        $event->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time'],
            'price' => $validatedData['price'],
            'quota' => $validatedData['quota'],
            'id_category' => $validatedData['id_category'],  
        ]);
    
        // Update lokasi event
        $event->location()->update([
            'location_name' => $validatedData['location_name'],
            'city' => $validatedData['city'],
            'province' => $validatedData['province'],
        ]);
    
    // Handle image update (if any)
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($event->image && Storage::exists(str_replace('/storage/', '', $event->image))) {
            Storage::delete(str_replace('/storage/', '', $event->image));
        }

        // Simpan gambar baru
        $path = $request->file('image')->store('events', 'public');
        $event->image = '/storage/' . $path; // Tambahkan prefix untuk akses URL
        $event->save();
    }

        // Redirect ke halaman event setelah update berhasil
        return redirect()->route('organizer.manageEvents')->with('success', 'Event updated successfully!');
    }

    public function manageTickets()
    {
    // Ambil user yang sedang login
    $user = Auth::user();

    // Ambil semua pemesanan tiket yang terkait dengan acara yang dikelola oleh user
    $bookings = Booking::with(['user', 'event'])
        ->whereHas('event', function ($query) use ($user) {
            $query->where('user_id', $user->id); // Filter berdasarkan event yang dikelola oleh organizer
        })
        ->latest() // Urutkan berdasarkan yang terbaru
        ->get();

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

    public function dashboardAdmin()
    {
        // Total events
        $totalEvents = Event::count();

        // Total tickets sold
        $totalTicketsSold = Booking::where('status', 'confirmed')->sum('quantity');

        // Total revenue
        $totalRevenue = Booking::where('status', 'confirmed')
            ->join('events', 'bookings.id_event', '=', 'events.id')
            ->sum(DB::raw('bookings.quantity * events.price'));

        // Upcoming events
        $upcomingEvents = Event::where('date', '>=', now())
            ->withCount(['bookings as tickets_sold' => function ($query) {
                $query->where('status', 'confirmed');
            }])
            ->withSum(['bookings as revenue' => function ($query) {
                $query->where('status', 'confirmed');
            }], DB::raw('bookings.quantity * events.price'))
            ->get();

        // Tickets sold per event
        $eventNames = Event::pluck('title');
        $eventTicketsSold = Event::withCount(['bookings as tickets_sold' => function ($query) {
            $query->where('status', 'confirmed');
        }])->pluck('tickets_sold');

        // Revenue per event
        $eventRevenues = Event::withSum(['bookings as revenue' => function ($query) {
            $query->where('status', 'confirmed');
        }], DB::raw('bookings.quantity * events.price'))->pluck('revenue');

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
}