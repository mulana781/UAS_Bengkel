<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bengkel',
        'alamat',
        'telepon',
        'email',
        'deskripsi',
        'jam_operasional',
        'status'
    ];
}
