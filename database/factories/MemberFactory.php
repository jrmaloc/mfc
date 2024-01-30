<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
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
            'username' => fake()->unique()->userName,
            'password' => fake()->unique()->password,
            'contact_number' => fake()->unique()->phoneNumber,
            'area' => fake()->randomElement(Member::$area),
            'chapter' => fake()->randomElement(Member::$chapter),
            'gender' => fake()->randomElement(Member::$gender),
            'status' => fake()->randomElement(Member::$status),
        ];
    }
}
