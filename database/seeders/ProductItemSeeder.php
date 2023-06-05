<?php

namespace Database\Seeders;

use App\Models\ProductItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductItem::factory(config('app.env') === 'testing' ? 50 : 500)->create();
    }
}
