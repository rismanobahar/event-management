<?php

namespace App\Providers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /* Gate is a simple way to define authorization logic in your application.
        * Gates are similar to policies, but they are not associated with a specific model.
        * Gates are typically defined in the AuthServiceProvider class and can be used to authorize actions based on any condition.
        * Gates are defined using the Gate::define method, which takes a name and a closure as arguments.
        * The closure receives the authenticated user and any additional parameters needed to determine if the action is authorized.
        * The closure should return true if the action is authorized, or false if it is not.
        * Gates are typically used for actions that are not tied to a specific model, such as creating or deleting resources.
        * Gates can be used in controllers, views, and anywhere else in your application where you need to check if a user is authorized to perform an action.
        * Now that we already have a policy for the Event and Attendee models, we are no longer using gates to authorize actions on these models.
        */

        // Gate::define('update-event', function ($user, Event $event) { // Check if the user is the owner of the event
        //     return $user->id === $event->user_id; // Assuming the event has a user_id field
        // });

        // Gate::define('delete-attendee', function ($user, Event $event, Attendee $attendee){ // Check if the user is the owner of the event or the attendee
        //     return $user->id === $event->user_id || 
        //     $user->id === $attendee->user_id; // Check if the user is the owner of the event or the attendee
        // });
    }
}
