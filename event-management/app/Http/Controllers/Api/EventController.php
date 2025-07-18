<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    use CanLoadRelationships; // Use the CanLoadRelationships trait to load relationships dynamically
    private array $relations = ['user', 'attendees', 'attendees.user']; // Define the relationships to be eager loaded

    public function __construct(){
        $this->middleware('auth:sanctum')->except(['index', 'show']); // Apply the auth middleware to all methods except index and show.
        // $this->middleware('throttle:60,1') //this was before using api
        $this->middleware('throttle:api') // this is after using api from RouteServiceProvider.php 
        ->only(['store', 'update', 'destroy']); // Apply the throttle middleware to the store and destroy methods, allowing 60 requests per minute
        $this->authorizeResource(Event::class, 'event'); // Authorize the resource using the Event model and the event policy
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**The below code is moved as global variable */
        // $relations = ['user', 'attendees', 'attendees.user']; // Define the relationships to be eager loaded. it is moved above 
        /** the $relations is removed because it already has a global variable */
        // $query = $this->loadRelationships(Event::query(), $relations); // Load the relationships dynamically using the CanLoadRelationships trait
        $query = $this->loadRelationships(Event::query()); // Load the relationships dynamically using the CanLoadRelationships trait 

        /** the following code is deleted because it is moved to the CanLoadRelationships trait file
         * and the loadRelationships method is used to load the relationships dynamically
         */
        // foreach ($relations as $relation){
        //     $query->when( 
        //         $this->shouldIncludeRelation($relation), // Check if the relationship should be included
        //         fn($q) => $q->with($relation) // Eager load the relationship
        //     );
        // }

        /* the following code check if the user relationship should be included in the response.
         this code is only used to test the function */
        // $this->shouldIncludeRelation('user');

        // return Event::all(); // Return all events from the database
        /* updated to the following line */
        // return EventResource::collection(Event::all()); // Return all events from the database
        /* updated to the following line */ 
        return EventResource::collection(
            // Event::with('user')->paginate()
            /* the above line is not used because it already has a query with the necessary relationship */
            $query->latest()->paginate() // Return all events from the database with pagination
        ); // Return all events from the database with the user relationship
    }

    /* the following method is used to check if the user relationship should be included in the response. 
    * so basically this method checks if the 'include' query parameter is present in the request and if it contains the specified relation.
    * for example if the request is /api/events?include=user, it will return true for the user relation.
    * if the request is /api/events?include=user,attendees it will return true for both user and attendees relations.
    * if the request is /api/events?include=user,attendees.attendees.user it will return true for both user, attendees, and attendees.user relations.
    * the code is moved to CanLoadRelationship.php trait file to be reused in other controllers.
    */
    
    // protected function shouldIncludeRelation(string $relation): bool
    // {
    //     $include = request()->query('include'); // Get the 'include' query parameter from the request

    //     if (!$include) {
    //         return false; // If the 'include' parameter is not present, return false
    //     }

    //     // $relations = explode(',', $include); // Split the 'include' parameter by commas
    //     $relations = array_map('trim', explode(',', $include)); // Split the 'include' parameter by commas and trim whitespace if the endpoint is a string with spaces

    //     // dd($include); // Debugging line to check the include parameter
    //     // dd($relations); // Debugging line to check the relations and turn it into an array
       
    //     /* after there is a trim function to remove the spaces, we can
    //        use the following line to check if the relation is in the array of
    //        relations, not using dd anymore */
        
    //     return in_array($relation, $relations); // Check if the specified relation is in the array of relations
    // }

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
            // 'user_id' => 1 // User ID is hardcoded for now, 1 means that this will be the first user
            'user_id' => $request->user()->id // Get the authenticated user's ID
        ]);
        // return new EventResource($event); // Return the created event
        return new EventResource($this->loadRelationships($event)); // Return the created event
    }

    /**
     * Display the specified resource.
     *  // why the syntax is different from the one in the index method? because in the index method we are
     *  // using EventResource::collection() but in this method we are using new EventResource($event) because we are returning a single event not a collection of events
     */
    public function show(Event $event)
    {
        // return $event; // Return the specified event from the database
        // $event->load('user', 'attendees'); // Load the user relationship for the specified event
        // return new EventResource($event); // Return the specified event from the database with the user relationship
        return new EventResource(
            $this->loadRelationships($event)
        ); // Return the specified event from the database with the user relationship
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        /* the following code is used to check if the user is authorized to update the event. */
        // if (Gate::denies('update-event', $event)){ // Check if the user is authorized to update the event
        //     abort(403, 'You are not authorized to update this event.'); // If not authorized, return a 403 Forbidden response
        // }

        /** the following code is the simpler way and used to check if the user is authorized to update the event. 
         * it is no longer needed because we are using the authorizeResource method in the constructor and using policy
        */
        // $this->authorize('update-event', $event); // Authorize the user to update the event

        $event->update( // update the specified event
            $request->validate([ // Validate the request data
                'name' => 'sometimes|string|max:255', // Event name is required
                'description' => 'nullable|string', // Event description is optional
                'start_time' => 'sometimes|date', // Event start time is required and must be a valid date
                'end_time' => 'sometimes|date|after:start_time' // Event end time is required, must be a valid date, and must be after the start time
            ])
        );

        // return $event; // Return the updated event
        // return new EventResource($event); // Return the updated event
        // return new EventResource($event); // Return the updated event
        return new EventResource($this->loadRelationships($event)); // Return the updated event
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