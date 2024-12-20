<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
    ];

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}