<?php

use App\Http\Controllers\ApiJobController;
use App\Http\Controllers\ApiRankSalaryController;
use App\Http\Controllers\ApiTimeSlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherClassController;
use App\Http\Controllers\TeacherSubjectController;

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