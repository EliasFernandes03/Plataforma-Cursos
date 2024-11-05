<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users/create', [UserController::class, 'create']);
Route::put('users/update/{id}', [UserController::class, 'update']);
Route::delete('users/delete/{id}', [UserController::class, 'delete']);
