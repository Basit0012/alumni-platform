<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
        Route::get('/users', function () { return view('admin.users'); })->name('users');
    });

    // Public Authenticated Routes
    Route::get('/feed', [App\Http\Controllers\PostController::class, 'index'])->name('feed');
    Route::get('/alumni', [\App\Http\Controllers\AlumniController::class, 'index'])->name('alumni.index');
    
    // Public Profiles
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Connections
    Route::post('/connections/{user}/send', [\App\Http\Controllers\ConnectionController::class, 'send'])->name('connections.send');
    Route::patch('/connections/{id}/accept', [\App\Http\Controllers\ConnectionController::class, 'accept'])->name('connections.accept');
    Route::delete('/connections/{id}/reject', [\App\Http\Controllers\ConnectionController::class, 'reject'])->name('connections.reject');

    // Mentorship
    Route::post('/mentorship/request/{alumni}', [\App\Http\Controllers\MentorshipController::class, 'request'])->name('mentorship.request');
    Route::patch('/mentorship/{id}/approve', [\App\Http\Controllers\MentorshipController::class, 'approve'])->name('mentorship.approve');

    // Posts
    Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{id}/like', [\App\Http\Controllers\PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{id}/comments', [\App\Http\Controllers\PostController::class, 'comment'])->name('posts.comment');

    // Events
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    Route::post('/events/{id}/register', [\App\Http\Controllers\EventController::class, 'register'])->name('events.register');
});

require __DIR__.'/auth.php';
