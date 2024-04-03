<?php

namespace Database\Factories;

use App\Models\Contact;
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
        $start = $this->faker->optional(0.5)->dateTimeBetween('-52 week', '+52 week');
        $end = $start ? $this->faker->dateTimeBetween($start, '+52 week') : null;

        return [
            'name' => $this->faker->bs(),
            'description' => $this->faker->realTextBetween($minNbChars = 160, $maxNbChars = 200),
            'body' => $this->faker->realTextBetween($minNbChars = 160, $maxNbChars = 2000),

            'start' => $start ? $start->format('Y-m-d H:i') : null,
            'end' => $end ? $end->format('Y-m-d H:i') : null,
            // 'start' => $this->faker->dateTimeBetween('-52 week', '+52 week')->format('Y-m-d H:i'),
            // 'end' => $this->faker->dateTimeBetween('-52 week', '+52 week')->format('Y-m-d H:i'),

            'registrations_limit' => $this->faker->optional(0.5)->numberBetween(1, 10),

            // the website doesn't seem to exist anymore
            // 'img_path' => function () {
            //     $absolutePath = fake()->image(storage_path('app/public/images'), 640, 480, 'cats', true);

            //     return str_replace(storage_path('app/public/'), '', $absolutePath);
            // },

            'organizer_id' => Contact::get()->random()->id,
            // 'organizer_id' => Organizer::get()->random()->id,

            'place_id' => Contact::get()->random()->id,
            // 'place' => $this->faker->company(),
        ];
    }
}
