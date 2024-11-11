<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

Route::prefix('users')->middleware('jwt.auth')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::post('create', [UserController::class, 'create']);
    Route::put('update/{id}', [UserController::class, 'update']);
    Route::delete('delete/{id}', [UserController::class, 'delete']);
});

Route::prefix('course')->middleware('jwt.auth')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::get('{id}', [CourseController::class, 'show']);
    Route::post('create', [CourseController::class, 'create']);
});

Route::post('/login', [AuthController::class, 'login']);
