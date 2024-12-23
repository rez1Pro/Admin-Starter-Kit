<?php

namespace App\Http\Controllers;

use App\Data\RoleData;
use App\Enums\Enums\BasePermissionEnums;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
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
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        $role->permissions()->sync($validated['permissions']);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::all()->groupBy('group');

        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        $role->permissions()->sync($validated['permissions']);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
