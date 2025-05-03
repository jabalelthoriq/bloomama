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
        $endDate = now();
        $startDate = now()->subYear();

        // Create a period of 12 months
        $period = CarbonPeriod::create($startDate->startOfMonth(), '1 month', $endDate->endOfMonth());

        // Create an associative array with month-year as key
        $dataByMonth = [];
        foreach ($monthlyData as $data) {
            $key = $data->year . '-' . str_pad($data->month, 2, '0', STR_PAD_LEFT);
            $dataByMonth[$key] = $data;
        }

        // Fill in all months in the period
        foreach ($period as $date) {
            $key = $date->format('Y-m');
            $monthName = $date->format('M');
            $monthYear = $date->format('M Y');

            if (isset($dataByMonth[$key])) {
                $result[] = $dataByMonth[$key];
            } else {
                // Create an object with zero count for missing months
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
