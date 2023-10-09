<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\schoolsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//user route
Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/{id}', [UsersController::class, 'show']);
Route::post('/users', [UsersController::class, 'store']);
Route::put('/users/{id}', [UsersController::class, 'update']);
Route::delete('/users/{id}', [UsersController::class, 'destroy']);
//route teacher
Route::get('/teachers', [TeachersController::class, 'index']);
Route::get('/teachers/{id}', [TeachersController::class, 'show']);
Route::post('/teachers', [TeachersController::class, 'store']);
Route::put('/teachers/{id}', [TeachersController::class, 'update']);
Route::delete('/teachers/{id}', [TeachersController::class, 'destroy']);
// route schools
Route::get('/schools', [schoolsController::class, 'index']);
Route::get('/schools/{id}', [schoolsController::class, 'show']);
Route::post('/schools', [schoolsController::class, 'store']);
Route::put('/schools/{id}', [schoolsController::class, 'update']);
Route::delete('/schools/{id}', [schoolsController::class, 'destroy']);
