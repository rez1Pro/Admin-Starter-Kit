<?php

namespace App\Enums\Enums\Permissions;

use App\Traits\UseBaseEnum;

enum UserPermissionEnums: string
{
    use UseBaseEnum;

    case VIEW_USER = 'user:view';
    case CREATE_USER = 'user:create';
    case UPDATE_USER = 'user:update';
}
