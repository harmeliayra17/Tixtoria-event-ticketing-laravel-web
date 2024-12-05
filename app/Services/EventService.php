<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Location;

class EventService
{
    public function createEvent(array $data)
    {
        // Membuat event baru
        $event = Event::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'date' => $data['date'],
            'time' => $data['time'],
            'price' => $data['price'],
            'quota' => $data['quota'],
            'id_category' => $data['category'],
        ]);
    
        // Membuat lokasi untuk event
        $location = new Location([
            'location_name' => $data['location_name'],
            'city' => $data['city'],
            'province' => $data['province'],
        ]);
        $event->location()->save($location);
    
        // Mengupload gambar jika ada
        if (isset($data['image'])) {
            $path = $data['image']->store('events', 'public');  // Menyimpan gambar ke folder 'events'
            $event->image = $path;  // Menyimpan path gambar di kolom 'image' pada tabel 'events'
            $event->save();
        }
    
        return $event;
    }

    public function deleteEvent($id)
    {
        // Temukan event berdasarkan ID
        $event = Event::findOrFail($id);

        // Hapus gambar yang terkait dengan event
        if ($event->image && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));  // Menghapus file gambar dari server
        }

        // Hapus event dari database
        $event->delete();

        return true;
    }
}
