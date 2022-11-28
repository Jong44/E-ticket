<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\pesanan;


class Tukar extends Model
{
    protected $fillable = [
        'id_pesanan','tanggal_tukar'
    ];

    public function pesanan()
    {
        return $this->belongsTo(pesanan::class, 'id_pesanan', 'id');
    }
}
