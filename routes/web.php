<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard (hanya untuk user yang login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// CRUD Buku (hanya untuk user yang login)
Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
});

// Auth routes (login, register, logout)
require __DIR__.'/auth.php';