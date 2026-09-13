<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, ConMarcasDeTiempoEnEspanol;

    protected $table = 'productos';

    /** Columna de borrado suave en español. */
    const DELETED_AT = 'eliminado_en';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo_producto_id',
        'nivel_id',
        'nombre',
        'descripcion',
        'precio_base',
        'modalidad_cobro',
        'activo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'precio_base' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    /**
     * El tipo de producto.
     * Relación muchos a uno.
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'tipo_producto_id');
    }

    /**
     * El nivel académico asociado (puede ser null).
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'nivel_id');
    }

    /**
     * Ofertas especiales para este producto.
     * Relación uno a muchos.
     */
    public function offers(): HasMany
    {
        return $this->hasMany(ProductOffer::class, 'producto_id');
    }

    /**
     * Oferta vigente en este momento, si existe.
     */
    public function activeOffer(): ?ProductOffer
    {
        return $this->offers()
            ->where('vigente_desde', '<=', now())
            ->where('vigente_hasta', '>=', now())
            ->orderByDesc('precio_oferta')
            ->first();
    }

    /**
     * Precio final a cobrar, considerando ofertas vigentes.
     */
    public function currentPrice(): string
    {
        return $this->activeOffer()?->precio_oferta ?? $this->precio_base;
    }

    /**
     * Items de orden que incluyen este producto.
     * Relación uno a muchos.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'producto_id');
    }

    /**
     * Accesos generados por la compra de este producto.
     * Relación uno a muchos.
     */
    public function accesses(): HasMany
    {
        return $this->hasMany(StudentAccess::class, 'producto_id');
    }

    /**
     * Suscripciones asociadas a este producto.
     * Relación uno a muchos.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'producto_id');
    }

    /**
     * Obtiene la oferta vigente (si existe).
     * 
     * @return ProductOffer|null
     */
    public function currentOffer()
    {
        return $this->offers()
            ->where('vigente_desde', '<=', now())
            ->where('vigente_hasta', '>=', now())
            ->first();
    }

    /**
     * Obtiene el precio efectivo (con oferta si existe, sino precio_base).
     * 
     * @return float
     */
    public function effectivePrice(): float
    {
        $offer = $this->currentOffer();
        return $offer ? (float) $offer->precio_oferta : (float) $this->precio_base;
    }

    /**
     * Modos de facturación (constantes).
     */
    public const BILLING_ONE_TIME = 'one_time';
    public const BILLING_MONTHLY = 'monthly';
    public const BILLING_PACKAGE = 'package';
}
