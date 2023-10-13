<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RankSalaryController;
use App\Http\Controllers\TimeSlotController;
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

Route::get('/', function () {
    return view('welcome');
});
//salary rank
Route::get('salary', [RankSalaryController::class, 'index'])->name('search_salary');
Route::match(['get','post'],'salary/add',[RankSalaryController::class,'create'])->name('salary.add');
Route::match(['get','post'],'salary/edit/{id}',[RankSalaryController::class,'update'])->name('salary.edit');
Route::get('salary/delete/{id}',[RankSalaryController::class,'delete'])->name('salary.delete');
//timeslot
Route::get('timeslot', [TimeSlotController::class, 'index'])->name('search_timeslot');
Route::match(['get','post'],'timelsot/add',[TimeSlotController::class,'create'])->name('timeslot.add');
Route::match(['get','post'],'timeslot/edit/{id}',[TimeSlotController::class,'update'])->name('timeslot.edit');
Route::get('timeslot/delete/{id}',[TimeSlotController::class,'delete'])->name('timeslot.delete');
//job
Route::get('job', [JobController::class, 'index'])->name('search_job');
Route::match(['get','post'], 'job/add',[JobController::class,'create'])->name('job.add');
Route::match(['get','post'],'job/edit/{id}',[JobController::class,'update'])->name('job.edit');
Route::get('job/delete/{id}',[JobController::class,'delete'])->name('job.delete');


