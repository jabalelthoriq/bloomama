<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
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
        $events = Event::orderBy('start_date_time', 'asc')->paginate(10);
        return view('acara', compact('events'));
    }

    /**
     * Add a new event
     */
    public function addEvent(Request $request)
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

            return redirect()->route('acara')->with('success', 'Event berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error("Error creating event: " . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create event',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to create event: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show edit event form
     */
    public function editEvent($id)
    {
        try {
            $event = Event::findOrFail($id);
            return view('event.edit', compact('event'));
        } catch (\Exception $e) {
            Log::error("Error finding event: " . $e->getMessage());
            return redirect()->route('acara')
                ->with('error', 'Event tidak ditemukan');
        }
    }

    /**
     * Update an existing event
     */
    public function updateEvent(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Find the event or throw a 404 error
            $event = Event::findOrFail($id);

            // Update the event
            $event->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_date_time' => $request->start_date_time,
                'end_date_time' => $request->end_date_time,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event updated successfully',
                    'event' => $event
                ]);
            }

            // Redirect with success message
            return redirect()->route('acara')
                ->with('success', 'Event berhasil diperbarui');
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error updating event: " . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update event',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui event')
                ->withInput();
        }
    }

    /**
     * Delete an event
     */
    public function destroyEvent($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            return redirect()->route('acara')->with('success', 'Event berhasil dihapus');
        } catch (\Exception $e) {
            Log::error("Error deleting event: " . $e->getMessage());
            return redirect()->route('acara')->with('error', 'Gagal menghapus event');
        }
    }

    /**
     * Update event status
     */
    public function updateStatus(Request $request, $id)
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

            return redirect()->back()->with('success', 'Status event berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error("Error updating event status: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui status event');
        }
    }
}
