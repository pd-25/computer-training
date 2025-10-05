<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Http\Controllers\FrontendController; // Add this line



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/about', [FrontendController::class, 'aboutUs'])->name('frontend.about'); // Add this line
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::get('/courses', [FrontendController::class, 'courses'])->name('frontend.courses');
Route::get('/events', [FrontendController::class, 'events'])->name('frontend.events');
Route::get('/event-details', [FrontendController::class, 'eventDetails'])->name('frontend.event-details');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('frontend.gallery');
Route::get('/mission', [FrontendController::class, 'mission'])->name('frontend.mission');
Route::get('/vision', [FrontendController::class, 'vision'])->name('frontend.vision');
Route::get('/paynow', [FrontendController::class, 'paynow'])->name('frontend.paynow');
Route::get('/computer-marksheet', [FrontendController::class, 'computerMarksheet'])->name('frontend.computer-marksheet');
Route::get('/typing', [FrontendController::class, 'typing'])->name('frontend.typing');
Route::get('/certificate', [FrontendController::class, 'certificate'])->name('frontend.certificate');
Route::get('/franchise-mode', [FrontendController::class, 'franchiseMode'])->name('frontend.franchise-mode');
Route::get('/wallet', [FrontendController::class, 'wallet'])->name('frontend.wallet');
Route::get('/verification', [FrontendController::class, 'verification'])->name('frontend.verification');
Route::get('/student-zone', [FrontendController::class, 'studentZone'])->name('frontend.student-zone');

require __DIR__ . '/admin.php';
