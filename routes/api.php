<?php
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\HealthTracking;
use App\Models\UserPregnant;
use App\Http\Controllers\Mobile\authcontroller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Mobile\dashboardcontroller;
use App\Http\Controllers\Mobile\kesehatancontroller;


Route::put('/pregnancies/{pregnancyId}', [UsersController::class, 'update'])->name('pregnancies.update');
Route::delete('/users', [UsersController::class, 'destroy'])->name('users.destroy');




//mobile api

///auth
Route::post('/register', [authcontroller::class, 'register']);
Route::post('/login', [authcontroller::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [authcontroller::class, 'profile']);
    Route::put('/update-profile', [authcontroller::class, 'updateProfile']);
    Route::post('/change-password', [authcontroller::class, 'changePassword']);
    Route::post('/logout', [authcontroller::class,'logout']);

});

///dashboard
Route::get('/health-trackings/user/{userId}', [dashboardcontroller::class, 'getHealthTrackingByUserId']);
Route::post('/register-pregnancies/{user_id}', [dashboardcontroller::class, 'registerUserPregnancy']);



///kesehatan
Route::get('/content/latest', [kesehatancontroller::class, 'getLatestContent']);
Route::get('/content/all', [kesehatancontroller::class, 'getAllContents']);
Route::get('/user/{user_id}/week/{week}',[kesehatancontroller::class, 'getHealthTrackingByWeek'] )->where(['pregnancy_id' => '[0-9]+','week' => '[0-9]+']);


