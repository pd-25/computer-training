<?php

use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\ClientController;
use App\Http\Controllers\admin\dashboard\DashboardController;
use App\Http\Controllers\admin\DisputeLetterController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.showlogin');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {


    // Dashboard======================================================================================================>
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');


    // Category=======================================================================================================>
    Route::get('/categories', [DashboardController::class, 'categoryView'])->name('admin.categories');
    Route::post('/categories', [DashboardController::class, 'categoryAdd'])->name('admin.categories.add');
    Route::put('/categories/edit/{id}', [DashboardController::class, 'categoryEdit'])->name('admin.categories.edit');
    Route::delete('/categories/delete/{id}', [DashboardController::class, 'categoryDelete'])->name('admin.categories.delete');


    // Course=======================================================================================================>
    Route::get('/courses', [DashboardController::class, 'courseView'])->name('admin.courses');
    Route::post('/courses', [DashboardController::class, 'courseAdd'])->name('admin.courses.add');
    Route::put('/courses/edit/{id}', [DashboardController::class, 'courseEdit'])->name('admin.courses.edit');
    Route::delete('/courses/delete/{id}', [DashboardController::class, 'courseDelete'])->name('admin.courses.delete');


    // Sub Admins=======================================================================================================>
    Route::get('/subadmins', [DashboardController::class, 'subadminView'])->name('admin.subadmins');
    Route::post('/subadmins', [DashboardController::class, 'addSubAdmin'])->name('admin.subadmins.add');
    Route::put('/subadmins/edit/{id}', [DashboardController::class, 'editSubAdmin'])->name('admin.subadmins.edit');
    Route::delete('/subadmins/delete/{id}', [DashboardController::class, 'deleteSubAdmin'])->name('admin.subadmins.delete');

    // Auth
    Route::get('/subadmins/login-as/{id}', [DashboardController::class, 'loginAsSubAdmin'])->name('admin.subadmins.loginAs');
    Route::get('/subadmins/return-admin', [DashboardController::class, 'returnToAdmin'])->name('admin.subadmins.return');



    // Students=======================================================================================================>
    Route::get('/students', [DashboardController::class, 'studentsView'])->name('admin.students');
    Route::post('/students', [DashboardController::class, 'studentAdd'])->name('admin.students.add');
    Route::put('/students/edit/{id}', [DashboardController::class, 'studentEdit'])->name('admin.students.edit');
    Route::delete('/students/delete/{id}', [DashboardController::class, 'studentDelete'])->name('admin.students.delete');


    // Franchise=======================================================================================================>
    Route::get('/franchise', [DashboardController::class, 'franchiseView'])->name('admin.franchise');
    Route::get('/franchise/{id}', [DashboardController::class, 'viewFranchiseDetails'])->name('admin.franchise.view');
    Route::post('/franchise/accept/{id}', [DashboardController::class, 'acceptFranchise'])->name('admin.franchise.accept');
    Route::post('/franchise/reject/{id}', [DashboardController::class, 'rejectFranchise'])->name('admin.franchise.reject');
    Route::delete('/franchise/delete/{id}', [DashboardController::class, 'deleteFranchise'])->name('admin.franchise.delete');
















    // Route::resource('/operation-schemes', OperationSchemesController::class);
    // Route::resource('/register-bookings', RegisterBookingController::class);
    // Route::resource('/booking-types', BookingTypesController::class);
    // Route::get('/check-patient-privious-bookings', [RegisterBookingController::class, 'checkPatientPriviousBooking'])->name('admin.checkPatientPriviousBooking');
    // Route::get('/check-bookingtype-operation', [RegisterBookingController::class, 'checkIfBookingTypeOperation'])->name('admin.checkIfBookingTypeOperation');
    // Route::post('/update-payment/{register_booking_slug}', [RegisterBookingController::class, 'updatePayment'])->name('admin.updatePayment');
    // Route::resource('/expenditure-manages', ExpenditureController::class);



    Route::get('log-out', [AuthController::class, 'adminLogout'])->name('admin.logout');
});
//these routes is common for both employee and admin
// Route::get('/check-patient-privious-bookings', [RegisterBookingController::class, 'checkPatientPriviousBooking'])->name('admin.checkPatientPriviousBooking');
// Route::get('/check-bookingtype-operation', [RegisterBookingController::class, 'checkIfBookingTypeOperation'])->name('admin.checkIfBookingTypeOperation');
// Route::get('/get-print/{slug}',[RegisterBookingController::class, 'getPrint'])->name("get-print");
// Route::get('/get-pescription-print/{slug}',[RegisterBookingController::class, 'getPescriptionPrint'])->name("get-pescription-print");

// Route::post('/save-pescription/{slug}', [RegisterBookingController::class, 'savePescription'])->name('admin.savePescription');

// Route::get('/expenditure-export', [ExpenditureController::class, 'export'])->name('expenditure.download');
