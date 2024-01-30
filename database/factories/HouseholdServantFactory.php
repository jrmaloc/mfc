<?php

namespace Database\Factories;

use App\Models\AreaServant;
use App\Models\HouseholdServant;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HouseholdServant>
 */
class HouseholdServantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'household_name' => fake()->name,
            'email'=> fake()->unique()->email,
            'password' => fake()->unique()->password,
            'contact_number' => fake()->unique()->phoneNumber,
            'area' => fake()->randomElement(HouseholdServant::$area),
            'chapter' => fake()->randomElement(HouseholdServant::$chapter),
            'gender' => fake()->randomElement(HouseholdServant::$gender),
            'status' => fake()->randomElement(HouseholdServant::$status),
        ];
    }
}
