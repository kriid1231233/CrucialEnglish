<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordedLesson extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'clases_grabadas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'nivel_id',
        'duracion_minutos',
        'ruta_video',
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
            'duracion_minutos' => 'integer',
            'revisado_en' => 'datetime',
        ];
    }

    /**
     * El nivel académico al que pertenece esta clase pregrabada.
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'nivel_id');
    }

    /**
     * El docente que creó esta clase pregrabada.
     * Relación muchos a uno.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    /**
     * El administrador que revisó esta clase pregrabada.
     * Relación muchos a uno (nullable).
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    /**
     * Estados de clase pregrabada (constantes).
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
}
