<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Public Job Postings
Route::get('/jobs', [App\Http\Controllers\PublicJobPostingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [App\Http\Controllers\PublicJobPostingController::class, 'show'])->name('jobs.show');

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/register', [LoginController::class, 'storeRegister'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('role:admin');

    // Department Routes
    Route::middleware('role:admin,hr')->group(function () {
        Route::get('/department', [App\Http\Controllers\DepartmentController::class, 'index'])->name('department.index');
    });
    Route::middleware('role:admin')->group(function () {
        Route::get('/department/create', [App\Http\Controllers\DepartmentController::class, 'create'])->name('department.create');
        Route::post('/department', [App\Http\Controllers\DepartmentController::class, 'store'])->name('department.store');
        Route::get('/department/{department}/edit', [App\Http\Controllers\DepartmentController::class, 'edit'])->name('department.edit');
        Route::put('/department/{department}', [App\Http\Controllers\DepartmentController::class, 'update'])->name('department.update');
        Route::delete('/department/{department}', [App\Http\Controllers\DepartmentController::class, 'destroy'])->name('department.destroy');
    });

    // HR Job Posting Routes
    Route::middleware('role:hr')->group(function () {
        Route::get('/hr/jobs', [App\Http\Controllers\HrJobPostingController::class, 'index'])->name('hr.jobs.index');
        Route::get('/hr/jobs/create', [App\Http\Controllers\HrJobPostingController::class, 'create'])->name('hr.jobs.create');
        Route::post('/hr/jobs', [App\Http\Controllers\HrJobPostingController::class, 'store'])->name('hr.jobs.store');
        Route::get('/hr/jobs/{job}/edit', [App\Http\Controllers\HrJobPostingController::class, 'edit'])->name('hr.jobs.edit');
        Route::put('/hr/jobs/{job}', [App\Http\Controllers\HrJobPostingController::class, 'update'])->name('hr.jobs.update');
        Route::patch('/hr/jobs/{job}/submit', [App\Http\Controllers\HrJobPostingController::class, 'submit'])->name('hr.jobs.submit');
        Route::patch('/hr/jobs/{job}/close', [App\Http\Controllers\HrJobPostingController::class, 'close'])->name('hr.jobs.close');
        
        // HR Applicant Management Routes
        Route::get('/hr/applicants', [App\Http\Controllers\HrApplicantController::class, 'index'])->name('hr.applicants.index');
        Route::get('/hr/applicants/{job}', [App\Http\Controllers\HrApplicantController::class, 'show'])->name('hr.applicants.show');
        Route::patch('/hr/applications/{application}/status', [App\Http\Controllers\HrApplicantController::class, 'updateStatus'])->name('hr.applications.status.update');
    });

    // Admin Job Posting Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/jobs', [App\Http\Controllers\AdminJobPostingController::class, 'index'])->name('admin.jobs.index');
        Route::get('/admin/jobs/{job}', [App\Http\Controllers\AdminJobPostingController::class, 'show'])->name('admin.jobs.show');
        Route::patch('/admin/jobs/{job}/approve', [App\Http\Controllers\AdminJobPostingController::class, 'approve'])->name('admin.jobs.approve');
        Route::patch('/admin/jobs/{job}/reject', [App\Http\Controllers\AdminJobPostingController::class, 'reject'])->name('admin.jobs.reject');
    });

    // Logs Route (Admin & HR)
    Route::middleware('role:admin,hr')->group(function () {
        Route::get('/logs', [App\Http\Controllers\StatusLogController::class, 'index'])->name('logs.index');
    });

    // Pelamar Routes
    Route::middleware('role:pelamar')->group(function () {
        Route::get('/applicant/profile', [App\Http\Controllers\ApplicantProfileController::class, 'edit'])->name('applicant.profile.edit');
        Route::put('/applicant/profile', [App\Http\Controllers\ApplicantProfileController::class, 'update'])->name('applicant.profile.update');
        
        Route::middleware(App\Http\Middleware\EnsureProfileCompleted::class)->group(function () {
            Route::get('/applicant/applications', [App\Http\Controllers\ApplicationController::class, 'index'])->name('applicant.applications.index');
            Route::post('/jobs/{job}/apply', [App\Http\Controllers\ApplicationController::class, 'store'])->name('jobs.apply');
        });
    });

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');
});
