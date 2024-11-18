<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'modelo',
        'nro_serie',
        'observaciones',
        'direccion_ip',
        'anio_fabricacion',
        'estado',
        'fecha_instalacion',
        'empresa_id',
        'local_id',
        'departamento_id',
        'subdepartamento_id',
        'modalidades_id',
        'imagen',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function locale()
    {
        return $this->belongsTo(Local::class, 'local_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function subdepartamento()
    {
        return $this->belongsTo(SubDepartamento::class);
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class, 'modalidades_id');
    }
    public function repuestos()
{
    return $this->hasMany(Repuesto::class);
}

public function componentes()
{
    return $this->hasMany(Componente::class);
}

public function getImagenAttribute($value)
{
    return $value ? asset($value) : asset('img/6QQGqDyu_400x400.jpg');
}


}
