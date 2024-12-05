<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_event'];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Define the relationship with the Event model
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event');
    }
}
