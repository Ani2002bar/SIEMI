<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'modelo',
        'nro_serie',
        'equipo_id'
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
    public function subcomponentes()
{
    return $this->hasMany(SubComponente::class);
}
}
