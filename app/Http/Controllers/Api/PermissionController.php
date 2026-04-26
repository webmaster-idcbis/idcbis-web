<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::select('id', 'name', 'guard_name', 'created_at')
            ->withCount('roles')
            ->latest()
            ->get()
            ->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'guard_name' => $permission->guard_name,
                    'module' => explode('.', $permission->name)[0] ?? 'other',
                    'action' => explode('.', $permission->name)[1] ?? $permission->name,
                    'roles_count' => $permission->roles_count,
                    'created_at' => $permission->created_at,
                ];
            });

        return response()->json([
            'data' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'nullable|string|max:255',
        ]);

        $permission = Permission::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'] ?? 'web'
        ]);

        return response()->json([
            'data' => $permission,
            'message' => 'Permiso creado exitosamente'
        ], 201);
    }

    public function show(Permission $permission)
    {
        return response()->json([
            'data' => $permission->load('roles:id,name')
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($permission->id)
            ],
            'guard_name' => 'nullable|string|max:255',
        ]);

        if (isset($validated['name'])) {
            $permission->name = $validated['name'];
        }
        if (isset($validated['guard_name'])) {
            $permission->guard_name = $validated['guard_name'];
        }
        $permission->save();

        return response()->json([
            'data' => $permission,
            'message' => 'Permiso actualizado exitosamente'
        ]);
    }

    public function destroy(Permission $permission)
    {
        // Check if permission has roles
        if ($permission->roles()->count() > 0) {
            return response()->json([
                'message' => 'No se puede eliminar el permiso porque está asignado a roles'
            ], 403);
        }

        // Prevent deletion of critical permissions
        $criticalPermissions = [
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
            'users.view', 'users.create', 'users.edit', 'users.delete'
        ];
        
        if (in_array($permission->name, $criticalPermissions)) {
            return response()->json([
                'message' => 'No se puede eliminar este permiso crítico del sistema'
            ], 403);
        }

        $permission->delete();

        return response()->json([
            'message' => 'Permiso eliminado exitosamente'
        ]);
    }

    public function grouped()
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

    public function modules()
    {
        $modules = Permission::select('name')
            ->get()
            ->map(function ($permission) {
                $parts = explode('.', $permission->name);
                return $parts[0] ?? 'other';
            })
            ->unique()
            ->values();

        return response()->json([
            'data' => $modules
        ]);
    }
}
