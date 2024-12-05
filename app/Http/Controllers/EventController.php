<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Location;
use App\Models\Bookings;
use App\Http\Requests\CreateEventRequest;
use App\Services\EventService;
use Illuminate\Support\Facades\Storage;


class EventController extends Controller
{
    // Homepage: Show events with their first image
    public function index()
    {
        // Mengambil semua acara dengan gambar dari kolom 'image'
        $events = Event::all();
    
        // Menentukan gambar pertama untuk setiap acara
        foreach ($events as $event) {
            $event->first_image = $event->image;  // Gambar diambil dari kolom 'image'
        }
    
        // Menampilkan acara terbaru berdasarkan date
        $latestEvents = Event::orderBy('date', 'desc')->limit(8)->get();

        // Menambahkan properti first_image untuk setiap event
        foreach ($latestEvents as $event) {
            $event->first_image = $event->image;
        }
    
        // Menampilkan acara terpopuler berdasarkan jumlah booking
        $popularEvents = Event::select('events.*')
            ->addSelect([
                'bookings_count' => DB::table('bookings')
                    ->selectRaw('SUM(quantity)')
                    ->whereColumn('bookings.id_event', 'events.id')
                    ->limit(1),
            ])
            ->orderByDesc('bookings_count')
            ->limit(8)
            ->get();

        foreach ($popularEvents as $event) {
            $event->first_image = $event->image;
        }

        return view('homepage-guest', compact('events', 'latestEvents', 'popularEvents'));
    }

    // Show event details page
    public function show($id)
    {
        // Menampilkan event beserta kategorinya, lokasi, dan gambar
        $event = Event::with(['category', 'location'])->findOrFail($id);
        $event->first_image = $event->image; // Mengambil gambar dari kolom 'image'

        return view('eventDetails', compact('event'));
    }

    // Admin area: List all events
    public function adminIndex(Request $request)
    {
        // Mengambil semua kategori dan lokasi untuk filter
        $categories = Category::all();
        $locations = Location::all();
        
        // Menangkap query pencarian dan parameter filter
        $search = $request->get('search');
        $date = $request->get('date');
        $city = $request->get('location'); // Mendapatkan lokasi dari request
        $categoryId = $request->get('category'); // Mendapatkan kategori dari request
        
        // Query dasar untuk events
        $eventsQuery = Event::query();
        
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
        $events = $eventsQuery->orderBy('date', 'desc')->paginate(12); // Menggunakan paginate jika ingin tampilan halaman per halaman
        
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
        return view('admin.manageEvents', compact('events', 'categories', 'locations', 'title'));
    }    

    public function catalog(Request $request)
    {
        // Mengambil semua kategori dan lokasi untuk filter
        $categories = Category::all();
        $locations = Location::all();
        
        // Menangkap query pencarian dan parameter filter
        $search = $request->get('search');
        $date = $request->get('date');
        $city = $request->get('location'); // Mendapatkan lokasi dari request
        $categoryId = $request->get('category'); // Mendapatkan kategori dari request
        
        // Query dasar untuk events
        $eventsQuery = Event::query();
        
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
        
        // Mendapatkan hasil akhir dengan sorting berdasarkan tanggal terbaru
        $events = $eventsQuery->orderBy('date', 'desc')->get();
        
        // Menentukan judul halaman berdasarkan kondisi filter yang ada
        if ($search) {
            $title = "Search results for '$search'";
        } elseif ($date) {
            $title = "Events on $date";
        } elseif ($categoryId && $city) {
            $title = "Events in $city under $categories->find($categoryId)->name category";
        } elseif ($categoryId) {
            $category = $categories->find($categoryId);
            $title = "Events in " . $category->name . " category";
        } elseif ($city) {
            $title = "Events in $city";
        } else {
            $title = "All Events";
        }
    
        // Mengirimkan data ke view
        return view('eventCatalog', compact('events', 'categories', 'locations', 'title'));
    }
    
    //Tambah Event
    // private $eventService;

    // public function __construct(EventService $eventService)
    // {
    //     $this->eventService = $eventService;
    // }

    public function create()
    {
        // Fetch categories from the database
        $categories = Category::all();
    

        // Pass the categories to the view
        return view('admin.createEvent', compact('categories'));
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
    
        return redirect()->route('admin.manageEvents')->with('success', 'Event created successfully');
    }
    
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
    
        // Hapus gambar dari storage jika ada
        if ($event->image && Storage::exists('public/' . $event->image)) {
            Storage::delete('public/' . $event->image);
        }
    
        // Hapus event dari database
        $event->delete();
    
        return redirect()->route('admin.manageEvents')->with('success', 'Event deleted successfully!');
    }
    

    // Metode untuk menampilkan form edit event
    public function edit($id)
    {
        // Ambil data event berdasarkan ID
        $event = Event::findOrFail($id);
        $categories = Category::all(); // Assuming you have a Category model

        return view('admin.editEvent', compact('event', 'categories'));
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
        return redirect()->route('admin.manageEvents')->with('success', 'Event updated successfully!');
    }    

    // public function store(Request $request, EventService $eventService)
    // {
    //     // Validasi data
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'date' => 'required|date',
    //         'time' => 'required',
    //         'price' => 'required|numeric',
    //         'quota' => 'required|integer',
    //         'category' => 'required|integer',
    //         'location_name' => 'required|string',
    //         'city' => 'required|string',
    //         'province' => 'required|string',
    //         'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Hanya satu gambar
    //     ]);
    
    //     // Panggil EventService untuk menyimpan event
    //     $event = $eventService->createEvent($validated);
    
    //     // Jika ada gambar, simpan gambar ke tabel events
    //     if ($request->hasFile('image')) {
    //         $path = $request->file('image')->store('events', 'public');
    //         $event->image = $path;  // Simpan gambar di kolom 'image' pada tabel events
    //         $event->save();
    //     }

    //     // Redirect atau kirim respons
    //     if ($event) {
    //         return redirect()->route('admin.manageEvents')->with('success', 'Event created successfully!');
    //     } else {
    //         return redirect()->back()->with('error', 'Failed to create event. Please try again.');
    //     }
    // }

    // public function delete($id)
    // {
    //     $this->eventService->deleteEvent($id);

    //     return redirect()->route('admin.manageEvents')->with('success', 'Event has been deleted successfully.');
    // }

    
}
