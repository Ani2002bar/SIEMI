<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;
use App\Models\Departamento;

class LocalController extends Controller
{
    public function index()
    {
        $locals = Local::with('departamentos')->get();
        return view('locals.index', compact('locals'));
    }

    public function create()
    {
        $departamentos = Departamento::whereNull('local_id')->get();
        return view('locals.create', compact('departamentos'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nombre_local' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'departamentos' => 'nullable',
    ]);

    $local = Local::create($request->only(['nombre_local', 'direccion']));

    if ($request->filled('departamentos')) {
        $departamentos = json_decode($request->departamentos, true);

        foreach ($departamentos as $dep) {
            Departamento::create([
                'nombre' => $dep['nombre'],
                'descripcion' => $dep['descripcion'],
                'local_id' => $local->id,
            ]);
        }
    }

    return redirect()->route('locals.index')->with('success', 'Local y departamentos creados exitosamente.');
}


    public function show($id)
    {
        $local = Local::with('departamentos')->findOrFail($id);
        return view('locals.detail', compact('local'));
    }

    public function edit($id)
    {
        $local = Local::findOrFail($id);
        return view('locals.edit', compact('local'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_local' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'direccion_ip' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $local = Local::findOrFail($id);

        $data = $request->only(['nombre_local', 'direccion', 'direccion_ip', 'telefono']);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('imagenes_locales', 'public');
        }

        $local->update($data);

        return redirect()->route('locals.index')->with('success', 'Local actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $local = Local::findOrFail($id);
        $local->delete();

        return redirect()->route('locals.index')->with('success', 'Local eliminado exitosamente.');
    }
}
