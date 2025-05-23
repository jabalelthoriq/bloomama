<?php

namespace App\Http\Controllers;

use App\Models\Midwive;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\UserPregnant;
use App\Models\HealthTracking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Flasher\Prime\FlasherInterface;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    /**
     * Constructor to check admin role for all methods
     */
    public function __construct()
    {
        $this->checkAdminAccess();
    }

    /**
     * Check if the authenticated user is a midwife with admin role
     */
    private function checkAdminAccess()
    {
        // Check if user is authenticated as midwife
        if (!Auth::guard('midwife')->check()) {
            abort(403, 'Unauthorized access');
        }

        // Check if midwife has admin role
        $midwife = Auth::guard('midwife')->user();

        // Check if role field exists, is not null, and is set to 'admin'
        if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'admin') {
            abort(403, 'Admin access required');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function menu1()
    {
        $appointments = Appointment::orderBy('date_time', 'asc')->paginate(5);
        $totalAppointment = Appointment::count();
        $totalUsers = User::count();
        $totalPregnant = UserPregnant::count();

        $monthlyData = DB::table('user_pregnancies')
            ->selectRaw('MONTH(start_date) as month, YEAR(start_date) as year, COUNT(*) as count')
            ->whereNotNull('start_date')
            ->where('start_date', '>=', now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                // Create a Carbon date to get the month name
                $date = Carbon::createFromDate($item->year, $item->month, 1);
                $item->month_name = $date->format('M');
                $item->month_year = $date->format('M Y');
                return $item;
            });

       $midwives = Midwive::orderBy('created_at', 'desc')->paginate(5, ['*'], 'midwife_page');

         $users = User::orderBy('created_at', 'desc')->paginate(5, ['*'], 'user_page');
        return view('admin/menu1',compact('users', 'midwives'), [
            'totalUsers' => $totalUsers,
            'totalPregnant' => $totalPregnant,
            'totalAppointment' => $totalAppointment,
            'appointments' => $appointments,
            'activePage' => 'admin/menu1'
        ]);
    }

    public function showUsersAndMidwives()
    {
        // In your controller
        $midwives = Midwive::orderBy('created_at', 'desc')->paginate(10, ['*'], 'midwife_page');
        $users = User::orderBy('created_at', 'desc')->paginate(10, ['*'], 'user_page');
        return view('admin/menu2', compact('users', 'midwives'));
    }

 public function storeMidwife(Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:midwives',
        'password' => 'required|string|min:8|confirmed',
        'phone_number' => 'required|string|max:15',
        'role' => 'nullable|string|in:admin,midwife',
        'status' => 'nullable|string|in:active,inactive',
        'available_day' => 'nullable|string',
        'start_time' => 'nullable|string',
    ]);

    try {
        Midwive::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
            'role' => $validated['role'] ?? 'midwife',
            'status' => $validated['status'] ?? 'active',
            'available_day' => $validated['available_day'] ?? null,
            'start_time' => $validated['start_time'] ?? null,
        ]);

        return redirect()->route('admin.user')->with('success', 'Bidan berhasil ditambahkan.');
    } catch (\Exception $e) {
        Log::error("Error creating midwife: " . $e->getMessage());
        return back()->withInput()->with('error', 'Gagal menambahkan bidan');
    }
}
/**
 * Update user information
 *
 * @param Request $request
 * @param string $id
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 */
public function update(Request $request, $id)
{
    DB::beginTransaction();
    try {
        $user = User::where('user_id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id.',user_id',
            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            // Delete old file if exists
            if ($user->profile_picture) {
                Storage::delete('public/'.$user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('users', 'public');
            $updateData['profile_picture'] = $path;
        }

        $user->update($updateData);

        DB::commit();

        // Jika request adalah AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil diperbarui',
                'id' => $user->user_id
            ]);
        }

        // Untuk request non-AJAX, redirect dengan flasher
        flash()->addSuccess('Data pasien berhasil diperbarui');
        return redirect()->route('admin.user');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating pasien: '.$e->getMessage());

        // Jika request adalah AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: '.$e->getMessage()
            ], 500);
        }

        // Untuk request non-AJAX, redirect dengan flasher
        flash()->addError('Terjadi kesalahan: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
}
public function destroyUsers(string $id, FlasherInterface $flasher)
{
    try {
        $user = User::findOrFail($id);

        // Delete profile picture if exists
        if ($user->profile_picture && file_exists(public_path('storage/' . $user->profile_picture))) {
            unlink(public_path('storage/' . $user->profile_picture));
        }

        // Check if there are related records before deleting
        // You might want to check if the user has appointments, pregnancy records, etc.
        // and handle them accordingly (delete or set null references)

        // Check for related UserPregnant records
        $pregnancyRecords = UserPregnant::where('user_id', $id)->count();
        if ($pregnancyRecords > 0) {
            // Option 1: Prevent deletion if there are related records
            // $flasher->addWarning('Tidak dapat menghapus pengguna karena memiliki data kehamilan');
            // return redirect()->route('admin.user');

            // Option 2: Delete related records
            UserPregnant::where('user_id', $id)->delete();
        }

        // Check for related HealthTracking records
        $healthRecords = HealthTracking::where('user_id', $id)->count();
        if ($healthRecords > 0) {
            HealthTracking::where('user_id', $id)->delete();
        }

        // Check for related Appointment records
        $appointmentRecords = Appointment::where('user_id', $id)->count();
        if ($appointmentRecords > 0) {
            Appointment::where('user_id', $id)->delete();
        }

        // Delete the user
        $user->delete();
        $flasher->addSuccess('Pengguna berhasil dihapus');

        return redirect()->route('admin.user');
    } catch (\Exception $e) {
        Log::error("Error deleting user: " . $e->getMessage());
        $flasher->addError('Gagal menghapus pengguna');
        return redirect()->route('admin.user');
    }
}

public function updateMidwife(Request $request, $id) {
    DB::beginTransaction();
    try {
        $midwife = Midwive::where('midwife_id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:midwives,email,'.$id.',midwife_id',
            'phone_number' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
            'available_day' => 'nullable|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
            'available_day' => $request->available_day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            // Delete old file if exists
            if ($midwife->profile_picture) {
                Storage::delete('public/'.$midwife->profile_picture);
            }

            $path = $request->file('profile_picture')->store('midwives', 'public');
            $updateData['profile_picture'] = $path;
        }

        $midwife->update($updateData);

        DB::commit();

        // Jika request adalah AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data bidan berhasil diperbarui',
                'id' => $midwife->midwife_id
            ]);
        }

        // Untuk request non-AJAX, redirect dengan flash notification
        flash()->addSuccess('Data bidan berhasil diperbarui');
        return redirect()->route('admin.user');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error updating bidan: '.$e->getMessage());

        // Jika request adalah AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: '.$e->getMessage()
            ], 500);
        }

        // Untuk request non-AJAX, redirect dengan flash notification
        flash()->addError('Terjadi kesalahan: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
