<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descripcion',
        'observaciones',
        'costo',
        'equipo_id',
        'local_id',
    ];

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_repuesto');
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }
}
