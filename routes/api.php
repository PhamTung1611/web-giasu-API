<?php

use App\Http\Controllers\ApiClassLevelController;
use App\Http\Controllers\ApiSubjectController;
use App\Http\Controllers\ApiJobController;
use App\Http\Controllers\ApiRankSalaryController;
use App\Http\Controllers\ApiTimeSlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\schoolsController;
use App\Http\Controllers\AuthController;
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
Route::prefix('users')->group(function(){
    Route::get('/', [UsersController::class, 'index']);
    Route::get('/{id}', [UsersController::class, 'show']);
    Route::post('/', [UsersController::class, 'store']);
    Route::put('/{id}', [UsersController::class, 'update']);
    Route::delete('/{id}', [UsersController::class, 'destroy']);
});
//route teacher

// route schools
Route::prefix('schools')->group(function(){
    Route::get('/', [schoolsController::class, 'index']);
    Route::get('/{id}', [schoolsController::class, 'show']);
    Route::post('/', [schoolsController::class, 'store']);
    Route::put('/{id}', [schoolsController::class, 'update']);
    Route::delete('/{id}', [schoolsController::class, 'destroy']);
});

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

Route::prefix('ranksalary')->group(function () {
    // lấy ra danh sách
    Route::get('/', [ApiRankSalaryController::class, 'index']);
    //thêm
    Route::post('/', [ApiRankSalaryController::class, 'store']);
    //chi tiết
    Route::get('/{id}', [ApiRankSalaryController::class, 'show']);
    //chỉnh sửa
    Route::put('/{id}', [ApiRankSalaryController::class, 'update']);
    //xóa
    Route::delete('/{id}', [ApiRankSalaryController::class, 'destroy']);
});
Route::prefix('timeslot')->group(function () {
    // lấy ra danh sách
    Route::get('/', [ApiTimeSlotController::class, 'index']);
    //thêm
    Route::post('/', [ApiTimeSlotController::class, 'store']);
    //chi tiết
    Route::get('/{id}', [ApiTimeSlotController::class, 'show']);
    //chỉnh sửa
    Route::put('/{id}', [ApiTimeSlotController::class, 'update']);
    //xóa
    Route::delete('/{id}', [ApiTimeSlotController::class, 'destroy']);
});
Route::prefix('job')->group(function () {
    // lấy ra danh sách
    Route::get('/', [ApiJobController::class, 'index']);
    //thêm
    Route::post('/', [ApiJobController::class, 'store']);
    //chi tiết
    Route::get('/{id}', [ApiJobController::class, 'show']);
    //chỉnh sửa
    Route::put('/{id}', [ApiJobController::class, 'update']);
    //xóa
    Route::delete('/{id}', [ApiJobController::class, 'destroy']);
});
Route::prefix('auth')->group(function(){
    Route::post('/login',[AuthController::class,'login']);
});
