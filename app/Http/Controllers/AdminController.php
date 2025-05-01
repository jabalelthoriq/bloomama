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



class AdminController extends Controller
{
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

            $midwives = Midwive::paginate(5, ['*'], 'midwife_page');
             $users = User::paginate(5, ['*'], 'user_page');
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
    $midwives = Midwive::paginate(10, ['*'], 'midwife_page');
    $users = User::paginate(10, ['*'], 'user_page');
    return view('admin/menu2', compact('users', 'midwives'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
