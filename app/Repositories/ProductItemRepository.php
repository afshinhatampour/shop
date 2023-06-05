<?php

namespace App\Repositories;

use App\Models\ProductItem;
use Illuminate\Database\Eloquent\Model;

class ProductItemRepository extends BaseRepository
{
    public function __construct(protected ProductItem $productItem = new ProductItem())
    {
        parent::__construct($this->productItem);
    }
}
