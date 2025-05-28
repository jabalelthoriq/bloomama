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
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SettingController;

//use api web
 Route::prefix('api')->group(function() {
        // routes for health tracking
            Route::get('/health-tracking/{pregnancyId}', [UsersController::class, 'getHealthTrackingData']);
            Route::post('/health-tracking/store/{pregnancyId}', [UsersController::class, 'storeHealthTracking']);
            Route::put('/health-tracking/{trackingId}', [UsersController::class, 'updateHealthTracking']);
            Route::delete('/health-tracking/{trackingId}', [UsersController::class, 'deleteHealthTracking']);

    
});

// Public routes - accessible without login
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Midwife routes
// Route::middleware('role:midwife')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// APPOINTMENT ROUTES - DIPERBAIKI
Route::put('/appointments/update', [AppointmentController::class, 'update'])->name('appointments.update');
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
Route::post('/appointments/user/{userId}', [UsersController::class, 'storeAppointment'])
    ->middleware(['auth:midwife']);


// User management routes for midwives
Route::get('/user', [UsersController::class, 'showUsersAndMidwives'])->name('user');
Route::post('/pregnancies/{pregnancy_id}', [UsersController::class, 'update'])->name('pregnancies.update');

// Chat routes
Route::get('/chat', [ChatController::class, 'chat']);

// Setting routes
Route::get('/setting', [SettingController::class, 'setting']);
Route::post('/update-profile', [SettingController::class, 'updateProfile'])->name('update.profile');
Route::get('/security', [SettingController::class, 'security']);
Route::post('/security/change-password', [SettingController::class, 'changePassword'])->name('security.change-password');
Route::post('/security/reset-password-email', [SettingController::class, 'sendResetLinkEmail'])->name('security.reset-password-email');
// });

// Admin routes
// Route::middleware('role:admin')->group(function () {
Route::get('/menu1', [AdminController::class, 'menu1'])->name('menu1');

//menu2
Route::get('/menu2', [AdminController::class, 'showUsersAndMidwives'])->name('admin.user');
Route::post('/midwives', [AdminController::class, 'storeMidwife'])->name('store.midwife');
Route::post('/pasien/update/{id}', [AdminController::class, 'update'])->name('admin.pasien.update');
Route::post('/midwife/update/{id}', [AdminController::class, 'updateMidwife'])->name('admin.midwife.update');
Route::delete('/midwife/delete/{id}', [AdminController::class, 'destroyMidwife'])->name('admin.midwife.destroy');

Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUsers'])->name('admin.users.destroy');

        // Event routes
        Route::get('/acara', [EventController::class, 'showevent'])->name('acara');
        Route::post('/acara', [EventController::class, 'addEvent'])->name('add.event');
        Route::post('/event/update/{id}', [EventController::class, 'updateEvent'])->name('admin.event.update');
        Route::delete('/acara/{id}', [EventController::class, 'destroy'])->name('event.destroy');



        // Content
        Route::get('/content', [ContentController::class, 'index'])->name('content.index');
        Route::post('/content', [ContentController::class, 'store'])->name('content.store');
        Route::post('/content/update/{id}', [ContentController::class, 'updateContent'])->name('admin.content.update');
        Route::delete('/content/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
    // });
