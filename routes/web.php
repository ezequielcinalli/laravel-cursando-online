<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\ApiCursoController;
use App\Http\Controllers\API\ApiUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index']);
Route::get('/inicio', [HomeController::class, 'index'])->name('home');
Route::get('/cursos', [HomeController::class, 'courses'])->name('courses');
Route::get('/administrar/cursos', [HomeController::class, 'manageCourses'])->name('manage-courses')->middleware('auth', 'admin');;
Route::get('/administrar/categorias', [HomeController::class, 'manageCategories'])->name('manage-categories')->middleware('auth', 'admin');;
Route::get('/administrar/usuarios', [HomeController::class, 'manageUsers'])->name('manage-users')->middleware('auth', 'admin');;

Auth::routes();

Route::apiResource('api/cursos', ApiCursoController::class);
Route::apiResource('api/users', ApiUserController::class);
Route::put('api/users/setAdmin/{id}', [ApiUserController::class, 'setAdmin']);
Route::put('api/users/unsetAdmin/{id}', [ApiUserController::class, 'unsetAdmin']);