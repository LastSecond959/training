<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'menu.welcome')->name('welcome');

Route::middleware('auth')->group(function () {
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
    
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');

    Route::prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/create', [TicketController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';
