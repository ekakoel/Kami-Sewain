<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categories>
 */
class CategoriesFactory extends Factory
{
    protected $model = Categories::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Chair', 'Table', 'Decoration', 'Lighting', 'Glasses', 'Plate', 'Cushion', 'Arch']),
            'description' => $this->faker->paragraph(),
            'icon' => $this->faker->imageUrl(640, 480, 'products', true),
        ];
    }
}
