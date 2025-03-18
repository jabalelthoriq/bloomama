<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserPregnantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EventController;



// login register route
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Appointment routes
Route::get('/appointments/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
Route::put('/appointments/update', [AppointmentController::class, 'update'])->name('appointments.update');
Route::delete('/appointments/delete', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

// event route
Route::get('/acara', [EventController::class, 'showevent'])->name('acara');
Route::post('/acara', [EventController::class, 'addEvent']);
Route::get('/acara/edit', [EventController::class, 'editEvent'])->name('event.edit');
Route::put('/acara/update', [EventController::class, 'updateEvent'])->name('event.update');
Route::delete('/acara/destroy', [EventController::class, 'destroyEvent'])->name('event.destroy');
// Other routes
Route::get('/chat', [AuthController::class, 'chat']);
Route::get('/user', [AuthController::class, 'user']);
Route::get('/setting', [AuthController::class, 'setting']);
Route::get('/security', [AuthController::class, 'security']);
