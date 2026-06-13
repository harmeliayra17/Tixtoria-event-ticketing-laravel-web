<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Location;

class EventService
{
    public function createEvent(array $data)
    {
        $event = Event::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'date' => $data['date'],
            'time' => $data['time'],
            'price' => $data['price'],
            'quota' => $data['quota'],
            'id_category' => $data['category'],
        ]);

        $location = new Location([
            'location_name' => $data['location_name'],
            'city' => $data['city'],
            'province' => $data['province'],
        ]);
        $event->location()->save($location);

        if (isset($data['image'])) {
            $path = $data['image']->store('events', 'public');
            $event->image = $path;
            $event->save();
        }

        return $event;
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);

        if ($event->image && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));
        }

        $event->delete();

        return true;
    }
}
