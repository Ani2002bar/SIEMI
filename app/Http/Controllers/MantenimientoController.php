<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Tecnico;
use App\Models\Local;
use App\Models\Equipo;
use App\Models\Repuesto;
use App\Models\Componente;
use App\Models\Subcomponente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class MantenimientoController extends Controller
{
    // Mostrar lista de mantenimientos
    public function index()
    {
        $mantenimientos = Mantenimiento::with(['tecnico', 'local', 'equipo'])->get();
        return view('mantenimientos.index', compact('mantenimientos'));
    }

    /**
     * Show the form for creating a new maintenance record.
     */
    public function create()
    {
        $tecnicos = Tecnico::all();
        $locals = Local::all();
        $equipos = Equipo::all();

        // States for the maintenance status
        $estados = ['pendiente' => 'Pendiente', 'finalizado' => 'Finalizado'];

        return view('mantenimientos.create', compact('tecnicos', 'locals', 'equipos', 'estados'));
    }

    /**
     * Store a new maintenance record in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'costo_reparacion' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,finalizado',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string|max:200',
            'tecnico_id' => 'required|exists:tecnicos,id',
            'local_id' => 'required|exists:locals,id',
            'equipo_id' => 'required|exists:equipos,id',
        ]);

        Mantenimiento::create($request->all());

        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento registrado exitosamente.');
    }

    // Mostrar formulario para editar mantenimiento
    public function edit(Mantenimiento $mantenimiento)
    {
        $tecnicos = Tecnico::all();
        $locals = Local::all();
        $equipos = Equipo::all();
        $repuestos = Repuesto::all();
        $componentes = Componente::all();
        $subcomponentes = Subcomponente::all();

        return view('mantenimientos.edit', compact('mantenimiento', 'tecnicos', 'locals', 'equipos', 'repuestos', 'componentes', 'subcomponentes'));
    }

    // Actualizar mantenimiento en la base de datos
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $request->validate([
            'costo_reparacion' => 'required|numeric|min:0',
            'estado' => 'required|string|max:100',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string|max:200',
            'tecnico_id' => 'required|exists:tecnicos,id',
            'local_id' => 'required|exists:locals,id',
            'equipo_id' => 'required|exists:equipos,id',
            'repuesto_id' => 'nullable|exists:repuestos,id',
            'componente_id' => 'nullable|exists:componentes,id',
            'subcomponente_id' => 'nullable|exists:subcomponentes,id',
        ]);

        $mantenimiento->update($request->all());

        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento actualizado exitosamente.');
    }

    // Eliminar mantenimiento
    public function destroy(Mantenimiento $mantenimiento)
    {
        $mantenimiento->delete();
        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento eliminado exitosamente.');
    }



public function show($id)
{
    $mantenimiento = Mantenimiento::with(['tecnico', 'equipo', 'local'])->findOrFail($id);
    return view('mantenimientos.detail', compact('mantenimiento'));
}
public function generatePdf($id)
{
    $mantenimiento = Mantenimiento::with(['local', 'tecnico', 'equipo'])->findOrFail($id);

    $pdf = Pdf::loadView('mantenimientos.pdf', compact('mantenimiento'));
    return $pdf->download('Hoja_Intervencion_Tecnica_' . $mantenimiento->id . '.pdf');
}
public function calendar()
{
    $events = Mantenimiento::select('id', 'estado as title', 'fecha as start', 'observaciones as description')
        ->get()
        ->map(function ($mantenimiento) {
            return [
                'id' => $mantenimiento->id,
                'title' => 'Estado: ' . $mantenimiento->title,
                'start' => $mantenimiento->start,
                'color' => $mantenimiento->title === 'Activo' ? '#28a745' : '#ffc107',
                'description' => $mantenimiento->description,
            ];
        });

    return view('calendar.index', ['events' => $events]);
}




}
