<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

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
            'name' => $this->faker->sentence(2),
            'photo' => $this->faker->imageUrl(640, 480, 'Faker', false, 'Produto', true),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'category_id' => Category::factory()->create()->id,
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
