<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'direccion_ip',
        'telefono', // Campo para teléfono
        'imagen',   // Campo para la imagen
        'local_id'
    ];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function locals()
{
    return $this->belongsToMany(Local::class, 'empresa_local', 'empresa_id', 'local_id');
}
}
