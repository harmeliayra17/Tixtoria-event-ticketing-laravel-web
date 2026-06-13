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
    public function index()
    {
        $events = Event::all();
    
        foreach ($events as $event) {
            $event->first_image = $event->image;
        }
    
        $latestEvents = Event::orderBy('date', 'desc')->limit(8)->get();

        foreach ($latestEvents as $event) {
            $event->first_image = $event->image;
        }
    
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

    public function show($id)
    {
        $event = Event::with(['category', 'location'])->findOrFail($id);
        $event->first_image = $event->image;

        return view('eventDetails', compact('event'));
    }

    public function adminIndex(Request $request)
    {
        $categories = Category::all();
        $locations = Location::all();
        
        $search = $request->get('search');
        $date = $request->get('date');
        $city = $request->get('location');
        $categoryId = $request->get('category');
        
        $eventsQuery = Event::query();
        
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
    
        return view('admin.manageEvents', compact('events', 'categories', 'locations', 'title'));
    }    

    public function catalog(Request $request)
    {
        $categories = Category::all();
        $locations = Location::all();
        
        $search = $request->get('search');
        $date = $request->get('date');
        $city = $request->get('location');
        $categoryId = $request->get('category');
        
        $eventsQuery = Event::query();
        
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
        
        $events = $eventsQuery->orderBy('date', 'desc')->get();
        
        if ($search) {
            $title = "Search results for '$search'";
        } elseif ($date) {
            $title = "Events on $date";
        } elseif ($categoryId && $city) {
            $category = $categories->find($categoryId);
            $title = "Events in $city under " . ($category ? $category->name : '') . " category";
        } elseif ($categoryId) {
            $category = $categories->find($categoryId);
            $title = "Events in " . $category->name . " category";
        } elseif ($city) {
            $title = "Events in $city";
        } else {
            $title = "All Events";
        }
    
        return view('eventCatalog', compact('events', 'categories', 'locations', 'title'));
    }
    
    public function create()
    {
        $categories = Category::all();
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
        ]);
    
        if ($request->hasFile('image')) {
            if ($event->image && Storage::exists(str_replace('/storage/', '', $event->image))) {
                Storage::delete(str_replace('/storage/', '', $event->image));
            }

            $path = $request->file('image')->store('events', 'public');
            $event->image = '/storage/' . $path;
            $event->save();
        }
    
        return redirect()->route('admin.manageEvents')->with('success', 'Event created successfully');
    }
    
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
    
        if ($event->image && Storage::exists('public/' . $event->image)) {
            Storage::delete('public/' . $event->image);
        }
    
        $event->delete();
    
        return redirect()->route('admin.manageEvents')->with('success', 'Event deleted successfully!');
    }
    
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all();
        return view('admin.editEvent', compact('event', 'categories'));
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

        return redirect()->route('admin.manageEvents')->with('success', 'Event updated successfully!');
    }
}
