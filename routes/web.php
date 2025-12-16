<?php

use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::resource('users', UserController::class);
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/{hashid}', 'show')->name('users.show');
    Route::get('/users/edit', 'edit')->name('users.edit')->middleware('admin');
    Route::put('/users/update', 'update')->name('users.update')->middleware('admin');
});

require __DIR__.'/settings.php';
