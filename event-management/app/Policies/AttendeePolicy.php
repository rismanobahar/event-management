<?php

namespace App\Policies;

use App\Models\Attendee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendeePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Allow all users to view attendees
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Attendee $attendee): bool
    {
        return true; // Allow all users to view attendees
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Allow all authenticated users to create attendees
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendee $attendee): bool
    {
        return $user->id === $attendee->event->user_id || 
        $user->id === $attendee->user_id; // Check if the user is the owner of the event or the attendee
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attendee $attendee): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attendee $attendee): bool
    {
        //
    }
}
