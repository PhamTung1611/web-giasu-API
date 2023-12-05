<?php

use App\Http\Controllers\ClassLevelController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DashBoradController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RankSalaryController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use App\Models\Connect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/history-admin', [DashBoradController::class, 'listHistoryAdmin']);
Route::get('/feedback', [DashBoradController::class, 'feedbackTeacher']);
Route::get('feedback/{id}',[DashBoradController::class,'starTeacher'])->name('starTeacher');
Route::get('/rent', [DashBoradController::class, 'rent'])->name('rent');
Route::get('/rentID', [DashBoradController::class, 'rentID'])->name('rentID');


Route::match(['get', 'post'], '/login',[UsersController::class, 'signin'])->name('login');
Route::get('/logout',[UsersController::class, 'logout'])->name('logout');
Route::get('vnpay', [UsersController::class, 'showvnpay']);
Route::post('deposit', [UsersController::class, 'deposit']);
// Route::post('/login',[UsersController::class, 'signin'])->name('post-login');
Route::match(['get', 'post'], '/register',[UsersController::class, 'register'])->name('register');
Route::middleware('auth')->group(function() {
    Route::middleware('check.role')->group(function() {
    Route::get('/',[DashBoradController::class, 'Statistical'])->name('dashboard');
    Route::get('connect',[ConnectController::class, 'index'])->name('search_connect');

    Route::get('salary', [RankSalaryController::class, 'index']);
    Route::get('payment', [TransactionController::class, 'index'])->name('vnpay');
    Route::post('salary', [RankSalaryController::class, 'index'])->name('search_salary');
    Route::get('timeslot', [TimeSlotController::class, 'index']);
    Route::post('timeslot', [TimeSlotController::class, 'index'])->name('search_timeslot');
    Route::get('job', [JobController::class, 'index']);
    Route::post('job', [JobController::class, 'index'])->name('search_job');
    Route::get('subject',[SubjectController::class,'index']);
    Route::post('subject',[SubjectController::class,'index'])->name('search_subject');
    Route::get('classLevel',[ClassLevelController::class,'index']);
    Route::post('classLevel',[ClassLevelController::class,'index'])->name('search_class');
    Route::get('teacher',[TeachersController::class,'getAllTeacher']);
    Route::post('teacher',[TeachersController::class,'getAllTeacher'])->name('search_teacher');
    Route::post('user',[UsersController::class,'getAllUser'])->name('search_user');
    Route::get('user',[UsersController::class,'getAllUser']);
    Route::get('teacher/waiting',[UsersController::class,'getAllTeacher'])->name('waiting');
    Route::post('waiting_teacher',[UsersController::class,'agree'])->name('waiting_teacher');
    //salary rank
        Route::match(['get','post'],'salary/add',[RankSalaryController::class,'add'])->name('salary.add');
        Route::match(['get','post'],'salary/edit/{id}',[RankSalaryController::class,'update'])->name('salary.edit');
        Route::get('salary/delete/{id}',[RankSalaryController::class,'delete'])->name('salary.delete');
        //timeslot
        Route::match(['get','post'],'timelsot/add',[TimeSlotController::class,'add'])->name('timeslot.add');
        Route::match(['get','post'],'timeslot/edit/{id}',[TimeSlotController::class,'update'])->name('timeslot.edit');
        Route::get('timeslot/delete/{id}',[TimeSlotController::class,'delete'])->name('timeslot.delete');
        //job
        Route::match(['get','post'], 'job/add',[JobController::class,'create'])->name('job.add');
        Route::match(['get','post'],'job/edit/{id}',[JobController::class,'update'])->name('job.edit');
        Route::get('job/delete/{id}',[JobController::class,'delete'])->name('job.delete');
        //subject
        Route::match(['get','post'],'subject/add',[SubjectController::class,'add'])->name('add_subject');
        Route::match(['get','post'],'subject/edit/{id}',[SubjectController::class,'edit'])->name('edit_subject');
        Route::get('subject/delete/{id}',[SubjectController::class,'delete'])->name('delete_subject');
        Route::get('subject/{id}/teachers', [SubjectController::class, 'ListTeacher'])->name('subject.teachers');
        Route::get('class/{id}/teachers', [ClassLevelController::class, 'ListTeacher'])->name('class.teachers');
        Route::get('salary/{id}/teachers', [RankSalaryController::class, 'ListTeacher'])->name('salary.teachers');
        Route::get('timeslot/{id}/teachers', [TimeSlotController::class, 'ListTeacher'])->name('timeslot.teachers');
        Route::get('detail/{id}', [SubjectController::class, 'DetailTeacher'])->name('detail_teacher');
        //class
        Route::match(['get','post'],'classLevel/add',[ClassLevelController::class,'add'])->name('add_class');
        Route::match(['get','post'],'classLevel/edit/{id}',[ClassLevelController::class,'edit'])->name('edit_class');
        Route::get('classLevel/delete/{id}',[ClassLevelController::class,'delete'])->name('delete_class');
        //users
        Route::match(['get','post'],'user/addNew',[UsersController::class,'addNewUser'])->name('add_user');
        Route::match(['get','post'],'user/edit/{id}',[UsersController::class,'updateUser'])->name('edit_user');
        Route::get('user/delete/{id}',[UsersController::class,'delete'])->name('delete_user');
        //teachers
        Route::match(['get','post'],'teacher/addNew',[TeachersController::class,'addNewTeacher'])->name('add_teacher');
        Route::match(['get','post'],'teacher/edit/{id}',[TeachersController::class,'updateTeacher'])->name('edit_teacher');
        Route::get('teacher/delete/{id}/{view}',[TeachersController::class,'delete'])->name('delete_teacher');
        Route::get('detailTeacher/{id}',[UsersController::class,'getOneTeacherWaiting'])->name('deatailWaitingTeacher');

        Route::get('ctv',[UsersController::class,'getAllCtv'])->name('allctv');
    });
});
