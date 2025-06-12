<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories_names = ['легкий', 'хрупкий', 'тяжелый'];
        $product_count = 10;

        $categories = [];

        foreach ($categories_names as $name) {
            array_push($categories, Category::create(['name' => $name]));   
        }

        foreach ($categories as $category) {
            Product::factory($product_count)->state([
                'category_id' => $category->id,
            ])->create();
        }
    }
}
