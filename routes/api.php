<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ticketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ADMIN
Route::post('admin/login',[AdminController::class,'login']);
Route::post('admin/register',[AdminController::class,'register']);
Route::middleware(['auth:sanctum','abilities:admin'])->group(function () {
    Route::resource('admin/tiket', ticketController::class)->except(
        ['create','edit','index','show']
    );
    Route::resource('admin/kategori', KategoriController::class)->except(
        ['create','edit','index','show']
    );
    Route::get('admin',[AdminController::class,'getAllAdmin']);
    Route::get('admin/details',[AdminController::class,'getAdmin'])->middleware(['auth:sanctum','abilities:admin']);
    Route::post('admin/logout',[AdminController::class,'logout'])->middleware(['auth:sanctum','abilities:admin']);
});




// USER
Route::post('user/login',[UserController::class,'login']);
Route::post('user/register',[UserController::class,'register']);
Route::middleware(['auth:sanctum','abilities:user'])->group(function () {
    Route::resource('user/pesanan', PesananController::class)->except(
        ['create','edit']
    );
    Route::get('detail',[KategoriController::class,'index']);
    Route::get('user',[UserController::class,'getAllUser']);
    Route::get('user/details',[UserController::class,'getAdmin'])->middleware(['auth:sanctum','abilities:user']);
    Route::post('user/logout',[UserController::class,'logout'])->middleware(['auth:sanctum','abilities:user']);
});

// PUBLIC
Route::get('tiket',[ticketController::class,'index']);
Route::get('tiket/{id}',[ticketController::class,'show']);
Route::get('kategori',[KategoriController::class,'index']);
Route::get('kategori/{id}',[KategoriController::class,'show']);
Route::get('detail',[DetailController::class,'index']);