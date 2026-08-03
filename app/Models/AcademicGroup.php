<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicGroup extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * La tabla asociada al modelo.
     * Se usa 'academic_groups' porque 'groups' es palabra reservada en MySQL.
     *
     * @var string
     */
    protected $table = 'academic_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'level_id',
        'teacher_id',
        'schedule_description',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * El nivel académico de este grupo.
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * El docente asignado a este grupo.
     * Relación muchos a uno.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Los estudiantes inscritos en este grupo.
     * Relación muchos a muchos a través de group_students.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_students', 'group_id', 'student_id')
            ->withPivot('joined_at', 'left_at', 'is_active')
            ->withTimestamps();
    }

    /**
     * Solo estudiantes activos del grupo.
     * 
     * @return BelongsToMany
     */
    public function activeStudents(): BelongsToMany
    {
        return $this->students()->wherePivot('is_active', true);
    }

    /**
     * Las sesiones de clase de este grupo.
     * Relación uno a muchos.
     */
    public function classSessions(): HasMany
    {
        return $this->hasMany(ClassSession::class, 'group_id');
    }

    /**
     * Las notas registradas para este grupo.
     * Relación uno a muchos.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class, 'group_id');
    }
}
