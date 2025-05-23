<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{

    public function __construct()
    {
        // SEMENTARA DIMATIKAN UNTUK TESTING - AKTIFKAN KEMBALI SETELAH BERHASIL
        // $this->checkAdminAccess();
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

        // Check if role field exists, is not null, and is set to 'midwife'
        if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'midwife') {
            abort(403, 'midwife access required');
        }
    }
    
    /**
     * Display a listing of appointments.
     */
    public function index()
    {
        $appointments = Appointment::orderBy('id', 'desc')->paginate(5);
        return view('dashboard', [
            'appointments' => $appointments,
            'activePage' => 'appointments'
        ]);
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        return view('dashboard', [
            'view' => 'appointments.create',
            'activePage' => 'appointments'
        ]);
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
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
     */
    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment)
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
     * VERSI YANG SUDAH DIPERBAIKI
     */
    public function destroy(Appointment $appointment)
{
    try {
        $appointmentData = [
            'id' => $appointment->id,
            'user_id' => $appointment->user_id,
            'status' => $appointment->status,
            'notes' => $appointment->notes,
        ];

        $appointment->delete();

        Log::info('Appointment deleted successfully', $appointmentData);
        return redirect()->back()->with('success', 'Appointment berhasil dihapus');
    } catch (\Exception $e) {
        Log::error('Error deleting appointment', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
        return redirect()->back()->with('error', 'Terjadi error: ' . $e->getMessage());
    }
}
}