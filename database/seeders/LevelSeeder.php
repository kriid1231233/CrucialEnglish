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
                'codigo' => Level::A1,
                'nombre' => 'Principiante (A1)',
                'descripcion' => 'Comprende y utiliza expresiones cotidianas de uso muy frecuente. Puede presentarse a sí mismo y a otros.',
                'orden' => 1,
            ],
            [
                'codigo' => Level::A2,
                'nombre' => 'Elemental (A2)',
                'descripcion' => 'Comprende frases y expresiones de uso frecuente relacionadas con áreas de experiencia relevantes.',
                'orden' => 2,
            ],
            [
                'codigo' => Level::B1,
                'nombre' => 'Intermedio (B1)',
                'descripcion' => 'Comprende los puntos principales de textos claros en situaciones de trabajo, estudio y ocio.',
                'orden' => 3,
            ],
            [
                'codigo' => Level::B2,
                'nombre' => 'Intermedio Alto (B2)',
                'descripcion' => 'Entiende las ideas principales de textos complejos. Puede relacionarse con hablantes nativos con fluidez.',
                'orden' => 4,
            ],
            [
                'codigo' => Level::C1,
                'nombre' => 'Avanzado (C1)',
                'descripcion' => 'Comprende textos largos y complejos, reconociendo significados implícitos. Se expresa con fluidez y espontaneidad.',
                'orden' => 5,
            ],
            [
                'codigo' => Level::C2,
                'nombre' => 'Dominio (C2)',
                'descripcion' => 'Comprende prácticamente todo lo que oye o lee. Puede expresarse con gran fluidez y precisión.',
                'orden' => 6,
            ],
        ];

        foreach ($levels as $levelData) {
            Level::firstOrCreate(
                ['codigo' => $levelData['codigo']],
                $levelData
            );
        }

        $this->command->info('✅ Niveles creados: A1, A2, B1, B2, C1, C2');
    }
}
