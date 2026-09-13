<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicGroup extends Model
{
    use HasFactory, SoftDeletes, ConMarcasDeTiempoEnEspanol;

    /**
     * La tabla asociada al modelo.
     * Se usa 'grupos_academicos' porque 'grupos' es ambiguo y 'groups' es palabra reservada en MySQL.
     *
     * @var string
     */
    protected $table = 'grupos_academicos';

    /** Columna de borrado suave en español. */
    const DELETED_AT = 'eliminado_en';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'nivel_id',
        'docente_id',
        'descripcion_horario',
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
            'activo' => 'boolean',
        ];
    }

    /**
     * El nivel académico de este grupo.
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'nivel_id');
    }

    /**
     * El docente asignado a este grupo.
     * Relación muchos a uno.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    /**
     * Los estudiantes inscritos en este grupo.
     * Relación muchos a muchos a través de estudiantes_grupo.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'estudiantes_grupo', 'grupo_id', 'estudiante_id')
            ->withPivot('union_en', 'salida_en', 'activo')
            ->withTimestamps();
    }

    /**
     * Solo estudiantes activos del grupo.
     * 
     * @return BelongsToMany
     */
    public function activeStudents(): BelongsToMany
    {
        return $this->students()->wherePivot('activo', true);
    }

    /**
     * Las sesiones de clase de este grupo.
     * Relación uno a muchos.
     */
    public function classSessions(): HasMany
    {
        return $this->hasMany(ClassSession::class, 'grupo_id');
    }

    /**
     * Las notas registradas para este grupo.
     * Relación uno a muchos.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class, 'grupo_id');
    }
}
