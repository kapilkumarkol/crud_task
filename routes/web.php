<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('task_list');
});
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login']);

