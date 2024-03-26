<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Individual;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Randomly choose a contactable type (either Company or Individual)
        $contactableType = $this->faker->randomElement([Company::class, Individual::class]);

        // Create a new instance of the chosen type
        $contactable = $contactableType::factory()->create();

        return [
            'contactable_type' => $contactableType,
            'contactable_id' => $contactable->id,

            'VAT' => $this->faker->iban('BE'),

            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),

            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
        ];
    }
}
