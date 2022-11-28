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

    public function pesanan()
    {
        return $this->hasMany(pesanan::class, 'id_kategori', 'id');
    }

    public function kategori1()
    {
        return $this->belongsTo(kategori::class, 'id_kategori', 'id');
    }
}

