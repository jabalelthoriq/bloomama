<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPregnant;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->checkAdminAccess();
    }

    /**
     * Check if the authenticated user is a midwife with admin role
     */
    private function checkAdminAccess()
    {
        if (!Auth::guard('midwife')->check()) {
            abort(403, 'Unauthorized access');
        }

        $midwife = Auth::guard('midwife')->user();

        if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'midwife') {
            abort(403, 'midwife access required');
        }
    }

    public function index()
{
    // Mendapatkan midwife_id dari midwife yang sedang login menggunakan guard 'midwife'
    $midwifeId = Auth::guard('midwife')->user()->midwife_id;
    
    // Alternatif lain untuk mendapatkan midwife_id:
    // $midwifeId = auth('midwife')->user()->midwife_id;
    // atau dari session:
    // $midwifeId = Session::get('user_data.midwife_id');
    
    // Filter appointments berdasarkan midwife_id
    $appointments = Appointment::whereIn('status', ['pending', 'completed', 'canceled'])
        ->where('midwife_id', $midwifeId) // Tambahkan filter midwife_id
        ->orderByRaw("CASE 
            WHEN status = 'pending' THEN 1 
            WHEN status = 'completed' THEN 2 
            WHEN status = 'canceled' THEN 3 
            ELSE 4 
        END")
        ->orderBy('date_time', 'asc')
        ->paginate(5);

    // Filter total appointment berdasarkan midwife_id
    $totalAppointment = Appointment::whereIn('status', ['pending'])
        ->where('midwife_id', $midwifeId) // Tambahkan filter midwife_id
        ->count();

    $totalUsers = User::count();
    $totalPregnant = UserPregnant::count();

    // Statistik kehamilan per bulan - jika perlu filter berdasarkan midwife juga
    $monthlyData = DB::table('user_pregnancies')
        ->selectRaw('MONTH(start_date) as month, YEAR(start_date) as year, COUNT(*) as count')
        ->whereNotNull('start_date')
        ->whereYear('start_date', 2025)
        // Tambahkan join jika ada relasi dengan midwife
        // ->join('appointments', 'user_pregnancies.user_id', '=', 'appointments.user_id')
        // ->where('appointments.midwife_id', $midwifeId)
        ->groupBy('year', 'month')
        ->orderBy('month')
        ->get()
        ->map(function ($item) {
            $date = Carbon::createFromDate($item->year, $item->month, 1);
            $item->month_name = $date->format('M');
            $item->month_year = $date->format('M');
            return $item;
        });

    $filledMonthlyData = $this->fillMissingMonths($monthlyData);

    // Statistik pendaftaran user per bulan
    $userMonthlyData = DB::table('users')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
        ->whereYear('created_at', 2025)
        ->groupBy('year', 'month')
        ->orderBy('month')
        ->get()
        ->map(function ($item) {
            $date = Carbon::createFromDate($item->year, $item->month, 1);
            $item->month_name = $date->format('M');
            $item->month_year = $date->format('M');
            return $item;
        });

    $filledUserMonthlyData = $this->fillMissingMonths($userMonthlyData);

    return view('dashboard', [
        'totalUsers' => $totalUsers,
        'totalPregnant' => $totalPregnant,
        'totalAppointment' => $totalAppointment,
        'appointments' => $appointments,
        'monthlyData' => $filledMonthlyData,
        'userMonthlyData' => $filledUserMonthlyData,
        'activePage' => 'dashboard'
    ]);
}

    private function fillMissingMonths($monthlyData)
    {
        $result = [];

        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::create(2025, 12, 31);
        $period = CarbonPeriod::create($startDate->startOfMonth(), '1 month', $endDate->endOfMonth());

        $dataByMonth = [];
        foreach ($monthlyData as $data) {
            $key = $data->year . '-' . str_pad($data->month, 2, '0', STR_PAD_LEFT);
            $dataByMonth[$key] = $data;
        }

        foreach ($period as $date) {
            $key = $date->format('Y-m');
            $monthName = $date->format('M');
            $monthYear = $date->format('M');

            if (isset($dataByMonth[$key])) {
                $result[] = $dataByMonth[$key];
            } else {
                $emptyMonth = (object)[
                    'month' => intval($date->format('m')),
                    'year' => intval($date->format('Y')),
                    'count' => 0,
                    'month_name' => $monthName,
                    'month_year' => $monthYear
                ];
                $result[] = $emptyMonth;
            }
        }

        return $result;
    }
}