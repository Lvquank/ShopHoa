<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductDetail>
 */
class ProductDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => 1, // sẽ được ghi đè trong seeder
            'title' => fake()->sentence(3),
            'image' => fake()->imageUrl(),
            'description' => fake()->paragraph(),
        ];
    }
}
