<?php

namespace App\Http\Controllers;

use App\Data\RoleData;
use App\Enums\BasePermissionEnums;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Enums\Permissions\RolePermissions;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            checkPermission(RolePermissions::VIEW_ROLE, only: ['index']),
            checkPermission(RolePermissions::CREATE_ROLE, only: ['create', 'store']),
            checkPermission(RolePermissions::UPDATE_ROLE, only: ['edit', 'update']),
            checkPermission(RolePermissions::DELETE_ROLE, only: ['destroy']),
        ];
    }

    public function index()
    {
        return Inertia::render('Roles/Index', [
            'roles' => RoleData::collection(QueryBuilder::for(Role::class)
                ->withCount(['permissions', 'users'])
                ->allowedSorts(['name', 'created_at'])
                ->defaultSort('-id')
                ->allowedFilters(['name'])
                ->paginate(request()->get('per_page', 10)))
        ]);
    }

    public function create()
    {
        return Inertia::render('Roles/Create', [
            'permissionGroups' => BasePermissionEnums::getGroupWithPermissions()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        $role->permissions()->sync(Permission::whereIn('name', $validated['permissions'])->pluck('id'));

        return redirect()->route('users.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        return Inertia::render('Roles/Edit', [
            'role' => RoleData::from($role->load('permissions')),
            'existingPermissions' => BasePermissionEnums::getGroupWithPermissions()
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ], [
            'permissions.required' => 'Please select at least one permission.',
            'permissions.*.exists' => 'The :attribute selected is invalid.'
        ]);

        if ($role->id == 1) {
            return redirect()->back()
                ->with('error', 'Admin role cannot be updated.');
        }

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        $role->permissions()->sync(Permission::whereIn('name', $validated['permissions'])->pluck('id'));

        return redirect()->back()
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->id === 1) {
            return redirect()->route('users.roles.index')
                ->with('error', 'Admin role cannot be deleted.');
        }

        try {
            $role->delete();
        } catch (\Exception $e) {
            return redirect()->route('users.roles.index')
                ->with('error', 'Role deletion failed. Maybe this role is assigned to some users.');
        }

        return redirect()->route('users.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
