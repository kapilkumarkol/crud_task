<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: X-Requested-With,Content-Type');
// header('Access-Control-Allow-Methods: POST,GET,OPTIONS');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',[AuthController::class,'login'])->name('login')->middleware(['api']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'task_list']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'delete_task']);
});
