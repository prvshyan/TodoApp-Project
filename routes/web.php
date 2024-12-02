<?php
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/login-form', function () {
    return view('login');
});
Route::get('/signup-form', function () {
    return view('signup');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    Route::put('/tasks/{task}/edit', [TaskController::class, 'edit']);
});

