<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all(); // Get all users from the database
        $events = \App\Models\Event::all(); // Get all events from the database

        foreach ($users as $user) {
            $eventsToAttend = $events->random(rand(1, 3)); // Randomly select 1 to 3 events for each user

            foreach ($eventsToAttend as $event) {
                \App\Models\Attendee::create([ // Create a new attendee record
                    'user_id' => $user->id, // Set the user ID
                    'event_id' => $event->id // Set the event ID
                ]);
            }
        }
    }
}
