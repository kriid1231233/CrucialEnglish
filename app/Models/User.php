<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, ConMarcasDeTiempoEnEspanol;

    /** Columna de borrado suave en español. */
    const DELETED_AT = 'eliminado_en';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'activo',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    /**
     * Los roles que tiene este usuario.
     * Relación muchos a muchos a través de roles_usuario.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_usuario', 'usuario_id', 'rol_id')
            ->withPivot('asignado_en', 'asignado_por')
            ->withTimestamps();
    }

    /**
     * Perfil de estudiante (si tiene rol Estudiante).
     * Relación uno a uno.
     */
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class, 'usuario_id');
    }

    /**
     * Perfil de docente (si tiene rol Docente).
     * Relación uno a uno.
     */
    public function teacherProfile(): HasOne
    {
        return $this->hasOne(TeacherProfile::class, 'usuario_id');
    }

    /**
     * Órdenes de compra realizadas por este estudiante.
     * Relación uno a muchos.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'estudiante_id');
    }

    /**
     * El carrito de compra activo del estudiante (orden en estado pendiente).
     */
    public function cartOrder(): ?Order
    {
        return $this->orders()->where('estado', Order::STATUS_PENDING)->first();
    }

    /**
     * Cantidad total de items en el carrito activo del estudiante.
     */
    public function cartItemsCount(): int
    {
        return (int) ($this->cartOrder()?->items()->sum('cantidad') ?? 0);
    }

    /**
     * Grupos académicos gestionados por este docente.
     * Relación uno a muchos (docente_id en grupos_academicos).
     */
    public function teacherGroups(): HasMany
    {
        return $this->hasMany(AcademicGroup::class, 'docente_id');
    }

    /**
     * Grupos académicos en los que este estudiante está inscrito.
     * Relación muchos a muchos a través de estudiantes_grupo.
     */
    public function studentGroups(): BelongsToMany
    {
        return $this->belongsToMany(AcademicGroup::class, 'estudiantes_grupo', 'estudiante_id', 'grupo_id')
            ->withPivot('union_en', 'salida_en', 'activo')
            ->withTimestamps();
    }

    /**
     * Notas del estudiante.
     * Relación uno a muchos.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class, 'estudiante_id');
    }

    /**
     * Registros de niveles completados por el estudiante.
     * Relación uno a muchos.
     */
    public function records(): HasMany
    {
        return $this->hasMany(StudentRecord::class, 'estudiante_id');
    }

    /**
     * Asistencia del estudiante a sesiones de clase.
     * Relación muchos a muchos a través de asistencia_sesion.
     */
    public function classSessionAttendances(): BelongsToMany
    {
        return $this->belongsToMany(ClassSession::class, 'asistencia_sesion', 'estudiante_id', 'sesion_clase_id')
            ->withPivot('estado_asistencia', 'notas')
            ->withTimestamps();
    }

    /**
     * Accesos del estudiante a materiales/clases pregrabadas.
     * Relación uno a muchos.
     */
    public function accesses(): HasMany
    {
        return $this->hasMany(StudentAccess::class, 'estudiante_id');
    }

    /**
     * Suscripciones del estudiante.
     * Relación uno a muchos.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'estudiante_id');
    }

    /**
     * Materiales creados por este docente.
     * Relación uno a muchos.
     */
    public function authoredMaterials(): HasMany
    {
        return $this->hasMany(Material::class, 'autor_id');
    }

    /**
     * Clases pregrabadas creadas por este docente.
     * Relación uno a muchos.
     */
    public function authoredRecordedLessons(): HasMany
    {
        return $this->hasMany(RecordedLesson::class, 'autor_id');
    }

    /**
     * Materiales revisados por este administrador.
     * Relación uno a muchos.
     */
    public function reviewedMaterials(): HasMany
    {
        return $this->hasMany(Material::class, 'revisado_por');
    }

    /**
     * Clases pregrabadas revisadas por este administrador.
     * Relación uno a muchos.
     */
    public function reviewedRecordedLessons(): HasMany
    {
        return $this->hasMany(RecordedLesson::class, 'revisado_por');
    }

    /**
     * Avisos/anuncios creados por este usuario.
     * Relación uno a muchos.
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'autor_id');
    }

    /**
     * Verifica si el usuario tiene un rol específico.
     * 
     * @param string $roleSlug
     * @return bool
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->roles()->where('identificador', $roleSlug)->exists();
    }

    /**
     * Verifica si el usuario tiene alguno de los roles especificados.
     * 
     * @param array $roleSlugs
     * @return bool
     */
    public function hasAnyRole(array $roleSlugs): bool
    {
        return $this->roles()->whereIn('identificador', $roleSlugs)->exists();
    }

    /**
     * Verifica si el usuario tiene todos los roles especificados.
     * 
     * @param array $roleSlugs
     * @return bool
     */
    public function hasAllRoles(array $roleSlugs): bool
    {
        return $this->roles()->whereIn('identificador', $roleSlugs)->count() === count($roleSlugs);
    }
}
