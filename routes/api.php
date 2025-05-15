<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\HealthTracking;
use App\Models\UserPregnant;
use App\Http\Controllers\Mobile\authcontroller;


//mobile api
Route::post('/register', [authcontroller::class, 'register']);
Route::post('/login', [authcontroller::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::get('/health-tracking/{pregnancyId}', function($pregnancyId) {
    try {
        $pregnancy = UserPregnant::with(['user', 'healthTrackings' => function($query) {
            $query->orderBy('date_recorded', 'desc');
        }])->findOrFail($pregnancyId);

        $latestTracking = $pregnancy->healthTrackings->first();

        return response()->json([
            'success' => true,
            'data' => [
                'patient' => $pregnancy->user->name,
                'pregnancy_week' => $pregnancy->pregnancy_week,
                'last_updated' => $latestTracking ? $latestTracking->date_recorded : null,
                'trackings' => $pregnancy->healthTrackings->map(function($tracking) {
                    return [
                        'tracking_id' => $tracking->tracking_id,
                        'date_recorded' => $tracking->date_recorded,
                        'weight' => $tracking->weight,
                        'blood_pressure' => $tracking->blood_pressure,
                        'heart_rate' => $tracking->heart_rate,
                        'notes' => $tracking->notes
                    ];
                }),
                'latest_stats' => $latestTracking ? [
                    'weight' => $latestTracking->weight,
                    'blood_pressure' => $latestTracking->blood_pressure,
                    'heart_rate' => $latestTracking->heart_rate,
                    'notes' => $latestTracking->notes
                ] : null
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal memuat data kesehatan',
            'error' => $e->getMessage()
        ], 404);
    }
});

Route::post('/health-tracking', function(Request $request) {
    try {
        $validated = $request->validate([
            'pregnancy_id' => 'required|exists:user_pregnancies,pregnancy_id',
            'user_id' => 'required|exists:users,user_id',
            'date_recorded' => 'required|date',
            'weight' => 'nullable|numeric|between:30,200',
            'blood_pressure' => 'nullable|string|max:20|regex:/^\d+\/\d+$/',
            'heart_rate' => 'nullable|integer|between:40,200',
            'notes' => 'nullable|string|max:500'
        ]);

        $tracking = HealthTracking::create($validated);

        // Update last check date in pregnancy
        UserPregnant::where('pregnancy_id', $validated['pregnancy_id'])
            ->update(['last_check_date' => $validated['date_recorded']]);

        return response()->json([
            'success' => true,
            'data' => $tracking,
            'message' => 'Data kesehatan berhasil ditambahkan'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menambahkan data kesehatan',
            'error' => $e->getMessage()
        ], 400);
    }
});

Route::put('/health-tracking/{trackingId}', function(Request $request, $trackingId) {
    try {
        $validated = $request->validate([
            'date_recorded' => 'required|date',
            'weight' => 'nullable|numeric|between:30,200',
            'blood_pressure' => 'nullable|string|max:20|regex:/^\d+\/\d+$/',
            'heart_rate' => 'nullable|integer|between:40,200',
            'notes' => 'nullable|string|max:500'
        ]);

        $tracking = HealthTracking::findOrFail($trackingId);
        $tracking->update($validated);

        return response()->json([
            'success' => true,
            'data' => $tracking,
            'message' => 'Data kesehatan berhasil diperbarui'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui data kesehatan',
            'error' => $e->getMessage()
        ], 400);
    }
});

Route::delete('/health-tracking/{trackingId}', function($trackingId) {
    try {
        $tracking = HealthTracking::findOrFail($trackingId);
        $tracking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data kesehatan berhasil dihapus'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus data kesehatan',
            'error' => $e->getMessage()
        ], 400);
    }
});
