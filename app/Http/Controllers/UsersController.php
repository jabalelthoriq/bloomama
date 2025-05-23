<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Midwive;
use App\Models\UserPregnant;
use App\Models\HealthTracking;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Carbon;

class UsersController extends Controller
{
    // public function __construct()
    // {
    //     $this->checkAdminAccess();
    // }

    // /**
    //  * Check if the authenticated user is a midwife with admin role
    //  */
    // private function checkAdminAccess()
    // {
    //     // Check if user is authenticated as midwife
    //     if (!Auth::guard('midwife')->check()) {
    //         abort(403, 'Unauthorized access');
    //     }

    //     // Check if midwife has admin role
    //     $midwife = Auth::guard('midwife')->user();

    //     // Check if role field exists, is not null, and is set to 'admin'
    //     if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'midwife') {
    //         abort(403, 'midwife access required');
    //     }
    // }
    /**
     * Show the users page with users data.
     *
     * @return \Illuminate\Contracts\View\View
     */

     public function showUsersAndMidwives()
     {
        $midwives = Midwive::orderBy('created_at', 'desc')->paginate(10, ['*'], 'midwife_page');
        $users = User::orderBy('created_at', 'desc')->paginate(10, ['*'], 'user_page');

         $userPregnancies = UserPregnant::with(['user' => function($query) {
                 $query->select('user_id', 'name'); // Only select needed columns
             }])
             ->orderBy('created_at', 'desc')
             ->paginate(10, ['*'], 'pregnancy_page');

         return view('user', compact('users', 'midwives', 'userPregnancies'));
     }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
 * Update the specified user in database.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $pregnancyId): RedirectResponse
{
    try {
        $userPregnancy = UserPregnant::findOrFail($pregnancyId);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'gravida' => 'required|integer|min:0',
            'para' => 'required|integer|min:0',
            'abortus' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'due_date' => 'nullable|date|after:start_date',
            'pregnancy_week' => 'required|integer|between:1,42',
            'last_check_date' => 'nullable|date|before_or_equal:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        $userPregnancy->update($validated);

        return redirect()->route('user.pregnancies')
            ->with('success', 'Data kehamilan berhasil diperbarui.');

    } catch (\Exception $e) {
        Log::error("Update Error: " . $e->getMessage());
        return back()->with('error', 'Gagal memperbarui data kehamilan.');
    }
}

    /**
     * Remove the specified user from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Update: Changed 'user' to 'midwife.user' to match route name in routes file
        return redirect()->route('midwife.user')
            ->with('success', 'Bidan berhasil dihapus.');
    }


public function getHealthTrackingData($pregnancyId, $userId = null)
{
    try {
        // Validate pregnancyId exists and is numeric
        if (!is_numeric($pregnancyId)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid pregnancy ID'
            ], 400);
        }

        // Build query with eager loading and ordering
        $query = UserPregnant::with(['user', 'healthTrackings' => function($query) {
            $query->orderBy('date_recorded', 'desc');
        }]);

        // Validate user_id if provided
        if ($userId) {
            if (!is_numeric($userId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid user ID'
                ], 400);
            }
            $query->where('user_id', $userId);
        }

        // Find by primary key (pregnancy_id)
        $pregnancy = $query->findOrFail($pregnancyId);

        // Get latest tracking data
        $latestStats = $pregnancy->healthTrackings->first();

        return response()->json([
            'success' => true,
            'data' => [
                'patient_name' => $pregnancy->user->name ?? 'Unknown',
                'pregnancy_id' => $pregnancy->pregnancy_id,
                'user_id' => $pregnancy->user_id,
                'pregnancy_week' => $pregnancy->pregnancy_week,
                'last_updated' => optional($latestStats)->date_recorded,
                'latest_stats' => $latestStats ? [
                    'weight' => $latestStats->weight,
                    'blood_pressure' => $latestStats->blood_pressure,
                    'heart_rate' => $latestStats->heart_rate,
                    'notes' => $latestStats->notes
                ] : null,
                'trackings' => $pregnancy->healthTrackings->map(function($tracking) {
                    return [
                        'tracking_id' => $tracking->id,
                        'date_recorded' => $tracking->date_recorded,
                        'weight' => $tracking->weight,
                        'blood_pressure' => $tracking->blood_pressure,
                        'heart_rate' => $tracking->heart_rate,
                        'notes' => $tracking->notes
                    ];
                })->toArray()
            ]
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Pregnancy record not found'
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch health tracking data',
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}


/**
 * Store health tracking data
 */
/**
 * Store health tracking data for a specific pregnancy
 *
 * @param Request $request
 * @param int $pregnancy_id
 * @return \Illuminate\Http\JsonResponse
 */
public function storeHealthTracking(Request $request, $pregnancy_id)
{
    // Validate the request data
    $validatedData = $request->validate([
        'date_recorded' => 'required|date_format:Y-m-d',
        'weight' => 'required|numeric|between:0,999.99',
        'blood_pressure' => 'nullable|string|max:20', // e.g., "120/80"
        'heart_rate' => 'required|integer|min:0',
        'notes' => 'nullable|string|max:500'
    ]);

    try {
        // Check if the pregnancy exists
        $pregnancy = UserPregnant::findOrFail($pregnancy_id);

        // Create new health tracking record using fillable fields
        $healthData = HealthTracking::create([
            'user_id' => $pregnancy->user_id,
            'pregnancy_id' => $pregnancy_id,
            'date_recorded' => $validatedData['date_recorded'],
            'weight' => $validatedData['weight'],
            'blood_pressure' => $validatedData['blood_pressure'] ?? null,
            'heart_rate' => $validatedData['heart_rate'],
            'notes' => $validatedData['notes'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Health tracking data stored successfully',
            'data' => $healthData
        ], 201);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Pregnancy record not found'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to store health tracking data',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Update health tracking data
 */
public function updateHealthTracking(Request $request, $trackingId)
{
    $validator = Validator::make($request->all(), [
        'date_recorded' => 'required|date',
        'weight' => 'nullable|numeric|min:30|max:200',
        'blood_pressure' => 'nullable|string|max:20',
        'heart_rate' => 'nullable|integer|min:40|max:200',
        'notes' => 'nullable|string|max:500'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $tracking = HealthTracking::findOrFail($trackingId);

        $tracking->update([
            'date_recorded' => $request->date_recorded,
            'weight' => $request->weight,
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Health tracking data updated successfully',
            'data' => $tracking
        ]);
    } catch (\Exception $e) {
        Log::error("Error updating health tracking: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to update health tracking data'
        ], 500);
    }
}

/**
 * Delete health tracking data
 */
public function deleteHealthTracking($trackingId)
{
    try {
        $tracking = HealthTracking::findOrFail($trackingId);
        $tracking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Health tracking data deleted successfully'
        ]);
    } catch (\Exception $e) {
        Log::error("Error deleting health tracking: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete health tracking data'
        ], 500);
    }
}





}
