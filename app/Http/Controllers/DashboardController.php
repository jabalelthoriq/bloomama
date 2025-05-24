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
        // Check if user is authenticated as midwife
        if (!Auth::guard('midwife')->check()) {
            abort(403, 'Unauthorized access');
        }

        // Check if midwife has admin role
        $midwife = Auth::guard('midwife')->user();

        // Check if role field exists, is not null, and is set to 'admin'
        if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'midwife') {
            abort(403, 'midwife access required');
        }
    }
    public function index()
    {
        $appointments = Appointment::orderBy('date_time', 'asc')->paginate(5);
        $totalAppointment = Appointment::count();
        $totalUsers = User::count();
        $totalPregnant = UserPregnant::count();

        $monthlyData = DB::table('user_pregnancies')
        ->selectRaw('MONTH(start_date) as month, YEAR(start_date) as year, COUNT(*) as count')
        ->whereNotNull('start_date')
        ->whereYear('start_date', 2025)
        ->groupBy('year', 'month')
        ->orderBy('month')
        ->get()
        ->map(function($item) {
            $date = Carbon::createFromDate($item->year, $item->month, 1);
            $item->month_name = $date->format('M');
            $item->month_year = $date->format('M');
            return $item;
        });


        // Fill in missing months with zero counts
        $filledMonthlyData = $this->fillMissingMonths($monthlyData);

        return view('dashboard', [
            'totalUsers' => $totalUsers,
            'totalPregnant' => $totalPregnant,
            'totalAppointment' => $totalAppointment,
            'appointments' => $appointments,
            'monthlyData' => $filledMonthlyData,
            'activePage' => 'dashboard'
        ]);
    }

   private function fillMissingMonths($monthlyData)
{
    $result = [];

    // Batasi hanya untuk tahun 2025
    $startDate = Carbon::create(2025, 1, 1);
    $endDate = Carbon::create(2025, 12, 31);

    // Buat periode 12 bulan
    $period = CarbonPeriod::create($startDate->startOfMonth(), '1 month', $endDate->endOfMonth());

    // Susun data berdasarkan bulan
    $dataByMonth = [];
    foreach ($monthlyData as $data) {
        $key = $data->year . '-' . str_pad($data->month, 2, '0', STR_PAD_LEFT);
        $dataByMonth[$key] = $data;
    }

    // Isi semua bulan di tahun 2025
    foreach ($period as $date) {
        $key = $date->format('Y-m');
        $monthName = $date->format('M');
        $monthYear = $date->format('M');

        if (isset($dataByMonth[$key])) {
            $result[] = $dataByMonth[$key];
        } else {
            // Tambahkan bulan kosong jika tidak ada data
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

