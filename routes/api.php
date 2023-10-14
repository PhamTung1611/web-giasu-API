<?php

use App\Http\Controllers\ApiClassLevelController;
use App\Http\Controllers\ApiSubjectController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('TeacherSubject')->group(function () {
    // lấy ra danh sách
    Route::get('/', [TeacherSubjectController::class, 'index']);
    //thêm
    Route::post('/', [TeacherSubjectController::class, 'store']);
    //chi tiết
    Route::get('/{id}', [TeacherSubjectController::class, 'show']);
    //chỉnh sửa
    Route::put('/{id}', [TeacherSubjectController::class, 'update']);
    //xóa
    Route::delete('/{id}', [TeacherSubjectController::class, 'destroy']);
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

Route::prefix('TeacherClass')->group(function () {
    // lấy ra danh sách
    Route::get('/', [TeacherClassController::class, 'index']);
    //thêm
    Route::post('/', [TeacherClassController::class, 'store']);
    //chi tiết
    Route::get('/{id}', [TeacherClassController::class, 'show']);
    //chỉnh sửa
    Route::put('/{id}', [TeacherClassController::class, 'update']);
    //xóa
    Route::delete('/{id}', [TeacherClassController::class, 'destroy']);
});

Route::prefix('subject')->group( function () {
    Route::get('/', [ApiSubjectController::class, 'index']);
    Route::get('/{id}', [ApiSubjectController::class, 'show']);
    Route::post('/', [ApiSubjectController::class, 'store']);
    Route::put('/{id}', [ApiSubjectController::class, 'update']);
    Route::delete('/{id}', [ApiSubjectController::class, 'destroy']);
});
Route::prefix('class_levels')->group( function () {
    Route::get('/', [ApiClassLevelController::class, 'index']);
    Route::get('/{id}', [ApiClassLevelController::class, 'show']);
    Route::post('/', [ApiClassLevelController::class, 'store']);
    Route::put('/{id}', [ApiClassLevelController::class, 'update']);
    Route::delete('/{id}', [ApiClassLevelController::class, 'destroy']);
});
