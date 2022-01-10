<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = "notes";

    protected $fillable = [
        'judul', 'gambar', 'slug', 'konten', 'penulis'
    ];

    public function creators()
    {
        return $this->belongsTo(User::class, 'penulis');
    }
}
