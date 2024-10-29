<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    protected $model = Products::class;
    private static $productCount = 0;
    public function definition(): array
    {
        $coverOptions = [
            'arch_01.jpeg',
            'arch_02.jpeg',
            'arch_03.jpeg',
            'arch_04.jpeg',
            'chair_01.jpeg',
            'chair_02.jpeg',
            'chair_03.jpeg',
            'chair_04.jpeg',
            'chair_05.jpeg',
            'decor_01.jpeg',
            'decor_02.jpeg',
            'decor_03.jpeg',
            'lighting_01.jpeg',
            'lighting_02.jpeg',
            'lighting_03.jpeg',
            'lighting_04.jpeg',
            'lighting_05.jpeg',
            'plate_01.jpeg',
            'plate_02.jpeg',
            'plate_03.jpeg',
            'plate_04.jpeg',
            'table_01.jpeg',
            'table_02.jpeg',
            'table_03.jpeg',
            'table_04.jpeg',
            'table_05.jpeg',
            'table_06.jpeg',
        ]; 
        $baseProductNames = [
            'Chair',
            'Table',
            'Glass',
            'Plate',
            'Lighting',
            'Decoration',
            'Arch',
            'Cushion',
        ];
        $name = $this->generateUniqueProductName($baseProductNames);
        return [
            'name' => $name,
            'description' => $this->faker->paragraph(),
            'category_id' => $this->faker->numberBetween(1, 8),
            'model_id' => $this->faker->numberBetween(1, 10),
            'color_id' => $this->faker->numberBetween(1, 25),
            'material_id' => $this->faker->numberBetween(1, 11),
            'price' => $this->faker->numberBetween(50000, 1000000),
            'cover' => $this->faker->randomElement($coverOptions),
            'alt' => $this->faker->sentence(),
            'sku' => strtoupper(Str::random(10)),
            'stock' => $this->faker->numberBetween(0, 100),
            'production_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Active', 'Draft']),
        ];
    }
    private function generateUniqueProductName(array $baseNames): string
    {
        // Menghasilkan nama produk yang unik
        $baseName = $this->faker->randomElement($baseNames);
        self::$productCount++; // Increment counter
        return $baseName . ' ' . self::$productCount; // Tambahkan angka untuk keunikan
    }
}
