<?php

namespace App\Enums;

use App\Traits\UseBaseEnum;

enum RoleEnums: string
{   
    use UseBaseEnum;
    
    case SUPER_ADMIN = 'Super Admin';
    case ADMIN = 'Admin';
    case USER = 'User';
}
