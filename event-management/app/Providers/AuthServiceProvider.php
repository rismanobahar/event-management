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
        Gate::define('update-event', function ($user, Event $event) { // Check if the user is the owner of the event
            return $user->id === $event->user_id; // Assuming the event has a user_id field
        });

        Gate::define('delete-attendee', function ($user, Event $event, Attendee $attendee){ // Check if the user is the owner of the event or the attendee
            return $user->id === $event->user_id || 
            $user->id === $attendee->user_id; // Check if the user is the owner of the event or the attendee
        });
    }
}
