<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\kategori;
use App\Models\tiket;

class pesanan extends Model
{
    protected $fillable = [
        'id_user','id_kategori','tanggal','jumlah','total_harga','status','status_tukar','kode_tukar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori', 'id');
    }

}
