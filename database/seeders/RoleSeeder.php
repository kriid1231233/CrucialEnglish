<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Estudiante',
                'slug' => Role::STUDENT,
                'description' => 'Usuario que accede a clases, materiales y contenido educativo',
            ],
            [
                'name' => 'Docente',
                'slug' => Role::TEACHER,
                'description' => 'Usuario que gestiona grupos, registra asistencia, crea materiales y evalúa estudiantes',
            ],
            [
                'name' => 'Administrador',
                'slug' => Role::ADMIN,
                'description' => 'Usuario con acceso completo al sistema, gestiona productos, usuarios y aprueba contenido',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }

        $this->command->info('✅ Roles creados: Estudiante, Docente, Administrador');
    }
}
