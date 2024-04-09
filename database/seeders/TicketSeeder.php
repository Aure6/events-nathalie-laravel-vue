<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();

        foreach ($events as $event) {
            Ticket::create([
                'name' => 'Particulier',
                'price' => 10.00,
                'event_id' => $event->id,
            ]);

            Ticket::create([
                'name' => 'Entreprise de moins de 10 personnes',
                'price' => 15.00,
                'event_id' => $event->id,
            ]);

            Ticket::create([
                'name' => 'Entreprise de plus de 10 personnes',
                'price' => 25.00,
                'event_id' => $event->id,
            ]);
        }
    }
}
