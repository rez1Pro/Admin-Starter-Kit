<?php

namespace App\Http\Controllers;

use App\Data\UserData;
use App\Enums\Permissions\UserPermissionEnums;
use App\Http\Middleware\CheckPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            checkPermission(UserPermissionEnums::VIEW_USER, only: ['index']),
        ];
    }

    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => UserData::collection(User::with('role')->paginate(10))
        ]);
    }

    public function create()
    {
        // return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
