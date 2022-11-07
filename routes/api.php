<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ticketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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
        ['create','edit']
    );
    Route::get('admin/details',[AdminController::class,'getAdmin'])->middleware(['auth:sanctum','abilities:admin']);
    Route::post('admin/logout',[AdminController::class,'logout'])->middleware(['auth:sanctum','abilities:admin']);
});




// USER

Route::post('user/login',[UserController::class,'login']);
Route::post('user/register',[UserController::class,'register']);
Route::middleware(['auth:sanctum','abilities:user'])->group(function () {
    Route::resource('user/tiket', ticketController::class)->except(
        ['create','edit']
    );
    Route::get('user/details',[UserController::class,'getAdmin'])->middleware(['auth:sanctum','abilities:user']);
    Route::post('user/logout',[UserController::class,'logout'])->middleware(['auth:sanctum','abilities:user']);
});