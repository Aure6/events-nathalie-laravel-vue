<?php

namespace Database\Factories;

use App\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(2),
            'start' => $this->faker->dateTimeBetween('-52 week', '+52 week'),
            'end' => $this->faker->dateTimeBetween('-52 week', '+52 week'),
            'organizer_id' => Organizer::get()->random()->id,
            'address' => $this->faker->address(),
        ];
    }
}
