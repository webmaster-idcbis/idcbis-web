<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            // Pages
            'pages.view',
            'pages.create',
            'pages.edit',
            'pages.delete',
            'pages.publish',
            
            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            
            // Roles
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            
            // Settings
            'settings.view',
            'settings.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        // Asignar permisos
        $adminRole->syncPermissions(Permission::all());
        
        $editorRole->syncPermissions([
            'pages.view',
            'pages.create',
            'pages.edit',
            'pages.publish',
        ]);

        $viewerRole->syncPermissions([
            'pages.view',
        ]);

        // Crear usuario admin por defecto
        $admin = User::firstOrCreate(
            ['email' => 'admin@idcbis.org.co'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('Admin123!')
            ]
        );
        $admin->assignRole('admin');

        $this->command->info('Roles y permisos creados exitosamente');
        $this->command->info('Usuario admin: admin@idcbis.org.co / Admin123!');
    }
}
