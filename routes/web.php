<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('welcome');
});

// login register route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Appointment routes
Route::get('/appointments/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
Route::put('/appointments/update', [AppointmentController::class, 'update'])->name('appointments.update');
Route::delete('/appointments/delete', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

// Other routes
Route::get('/acara', [AuthController::class, 'acara']);
Route::get('/chat', [AuthController::class, 'chat']);
Route::get('/user', [AuthController::class, 'user']);
Route::get('/setting', [AuthController::class, 'setting']);
Route::get('/security', [AuthController::class, 'security']);
