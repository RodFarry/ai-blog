<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Auth;

// Public-facing React app
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes(); // Registers login, register, and other auth-related routes

// Admin area (only authenticated users can access)
Route::middleware('auth')->group(function () {
    Route::get('/admin/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/admin/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/admin/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/admin/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/admin/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/admin/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/admin/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('/admin/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/admin/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::get('/admin/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::put('/admin/topics/{topic}', [TopicController::class, 'update'])->name('topics.update');
    Route::delete('/admin/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
