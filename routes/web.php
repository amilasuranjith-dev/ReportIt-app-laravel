<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/requests/create', function () {
        return view('requests.create');
    })->name('requests.create');

    Route::get('/requests/{serviceRequest}/edit', function (\App\Models\ServiceRequest $serviceRequest) {
        if ($serviceRequest->user_id !== auth()->id() || $serviceRequest->status->value !== 'pending') {
            abort(403, 'Unauthorized action.');
        }
        return view('requests.edit', compact('serviceRequest'));
    })->name('requests.edit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
