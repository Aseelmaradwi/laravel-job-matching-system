<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationsController;
use App\Http\Controllers\JobVacancyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-groq', [JobVacancyController::class, 'testGroqApi'])->name('test.groq');


Route::middleware('auth')->group(function () {
Route::get('/job-applications', [JobApplicationsController::class, 'index'])->name('job-applications.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get("/job/{id}", [JobVacancyController::class, 'show'])->name('job.show');
Route::get('/job/{id}/apply', [JobVacancyController::class, 'apply'])->name('job.apply');
Route::post('/job/{id}/apply', [JobVacancyController::class, 'processApplication'])->name('job.apply.store');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
