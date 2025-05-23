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

public function getHealthTrackingByWeek($user_id, $week)
{
    try {
        // Validasi week
        if (!is_numeric($week) || $week < 1 || $week > 40) {
            return response()->json([
                'success' => false,
                'message' => 'Pregnancy week must be between 1-40'
            ], 400);
        }

        $healthTracking = HealthTracking::where('user_id', $user_id)
                                     ->where('pregnancy_week', $week)
                                     ->first([
                                         'tracking_id',
                                         'user_id',
                                         'pregnancy_week',
                                         'weight',
                                         'height',
                                         'blood_pressure',
                                         'heart_rate',
                                         'notes',
                                         'date_recorded'
                                     ]);

        if (!$healthTracking) {
            return response()->json([
                'success' => false,
                'message' => 'Health tracking data not found for week '.$week
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'tracking_id' => $healthTracking->tracking_id,
                'user_id' => $healthTracking->user_id,
                'week' => $healthTracking->pregnancy_week,
                'weight' => $healthTracking->weight,
                'height' => $healthTracking->height,
                'blood_pressure' => $healthTracking->blood_pressure,
                'heart_rate' => $healthTracking->heart_rate,
                'notes' => $healthTracking->notes,
                'date_recorded' => $healthTracking->date_recorded
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred',
            'error' => $e->getMessage()
        ], 500);
    }
}


}
