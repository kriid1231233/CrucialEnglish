<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'orden',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'orden' => 'integer',
        ];
    }

    /**
     * Productos asociados a este nivel.
     * Relación uno a muchos.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'nivel_id');
    }

    /**
     * Grupos académicos de este nivel.
     * Relación uno a muchos.
     */
    public function academicGroups(): HasMany
    {
        return $this->hasMany(AcademicGroup::class, 'nivel_id');
    }

    /**
     * Notas registradas para este nivel.
     * Relación uno a muchos.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class, 'nivel_id');
    }

    /**
     * Registros de completación de este nivel.
     * Relación uno a muchos.
     */
    public function records(): HasMany
    {
        return $this->hasMany(StudentRecord::class, 'nivel_id');
    }

    /**
     * Materiales asociados a este nivel.
     * Relación uno a muchos.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'nivel_id');
    }

    /**
     * Clases pregrabadas asociadas a este nivel.
     * Relación uno a muchos.
     */
    public function recordedLessons(): HasMany
    {
        return $this->hasMany(RecordedLesson::class, 'nivel_id');
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
