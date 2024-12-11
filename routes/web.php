<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/upload-resume', [ResumeController::class, 'showForm'])->name('resume.form');
Route::post('/upload-resume', [ResumeController::class, 'uploadResume'])->name('resume.upload');
Route::get('/resume-text', [ResumeController::class, 'showText'])->name('resume.text');

