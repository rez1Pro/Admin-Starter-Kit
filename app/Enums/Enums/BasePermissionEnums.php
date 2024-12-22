<?php

namespace App\Enums\Enums;

use App\Enums\Enums\Permissions\RolePermissionEnums;
use App\Enums\Enums\Permissions\UserPermissionEnums;
use App\Traits\UseBaseEnum;

enum BasePermissionEnums
{
    use UseBaseEnum;

    // Get Group wise permissions
    static function getGroupWithPermissions(): array
    {
        return [
            [
                "name" => "User",
                "permissions" => UserPermissionEnums::getValuesWithNames()
            ],
            [
                "name" => "Role",
                "permissions" => RolePermissionEnums::getValuesWithNames()
            ]
        ];
    }

    // Get all permissions
    static function getAllPermissionList(): array
    {
        return [
            ...UserPermissionEnums::getValues(),
            ...RolePermissionEnums::getValues()
        ];
    }
}
