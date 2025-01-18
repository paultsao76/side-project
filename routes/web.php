<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\MailController;

// Route::get('/', [BooksController::class, "index"])->name("root");
// Route::resource("books", BooksController::class);
// Route::resource("users", UsersController::class);

Route::get('/', function () {
        return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
	Route::resource("books", BooksController::class);
	Route::get("report", [BooksController::class, 'report'])->name('report');//報表
});


