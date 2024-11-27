<?php

use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/validate-token', [AuthController::class, 'validateToken']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/user', [AuthController::class, 'user']);
Route::post('/logout', [AuthController::class, 'logout']);
