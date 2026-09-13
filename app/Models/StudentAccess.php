<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAccess extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'accesos_estudiante';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estudiante_id',
        'producto_id',
        'tipo_acceso',
        'otorgado_en',
        'expira_en',
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
            'otorgado_en' => 'datetime',
            'expira_en' => 'datetime',
            'activo' => 'boolean',
        ];
    }

    /**
     * El estudiante que tiene este acceso.
     * Relación muchos a uno.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    /**
     * El producto al que se tiene acceso.
     * Relación muchos a uno.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    /**
     * Verifica si el acceso está vigente.
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->activo && 
               ($this->expira_en === null || now()->lte($this->expira_en));
    }

    /**
     * Tipos de acceso (constantes).
     */
    public const TYPE_MATERIAL = 'material';
    public const TYPE_RECORDED_LESSON = 'recorded_lesson';
}
