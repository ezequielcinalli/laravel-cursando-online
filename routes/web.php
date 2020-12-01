<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/cursos', [App\Http\Controllers\HomeController::class, 'index'])->name('courses');

Auth::routes();