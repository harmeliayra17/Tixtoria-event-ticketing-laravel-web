<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'price',
        'quota',
        'id_category',
        'location_id',
        'image',  
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // Relasi dengan model Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_event');// Sesuaikan dengan nama model yang tepat
    }

    public function decrementQuota($quantity)
    {
        if ($this->quota < $quantity) {
            throw new \Exception('Kuota tidak cukup');
        }
        $this->decrement('quota', $quantity);
    }

    // Relasi dengan model Favorite
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'id_event');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}

