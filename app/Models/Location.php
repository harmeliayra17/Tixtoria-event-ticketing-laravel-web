<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Tabel terkait model ini (opsional jika sesuai konvensi)
    protected $table = 'locations';

    // Kolom yang dapat diisi
    protected $fillable = ['location_name', 'province', 'city'];

    // Relasi: Lokasi memiliki banyak event
    public function events()
    {
        return $this->hasMany(Event::class, 'location_id');
    }
}
