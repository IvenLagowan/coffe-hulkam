<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelapor_id',
        'terlapor_id',
        'terlapor_cafe_id',
        'tipe',
        'kategori_laporan',
        'deskripsi',
        'status',
        'bukti',
    ];

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    public function terlapor()
    {
        return $this->belongsTo(User::class, 'terlapor_id');
    }

    public function cafe()
    {
        return $this->belongsTo(Cafe::class, 'terlapor_cafe_id');
    }
}
