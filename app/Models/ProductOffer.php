<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOffer extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'ofertas_producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'producto_id',
        'precio_oferta',
        'vigente_desde',
        'vigente_hasta',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'precio_oferta' => 'decimal:2',
            'vigente_desde' => 'datetime',
            'vigente_hasta' => 'datetime',
        ];
    }

    /**
     * El producto al que pertenece esta oferta.
     * Relación muchos a uno.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    /**
     * Verifica si la oferta está vigente.
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        return now()->between($this->vigente_desde, $this->vigente_hasta);
    }
}
