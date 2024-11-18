<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::latest()->get();
        return view('empresas.index', compact('empresas'));
    }

    public function create()
    {
        $locals = Local::all();
        return view('empresas.create', compact('locals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:45',
            'direccion' => 'required|string|max:200',
            'direccion_ip' => 'required|string|max:45',
            'telefono' => 'nullable|string|max:20',
            'local_id' => 'required|exists:locals,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('imagenes_empresas', 'public');
        }

        Empresa::create($data);

        return redirect()->route('empresas.index')->with('success', 'Empresa creada exitosamente.');
    }

    public function edit(Empresa $empresa)
    {
        $locals = Local::all();
        return view('empresas.edit', compact('empresa', 'locals'));
    }

    public function update(Request $request, Empresa $empresa)
{
    $request->validate([
        'nombre' => 'required|string|max:45',
        'direccion' => 'required|string|max:200',
        'direccion_ip' => 'required|string|max:45',
        'telefono' => 'nullable|string|max:20',
        'local_id' => 'required|exists:locals,id',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024000'
    ]);

    $data = $request->all();

    // Verificar si delete_image es "1" para eliminar la imagen
    if ($request->input('delete_image') == "1" && $empresa->imagen) {
        Storage::disk('public')->delete($empresa->imagen);
        $data['imagen'] = null;
    }

    // Manejar carga de nueva imagen
    if ($request->hasFile('imagen')) {
        if ($empresa->imagen) {
            Storage::disk('public')->delete($empresa->imagen);
        }
        $data['imagen'] = $request->file('imagen')->store('imagenes_empresas', 'public');
    }

    $empresa->update($data);

    return redirect()->route('empresas.index')->with('success', 'Empresa actualizada exitosamente.');
}


    public function show($id)
    {
        $empresa = Empresa::with('local')->findOrFail($id);
        return view('empresas.detail', compact('empresa'));
    }

    public function destroy(Empresa $empresa)
    {
        if ($empresa->imagen) {
            Storage::disk('public')->delete($empresa->imagen);
        }

        $empresa->delete();

        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada exitosamente.');
    }
}
