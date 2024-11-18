<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;
use Illuminate\Support\Facades\Storage;

class LocalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locals = Local::all();
        return view('locals.index', compact('locals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombre_local' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'direccion_ip' => 'nullable|string|max:45',
            'telefono' => 'nullable|string|max:20',
            'imagen' => 'nullable|image|max:2048' // Imagen opcional
        ]);

        // Crear nuevo Local y subir la imagen si está presente
        $local = new Local($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            // Guarda la imagen en 'public/imagenes' y almacena la ruta en la base de datos
            $imagePath = $request->file('imagen')->store('public/imagenes');
            $local->imagen = str_replace('public/', 'storage/', $imagePath);
        }

        $local->save();

        return redirect()->route('locals.index')->with('success', 'Local creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $local = Local::findOrFail($id);
        return view('locals.detail', compact('local'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $local = Local::findOrFail($id);
        return view('locals.edit', compact('local'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            'nombre_local' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'direccion_ip' => 'nullable|string|max:45',
            'telefono' => 'nullable|string|max:20',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024000' // Imagen opcional
        ]);

        $local = Local::findOrFail($id);
        $local->fill($request->except('imagen', 'delete_image'));

        // Condición para eliminar la imagen si está marcada
        if ($request->input('delete_image') == 1) {
            if ($local->imagen) {
                Storage::delete(str_replace('storage/', 'public/', $local->imagen));
                $local->imagen = null; // Eliminar referencia en la base de datos
            }
        } elseif ($request->hasFile('imagen')) { // Nueva imagen cargada
            // Eliminar imagen antigua si existe
            if ($local->imagen) {
                Storage::delete(str_replace('storage/', 'public/', $local->imagen));
            }
            $imagePath = $request->file('imagen')->store('public/imagenes');
            $local->imagen = str_replace('public/', 'storage/', $imagePath);
        }

        $local->save();

        return redirect()->route('locals.index')->with('success', 'Local actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $local = Local::findOrFail($id);
        
        // Eliminar imagen si existe
        if ($local->imagen) {
            Storage::delete(str_replace('storage/', 'public/', $local->imagen));
        }

        $local->delete();

        return redirect()->route('locals.index')->with('success', 'Local eliminado exitosamente.');
    }
}
