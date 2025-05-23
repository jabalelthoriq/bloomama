<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
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
        if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'admin') {
            abort(403, 'Admin access required');
        }
    }
    /**
     * Validation rules for event
     */
    private $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date_time' => 'required|date',
        'end_date_time' => 'required|date|after:start_date_time',
    ];

    /**
     * Show events list
     */
      public function showevent()
{
    $now = Carbon::now();

    $events = Event::orderByRaw("CASE WHEN status = 'event end' THEN 1 ELSE 0 END")
             ->orderBy('start_date_time', 'ASC')
             ->paginate(10);

    return view('admin/acara', compact('events'));
}

    /**
     * Add a new event
     */
    public function addEvent(Request $request, FlasherInterface $flasher)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            // If this is an AJAX request expecting JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // For regular form submission
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date_time' => $request->start_date_time,
                'end_date_time' => $request->end_date_time,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event created successfully',
                    'event' => $event
                ]);
            }
            flash('Your changes have been saved!');


            return redirect()->back();

        } catch (\Exception $e) {
            Log::error("Error creating event: " . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create event',
                    'error' => $e->getMessage()
                ], 500);
            }

            // Add Flasher notification for error
            $flasher->addError('Gagal menambahkan event: ' . $e->getMessage());

            return redirect()->back()
                ->withInput();
        }
    }

    /**
     * Show edit event form
     */


    /**
     * Update an existing event
     */
    public function updateEvent(Request $request, $id)
    {
        // Find the event
         $event = Event::where('event_id', $id)->firstOrFail();
        // Check if event exists
        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found'
            ], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'start_date_time' => 'sometimes|required|date',
            'end_date_time' => 'sometimes|required|date|after_or_equal:start_date_time',
            'status' => 'sometimes|required|in:active,cancelled,postponed,completed',
        ]);

        // Return error if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update event with validated data
        $event->fill($request->only([
            'title',
            'description',
            'start_date_time',
            'end_date_time',
            'status',
        ]));

        // Save the updated event
        $event->save();

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Event updated successfully',
            'data' => $event
        ], 200);
    }

    /**
     * Delete an event
     */
    public function destroyEvent($id, FlasherInterface $flasher)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            $flasher->addSuccess('Event berhasil dihapus');
            return redirect()->route('acara');
        } catch (\Exception $e) {
            Log::error("Error deleting event: " . $e->getMessage());
            $flasher->addError('Gagal menghapus event: ' . $e->getMessage());
            return redirect()->route('acara');
        }
    }

    /**
     * Update event status
     */
    public function updateStatus(Request $request, $id, FlasherInterface $flasher)
    {
        // Validate status
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,cancelled,completed,pending'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $event = Event::findOrFail($id);
            $event->status = $request->status;
            $event->save();

            $flasher->addSuccess('Status event berhasil diperbarui');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error("Error updating event status: " . $e->getMessage());
            $flasher->addError('Gagal memperbarui status event: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
