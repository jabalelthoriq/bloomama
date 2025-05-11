<?php

namespace App\Http\Controllers;

use App\Models\Midwive;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\UserPregnant;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
