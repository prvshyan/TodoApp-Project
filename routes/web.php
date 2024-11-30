<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignupController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/signup', [SignupController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);


