<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ticketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\FiturController;
use App\Http\Controllers\PenukaranController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ADMIN
Route::post('admin/login',[AdminController::class,'login']);
Route::post('admin/register',[AdminController::class,'register']);
Route::middleware(['auth:sanctum','abilities:admin'])->group(function () {

    //TIKET
    Route::post('tiket',[ticketController::class,'store']);
    Route::put('tiket/{id}',[ticketController::class,'update']);
    Route::delete('tiket/{id}',[ticketController::class,'destroy']);

    //KATEGORI
    Route::resource('kategori', KategoriController::class)->except(
        ['create','edit','index','show']
    );

    // PEMBAYARAN
    Route::get('pembayarans',[PembayaranController::class,'index']);
    Route::get('pembayaran/{id}',[PembayaranController::class,'show']);
    Route::delete('pembayaran/{id}',[PembayaranController::class,'destroy']);

    // PESANAN
    Route::get('pesanan/status/1',[PesananController::class,'getStatusSudahBayar']);
    Route::get('pesanan/status/0',[PesananController::class,'getStatusBelumBayar']);

    //ACCOUNT
    Route::get('admins',[AdminController::class,'getAllAdmin']);
    Route::put('admin',[AdminController::class,'updateProfile'])->middleware(['auth:sanctum','abilities:admin']);
    Route::delete('admin',[AdminController::class,'deleteAccount'])->middleware(['auth:sanctum','abilities:admin']);
    Route::get('admin',[AdminController::class,'getAdmin'])->middleware(['auth:sanctum','abilities:admin']);
    Route::post('admin/logout',[AdminController::class,'logout'])->middleware(['auth:sanctum','abilities:admin']);

    //FITUR ADMIN
    Route::post('tiket/count',[FiturController::class,'count']);
    //USER
    Route::get('users',[UserController::class,'getAllUser']);
});




// USER
Route::post('user/login',[UserController::class,'login']);
Route::post('user/register',[UserController::class,'register']);
Route::middleware(['auth:sanctum','abilities:user'])->group(function () {

    //Pesanan
    Route::resource('pesanan', PesananController::class)->except(
        ['create','edit']
    );

    //Pembayaran
    Route::post('pembayaran',[PembayaranController::class,'store'])->middleware(['auth:sanctum','abilities:user']);
    Route::get('pembayaran/user',[PembayaranController::class,'getByUser'])->middleware(['auth:sanctum','abilities:user']);
    
    //ACCOUNT
    Route::put('user',[UserController::class,'updateProfile'])->middleware(['auth:sanctum','abilities:user']);
    Route::delete('user',[UserController::class,'deleteAccount'])->middleware(['auth:sanctum','abilities:user']);
    Route::get('user',[UserController::class,'getAdmin'])->middleware(['auth:sanctum','abilities:user']);
    Route::post('user/logout',[UserController::class,'logout'])->middleware(['auth:sanctum','abilities:user']);

    //TUKAR
    Route::resource('tukar', PenukaranController::class)->except(
        ['create','edit','update','delete']
    );

    //PENUKARAN
    Route::get('penukaran',[PenukaranController::class,'index']);
    Route::get('penukaran/{id}',[PenukaranController::class,'show']);
    Route::post('penukaran',[PenukaranController::class,'store']);
});

// PUBLIC
Route::get('tiket',[ticketController::class,'index']);
Route::get('tiket/{id}',[ticketController::class,'show']);
Route::get('kategori',[KategoriController::class,'index']);
Route::get('kategori/{id}',[KategoriController::class,'show']);


// FITUR
Route::get('fitur/tanggal/asc',[FiturController::class,'getByTanggalASC']);
Route::get('fitur/tanggal/desc',[FiturController::class,'getByTanggalDESC']);
Route::get('fitur/harga/asc',[FiturController::class,'getByHargaASC']);
Route::get('fitur/harga/desc',[FiturController::class,'getByHargaDESC']);
Route::post('fitur/lokasi',[FiturController::class,'getLokasi']);

Route::post('tiket/jumlah',[FiturController::class,'getJumlahPenjualan']);
