<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'code' => Level::A1,
                'name' => 'Principiante (A1)',
                'description' => 'Comprende y utiliza expresiones cotidianas de uso muy frecuente. Puede presentarse a sí mismo y a otros.',
                'order' => 1,
            ],
            [
                'code' => Level::A2,
                'name' => 'Elemental (A2)',
                'description' => 'Comprende frases y expresiones de uso frecuente relacionadas con áreas de experiencia relevantes.',
                'order' => 2,
            ],
            [
                'code' => Level::B1,
                'name' => 'Intermedio (B1)',
                'description' => 'Comprende los puntos principales de textos claros en situaciones de trabajo, estudio y ocio.',
                'order' => 3,
            ],
            [
                'code' => Level::B2,
                'name' => 'Intermedio Alto (B2)',
                'description' => 'Entiende las ideas principales de textos complejos. Puede relacionarse con hablantes nativos con fluidez.',
                'order' => 4,
            ],
            [
                'code' => Level::C1,
                'name' => 'Avanzado (C1)',
                'description' => 'Comprende textos largos y complejos, reconociendo significados implícitos. Se expresa con fluidez y espontaneidad.',
                'order' => 5,
            ],
            [
                'code' => Level::C2,
                'name' => 'Dominio (C2)',
                'description' => 'Comprende prácticamente todo lo que oye o lee. Puede expresarse con gran fluidez y precisión.',
                'order' => 6,
            ],
        ];

        foreach ($levels as $levelData) {
            Level::firstOrCreate(
                ['code' => $levelData['code']],
                $levelData
            );
        }

        $this->command->info('✅ Niveles creados: A1, A2, B1, B2, C1, C2');
    }
}
