<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignupController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/register', [SignupController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login-form',function (){
    return view('login');
});
Route::get('/signup-form',function (){
    return view('signup');
});

