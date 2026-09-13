<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'pedidos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estudiante_id',
        'monto_total',
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
            'monto_total' => 'decimal:2',
        ];
    }

    /**
     * El estudiante que realizó esta orden.
     * Relación muchos a uno.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    /**
     * Los items de esta orden.
     * Relación uno a muchos.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'pedido_id');
    }

    /**
     * Los pagos asociados a esta orden.
     * Relación uno a muchos.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'pedido_id');
    }

    /**
     * Obtiene el pago aprobado de esta orden (si existe).
     * 
     * @return Payment|null
     */
    public function approvedPayment()
    {
        return $this->payments()->where('estado', self::STATUS_APPROVED)->first();
    }

    /**
     * Estados de orden (constantes).
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';
}
