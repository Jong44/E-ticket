<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket;
use App\Models\kategori;
use App\Models\pesanan;

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
        $tiket = tiket::with('kategori')->first();
        $tiket = $tiket->kategori()->with('tiket')->orderBy('harga','asc')->get();
        return $tiket;
    }

    public function getByHargaDESC()
    {
        $tiket = tiket::with('kategori')->first();
        $tiket = $tiket->kategori()->with('tiket')->orderBy('harga','desc')->get();
        return $tiket;
    }

    public function getLokasi(Request $request)
    {
        $lokasi = $request->lokasi;
        $tiket = tiket::where('lokasi', $lokasi)->with('kategori')->get();
        if($tiket->count() != 0){
            return response()->json([
                'status' => 201,
                'data' => $tiket
            ], 201);
        } else {
            return response()->json([
                'status' => 401,
                'message' => "Data tiket tidak ditemukan", 
            ], 401);
        }
    }

    public function count(Request $request)
    {
        $id_tiket = $request->id_tiket;
        $nama_tiket = $request->nama_tiket;
        $tiket = tiket::where('id', $id_tiket)->where('nama_tiket', $nama_tiket)->with('kategori','pesanan')->first();
        if($tiket){
            $tiket = $tiket->pesanan->where('status',1);
            $count = $tiket->count();
            return response()->json([
                'status' => 201,
                'jumlah_count' => $count,
                'data' => $tiket, 
            ], 201);;
        } else{
            return response()->json([
                'status' => 401,
                'message' => "Data tiket tidak ditemukan", 
            ], 401);
        } 
    }

    public function getJumlahPenjualan(Request $request)
    {
        $id_tiket = $request->id_tiket;
        $nama_tiket = $request->nama_tiket;
        $tiket = tiket::where('id', $id_tiket)->where('nama_tiket', $nama_tiket)->with('kategori','pesanan')->first();
        if($tiket){
            $tiket = $tiket->pesanan->where('status',1);
            $count = $tiket->kategori;
            return $tiket;
        } else{
            return response()->json([
                'status' => 401,
                'message' => "Data tiket tidak ditemukan", 
            ], 401);
        } 
    }

    




}
