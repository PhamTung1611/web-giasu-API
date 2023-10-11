<?php

use App\Http\Controllers\ClassLevelController;
use App\Http\Controllers\SubjectController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [SubjectController::class, 'dashboard'])->name('dashboard');
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