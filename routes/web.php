<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::get('/acara', [AuthController::class, 'acara']);
Route::get('/chat', [AuthController::class, 'chat']);
Route::get('/user', [AuthController::class, 'user']);
Route::get('/setting', [AuthController::class, 'setting']);
Route::get('/security', [AuthController::class, 'security']);
