<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket;
use App\Models\kategori;

class FiturController extends Controller
{
    public function getByTanggalASC()
    {
        $tiket = tiket::with('kategori')->orderBy('tanggal','asc')->get();
        return $tiket;
    }

    public function getByTanggalDESC()
    {
        $tiket = tiket::with('kategori')->orderBy('tanggal','desc')->get();
        return $tiket;
    }

    public function getByHargaASC()
    {
        $tiket = kategori::with('kategori','tiket')->orderBy('harga','asc')->get();
        return $tiket;
    }

    public function getByHargaDESC()
    {
        $tiket = kategori::with('kategori','tiket')->orderBy('harga','desc')->get();
        return $tiket;
    }

    public function getLokasi(Request $request)
    {
        $tiket = tiket::with('kategori')->query('lokasi','LIKE','%{$request}%')->get();
        return $tiket;
    }

    




}
