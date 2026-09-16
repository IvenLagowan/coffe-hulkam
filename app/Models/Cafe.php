<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    use HasFactory;

    protected $table = 'cafe';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'vendor_id',
        'status',
        'alasan_ditolak',
        'nama',
        'titik_geo',
        'no_telp',
        'alamat',
        'deskripsi',
        'fasilitas',
        'galeri',
        'foto_profil',
        'jam_operasional',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
