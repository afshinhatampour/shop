<?php

namespace App\Models;

use App\Traits\GenerateUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, GenerateUniqueId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'unique_id',
        'content',
        'status'
    ];

    /**
     * @return HasMany
     */
    public function productItems(): HasMany
    {
        return $this->hasMany(ProductItem::class);
    }
}
