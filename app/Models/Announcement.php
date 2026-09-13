<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'anuncios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'contenido',
        'autor_id',
        'tipo_audiencia',
        'audiencia_id',
        'estado',
        'publicado_en',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'publicado_en' => 'datetime',
        ];
    }

    /**
     * El usuario que creó este aviso.
     * Relación muchos a uno.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    /**
     * Tipos de audiencia (constantes).
     */
    public const AUDIENCE_ALL = 'all';
    public const AUDIENCE_GROUP = 'group';
    public const AUDIENCE_LEVEL = 'level';

    /**
     * Estados de aviso (constantes).
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
}
