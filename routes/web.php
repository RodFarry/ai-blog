<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('topics', TopicController::class);