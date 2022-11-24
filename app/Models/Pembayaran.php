<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\pesanan;

class Pembayaran extends Model
{
    protected $fillable = [
        'id_pesanan','metode_pembayaran','tanggal_pembayaran'
    ];

    public function pesanan()
    {
        return $this->belongsTo(pesanan::class, 'id_pesanan', 'id');
    }
    
}
