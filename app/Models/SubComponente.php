<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubComponente extends Model
{
    use HasFactory;
    protected $table = 'subcomponentes'; 
    protected $fillable = ['descripcion', 'modelo', 'nro_serie', 'componente_id'];

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
}
