<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentGrade extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'notas_estudiante';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estudiante_id',
        'nivel_id',
        'grupo_id',
        'tipo_evaluacion',
        'nota',
        'fecha_evaluacion',
        'comentarios',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nota' => 'decimal:1',
            'fecha_evaluacion' => 'date',
        ];
    }

    /**
     * El estudiante al que pertenece esta nota.
     * Relación muchos a uno.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    /**
     * El nivel académico de esta evaluación.
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'nivel_id');
    }

    /**
     * El grupo académico donde se realizó esta evaluación.
     * Relación muchos a uno.
     */
    public function academicGroup(): BelongsTo
    {
        return $this->belongsTo(AcademicGroup::class, 'grupo_id');
    }

    /**
     * Tipos de evaluación (constantes).
     */
    public const TYPE_TEST = 'prueba';
    public const TYPE_HOMEWORK = 'tarea';
    public const TYPE_ORAL = 'oral';
    public const TYPE_FINAL = 'final';
}
