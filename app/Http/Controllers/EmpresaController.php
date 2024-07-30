<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas= Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre-corto' => 'required|unique:empresas',
            'nombre-comercial' => 'required|unique:empresas',
            'contacto' => 'nullable|string',
            'telefono' => 'nullable|string',
            'correo' => 'nullable|email',
        ]);

        Empresa::create($request->all());
        return redirect()->route('empresas.index')->with('success', 'Empresa creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre-corto' => 'required|unique:empresas,nombre-corto,' . $id,
            'nombre-comercial' => 'required|unique:empresas,nombre-comercial,' . $id,
            'contacto' => 'nullable|string',
            'telefono' => 'nullable|string',
            'correo' => 'nullable|email',
        ]);

        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());
        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada exitosamente.');
    }
}
