<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles:id,name')
            ->latest()
            ->get();
        
        return response()->json([
            'data' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'nullable|array',
            'roles.*' => 'string|exists:roles,name',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if (!empty($validated['roles'])) {
            $user->assignRole($validated['roles']);
        }

        return response()->json([
            'data' => $user->load('roles:id,name'),
            'message' => 'Usuario creado exitosamente'
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json([
            'data' => $user->load('roles:id,name')
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'roles' => 'nullable|array',
            'roles.*' => 'string|exists:roles,name',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return response()->json([
            'data' => $user->load('roles:id,name'),
            'message' => 'Usuario actualizado exitosamente'
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json([
                'message' => 'No puedes eliminar tu propio usuario'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente'
        ]);
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'data' => $user->load('roles:id,name'),
            'message' => 'Estado del usuario actualizado'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255'
        ]);

        $user->update($validated);

        return response()->json([
            'data' => $user->load('roles:id,name'),
            'message' => 'Perfil actualizado exitosamente'
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8'
        ]);

        // Verificar contraseña actual
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'message' => 'La contraseña actual es incorrecta'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return response()->json([
            'message' => 'Contraseña actualizada exitosamente'
        ]);
    }
}
