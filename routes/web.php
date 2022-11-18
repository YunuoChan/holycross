<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolyearController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionSubjectController;
use App\Http\Controllers\GenerateScheduleController;
use App\Http\Controllers\CourseController;
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


    // SUBJECT
    Route::get('/subject/get', [SubjectController::class, 'index'])->name('subject');
    Route::get('/subject/show', [SubjectController::class, 'show'])->name('subject.show');
    Route::post('/subject/save', [SubjectController::class, 'store'])->name('subject.save');
    Route::post('/subject/trash', [SubjectController::class, 'destroy'])->name('subject.trash');
    Route::get('/subject/edit', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::post('/subject/update', [SubjectController::class, 'update'])->name('subject.update');


    // SECTION
    Route::get('/section/get', [SectionController::class, 'index'])->name('section');
    Route::get('/section/show', [SectionController::class, 'show'])->name('section.show');
    Route::post('/section/save', [SectionController::class, 'store'])->name('section.save');
    Route::post('/section/trash', [SectionController::class, 'destroy'])->name('section.trash');
    Route::get('/section/edit', [SectionController::class, 'edit'])->name('section.edit');
    Route::post('/section/update', [SectionController::class, 'update'])->name('section.update');


    // SECTION SUBJECT
    Route::get('/section/subject/get',              [SectionSubjectController::class, 'index'])->name('section.subject');
    Route::get('/section/subject/show',             [SectionSubjectController::class, 'show'])->name('section.subject.show');
    Route::get('/section/subject/get/sectiondata',  [SectionSubjectController::class, 'sectionData'])->name('section.subject.sectiondata');
    Route::post('/section/subject/update',          [SectionSubjectController::class, 'update'])->name('section.subject.update');
    Route::post('/section/subject/destroy',         [SectionSubjectController::class, 'destroy'])->name('section.subject.destroy');

    // COURSE
    Route::get('/course/get',                       [CourseController::class, 'show'])->name('course');

    
    // GENERATE SCHEDULE
    Route::get('/schedule/generate/get',              [GenerateScheduleController::class, 'index'])->name('generate.schedule');
    Route::get('/schedule/generate/show',             [GenerateScheduleController::class, 'show'])->name('generate.schedule.show');
    Route::get('/schedule/generate/data',        [GenerateScheduleController::class, 'generateSched'])->name('generate.schedule.data');
    Route::get('/schedule/generate/gets',        [GenerateScheduleController::class, 'get'])->name('generate.schedule.get');
    Route::post('/schedule/generate/save',           [GenerateScheduleController::class, 'store'])->name('generate.schedule.save');
});