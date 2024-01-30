<?php

namespace Database\Factories;

use App\Models\AreaServant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AreaServant>
 */
class AreaServantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'area_name' => fake()->name,
            'email'=> fake()->unique()->email,
            'password'=> fake()->unique()->password,
            'contact_number' => fake()->unique()->phoneNumber,
            'area' => fake()->randomElement(AreaServant::$area),
            'chapter' => fake()->randomElement(AreaServant::$chapter),
            'gender' => fake()->randomElement(AreaServant::$gender),
            'status' => fake()->randomElement(AreaServant::$status),
        ];
    }
}