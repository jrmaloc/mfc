<?php

namespace Database\Factories;

use App\Models\Tithe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tithe>
 */
class TitheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email'=> fake()->unique()->email,
            'contact_number' => fake()->unique()->phoneNumber,
            'transaction_number' => fake()->unique()->bothify('###???????'),
            'amount' => fake()->unique()->numberBetween(1_000, 10_000),
            'mop' => fake()->randomElement(Tithe::$mop),
            'timestamp' => fake()->dateTime
        ];
    }
}