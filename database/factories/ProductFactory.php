<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => time() . '.png',
            'barcode' => fake()->ean13(),
            'category_id' => Category::factory()->create()->id,
            'name' => fake()->word(),
            'desc' => fake()->sentence(),
            'price' => fake()->numberBetween(100, 1000),
            'available' => true
        ];
    }
}
