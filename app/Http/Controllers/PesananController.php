<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan;
use App\Models\User;
use App\Models\kategori;
use App\Models\detail;
use Auth;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesanan = pesanan::with('user','kategori')->get();
        return $pesanan;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kode = mt_rand(1000,9999);
        $getId = Auth::id();
        $table = pesanan::create([
            "id_user" => $getId,
            "id_kategori" => $request->id_kategori,
            "tanggal" => $request->tanggal,
            "kode" => $kode,
            "status" => 0
        ]);
        
        $kategori = kategori::where('id', $request->id_kategori)->first();
        if($kategori){
            $kategori->jumlah = ($kategori->jumlah - 1);
            $kategori->save();
        }

        return response()->json([
            'success' => 201,
            'message' => "Pesanan berhasil disimpan", 
            'data' => $table
        ],
          201  
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
