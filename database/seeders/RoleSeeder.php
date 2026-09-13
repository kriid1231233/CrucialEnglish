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
                'nombre' => 'Estudiante',
                'identificador' => Role::STUDENT,
                'descripcion' => 'Usuario que accede a clases, materiales y contenido educativo',
            ],
            [
                'nombre' => 'Docente',
                'identificador' => Role::TEACHER,
                'descripcion' => 'Usuario que gestiona grupos, registra asistencia, crea materiales y evalúa estudiantes',
            ],
            [
                'nombre' => 'Administrador',
                'identificador' => Role::ADMIN,
                'descripcion' => 'Usuario con acceso completo al sistema, gestiona productos, usuarios y aprueba contenido',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['identificador' => $roleData['identificador']],
                $roleData
            );
        }

        $this->command->info('✅ Roles creados: Estudiante, Docente, Administrador');
    }
}
