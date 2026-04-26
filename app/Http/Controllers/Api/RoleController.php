<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions:id,name')
            ->withCount('users')
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name,
                    'permissions' => $role->permissions,
                    'users_count' => $role->users_count,
                    'created_at' => $role->created_at,
                ];
            });

        return response()->json([
            'data' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web'
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json([
            'data' => $role->load('permissions:id,name'),
            'message' => 'Rol creado exitosamente'
        ], 201);
    }

    public function show(Role $role)
    {
        return response()->json([
            'data' => $role->load('permissions:id,name')
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        if (isset($validated['name'])) {
            $role->name = $validated['name'];
            $role->save();
        }

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json([
            'data' => $role->load('permissions:id,name'),
            'message' => 'Rol actualizado exitosamente'
        ]);
    }

    public function destroy(Role $role)
    {
        // Prevent deletion of admin role
        if ($role->name === 'admin') {
            return response()->json([
                'message' => 'No se puede eliminar el rol de administrador'
            ], 403);
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            return response()->json([
                'message' => 'No se puede eliminar el rol porque tiene usuarios asignados'
            ], 403);
        }

        $role->delete();

        return response()->json([
            'message' => 'Rol eliminado exitosamente'
        ]);
    }

    public function permissions()
    {
        $permissions = Permission::select('id', 'name', 'guard_name')
            ->get()
            ->groupBy(function ($permission) {
                $parts = explode('.', $permission->name);
                return $parts[0] ?? 'other';
            });

        return response()->json([
            'data' => $permissions
        ]);
    }
}
