<?php

namespace App\Enums;

enum RoleEnums
{
    const STATUS = [
        'active'   => 'ACTIVE',
        'inactive' => 'INACTIVE',
    ];

    const ADMIN_ROLES_NAME = [
        'SUPER_ADMIN'            => 'super_admin',
        'CUSTOMER_SERVICE_ADMIN' => 'customer_service_admin',
        'FINANCE_ADMIN'          => 'finance_admin',
        'COMMERCIAL_ADMIN'       => 'commercial_admin',
        'INVENTORY_ADMIN'        => 'inventory_admin',
        'MARKETING_ADMIN'        => 'marketing_admin'
    ];

    const STAFF_ROLES_NAME = [
        'CUSTOMER_SERVICE_STAFF' => 'customer_service_staff',
        'FINANCE_STAFF'          => 'finance_staff',
        'COMMERCIAL_STAFF'       => 'commercial_staff',
        'INVENTORY_STAFF'        => 'inventory_staff',
        'MARKETING_STAFF'        => 'marketing_staff'
    ];

    const THIRD_PARTY_ROLES_NAME = [
        'CUSTOMER' => 'customer',
        'SELLER'   => 'seller'
    ];

    /**
     * @return string[]
     */
    public static function getAllRoles(): array
    {
        return array_merge(self::ADMIN_ROLES_NAME,
            self::STAFF_ROLES_NAME,
            self::THIRD_PARTY_ROLES_NAME
        );
    }
}
