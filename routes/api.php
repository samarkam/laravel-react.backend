<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;

Route::post('register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/validate-token', [AuthController::class, 'validateToken']);
Route::post('/user', [AuthController::class, 'user']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/userprofile', [UserProfileController::class,'index']);
Route::post ('/userprofile', [UserProfileController::class,'store']);
Route::get('/userprofiles/{id}', [UserProfileController::class, 'show']);
Route::put('/userprofiles/{id}',[UserProfileController  ::class,'update']);
Route::delete('/userprofiles/{id}',[UserProfileController::class,'destroy']);