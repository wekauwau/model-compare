<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/signup', [RegisterController::class, 'showRegistrationForm'])->name('signup');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.post');

Route::get('/', function () {
    return view('test')->name('dashboard-user');
});

// Route::get('/dashboard-admin', function () {
//     return 'Welcome, Admin!';
// })->name('dashboard-admin')->middleware('auth');

Route::get('/', function () {
    return 'Welcome, User!';
})->name('dashboard-user')->middleware('auth');

// Route::get('/login', function () {
//     return view('login')->name('login');
// });
