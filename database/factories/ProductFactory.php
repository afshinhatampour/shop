<?php

namespace Database\Factories;

use App\Enums\ProductEnums;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'unique_id' => Product::generateUniqueId(ProductEnums::UNIQUE_ID_PREFIX),
            'title'     => $this->faker->sentence,
            'content'   => $this->faker->paragraph,
            'status'    => $this->faker->randomElement(array_values(ProductEnums::STATUS)),
        ];
    }
}
