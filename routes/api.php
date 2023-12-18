<?php

use App\Http\Controllers\ApiClassLevelController;
use App\Http\Controllers\ApiSubjectController;
use App\Http\Controllers\ApiJobController;
use App\Http\Controllers\ApiRankSalaryController;
use App\Http\Controllers\ApiTimeSlotController;
use App\Http\Controllers\EducationLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\schoolsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\HistoryController;
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
    //user route

    Route::prefix('users')->group(function () {
        Route::post('/{id}', [UsersController::class, 'updateApi']);
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
});
Route::prefix('teachers')->group(function () {
    Route::get('/', [TeachersController::class, 'index']);
    Route::get('/{id}', [TeachersController::class, 'getDetailTeacher']);
    Route::get('/class/{id}', [TeachersController::class, 'getTeacherByClass']);
    Route::get('/subject/{id}', [ApiSubjectController::class, 'getTeacherBySubject']);
    Route::get('/district/{id}', [DistrictController::class, 'getTeacherByDistrict']);
    Route::get('/timeSlot/{id}', [ApiTimeSlotController::class, 'getTeacherByTimeSlot']);
    Route::get('/subjectAndClass/{id}', [TeachersController::class, 'getSubjectAndClass']);
});
Route::get('filter', [TeachersController::class, 'getTeacherByFilter']);
Route::get('teacherStar', [TeachersController::class, 'getTeacherByStar']);

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
    Route::put('/reset-password', [ResetPasswordController::class, 'reset']);
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
    Route::post('/', [FeedBackController::class, 'store']);
        Route::get('/{id}', [FeedBackController::class, 'show']);
        Route::get('/user/{id}', [FeedBackController::class, 'showUser']);
        Route::get('/avgPoint/{id}', [FeedBackController::class, 'averagePoint']);
    });
 Route::prefix('users')->group(function () {
        Route::get('status',[UsersController::class,'updatestatusSendMail']);
        Route::get('/', [UsersController::class, 'index']);
        Route::get('/{id}', [UsersController::class, 'show']);
    });
Route::post('contact',[ContactController::class,'store']);
Route::prefix('connect')->group(function () {
    // lấy ra danh sách
    Route::get('/{id}', [ConnectController::class, 'show']);
    Route::get('/top/{id}', [ConnectController::class, 'connectTop4Success']);
    Route::put('/{id}', [ConnectController::class, 'update']);

});
Route::prefix('job')->group(function () {
    // lấy ra danh sách
    Route::get('/', [ApiJobController::class, 'index']);
    //thêm
    Route::post('/', [ApiJobController::class, 'store']);
    //chi tiết
    Route::get('/{id}', [ApiJobController::class, 'show']);
    Route::get('/detail/{id}', [ApiJobController::class, 'showDetailJob']);
    //chỉnh sửa
    Route::put('/{id}', [ApiJobController::class, 'update']);
    //xóa
    Route::delete('/{id}', [ApiJobController::class, 'destroy']);
});
Route::prefix('feedback')->group(function () {
    // lấy ra danh sách
    Route::post('/', [FeedBackController::class, 'store']);

});
Route::post('filterDistrict',[UsersController::class,'filterTeacherByDistrict']);
Route::post('get-google-sign-in-url', [AuthController::class, 'getGoogleSignInUrl']);
Route::get('callback', [AuthController::class, 'loginCallback']);
//Route::post('ggregister',[AuthController::class,'getInfoGG']);
Route::prefix('history')->group(function () {
    // lấy ra danh sách
    Route::get('/{id}', [HistoryController::class, 'show']);

});
// Route::post('users/editpassword',[AuthController::class,'updatePassword']);
Route::post('add-info',[AuthController::class,'addInfo']);
Route::put('update-status-teacher/{id}',[UsersController::class,'updatestatus']);
Route::get('education-level',[EducationLevel::class,'index']);
Route::put('certificate-public/{id}',[UsersController::class,'certificate_public']);
Route::put('status-certificate/{id}',[UsersController::class,'status_certificate']);
Route::post('upload-certificate',[UsersController::class,'uploadCertificate']);
Route::post('userss/editpassword',[AuthController::class,'updatePassword']);
Route::put('delete-certificate/{id}',[UsersController::class,'delete_certificate']);