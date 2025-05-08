<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications to all event attendees that will starting soon'; // Description of the command

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
            ->whereBetween('start_time', [now(), now()->addDay()]) // Fetch events starting within the next day
            ->get(); // Fetch events starting within the next day with their attendees

        $eventCount = $events->count(); // Count the number of events
        $eventLabel = Str::plural('event', $eventCount); // Get the pluralized label for events, means if there are 1 event or 2 events

        $this->info("Found {$eventCount} {$eventLabel}."); // Display the number of events found

        $events->each(fn ($event) => $event->attendees->each(
            fn ($attendee) => $this->info("Notifying the user {$attendee->user->id}")
        )); // Notify each attendee of the event
        
        $this->info('Reminder notification sent successfully!'); // Display a success message
    }
}
