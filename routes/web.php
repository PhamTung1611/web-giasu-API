<?php

use App\Http\Controllers\ClassLevelController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\SubjectController;
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

Route::get('/',[Dashboard::class, 'index'])->name('dashboard');
//salary rank
Route::get('salary', [RankSalaryController::class, 'index'])->name('search_salary');
Route::match(['get','post'],'salary/add',[RankSalaryController::class,'add'])->name('salary.add');
Route::match(['get','post'],'salary/edit/{id}',[RankSalaryController::class,'update'])->name('salary.edit');
Route::get('salary/delete/{id}',[RankSalaryController::class,'delete'])->name('salary.delete');
//timeslot
Route::get('timeslot', [TimeSlotController::class, 'index'])->name('search_timeslot');
Route::match(['get','post'],'timelsot/add',[TimeSlotController::class,'add'])->name('timeslot.add');
Route::match(['get','post'],'timeslot/edit/{id}',[TimeSlotController::class,'update'])->name('timeslot.edit');
Route::get('timeslot/delete/{id}',[TimeSlotController::class,'delete'])->name('timeslot.delete');
//job
Route::get('job', [JobController::class, 'index'])->name('search_job');
Route::match(['get','post'], 'job/add',[JobController::class,'create'])->name('job.add');
Route::match(['get','post'],'job/edit/{id}',[JobController::class,'update'])->name('job.edit');
Route::get('job/delete/{id}',[JobController::class,'delete'])->name('job.delete');
//subject
Route::get('subject',[SubjectController::class,'index'])->name('search_subject');
Route::match(['get','post'],'subject/add',[SubjectController::class,'add'])->name('add_subject');
Route::match(['get','post'],'subject/edit/{id}',[SubjectController::class,'edit'])->name('edit_subject');
Route::get('subject/delete/{id}',[SubjectController::class,'delete'])->name('delete_subject');
//class
Route::get('classLevel',[ClassLevelController::class,'index'])->name('search_class');
Route::match(['get','post'],'classLevel/add',[ClassLevelController::class,'add'])->name('add_class');
Route::match(['get','post'],'classLevel/edit/{id}',[ClassLevelController::class,'edit'])->name('edit_class');
Route::get('classLevel/delete/{id}',[ClassLevelController::class,'delete'])->name('delete_class');
