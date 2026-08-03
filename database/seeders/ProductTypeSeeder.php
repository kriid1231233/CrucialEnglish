<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productTypes = [
            [
                'name' => 'Clase Individual',
                'slug' => ProductType::INDIVIDUAL_CLASS,
                'description' => 'Clases personalizadas uno a uno con el docente, adaptadas a las necesidades específicas del estudiante.',
            ],
            [
                'name' => 'Clase Grupal',
                'slug' => ProductType::GROUP_CLASS,
                'description' => 'Clases en grupo reducido, ideal para practicar conversación y aprender en comunidad.',
            ],
            [
                'name' => 'Material de Apoyo',
                'slug' => ProductType::SUPPORT_MATERIAL,
                'description' => 'Recursos didácticos digitales: PDFs, ejercicios, guías de estudio y material complementario.',
            ],
            [
                'name' => 'Suscripción',
                'slug' => ProductType::SUBSCRIPTION,
                'description' => 'Acceso ilimitado a clases pregrabadas, materiales y recursos educativos durante el período contratado.',
            ],
        ];

        foreach ($productTypes as $typeData) {
            ProductType::firstOrCreate(
                ['slug' => $typeData['slug']],
                $typeData
            );
        }

        $this->command->info('✅ Tipos de producto creados: Clase Individual, Grupal, Material, Suscripción');
    }
}
