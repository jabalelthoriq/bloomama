<?php
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\HealthTracking;
use App\Models\UserPregnant;
use App\Http\Controllers\Mobile\authcontroller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Mobile\dashboardcontroller;
use App\Http\Controllers\Mobile\kesehatancontroller;


Route::put('/pregnancies/{pregnancyId}', [UsersController::class, 'update'])->name('pregnancies.update');
Route::delete('/users', [UsersController::class, 'destroy'])->name('users.destroy');


 Route::middleware('auth:api')->group(function () {
    
    // Send message dari user yang sudah login
    Route::post('/messages/send', [ChatController::class, 'sendMessage']);
    
    // Get chat status untuk debugging
    Route::get('/chat/status', [ChatController::class, 'getChatStatus']);
});

// Test routes (tanpa auth untuk testing)
Route::prefix('test')->group(function () {
    // Send test message dari web interface
    Route::post('/send-message', [ChatController::class, 'sendTestMessage']);
});

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
Route::get('/health-trackings/latest/{user_id}', [dashboardcontroller::class, 'getLatestHealthData']);
Route::post('/register-pregnancies/{user_id}', [dashboardcontroller::class, 'registerUserPregnancy']);
Route::get('/getPregnancyData/{user_id}', [dashboardcontroller::class, 'getPregnancyData']);
Route::get('/getHealthTrackingForChart/{user_id}', [dashboardcontroller::class, 'getHealthTrackingForChart']);
Route::get('/events', [dashboardcontroller::class, 'getEventsByDate']);
Route::get('/appointments/user/{user_id}', [dashboardcontroller::class, 'getAppointmentByUser']);



///kesehatan
Route::get('/content/latest', [kesehatancontroller::class, 'getLatestContent']);
Route::get('/content/one', [kesehatancontroller::class, 'getOneContent']);
Route::get('/content/all', [kesehatancontroller::class, 'getAllContent']);
Route::get('/content/category/{category}', [kesehatancontroller::class, 'getContentByCategory']);
Route::get('/health-trackings/week/{user_id}/{week}',[kesehatancontroller::class, 'getHealthTrackingByWeek'] )->where(['pregnancy_id' => '[0-9]+','week' => '[0-9]+']);