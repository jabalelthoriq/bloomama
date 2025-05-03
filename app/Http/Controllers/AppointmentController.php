<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
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
    /**
     * Display a listing of appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():\Illuminate\Contracts\View\View
    {
        $appointments = Appointment::orderBy('visit_time_start', 'asc')->paginate(5);
        return view('dashboard', [
            'appointments' => $appointments,
            'activePage' => 'appointments'
        ]);
    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create():\Illuminate\Contracts\View\View
    {
        return view('dashboard', [
            'view' => 'appointments.create',
            'activePage' => 'appointments'
        ]);
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request):\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'visit_time_start' => 'required|date',
            'visit_time_end' => 'required|date|after:visit_time_start',
            'doctor_name' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
        ]);

        Appointment::create($request->all());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Show the form for editing the specified appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment):\Illuminate\Contracts\View\View
    {
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment):\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'midwife_id' => 'required|integer',
            'hospital_id' => 'required|integer',
            'date_time' => 'required|date',
            'status' => 'required|in:pending,confirmed,completed,canceled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Appointment updated successfully');
    }

    /**
     * Remove the specified appointment from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment):\Illuminate\Http\RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully');
    }
}
