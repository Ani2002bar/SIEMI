<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Empresa;
use App\Models\Local;
use App\Models\Modalidad;
use App\Models\Departamento;
use App\Models\SubDepartamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Componente;
use App\Models\SubComponente;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipoController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipo::with(['empresa', 'modalidad', 'local']); // Relacionar datos necesarios

        // Aplicar filtros si están definidos
        if ($request->filled('empresa_id')) {
            $query->where('empresa_id', $request->empresa_id);
        }
        if ($request->filled('modalidad_id')) {
            $query->where('modalidades_id', $request->modalidad_id);
        }
        if ($request->filled('local_id')) {
            $query->where('local_id', $request->local_id);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Manejo de solicitudes AJAX
        if ($request->ajax()) {
            $equipos = $query->latest()->get(['id', 'descripcion', 'nro_serie', 'estado']);
            return response()->json(['equipos' => $equipos]);
        }

        // Cargar datos para la vista
        $equipos = $query->latest()->get();
        $empresas = Empresa::all();
        $locals = Local::all();
        $modalidades = Modalidad::all();

        return view('equipos.index', compact('equipos', 'empresas', 'locals', 'modalidades'));
    }






    public function create()
    {
        $empresas = Empresa::all();
        $locals = Local::all();
        $modalidades = Modalidad::all();
        $departamentos = Departamento::all();
        $subdepartamentos = SubDepartamento::all();

        return view('equipos.create', compact('empresas', 'locals', 'modalidades', 'departamentos', 'subdepartamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'local_id' => 'required|exists:locals,id',
            'descripcion' => 'required|string|max:200',
            'modelo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'nro_serie' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:200',
            'direccion_ip' => 'nullable|string|max:50',
            'anio_fabricacion' => 'nullable|date',
            'estado' => 'required|in:Activo,Inactivo',
            'fecha_instalacion' => 'nullable|date',
            'empresa_id' => 'nullable|exists:empresas,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'subdepartamento_id' => 'nullable|exists:subdepartamentos,id',
            'modalidades_id' => 'nullable|exists:modalidades,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'componentes' => 'nullable|json',
        ]);

        $data = $request->only([
            'local_id',
            'descripcion',
            'modelo',
            'marca',
            'nro_serie',
            'observaciones',
            'direccion_ip',
            'anio_fabricacion',
            'estado',
            'fecha_instalacion',
            'empresa_id',
            'departamento_id',
            'subdepartamento_id',
            'modalidades_id',
        ]);

        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('public/imagenes_equipos');
            $data['imagen'] = str_replace('public/', 'storage/', $imagePath);
        }

        $equipo = Equipo::create($data);

        if ($request->filled('componentes')) {
            $componentes = json_decode($request->input('componentes'), true);

            foreach ($componentes as $componenteData) {
                $componente = Componente::create([
                    'descripcion' => $componenteData['descripcion'],
                    'modelo' => $componenteData['modelo'],
                    'nro_serie' => $componenteData['nro_serie'],
                    'equipo_id' => $equipo->id,
                ]);

                foreach ($componenteData['subcomponentes'] as $subcomponenteData) {
                    SubComponente::create([
                        'descripcion' => $subcomponenteData['descripcion'],
                        'modelo' => $subcomponenteData['modelo'],
                        'nro_serie' => $subcomponenteData['nro_serie'],
                        'componente_id' => $componente->id,
                    ]);
                }
            }
        }

        return redirect()->route('equipos.index')->with('success', 'Equipo creado exitosamente.');
    }


    public function show($id)
    {
        $equipo = Equipo::with(['empresa', 'local', 'departamento', 'subdepartamento', 'modalidad'])->findOrFail($id);

        $repuestos = $equipo->repuestos;
        $componentes = $equipo->componentes;
        $subcomponentes = $componentes ? $componentes->flatMap->subcomponentes : collect();

        return view('equipos.detail', compact('equipo', 'repuestos', 'componentes', 'subcomponentes'));
    }

    public function edit(Equipo $equipo)
    {
        // Cargar relaciones del equipo con componentes y subcomponentes
        $equipo->load('componentes.subcomponentes');

        // Obtener datos adicionales para los selects
        $empresas = Empresa::all();
        $locals = Local::all();
        $modalidades = Modalidad::all();
        $departamentos = Departamento::where('local_id', $equipo->local_id)->get();
        $subdepartamentos = SubDepartamento::where('departamento_id', $equipo->departamento_id)->get();

        // Mapear componentes y subcomponentes para ser enviados como JSON
        $componentes = $equipo->componentes->map(function ($componente) {
            return [
                'id' => $componente->id,
                'descripcion' => $componente->descripcion,
                'modelo' => $componente->modelo,
                'nro_serie' => $componente->nro_serie,
                'subcomponentes' => $componente->subcomponentes->map(function ($subcomponente) {
                    return [
                        'id' => $subcomponente->id,
                        'descripcion' => $subcomponente->descripcion,
                        'modelo' => $subcomponente->modelo,
                        'nro_serie' => $subcomponente->nro_serie,
                    ];
                })->toArray(),
            ];
        })->toArray();

        return view('equipos.edit', compact(
            'equipo',
            'empresas',
            'locals',
            'modalidades',
            'departamentos',
            'subdepartamentos',
            'componentes' // Incluye componentes para el frontend
        ));
    }


    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'local_id' => 'required|exists:locals,id',
            'descripcion' => 'required|string|max:200',
            'modelo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'nro_serie' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:200',
            'direccion_ip' => 'nullable|string|max:50',
            'anio_fabricacion' => 'nullable|date',
            'estado' => 'required|in:Activo,Inactivo',
            'fecha_instalacion' => 'nullable|date',
            'empresa_id' => 'nullable|exists:empresas,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'subdepartamento_id' => 'nullable|exists:subdepartamentos,id',
            'modalidades_id' => 'nullable|exists:modalidades,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'componentes' => 'nullable|json',// Componentes enviados desde el formulario
        ]);

        $equipo->update($request->only([
            'descripcion',
            'modelo',
            'marca',
            'nro_serie',
            'observaciones',
            'direccion_ip',
            'anio_fabricacion',
            'estado',
            'fecha_instalacion',
            'empresa_id',
            'local_id',
            'departamento_id',
            'subdepartamento_id',
            'modalidades_id',
        ]));

        if ($request->filled('componentes')) {
            $componentes = json_decode($request->input('componentes'), true);

            // Eliminar componentes no enviados
            $componenteIds = collect($componentes)->pluck('id')->filter()->toArray();
            $equipo->componentes()->whereNotIn('id', $componenteIds)->delete();

            foreach ($componentes as $componenteData) {
                $componente = Componente::updateOrCreate(
                    ['id' => $componenteData['id'] ?? null],
                    [
                        'descripcion' => $componenteData['descripcion'],
                        'modelo' => $componenteData['modelo'],
                        'nro_serie' => $componenteData['nro_serie'],
                        'equipo_id' => $equipo->id,
                    ]
                );

                // Eliminar subcomponentes no enviados
                $subcomponenteIds = collect($componenteData['subcomponentes'])->pluck('id')->filter()->toArray();
                $componente->subcomponentes()->whereNotIn('id', $subcomponenteIds)->delete();

                foreach ($componenteData['subcomponentes'] as $subcomponenteData) {
                    SubComponente::updateOrCreate(
                        ['id' => $subcomponenteData['id'] ?? null],
                        [
                            'descripcion' => $subcomponenteData['descripcion'],
                            'modelo' => $subcomponenteData['modelo'],
                            'nro_serie' => $subcomponenteData['nro_serie'],
                            'componente_id' => $componente->id,
                        ]
                    );
                }
            }
        }

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado exitosamente.');
    }




    public function destroy(Equipo $equipo)
    {
        if ($equipo->imagen) {
            Storage::delete(str_replace('storage/', 'public/', $equipo->imagen));
        }

        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado exitosamente.');
    }
    public function getEmpresas($localId)
    {
        $empresas = Empresa::whereHas('locals', function ($query) use ($localId) {
            $query->where('locals.id', $localId);
        })->get(['id', 'nombre']);
        return response()->json($empresas);
    }

    public function getDepartamentos($localId)
    {
        $departamentos = Departamento::where('local_id', $localId)->get(['id', 'nombre']);
        return response()->json($departamentos);
    }

    public function getSubdepartamentos($departamentoId)
    {
        $subdepartamentos = SubDepartamento::where('departamento_id', $departamentoId)->get(['id', 'nombre']);
        return response()->json($subdepartamentos);
    }



    public function generatePdf(Request $request)
{
    $query = Equipo::with(['empresa', 'local', 'modalidad']); // Cargar relaciones necesarias

    // Aplicar los filtros si existen
    if ($request->filled('empresa_id')) {
        $query->where('empresa_id', $request->empresa_id);
    }
    if ($request->filled('modalidad_id')) {
        $query->where('modalidades_id', $request->modalidad_id);
    }
    if ($request->filled('local_id')) {
        $query->where('local_id', $request->local_id);
    }
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    // Obtiene los equipos filtrados
    $equipos = $query->get();

    // Genera el PDF
    $pdf = Pdf::loadView('equipos.pdf', compact('equipos'));
    return $pdf->download('Listado_de_Equipos.pdf');
}





    public function storeFromModal(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'equipo_id' => 'required|exists:equipos,id',
        ]);

        $componente = Componente::create($validated);

        return response()->json($componente, 201);
    }
    public function getComponentes($equipoId)
    {
        $componentes = Componente::where('equipo_id', $equipoId)->with('subcomponentes')->get();
        return response()->json($componentes);
    }

    public function getByEquipo($equipoId)
    {
        $componentes = Componente::where('equipo_id', $equipoId)->with('subcomponentes')->get();
        return response()->json($componentes);
    }


}
