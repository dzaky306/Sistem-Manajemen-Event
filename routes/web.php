<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('events.public');
});

// Dashboard (auth required)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes (dari Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', EventController::class)->except(['show']);
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
    
    // Registrations Management
    Route::get('registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::put('registrations/{registration}/attendance', [RegistrationController::class, 'markAttendance'])
        ->name('registrations.attendance');
    Route::delete('registrations/{registration}', [RegistrationController::class, 'destroy'])
        ->name('registrations.destroy');
});

// Public routes (bisa diakses semua)
Route::get('/events', [EventController::class, 'publicIndex'])->name('events.public');
Route::get('/events/{event}', [EventController::class, 'publicShow'])->name('events.public.show');

// Registration routes (public)
Route::get('/events/{event}/register', [RegistrationController::class, 'create'])
    ->name('registrations.create');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])
    ->name('registrations.store');
Route::get('/registrations/{registration}/success', [RegistrationController::class, 'success'])
    ->name('registrations.success');

require __DIR__.'/auth.php';