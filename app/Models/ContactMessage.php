<?php

namespace App\Models;

use App\Models\Concerns\ConMarcasDeTiempoEnEspanol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory, ConMarcasDeTiempoEnEspanol;

    protected $table = 'mensajes_contacto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'mensaje',
        'leido_en',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'leido_en' => 'datetime',
        ];
    }

    /**
     * Marca el mensaje como leído.
     * 
     * @return bool
     */
    public function markAsRead(): bool
    {
        if ($this->leido_en === null) {
            $this->leido_en = now();
            return $this->save();
        }
        return false;
    }

    /**
     * Verifica si el mensaje ha sido leído.
     * 
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
