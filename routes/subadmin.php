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



    Route::get('log-out', [AuthController::class, 'adminLogout'])->name('subadmin.logout');
});


