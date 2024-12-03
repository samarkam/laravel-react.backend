<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserProfileController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/validate-token', [AuthController::class, 'validateToken']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/user', [AuthController::class, 'user']);
Route::post('/logout', [AuthController::class, 'logout']);



Route::get("/menu",[MenuController::class,'index']);
Route::post("/menu",[MenuController::class,'store']);
Route::get("/menu/{id}",[MenuController::class,'show']);
Route::delete("/menu/{id}",[MenuController::class,'destroy']);
Route::put("/menu/{id}",[MenuController::class,'update']);

Route::get("/categories",[CategoryController::class,'index']);
Route::post("/categories",[CategoryController::class,'store']);
Route::get("/categories/{id}",[CategoryController::class,'show']);
Route::delete("/categories/{id}",[CategoryController::class,'destroy']);
Route::put("/categories/{id}",[CategoryController::class,'update']);

Route::get("/articles",[ArticleController::class,'index']);
Route::post("/articles",[ArticleController::class,'store']);
Route::put("/articles/{id}",[ArticleController::class,'update']);
Route::get("/articles/{id}",[ArticleController::class,'show']);
Route::delete("/articles/{id}",[ArticleController::class,'destroy']);


Route::get("/userProfile",[UserProfileController::class,'index']);
Route::post("/userProfile",[UserProfileController::class,'store']);
Route::put("/userProfile/{id}",[UserProfileController::class,'update']);
Route::get("/userProfile/{id}",[UserProfileController::class,'show']);
Route::delete("/userProfile/{id}",[UserProfileController::class,'destroy']);

Route::post( '/user-details', [UserProfileController::class, 'userDetails']);
Route::put('/update-user/{id}', [UserProfileController::class, 'updateUser']);
//Route::post('user-details', [UserProfileController::class, 'userDetails'])->middleware('auth.jwt');


use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
Route::post( "/orders",[OrderController::class,'store']);
Route::get( "/orders/{id}",[OrderController::class,'show']);
Route::get( "/orders/user/{id}",[OrderController::class,'getUserOrders']);


Route::apiResource('orders', OrderController::class);
Route::apiResource('order-details', OrderDetailController::class);