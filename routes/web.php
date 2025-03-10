<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware(['guest', PreventBackHistory::class])->group(function () {
    Route::view('/', 'menu.welcome')->name('welcome');
});

Route::middleware(['auth', PreventBackHistory::class])->group(function () {
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
    
    // Ticket Routes
    Route::prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/new', [TicketController::class, 'create'])->name('create');
        Route::post('/new', [TicketController::class, 'store'])->name('store');
        Route::get('/{id}', [TicketController::class, 'show'])->name('show');
        Route::patch('/{id}/handle', [TicketController::class, 'handle'])->name('handle');
        Route::put('/{id}', [TicketController::class, 'update'])->name('update');
        Route::patch('/{id}/changePriority', [TicketController::class, 'changePriority'])->name('changePriority');
        Route::patch('/{id}/reopen', [TicketController::class, 'reopen'])->name('reopen');
        Route::post('/{id}/comment', [CommentController::class, 'store'])->name('comment');
    });
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
