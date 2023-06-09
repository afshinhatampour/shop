<?php

namespace App\Traits;

use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;

trait Gates
{
    /**
     * @return void
     */
    public static function gatesMake(): void
    {
        Gate::define('manage-product-index', [ProductPolicy::class, 'viewAny']);
        Gate::define('manage-product-show', [ProductPolicy::class, 'view']);
    }
}
