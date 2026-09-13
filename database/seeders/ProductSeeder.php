<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Catálogo inicial de productos académicos, ligados a niveles y tipos reales.
     */
    public function run(): void
    {
        $individual = ProductType::where('identificador', ProductType::INDIVIDUAL_CLASS)->first();
        $grupal = ProductType::where('identificador', ProductType::GROUP_CLASS)->first();
        $material = ProductType::where('identificador', ProductType::SUPPORT_MATERIAL)->first();
        $suscripcion = ProductType::where('identificador', ProductType::SUBSCRIPTION)->first();

        if (!$individual || !$grupal || !$material || !$suscripcion) {
            $this->command->warn('Tipos de producto no encontrados. Ejecuta ProductTypeSeeder primero.');
            return;
        }

        $productos = [
            [
                'tipo_producto_id' => $individual->id,
                'nivel_id' => Level::where('codigo', Level::A1)->value('id'),
                'nombre' => 'Inglés Individual A1',
                'descripcion' => 'Clases personalizadas uno a uno para comenzar desde cero con bases sólidas.',
                'precio_base' => 45000,
                'modalidad_cobro' => Product::BILLING_PACKAGE,
            ],
            [
                'tipo_producto_id' => $individual->id,
                'nivel_id' => Level::where('codigo', Level::C1)->value('id'),
                'nombre' => 'Preparación Business English C1',
                'descripcion' => 'Clases individuales enfocadas en inglés de negocios para nivel avanzado.',
                'precio_base' => 52000,
                'modalidad_cobro' => Product::BILLING_PACKAGE,
            ],
            [
                'tipo_producto_id' => $grupal->id,
                'nivel_id' => Level::where('codigo', Level::B1)->value('id'),
                'nombre' => 'Grupo Conversacional B1',
                'descripcion' => 'Clases grupales para practicar conversación con estudiantes de tu mismo nivel.',
                'precio_base' => 28000,
                'modalidad_cobro' => Product::BILLING_MONTHLY,
            ],
            [
                'tipo_producto_id' => $grupal->id,
                'nivel_id' => Level::where('codigo', Level::B2)->value('id'),
                'nombre' => 'Grupo Intensivo B2',
                'descripcion' => 'Grupo reducido con ritmo intensivo para consolidar el nivel intermedio alto.',
                'precio_base' => 32000,
                'modalidad_cobro' => Product::BILLING_MONTHLY,
            ],
            [
                'tipo_producto_id' => $material->id,
                'nivel_id' => null,
                'nombre' => 'Guía de Gramática Completa',
                'descripcion' => 'Material de apoyo descargable con ejercicios prácticos para todos los niveles.',
                'precio_base' => 12000,
                'modalidad_cobro' => Product::BILLING_ONE_TIME,
            ],
            [
                'tipo_producto_id' => $suscripcion->id,
                'nivel_id' => null,
                'nombre' => 'Suscripción Mensual Premium',
                'descripcion' => 'Acceso ilimitado a clases pregrabadas y materiales durante un mes.',
                'precio_base' => 25000,
                'modalidad_cobro' => Product::BILLING_MONTHLY,
            ],
        ];

        foreach ($productos as $data) {
            Product::firstOrCreate(
                ['nombre' => $data['nombre']],
                array_merge($data, ['activo' => true])
            );
        }

        $this->command->info('✅ Productos de catálogo creados: '.count($productos));
    }
}
