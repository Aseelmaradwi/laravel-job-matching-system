<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;


    // Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('create');
//shared Routes
Route::middleware(['auth','role:admin,company_owner'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('job-applications', JobApplicationController::class);
        Route::put('job-applications/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-applications.restore');
        Route::resource('job-vacancies', JobVacancyController::class);
        Route::put('job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');
});


//company Routes
Route::middleware(['auth','role:company_owner'])->group(function () {
Route::get('/my-company',[CompanyController::class,'show'])->name('my-company.show');
Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
Route::put('/my-company', [CompanyController::class, 'update']) ->name('my-company.update');
});

//admin Routes
Route::middleware(['auth','role:admin'])->group(function () {

    Route::resource('job-categories', JobCategoryController::class);
    Route::post('job-categories/{id}/restore',[JobCategoryController::class, 'restore'])->name('job-categories.restore');

    Route::resource('users', UserController::class);
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');



    Route::resource('companies', CompanyController::class);
    Route::post('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');

  });

require __DIR__.'/auth.php';