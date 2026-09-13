<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'tipos_producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'identificador',
        'descripcion',
    ];

    /**
     * Productos de este tipo.
     * Relación uno a muchos.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'tipo_producto_id');
    }

    /**
     * Identificadores de tipos de producto del sistema (constantes).
     */
    public const INDIVIDUAL_CLASS = 'clase-individual';
    public const GROUP_CLASS = 'clase-grupal';
    public const SUPPORT_MATERIAL = 'material-apoyo';
    public const SUBSCRIPTION = 'suscripcion';
}
