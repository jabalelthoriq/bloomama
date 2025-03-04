<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $appointments = Appointment::orderBy('date_time', 'asc')->paginate(5);
        
        return view('dashboard', [
            'appointments' => $appointments,
            'activePage' => 'dashboard'
        ]);
    }
} 