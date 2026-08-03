<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_type_id',
        'level_id',
        'name',
        'description',
        'base_price',
        'billing_mode',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * El tipo de producto.
     * Relación muchos a uno.
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * El nivel académico asociado (puede ser null).
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Ofertas especiales para este producto.
     * Relación uno a muchos.
     */
    public function offers(): HasMany
    {
        return $this->hasMany(ProductOffer::class);
    }

    /**
     * Items de orden que incluyen este producto.
     * Relación uno a muchos.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Accesos generados por la compra de este producto.
     * Relación uno a muchos.
     */
    public function accesses(): HasMany
    {
        return $this->hasMany(StudentAccess::class);
    }

    /**
     * Suscripciones asociadas a este producto.
     * Relación uno a muchos.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Obtiene la oferta vigente (si existe).
     * 
     * @return ProductOffer|null
     */
    public function currentOffer()
    {
        return $this->offers()
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->first();
    }

    /**
     * Obtiene el precio efectivo (con oferta si existe, sino base_price).
     * 
     * @return float
     */
    public function effectivePrice(): float
    {
        $offer = $this->currentOffer();
        return $offer ? (float) $offer->discount_price : (float) $this->base_price;
    }

    /**
     * Modos de facturación (constantes).
     */
    public const BILLING_ONE_TIME = 'one_time';
    public const BILLING_MONTHLY = 'monthly';
    public const BILLING_PACKAGE = 'package';
}
