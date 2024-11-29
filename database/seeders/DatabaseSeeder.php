<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(3)->create()->each(function ($category) {
            // Crear 3 productos para cada categoría
            Product::factory(3)->create([
                'category_id' => $category->id, // Asignar el producto a la categoría
            ]);
        });
    }
}
