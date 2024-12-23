<?php

namespace App\Enums;

use App\Enums\Permissions\RolePermissionEnums;
use App\Enums\Permissions\UserPermissionEnums;
use App\Traits\UseBaseEnum;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
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
