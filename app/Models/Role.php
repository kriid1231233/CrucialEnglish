<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'identificador',
        'descripcion',
    ];

    /**
     * Los usuarios que tienen este rol.
     * Relación muchos a muchos a través de roles_usuario.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'roles_usuario', 'rol_id', 'usuario_id')
            ->withPivot('asignado_en', 'asignado_por')
            ->withTimestamps();
    }

    /**
     * Identificadores de roles del sistema (constantes para uso en código).
     */
    public const STUDENT = 'estudiante';
    public const TEACHER = 'docente';
    public const ADMIN = 'administrador';
}
