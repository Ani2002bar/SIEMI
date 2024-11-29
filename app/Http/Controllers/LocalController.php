<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;
use App\Models\Empresa;
use App\Models\Departamento;
use App\Models\SubDepartamento;
use Illuminate\Support\Facades\Storage;

class LocalController extends Controller
{
    public function index()
    {
        $locals = Local::with('departamentos', 'empresas')->get();
        return view('locals.index', compact('locals'));
    }

    public function create()
    {
        $empresas = Empresa::all(); // Todas las empresas para el modal
        return view('locals.create', ['empresas' => json_encode($empresas)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_local' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'direccion_ip' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'departamentos' => 'nullable|json',
            'empresas' => 'nullable|json',
        ]);

        $data = $request->only(['nombre_local', 'direccion', 'direccion_ip', 'telefono']);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('imagenes_locales', 'public');
        } else {
            $data['imagen'] = 'img/imagen_por_defecto.jpg'; // Imagen por defecto
        }

        $local = Local::create($data);

        // Procesar departamentos y subdepartamentos
        if ($request->filled('departamentos')) {
            $departamentos = json_decode($request->departamentos, true);

            foreach ($departamentos as $dep) {
                $departamento = Departamento::create([
                    'nombre' => $dep['nombre'],
                    'descripcion' => $dep['descripcion'],
                    'local_id' => $local->id,
                ]);

                if (isset($dep['subdepartamentos']) && is_array($dep['subdepartamentos'])) {
                    foreach ($dep['subdepartamentos'] as $subdep) {
                        SubDepartamento::create([
                            'nombre' => $subdep['nombre'],
                            'descripcion' => $subdep['descripcion'],
                            'departamento_id' => $departamento->id,
                        ]);
                    }
                }
            }
        }

        // Vincular empresas
        if ($request->filled('empresas')) {
            $empresas = json_decode($request->empresas, true);
            $empresaIds = collect($empresas)->pluck('id')->toArray();
            $local->empresas()->sync($empresaIds);
        }

        return redirect()->route('locals.index')->with('success', 'Local creado exitosamente.');
    }

    public function edit(Local $local)
{
    $local->load('departamentos.subdepartamentos', 'empresas');

    $departamentos = $local->departamentos->map(function ($departamento) {
        return [
            'id' => $departamento->id,
            'nombre' => $departamento->nombre,
            'descripcion' => $departamento->descripcion,
            'subdepartamentos' => $departamento->subdepartamentos->map(function ($subdepartamento) {
                return [
                    'id' => $subdepartamento->id,
                    'nombre' => $subdepartamento->nombre,
                    'descripcion' => $subdepartamento->descripcion,
                ];
            })->toArray(),
        ];
    })->toArray();

    $empresas = Empresa::all()->map(function ($empresa) {
        return [
            'id' => $empresa->id,
            'nombre' => $empresa->nombre,
            'direccion' => $empresa->direccion,
        ];
    });

    $empresasVinculadas = $local->empresas->map(function ($empresa) {
        return [
            'id' => $empresa->id,
            'nombre' => $empresa->nombre,
            'direccion' => $empresa->direccion,
        ];
    });

    return view('locals.edit', [
        'local' => $local,
        'empresas' => $empresas->toJson(), // Enviar todas las empresas como JSON
        'empresasVinculadas' => $empresasVinculadas->toJson(), // Empresas ya vinculadas
        'departamentos' => $local->departamentos->toJson(), // Departamentos y subdepartamentos
    ]);
}



    public function update(Request $request, Local $local)
    {
        $request->validate([
            'nombre_local' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'direccion_ip' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'departamentos' => 'nullable|json',
            'empresas' => 'nullable|json',
        ]);

        $data = $request->only(['nombre_local', 'direccion', 'direccion_ip', 'telefono']);

        if ($request->input('delete_image') == "1" && $local->imagen) {
            Storage::disk('public')->delete($local->imagen);
            $data['imagen'] = null;
        }

        if ($request->hasFile('imagen')) {
            if ($local->imagen) {
                Storage::disk('public')->delete($local->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('imagenes_locales', 'public');
        }

        $local->update($data);

        // Actualizar departamentos y subdepartamentos
        if ($request->filled('departamentos')) {
            $departamentos = json_decode($request->departamentos, true);

            $idsExistentes = collect($departamentos)->pluck('id')->filter()->toArray();
            $local->departamentos()->whereNotIn('id', $idsExistentes)->delete();

            foreach ($departamentos as $dep) {
                $departamento = Departamento::updateOrCreate(
                    ['id' => $dep['id'] ?? null],
                    ['nombre' => $dep['nombre'], 'descripcion' => $dep['descripcion'], 'local_id' => $local->id]
                );

                $subdepartamentos = $dep['subdepartamentos'] ?? [];
                $idsSubExistentes = collect($subdepartamentos)->pluck('id')->filter()->toArray();
                $departamento->subdepartamentos()->whereNotIn('id', $idsSubExistentes)->delete();

                foreach ($subdepartamentos as $subdep) {
                    SubDepartamento::updateOrCreate(
                        ['id' => $subdep['id'] ?? null],
                        ['nombre' => $subdep['nombre'], 'descripcion' => $subdep['descripcion'], 'departamento_id' => $departamento->id]
                    );
                }
            }
        }

        // Actualizar empresas asociadas
        // Actualizar empresas asociadas
        if ($request->filled('empresas')) {
            $empresas = json_decode($request->input('empresas'), true);
            if (is_array($empresas)) {
                $empresaIds = collect($empresas)->pluck('id')->toArray();
                $local->empresas()->sync($empresaIds); // Sync empresas with local
            }
        }

        return redirect()->route('locals.index')->with('success', 'Local actualizado exitosamente.');
    }

    public function show($id)
    {
        $local = Local::with('departamentos.subdepartamentos', 'empresas')->findOrFail($id);
        return view('locals.detail', compact('local'));
    }

    public function destroy($id)
    {
        $local = Local::findOrFail($id);

        if ($local->imagen && $local->imagen !== 'img/imagen_por_defecto.jpg') {
            Storage::disk('public')->delete($local->imagen);
        }

        $local->departamentos()->each(function ($departamento) {
            $departamento->subdepartamentos()->delete();
            $departamento->delete();
        });

        $local->delete();

        return redirect()->route('locals.index')->with('success', 'Local y sus departamentos asociados eliminados exitosamente.');
    }
}