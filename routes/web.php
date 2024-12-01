<?php

use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::get('/', function () {
    return view('welcome');
});
Route::post('/register', [SignupController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
Route::get('/login-form',function (){
    return view('login');
});
Route::get('/signup-form',function (){
    return view('signup');
});
Route::middleware('auth:api')->group(function () {
    Route::get('/protected', function () {
        return response()->json(['message' => 'This is a protected route.']);
    });
});


