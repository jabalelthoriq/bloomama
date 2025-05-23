<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\HealthTracking;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\UserPregnant;
class kesehatancontroller extends Controller
{

    public function getPregnancyData($pregnancy_id)
    {
        try {
            $pregnancy = UserPregnant::findOrFail($pregnancy_id);

            return response()->json([
                'success' => true,
                'data' => [
                    'start_date' => $pregnancy->start_date,
                    'due_date' => $pregnancy->due_date,
                    'pregnancy_week' => $pregnancy->pregnancy_week
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pregnancy data not found'
            ], 404);
        }
    }
     public function getLatestContent()
    {
        $latestContent = Content::latest('created_at')
            ->limit(1)
            ->first();

        return response()->json([
            'success' => true,
            'data' => $latestContent
        ]);
    }

public function getPregnancyByIdWithWeek($pregnancy_id, $week)
{
    try {
        // Validasi week
        if (!is_numeric($week) || $week < 1 || $week > 40) {
            return response()->json([
                'success' => false,
                'message' => 'Minggu kehamilan harus antara 1-40'
            ], 400);
        }

        $pregnancy = HealthTracking::where('pregnancy_id', $pregnancy_id)
                                ->where('pregnancy_week', $week)
                                ->first([
                                    'tracking_id',
                                    'pregnancy_week',
                                    'weight',
                                    'height',
                                    'blood_pressure',
                                    'heart_rate',
                                    'notes',
                                    'date_recorded'
                                ]);

        if (!$pregnancy) {
            return response()->json([
                'success' => false,
                'message' => 'Data kehamilan tidak ditemukan untuk ID '.$pregnancy_id.' dan minggu ke-'.$week
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'tracking_id' => $pregnancy->tracking_id,
                'pregnancy_id' => $pregnancy_id,
                'week' => $pregnancy->pregnancy_week,
                'weight' => $pregnancy->weight,
                'height' => $pregnancy->height,
                'blood_pressure' => $pregnancy->blood_pressure,
                'heart_rate' => $pregnancy->heart_rate,
                'notes' => $pregnancy->notes,
                'date_recorded' => $pregnancy->date_recorded
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan',
            'error' => $e->getMessage()
        ], 500);
    }
}


}
