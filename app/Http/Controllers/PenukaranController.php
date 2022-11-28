<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pesanan;
use App\Models\Tukar;

class PenukaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tukar = tukar::with('pesanan')->get();
        return $tukar;
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
        $kode = $request->kode;
        $pesanan = pesanan::where('kode', $kode)->with('kategori')->first();
        if($pesanan){
            $date = date('Y-m-d'); 
            $pesanan->status_tukar = 1;
            $pesanan->save();
            $table = pesanan::create([
                "id_pesanan" => $request->id_pesanan,
                "tanggal_tukar" => $date
            ]);
            return response()->json([
                'status' => 201,
                'message' => 'Tiket Berhasil Ditukar',
                'data' => $pesanan
            ], 201);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data pesanan tidak ditemukan '
            ], 404);    
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penukaran = penukaran::where('id', $id)->first();
        if ($pembayaran){
            return response()->json([
                'status' => 200,
                'data' => $pembayaran
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'data' => 'Data tiket dengan id ' . $id . ' tidak ditemukan '
            ], 404);
        }
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
