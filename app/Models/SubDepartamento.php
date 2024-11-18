<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDepartamento extends Model
{
    use HasFactory;

    protected $table = 'subdepartamentos'; // Especifica el nombre de la tabla

    protected $fillable = ['nombre', 'descripcion', 'funciones', 'departamento_id'];

    /**
     * Relación con Departamento: Un subdepartamento pertenece a un departamento.
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Relación con Equipo: Un subdepartamento tiene muchos equipos.
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}
