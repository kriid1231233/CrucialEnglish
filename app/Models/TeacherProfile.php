<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'specialization',
        'bio',
        'availability_schedule',
    ];

    /**
     * El usuario al que pertenece este perfil de docente.
     * Relación uno a uno inversa.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
