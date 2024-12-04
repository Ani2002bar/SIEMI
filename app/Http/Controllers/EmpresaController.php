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
    $validated = $request->validate([
        'nombre' => 'required|string|max:45',
        'direccion' => 'required|string|max:200',
        'direccion_ip' => 'required|string|max:45',
        'telefono' => 'nullable|string|max:20',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'locals' => 'nullable|string', // Validar como string porque se envía como JSON
    ]);

    if ($request->hasFile('imagen')) {
        $validated['imagen'] = $request->file('imagen')->store('imagenes_empresas', 'public');
    }

    $empresa = Empresa::create($validated);

    // Sincronizar locals vinculados
    if ($request->filled('locals')) {
        $localIds = json_decode($request->input('locals'), true); // Decodificar JSON
        if (is_array($localIds)) {
            $empresa->locals()->sync($localIds); // Sincronizar locals
        }
    }

    // Verificar si la solicitud es AJAX
    if ($request->ajax()) {
        return response()->json($empresa); // Devuelve la empresa recién creada como JSON
    }

    return redirect()->route('empresas.index')->with('success', 'Empresa creada exitosamente.');
}



    public function getExistingEmpresas()
    {
        $empresas = Empresa::select('id', 'nombre', 'direccion')->get();
        return response()->json($empresas);
    }

    public function getExistingLocales()
    {
        $locals = Local::select('id', 'nombre_local', 'direccion')->get();
        return response()->json($locals);
    }

    public function edit(Empresa $empresa)
{
    // Obtener todos los locales existentes
    $locals = Local::select('id', 'nombre_local')->get();

    // Obtener los locales vinculados a la empresa con su información completa
    $vinculados = $empresa->locals()->select('locals.id', 'locals.nombre_local')->get();

    return view('empresas.edit', compact('empresa', 'locals', 'vinculados'));
}
public function update(Request $request, Empresa $empresa)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:45',
        'direccion' => 'required|string|max:200',
        'direccion_ip' => 'required|string|max:45',
        'telefono' => 'nullable|string|max:20',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'locals' => 'nullable|string', // Expected as JSON
    ]);

    // Handle image removal or upload
    if ($request->input('delete_image') == "1" && $empresa->imagen) {
        Storage::disk('public')->delete($empresa->imagen);
        $validated['imagen'] = null;
    }

    if ($request->hasFile('imagen')) {
        if ($empresa->imagen) {
            Storage::disk('public')->delete($empresa->imagen);
        }
        $validated['imagen'] = $request->file('imagen')->store('imagenes_empresas', 'public');
    }

    $empresa->update($validated);

    // Update linked locals
    if ($request->filled('locals')) {
        $localIds = json_decode($request->input('locals'), true); // Decode JSON input
        if (is_array($localIds)) {
            $empresa->locals()->sync($localIds); // Replace current locals with new list
        }
    } else {
        // If no locals are provided, do not detach any
        // Leave the current locals as they are
    }

    return redirect()->route('empresas.index')->with('success', 'Empresa actualizada exitosamente.');
}


    public function show($id)
    {
        $empresa = Empresa::with('locals')->findOrFail($id);
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
