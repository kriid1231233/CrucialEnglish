<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    /**
     * Productos asociados a este nivel.
     * Relación uno a muchos.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Grupos académicos de este nivel.
     * Relación uno a muchos.
     */
    public function academicGroups(): HasMany
    {
        return $this->hasMany(AcademicGroup::class);
    }

    /**
     * Notas registradas para este nivel.
     * Relación uno a muchos.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }

    /**
     * Registros de completación de este nivel.
     * Relación uno a muchos.
     */
    public function records(): HasMany
    {
        return $this->hasMany(StudentRecord::class);
    }

    /**
     * Materiales asociados a este nivel.
     * Relación uno a muchos.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Clases pregrabadas asociadas a este nivel.
     * Relación uno a muchos.
     */
    public function recordedLessons(): HasMany
    {
        return $this->hasMany(RecordedLesson::class);
    }

    /**
     * Códigos de niveles del sistema (constantes).
     */
    public const A1 = 'A1';
    public const A2 = 'A2';
    public const B1 = 'B1';
    public const B2 = 'B2';
    public const C1 = 'C1';
    public const C2 = 'C2';
}
