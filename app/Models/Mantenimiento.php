<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'costo_reparacion',
        'estado',
        'fecha',
        'observaciones',
        'tecnico_id',
        'local_id',
        'equipo_id',
        'repuesto_id',
        'componente_id',
        'subcomponente_id',
    ];

    // Relación con Técnico
    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    // Relación con Local
    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    // Relación con Equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    // Relación con Repuesto
    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class);
    }

    // Relación con Componente
    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    // Relación con Subcomponente
    public function subcomponente()
    {
        return $this->belongsTo(Subcomponente::class);
    }
}