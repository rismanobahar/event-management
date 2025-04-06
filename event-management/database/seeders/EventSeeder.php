<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all(); // Get all users from the database
        for ($i = 0; $i < 200; $i++){ // Create 200 events
            $user = $users->random(); // Randomly select a user
            \App\Models\Event::factory()->create([ // Create a new event record
                'user_id' => $user->id // Set the user ID
            ]);
        }
    }
}
