<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Productos de este tipo.
     * Relación uno a muchos.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Slugs de tipos de producto del sistema (constantes).
     */
    public const INDIVIDUAL_CLASS = 'clase-individual';
    public const GROUP_CLASS = 'clase-grupal';
    public const SUPPORT_MATERIAL = 'material-apoyo';
    public const SUBSCRIPTION = 'suscripcion';
}
