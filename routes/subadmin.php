<?php

use App\Http\Controllers\subadmin\auth\AuthController;
use App\Http\Controllers\subadmin\dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('subadmin/login', [AuthController::class, 'showLogin'])->name('subadmin.showlogin');
Route::post('subadmin/login', [AuthController::class, 'login'])->name('subadmin.login');

Route::group(['prefix' => 'subadmin', 'middleware' => 'subadmin'], function () {


    // Dashboard======================================================================================================>
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('subadmin.dashboard');

    // Students=======================================================================================================>
    Route::get('/students', [DashboardController::class, 'studentsView'])->name('subadmin.students');
    Route::post('/students', [DashboardController::class, 'studentAdd'])->name('subadmin.students.add');
    Route::put('/students/edit/{id}', [DashboardController::class, 'studentEdit'])->name('subadmin.students.edit');
    Route::delete('/students/delete/{id}', [DashboardController::class, 'studentDelete'])->name('subadmin.students.delete');


    // Assaigned Courses===============================================================================================>
    Route::get('/course-assign', [DashboardController::class, 'courseAssignView'])->name('subadmin.course-assign');
    Route::post('/students/assign-course', [DashboardController::class, 'courseAssignAdd'])->name('subadmin.course-assign.add');
    Route::put('/course-assign/edit/{id}', [DashboardController::class, 'courseAssignEdit'])->name('subadmin.course-assign.edit');
    Route::delete('/course-assign/delete/{id}', [DashboardController::class, 'courseAssignDelete'])->name('subadmin.course-assign.delete');
    Route::post('/course-assign/certificate/generate', [DashboardController::class, 'generateCertificate'])->name('subadmin.certificate.generate');
    Route::post('/course-assign/idcard/generate', [DashboardController::class, 'generateIdCard'])->name('subadmin.idcard.generate');




    Route::get('log-out', [AuthController::class, 'adminLogout'])->name('subadmin.logout');
});
