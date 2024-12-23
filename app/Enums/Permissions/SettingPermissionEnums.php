<?php

namespace App\Enums\Permissions;

use App\Traits\UseBaseEnum;

enum SettingPermissionEnums: string
{
    use UseBaseEnum;

    case VIEW = 'setting:view';
    case UPDATE = 'setting:update';
}
