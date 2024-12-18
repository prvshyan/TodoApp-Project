<?php
use App\Http\Controllers\ApiTaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'apiRegister'])->name('api.register');
Route::post('/login', [AuthController::class, 'apiLogin'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
Route::get('/tasks', [ApiTaskController::class, 'index'])->name('api.tasks.index');
Route::post('/tasks', [ApiTaskController::class, 'store'])->name('api.tasks.store');
Route::put('/tasks/{task}', [ApiTaskController::class, 'update'])->name('api.tasks.update');
Route::delete('/tasks/{task}', [ApiTaskController::class, 'destroy'])->name('api.tasks.destroy');
Route::put('/tasks/{task}/toggle', [ApiTaskController::class, 'toggleStatus'])->name('api.tasks.toggle');
});
