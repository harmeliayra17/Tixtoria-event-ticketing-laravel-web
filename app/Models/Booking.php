<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_event',
        'quantity',
        'total_price',
        'payment_method',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }
    
}
