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

    // Relación muchos a muchos con Repuestos
    public function repuestos()
{
    return $this->belongsToMany(Repuesto::class, 'mantenimiento_repuesto')
                ->withPivot(['costo_total', 'cantidad'])
                ->withTimestamps();
}
}

