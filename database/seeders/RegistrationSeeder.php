<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Registration::factory(20)->create();

        $events = Event::all(); // Assuming you have an Event model

        foreach ($events as $event) {
            // Generate a random number between 0 and 1
            $randomNumber = rand(0, 1);

            // If the random number is 1, create between 1 and 5 registrations
            if ($randomNumber == 1) {
                $numberOfRegistrations = rand(1, 5);

                for ($i = 0; $i < $numberOfRegistrations; $i++) {
                    Registration::factory()->create(['event_id' => $event->id]);
                }
            }
        }
    }
}
