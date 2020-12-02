<?php

use App\Http\Controllers\API\ApiCursoController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/cursos', [App\Http\Controllers\HomeController::class, 'courses'])->name('courses');
Route::get('/administrar/cursos', [App\Http\Controllers\HomeController::class, 'manageCourses'])->name('manage-courses')->middleware('auth', 'admin');;
Route::get('/administrar/categorias', [App\Http\Controllers\HomeController::class, 'manageCategories'])->name('manage-categories')->middleware('auth', 'admin');;
Route::get('/administrar/usuarios', [App\Http\Controllers\HomeController::class, 'manageUsers'])->name('manage-users')->middleware('auth', 'admin');;

Auth::routes();

Route::apiResource('api/cursos', ApiCursoController::class);