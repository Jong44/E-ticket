<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\kategori;

class tiket extends Model
{
    protected $fillable = [
        'nama_tiket','deskripsi','tanggal','lokasi'
    ];

    public function kategori()
    {
        return $this->hasMany(kategori::class, 'id_tiket', 'id');
    }
}
