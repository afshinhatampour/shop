<?php

namespace Database\Factories;

use App\Enums\ProductItemEnums;
use App\Models\Product;
use App\Models\ProductItem;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductItem>
 */
class ProductItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'unique_id'  => ProductItem::generateUniqueId(ProductItemEnums::UNIQUE_ID_PREFIX),
            'status'     => $this->faker->randomElement(array_values(ProductItemEnums::STATUS)),
            'price'      => random_int(5, 999),
            'discount'   => $this->faker->randomElement([0, 5, 10, 15, 0, 0, 0,]),
            'product_id' => Product::query()->inRandomOrder()->first()->id
        ];
    }
}
