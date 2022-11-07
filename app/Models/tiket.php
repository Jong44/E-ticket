<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tiket extends Model
{
    protected $fillable = [
        'nama_tiket','deskripsi','tanggal','lokasi'
    ];
}
