<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\HealthTracking;
use App\Models\UserPregnant;
use App\Http\Controllers\Mobile\authcontroller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminController;
Route::put('/pregnancies/{pregnancyId}', [UsersController::class, 'update'])->name('pregnancies.update');
Route::delete('/users', [UsersController::class, 'destroy'])->name('users.destroy');

// Route::put('/admin/users', [AdminController::class, 'updateUsers'])->name('admin.pasien.update');
// Route::delete('/admin/users', [AdminController::class, 'destroyUsers'])->name('admin.users.destroy');


Route::post('/pasien/update/{id}', [AdminController::class, 'update'])
     ->name('admin.pasien.update');

//mobile api
Route::post('/register', [authcontroller::class, 'register']);
Route::post('/login', [authcontroller::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [authcontroller::class, 'profile']);
    Route::put('/update-profile', [authcontroller::class, 'updateProfile']);
    Route::post('/change-password', [authcontroller::class, 'changePassword']);
    Route::post('/logout', [authcontroller::class,'logout']);
});



