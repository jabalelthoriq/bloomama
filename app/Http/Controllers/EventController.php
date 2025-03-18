<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function showevent()
    {
        $events = Event::orderBy('start_date_time', 'asc')->paginate(10);
        return view('acara', compact('events'));
    }

    public function addEvent(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
        ]);

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

    public function editEvent($id) {
        $event = Event::findOrFail($id); // This will throw a 404 if not found
        return view('edit-event', compact('event'));
    }

    public function updateEvent(Request $request, $id) {
        // Your validation code...

        $event = Event::findOrFail($id);
        $event->update($request->only(['title', 'description', 'start_date_time', 'end_date_time']));

        return redirect()->route('acara')->with('success', 'Event berhasil diperbarui');
    }

    public function destroyEvent($id) {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('acara')->with('success', 'Event berhasil dihapus');
    }
}
