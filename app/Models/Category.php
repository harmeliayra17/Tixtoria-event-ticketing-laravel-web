<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tabel terkait model ini (opsional jika sesuai konvensi)
    protected $table = 'categories';

    // Kolom yang dapat diisi
    protected $fillable = ['name'];

    // Relasi: Kategori memiliki banyak event
    public function events()
    {
        return $this->hasMany(Event::class, 'id_category');
    }

    
}
