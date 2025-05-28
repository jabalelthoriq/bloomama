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
public function update(Request $request, $pregnancy_id): RedirectResponse
{
    try {
        $userPregnancy = UserPregnant::findOrFail($pregnancy_id);

        $validated = $request->validate([
            'gravida' => 'nullable|integer|min:0',
            'para' => 'nullable|integer|min:0',
            'abortus' => 'nullable|integer|min:0',
            'start_date' => 'required|date',
            'due_date' => 'nullable|date|after:start_date',
            'pregnancy_week' => 'nullable|integer|between:1,42',
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
    // Validate the request data with new fields
    $validatedData = $request->validate([
        'date_recorded' => 'required|date_format:Y-m-d',
        'weight' => 'nullable|numeric|between:0,999.99',
        'height' => 'nullable|numeric|between:0,300', // in cm, nullable
        'pregnancy_week' => 'required|integer|min:1|max:42', // weeks 1-42
        'blood_pressure' => 'nullable|string|max:20', // e.g., "120/80"
        'heart_rate' => 'nullable|integer|min:0',
        'notes' => 'nullable|string|max:500'
    ]);

    try {
        // Check if the pregnancy exists
        $pregnancy = UserPregnant::findOrFail($pregnancy_id);

        // Create new health tracking record with all fields
        $healthData = HealthTracking::create([
            'user_id' => $pregnancy->user_id,
            'pregnancy_id' => $pregnancy_id,
            'date_recorded' => $validatedData['date_recorded'],
            'weight' => $validatedData['weight'],
            'height' => $validatedData['height'] ?? null,
            'pregnancy_week' => $validatedData['pregnancy_week'],
            'blood_pressure' => $validatedData['blood_pressure'] ?? null,
            'heart_rate' => $validatedData['heart_rate'],
            'notes' => $validatedData['notes'] ?? null
        ]);

        // Update the pregnancy's last check date and pregnancy week
        $pregnancy->update([
            'last_check_date' => $validatedData['date_recorded'],
            'pregnancy_week' => $validatedData['pregnancy_week']
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


public function storeAppointment(Request $request, $userId)
{
    // Debug: Lihat data yang diterima dari form
    \Log::info('Appointment form data received:', $request->all());
    
    $validated = $request->validate([
        'date_time' => 'required|date|after:now',
        'notes' => 'nullable|string|max:500',
        'midwife_id' => 'required|exists:midwives,midwife_id', // midwife_id dari select dropdown
    ]);

    // Cari user
    $user = User::find($userId);
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User tidak ditemukan',
            'debug' => [
                'requested_user_id' => $userId,
            ]
        ], 404);
    }

    // Cari bidan - perbaikan: gunakan find() dengan midwife_id dari request
    $midwife = Midwive::find($validated['midwife_id']);
    if (!$midwife) {
        return response()->json([
            'success' => false,
            'message' => 'Bidan tidak ditemukan',
            'debug' => [
                'requested_midwife_id' => $validated['midwife_id'],
                'available_midwives' => Midwive::pluck('id', 'name')->toArray(), // Debug: tampilkan bidan yang tersedia
            ]
        ], 404);
    }

    try {
        $appointmentData = [
            'user_id' => $userId,
            'midwife_id' => $validated['midwife_id'],
            'date_time' => $validated['date_time'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ];

        $appointment = Appointment::create($appointmentData);

        // Load relasi untuk response
        $appointment->load(['user', 'midwife']);

        return response()->json([
            'success' => true,
            'message' => 'Janji temu berhasil dibuat',
            'data' => [
                'appointment' => $appointment,
                'formatted_date_time' => $appointment->formatted_date_time ?? date('d/m/Y H:i', strtotime($appointment->date_time)),
                'user' => $appointment->user,
                'midwife' => $appointment->midwife
            ],
            'debug' => [
                'appointment_input' => $appointmentData,
                'user_found' => $user->id,
                'midwife_found' => $midwife->id,
                'midwife_name' => $midwife->name,
            ]
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat janji temu',
            'error' => app()->isLocal() || config('app.debug') ? $e->getMessage() : 'Internal server error',
            'debug' => [
                'exception' => get_class($e),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'validated_data' => $validated,
            ]
        ], 500);
    }
}

/**
 * Delete health tracking data
 */
 public function storeAppointment2(Request $request, $userId)
{
    $debug = [];
    
    try {
        // Validate input data
        $validated = $request->validate([
            'date_time' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $debug['validated_data'] = $validated;
        
        // Find the user
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
                'debug' => [
                    'requested_user_id' => $userId,
                ]
            ], 404);
        }
        
        $debug['user_found'] = $user->id;
        
        // Get authenticated midwife - improved authentication logic
        $midwife = null;
        
        // Try different authentication methods
        if (auth()->guard('midwife')->check()) {
            $midwife = auth()->guard('midwife')->user();
            $debug['auth_method'] = 'midwife_guard';
        } elseif (auth()->guard('web')->check()) {
            $midwife = auth()->guard('web')->user();
            $debug['auth_method'] = 'web_guard';
        } elseif (auth()->check()) {
            $midwife = auth()->user();
            $debug['auth_method'] = 'default_guard';
        } else {
            // Try to get from session
            if (session()->has('midwife_id')) {
                $midwife = User::find(session('midwife_id'));
                $debug['auth_method'] = 'session_midwife_id';
            } elseif (session()->has('user_id')) {
                $midwife = User::find(session('user_id'));
                $debug['auth_method'] = 'session_user_id';
            }
        }
        
        $debug['midwife_id'] = $midwife ? $midwife->id : null;
        
        if (!$midwife) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Anda harus login sebagai bidan untuk membuat janji temu',
                'debug' => [
                    'auth_guards_checked' => ['midwife', 'web', 'default'],
                    'session_data' => [
                        'has_midwife_id' => session()->has('midwife_id'),
                        'has_user_id' => session()->has('user_id'),
                    ]
                ]
            ], 401);
        }
        
        // Check for existing appointments at the same time
        $existingAppointment = Appointment::where('midwife_id', $midwife->id)
            ->where('date_time', $validated['date_time'])
            ->where('status', '!=', 'cancelled')
            ->first();
            
        if ($existingAppointment) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki janji temu pada waktu tersebut',
                'debug' => [
                    'existing_appointment_id' => $existingAppointment->id
                ]
            ], 422);
        }
        
        // Create appointment data
        $appointmentData = [
            'user_id' => $userId,
            'midwife_id' => $midwife->id,
            'date_time' => $validated['date_time'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ];
        
        $debug['appointment_data'] = $appointmentData;
        
        // Create the appointment
        $appointment = Appointment::create($appointmentData);
        
        // Load relationships for response
        $appointment->load(['user', 'midwife']);
        
        return response()->json([
            'success' => true,
            'message' => 'Janji temu berhasil dibuat',
            'data' => [
                'appointment' => $appointment,
                'formatted_date_time' => $appointment->created_at->format('d M Y H:i'),
                'user' => [
                    'id' => $appointment->user->id,
                    'name' => $appointment->user->name,
                ],
                'midwife' => [
                    'id' => $appointment->midwife->id,
                    'name' => $appointment->midwife->name,
                ]
            ],
            'debug' => config('app.debug') ? $debug : null
        ], 201);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak valid',
            'errors' => $e->errors(),
            'debug' => config('app.debug') ? $debug : null
        ], 422);
        
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Appointment creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'user_id' => $userId,
            'request_data' => $request->all()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat janji temu',
            'error' => config('app.debug') ? $e->getMessage() : 'Terjadi kesalahan sistem',
            'debug' => config('app.debug') ? [
                'exception_class' => get_class($e),
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'debug_data' => $debug
            ] : null
        ], 500);
    }
}

private function sendNotificationToUser($appointment)
{
    // Contoh implementasi notifikasi ke user
    $user = $appointment->user;
    $midwife = $appointment->midwife;
    
    // Kirim email/SMS/push notification ke user
    // Mail::to($user->email)->send(new AppointmentCreated($appointment));
    
    // Atau simpan ke tabel notifications
    // $user->notifications()->create([
    //     'title' => 'Janji Temu Baru',
    //     'message' => "Janji temu Anda dengan {$midwife->name} telah dijadwalkan pada " . $appointment->date_time,
    //     'type' => 'appointment_created'
    // ]);
}

// Method untuk mengirim notifikasi ke midwife
private function sendNotificationToMidwife($appointment)
{
    // Contoh implementasi notifikasi ke midwife
    $user = $appointment->user;
    $midwife = $appointment->midwife;
    
    // Kirim notifikasi ke midwife
    // Mail::to($midwife->email)->send(new AppointmentScheduled($appointment));
    
    // Atau simpan ke tabel notifications
    // $midwife->notifications()->create([
    //     'title' => 'Janji Temu Baru',
    //     'message' => "Janji temu baru dengan {$user->name} pada " . $appointment->date_time,
    //     'type' => 'appointment_scheduled'
    // ]);
}





}
