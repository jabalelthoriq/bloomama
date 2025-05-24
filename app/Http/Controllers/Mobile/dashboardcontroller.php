<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealthTracking;
use App\Models\UserPregnant;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
public function getLatestHealthData($userId)
{
    $latestData = HealthTracking::with(['user', 'pregnancy'])
        ->where('user_id', $userId)
        ->latest('date_recorded') // Sama dengan orderBy('date_recorded', 'desc')
        ->select([
            'tracking_id',
            'user_id',
            'pregnancy_id',
            'weight',
            'blood_pressure',
            'heart_rate',
            'height',
            'date_recorded'
        ])
        ->first(); // Ambil hanya 1 record teratas (terbaru)

    if (!$latestData) {
        return response()->json([
            'success' => false,
            'message' => 'Data kesehatan tidak ditemukan',
            'data' => null
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Data kesehatan terbaru berhasil diambil',
        'data' => $latestData
    ]);
}

public function getPregnancyData($user_id)
{
    try {
        // Cari data kehamilan berdasarkan user_id yang aktif/terbaru
        $pregnancy = UserPregnant::where('user_id', $user_id)
                                 ->where('status', 'active') // atau kondisi status sesuai kebutuhan
                                 ->latest() // ambil yang terbaru jika ada multiple record
                                 ->first();

        // Jika tidak ditemukan data kehamilan
        if (!$pregnancy) {
            return response()->json([
                'success' => false,
                'message' => 'Pregnancy data not found for this user'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pregnancy->pregnancy_id,
                'gravida' => $pregnancy->gravida,
                'para' => $pregnancy->para,
                'abortus' => $pregnancy->abortus,
                'start_date' => $pregnancy->start_date,
                'due_date' => $pregnancy->due_date,
                'pregnancy_week' => $pregnancy->pregnancy_week,
                'status' => $pregnancy->status,
                // Tambahkan field lain yang diperlukan
                'user' => [
                    'full_name' => $pregnancy->user->name // contoh akses relasi
                ]
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error retrieving pregnancy data: ' . $e->getMessage()
        ], 500);
}
}

}