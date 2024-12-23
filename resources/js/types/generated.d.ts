declare namespace App.Data {
export type RoleData = {
id: number;
name: string;
description: string;
permissions_count: number | null;
users_count: number | null;
created_at: string;
};
export type UserData = {
id: number;
name: string;
email: string;
phone: string | null;
role: App.Data.RoleData;
};
}
declare namespace App.Enums {
export type BasePermissionEnums = {
name: string;
};
export type RoleEnums = 'Admin' | 'User';
}
declare namespace App.Enums.Permissions {
export type RolePermissionEnums = 'role:view' | 'role:create' | 'role:update' | 'role:delete';
export type UserPermissionEnums = 'user:view' | 'user:create' | 'user:update';
}
