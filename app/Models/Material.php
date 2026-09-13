<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'materiales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'nivel_id',
        'tipo_archivo',
        'ruta_archivo',
        'enlace_externo',
        'estado',
        'autor_id',
        'revisado_por',
        'revisado_en',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'revisado_en' => 'datetime',
        ];
    }

    /**
     * El nivel académico al que pertenece este material.
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'nivel_id');
    }

    /**
     * El docente que creó este material.
     * Relación muchos a uno.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    /**
     * El administrador que revisó este material.
     * Relación muchos a uno (nullable).
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    /**
     * Estados de material (constantes).
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
}
