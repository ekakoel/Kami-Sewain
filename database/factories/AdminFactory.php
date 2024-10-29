<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;
    public function definition(): array
    {
        return [
            'username' => fake()->name,
            'fullname' => $this->faker->name,
            'email' => fake()->unique()->safeEmail(),
            'password' => Str::random(6),
            'remember_token' => Str::random(10),
        ];
    }
}
