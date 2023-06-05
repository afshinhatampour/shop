<?php

namespace App\Repositories;

use App\Enums\ProductEnums;
use App\Models\Product;
use Illuminate\Support\Arr;

class ProductRepository extends BaseRepository
{
    /**
     * @param Product $product
     */
    public function __construct(protected Product $product = new Product())
    {
        parent::__construct($this->product);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function create(array $params): mixed
    {
        Arr::set($params, 'unique_id', Product::generateUniqueId(ProductEnums::UNIQUE_ID_PREFIX));
        return parent::create($params);
    }
}
