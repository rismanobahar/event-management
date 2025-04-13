<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Event::all(); // Return all events from the database
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([ // Create a new event
            ...$request->validate([ // Validate the request data
                'name' => 'required|string|max:255', // Event name is required
                'description' => 'nullable|string', // Event description is optional
                'start_time' => 'required|date', // Event start time is required and must be a valid date
                'end_time' => 'required|date|after:start_time' // Event end time is required, must be a valid date, and must be after the start time
            ]),
            'user_id' => 1 // User ID is hardcoded for now, 1 means that this will be the first user
        ]);

        return $event;
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return $event; // Return the specified event from the database
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event->update( // update the specified event
            $request->validate([ // Validate the request data
                'name' => 'sometimes|string|max:255', // Event name is required
                'description' => 'nullable|string', // Event description is optional
                'start_time' => 'sometimes|date', // Event start time is required and must be a valid date
                'end_time' => 'sometimes|date|after:start_time' // Event end time is required, must be a valid date, and must be after the start time
            ])
        );

        return $event; // Return the updated event
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete(); // Delete the specified event from the database

        return response()->json([ // Return a JSON response
            'message' => 'Event deleted successfully' // Return a success message
        ]);

        // return response(stats: 204); // Another way of response that return a 204 but with No Content response
    }
}