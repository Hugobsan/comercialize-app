<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fontAwesomeIcons = [
            'fas fa-utensils',
            'fas fa-tshirt',
            'fas fa-laptop',
            'fas fa-mobile-alt',
            'fas fa-tablet-alt',
            'fas fa-headphones',
            'fas fa-book',
            'fas fa-futbol',
            'fas fa-guitar',
            'fas fa-baby',
            'fas fa-car',
            'fas fa-bicycle',
            'fas fa-paw',
            'fas fa-tree',
            'fas fa-bolt',
            'fas fa-umbrella',
            'fas fa-globe',
            'fas fa-rocket',
            'fas fa-graduation-cap',
            'fas fa-briefcase',
            'fas fa-coffee',
            'fas fa-beer',
            'fas fa-cocktail',
            'fas fa-wine-glass',
            'fas fa-pizza-slice',
            'fas fa-ice-cream',
            'fas fa-candy-cane',
            'fas fa-birthday-cake',
            'fas fa-umbrella-beach',
            'fas fa-snowflake',
            'fas fa-fire',
            'fas fa-bug',
            'fas fa-ghost',
            'fas fa-pumpkin',
            'fas fa-broom',
            'fas fa-spider',
            'fas fa-skull-crossbones',
            'fas fa-cat',
            'fas fa-dog',
            'fas fa-fish',
            'fas fa-kiwi-bird',
            'fas fa-hippo',
            'fas fa-otter',
            'fas fa-dragon',
            'fas fa-robot',
            'fas fa-rocket',
            'fas fa-space-shuttle',
            'fas fa-satellite-dish',
            'fas fa-sun',
            'fas fa-moon',
            'fas fa-cloud',
            'fas fa-rainbow',
            'fas fa-snowflake',
            'fas fa-tornado',
            'fas fa-temperature-high',
            'fas fa-temperature-low',
            'fas fa-wind',
            'fas fa-smog',
            'fas fa-cloud-sun',
            'fas fa-cloud-moon',
            'fas fa-cloud-rain',
            'fas fa-cloud-showers-heavy',
            'fas fa-cloud-snow',
            'fas fa-cloud-meatball',
            'fas fa-cloud-moon-rain',
        ];

        return [
            'name' => $this->faker->word(),
            'code' => null,
            'icon' => $this->faker->randomElement($fontAwesomeIcons),
            'color' => $this->faker->hexColor(),
            'description' => $this->faker->sentence(),
        ];
    }
}
