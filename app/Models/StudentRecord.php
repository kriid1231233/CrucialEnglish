<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentRecord extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'registros_estudiante';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estudiante_id',
        'nivel_id',
        'completado_en',
        'promedio',
        'aprobado',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'completado_en' => 'date',
            'promedio' => 'decimal:1',
            'aprobado' => 'boolean',
        ];
    }

    /**
     * El estudiante al que pertenece este registro.
     * Relación muchos a uno.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    /**
     * El nivel académico completado.
     * Relación muchos a uno.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'nivel_id');
    }
}
