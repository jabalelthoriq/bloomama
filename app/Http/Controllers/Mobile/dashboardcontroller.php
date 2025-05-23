<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealthTracking;
use App\Models\UserPregnant;
use App\Models\User;

class dashboardcontroller extends Controller
{

   public function registerUserPregnancy(Request $request, $user_id)
{
    // Validasi data input
    $validated = $request->validate([
        'gravida' => 'required|integer|min:1',
        'para' => 'required|integer|min:0',
        'abortus' => 'required|integer|min:0',
        'start_date' => 'required|date|before_or_equal:today',
        // Status dihapus dari validasi karena tidak boleh diinput user
    ]);

    try {
        // Cek apakah user valid dan aktif
        $user = User::where('user_id', $user_id)
                  ->where('status', 'active') // Asumsi ada kolom status di tabel users
                  ->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found or inactive',
                'user_status' => User::find($user_id)->status ?? 'not_found'
            ], 404);
        }

        // Cek kehamilan aktif yang sudah ada
        $activePregnancy = UserPregnant::where('user_id', $user_id)
                            ->where('status', 'active')
                            ->first();

        // Jika sudah ada kehamilan aktif, tolak pendaftaran baru
        if ($activePregnancy) {
            return response()->json([
                'message' => 'Cannot register new pregnancy. User already has an active pregnancy record.',
                'existing_pregnancy' => $activePregnancy,
                'suggestion' => 'Update the existing record instead'
            ], 409);
        }

        // Buat record kehamilan baru dengan status selalu 'active'
        $pregnancy = UserPregnant::create([
            'user_id' => $user_id,
            'gravida' => $validated['gravida'],
            'para' => $validated['para'],
            'abortus' => $validated['abortus'],
            'start_date' => $validated['start_date'],
            'status' => 'active', // Status selalu active untuk kehamilan baru
            'registered_by' => auth()->id() // Jika menggunakan authentication
        ]);

        return response()->json([
            'message' => 'Pregnancy data registered successfully',
            'data' => $pregnancy
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to register pregnancy data',
            'error' => $e->getMessage(),
            'trace' => env('APP_DEBUG') ? $e->getTrace() : null
        ], 500);
    }
}
    public function getHealthTrackingByUserId($userId)
{
    $data = HealthTracking::with(['user', 'pregnancy'])
                ->where('user_id', $userId)
                ->select([
                    'tracking_id', // biasanya perlu menyertakan primary key
                    'user_id', // diperlukan untuk relasi
                    'pregnancy_id', // diperlukan untuk relasi
                    'date_recorded', // biasanya berguna untuk sorting/filter
                    'weight',
                    'blood_pressure',
                    'heart_rate',
                    'notes'
                ])
                ->get();

    if ($data->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan untuk user_id: ' . $userId,
            'data' => []
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Data health tracking berhasil diambil.',
        'data' => $data
    ]);
}


  

}
