<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Faker\Factory;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CatalogSeeder::class);
        $this->call(CartSeeder::class);
    }
}
