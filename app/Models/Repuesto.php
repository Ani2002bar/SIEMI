<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro_parte',
        'nro_serie',
        'descripcion',
        'observaciones',
        'costo',
        'equipo_id',
        'local_id',
        'empresa_id',
        'subcomponente_id',
        'componente_id',
        'estado',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function subcomponente()
    {
        return $this->belongsTo(SubComponente::class);
    }

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
    public function mantenimientos()
    {
        return $this->belongsToMany(Mantenimiento::class, 'mantenimiento_repuesto')
                    ->withPivot('cantidad', 'costo_total')
                    ->withTimestamps();
    }
}
