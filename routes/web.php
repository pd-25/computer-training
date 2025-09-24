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

require __DIR__ . '/admin.php';
