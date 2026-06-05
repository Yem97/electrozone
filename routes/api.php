<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//link for user regristration from authcontroller register function
Route::post('/register',action:[AuthController::class,'register']);

//link for user login from authcontroller login function
Route::post('/login',action:[AuthController::class,'login']);

//link for logout using auth:sactum where only authenticated user will logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource("users", UserController::class);
    
});

