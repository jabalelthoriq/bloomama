<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MidwiveController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContentController;

//landing page route
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

// login register route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
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
Route::post('/acara', [EventController::class, 'addEvent'])->name('add.event');
Route::get('/acara/edit', [EventController::class, 'editEvent'])->name('event.edit');
Route::put('/acara/update', [EventController::class, 'updateEvent'])->name('event.update');
Route::delete('/acara/destroy', [EventController::class, 'destroyEvent'])->name('event.destroy');

// chat routes
Route::get('/chat', [AuthController::class, 'chat']);

//user route
Route::get('/user', [UsersController::class, 'showUsersAndMidwives'])->name('user');
Route::get('/users/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('/users', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users', [UsersController::class, 'destroy'])->name('users.destroy');

// Midwife routes
Route::post('/midwives', [App\Http\Controllers\MidwiveController::class, 'store'])->name('midwives.store');

//seting route
Route::get('/setting', [AuthController::class, 'setting']);
Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('update.profile');

//security route
Route::get('/security', [AuthController::class, 'security']);
Route::post('/security/change-password', [AuthController::class, 'changePassword'])->name('security.change-password');
Route::post('/security/reset-password-email', [AuthController::class, 'sendResetLinkEmail'])->name('security.reset-password-email');

//admin route
Route::get('/menu1', [AdminController::class, 'menu1']);
Route::get('/menu2', [AdminController::class, 'showUsersAndMidwives'])->name('user');


//content
Route::get('/content', [ContentController::class, 'index'])->name('content.index');
Route::post('/content', [ContentController::class, 'store'])->name('content.store');
Route::put('/content/{id}', [ContentController::class, 'update'])->name('content.update');
Route::delete('/content', [ContentController::class, 'destroy'])->name('content.destroy');





