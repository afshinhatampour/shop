<?php

namespace App\Enums;

enum ProductItemEnums
{
    const UNIQUE_ID_PREFIX = 'lnzpi-';

    const STATUS = [
        'active'   => 'ACTIVE',
        'inactive' => 'INACTIVE',
        'draft'    => 'DRAFT',
        'reject'   => 'REJECT',
        'review'   => 'REVIEW'
    ];
}
