<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentGrade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'level_id',
        'group_id',
        'evaluation_type',
        'grade',
        'evaluation_date',
        'comments',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'grade' => 'decimal:1',
            'evaluation_date' => 'date',
        ];
    }

    /**
     * El estudiante al que pertenece esta nota.
     * Relación muchos a uno.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * El nivel académico de esta evaluación.
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * El grupo académico donde se realizó esta evaluación.
     * Relación muchos a uno.
     */
    public function academicGroup(): BelongsTo
    {
        return $this->belongsTo(AcademicGroup::class, 'group_id');
    }

    /**
     * Tipos de evaluación (constantes).
     */
    public const TYPE_TEST = 'prueba';
    public const TYPE_HOMEWORK = 'tarea';
    public const TYPE_ORAL = 'oral';
    public const TYPE_FINAL = 'final';
}
