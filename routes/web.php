<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolyearController;
use App\Http\Controllers\SubjectController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(array('prefix' => '/admin'), function () {

    // SCHOOL YEAR
    Route::get('/schoolyear/get', [SchoolyearController::class, 'index'])->name('fetch-schoolyear');
    Route::post('/schoolyear/save', [SchoolyearController::class, 'create'])->name('save-schoolyear');
    Route::post('/schoolyear/trash', [SchoolyearController::class, 'update'])->name('trash-schoolyear');


    // PROFESSOR
    Route::get('/subject/get', [SubjectController::class, 'index'])->name('subject');
    Route::get('/subject/show', [SubjectController::class, 'show'])->name('subject.show');
    Route::post('/subject/save', [SubjectController::class, 'store'])->name('subject.save');
    Route::post('/subject/trash', [SubjectController::class, 'destroy'])->name('subject.trash');
    Route::get('/subject/edit', [SubjectController::class, 'edit'])->name('subject.edit');

});