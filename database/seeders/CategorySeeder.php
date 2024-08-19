<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Books',
            'Toys',
            'Furniture',
            'Food',
            'Tools',
            'Sporting Goods',
            'Automotive',
            'Beauty',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::factory()->create(['name' => $category]);
        }
    }
}
