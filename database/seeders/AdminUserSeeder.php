<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or get admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create admin user
        $user = User::create([
            'name' => 'Administrador IDCBIS',
            'email' => 'admin@idcbis.gov.co',
            'password' => Hash::make('Admin123!'),
            'email_verified_at' => now(),
            'phone' => '601-1234567',
            'position' => 'Administrador del Sistema'
        ]);

        // Assign admin role
        $user->assignRole('admin');

        $this->command->info('Usuario administrador creado exitosamente!');
        $this->command->info('Email: admin@idcbis.gov.co');
        $this->command->info('Password: Admin123!');
        $this->command->info('Rol: admin asignado');
    }
}
