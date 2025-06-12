<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\Randomizer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $randomizer = new Randomizer();

        return [
            'name' => $this->faker->text(70),
            'price' => $randomizer->getFloat(1.01, 100000.99),
            'description' => $this->faker->text(400),
        ];
    }
}
