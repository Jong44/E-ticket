<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\kategori;
use App\Models\pesanan;
use App\Models\User;

class detail extends Model
{
    protected $fillable = [
        'id_detail','id_user','id_pesanan','jumlah_tiket','jumlah_harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori', 'id');
    }

    public function pesanan()
    {
        return $this->belongsTo(pesanan::class, 'id_pesanan', 'id_pesanan');
    }

}
