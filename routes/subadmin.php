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
    Route::get('subadmin/student-search', [DashboardController::class, 'searchStudent'])->name('subadmin.student.search');

    Route::post('/students/assign-course', [DashboardController::class, 'courseAssignAdd'])->name('subadmin.course-assign.add');
    Route::put('/course-assign/edit/{id}', [DashboardController::class, 'courseAssignEdit'])->name('subadmin.course-assign.edit');
    Route::delete('/course-assign/delete/{id}', [DashboardController::class, 'courseAssignDelete'])->name('subadmin.course-assign.delete');
    Route::post('/course-assign/certificate/generate', [DashboardController::class, 'generateCertificate'])->name('subadmin.certificate.generate');
    Route::post('/course-assign/idcard/generate', [DashboardController::class, 'generateIdCard'])->name('subadmin.idcard.generate');

    Route::post('/course-assign/marks/store', [DashboardController::class, 'giveMarks'])->name('subadmin.marks.store');
    Route::get('/course-assign/marks/subjects/{course_id}', [DashboardController::class, 'getSubjects'])->name('subadmin.marks.subjects');
    Route::get('/course-assign/marks/get/{student}/{course}', [DashboardController::class, 'getStudentMarks'])->name('subadmin.marks.get');
    Route::get('/course-assign/marksheet/{student_id}/{course_id}/{year?}', [DashboardController::class, 'getMarksheet'])->name('subadmin.marksheet.get');

    // My Wallet=======================================================================================================>
    Route::get('/wallet', [DashboardController::class, 'myWallet'])->name('subadmin.wallet');
    Route::post('/wallet/topup', [DashboardController::class, 'topupRequest'])->name('subadmin.topup.request');





    // Affiliation Certificate
    Route::get('/affiliation-certificate', [DashboardController::class, 'showAffiliation'])->name('subadmin.affiliation.certificate');
    Route::get('/my-idcard', [DashboardController::class, 'showMyIdCard'])->name('subadmin.my_idcard');

    Route::get('log-out', [AuthController::class, 'adminLogout'])->name('subadmin.logout');
});
