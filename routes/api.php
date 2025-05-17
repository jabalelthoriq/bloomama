<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\HealthTracking;
use App\Models\UserPregnant;
use App\Http\Controllers\Mobile\authcontroller;
use App\Http\Controllers\UsersController;


//mobile api
Route::post('/register', [authcontroller::class, 'register']);
Route::post('/login', [authcontroller::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [authcontroller::class, 'profile']);
    Route::put('/update-profile', [authcontroller::class, 'updateProfile']);
    Route::post('/logout', [authcontroller::class, 'logout']);
});



