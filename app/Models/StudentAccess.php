<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAccess extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'product_id',
        'access_type',
        'granted_at',
        'expires_at',
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
            'granted_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * El estudiante que tiene este acceso.
     * Relación muchos a uno.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * El producto al que se tiene acceso.
     * Relación muchos a uno.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Verifica si el acceso está vigente.
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->is_active && 
               ($this->expires_at === null || now()->lte($this->expires_at));
    }

    /**
     * Tipos de acceso (constantes).
     */
    public const TYPE_MATERIAL = 'material';
    public const TYPE_RECORDED_LESSON = 'recorded_lesson';
}
