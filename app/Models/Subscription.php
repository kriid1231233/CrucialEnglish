<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'suscripciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estudiante_id',
        'producto_id',
        'inicia_en',
        'termina_en',
        'estado',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'inicia_en' => 'datetime',
            'termina_en' => 'datetime',
        ];
    }

    /**
     * El estudiante que tiene esta suscripción.
     * Relación muchos a uno.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    /**
     * El producto de suscripción.
     * Relación muchos a uno.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    /**
     * Verifica si la suscripción está activa.
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->estado === self::STATUS_ACTIVE && 
               now()->between($this->inicia_en, $this->termina_en);
    }

    /**
     * Estados de suscripción (constantes).
     */
    public const STATUS_ACTIVE = 'active';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CANCELLED = 'cancelled';
}
