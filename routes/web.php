<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['IsLoggedIn'])->group(function () {
    // Rute yang memerlukan autentikasi, termasuk seluruh halaman administrasi.
    Route::get('/logout', [
        UserController::class,
        'logout'
    ])->name('logout');

    // prefix untuk mengelompokkan route admin yang pathnya di awali dengan /admin
    // seluruh route pada kelompok ini akan memiliki nama route di awali dengan admin.
    // contoh : admin.dashboard
    Route::prefix('admin')->name('admin.')->middleware('IsAdmin')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('book-categories', BookCategoryController::class);
        Route::resource('subscription-packages', SubscriptionPackageController::class);
        Route::resource('books', BookController::class);
    });
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['IsGuest'])->group(function () {
    // Halaman autentikasi hanya tersedia bagi pengunjung yang belum masuk.
    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::post('/register', [
        UserController::class,
        'register'
    ])->name('register.store')->middleware('throttle:5,1');

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [
        UserController::class,
        'login'
    ])->name('login.store')->middleware('throttle:5,1');
});