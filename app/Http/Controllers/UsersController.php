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
public function storeHealthTracking(Request $request)
{
    $validator = Validator::make($request->all(), [
        'pregnancy_id' => 'required|exists:user_pregnants,pregnancy_id',
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
        $tracking = HealthTracking::create([
            'user_id' => UserPregnant::find($request->pregnancy_id)->user_id,
            'pregnancy_id' => $request->pregnancy_id,
            'date_recorded' => $request->date_recorded,
            'weight' => $request->weight,
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Health tracking data saved successfully',
            'data' => $tracking
        ]);
    } catch (\Exception $e) {
        Log::error("Error saving health tracking: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to save health tracking data'
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
