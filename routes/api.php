<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\HealthTracking;
use App\Models\UserPregnant;

// routes/api.php
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
                'weight' => optional($latestTracking)->weight ?? null,
                'blood_pressure' => optional($latestTracking)->blood_pressure ?? null,
                'heart_rate' => optional($latestTracking)->heart_rate ?? null,
                'notes' => optional($latestTracking)->notes ?? null,
                'last_updated' => optional($latestTracking)->date_recorded ?? null,
                'trackings' => $pregnancy->healthTrackings->toArray() // Pastikan ini tidak null
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
