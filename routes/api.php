<?php

use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);


Route::middleware('auth:api')->get('/profile', function () {
    return response()->json(auth()->user());
});