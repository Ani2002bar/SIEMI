<?php

namespace App\Http\Controllers;

use App\Models\Repuesto;
use App\Models\Equipo;
use App\Models\Local;
use App\Models\Empresa;
use App\Models\Componente;
use App\Models\SubComponente;
use Illuminate\Http\Request;

class RepuestoController extends Controller
{
    public function index()
    {
        $repuestos = Repuesto::with(['equipo', 'local', 'empresa', 'componente', 'subcomponente'])->latest()->get();
        return view('repuestos.index', compact('repuestos'));
    }



    public function create()
    {
        $equipos = Equipo::all();
        $locals = Local::all();
        $empresas = Empresa::all();
        $componentes = Componente::all();
        $subcomponentes = SubComponente::all();

        return view('repuestos.create', compact('equipos', 'locals', 'empresas', 'componentes', 'subcomponentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nro_parte' => 'nullable|string|max:50',
            'nro_serie' => 'nullable|string|max:50',
            'descripcion' => 'required|string|max:200',
            'observaciones' => 'nullable|string|max:200',
            'costo' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Instalado,No Instalado',
            'equipo_id' => 'nullable|exists:equipos,id',
            'local_id' => 'nullable|exists:locals,id',
            'empresa_id' => 'nullable|exists:empresas,id',
            'componente_id' => 'nullable|exists:componentes,id',
            'subcomponente_id' => 'nullable|exists:subcomponentes,id',
        ]);

        Repuesto::create($request->all());

        return redirect()->route('repuestos.index')->with('success', 'Repuesto creado exitosamente.');
    }

    public function show(Repuesto $repuesto)
    {
        $repuesto->load(['equipo', 'local', 'empresa', 'componente', 'subcomponente']);
        return view('repuestos.detail', compact('repuesto'));
    }

    public function edit(Repuesto $repuesto)
    {
        $equipos = Equipo::all();
        $locals = Local::all();
        $empresas = Empresa::all();
        $componentes = Componente::all();
        $subcomponentes = SubComponente::all();

        return view('repuestos.edit', compact('repuesto', 'equipos', 'locals', 'empresas', 'componentes', 'subcomponentes'));
    }

    public function update(Request $request, Repuesto $repuesto)
    {
        $request->validate([
            'nro_parte' => 'nullable|string|max:50',
            'nro_serie' => 'nullable|string|max:50',
            'descripcion' => 'required|string|max:200',
            'observaciones' => 'nullable|string|max:200',
            'costo' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Instalado,No Instalado',
            'equipo_id' => 'nullable|exists:equipos,id',
            'local_id' => 'nullable|exists:locals,id',
            'empresa_id' => 'nullable|exists:empresas,id',
            'componente_id' => 'nullable|exists:componentes,id',
            'subcomponente_id' => 'nullable|exists:subcomponentes,id',
        ]);

        $repuesto->update($request->all());

        return redirect()->route('repuestos.index')->with('success', 'Repuesto actualizado exitosamente.');
    }

    public function destroy(Repuesto $repuesto)
    {
        $repuesto->delete();

        return redirect()->route('repuestos.index')->with('success', 'Repuesto eliminado exitosamente.');
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

}
