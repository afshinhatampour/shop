<?php

namespace App\Enums;

enum ProductEnums
{
    const UNIQUE_ID_PREFIX = 'lnzp-';

    const STATUS = [
        'active'   => 'ACTIVE',
        'inactive' => 'INACTIVE',
        'draft'    => 'DRAFT',
        'reject'   => 'REJECT',
        'review'   => 'REVIEW'
    ];
}
