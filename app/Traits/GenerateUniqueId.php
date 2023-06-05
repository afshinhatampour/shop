<?php

namespace App\Traits;

trait GenerateUniqueId
{
    /**
     * @param string $prefix
     * @return string
     */
    public static function generateUniqueId(string $prefix): string
    {
        return $prefix . uniqid();
    }
}
