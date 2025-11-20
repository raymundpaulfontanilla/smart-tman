<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('accounts')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('projects')->group(function () {
    Route::post('/create-project', [ProjectController::class, 'store']);
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/{id}', [ProjectController::class, 'show']);
    Route::put('/{id}', [ProjectController::class, 'update']);
    Route::delete('/{id}', [ProjectController::class, 'destroy']);
});

Route::prefix('tasks')->group(function () {
    Route::post('/create-task', [TaskController::class, 'store']);
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{id}', [TaskController::class, 'show']);
});
