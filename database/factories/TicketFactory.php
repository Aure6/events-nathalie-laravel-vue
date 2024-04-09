<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // TO CHANGE
            'name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(0, 100),
            'event_id' => Event::get()->random()->id,
        ];
    }
}
