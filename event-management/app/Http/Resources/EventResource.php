<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request); // Return the event data as an array and returning all the fields

        // the following code is used to return only the fields that are needed
        return [
            'id' => $this->id, // Event ID
            'name' => $this->name, // Event name
            'description' => $this->description, // Event description
            'start_time' => $this->start_time, // Event start time
            'end_time' => $this->end_time, // Event end time
            'user' => new UserResource($this->whenLoaded('user')), // User relationship, only load if it is loaded. user is earned from the Event model
            'attendees' => AttendeeResource::collection($this->whenLoaded('attendees')) // Attendees relationship, only load if it is loaded. attendees is earned from the Event model
        ];
    }
}
