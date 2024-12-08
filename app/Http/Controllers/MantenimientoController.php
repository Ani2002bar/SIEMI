<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Tecnico;
use App\Models\Local;
use App\Models\Equipo;
use App\Models\Repuesto;
use App\Models\Empresa;
use App\Models\Componente;
use App\Models\SubComponente;
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

    // Mostrar formulario para crear mantenimiento
    public function create()
    {
        $tecnicos = Tecnico::all();
        $locals = Local::all();
        $equipos = Equipo::all();
        $repuestos = Repuesto::all();
        $empresas = Empresa::all() ?? collect(); // Use collect() for an empty fallback
        $componentes = Componente::all() ?? collect();
        $subcomponentes = SubComponente::all() ?? collect();

        $estados = ['pendiente' => 'Pendiente', 'finalizado' => 'Finalizado'];

        return view('mantenimientos.create', compact(
            'tecnicos',
            'locals',
            'equipos',
            'repuestos',
            'empresas',
            'componentes',
            'subcomponentes',
            'estados'
        ));
    }



    // Guardar nuevo mantenimiento
    public function store(Request $request)
{
    $request->validate([
        'estado' => 'required|in:pendiente,finalizado',
        'fecha' => 'required|date',
        'observaciones' => 'nullable|string|max:200',
        'tecnico_id' => 'required|exists:tecnicos,id',
        'local_id' => 'required|exists:locals,id',
        'equipo_id' => 'required|exists:equipos,id',
        'repuestos' => 'nullable|json',
    ]);

    // Decodificar el campo `repuestos`
    $repuestos = json_decode($request->input('repuestos', '[]'), true);
    if (!is_array($repuestos)) {
        return redirect()->back()->withErrors(['repuestos' => 'Los datos de repuestos no son válidos.']);
    }

    // Calcular el costo total de reparación
    $costoReparacion = 0;
    foreach ($repuestos as $repuesto) {
        $costoReparacion += ($repuesto['costo'] ?? 0) * ($repuesto['cantidad'] ?? 1);
    }

    // Crear el mantenimiento
    $mantenimiento = Mantenimiento::create([
        'estado' => $request->input('estado'),
        'fecha' => $request->input('fecha'),
        'observaciones' => $request->input('observaciones'),
        'tecnico_id' => $request->input('tecnico_id'),
        'local_id' => $request->input('local_id'),
        'equipo_id' => $request->input('equipo_id'),
        'costo_reparacion' => $costoReparacion,
    ]);

    // Vincular los repuestos al mantenimiento
    if (!empty($repuestos)) {
        $syncData = [];
        foreach ($repuestos as $repuesto) {
            $syncData[$repuesto['id']] = [
                'cantidad' => $repuesto['cantidad'] ?? 1,
                'costo_total' => $repuesto['costo'] ?? 0,
            ];
        }
        $mantenimiento->repuestos()->sync($syncData);
    }

    return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento registrado exitosamente.');
}

 
// Mostrar formulario de edición
public function edit(Mantenimiento $mantenimiento)
{
    $tecnicos = Tecnico::all();
    $locals = Local::all();
    $equipos = Equipo::all();
    $repuestos = Repuesto::all();
    $empresas = Empresa::all();
    $componentes = Componente::all();
    $subcomponentes = SubComponente::all();

    // Obtener repuestos vinculados al mantenimiento
    $repuestosVinculados = $mantenimiento->repuestos()->get()->map(function ($repuesto) {
        return [
            'id' => $repuesto->id,
            'descripcion' => $repuesto->descripcion,
            'costo' => $repuesto->pivot->costo_total,
        ];
    });

    $costoReparacion = $repuestosVinculados->sum(fn($r) => $r['costo']);

    return view('mantenimientos.edit', compact(
        'mantenimiento',
        'tecnicos',
        'locals',
        'equipos',
        'repuestos',
        'repuestosVinculados',
        'empresas',
        'componentes',
        'subcomponentes',
        'costoReparacion'
    ));
}

// Actualizar mantenimiento// Actualizar mantenimiento
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
        'repuestos' => 'nullable|json', // JSON que contiene los repuestos
    ]);

    // Actualizar datos principales del mantenimiento
    $mantenimiento->update($request->only([
        'costo_reparacion',
        'estado',
        'fecha',
        'observaciones',
        'tecnico_id',
        'local_id',
        'equipo_id',
    ]));

    // Sincronizar repuestos vinculados
    if ($request->filled('repuestos')) {
        $repuestos = json_decode($request->input('repuestos'), true);

        $syncData = [];
        foreach ($repuestos as $repuesto) {
            $syncData[$repuesto['id']] = [
                'cantidad' => $repuesto['cantidad'] ?? 1,
                'costo_total' => $repuesto['costo'] ?? 0,
            ];
        }

        $mantenimiento->repuestos()->sync($syncData); // Sincronizar relación
    } else {
        $mantenimiento->repuestos()->detach(); // Desvincular si no hay repuestos
    }

    return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento actualizado exitosamente.');
}





    // Eliminar mantenimiento
    public function destroy(Mantenimiento $mantenimiento)
    {
        $mantenimiento->repuestos()->detach();
        $mantenimiento->delete();

        return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento eliminado exitosamente.');
    }

    // Mostrar detalles de un mantenimiento
    public function show($id)
{
    $mantenimiento = Mantenimiento::with(['tecnico', 'local', 'equipo', 'repuestos'])->findOrFail($id);

    $repuestos = $mantenimiento->repuestos->map(function ($repuesto) {
        return [
            'id' => $repuesto->id,
            'descripcion' => $repuesto->descripcion,
            'cantidad' => $repuesto->pivot->cantidad,
            'costo_total' => $repuesto->pivot->costo_total,
        ];
    });

    return view('mantenimientos.detail', compact('mantenimiento', 'repuestos'));
}




    // Generar PDF de mantenimiento
    public function generatePdf($id)
    {
        $mantenimiento = Mantenimiento::with(['local', 'tecnico', 'equipo', 'repuestos'])->findOrFail($id);

        $pdf = Pdf::loadView('mantenimientos.pdf', compact('mantenimiento'));
        return $pdf->download('Hoja_Intervencion_Tecnica_' . $mantenimiento->id . '.pdf');
    }

    // Mostrar calendario de mantenimientos
    public function calendar()
    {
        $events = Mantenimiento::with('equipo')
            ->get()
            ->map(function ($mantenimiento) {
                return [
                    'id' => $mantenimiento->id,
                    'title' => $mantenimiento->equipo->descripcion, // Mostrar la descripción del equipo
                    'start' => $mantenimiento->fecha,
                    'color' => $mantenimiento->estado === 'pendiente' ? '#ffc107' : '#28a745', // Amarillo si pendiente, verde si finalizado
                    'url' => route('mantenimientos.show', $mantenimiento->id), // Enlace al detalle del mantenimiento
                ];
            });

        return view('calendar.index', ['events' => $events]);
    }

    public function getRepuestos()
    {
        try {
            $repuestos = Repuesto::all(['id', 'descripcion', 'nro_parte', 'nro_serie', 'costo']);
            return response()->json($repuestos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudieron cargar los repuestos.'], 500);
        }
    }

    public function storeRepuesto(Request $request)
{
    $request->validate([
        'nro_parte' => 'nullable|string|max:100',
        'nro_serie' => 'nullable|string|max:100',
        'descripcion' => 'required|string|max:255',
        'observaciones' => 'nullable|string|max:500',
        'costo' => 'required|numeric|min:0',
    ]);

    try {
        $repuesto = Repuesto::create($request->all());
        return response()->json($repuesto, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'No se pudo crear el repuesto.'], 500);
    }
}



    public function destroyRepuesto(Repuesto $repuesto)
    {
        try {
            $repuesto->delete();
            return response()->json(['message' => 'Repuesto eliminado exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar el repuesto.'], 500);
        }
    }
    public function getFilteredRepuestos(Request $request)
{
    $query = Repuesto::query();

    // Filtrar por equipo
    if ($request->filled('equipo_id')) {
        $query->where('equipo_id', $request->input('equipo_id'));
    }

    // Filtrar por local
    if ($request->filled('local_id')) {
        $query->where('local_id', $request->input('local_id'));
    }

    // Filtrar por empresa
    if ($request->filled('empresa_id')) {
        $query->where('empresa_id', $request->input('empresa_id'));
    }

    // Obtener los datos filtrados
    $repuestos = $query->get();

    return response()->json($repuestos);
}



}
