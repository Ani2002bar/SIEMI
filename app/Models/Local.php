<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_local',
        'direccion',
        'direccion_ip',
        'telefono', // Campo para teléfono
        'imagen'    // Campo para la imagen
    ];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }
    public function departamentos()
{
    return $this->hasMany(Departamento::class);
}

public function subdepartamentos()
{
    return $this->hasManyThrough(SubDepartamento::class, Departamento::class);
}

}
