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
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TransactionController;

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
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('TeacherSubject')->group(function () {
        // lấy ra danh sách

        //thêm
        Route::post('/', [TeacherSubjectController::class, 'store']);
        //chi tiết

        //chỉnh sửa
        Route::put('/{id}', [TeacherSubjectController::class, 'update']);
        //xóa
        Route::delete('/{id}', [TeacherSubjectController::class, 'destroy']);
    });
    //user route
    Route::prefix('users')->group(function () {



        Route::put('/{id}', [UsersController::class, 'updateApi']);
        Route::delete('/{id}', [UsersController::class, 'destroy']);
    });

    //route teacher
    Route::prefix('teachers')->group(function () {
        Route::put('/{id}', [TeachersController::class, 'update']);
        Route::delete('/{id}', [TeachersController::class, 'destroy']);
    });
    // route schools
    Route::prefix('schools')->group(function () {

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

    Route::prefix('subject')->group(function () {

        Route::post('/', [ApiSubjectController::class, 'store']);
        Route::put('/{id}', [ApiSubjectController::class, 'update']);
        Route::delete('/{id}', [ApiSubjectController::class, 'destroy']);
    });
    Route::prefix('class_levels')->group(function () {
        Route::post('/', [ApiClassLevelController::class, 'store']);
        Route::put('/{id}', [ApiClassLevelController::class, 'update']);
        Route::delete('/{id}', [ApiClassLevelController::class, 'destroy']);
    });

    Route::prefix('ranksalary')->group(function () {
        // lấy ra danh sách

        Route::post('/', [ApiRankSalaryController::class, 'store']);
        //chi tiết

        Route::put('/{id}', [ApiRankSalaryController::class, 'update']);
        //xóa
        Route::delete('/{id}', [ApiRankSalaryController::class, 'destroy']);
    });
    Route::prefix('timeslot')->group(function () {
        // lấy ra danh sách

        //thêm
        Route::post('/', [ApiTimeSlotController::class, 'store']);
        //chi tiết

        //chỉnh sửa
        Route::put('/{id}', [ApiTimeSlotController::class, 'update']);
        //xóa
        Route::delete('/{id}', [ApiTimeSlotController::class, 'destroy']);
    });



    // Route::get('filter', [TeachersController::class,'getTeacherByFilter']);


});
Route::prefix('teachers')->group(function () {
    Route::get('/', [TeachersController::class, 'index']);
    Route::get('/{id}', [TeachersController::class, 'getDetailTeacher']);
    Route::get('/class/{id}', [TeachersController::class, 'getTeacherByClass']);
    Route::get('/subject/{id}', [ApiSubjectController::class, 'getTeacherBySubject']);
    Route::get('/district/{id}', [DistrictController::class, 'getTeacherByDistrict']);
    Route::get('/timeSlot/{id}', [ApiTimeSlotController::class, 'getTeacherByTimeSlot']);
});
Route::get('filter', [TeachersController::class, 'getTeacherByFilter']);
Route::prefix('ranksalary')->group(function () {
    // lấy ra danh sách
    Route::get('/', [ApiRankSalaryController::class, 'index']);
    Route::get('/{id}', [ApiRankSalaryController::class, 'show']);
    //chỉnh sửa
});
Route::prefix('subject')->group(function () {
    Route::get('/', [ApiSubjectController::class, 'index']);
    Route::get('/{id}', [ApiSubjectController::class, 'show']);
});
Route::prefix('class_levels')->group(function () {
    Route::get('/', [ApiClassLevelController::class, 'index']);
    Route::get('/{id}', [ApiClassLevelController::class, 'show']);
});
Route::prefix('district')->group(function () {
    // lấy ra danh sách
    Route::get('/', [DistrictController::class, 'index']);
});
Route::post('/register', [UsersController::class, 'store']);
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'RefreshToken']);
    Route::post('/reset-password', [ResetPasswordController::class, 'sendMail']);
    Route::put('/reset-password/{token}', [ResetPasswordController::class, 'reset']);
});
Route::prefix('timeslot')->group(function () {
    // lấy ra danh sách
    Route::get('/', [ApiTimeSlotController::class, 'index']);

    Route::get('/{id}', [ApiTimeSlotController::class, 'show']);
    //chỉnh sửa

});
Route::prefix('schools')->group(function () {
    Route::get('/', [schoolsController::class, 'index']);
    Route::get('/{id}', [schoolsController::class, 'show']);
});
//nap tien
Route::prefix('vnpay')->group(function () {
    Route::post('/deposit', [UsersController::class, 'deposit']);
    // Route::post('/saveDeposit',[UsersController::class,'depositInsertDatabase']);
    Route::post('/', [TransactionController::class, 'store']);
    Route::get('/{id}', [TransactionController::class, 'show']);
});
Route::prefix('feedback')->group(function () {
        // lấy ra danh sách

        Route::get('/{id}', [FeedBackController::class, 'show']);
        Route::get('/avgPoint/{id}', [FeedBackController::class, 'averagePoint']);
    });
 Route::prefix('users')->group(function () {

        Route::get('/', [UsersController::class, 'index']);
        Route::get('/{id}', [UsersController::class, 'show']);
    });
//transaction
Route::post('contact',[ContactController::class,'store']);
Route::post('test',function(Request $request){
    $certificates = [];
    if ($request->has('Certificate')) {

            foreach ($request->file('Certificate') as $file) {
                    $certificates[] = 'http://127.0.0.1:8000/storage/' . uploadFile('hinh', $file);
            }
           $certificate = json_encode($certificates); // Lưu đường dẫn của các ảnh trong một mảng JSON
    } else {
        $Certificate = null;
    }
$district =$request->district;
    $data=[$certificates,$district];
    return $data;
});
Route::prefix('feedback')->group(function () {
    // lấy ra danh sách
    Route::post('/', [FeedBackController::class, 'store']);

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
