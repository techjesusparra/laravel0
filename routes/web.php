<?php

use Illuminate\Support\Facades\Route;

// Controladores
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Prueba de UserController
Route::get('/usuario/testuser',[UserController::class,'testuser']);

// UserController
Route::post('/api/registrar',[UserController::class,'registrar']);
Route::post('/api/login',[UserController::class,'login']);
Route::put('/api/user/update',[UserController::class,'update']);
Route::post('/api/user/upload',[UserController::class,'upload'])->middleware(ApiAuthMiddleware::class);
Route::get('/api/user/avatar/{filename}',[UserController::class,'getImage']);
Route::get('/api/user/detail/{id}', [UserController::class,'detail']);
