<?php

namespace App\Models\Concerns;

/**
 * Nombres de columnas de timestamps en español para todos los modelos del dominio.
 */
trait ConMarcasDeTiempoEnEspanol
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
}
