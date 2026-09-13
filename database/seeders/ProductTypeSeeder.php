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
                'nombre' => 'Clase Individual',
                'identificador' => ProductType::INDIVIDUAL_CLASS,
                'descripcion' => 'Clases personalizadas uno a uno con el docente, adaptadas a las necesidades específicas del estudiante.',
            ],
            [
                'nombre' => 'Clase Grupal',
                'identificador' => ProductType::GROUP_CLASS,
                'descripcion' => 'Clases en grupo reducido, ideal para practicar conversación y aprender en comunidad.',
            ],
            [
                'nombre' => 'Material de Apoyo',
                'identificador' => ProductType::SUPPORT_MATERIAL,
                'descripcion' => 'Recursos didácticos digitales: PDFs, ejercicios, guías de estudio y material complementario.',
            ],
            [
                'nombre' => 'Suscripción',
                'identificador' => ProductType::SUBSCRIPTION,
                'descripcion' => 'Acceso ilimitado a clases pregrabadas, materiales y recursos educativos durante el período contratado.',
            ],
        ];

        foreach ($productTypes as $typeData) {
            ProductType::firstOrCreate(
                ['identificador' => $typeData['identificador']],
                $typeData
            );
        }

        $this->command->info('✅ Tipos de producto creados: Clase Individual, Grupal, Material, Suscripción');
    }
}
