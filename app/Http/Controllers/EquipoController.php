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

class EquipoController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipo::query();

        if ($request->filled('empresa_id')) {
            $query->where('empresa_id', $request->empresa_id);
        }
        if ($request->filled('modalidad_id')) {
            $query->where('modalidades_id', $request->modalidad_id);
        }
        if ($request->filled('local_id')) {
            $query->where('local_id', $request->local_id);
        }
        if ($request->filled('departamento_id')) {
            $query->where('departamento_id', $request->departamento_id);
        }
        if ($request->filled('subdepartamento_id')) {
            $query->where('subdepartamento_id', $request->subdepartamento_id);
        }

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
            'descripcion' => 'required|string|max:200',
            'modelo' => 'required|string|max:50',
            'nro_serie' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:200',
            'direccion_ip' => 'nullable|string|max:50',
            'anio_fabricacion' => 'required|date',
            'estado' => 'required|string|max:45',
            'fecha_instalacion' => 'required|date',
            'empresa_id' => 'required|exists:empresas,id',
            'local_id' => 'required|exists:locals,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'subdepartamento_id' => 'required|exists:subdepartamentos,id',
            'modalidades_id' => 'required|exists:modalidades,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only([
            'descripcion',
            'modelo',
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
        ]);

        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('public/imagenes_equipos');
            $data['imagen'] = str_replace('public/', 'storage/', $imagePath);
        }

        Equipo::create($data);

        return redirect()->route('equipos.index')->with('success', 'Equipo creado exitosamente.');
    }

    public function show($id)
    {
        $equipo = Equipo::with(['empresa', 'locale', 'departamento', 'subdepartamento', 'modalidad'])->findOrFail($id);

        $repuestos = $equipo->repuestos; 
        $componentes = $equipo->componentes;
        $subcomponentes = $componentes ? $componentes->flatMap->subcomponentes : collect();

        return view('equipos.detail', compact('equipo', 'repuestos', 'componentes', 'subcomponentes'));
    }

    public function edit(Equipo $equipo)
    {
        $empresas = Empresa::all();
        $locals = Local::all();
        $modalidades = Modalidad::all();
        $departamentos = Departamento::where('local_id', $equipo->local_id)->get();
        $subdepartamentos = SubDepartamento::where('departamento_id', $equipo->departamento_id)->get();
        return view('equipos.edit', compact('equipo', 'empresas', 'locals', 'modalidades', 'departamentos', 'subdepartamentos'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'descripcion' => 'required|string|max:200',
            'modelo' => 'required|string|max:50',
            'nro_serie' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:200',
            'direccion_ip' => 'nullable|string|max:50',
            'anio_fabricacion' => 'required|date',
            'estado' => 'required|string|max:45',
            'fecha_instalacion' => 'required|date',
            'empresa_id' => 'required|exists:empresas,id',
            'local_id' => 'required|exists:locals,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'subdepartamento_id' => 'required|exists:subdepartamentos,id',
            'modalidades_id' => 'required|exists:modalidades,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only([
            'descripcion',
            'modelo',
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
        ]);

        if ($request->input('delete_image') == 1 && $equipo->imagen) {
            Storage::delete(str_replace('storage/', 'public/', $equipo->imagen));
            $data['imagen'] = null;
        } elseif ($request->hasFile('imagen')) {
            if ($equipo->imagen) {
                Storage::delete(str_replace('storage/', 'public/', $equipo->imagen));
            }
            $imagePath = $request->file('imagen')->store('public/imagenes_equipos');
            $data['imagen'] = str_replace('public/', 'storage/', $imagePath);
        }

        $equipo->update($data);

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

    public function getDepartamentosByLocal($localId)
    {
        $departamentos = Departamento::where('local_id', $localId)->get();
        return response()->json($departamentos);
    }

    public function getSubdepartamentosByDepartamento($departamentoId)
    {
        $subdepartamentos = SubDepartamento::where('departamento_id', $departamentoId)->get();
        return response()->json($subdepartamentos);
    }

}