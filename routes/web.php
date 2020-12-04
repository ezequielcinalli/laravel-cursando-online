<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\API\ApiCourseController;
use App\Http\Controllers\API\ApiUserController;
use App\Http\Controllers\API\ApiCategoryController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/inicio', [HomeController::class, 'index'])->name('home');
Route::get('/cursos', [HomeController::class, 'courses'])->name('courses');
Route::get('/administrar/cursos', [HomeController::class, 'manageCourses'])->name('manage-courses')->middleware('auth', 'admin');;
Route::get('/administrar/categorias', [HomeController::class, 'manageCategories'])->name('manage-categories')->middleware('auth', 'admin');;
Route::get('/administrar/usuarios', [HomeController::class, 'manageUsers'])->name('manage-users')->middleware('auth', 'admin');;

Auth::routes();

Route::apiResources([
    'api/courses' => ApiCourseController::class,
    'api/users' => ApiUserController::class,
    'api/categories' => ApiCategoryController::class,
]);

//  API/USERS
Route::put('api/users/setAdmin/{id}', [ApiUserController::class, 'setAdmin']);
Route::put('api/users/unsetAdmin/{id}', [ApiUserController::class, 'unsetAdmin']);