<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'local_id'];

    /**
     * Relación con SubDepartamento: Un departamento tiene muchos subdepartamentos.
     */
    public function subDepartamentos()
    {
        return $this->hasMany(SubDepartamento::class);
    }

    /**
     * Relación con Local: Un departamento pertenece a un local.
     */
    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    /**
     * Relación con Equipo: Un departamento tiene muchos equipos.
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}
