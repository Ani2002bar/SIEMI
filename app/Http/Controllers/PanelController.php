<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Mantenimiento;

class PanelController extends Controller
{
    public function index()
    {
        // Calcular estadísticas
        $totalEquipos = Equipo::count(); // Total de equipos
        $equiposInactivos = Equipo::where('estado', 'Inactivo')->count(); // Equipos inactivos
        $mantenimientosPendientes = Mantenimiento::where('estado', 'Pendiente')->count(); // Mantenimientos pendientes

        // Pasar estadísticas a la vista
        return view('panel.index', compact('totalEquipos', 'equiposInactivos', 'mantenimientosPendientes'));
    }
}
