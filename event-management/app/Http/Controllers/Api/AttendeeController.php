<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    use CanLoadRelationships; // Use the CanLoadRelationships trait to load relationships dynamically

    private array $relations = ['user']; // Define the relationships to be eager loaded

    public function __construct(){
        $this->middleware('auth:sanctum')->except(['index', 'show', 'update']); // Apply the auth middleware to all methods except index and show
        $this->middleware('throttle');
        $this->authorizeResource(Attendee::class, 'attendee'); // Authorize the resource using the Attendee model and the attendee policy
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $attendees = $event->attendees()->latest(); // Get the latest attendees for the specified event

        return AttendeeResource::collection( // Return a collection of attendees
            $attendees->paginate() // Paginate the attendees
        ); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        // $attendee = $event->attendees()->create([
        //     'user_id' => 1
        // ]);

        $attendee = $this->loadRelationships(
            $event->attendees()->create([
                'user_id' => $request->user()->id // Get the authenticated user's ID
            ])
        );

        return new AttendeeResource($attendee); // Return the newly created attendee resource
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($attendee); // Return the specified attendee resource
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
    public function destroy(Event $event, Attendee $attendee)
    {
        /* we are no longer need authorization here because we already have a policy for the Attendee model
         * and we are using the authorizeResource method in the constructor to authorize the resource
         * so we can remove the authorization here.
         */
        // $this->authorize('delete-attendee', [$event, $attendee]); // Authorize the user to delete the attendee
        $attendee->delete(); // Delete the specified attendee
        
        return response(status: 204); // Return a 204 No Content response
    }
}
