<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando seeders de CrucialEnglish...');
        $this->command->newLine();

        // 1. Seeders de configuración base
        $this->command->info('📋 Paso 1: Configuración base del sistema');
        $this->call([
            RoleSeeder::class,
            LevelSeeder::class,
            ProductTypeSeeder::class,
        ]);
        $this->command->newLine();

        // 2. Usuario administrador inicial
        $this->command->info('👤 Paso 2: Usuario administrador inicial');
        $this->call([
            AdminUserSeeder::class,
        ]);
        $this->command->newLine();

        // 3. Datos de prueba (descomentar en desarrollo)
        // $this->command->info('🧪 Paso 3: Datos de prueba (desarrollo)');
        // $this->call([
        //     TestUsersSeeder::class,
        //     TestProductsSeeder::class,
        //     TestAcademicGroupsSeeder::class,
        // ]);
        // $this->command->newLine();

        $this->command->info('✅ Seeders completados exitosamente');
        $this->command->newLine();
        $this->command->warn('⚠️  Recuerda:');
        $this->command->warn('   - Cambiar la contraseña del administrador en producción');
        $this->command->warn('   - Configurar correctamente la zona horaria (America/Santiago)');
        $this->command->warn('   - Revisar permisos de archivos y carpetas');
    }
}
