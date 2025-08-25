<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use L5Swagger\Http\Controllers\SwaggerController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/keluar', [LoginController::class, 'logout'])->name('keluar');
