<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar que el rol admin exista
        $adminRole = Role::where('slug', Role::ADMIN)->first();
        
        if (!$adminRole) {
            $this->command->error('❌ Error: El rol Administrador no existe. Ejecuta RoleSeeder primero.');
            return;
        }

        // Crear usuario administrador por defecto
        $admin = User::firstOrCreate(
            ['email' => 'admin@crucialenglish.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin123!'),
                'email_verified_at' => now(),
                'active' => true,
            ]
        );

        // Asignar rol de administrador si no lo tiene
        if (!$admin->roles()->where('role_id', $adminRole->id)->exists()) {
            $admin->roles()->attach($adminRole->id, [
                'assigned_at' => now(),
                'assigned_by' => null, // Auto-asignado en seeder
            ]);
        }

        $this->command->info('✅ Usuario administrador creado:');
        $this->command->info('   Email: admin@crucialenglish.com');
        $this->command->info('   Password: Admin123!');
        $this->command->warn('⚠️  IMPORTANTE: Cambia esta contraseña en producción');
    }
}
