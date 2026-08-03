<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'session_date',
        'start_time',
        'duration_minutes',
        'topic',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'start_time' => 'datetime',
            'duration_minutes' => 'integer',
        ];
    }

    /**
     * El grupo académico al que pertenece esta sesión.
     * Relación muchos a uno.
     */
    public function academicGroup(): BelongsTo
    {
        return $this->belongsTo(AcademicGroup::class, 'group_id');
    }

    /**
     * Los estudiantes y su asistencia a esta sesión.
     * Relación muchos a muchos a través de class_session_students.
     */
    public function attendances(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'class_session_students', 'class_session_id', 'student_id')
            ->withPivot('attendance_status', 'notes')
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
