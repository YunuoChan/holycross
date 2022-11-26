<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolyearController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionSubjectController;
use App\Http\Controllers\GenerateScheduleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProfessorSubjectController;

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

    Route::get('/section/show/specific', [SectionController::class, 'showSpecific'])->name('section.show.specific');


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


    // STUDENT 
    Route::get('/student/get',              [StudentController::class, 'index'])->name('student');
    Route::get('/student/show',             [StudentController::class, 'show'])->name('student.show');
    Route::post('/student/save',            [StudentController::class, 'store'])->name('student.save');
    Route::post('/student/trash',           [StudentController::class, 'destroy'])->name('student.trash');
    Route::get('/student/edit',             [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/update',          [StudentController::class, 'update'])->name('student.update');


    // PROFESSOR 
    Route::get('/professor/get',              [ProfessorController::class, 'index'])->name('professor');
    Route::get('/professor/show',             [ProfessorController::class, 'show'])->name('professor.show');
    Route::post('/professor/save',            [ProfessorController::class, 'store'])->name('professor.save');
    Route::post('/professor/trash',           [ProfessorController::class, 'destroy'])->name('professor.trash');
    Route::get('/professor/edit',             [ProfessorController::class, 'edit'])->name('professor.edit');
    Route::post('/professor/update',          [ProfessorController::class, 'update'])->name('professor.update');


    // PROFESSOR SUBJECT
    Route::get('/professor/subject/get',              [ProfessorSubjectController::class, 'index'])->name('professor.subject');
    Route::get('/professor/subject/show',             [ProfessorSubjectController::class, 'show'])->name('professor.subject.show');
    Route::post('/professor/subject/save',            [ProfessorSubjectController::class, 'store'])->name('professor.subject.save');
    Route::post('/professor/subject/trash',           [ProfessorSubjectController::class, 'destroy'])->name('professor.subject.trash');
    Route::get('/professor/subject/edit',             [ProfessorSubjectController::class, 'edit'])->name('professor.subject.edit');
    Route::post('/professor/subject/update',          [ProfessorSubjectController::class, 'update'])->name('professor.subject.update');
    Route::get('/professor/subject/list',            [ProfessorSubjectController::class, 'showSubjectList'])->name('professor.subject.list');

});



Route::group(array('prefix' => '/student'), function () {
    Route::get('/schedule/get',              [StudentController::class, 'getSchedule'])->name('student.schedule');

});