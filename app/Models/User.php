<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
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
            'active' => 'boolean',
        ];
    }

    /**
     * Los roles que tiene este usuario.
     * Relación muchos a muchos a través de user_roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withPivot('assigned_at', 'assigned_by')
            ->withTimestamps();
    }

    /**
     * Perfil de estudiante (si tiene rol Estudiante).
     * Relación uno a uno.
     */
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * Perfil de docente (si tiene rol Docente).
     * Relación uno a uno.
     */
    public function teacherProfile(): HasOne
    {
        return $this->hasOne(TeacherProfile::class);
    }

    /**
     * Órdenes de compra realizadas por este estudiante.
     * Relación uno a muchos.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'student_id');
    }

    /**
     * Grupos académicos gestionados por este docente.
     * Relación uno a muchos (teacher_id en academic_groups).
     */
    public function teacherGroups(): HasMany
    {
        return $this->hasMany(AcademicGroup::class, 'teacher_id');
    }

    /**
     * Grupos académicos en los que este estudiante está inscrito.
     * Relación muchos a muchos a través de group_students.
     */
    public function studentGroups(): BelongsToMany
    {
        return $this->belongsToMany(AcademicGroup::class, 'group_students', 'student_id', 'group_id')
            ->withPivot('joined_at', 'left_at', 'is_active')
            ->withTimestamps();
    }

    /**
     * Notas del estudiante.
     * Relación uno a muchos.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class, 'student_id');
    }

    /**
     * Registros de niveles completados por el estudiante.
     * Relación uno a muchos.
     */
    public function records(): HasMany
    {
        return $this->hasMany(StudentRecord::class, 'student_id');
    }

    /**
     * Asistencia del estudiante a sesiones de clase.
     * Relación muchos a muchos a través de class_session_students.
     */
    public function classSessionAttendances(): BelongsToMany
    {
        return $this->belongsToMany(ClassSession::class, 'class_session_students', 'student_id', 'class_session_id')
            ->withPivot('attendance_status', 'notes')
            ->withTimestamps();
    }

    /**
     * Accesos del estudiante a materiales/clases pregrabadas.
     * Relación uno a muchos.
     */
    public function accesses(): HasMany
    {
        return $this->hasMany(StudentAccess::class, 'student_id');
    }

    /**
     * Suscripciones del estudiante.
     * Relación uno a muchos.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'student_id');
    }

    /**
     * Materiales creados por este docente.
     * Relación uno a muchos.
     */
    public function authoredMaterials(): HasMany
    {
        return $this->hasMany(Material::class, 'author_id');
    }

    /**
     * Clases pregrabadas creadas por este docente.
     * Relación uno a muchos.
     */
    public function authoredRecordedLessons(): HasMany
    {
        return $this->hasMany(RecordedLesson::class, 'author_id');
    }

    /**
     * Materiales revisados por este administrador.
     * Relación uno a muchos.
     */
    public function reviewedMaterials(): HasMany
    {
        return $this->hasMany(Material::class, 'reviewed_by');
    }

    /**
     * Clases pregrabadas revisadas por este administrador.
     * Relación uno a muchos.
     */
    public function reviewedRecordedLessons(): HasMany
    {
        return $this->hasMany(RecordedLesson::class, 'reviewed_by');
    }

    /**
     * Avisos/anuncios creados por este usuario.
     * Relación uno a muchos.
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'author_id');
    }

    /**
     * Verifica si el usuario tiene un rol específico.
     * 
     * @param string $roleSlug
     * @return bool
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    /**
     * Verifica si el usuario tiene alguno de los roles especificados.
     * 
     * @param array $roleSlugs
     * @return bool
     */
    public function hasAnyRole(array $roleSlugs): bool
    {
        return $this->roles()->whereIn('slug', $roleSlugs)->exists();
    }

    /**
     * Verifica si el usuario tiene todos los roles especificados.
     * 
     * @param array $roleSlugs
     * @return bool
     */
    public function hasAllRoles(array $roleSlugs): bool
    {
        return $this->roles()->whereIn('slug', $roleSlugs)->count() === count($roleSlugs);
    }
}
