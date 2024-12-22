declare namespace App.Data {
export type RoleData = {
id: number;
name: string;
};
export type UserData = {
id: number;
name: string;
email: string;
password: string;
phone: string;
role: App.Data.RoleData;
};
}
declare namespace App.Enums {
export type RoleEnums = 'Admin' | 'User';
}
declare namespace App.Enums.Enums.Permissions {
export type RolePermissionEnums = 'role:view' | 'role:create' | 'role:update' | 'role:delete';
export type UserPermissionEnums = 'user:view' | 'user:create' | 'user:update';
}
