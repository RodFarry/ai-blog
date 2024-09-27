<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/posts', function () {
    return Post::orderBy('created_at', 'desc')->paginate(10);
});

Route::get('/posts/{id}', function ($id) {
    return Post::findOrFail($id);
});