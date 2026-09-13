<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassSession extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'sesiones_clase';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'grupo_id',
        'fecha_sesion',
        'hora_inicio',
        'duracion_minutos',
        'tema',
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
            'fecha_sesion' => 'date',
            'hora_inicio' => 'datetime',
            'duracion_minutos' => 'integer',
        ];
    }

    /**
     * El grupo académico al que pertenece esta sesión.
     * Relación muchos a uno.
     */
    public function academicGroup(): BelongsTo
    {
        return $this->belongsTo(AcademicGroup::class, 'grupo_id');
    }

    /**
     * Los estudiantes y su asistencia a esta sesión.
     * Relación muchos a muchos a través de asistencia_sesion.
     */
    public function attendances(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'asistencia_sesion', 'sesion_clase_id', 'estudiante_id')
            ->withPivot('estado_asistencia', 'notas')
            ->withTimestamps();
    }

    /**
     * Estados de sesión (constantes).
     */
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Estados de asistencia (constantes para pivot).
     */
    public const ATTENDANCE_PRESENT = 'present';
    public const ATTENDANCE_ABSENT = 'absent';
    public const ATTENDANCE_LATE = 'late';
    public const ATTENDANCE_JUSTIFIED = 'justified';
}
